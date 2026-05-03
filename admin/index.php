<?php 
/**
 * Admin Dashboard - Main Entry Point
 * Replicates the modern MVC UI from the officer module
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

$username = $_SESSION['username'] ?? 'ผู้ใช้';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
$role = $_SESSION['role'] ?? 'admin';

// Set page title
$pageTitle = 'หน้าหลักผู้ดูแลระบบ';

// Load the view content
ob_start();
require 'views/home/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
