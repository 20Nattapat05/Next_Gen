<?php
session_start();
require_once __DIR__ . '/../function/admin/content_function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- [1. Basic Validation] ---
    if (empty($_POST['content_key'])) {
        $_SESSION['error'] = "กรุณาเลือกตำแหน่งที่ต้องการแก้ไข";
        header("Location: ../admin_news.php");
        exit();
    }

    $content_key = $_POST['content_key'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $new_image_name = null; 

    if (empty($_POST['title'])) {
        $_SESSION['error'] = 'กรุณากรอกชื่อข่าว';
        header("Location: ../admin_news.php");
        exit();
    }

    if (empty($_POST["description"])) {
        $_SESSION['error'] = 'กรุณากรอกรายละเอียดข่าว';
        header("Location: ../admin_news.php");
        exit();
    }

    //Image Validation
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        

        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // ตรวจสอบนามสกุลไฟล์
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($ext, $allowed_ext)) {
            $_SESSION['error'] = "อนุญาตเฉพาะไฟล์นามสกุล jpg, jpeg, png, webp เท่านั้น";
            header("Location: ../admin_news.php");
            exit();
        }

        //File Processing
        $new_image_name = uniqid('content_') . "." . $ext;
        $upload_path = __DIR__ . '/../assets/images/news/' . $new_image_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            // ดึงข้อมูลเดิมเพื่อลบรูปเก่า
            $all_data = GetContent();
            $old_image = $all_data[$content_key]['content_image'] ?? null;
            if ($old_image && file_exists(__DIR__ . '/../assets/images/news/' . $old_image)) {
                unlink(__DIR__ . '/../assets/images/news/' . $old_image);
            }
        } else {
            $_SESSION['error'] = "ไม่สามารถอัปโหลดรูปภาพได้";
            header("Location: ../admin_news.php");
            exit();
        }
    }

    // --- [4. Database Update] ---
    $isSuccess = UpdateContent($content_key, $title, $description, $new_image_name);

    if ($isSuccess) {
        $_SESSION['success'] = 'อัปเดตข้อมูลเรียบร้อยแล้ว';
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการบันทึกฐานข้อมูล";
    }

    header("Location: ../admin_news.php");
    exit();
}