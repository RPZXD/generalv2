<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';
require_once '../../classes/DatabaseUsers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    $startDate = $_GET['start_date'] ?? date('Y-m-01');
    $endDate = $_GET['end_date'] ?? date('Y-m-t');
    $carId = $_GET['car_id'] ?? '';

    $dbGeneral = new App\DatabaseGeneral();
    $dbUsers = new App\DatabaseUsers();

    // Fetch fiscal year from termpee table
    $fiscalYearStmt = $dbUsers->query("SELECT pee FROM termpee LIMIT 1");
    $fiscalYearData = $fiscalYearStmt->fetch();
    $dbFiscalYear = $fiscalYearData ? $fiscalYearData['pee'] : '';


    // 1. Fetch detailed bookings
    $sql = "SELECT cb.*, c.car_model, c.license_plate, c.car_type, c.capacity
            FROM car_bookings cb
            LEFT JOIN cars c ON cb.car_id = c.id
            WHERE cb.booking_date BETWEEN ? AND ?";
    
    $params = [$startDate, $endDate];
    if (!empty($carId)) {
        $sql .= " AND cb.car_id = ?";
        $params[] = $carId;
    }
    $sql .= " ORDER BY cb.booking_date ASC, cb.start_time ASC";

    $stmt = $dbGeneral->query($sql, $params);
    $bookings = $stmt->fetchAll();

    // Enrich with teacher and driver names
    foreach ($bookings as &$booking) {
        if ($booking['teacher_id']) {
            $t = $dbUsers->getTeacherById($booking['teacher_id']);
            $booking['requester_name'] = $t ? $t['Teach_name'] : $booking['teacher_name'];
        } else {
            $booking['requester_name'] = $booking['teacher_name'] ?? '-';
        }

        if ($booking['driver_id']) {
            $d = $dbUsers->getTeacherById($booking['driver_id']);
            $booking['driver_name_full'] = $d ? $d['Teach_name'] : '-';
        } else {
            $booking['driver_name_full'] = '-';
        }
    }
    unset($booking);

    // 2. Fetch aggregated data per car
    $aggSql = "SELECT c.id as car_id, c.car_model, c.license_plate, c.car_type,
                      COUNT(cb.id) as trip_count,
                      SUM(CASE WHEN cb.agency_type = 'internal' THEN (cb.passenger_count - cb.student_count) ELSE 0 END) as internal_teacher_sum,
                      SUM(CASE WHEN cb.agency_type = 'internal' THEN cb.student_count ELSE 0 END) as internal_student_sum,
                      SUM(CASE WHEN cb.agency_type = 'external' THEN (cb.passenger_count - cb.student_count) ELSE 0 END) as external_teacher_sum,
                      SUM(CASE WHEN cb.agency_type = 'external' THEN cb.student_count ELSE 0 END) as external_student_sum,
                      SUM(cb.passenger_count) as total_passengers_sum
               FROM cars c
               LEFT JOIN car_bookings cb ON c.id = cb.car_id AND cb.booking_date BETWEEN ? AND ?
               WHERE c.status = 1";
    
    $aggParams = [$startDate, $endDate];
    if (!empty($carId)) {
        $aggSql .= " AND c.id = ?";
        $aggParams[] = $carId;
    }
    $aggSql .= " GROUP BY c.id ORDER BY c.id ASC";

    $aggStmt = $dbGeneral->query($aggSql, $aggParams);
    $summary = $aggStmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => [
            'bookings' => $bookings,
            'summary' => $summary,
            'db_fiscal_year' => $dbFiscalYear,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'car_id' => $carId
            ]
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
