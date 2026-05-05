<?php
require('admin/inc/essentials.php');
require('admin/inc/db_config.php');
session_start();

// Function to log messages
function logMessage($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'booking_debug.log');
}

// Function to regenerate session
function regenerate_session($uid) {
    $user_q = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$uid], 'i');
    $user_fetch = mysqli_fetch_assoc($user_q);
    $_SESSION['login'] = true;
    $_SESSION['uId'] = $user_fetch['id'];
    $_SESSION['uName'] = $user_fetch['name'];
    $_SESSION['uPhone'] = $user_fetch['phonenum'];
}

// Check if user is logged in
if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('hotel.php');
}

if (isset($_POST['pay_now'])) {
    $ORDER_ID = 'ORD' . $_SESSION['uId'] . random_int(11111, 9999999);
    $frm_data = filteration($_POST);

    // Fetch user's balance
    $stmt = $con->prepare("SELECT `balance` FROM `balances` WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['uId']);
    $stmt->execute();
    $result = $stmt->get_result();
    $balance = $result->fetch_assoc();

    // Calculate total payment
    $checkInTime = strtotime($frm_data['checkin']);
    $checkOutTime = strtotime($frm_data['checkout']);
    $diffInDays = ($checkOutTime - $checkInTime) / (60 * 60 * 24);
    $total_pay = $_SESSION['room']['price'] * $diffInDays;

    logMessage("User ID: {$_SESSION['uId']}, Current Balance: {$balance['balance']}, Total Pay: {$total_pay}");

    if ($balance['balance'] >= $total_pay) {
        $con->begin_transaction();
        try {
            // Deduct amount from user's balance
            $stmt = $con->prepare("UPDATE balances SET balance = balance - ? WHERE user_id = ?");
            $stmt->bind_param("di", $total_pay, $_SESSION['uId']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Insert booking order
                $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`,`trans_status`) VALUES (?,?,?,?,?,?)";
                $booking_order_result = insert($query1, [$_SESSION['uId'], $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID,"success"], 'isssss');
                $booking_id = mysqli_insert_id($con);

                // Insert booking details
                $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
                $booking_details_result = insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $total_pay, $frm_data['name'], $frm_data['phonenum'], $frm_data['address']], 'issssss');

                if ($booking_order_result && $booking_details_result) {
                    $con->commit();
                    logMessage("Booking successful. Order ID: {$ORDER_ID}, Booking ID: {$booking_id}");
                    redirect('pay_status.php?order=' . $ORDER_ID);
                } else {
                    throw new Exception("Failed to insert booking details");
                }
            } else {
                throw new Exception("Failed to update balance");
            }
        } catch (Exception $e) {
            $con->rollback();
            logMessage("Error during booking process: " . $e->getMessage());
            echo "An error occurred during the booking process. Please try again.";
        }
    } else {

        logMessage("Insufficient balance. User ID: {$_SESSION['uId']}, Required: {$total_pay}, Available: {$balance['balance']}");

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`,`booking_status`,`trans_status`) VALUES (?,?,?,?,?,?,?)";

        $booking_order_result = insert($query1, [$_SESSION['uId'], $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID,"peding","failed"], 'issssss');

        if($booking_order_result) {
            redirect('pay_status.php?order=' . $ORDER_ID);
        } else {
            echo "حدث خطأ أثناء تسجيل الطلب. يرجى المحاولة مرة أخرى.";
        }
            }
} elseif (isset($_POST['ORDERID'])) {
    // Handle payment status update
    $slct_query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id` = ?";
    $stmt = $con->prepare($slct_query);
    $stmt->bind_param("s", $_POST['ORDERID']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        redirect('hotel.php');
    }
    
    $slct_fetch = $result->fetch_assoc();
    
    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        regenerate_session($slct_fetch['user_id']);
    }

    $status = ($_POST['STATUS'] == 1) ? 'success' : 'failure';
    redirect('pay_status.php?order=' . $_POST['ORDERID'] . '&status=' . $status);
}

// Clear room session data
unset($_SESSION['room']);
?>