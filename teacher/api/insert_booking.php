<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\BookingController;

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // รองรับทั้ง POST และ JSON input
    $data = [];
    if (!empty($_POST)) {
        $data = $_POST;
    } else {
        // อ่านข้อมูลจาก raw input สำหรับ mobile apps หรือ AJAX requests
        $input = file_get_contents('php://input');
        if (!empty($input)) {
            $jsonData = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
                $data = $jsonData;
            }
        }
    }
    
    // Log device และ user agent สำหรับ debugging
    error_log("Request from Device - User Agent: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'));
    error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
    error_log("Content Type: " . ($_SERVER['CONTENT_TYPE'] ?? 'Unknown'));

    // รวม media จาก media_items[] และ other_media (ถ้ามี)
    $media = [];
    if (!empty($data['media_items'])) {
        if (is_array($data['media_items'])) {
            $media = $data['media_items'];
        } else {
            // รองรับกรณีที่ส่งมาเป็น string (จาก mobile apps)
            $media = explode(',', $data['media_items']);
            $media = array_map('trim', $media);
        }
    }
    if (!empty($data['other_media'])) {
        $media[] = trim($data['other_media']);
    }
    if (!empty($media)) {
        $data['media'] = implode(', ', $media);
    }
    
    // Log ข้อมูลที่ได้รับ
    error_log("Received booking data: " . print_r($data, true));
    
    // ถ้ามี room_id ให้ดึงชื่อห้องจาก database มาใส่ใน location ด้วย
    if (!empty($data['room_id'])) {
        $dbGeneral = new \App\DatabaseGeneral();
        $stmt = $dbGeneral->query("SELECT room_name FROM meeting_rooms WHERE id = :id", ['id' => $data['room_id']]);
        $room = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($room) {
            $data['location'] = $room['room_name'];
        }
    }
    
    // ตรวจสอบข้อมูลที่จำเป็น - รองรับทั้ง room_id หรือ location
    $hasRoom = !empty($data['room_id']) || !empty($data['location']);
    if (empty($data['date']) || !$hasRoom || empty($data['time_start']) || empty($data['time_end']) || empty($data['purpose'])) {
        error_log("Missing required fields: " . json_encode($data));
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน กรุณาตรวจสอบข้อมูลอีกครั้ง']);
        exit;
    }
    
    // ใช้ TermPee หากไม่ได้ส่ง term/pee มา
    if (empty($data['term']) || empty($data['pee'])) {
        $termPee = \TermPee::getCurrent();
        $data['term'] = $termPee->term;
        $data['pee'] = $termPee->pee;
    }

    // เพิ่ม status = 0 (pending)
    $data['status'] = 0;

    $controller = new BookingController();
    $result = $controller->create($data);

    // --- ส่ง Flex Message ไปยังกลุ่ม LINE (Messaging API) ---
    function send_line_flex($channel_access_token, $groupId, $flex, $retries = 3) {
        $url = "https://api.line.me/v2/bot/message/push";
        $headers = [
            "Content-Type: application/json; charset=UTF-8",
            "Authorization: Bearer {$channel_access_token}",
            "User-Agent: PHP LINE Bot"
        ];
        $body = [
            "to" => $groupId,
            "messages" => [
                [
                    "type" => "flex",
                    "altText" => "แจ้งเตือนการจองห้องประชุมใหม่",
                    "contents" => $flex
                ]
            ]
        ];

        $attempt = 0;
        while ($attempt < $retries) {
            $attempt++;
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); // เพิ่ม timeout
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // connection timeout
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // สำหรับ development
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            
            error_log("LINE API Attempt {$attempt}: HTTP CODE: {$httpCode} | RESPONSE: {$result} | CURL ERROR: {$curlError}");
            
            // ตรวจสอบว่าส่งสำเร็จหรือไม่
            if ($httpCode === 200 && empty($curlError)) {
                curl_close($ch);
                error_log("LINE message sent successfully on attempt {$attempt}");
                return ['success' => true, 'response' => $result];
            }
            
            curl_close($ch);
            
            // ถ้าไม่ใช่ attempt สุดท้าย ให้รอสักครู่ก่อน retry
            if ($attempt < $retries) {
                error_log("LINE API failed on attempt {$attempt}, retrying in 2 seconds...");
                sleep(2);
            }
        }
        
        error_log("LINE API failed after {$retries} attempts. Last HTTP CODE: {$httpCode}, Last Error: {$curlError}");
        return ['success' => false, 'error' => "Failed after {$retries} attempts", 'last_http_code' => $httpCode, 'last_error' => $curlError];
    }

    // ฟังก์ชัน fallback สำหรับส่งข้อความธรรมดา
    function send_simple_line_message($channel_access_token, $messageData, $retries = 3) {
        $url = "https://api.line.me/v2/bot/message/push";
        $headers = [
            "Content-Type: application/json; charset=UTF-8",
            "Authorization: Bearer {$channel_access_token}",
            "User-Agent: PHP LINE Bot"
        ];

        $attempt = 0;
        while ($attempt < $retries) {
            $attempt++;
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            
            error_log("LINE Simple Message Attempt {$attempt}: HTTP CODE: {$httpCode} | RESPONSE: {$result} | CURL ERROR: {$curlError}");
            
            if ($httpCode === 200 && empty($curlError)) {
                curl_close($ch);
                return ['success' => true, 'response' => $result];
            }
            
            curl_close($ch);
            
            if ($attempt < $retries) {
                sleep(2);
            }
        }
        
        return ['success' => false, 'error' => "Failed after {$retries} attempts", 'last_http_code' => $httpCode, 'last_error' => $curlError];
    }

    // ฟังก์ชันส่งการแจ้งเตือนไปยัง Discord
    function send_discord_notification($webhookUrl, $message, $retries = 3) {
        $data = [
            'content' => $message,
            'username' => 'ระบบจองห้องประชุม',
            'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/2111/2111615.png'
        ];

        $attempt = 0;
        while ($attempt < $retries) {
            $attempt++;
            
            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=UTF-8',
                'User-Agent: PHP Discord Bot'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            
            error_log("Discord Notification Attempt {$attempt}: HTTP CODE: {$httpCode} | RESPONSE: {$result} | CURL ERROR: {$curlError}");
            
            if (($httpCode === 200 || $httpCode === 204) && empty($curlError)) {
                curl_close($ch);
                return ['success' => true, 'response' => $result];
            }
            
            curl_close($ch);
            
            if ($attempt < $retries) {
                sleep(1);
            }
        }
        
        return ['success' => false, 'error' => "Failed after {$retries} attempts", 'last_http_code' => $httpCode, 'last_error' => $curlError];
    }

    // ถ้า insert สำเร็จ ส่งไลน์แจ้งเตือนผ่าน Messaging API (Flex)
    if (!empty($result['success'])) {
        $channelAccessToken = '3K7fh1bhbCn0uPjgNoGQpN3jNgpwpSoMA0QaE6m4dOMJkly+SeGyDyS73+EV6wSVuLoB6M/+FwdbxRWlY6ZGuQymNTYSrFzA5xQ7AhwlwOufu+et60PnAnYK2vpyvUyy3ye0yBe7cTu+PoiFDxsmmgdB04t89/1O/w1cDnyilFU=';
        $groupId = 'Cafbcad04d9e78bbee85b2447ee768baf';
        // $groupId = 'U9e0d2e5050696fef1168a9fcb9ca5a3f'; // สำหรับทดสอบในกลุ่มส่วนตัว

        // ดึงชื่อครูจาก DatabaseUsers
        $userDb = new \App\DatabaseUsers();
        $teacher = $userDb->getTeacherByUsername($data['teach_id']);
        $teacherName = $teacher ? $teacher['Teach_name'] : $data['teach_id'];

        // ฟังก์ชันแปลงวันที่เป็นวันเดือนปีภาษาไทย
        function thai_date($date) {
            $months = [
                "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
            ];
            $ts = strtotime($date);
            if (!$ts) return $date;
            $day = date('j', $ts);
            $month = $months[(int)date('n', $ts)];
            $year = date('Y', $ts) + 543;
            return "{$day} {$month} {$year}";
        }

        // แปลงรูปแบบการจัดห้องเป็นข้อความ (สำหรับ Flex Message)
        $this_roomLayoutText = '-';
        if (!empty($data['room_layout'])) {
            $layoutMap = [
                'theater' => '🎭 โรงภาพยนตร์',
                'classroom' => '🏫 ห้องเรียน',
                'u-shape' => '🔲 ตัว U',
                'boardroom' => '📋 โต๊ะประชุม',
                'banquet' => '🍽️ โต๊ะกลม',
                'none' => '-'
            ];
            if (strpos($data['room_layout'], 'custom:') === 0) {
                $this_roomLayoutText = '✏️ ' . substr($data['room_layout'], 7);
            } else {
                $this_roomLayoutText = $layoutMap[$data['room_layout']] ?? '-';
            }
        }

        $flex = [
            "type" => "bubble",
            "styles" => [
                "header" => [
                    "backgroundColor" => "#7c3aed"
                ],
                "body" => [
                    "backgroundColor" => "#f8fafc"
                ]
            ],
            "header" => [
                "type" => "box",
                "layout" => "vertical",
                "paddingAll" => "20px",
                "backgroundColor" => "#7c3aed",
                "contents" => [
                    [
                        "type" => "text",
                        "text" => "🎉 การจองห้องประชุมใหม่ 🎉",
                        "weight" => "bold",
                        "size" => "xl",
                        "color" => "#ffffff",
                        "align" => "center"
                    ],
                    [
                        "type" => "text",
                        "text" => "📋 รายละเอียดการจอง",
                        "size" => "md",
                        "color" => "#e5e7eb",
                        "align" => "center",
                        "margin" => "sm"
                    ]
                ]
            ],
            "body" => [
                "type" => "box",
                "layout" => "vertical",
                "spacing" => "md",
                "paddingAll" => "20px",
                "contents" => [
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "📅",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "วันที่",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => thai_date($data['date']),
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "weight" => "bold",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "⏰",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "เวลา",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => substr($data['time_start'], 0, 5) . " - " . substr($data['time_end'], 0, 5) . " น.",
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "weight" => "bold",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "🏢",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "สถานที่",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => $data['location'],
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "weight" => "bold",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "🎯",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "วัตถุประสงค์",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => strlen($data['purpose']) > 80 ? substr($data['purpose'], 0, 80) . "..." : $data['purpose'],
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    // เพิ่มแสดงรูปแบบการจัดห้อง
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "🪑",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "จัดห้อง",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => $this_roomLayoutText ?? "-",
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    // เพิ่มแสดงอุปกรณ์ที่ต้องการ
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "🛠️",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "อุปกรณ์",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => !empty($data['media']) ? $data['media'] : "-",
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#111827",
                                "flex" => 6
                            ]
                        ]
                    ],
                    [
                        "type" => "separator",
                        "margin" => "md"
                    ],
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => "sm",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "👨‍🏫",
                                "size" => "lg",
                                "flex" => 1
                            ],
                            [
                                "type" => "text",
                                "text" => "ผู้จอง",
                                "size" => "sm",
                                "weight" => "bold",
                                "color" => "#6b7280",
                                "flex" => 3
                            ],
                            [
                                "type" => "text",
                                "text" => $teacherName,
                                "wrap" => true,
                                "size" => "sm",
                                "color" => "#7c3aed",
                                "weight" => "bold",
                                "flex" => 6
                            ]
                        ]
                    ]
                ]
            ],
            "footer" => [
                "type" => "box",
                "layout" => "vertical",
                "spacing" => "sm",
                "paddingAll" => "15px",
                "backgroundColor" => "#f3f4f6",
                "contents" => [
                    [
                        "type" => "box",
                        "layout" => "horizontal",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "🔔",
                                "size" => "sm",
                                "flex" => 1,
                                "align" => "center"
                            ],
                            [
                                "type" => "text",
                                "text" => "สถานะ: รอการอนุมัติ",
                                "size" => "sm",
                                "color" => "#f59e0b",
                                "weight" => "bold",
                                "flex" => 8,
                                "align" => "center"
                            ],
                            [
                                "type" => "text",
                                "text" => "⏳",
                                "size" => "sm",
                                "flex" => 1,
                                "align" => "center"
                            ]
                        ]
                    ],
                    [
                        "type" => "text",
                        "text" => "📞 ติดต่อสอบถาม: " . (!empty($data['phone']) ? $data['phone'] : "-"),
                        "size" => "xs",
                        "color" => "#9ca3af",
                        "align" => "center",
                        "margin" => "sm"
                    ]
                ]
            ]
        ];

        error_log("Sending LINE message for booking success...");
        $lineResult = send_line_flex($channelAccessToken, $groupId, $flex);
        
        if ($lineResult['success']) {
            error_log("LINE notification sent successfully");
        } else {
            error_log("LINE notification failed: " . json_encode($lineResult));
            
            // ลอง fallback ด้วย simple text message
            error_log("Attempting fallback with simple text message...");
            $simpleMessage = [
                "to" => $groupId,
                "messages" => [
                    [
                        "type" => "text",
                        "text" => "🎉 มีการจองห้องประชุมใหม่\n\n" .
                               "📅 วันที่: " . thai_date($data['date']) . "\n" .
                               "⏰ เวลา: " . substr($data['time_start'], 0, 5) . " - " . substr($data['time_end'], 0, 5) . " น.\n" .
                               "🏢 สถานที่: " . $data['location'] . "\n" .
                               "🪑 รูปแบบจัดห้อง: " . $this_roomLayoutText . "\n" .
                               "🎯 วัตถุประสงค์: " . $data['purpose'] . "\n" .
                               "🛠️ อุปกรณ์: " . (!empty($data['media']) ? $data['media'] : "-") . "\n" .
                               "👨‍🏫 ผู้จอง: " . $teacherName . "\n" .
                               "📞 โทร: " . (!empty($data['phone']) ? $data['phone'] : "-") . "\n\n" .
                               "⏳ สถานะ: รอการอนุมัติ"
                    ]
                ]
            ];
            
            $fallbackResult = send_simple_line_message($channelAccessToken, $simpleMessage);
            if ($fallbackResult['success']) {
                error_log("Fallback text message sent successfully");
            } else {
                error_log("Both Flex and text message failed: " . json_encode($fallbackResult));
            }
        }

        // ส่งการแจ้งเตือนไปยัง Discord (ส่งครั้งเดียว)
        $discordWebhookUrl = 'https://discord.com/api/webhooks/1392369288953856052/y1BfeY9KlMjHyhQ1P5lFKROa2yWaWQQxzAAK6NZLjheGm6nOtjSTuukr2cE7uX3tBtXF';
        
        if (!empty($discordWebhookUrl)) {
            error_log("Sending Discord notification...");
            
            $discordMessage = "🎉 **การจองห้องประชุมใหม่** 🎉\n\n" .
                            "📅 **วันที่:** " . thai_date($data['date']) . "\n" .
                            "⏰ **เวลา:** " . substr($data['time_start'], 0, 5) . " - " . substr($data['time_end'], 0, 5) . " น.\n" .
                            "🏢 **สถานที่:** " . $data['location'] . "\n" .
                            "🪑 **รูปแบบจัดห้อง:** " . $this_roomLayoutText . "\n" .
                            "🎯 **วัตถุประสงค์:** " . $data['purpose'] . "\n" .
                            "🛠️ **อุปกรณ์:** " . (!empty($data['media']) ? $data['media'] : "-") . "\n" .
                            "👨‍🏫 **ผู้จอง:** " . $teacherName . "\n" .
                            "📞 **ติดต่อ:** " . (!empty($data['phone']) ? $data['phone'] : "-") . "\n\n" .
                            "⏳ **สถานะ:** รอการอนุมัติ";
            
            $discordResult = send_discord_notification($discordWebhookUrl, $discordMessage);
            
            if ($discordResult['success']) {
                error_log("Discord notification sent successfully");
            } else {
                error_log("Discord notification failed: " . json_encode($discordResult));
            }
        }

    } else {
        error_log("Booking failed, not sending LINE message. Result: " . print_r($result, true));
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (\Throwable $e) {
    error_log("Error in insert_booking.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    error_log("Request data: " . print_r($_POST, true));
    error_log("Raw input: " . file_get_contents('php://input'));
    
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในระบบ กรุณาลองใหม่อีกครั้ง'], JSON_UNESCAPED_UNICODE);
}
