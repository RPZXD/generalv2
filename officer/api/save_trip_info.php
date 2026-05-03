<?php
session_start();
require_once '../../classes/DatabaseGeneral.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'กรุณาเข้าสู่ระบบ']);
    exit;
}

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

if ($input === null && !empty($_POST)) {
    $input = $_POST;
}

try {
    $id = $input['id'] ?? '';
    $fuel_project = $input['fuel_project'] ?? '';
    $fuel_cost = $input['fuel_cost'] ?? 0;
    $mileage_end = $input['mileage_end'] ?? 0;
    $agency_type = $input['agency_type'] ?? 'internal';
    $status = $input['status'] ?? 'completed';

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาระบุ ID การจอง']);
        exit;
    }

    $db = new App\DatabaseGeneral();
    
    $sql = "UPDATE car_bookings 
            SET fuel_project = ?, 
                fuel_cost = ?, 
                mileage_end = ?, 
                agency_type = ?, 
                status = ?, 
                updated_at = NOW() 
            WHERE id = ?";
    
    $params = [$fuel_project, $fuel_cost, $mileage_end, $agency_type, $status, $id];
    $stmt = $db->query($sql, $params);
    
    if ($stmt->rowCount() >= 0) { // rowCount might be 0 if no data changed but ID exists
        echo json_encode(['success' => true, 'message' => 'บันทึกข้อมูลการเดินทางเรียบร้อยแล้ว']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลการจอง']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
?>
