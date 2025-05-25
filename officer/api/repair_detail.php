<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['error' => 'forbidden']);
    exit;
}
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'missing id']);
    exit;
}
require_once('../../controllers/ReportRepairController.php');
use Controllers\ReportRepairController;

$controller = new ReportRepairController();
$data = $controller->getDetail($_GET['id']);
echo json_encode($data);
