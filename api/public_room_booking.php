<?php
/**
 * Public Room Booking API
 * ดึงข้อมูลการจองห้องประชุมสาธารณะ - ไม่ต้อง login
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../classes/DatabaseUsers.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

try {
    $db = DatabaseGeneral::getInstance();
    $userDb = new DatabaseUsers();
    
    // รับ parameter
    $month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
    $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : null;
    
    // ดึงรายการห้องประชุม
    $rooms = $db->query("SELECT * FROM meeting_rooms WHERE status = 1 ORDER BY room_name")->fetchAll();
    
    // สร้าง query สำหรับดึงการจอง
    $sql = "SELECT b.*, m.room_name, m.capacity, m.color, m.emoji, m.building 
            FROM bookings b 
            LEFT JOIN meeting_rooms m ON b.room_id = m.id 
            WHERE MONTH(b.date) = ? AND YEAR(b.date) = ?";
    $params = [$month, $year];
    
    if ($room_id) {
        $sql .= " AND b.room_id = ?";
        $params[] = $room_id;
    }
    
    $sql .= " ORDER BY b.date ASC, b.time_start ASC";
    
    $bookings = $db->query($sql, $params)->fetchAll();
    
    // เพิ่มชื่อครูผู้จอง (mask สำหรับความเป็นส่วนตัว)
    foreach ($bookings as &$booking) {
        $booking['teacher_name'] = null;
        $booking['teacher_name_masked'] = null;
        if (!empty($booking['teach_id'])) {
            $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$booking['teach_id']])->fetch();
            if ($teacher && !empty($teacher['Teach_name'])) {
                $fullName = trim($teacher['Teach_name']);
                // Mask ชื่อ: แสดงคำนำหน้า + 2 ตัวแรกของชื่อ + xxx
                // รูปแบบ: "นายสมชาย ใจดี" หรือ "นาย สมชาย ใจดี"
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
                
                // แยกชื่อ-นามสกุล จาก nameWithoutPrefix (อาจมี space หรือไม่มี)
                $nameParts = preg_split('/\s+/', $nameWithoutPrefix);
                if (!empty($nameParts[0])) {
                    $firstName = mb_substr($nameParts[0], 0, 2, 'UTF-8'); // 2 ตัวแรกของชื่อจริง
                    $booking['teacher_name_masked'] = $foundPrefix . ' ' . $firstName . 'xxx';
                } else {
                    $booking['teacher_name_masked'] = mb_substr($fullName, 0, 4, 'UTF-8') . 'xxx';
                }
            }
        }
        // ลบข้อมูลส่วนตัวที่ไม่ควรแสดงสาธารณะ
        unset($booking['phone']);
        unset($booking['teach_id']);
        
        // แปลง status เป็นข้อความ
        $booking['status_text'] = match((int)$booking['status']) {
            0 => 'รออนุมัติ',
            1 => 'อนุมัติแล้ว',
            2 => 'ไม่อนุมัติ',
            default => 'ไม่ทราบสถานะ'
        };
        $booking['status_color'] = match((int)$booking['status']) {
            0 => 'amber',
            1 => 'green',
            2 => 'red',
            default => 'gray'
        };
    }
    unset($booking);
    
    // สถิติ
    $stats = [
        'total' => count($bookings),
        'approved' => count(array_filter($bookings, fn($b) => (int)$b['status'] === 1)),
        'pending' => count(array_filter($bookings, fn($b) => (int)$b['status'] === 0)),
        'rejected' => count(array_filter($bookings, fn($b) => (int)$b['status'] === 2)),
    ];
    
    echo json_encode([
        'success' => true,
        'rooms' => $rooms,
        'bookings' => $bookings,
        'stats' => $stats,
        'month' => $month,
        'year' => $year
    ]);
} catch (\Throwable $e) {
    error_log("Error in api/public_room_booking.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'rooms' => [],
        'bookings' => [],
        'stats' => ['total' => 0, 'approved' => 0, 'pending' => 0, 'rejected' => 0]
    ]);
}
