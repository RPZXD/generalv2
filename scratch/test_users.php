<?php
require_once __DIR__ . '/../classes/DatabaseUsers.php';
$db = new App\DatabaseUsers();
$pdo = $db->getTeacherByUsername('test'); // Dummy call to get connection or internal info if we want to write direct PDO

// Since DatabaseUsers probably has a PDO connection, let's inspect the class definition or write a PDO query.
// Let's run a direct query to see the database schema and users.
$host = "localhost";
$dbName = "phichaia_student";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT Teach_id, Teach_name, role_general, password FROM teacher WHERE role_general = 'ADM' LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
