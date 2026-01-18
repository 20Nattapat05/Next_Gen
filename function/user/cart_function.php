<?php

require_once __DIR__ . '/../../config/dbconfig.php';

// Add product to cart
function AddToCart($user_id, $product_id, $quantity = 1) {
    $conn = db();
    
    try {
        // Check if product exists and get price
        $check_sql = "SELECT product_price, product_qty FROM product_tb WHERE product_id = :product_id";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $check_stmt->execute();
        
        $product = $check_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            return ['success' => false, 'message' => 'ไม่พบสินค้า'];
        }
        
        // Check stock
        if ($product['product_qty'] < $quantity) {
            return ['success' => false, 'message' => 'จำนวนสินค้าไม่เพียงพอ'];
        }
        
        // Check if product already in cart
        $check_cart_sql = "SELECT cart_id, quantity FROM cart_tb WHERE user_id = :user_id AND product_id = :product_id";
        $check_cart_stmt = $conn->prepare($check_cart_sql);
        $check_cart_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $check_cart_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $check_cart_stmt->execute();
        
        $existing = $check_cart_stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($existing) {
            // Update quantity if already exists
            $new_quantity = $existing['quantity'] + $quantity;
            
            // Check if total quantity exceeds stock
            if ($new_quantity > $product['product_qty']) {
                return ['success' => false, 'message' => 'จำนวนสินค้าไม่เพียงพอ'];
            }
            
            $update_sql = "UPDATE cart_tb SET quantity = :quantity WHERE cart_id = :cart_id";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':quantity', $new_quantity, PDO::PARAM_INT);
            $update_stmt->bindParam(':cart_id', $existing['cart_id'], PDO::PARAM_INT);
            $update_stmt->execute();
            
            return ['success' => true, 'message' => 'อัปเดตจำนวนสินค้าในตะกร้าแล้ว'];
        } else {
            // Insert new cart item
            $insert_sql = "INSERT INTO cart_tb (user_id, product_id, quantity, price_per_unit) 
                          VALUES (:user_id, :product_id, :quantity, :price_per_unit)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $insert_stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $insert_stmt->bindParam(':price_per_unit', $product['product_price'], PDO::PARAM_STR);
            $insert_stmt->execute();
            
            return ['success' => true, 'message' => 'เพิ่มสินค้าลงตะกร้าแล้ว'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Get user's cart
function GetCart($user_id) {
    $conn = db();
    
    try {
        $sql = "SELECT c.*, p.product_name, p.product_picture, p.product_qty, e.event_discount, e.event_name
                FROM cart_tb c
                JOIN product_tb p ON c.product_id = p.product_id
                LEFT JOIN event_tb e ON p.event_id = e.event_id
                WHERE c.user_id = :user_id
                ORDER BY c.created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// Update cart quantity
function UpdateCartQuantity($cart_id, $quantity) {
    $conn = db();
    
    try {
        if ($quantity <= 0) {
            return RemoveFromCart($cart_id);
        }
        
        // Get product id and check stock
        $get_sql = "SELECT c.product_id FROM cart_tb c WHERE c.cart_id = :cart_id";
        $get_stmt = $conn->prepare($get_sql);
        $get_stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $get_stmt->execute();
        
        $cart_item = $get_stmt->fetch(PDO::FETCH_ASSOC);
        if (!$cart_item) {
            return ['success' => false, 'message' => 'ไม่พบสินค้าในตะกร้า'];
        }
        
        // Check stock
        $check_sql = "SELECT product_qty FROM product_tb WHERE product_id = :product_id";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':product_id', $cart_item['product_id'], PDO::PARAM_INT);
        $check_stmt->execute();
        
        $product = $check_stmt->fetch(PDO::FETCH_ASSOC);
        if ($quantity > $product['product_qty']) {
            return ['success' => false, 'message' => 'จำนวนสินค้าไม่เพียงพอ'];
        }
        
        $update_sql = "UPDATE cart_tb SET quantity = :quantity WHERE cart_id = :cart_id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $update_stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $update_stmt->execute();
        
        return ['success' => true, 'message' => 'อัปเดตจำนวนแล้ว'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Remove item from cart
function RemoveFromCart($cart_id) {
    $conn = db();
    
    try {
        $sql = "DELETE FROM cart_tb WHERE cart_id = :cart_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return ['success' => true, 'message' => 'ลบสินค้าออกจากตะกร้าแล้ว'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Clear entire cart
function ClearCart($user_id) {
    $conn = db();
    
    try {
        $sql = "DELETE FROM cart_tb WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return ['success' => true, 'message' => 'ลบสินค้าทั้งหมดออกจากตะกร้าแล้ว'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()];
    }
}

// Calculate cart total
function CalculateCartTotal($user_id) {
    $conn = db();
    
    try {
        $cart = GetCart($user_id);
        
        $subtotal = 0;
        $total_discount = 0;
        $items = [];
        
        foreach ($cart as $item) {
            $item_subtotal = $item['price_per_unit'] * $item['quantity'];
            $discount = ($item['event_discount'] ?? 0) * $item['quantity'];
            $item_total = $item_subtotal - $discount;
            
            $subtotal += $item_subtotal;
            $total_discount += $discount;
            
            $items[] = [
                'cart_id' => $item['cart_id'],
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'available_qty' => $item['product_qty'],
                'picture' => $item['product_picture'],
                'price_per_unit' => $item['price_per_unit'],
                'discount_per_unit' => $item['event_discount'] ?? 0,
                'item_subtotal' => $item_subtotal,
                'item_discount' => $discount,
                'item_total' => $item_total
            ];
        }
        
        $grand_total = $subtotal - $total_discount;
        
        return [
            'items' => $items,
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

// Get cart item count for navbar
function GetCartItemCount($user_id) {
    $conn = db();
    
    try {
        $sql = "SELECT COUNT(*) as count FROM cart_tb WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    } catch (PDOException $e) {
        return 0;
    }
}
?>
