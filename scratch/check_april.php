<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SELECT COUNT(*) as total FROM report_repair WHERE AddDate >= '2026-04-01'");
$row = $stmt->fetch();
header('Content-Type: application/json');
echo json_encode($row, JSON_PRETTY_PRINT);
