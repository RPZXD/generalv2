<?php
$username = $_SESSION['username'] ?? 'ผู้บริหาร';
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? $username;
?>
<nav class="sticky top-0 z-30 flex items-center justify-between px-4 py-3 md:px-6 md:py-4 glass border-b border-white/10">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-fuchsia-600">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="hidden md:block">
            <h2 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                <?php echo $pageTitle ?? 'แผงบริหาร'; ?>
            </h2>
        </div>
    </div>

    <div class="flex items-center gap-4">
        <button onclick="toggleDarkMode()"
            class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 hover:text-fuchsia-500 transition-all">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block"></i>
        </button>

        <div class="flex items-center gap-3 pl-4 border-l border-gray-200 dark:border-gray-700">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-gray-800 dark:text-white"><?php echo $fullname; ?></p>
                <p class="text-[10px] text-fuchsia-500 font-bold uppercase">Director</p>
            </div>

        </div>
    </div>
</nav>