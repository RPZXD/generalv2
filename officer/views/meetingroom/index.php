<!-- Meeting Room Management - Tab Layout with Full Calendar -->
<div class="space-y-6">
    <!-- Page Header with Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🏢</span> จัดการจองห้องประชุม
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ตรวจสอบและอนุมัติการจองห้องประชุม</p>
        </div>
        <div class="flex gap-2">
            <button id="refreshData" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl font-medium hover:shadow-lg transition-all flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> รีเฟรช
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="glass rounded-2xl p-4 border-l-4 border-blue-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-xl text-2xl">📋</div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statTotal">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-yellow-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30 rounded-xl text-2xl">⏳</div>
                <div>
                    <p class="text-2xl font-bold text-yellow-600" id="statPending">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">รอการอนุมัติ</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-green-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-xl text-2xl">✅</div>
                <div>
                    <p class="text-2xl font-bold text-green-600" id="statApproved">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">อนุมัติแล้ว</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-red-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-xl text-2xl">❌</div>
                <div>
                    <p class="text-2xl font-bold text-red-600" id="statCanceled">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ยกเลิก</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-fuchsia-500">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-fuchsia-100 dark:bg-fuchsia-900/30 rounded-xl text-2xl">📅</div>
                <div>
                    <p class="text-2xl font-bold text-fuchsia-600" id="statToday">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">วันนี้</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="glass rounded-2xl p-2">
        <div class="flex flex-wrap gap-2">
            <button class="tab-btn active px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="list">
                <span class="text-lg">📋</span> รายการจอง
            </button>
            <button class="tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="calendar">
                <span class="text-lg">📅</span> ปฏิทิน
            </button>
            <button class="tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="rooms">
                <span class="text-lg">🏛️</span> ห้องประชุม
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tabContent">
        <!-- List Tab -->
        <div id="tab-list" class="tab-pane">
            <!-- Filter Buttons -->
            <div class="glass rounded-2xl p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 ring-2 ring-fuchsia-500 bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/30 dark:text-fuchsia-400" data-status="">
                        <span class="text-lg">📋</span> ทั้งหมด
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400" data-status="0">
                        <span class="text-lg">⏳</span> รอการอนุมัติ
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400" data-status="1">
                        <span class="text-lg">✅</span> อนุมัติแล้ว
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400" data-status="2">
                        <span class="text-lg">❌</span> ยกเลิกแล้ว
                    </button>
                </div>
            </div>

            <!-- Booking List -->
            <div class="glass rounded-2xl p-6">
                <div id="bookingList" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="col-span-full text-center py-12 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลดข้อมูล...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Tab -->
        <div id="tab-calendar" class="tab-pane hidden">
            <div class="glass rounded-2xl p-6">
                <!-- Legend (Dynamic from Database) -->
                <div id="calendarLegend" class="flex flex-wrap gap-3 mb-6 p-4 bg-gray-50 dark:bg-slate-800 rounded-xl">
                    <span class="text-gray-500">กำลังโหลดห้องประชุม...</span>
                </div>
                
                <div id="calendar" class="fc-large"></div>
            </div>
        </div>

        <!-- Rooms Tab (Dynamic from Database) -->
        <div id="tab-rooms" class="tab-pane hidden">
            <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-full text-center py-12 text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p>กำลังโหลดข้อมูลห้องประชุม...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <div class="sticky top-0 bg-gradient-to-r from-fuchsia-600 to-purple-600 p-6 rounded-t-2xl">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-xl font-bold text-white flex items-center gap-2" id="detailTitle">
                <span class="text-2xl">🏢</span> รายละเอียดการจอง
            </h3>
        </div>
        <div class="p-6" id="detailContent">
            <!-- Content will be loaded here -->
        </div>
        <div class="p-6 pt-0 flex gap-3" id="detailActions">
            <!-- Actions will be loaded here -->
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <button onclick="closeEditModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">✏️ แก้ไขการจอง</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">แก้ไขรายละเอียดการจอง</p>
            </div>
        </div>

        <form id="editBookingForm" class="space-y-5">
            <input type="hidden" name="id" id="editId">
            <input type="hidden" name="room_id" id="editRoomId">
            <input type="hidden" name="location" id="editLocationName">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📅 วันที่</label>
                    <input type="date" name="date" id="editDate" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🏢 ห้องประชุม</label>
                    <select id="editLocation" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" required>
                        <!-- Options will be loaded dynamically from database -->
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">�� เวลาเริ่ม</label>
                    <input type="time" name="time_start" id="editTimeStart" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🕐 เวลาสิ้นสุด</label>
                    <input type="time" name="time_end" id="editTimeEnd" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🎯 วัตถุประสงค์</label>
                <textarea name="purpose" id="editPurpose" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🪑 รูปแบบการจัดโต๊ะเก้าอี้</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="theater" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">🎭</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">แบบโรงภาพยนตร์</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="classroom" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">🏫</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">แบบห้องเรียน</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="u-shape" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">🔲</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">แบบตัว U</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="boardroom" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">📋</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">แบบโต๊ะประชุม</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="banquet" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">🍽️</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">แบบโต๊ะกลม</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="room_layout" value="none" class="hidden peer">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">➖</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">ไม่ระบุ</div>
                        </div>
                    </label>
                    <label class="cursor-pointer col-span-2">
                        <input type="radio" name="room_layout" value="other" class="hidden peer" id="editLayoutCustomRadio">
                        <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 peer-checked:border-fuchsia-500 peer-checked:bg-fuchsia-50 dark:peer-checked:bg-fuchsia-900/20 transition-all text-center hover:border-fuchsia-300">
                            <div class="text-2xl mb-1">✏️</div>
                            <div class="text-xs font-medium text-gray-700 dark:text-gray-300">อื่นๆ (กรอกเอง)</div>
                        </div>
                    </label>
                </div>
                <!-- Custom Layout Input -->
                <div id="customLayoutWrapper" class="mt-3 hidden">
                    <input type="text" name="room_layout_custom" id="editRoomLayoutCustom" 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" 
                        placeholder="อธิบายรูปแบบการจัดโต๊ะเก้าอี้ที่ต้องการ...">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🛠️ อุปกรณ์</label>
                    <input type="text" name="media" id="editMedia" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" placeholder="ไมค์, โปรเจคเตอร์...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📞 เบอร์โทร</label>
                    <input type="tel" name="phone" id="editPhone" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent" placeholder="0xx-xxx-xxxx">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-fuchsia-500 to-purple-500 hover:from-fuchsia-600 hover:to-purple-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>บันทึกการแก้ไข</span>
            </button>
        </form>
    </div>
