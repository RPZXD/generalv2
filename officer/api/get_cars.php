<?php
session_start();
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $db = new \App\DatabaseGeneral();

    // If specific ID requested
    if (isset($_GET['id']) && intval($_GET['id']) > 0) {
        $id = intval($_GET['id']);
        $stmt = $db->query("SELECT * FROM cars WHERE id = ?", [$id]);
        $car = $stmt->fetch();
        echo json_encode(['success' => true, 'car' => $car]);
        exit;
    }

    // Get all cars
    $stmt = $db->query("SELECT * FROM cars ORDER BY car_model ASC");
    $cars = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'cars' => $cars]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage(), 'cars' => []]);
}
