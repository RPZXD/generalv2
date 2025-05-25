<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';

use Controllers\BookingController;

header('Content-Type: application/json');

try {
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
        exit;
    }

    $controller = new BookingController();
    $booking = $controller->getDetail($id);

    if ($booking) {
        echo json_encode(['success' => true, 'booking' => $booking]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
    }
} catch (\Throwable $e) {
    error_log("Error in fetch_booking_detail.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
