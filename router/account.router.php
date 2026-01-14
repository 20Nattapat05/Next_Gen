<?php

session_start();

require_once __DIR__ . '/../function/shared/account_function.php';

// Check if user or admin is logged in
$isAdmin = isset($_SESSION['admin_id']);
$isUser = isset($_SESSION['user_id']);

if (!$isAdmin && !$isUser) {
    header('Location: ../login.php');
    exit();
}

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($isUser) {
        // User actions
        if ($action === 'update_info') {
            $result = UpdateUserInfo($_SESSION['user_id'], 
            data: [
                'fullname' => $_POST['fullname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'username' => $_POST['username'] ?? ''
            ]);
            
            if ($result['success']) {
                // Update session
                $_SESSION['user_fullname'] = htmlspecialchars($_POST['fullname']);
                $_SESSION['user_email'] = htmlspecialchars($_POST['email']);
                $_SESSION['user_username'] = htmlspecialchars($_POST['username']);
            }
            
            $response = $result;
        } 
        else if ($action === 'update_password') {
            $result = UpdateUserPassword(
                $_SESSION['user_id'],
                $_POST['old_password'] ?? '',
                $_POST['new_password'] ?? ''
            );
            $response = $result;
        }
    } 
    else if ($isAdmin) {
        // Admin actions
        if ($action === 'update_info') {
            $result = UpdateAdminInfo($_SESSION['admin_id'], [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'fname' => $_POST['fname'] ?? '',
                'sname' => $_POST['sname'] ?? ''
            ]);
            
            if ($result['success']) {
                // Update session
                $_SESSION['admin_username'] = htmlspecialchars($_POST['username']);
                $_SESSION['admin_email'] = htmlspecialchars($_POST['email']);
                $_SESSION['admin_fname'] = htmlspecialchars($_POST['fname']);
                $_SESSION['admin_sname'] = htmlspecialchars($_POST['sname']);
            }
            
            $response = $result;
        } 
        else if ($action === 'update_password') {
            $result = UpdateAdminPassword(
                $_SESSION['admin_id'],
                $_POST['old_password'] ?? '',
                $_POST['new_password'] ?? ''
            );
            $response = $result;
        }
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();

?>
