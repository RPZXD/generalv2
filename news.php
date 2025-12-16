<?php 
/**
 * News/Newsletter Page - Public
 * Uses the new MVC layout with modern UI
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Read configuration from JSON file
$config = json_decode(file_get_contents('config.json'), true);
$global = $config['global'];

$pageTitle = 'ข่าวประชาสัมพันธ์';

// Render view with layout
ob_start();
require 'views/news/index.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
