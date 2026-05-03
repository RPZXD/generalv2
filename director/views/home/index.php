<?php
$fullname = $_SESSION['user']['Teach_name'] ?? $_SESSION['fullname'] ?? 'ท่านผู้อำนวยการ';
?>
<div class="space-y-8 animate-fade-in">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h1 class="text-4xl font-black gradient-text tracking-tight">สวัสดีครับ, <?php echo $fullname; ?></h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium flex items-center gap-2">
                <i class="fas fa-chart-pie text-fuchsia-500"></i>
                สรุปภาพรวมความเคลื่อนไหวประจำวันที่ <?php echo date('d/m/Y'); ?>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="glass px-4 py-2 rounded-2xl border border-white/20 shadow-sm flex items-center gap-3">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest">System Online</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Car Bookings -->
        <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl card-hover group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                    <i class="fas fa-car-side"></i>
                </div>
                <span class="text-[10px] font-black text-indigo-500/50 uppercase tracking-widest">Car Booking</span>
            </div>
            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">อนุมัติวันนี้</p>
            <div class="flex items-baseline gap-2 mt-1">
                <h3 class="text-4xl font-black text-gray-800 dark:text-white" id="stat-cars">0</h3>
                <span class="text-xs font-bold text-gray-400">รายการ</span>
            </div>
        </div>

        <!-- Repairs -->
        <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl card-hover group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                    <i class="fas fa-tools"></i>
                </div>
                <span class="text-[10px] font-black text-emerald-500/50 uppercase tracking-widest">Maintenance</span>
            </div>
            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">รอการดำเนินการ</p>
            <div class="flex items-baseline gap-2 mt-1">
                <h3 class="text-4xl font-black text-gray-800 dark:text-white" id="stat-repair">0</h3>
                <span class="text-xs font-bold text-gray-400">รายการ</span>
            </div>
        </div>

        <!-- Meetings -->
        <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl card-hover group">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform">
                    <i class="fas fa-building"></i>
                </div>
                <span class="text-[10px] font-black text-amber-500/50 uppercase tracking-widest">Meetings</span>
            </div>
            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">ในสัปดาห์นี้</p>
            <div class="flex items-baseline gap-2 mt-1">
                <h3 class="text-4xl font-black text-gray-800 dark:text-white" id="stat-meeting">0</h3>
                <span class="text-xs font-bold text-gray-400">รายการ</span>
            </div>
        </div>

        <!-- System Alerts -->
        <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl card-hover group bg-gradient-to-br from-fuchsia-500/5 to-pink-500/5">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-fuchsia-500 to-pink-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-fuchsia-500/30 group-hover:scale-110 transition-transform">
                    <i class="fas fa-bell"></i>
                </div>
                <span class="text-[10px] font-black text-fuchsia-500/50 uppercase tracking-widest">Alerts</span>
            </div>
            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">การแจ้งเตือนวันนี้</p>
            <div class="flex items-baseline gap-2 mt-1">
                <h3 class="text-4xl font-black text-gray-800 dark:text-white">Active</h3>
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Approved Bookings -->
        <div class="lg:col-span-2 glass p-10 rounded-[3rem] border border-white/20 shadow-2xl">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                        <i class="fas fa-clipboard-check text-indigo-500"></i>
                        ประวัติการจองรถล่าสุด
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">รายการที่ได้รับการอนุมัติและพร้อมเดินทาง</p>
                </div>
                <a href="car_report.php" class="px-6 py-3 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-2xl text-xs font-bold hover:bg-gray-200 dark:hover:bg-slate-700 transition-all border border-gray-200 dark:border-gray-700">ดูรายงานทั้งหมด</a>
            </div>
            
            <div class="space-y-4" id="recent-bookings">
                <div class="flex justify-center py-20">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-indigo-500 border-t-transparent"></div>
                </div>
            </div>
        </div>

        <!-- Quick Access Sidebar -->
        <div class="space-y-6">
            <!-- User Profile Summary -->
            <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl bg-gradient-to-br from-fuchsia-500/10 to-pink-500/10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center text-3xl shadow-lg">
                        <i class="fas fa-user-tie text-fuchsia-600"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-gray-800 dark:text-white"><?php echo $fullname; ?></h4>
                        <p class="text-xs font-bold text-fuchsia-500 uppercase tracking-widest">ผู้บริหารสถานศึกษา</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">ปีการศึกษา</span>
                        <span class="font-bold text-gray-800 dark:text-white"><?php echo $_SESSION['pee'] ?? (date('Y') + 543); ?></span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">ภาคเรียนที่</span>
                        <span class="font-bold text-gray-800 dark:text-white"><?php echo $_SESSION['term'] ?? '1'; ?></span>
                    </div>
                </div>
            </div>

            <!-- Notification Channels -->
            <div class="glass p-8 rounded-[2.5rem] border border-white/20 shadow-xl bg-gradient-to-br from-indigo-500/5 to-purple-500/5">
                <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-6">ช่องทางแจ้งเตือน</h4>
                <div class="flex justify-around">
                    <div class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fab fa-line"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">LINE</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fab fa-discord"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">DISCORD</span>
                    </div>
                    <div class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/30 text-sky-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                            <i class="fab fa-telegram"></i>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400">TELEGRAM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadDirectorStats();
    // Auto refresh every 5 minutes
    setInterval(loadDirectorStats, 300000);
});

function loadDirectorStats() {
    $.ajax({
        url: 'api/overview_stats.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Animate numbers
                animateValue("stat-cars", 0, response.stats.cars_today, 500);
                animateValue("stat-repair", 0, response.stats.repair_pending, 500);
                animateValue("stat-meeting", 0, response.stats.meetings_week, 500);
                
                renderRecentBookings(response.recent_bookings);
            }
        },
        error: function() {
            console.error('Failed to load stats');
        }
    });
}

function animateValue(id, start, end, duration) {
    const obj = document.getElementById(id);
    if (!obj) return;
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

function renderRecentBookings(bookings) {
    const container = $('#recent-bookings');
    container.empty();
    
    if (bookings.length === 0) {
        container.html(`
            <div class="text-center py-20 bg-gray-50/50 dark:bg-slate-800/20 rounded-[2rem] border-2 border-dashed border-gray-200 dark:border-gray-700">
                <i class="fas fa-folder-open text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-400 font-medium">ไม่มีรายการจองรถในขณะนี้</p>
            </div>
        `);
        return;
    }
    
    bookings.forEach((b, index) => {
        const delay = index * 100;
        container.append(`
            <div class="flex items-center gap-6 p-6 rounded-[2rem] bg-white dark:bg-slate-800 border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:scale-[1.01] transition-all group animate-fade-in" style="animation-delay: ${delay}ms">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-blue-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl shrink-0 group-hover:rotate-6 transition-transform">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-lg font-black text-gray-800 dark:text-white truncate">${b.teacher_name}</p>
                        <span class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-[9px] font-black uppercase tracking-tighter">Verified</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate flex items-center gap-2 mt-0.5">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        ${b.destination}
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-black text-indigo-600 dark:text-indigo-400">${b.booking_date}</p>
                    <div class="flex items-center gap-1.5 justify-end mt-1">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">อนุมัติแล้ว</span>
                    </div>
                </div>
            </div>
        `);
    });
}
</script>
