<!-- Top Navbar for Teacher -->
<header class="sticky top-0 z-30 glass border-b border-gray-200/50 dark:border-gray-700/50">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Mobile Menu Button -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Breadcrumb or Title -->
                <div class="ml-4 lg:ml-0">
                    <h1 class="text-lg font-semibold text-gray-800 dark:text-white hidden sm:block">
                        <?php echo $pageTitle ?? 'ระบบบริหารงานทั่วไป'; ?>
                    </h1>
                </div>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Current Time -->
                <div class="hidden md:flex items-center space-x-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <i class="fas fa-clock text-primary-500"></i>
                    <span id="currentTime" class="text-sm font-medium text-gray-600 dark:text-gray-300"></span>
                </div>
                
                <!-- User Info -->
                <div class="hidden md:flex items-center space-x-2 px-3 py-1.5 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-lg">
                    <i class="fas fa-user-tie text-blue-600 dark:text-blue-400"></i>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($fullname ?? $username ?? 'ครู'); ?></span>
                    <span class="px-2 py-0.5 text-xs bg-blue-500 text-white rounded-full"><?php echo htmlspecialchars($role ?? 'ครู'); ?></span>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" class="relative w-14 h-7 bg-gray-200 dark:bg-gray-700 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 group">
                    <div class="absolute inset-1 flex items-center justify-between px-1">
                        <i class="fas fa-sun text-xs text-amber-500 opacity-100 dark:opacity-50 transition-opacity"></i>
                        <i class="fas fa-moon text-xs text-blue-300 opacity-50 dark:opacity-100 transition-opacity"></i>
                    </div>
                    <div class="absolute top-0.5 left-0.5 w-6 h-6 bg-white dark:bg-gray-800 rounded-full shadow-md transform transition-transform dark:translate-x-7 flex items-center justify-center">
                        <i class="fas fa-sun text-xs text-amber-500 dark:hidden"></i>
                        <i class="fas fa-moon text-xs text-blue-300 hidden dark:block"></i>
                    </div>
                </button>
                
                <!-- User Avatar -->
                <div class="relative">
                    <div class="flex items-center space-x-2 p-1 rounded-lg">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                            <?php echo strtoupper(substr($fullname ?? $username ?? 'U', 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const options = { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit',
            hour12: false 
        };
        const timeString = now.toLocaleTimeString('th-TH', options);
        const dateElement = document.getElementById('currentTime');
        if (dateElement) {
            dateElement.textContent = timeString;
        }
    }
    
    updateTime();
    setInterval(updateTime, 1000);
</script>
