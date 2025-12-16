<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../controllers/BookingController.php';
use Controllers\BookingController;

header('Content-Type: application/json');

// รับข้อมูลทั้ง JSON และ POST
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    $data = $_POST;
}

$id = $data['id'] ?? null;
$status = $data['status'] ?? null;

if (!$id || !in_array($status, ['0', '1', '2', 0, 1, 2], true)) {
    echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ถูกต้อง']);
    exit;
}

$controller = new BookingController();
$result = $controller->updateStatus($id, $status);

echo json_encode($result);
