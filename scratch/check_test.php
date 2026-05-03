<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SELECT * FROM report_repair WHERE teach_id = '999'");
$row = $stmt->fetch();
header('Content-Type: application/json');
echo json_encode($row, JSON_PRETTY_PRINT);
