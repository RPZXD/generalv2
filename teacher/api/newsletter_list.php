<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    $create_by = isset($_GET['create_by']) ? $_GET['create_by'] : null;
    if (!$create_by) {
        echo json_encode(['list' => []]);
        exit;
    }

    $controller = new NewsletterController();
    // ดึงเฉพาะข่าวที่สร้างโดย create_by
    $list = $controller->getByCreateBy($create_by);

    echo json_encode(['list' => $list]);
} catch (\Throwable $e) {
    error_log("Error in newsletter_list.php: " . $e->getMessage());
    echo json_encode(['list' => [], 'error' => $e->getMessage()]);
}
