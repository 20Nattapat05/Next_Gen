<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../function/user/order_function.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('Location: /Next_Gen/login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'วิธีการร้องขอไม่ถูกต้อง';
    header('Location: /Next_Gen/order_history.php');
    exit();
}

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if ($order_id <= 0) {
    $_SESSION['error'] = 'เลขคำสั่งซื้อไม่ถูกต้อง';
    header('Location: /Next_Gen/order_history.php');
    exit();
}

if (!isset($_FILES['slip']) || $_FILES['slip']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error'] = 'กรุณาแนบรูปสลิปการชำระเงิน';
    header('Location: /Next_Gen/payment.php?order_id=' . $order_id);
    exit();
}

$allowed = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/webp' => '.webp'];
$mime = mime_content_type($_FILES['slip']['tmp_name']);
if (!isset($allowed[$mime])) {
    $_SESSION['error'] = 'ประเภทไฟล์ไม่รองรับ';
    header('Location: /Next_Gen/payment.php?order_id=' . $order_id);
    exit();
}

$uploadDir = __DIR__ . '/../assets/uploads/slips/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}
$ext = $allowed[$mime];
$target = $uploadDir . 'order_' . $order_id . $ext;

if (!move_uploaded_file($_FILES['slip']['tmp_name'], $target)) {
    $_SESSION['error'] = 'อัปโหลดไฟล์ไม่สำเร็จ';
    header('Location: /Next_Gen/payment.php?order_id=' . $order_id);
    exit();
}

$res = UpdatePaymentStatus($order_id, 'paid');
if ($res['success']) {
    $_SESSION['payment_success'] = 'อัปโหลดสลิปสำเร็จ กำลังตรวจสอบ';
} else {
    $_SESSION['payment_error'] = $res['message'];
}

header('Location: /Next_Gen/order_history.php?order_id=' . $order_id);
exit();
?>
