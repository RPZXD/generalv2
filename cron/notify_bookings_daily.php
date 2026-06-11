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
require_once __DIR__ . '/../classes/SystemSettings.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;
use App\SystemSettings;

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

try {
    // Initialize DB connections
    $dbGeneral = new DatabaseGeneral();
    $pdoGeneral = $dbGeneral->getPDO();

    $dbUsers = new DatabaseUsers();
    $pdoUsers = $dbUsers->getTeacherByUsername('test'); // test connection

    // Initialize SystemSettings
    $sysSettings = new SystemSettings();
    $dbSettings = $sysSettings->getAll();

    // Load configuration values from DB settings
    $morningEnabled = ($dbSettings['notify_morning_enabled'] ?? '1') === '1';
    $morningTime = $dbSettings['notify_morning_time'] ?? '05:00';
    $morningAdvance = (int)($dbSettings['notify_morning_advance_days'] ?? 0);

    $eveningEnabled = ($dbSettings['notify_evening_enabled'] ?? '1') === '1';
    $eveningTime = $dbSettings['notify_evening_time'] ?? '18:00';
    $eveningAdvance = (int)($dbSettings['notify_evening_advance_days'] ?? 1);

    // Auto-detect round based on current time and settings if not specified
    if (empty($round) || !in_array($round, ['morning', 'evening'])) {
        $currentHour = (int)date('H');
        $morningHour = (int)explode(':', $morningTime)[0];
        $eveningHour = (int)explode(':', $eveningTime)[0];

        if ($currentHour === $morningHour && $morningEnabled) {
            $round = 'morning';
        } elseif ($currentHour === $eveningHour && $eveningEnabled) {
            $round = 'evening';
        } else {
            // If it is run manually (e.g. from browser or CLI with no matches)
            // Fallback to simple AM/PM logic
            if (!$isCli) {
                if ($currentHour < 12) {
                    $round = 'morning';
                } else {
                    $round = 'evening';
                }
            } else {
                echo "No scheduled notification for current hour ($currentHour). Configured: Morning={$morningTime} (Enabled: " . ($morningEnabled ? 'Yes' : 'No') . "), Evening={$eveningTime} (Enabled: " . ($eveningEnabled ? 'Yes' : 'No') . ")\n";
                exit;
            }
        }
    }

    // Check if the chosen round is disabled
    if ($round === 'morning' && !$morningEnabled) {
        $results = ['success' => false, 'message' => 'Morning notification is disabled'];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    if ($round === 'evening' && !$eveningEnabled) {
        $results = ['success' => false, 'message' => 'Evening notification is disabled'];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // Determine target start and end dates based on advance days setting
    if ($round === 'morning') {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+$morningAdvance day"));
        
        if ($morningAdvance === 0) {
            $dayLabel = "วันนี้ (" . thaiDate($startDate) . ")";
        } elseif ($morningAdvance === 1) {
            $dayLabel = "วันนี้ - วันพรุ่งนี้ (" . thaiDate($startDate) . " - " . thaiDate($endDate) . ")";
        } else {
            $dayLabel = "วันนี้ - {$morningAdvance} วันล่วงหน้า (" . thaiDate($startDate) . " - " . thaiDate($endDate) . ")";
        }
    } else {
        $startDate = date('Y-m-d', strtotime('+1 day'));
        $endDate = date('Y-m-d', strtotime("+$eveningAdvance day"));
        
        if ($eveningAdvance <= 1) {
            $dayLabel = "วันพรุ่งนี้ (" . thaiDate($startDate) . ")";
        } else {
            $dayLabel = "วันพรุ่งนี้ - {$eveningAdvance} วันล่วงหน้า (" . thaiDate($startDate) . " - " . thaiDate($endDate) . ")";
        }
    }

    $results = [
        'success' => true,
        'round' => $round,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'room_notifications' => [],
        'car_notifications' => []
    ];

    // Load config.json
    $config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);

    // --- SECTION 1: ROOM BOOKINGS ---
    // Fetch active room bookings for target date range (status != 2, 2 is typically rejected/cancelled)
    $roomSql = "SELECT b.*, mr.room_name 
                FROM bookings b 
                LEFT JOIN meeting_rooms mr ON b.room_id = mr.id 
                WHERE b.date >= :start_date AND b.date <= :end_date AND b.status != 2
                ORDER BY b.date ASC, b.time_start ASC";
    $stmt = $pdoGeneral->prepare($roomSql);
    $stmt->execute(['start_date' => $startDate, 'end_date' => $endDate]);
    $roomBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($roomBookings)) {
        // Build Room Summary Message
        $roomMessage = "-----------------------------\n"
                     . "📢 สรุปรายการจองห้องประชุม\n"
                     . "สำหรับ{$dayLabel}\n"
                     . "-----------------------------\n";

        // Group by date
        $groupedRoomBookings = [];
        foreach ($roomBookings as $booking) {
            $groupedRoomBookings[$booking['date']][] = $booking;
        }

        foreach ($groupedRoomBookings as $bookingDate => $dayBookings) {
            $roomMessage .= "📅 วันที่ " . thaiDate($bookingDate) . "\n";
            foreach ($dayBookings as $index => $booking) {
                // Find teacher name
                $teacherName = $booking['teach_id'];
                $teacher = $dbUsers->getTeacherByUsername($booking['teach_id']);
                if ($teacher) {
                    $teacherName = $teacher['Teach_name'];
                }
                
                $statusText = $booking['status'] == 1 ? '✅ อนุมัติแล้ว' : '⏳ รออนุมัติ';
                
                // Translate room layout
                $layoutMap = [
                    "theater" => "🎭 โรงภาพยนตร์",
                    "classroom" => "🏫 ห้องเรียน",
                    "u-shape" => "🔲 ตัว U",
                    "boardroom" => "📋 โต๊ะประชุม",
                    "banquet" => "🍽️ โต๊ะกลม",
                    "none" => "-"
                ];
                $roomLayoutText = "-";
                if (!empty($booking['room_layout'])) {
                    if (strpos($booking['room_layout'], "custom:") === 0) {
                        $roomLayoutText = "✏️ " . substr($booking['room_layout'], 7);
                    } else {
                        $roomLayoutText = $layoutMap[$booking['room_layout']] ?? "-";
                    }
                }
                
                $roomMessage .= "  " . ($index + 1) . ". 🏢 " . ($booking['room_name'] ?? $booking['location']) . "\n"
                              . "     ⏰ เวลา: " . substr($booking['time_start'], 0, 5) . " - " . substr($booking['time_end'], 0, 5) . " น.\n"
                              . "     👤 ผู้จอง: {$teacherName}" . (!empty($booking['phone']) ? " (โทร: {$booking['phone']})" : "") . "\n"
                              . "     🎯 วัตถุประสงค์: {$booking['purpose']}\n"
                              . "     🪑 จัดห้อง: {$roomLayoutText}\n"
                              . "     📺 อุปกรณ์: " . (!empty($booking['media']) ? $booking['media'] : "-") . "\n"
                              . "     สถานะ: {$statusText}\n";
            }
            $roomMessage .= "-----------------------------\n";
        }

        // Room credentials from system settings database table
        $channelAccessToken = $dbSettings['room_line_token'] ?? '';
        $groupId = $dbSettings['room_group_id'] ?? '';
        $discordWebhook = $dbSettings['room_discord_webhook'] ?? '';

        // Toggles from config.json (default to true if not set)
        $roomLineEnabled = $config['notifications']['room_line_enabled'] ?? true;
        $roomDiscordEnabled = $config['notifications']['room_discord_enabled'] ?? true;

        // Send LINE Bot Notification for Rooms
        if ($roomLineEnabled && !empty($channelAccessToken) && !empty($groupId)) {
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
        } else {
            $results['room_notifications']['line'] = [
                'sent' => false,
                'reason' => 'Disabled or credentials missing'
            ];
        }

        // Send Discord Notification for Rooms
        if ($roomDiscordEnabled && !empty($discordWebhook)) {
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
            $results['room_notifications']['discord'] = [
                'sent' => false,
                'reason' => 'Disabled or credentials missing'
            ];
        }
    } else {
        $results['room_notifications']['status'] = "No bookings found for target date range";
    }

    // --- SECTION 2: CAR BOOKINGS ---
    // Fetch active car bookings for target date range (status != 'rejected')
    $carSql = "SELECT cb.*, c.car_model, c.license_plate 
               FROM car_bookings cb 
               LEFT JOIN cars c ON cb.car_id = c.id 
               WHERE cb.booking_date >= :start_date AND cb.booking_date <= :end_date AND cb.status != 'rejected'
               ORDER BY cb.booking_date ASC, cb.start_time ASC";
    $stmt = $pdoGeneral->prepare($carSql);
    $stmt->execute(['start_date' => $startDate, 'end_date' => $endDate]);
    $carBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($carBookings)) {
        // Build Car Summary Message
        $carMessage = "-----------------------------\n"
                    . "📢 สรุปรายการจองรถยนต์ราชการ\n"
                    . "สำหรับ{$dayLabel}\n"
                    . "-----------------------------\n";

        // Group by date
        $groupedCarBookings = [];
        foreach ($carBookings as $booking) {
            $groupedCarBookings[$booking['booking_date']][] = $booking;
        }

        foreach ($groupedCarBookings as $bookingDate => $dayBookings) {
            $carMessage .= "📅 วันที่ " . thaiDate($bookingDate) . "\n";
            foreach ($dayBookings as $index => $booking) {
                $carDesc = $booking['car_model'] 
                    ? "{$booking['car_model']} ({$booking['license_plate']})" 
                    : $booking['car_id'];
                    
                $statusText = $booking['status'] === 'approved' ? '✅ อนุมัติแล้ว' : ($booking['status'] === 'pending' ? '⏳ รออนุมัติ' : $booking['status']);
                
                $carMessage .= "  " . ($index + 1) . ". 🚐 " . $carDesc . "\n"
                             . "     ⏰ เวลา: " . date('H:i', strtotime($booking['start_time'])) . " - " . date('H:i', strtotime($booking['end_time'])) . " น.\n"
                             . "     👤 ผู้จอง: {$booking['teacher_name']} ({$booking['teacher_position']})\n"
                             . "     📍 ปลายทาง: {$booking['destination']}\n"
                             . "     🎯 วัตถุประสงค์: {$booking['purpose']}\n"
                             . "     สถานะ: {$statusText}\n";
            }
            $carMessage .= "-----------------------------\n";
        }

        // Discord Notification
        $webhookUrl = $dbSettings['car_discord_webhook'] ?? '';
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
        $lineToken = $dbSettings['car_line_token'] ?? '';
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
        $tgToken = $dbSettings['telegram_bot_token'] ?? '';
        $tgChatId = $dbSettings['telegram_chat_id'] ?? '';
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
        $results['car_notifications']['status'] = "No bookings found for target date range";
    }

} catch (Exception $e) {
    $results['success'] = false;
    $results['error'] = $e->getMessage();
}

// Output JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
