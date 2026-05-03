<?php
require_once 'classes/DatabaseGeneral.php';
try {
    $db = new App\DatabaseGeneral();
    
    // Check if driver_id exists, if not add it
    $stmt = $db->query("DESCRIBE car_bookings");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $queries = [];
    if (!in_array('driver_id', $columns)) {
        $queries[] = "ALTER TABLE car_bookings ADD COLUMN driver_id varchar(50) DEFAULT NULL AFTER teacher_id";
    }
    if (!in_array('fuel_project', $columns)) {
        $queries[] = "ALTER TABLE car_bookings ADD COLUMN fuel_project varchar(255) DEFAULT NULL";
    }
    if (!in_array('fuel_cost', $columns)) {
        $queries[] = "ALTER TABLE car_bookings ADD COLUMN fuel_cost decimal(10,2) DEFAULT NULL";
    }
    if (!in_array('mileage_end', $columns)) {
        $queries[] = "ALTER TABLE car_bookings ADD COLUMN mileage_end int(11) DEFAULT NULL";
    }
    if (!in_array('agency_type', $columns)) {
        $queries[] = "ALTER TABLE car_bookings ADD COLUMN agency_type varchar(100) DEFAULT NULL";
    }

    foreach ($queries as $q) {
        $db->query($q);
        echo "Executed: $q\n";
    }
    
    echo "Database check and update completed.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
