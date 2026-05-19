<?php 
/**
 * System Settings - Entry Point
 */
session_start();

// Check session and role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Read configuration from JSON file
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

// Load database settings
require_once __DIR__ . '/../classes/SystemSettings.php';
$sysSettingsObj = new App\SystemSettings();
$dbSettings = $sysSettingsObj->getAll();

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'admin';

// Set page title
$pageTitle = 'ตั้งค่าระบบ';

// Load the view content
ob_start();
require 'views/settings/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
