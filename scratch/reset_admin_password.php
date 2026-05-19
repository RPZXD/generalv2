<?php
$host = "localhost";
$dbName = "phichaia_student";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $newHash = password_hash("123456", PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE teacher SET password = :hash WHERE Teach_id = '731'");
    $stmt->execute(['hash' => $newHash]);
    echo "Password reset successfully for Teach_id 731 to '123456'";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
