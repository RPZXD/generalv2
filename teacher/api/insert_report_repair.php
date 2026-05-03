<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';
require_once __DIR__ . '/../../classes/DatabaseUsers.php';
require_once __DIR__ . '/../../classes/NotificationHelper.php';

use Controllers\ReportRepairController;
use App\NotificationHelper;

header('Content-Type: application/json');

try {
    $data = $_POST;
    // ตรวจสอบและแปลงค่าที่จำเป็น
    $fields = [
        'AddDate',
        'AddLocation',
        'doorCount',
        'doorDamage',
        'windowCount',
        'windowDamage',
        'tablestCount',
        'tablestDamage',
        'chairstCount',
        'chairstDamage',
        'tabletaCount',
        'tabletaDamage',
        'chairtaCount',
        'chairtaDamage',
        'other1Details',
        'other1Count',
        'other1Damage',
        'tvCount',
        'tvDamage',
        'audioCount',
        'audioDamage',
        'hdmiCount',
        'hdmiDamage',
        'projectorCount',
        'projectorDamage',
        'other2Details',
        'other2Count',
        'other2Damage',
        'fanCount',
        'fanDamage',
        'lightCount',
        'lightDamage',
        'airCount',
        'airDamage',
        'swCount',
        'swDamage',
        'swfanCount',
        'swfanDamage',
        'plugCount',
        'plugDamage',
        'other3Details',
        'other3Count',
        'other3Damage',
        'teach_id',
        'term',
        'pee'
    ];

    $insertData = [];
    foreach ($fields as $f) {
        $insertData[$f] = isset($data[$f]) && $data[$f] !== '' ? $data[$f] : null;
    }

    if (empty($insertData['term']) || empty($insertData['pee'])) {
        $termPee = \TermPee::getCurrent();
        $insertData['term'] = $termPee->term;
        $insertData['pee'] = $termPee->pee;
    }

    $insertData['status'] = '0';

    $controller = new ReportRepairController();
    $success = $controller->create($insertData);

    if ($success) {
        // ดึงชื่อครู
        $userDb = new \App\DatabaseUsers();
        $teacher = $userDb->getTeacherByUsername($data['teach_id']);
        $teacherName = $teacher ? $teacher['Teach_name'] : $data['teach_id'];

        // เตรียมรายละเอียดการแจ้งซ่อม
        $details = [];
        $checkFields = [
            'door' => 'ประตู',
            'window' => 'หน้าต่าง',
            'tablest' => 'โต๊ะนักเรียน',
            'chairst' => 'เก้าอี้นักเรียน',
            'tableta' => 'โต๊ะอาจารย์',
            'chairta' => 'เก้าอี้อาจารย์',
            'tv' => 'ทีวี',
            'audio' => 'เครื่องเสียง',
            'hdmi' => 'HDMI',
            'projector' => 'โปรเจคเตอร์',
            'fan' => 'พัดลม',
            'light' => 'ไฟ',
            'air' => 'แอร์',
            'sw' => 'สวิตช์ไฟ',
            'swfan' => 'สวิตช์พัดลม',
            'plug' => 'ปลั๊กไฟ'
        ];

        foreach ($checkFields as $key => $label) {
            if (!empty($insertData[$key . 'Count']) || !empty($insertData[$key . 'Damage'])) {
                $count = $insertData[$key . 'Count'] ?? 1;
                $damage = $insertData[$key . 'Damage'] ?? '-';
                $details[] = "🔹 *{$label}* ({$count}) : {$damage}";
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            if (!empty($insertData["other{$i}Details"])) {
                $label = $insertData["other{$i}Details"];
                $count = $insertData["other{$i}Count"] ?? 1;
                $damage = $insertData["other{$i}Damage"] ?? '-';
                $details[] = "🔸 *{$label}* ({$count}) : {$damage}";
            }
        }

        $msg = "🛠️ *แจ้งซ่อมใหม่ (New Repair)*\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📍 *สถานที่:* " . ($insertData['AddLocation'] ?? '-') . "\n"
            . "📅 *วันที่:* " . ($insertData['AddDate'] ?? '-') . "\n"
            . "👤 *ผู้แจ้ง:* {$teacherName}\n"
            . "━━━━━━━━━━━━━━━━━━━━\n"
            . "📋 *รายการแจ้งซ่อม:*\n"
            . (count($details) > 0 ? implode("\n", $details) : "⚠️ _ไม่มีรายละเอียดอุปกรณ์_") . "\n"
            . "━━━━━━━━━━━━━━━━━━━━";

        NotificationHelper::sendRepairNotification($msg);
    }

    echo json_encode(['success' => $success]);
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
