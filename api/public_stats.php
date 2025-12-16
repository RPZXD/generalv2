<?php
/**
 * Public Stats API
 * ดึงสถิติสาธารณะ - ไม่ต้อง login
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../classes/DatabaseGeneral.php';

use App\DatabaseGeneral;

try {
    $db = DatabaseGeneral::getInstance();
    
    // นับจำนวนแจ้งซ่อม
    $repairCount = $db->query("SELECT COUNT(*) as total FROM report_repair")->fetch()['total'];
    
    // นับจำนวนจองห้อง
    $roomCount = $db->query("SELECT COUNT(*) as total FROM bookings")->fetch()['total'];
    
    // นับจำนวนจองรถ
    $carCount = $db->query("SELECT COUNT(*) as total FROM car_bookings")->fetch()['total'];
    
    // นับจำนวนข่าว
    $newsCount = $db->query("SELECT COUNT(*) as total FROM newsletters")->fetch()['total'];
    
    // ยอดอ่านข่าวทั้งหมด
    $totalViews = $db->query("SELECT COALESCE(SUM(view_count), 0) as total FROM newsletters")->fetch()['total'];
    
    echo json_encode([
        'success' => true,
        'stats' => [
            'repair' => (int)$repairCount,
            'room' => (int)$roomCount,
            'car' => (int)$carCount,
            'news' => (int)$newsCount,
            'total_views' => (int)$totalViews
        ]
    ]);
} catch (\Throwable $e) {
    error_log("Error in api/public_stats.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'stats' => [
            'repair' => 0,
            'room' => 0,
            'car' => 0,
            'news' => 0,
            'total_views' => 0
        ]
    ]);
}
