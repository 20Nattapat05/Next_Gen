<?php
session_start();

require_once __DIR__ . '/../function/admin/user_function.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    
    $user_id = $_POST['user_id'];
    $status_to_update = '';


    if (isset($_POST['ban_user'])) {
        $status_to_update = 'banned';
        $message_success = "ระงับการใช้งานสมาชิกเรียบร้อยแล้ว";
    } elseif (isset($_POST['unban_user'])) {
        $status_to_update = 'active';
        $message_success = "ปลดระงับสมาชิกเรียบร้อยแล้ว";
    }

    if (!empty($status_to_update)) {
        $result = UpdateUserStatus($user_id, $status_to_update);

        if ($result) {
            $_SESSION['success'] = $message_success;
        } else {
            $_SESSION['error'] = "ไม่สามารถดำเนินการได้ กรุณาลองใหม่";
        }
    }


    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();

} else {

    header("Location: ../admin_index.php");
    exit();
}