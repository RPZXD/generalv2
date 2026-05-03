<!-- Driver Car Booking Page Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🗓️</span> ตารางเวลาการปฏิบัติงาน
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ดูรายละเอียดและตารางการจองรถยนต์ทั้งหมด</p>
        </div>
        <div class="flex items-center gap-2">
            <button id="refreshList" class="p-3 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl shadow-md hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700">
                <i class="fas fa-sync-alt"></i>
            </button>
            <div class="flex bg-gray-100 dark:bg-slate-700 rounded-xl p-1 shadow-inner">
                <button id="showTableBtn" class="view-toggle-btn active px-4 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-list"></i>
                    <span class="hidden sm:inline">รายการ</span>
                </button>
                <button id="showCalendarBtn" class="view-toggle-btn px-4 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="hidden sm:inline">ปฏิทิน</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Time Filtering Shortcuts -->
    <div class="glass rounded-2xl p-4 flex flex-wrap items-center gap-3 overflow-x-auto no-scrollbar">
        <span class="text-sm font-bold text-gray-500 mr-2 flex items-center gap-2"><i class="fas fa-filter text-emerald-500"></i> ตัวกรอง:</span>
        <button class="filter-btn active px-4 py-2 bg-emerald-500 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-emerald-500/30" data-filter="all">ทั้งหมด</button>
        <button class="filter-btn px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-sm font-semibold transition-all shadow-sm border border-gray-200 dark:border-gray-700" data-filter="today">วันนี้</button>
        <button class="filter-btn px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-sm font-semibold transition-all shadow-sm border border-gray-200 dark:border-gray-700" data-filter="tomorrow">พรุ่งนี้</button>
        <button class="filter-btn px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-sm font-semibold transition-all shadow-sm border border-gray-200 dark:border-gray-700" data-filter="week">สัปดาห์นี้</button>
        <button class="filter-btn px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-sm font-semibold transition-all shadow-sm border border-gray-200 dark:border-gray-700" data-filter="month">เดือนนี้</button>
        <button class="filter-btn px-4 py-2 bg-blue-500 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-blue-500/30" data-filter="myjobs">
            <i class="fas fa-user-check mr-1"></i> งานของฉัน
        </button>
        
        <div class="flex items-center gap-2 ml-auto">
            <div class="relative">
                <input type="date" id="startDate" class="px-3 py-2 bg-white dark:bg-slate-800 text-xs rounded-lg border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-emerald-500">
            </div>
            <span class="text-gray-400">-</span>
            <div class="relative">
                <input type="date" id="endDate" class="px-3 py-2 bg-white dark:bg-slate-800 text-xs rounded-lg border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-emerald-500">
            </div>
            <button id="customRangeBtn" class="p-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                <i class="fas fa-search text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div id="tableView" class="space-y-4">
        <!-- Statistics Summary (Filtered) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="statsContainer">
             <!-- Stats will be updated by JS based on filters -->
        </div>

        <!-- Desktop View Table -->
        <div class="hidden md:block glass rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-800 dark:to-slate-700 text-gray-600 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                        <th class="py-4 px-6 font-bold text-sm uppercase">วันเวลาที่ใช้</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase">รถยนต์</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase">ผู้จอง / จุดประสงค์</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase">จุดหมาย</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase text-center">จำนวน</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase">คนขับรถ</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase text-center">สถานะ</th>
                        <th class="py-4 px-6 font-bold text-sm uppercase text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="bookingTableBody" class="divide-y divide-gray-100 dark:divide-gray-800">
                    <!-- Data will be loaded here -->
                    <tr>
                        <td colspan="8" class="py-20 text-center">
                            <div class="loader mx-auto"></div>
                            <p class="mt-4 text-gray-500">กำลังโหลดรายการจอง...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4" id="bookingCardList">
             <!-- Cards for mobile -->
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="hidden space-y-4 animate-fade-in">
        <div class="glass rounded-2xl p-4">
            <div id="carBookingCalendar" class="min-h-[500px]"></div>
        </div>
    </div>
</div>

