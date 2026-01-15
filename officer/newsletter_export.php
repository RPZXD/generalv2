<?php
/**
 * Newsletter Export Page - สำหรับเจ้าหน้าที่เท่านั้น
 * ต้อง login ก่อนใช้งาน
 */
session_start();

// ตรวจสอบการ login - เฉพาะเจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../models/Newsletter.php';
require_once __DIR__ . '/../controllers/NewsletterController.php';

use Controllers\NewsletterController;

// Settings Persistence logic
$settingsFile = __DIR__ . '/../newsletter_settings.json';
$defaultSettings = [
    'contentMarginTop' => 238,
    'titleMarginLeft' => 10,
    'titleMarginBottom' => 1,
    'titleColor' => '#000000',
    'showIssueNo' => false,
    'issueX' => 180,
    'issueY' => 180,
    'issueFontSize' => 16,
    'issueColor' => '#000000',
    'titleFontSize' => 18,
    'contentFontSize' => 16,
    'customBackgroundImage' => '',
    'useCustomBackground' => false
];

// Load settings
$settings = $defaultSettings;
if (file_exists($settingsFile)) {
    $savedSettings = json_decode(file_get_contents($settingsFile), true);
    if (is_array($savedSettings)) {
        $settings = array_merge($defaultSettings, $savedSettings);
    }
}

// Handle Save Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_settings') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        if (file_put_contents($settingsFile, json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to write file']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo "ไม่พบข้อมูล";
    exit;
}

$controller = new NewsletterController();
$news = $controller->getById($id);

if (!$news) {
    echo "ไม่พบข้อมูล";
    exit;
}

// ดึงชื่อครู
$teacher_name = '-';
if (!empty($news['create_by'])) {
    require_once __DIR__ . '/../classes/DatabaseUsers.php';
    $userDb = new \App\DatabaseUsers();
    $teacher = $userDb->query("SELECT Teach_name FROM teacher WHERE Teach_id = ?", [$news['create_by']])->fetch();
    if ($teacher && isset($teacher['Teach_name'])) {
        $teacher_name = $teacher['Teach_name'];
    }
}

// รูปภาพ
$images = [];
try { $images = json_decode($news['images'], true); } catch (\Throwable $e) {}
if (!is_array($images)) $images = [];

$school = '';
$config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);
if (isset($config['global']['nameschool'])) {
    $school = $config['global']['nameschool'];
}

// ฉบับที่
$issue_no = isset($news['issue_no']) && $news['issue_no'] ? $news['issue_no'] : '-';
// ปี
$year = isset($news['news_date']) ? (date('Y', strtotime($news['news_date'])) + 543) : '';

function thai_date_short($date_str) {
    $months = [
        "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
        "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
    ];
    $time = strtotime($date_str);
    $day = date('j', $time); // ไม่มี 0 นำหน้า
    $month = $months[(int)date('n', $time)];
    $year = date('Y', $time) + 543;
    return "$day $month $year";
}

$date = isset($news['news_date']) ? thai_date_short($news['news_date']) : '';


// เลือกโทนสี
$theme = isset($_GET['theme']) ? $_GET['theme'] : 'red-yellow';

// Settings Persistence logic
$settingsFile = __DIR__ . '/../newsletter_settings.json';
$defaultSettings = [
    'contentMarginTop' => 238,
    'titleMarginLeft' => 10,
    'titleMarginBottom' => 1,
    'titleColor' => '#000000',
    'showIssueNo' => false,
    'issueX' => 180,
    'issueY' => 180,
    'issueFontSize' => 16,
    'issueColor' => '#000000',
    'titleFontSize' => 18,
    'contentFontSize' => 16
];

// Load settings
$settings = $defaultSettings;
if (file_exists($settingsFile)) {
    $savedSettings = json_decode(file_get_contents($settingsFile), true);
    if (is_array($savedSettings)) {
        $settings = array_merge($defaultSettings, $savedSettings);
    }
}

