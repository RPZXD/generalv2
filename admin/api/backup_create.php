<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../../classes/DatabaseGeneral.php';
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'phichaia_general',
    'user' => 'root',
    'pass' => ''
];

$backupDir = '../../backups/';
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$filename = 'backup_' . $dbConfig['dbname'] . '_' . date('Y-m-d_H-i-s') . '.sql';
$filePath = $backupDir . $filename;

// Use mysqldump if available
$command = "mysqldump --user={$dbConfig['user']} --password={$dbConfig['pass']} --host={$dbConfig['host']} {$dbConfig['dbname']} > {$filePath} 2>&1";

// For XAMPP, we might need the full path to mysqldump
$xamppPath = 'C:\xampp\mysql\bin\mysqldump.exe';
if (file_exists($xamppPath)) {
    $command = "\"{$xamppPath}\" --user={$dbConfig['user']} --password={$dbConfig['pass']} --host={$dbConfig['host']} {$dbConfig['dbname']} > {$filePath} 2>&1";
}

exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo json_encode(['success' => true, 'filename' => $filename]);
} else {
    // Fallback: Simple PHP backup if mysqldump fails
    // (In a real production environment, we'd implement a more robust PHP-based dumper if exec is disabled)
    echo json_encode([
        'success' => false, 
        'message' => 'เกิดข้อผิดพลาดในการสำรองข้อมูล (Error Code: ' . $returnVar . ')',
        'details' => $output
    ]);
}
