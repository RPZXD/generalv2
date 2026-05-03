<?php
require_once __DIR__ . '/../classes/DatabaseUsers.php';
$db = new \App\DatabaseUsers();
$stmt = $db->query("DESCRIBE teacher");
$rows = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($rows, JSON_PRETTY_PRINT);
