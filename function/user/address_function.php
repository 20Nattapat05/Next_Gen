<?php

require_once __DIR__ . '/../../config/dbconfig.php';

function GetAddressesByUserId($user_id) {
    try {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT address_id, user_id, address_name, recipient_name, recipient_phone, address_detail, postal_code, created_at FROM user_address_tb WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function AddAddress($user_id, $address_name, $recipient_name, $recipient_phone, $address_detail, $postal_code) {
    try {
        $address_name = trim($address_name);
        $recipient_name = trim($recipient_name);
        $recipient_phone = trim($recipient_phone);
        $address_detail = trim($address_detail);
        $postal_code = trim($postal_code);

        if ($address_name === '' || $recipient_name === '' || $recipient_phone === '' || $address_detail === '' || $postal_code === '') {
            return ['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'];
        }

        if (!preg_match('/^[0-9]{10}$/', $recipient_phone)) {
            return ['success' => false, 'message' => 'เบอร์โทรต้องเป็นตัวเลข 10 หลัก'];
        }

        if (!preg_match('/^[0-9]{5}$/', $postal_code)) {
            return ['success' => false, 'message' => 'รหัสไปรษณีย์ต้องเป็นตัวเลข 5 หลัก'];
        }

        $pdo = db();
        $stmt = $pdo->prepare("INSERT INTO user_address_tb (user_id, address_name, recipient_name, recipient_phone, address_detail, postal_code, created_at) VALUES (:user_id, :address_name, :recipient_name, :recipient_phone, :address_detail, :postal_code, NOW())");
        $ok = $stmt->execute([
            ':user_id' => $user_id,
            ':address_name' => $address_name,
            ':recipient_name' => $recipient_name,
            ':recipient_phone' => $recipient_phone,
            ':address_detail' => $address_detail,
            ':postal_code' => $postal_code
        ]);

        if ($ok) return ['success' => true, 'message' => 'เพิ่มที่อยู่สำเร็จ'];
        return ['success' => false, 'message' => 'ไม่สามารถเพิ่มที่อยู่ได้'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}

function DeleteAddress($user_id, $address_id) {
    try {
        $pdo = db();
        $stmt = $pdo->prepare("DELETE FROM user_address_tb WHERE address_id = :address_id AND user_id = :user_id");
        $ok = $stmt->execute([':address_id' => $address_id, ':user_id' => $user_id]);
        if ($ok && $stmt->rowCount() > 0) return ['success' => true, 'message' => 'ลบที่อยู่สำเร็จ'];
        return ['success' => false, 'message' => 'ไม่พบที่อยู่หรือไม่มีสิทธิ์ลบ'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'เกิดข้อผิดพลาดในฐานข้อมูล'];
    }
}


?>
