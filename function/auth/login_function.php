<?php

require_once __DIR__ . '/../../config/dbconfig.php';

function login($data)
{
  $username = trim($data['username'] ?? '');
  $password = $data['password'] ?? '';

  if ($username === '' || $password === '') {
    return false;
  }

  $pdo = db();

  // admin role check
  $stmt = $pdo->prepare("
        SELECT admin_id, admin_username, admin_password
        FROM admin_tb
        WHERE admin_email = :username
        OR admin_username = :username
        LIMIT 1
    ");
  $stmt->execute(['username' => $username]);
  $admin = $stmt->fetch();

  if ($admin && password_verify($password, $admin['admin_password'])) {
    // return admin data
    return $admin;
  }


  // user role check
  $stmt = $pdo->prepare("
    SELECT user_id, user_username, user_password, user_fullname, user_email, user_status
    FROM user_tb 
    WHERE user_email = :username 
    OR user_username = :username 
    LIMIT 1
  ");
  $stmt->execute(['username' => $username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['user_password'])) {
    // return user data
    return $user;
  }

  return false;
}

?>