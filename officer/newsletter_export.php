<?php
require_once __DIR__ . '/../classes/DatabaseGeneral.php';
require_once __DIR__ . '/../models/Newsletter.php';
require_once __DIR__ . '/../controllers/NewsletterController.php';

use Controllers\NewsletterController;

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
            background: url('../dist/img/newletter_bg.png') no-repeat center/cover;
        }
        
        /* Theme-based Header Design */
        .header-bg {
            /* background: linear-gradient(135deg, 
                var(--primary-start) 0%, 
                var(--primary-mid) 50%, 
                var(--primary-end) 100%);
            position: relative;
            height: 30mm;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact; */

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
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            z-index: 1000;
            backdrop-filter: blur(10px);
            max-width: 280px;
        }
        
        .theme-selector h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #374151;
            text-align: center;
        }
        
        .theme-section {
            margin-bottom: 12px;
        }
        
        .theme-section-title {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 6px;
            text-align: center;
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
    </style>
</head>
<body>
    <!-- Theme Selector -->
    <div class="theme-selector no-print">
        <h3>เลือกโทนสี</h3>
        
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
                <select id="maximg-select" style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #ddd;font-size:14px;" onchange="changeMaxImg(this.value)">
                    <option value="3">3 รูป</option>
                    <option value="6">6 รูป</option>
                    <option value="9">9 รูป</option>
                    <option value="all">ทั้งหมด</option>
                </select>
            </div>


                <!-- Dropdown เลือกขนาดเนื้อหา -->
                <div class="theme-section">
                    <div class="theme-section-title">ขนาดเนื้อหา</div>
                    <select id="contentfontsize-select" style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #ddd;font-size:14px;" onchange="changeContentFontSize(this.value)">
                        <option value="small">เล็ก</option>
                        <option value="medium">กลาง</option>
                        <option value="large">ใหญ่</option>
                    </select>
                </div>

            <!-- Dropdown เลือกขนาดรูปภาพ -->
            <div class="theme-section">
                <div class="theme-section-title">ขนาดรูปภาพ</div>
                <select id="imgsize-select" style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #ddd;font-size:14px;" onchange="changeImgSize(this.value)">
                    <option value="small">เล็ก</option>
                    <option value="medium">กลาง</option>
                    <option value="large">ใหญ่</option>
                </select>
            </div>

            <!-- Dropdown เลือกจำนวนรูปต่อแถว -->
            <div class="theme-section">
                <div class="theme-section-title">จำนวนรูปต่อแถว</div>
                <select id="imgcols-select" style="width:100%;padding:6px 8px;border-radius:8px;border:1px solid #ddd;font-size:14px;" onchange="changeImgCols(this.value)">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
    </div>

    <div class="content-area">
        <!-- Modern Red-Yellow Header -->
        

        <!-- Content Section -->
        <div class="news-content ">
            <?php 
                $titlefontsize = isset($_GET['titlefontsize']) ? $_GET['titlefontsize'] : 'medium';
                $contentfontsize = isset($_GET['contentfontsize']) ? $_GET['contentfontsize'] : 'medium';
            ?>
            <h1 class="news-title titlefont-<?php echo $titlefontsize; ?>"><?php echo htmlspecialchars($news['title']); ?></h1>
            
            <div class="content-text contentfont-<?php echo $contentfontsize; ?>">
                <?php 
                // รักษาช่องว่างและการขึ้นบรรทัดใหม่ตามต้นฉบับ
                $content = htmlspecialchars($news['detail']);
                // ใช้ nl2br เพื่อแปลงการขึ้นบรรทัดใหม่เป็น <br>
                $content = nl2br($content);
                echo $content;
                ?>
            </div>
            
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
                                <img src="../<?php echo htmlspecialchars(preg_replace('/^teacher\//', '', $img)); ?>" 
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
    </script>
</body>
</html>
