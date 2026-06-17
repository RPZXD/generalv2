<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    $db = new App\DatabaseGeneral();
    
    // Calculate tomorrow's date
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    
    // Query approved bookings for tomorrow
    $sql = "SELECT b.*, c.car_model, c.license_plate, c.car_type 
            FROM car_bookings b
            LEFT JOIN cars c ON b.car_id = c.id
            WHERE b.booking_date = ? 
            AND b.status = 'approved'
            ORDER BY b.start_time ASC";
    
    $stmt = $db->query($sql, [$tomorrow]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($bookings) === 0) {
        echo json_encode(['success' => false, 'message' => 'ไม่มีรายการจองรถในวันพรุ่งนี้ (' . $tomorrow . ')']);
        exit;
    }

    // Load notification config from DB & config.json
    require_once '../../classes/SystemSettings.php';
    $sysSettings = new App\SystemSettings();
    $dbSettings = $sysSettings->getAll();

    $config = json_decode(file_get_contents('../../config.json'), true);
    $notif = $config['notifications'] ?? [];

    // Format Message
    $msg = " สรุปตารางงานใช้รถวันพรุ่งนี้\n";
    $msg .= "ประจำวันที่: " . date('d/m/Y', strtotime($tomorrow)) . "\n";
    $msg .= "-----------------------------\n";

    foreach ($bookings as $idx => $b) {
        $startTime = date('H:i', strtotime($b['start_time']));
        $endTime = date('H:i', strtotime($b['end_time']));
        $car = $b['car_model'] . " (" . $b['license_plate'] . ")";
        
        $msg .= ($idx + 1) . ". เวลา: " . $startTime . " - " . $endTime . " น.\n";
        $msg .= " ผู้จอง: " . $b['teacher_name'] . "\n";
        $msg .= " ปลายทาง: " . $b['destination'] . "\n";
        $msg .= " รถ: " . $car . "\n";
        $msg .= "-----------------------------\n";
    }

    $results = [];

    // 1. Send to Discord Driver Group
    $driverDiscordWebhook = $dbSettings['driver_discord_webhook'] ?? '';
    if (($notif['driver_discord_enabled'] ?? false) && !empty($driverDiscordWebhook)) {
        $ch = curl_init($driverDiscordWebhook);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['content' => $msg]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $results['discord'] = true;
    }

    // 2. Send to Line Bot Driver Group
    $channelAccessToken = $dbSettings['room_line_token'] ?? '';
    $driverGroupId = $dbSettings['driver_group_id'] ?? '';
    if (($notif['driver_line_enabled'] ?? false) && !empty($channelAccessToken) && !empty($driverGroupId)) {
        $lineUrl = "https://api.line.me/v2/bot/message/push";
        $lineHeaders = [
            "Content-Type: application/json; charset=UTF-8",
            "Authorization: Bearer {$channelAccessToken}",
            "User-Agent: PHP LINE Bot"
        ];
        $lineBody = [
            "to" => $driverGroupId,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $msg
                ]
            ]
        ];

        $ch = curl_init($lineUrl);
        curl_setopt($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($lineBody, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => $lineHeaders,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        $results['line'] = true;
    }

    // 3. Send to Telegram Driver Group
    $tgToken = $dbSettings['telegram_bot_token'] ?? '';
    $tgChatId = $dbSettings['telegram_driver_chat_id'] ?? '';
    $isTgEnabled = $notif['telegram_driver_enabled'] ?? false;

    if ($isTgEnabled && !empty($tgToken) && !empty($tgChatId)) {
        $tgUrl = "https://api.telegram.org/bot{$tgToken}/sendMessage";
        $ch = curl_init($tgUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $tgChatId,
            'text' => $msg
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $results['telegram'] = true;
    }

    if (empty($results)) {
        echo json_encode(['success' => false, 'message' => 'ไม่ได้เปิดใช้งานช่องทางการแจ้งเตือนสำหรับกลุ่มคนขับรถ']);
    } else {
        echo json_encode(['success' => true, 'message' => 'ส่งสรุปตารางงานวันพรุ่งนี้เรียบร้อยแล้ว', 'channels' => array_keys($results)]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
