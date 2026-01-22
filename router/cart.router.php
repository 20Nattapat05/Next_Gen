<?php

require_once __DIR__ . '/../function/user/cart_function.php';

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
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'view';

$response = ['success' => false, 'message' => 'Action ไม่ถูกต้อง'];

switch ($action) {
    case 'add':
        if (isset($_GET['id'])) {
            $product_id = intval($_GET['id']);
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
            
            if ($quantity <= 0) {
                $response = ['success' => false, 'message' => 'จำนวนสินค้าต้องมากกว่า 0'];
            } else {
                $response = AddToCart($user_id, $product_id, $quantity);
            }
        }
        break;
        
    case 'update':
        if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
            $cart_id = intval($_POST['cart_id']);
            $quantity = intval($_POST['quantity']);
            
            if ($quantity <= 0) {
                $response = RemoveFromCart($cart_id);
            } else {
                $response = UpdateCartQuantity($cart_id, $quantity);
            }
        }
        break;
        
    case 'remove':
        if (isset($_POST['cart_id'])) {
            $cart_id = intval($_POST['cart_id']);
            $response = RemoveFromCart($cart_id);
        }
        break;
        
    case 'clear':
        $response = ClearCart($user_id);
        break;
        
    case 'get':
        $cart_total = CalculateCartTotal($user_id);
        $response = [
            'success' => true,
            'data' => $cart_total
        ];
        break;
        
    case 'view':
        // Redirect to cart page
        header('Location: /Next_Gen/cart.php');
        exit();
        break;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
