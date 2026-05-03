<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../../classes/DatabaseGeneral.php';
require_once '../../classes/DatabaseUsers.php';

try {
    $dbGen = new \App\DatabaseGeneral();
    $dbUsers = new \App\DatabaseUsers();

    // 1. Total Users
    $userCountSql = "SELECT COUNT(*) as total FROM teacher WHERE Teach_status = '1'";
    $userCount = $dbUsers->query($userCountSql)->fetch()['total'];

    // 2. Database Size
    $dbSizeSql = "SELECT SUM(data_length + index_length) / 1024 / 1024 AS size_mb 
                  FROM information_schema.TABLES 
                  WHERE table_schema = 'phichaia_general'";
    $dbSize = $dbGen->query($dbSizeSql)->fetch()['size_mb'];

    // 3. Backup Count
    $backupDir = '../../backups/';
    $backupCount = 0;
    if (file_exists($backupDir)) {
        $files = scandir($backupDir);
        foreach ($files as $file) {
            if (is_file($backupDir . $file)) $backupCount++;
        }
    }

    // 4. Recent Logs
    $logsSql = "SELECT * FROM system_logs ORDER BY created_at DESC LIMIT 5";
    $logs = $dbGen->query($logsSql)->fetchAll();

    echo json_encode([
        'success' => true,
        'stats' => [
            'total_users' => $userCount,
            'db_size' => round($dbSize, 2) . ' MB',
            'backup_count' => $backupCount,
            'recent_logs' => $logs
        ]
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
