<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ถูกต้อง']);
        exit;
    }

    // Save database settings if present
    if (isset($data['db_settings']) && is_array($data['db_settings'])) {
        require_once __DIR__ . '/../../classes/SystemSettings.php';
        $sysSettings = new App\SystemSettings();
        foreach ($data['db_settings'] as $key => $value) {
            $sysSettings->set($key, $value);
        }
        // Remove from config data to prevent saving to config.json
        unset($data['db_settings']);
    }

    // Sanitize/clear sensitive tokens from config.json so they are not tracked in git
    if (isset($data['notifications']) && is_array($data['notifications'])) {
        $data['notifications']['car_discord_webhook'] = '';
        $data['notifications']['repair_discord_webhook'] = '';
        $data['notifications']['driver_discord_webhook'] = '';
        $data['notifications']['line_token'] = '';
        $data['notifications']['driver_line_token'] = '';
        $data['notifications']['telegram_bot_token'] = '';
        $data['notifications']['telegram_chat_id'] = '';
        $data['notifications']['telegram_repair_chat_id'] = '';
        $data['notifications']['telegram_driver_chat_id'] = '';
    }

    $configPath = '../../config.json';
    
    // Read current config to preserve any keys not sent in the form
    $currentConfig = json_decode(file_get_contents($configPath), true);
    
    // Update config with new data
    $newConfig = array_merge($currentConfig, $data);
    
    // Write back to file
    if (file_put_contents($configPath, json_encode($newConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        echo json_encode(['success' => true, 'message' => 'บันทึกการตั้งค่าเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถบันทึกไฟล์ได้']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
