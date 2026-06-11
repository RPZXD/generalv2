<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์ในการเข้าถึง']);
    exit;
}

try {
    require_once __DIR__ . '/../../classes/SystemSettings.php';
    $sysSettings = new App\SystemSettings();
    
    $keys = [
        'notify_morning_enabled',
        'notify_morning_time',
        'notify_morning_advance_days',
        'notify_evening_enabled',
        'notify_evening_time',
        'notify_evening_advance_days'
    ];
    
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $sysSettings->set($key, $_POST[$key]);
        }
    }
    
    echo json_encode(['success' => true, 'message' => 'บันทึกการตั้งค่าการแจ้งเตือนเรียบร้อยแล้ว']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
