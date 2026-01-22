<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'addresses' => [], 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit();
}

require_once __DIR__ . '/../function/user/address_function.php';

$addresses = GetAddressesByUserId($_SESSION['user_id']);

header('Content-Type: application/json');
echo json_encode(['success' => true, 'addresses' => $addresses]);
exit();

?>
