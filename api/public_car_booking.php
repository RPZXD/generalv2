<?php
/**
 * Public Car Booking API
 * ดึงข้อมูลการจองรถสาธารณะ - ไม่ต้อง login
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../classes/DatabaseUsers.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

/**
 * Mask ชื่อสำหรับความเป็นส่วนตัว
 */
function maskName($fullName) {
    if (empty($fullName)) return null;
    
    $fullName = trim($fullName);
    $prefixes = ['นางสาว', 'ว่าที่ร้อยตรี', 'นาง', 'นาย', 'ดร.', 'Mr.', 'Mrs.', 'Miss'];
    $foundPrefix = '';
    $nameWithoutPrefix = $fullName;
    
    foreach ($prefixes as $p) {
        if (mb_strpos($fullName, $p, 0, 'UTF-8') === 0) {
            $foundPrefix = $p;
            $nameWithoutPrefix = trim(mb_substr($fullName, mb_strlen($p, 'UTF-8'), null, 'UTF-8'));
            break;
        }
    }
    
    $nameParts = preg_split('/\s+/', $nameWithoutPrefix);
    if (!empty($nameParts[0])) {
        $firstName = mb_substr($nameParts[0], 0, 2, 'UTF-8');
        return $foundPrefix . ' ' . $firstName . 'xxx';
    } else {
        return mb_substr($fullName, 0, 4, 'UTF-8') . 'xxx';
    }
}

try {
    $db = DatabaseGeneral::getInstance();
    $userDb = new DatabaseUsers();
    
    // รับ parameter
    $month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
    $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : null;
    
    // ดึงรายการรถ
    $cars = $db->query("SELECT * FROM cars WHERE status = 1 ORDER BY car_model")->fetchAll();
    
    // กำหนด emoji ตามประเภทรถ
    $carEmojis = [
        'รถเก๋ง' => '🚗',
        'รถตู้' => '🚐',
        'รถกระบะ' => '🛻',
        'รถบัส' => '🚌'
    ];
    
    foreach ($cars as &$car) {
        $car['emoji'] = $carEmojis[$car['car_type']] ?? '🚗';
    }
    unset($car);
    
    // สร้าง query สำหรับดึงการจอง
    $sql = "SELECT cb.*, c.car_model, c.license_plate, c.car_type, c.capacity 
            FROM car_bookings cb 
            LEFT JOIN cars c ON cb.car_id = c.id 
            WHERE MONTH(cb.booking_date) = ? AND YEAR(cb.booking_date) = ?";
    $params = [$month, $year];
    
    if ($car_id) {
        $sql .= " AND cb.car_id = ?";
        $params[] = $car_id;
    }
    
    $sql .= " ORDER BY cb.booking_date ASC, cb.start_time ASC";
    
    $bookings = $db->query($sql, $params)->fetchAll();
    
    // เพิ่มชื่อครูผู้จอง (mask สำหรับความเป็นส่วนตัว)
    foreach ($bookings as &$booking) {
        $booking['teacher_name_masked'] = null;
        $booking['emoji'] = $carEmojis[$booking['car_type']] ?? '🚗';
        
        if (!empty($booking['teacher_id'])) {
            $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$booking['teacher_id']])->fetch();
            if ($teacher && !empty($teacher['Teach_name'])) {
                $booking['teacher_name_masked'] = maskName($teacher['Teach_name']);
            }
        }
        
        // ลบข้อมูลส่วนตัวที่ไม่ควรแสดงสาธารณะ
        unset($booking['teacher_id']);
        unset($booking['phone']);
        unset($booking['contact_phone']);
        unset($booking['teacher_phone']);
        unset($booking['teacher_name']);
        unset($booking['passengers_detail']);
        unset($booking['teacher_position']);
        
        // แปลง status เป็นข้อความ
        $statusMap = [
            'pending' => ['text' => 'รออนุมัติ', 'color' => 'amber', 'value' => 0],
            'approved' => ['text' => 'อนุมัติแล้ว', 'color' => 'green', 'value' => 1],
            'rejected' => ['text' => 'ไม่อนุมัติ', 'color' => 'red', 'value' => 2],
        ];
        $statusInfo = $statusMap[$booking['status']] ?? ['text' => 'ไม่ทราบสถานะ', 'color' => 'gray', 'value' => -1];
        $booking['status_text'] = $statusInfo['text'];
        $booking['status_color'] = $statusInfo['color'];
        $booking['status_value'] = $statusInfo['value'];
    }
    unset($booking);
    
    // สถิติ
    $stats = [
        'total' => count($bookings),
        'approved' => count(array_filter($bookings, fn($b) => $b['status'] === 'approved')),
        'pending' => count(array_filter($bookings, fn($b) => $b['status'] === 'pending')),
        'rejected' => count(array_filter($bookings, fn($b) => $b['status'] === 'rejected')),
    ];
    
    echo json_encode([
        'success' => true,
        'cars' => $cars,
        'bookings' => $bookings,
        'stats' => $stats,
        'month' => $month,
        'year' => $year
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
