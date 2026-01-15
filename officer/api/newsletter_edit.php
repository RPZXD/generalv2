<?php
session_start();

// ตรวจสอบการ login - เฉพาะเจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? intval($input['id']) : 0;
    $title = isset($input['title']) ? trim($input['title']) : '';
    $news_date = isset($input['news_date']) ? trim($input['news_date']) : null;
    $detail = isset($input['detail']) ? trim($input['detail']) : '';

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID ไม่ถูกต้อง']);
        exit;
    }
    
    if (empty($title)) {
        echo json_encode(['success' => false, 'message' => 'กรุณาระบุหัวข้อ']);
        exit;
    }

    $db = new \App\DatabaseGeneral();
    
    // ถ้ามี news_date ให้อัปเดตด้วย
    if ($news_date) {
        $sql = "UPDATE newsletters SET title = ?, news_date = ?, detail = ? WHERE id = ?";
        $stmt = $db->query($sql, [$title, $news_date, $detail, $id]);
    } else {
        // อัปเดตเฉพาะ title และ detail
        $sql = "UPDATE newsletters SET title = ?, detail = ? WHERE id = ?";
        $stmt = $db->query($sql, [$title, $detail, $id]);
    }

    if ($stmt) {
        echo json_encode(['success' => true, 'message' => 'บันทึกเรียบร้อย']);
    } else {
        echo json_encode(['success' => false, 'message' => 'บันทึกข้อมูลไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_edit.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