<!-- Modal รายละเอียดการจอง -->
<div id="detailBookingModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95 opacity-0" id="detailModalContent">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center text-emerald-600 text-2xl">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">รายละเอียดการปฏิบัติงาน</h3>
                        <p class="text-sm text-gray-500" id="detailBookingIdLabel">Booking ID: #000</p>
                    </div>
                </div>
                <button onclick="closeDetailModal()" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-500 hover:text-red-500 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="space-y-6">
                <!-- Status Badge -->
                <div class="flex justify-center" id="detailStatusBadge">
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <span class="text-xs uppercase font-bold text-gray-400">วันเวลาเริ่มต้น</span>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-200" id="detailStart"></p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs uppercase font-bold text-gray-400">วันเวลาสิ้นสุด</span>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-200" id="detailEnd"></p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs uppercase font-bold text-gray-400">รถที่จะใช้งาน</span>
                        <p class="text-lg font-bold text-emerald-600" id="detailCar"></p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs uppercase font-bold text-gray-400">ผู้ขอใช้งาน</span>
                        <p class="text-lg font-bold text-blue-600" id="detailTeacher"></p>
                    </div>
                    <div class="space-y-1 col-span-2 p-3 bg-blue-50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-800">
                        <span class="text-xs uppercase font-bold text-blue-400 block">คนขับรถที่ปฏิบัติหน้าที่</span>
                        <p class="text-lg font-bold text-blue-700 dark:text-blue-300 flex items-center gap-2" id="detailDriver">
                           <i class="fas fa-user-tie"></i> 
                           <span>-</span>
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700/50 rounded-2xl border border-gray-100 dark:border-gray-600">
                    <span class="text-xs uppercase font-bold text-gray-400 block mb-2">จุดหมายปลายทาง</span>
                    <p class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-red-500"></i>
                        <span id="detailDestination"></span>
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <span class="text-xs uppercase font-bold text-gray-400 block mb-2">วัตถุประสงค์</span>
                        <p class="text-gray-700 dark:text-gray-300" id="detailPurpose"></p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-users text-emerald-600"></i>
                        <span class="font-bold text-emerald-800 dark:text-emerald-300">จำนวนผู้โดยสารทั้งหมด</span>
                    </div>
                    <span class="text-2xl font-black text-emerald-600" id="detailTotalPassengers">0</span>
                </div>

                <div id="detailPassengersSection" class="space-y-2">
                    <span class="text-xs uppercase font-bold text-gray-400 block">ผู้โดยสาร (คณะครู/เจ้าหน้าที่)</span>
                    <div id="detailPassengersList" class="flex flex-wrap gap-2"></div>
                </div>

                <div id="detailNotesSection" class="p-4 bg-yellow-50 dark:bg-yellow-900/10 rounded-2xl border border-yellow-200/50 hidden">
                    <span class="text-xs uppercase font-bold text-yellow-600 block mb-1">หมายเหตุชุดคำสั่ง</span>
                    <p class="text-gray-700 dark:text-gray-300 italic text-sm" id="detailNotes"></p>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button onclick="window.print()" class="flex-1 py-4 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> พิมพ์ใบจอง
                </button>
                <button onclick="closeDetailModal()" class="px-8 py-4 bg-emerald-500 text-white font-bold rounded-2xl hover:bg-emerald-600 shadow-lg shadow-emerald-500/30 transition-all">
                    ตกลง
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Switch Logic */
.view-toggle-btn {
    color: #64748b;
}
.view-toggle-btn.active {
    background-color: white;
    color: #10b981;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
.dark .view-toggle-btn.active {
    background-color: #1e293b;
    color: #34d399;
}

/* Scrollbar Hide */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Animations */
@keyframes modalIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.modal-anim-in {
    animation: modalIn 0.3s ease-out forwards;
}

/* Calendar Styles */
.fc-theme-standard .fc-scrollgrid { border: none !important; }
.fc .fc-toolbar-title { font-weight: 800; font-size: 1.25rem !important; }
.fc .fc-button-primary { 
    background-color: transparent !important; 
    border-color: #e2e8f0 !important; 
    color: #64748b !important;
}
.dark .fc .fc-button-primary { border-color: #334155 !important; }
.fc .fc-button-primary:hover { background-color: #f1f5f9 !important; }
.dark .fc .fc-button-primary:hover { background-color: #1e293b !important; }
.fc .fc-button-active { background-color: #10b981 !important; color: white !important; border-color: #10b981 !important; }

/* Status Styles */
.status-approved { background: #d1fae5; color: #065f46; }
.dark .status-approved { background: rgba(5, 150, 105, 0.2); color: #34d399; }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    // Global data passed to script.js
    // Note: currentUserFullname is already defined in app.php layout
    const currentUserTeachId = "<?php echo $teacher_id; ?>";
    const ALL_BOOKINGS = []; 
</script>
<script src="views/car_booking/script.js"></script>
