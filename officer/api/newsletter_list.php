<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../classes/DatabaseUsers.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;
use App\DatabaseUsers;

header('Content-Type: application/json');

try {
    $controller = new NewsletterController();
    $list = $controller->getAll();

    // ดึงชื่อครูจาก create_by
    $userDb = new DatabaseUsers();
    foreach ($list as &$item) {
        $teacher_name = null;
        if (!empty($item['create_by'])) {
            $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$item['create_by']])->fetch();
            if ($teacher && isset($teacher['Teach_name'])) {
                $teacher_name = $teacher['Teach_name'];
            }
        }
        $item['teacher_name'] = $teacher_name;
    }

    echo json_encode(['list' => $list]);
} catch (\Throwable $e) {
    error_log("Error in officer/api/newsletter_list.php: " . $e->getMessage());
    echo json_encode(['list' => [], 'error' => $e->getMessage()]);
}
