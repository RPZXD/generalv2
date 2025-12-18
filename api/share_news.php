<?php
/**
 * API for incrementing share count
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../models/Newsletter.php';
require_once __DIR__ . '/../controllers/NewsletterController.php';

use Controllers\NewsletterController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? intval($input['id']) : 0;

    if ($id > 0) {
        $controller = new NewsletterController();
        $success = $controller->incrementShares($id);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Share count incremented']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to increment share count']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
