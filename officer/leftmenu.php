<?php
function createNavItem($href, $iconClass, $text) {
    return '
    <li class="nav-item">
        <a href="' . htmlspecialchars($href) . '" class="nav-link">
            <i class="bi ' . htmlspecialchars($iconClass) . '"></i>
            <p>' . htmlspecialchars($text) . '</p>
        </a>
    </li>';
}


    echo createNavItem('index.php', 'bi-house', 'หน้าหลัก');
    echo createNavItem('club_list.php', 'bi-list-ul', 'รายการชุมนุม');
    echo createNavItem('club_report.php', 'bi-file-earmark-text', 'รายงานการสมัครชุมนุม');
    echo createNavItem('club_statistic.php', 'bi-bar-chart', 'สถิติการสมัครชุมนุม');
    // เพิ่มเมนูเฉพาะครู
    echo createNavItem('../logout.php', 'bi-box-arrow-right', 'ออกจากระบบ');

?>