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
    $status = $input['status'] ?? '';

    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($id) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาระบุข้อมูลให้ครบถ้วน']);
        exit;
    }

    // ตรวจสอบสถานะที่ถูกต้อง
    $validStatuses = ['pending', 'approved', 'rejected', 'completed'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'สถานะไม่ถูกต้อง']);
        exit;
    }

    // อัปเดตสถานะ
    $db = new App\DatabaseGeneral();
    $sql = "UPDATE car_bookings SET status = ?, updated_at = NOW() WHERE id = ?";
    $params = [$status, $id];

    $stmt = $db->query($sql, $params);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'อัปเดตสถานะเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
