<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/ReportRepair.php';
require_once __DIR__ . '/../../controllers/ReportRepairController.php';
require_once __DIR__ . '/../../models/TermPee.php';

use Controllers\ReportRepairController;

header('Content-Type: application/json');

try {
    $data = $_POST;
    // ตรวจสอบและแปลงค่าที่จำเป็น
    $fields = [
        'AddDate', 'AddLocation',
        'doorCount', 'doorDamage', 'windowCount', 'windowDamage', 'tablestCount', 'tablestDamage',
        'chairstCount', 'chairstDamage', 'tabletaCount', 'tabletaDamage', 'chairtaCount', 'chairtaDamage',
        'other1Details', 'other1Count', 'other1Damage',
        'tvCount', 'tvDamage', 'audioCount', 'audioDamage', 'hdmiCount', 'hdmiDamage', 'projectorCount', 'projectorDamage',
        'other2Details', 'other2Count', 'other2Damage',
        'fanCount', 'fanDamage', 'lightCount', 'lightDamage', 'airCount', 'airDamage',
        'swCount', 'swDamage', 'swfanCount', 'swfanDamage', 'plugCount', 'plugDamage',
        'other3Details', 'other3Count', 'other3Damage',
        'teach_id', 'term', 'pee'
    ];
    
    $insertData = [];
    foreach ($fields as $f) {
        // Convert empty strings to null, but keep all fields
        $insertData[$f] = isset($data[$f]) && $data[$f] !== '' ? $data[$f] : null;
    }

    // ใช้ TermPee หากไม่ได้ส่ง term/pee มา
    if (empty($insertData['term']) || empty($insertData['pee'])) {
        $termPee = \TermPee::getCurrent();
        $insertData['term'] = $termPee->term;
        $insertData['pee'] = $termPee->pee;
    }

    // Add missing status field
    $insertData['status'] = 'รอดำเนินการ';

    $controller = new ReportRepairController();
    $success = $controller->create($insertData);

    echo json_encode(['success' => $success]);
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage(), 'debug' => array_keys($insertData ?? [])]);
}
