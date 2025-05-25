<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';

use Controllers\BookingController;

header('Content-Type: application/json');

try {
    // รับข้อมูลจาก JSON input แทน $_POST
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? $input['id'] : null;


    if (!$id || !$teacher_id) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
        exit;
    }

    $controller = new BookingController();
    $success = $controller->delete($id);

    echo json_encode(['success' => $success]);
} catch (\Throwable $e) {
    error_log("Error in delete_booking.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
