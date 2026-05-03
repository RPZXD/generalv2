<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SELECT id, AddDate, AddLocation, teach_id, status FROM report_repair ORDER BY id DESC LIMIT 10");
$rows = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($rows, JSON_PRETTY_PRINT);
