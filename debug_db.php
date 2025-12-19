<?php
require_once 'config/DatabaseGeneral.php';
$db = new App\DatabaseGeneral();
$pdo = $db->getConnection();

echo "<pre>";

// 1. Check ID 0 count
$stmt = $pdo->query("SELECT COUNT(*) FROM car_bookings WHERE id = 0");
echo "Bookings with ID 0: " . $stmt->fetchColumn() . "\n\n";

// 2. Check Table Structure
echo "Table Structure:\n";
$stmt = $pdo->query("DESCRIBE car_bookings");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

// 3. Check table status (AUTO_INCREMENT value)
echo "\nTable Status:\n";
$stmt = $pdo->query("SHOW TABLE STATUS LIKE 'car_bookings'");
print_r($stmt->fetch(PDO::FETCH_ASSOC));
