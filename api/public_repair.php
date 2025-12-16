<?php
/**
 * Public Repair Report API
 * ดึงข้อมูลการแจ้งซ่อมสาธารณะ - ไม่ต้อง login
 */
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../classes/DatabaseUsers.php';

use App\DatabaseGeneral;
use App\DatabaseUsers;

/**
 * Mask ชื่อสำหรับความเป็นส่วนตัว
 */
function maskName($fullName) {
    if (empty($fullName)) return null;
    
    $fullName = trim($fullName);
    $prefixes = ['นางสาว', 'ว่าที่ร้อยตรี', 'นาง', 'นาย', 'ดร.', 'Mr.', 'Mrs.', 'Miss'];
    $foundPrefix = '';
    $nameWithoutPrefix = $fullName;
    
    foreach ($prefixes as $p) {
        if (mb_strpos($fullName, $p, 0, 'UTF-8') === 0) {
            $foundPrefix = $p;
            $nameWithoutPrefix = trim(mb_substr($fullName, mb_strlen($p, 'UTF-8'), null, 'UTF-8'));
            break;
        }
    }
    
    $nameParts = preg_split('/\s+/', $nameWithoutPrefix);
    if (!empty($nameParts[0])) {
        $firstName = mb_substr($nameParts[0], 0, 2, 'UTF-8');
        return $foundPrefix . ' ' . $firstName . 'xxx';
    } else {
        return mb_substr($fullName, 0, 4, 'UTF-8') . 'xxx';
    }
}

/**
 * สรุปรายการที่ต้องซ่อม
 */
function summarizeDamages($item) {
    $damages = [];
    
    // อาคารสถานที่
    $building = [
        'door' => 'ประตู',
        'window' => 'หน้าต่าง',
        'tablest' => 'โต๊ะนักเรียน',
        'chairst' => 'เก้าอี้นักเรียน',
        'tableta' => 'โต๊ะครู',
        'chairta' => 'เก้าอี้ครู'
    ];
    
    // โสตทัศนูปกรณ์
    $media = [
        'tv' => 'โทรทัศน์',
        'audio' => 'เครื่องเสียง',
        'hdmi' => 'สาย HDMI',
        'projector' => 'โปรเจคเตอร์'
    ];
    
    // ไฟฟ้า
    $electric = [
        'fan' => 'พัดลม',
        'light' => 'หลอดไฟ',
        'air' => 'แอร์',
        'sw' => 'สวิตช์ไฟ',
        'swfan' => 'สวิตช์พัดลม',
        'plug' => 'ปลั๊กไฟ'
    ];
    
    foreach ($building as $key => $name) {
        $count = $item[$key . 'Count'] ?? 0;
        $damage = $item[$key . 'Damage'] ?? '';
        if ($count > 0 && !empty($damage)) {
            $damages[] = ['name' => $name, 'count' => $count, 'damage' => $damage, 'category' => 'อาคารสถานที่'];
        }
    }
    
    foreach ($media as $key => $name) {
        $count = $item[$key . 'Count'] ?? 0;
        $damage = $item[$key . 'Damage'] ?? '';
        if ($count > 0 && !empty($damage)) {
            $damages[] = ['name' => $name, 'count' => $count, 'damage' => $damage, 'category' => 'โสตทัศนูปกรณ์'];
        }
    }
    
    foreach ($electric as $key => $name) {
        $count = $item[$key . 'Count'] ?? 0;
        $damage = $item[$key . 'Damage'] ?? '';
        if ($count > 0 && !empty($damage)) {
            $damages[] = ['name' => $name, 'count' => $count, 'damage' => $damage, 'category' => 'ระบบไฟฟ้า'];
        }
    }
    
    // อื่นๆ
    if (!empty($item['other1Details']) && ($item['other1Count'] ?? 0) > 0) {
        $damages[] = ['name' => $item['other1Details'], 'count' => $item['other1Count'], 'damage' => $item['other1Damage'] ?? '', 'category' => 'อาคารสถานที่'];
    }
    if (!empty($item['other2Details']) && ($item['other2Count'] ?? 0) > 0) {
        $damages[] = ['name' => $item['other2Details'], 'count' => $item['other2Count'], 'damage' => $item['other2Damage'] ?? '', 'category' => 'โสตทัศนูปกรณ์'];
    }
    if (!empty($item['other3Details']) && ($item['other3Count'] ?? 0) > 0) {
        $damages[] = ['name' => $item['other3Details'], 'count' => $item['other3Count'], 'damage' => $item['other3Damage'] ?? '', 'category' => 'ระบบไฟฟ้า'];
    }
    
    return $damages;
}

