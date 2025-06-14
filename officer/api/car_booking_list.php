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
    $dbGeneral = new App\DatabaseGeneral();
    $dbUsers = new App\DatabaseUsers();
    
    // ดึงข้อมูลการจองและรถยนต์จาก phichaia_general
    $sql = "SELECT cb.*, 
                   c.car_model, c.license_plate, c.car_type, c.capacity
            FROM car_bookings cb
            LEFT JOIN cars c ON cb.car_id = c.id
            ORDER BY cb.created_at DESC";
    
    $stmt = $dbGeneral->query($sql);
    $bookings = $stmt->fetchAll();
    
    // ดึงข้อมูลครูแยกต่างหากและเพิ่มเข้าไปในผลลัพธ์
    foreach ($bookings as &$booking) {
        if ($booking['teacher_id']) {
            $teacher = $dbUsers->getTeacherById($booking['teacher_id']);
            if ($teacher) {
                $booking['teacher_name'] = $teacher['Teach_name'];
                $booking['teacher_position'] = ($teacher['Teach_Position2'] == "ลูกจ้างชั่วคราว (บกศ.)" || $teacher['Teach_Position2'] == "ลูกจ้างชั่วคราว (สพฐ.)") ? "ครูอัตราจ้าง" : $teacher['Teach_Position2'];
                $booking['teacher_phone'] = $teacher['Teach_phone'];
            } else {
                $booking['teacher_name'] = 'ไม่พบข้อมูลครู';
                $booking['teacher_position'] = '';
                $booking['teacher_phone'] = '';
            }
        } else {
            $booking['teacher_name'] = '-';
            $booking['teacher_position'] = '';
            $booking['teacher_phone'] = '';
        }
    }
    unset($booking); // ยกเลิก reference
    
    echo json_encode([
        'success' => true,
        'list' => $bookings
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
?>
