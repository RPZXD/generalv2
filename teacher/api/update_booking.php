<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';

use App\DatabaseGeneral;
use Controllers\BookingController;

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
    
    // รวม media จาก edit_media_items[] (ถ้ามี)
    $media = [];
    if (!empty($data['edit_media_items'])) {
        if (is_array($data['edit_media_items'])) {
            $media = $data['edit_media_items'];
        } else {
            $media = explode(',', $data['edit_media_items']);
            $media = array_map('trim', $media);
        }
    }
    if (!empty($data['edit_other_media'])) {
        $media[] = trim($data['edit_other_media']);
    }
    // ถ้ามี media string ตรงๆ ก็ใช้
    if (!empty($data['media']) && empty($media)) {
        $data['media'] = $data['media'];
    } else if (!empty($media)) {
        $data['media'] = implode(', ', $media);
    } else {
        $data['media'] = '';
    }
    
    // ใช้ BookingController เพื่อให้รองรับ room_layout
    // ถ้ามี room_id ให้ดึงชื่อห้องจาก database มาใส่ใน location ด้วย
    if (!empty($data['room_id'])) {
        $stmt = $db->query("SELECT room_name FROM meeting_rooms WHERE id = :id", ['id' => $data['room_id']]);
        $room = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($room) {
            $data['location'] = $room['room_name'];
        }
    }
    
    $controller = new BookingController();
    $result = $controller->update($data, $teacher_id);
    
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
