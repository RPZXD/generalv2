<?php
session_start();
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$car_model = trim($_POST['car_model'] ?? '');
$license_plate = trim($_POST['license_plate'] ?? '');
$car_type = trim($_POST['car_type'] ?? 'รถตู้');
$capacity = intval($_POST['capacity'] ?? 8);
$status = intval($_POST['status'] ?? 1);

if (empty($car_model) || empty($license_plate)) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อรถและทะเบียน']);
    exit;
}

try {
    $db = new \App\DatabaseGeneral();

    if ($id > 0) {
        // Update existing car
        $sql = "UPDATE cars SET 
                car_model = ?,
                license_plate = ?,
                car_type = ?,
                capacity = ?,
                status = ?,
                updated_at = NOW()
                WHERE id = ?";
        $db->query($sql, [$car_model, $license_plate, $car_type, $capacity, $status, $id]);
    } else {
        // Insert new car
        $sql = "INSERT INTO cars (car_model, license_plate, car_type, capacity, status, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $db->query($sql, [$car_model, $license_plate, $car_type, $capacity, $status]);
    }

    echo json_encode(['success' => true, 'message' => $id > 0 ? 'แก้ไขเรียบร้อย' : 'เพิ่มเรียบร้อย']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
