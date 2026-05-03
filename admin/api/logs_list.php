<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once '../../classes/DatabaseGeneral.php';
$db = new App\DatabaseGeneral();

// Create table if not exists
$createTableSql = "CREATE TABLE IF NOT EXISTS system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255),
    user_role VARCHAR(50),
    action TEXT,
    module VARCHAR(100),
    type VARCHAR(50),
    ip_address VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
$db->query($createTableSql);

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

// Count total
$countSql = "SELECT COUNT(*) as total FROM system_logs";
$countStmt = $db->query($countSql);
$totalRecords = $countStmt->fetch()['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch logs
$sql = "SELECT * FROM system_logs ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $db->getPDO()->prepare($sql);
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format for view
$list = array_map(function($log) {
    // Get initials
    $names = explode(' ', $log['user_name']);
    $initials = '';
    if (count($names) >= 2) {
        $initials = mb_substr($names[0], 0, 1) . mb_substr($names[1], 0, 1);
    } else {
        $initials = mb_substr($log['user_name'], 0, 2);
    }
    
    $log['user_initials'] = mb_strtoupper($initials);
    return $log;
}, $logs);

echo json_encode([
    'success' => true,
    'list' => $list,
    'total_records' => $totalRecords,
    'total_pages' => $totalPages,
    'current_page' => $page
]);
