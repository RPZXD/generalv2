<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';
header('Content-Type: application/json');
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}
try {
    $db = new App\DatabaseGeneral();
    $sql = "SELECT * FROM cars WHERE status = 1 ORDER BY car_model";
    $stmt = $db->query($sql);
    $cars = $stmt->fetchAll();
    echo json_encode([
        'success' => true,
        'cars' => $cars
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
