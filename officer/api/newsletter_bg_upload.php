<?php
/**
 * Newsletter Background Upload API
 * สำหรับอัปโหลดรูป background ของ newsletter export
 */
session_start();

// ตรวจสอบการ login - เฉพาะเจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ไม่มีสิทธิ์เข้าถึง']);
    exit;
}

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method not allowed');
    }

    if (!isset($_FILES['background']) || $_FILES['background']['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'ไฟล์ใหญ่เกินที่ระบบกำหนด',
            UPLOAD_ERR_FORM_SIZE => 'ไฟล์ใหญ่เกินไป',
            UPLOAD_ERR_PARTIAL => 'อัปโหลดไฟล์ไม่สมบูรณ์',
            UPLOAD_ERR_NO_FILE => 'ไม่พบไฟล์',
            UPLOAD_ERR_NO_TMP_DIR => 'ไม่พบโฟลเดอร์ temp',
            UPLOAD_ERR_CANT_WRITE => 'ไม่สามารถเขียนไฟล์ได้',
        ];
        $errorCode = isset($_FILES['background']) ? $_FILES['background']['error'] : UPLOAD_ERR_NO_FILE;
        $errorMsg = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'เกิดข้อผิดพลาดในการอัปโหลด';
        throw new Exception($errorMsg);
    }

    $file = $_FILES['background'];
    
    // ตรวจสอบประเภทไฟล์
    $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        throw new Exception('ประเภทไฟล์ไม่ถูกต้อง รองรับเฉพาะ PNG, JPG, WEBP');
    }
    
    // ตรวจสอบขนาดไฟล์ (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('ไฟล์มีขนาดใหญ่เกินไป (สูงสุด 5MB)');
    }
    
    // กำหนด path - ใช้ uploads/newsletter/ เพราะควรมี write permission
    $uploadDir = __DIR__ . '/../../uploads/newsletter/';
    
    // สร้างโฟลเดอร์ถ้าไม่มี
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception('ไม่สามารถสร้างโฟลเดอร์อัปโหลดได้');
        }
    }
    
    // ตรวจสอบว่าสามารถเขียนได้
    if (!is_writable($uploadDir)) {
        // พยายาม chmod
        @chmod($uploadDir, 0777);
        if (!is_writable($uploadDir)) {
            throw new Exception('โฟลเดอร์ไม่สามารถเขียนได้: ' . $uploadDir);
        }
    }
    
    // ใช้ชื่อไฟล์คงที่เพื่อให้ง่ายต่อการอ้างอิง
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if ($extension === 'jpeg') $extension = 'jpg';
    $filename = 'newsletter_bg_custom.' . $extension;
    $targetPath = $uploadDir . $filename;
    
    // ลบไฟล์เก่าถ้ามี (ต่าง extension)
    $oldFiles = glob($uploadDir . 'newsletter_bg_custom.*');
    foreach ($oldFiles as $oldFile) {
        @unlink($oldFile);
    }
    
    // ย้ายไฟล์
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('ไม่สามารถบันทึกไฟล์ได้ (move_uploaded_file failed)');
    }
    
    // ตรวจสอบว่าไฟล์ถูกบันทึกจริง
    if (!file_exists($targetPath)) {
        throw new Exception('ไฟล์ไม่ถูกบันทึก');
    }
    
    // บันทึก path ใน settings
    $settingsFile = __DIR__ . '/../../newsletter_settings.json';
    $settings = [];
    if (file_exists($settingsFile)) {
        $settings = json_decode(file_get_contents($settingsFile), true) ?: [];
    }
    
    // บันทึก path สัมพัทธ์จาก officer folder
    $relativePath = '../uploads/newsletter/' . $filename;
    $settings['customBackgroundImage'] = $relativePath;
    $settings['useCustomBackground'] = true;
    
    if (!file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        throw new Exception('ไม่สามารถบันทึกการตั้งค่าได้');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'อัปโหลดสำเร็จ',
        'path' => $relativePath,
        'filename' => $filename
    ]);
    
} catch (Exception $e) {
    error_log('Newsletter BG Upload Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
