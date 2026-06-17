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
    
    // 1. Save database settings
    $dbKeys = [
        'notify_morning_enabled',
        'notify_morning_time',
        'notify_morning_advance_days',
        'notify_evening_enabled',
        'notify_evening_time',
        'notify_evening_advance_days',
        'room_group_id',
        'car_group_id',
        'driver_group_id'
    ];
    
    foreach ($dbKeys as $key) {
        if (isset($_POST[$key])) {
            $sysSettings->set($key, $_POST[$key]);
        }
    }

    // 2. Save config.json settings
    $configPath = __DIR__ . '/../../config.json';
    if (file_exists($configPath)) {
        $config = json_decode(file_get_contents($configPath), true);
        if ($config) {
            if (!isset($config['notifications'])) {
                $config['notifications'] = [];
            }
            
            if (isset($_POST['room_line_enabled'])) {
                $config['notifications']['room_line_enabled'] = $_POST['room_line_enabled'] === '1' ? true : false;
            }
            if (isset($_POST['line_enabled'])) {
                $config['notifications']['line_enabled'] = $_POST['line_enabled'] === '1' ? true : false;
            }
            if (isset($_POST['driver_line_enabled'])) {
                $config['notifications']['driver_line_enabled'] = $_POST['driver_line_enabled'] === '1' ? true : false;
            }
            
            file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
    
    echo json_encode(['success' => true, 'message' => 'บันทึกการตั้งค่าการแจ้งเตือนเรียบร้อยแล้ว']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
