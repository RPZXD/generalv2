<?php
session_start();
header('Content-Type: application/json');

// ตรวจสอบสิทธิ์
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์ในการเข้าถึง']);
    exit;
}

try {
    // อ่าน config ปัจจุบัน
    $configPath = '../../config.json';
    $config = json_decode(file_get_contents($configPath), true);
    
    if (!$config) {
        throw new Exception('ไม่สามารถอ่านไฟล์ config ได้');
    }
    
    $section = $_POST['section'] ?? 'global';
    
    switch ($section) {
        case 'global':
            // อัปเดตการตั้งค่าทั่วไป
            $config['global']['nameschool'] = $_POST['nameschool'] ?? $config['global']['nameschool'];
            $config['global']['address'] = $_POST['address'] ?? '';
            $config['global']['phone'] = $_POST['phone'] ?? '';
            $config['global']['email'] = $_POST['email'] ?? '';
            break;
            
        case 'repair':
            // อัปเดตการตั้งค่าระบบแจ้งซ่อม
            if (!isset($config['repair'])) {
                $config['repair'] = [];
            }
            $config['repair']['default_days'] = (int)($_POST['repair_days'] ?? 7);
            $config['repair']['email_notification'] = (bool)($_POST['email_notification'] ?? true);
            break;
            
        case 'meeting':
            // อัปเดตการตั้งค่าระบบจองห้องประชุม
            if (!isset($config['meeting'])) {
                $config['meeting'] = [];
            }
            $config['meeting']['start_time'] = $_POST['booking_start_time'] ?? '08:00';
            $config['meeting']['end_time'] = $_POST['booking_end_time'] ?? '17:00';
            $config['meeting']['advance_days'] = (int)($_POST['advance_booking_days'] ?? 14);
            $config['meeting']['min_hours'] = (int)($_POST['min_booking_hours'] ?? 1);
            break;
            
        case 'car':
            // อัปเดตการตั้งค่าระบบจองรถ
            if (!isset($config['car'])) {
                $config['car'] = [];
            }
            $config['car']['advance_days'] = (int)($_POST['car_advance_days'] ?? 7);
            $config['car']['require_approval'] = (bool)($_POST['require_approval'] ?? true);
            break;
            
        default:
            throw new Exception('ไม่พบส่วนการตั้งค่าที่ระบุ');
    }
    
    // บันทึกไฟล์ config
    $result = file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
    if ($result === false) {
        throw new Exception('ไม่สามารถบันทึกไฟล์ config ได้');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'บันทึกการตั้งค่าเรียบร้อยแล้ว'
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
