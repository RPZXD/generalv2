<?php
/**
 * Daily Booking Notification Cron Script
 * 
 * Schedule:
 * - 05:00 Round: Summarize bookings for Today (?round=morning)
 * - 18:00 Round: Summarize bookings for Tomorrow (?round=evening)
 * 
 * Supports both CLI and Web execution.
 */

// Set timezone
date_default_timezone_set('Asia/Bangkok');

// Load database files
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../classes/DatabaseUsers.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

// Helper function to format Thai date
function thaiDate($date) {
    if (!$date) return '-';
    $months = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
        5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
        9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];
    $dt = new DateTime($date);
    $day = $dt->format('j');
    $month = $months[(int)$dt->format('n')];
    $year = $dt->format('Y') + 543;
    return "{$day} {$month} {$year}";
}

// Check execution mode (CLI vs Web)
$isCli = (php_sapi_name() === 'cli');
$round = '';

if ($isCli) {
    // Get from CLI argument
    $round = $argv[1] ?? '';
} else {
    // Get from GET parameter
    $round = $_GET['round'] ?? $_GET['action'] ?? '';
}

// Auto-detect round based on current time if not specified
if (empty($round) || !in_array($round, ['morning', 'evening'])) {
    $hour = (int)date('H');
    if ($hour < 12) {
        $round = 'morning';
    } else {
        $round = 'evening';
    }
}

// Calculate target date based on round
if ($round === 'morning') {
    $targetDate = date('Y-m-d');
    $dayLabel = "วันนี้ (" . thaiDate($targetDate) . ")";
} else {
    $targetDate = date('Y-m-d', strtotime('+1 day'));
    $dayLabel = "วันพรุ่งนี้ (" . thaiDate($targetDate) . ")";
}

$results = [
    'success' => true,
    'round' => $round,
    'target_date' => $targetDate,
    'room_notifications' => [],
    'car_notifications' => []
];

