<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Next_Gen/admin_event');
  exit();
}

require_once __DIR__ . '/../function/admin/event_function.php';


if (isset($_POST['event_name']) && isset($_POST['event_discount'])) {
  $event_name = trim($_POST['event_name']);
  $event_discount = trim($_POST['event_discount']);

  if ($event_name === '' || $event_discount === '') {
    $_SESSION['event_input_error'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: /Next_Gen/admin_home');
    exit();
  }

  $CheckEvent = CheckEvent($event_name);
  if ($CheckEvent) {
    $_SESSION['event_input_error'] = 'ชื่องานกิจกรรมนี้มีอยู่แล้ว กรุณาใช้ชื่ออื่น';
    header('Location: /Next_Gen/admin_home');
    exit();
  }

  $add_result = AddEvent($event_name, $event_discount);
  if ($add_result) {
    $_SESSION['event_success'] = 'เพิ่มงานกิจกรรมสำเร็จ';
  } else {
    $_SESSION['event_input_error'] = 'เกิดข้อผิดพลาดในการเพิ่มงานกิจกรรม กรุณาลองใหม่';
  }
  header('Location: /Next_Gen/admin_home');
  exit();
}

if (isset($_POST['delete_event_id'])) {
  $event_id = $_POST['delete_event_id'];

  $delete_result = DeleteEvent($event_id);
  if ($delete_result === true) {
    $_SESSION['event_success'] = 'ลบงานกิจกรรมสำเร็จ';
  } elseif ($delete_result === false) {
    $_SESSION['event_input_error'] = 'ไม่สามารถลบงานกิจกรรมได้ เนื่องจากมีสินค้าที่เกี่ยวข้องอยู่';
  } else {
    $_SESSION['event_input_error'] = 'เกิดข้อผิดพลาดในการลบงานกิจกรรม กรุณาลองใหม่';
  }
  header('Location: /Next_Gen/admin_home');
  exit();
}

header('Location: /Next_Gen/admin_home');
exit();
