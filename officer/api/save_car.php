<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

// Check authentication
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    require_once('../../controllers/CarController.php');
    
    $carController = new CarController();
    
    // Get form data
    $data = [
        'car_id' => $_POST['car_id'] ?? null,
        'car_model' => trim($_POST['car_model'] ?? ''),
        'license_plate' => trim($_POST['license_plate'] ?? ''),
        'car_type' => $_POST['car_type'] ?? '',
        'capacity' => $_POST['capacity'] ?? null,
        'status' => $_POST['status'] ?? 1
    ];
    
    $result = $carController->saveCar($data);
    
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาดในเซิร์ฟเวอร์: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
