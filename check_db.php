<?php
require_once 'classes/DatabaseGeneral.php';
try {
    $db = new App\DatabaseGeneral();
    $stmt = $db->query("DESCRIBE car_bookings");
    $columns = $stmt->fetchAll();
    echo json_encode($columns, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
