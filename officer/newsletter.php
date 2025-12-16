<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'เจ้าหน้าที่';
$pageTitle = 'จดหมายข่าว';

ob_start();
require 'views/newsletter/index.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
