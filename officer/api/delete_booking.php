<?php
/**
 * Delete Booking API - Officer Module
 * Permanently delete a meeting room booking
 */
session_start();

// Check authentication
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../controllers/BookingController.php';
use Controllers\BookingController;

header('Content-Type: application/json');

// รับข้อมูลทั้ง JSON และ POST
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    $data = $_POST;
}

$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ไม่พบรหัสการจอง']);
    exit;
}

$controller = new BookingController();
// Officer can delete any booking, so we don't pass teacher_id
$result = $controller->delete($id, null);

// Check result format and return appropriate response
if (is_array($result)) {
    echo json_encode($result);
} else {
    echo json_encode(['success' => $result]);
}
