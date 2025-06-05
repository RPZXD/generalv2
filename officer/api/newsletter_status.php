<?php
require_once __DIR__ . '/../../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../../models/Newsletter.php';
require_once __DIR__ . '/../../controllers/NewsletterController.php';

use Controllers\NewsletterController;

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = isset($input['id']) ? $input['id'] : null;
    $status = isset($input['status']) ? $input['status'] : null;

    if (!$id || !in_array($status, ['0', '1', '2', 0, 1, 2], true)) {
        echo json_encode(['success' => false, 'message' => 'ข้อมูลไม่ถูกต้อง']);
        exit;
    }

    $controller = new NewsletterController();

    // ถ้าเปลี่ยนเป็นเผยแพร่ (1) ให้กำหนดเลขฉบับของปีนั้นๆ
    if ($status == 1 || $status === '1') {
        // ดึงปีของข่าว
        $newsletter = $controller->getById($id);
        if (!$newsletter) {
            echo json_encode(['success' => false, 'message' => 'ไม่พบข้อมูลข่าว']);
            exit;
        }
        $year = substr($newsletter['news_date'], 0, 4);

        // หาฉบับล่าสุดของปีนี้ (เฉพาะที่เผยแพร่แล้ว)
        $db = new \App\DatabaseGeneral();
        $sql = "SELECT MAX(issue_no) as max_issue FROM newsletters WHERE YEAR(news_date) = ? AND status = 1";
        $stmt = $db->query($sql, [$year]);
        $row = $stmt->fetch();
        $next_issue = ($row && $row['max_issue']) ? intval($row['max_issue']) + 1 : 1;

        // อัปเดต status และ issue_no
        $result = $controller->updateStatusAndIssue($id, $status, $next_issue);

        if ($result) {
            echo json_encode(['success' => true, 'issue_no' => $next_issue]);
        } else {
            echo json_encode(['success' => false, 'message' => 'อัปเดตสถานะ/ฉบับที่ ไม่สำเร็จ']);
        }
        exit;
    }

    // กรณีอื่น อัปเดตเฉพาะ status
    $result = $controller->updateStatus($id, $status);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'อัปเดตสถานะไม่สำเร็จ']);
    }
} catch (\Throwable $e) {
    error_log("Error in newsletter_status.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
