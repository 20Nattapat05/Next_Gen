<?php
/**
 * Account Management Functions - ฟังก์ชันจัดการบัญชี
 * ใช้สำหรับ User และ Admin
 */

require_once __DIR__ . '/../../config/dbconfig.php';

/**
 * อัปเดตข้อมูล User
 * 
 * @param int $user_id ID ของผู้ใช้
 * @param array $data ข้อมูลที่ต้องการอัปเดต (fullname, email, username)
 * @return array ผลลัพธ์ (success/error message)
 */
function UpdateUserInfo($user_id, $data) {
    try {
        $pdo = db();
        
        // Validation
        $fullname = trim($data['fullname'] ?? '');
        $email = trim($data['email'] ?? '');
        $username = trim($data['username'] ?? '');
        
        // Check if fields are empty
        if (empty($fullname) || empty($email) || empty($username)) {
            return ['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'];
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'รูปแบบอีเมลไม่ถูกต้อง'];
        }
        
        // Check username length
        if (strlen($username) < 3) {
            return ['success' => false, 'message' => 'ชื่อผู้ใช้ต้องมีความยาวอย่างน้อย 3 ตัวอักษร'];
        }
        
        // Check fullname length
        if (strlen($fullname) < 3) {
            return ['success' => false, 'message' => 'ชื่อ-นามสกุลต้องมีความยาวอย่างน้อย 3 ตัวอักษร'];
        }
        
        // Check if username already exists (except current user)
        $stmt = $pdo->prepare("SELECT user_id FROM user_tb WHERE user_username = :username AND user_id != :user_id");
        $stmt->execute([':username' => $username, ':user_id' => $user_id]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'ชื่อผู้ใช้นี้มีอยู่แล้ว'];
        }
        
        // Check if email already exists (except current user)
        $stmt = $pdo->prepare("SELECT user_id FROM user_tb WHERE user_email = :email AND user_id != :user_id");
        $stmt->execute([':email' => $email, ':user_id' => $user_id]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'อีเมลนี้มีอยู่แล้ว'];
        }
        
        $sql = "UPDATE user_tb SET 
                user_fullname = :fullname,
                user_email = :email,
                user_username = :username
                WHERE user_id = :user_id";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':fullname' => $fullname,
            ':email' => $email,
            ':username' => $username,
            ':user_id' => $user_id
        ]);
        
        if ($result) {
            return ['success' => true, 'message' => 'อัปเดตข้อมูลสำเร็จ'];
        } else {
            return ['success' => false, 'message' => 'การอัปเดตล้มเหลว'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}

/**
 * อัปเดตรหัสผ่าน User
 * 
 * @param int $user_id ID ของผู้ใช้
 * @param string $old_password รหัสผ่านเดิม
 * @param string $new_password รหัสผ่านใหม่
 * @return array ผลลัพธ์ (success/error message)
 */
function UpdateUserPassword($user_id, $old_password, $new_password) {
    try {
        $pdo = db();
        
        // ตรวจสอบรหัสผ่านเดิม
        $stmt = $pdo->prepare("SELECT user_password FROM user_tb WHERE user_id = :id");
        $stmt->execute([':id' => $user_id]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($old_password, $user['user_password'])) {
            return ['success' => false, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง'];
        }
        
        // ตรวจสอบรหัสผ่านใหม่
        if (strlen($new_password) < 6) {
            return ['success' => false, 'message' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'];
        }
        
        // อัปเดตรหัสผ่าน
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE user_tb SET user_password = :password WHERE user_id = :id");
        
        if ($stmt->execute([':password' => $hashed_password, ':id' => $user_id])) {
            return ['success' => true, 'message' => 'อัปเดตรหัสผ่านสำเร็จ'];
        } else {
            return ['success' => false, 'message' => 'การอัปเดตล้มเหลว'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}

/**
 * อัปเดตข้อมูล Admin
 * 
 * @param int $admin_id ID ของแอดมิน
 * @param array $data ข้อมูลที่ต้องการอัปเดต (username, email, fname, sname)
 * @return array ผลลัพธ์ (success/error message)
 */
function UpdateAdminInfo($admin_id, $data) {
    try {
        $pdo = db();
        
        // Validation
        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $fname = trim($data['fname'] ?? '');
        $sname = trim($data['sname'] ?? '');
        
        // Check if fields are empty
        if (empty($username) || empty($email) || empty($fname) || empty($sname)) {
            return ['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'];
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'รูปแบบอีเมลไม่ถูกต้อง'];
        }
        
        // Check username length
        if (strlen($username) < 3) {
            return ['success' => false, 'message' => 'ชื่อผู้ใช้ต้องมีความยาวอย่างน้อย 3 ตัวอักษร'];
        }
        
        // Check if username already exists (except current admin)
        $stmt = $pdo->prepare("SELECT admin_id FROM admin_tb WHERE admin_username = :username AND admin_id != :admin_id");
        $stmt->execute([':username' => $username, ':admin_id' => $admin_id]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'ชื่อผู้ใช้นี้มีอยู่แล้ว'];
        }
        
        // Check if email already exists (except current admin)
        $stmt = $pdo->prepare("SELECT admin_id FROM admin_tb WHERE admin_email = :email AND admin_id != :admin_id");
        $stmt->execute([':email' => $email, ':admin_id' => $admin_id]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'อีเมลนี้มีอยู่แล้ว'];
        }
        
        $sql = "UPDATE admin_tb SET 
                admin_username = :username,
                admin_email = :email,
                admin_fname = :fname,
                admin_sname = :sname
                WHERE admin_id = :admin_id";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':fname' => $fname,
            ':sname' => $sname,
            ':admin_id' => $admin_id
        ]);
        
        if ($result) {
            return ['success' => true, 'message' => 'อัปเดตข้อมูลสำเร็จ'];
        } else {
            return ['success' => false, 'message' => 'การอัปเดตล้มเหลว'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}

/**
 * อัปเดตรหัสผ่าน Admin
 * 
 * @param int $admin_id ID ของแอดมิน
 * @param string $old_password รหัสผ่านเดิม
 * @param string $new_password รหัสผ่านใหม่
 * @return array ผลลัพธ์ (success/error message)
 */
function UpdateAdminPassword($admin_id, $old_password, $new_password) {
    try {
        $pdo = db();
        
        // ตรวจสอบรหัสผ่านเดิม
        $stmt = $pdo->prepare("SELECT admin_password FROM admin_tb WHERE admin_id = :id");
        $stmt->execute([':id' => $admin_id]);
        $admin = $stmt->fetch();
        
        if (!$admin || !password_verify($old_password, $admin['admin_password'])) {
            return ['success' => false, 'message' => 'รหัสผ่านเดิมไม่ถูกต้อง'];
        }
        
        // ตรวจสอบรหัสผ่านใหม่
        if (strlen($new_password) < 6) {
            return ['success' => false, 'message' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'];
        }
        
        // อัปเดตรหัสผ่าน
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admin_tb SET admin_password = :password WHERE admin_id = :id");
        
        if ($stmt->execute([':password' => $hashed_password, ':id' => $admin_id])) {
            return ['success' => true, 'message' => 'อัปเดตรหัสผ่านสำเร็จ'];
        } else {
            return ['success' => false, 'message' => 'การอัปเดตล้มเหลว'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}

?>
