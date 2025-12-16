<?php 
$config = json_decode(file_get_contents(__DIR__ . '/../../../config.json'), true);
$global = $config['global'];

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Menu configuration for Teacher
$menuItems = [
    [
        'key' => 'home',
        'name' => 'หน้าหลัก',
        'url' => 'index.php',
        'icon' => 'fa-home',
        'gradient' => ['from' => 'blue-500', 'to' => 'blue-600'],
    ],
    [
        'key' => 'repair',
        'name' => 'แจ้งซ่อม',
        'url' => 'repair_request.php',
        'icon' => 'fa-tools',
        'emoji' => '🛠️',
        'gradient' => ['from' => 'amber-500', 'to' => 'orange-500'],
    ],
    [
        'key' => 'room',
        'name' => 'จองห้องประชุม',
        'url' => 'room_booking.php',
        'icon' => 'fa-door-open',
        'emoji' => '🏢',
        'gradient' => ['from' => 'indigo-500', 'to' => 'purple-500'],
    ],
    [
        'key' => 'car',
        'name' => 'จองรถ',
        'url' => 'car_booking.php',
        'icon' => 'fa-car',
        'emoji' => '🚗',
        'gradient' => ['from' => 'emerald-500', 'to' => 'teal-500'],
    ],
    [
        'key' => 'newsletter',
        'name' => 'จดหมายข่าว',
        'url' => 'newsletter.php',
        'icon' => 'fa-newspaper',
        'emoji' => '📰',
        'gradient' => ['from' => 'cyan-500', 'to' => 'sky-500'],
    ],
];
?>

<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0">
    <!-- Sidebar Background -->
    <div class="h-full overflow-y-auto bg-gradient-to-b from-slate-800 via-slate-900 to-slate-950 dark:from-slate-900 dark:via-slate-950 dark:to-black">
        
        <!-- Logo Section -->
        <div class="px-6 py-5 border-b border-white/10">
            <a href="index.php" class="flex items-center space-x-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full blur-lg opacity-50 group-hover:opacity-75 transition-opacity"></div>
                    <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>" class="relative w-12 h-12 rounded-full ring-2 ring-white/20 group-hover:ring-blue-400 transition-all" alt="Logo">
                </div>
                <div>
                    <span class="text-lg font-bold text-white"><?php echo $global['nameTitle'] ?? 'ระบบบริหารงาน'; ?></span>
                    <p class="text-xs text-blue-400">👨‍🏫 ระบบสำหรับครู</p>
                </div>
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="mt-6 px-3">
            <ul class="space-y-1">
                <!-- Main Menu Items -->
                <?php foreach ($menuItems as $menu): 
                    $fromColor = $menu['gradient']['from'];
                    $toColor = $menu['gradient']['to'];
                    $colorBase = explode('-', $fromColor)[0];
                    $isActive = ($currentPage === $menu['url']);
                    $activeClass = $isActive ? 'bg-white/10 text-white' : 'text-gray-300';
                ?>
                <li>
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="sidebar-item flex items-center px-4 py-3 <?php echo $activeClass; ?> rounded-xl hover:bg-white/10 hover:text-white group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-<?php echo $fromColor; ?> to-<?php echo $toColor; ?> rounded-lg shadow-lg shadow-<?php echo $colorBase; ?>-500/30 group-hover:shadow-<?php echo $colorBase; ?>-500/50 transition-shadow">
                            <i class="fas <?php echo $menu['icon']; ?> text-white"></i>
                        </span>
                        <span class="ml-3 font-medium"><?php echo htmlspecialchars($menu['name']); ?></span>
                        <?php if (isset($menu['emoji'])): ?>
                        <span class="ml-auto"><?php echo $menu['emoji']; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php endforeach; ?>
                
                <!-- Divider -->
                <li class="my-4 border-t border-white/10"></li>
                
                <!-- Logout -->
                <li>
                    <a href="../logout.php" class="sidebar-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:bg-red-500/20 hover:text-red-400 group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg shadow-red-500/30 group-hover:shadow-red-500/50 transition-shadow">
                            <i class="fas fa-sign-out-alt text-white"></i>
                        </span>
                        <span class="ml-3 font-medium">ออกจากระบบ</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
            <div class="text-center text-xs text-gray-500">
                <p><?php echo $global['nameschool'] ?? ''; ?></p>
                <p class="mt-1">Version 2.0 | Teacher Portal</p>
            </div>
        </div>
    </div>
</aside>
