<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../login.php');
  exit();
}

session_start();

require_once __DIR__ . '/../function/auth/login_function.php';

$result = login($_POST);

if ($result === true) {
  if (isset($_SESSION['admin_id'])) {
    $_SESSION['login_success'] = true;
    header('Location: /Next_Gen/admin_home');
    exit();
  }

  if (isset($_SESSION['user_id'])) {
    $_SESSION['login_success'] = true;
    header('Location: ../user/home.php');
    exit();
  }
}

// Login error
$_SESSION['login_error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
header('Location: /Next_Gen/login');
exit();
