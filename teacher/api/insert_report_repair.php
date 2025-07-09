<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\ReportRepairController;

header('Content-Type: application/json');

try {
    $data = $_POST;
    // ตรวจสอบและแปลงค่าที่จำเป็น
    $fields = [
        'AddDate', 'AddLocation',
        'doorCount', 'doorDamage', 'windowCount', 'windowDamage', 'tablestCount', 'tablestDamage',
        'chairstCount', 'chairstDamage', 'tabletaCount', 'tabletaDamage', 'chairtaCount', 'chairtaDamage',
        'other1Details', 'other1Count', 'other1Damage',
        'tvCount', 'tvDamage', 'audioCount', 'audioDamage', 'hdmiCount', 'hdmiDamage', 'projectorCount', 'projectorDamage',
        'other2Details', 'other2Count', 'other2Damage',
        'fanCount', 'fanDamage', 'lightCount', 'lightDamage', 'airCount', 'airDamage',
        'swCount', 'swDamage', 'swfanCount', 'swfanDamage', 'plugCount', 'plugDamage',
        'other3Details', 'other3Count', 'other3Damage',
        'teach_id', 'term', 'pee'
    ];
    
    $insertData = [];
    foreach ($fields as $f) {
        // Convert empty strings to null, but keep all fields
        $insertData[$f] = isset($data[$f]) && $data[$f] !== '' ? $data[$f] : null;
    }

    // ใช้ TermPee หากไม่ได้ส่ง term/pee มา
    if (empty($insertData['term']) || empty($insertData['pee'])) {
        $termPee = \TermPee::getCurrent();
        $insertData['term'] = $termPee->term;
        $insertData['pee'] = $termPee->pee;
    }

    // Add missing status field
    $insertData['status'] = '0';

    $controller = new ReportRepairController();
    $success = $controller->create($insertData);

        // ดึงชื่อครูจาก DatabaseUsers
    $userDb = new \App\DatabaseUsers();
    $teacher = $userDb->getTeacherByUsername($data['teach_id']);
    $teacherName = $teacher ? $teacher['Teach_name'] : $data['teach_id'];


    // แจ้งเตือน Discord เมื่อบันทึกสำเร็จ
    if ($success) {
        $webhookUrl = 'https://discord.com/api/webhooks/1392374493686665226/_Sl9fYw2L193asCqZpxyJkw7ApioLhrPBlmImGwFvTY_L6I-kfvzK93W6yJqicbmlF09'; // เปลี่ยนเป็น Webhook URL ของคุณ
        $location = $insertData['AddLocation'] ?? '-';
        $date = $insertData['AddDate'] ?? '-';
        $teacher = $insertData['teach_id'] ?? '-';

        // รายการรายละเอียด (แสดงเฉพาะที่มีข้อมูล)
        $details = [];
        if (!empty($insertData['doorCount']) || !empty($insertData['doorDamage'])) {
            $details[] = "🚪 ประตู: {$insertData['doorCount']} | เสีย: {$insertData['doorDamage']}";
        }
        if (!empty($insertData['windowCount']) || !empty($insertData['windowDamage'])) {
            $details[] = "🪟 หน้าต่าง: {$insertData['windowCount']} | เสีย: {$insertData['windowDamage']}";
        }
        if (!empty($insertData['tablestCount']) || !empty($insertData['tablestDamage'])) {
            $details[] = "🪑 โต๊ะนักเรียน: {$insertData['tablestCount']} | เสีย: {$insertData['tablestDamage']}";
        }
        if (!empty($insertData['chairstCount']) || !empty($insertData['chairstDamage'])) {
            $details[] = "💺 เก้าอี้นักเรียน: {$insertData['chairstCount']} | เสีย: {$insertData['chairstDamage']}";
        }
        if (!empty($insertData['tabletaCount']) || !empty($insertData['tabletaDamage'])) {
            $details[] = "🧑‍💻 โต๊ะอาจารย์: {$insertData['tabletaCount']} | เสีย: {$insertData['tabletaDamage']}";
        }
        if (!empty($insertData['chairtaCount']) || !empty($insertData['chairtaDamage'])) {
            $details[] = "👨‍🏫 เก้าอี้อาจารย์: {$insertData['chairtaCount']} | เสีย: {$insertData['chairtaDamage']}";
        }
        if (!empty($insertData['other1Details']) || !empty($insertData['other1Count']) || !empty($insertData['other1Damage'])) {
            $details[] = "📝 อื่นๆ1: {$insertData['other1Details']} | จำนวน: {$insertData['other1Count']} | เสีย: {$insertData['other1Damage']}";
        }
        if (!empty($insertData['tvCount']) || !empty($insertData['tvDamage'])) {
            $details[] = "📺 ทีวี: {$insertData['tvCount']} | เสีย: {$insertData['tvDamage']}";
        }
        if (!empty($insertData['audioCount']) || !empty($insertData['audioDamage'])) {
            $details[] = "🔊 เครื่องเสียง: {$insertData['audioCount']} | เสีย: {$insertData['audioDamage']}";
        }
        if (!empty($insertData['hdmiCount']) || !empty($insertData['hdmiDamage'])) {
            $details[] = "🔌 HDMI: {$insertData['hdmiCount']} | เสีย: {$insertData['hdmiDamage']}";
        }
        if (!empty($insertData['projectorCount']) || !empty($insertData['projectorDamage'])) {
            $details[] = "📽️ โปรเจคเตอร์: {$insertData['projectorCount']} | เสีย: {$insertData['projectorDamage']}";
        }
        if (!empty($insertData['other2Details']) || !empty($insertData['other2Count']) || !empty($insertData['other2Damage'])) {
            $details[] = "📝 อื่นๆ2: {$insertData['other2Details']} | จำนวน: {$insertData['other2Count']} | เสีย: {$insertData['other2Damage']}";
        }
        if (!empty($insertData['fanCount']) || !empty($insertData['fanDamage'])) {
            $details[] = "🌀 พัดลม: {$insertData['fanCount']} | เสีย: {$insertData['fanDamage']}";
        }
        if (!empty($insertData['lightCount']) || !empty($insertData['lightDamage'])) {
            $details[] = "💡 ไฟ: {$insertData['lightCount']} | เสีย: {$insertData['lightDamage']}";
        }
        if (!empty($insertData['airCount']) || !empty($insertData['airDamage'])) {
            $details[] = "❄️ แอร์: {$insertData['airCount']} | เสีย: {$insertData['airDamage']}";
        }
        if (!empty($insertData['swCount']) || !empty($insertData['swDamage'])) {
            $details[] = "🔘 สวิตช์ไฟ: {$insertData['swCount']} | เสีย: {$insertData['swDamage']}";
        }
        if (!empty($insertData['swfanCount']) || !empty($insertData['swfanDamage'])) {
            $details[] = "🔘 สวิตช์พัดลม: {$insertData['swfanCount']} | เสีย: {$insertData['swfanDamage']}";
        }
        if (!empty($insertData['plugCount']) || !empty($insertData['plugDamage'])) {
            $details[] = "🔌 ปลั๊กไฟ: {$insertData['plugCount']} | เสีย: {$insertData['plugDamage']}";
        }
        if (!empty($insertData['other3Details']) || !empty($insertData['other3Count']) || !empty($insertData['other3Damage'])) {
            $details[] = "📝 อื่นๆ3: {$insertData['other3Details']} | จำนวน: {$insertData['other3Count']} | เสีย: {$insertData['other3Damage']}";
        }

        $msg = "📢 **แจ้งซ่อมใหม่!**\n"
            . "-----------------------------\n"
            . "🏫 **สถานที่:** {$location}\n"
            . "📅 **วันที่:** {$date}\n"
            . "👤 **ผู้แจ้ง:** {$teacherName}\n"
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

    echo json_encode(['success' => $success]);
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage(), 'debug' => array_keys($insertData ?? [])]);
}
