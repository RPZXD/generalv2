<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Set page title
$pageTitle = 'สำรองข้อมูลระบบ';

// Load the view content
ob_start();
require 'views/backup/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
