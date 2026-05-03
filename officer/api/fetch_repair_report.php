<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'forbidden']);
    exit;
}

require_once '../../models/ReportRepair.php';
use Models\ReportRepair;

$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;
$status = $_GET['status'] ?? null;

if (!$startDate || !$endDate) {
    echo json_encode(['success' => false, 'error' => 'missing dates']);
    exit;
}

try {
    $model = new ReportRepair();
    $list = $model->getFilteredReport($startDate, $endDate, $status);
    echo json_encode([
        'success' => true, 
        'list' => $list,
        'debug' => [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'count' => count($list)
        ]
    ]);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
