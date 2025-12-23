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
    session_regenerate_id(true);
    // set session
    $_SESSION['admin_id'] = $admin['admin_id'];

    return true;
  }


  // user role check
  $stmt = $pdo->prepare("
    SELECT user_id, user_username, user_password 
    FROM user_tb 
    WHERE user_email = :username 
    OR user_username = :username 
    LIMIT 1
  ");
  $stmt->execute(['username' => $username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['user_password'])) {
    session_regenerate_id(true);
    // set session
    $_SESSION['user_id'] = $user['user_id'];

    return true;
  }

  return false;
}

?>