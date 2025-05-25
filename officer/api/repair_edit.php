ึ<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'forbidden']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['id']) || !isset($data['AddLocation'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'missing data']);
    exit;
}
require_once('../../controllers/ReportRepairController.php');
use Controllers\ReportRepairController;

$controller = new ReportRepairController();
$sql = "UPDATE report_repair SET AddLocation = :AddLocation, other1Details = :other1Details WHERE id = :id";
$params = [
    'AddLocation' => $data['AddLocation'],
    'other1Details' => isset($data['other1Details']) ? $data['other1Details'] : '',
    'id' => $data['id']
];
$result = $controller->model->db->query($sql, $params);
echo json_encode(['success' => $result->rowCount() > 0]);
