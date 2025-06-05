<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? $input['id'] : null;
    $title = isset($input['title']) ? trim($input['title']) : '';
    $news_date = isset($input['news_date']) ? trim($input['news_date']) : '';
    $detail = isset($input['detail']) ? trim($input['detail']) : '';

    if (!$id || !$title || !$news_date || !$detail) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit;
    }

    $controller = new NewsletterController();
    $result = $controller->update([
        'id' => $id,
        'title' => $title,
        'news_date' => $news_date,
        'detail' => $detail
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'บันทึกข้อมูลไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_edit.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
