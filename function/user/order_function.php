<?php

require_once __DIR__ . '/../../config/dbconfig.php';
require_once __DIR__ . '/../shared/common_function.php';

$conn = db();

// Create order from cart
function CreateOrder($user_id) {
    global $conn;
    
    try {
        $cart_total = CalculateCartTotal($user_id);
        
        if (empty($cart_total['items'])) {
            return ['success' => false, 'message' => 'ตะกร้าว่างเปล่า'];
        }
        
        // Start transaction
        $conn->beginTransaction();
        
        // Insert order
        $order_sql = "INSERT INTO order_tb (user_id, total_price, order_status, payment_status) 
                     VALUES (:user_id, :total_price, 'pending', 'pending')";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $order_stmt->bindParam(':total_price', $cart_total['grand_total'], PDO::PARAM_STR);
        $order_stmt->execute();
        
        $order_id = $conn->lastInsertId();
        
        // Insert order items from cart
        foreach ($cart_total['items'] as $item) {
            $item_sql = "INSERT INTO order_item_tb (order_id, product_id, quantity, price_per_unit, discount_per_unit) 
                        VALUES (:order_id, :product_id, :quantity, :price_per_unit, :discount_per_unit)";
            $item_stmt = $conn->prepare($item_sql);
            $item_stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $item_stmt->bindParam(':product_id', $item['product_id'], PDO::PARAM_INT);
            $item_stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
            $item_stmt->bindParam(':price_per_unit', $item['price_per_unit'], PDO::PARAM_STR);
            $item_stmt->bindParam(':discount_per_unit', $item['discount_per_unit'], PDO::PARAM_STR);
            $item_stmt->execute();
        }
        
        // Clear cart
        ClearCart($user_id);
        
        // Commit transaction
        $conn->commit();
        
        return ['success' => true, 'message' => 'สร้างคำสั่งซื้อสำเร็จ', 'order_id' => $order_id];
    } catch (PDOException $e) {
        $conn->rollBack();
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Get all orders for user
function GetOrders($user_id, $limit = 10, $offset = 0) {
    global $conn;
    
    try {
        $sql = "SELECT order_id, total_price, order_status, payment_status, created_at 
                FROM order_tb 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Get order detail
function GetOrderDetail($order_id, $user_id = null) {
    global $conn;
    
    try {
        $sql = "SELECT order_id, user_id, total_price, order_status, payment_status, created_at, updated_at 
                FROM order_tb 
                WHERE order_id = :order_id";
        
        if ($user_id) {
            $sql .= " AND user_id = :user_id";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        if ($user_id) {
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

// Get order items
function GetOrderItems($order_id) {
    global $conn;
    
    try {
        $sql = "SELECT oi.order_item_id, oi.product_id, oi.quantity, oi.price_per_unit, 
                       oi.discount_per_unit, p.product_name, p.product_picture
                FROM order_item_tb oi
                JOIN product_tb p ON oi.product_id = p.product_id
                WHERE oi.order_id = :order_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Update order status
function UpdateOrderStatus($order_id, $order_status) {
    global $conn;
    
    try {
        $valid_status = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($order_status, $valid_status)) {
            return ['success' => false, 'message' => 'สถานะไม่ถูกต้อง'];
        }
        
        $sql = "UPDATE order_tb SET order_status = :order_status WHERE order_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':order_status', $order_status, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return ['success' => true, 'message' => 'อัปเดตสถานะแล้ว'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Update payment status
function UpdatePaymentStatus($order_id, $payment_status) {
    global $conn;
    
    try {
        $valid_status = ['pending', 'paid', 'failed'];
        if (!in_array($payment_status, $valid_status)) {
            return ['success' => false, 'message' => 'สถานะการชำระเงินไม่ถูกต้อง'];
        }
        
        $sql = "UPDATE order_tb SET payment_status = :payment_status WHERE order_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':payment_status', $payment_status, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return ['success' => true, 'message' => 'อัปเดตสถานะการชำระเงินแล้ว'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Get order count for user
function GetOrderCount($user_id) {
    global $conn;
    
    try {
        $sql = "SELECT COUNT(*) as count FROM order_tb WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}

// Calculate order total with items
function CalculateOrderTotal($order_id) {
    global $conn;
    
    try {
        $items = GetOrderItems($order_id);
        
        $subtotal = 0;
        $total_discount = 0;
        $order_items = [];
        
        foreach ($items as $item) {
            $item_subtotal = $item['price_per_unit'] * $item['quantity'];
            $item_discount = $item['discount_per_unit'] * $item['quantity'];
            $item_total = $item_subtotal - $item_discount;
            
            $subtotal += $item_subtotal;
            $total_discount += $item_discount;
            
            $order_items[] = [
                'order_item_id' => $item['order_item_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price_per_unit' => $item['price_per_unit'],
                'discount_per_unit' => $item['discount_per_unit'],
                'item_subtotal' => $item_subtotal,
                'item_discount' => $item_discount,
                'item_total' => $item_total
            ];
        }
        
        $grand_total = $subtotal - $total_discount;
        
        return [
            'items' => $order_items,
            'subtotal' => $subtotal,
            'total_discount' => $total_discount,
            'grand_total' => $grand_total,
            'item_count' => count($items)
        ];
    } catch (Exception $e) {
        return [
            'items' => [],
            'subtotal' => 0,
            'total_discount' => 0,
            'grand_total' => 0,
            'item_count' => 0
        ];
    }
}
?>