try {
    // Initialize DB connections
    $dbGeneral = new DatabaseGeneral();
    $pdoGeneral = $dbGeneral->getPDO();

    $dbUsers = new DatabaseUsers();
    $pdoUsers = $dbUsers->getTeacherByUsername('test'); // test connection

    // --- SECTION 1: ROOM BOOKINGS ---
    // Fetch active room bookings for target date (status != 2, 2 is typically rejected/cancelled)
    $roomSql = "SELECT b.*, mr.room_name 
                FROM bookings b 
                LEFT JOIN meeting_rooms mr ON b.room_id = mr.id 
                WHERE b.date = :target_date AND b.status != 2
                ORDER BY b.time_start ASC";
    $stmt = $pdoGeneral->prepare($roomSql);
    $stmt->execute(['target_date' => $targetDate]);
    $roomBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($roomBookings)) {
        // Build Room Summary Message
        $roomMessage = "-----------------------------\n"
                     . "📢 สรุปรายการจองห้องประชุม\n"
                     . "สำหรับ{$dayLabel}\n"
                     . "-----------------------------\n";

        foreach ($roomBookings as $index => $booking) {
            // Find teacher name
            $teacherName = $booking['teach_id'];
            $teacher = $dbUsers->getTeacherByUsername($booking['teach_id']);
            if ($teacher) {
                $teacherName = $teacher['Teach_name'];
            }
            
            $statusText = $booking['status'] == 1 ? '✅ อนุมัติแล้ว' : '⏳ รออนุมัติ';
            
            $roomMessage .= ($index + 1) . ". 🏢 " . ($booking['room_name'] ?? $booking['location']) . "\n"
                          . "   ⏰ เวลา: " . substr($booking['time_start'], 0, 5) . " - " . substr($booking['time_end'], 0, 5) . " น.\n"
                          . "   👤 ผู้จอง: {$teacherName}\n"
                          . "   🎯 วัตถุประสงค์: {$booking['purpose']}\n"
                          . "   สถานะ: {$statusText}\n"
                          . "-----------------------------\n";
        }

        // Room hardcoded credentials from insert_booking.php
        $channelAccessToken = "3K7fh1bhbCn0uPjgNoGQpN3jNgpwpSoMA0QaE6m4dOMJkly+SeGyDyS73+EV6wSVuLoB6M/+FwdbxRWlY6ZGuQymNTYSrFzA5xQ7AhwlwOufu+et60PnAnYK2vpyvUyy3ye0yBe7cTu+PoiFDxsmmgdB04t89/1O/w1cDnyilFU=";
        $groupId = "Cafbcad04d9e78bbee85b2447ee768baf";
        $discordWebhook = "https://discord.com/api/webhooks/1324990236822241300/lZk9s-t-l324_uD6s-kK4v-lZk9s-t-l324_uD6s-kK4v";

        // Send LINE Bot Notification for Rooms
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
                    "text" => $roomMessage
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
        $lineCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $results['room_notifications']['line'] = [
            'sent' => true,
            'http_code' => $lineCode,
            'response' => json_decode($lineRes, true) ?: $lineRes
        ];

        // Send Discord Notification for Rooms
        $discordBody = [
            "content" => $roomMessage,
            "username" => "ระบบจองห้องประชุม",
            "avatar_url" => "https://cdn-icons-png.flaticon.com/512/2111/2111615.png"
        ];
        $ch = curl_init($discordWebhook);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($discordBody, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => ["Content-Type: application/json; charset=UTF-8"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $discordRes = curl_exec($ch);
        $discordCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $results['room_notifications']['discord'] = [
            'sent' => true,
            'http_code' => $discordCode
        ];
    } else {
        $results['room_notifications']['status'] = "No bookings found for target date";
    }

    // --- SECTION 2: CAR BOOKINGS ---
    // Fetch active car bookings for target date (status != 'rejected')
    $carSql = "SELECT cb.*, c.car_model, c.license_plate 
               FROM car_bookings cb 
               LEFT JOIN cars c ON cb.car_id = c.id 
               WHERE cb.booking_date = :target_date AND cb.status != 'rejected'
               ORDER BY cb.start_time ASC";
    $stmt = $pdoGeneral->prepare($carSql);
    $stmt->execute(['target_date' => $targetDate]);
    $carBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($carBookings)) {
        // Build Car Summary Message
        $carMessage = "-----------------------------\n"
                    . "📢 สรุปรายการจองรถยนต์ราชการ\n"
                    . "สำหรับ{$dayLabel}\n"
                    . "-----------------------------\n";

        foreach ($carBookings as $index => $booking) {
            $carDesc = $booking['car_model'] 
                ? "{$booking['car_model']} ({$booking['license_plate']})" 
                : $booking['car_id'];
                
            $statusText = $booking['status'] === 'approved' ? '✅ อนุมัติแล้ว' : ($booking['status'] === 'pending' ? '⏳ รออนุมัติ' : $booking['status']);
            
            $carMessage .= ($index + 1) . ". 🚐 " . $carDesc . "\n"
                         . "   ⏰ เวลา: " . date('H:i', strtotime($booking['start_time'])) . " - " . date('H:i', strtotime($booking['end_time'])) . " น.\n"
                         . "   👤 ผู้จอง: {$booking['teacher_name']} ({$booking['teacher_position']})\n"
                         . "   📍 ปลายทาง: {$booking['destination']}\n"
                         . "   🎯 วัตถุประสงค์: {$booking['purpose']}\n"
                         . "   สถานะ: {$statusText}\n"
                         . "-----------------------------\n";
        }

        // Load credentials from config.json
        $config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);

        // Discord Notification
        $webhookUrl = $config['notifications']['car_discord_webhook'] ?? '';
        $isEnabled = $config['notifications']['car_discord_enabled'] ?? false;

        if ($isEnabled && !empty($webhookUrl)) {
            $discordBody = [
                "content" => $carMessage,
                "username" => "ระบบจองรถยนต์ราชการ",
                "avatar_url" => "https://cdn-icons-png.flaticon.com/512/2111/2111615.png"
            ];
            $ch = curl_init($webhookUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($discordBody, JSON_UNESCAPED_UNICODE),
                CURLOPT_HTTPHEADER => ["Content-Type: application/json; charset=UTF-8"],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            curl_exec($ch);
            $discordCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $results['car_notifications']['discord'] = [
                'sent' => true,
                'http_code' => $discordCode
            ];
        }

        // LINE Notify Notification
        $lineToken = $config['notifications']['line_token'] ?? '';
        $isLineEnabled = $config['notifications']['line_enabled'] ?? false;

        if ($isLineEnabled && !empty($lineToken)) {
            $ch = curl_init('https://notify-api.line.me/api/notify');
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(['message' => "\n" . $carMessage]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $lineToken
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            $lineRes = curl_exec($ch);
            $lineCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $results['car_notifications']['line'] = [
                'sent' => true,
                'http_code' => $lineCode,
                'response' => json_decode($lineRes, true) ?: $lineRes
            ];
        }

        // Telegram Notification
        $tgToken = $config['notifications']['telegram_bot_token'] ?? '';
        $tgChatId = $config['notifications']['telegram_chat_id'] ?? '';
        $isTgEnabled = $config['notifications']['telegram_enabled'] ?? false;

        if ($isTgEnabled && !empty($tgToken) && !empty($tgChatId)) {
            $tgUrl = "https://api.telegram.org/bot{$tgToken}/sendMessage";
            $ch = curl_init($tgUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    'chat_id' => $tgChatId,
                    'text' => $carMessage
                ]),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false
            ]);
            $tgRes = curl_exec($ch);
            $tgCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $results['car_notifications']['telegram'] = [
                'sent' => true,
                'http_code' => $tgCode,
                'response' => json_decode($tgRes, true) ?: $tgRes
            ];
        }
    } else {
        $results['car_notifications']['status'] = "No bookings found for target date";
    }

} catch (Exception $e) {
    $results['success'] = false;
    $results['error'] = $e->getMessage();
}

// Output JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
