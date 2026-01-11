<?php

require_once __DIR__ . '/../../config/dbconfig.php';

/**
 * 1. ดึงข้อมูลสมาชิกทั้งหมด พร้อมระบบค้นหา
 */
function GetAllUsers($search = null)
{
    try {
        $pdo = db();
        // ดึงเฉพาะ User ที่ไม่ใช่ Admin (เลือกระดับได้ตามความเหมาะสม)
        $sql = "SELECT user_id, user_fullname, user_email, user_status, created_at 
                FROM user_tb WHERE 1=1"; 

        $params = [];

        if (!empty($search)) {
            $sql .= " AND (user_fullname LIKE :search OR user_email LIKE :search)";
            $params[':search'] = "%$search%";
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * 2. ฟังก์ชันเปลี่ยนสถานะผู้ใช้ (Active / Banned)
 */
function UpdateUserStatus($user_id, $status)
{
    try {
        $pdo = db();
        $sql = "UPDATE user_tb SET user_status = :user_status, updated_at = NOW() WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':user_status' => $status,
            ':user_id' => $user_id
        ]);
    } catch (PDOException $e) {
        return false;
        // die($e->getMessage());
    }
}

/**
 * 3. นับจำนวนสมาชิกทั้งหมด (สำหรับแสดงหน้า Dashboard)
 */
function CountTotalUsers()
{
    try {
        $pdo = db();
        $stmt = $pdo->query("SELECT COUNT(*) FROM user_tb");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}