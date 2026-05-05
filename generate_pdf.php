<?php
// Database connection parameters
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'homework_std_ro_db';

// Establish database connection
$con = mysqli_connect($hname, $uname, $pass, $db);

if (!$con) {
    die("Cannot Connect to Database: " . mysqli_connect_error());
}

// Data filtration function
function filteration($data) {
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $data[$key] = $value;
    }
    return $data;
}

// Select all records from a table
function selectAll($table) {
    global $con;
    $res = mysqli_query($con, "SELECT * FROM `" . mysqli_real_escape_string($con, $table) . "`");
    return $res;
}

// Parameterized select query
function select($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return "Query execution failed: " . $error;
        }
    } else {
        return "Query preparation failed: " . mysqli_error($con);
    }
}

// Parameterized update query
function update($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return "Query execution failed: " . $error;
        }
    } else {
        return "Query preparation failed: " . mysqli_error($con);
    }
}

// Parameterized insert query
function insert($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return "Query execution failed: " . $error;
        }
    } else {
        return "Query preparation failed: " . mysqli_error($con);
    }
}

// Parameterized delete query
function delete($sql, $values, $datatypes) {
    global $con;
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            $error = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            return "Query execution failed: " . $error;
        }
    } else {
        return "Query preparation failed: " . mysqli_error($con);
    }
}

// Define constants
define('SITE_URL', 'http://localhost/my_project/last pr/');
define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL . 'images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL . 'images/rooms/');
define('USERS_IMG_PATH', SITE_URL . 'images/users/');

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/last pr/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');

// Admin login check
function adminLogin() {
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}

// Redirect function
function redirect($url) {
    echo "<script>window.location.href='$url';</script>";
    exit;
}

// Alert function
function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo "<div class='alert $bs_class alert-dismissible fade show custom-alert' role='alert'>
            <strong class='me-3'>$msg</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}

// Image upload function
function uploadImage($image, $folder) {
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

// Image delete function
function deleteImage($image, $folder) {
    if (unlink(UPLOAD_IMAGE_PATH . $folder . $image)) {
        return true;
    } else {
        return false;
    }
}

// SVG image upload function
function uploadSVGImage($image, $folder) {
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif (($image['size'] / (1024 * 1024)) > 1) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";
        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

// Check admin login
adminLogin();

// Generate PDF
if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {
    $frm_data = filteration($_GET);
    $query = "SELECT bo.*, bd.*, uc.email 
                FROM `booking_order` bo 
                INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                INNER JOIN `user_cred` uc ON bo.user_id = uc.id
                WHERE ((bo.booking_status='booked' AND bo.arrival=1)        
                OR (bo.booking_status='cancelled' AND bo.refund=1)
                OR (bo.booking_status='failed'))
                AND bo.booking_id=?";

    $values = [$frm_data['id']];
    $res = select($query, $values, 's');

    if (!$res || mysqli_num_rows($res) == 0) {
        redirect('dashboard.php');
    }

    $data = mysqli_fetch_assoc($res);
    $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $table_data = "
        <h2>BOOKING RECEIPT</h2>
        <table border='1'>
            <tr>
                <td>Order ID: {$data['order_id']}</td>
                <td>Booking Date: $date</td>
            </tr>
            <tr>
                <td colspan='2'>Status: {$data['booking_status']}</td>
            </tr>
            <tr>
                <td>Name: {$data['user_name']}</td>
                <td>Email: {$data['email']}</td>
            </tr>
            <tr>
                <td>Phone: {$data['phonenum']}</td>
                <td>Address: {$data['address']}</td>
            </tr>
            <tr>
                <td>Room Name: {$data['room_name']}</td>
                <td>Cost: {$data['price']} per night</td>
            </tr>
            <tr>
                <td>Check-in: $checkin</td>
                <td>Check-out: $checkout</td>
            </tr>";

    if ($data['booking_status'] == 'cancelled') {
        $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";
        $table_data .= "
            <tr>
                <td>Amount Paid: {$data['total_pay']}</td>
                <td>Refund: $refund</td>
            </tr>";
    } else {
        $table_data .= "
            <tr>
                <td>Room Number: {$data['room_no']}</td>
                <td>Amount Paid: {$data['total_pay']}</td>
            </tr>";
    }

    $table_data .= "</table>";
    echo $table_data;
} else {
    redirect('dashboard.php');
}
?>