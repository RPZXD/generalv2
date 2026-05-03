<?php
$config = json_decode(file_get_contents(__DIR__ . '/../../../config.json'), true);
$global = $config['global'];
$currentPage = basename($_SERVER['PHP_SELF']);

$menuItems = [
    [
        'name' => 'หน้าหลัก',
        'url' => 'index.php',
        'icon' => 'fa-home',
        'gradient' => ['from' => 'fuchsia-500', 'to' => 'pink-500'],
    ],
    [
        'name' => 'รายงานการจองรถ',
        'url' => 'car_report.php',
        'icon' => 'fa-car',
        'gradient' => ['from' => 'blue-500', 'to' => 'indigo-500'],
    ],
    [
        'name' => 'รายงานการใช้ห้อง',
        'url' => 'meeting_report.php',
        'icon' => 'fa-building',
        'gradient' => ['from' => 'emerald-500', 'to' => 'teal-600'],
    ],
    [
        'name' => 'รายงานการแจ้งซ่อม',
        'url' => 'repair_report.php',
        'icon' => 'fa-tools',
        'gradient' => ['from' => 'amber-500', 'to' => 'orange-500'],
    ],
];
?>

<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0">
    <div class="h-full overflow-y-auto bg-gradient-to-b from-slate-900 to-black border-r border-white/5">
        <div class="px-6 py-8 border-b border-white/10">
            <div class="flex items-center space-x-3">
                <img src="../dist/img/<?php echo $global['logoLink']; ?>" class="w-12 h-12 rounded-full ring-2 ring-white/20">
                <div>
                    <span class="text-lg font-bold text-white"><?php echo $global['nameTitle']; ?></span>
                    <p class="text-[10px] text-fuchsia-400 font-bold tracking-widest uppercase">Director Portal</p>
                </div>
            </div>
        </div>

        <nav class="mt-6 px-4">
            <ul class="space-y-2">
                <?php foreach ($menuItems as $menu): 
                    $isActive = ($currentPage === $menu['url']);
                    $activeClass = $isActive ? 'bg-white/10 text-white' : 'text-gray-400';
                ?>
                <li>
                    <a href="<?php echo $menu['url']; ?>" class="flex items-center px-4 py-3 rounded-2xl <?php echo $activeClass; ?> hover:bg-white/5 transition-all group">
                        <span class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-<?php echo $menu['gradient']['from']; ?> to-<?php echo $menu['gradient']['to']; ?> rounded-xl shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fas <?php echo $menu['icon']; ?> text-white text-sm"></i>
                        </span>
                        <span class="ml-3 font-medium text-sm"><?php echo $menu['name']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>

                <li class="pt-4 mt-4 border-t border-white/10">
                    <a href="../logout.php" class="flex items-center px-4 py-3 text-red-400 rounded-2xl hover:bg-red-500/10 transition-all">
                        <span class="w-10 h-10 flex items-center justify-center bg-red-500/20 rounded-xl">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="ml-3 font-medium text-sm">ออกจากระบบ</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