try {
    $db = DatabaseGeneral::getInstance();
    $userDb = new DatabaseUsers();
    
    // รับ parameter
    $month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
    $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    
    // สร้าง query
    $sql = "SELECT * FROM report_repair WHERE MONTH(AddDate) = ? AND YEAR(AddDate) = ?";
    $params = [$month, $year];
    
    if ($status !== null && $status !== '') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY AddDate DESC, id DESC";
    
    $repairs = $db->query($sql, $params)->fetchAll();
    
    // จัดการข้อมูล
    foreach ($repairs as &$item) {
        // Mask ชื่อผู้แจ้ง
        $item['teacher_name_masked'] = null;
        if (!empty($item['teach_id'])) {
            $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$item['teach_id']])->fetch();
            if ($teacher && !empty($teacher['Teach_name'])) {
                $item['teacher_name_masked'] = maskName($teacher['Teach_name']);
            }
        }
        
        // สรุปรายการซ่อม
        $item['damages_summary'] = summarizeDamages($item);
        $item['total_items'] = count($item['damages_summary']);
        
        // แปลง status เป็นข้อความ
        $statusInt = intval($item['status']);
        $item['status_text'] = match($statusInt) {
            0 => 'รอดำเนินการ',
            1 => 'กำลังดำเนินการ',
            2 => 'เสร็จสิ้น',
            default => 'ไม่ทราบสถานะ'
        };
        $item['status_color'] = match($statusInt) {
            0 => 'amber',
            1 => 'blue',
            2 => 'green',
            default => 'gray'
        };
        
        // ลบข้อมูลส่วนตัว
        unset($item['teach_id']);
        
        // ลบข้อมูลดิบ (เก็บเฉพาะ summary)
        $fieldsToRemove = [
            'doorCount', 'doorDamage', 'windowCount', 'windowDamage',
            'tablestCount', 'tablestDamage', 'chairstCount', 'chairstDamage',
            'tabletaCount', 'tabletaDamage', 'chairtaCount', 'chairtaDamage',
            'other1Details', 'other1Count', 'other1Damage',
            'tvCount', 'tvDamage', 'audioCount', 'audioDamage',
            'hdmiCount', 'hdmiDamage', 'projectorCount', 'projectorDamage',
            'other2Details', 'other2Count', 'other2Damage',
            'fanCount', 'fanDamage', 'lightCount', 'lightDamage',
            'airCount', 'airDamage', 'swCount', 'swDamage',
            'swfanCount', 'swfanDamage', 'plugCount', 'plugDamage',
            'other3Details', 'other3Count', 'other3Damage'
        ];
        foreach ($fieldsToRemove as $field) {
            unset($item[$field]);
        }
    }
    unset($item);
    
    // สถิติ
    $stats = [
        'total' => count($repairs),
        'pending' => count(array_filter($repairs, fn($r) => intval($r['status']) === 0)),
        'in_progress' => count(array_filter($repairs, fn($r) => intval($r['status']) === 1)),
        'completed' => count(array_filter($repairs, fn($r) => intval($r['status']) === 2)),
    ];
    
    echo json_encode([
        'success' => true,
        'repairs' => $repairs,
        'stats' => $stats,
        'month' => $month,
        'year' => $year
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}
