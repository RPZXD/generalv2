<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'forbidden']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id']) || !isset($data['status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'missing data']);
    exit;
}
require_once('../../controllers/ReportRepairController.php');
use Controllers\ReportRepairController;

$controller = new ReportRepairController();
$update = $controller->updateStatusById($data['id'], $data['status']);

// เพิ่มแจ้งเตือน Discord เมื่อเจ้าหน้าที่อัพเดทสถานะ
if ($update) {
    // ดึงรายละเอียดรายการแจ้งซ่อม
    $detail = $controller->getDetail($data['id']);
    $location = $detail['AddLocation'] ?? '-';
    $date = $detail['AddDate'] ?? '-';
    $teacher = $detail['teach_id'] ?? '-';
    $statusText = [
        '0' => 'รอดำเนินการ',
        '1' => 'กำลังดำเนินการ',
        '2' => 'เสร็จสิ้น'
    ];
    $statusLabel = $statusText[$data['status']] ?? $data['status'];

    // รายการรายละเอียด (แสดงเฉพาะที่มีข้อมูล)
    $details = [];
    if (!empty($detail['doorCount']) || !empty($detail['doorDamage'])) {
        $details[] = "🚪 ประตู: {$detail['doorCount']} | เสีย: {$detail['doorDamage']}";
    }
    if (!empty($detail['windowCount']) || !empty($detail['windowDamage'])) {
        $details[] = "🪟 หน้าต่าง: {$detail['windowCount']} | เสีย: {$detail['windowDamage']}";
    }
    if (!empty($detail['tablestCount']) || !empty($detail['tablestDamage'])) {
        $details[] = "🪑 โต๊ะนักเรียน: {$detail['tablestCount']} | เสีย: {$detail['tablestDamage']}";
    }
    if (!empty($detail['chairstCount']) || !empty($detail['chairstDamage'])) {
        $details[] = "💺 เก้าอี้นักเรียน: {$detail['chairstCount']} | เสีย: {$detail['chairstDamage']}";
    }
    if (!empty($detail['tabletaCount']) || !empty($detail['tabletaDamage'])) {
        $details[] = "🧑‍💻 โต๊ะอาจารย์: {$detail['tabletaCount']} | เสีย: {$detail['tabletaDamage']}";
    }
    if (!empty($detail['chairtaCount']) || !empty($detail['chairtaDamage'])) {
        $details[] = "👨‍🏫 เก้าอี้อาจารย์: {$detail['chairtaCount']} | เสีย: {$detail['chairtaDamage']}";
    }
    if (!empty($detail['other1Details']) || !empty($detail['other1Count']) || !empty($detail['other1Damage'])) {
        $details[] = "📝 อื่นๆ1: {$detail['other1Details']} | จำนวน: {$detail['other1Count']} | เสีย: {$detail['other1Damage']}";
    }
    if (!empty($detail['tvCount']) || !empty($detail['tvDamage'])) {
        $details[] = "📺 ทีวี: {$detail['tvCount']} | เสีย: {$detail['tvDamage']}";
    }
    if (!empty($detail['audioCount']) || !empty($detail['audioDamage'])) {
        $details[] = "🔊 เครื่องเสียง: {$detail['audioCount']} | เสีย: {$detail['audioDamage']}";
    }
    if (!empty($detail['hdmiCount']) || !empty($detail['hdmiDamage'])) {
        $details[] = "🔌 HDMI: {$detail['hdmiCount']} | เสีย: {$detail['hdmiDamage']}";
    }
    if (!empty($detail['projectorCount']) || !empty($detail['projectorDamage'])) {
        $details[] = "📽️ โปรเจคเตอร์: {$detail['projectorCount']} | เสีย: {$detail['projectorDamage']}";
    }
    if (!empty($detail['other2Details']) || !empty($detail['other2Count']) || !empty($detail['other2Damage'])) {
        $details[] = "📝 อื่นๆ2: {$detail['other2Details']} | จำนวน: {$detail['other2Count']} | เสีย: {$detail['other2Damage']}";
    }
    if (!empty($detail['fanCount']) || !empty($detail['fanDamage'])) {
        $details[] = "🌀 พัดลม: {$detail['fanCount']} | เสีย: {$detail['fanDamage']}";
    }
    if (!empty($detail['lightCount']) || !empty($detail['lightDamage'])) {
        $details[] = "💡 ไฟ: {$detail['lightCount']} | เสีย: {$detail['lightDamage']}";
    }
    if (!empty($detail['airCount']) || !empty($detail['airDamage'])) {
        $details[] = "❄️ แอร์: {$detail['airCount']} | เสีย: {$detail['airDamage']}";
    }
    if (!empty($detail['swCount']) || !empty($detail['swDamage'])) {
        $details[] = "🔘 สวิตช์ไฟ: {$detail['swCount']} | เสีย: {$detail['swDamage']}";
    }
    if (!empty($detail['swfanCount']) || !empty($detail['swfanDamage'])) {
        $details[] = "🔘 สวิตช์พัดลม: {$detail['swfanCount']} | เสีย: {$detail['swfanDamage']}";
    }
    if (!empty($detail['plugCount']) || !empty($detail['plugDamage'])) {
        $details[] = "🔌 ปลั๊กไฟ: {$detail['plugCount']} | เสีย: {$detail['plugDamage']}";
    }
    if (!empty($detail['other3Details']) || !empty($detail['other3Count']) || !empty($detail['other3Damage'])) {
        $details[] = "📝 อื่นๆ3: {$detail['other3Details']} | จำนวน: {$detail['other3Count']} | เสีย: {$detail['other3Damage']}";
    }

    // ดึงชื่อครูจาก DatabaseUsers
    require_once(__DIR__ . '/../../classes/DatabaseUsers.php');
    $userDb = new \App\DatabaseUsers();
    $teacherData = $userDb->getTeacherByUsername($teacher);
    $teacherName = $teacherData ? $teacherData['Teach_name'] : $teacher;

    $webhookUrl = 'https://discord.com/api/webhooks/1392374493686665226/_Sl9fYw2L193asCqZpxyJkw7ApioLhrPBlmImGwFvTY_L6I-kfvzK93W6yJqicbmlF09';
    $msg = "🔔 **เจ้าหน้าที่อัพเดทสถานะแจ้งซ่อม!**\n"
        . "-----------------------------\n"
        . "🏫 **สถานที่:** {$location}\n"
        . "📅 **วันที่:** {$date}\n"
        . "👤 **ผู้แจ้ง:** {$teacherName}\n"
        . "📌 **สถานะใหม่:** {$statusLabel}\n"
        . "-----------------------------\n"
        . (count($details) > 0 ? implode("\n", $details) : "ไม่มีรายละเอียดอุปกรณ์ที่แจ้งซ่อม");

    $payload = json_encode(['content' => $msg]);
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

echo json_encode(['success' => $update]);
