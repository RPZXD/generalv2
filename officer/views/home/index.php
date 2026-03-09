<!-- Officer Dashboard Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">👔</span> แผงควบคุมเจ้าหน้าที่
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ยินดีต้อนรับเข้าสู่ระบบบริหารงานทั่วไป</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/30 dark:text-fuchsia-400">
                <span class="w-2 h-2 bg-fuchsia-500 rounded-full mr-2 animate-pulse"></span>
                Officer Portal
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Repair Stats -->
        <div class="glass rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">แจ้งซ่อมรอดำเนินการ</p>
                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400" id="pendingRepairs">-</p>
                </div>
                <div
                    class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl shadow-lg">
                    <i class="fas fa-tools text-2xl text-white"></i>
                </div>
            </div>
            <a href="repair.php" class="mt-4 inline-flex items-center text-sm text-amber-600 hover:text-amber-700">
                ดูทั้งหมด <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Room Booking Stats -->
        <div class="glass rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">จองห้องรออนุมัติ</p>
                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400" id="pendingRooms">-</p>
                </div>
                <div
                    class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl shadow-lg">
                    <i class="fas fa-door-open text-2xl text-white"></i>
                </div>
            </div>
            <a href="meetingroom.php"
                class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700">
                ดูทั้งหมด <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <!-- Newsletter Stats -->
        <div class="glass rounded-2xl p-6 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">จดหมายข่าวทั้งหมด</p>
                    <p class="text-3xl font-bold text-cyan-600 dark:text-cyan-400" id="totalNewsletters">-</p>
                </div>
                <div
                    class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-cyan-400 to-sky-500 rounded-2xl shadow-lg">
                    <i class="fas fa-newspaper text-2xl text-white"></i>
                </div>
            </div>
            <a href="newsletter.php" class="mt-4 inline-flex items-center text-sm text-cyan-600 hover:text-cyan-700">
                ดูทั้งหมด <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="glass rounded-2xl p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="text-2xl">⚡</span> การดำเนินการด่วน
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <a href="repair.php"
                    class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl hover:shadow-lg transition-all group">
                    <div class="flex items-center gap-3">
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-amber-500 rounded-lg text-white group-hover:scale-110 transition-transform">
                            <i class="fas fa-tools"></i>
                        </span>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">จัดการแจ้งซ่อม</p>
                            <p class="text-xs text-gray-500">🔧 อัปเดตสถานะงานซ่อม</p>
                        </div>
                    </div>
                </a>
                <a href="meetingroom.php"
                    class="p-4 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl hover:shadow-lg transition-all group">
                    <div class="flex items-center gap-3">
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-indigo-500 rounded-lg text-white group-hover:scale-110 transition-transform">
                            <i class="fas fa-door-open"></i>
                        </span>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">อนุมัติห้องประชุม</p>
                            <p class="text-xs text-gray-500">🏢 ตรวจสอบการจอง</p>
                        </div>
                    </div>
                </a>
                <a href="settings.php"
                    class="p-4 bg-gradient-to-br from-slate-50 to-gray-50 dark:from-slate-900/20 dark:to-gray-900/20 rounded-xl hover:shadow-lg transition-all group">
                    <div class="flex items-center gap-3">
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-slate-500 rounded-lg text-white group-hover:scale-110 transition-transform">
                            <i class="fas fa-cog"></i>
                        </span>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white">ตั้งค่าระบบ</p>
                            <p class="text-xs text-gray-500">⚙️ จัดการห้อง/รถ</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- User Guide -->
        <div class="glass rounded-2xl p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                <span class="text-2xl">📖</span> คู่มือการใช้งาน
            </h2>
            <div class="space-y-3">
                <div class="flex items-start gap-3 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                    <span class="text-2xl">🔧</span>
                    <div>
                        <p class="font-medium text-gray-800 dark:text-white">แจ้งซ่อม</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">ตรวจสอบรายการแจ้งซ่อม อัปเดตสถานะงานซ่อม
                            และจัดการข้อมูลการซ่อมแซม</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl">
                    <span class="text-2xl">🏢</span>
                    <div>
                        <p class="font-medium text-gray-800 dark:text-white">จองห้องประชุม</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">ตรวจสอบและอนุมัติการจองห้องประชุม
                            ดูตารางการใช้งานห้อง</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 p-3 bg-fuchsia-50 dark:bg-fuchsia-900/20 rounded-xl">
                <p class="text-sm text-fuchsia-700 dark:text-fuchsia-400 flex items-center gap-2">
                    <span>💡</span>
                    หากต้องการความช่วยเหลือเพิ่มเติม กรุณาติดต่อผู้ดูแลระบบ
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Load stats
        loadStats();
    });

    function loadStats() {
        // Load pending repairs
        $.get('api/repair_list.php', function (data) {
            if (data.list) {
                const pending = data.list.filter(r => r.status == 0 || r.status == 1).length;
                $('#pendingRepairs').text(pending);
            }
        }).fail(() => $('#pendingRepairs').text('0'));

        // Load pending room bookings
        $.get('api/room_booking_list.php', function (data) {
            if (data.list) {
                const pending = data.list.filter(b => b.status == 0).length;
                $('#pendingRooms').text(pending);
            }
        }).fail(() => $('#pendingRooms').text('0'));

        // Load newsletters
        $.get('api/newsletter_list.php', function (data) {
            if (data.list) {
                $('#totalNewsletters').text(data.list.length);
            }
        }).fail(() => $('#totalNewsletters').text('0'));
    }
</script>