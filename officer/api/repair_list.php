<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}
require_once('../../controllers/ReportRepairController.php');
require_once('../../classes/DatabaseUsers.php');
use Controllers\ReportRepairController;
use App\DatabaseUsers;

$controller = new ReportRepairController();
$data = $controller->getAll();

// ดึงชื่อครูจาก teach_id
$userDb = new DatabaseUsers();
foreach ($data as &$item) {
    if (!empty($item['teach_id'])) {
        $teacher = $userDb->getTeacherById($item['teach_id']);
        if ($teacher) {
            $item['teacher_name'] = $teacher['Teach_name'] ?? null;
            $item['teacher_phone'] = $teacher['Teach_phone'] ?? null;
        } else {
            $item['teacher_name'] = null;
            $item['teacher_phone'] = null;
        }
    } else {
        $item['teacher_name'] = null;
        $item['teacher_phone'] = null;
    }
}
unset($item);

echo json_encode(['list' => $data]);
