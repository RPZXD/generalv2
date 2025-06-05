<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? $input['id'] : null;

    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลที่ต้องการลบ']);
        exit;
    }

    $controller = new NewsletterController();
    // ตรวจสอบสถานะก่อนลบ (อนุญาตลบเฉพาะ status = 0)
    $newsletter = $controller->getById($id);
    if (!$newsletter) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
        exit;
    }
    if (!isset($newsletter['status']) || $newsletter['status'] != 0) {
        echo json_encode(['success' => false, 'message' => 'สามารถลบได้เฉพาะจดหมายข่าวที่เป็นฉบับร่างเท่านั้น']);
        exit;
    }

    // ลบ record
    $result = $controller->delete($id);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ลบข้อมูลไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_delete.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
