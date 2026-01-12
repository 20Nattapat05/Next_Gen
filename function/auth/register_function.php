<?php

require_once __DIR__ . '/../../config/dbconfig.php';

function register($fullname, $email, $phone, $username, $password)
{
  try {
    $pdo = db();


    $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_tb WHERE user_email = :email OR user_username = :username");
    $stmt->execute(
      [
        'email' => $email,
        'username' => $username
      ]
    );
    $count = $stmt->fetchColumn();

    if ($count > 0) {
      return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $pdo->prepare("
      INSERT INTO user_tb (user_id, user_username, user_password, user_fullname, user_email, user_phone, user_status, created_at, updated_at)
      VALUES (:id, :username, :password, :fullname, :email, :phone, 'active', NOW(), NOW())
    ");

    $result = $stmt->execute([
      'id' => null,
      'username' => $username,
      'password' => $hashedPassword,
      'fullname' => $fullname,
      'email' => $email,
      'phone' => $phone,
    ]);

    return $result;
  } catch (PDOException $e) {
    // for production
    die("ระบบฐานข้อมูลขัดข้อง กรุณาลองใหม่ภายหลัง");

    // for dev
    // die($e->getMessage());
  }
}

?>