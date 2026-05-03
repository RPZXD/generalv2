<?php
$config = json_decode(file_get_contents(__DIR__ . '/../../../config.json'), true);
$global = $config['global'];

// Get current page for active state
$currentPage = basename($_SERVER['PHP_SELF']);

// Menu configuration for Officer
$menuItems = [
    [
        'key' => 'home',
        'name' => 'หน้าหลัก',
        'url' => 'index.php',
        'icon' => 'fa-home',
        'gradient' => ['from' => 'fuchsia-500', 'to' => 'pink-500'],
    ],
    [
        'key' => 'repair',
        'name' => 'จัดการแจ้งซ่อม',
        'url' => 'repair.php',
        'icon' => 'fa-tools',
        'emoji' => '🔧',
        'gradient' => ['from' => 'amber-500', 'to' => 'orange-500'],
    ],
    [
        'key' => 'meetingroom',
        'name' => 'จัดการจองห้องประชุม',
        'url' => 'meetingroom.php',
        'icon' => 'fa-door-open',
        'emoji' => '🏢',
        'gradient' => ['from' => 'indigo-500', 'to' => 'purple-500'],
    ],
    [
        'key' => 'car_booking',
        'name' => 'จองรถ',
        'url' => 'car_booking.php',
        'icon' => 'fa-truck',
        'emoji' => '🚗',
        'gradient' => ['from' => 'red-500', 'to' => 'rose-600'],
    ],
    [
        'key' => 'newsletter',
        'name' => 'จดหมายข่าว',
        'url' => 'newsletter.php',
        'icon' => 'fa-newspaper',
        'emoji' => '📰',
        'gradient' => ['from' => 'cyan-500', 'to' => 'sky-500'],
    ],
    [
        'key' => 'settings',
        'name' => 'ตั้งค่าระบบ',
        'url' => 'settings.php',
        'icon' => 'fa-cog',
        'emoji' => '⚙️',
        'gradient' => ['from' => 'slate-500', 'to' => 'gray-600'],
    ],
];
?>

<!-- Sidebar Overlay (Mobile) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-all duration-300 lg:translate-x-0 -translate-x-full group/sidebar sidebar-container">
    <!-- Sidebar Background -->
    <div
        class="h-full overflow-y-auto bg-slate-900 border-r border-white/5 shadow-2xl overflow-x-hidden custom-scrollbar-sidebar">

        <!-- Logo Section -->
        <div class="px-5 py-5 border-b border-white/10 h-20 flex items-center overflow-hidden">
            <a href="index.php" class="flex items-center space-x-4 group/logo shrink-0">
                <div class="relative shrink-0">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-fuchsia-500 to-pink-600 rounded-2xl blur-lg opacity-50 group-hover/logo:opacity-75 transition-opacity">
                    </div>
                    <img src="../dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>"
                        class="relative w-10 h-10 rounded-xl ring-2 ring-white/10 group-hover/logo:ring-fuchsia-400 transition-all object-cover"
                        alt="Logo">
                </div>
                <div class="sidebar-text opacity-100 transition-opacity duration-300 whitespace-nowrap">
                    <span
                        class="text-md font-black text-white tracking-tighter uppercase"><?php echo $global['nameTitle'] ?? 'GENERAL'; ?></span>
                    <p class="text-[10px] font-bold text-fuchsia-400 uppercase tracking-widest">Officer Hub</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-3">
            <ul class="space-y-2">
                <?php foreach ($menuItems as $menu):
                    $fromColor = $menu['gradient']['from'];
                    $toColor = $menu['gradient']['to'];
                    $isActive = ($currentPage === $menu['url']);
                    $activeClass = $isActive ? 'bg-white/10 text-white ring-1 ring-white/10' : 'text-slate-400';
                    ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($menu['url']); ?>"
                            class="sidebar-item flex items-center px-3 py-3 <?php echo $activeClass; ?> rounded-2xl hover:bg-white/10 hover:text-white group/item transition-all duration-200">
                            <span
                                class="w-10 h-10 shrink-0 flex items-center justify-center bg-gradient-to-br from-<?php echo $fromColor; ?> to-<?php echo $toColor; ?> rounded-xl shadow-lg shadow-black/20 group-hover/item:scale-110 transition-transform duration-200">
                                <i class="fas <?php echo $menu['icon']; ?> text-white text-sm"></i>
                            </span>
                            <span class="ml-4 font-bold text-sm sidebar-text whitespace-nowrap opacity-100 transition-opacity duration-300"><?php echo htmlspecialchars($menu['name']); ?></span>
                            <?php if (isset($menu['emoji']) && !empty($menu['emoji'])): ?>
                                <span class="ml-auto sidebar-text opacity-100"><?php echo $menu['emoji']; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>

                <li class="my-6 mx-4 border-t border-white/5"></li>

                <li>
                    <a href="../logout.php"
                        class="sidebar-item flex items-center px-3 py-3 text-slate-400 rounded-2xl hover:bg-rose-500/10 hover:text-rose-400 group/logout transition-all duration-200">
                        <span
                            class="w-10 h-10 shrink-0 flex items-center justify-center bg-slate-800 rounded-xl group-hover/logout:bg-rose-500 group-hover/logout:text-white transition-all">
                            <i class="fas fa-sign-out-alt text-sm"></i>
                        </span>
                        <span class="ml-4 font-bold text-sm sidebar-text whitespace-nowrap opacity-100 transition-opacity duration-300">ออกจากระบบ</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-white/5 bg-slate-900/80 backdrop-blur-md">
            <div class="sidebar-text text-center text-[10px] font-black text-slate-500 uppercase tracking-widest opacity-100 transition-opacity duration-300">
                <p>Version 2.0</p>
                <p class="mt-1">Officer Portal</p>
            </div>
        </div>
    </div>
</aside>

<style>
/* Sidebar Transitions */
.sidebar-container {
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Mini State (Desktop Only) */
@media (min-width: 1024px) {
    .sidebar-mini {
        width: 80px !important;
    }
    
    .sidebar-mini .sidebar-text {
        opacity: 0;
        pointer-events: none;
        width: 0;
        margin: 0;
    }
    
    /* Hover to Expand */
    .sidebar-mini:hover {
        width: 256px !important; /* w-64 */
        z-index: 50;
    }
    
    .sidebar-mini:hover .sidebar-text {
        opacity: 1;
        width: auto;
        margin-left: 1rem;
    }
}

.custom-scrollbar-sidebar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar-sidebar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
</style>