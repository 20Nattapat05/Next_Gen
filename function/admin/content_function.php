<?php

require_once __DIR__ . '/../../config/dbconfig.php';

function GetContent() {
    try {
        $pdo = db(); // เรียกใช้การเชื่อมต่อฐานข้อมูล
        $sql = "SELECT * FROM content_tb";
        $stmt = $pdo->query($sql);
        
        $result = []; // สร้าง Array ว่างเพื่อรอเก็บข้อมูลแบบจัดกลุ่ม
        
        while ($row = $stmt->fetch()) {
            $result[$row['content_key']] = $row;
        }
        
        return $result; 
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * ฟังก์ชันอัปเดตเนื้อหา (สำหรับใช้ใน Router)
 */
function UpdateContent($key, $title, $description, $image_name = null) {
    try {
        $pdo = db();
        

        $stmt_current = $pdo->prepare("SELECT * FROM content_tb WHERE content_key = :key");
        $stmt_current->execute([':key' => $key]);
        $current = $stmt_current->fetch();


        $final_title = (!empty($title)) ? $title : $current['content_title'];
        $final_desc = (!empty($description)) ? $description : $current['content_description'];
        $final_image = (!empty($image_name)) ? $image_name : $current['content_image'];


        $sql = "UPDATE content_tb SET 
                content_title = :title, 
                content_description = :description, 
                content_image = :image 
                WHERE content_key = :key";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':title' => $final_title,
            ':description' => $final_desc,
            ':image' => $final_image,
            ':key' => $key
        ]);
    } catch (PDOException $e) {
        return false;
    }
}