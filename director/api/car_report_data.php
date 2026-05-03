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

    $startDate = $_GET['startDate'] ?? '';
    $endDate = $_GET['endDate'] ?? '';
    $status = $_GET['status'] ?? 'all';

    $sql = "SELECT b.*, u.Teach_name as teacher_name, c.car_model as car_name, d.Teach_name as driver_name
            FROM car_bookings b
            LEFT JOIN phichaia_student.teacher u ON b.teacher_id = u.Teach_id
            LEFT JOIN cars c ON b.car_id = c.id
            LEFT JOIN phichaia_student.teacher d ON b.driver_id = d.Teach_id
            WHERE 1=1";

    $params = [];

    if ($startDate) {
        $sql .= " AND b.booking_date >= :start";
        $params['start'] = $startDate;
    }
    if ($endDate) {
        $sql .= " AND b.booking_date <= :end";
        $params['end'] = $endDate;
    }
    if ($status !== 'all') {
        $sql .= " AND b.status = :status";
        $params['status'] = $status;
    }

    $sql .= " ORDER BY b.booking_date DESC";

    $stmt = $db->query($sql, $params);
    $data = $stmt->fetchAll();

    $statusMap = [
        'approved' => 'อนุมัติแล้ว',
        'pending' => 'รอการอนุมัติ',
        'cancelled' => 'ยกเลิก',
        'rejected' => 'ปฏิเสธ'
    ];

    foreach ($data as &$item) {
        $item['status_th'] = $statusMap[$item['status']] ?? $item['status'];
        $item['booking_date'] = date('d/m/Y', strtotime($item['booking_date']));
        $item['teacher_name'] = $item['teacher_name'] ?? 'บุคลากร (ID: ' . $item['teacher_id'] . ')';
    }

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