// Handle Save Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_settings') {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        if (file_put_contents($settingsFile, json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to write file']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จดหมายข่าว | ฉบับที่ <?php echo $issue_no; ?> | หัวเรื่อง <?php echo htmlspecialchars($news['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            <?php if ($theme === 'sunday-red'): ?>
            --primary-start: #dc2626;
            --primary-mid: #ef4444;
            --primary-end: #f87171;
            --accent-light: #fecaca;
            --accent-bg: #fef2f2;
            --text-primary: #dc2626;
            --border-color: rgba(220, 38, 38, 0.15);
            --badge-text: #dc2626;
            <?php elseif ($theme === 'monday-yellow'): ?>
            --primary-start: #ca8a04;
            --primary-mid: #eab308;
            --primary-end: #facc15;
            --accent-light: #fef3c7;
            --accent-bg: #fffbeb;
            --text-primary: #ca8a04;
            --border-color: rgba(234, 179, 8, 0.15);
            --badge-text: #ca8a04;
            <?php elseif ($theme === 'tuesday-pink'): ?>
            --primary-start: #be185d;
            --primary-mid: #ec4899;
            --primary-end: #f472b6;
            --accent-light: #fce7f3;
            --accent-bg: #fdf2f8;
            --text-primary: #be185d;
            --border-color: rgba(236, 72, 153, 0.15);
            --badge-text: #be185d;
            <?php elseif ($theme === 'wednesday-green'): ?>
            --primary-start: #14532d;
            --primary-mid: #16a34a;
            --primary-end: #22c55e;
            --accent-light: #dcfce7;
            --accent-bg: #f0fdf4;
            --text-primary: #14532d;
            --border-color: rgba(34, 197, 94, 0.15);
            --badge-text: #14532d;
            <?php elseif ($theme === 'thursday-orange'): ?>
            --primary-start: #c2410c;
            --primary-mid: #ea580c;
            --primary-end: #fb923c;
            --accent-light: #fed7aa;
            --accent-bg: #fff7ed;
            --text-primary: #c2410c;
            --border-color: rgba(234, 88, 12, 0.15);
            --badge-text: #c2410c;
            <?php elseif ($theme === 'friday-blue'): ?>
            --primary-start: #1e3a8a;
            --primary-mid: #3b82f6;
            --primary-end: #60a5fa;
            --accent-light: #dbeafe;
            --accent-bg: #eff6ff;
            --text-primary: #1e3a8a;
            --border-color: rgba(59, 130, 246, 0.15);
            --badge-text: #1e3a8a;
            <?php elseif ($theme === 'saturday-purple'): ?>
            --primary-start: #581c87;
            --primary-mid: #7c3aed;
            --primary-end: #a855f7;
            --accent-light: #ede9fe;
            --accent-bg: #f5f3ff;
            --text-primary: #581c87;
            --border-color: rgba(124, 58, 237, 0.15);
            --badge-text: #581c87;
            <?php elseif ($theme === 'blue-cyan'): ?>
            --primary-start: #1e3a8a;
            --primary-mid: #3b82f6;
            --primary-end: #06b6d4;
            --accent-light: #e0f2fe;
            --accent-bg: #f0f9ff;
            --text-primary: #1e40af;
            --border-color: rgba(59, 130, 246, 0.15);
            --badge-text: #1e40af;
            <?php elseif ($theme === 'green-emerald'): ?>
            --primary-start: #14532d;
            --primary-mid: #16a34a;
            --primary-end: #10b981;
            --accent-light: #d1fae5;
            --accent-bg: #ecfdf5;
            --text-primary: #065f46;
            --border-color: rgba(34, 197, 94, 0.15);
            --badge-text: #065f46;
            <?php elseif ($theme === 'purple-violet'): ?>
            --primary-start: #581c87;
            --primary-mid: #7c3aed;
            --primary-end: #8b5cf6;
            --accent-light: #ede9fe;
            --accent-bg: #f5f3ff;
            --text-primary: #6b21a8;
            --border-color: rgba(139, 92, 246, 0.15);
            --badge-text: #6b21a8;
            <?php elseif ($theme === 'orange-amber'): ?>
            --primary-start: #c2410c;
            --primary-mid: #ea580c;
            --primary-end: #f59e0b;
            --accent-light: #fed7aa;
            --accent-bg: #fffbeb;
            --text-primary: #c2410c;
            --border-color: rgba(234, 88, 12, 0.15);
            --badge-text: #c2410c;
            <?php elseif ($theme === 'pink-rose'): ?>
            --primary-start: #be185d;
            --primary-mid: #ec4899;
            --primary-end: #f43f5e;
            --accent-light: #fce7f3;
            --accent-bg: #fdf2f8;
            --text-primary: #be185d;
            --border-color: rgba(236, 72, 153, 0.15);
            --badge-text: #be185d;
            <?php elseif ($theme === 'indigo-blue'): ?>
            --primary-start: #312e81;
            --primary-mid: #4f46e5;
            --primary-end: #3b82f6;
            --accent-light: #e0e7ff;
            --accent-bg: #eef2ff;
            --text-primary: #312e81;
            --border-color: rgba(79, 70, 229, 0.15);
            --badge-text: #312e81;
            <?php elseif ($theme === 'teal-cyan'): ?>
            --primary-start: #134e4a;
            --primary-mid: #0d9488;
            --primary-end: #06b6d4;
            --accent-light: #ccfbf1;
            --accent-bg: #f0fdfa;
            --text-primary: #134e4a;
            --border-color: rgba(13, 148, 136, 0.15);
            --badge-text: #134e4a;
            <?php elseif ($theme === 'lime-green'): ?>
            --primary-start: #365314;
            --primary-mid: #65a30d;
            --primary-end: #84cc16;
            --accent-light: #ecfccb;
            --accent-bg: #f7fee7;
            --text-primary: #365314;
            --border-color: rgba(101, 163, 13, 0.15);
            --badge-text: #365314;
            <?php elseif ($theme === 'yellow-orange'): ?>
            --primary-start: #a16207;
            --primary-mid: #eab308;
            --primary-end: #f97316;
            --accent-light: #fef3c7;
            --accent-bg: #fffbeb;
            --text-primary: #a16207;
            --border-color: rgba(234, 179, 8, 0.15);
            --badge-text: #a16207;
            <?php elseif ($theme === 'slate-gray'): ?>
            --primary-start: #1e293b;
            --primary-mid: #475569;
            --primary-end: #64748b;
            --accent-light: #f1f5f9;
            --accent-bg: #f8fafc;
            --text-primary: #1e293b;
            --border-color: rgba(71, 85, 105, 0.15);
            --badge-text: #1e293b;
            <?php else: // red-yellow default ?>
            --primary-start: #dc2626;
            --primary-mid: #f97316;
            --primary-end: #eab308;
            --accent-light: #fef3c7;
            --accent-bg: #fefce8;
            --text-primary: #dc2626;
            --border-color: rgba(220, 38, 38, 0.15);
            --badge-text: #dc2626;
            <?php endif; ?>
        }

        @media print {
            .no-print { display: none !important; }
        }
        
        @page {
            size: A4 portrait;
            margin: 0;
        }
        
        body { 
            font-family: 'Sarabun', sans-serif; 
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            line-height: 1.6;
            
        }
        
        .content-area {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            <?php 
            $bgImage = '../dist/img/newletter_bg2.png'; // default
            if (!empty($settings['useCustomBackground']) && !empty($settings['customBackgroundImage'])) {
                $bgImage = $settings['customBackgroundImage'];
            }
            ?>
            background: url('<?php echo $bgImage; ?>') no-repeat center/cover;
        }
        
        /* Theme-based Header Design */
        .header-bg {
            height: 30mm;
            position: relative;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        
        .school-logo {
            width: 16mm;
            height: 16mm;
            background: rgba(255,255,255,0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 4px 20px rgba(220, 38, 38, 0.3),
                0 0 0 2px rgba(255,255,255,0.9),
                inset 0 1px 3px rgba(255,255,255,0.7);
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .school-logo:hover {
            transform: scale(1.05);
        }
        
        .issue-badge {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            border: 1.5px solid rgba(255,255,255,0.4);
            border-radius: 12px;
            padding: 10px 16px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            text-align: center;
        }
        
        .issue-badge .text-gray-700 {
            color: var(--badge-text) !important;
            font-weight: 600;
        }
        
        /* Enhanced Typography */
        .news-title {
            font-family: 'Prompt', sans-serif;
            font-size: 18px;
            font-weight: 800;
            background: white;
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: left;
            margin-bottom: 1px;
            margin-left: 10px;
            line-height: 1.3;
            position: relative;
            padding: 0 20px;
        }

        /* Title font size classes */
        .titlefont-small { font-size: 15px !important; }
        .titlefont-medium { font-size: 18px !important; }
        .titlefont-large { font-size: 24px !important; }

        /* Content font size classes */
        .contentfont-small { font-size: 13px !important; }
        .contentfont-medium { font-size: 16px !important; }
        .contentfont-large { font-size: 20px !important; }
        
        .news-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-start), var(--primary-end));
            border-radius: 2px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }
        
        .news-content {
            flex: 1;
            margin-top: 238px;
            padding: 16px 20px;
           
            position: relative;
        }
        
        .news-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
        }
        
        .content-text {
            font-size: 16px;
            line-height: 1.8;
            color: #1f2937;
            text-align: justify;
            text-indent: 1.8em;
            margin-bottom: 16px;
            position: relative;
            padding-left: 6px;
            word-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            overflow-wrap: break-word;
            white-space: pre-wrap; /* รักษาช่องว่างและการขึ้นบรรทัดใหม่ */
        }
        
        .content-text::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            /* background: linear-gradient(180deg, var(--primary-start), var(--primary-mid), var(--primary-end)); */
            border-radius: 1px;
            opacity: 0.6;
        }
        
        /* Theme-based Image Gallery */
        .photo-section {
            /* background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent-bg) 50%, #ffffff 100%); */
            border-radius: 12px;
            padding: 14px;
            margin-top: 12px;
            /* border: 1px solid var(--border-color); */
            position: relative;
            overflow: hidden;
        }
        
        .photo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-start), var(--primary-mid), var(--primary-end));
            background-size: 200% 100%;
        }
        
        .photo-title {
            font-family: 'Prompt', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .photo-title::before,
        .photo-title::after {
            content: '';
            width: 25px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-start), var(--primary-end));
            border-radius: 1px;
        }
        
        .image-grid {
            display: grid;
            gap: 8px;
        }

        /* จำนวนคอลัมน์ที่เลือก */
        .imggrid-cols-1 {
            grid-template-columns: 1fr;
        }
        .imggrid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        .imggrid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }
        .imggrid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        /* ขนาดรูปภาพที่เลือก */
        .imgsize-small .photo-item {
            max-height: 90px;
        }
        .imgsize-medium .photo-item {
            max-height: 140px;
        }
        .imgsize-large .photo-item {
            max-height: 220px;
        }
        
        
        .photo-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 
                0 3px 12px rgba(220, 38, 38, 0.15),
                0 1px 4px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1.5px solid rgba(255,255,255,0.9);
            background: #ffffff;
            aspect-ratio: 4/3;
        }
        
        .photo-item:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 
                0 6px 20px rgba(220, 38, 38, 0.25),
                0 3px 8px rgba(0,0,0,0.15);
        }
        
        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .photo-item:hover img {
            transform: scale(1.03);
        }
        
        .photo-number {
            position: absolute;
            top: 6px;
            right: 6px;
            background: linear-gradient(135deg, var(--primary-start), var(--primary-mid));
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.9);
        }
        
        /* Print adjustments */
        @media print {
            .photo-item {
                aspect-ratio: 4/3 !important;
            }
            .photo-item img {
                width: 100% !important;
                height: 100% !important;
                object-fit: cover !important;
            }
        }
        
        /* Theme-based Footer */
        .footer-section {
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent-bg) 50%, #ffffff 100%);
            padding: 12px 20px;
            border-top: 2px solid;
            border-image: linear-gradient(90deg, var(--primary-start), var(--primary-mid), var(--primary-end)) 1;
            height: 35mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        .school-info {
            text-align: center;
            margin-bottom: 3px;
        }
        
        .school-name {
            font-family: 'Prompt', sans-serif;
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-start), var(--primary-mid), var(--primary-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
        }
        
        .school-details {
            font-size: 11px;
            color: #7c2d12;
            line-height: 1.5;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            gap: 12px;
            font-size: 10px;
            color: #7c2d12;
            flex-wrap: wrap;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 4px;
            background: rgba(255,255,255,0.9);
            padding: 4px 8px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        
        .contact-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            background: rgba(255,255,255,1);
        }
        
        /* Theme Selector */
        .theme-selector {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.85);
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 0 0 1px rgba(255,255,255,0.5);
            z-index: 1000;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            max-width: 300px;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .theme-selector-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 16px;
            text-align: center;
            font-weight: 700;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .theme-selector-body {
            padding: 16px;
            overflow-y: auto;
            flex: 1;
            max-height: calc(90vh - 60px);
        }
        
        .theme-selector-body::-webkit-scrollbar {
            width: 6px;
        }
        
        .theme-selector-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .theme-selector-body::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 3px;
        }
        
        .theme-selector h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #374151;
            text-align: center;
        }
        
        .theme-section {
            margin-bottom: 16px;
            background: rgba(255,255,255,0.6);
            border-radius: 12px;
            padding: 12px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .theme-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .theme-section-title::before {
            content: '';
            width: 3px;
            height: 12px;
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 2px;
        }
        
        .theme-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 6px;
        }
        
        .theme-options.week-colors {
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        
        .theme-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .theme-btn.week-btn {
            width: 28px;
            height: 28px;
        }
        
        .theme-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .theme-btn.active {
            border: 3px solid #000000;
            transform: scale(1.15);
        }
        
        /* Thai Day Colors */
        .theme-sunday-red { background: #dc2626; }
        .theme-monday-yellow { background: #eab308; }
        .theme-tuesday-pink { background: #ec4899; }
        .theme-wednesday-green { background: #16a34a; }
        .theme-thursday-orange { background: #ea580c; }
        .theme-friday-blue { background: #3b82f6; }
        .theme-saturday-purple { background: #7c3aed; }
        
        /* Additional Theme Colors */
        .theme-red-yellow { background: linear-gradient(45deg, #dc2626, #f59e0b); }
        .theme-blue-cyan { background: linear-gradient(45deg, #1e3a8a, #06b6d4); }
        .theme-green-emerald { background: linear-gradient(45deg, #14532d, #10b981); }
        .theme-purple-violet { background: linear-gradient(45deg, #581c87, #8b5cf6); }
        .theme-orange-amber { background: linear-gradient(45deg, #c2410c, #f59e0b); }
        .theme-pink-rose { background: linear-gradient(45deg, #be185d, #f43f5e); }
        .theme-indigo-blue { background: linear-gradient(45deg, #312e81, #3b82f6); }
        .theme-teal-cyan { background: linear-gradient(45deg, #134e4a, #06b6d4); }
        .theme-lime-green { background: linear-gradient(45deg, #365314, #84cc16); }
        .theme-yellow-orange { background: linear-gradient(45deg, #a16207, #f97316); }
        .theme-slate-gray { background: linear-gradient(45deg, #1e293b, #64748b); }
        
        /* Print Button with theme colors */
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--primary-start), var(--primary-mid), var(--primary-end));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 700;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Sarabun', sans-serif;
            font-size: 14px;
            z-index: 1000;
        }
        
        .print-button:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        }

        /* Custom Form Elements */
        .custom-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            font-size: 13px;
            font-family: 'Sarabun', sans-serif;
            background: linear-gradient(to bottom, #ffffff, #f9fafb);
            cursor: pointer;
            transition: all 0.2s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 36px;
        }

        .custom-select:hover {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .custom-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .control-label {
            font-size: 12px;
            color: #4b5563;
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .control-value {
            text-align: right;
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
        }

        .control-group {
            margin-bottom: 12px;
        }

        /* Custom Range Slider */
        input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: linear-gradient(to right, #e5e7eb, #d1d5db);
            outline: none;
            transition: all 0.2s ease;
        }

        input[type="range"]:hover {
            background: linear-gradient(to right, #667eea, #764ba2);
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.4);
            border: 2px solid white;
            transition: all 0.2s ease;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
        }

        input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(102, 126, 234, 0.4);
            border: 2px solid white;
        }

        /* Custom Color Picker */
        input[type="color"] {
            -webkit-appearance: none;
            width: 100%;
            height: 36px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            padding: 2px;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 2px;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 8px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Custom Checkbox (Toggle Style) */
        input[type="checkbox"] {
            -webkit-appearance: none;
            appearance: none;
            width: 44px;
            height: 24px;
            background: #e5e7eb;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            top: 2px;
            left: 2px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:checked {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        input[type="checkbox"]:checked::before {
            left: 22px;
        }

        /* Custom Buttons */
        .custom-btn {
            font-size: 11px;
            border: 1px solid #e5e7eb;
            background: linear-gradient(to bottom, #ffffff, #f9fafb);
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            font-family: 'Sarabun', sans-serif;
        }

        .custom-btn:hover {
            border-color: #667eea;
            background: linear-gradient(to bottom, #f9fafb, #f3f4f6);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
        }

        .custom-btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .custom-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .divider {
            border-top: 1px dashed #e5e7eb;
            margin: 16px 0;
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <!-- Theme Selector -->
    <div class="theme-selector no-print">
        <div class="theme-selector-header">
            🎨 เครื่องมือปรับแต่ง
        </div>
        <div class="theme-selector-body">
        
        <!-- Thai 7-Day Colors -->
        <div class="theme-section">
            <div class="theme-section-title">สีประจำวัน</div>
            <div class="theme-options week-colors">
                <div class="theme-btn week-btn theme-sunday-red <?php echo $theme === 'sunday-red' ? 'active' : ''; ?>" 
                     onclick="changeTheme('sunday-red')" title="อาทิตย์ - แดง"></div>
                <div class="theme-btn week-btn theme-monday-yellow <?php echo $theme === 'monday-yellow' ? 'active' : ''; ?>" 
                     onclick="changeTheme('monday-yellow')" title="จันทร์ - เหลือง"></div>
                <div class="theme-btn week-btn theme-tuesday-pink <?php echo $theme === 'tuesday-pink' ? 'active' : ''; ?>" 
                     onclick="changeTheme('tuesday-pink')" title="อังคาร - ชมพู"></div>
                <div class="theme-btn week-btn theme-wednesday-green <?php echo $theme === 'wednesday-green' ? 'active' : ''; ?>" 
                     onclick="changeTheme('wednesday-green')" title="พุธ - เขียว"></div>
                <div class="theme-btn week-btn theme-thursday-orange <?php echo $theme === 'thursday-orange' ? 'active' : ''; ?>" 
                     onclick="changeTheme('thursday-orange')" title="พฤหัส - ส้ม"></div>
                <div class="theme-btn week-btn theme-friday-blue <?php echo $theme === 'friday-blue' ? 'active' : ''; ?>" 
                     onclick="changeTheme('friday-blue')" title="ศุกร์ - ฟ้า"></div>
                <div class="theme-btn week-btn theme-saturday-purple <?php echo $theme === 'saturday-purple' ? 'active' : ''; ?>" 
                     onclick="changeTheme('saturday-purple')" title="เสาร์ - ม่วง"></div>
            </div>
        </div>
        
        <!-- Additional Color Themes -->
        <div class="theme-section">
            <div class="theme-section-title">โทนสีเพิ่มเติม</div>
            <div class="theme-options">
                <div class="theme-btn theme-red-yellow <?php echo $theme === 'red-yellow' ? 'active' : ''; ?>" 
                     onclick="changeTheme('red-yellow')" title="แดง-เหลือง"></div>
                <div class="theme-btn theme-blue-cyan <?php echo $theme === 'blue-cyan' ? 'active' : ''; ?>" 
                     onclick="changeTheme('blue-cyan')" title="น้ำเงิน-ฟ้า"></div>
                <div class="theme-btn theme-green-emerald <?php echo $theme === 'green-emerald' ? 'active' : ''; ?>" 
                     onclick="changeTheme('green-emerald')" title="เขียว-มรกต"></div>
                <div class="theme-btn theme-purple-violet <?php echo $theme === 'purple-violet' ? 'active' : ''; ?>" 
                     onclick="changeTheme('purple-violet')" title="ม่วง-ไวโอเลต"></div>
                <div class="theme-btn theme-orange-amber <?php echo $theme === 'orange-amber' ? 'active' : ''; ?>" 
                     onclick="changeTheme('orange-amber')" title="ส้ม-เหลืองอำพัน"></div>
                <div class="theme-btn theme-pink-rose <?php echo $theme === 'pink-rose' ? 'active' : ''; ?>" 
                     onclick="changeTheme('pink-rose')" title="ชมพู-กุหลาบ"></div>
                <div class="theme-btn theme-indigo-blue <?php echo $theme === 'indigo-blue' ? 'active' : ''; ?>" 
                     onclick="changeTheme('indigo-blue')" title="คราม-น้ำเงิน"></div>
                <div class="theme-btn theme-teal-cyan <?php echo $theme === 'teal-cyan' ? 'active' : ''; ?>" 
                     onclick="changeTheme('teal-cyan')" title="เขียวน้ำทะเล-ฟ้า"></div>
                <div class="theme-btn theme-lime-green <?php echo $theme === 'lime-green' ? 'active' : ''; ?>" 
                     onclick="changeTheme('lime-green')" title="เขียวมะนาว"></div>
                <div class="theme-btn theme-yellow-orange <?php echo $theme === 'yellow-orange' ? 'active' : ''; ?>" 
                     onclick="changeTheme('yellow-orange')" title="เหลือง-ส้ม"></div>
                <div class="theme-btn theme-slate-gray <?php echo $theme === 'slate-gray' ? 'active' : ''; ?>" 
                     onclick="changeTheme('slate-gray')" title="เทา-ชาร์โคล"></div>
            </div>
        </div>
            <!-- Dropdown เลือกจำนวนรูป -->
            <div class="theme-section">
                <div class="theme-section-title">จำนวนรูปภาพที่แสดง</div>
                <select id="maximg-select" class="custom-select" onchange="changeMaxImg(this.value)">
                    <option value="3">3 รูป</option>
                    <option value="6">6 รูป</option>
                    <option value="9">9 รูป</option>
                    <option value="all">ทั้งหมด</option>
                </select>
            </div>


                <div class="theme-section">
                    <div class="theme-section-title">ขนาดเนื้อหา</div>
                    <select id="contentfontsize-select" class="custom-select" onchange="changeContentFontSize(this.value)">
                        <option value="small">เล็ก</option>
                        <option value="medium">กลาง</option>
                        <option value="large">ใหญ่</option>
                    </select>
                </div>

            <div class="theme-section">
                <div class="theme-section-title">ขนาดรูปภาพ</div>
                <select id="imgsize-select" class="custom-select" onchange="changeImgSize(this.value)">
                    <option value="small">เล็ก</option>
                    <option value="medium">กลาง</option>
                    <option value="large">ใหญ่</option>
                </select>
            </div>

            <div class="theme-section">
                <div class="theme-section-title">จำนวนรูปต่อแถว</div>
                <select id="imgcols-select" class="custom-select" onchange="changeImgCols(this.value)">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>

            <!-- Layout Adjustment Tools -->
            <div class="theme-section">
                <div class="theme-section-title">เครื่องมือปรับแต่ง Layout</div>
                
                <div style="margin-bottom:8px;">
                    <label class="control-label">ขยับเนื้อหาขึ้น-ลง (px)</label>
                    <input type="range" id="marginTopRange" min="100" max="400" value="<?php echo $settings['contentMarginTop']; ?>" step="1" 
                           style="width:100%;" oninput="updateContentMargin(this.value)">
                    <div class="control-value" id="marginTopVal"><?php echo $settings['contentMarginTop']; ?>px</div>
                </div>

                <div class="control-group">
                    <label class="control-label">สีหัวข้อข่าว</label>
                    <input type="color" id="titleColorPicker" value="<?php echo $settings['titleColor']; ?>" 
                           style="width:100%;height:30px;border:none;cursor:pointer;" oninput="updateTitleColor(this.value)">
                    <div style="display:flex;justify-content:space-between;margin-top:2px;">
                        <button onclick="resetTitleColor()" class="custom-btn">สีเดิม (ไล่เฉด)</button>
                        <button onclick="setTitleColor('white')" class="custom-btn">สีขาว</button>
                        <button onclick="setTitleColor('black')" class="custom-btn">สีดำ</button>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">ขยับหัวข้อซ้าย-ขวา (px)</label>
                    <input type="range" id="titleMarginLeftRange" min="0" max="100" value="<?php echo $settings['titleMarginLeft']; ?>" step="1" 
                           style="width:100%;" oninput="updateTitleMarginLeft(this.value)">
                    <div class="control-value" id="titleMarginLeftVal"><?php echo $settings['titleMarginLeft']; ?>px</div>
                </div>

                <div class="control-group">
                    <label class="control-label">ขยับหัวข้อขึ้น-ลง (px)</label>
                    <input type="range" id="titleMarginBottomRange" min="0" max="50" value="<?php echo $settings['titleMarginBottom']; ?>" step="1" 
                           style="width:100%;" oninput="updateTitleMarginBottom(this.value)">
                    <div class="control-value" id="titleMarginBottomVal"><?php echo $settings['titleMarginBottom']; ?>px</div>
                </div>

                <div class="divider">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span class="theme-section-title" style="margin:0;">แสดงฉบับที่</span>
                        <input type="checkbox" id="showIssueNo" onchange="toggleIssueNo(this.checked)" <?php echo $settings['showIssueNo'] ? 'checked' : ''; ?>>
                    </div>
                </div>
                
                <div id="issueNoControls" style="display:<?php echo $settings['showIssueNo'] ? 'block' : 'none'; ?>; padding-left:8px; border-left:2px solid #ddd;">
                    <div class="control-group">
                        <label class="control-label">ตำแหน่ง X (ซ้าย-ขวา)</label>
                        <input type="range" id="issueX" min="0" max="700" value="<?php echo $settings['issueX']; ?>" step="5" style="width:100%;" oninput="updateIssuePos()">
                    </div>
                    <div class="control-group">
                        <label class="control-label">ตำแหน่ง Y (ขึ้น-ลง)</label>
                        <input type="range" id="issueY" min="0" max="400" value="<?php echo $settings['issueY']; ?>" step="5" style="width:100%;" oninput="updateIssuePos()">
                    </div>
                    <div class="control-group">
                        <label class="control-label">ขนาดตัวอักษร</label>
                        <input type="range" id="issueFontSize" min="10" max="40" value="<?php echo $settings['issueFontSize']; ?>" step="1" style="width:100%;" oninput="updateIssueStyle()">
                        <div class="control-value" id="issueFontSizeVal"><?php echo $settings['issueFontSize']; ?>px</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">สีตัวอักษร</label>
                        <input type="color" id="issueColor" value="<?php echo $settings['issueColor']; ?>" style="width:100%; height:30px; border:none;" oninput="updateIssueStyle()">
                    </div>
                </div>

                <div class="divider">
                     <div class="theme-section-title">ปรับขนาดตัวอักษรเนื้อหา</div>
                     <div class="control-group">
                        <label class="control-label">ขนาดหัวข้อ (Title)</label>
                        <input type="range" id="customTitleSize" min="14" max="60" value="<?php echo $settings['titleFontSize']; ?>" step="1" style="width:100%;" oninput="updateCustomTitleSize(this.value)">
                        <div class="control-value" id="customTitleSizeVal"><?php echo $settings['titleFontSize']; ?>px</div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">ขนาดเนื้อหา (Content)</label>
                        <input type="range" id="customContentSize" min="10" max="30" value="<?php echo $settings['contentFontSize']; ?>" step="1" style="width:100%;" oninput="updateCustomContentSize(this.value)">
                        <div class="control-value" id="customContentSizeVal"><?php echo $settings['contentFontSize']; ?>px</div>
                    </div>
                </div>

                <div class="divider">
                    <button onclick="saveCurrentSettings()" class="custom-btn-primary" id="saveSettingsBtn">
                        💾 บันทึกเป็นค่าเริ่มต้น
                    </button>
                </div>
            </div>

            <!-- ปุ่มแก้ไขข้อมูล -->
            <div class="theme-section">
                <div class="theme-section-title" style="color: #10b981;">✨ แก้ไขข้อมูล</div>
                <button onclick="toggleEditMode()" id="editModeBtn" class="custom-btn-primary" style="background: linear-gradient(135deg, #10b981, #059669);">
                    ✏️ เปิดโหมดแก้ไข
                </button>
                <p style="font-size:11px;color:#6b7280;text-align:center;margin-top:8px;">คลิกที่หัวข้อหรือเนื้อหาเพื่อแก้ไข</p>
            </div>

            <!-- อัปโหลด Background Image -->
            <div class="theme-section">
                <div class="theme-section-title" style="color: #8b5cf6;">🖼️ รูป Background</div>
                
                <!-- Current Background Preview -->
                <div style="margin-bottom:12px; text-align:center;">
                    <div style="width:100%; aspect-ratio:210/297; border-radius:8px; overflow:hidden; border:2px dashed #e5e7eb; background-size:cover; background-position:center;" 
                         id="bgPreview"
                         style="background-image: url('<?php echo $bgImage; ?>');">
                        <img src="<?php echo $bgImage; ?>" alt="Background Preview" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'">
                    </div>
                    <p style="font-size:10px; color:#9ca3af; margin-top:4px;">
                        <?php echo $settings['useCustomBackground'] ? 'รูป Custom' : 'รูป Default'; ?>
                    </p>
                </div>
                
                <!-- Toggle Custom Background -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <span class="control-label" style="margin:0;">ใช้รูป Custom</span>
                    <input type="checkbox" id="useCustomBg" onchange="toggleCustomBackground(this.checked)" <?php echo $settings['useCustomBackground'] ? 'checked' : ''; ?>>
                </div>
                
                <!-- Upload Button -->
                <input type="file" id="bgUploadInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display:none;" onchange="uploadBackground(this)">
                <button onclick="document.getElementById('bgUploadInput').click()" class="custom-btn-primary" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); margin-bottom:8px;">
                    📤 เลือกรูป Background ใหม่
                </button>
                
                <!-- Reset to Default -->
                <button onclick="resetBackground()" class="custom-btn" style="width:100%;">
                    🔄 ใช้รูป Default
                </button>
                
                <p style="font-size:10px;color:#9ca3af;text-align:center;margin-top:8px;">
                    รองรับ PNG, JPG, WEBP (สูงสุด 5MB)<br>
                    แนะนำขนาด 2480 x 3508 px (A4)
                </p>
            </div>
        </div><!-- End theme-selector-body -->
    </div>

    <div class="content-area">
        <!-- Modern Red-Yellow Header -->
        

        <!-- Issue Number Element -->
        <div id="issueNumberDisplay" style="position: absolute; top: <?php echo $settings['issueY']; ?>px; left: <?php echo $settings['issueX']; ?>px; font-weight: bold; font-size: <?php echo $settings['issueFontSize']; ?>px; color: <?php echo $settings['issueColor']; ?>; z-index: 10; font-family: 'Prompt', sans-serif; display: <?php echo $settings['showIssueNo'] ? 'block' : 'none'; ?>;">
            ฉบับที่ <?php echo htmlspecialchars($issue_no); ?>
        </div>

        <!-- Content Section -->
        <div class="news-content " style="margin-top: <?php echo $settings['contentMarginTop']; ?>px;">
            <?php 
                $titlefontsize = isset($_GET['titlefontsize']) ? $_GET['titlefontsize'] : 'medium';
                $contentfontsize = isset($_GET['contentfontsize']) ? $_GET['contentfontsize'] : 'medium';
            ?>
            <h1 class="news-title titlefont-<?php echo $titlefontsize; ?>" id="editableTitle" style="color: <?php echo $settings['titleColor']; ?>; margin-left: <?php echo $settings['titleMarginLeft']; ?>px; margin-bottom: <?php echo $settings['titleMarginBottom']; ?>px; font-size: <?php echo $settings['titleFontSize']; ?>px !important; <?php if($settings['titleColor'] !== '#000000'): ?>-webkit-text-fill-color: initial; background: none;<?php endif; ?>"><?php echo htmlspecialchars($news['title']); ?></h1>
            
            <div class="content-text contentfont-<?php echo $contentfontsize; ?>" id="editableContent" style="font-size: <?php echo $settings['contentFontSize']; ?>px !important;"> <?php 
                // รักษาช่องว่างและการขึ้นบรรทัดใหม่ตามต้นฉบับ
                $content = htmlspecialchars($news['detail']);
                // ใช้ nl2br เพื่อแปลงการขึ้นบรรทัดใหม่เป็น <br>
                $content = nl2br($content);
                echo $content;
                ?></div>
            
            <?php if ($images): ?>
            <?php 
                $maximg = isset($_GET['maximg']) ? $_GET['maximg'] : '6';
                $imgsize = isset($_GET['imgsize']) ? $_GET['imgsize'] : 'medium';
                $imgcols = isset($_GET['imgcols']) ? $_GET['imgcols'] : '3';
                if ($maximg === 'all') {
                    $maxImages = count($images);
                } else {
                    $maxImages = max(1, intval($maximg));
                }
                $imageCount = min(count($images), $maxImages);
                $gridClass = 'imggrid-cols-' . $imgcols . ' imgsize-' . $imgsize;
            ?>
            <div class="photo-section">
                    <div class="image-grid <?php echo $gridClass; ?>">
                        <?php foreach ($images as $index => $img): ?>
                            <?php if ($index < $maxImages): ?>
                            <div class="photo-item">
                                <img src="../<?php echo htmlspecialchars($img); ?>" 
                                     alt="รูปภาพข่าว <?php echo $index + 1; ?>">
                                <div class="photo-number"><?php echo $index + 1; ?></div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($images) > $maxImages): ?>
                    <div style="color: #dc2626; font-size: 13px; text-align: center; margin-top: 8px; font-weight: 600;">
                        * มีรูปภาพมากกว่า <?php echo $maxImages; ?> รูป จะแสดงเฉพาะรูปแรกสุด <?php echo $maxImages; ?> รูปเท่านั้น
                    </div>
                    <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>


        <!-- Print Button -->
        <button onclick="window.print()" class="print-button no-print">
            🖨️ พิมพ์จดหมายข่าว
        </button>
    </div>

    <script>
        function changeTheme(theme) {
            const url = new URL(window.location);
            url.searchParams.set('theme', theme);
            window.location.href = url.toString();
        }
        function changeMaxImg(val) {
            const url = new URL(window.location);
            url.searchParams.set('maximg', val);
            window.location.href = url.toString();
        }
        function changeImgSize(val) {
            const url = new URL(window.location);
            url.searchParams.set('imgsize', val);
            window.location.href = url.toString();
        }
        function changeImgCols(val) {
            const url = new URL(window.location);
            url.searchParams.set('imgcols', val);
            window.location.href = url.toString();
        }

            function changeTitleFontSize(val) {
                const url = new URL(window.location);
                url.searchParams.set('titlefontsize', val);
                window.location.href = url.toString();
            }

            function changeContentFontSize(val) {
                const url = new URL(window.location);
                url.searchParams.set('contentfontsize', val);
                window.location.href = url.toString();
            }

        // ตั้งค่า dropdown ตามค่าปัจจุบัน
        window.addEventListener('DOMContentLoaded', function() {
            var params = new URL(window.location).searchParams;
            var maximg = params.get('maximg');
            var imgsize = params.get('imgsize');
            var imgcols = params.get('imgcols');
            var selectMaximg = document.getElementById('maximg-select');
            var selectImgsize = document.getElementById('imgsize-select');
            var selectImgcols = document.getElementById('imgcols-select');
            if (selectMaximg && maximg) selectMaximg.value = maximg;
            if (selectImgsize && imgsize) selectImgsize.value = imgsize;
            if (selectImgcols && imgcols) selectImgcols.value = imgcols;

                // Set title/content font size dropdowns
                var titlefontsize = params.get('titlefontsize');
                var contentfontsize = params.get('contentfontsize');
                var selectTitleFontsize = document.getElementById('titlefontsize-select');
                var selectContentFontsize = document.getElementById('contentfontsize-select');
                if (selectTitleFontsize && titlefontsize) selectTitleFontsize.value = titlefontsize;
                if (selectContentFontsize && contentfontsize) selectContentFontsize.value = contentfontsize;
        });

        // ฟังก์ชันโหมดแก้ไขข้อมูล
        var isEditMode = false;
        var newsletterId = <?php echo json_encode($id); ?>;
        
        async function toggleEditMode() {
            var title = document.getElementById('editableTitle');
            var content = document.getElementById('editableContent');
            var btn = document.getElementById('editModeBtn');
            
            if (!isEditMode) {
                // เปิดโหมดแก้ไข
                isEditMode = true;
                title.contentEditable = 'true';
                content.contentEditable = 'true';
                
                // เพิ่ม style เมื่อแก้ไข
                title.style.outline = '2px dashed #10b981';
                title.style.outlineOffset = '4px';
                title.style.backgroundColor = '#f0fdf4';
                title.style.padding = '8px';
                title.style.borderRadius = '8px';
                title.style.cursor = 'text';
                
                content.style.outline = '2px dashed #10b981';
                content.style.outlineOffset = '4px';
                content.style.backgroundColor = '#f0fdf4';
                content.style.padding = '12px';
                content.style.borderRadius = '8px';
                content.style.cursor = 'text';
                content.style.minHeight = '100px';
                
                // เปลี่ยนปุ่ม
                btn.innerHTML = '💾 บันทึกการแก้ไข';
                btn.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
                
                // แสดงคำแนะนำ
                showEditTip();
            } else {
                // บันทึกการแก้ไขลงฐานข้อมูล
                btn.disabled = true;
                btn.innerHTML = '⏳ กำลังบันทึก...';
                
                try {
                    // ดึงข้อความที่แก้ไข
                    var newTitle = title.innerText.trim();
                    var newDetail = content.innerText.trim();
                    
                    // เรียก API บันทึก
                    const response = await fetch('api/newsletter_edit.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            id: newsletterId,
                            title: newTitle,
                            detail: newDetail
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        // บันทึกสำเร็จ
                        btn.innerHTML = '✅ บันทึกสำเร็จ!';
                        btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                        
                        setTimeout(() => {
                            closeEditMode(title, content, btn);
                        }, 1500);
                    } else {
                        throw new Error(result.message || 'บันทึกไม่สำเร็จ');
                    }
                } catch (err) {
                    console.error('Save error:', err);
                    btn.innerHTML = '❌ ' + err.message;
                    btn.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                    btn.disabled = false;
                    
                    setTimeout(() => {
                        btn.innerHTML = '💾 บันทึกการแก้ไข';
                        btn.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
                    }, 3000);
                    return; // ไม่ปิดโหมดแก้ไขถ้า error
                }
            }
        }
        
        function closeEditMode(title, content, btn) {
            isEditMode = false;
            
            // ปิดโหมดแก้ไข
            title.contentEditable = 'false';
            content.contentEditable = 'false';
            
            // ลบ style
            title.style.outline = 'none';
            title.style.outlineOffset = '0';
            title.style.backgroundColor = 'transparent';
            title.style.padding = '0';
            title.style.cursor = 'default';
            
            content.style.outline = 'none';
            content.style.outlineOffset = '0';
            content.style.backgroundColor = 'transparent';
            content.style.padding = '0';
            content.style.cursor = 'default';
            
            // เปลี่ยนปุ่มกลับ
            btn.innerHTML = '✏️ เปิดโหมดแก้ไข';
            btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            btn.disabled = false;
            
            // ซ่อนคำแนะนำ
            hideEditTip();
        }
        
        function showEditTip() {
            // สร้างกล่องคำแนะนำ
            if (!document.getElementById('editTip')) {
                var tip = document.createElement('div');
                tip.id = 'editTip';
                tip.innerHTML = '<div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 1px solid #f59e0b; border-radius: 12px; padding: 12px 16px; margin: 16px 0; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"><div style="display: flex; align-items: center; gap: 8px; color: #92400e; font-weight: 600; margin-bottom: 4px;"><span>💡</span> โหมดแก้ไขเปิดใช้งาน</div><div style="color: #78350f; font-size: 13px;">คลิกที่หัวข้อหรือเนื้อหาเพื่อแก้ไขข้อความ เมื่อเสร็จแล้วกด "บันทึกการแก้ไข"</div></div>';
                
                var newsContent = document.querySelector('.news-content');
                if (newsContent) {
                    newsContent.insertBefore(tip, newsContent.firstChild);
                }
            }
        }
        
        function hideEditTip() {
            var tip = document.getElementById('editTip');
            if (tip) {
                tip.remove();
            }
        }
        function updateContentMargin(val) {
            document.querySelector('.news-content').style.marginTop = val + 'px';
            document.getElementById('marginTopVal').textContent = val + 'px';
        }

        function updateTitleColor(color) {
            const title = document.querySelector('.news-title');
            title.style.color = color;
            title.style.webkitTextFillColor = 'initial';
            title.style.background = 'none';
        }

        function resetTitleColor() {
            const title = document.querySelector('.news-title');
            title.style.color = '';
            title.style.webkitTextFillColor = 'transparent';
            title.style.background = 'white';
            title.style.backgroundSize = '200% 200%';
            title.style.webkitBackgroundClip = 'text';
            title.style.backgroundClip = 'text';
            document.getElementById('titleColorPicker').value = '#000000';
        }

        function setTitleColor(color) {
            const title = document.querySelector('.news-title');
            title.style.color = color;
            title.style.webkitTextFillColor = color; // Forcing fill color
            title.style.backgroundImage = 'none'; // Removing gradient
            title.style.background = 'none';
            
            // Map common colors to hex for picker sync
            const colorMap = {
                'white': '#ffffff',
                'black': '#000000'
            };
            if(colorMap[color]) {
                document.getElementById('titleColorPicker').value = colorMap[color];
            }
        }

        function updateTitleMarginLeft(val) {
            document.querySelector('.news-title').style.marginLeft = val + 'px';
            document.getElementById('titleMarginLeftVal').textContent = val + 'px';
        }

        function updateTitleMarginBottom(val) {
            document.querySelector('.news-title').style.marginBottom = val + 'px';
            document.getElementById('titleMarginBottomVal').textContent = val + 'px';
        }

        // Issue Number Functions
        function toggleIssueNo(checked) {
            const display = document.getElementById('issueNumberDisplay');
            const controls = document.getElementById('issueNoControls');
            if(checked) {
                display.style.display = 'block';
                controls.style.display = 'block';
            } else {
                display.style.display = 'none';
                controls.style.display = 'none';
            }
        }

        function updateIssuePos() {
            const x = document.getElementById('issueX').value;
            const y = document.getElementById('issueY').value;
            const el = document.getElementById('issueNumberDisplay');
            el.style.left = x + 'px';
            el.style.top = y + 'px';
        }

        function updateIssueStyle() {
            const size = document.getElementById('issueFontSize').value;
            const color = document.getElementById('issueColor').value;
            const el = document.getElementById('issueNumberDisplay');
            el.style.fontSize = size + 'px';
            el.style.color = color;
            document.getElementById('issueFontSizeVal').textContent = size + 'px';
        }

        // Font Size Functions
        function updateCustomTitleSize(val) {
            const title = document.querySelector('.news-title');
            title.style.fontSize = val + 'px';
            document.getElementById('customTitleSizeVal').textContent = val + 'px';
            
            // Override class-based sizing if necessary by setting imporant via inline style logic or just relying on inline specificity
            // Inline style usually overrides class, but !important in class might block it.
            // Let's check classes. classes use !important.
            // So we might need to remove size classes or set cssText with !important
            title.classList.remove('titlefont-small', 'titlefont-medium', 'titlefont-large');
            title.style.setProperty('font-size', val + 'px', 'important');
        }

        function updateCustomContentSize(val) {
            const content = document.querySelector('.content-text');
            // content.style.fontSize = val + 'px';
            document.getElementById('customContentSizeVal').textContent = val + 'px';
            
            content.classList.remove('contentfont-small', 'contentfont-medium', 'contentfont-large');
            content.style.setProperty('font-size', val + 'px', 'important');
        }

        async function saveCurrentSettings() {
            const btn = document.getElementById('saveSettingsBtn');
            const originalText = btn.innerHTML;
            
            try {
                btn.disabled = true;
                btn.innerHTML = '⌛ กำลังบันทึก...';
                
                const settings = {
                    contentMarginTop: parseInt(document.getElementById('marginTopRange').value),
                    titleMarginLeft: parseInt(document.getElementById('titleMarginLeftRange').value),
                    titleMarginBottom: parseInt(document.getElementById('titleMarginBottomRange').value),
                    titleColor: document.getElementById('titleColorPicker').value,
                    showIssueNo: document.getElementById('showIssueNo').checked,
                    issueX: parseInt(document.getElementById('issueX').value),
                    issueY: parseInt(document.getElementById('issueY').value),
                    issueFontSize: parseInt(document.getElementById('issueFontSize').value),
                    issueColor: document.getElementById('issueColor').value,
                    titleFontSize: parseInt(document.getElementById('customTitleSize').value),
                    contentFontSize: parseInt(document.getElementById('customContentSize').value)
                };

                const response = await fetch('newsletter_export.php?action=save_settings', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(settings)
                });

                const result = await response.json();
                if (result.success) {
                    btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                    btn.innerHTML = '✅ บันทึกสำเร็จ';
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        btn.style.background = '';
                    }, 2000);
                } else {
                    throw new Error(result.message || 'Save failed');
                }
            } catch (err) {
                console.error(err);
                btn.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                btn.innerHTML = '❌ ผิดพลาด: ' + err.message;
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                }, 3000);
            }
        }

        // ====== Background Upload Functions ======
        async function uploadBackground(input) {
            if (!input.files || !input.files[0]) return;
            
            const file = input.files[0];
            
            // Validate file size
            if (file.size > 5 * 1024 * 1024) {
                alert('ไฟล์มีขนาดใหญ่เกินไป (สูงสุด 5MB)');
                return;
            }
            
            const formData = new FormData();
            formData.append('background', file);
            
            try {
                // Show loading
                const uploadBtn = document.querySelector('[onclick*="bgUploadInput"]');
                const originalText = uploadBtn.innerHTML;
                uploadBtn.innerHTML = '⏳ กำลังอัปโหลด...';
                uploadBtn.disabled = true;
                
                const response = await fetch('api/newsletter_bg_upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Update preview
                    const preview = document.querySelector('#bgPreview img');
                    if (preview) {
                        preview.src = result.path + '?t=' + Date.now();
                        preview.style.display = 'block';
                    }
                    
                    // Update content-area background
                    document.querySelector('.content-area').style.backgroundImage = `url('${result.path}?t=${Date.now()}')`;
                    
                    // Check the toggle
                    document.getElementById('useCustomBg').checked = true;
                    
                    uploadBtn.innerHTML = '✅ อัปโหลดสำเร็จ!';
                    setTimeout(() => {
                        uploadBtn.innerHTML = originalText;
                        uploadBtn.disabled = false;
                    }, 2000);
                    
                    // Reload page to apply changes
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    throw new Error(result.message || 'อัปโหลดไม่สำเร็จ');
                }
            } catch (err) {
                console.error(err);
                alert('เกิดข้อผิดพลาด: ' + err.message);
                const uploadBtn = document.querySelector('[onclick*="bgUploadInput"]');
                uploadBtn.innerHTML = '📤 เลือกรูป Background ใหม่';
                uploadBtn.disabled = false;
            }
            
            // Reset input
            input.value = '';
        }
        
        async function toggleCustomBackground(useCustom) {
            try {
                // Get current settings first
                const currentSettings = {
                    contentMarginTop: parseInt(document.getElementById('marginTopRange').value),
                    titleMarginLeft: parseInt(document.getElementById('titleMarginLeftRange').value),
                    titleMarginBottom: parseInt(document.getElementById('titleMarginBottomRange').value),
                    titleColor: document.getElementById('titleColorPicker').value,
                    showIssueNo: document.getElementById('showIssueNo').checked,
                    issueX: parseInt(document.getElementById('issueX').value),
                    issueY: parseInt(document.getElementById('issueY').value),
                    issueFontSize: parseInt(document.getElementById('issueFontSize').value),
                    issueColor: document.getElementById('issueColor').value,
                    titleFontSize: parseInt(document.getElementById('customTitleSize').value),
                    contentFontSize: parseInt(document.getElementById('customContentSize').value),
                    useCustomBackground: useCustom
                };
                
                const response = await fetch('newsletter_export.php?action=save_settings', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(currentSettings)
                });
                
                const result = await response.json();
                if (result.success) {
                    location.reload();
                }
            } catch (err) {
                console.error(err);
                alert('เกิดข้อผิดพลาด: ' + err.message);
            }
        }
        
        async function resetBackground() {
            if (!confirm('ต้องการใช้รูป Background เดิมหรือไม่?')) return;
            
            try {
                // Get current settings and reset background settings
                const currentSettings = {
                    contentMarginTop: parseInt(document.getElementById('marginTopRange').value),
                    titleMarginLeft: parseInt(document.getElementById('titleMarginLeftRange').value),
                    titleMarginBottom: parseInt(document.getElementById('titleMarginBottomRange').value),
                    titleColor: document.getElementById('titleColorPicker').value,
                    showIssueNo: document.getElementById('showIssueNo').checked,
                    issueX: parseInt(document.getElementById('issueX').value),
                    issueY: parseInt(document.getElementById('issueY').value),
                    issueFontSize: parseInt(document.getElementById('issueFontSize').value),
                    issueColor: document.getElementById('issueColor').value,
                    titleFontSize: parseInt(document.getElementById('customTitleSize').value),
                    contentFontSize: parseInt(document.getElementById('customContentSize').value),
                    useCustomBackground: false,
                    customBackgroundImage: ''
                };
                
                const response = await fetch('newsletter_export.php?action=save_settings', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(currentSettings)
                });
                
                const result = await response.json();
                if (result.success) {
                    location.reload();
                }
            } catch (err) {
                console.error(err);
                alert('เกิดข้อผิดพลาด: ' + err.message);
            }
        }
    </script>
    
    <style>
        /* Style สำหรับโหมดแก้ไข */
        [contenteditable="true"]:focus {
            outline: 2px solid #10b981 !important;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2) !important;
        }
        
        [contenteditable="true"]:hover {
            background-color: #ecfdf5 !important;
        }
        
        /* Animation สำหรับปุ่ม */
        #editModeBtn {
            transition: all 0.3s ease;
        }
        
        #editModeBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }
        
        /* ซ่อน sidebar เมื่อพิมพ์ */
        @media print {
            #editTip {
                display: none !important;
            }
            [contenteditable] {
                outline: none !important;
                background-color: transparent !important;
            }
        }
    </style>
</body>
</html>
