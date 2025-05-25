<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

use App\DatabaseGeneral;

header('Content-Type: application/json');

session_start();
$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];

if (!$teacher_id) {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลผู้ใช้']);
    exit;
}

try {
    $data = $_POST;
    $id = isset($data['id']) ? $data['id'] : null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบรหัสการจอง']);
        exit;
    }
    
    $db = new DatabaseGeneral();
    
    // ตรวจสอบว่าเป็นเจ้าของการจองหรือไม่
    $sql = "SELECT id FROM bookings WHERE id = ? AND teach_id = ?";
    $stmt = $db->query($sql, [$id, $teacher_id]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลหรือไม่มีสิทธิ์แก้ไข']);
        exit;
    }
    
    $sql = "UPDATE bookings SET 
            date = ?, 
            location = ?, 
            time_start = ?, 
            time_end = ?, 
            purpose = ?, 
            media = ?, 
            phone = ?
            WHERE id = ? AND teach_id = ?";
    
    $params = [
        $data['date'],
        $data['location'],
        $data['time_start'],
        $data['time_end'],
        $data['purpose'],
        $data['media'] ?? '',
        $data['phone'] ?? '',
        $id,
        $teacher_id
    ];
    
    $stmt = $db->query($sql, $params);
    
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
