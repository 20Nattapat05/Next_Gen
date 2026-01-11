<?php

require_once __DIR__ . '/../../config/dbconfig.php';

// 1. ปรับปรุงการดึงข้อมูลให้รองรับ Search และ Sort
function GetAllProduct($search = null, $category = null, $sort = 'latest')
{
    try {
        $pdo = db();
        $sql = "SELECT product_tb.*, product_type_tb.product_type_name, event_tb.event_name, event_tb.event_discount
                FROM product_tb
                LEFT JOIN product_type_tb ON product_tb.product_type_id = product_type_tb.product_type_id
                LEFT JOIN event_tb ON product_tb.event_id = event_tb.event_id
                WHERE 1=1"; // ใช้ 1=1 เพื่อให้ง่ายต่อการต่อ String ด้วย AND
        
        $params = [];

        if (!empty($search)) {
            $sql .= " AND (product_tb.product_name LIKE :search OR product_type_tb.product_type_name LIKE :search OR event_tb.event_name LIKE :search)";
            $params[':search'] = "%$search%";
        }

        if (!empty($category)) {
            $sql .= " AND product_tb.product_type_id = :category";
            $params[':category'] = $category;
        }

        // กำหนดการเรียงลำดับ
        if ($sort === 'price_low') {
            $sql .= " ORDER BY product_tb.product_price ASC";
        } elseif ($sort === 'price_high') {
            $sql .= " ORDER BY product_tb.product_price DESC";
        } else {
            $sql .= " ORDER BY product_tb.product_id DESC";
        }

        $stmt = $pdo->prepare($sql);
        // $params = ['search' => '%$search%',
        //            ':category' => $category,]
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

// 2. ปรับปรุงการเพิ่มสินค้า (รองรับการจัดการ NULL ที่ event_id)
function AddProduct($product_name, $product_type_id, $product_price, $product_detail, $product_picture, $event_id, $product_qty)
{
    try {
        $pdo = db();

        // เช็คชื่อซ้ำ
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM product_tb WHERE product_name = :product_name");
        $stmt_check->execute(['product_name' => $product_name]);
        if ($stmt_check->fetchColumn() > 0) return false;

        $sql = "INSERT INTO product_tb (product_id,product_name, product_type_id, product_price, product_detail, product_picture, event_id, product_qty, created_at, updated_at) 
                VALUES (NULL,:product_name, :product_type_id, :product_price, :product_detail, :product_picture, :event_id, :product_qty, NOW(), NOW())";
        
        $stmt = $pdo->prepare($sql);
        
        // ผูกค่าปกติ
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_type_id', $product_type_id);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_detail', $product_detail);
        $stmt->bindParam(':product_picture', $product_picture);
        $stmt->bindParam(':product_qty', $product_qty);

        // จัดการ event_id ให้เป็น NULL ถ้าไม่มีการส่งมา
        if (empty($event_id)) {
            $stmt->bindValue(':event_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':event_id', $event_id);
        }

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

// 3. ปรับปรุงการลบสินค้า (ใช้ระบบลบรูปที่แม่นยำขึ้น)
function DeleteProduct($id)
{
    try {
        $pdo = db();
        // ดึงชื่อรูป
        $stmt = $pdo->prepare("SELECT product_picture FROM product_tb WHERE product_id = :id");
        $stmt->execute(['id' => $id]);
        $img = $stmt->fetchColumn();

        // ลบข้อมูล
        $stmt = $pdo->prepare("DELETE FROM product_tb WHERE product_id = :id");
        $result = $stmt->execute(['id' => $id]);

        if ($result && !empty($img)) {
            $filePath = __DIR__ . "/../../assets/images/product/" . $img;
            if (file_exists($filePath)) unlink($filePath);
        }
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// 4. ปรับปรุงการแก้ไขสินค้า (เพิ่มระบบลบรูปเก่าทิ้งเมื่อมีการเปลี่ยนรูปใหม่)
function EditProduct($product_id, $product_name, $product_type_id, $product_price, $product_detail, $product_picture, $event_id, $product_qty) 
{
    try {
        $pdo = db();
        
        // ถ้ามีการเปลี่ยนรูปใหม่ ให้ดึงชื่อรูปเก่ามาเตรียมลบทิ้ง
        if ($product_picture) {
            $stmt_old = $pdo->prepare("SELECT product_picture FROM product_tb WHERE product_id = :id");
            $stmt_old->execute(['id' => $product_id]);
            $old_img = $stmt_old->fetchColumn();

            $sql = "UPDATE product_tb SET product_name = :product_name, product_type_id = :product_type_id, product_price = :product_price, product_detail = :product_detail, product_picture = :product_picture, event_id = :event_id, product_qty = :product_qty, updated_at = NOW() WHERE product_id = :product_id";
        } else {
            $sql = "UPDATE product_tb SET product_name = :product_name, product_type_id = :product_type_id, product_price = :product_price, product_detail = :product_detail, event_id = :event_id, product_qty = :product_qty, updated_at = NOW() WHERE product_id = :product_id";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_type_id', $product_type_id);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_detail', $product_detail);
        $stmt->bindParam(':product_qty', $product_qty);

        if (empty($event_id)) {
            $stmt->bindValue(':event_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':event_id', $event_id);
        }

        if ($product_picture) {
            $stmt->bindParam(':product_picture', $product_picture);
        }

        if ($stmt->execute()) {
            // ถ้า Update สำเร็จ และมีการเปลี่ยนรูป ให้ลบรูปเก่าออกจาก Folder
            if ($product_picture && !empty($old_img)) {
                $oldPath = __DIR__ . "/../../assets/images/product/" . $old_img;
                if (file_exists($oldPath)) unlink($oldPath);
            }
            return true;
        }
        return false;
    } catch (PDOException $e) {
        return false;
    }
}