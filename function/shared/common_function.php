<?php
/**
 * Shared Functions - ฟังก์ชันที่ใช้ร่วมกันระหว่าง Admin และ User
 * Location: function/shared/common_function.php
 */

require_once __DIR__ . '/../../config/dbconfig.php';

/**
 * ดึงข้อมูลเนื้อหา (Banner, News) ทั้งหมด
 * ใช้งาน: index.php, admin_news.php, content.router.php
 * 
 * @return array ข้อมูลเนื้อหาจัดกลุ่มตามคีย์
 */
function GetContent() {
    try {
        $pdo = db();
        $sql = "SELECT * FROM content_tb";
        $stmt = $pdo->query($sql);
        
        $result = [];
        
        while ($row = $stmt->fetch()) {
            $result[$row['content_key']] = $row;
        }
        
        return $result; 
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * ดึงข้อมูลสินค้าสุ่ม พร้อมข้อมูลโปรโมชัน
 * ใช้งาน: index.php, products.php
 * 
 * @param int $limit จำนวนสินค้าที่ต้องการ (ค่าเริ่มต้น 3)
 * @return array ข้อมูลสินค้า
 */
function GetRandomProducts($limit = 3) {
    try {
        $pdo = db();
        $sql = "SELECT p.*, e.event_name, e.event_discount 
                FROM product_tb p 
                LEFT JOIN event_tb e ON p.event_id = e.event_id 
                ORDER BY RAND() 
                LIMIT :limit";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            if (!empty($product['event_id']) && $product['event_discount'] > 0) {
                $product['final_price'] = $product['product_price'] - $product['event_discount'];
            } else {
                $product['final_price'] = $product['product_price'];
            }
        }
        return $products;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * ดึงข้อมูลสินค้าทั้งหมด พร้อมข้อมูลโปรโมชัน
 * ใช้งาน: products.php
 * 
 * @return array ข้อมูลสินค้าทั้งหมด
 */
function GetAllProducts() {
    try {
        $pdo = db();
        $sql = "SELECT p.*, e.event_name, e.event_discount 
                FROM product_tb p 
                LEFT JOIN event_tb e ON p.event_id = e.event_id 
                ORDER BY p.product_id DESC";
        
        $stmt = $pdo->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            if (!empty($product['event_id']) && $product['event_discount'] > 0) {
                $product['final_price'] = $product['product_price'] - $product['event_discount'];
            } else {
                $product['final_price'] = $product['product_price'];
            }
        }
        return $products;
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * ดึงข้อมูลสินค้าตามไอดี
 * ใช้งาน: product_detail.php
 * 
 * @param int $product_id ไอดีของสินค้า
 * @return array|null ข้อมูลสินค้า หรือ null หากไม่พบ
 */
function GetProductById($product_id) {
    try {
        $pdo = db();
        $sql = "SELECT p.*, e.event_name, e.event_discount 
                FROM product_tb p 
                LEFT JOIN event_tb e ON p.event_id = e.event_id 
                WHERE p.product_id = :id 
                LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['event_id']) && $product['event_discount'] > 0) {
            $product['final_price'] = $product['product_price'] - $product['event_discount'];
        } else if ($product) {
            $product['final_price'] = $product['product_price'];
        }
        
        return $product;
    } catch (PDOException $e) {
        return null;
    }
}

?>
