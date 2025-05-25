<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Booking.php';
require_once __DIR__ . '/../../controllers/BookingController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\BookingController;

header('Content-Type: application/json');

try {
    $data = $_POST;

    // รวม media จาก media_items[] และ other_media (ถ้ามี)
    $media = [];
    if (!empty($_POST['media_items']) && is_array($_POST['media_items'])) {
        $media = $_POST['media_items'];
    }
    if (!empty($_POST['other_media'])) {
        $media[] = trim($_POST['other_media']);
    }
    if (!empty($media)) {
        $data['media'] = implode(', ', $media);
    }
    
    // Log ข้อมูลที่ได้รับ
    error_log("Received booking data: " . print_r($data, true));
    
    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($data['date']) || empty($data['location']) || empty($data['time_start']) || empty($data['time_end']) || empty($data['purpose'])) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
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
    function send_line_flex($channel_access_token, $groupId, $flex) {
        $url = "https://api.line.me/v2/bot/message/push";
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer {$channel_access_token}"
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
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        error_log("LINE API HTTP CODE: $httpCode | RESPONSE: $result | CURL ERROR: $curlError");
        curl_close($ch);
        return $result;
    }

    // ถ้า insert สำเร็จ ส่งไลน์แจ้งเตือนผ่าน Messaging API (Flex)
    if (!empty($result['success'])) {
        $channelAccessToken = '3K7fh1bhbCn0uPjgNoGQpN3jNgpwpSoMA0QaE6m4dOMJkly+SeGyDyS73+EV6wSVuLoB6M/+FwdbxRWlY6ZGuQymNTYSrFzA5xQ7AhwlwOufu+et60PnAnYK2vpyvUyy3ye0yBe7cTu+PoiFDxsmmgdB04t89/1O/w1cDnyilFU=';
        $groupId = 'U9e0d2e5050696fef1168a9fcb9ca5a3f';

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
                        "text" => "📞 ติดต่อสอบถาม: เจ้าหน้าที่บริหารงานทั่วไป",
                        "size" => "xs",
                        "color" => "#9ca3af",
                        "align" => "center",
                        "margin" => "sm"
                    ]
                ]
            ]
        ];

        error_log("Sending LINE message for booking success...");
        send_line_flex($channelAccessToken, $groupId, $flex);
    } else {
        error_log("Booking failed, not sending LINE message. Result: " . print_r($result, true));
    }

    echo json_encode($result);
} catch (\Throwable $e) {
    error_log("Error in insert_booking.php: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
