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

    // ลบการจอง
    $db = new App\DatabaseGeneral();
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
