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
    $dbGeneral = new App\DatabaseGeneral();
    $dbUsers = new App\DatabaseUsers();

    $month = $_GET['month'] ?? date('m');
    $year = $_GET['year'] ?? date('Y');

    // ดึงข้อมูลการจองที่ approved ในเดือนที่เลือก
    $sql = "SELECT cb.*, 
                   c.car_model, c.license_plate, c.car_type, c.capacity
            FROM car_bookings cb
            LEFT JOIN cars c ON cb.car_id = c.id
            WHERE cb.status = 'approved'
            AND MONTH(cb.booking_date) = ?
            AND YEAR(cb.booking_date) = ?
            ORDER BY cb.booking_date ASC, cb.start_time ASC";

    $stmt = $dbGeneral->query($sql, [$month, $year]);
    $bookings = $stmt->fetchAll();

    // ดึงข้อมูลรถยนต์ทั้งหมด
    $carsSql = "SELECT * FROM cars ORDER BY id ASC";
    $carsStmt = $dbGeneral->query($carsSql);
    $cars = $carsStmt->fetchAll();

    // เติมข้อมูลครูและคนขับ
    foreach ($bookings as &$booking) {
        // ข้อมูลครู
        if ($booking['teacher_id']) {
            $teacher = $dbUsers->getTeacherById($booking['teacher_id']);
            if ($teacher) {
                $booking['teacher_name'] = $teacher['Teach_name'];
                $booking['teacher_position'] = $teacher['Teach_Position2'] ?? '';
                $booking['teacher_phone'] = $teacher['Teach_phone'] ?? '';
                $booking['teacher_department'] = $teacher['Teach_Department'] ?? '';
            } else {
                $booking['teacher_name'] = 'ไม่พบข้อมูล';
                $booking['teacher_position'] = '';
                $booking['teacher_phone'] = '';
                $booking['teacher_department'] = '';
            }
        } else {
            $booking['teacher_name'] = '-';
            $booking['teacher_position'] = '';
            $booking['teacher_phone'] = '';
            $booking['teacher_department'] = '';
        }

        // ข้อมูลคนขับ
        if (!empty($booking['driver_id'])) {
            $driver = $dbUsers->getTeacherById($booking['driver_id']);
            $booking['driver_name'] = $driver ? $driver['Teach_name'] : '-';
        } else {
            $booking['driver_name'] = '-';
        }

        // Parse student_count & passenger_count
        $booking['student_count'] = intval($booking['student_count'] ?? 0);
        $booking['passenger_count'] = intval($booking['passenger_count'] ?? 0);
        // คำนวณจำนวนครู (ผู้โดยสาร - นักเรียน)
        $booking['teacher_count'] = max(0, $booking['passenger_count'] - $booking['student_count']);
    }
    unset($booking);

    // สร้างสถิติสรุปต่อรถ
    $carStats = [];
    foreach ($cars as $car) {
        $carBookings = array_filter($bookings, function($b) use ($car) {
            return $b['car_id'] == $car['id'];
        });

        $totalTrips = count($carBookings);
        $totalTeachers = 0;
        $totalStudents = 0;

        foreach ($carBookings as $b) {
            $totalTeachers += $b['teacher_count'];
            $totalStudents += $b['student_count'];
        }

        $carStats[] = [
            'car_id' => $car['id'],
            'car_type' => $car['car_type'] ?? '',
            'car_model' => $car['car_model'],
            'license_plate' => $car['license_plate'],
            'total_trips' => $totalTrips,
            'total_teachers' => $totalTeachers,
            'total_students' => $totalStudents
        ];
    }

    echo json_encode([
        'success' => true,
        'bookings' => $bookings,
        'cars' => $cars,
        'car_stats' => $carStats,
        'month' => intval($month),
        'year' => intval($year)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
?>
