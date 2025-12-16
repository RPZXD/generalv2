<?php
session_start();
header('Content-Type: application/json');

// ตรวจสอบสิทธิ์เจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

// ตรวจสอบข้อมูลที่ส่งมา - รองรับ room_id หรือ location
$hasRoom = !empty($_POST['room_id']) || !empty($_POST['location']);
if (
    empty($_POST['id']) ||
    empty($_POST['date']) ||
    !$hasRoom ||
    empty($_POST['time_start']) ||
    empty($_POST['time_end']) ||
    empty($_POST['purpose'])
) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    exit;
}

require_once(__DIR__ . '/../../controllers/BookingController.php');
require_once(__DIR__ . '/../../classes/DatabaseGeneral.php');

use Controllers\BookingController;
use App\DatabaseGeneral;

$controller = new BookingController();

// ถ้ามี room_id ให้ดึงชื่อห้องจาก database
$location = isset($_POST['location']) ? $_POST['location'] : '';
$room_id = isset($_POST['room_id']) ? $_POST['room_id'] : null;

if (!empty($room_id)) {
    $db = new DatabaseGeneral();
    $stmt = $db->query("SELECT room_name FROM meeting_rooms WHERE id = :id", ['id' => $room_id]);
    $room = $stmt->fetch(\PDO::FETCH_ASSOC);
    if ($room) {
        $location = $room['room_name'];
    }
}

// Handle room layout - if other, combine with custom value
$roomLayout = isset($_POST['room_layout']) ? $_POST['room_layout'] : 'none';
if ($roomLayout === 'other' && !empty($_POST['room_layout_custom'])) {
    $roomLayout = 'custom:' . trim($_POST['room_layout_custom']);
}

$data = [
    'id' => $_POST['id'],
    'date' => $_POST['date'],
    'room_id' => $room_id,
    'location' => $location,
    'time_start' => $_POST['time_start'],
    'time_end' => $_POST['time_end'],
    'purpose' => $_POST['purpose'],
    'media' => isset($_POST['media']) ? $_POST['media'] : '',
    'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
    'room_layout' => $roomLayout
];

// ตรวจสอบความพร้อมของห้อง (exclude ตัวเอง) - ใช้ room_id ถ้ามี
if (!$controller->model->checkAvailability($data['date'], $data['time_start'], $data['time_end'], $data['location'], $data['id'], $room_id)) {
    echo json_encode(['success' => false, 'message' => 'ห้องไม่ว่างในช่วงเวลานี้']);
    exit;
}

// อัปเดตข้อมูล (officer ไม่ต้องส่ง teacher_id)
$success = $controller->model->update($data, null);

if ($success) {
    echo json_encode(['success' => true, 'message' => 'แก้ไขข้อมูลสำเร็จ']);
} else {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล หรือไม่มีการเปลี่ยนแปลง']);
}
