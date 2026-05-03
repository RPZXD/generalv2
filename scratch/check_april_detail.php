<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SELECT id, AddDate, teach_id FROM report_repair WHERE AddDate >= '2026-04-01'");
$rows = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($rows, JSON_PRETTY_PRINT);
