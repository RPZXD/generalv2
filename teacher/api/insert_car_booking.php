<?php
require_once __DIR__ . '/../../controllers/CarBookingController.php';

use Controllers\CarBookingController;

header('Content-Type: application/json');

try {
    $data = $_POST;
    if (empty($data['date']) || empty($data['time']) || empty($data['car_type']) || empty($data['destination']) || empty($data['purpose'])) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน']);
        exit;
    }
    $controller = new CarBookingController();
    $result = $controller->create($data);
    echo json_encode($result);
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
