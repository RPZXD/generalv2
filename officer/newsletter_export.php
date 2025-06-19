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
            <?php if ($theme === 'blue-cyan'): ?>
            --primary-start: #1e3a8a;
            --primary-mid: #3b82f6;
            --primary-end: #06b6d4;
            --accent-light: #e0f2fe;
            --accent-bg: #f0f9ff;
            --text-primary: #1e40af;
            --border-color: rgba(59, 130, 246, 0.15);
            <?php elseif ($theme === 'green-emerald'): ?>
            --primary-start: #14532d;
            --primary-mid: #16a34a;
            --primary-end: #10b981;
            --accent-light: #d1fae5;
            --accent-bg: #ecfdf5;
            --text-primary: #065f46;
            --border-color: rgba(34, 197, 94, 0.15);
            <?php elseif ($theme === 'purple-violet'): ?>
            --primary-start: #581c87;
            --primary-mid: #7c3aed;
            --primary-end: #8b5cf6;
            --accent-light: #ede9fe;
            --accent-bg: #f5f3ff;
            --text-primary: #6b21a8;
            --border-color: rgba(139, 92, 246, 0.15);
            <?php elseif ($theme === 'orange-amber'): ?>
            --primary-start: #c2410c;
            --primary-mid: #ea580c;
            --primary-end: #f59e0b;
            --accent-light: #fed7aa;
            --accent-bg: #fffbeb;
            --text-primary: #c2410c;
            --border-color: rgba(234, 88, 12, 0.15);
            <?php else: // red-yellow default ?>
            --primary-start: #dc2626;
            --primary-mid: #f97316;
            --primary-end: #eab308;
            --accent-light: #fef3c7;
            --accent-bg: #fefce8;
            --text-primary: #dc2626;
            --border-color: rgba(220, 38, 38, 0.15);
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
            background: url('../dist/img/header_newlatter.png') no-repeat center/cover;
            height: 30mm;
            position: relative;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .header-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(ellipse at 30% 20%, rgba(255,255,255,0.4) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 80%, rgba(255,255,255,0.3) 0%, transparent 60%),
                linear-gradient(135deg, transparent 20%, rgba(255,255,255,0.15) 50%, transparent 80%);
        }
        
        .header-bg::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-start), var(--primary-mid), var(--primary-end));
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
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
        
        /* Enhanced Typography */
        .news-title {
            font-family: 'Prompt', sans-serif;
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-start) 0%, var(--primary-mid) 50%, var(--primary-end) 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 16px;
            line-height: 1.3;
            position: relative;
            padding: 0 20px;
        }
        
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
            padding: 16px 20px;
            background: linear-gradient(135deg, var(--accent-bg) 0%, #ffffff 30%, var(--accent-light) 70%, #ffffff 100%);
            position: relative;
        }
        
        .news-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 10%, var(--primary-start) 30%, var(--primary-mid) 50%, var(--primary-end) 70%, transparent 90%);
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
            background: linear-gradient(180deg, var(--primary-start), var(--primary-mid), var(--primary-end));
            border-radius: 1px;
            opacity: 0.6;
        }
        
        /* Theme-based Image Gallery */
        .photo-section {
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent-bg) 50%, #ffffff 100%);
            border-radius: 12px;
            padding: 14px;
            margin-top: 12px;
            border: 1px solid var(--border-color);
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
        
        /* Responsive grid based on image count */
        .image-grid.cols-4 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
        }
        .image-grid.cols-5 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
        }
        .image-grid.cols-6 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
        }
        .image-grid.cols-7 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
        }
        .image-grid.cols-8 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
        }
        .image-grid.cols-9 { 
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
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
            padding: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        
        .theme-selector h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #374151;
        }
        
        .theme-options {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .theme-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .theme-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        .theme-btn.active {
            border: 3px solid #000000;
            transform: scale(1.15);
        }
        
        .theme-red-yellow { background: linear-gradient(45deg, #dc2626, #f59e0b); }
        .theme-blue-cyan { background: linear-gradient(45deg, #1e3a8a, #06b6d4); }
        .theme-green-emerald { background: linear-gradient(45deg, #14532d, #10b981); }
        .theme-purple-violet { background: linear-gradient(45deg, #581c87, #8b5cf6); }
        .theme-orange-amber { background: linear-gradient(45deg, #c2410c, #f59e0b); }
        
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
        </div>
    </div>

    <div class="content-area">
        <!-- Modern Red-Yellow Header -->
        <div class="header-bg">
            <div class="relative h-full flex items-center justify-between px-6 z-2">
                <div class="flex items-center gap-4">
                    <div class="school-logo">
                        <img src="../dist/img/logo-phicha.png" alt="โลโก้โรงเรียน" class="w-15 h-15 rounded-full object-cover">
                    </div>
                    <div class="text-gray-800">
                        <div class="text-xl font-bold font-prompt mb-1 drop-shadow-lg"><?php echo htmlspecialchars($school); ?></div>
                        <div class="text-base opacity-95 mb-1 drop-shadow-md font-medium">จดหมายข่าวโรงเรียน</div>
                        <div class="text-xs opacity-90 tracking-wider drop-shadow-sm font-medium">PHICHAI SCHOOL NEWSLETTER</div>
                    </div>
                </div>
                <div class="issue-badge text-white">
                    <div class="text-xs font-semibold mb-1 text-gray-700">ฉบับที่</div>
                    <div class="text-xl font-bold mb-1 text-gray-700"><?php echo $issue_no; ?></div>
                    <div class="text-xs text-gray-700 font-medium"><?php echo $date; ?></div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="news-content">
            <h1 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h1>
            
            <div class="content-text">
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
            $imageCount = count($images);
            $gridClass = 'cols-' . min($imageCount, 9);
            ?>
            <div class="photo-section">
                <div class="photo-title">
                    📸 ภาพประกอบข่าว
                </div>
                <div class="image-grid <?php echo $gridClass; ?>">
                    <?php foreach ($images as $index => $img): ?>
                        <?php if ($index < 9): ?>
                        <div class="photo-item">
                            <img src="../<?php echo htmlspecialchars(preg_replace('/^teacher\//', '', $img)); ?>" 
                                 alt="รูปภาพข่าว <?php echo $index + 1; ?>">
                            <div class="photo-number"><?php echo $index + 1; ?></div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Enhanced Footer -->
        <div class="footer-section">
            <div class="school-info">
                <div class="school-name">โรงเรียนพิชัย</div>
                <div class="school-details">
                    9/9 หมู่ 3 ต.ในเมือง อ.พิชัย จ.อุตรดิตถ์ 53120<br>
                    สังกัดสำนักงานเขตพื้นที่การศึกษามัธยมศึกษาพิษณุโลก อุตรดิตถ์
                    สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน กระทรวงศึกษาธิการ
                </div>
            </div>
            <div class="contact-info">
                <div class="contact-item">📞 055-421-402</div>
                <div class="contact-item">📠 055-421-406</div>
                <div class="contact-item">🌐 www.phichai.ac.th</div>
                <div class="contact-item">📘 FB: PhichaischoolSec39</div>
            </div>
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
    </script>
</body>
</html>
