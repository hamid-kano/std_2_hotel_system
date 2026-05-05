<?php
session_start();
header('Content-Type: application/json');
// $_SESSION['uId']=$u_fetch['id']

// تأكد من أن المستخدم قد سجل الدخول
if (!isset($_SESSION['uId'])) {
    echo json_encode(['success' => false, 'message' => 'يجب تسجيل الدخول أولاً']);
    exit;
}

$user_id = $_SESSION['uId'];

// التحقق من صحة المدخلات
if (!isset($_POST['amount']) || !isset($_POST['password'])) {
    echo json_encode(['success' => false, 'message' => 'بيانات غير كاملة']);
    exit;
}

$amount = filter_var($_POST['amount'], FILTER_VALIDATE_FLOAT);
$password = $_POST['password'];

if ($amount === false || $amount <= 0) {
    echo json_encode(['success' => false, 'message' => 'مبلغ غير صالح']);
    exit;
}

// الاتصال بقاعدة البيانات
$db = new mysqli('localhost', 'root', '', 'homework_std_ro_db');

if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => 'فشل الاتصال بقاعدة البيانات']);
    exit;
}

// التحقق من كلمة المرور
$stmt = $db->prepare("SELECT password FROM user_cred WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (!password_verify($password, $row['password'])) {
        echo json_encode(['success' => false, 'message' => 'كلمة المرور غير صحيحة']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'لم يتم العثور على المستخدم']);
    exit;
}

// إضافة الرصيد
$stmt = $db->prepare("UPDATE balances SET balance = balance + ? WHERE user_id = ?");
$stmt->bind_param("di", $amount, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'تم إضافة الرصيد بنجاح']);
} else {
    echo json_encode(['success' => false, 'message' => 'فشل في إضافة الرصيد']);
}

$stmt->close();
$db->close();
?>  