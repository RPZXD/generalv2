<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Set page title
$pageTitle = 'บันทึกการใช้งานระบบ';

// Load the view content
ob_start();
require 'views/logs/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
