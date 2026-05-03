<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$startDate = '2026-03-31';
$endDate = '2026-04-22';
$params = ['start' => $startDate, 'end' => $endDate];
$sql = "SELECT r.* FROM report_repair r WHERE AddDate BETWEEN :start AND :end";
$stmt = $db->query($sql, $params);
$rows = $stmt->fetchAll();
file_put_contents(__DIR__ . '/debug_query.txt', "Rows found: " . count($rows) . "\n" . print_r($rows, true));
echo "Done";
