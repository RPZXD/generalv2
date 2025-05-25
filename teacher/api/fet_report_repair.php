<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\ReportRepairController;

header('Content-Type: application/json');

$teach_id = isset($_GET['Teach_id']) ? $_GET['Teach_id'] : null;

if (!$teach_id) {
    echo json_encode([]);
    exit;
}

$termPee = \TermPee::getCurrent();
$term = $termPee->term;
$pee = $termPee->pee;

$controller = new ReportRepairController();
// ส่ง term, pee ไปที่ listByTeacher
$list = $controller->model->listByTeacher($teach_id, $term, $pee);

echo json_encode([
    'list' => $list,
    'term' => $term,
    'pee' => $pee
]);
