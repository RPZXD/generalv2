<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$stmt = $db->query("SHOW DATABASES");
$rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($rows);
