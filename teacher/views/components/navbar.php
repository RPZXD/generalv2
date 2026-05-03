<!-- Top Navbar for Teacher - Refined & Modern -->
<header class="sticky top-0 z-30 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center gap-4">
                <!-- Sidebar Toggle Button (Mobile & Desktop) -->
                <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all focus:outline-none">
                    <i class="fas fa-indent text-lg transition-transform sidebar-toggle-icon"></i>
                </button>
                
                <!-- Page Title -->
                <div class="flex flex-col hidden sm:flex">
                    <h1 class="text-lg font-black text-slate-800 dark:text-white leading-tight">
                        <?php echo $pageTitle ?? 'Dashboard'; ?>
                    </h1>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Teacher Active</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center space-x-3">
                <!-- Current Time -->
                <div class="hidden md:flex items-center space-x-3 px-4 py-2 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800/50">
                    <i class="fas fa-clock text-blue-500 animate-pulse-slow"></i>
                    <span id="currentTime" class="text-xs font-black text-slate-600 dark:text-slate-300 tracking-tighter">00:00:00</span>
                </div>
                
                <!-- User Profile Summary -->
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-black text-slate-800 dark:text-white"><?php echo htmlspecialchars($fullname ?? $username ?? 'User'); ?></span>
                        <span class="text-[9px] font-black text-blue-500 uppercase tracking-widest">Instructor</span>
                    </div>
                    
                    <!-- Avatar -->
                    <div class="relative">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/20 text-xl overflow-hidden border-2 border-white dark:border-slate-700">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full shadow-sm"></div>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all">
                    <i class="fas fa-sun dark:hidden"></i>
                    <i class="fas fa-moon hidden dark:block"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<script>
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        const dateElement = document.getElementById('currentTime');
        if (dateElement) dateElement.textContent = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
