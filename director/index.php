<?php
session_start();

// Check if user is logged in and has the director role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || ($_SESSION['role'] !== 'ผู้บริหาร' && $_SESSION['role'] !== 'director' && $_SESSION['role'] !== 'DIR')) {
    header('Location: ../login.php');
    exit;
}

$pageTitle = 'แผงบริหารผู้บริหาร';
$username = $_SESSION['username'] ?? 'ผู้บริหาร';
$role = $_SESSION['role'] ?? 'director';

// Load the view content
ob_start();
require 'views/home/index.php';
$content = ob_get_clean();

// Render with the main layout
require 'views/layouts/app.php';
