<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../classes/DatabaseUsers.php';
require_once __DIR__ . '/../../models/TermPee.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

header('Content-Type: application/json');

$date = isset($_GET['date']) ? $_GET['date'] : null;
$location = isset($_GET['location']) ? $_GET['location'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;

try {
    $termPee = \TermPee::getCurrent();
    $term = $termPee->term;
    $pee = $termPee->pee;

    $db = new DatabaseGeneral();
    $userDb = new DatabaseUsers();
    
    // สร้าง SQL query พร้อม conditions - JOIN กับ meeting_rooms เพื่อดึง room details
    $sql = "SELECT rb.*, t.Teach_name as teacher_name,
                   m.room_name as room_name_from_db,
                   m.emoji as room_emoji,
                   m.color as room_color,
                   m.capacity as room_capacity,
                   m.building as room_building
            FROM bookings rb 
            LEFT JOIN phichaia_student.teacher t ON rb.teach_id = t.Teach_id 
            LEFT JOIN meeting_rooms m ON rb.room_id = m.id
            WHERE rb.term = ? AND rb.pee = ?";
    
    $params = [$term, $pee];
    
    if ($date) {
        $sql .= " AND rb.date = ?";
        $params[] = $date;
    }
    
    if ($location) {
        $sql .= " AND rb.location = ?";
        $params[] = $location;
    }
    
    if ($status !== null) {
        $sql .= " AND rb.status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY rb.date DESC, rb.time_start ASC";
    
    $stmt = $db->query($sql, $params);
    $list = $stmt->fetchAll();

    echo json_encode([
        'list' => $list,
        'term' => $term,
        'pee' => $pee
    ]);
} catch (Exception $e) {
    echo json_encode(['list' => [], 'error' => $e->getMessage()]);
}
