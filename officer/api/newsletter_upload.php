<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    // ตรวจสอบข้อมูลที่จำเป็น
    if (
        empty($_POST['title']) ||
        empty($_POST['news_date']) ||
        empty($_POST['detail']) ||
        empty($_FILES['images']) ||
        empty($_POST['create_by'])
    ) {
        echo json_encode(['success' => false, 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit;
    }

    $title = trim($_POST['title']);
    $news_date = trim($_POST['news_date']);
    $detail = trim($_POST['detail']);
    $create_by = trim($_POST['create_by']);
    $images = $_FILES['images'];

    // ตรวจสอบจำนวนไฟล์ภาพ
    if (!isset($images['name']) || count($images['name']) < 4 || count($images['name']) > 8) {
        echo json_encode(['success' => false, 'message' => 'กรุณาอัปโหลดรูปภาพ 4-8 รูป']);
        exit;
    }

    // อัปโหลดไฟล์ภาพ
    $uploadDir = '../../uploads/newsletter/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $imagePaths = [];
    for ($i = 0; $i < count($images['name']); $i++) {
        if ($images['error'][$i] !== UPLOAD_ERR_OK) continue;
        $ext = strtolower(pathinfo($images['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) continue;
        $newName = uniqid('news_', true) . '.' . $ext;
        $targetPath = $uploadDir . $newName;
        if (move_uploaded_file($images['tmp_name'][$i], $targetPath)) {
            $imagePaths[] = 'uploads/newsletter/' . $newName;
        }
    }

    if (count($imagePaths) < 4) {
        echo json_encode(['success' => false, 'message' => 'อัปโหลดรูปภาพไม่สำเร็จอย่างน้อย 4 รูป']);
        exit;
    }

    // บันทึกข้อมูลลงฐานข้อมูลผ่าน Controller
    $controller = new NewsletterController();
    $result = $controller->create([
        'title' => $title,
        'news_date' => $news_date,
        'detail' => $detail,
        'images' => json_encode($imagePaths),
        'create_by' => $create_by,
        'status' => 1 // เจ้าหน้าที่สร้างให้เป็นสถานะเผยแพร่เลย
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'บันทึกข้อมูลไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_upload.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
