<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SELECT id, AddDate FROM report_repair ORDER BY id DESC LIMIT 5");
$rows = $stmt->fetchAll();
file_put_contents(__DIR__ . '/debug_dates.txt', print_r($rows, true));
echo "Done";
