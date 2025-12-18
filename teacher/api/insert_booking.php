<?php
require_once __DIR__ . "/../../classes/DatabaseGeneral.php";
require_once __DIR__ . "/../../models/Booking.php";
require_once __DIR__ . "/../../controllers/BookingController.php";
require_once __DIR__ . "/../../models/TermPee.php";

use Controllers\BookingController;

// Set headers
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle preflight requests
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

// Helper Functions
function getThaiDate($date) {
    $months = [
        "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
    ];
    $ts = strtotime($date);
    if (!$ts) return $date;
    $day = date("j", $ts);
    $month = $months[(int)date("n", $ts)];
    $year = date("Y", $ts) + 543;
    return "{$day} {$month} {$year}";
}

function sendLineFlexMessage($channelAccessToken, $groupId, $flexContent, $retries = 3) {
    $url = "https://api.line.me/v2/bot/message/push";
    $headers = [
        "Content-Type: application/json; charset=UTF-8",
        "Authorization: Bearer {$channelAccessToken}",
        "User-Agent: PHP LINE Bot"
    ];
    $body = [
        "to" => $groupId,
        "messages" => [
            [
                "type" => "flex",
                "altText" => "แจ้งเตือนการจองห้องประชุมใหม่",
                "contents" => $flexContent
            ]
        ]
    ];

    for ($attempt = 1; $attempt <= $retries; $attempt++) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($body, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode === 200 && empty($curlError)) {
            return ["success" => true, "response" => $result];
        }

        error_log("LINE API Attempt {$attempt} Failed: HTTP {$httpCode} | Error: {$curlError}");
        if ($attempt < $retries) sleep(2);
    }

    return ["success" => false, "error" => "Failed after {$retries} attempts"];
}

