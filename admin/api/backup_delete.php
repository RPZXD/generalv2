<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$filename = $_POST['filename'] ?? '';
if (empty($filename)) {
    echo json_encode(['success' => false, 'message' => 'Filename is required']);
    exit;
}

// Security check: prevent directory traversal
$filename = basename($filename);
$filePath = '../../backups/' . $filename;

if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not delete file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'File not found']);
}
