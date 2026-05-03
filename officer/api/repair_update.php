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

require_once '../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../classes/DatabaseUsers.php';
require_once __DIR__ . '/../../classes/NotificationHelper.php';

use Controllers\ReportRepairController;
use App\NotificationHelper;

$controller = new ReportRepairController();
$update = $controller->updateStatusById($data['id'], $data['status']);

if ($update) {
    $detail = $controller->getDetail($data['id']);
    $teacher = $detail['teach_id'] ?? '-';

    $statusText = [
        '0' => '🆕 รายการแจ้งใหม่',
        '1' => '⏳ รอพิจารณา/จัดสรรงบ',
        '2' => '🛠️ กำลังดำเนินการ',
        '3' => '🔍 ตรวจสอบ/ทดสอบ',
        '4' => '✅ ดำเนินการเสร็จสิ้น'
    ];
    $statusLabel = $statusText[$data['status']] ?? $data['status'];

    $userDb = new \App\DatabaseUsers();
    $teacherData = $userDb->getTeacherByUsername($teacher);
    $teacherName = $teacherData ? $teacherData['Teach_name'] : $teacher;

    $msg = "📢 *อัพเดทสถานะ (Repair Update)*\n"
        . "━━━━━━━━━━━━━━━━━━━━\n"
        . "🔢 *Ticket:* #{$data['id']}\n"
        . "📍 *สถานที่:* " . ($detail['AddLocation'] ?? '-') . "\n"
        . "👤 *ผู้แจ้ง:* {$teacherName}\n"
        . "━━━━━━━━━━━━━━━━━━━━\n"
        . "🚩 *สถานะล่าสุด:* {$statusLabel}\n"
        . "━━━━━━━━━━━━━━━━━━━━";

    NotificationHelper::sendRepairNotification($msg);
}

echo json_encode(['success' => $update]);
