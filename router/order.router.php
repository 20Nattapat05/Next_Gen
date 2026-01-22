<?php

require_once __DIR__ . '/../function/user/order_function.php';
require_once __DIR__ . '/../function/user/address_function.php';

// Initialize session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบก่อน', 'redirect' => 'login.php']);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'list';

$response = ['success' => false, 'message' => 'Action ไม่ถูกต้อง'];

switch ($action) {
    case 'create':
        // Create order from cart
        $address_id = isset($_POST['address_id']) ? intval($_POST['address_id']) : 0;
        
        // Validate address belongs to user
        $valid = false;
        if ($address_id > 0) {
            $addresses = GetAddressesByUserId($user_id);
            foreach ($addresses as $a) {
                if (intval($a['address_id']) === $address_id) {
                    $valid = true;
                    break;
                }
            }
        }
        if (!$valid) {
            $response = ['success' => false, 'message' => 'กรุณาเลือกที่อยู่จัดส่งที่ถูกต้อง'];
            break;
        }
        
        $result = CreateOrder($user_id);
        if ($result['success']) {
            $order_id = $result['order_id'];
            // Update payment method (if you have a column for it)
            $response = [
                'success' => true,
                'message' => 'สร้างคำสั่งซื้อสำเร็จ',
                'order_id' => $order_id
            ];
        } else {
            $response = $result;
        }
        break;
        
    case 'get':
        // Get order detail
        if (isset($_GET['id'])) {
            $order_id = intval($_GET['id']);
            $order = GetOrderDetail($order_id, $user_id);
            
            if ($order) {
                $items = GetOrderItems($order_id);
                $response = [
                    'success' => true,
                    'order' => $order,
                    'items' => $items
                ];
            } else {
                $response = ['success' => false, 'message' => 'ไม่พบคำสั่งซื้อ'];
            }
        }
        break;
        
    case 'list':
        // Get all orders
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $orders = GetOrders($user_id, $limit, $offset);
        $count = GetOrderCount($user_id);
        $total_pages = ceil($count / $limit);
        
        $response = [
            'success' => true,
            'orders' => $orders,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $total_pages,
                'total_count' => $count
            ]
        ];
        break;
        
    case 'update_status':
        // Admin only - Update order status
        if (isset($_POST['order_id']) && isset($_POST['status'])) {
            $order_id = intval($_POST['order_id']);
            $status = htmlspecialchars($_POST['status']);
            
            // Verify user owns this order
            $order = GetOrderDetail($order_id, $user_id);
            if ($order) {
                $response = UpdateOrderStatus($order_id, $status);
            } else {
                $response = ['success' => false, 'message' => 'ไม่มีสิทธิ์อัปเดตคำสั่งซื้อนี้'];
            }
        }
        break;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
