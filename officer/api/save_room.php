<?php
session_start();
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$room_name = trim($_POST['room_name'] ?? '');
$emoji = trim($_POST['emoji'] ?? '🏢');
$color = trim($_POST['color'] ?? 'blue');
$capacity = intval($_POST['capacity'] ?? 50);
$building = trim($_POST['building'] ?? '');
$equipment = trim($_POST['equipment'] ?? '');
$status = intval($_POST['status'] ?? 1);

if (empty($room_name)) {
    echo json_encode(['success' => false, 'message' => 'กรุณากรอกชื่อห้องประชุม']);
    exit;
}

try {
    $db = new \App\DatabaseGeneral();

    if ($id > 0) {
        // Update existing room
        $sql = "UPDATE meeting_rooms SET 
                room_name = ?,
                emoji = ?,
                color = ?,
                capacity = ?,
                building = ?,
                equipment = ?,
                status = ?,
                updated_at = NOW()
                WHERE id = ?";
        $db->query($sql, [$room_name, $emoji, $color, $capacity, $building, $equipment, $status, $id]);
    } else {
        // Insert new room
        $sql = "INSERT INTO meeting_rooms (room_name, emoji, color, capacity, building, equipment, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $db->query($sql, [$room_name, $emoji, $color, $capacity, $building, $equipment, $status]);
    }

    echo json_encode(['success' => true, 'message' => $id > 0 ? 'แก้ไขเรียบร้อย' : 'เพิ่มเรียบร้อย']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
