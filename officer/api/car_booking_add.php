<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    // รับข้อมูลจาก POST
    $teacher_id = $_POST['teacher_id'] ?? '';
    $car_id = $_POST['car_id'] ?? '';
    $start_datetime = $_POST['start_datetime'] ?? '';
    $end_datetime = $_POST['end_datetime'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $passenger_count = $_POST['passenger_count'] ?? '';
    $student_count = $_POST['student_count'] ?? 0;
    $passengers_detail = $_POST['passengers_detail'] ?? '';
    $teacher_name = $_POST['teacher_name'] ?? '';
    $teacher_position = $_POST['teacher_position'] ?? '';
    $teacher_phone = $_POST['teacher_phone'] ?? '';
    $notes = $_POST['notes'] ?? '';

    // แปลงวันเวลา
    $booking_date = '';
    $start_time = '';
    $end_time = '';
    if ($start_datetime && $end_datetime) {
        $start_dt = date_create($start_datetime);
        $end_dt = date_create($end_datetime);
        $booking_date = $start_dt ? $start_dt->format('Y-m-d') : '';
        $start_time = $start_dt ? $start_dt->format('Y-m-d H:i:s') : '';
        $end_time = $end_dt ? $end_dt->format('Y-m-d H:i:s') : '';
    }

    // ตรวจสอบข้อมูลที่จำเป็น
    if (
        empty($teacher_id) || empty($car_id) || empty($booking_date) ||
        empty($start_time) || empty($end_time) || empty($destination) ||
        empty($purpose) || $passenger_count === ''
    ) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit;
    }

    // ตรวจสอบความถูกต้องของข้อมูล
    if (!is_numeric($passenger_count) || $passenger_count < 1) {
        echo json_encode(['success' => false, 'message' => 'จำนวนผู้โดยสารไม่ถูกต้อง']);
        exit;
    }

    // ตรวจสอบว่าเวลาเริ่มต้นน้อยกว่าเวลาสิ้นสุด
    if ($start_time >= $end_time) {
        echo json_encode(['success' => false, 'message' => 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด']);
        exit;
    }

    $db = new App\DatabaseGeneral();

    // ตรวจสอบว่ารถว่างในช่วงเวลาที่ต้องการ
    $checkSql = "SELECT COUNT(*) as count FROM car_bookings 
                 WHERE car_id = ? 
                 AND status NOT IN ('rejected', 'completed')
                 AND (
                     (booking_date = ? AND start_time < ? AND end_time > ?) OR
                     (booking_date = ? AND start_time < ? AND end_time > ?) OR
                     (booking_date = ? AND start_time >= ? AND start_time < ?)
                 )";
    $checkParams = [
        $car_id,
        $booking_date, $end_time, $start_time,
        $booking_date, $end_time, $start_time,
        $booking_date, $start_time, $end_time
    ];
    $checkStmt = $db->query($checkSql, $checkParams);
    $conflictCount = $checkStmt->fetch()['count'];

    if ($conflictCount > 0) {
        echo json_encode(['success' => false, 'message' => 'รถยนต์ไม่ว่างในช่วงเวลาที่เลือก']);
        exit;
    }

    // เพิ่มข้อมูลการจอง
    $sql = "INSERT INTO car_bookings 
            (teacher_id, car_id, booking_date, start_time, end_time, 
             destination, purpose, passenger_count, student_count,
             passengers_detail, teacher_name, teacher_position, 
             teacher_phone, notes, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())";

    $params = [
        $teacher_id, $car_id, $booking_date, $start_time, $end_time,
        $destination, $purpose, $passenger_count, $student_count,
        $passengers_detail, $teacher_name, $teacher_position,
        $teacher_phone, $notes
    ];

    $stmt = $db->query($sql, $params);

    if ($stmt && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'บันทึกการจองเรียบร้อยแล้ว']);
    } else {
        // เพิ่ม error log
        $errorInfo = $stmt ? $stmt->errorInfo() : [];
        echo json_encode([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
            'error' => $errorInfo
        ]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
