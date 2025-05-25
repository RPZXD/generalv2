<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\ReportRepairController;

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
    exit;
}

$controller = new ReportRepairController();
$report = $controller->getDetail($id);

if ($report) {
    echo json_encode(['success' => true, 'report' => $report]);
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
}