function sendDiscordNotification($webhookUrl, $message, $retries = 3) {
    $data = [
        "content" => $message,
        "username" => "ระบบจองห้องประชุม",
        "avatar_url" => "https://cdn-icons-png.flaticon.com/512/2111/2111615.png"
    ];

    for ($attempt = 1; $attempt <= $retries; $attempt++) {
        $ch = curl_init($webhookUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER => ["Content-Type: application/json; charset=UTF-8"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if (($httpCode === 200 || $httpCode === 204) && empty($curlError)) {
            return ["success" => true, "response" => $result];
        }

        error_log("Discord API Attempt {$attempt} Failed: HTTP {$httpCode} | Error: {$curlError}");
        if ($attempt < $retries) sleep(1);
    }

    return ["success" => false, "error" => "Failed after {$retries} attempts"];
}

// Main Logic
try {
    // Parse Input
    $data = $_POST;
    if (empty($data)) {
        $input = file_get_contents("php://input");
        if (!empty($input)) {
            $jsonData = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($jsonData)) {
                $data = $jsonData;
            }
        }
    }

    // Process Media Items
    $media = [];
    if (!empty($data["media_items"])) {
        $media = is_array($data["media_items"]) ? $data["media_items"] : array_map("trim", explode(",", $data["media_items"]));
    }
    if (!empty($data["other_media"])) {
        $media[] = trim($data["other_media"]);
    }
    if (!empty($media)) {
        $data["media"] = implode(", ", $media);
    }

    // Fetch Room Name if needed
    if (!empty($data["room_id"])) {
        $dbGeneral = new \App\DatabaseGeneral();
        $stmt = $dbGeneral->query("SELECT room_name FROM meeting_rooms WHERE id = :id", ["id" => $data["room_id"]]);
        $room = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($room) {
            $data["location"] = $room["room_name"];
        }
    }

    // Validation
    $hasRoom = !empty($data["room_id"]) || !empty($data["location"]);
    if (empty($data["date"]) || !$hasRoom || empty($data["time_start"]) || empty($data["time_end"]) || empty($data["purpose"])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "ข้อมูลไม่ครบถ้วน กรุณาตรวจสอบข้อมูลอีกครั้ง"]);
        exit;
    }

    // Set Term/Pee
    if (empty($data["term"]) || empty($data["pee"])) {
        $termPee = \TermPee::getCurrent();
        $data["term"] = $termPee->term;
        $data["pee"] = $termPee->pee;
    }

    $data["status"] = 0; // Pending

    // Create Booking
    $controller = new BookingController();
    $result = $controller->create($data);

    if (!empty($result["success"])) {
        // Configuration
        $channelAccessToken = "3K7fh1bhbCn0uPjgNoGQpN3jNgpwpSoMA0QaE6m4dOMJkly+SeGyDyS73+EV6wSVuLoB6M/+FwdbxRWlY6ZGuQymNTYSrFzA5xQ7AhwlwOufu+et60PnAnYK2vpyvUyy3ye0yBe7cTu+PoiFDxsmmgdB04t89/1O/w1cDnyilFU=";
        $groupId = "Cafbcad04d9e78bbee85b2447ee768baf";
        
        // Get Teacher Name
        $userDb = new \App\DatabaseUsers();
        $teacher = $userDb->getTeacherByUsername($data["teach_id"]);
        $teacherName = $teacher ? $teacher["Teach_name"] : $data["teach_id"];

        // Prepare Layout Text
        $layoutMap = [
            "theater" => "🎭 โรงภาพยนตร์",
            "classroom" => "🏫 ห้องเรียน",
            "u-shape" => "🔲 ตัว U",
            "boardroom" => "📋 โต๊ะประชุม",
            "banquet" => "🍽️ โต๊ะกลม",
            "none" => "-"
        ];
        $roomLayoutText = "-";
        if (!empty($data["room_layout"])) {
            if (strpos($data["room_layout"], "custom:") === 0) {
                $roomLayoutText = "✏️ " . substr($data["room_layout"], 7);
            } else {
                $roomLayoutText = $layoutMap[$data["room_layout"]] ?? "-";
            }
        }

        // Prepare Flex Message
        $flexContent = [
            "type" => "bubble",
            "styles" => [
                "header" => ["backgroundColor" => "#7c3aed"],
                "body" => ["backgroundColor" => "#f8fafc"]
            ],
            "header" => [
                "type" => "box",
                "layout" => "vertical",
                "paddingAll" => "20px",
                "backgroundColor" => "#7c3aed",
                "contents" => [
                    ["type" => "text", "text" => "🎉 การจองห้องประชุมใหม่ 🎉", "weight" => "bold", "size" => "xl", "color" => "#ffffff", "align" => "center"],
                    ["type" => "text", "text" => "📋 รายละเอียดการจอง", "size" => "md", "color" => "#e5e7eb", "align" => "center", "margin" => "sm"]
                ]
            ],
            "body" => [
                "type" => "box",
                "layout" => "vertical",
                "spacing" => "md",
                "paddingAll" => "20px",
                "contents" => [
                    // Date
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "📅", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "วันที่", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => getThaiDate($data["date"]), "wrap" => true, "size" => "sm", "color" => "#111827", "weight" => "bold", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Time
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "⏰", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "เวลา", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => substr($data["time_start"], 0, 5) . " - " . substr($data["time_end"], 0, 5) . " น.", "wrap" => true, "size" => "sm", "color" => "#111827", "weight" => "bold", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Location
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "🏢", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "สถานที่", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => $data["location"], "wrap" => true, "size" => "sm", "color" => "#111827", "weight" => "bold", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Purpose
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "🎯", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "วัตถุประสงค์", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => strlen($data["purpose"]) > 80 ? substr($data["purpose"], 0, 80) . "..." : $data["purpose"], "wrap" => true, "size" => "sm", "color" => "#111827", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Layout
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "🪑", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "จัดห้อง", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => $roomLayoutText, "wrap" => true, "size" => "sm", "color" => "#111827", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Equipment
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "🛠️", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "อุปกรณ์", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => !empty($data["media"]) ? $data["media"] : "-", "wrap" => true, "size" => "sm", "color" => "#111827", "flex" => 6]
                        ]
                    ],
                    ["type" => "separator", "margin" => "md"],
                    // Booker
                    [
                        "type" => "box", "layout" => "baseline", "spacing" => "sm",
                        "contents" => [
                            ["type" => "text", "text" => "👤", "size" => "lg", "flex" => 1],
                            ["type" => "text", "text" => "ผู้จอง", "size" => "sm", "weight" => "bold", "color" => "#6b7280", "flex" => 3],
                            ["type" => "text", "text" => $teacherName, "wrap" => true, "size" => "sm", "color" => "#111827", "weight" => "bold", "flex" => 6]
                        ]
                    ]
                ]
            ],
            "footer" => [
                "type" => "box",
                "layout" => "vertical",
                "spacing" => "sm",
                "contents" => [
                    [
                        "type" => "button",
                        "style" => "primary",
                        "height" => "sm",
                        "action" => [
                            "type" => "uri",
                            "label" => "ตรวจสอบสถานะ",
                            "uri" => "https://general.pnru.ac.th/generalv2/"
                        ],
                        "color" => "#7c3aed"
                    ]
                ],
                "paddingAll" => "20px"
            ]
        ];

        // Send response to client FIRST (before slow notifications)
        echo json_encode($result);
        
        // Flush output to client immediately so they don't wait
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } else {
            // For non-FastCGI environments
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();
        }
        
        // Now send notifications in background (client already got response)
        // Send LINE Notification
        sendLineFlexMessage($channelAccessToken, $groupId, $flexContent);

        // Send Discord Notification
        $discordMessage = "**มีการจองห้องประชุมใหม่**\n" .
            "**วันที่:** " . getThaiDate($data["date"]) . "\n" .
            "**เวลา:** " . substr($data["time_start"], 0, 5) . " - " . substr($data["time_end"], 0, 5) . " น.\n" .
            "**ห้อง:** " . $data["location"] . "\n" .
            "**ผู้จอง:** " . $teacherName . "\n" .
            "**หัวข้อ:** " . $data["purpose"];
            
        sendDiscordNotification(
            "https://discord.com/api/webhooks/1324990236822241300/lZk9s-t-l324_uD6s-kK4v-lZk9s-t-l324_uD6s-kK4v",
            $discordMessage
        );
        
        exit; // Stop here, response already sent
    }

    echo json_encode($result);

} catch (Exception $e) {
    error_log("Error in insert_booking.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "success" => false, 
        "message" => "เกิดข้อผิดพลาดภายในระบบ: " . $e->getMessage(),
        "trace" => $e->getTraceAsString()
    ]);
}
?>