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

    echo createNavItem('repair.php', 'bi-tools', 'แจ้งซ่อม');
    echo createNavItem('meetingroom.php', 'bi-building', 'จองห้องประชุม');
    echo createNavItem('carbooking.php', 'bi-truck', 'จองรถ');
    echo createNavItem('report.php', 'bi-bar-chart', 'รายงานและสถิติ');

    echo createNavItem('../logout.php', 'bi-box-arrow-right', 'ออกจากระบบ');

?>