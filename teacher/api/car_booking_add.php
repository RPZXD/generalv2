<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';
require_once '../../classes/DatabaseUsers.php';

use App\DatabaseUsers;

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

try {
    // รับข้อมูลจาก POST
    $teacher_id = $_POST['teacher_id'] ?? '';
    $car_id = $_POST['car_id'] ?? '';
    $start_datetime = $_POST['start_datetime'] ?? '';
    $end_datetime = $_POST['end_datetime'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $passenger_count = $_POST['passenger_count'] ?? '';
    $student_count = $_POST['student_count'] ?? 0;
    $passengers_detail = $_POST['passengers_detail'] ?? '';
    $teacher_name = $_POST['teacher_name'] ?? '';
    $teacher_position = $_POST['teacher_position'] ?? '';
    $teacher_phone = $_POST['teacher_phone'] ?? '';
    $notes = $_POST['notes'] ?? '';

    // แปลงวันเวลา
    $booking_date = '';
    $start_time = '';
    $end_time = '';
    if ($start_datetime && $end_datetime) {
        $start_dt = date_create($start_datetime);
        $end_dt = date_create($end_datetime);
        $booking_date = $start_dt ? $start_dt->format('Y-m-d') : '';
        $start_time = $start_dt ? $start_dt->format('Y-m-d H:i:s') : '';
        $end_time = $end_dt ? $end_dt->format('Y-m-d H:i:s') : '';
    }

    // ตรวจสอบข้อมูลที่จำเป็น
    if (
        empty($teacher_id) || empty($car_id) || empty($booking_date) ||
        empty($start_time) || empty($end_time) || empty($destination) ||
        empty($purpose) || $passenger_count === ''
    ) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit;
    }

    // ตรวจสอบความถูกต้องของข้อมูล
    if (!is_numeric($passenger_count) || $passenger_count < 1) {
        echo json_encode(['success' => false, 'message' => 'จำนวนผู้โดยสารไม่ถูกต้อง']);
        exit;
    }

    // ตรวจสอบว่าเวลาเริ่มต้นน้อยกว่าเวลาสิ้นสุด
    if ($start_time >= $end_time) {
        echo json_encode(['success' => false, 'message' => 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด']);
        exit;
    }

    $db = new App\DatabaseGeneral();

    // ตรวจสอบว่ารถว่างในช่วงเวลาที่ต้องการ
    $checkSql = "SELECT COUNT(*) as count FROM car_bookings 
                 WHERE car_id = ? 
                 AND status NOT IN ('rejected', 'completed')
                 AND (
                     (booking_date = ? AND start_time < ? AND end_time > ?) OR
                     (booking_date = ? AND start_time < ? AND end_time > ?) OR
                     (booking_date = ? AND start_time >= ? AND start_time < ?)
                 )";
    $checkParams = [
        $car_id,
        $booking_date, $end_time, $start_time,
        $booking_date, $end_time, $start_time,
        $booking_date, $start_time, $end_time
    ];
    $checkStmt = $db->query($checkSql, $checkParams);
    $conflictCount = $checkStmt->fetch()['count'];

    if ($conflictCount > 0) {
        echo json_encode(['success' => false, 'message' => 'รถยนต์ไม่ว่างในช่วงเวลาที่เลือก']);
        exit;
    }

    // เพิ่มข้อมูลการจอง
    $sql = "INSERT INTO car_bookings 
            (teacher_id, car_id, booking_date, start_time, end_time, 
             destination, purpose, passenger_count, student_count,
             passengers_detail, teacher_name, teacher_position, 
             teacher_phone, notes, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), NOW())";

    $params = [
        $teacher_id, $car_id, $booking_date, $start_time, $end_time,
        $destination, $purpose, $passenger_count, $student_count,
        $passengers_detail, $teacher_name, $teacher_position,
        $teacher_phone, $notes
    ];

    $stmt = $db->query($sql, $params);

    // ฟังก์ชันแปลงวันเวลาเป็นภาษาไทย
    function thaiDatetime($datetime) {
        if (!$datetime) return '-';
        $months = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $dt = new DateTime($datetime);
        $day = $dt->format('j');
        $month = $months[(int)$dt->format('n')];
        $year = $dt->format('Y') + 543;
        $time = $dt->format('H:i');
        return "{$day} {$month} {$year} เวลา {$time} น.";
    }

    // ดึงชื่อครูจาก DatabaseUsers
    $userDb = new DatabaseUsers();
    $teacher = $userDb->getTeacherByUsername($teacher_id);
    $teacherName = $teacher ? $teacher['Teach_name'] : $teacher_id;

    // ดึงข้อมูลรถ
    $carInfo = null;
    $carSql = "SELECT car_model, license_plate, car_type, capacity FROM cars WHERE id = ?";
    $carStmt = $db->query($carSql, [$car_id]);
    if ($carStmt) {
        $carInfo = $carStmt->fetch(\PDO::FETCH_ASSOC);
    }
    $carDesc = $carInfo
        ? "{$carInfo['car_model']} ({$carInfo['license_plate']}) | {$carInfo['car_type']} | {$carInfo['capacity']} ที่นั่ง"
        : $car_id;

    if ($stmt && $stmt->rowCount() > 0) {
        /*
        // ปิดการแจ้งเตือนทันที เพื่อเปลี่ยนเป็นแบบสรุปรอบเวลา (05.00 และ 18.00 น.)
        // แจ้งเตือน Discord
        require_once '../../classes/SystemSettings.php';
        $sysSettings = new App\SystemSettings();
        $dbSettings = $sysSettings->getAll();

        $config = json_decode(file_get_contents('../../config.json'), true);
        $webhookUrl = $dbSettings['car_discord_webhook'] ?? '';
        $isEnabled = $config['notifications']['car_discord_enabled'] ?? false;

        if ($isEnabled && !empty($webhookUrl)) {
            $msg = "-----------------------------\n"
                . " มีการจองรถใหม่!\n"
                . "-----------------------------\n"
                . " ผู้จอง: {$teacherName} ({$teacher_position})\n"
                . " เบอร์โทร: {$teacher_phone}\n"
                . " รหัสผู้จอง: {$teacher_id}\n"
                . " รถ: {$carDesc}\n"
                . " วันที่เดินทาง: " . thaiDatetime($start_time) . "\n"
                . " สิ้นสุดการเดินทาง: " . thaiDatetime($end_time) . "\n"
                . " ปลายทาง: {$destination}\n"
                . " วัตถุประสงค์: {$purpose}\n"
                . " จำนวนผู้โดยสาร: {$passenger_count}\n"
                . " นักเรียน: {$student_count}\n"
                . " รายละเอียดผู้โดยสาร: {$passengers_detail}\n"
                . " หมายเหตุ: {$notes}\n"
                . "-----------------------------";

            $payload = json_encode(['content' => $msg]);

            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $ch_close = curl_close($ch);
        }

        // แจ้งเตือน Line
        $lineToken = $dbSettings['car_line_token'] ?? '';
        $isLineEnabled = $config['notifications']['line_enabled'] ?? false;

        if ($isLineEnabled && !empty($lineToken)) {
            $ch = curl_init('https://notify-api.line.me/api/notify');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['message' => "\n" . $msg]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $lineToken
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }

        // แจ้งเตือน Telegram
        $tgToken = $dbSettings['telegram_bot_token'] ?? '';
        $tgChatId = $dbSettings['telegram_chat_id'] ?? '';
        $isTgEnabled = $config['notifications']['telegram_enabled'] ?? false;

        if ($isTgEnabled && !empty($tgToken) && !empty($tgChatId)) {
            $tgUrl = "https://api.telegram.org/bot{$tgToken}/sendMessage";
            $ch = curl_init($tgUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'chat_id' => $tgChatId,
                'text' => $msg
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
        */

        echo json_encode(['success' => true, 'message' => 'บันทึกการจองเรียบร้อยแล้ว']);
    } else {
        // เพิ่ม error log
        $errorInfo = $stmt ? $stmt->errorInfo() : [];
        echo json_encode([
            'success' => false,
            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
            'error' => $errorInfo
        ]);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
