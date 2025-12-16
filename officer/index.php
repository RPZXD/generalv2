<?php 
/**
 * Officer Dashboard - Main Entry Point
 * Uses the new MVC layout with modern UI
 */
session_start();

// เช็ค session และ role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}

// Read configuration from JSON file
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'เจ้าหน้าที่';

// Set page title
$pageTitle = 'หน้าหลัก';

// Load the view content
ob_start();
require 'views/home/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
