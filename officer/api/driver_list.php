<?php
session_start();
require_once '../../classes/DatabaseUsers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    $db = new App\DatabaseUsers();
    // ดึงข้อมูลครูที่มี role_general = 'DRV' และ Teach_status = 1
    $sql = "SELECT Teach_id, Teach_name, role_general 
            FROM teacher 
            WHERE role_general = 'DRV' AND Teach_status = 1 
            ORDER BY Teach_name ASC";
    
    $stmt = $db->query($sql);
    $drivers = $stmt->fetchAll();
    
    echo json_encode([
        'success' => true,
        'list' => $drivers
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
