<?php 
session_start();
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || ($_SESSION['role'] !== 'ผู้บริหาร' && $_SESSION['role'] !== 'director' && $_SESSION['role'] !== 'DIR')) {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'director';
$pageTitle = 'สรุปรายงานการใช้รถยนต์';

ob_start();
require 'views/car_report/summary.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
