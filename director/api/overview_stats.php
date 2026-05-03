<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'ผู้บริหาร' && $_SESSION['role'] !== 'director' && $_SESSION['role'] !== 'DIR')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../../classes/DatabaseGeneral.php';

try {
    $db = new \App\DatabaseGeneral();
    
    // 1. Approved car bookings for today
    $today = date('Y-m-d');
    $carTodaySql = "SELECT COUNT(*) as total FROM car_bookings WHERE status = 'approved' AND DATE(booking_date) = :today";
    $stmt = $db->query($carTodaySql, ['today' => $today]);
    $carsToday = $stmt->fetch()['total'];

    // 2. Pending repairs
    $repairPendingSql = "SELECT COUNT(*) as total FROM repair_reports WHERE status = 'pending'";
    $repairPending = $db->query($repairPendingSql)->fetch()['total'];

    // 3. Meeting room use this week
    $startOfWeek = date('Y-m-d', strtotime('monday this week'));
    $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
    $meetingWeekSql = "SELECT COUNT(*) as total FROM meeting_bookings WHERE status = 'approved' AND booking_date BETWEEN :start AND :end";
    $stmt = $db->query($meetingWeekSql, ['start' => $startOfWeek, 'end' => $endOfWeek]);
    $meetingsWeek = $stmt->fetch()['total'];

    // 4. Recent bookings list
    $recentSql = "SELECT b.*, u.Teach_name as teacher_name 
                  FROM car_bookings b 
                  LEFT JOIN phichaia_student.teacher u ON b.teacher_id = u.Teach_id
                  WHERE b.status = 'approved' 
                  ORDER BY b.created_at DESC 
                  LIMIT 5";
    // Adjusting for DatabaseGeneral which might not have cross-db link easily if not configured, 
    // but in this project it seems they use same server.
    // However, I'll use a simpler query if teacher_all is not accessible directly.
    $recentBookings = $db->query($recentSql)->fetchAll();
    
    // Format dates and names for UI
    foreach ($recentBookings as &$b) {
        $b['teacher_name'] = $b['teacher_name'] ?? 'บุคลากร'; // Fallback if join failed
        $b['booking_date'] = date('d/m/Y', strtotime($b['booking_date']));
    }

    echo json_encode([
        'success' => true,
        'stats' => [
            'cars_today' => $carsToday,
            'repair_pending' => $repairPending,
            'meetings_week' => $meetingsWeek
        ],
        'recent_bookings' => $recentBookings
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
