<?php
session_start();
require_once '../../classes/DatabaseUsers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

try {
    $db = new \App\DatabaseUsers();
    
    // Fetch all teachers that are active
    $sql = "SELECT Teach_id, Teach_name, role_general, Teach_status, Teach_photo
            FROM teacher 
            WHERE Teach_status = '1'
            ORDER BY Teach_id ASC";
    
    $stmt = $db->query($sql);
    $users = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'users' => $users
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
