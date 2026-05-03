<?php
require_once 'classes/DatabaseUsers.php';
$db = new App\DatabaseUsers();
try {
    $stmt = $db->getPDO()->query("DESCRIBE teacher");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
