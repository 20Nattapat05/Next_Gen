<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Next_Gen/admin_product');
    exit();
}

require_once __DIR__ . '/../function/admin/product_type_function.php';

if (isset($_POST['product_type_name'])) {
    $product_type_name = trim($_POST['product_type_name']);

    if ($product_type_name === '') {
        $_SESSION['product_type_input_error'] = 'กรุณากรอกชื่อประเภทสินค้า';
        header('Location: /Next_Gen/admin_product');
        exit();
    }

    if (CheckProductType($product_type_name)) {
        $_SESSION['product_type_input_error'] = 'ชื่อประเภทสินค้านี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น';
        header('Location: /Next_Gen/admin_product');
        exit();
    }

    $add_result = addProductType($product_type_name);
    if ($add_result) {
        $_SESSION['product_type_success'] = 'เพิ่มประเภทสินค้าสำเร็จ';
    } else {
        $_SESSION['product_type_input_error'] = 'เกิดข้อผิดพลาดในการเพิ่มประเภทสินค้า กรุณาลองใหม่';
    }
    header('Location: /Next_Gen/admin_product');
    exit();
}

if (isset($_POST['delete_product_type_id'])) {
    $product_type_id = $_POST['delete_product_type_id'];

    $delete_result = deleteProductType($product_type_id);
    if ($delete_result === true) {
        $_SESSION['product_type_success'] = 'ลบประเภทสินค้าสำเร็จ';
    } elseif ($delete_result === false) {
        $_SESSION['product_type_input_error'] = 'ไม่สามารถลบประเภทสินค้าได้ เนื่องจากมีสินค้าที่เกี่ยวข้องอยู่';
    } else {
        $_SESSION['product_type_input_error'] = 'เกิดข้อผิดพลาดในการลบประเภทสินค้า กรุณาลองใหม่';
    }
    header('Location: /Next_Gen/admin_product');
    exit();
}

header('Location: /Next_Gen/admin_product');
exit();
