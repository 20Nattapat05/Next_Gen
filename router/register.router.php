<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /Next_Gen/register');
}


require_once __DIR__ . '/../function/auth/register_function.php';

$fullname = htmlspecialchars($_POST['fullname'] ?? '');
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$username = htmlspecialchars(trim($_POST['username'] ?? ''));
$password = trim($_POST['password'] ?? '');
$password_confirm = trim($_POST['password_confirm'] ?? '');

  if ($fullname === '' || $email === '' || $phone === '' || $username === '' || $password === '') {
    $_SESSION['register_error'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: /Next_Gen/register');
    exit();
  }
  
  if (strlen($password) < 8) {
    $_SESSION['register_error'] = 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร';
    header('Location: /Next_Gen/register');
    exit();
  }

  if ($password !== $password_confirm) {
    $_SESSION['register_error'] = 'รหัสผ่านทั้งสองไม่ตรงกัน กรุณาลองใหม่';
    header('Location: /Next_Gen/register');
    exit();
  }


  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_error'] = 'รูปแบบอีเมลไม่ถูกต้อง กรุณาลองใหม่ ตัวอย่าง example@example.com';
    header('Location: /Next_Gen/register');
    exit();
  }

if (!is_numeric($phone) || strlen($phone) !== 10) {
    $_SESSION['register_error'] = 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง (กรุณากรอกตัวเลข 10 หลัก เช่น 0812345678)';
    header('Location: /Next_Gen/register');
    exit();
}


  $result = register($fullname, $email, $phone, $username, $password);

  if ($result === true) {
    $_SESSION['register_success'] = 'สมัครสมาชิกสำเร็จ คุณสามารถเข้าสู่ระบบได้ทันที';
    header('Location: /Next_Gen/login');
    exit();
  } else {
    $_SESSION['register_error'] = 'อีเมลหรือชื่อผู้ใช้ถูกใช้งานแล้ว กรุณาลองใหม่';
    header('Location: /Next_Gen/register');
    exit();
  }

?>
