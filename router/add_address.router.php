<?php
session_start();
require_once __DIR__ . '/../function/user/address_function.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'วิธีการร้องขอไม่ถูกต้อง';
    header('Location: /Next_Gen/account.php');
    exit();
}

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('Location: /Next_Gen/login');
    exit();
}

$user_id = $_SESSION['user_id'];

$address_name    = $_POST['address_name'] ?? '';
$recipient_name  = $_POST['recipient_name'] ?? '';
$recipient_phone = $_POST['recipient_phone'] ?? '';
$address_detail  = $_POST['address_detail'] ?? '';
$postal_code     = $_POST['postal_code'] ?? '';

// Validation
if (empty($address_name) || empty($recipient_name) || empty($recipient_phone) || empty($address_detail) || empty($postal_code)) {
    $_SESSION['error'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: /Next_Gen/account.php');
    exit();
}

if (!preg_match('/^[0-9]{10}$/', $recipient_phone)) {
    $_SESSION['error'] = 'เบอร์โทรต้องเป็นตัวเลข 10 หลัก';
    header('Location: /Next_Gen/account.php');
    exit();
}

if (!preg_match('/^[0-9]{5}$/', $postal_code)) {
    $_SESSION['error'] = 'รหัสไปรษณีย์ต้องเป็นตัวเลข 5 หลัก';
    header('Location: /Next_Gen/account.php');
    exit();
}

$result = AddAddress($user_id, $address_name, $recipient_name, $recipient_phone, $address_detail, $postal_code);

if ($result['success']) {
    $_SESSION['success'] = $result['message'];
} else {
    $_SESSION['error'] = $result['message'];
}

header('Location: /Next_Gen/account.php');
exit();
?>
