<?php
require_once 'classes/DatabaseGeneral.php';
require_once 'classes/DatabaseUsers.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

try {
    $dbGeneral = new DatabaseGeneral();
    echo "--- Tables in phichaia_general ---\n";
    $stmt = $dbGeneral->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
        // Show columns for each table to find user-related ones
        $columns = $dbGeneral->query("DESCRIBE " . $row[0]);
        while ($col = $columns->fetch(PDO::FETCH_ASSOC)) {
            echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
        }
    }

    $dbUsers = new DatabaseUsers();
    echo "\n--- Tables in phichaia_student ---\n";
    $stmt = $dbUsers->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        if (in_array($row[0], ['teacher', 'student', 'termpee'])) {
            echo $row[0] . "\n";
            $columns = $dbUsers->query("DESCRIBE " . $row[0]);
            while ($col = $columns->fetch(PDO::FETCH_ASSOC)) {
                echo "  - " . $col['Field'] . " (" . $col['Type'] . ")\n";
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