</div>

<style>
/* Loader */
.loader {
    width: 48px;
    height: 48px;
    border: 4px solid #e5e7eb;
    border-top-color: #d946ef;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Scale In Animation */
@keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.animate-scale-in { animation: scale-in 0.2s ease-out; }

/* Tab Styles */
.tab-btn {
    background: transparent;
    color: #6b7280;
}
.tab-btn:hover {
    background: rgba(217, 70, 239, 0.1);
    color: #d946ef;
}
.tab-btn.active {
    background: linear-gradient(135deg, #d946ef, #a855f7);
    color: white;
    box-shadow: 0 4px 15px rgba(217, 70, 239, 0.3);
}
.dark .tab-btn {
    color: #9ca3af;
}
.dark .tab-btn:hover {
    color: #d946ef;
}

/* Room Stat Badge */
.room-stat-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 9999px;
    background: rgba(0,0,0,0.05);
}
.dark .room-stat-badge {
    background: rgba(255,255,255,0.1);
}

/* FullCalendar Large */
.fc-large {
    font-family: 'Mali', sans-serif !important;
}
.fc-large .fc-toolbar-title {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
}
.fc-large .fc-button {
    padding: 0.5rem 1rem !important;
    border-radius: 0.75rem !important;
    font-weight: 500 !important;
}
.fc-large .fc-button-primary {
    background: linear-gradient(135deg, #d946ef, #a855f7) !important;
    border: none !important;
}
.fc-large .fc-button-primary:hover {
    background: linear-gradient(135deg, #c026d3, #9333ea) !important;
}
.fc-large .fc-event {
    border-radius: 6px !important;
    padding: 4px 8px !important;
    font-size: 0.8rem !important;
    cursor: pointer !important;
    border: none !important;
}
.fc-large .fc-daygrid-day-number {
    font-size: 1rem !important;
    padding: 8px !important;
}
.fc-large .fc-col-header-cell-cushion {
    font-size: 0.9rem !important;
    font-weight: 600 !important;
}

/* Custom Scrollbar */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #d946ef; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #c026d3; }
</style>

<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
let calendar;
let currentFilter = '';
let allBookings = [];
let currentTab = 'list';
let roomsData = []; // Store rooms data from database

$(document).ready(function() {
    fetchRoomsData(); // Load rooms first
    fetchBookings();
    setupEventHandlers();
});

function initCalendar() {
    if (calendar) return;
    
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        height: 700,
        dayMaxEvents: 3,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            const events = allBookings.filter(b => b.status != 2).map(function(booking) {
                let color = getRoomColor(booking.location);
                
                return {
                    id: booking.id,
                    title: `${booking.location.substring(0, 8)} - ${booking.teacher_name || 'ไม่ระบุ'}`,
                    start: `${booking.date}T${booking.time_start}`,
                    end: `${booking.date}T${booking.time_end}`,
                    color: booking.status == 0 ? '#fbbf24' : color,
                    extendedProps: { booking: booking }
                };
            });
            successCallback(events);
        },
        eventClick: function(info) {
            showDetailModal(info.event.extendedProps.booking);
        }
    });
    calendar.render();
}

