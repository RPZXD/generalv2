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
    if (!isset($images['name']) || count($images['name']) < 6 || count($images['name']) > 9) {
        echo json_encode(['success' => false, 'message' => 'กรุณาอัปโหลดรูปภาพ 6-9 รูป']);
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

    if (count($imagePaths) < 6) {
        echo json_encode(['success' => false, 'message' => 'อัปโหลดรูปภาพไม่สำเร็จอย่างน้อย 6 รูป']);
        exit;
    }

    // บันทึกข้อมูลลงฐานข้อมูลผ่าน Controller
    $controller = new NewsletterController();
    $result = $controller->create([
        'title' => $title,
        'news_date' => $news_date,
        'detail' => $detail,
        'images' => json_encode($imagePaths),
        'create_by' => $create_by
    ]);

            // ดึงชื่อครูจาก DatabaseUsers
    $userDb = new \App\DatabaseUsers();
    $teacher = $userDb->getTeacherByUsername($data['teach_id']);
    $teacherName = $teacher ? $teacher['Teach_name'] : $data['teach_id'];

    if ($result) {
        // แจ้งเตือน Discord
        $webhookUrl = 'https://discord.com/api/webhooks/1392376891129991209/p3LCdf5yzza9WZNnllylwlE5f7jpg82Q2rG2Ri2x2NiaR9T29VKd3IyRJ6AtFZ2RoJy0'; // เปลี่ยนเป็น Webhook URL ของคุณ

        $msg = "📰 **อัปโหลดจดหมายข่าวใหม่!**\n"
            . "-----------------------------\n"
            . "📌 **หัวข้อ:** {$title}\n"
            . "📅 **วันที่:** {$news_date}\n"
            . "📝 **รายละเอียด:** " . (mb_strlen($detail) > 200 ? mb_substr($detail, 0, 200) . '...' : $detail) . "\n"
            . "👤 **ผู้สร้าง:** {$teacherName}\n"
            . "🖼️ **จำนวนรูป:** " . count($imagePaths);

        $payload = json_encode(['content' => $msg]);

        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'บันทึกข้อมูลไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_upload.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
