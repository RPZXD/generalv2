<?php
require_once __DIR__ . '/../../controllers/CarBookingController.php';

use Controllers\CarBookingController;

header('Content-Type: application/json');

$teach_id = $_GET['teach_id'] ?? '';
if (!$teach_id) {
    echo json_encode(['list' => []]);
    exit;
}
$controller = new CarBookingController();
$list = $controller->getByTeacher($teach_id);
echo json_encode(['list' => $list]);
