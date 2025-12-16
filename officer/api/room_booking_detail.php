<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

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
        $teacher_phone = null;
        if (!empty($booking['teach_id'])) {
            $userDb = new DatabaseUsers();
            $teacher = $userDb->query("SELECT Teach_name, Teach_phone FROM teacher WHERE Teach_id = ?", [$booking['teach_id']])->fetch();
            if ($teacher) {
                $teacher_name = $teacher['Teach_name'] ?? null;
                $teacher_phone = $teacher['Teach_phone'] ?? null;
            }
        }
        $booking['teacher_name'] = $teacher_name;
        $booking['teacher_phone'] = $teacher_phone;
        echo json_encode(['success' => true, 'booking' => $booking]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
    }
} catch (\Throwable $e) {
    error_log("Error in room_booking_detail.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
