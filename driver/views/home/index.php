<!-- Driver Dashboard Home Content -->
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black gradient-text">👋 สวัสดี, <?php echo $fullname; ?></h1>
            <p class="text-gray-500 mt-2 flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                ยินดีต้อนรับสู่ระบบจัดการงานสำหรับคนขับรถ
            </p>
        </div>
        <div class="glass px-6 py-4 rounded-3xl flex items-center gap-4 border border-emerald-100 shadow-sm">
            <div class="text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">สถานะปัจจุบัน</p>
                <p class="text-emerald-600 font-black text-lg leading-none">พร้อมปฏิบัติงาน</p>
            </div>
            <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Jobs -->
        <div class="glass p-6 rounded-[2rem] border-b-4 border-emerald-500 card-hover group cursor-pointer" onclick="location.href='car_booking.php'">
            <div class="flex justify-between items-start mb-4">
                <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <span class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">วันนึ้</span>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase">งานที่ต้องทำวันนี้</p>
            <h3 class="text-4xl font-black text-gray-800 dark:text-white mt-1" id="todayJobsCount">0</h3>
        </div>

        <!-- Tomorrow's Jobs -->
        <div class="glass p-6 rounded-[2rem] border-b-4 border-blue-500 card-hover group cursor-pointer" onclick="location.href='car_booking.php'">
            <div class="flex justify-between items-start mb-4">
                <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <span class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">พรุ่งนี้</span>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase">งานในวันพรุ่งนี้</p>
            <h3 class="text-4xl font-black text-gray-800 dark:text-white mt-1" id="tomorrowJobsCount">0</h3>
        </div>

        <!-- Weekly Total -->
        <div class="glass p-6 rounded-[2rem] border-b-4 border-purple-500 card-hover group cursor-pointer" onclick="location.href='car_booking.php'">
            <div class="flex justify-between items-start mb-4">
                <div class="w-14 h-14 bg-purple-50 dark:bg-purple-900/30 text-purple-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <span class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">สัปดาห์นี้</span>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase">รวมงานตลอดสัปดาห์</p>
            <h3 class="text-4xl font-black text-gray-800 dark:text-white mt-1" id="weekJobsCount">0</h3>
        </div>

        <!-- Monthly Overview -->
        <div class="glass p-6 rounded-[2rem] border-b-4 border-amber-500 card-hover group cursor-pointer" onclick="location.href='car_booking.php'">
            <div class="flex justify-between items-start mb-4">
                <div class="w-14 h-14 bg-amber-50 dark:bg-amber-900/30 text-amber-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span class="text-[10px] font-black uppercase text-gray-400 tracking-tighter">เดือนนี้</span>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase">งานทั้งหมดในเดือนนี้</p>
            <h3 class="text-4xl font-black text-gray-800 dark:text-white mt-1" id="monthJobsCount">0</h3>
        </div>
    </div>

    <!-- Main Section: Upcoming Jobs & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Upcoming Jobs List -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                    <i class="fas fa-clipboard-list text-emerald-500"></i> งานที่กำลังจะมาถึง
                </h3>
                <a href="car_booking.php" class="text-sm font-bold text-emerald-600 hover:text-emerald-700 underline underline-offset-4">ดูทั้งหมด</a>
            </div>
            
            <div class="space-y-4" id="upcomingJobsList">
                <!-- Data will be loaded by JS -->
                <div class="py-20 text-center text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p class="animate-pulse">กำลังตรวจสอบงานที่กำลังมาถึง...</p>
                </div>
            </div>
        </div>

        <!-- Quick Info / Profile Card -->
        <div class="space-y-6">
            <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-id-card text-emerald-500"></i> โปรไฟล์ของคุณ
            </h3>
            
            <div class="glass rounded-[2rem] p-8 text-center relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-150 duration-700"></div>
                
                <div class="relative">
                    <div class="w-24 h-24 mx-auto rounded-3xl bg-slate-100 dark:bg-slate-700 p-1 mb-4 shadow-xl">
                        <img src="../dist/img/avatar.png" alt="Profile" class="w-full h-full rounded-2xl object-cover" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($fullname); ?>&background=10b981&color=fff'">
                    </div>
                    <h4 class="text-xl font-black text-gray-800 dark:text-white"><?php echo $fullname; ?></h4>
                    <span class="px-4 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-full text-xs font-black uppercase mt-2 inline-block">
                        <i class="fas fa-steering-wheel mr-1"></i> คนขับรถ
                    </span>
                    
                    <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700 grid grid-cols-2 gap-4 text-center">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">สังกัด</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">กลุ่มงานบริการ</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">อายุงาน</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300">ระบุไม่ได้</p>
                        </div>
                    </div>
                    
                    <button onclick="location.href='../logout.php'" class="w-full mt-8 py-4 bg-gray-100 hover:bg-red-50 text-gray-700 hover:text-red-500 rounded-2xl font-bold transition-all text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Dashboard Script -->
<script src="views/home/script.js"></script>
