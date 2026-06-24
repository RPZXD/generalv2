<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. Session verification
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์ในการเข้าถึง']);
    exit;
}

try {
    // 2. Load system settings
    require_once __DIR__ . '/../../classes/SystemSettings.php';
    $sysSettings = new App\SystemSettings();
    $dbSettings = $sysSettings->getAll();

    $channelAccessToken = $dbSettings['room_line_token'] ?? '';

    if (empty($channelAccessToken)) {
        echo json_encode([
            'success' => false,
            'message' => 'ไม่ได้ตั้งค่า LINE Channel Access Token ในระบบส่วนกลาง (กรุณาแจ้งผู้ดูแลระบบเพื่อทำการตั้งค่า)'
        ]);
        exit;
    }

    // 3. Retrieve inputs
    $target = $_POST['target'] ?? '';
    $groupId = $_POST['group_id'] ?? '';

    if (empty($target) || !in_array($target, ['room', 'car', 'driver'])) {
        echo json_encode(['success' => false, 'message' => 'ประเภทกลุ่มเป้าหมายไม่ถูกต้อง']);
        exit;
    }

    if (empty($groupId)) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอก Group ID สำหรับการแจ้งเตือน']);
        exit;
    }

    // Translate group target
    $targetName = '';
    switch ($target) {
        case 'room':
            $targetName = '🏢 ห้องประชุม (Room Booking)';
            break;
        case 'car':
            $targetName = '🚗 จองรถยนต์ (Car Booking)';
            break;
        case 'driver':
            $targetName = '🚐 กลุ่มคนขับรถ (Driver Group)';
            break;
    }

    // Sender fullname
    $username = $_SESSION['username'] ?? 'ผู้ใช้';
    $fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
    
    // 4. Format test message
    $msg = "🔔 [ทดสอบระบบแจ้งเตือน LINE Bot]\n"
         . "-----------------------------\n"
         . "กลุ่มเป้าหมาย: {$targetName}\n"
         . "สถานะการส่ง: เชื่อมต่อและส่งข้อความสำเร็จ\n"
         . "ผู้ดำเนินการ: {$fullname}\n"
         . "เวลาดำเนินการ: " . date('d/m/Y H:i:s') . " น.\n"
         . "-----------------------------";

    // 5. Send LINE Bot Push Notification
    $lineUrl = "https://api.line.me/v2/bot/message/push";
    $lineHeaders = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: Bearer {$channelAccessToken}",
        "User-Agent: PHP LINE Bot"
    ];
    $lineBody = [
        "to" => $groupId,
        "messages" => [
            [
                "type" => "text",
                "text" => $msg
            ]
        ]
    ];

    $ch = curl_init($lineUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($lineBody, JSON_UNESCAPED_UNICODE),
        CURLOPT_HTTPHEADER => $lineHeaders,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $lineRes = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);

    if ($curlErr) {
        echo json_encode([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อ (cURL Error): ' . $curlErr
        ]);
        exit;
    }

    $responseDecoded = json_decode($lineRes, true);

    if ($httpCode === 200) {
        echo json_encode([
            'success' => true,
            'message' => 'ส่งการแจ้งเตือนทดสอบไปยังกลุ่ม LINE สำเร็จ',
            'http_code' => $httpCode,
            'response' => $responseDecoded
        ]);
    } else {
        $errorMessage = $responseDecoded['message'] ?? 'ตรวจสอบ Group ID หรือ Token ว่าถูกต้องหรือไม่';
        echo json_encode([
            'success' => false,
            'message' => "ส่งไม่สำเร็จ (HTTP Code: {$httpCode}) - {$errorMessage}",
            'http_code' => $httpCode,
            'response' => $responseDecoded ?: $lineRes
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
exit;
