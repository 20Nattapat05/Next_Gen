<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'วิธีการร้องขอไม่ถูกต้อง']);
    exit();
}

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit();
}

require_once __DIR__ . '/../function/user/address_function.php';

$input = json_decode(file_get_contents('php://input'), true);
$address_id = isset($input['address_id']) ? intval($input['address_id']) : 0;

if ($address_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ถูกต้อง']);
    exit();
}

$result = DeleteAddress($_SESSION['user_id'], $address_id);

header('Content-Type: application/json');
echo json_encode($result);
exit();

?>
