<?php
session_start();
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $db = new \App\DatabaseGeneral();

    // If specific ID requested
    if (isset($_GET['id']) && intval($_GET['id']) > 0) {
        $id = intval($_GET['id']);
        $stmt = $db->query("SELECT * FROM meeting_rooms WHERE id = ?", [$id]);
        $room = $stmt->fetch();
        echo json_encode(['success' => true, 'room' => $room]);
        exit;
    }

    // Get all rooms
    $stmt = $db->query("SELECT * FROM meeting_rooms ORDER BY room_name ASC");
    $rooms = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'rooms' => $rooms]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage(), 'rooms' => []]);
}
