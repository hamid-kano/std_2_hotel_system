
<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();  
    if(isset($_POST['get_bookings']))
    {
        $frm_data=filteration($_POST);

        $query="SELECT bo.* , bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ? ) AND
        (bo.booking_status =? AND bo.refund =?) ORDER BY bo.booking_id ASC";

        $res=select($query,["%$frm_data[search]%","$frm_data[search]%","$frm_data[search]%","cancelled",0],'sssss');
        $i=1;
        $table_data="";
        if(mysqli_num_rows($res)==0){
            echo"<b>No Data Found!</b>";
            exit;
        }

        while($data = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y",strtotime($data['datentime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            $table_data .="
            
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary'>
                            Order ID : $data[order_id]
                        </span>
                        <br>
                        <b>Name :</b> $data[user_name]
                        <br>
                        <b>Phone No :</b> $data[phonenum]
                        <br>
                    </td>
                    <td>

                        <b> Room :</b> $data[room_name]
                        <br>
                        <b>Check in:</b> $checkin
                        <br>
                        <b>Check out:</b> $checkout
                        <br>
                        <br>
                        <b>Date:</b> $date
                    </td>
                    <td>
                    <b>$$data[total_pay]</b> 
                    </td>
                    <td>
                        <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none'>
                            <i class='bi bi-cash-stack'></i>  Refund
                        </button>

                    </td>


                    
                </tr>
            ";
            $i++;
        }
        echo $table_data;
        
    }
if(isset($_POST['refund_booking']))
{
    $frm_data = filteration($_POST);
    $booking_id = $frm_data['booking_id'];

    // استرجاع معلومات الحجز والمبلغ المدفوع
    $booking_query = "SELECT bo.user_id, bd.total_pay 
                    FROM `booking_order` bo
                    JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                    WHERE bo.booking_id = ?";
    $booking_values = [$booking_id];
    $booking_res = select($booking_query, $booking_values, 'i');
    
    if($booking_res && mysqli_num_rows($booking_res) > 0)
    {
        $booking_data = mysqli_fetch_assoc($booking_res);
        $user_id = $booking_data['user_id'];
        $total_pay = $booking_data['total_pay'];

        // بدء المعاملة
        mysqli_begin_transaction($con);

        try {
            // تحديث حالة الاسترداد في جدول الحجوزات
            $update_booking_query = "UPDATE `booking_order` SET `refund`=1 WHERE `booking_id`=?";
            $update_booking_values = [$booking_id];
            $update_booking_res = update($update_booking_query, $update_booking_values, 'i');

            if(!$update_booking_res) {
                throw new Exception("فشل تحديث حالة الاسترداد");
            }

            // تحديث رصيد المستخدم في جدول balances
            $update_balance_query = "UPDATE `balances` SET `balance` = `balance` + ? WHERE `user_id` = ?";
            $update_balance_values = [$total_pay, $user_id];
            $update_balance_res = update($update_balance_query, $update_balance_values, 'di');

            if(!$update_balance_res) {
                throw new Exception("فشل تحديث رصيد المستخدم");
            }

            // إتمام المعاملة
            mysqli_commit($con);
            echo json_encode(['status' => 'success', 'message' => 'تم استرداد المبلغ بنجاح']);
        } catch (Exception $e) {
            // التراجع عن المعاملة في حالة حدوث خطأ
            mysqli_rollback($con);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    else
    {
        echo json_encode(['status' => 'error', 'message' => 'لم يتم العثور على معلومات الحجز']);
    }
}
?>



