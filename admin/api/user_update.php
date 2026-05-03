<?php
session_start();
require_once '../../classes/DatabaseUsers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || !isset($data['teach_id']) || !isset($data['action'])) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
        exit;
    }

    $teach_id = $data['teach_id'];
    $action = $data['action'];
    $db = new \App\DatabaseUsers();

    if ($action === 'update_role') {
        $role = $data['role'] ?? 'T'; // Default to Teacher
        $sql = "UPDATE teacher SET role_general = ? WHERE Teach_id = ?";
        $db->query($sql, [$role, $teach_id]);
        echo json_encode(['success' => true, 'message' => 'อัปเดตสิทธิ์การใช้งานเรียบร้อยแล้ว']);
    } else if ($action === 'reset_password') {
        // Clearing the 'password' column so the user reverts to initial login (Teach_id as password)
        $sql = "UPDATE teacher SET password = NULL WHERE Teach_id = ?";
        $db->query($sql, [$teach_id]);
        echo json_encode(['success' => true, 'message' => 'รีเซ็ตรหัสผ่านเป็นรหัสเริ่มต้นเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'การทำงานไม่ถูกต้อง']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
