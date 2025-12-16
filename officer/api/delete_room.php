<?php
session_start();
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid room ID']);
    exit;
}

try {
    $db = new \App\DatabaseGeneral();
    $db->query("DELETE FROM meeting_rooms WHERE id = ?", [$id]);

    echo json_encode(['success' => true, 'message' => 'ลบห้องประชุมเรียบร้อย']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
