<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$backupDir = '../../backups/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$files = scandir($backupDir);
$list = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    
    $filePath = $backupDir . $file;
    if (is_file($filePath)) {
        $stat = stat($filePath);
        $list[] = [
            'name' => $file,
            'date' => date('Y-m-d H:i:s', $stat['mtime']),
            'size' => formatSizeUnits($stat['size']),
            'type' => pathinfo($file, PATHINFO_EXTENSION) === 'sql' ? 'database' : 'other'
        ];
    }
}

// Sort by date descending
usort($list, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

echo json_encode(['success' => true, 'list' => $list]);

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}
