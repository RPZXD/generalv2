<!-- Teacher Home Page Content -->
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text"><?php echo $global['nameschool']; ?></h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400 flex items-center gap-2">
                <span class="text-2xl">👨‍🏫</span> ยินดีต้อนรับ คุณ<?php echo htmlspecialchars($fullname ?? $username ?? 'ครู'); ?>
            </p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                บทบาท: ครู
            </span>
        </div>
    </div>

    <!-- Welcome Alert -->
    <div class="glass rounded-2xl p-6 border-l-4 border-green-500 flex items-center gap-4">
        <span class="text-4xl animate-bounce">👋</span>
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">ยินดีต้อนรับเข้าสู่ระบบ</h3>
            <p class="text-gray-600 dark:text-gray-400">คุณสามารถใช้งานระบบบริหารงานทั่วไปได้ทุกฟังก์ชัน</p>
        </div>
    </div>

    <!-- System Info Card -->
    <div class="glass rounded-2xl p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-10 rounded-full -mr-32 -mt-32"></div>
        
        <div class="relative">
            <div class="flex items-center gap-4 mb-6">
                <div class="text-5xl">🛠️🏢🚗</div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        ระบบบริหารงานทั่วไป <span class="animate-pulse">✨</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">สำหรับครูสามารถใช้งานทุกฟังก์ชันได้</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- แจ้งซ่อม -->
        <a href="repair_request.php" class="card-hover glass rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500 to-orange-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:opacity-30 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg text-white mb-4">
                    <i class="fas fa-tools text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">📋 แจ้งซ่อม</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">แจ้งปัญหาและติดตามสถานะการซ่อมแซม</p>
            </div>
        </a>

        <!-- จองห้องประชุม -->
        <a href="room_booking.php" class="card-hover glass rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500 to-purple-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:opacity-30 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-lg text-white mb-4">
                    <i class="fas fa-door-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">🏢 จองห้องประชุม</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">ตรวจสอบและจองห้องประชุม</p>
            </div>
        </a>

        <!-- จองรถ -->
        <a href="car_booking.php" class="card-hover glass rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500 to-teal-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:opacity-30 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl shadow-lg text-white mb-4">
                    <i class="fas fa-car text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">🚗 จองรถ</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">จองรถสำหรับภารกิจต่าง ๆ</p>
            </div>
        </a>

        <!-- จดหมายข่าว -->
        <a href="newsletter.php" class="card-hover glass rounded-2xl p-6 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-500 to-sky-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:opacity-30 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-cyan-500 to-sky-500 rounded-xl shadow-lg text-white mb-4">
                    <i class="fas fa-newspaper text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">📰 จดหมายข่าว</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">ติดตามข่าวสารของโรงเรียน</p>
            </div>
        </a>
    </div>

    <!-- Info Footer -->
    <div class="glass rounded-2xl p-6 text-center">
        <p class="text-gray-500 dark:text-gray-400">
            <span class="mr-1">🤝</span> Powered by General Management System <span class="ml-1">🎉</span>
        </p>
    </div>
</div>
