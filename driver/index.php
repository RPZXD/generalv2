<?php 
/**
 * Driver Dashboard - Index Page
 */
session_start();

// เช็ค session และ role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'คนขับรถ') {
    header('Location: ../login.php');
    exit;
}

// Read configuration from JSON file
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

require_once __DIR__ . '/../classes/DatabaseUsers.php';
use App\DatabaseUsers;

$dbUsers = new DatabaseUsers();

$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];

if ($teacher_id) {
    $TeacherData = $dbUsers->getTeacherById($teacher_id);
} else {
    $TeacherData = $dbUsers->getTeacherByUsername($_SESSION['username']);
}

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $TeacherData['Teach_name'] ?? $username;
$role = $_SESSION['role'] ?? 'คนขับรถ';

if (!$TeacherData) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}

$pageTitle = 'หน้าหลัก | คนขับรถ';

// Render view with layout
ob_start();
require 'views/home/index.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
