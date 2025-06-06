<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\ReportRepairController;

header('Content-Type: application/json');

try {
    $data = $_POST;
    
    // ตรวจสอบว่ามี id และข้อมูลที่จำเป็น
    if (!isset($data['id']) || empty($data['id'])) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบ ID ของรายการ']);
        exit;
    }

    // ตรวจสอบ session
    session_start();
    $user = $_SESSION['user'];
    $teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];
    
    if (!$teacher_id) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลครู']);
        exit;
    }

    // เตรียมข้อมูลสำหรับการอัปเดต
    $fields = [
        'AddDate', 'AddLocation',
        'doorCount', 'doorDamage', 'windowCount', 'windowDamage', 'tablestCount', 'tablestDamage',
        'chairstCount', 'chairstDamage', 'tabletaCount', 'tabletaDamage', 'chairtaCount', 'chairtaDamage',
        'other1Details', 'other1Count', 'other1Damage',
        'tvCount', 'tvDamage', 'audioCount', 'audioDamage', 'hdmiCount', 'hdmiDamage', 'projectorCount', 'projectorDamage',
        'other2Details', 'other2Count', 'other2Damage',
        'fanCount', 'fanDamage', 'lightCount', 'lightDamage', 'airCount', 'airDamage',
        'swCount', 'swDamage', 'swfanCount', 'swfanDamage', 'plugCount', 'plugDamage',
        'other3Details', 'other3Count', 'other3Damage'
    ];
    
    // Define numeric fields that should be converted to NULL if empty
    $numericFields = [
        'doorCount', 'windowCount', 'tablestCount', 'chairstCount', 'tabletaCount', 'chairtaCount',
        'other1Count', 'tvCount', 'audioCount', 'hdmiCount', 'projectorCount', 'other2Count',
        'fanCount', 'lightCount', 'airCount', 'swCount', 'swfanCount', 'plugCount', 'other3Count'
    ];
    
    $updateData = ['id' => $data['id']];
    foreach ($fields as $field) {
        $value = isset($data[$field]) ? $data[$field] : null;
        
        // Convert empty strings to NULL for numeric fields
        if (in_array($field, $numericFields) && $value === '') {
            $value = null;
        }
        
        $updateData[$field] = $value;
    }

    $controller = new ReportRepairController();
    $success = $controller->update($updateData, $teacher_id);

    echo json_encode(['success' => $success]);
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
