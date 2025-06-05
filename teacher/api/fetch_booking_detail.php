<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../classes/DatabaseUsers.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';

use Controllers\BookingController;
use App\DatabaseUsers;

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
        // ดึงชื่อครูจาก DatabaseUsers
        $teacher_name = null;
        if (!empty($booking['teach_id'])) {
            $userDb = new DatabaseUsers();
            $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$booking['teach_id']])->fetch();
            if ($teacher && isset($teacher['Teach_name'])) {
                $teacher_name = $teacher['Teach_name'];
            }
        }
        $booking['teacher_name'] = $teacher_name;
        echo json_encode(['success' => true, 'booking' => $booking]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
    }
} catch (\Throwable $e) {
    error_log("Error in fetch_booking_detail.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
