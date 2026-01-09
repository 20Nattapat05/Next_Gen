<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Next_Gen/admin_product');
  exit();
}

require_once __DIR__ . '/../function/admin/product_function.php';

if (isset($_POST['add_product'])) {

  $product_name    = trim($_POST['product_name']);
  $product_type_id = isset($_POST['product_type_id']) ? $_POST['product_type_id'] : null;
  $product_price   = $_POST['product_price'];
  $product_detail  = trim($_POST['product_detail']);
  $product_qty     = $_POST['product_qty'];
  $event_id        = !empty($_POST['event_id']) ? $_POST['event_id'] : null;

  if (empty($product_name) || empty($product_price) || empty($product_detail) || empty($product_qty)) {
    $_SESSION['error'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
    header("Location: ../admin_product");
    exit();
  }

  if (!is_numeric($product_price) || $product_price < 0) {
    $_SESSION['error'] = "ราคาสินค้าต้องเป็นตัวเลขบวกเท่านั้น";
    header("Location: ../admin_product");
    exit();
  }

  if($product_type_id === null) {
    $_SESSION['error'] = "กรุณาเลือกประเภทสินค้า";
    header("Location: ../admin_product");
    exit();
  }

  $is_upload_success = false;
  $upload_path = "";

  // 1. ตรวจสอบไฟล์และย้ายไฟล์ก่อน
  if (isset($_FILES['product_picture']) && $_FILES['product_picture']['error'] === 0) {
    $file = $_FILES['product_picture'];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ext, $allowed)) {
      $new_filename = "prod_" . uniqid() . "_" . time() . "." . $ext;
      $upload_path  = "../assets/images/product/" . $new_filename;

      if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $is_upload_success = true; // ย้ายไฟล์สำเร็จแล้วนะ
      } else {
        $_SESSION['error'] = "ไม่สามารถย้ายไฟล์รูปภาพได้";
        header("Location: ../admin_product");
        exit();
      }
    } else {
      $_SESSION['error'] = "นามสกุลไฟล์ไม่ถูกต้อง";
      header("Location: ../admin_product");
      exit();
    }
  }


  if ($is_upload_success) {
    if (AddProduct($product_name, $product_type_id, $product_price, $product_detail, $new_filename, $event_id, $product_qty)) {
      // สำเร็จทั้งคู่ (ไฟล์ไป DB ผ่าน)
      $_SESSION['success'] = "เพิ่มสินค้าเรียบร้อยแล้ว";
    } else {

      if (file_exists($upload_path)) {
        unlink($upload_path); // คำสั่งลบไฟล์ทิ้ง
      }
      $_SESSION['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล ตรวจเช็คข้อมูลอีกครั้งว่าซ้ำหรือลืมใส่ข้อมูลหรือไม่";

    }
  }

  header("Location: ../admin_product");
  exit();
}


if (isset($_POST['btn_update_product'])) {

  // 1. รับข้อมูลจาก Form (ชื่อต้องตรงกับ attribute 'name' ใน Modal)
  $product_id = $_POST['update_product_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_qty = $_POST['product_qty'];
  $product_detail = $_POST['product_detail'];
  $product_type_id = $_POST['product_type_id'];

  // จัดการ event_id: ถ้าไม่ได้เลือกมา ให้เป็นค่าว่าง (ซึ่งฟังก์ชันเราจะเปลี่ยนเป็น NULL ให้เอง)
  $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : "";

  // 2. จัดการไฟล์รูปภาพ
  $new_filename = null; // ตั้งต้นเป็น null แปลว่าไม่เปลี่ยนรูป

  // เช็คว่ามีการอัปโหลดไฟล์ใหม่มาจริงๆ และไม่มีข้อผิดพลาด
  if (isset($_FILES['product_picture']) && $_FILES['product_picture']['error'] == 0) {
    $file = $_FILES['product_picture'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION); // ดึงนามสกุลไฟล์

    // สุ่มชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
    $new_filename = "prod_" . uniqid() . "." . $ext;

    // กำหนดปลายทางที่เก็บรูป
    $upload_path = "../assets/images/product/" . $new_filename;

    // ย้ายไฟล์จากที่พัก (temp) ไปยังโฟลเดอร์จริง
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
      $_SESSION['error'] = "ไม่สามารถอัปโหลดรูปภาพได้";
      header("Location: ../admin_product.php");
      exit();
    }
  }

  // 3. เรียกใช้ฟังก์ชัน EditProduct ที่เราเพิ่งเขียนไป
  $result = EditProduct(
    $product_id,
    $product_name,
    $product_type_id,
    $product_price,
    $product_detail,
    $new_filename, // จะเป็นชื่อไฟล์ใหม่ หรือเป็น null ถ้าไม่เปลี่ยน
    $event_id,
    $product_qty
  );

  // 4. แจ้งผลลัพธ์ผ่าน Session และกลับหน้าเดิม
  if ($result) {
    $_SESSION['success'] = "แก้ไขข้อมูลสินค้าสำเร็จ";
  } else {
    $_SESSION['error'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล";
  }

  header("Location: ../admin_product.php");
  exit();
}


if (isset($_POST['delete_product_id'])) {
  $id = $_POST['delete_product_id'];

  if (DeleteProduct($id)) {
    $_SESSION['success'] = "ลบสินค้าสำเร็จ";
  } else {
    $_SESSION['error'] = "ไม่สามารถลบสินค้าได้";
  }
  header("Location: ../admin_product");
  exit();
}
