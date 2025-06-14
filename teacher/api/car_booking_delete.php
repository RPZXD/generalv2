<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

// รับข้อมูล JSON
$input = json_decode(file_get_contents('php://input'), true);

try {
    $id = $input['id'] ?? '';

    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาระบุรหัสการจอง']);
        exit;
    }

    $db = new App\DatabaseGeneral();

    // ตรวจสอบสถานะก่อนลบ
    $sqlCheck = "SELECT status FROM car_bookings WHERE id = ?";
    $stmtCheck = $db->query($sqlCheck, [$id]);
    $row = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
        exit;
    }

    if ($row['status'] === 'approved') {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถลบการจองที่ได้รับการอนุมัติแล้วได้']);
        exit;
    }

    // ลบการจอง
    $sql = "DELETE FROM car_bookings WHERE id = ?";
    $params = [$id];

    $stmt = $db->query($sql, $params);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'ลบการจองเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
