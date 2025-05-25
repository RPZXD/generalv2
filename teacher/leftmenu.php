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
    // เมนูระบบบริหารงานทั่วไป
    echo createNavItem('repair_request.php', 'bi-tools', 'แจ้งซ่อม 🛠️');
    echo createNavItem('room_booking.php', 'bi-building', 'จองห้องประชุม 🏢');
    echo createNavItem('car_booking.php', 'bi-truck', 'จองรถ 🚗');
    echo createNavItem('../logout.php', 'bi-box-arrow-right', 'ออกจากระบบ');

?>