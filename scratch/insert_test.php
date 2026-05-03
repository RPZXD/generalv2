<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
$db = new \App\DatabaseGeneral();
$data = [
    'AddDate' => date('Y-m-d'), // Should be 2026-04-22
    'AddLocation' => 'Test Location',
    'teach_id' => '999',
    'term' => '1',
    'pee' => '2569',
    'status' => '0'
];
$sql = "INSERT INTO report_repair (AddDate, AddLocation, teach_id, term, pee, status) VALUES (:AddDate, :AddLocation, :teach_id, :term, :pee, :status)";
$stmt = $db->query($sql, $data);
echo json_encode(['success' => $stmt->rowCount() > 0]);
