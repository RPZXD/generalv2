<?php
/**
 * Newsletter Export Page 2 - สำหรับเจ้าหน้าที่เท่านั้น
 * ต้อง login ก่อนใช้งาน
 */
session_start();

// ตรวจสอบการ login - เฉพาะเจ้าหน้าที่
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}
?>
    <style>
        @media print {
            body, html {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .content-area {
                position: relative;
                width: 210mm;
                height: 297mm;
                min-height: 297mm;
                max-height: 297mm;
                background: url('../uploads/newsletter/newsletter_bg.png') no-repeat center center;
                background-size: cover;
                overflow: hidden;
                page-break-after: avoid;
                box-sizing: border-box;
                padding: 20mm 10mm 10mm 10mm;
            }
            .news-content, .footer-section {
                max-height: 220mm;
                overflow: hidden;
                page-break-inside: avoid;
            }
            .news-title {
                font-size: 1.2em !important;
                font-weight: bold;
                margin-bottom: 0.5em;
            }
            .content-text {
                font-size: 1em !important;
                line-height: 1.3em;
                max-height: 80mm;
                overflow: hidden;
            }
            .photo-section {
                margin-top: 0.5em;
                margin-bottom: 0.5em;
            }
            .image-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
                gap: 4px;
                max-height: 60mm;
                overflow: hidden;
            }
            .photo-item img {
                width: 100%;
                height: auto;
                max-height: 45mm;
                object-fit: contain;
            }
            .footer-section {
                font-size: 0.9em !important;
                margin-top: 0.5em;
            }
            .print-button, .no-print {
                display: none !important;
            }
        }
    <style>
        @media print {
            body, html {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .content-area {
                position: relative;
                width: 210mm;
                height: 297mm;
                min-height: 297mm;
                max-height: 297mm;
                background: url('../uploads/newsletter/newsletter_bg.png') no-repeat center center;
                background-size: cover;
                overflow: hidden;
                page-break-after: avoid;
                /* Hide overflow and scale down if needed */
                box-sizing: border-box;
                padding: 20mm 10mm 10mm 10mm;
            }
            .news-content, .footer-section {
                max-height: 220mm;
                overflow: hidden;
                page-break-inside: avoid;
            }
            .image-grid img {
                max-width: 100%;
                height: auto;
                page-break-inside: avoid;
            }
            /* Scale down content if it overflows */
            .content-area {
                transform: scale(1);
                transform-origin: top left;
            }
        }
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
        @media print {
            body, html {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            .content-area {
                position: relative;
                width: 210mm;
                height: 297mm;
                min-height: 297mm;
                max-height: 297mm;
                background: url('../uploads/newsletter/newsletter_bg.png') no-repeat center center;
                background-size: cover;
                overflow: hidden;
                page-break-after: avoid;
            }
            .news-content, .footer-section, .print-button {
                position: relative;
                z-index: 2;
            }
            .print-button, .no-print {
                display: none !important;
            }
            .image-grid img {
                max-width: 100%;
                height: auto;
                page-break-inside: avoid;
            }
        }
        /* For screen preview, show the background faintly */
        .content-area {
            background: url('../uploads/newsletter/newsletter_bg.png') no-repeat center center;
            background-size: cover;
        }
    </style>
</head>
<body>


    <div class="content-area">
        <!-- Modern Red-Yellow Header -->
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
