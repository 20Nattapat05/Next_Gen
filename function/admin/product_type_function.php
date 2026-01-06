<?php
require_once __DIR__ . '/../../config/dbconfig.php';


function CheckProductType($product_type_name){
    try {
        $pdo = db();
        $sql = "SELECT COUNT(*) FROM product_type_tb WHERE product_type_name = :product_type_name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['product_type_name' => $product_type_name]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false; 
    }
}


function getAllProductTypes(){
    try {
        $pdo = db();
        $sql = "SELECT * FROM product_type_tb ORDER BY product_type_id ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}


function addProductType($product_type_name){
    try {
        $pdo = db();
        // ปล่อยให้ product_type_id รันอัตโนมัติ (Auto Increment)
        $sql = "INSERT INTO product_type_tb (product_type_name, created_at, updated_at) 
                VALUES (:product_type_name, NOW(), NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':product_type_name' => $product_type_name]);
    } catch (PDOException $e) {
        return false;
    }
}


function deleteProductType($product_type_id){
    try {
        $pdo = db();
        $sql = "DELETE FROM product_type_tb WHERE product_type_id = :product_type_id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':product_type_id' => $product_type_id]);
    } catch (PDOException $e) {

        return false;
    }
}
?>