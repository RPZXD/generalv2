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
    // เจ้าหน้าที่สามารถลบได้ทุกสถานะ
    $newsletter = $controller->getById($id);
    if (!$newsletter) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูล']);
        exit;
    }

    // ลบไฟล์รูปภาพ
    if (!empty($newsletter['images'])) {
        try {
            $images = json_decode($newsletter['images'], true);
            if (is_array($images)) {
                foreach ($images as $imagePath) {
                    $fullPath = __DIR__ . '/../../' . $imagePath;
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
        } catch (\Exception $e) {
            // ไม่ต้องหยุดการลบถ้าลบไฟล์ไม่ได้
            error_log("Error deleting image files: " . $e->getMessage());
        }
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
