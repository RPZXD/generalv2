<?php
session_start();
header('Content-Type: application/json');

// ตรวจสอบสิทธิ์เจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

// ตรวจสอบข้อมูลที่ส่งมา
if (
    empty($_POST['id']) ||
    empty($_POST['date']) ||
    empty($_POST['location']) ||
    empty($_POST['time_start']) ||
    empty($_POST['time_end']) ||
    empty($_POST['purpose'])
) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    exit;
}

require_once(__DIR__ . '/../../controllers/BookingController.php');

use Controllers\BookingController;

$controller = new BookingController();

$data = [
    'id' => $_POST['id'],
    'date' => $_POST['date'],
    'location' => $_POST['location'],
    'time_start' => $_POST['time_start'],
    'time_end' => $_POST['time_end'],
    'purpose' => $_POST['purpose'],
    'media' => isset($_POST['media']) ? $_POST['media'] : '',
    'phone' => isset($_POST['phone']) ? $_POST['phone'] : ''
];

// ตรวจสอบความพร้อมของห้อง (exclude ตัวเอง)
if (!$controller->model->checkAvailability($data['date'], $data['time_start'], $data['time_end'], $data['location'], $data['id'])) {
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
