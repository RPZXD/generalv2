<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

require_once __DIR__ . '/../classes/SystemSettings.php';
$sysSettings = new App\SystemSettings();
$dbSettings = $sysSettings->getAll();

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'เจ้าหน้าที่';
$pageTitle = 'ตั้งค่าระบบ';

ob_start();
require 'views/settings/index.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
