<?php 
/**
 * Newsletter View Page - Public
 * Uses the new MVC layout with modern UI
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/classes/DatabaseGeneral.php';
require_once __DIR__ . '/models/Newsletter.php';
require_once __DIR__ . '/controllers/NewsletterController.php';

use Controllers\NewsletterController;

// Read configuration from JSON file
$config = json_decode(file_get_contents('config.json'), true);
$global = $config['global'];

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$id) {
    header('Location: news.php');
    exit;
}

$controller = new NewsletterController();
$news = $controller->getById($id);

// ตรวจสอบว่าข่าวมีอยู่
if (!$news) {
    header('Location: news.php');
    exit;
}

// เพิ่มจำนวนการอ่าน
$controller->incrementViews($id);

// ดึงชื่อครู
$teacher_name = '-';
if (!empty($news['create_by'])) {
    require_once __DIR__ . '/classes/DatabaseUsers.php';
    $userDb = new \App\DatabaseUsers();
    $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$news['create_by']])->fetch();
    if ($teacher && isset($teacher['Teach_name'])) {
        $teacher_name = $teacher['Teach_name'];
    }
}

$pageTitle = $news['title'] ?? 'ข่าวประชาสัมพันธ์';

// Shorten page title for very long titles (keep multibyte/Thai safe)
function shorten_title($text, $max = 30) {
    if (!is_string($text)) return $text;
    $text = trim(strip_tags($text));
    if (mb_strlen($text, 'UTF-8') <= $max) return $text;
    return mb_substr($text, 0, $max - 1, 'UTF-8') . '…';
}

$pageTitle = shorten_title($pageTitle, 30);

// Render view with layout
ob_start();
require 'views/news/view.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