// Fetch rooms from database
function fetchRoomsData() {
    $.ajax({
        url: 'api/get_rooms.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            roomsData = response.rooms || [];
            renderRoomsTab();
            renderCalendarLegend();
            loadRoomDropdown();
        },
        error: function() {
            console.error('Failed to load rooms');
            roomsData = [];
        }
    });
}

// Render Rooms Tab with dynamic data
function renderRoomsTab() {
    if (roomsData.length === 0) {
        $('#roomsGrid').html('<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">🏢</div><p class="text-gray-500">ยังไม่มีห้องประชุมในระบบ</p><p class="text-sm text-gray-400 mt-2">กรุณาเพิ่มห้องประชุมในหน้าตั้งค่า</p></div>');
        return;
    }
    
    let html = '';
    roomsData.forEach(room => {
        if (room.status != 1) return; // Only show active rooms
        
        const emoji = room.emoji || '🏢';
        const color = room.color || 'blue';
        const gradientMap = {
            'red': 'from-red-500 to-rose-600',
            'blue': 'from-blue-500 to-indigo-600',
            'green': 'from-green-500 to-emerald-600',
            'amber': 'from-amber-500 to-orange-600',
            'purple': 'from-purple-500 to-violet-600',
            'pink': 'from-pink-500 to-rose-600',
            'cyan': 'from-cyan-500 to-teal-600',
            'orange': 'from-orange-500 to-red-600'
        };
        const textColorMap = {
            'red': 'text-red-500',
            'blue': 'text-blue-500',
            'green': 'text-green-500',
            'amber': 'text-amber-500',
            'purple': 'text-purple-500',
            'pink': 'text-pink-500',
            'cyan': 'text-cyan-500',
            'orange': 'text-orange-500'
        };
        const gradient = gradientMap[color] || 'from-blue-500 to-indigo-600';
        const textColor = textColorMap[color] || 'text-blue-500';
        
        html += `
        <div class="glass rounded-2xl overflow-hidden group hover:shadow-xl transition-all">
            <div class="h-32 bg-gradient-to-br ${gradient} flex items-center justify-center">
                <span class="text-6xl">${emoji}</span>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">${room.room_name}</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p><i class="fas fa-users mr-2 ${textColor}"></i>ความจุ: ${room.capacity || 0} คน</p>
                    <p><i class="fas fa-map-marker-alt mr-2 ${textColor}"></i>${room.building || '-'}</p>
                    <p><i class="fas fa-cog mr-2 ${textColor}"></i>${room.equipment || '-'}</p>
                </div>
                <div class="mt-4 flex gap-2">
                    <span class="room-stat-badge" data-room="${room.room_name}" data-type="pending">⏳ 0</span>
                    <span class="room-stat-badge" data-room="${room.room_name}" data-type="approved">✅ 0</span>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#roomsGrid').html(html || '<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">🏢</div><p class="text-gray-500">ไม่มีห้องประชุมที่เปิดใช้งาน</p></div>');
}

// Render Calendar Legend dynamically
function renderCalendarLegend() {
    if (roomsData.length === 0) {
        $('#calendarLegend').html('<span class="text-gray-500">ไม่มีข้อมูลห้องประชุม</span>');
        return;
    }
    
    const bgColorMap = {
        'red': 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        'blue': 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'green': 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
        'amber': 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'purple': 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
        'pink': 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400',
        'cyan': 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
        'orange': 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400'
    };
    const dotColorMap = {
        'red': 'bg-red-500',
        'blue': 'bg-blue-500',
        'green': 'bg-green-500',
        'amber': 'bg-amber-500',
        'purple': 'bg-purple-500',
        'pink': 'bg-pink-500',
        'cyan': 'bg-cyan-500',
        'orange': 'bg-orange-500'
    };
    
    let html = '';
    roomsData.forEach(room => {
        if (room.status != 1) return;
        const color = room.color || 'blue';
        const bgClass = bgColorMap[color] || 'bg-blue-100 text-blue-700';
        const dotClass = dotColorMap[color] || 'bg-blue-500';
        
        html += `
        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg ${bgClass} font-medium text-sm">
            <span class="w-3 h-3 rounded-full ${dotClass}"></span> ${room.room_name}
        </span>
        `;
    });
    
    $('#calendarLegend').html(html || '<span class="text-gray-500">ไม่มีห้องประชุมที่เปิดใช้งาน</span>');
}

// Load room dropdown for edit form - ใช้ room_id เป็น value
function loadRoomDropdown() {
    let options = '';
    roomsData.forEach(room => {
        if (room.status != 1) return;
        const emoji = room.emoji || '🏢';
        options += `<option value="${room.id}" data-name="${room.room_name}">${emoji} ${room.room_name}</option>`;
    });
    
    $('#editLocation').html(options || '<option value="">ไม่มีห้องประชุม</option>');
    
    // เพิ่ม event listener เพื่ออัพเดท hidden fields เมื่อเลือกห้อง
    $('#editLocation').off('change.roomId').on('change.roomId', function() {
        const selectedOption = $(this).find('option:selected');
        $('#editRoomId').val($(this).val());
        $('#editLocationName').val(selectedOption.data('name') || '');
    });
}

// Get room color by name from database
function getRoomColor(roomName) {
    const room = roomsData.find(r => roomName.includes(r.room_name) || r.room_name.includes(roomName));
    if (room) {
        const colorHex = {
            'red': '#ef4444',
            'blue': '#3b82f6',
            'green': '#22c55e',
            'amber': '#f59e0b',
            'purple': '#8b5cf6',
            'pink': '#ec4899',
            'cyan': '#06b6d4',
            'orange': '#f97316'
        };
        return colorHex[room.color] || '#8b5cf6';
    }
    return '#8b5cf6';
}

// Get room emoji by name from database
function getRoomEmoji(roomName) {
    const room = roomsData.find(r => roomName.includes(r.room_name) || r.room_name.includes(roomName));
    return room ? (room.emoji || '🏢') : '🏢';
}

function fetchBookings() {
    $.ajax({
        url: 'api/room_booking_list.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $('#bookingList').html('<div class="col-span-full text-center py-12"><div class="loader mx-auto mb-4"></div><p class="text-gray-400">กำลังโหลด...</p></div>');
        },
        success: function(response) {
            allBookings = response.list || [];
            updateStats();
            renderBookings(filterBookings());
            updateRoomStats();
            if (calendar) calendar.refetchEvents();
        },
        error: function() {
            $('#bookingList').html('<div class="col-span-full text-center py-12 text-red-500"><i class="fas fa-exclamation-circle text-5xl mb-4"></i><p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>');
        }
    });
}

function updateStats() {
    const today = new Date().toISOString().split('T')[0];
    const pending = allBookings.filter(b => b.status == 0).length;
    const approved = allBookings.filter(b => b.status == 1).length;
    const canceled = allBookings.filter(b => b.status == 2).length;
    const todayCount = allBookings.filter(b => b.date === today && b.status == 1).length;
    
    $('#statTotal').text(allBookings.length);
    $('#statPending').text(pending);
    $('#statApproved').text(approved);
    $('#statCanceled').text(canceled);
    $('#statToday').text(todayCount);
}

function updateRoomStats() {
    roomsData.forEach(room => {
        if (room.status != 1) return;
        const pending = allBookings.filter(b => b.location.includes(room.room_name) && b.status == 0).length;
        const approved = allBookings.filter(b => b.location.includes(room.room_name) && b.status == 1).length;
        $(`.room-stat-badge[data-room="${room.room_name}"][data-type="pending"]`).text(`⏳ ${pending}`);
        $(`.room-stat-badge[data-room="${room.room_name}"][data-type="approved"]`).text(`✅ ${approved}`);
    });
}

function filterBookings() {
    if (currentFilter === '') return allBookings;
    return allBookings.filter(b => b.status == currentFilter);
}

function renderBookings(bookings) {
    if (bookings.length === 0) {
        $('#bookingList').html('<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">📭</div><p class="text-gray-500">ไม่พบรายการจอง</p></div>');
        return;
    }

    let html = '';
    bookings.forEach(function(booking) {
        let statusInfo = getStatusInfo(booking.status);
        let roomEmoji = getRoomEmoji(booking.location);
        let layoutInfo = getRoomLayoutInfo(booking.room_layout);
        
        const dateObj = new Date(booking.date);
        const formattedDate = dateObj.toLocaleDateString('th-TH', { weekday: 'short', day: 'numeric', month: 'short', year: '2-digit' });

        html += `
        <div class="bg-white dark:bg-slate-800 rounded-2xl border-l-4 ${statusInfo.border} shadow-sm hover:shadow-lg transition-all overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">${roomEmoji}</span>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">${booking.location}</h4>
                            <p class="text-xs text-gray-500">#${booking.id}</p>
                        </div>
                    </div>
                    ${statusInfo.badge}
                </div>
                
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-fuchsia-500">📅</span>
                        <span>${formattedDate}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-fuchsia-500">⏰</span>
                        <span>${booking.time_start} - ${booking.time_end}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-fuchsia-500">👨‍🏫</span>
                        <span class="truncate">${booking.teacher_name || 'รหัส: ' + booking.teach_id}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-fuchsia-500">${layoutInfo.emoji}</span>
                        <span>${layoutInfo.name}</span>
                    </div>
                </div>
                
                <div class="mb-4 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>🎯 วัตถุประสงค์:</strong> ${booking.purpose}</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <button onclick="showDetailModal(${JSON.stringify(booking).replace(/"/g, '&quot;')})" class="flex-1 px-4 py-2 bg-fuchsia-100 dark:bg-fuchsia-900/30 text-fuchsia-700 dark:text-fuchsia-400 rounded-xl text-sm font-medium hover:bg-fuchsia-200 dark:hover:bg-fuchsia-900/50 transition-colors">
                        <i class="fas fa-eye mr-1"></i>ดู
                    </button>
                    <button onclick="openEditModal(${booking.id})" class="px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-xl text-sm font-medium hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors">
                        <i class="fas fa-edit mr-1"></i>แก้ไข
                    </button>
                    ${booking.status == 0 ? `
                    <button onclick="updateStatus(${booking.id}, 1)" class="px-4 py-2 bg-green-500 text-white rounded-xl text-sm font-medium hover:bg-green-600 transition-colors" title="อนุมัติ">
                        <i class="fas fa-check"></i>
                    </button>
                    <button onclick="updateStatus(${booking.id}, 2)" class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition-colors" title="ยกเลิก">
                        <i class="fas fa-times"></i>
                    </button>
                    ` : ''}
                </div>
            </div>
        </div>
        `;
    });
    $('#bookingList').html(html);
}

function setupEventHandlers() {
    // Tab switching
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        switchTab(tab);
    });

    // Filter buttons
    $('.status-filter-btn').on('click', function() {
        $('.status-filter-btn').removeClass('ring-2 ring-fuchsia-500 bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/30 dark:text-fuchsia-400');
        $(this).addClass('ring-2 ring-fuchsia-500 bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/30 dark:text-fuchsia-400');
        currentFilter = $(this).data('status');
        renderBookings(filterBookings());
    });

    // Refresh
    $('#refreshData').on('click', function() {
        fetchBookings();
    });

    // Edit form submit
    $('#editBookingForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        Swal.fire({
            title: 'กำลังบันทึก...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        $.post('api/edit_booking_by_officer.php', formData, function(response) {
            if (response.success) {
                Swal.fire({icon: 'success', title: 'สำเร็จ!', text: 'บันทึกการแก้ไขเรียบร้อย', timer: 1500, showConfirmButton: false});
                closeEditModal();
                fetchBookings();
            } else {
                Swal.fire({icon: 'error', title: 'ผิดพลาด', text: response.message || 'ไม่สามารถบันทึกได้'});
            }
        }, 'json').fail(function() {
            Swal.fire({icon: 'error', title: 'ผิดพลาด', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ'});
        });
    });
}

function switchTab(tab) {
    currentTab = tab;
    $('.tab-btn').removeClass('active');
    $(`.tab-btn[data-tab="${tab}"]`).addClass('active');
    $('.tab-pane').addClass('hidden');
    $(`#tab-${tab}`).removeClass('hidden');
    
    if (tab === 'calendar') {
        setTimeout(() => initCalendar(), 100);
    }
}

function showDetailModal(booking) {
    const dateObj = new Date(booking.date);
    const formattedDate = dateObj.toLocaleDateString('th-TH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    const statusInfo = getStatusInfo(booking.status);
    const layoutInfo = getRoomLayoutInfo(booking.room_layout);
    const roomEmoji = getRoomEmoji(booking.location);
    
    $('#detailTitle').html(`<span class="text-2xl mr-2">${roomEmoji}</span>${booking.location}`);
    
    $('#detailContent').html(`
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <span class="text-gray-600 dark:text-gray-400">สถานะ</span>
                ${statusInfo.badge}
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">📅 วันที่</p>
                    <p class="font-medium text-gray-900 dark:text-white">${formattedDate}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">⏰ เวลา</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.time_start} - ${booking.time_end} น.</p>
                </div>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">🎯 วัตถุประสงค์</p>
                <p class="font-medium text-gray-900 dark:text-white">${booking.purpose}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">👨‍🏫 ผู้จอง</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.teacher_name || 'รหัส: ' + booking.teach_id}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">📞 เบอร์โทร</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.phone || '-'}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">🪑 รูปแบบจัดโต๊ะเก้าอี้</p>
                    <p class="font-medium text-gray-900 dark:text-white">${layoutInfo.emoji} ${layoutInfo.name}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">🛠️ อุปกรณ์</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.media || '-'}</p>
                </div>
            </div>
        </div>
    `);
    
    let actionsHtml = `
        <button onclick="openEditModal(${booking.id})" class="flex-1 px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-edit"></i> แก้ไข
        </button>
    `;
    
    if (booking.status == 0) {
        actionsHtml += `
            <button onclick="updateStatus(${booking.id}, 1); closeDetailModal();" class="flex-1 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-check"></i> อนุมัติ
            </button>
            <button onclick="updateStatus(${booking.id}, 2); closeDetailModal();" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-times"></i> ยกเลิก
            </button>
        `;
    }
    
    $('#detailActions').html(actionsHtml);
    $('#detailModal').removeClass('hidden');
}

function closeDetailModal() {
    $('#detailModal').addClass('hidden');
}

function openEditModal(id) {
    closeDetailModal();
    $.get('api/room_booking_detail.php', { id: id }, function(response) {
        if (response.success && response.booking) {
            const b = response.booking;
            $('#editId').val(b.id);
            $('#editDate').val(b.date);
            
            // Set room - ใช้ room_id ถ้ามี ไม่งั้นหาจากชื่อห้อง
            if (b.room_id) {
                $('#editLocation').val(b.room_id);
                $('#editRoomId').val(b.room_id);
                $('#editLocationName').val(b.location);
            } else {
                // Fallback: หาห้องจากชื่อ
                const room = roomsData.find(r => r.room_name === b.location);
                if (room) {
                    $('#editLocation').val(room.id);
                    $('#editRoomId').val(room.id);
                    $('#editLocationName').val(b.location);
                } else {
                    $('#editLocation').val('');
                    $('#editRoomId').val('');
                    $('#editLocationName').val(b.location);
                }
            }
            
            $('#editTimeStart').val(b.time_start);
            $('#editTimeEnd').val(b.time_end);
            $('#editPurpose').val(b.purpose);
            $('#editMedia').val(b.media || '');
            $('#editPhone').val(b.phone || '');
            
            // Handle room layout
            $('input[name="room_layout"]').prop('checked', false);
            $('#editRoomLayoutCustom').val('');
            $('#customLayoutWrapper').addClass('hidden');
            
            const layout = b.room_layout || 'none';
            const standardLayouts = ['none', 'theater', 'classroom', 'u-shape', 'boardroom', 'banquet', 'other'];
            
            if (layout.startsWith('custom:')) {
                // Custom layout with value (e.g., "custom:วงกลม")
                $('input[name="room_layout"][value="other"]').prop('checked', true);
                $('#editRoomLayoutCustom').val(layout.replace('custom:', ''));
                $('#customLayoutWrapper').removeClass('hidden');
            } else if (standardLayouts.includes(layout)) {
                $(`input[name="room_layout"][value="${layout}"]`).prop('checked', true);
                if (layout === 'other') {
                    $('#customLayoutWrapper').removeClass('hidden');
                }
            } else {
                // Unknown layout - treat as other/custom
                $('input[name="room_layout"][value="other"]').prop('checked', true);
                $('#editRoomLayoutCustom').val(layout);
                $('#customLayoutWrapper').removeClass('hidden');
            }
            
            $('#editModal').removeClass('hidden');
        }
    }, 'json');
}

function closeEditModal() {
    $('#editModal').addClass('hidden');
}

function updateStatus(id, status) {
    const action = status == 1 ? 'อนุมัติ' : 'ยกเลิก';
    
    Swal.fire({
        title: `ยืนยัน${action}?`,
        text: `คุณต้องการ${action}การจองนี้ใช่หรือไม่?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: status == 1 ? '#22c55e' : '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: `ใช่, ${action}`,
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api/room_booking_status.php', { id: id, status: status }, function(response) {
                if (response.success) {
                    Swal.fire({icon: 'success', title: 'สำเร็จ!', text: `${action}เรียบร้อยแล้ว`, timer: 1500, showConfirmButton: false});
                    fetchBookings();
                } else {
                    Swal.fire({icon: 'error', title: 'ผิดพลาด', text: response.message || 'ไม่สามารถอัปเดตสถานะได้'});
                }
            }, 'json');
        }
    });
}

// Helper Functions
function getStatusInfo(status) {
    const statuses = {
        0: { badge: '<span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full font-medium">⏳ รอการอนุมัติ</span>', border: 'border-yellow-400' },
        1: { badge: '<span class="px-3 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full font-medium">✅ อนุมัติแล้ว</span>', border: 'border-green-400' },
        2: { badge: '<span class="px-3 py-1 text-xs bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full font-medium">❌ ยกเลิก</span>', border: 'border-red-400' }
    };
    return statuses[status] || statuses[0];
}

function getRoomLayoutInfo(layout) {
    const layouts = {
        'none': { emoji: '➖', name: 'ไม่ระบุ' },
        'theater': { emoji: '🎭', name: 'แบบโรงภาพยนตร์' },
        'classroom': { emoji: '🏫', name: 'แบบห้องเรียน' },
        'u-shape': { emoji: '🔲', name: 'แบบตัว U' },
        'boardroom': { emoji: '📋', name: 'แบบโต๊ะประชุม' },
        'banquet': { emoji: '🍽️', name: 'แบบโต๊ะกลม' },
        'other': { emoji: '✏️', name: 'อื่นๆ' }
    };

    // Handle custom layout with value (e.g., "custom:วงกลม")
    if (layout && layout.startsWith('custom:')) {
        return { emoji: '✏️', name: layout.replace('custom:', '') };
    }

    return layouts[layout] || { emoji: '✏️', name: layout || '-' };
}

// Toggle custom layout input
$(document).on('change', 'input[name="room_layout"]', function() {
    if ($(this).val() === 'other') {
        $('#customLayoutWrapper').removeClass('hidden');
        $('#editRoomLayoutCustom').focus();
    } else {
        $('#customLayoutWrapper').addClass('hidden');
        $('#editRoomLayoutCustom').val('');
    }
});

// Close modals on outside click
$('#detailModal, #editModal').on('click', function(e) {
    if (e.target === this) {
        $(this).addClass('hidden');
    }
});
</script>
