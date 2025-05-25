<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'forbidden']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'missing id']);
    exit;
}
require_once('../../controllers/ReportRepairController.php');
use Controllers\ReportRepairController;

$controller = new ReportRepairController();
// เรียกผ่านเมธอดใหม่ใน model
$success = $controller->model->deleteById($data['id']);
echo json_encode(['success' => $success]);
