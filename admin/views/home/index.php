<div class="space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <i class="fas fa-shield-alt text-fuchsia-600"></i>
                แผงควบคุมผู้ดูแลระบบ
            </h1>
            <p class="mt-1 text-gray-500 dark:text-gray-400">ภาพรวมการทำงานและความเคลื่อนไหวของระบบบริหารงานทั่วไป</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-full text-xs font-bold flex items-center gap-2 border border-emerald-100 dark:border-emerald-800">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                ระบบปกติ (Online)
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass p-6 rounded-3xl border border-white/20 shadow-xl card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl">
                    <i class="fas fa-users"></i>
                </div>
                <span class="text-xs font-bold text-gray-400">TOTAL</span>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ผู้ใช้งานทั้งหมด</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1" id="stat-users">-</h3>
        </div>

        <div class="glass p-6 rounded-3xl border border-white/20 shadow-xl card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fas fa-database"></i>
                </div>
                <span class="text-xs font-bold text-gray-400">SQL SIZE</span>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ขนาดฐานข้อมูล</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1" id="stat-db">-</h3>
        </div>

        <div class="glass p-6 rounded-3xl border border-white/20 shadow-xl card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl">
                    <i class="fas fa-archive"></i>
                </div>
                <span class="text-xs font-bold text-gray-400">FILES</span>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ไฟล์สำรองข้อมูล</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1" id="stat-backups">-</h3>
        </div>

        <div class="glass p-6 rounded-3xl border border-white/20 shadow-xl card-hover">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-fuchsia-100 dark:bg-fuchsia-900/30 text-fuchsia-600 dark:text-fuchsia-400 flex items-center justify-center text-xl">
                    <i class="fas fa-microchip"></i>
                </div>
                <span class="text-xs font-bold text-gray-400">PHP <?php echo phpversion(); ?></span>
            </div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">เวอร์ชันเซิร์ฟเวอร์</p>
            <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">PHP 8.2</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quick Actions & Modules -->
        <div class="lg:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border border-white/20">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-th-large text-fuchsia-500"></i>
                    โมดูลการจัดการระบบ
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="users.php" class="flex items-center gap-4 p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-900/10 border border-indigo-100/50 dark:border-indigo-900/20 hover:scale-[1.02] transition-all group">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-500 text-white flex items-center justify-center text-xl shadow-lg shadow-indigo-500/20">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 dark:text-white">จัดการสิทธิ์ผู้ใช้</p>
                            <p class="text-xs text-gray-500">กำหนดกลุ่มผู้ใช้งานและระดับสิทธิ์</p>
                        </div>
                    </a>
                    <a href="settings.php" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 dark:bg-slate-800/10 border border-slate-200/50 dark:border-slate-800/20 hover:scale-[1.02] transition-all group">
                        <div class="w-14 h-14 rounded-2xl bg-slate-600 text-white flex items-center justify-center text-xl shadow-lg shadow-slate-600/20">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 dark:text-white">ตั้งค่าระบบส่วนกลาง</p>
                            <p class="text-xs text-gray-500">จัดการข้อมูลโรงเรียนและเงื่อนไขการจอง</p>
                        </div>
                    </a>
                    <a href="backup.php" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50/50 dark:bg-emerald-900/10 border border-emerald-100/50 dark:border-emerald-900/20 hover:scale-[1.02] transition-all group">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/20">
                            <i class="fas fa-database"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 dark:text-white">สำรองข้อมูลฐานข้อมูล</p>
                            <p class="text-xs text-gray-500">Backup & Restore ความปลอดภัยข้อมูล</p>
                        </div>
                    </a>
                    <a href="logs.php" class="flex items-center gap-4 p-4 rounded-2xl bg-amber-50/50 dark:bg-amber-900/10 border border-amber-100/50 dark:border-amber-900/20 hover:scale-[1.02] transition-all group">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-lg shadow-amber-500/20">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 dark:text-white">ประวัติกิจกรรม</p>
                            <p class="text-xs text-gray-500">ตรวจสอบ Log การเข้าใช้งานย้อนหลัง</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Server Health -->
            <div class="glass p-8 rounded-[2.5rem] border border-white/20">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">ความสมบูรณ์ของระบบ</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-500">MySQL Connectivity</span>
                            <span class="text-emerald-500 font-bold">Stable</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-500">File System Permissions</span>
                            <span class="text-emerald-500 font-bold">Ready</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Logs -->
        <div class="glass p-6 rounded-[2.5rem] border border-white/20 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">กิจกรรมล่าสุด</h2>
                <a href="logs.php" class="text-xs text-fuchsia-600 hover:underline font-bold">ดูทั้งหมด</a>
            </div>
            <div class="space-y-4 flex-1" id="recent-logs">
                <div class="flex justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-4 border-fuchsia-500 border-t-transparent"></div>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-center">
                <p class="text-xs text-gray-400">อัปเดตอัตโนมัติทุก 1 นาที</p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    refreshStats();
    // Auto refresh every minute
    setInterval(refreshStats, 60000);
});

function refreshStats() {
    $.ajax({
        url: 'api/dashboard_stats.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#stat-users').text(response.stats.total_users.toLocaleString());
                $('#stat-db').text(response.stats.db_size);
                $('#stat-backups').text(response.stats.backup_count);
                
                renderRecentLogs(response.stats.recent_logs);
            }
        }
    });
}

function renderRecentLogs(logs) {
    const container = $('#recent-logs');
    container.empty();
    
    if (logs.length === 0) {
        container.html('<p class="text-center text-gray-400 py-8">ไม่มีกิจกรรมล่าสุด</p>');
        return;
    }
    
    logs.forEach(log => {
        const time = formatTime(log.created_at);
        container.append(`
            <div class="flex gap-4 p-3 rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-700 flex items-center justify-center shrink-0">
                    <i class="fas ${getLogIcon(log.type)} text-gray-500 text-xs"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-800 dark:text-white truncate">${log.action}</p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="text-[10px] text-gray-400">${time}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="text-[10px] text-fuchsia-500 font-bold uppercase">${log.user_name}</span>
                    </div>
                </div>
            </div>
        `);
    });
}

function formatTime(dateTimeStr) {
    const date = new Date(dateTimeStr);
    return date.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' }) + ' น.';
}

function getLogIcon(type) {
    switch(type) {
        case 'create': return 'fa-plus';
        case 'update': return 'fa-edit';
        case 'delete': return 'fa-trash';
        case 'login': return 'fa-sign-in-alt';
        default: return 'fa-info-circle';
    }
}
</script>
