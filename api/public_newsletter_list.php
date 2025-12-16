<?php
/**
 * Public Newsletter List API
 * ดึงข่าวสาธารณะที่เผยแพร่แล้ว - ไม่ต้อง login
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../classes/DatabaseUsers.php';
require_once __DIR__ . '/../models/Newsletter.php';
require_once __DIR__ . '/../controllers/NewsletterController.php';

use Controllers\NewsletterController;
use App\DatabaseUsers;

try {
    $controller = new NewsletterController();
    
    // ดึงเฉพาะข่าวที่เผยแพร่แล้ว
    $list = $controller->getPublished();

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

    echo json_encode(['list' => $list, 'success' => true]);
} catch (\Throwable $e) {
    error_log("Error in api/public_newsletter_list.php: " . $e->getMessage());
    echo json_encode(['list' => [], 'success' => false, 'error' => $e->getMessage()]);
}
