<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../include/check_auth_admin.php';
require_once __DIR__ . '/../function/user/order_function.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'วิธีการร้องขอไม่ถูกต้อง';
    header('Location: /Next_Gen/admin_order');
    exit();
}

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if ($order_id <= 0) {
    $_SESSION['error'] = 'เลขคำสั่งซื้อไม่ถูกต้อง';
    header('Location: /Next_Gen/admin_order');
    exit();
}

// Generate tracking number
$tracking = 'TRK-' . strtoupper(bin2hex(random_bytes(4)));
$trackDir = __DIR__ . '/../assets/uploads/tracking/';
if (!is_dir($trackDir)) {
    @mkdir($trackDir, 0777, true);
}
$trackFile = $trackDir . 'order_' . $order_id . '.txt';
file_put_contents($trackFile, $tracking);

$res = UpdateOrderStatus($order_id, 'shipped');
if ($res['success']) {
    $_SESSION['success'] = 'ยืนยันออเดอร์แล้ว เลขพัสดุ: ' . $tracking;
} else {
    $_SESSION['error'] = $res['message'];
}

header('Location: /Next_Gen/admin_order');
exit();
?>
