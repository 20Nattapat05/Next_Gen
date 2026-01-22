<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../login.php');
  exit();
}

session_start();

require_once __DIR__ . '/../function/auth/login_function.php';

$result = login($_POST);

if (is_array($result)) { 


    if (isset($result['admin_id'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $result['admin_id'];
        $_SESSION['admin_username'] = $result['admin_username'];
        $_SESSION['admin_email'] = $result['admin_email'];
        $_SESSION['admin_fname'] = $result['admin_fname'];
        $_SESSION['admin_sname'] = $result['admin_sname'];
        $_SESSION['login_success'] = true;
        header('Location: /Next_Gen/admin_home');
        exit();
    }

    
    if (isset($result['user_id'])) {
        
        // Check if user is active
        if ($result['user_status'] !== 'active') {
            $_SESSION['login_error'] = 'บัญชีผู้ใช้ของคุณถูกระงับหรือไม่เป็นสมาชิกที่ใช้งานได้ กรุณาติดต่อแอดมิน';
            header('Location: /Next_Gen/login');
            exit();
        }
        
        session_regenerate_id(true);

        $_SESSION['user_id']         = $result['user_id'];
        $_SESSION['user_username']   = $result['user_username'];
        $_SESSION['user_fullname']   = $result['user_fullname']; 
        $_SESSION['user_email']      = $result['user_email'];
        $_SESSION['user_status']     = $result['user_status'];

        $_SESSION['user_login_success'] = true;

        header('Location: ../');
        exit();
    }
}




$_SESSION['login_error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
header('Location: /Next_Gen/login');
exit();
