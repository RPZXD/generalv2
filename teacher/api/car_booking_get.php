<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';
require_once '../../classes/DatabaseUsers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    $id = $_GET['id'] ?? '';
    
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาระบุรหัสการจอง']);
        exit;
    }
    
    $dbGeneral = new App\DatabaseGeneral();
    $dbUsers = new App\DatabaseUsers();
    
    // ดึงข้อมูลการจองและรถยนต์จาก phichaia_general
    $sql = "SELECT cb.*, 
                   c.car_model, c.license_plate, c.car_type, c.capacity
            FROM car_bookings cb
            LEFT JOIN cars c ON cb.car_id = c.id
            WHERE cb.id = ?";
    
    $stmt = $dbGeneral->query($sql, [$id]);
    $booking = $stmt->fetch();
    
    if (!$booking) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
        exit;
    }
    
    // ดึงข้อมูลครูจาก phichaia_student
    if ($booking['teacher_id']) {
        $teacher = $dbUsers->getTeacherById($booking['teacher_id']);
        if ($teacher) {
            $booking['teacher_name'] = $teacher['Teach_name'];
            $booking['teacher_position'] = ($teacher['Teach_Position2'] == "ลูกจ้างชั่วคราว (บกศ.)" || $teacher['Teach_Position2'] == "ลูกจ้างชั่วคราว (สพฐ.)") ? "ครูอัตราจ้าง" : $teacher['Teach_Position2'];
            $booking['teacher_phone'] = $teacher['Teach_phone'];
        }
    }
    
    echo json_encode([
        'success' => true,
        'booking' => $booking
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
?>
