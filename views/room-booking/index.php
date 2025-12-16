<!-- Room Booking Public View Page Content -->
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-500 p-8 md:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -ml-36 -mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative flex flex-col lg:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                    <div class="relative w-32 h-32 md:w-40 md:h-40 flex items-center justify-center bg-white/20 backdrop-blur rounded-full">
                        <span class="text-6xl md:text-7xl">🏢</span>
                    </div>
                </div>
            </div>
            <div class="text-center lg:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    ดูตารางการจอง
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3">
                    จองห้องประชุม
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-6">
                    ตรวจสอบตารางการจองห้องประชุมและสถานที่ต่างๆ
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-5 border-l-4 border-purple-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    📋
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statTotal">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">จองทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-green-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    ✅
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600" id="statApproved">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">อนุมัติแล้ว</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-amber-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    ⏳
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-600" id="statPending">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รออนุมัติ</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-blue-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    🏢
                </div>
                <div>
                    <p class="text-2xl font-bold text-blue-600" id="statRooms">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ห้องประชุม</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-2xl">🔍</span> กรองตารางการจอง
            </h2>
            <div class="flex flex-col sm:flex-row gap-4">
                <select id="filterRoom" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent cursor-pointer min-w-[200px]">
                    <option value="">🏢 ทุกห้อง</option>
                </select>
                <select id="filterMonth" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent cursor-pointer">
                    <option value="1">มกราคม</option>
                    <option value="2">กุมภาพันธ์</option>
                    <option value="3">มีนาคม</option>
                    <option value="4">เมษายน</option>
                    <option value="5">พฤษภาคม</option>
                    <option value="6">มิถุนายน</option>
                    <option value="7">กรกฎาคม</option>
                    <option value="8">สิงหาคม</option>
                    <option value="9">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                </select>
                <select id="filterYear" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-500 rounded-xl text-white text-xl">
                        📅
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">ปฏิทินการจอง</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400" id="calendarTitle">กำลังโหลด...</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="prevMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="goToday()" class="px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg font-medium hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                        วันนี้
                    </button>
                    <button onclick="nextMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-12 h-12 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="mt-4 text-gray-500 dark:text-gray-400">กำลังโหลดตารางการจอง...</p>
            </div>

            <!-- Calendar -->
            <div id="calendarContainer" class="hidden">
                <!-- Calendar Header -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center py-2 text-sm font-bold text-red-500">อา</div>
                    <div class="text-center py-2 text-sm font-bold text-gray-600 dark:text-gray-400">จ</div>
                    <div class="text-center py-2 text-sm font-bold text-gray-600 dark:text-gray-400">อ</div>
                    <div class="text-center py-2 text-sm font-bold text-gray-600 dark:text-gray-400">พ</div>
                    <div class="text-center py-2 text-sm font-bold text-gray-600 dark:text-gray-400">พฤ</div>
                    <div class="text-center py-2 text-sm font-bold text-gray-600 dark:text-gray-400">ศ</div>
                    <div class="text-center py-2 text-sm font-bold text-blue-500">ส</div>
                </div>
                <!-- Calendar Grid -->
                <div id="calendarGrid" class="grid grid-cols-7 gap-1">
                    <!-- Days will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Booking List -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl text-white text-xl">
                    📋
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">รายการจอง</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400" id="bookingResultText">กำลังโหลด...</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div id="emptyBooking" class="hidden text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 dark:text-gray-400">ไม่มีการจองในเดือนนี้</p>
            </div>
            
            <div id="bookingList" class="hidden space-y-4">
                <!-- Booking items will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Room List -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl text-white text-xl">
                    🏢
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">ห้องประชุมทั้งหมด</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รายการห้องประชุมที่พร้อมให้บริการ</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div id="roomList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Room cards will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Booking Detail Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">รายละเอียดการจอง</h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-slate-700 rounded-full transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div id="modalContent" class="p-6">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<script>
let currentMonth = new Date().getMonth() + 1;
let currentYear = new Date().getFullYear();
let allRooms = [];
let allBookings = [];

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

$(document).ready(function() {
    initFilters();
    loadData();
    
    $('#filterRoom, #filterMonth, #filterYear').on('change', function() {
        currentMonth = parseInt($('#filterMonth').val());
        currentYear = parseInt($('#filterYear').val());
        loadData();
    });
});

function initFilters() {
    // Set current month
    $('#filterMonth').val(currentMonth);
    
    // Generate year options
    const thisYear = new Date().getFullYear();
    let yearHtml = '';
    for (let y = thisYear - 2; y <= thisYear + 2; y++) {
        yearHtml += `<option value="${y}" ${y === thisYear ? 'selected' : ''}>${y + 543}</option>`;
    }
    $('#filterYear').html(yearHtml);
}

function loadData() {
    const roomId = $('#filterRoom').val();
    let url = `api/public_room_booking.php?month=${currentMonth}&year=${currentYear}`;
    if (roomId) url += `&room_id=${roomId}`;
    
    $('#loading').removeClass('hidden');
    $('#calendarContainer').addClass('hidden');
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            if (response.success) {
                allRooms = response.rooms;
                allBookings = response.bookings;
                
                updateStats(response.stats, allRooms.length);
                updateRoomFilter();
                renderCalendar();
                renderBookingList();
                renderRoomList();
            }
        },
        error: function() {
            $('#loading').addClass('hidden');
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
        }
    });
}

function updateStats(stats, roomCount) {
    $('#statTotal').text(stats.total.toLocaleString());
    $('#statApproved').text(stats.approved.toLocaleString());
    $('#statPending').text(stats.pending.toLocaleString());
    $('#statRooms').text(roomCount.toLocaleString());
}

function updateRoomFilter() {
    const currentVal = $('#filterRoom').val();
    let html = '<option value="">🏢 ทุกห้อง</option>';
    allRooms.forEach(room => {
        html += `<option value="${room.id}" ${currentVal == room.id ? 'selected' : ''}>${room.emoji || '🏢'} ${room.room_name}</option>`;
    });
    $('#filterRoom').html(html);
}

function renderCalendar() {
    $('#calendarTitle').text(`${thaiMonths[currentMonth]} ${currentYear + 543}`);
    
    const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    const today = new Date();
    
    // Group bookings by date
    const bookingsByDate = {};
    allBookings.forEach(b => {
        const date = b.date;
        if (!bookingsByDate[date]) bookingsByDate[date] = [];
        bookingsByDate[date].push(b);
    });
    
    let html = '';
    
    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        html += '<div class="min-h-[80px] p-1 bg-gray-50 dark:bg-slate-800/30 rounded-lg"></div>';
    }
    
    // Days
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayBookings = bookingsByDate[dateStr] || [];
        const isToday = today.getDate() === day && today.getMonth() === currentMonth - 1 && today.getFullYear() === currentYear;
        const dayOfWeek = new Date(currentYear, currentMonth - 1, day).getDay();
        const isSunday = dayOfWeek === 0;
        const isSaturday = dayOfWeek === 6;
        
        html += `
        <div class="min-h-[80px] p-1 ${isToday ? 'bg-purple-100 dark:bg-purple-900/30 ring-2 ring-purple-500' : 'bg-gray-50 dark:bg-slate-800/50'} rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700/50 transition-colors">
            <div class="text-right mb-1">
                <span class="inline-flex items-center justify-center w-7 h-7 text-sm font-bold ${isToday ? 'bg-purple-500 text-white rounded-full' : isSunday ? 'text-red-500' : isSaturday ? 'text-blue-500' : 'text-gray-700 dark:text-gray-300'}">${day}</span>
            </div>
            <div class="space-y-1 max-h-[60px] overflow-y-auto">
                ${dayBookings.slice(0, 3).map(b => `
                    <div onclick="showBookingDetail(${b.id})" class="text-xs px-1.5 py-0.5 rounded cursor-pointer truncate ${getStatusBgClass(b.status)}" title="${b.room_name} - ${b.purpose}">
                        ${b.room_name ? b.room_name.substring(0, 10) : 'ไม่ระบุห้อง'}
                    </div>
                `).join('')}
                ${dayBookings.length > 3 ? `<div class="text-xs text-center text-gray-500">+${dayBookings.length - 3} อีก</div>` : ''}
            </div>
        </div>
        `;
    }
    
    $('#calendarGrid').html(html);
    $('#calendarContainer').removeClass('hidden');
}

function getStatusBgClass(status) {
    switch(parseInt(status)) {
        case 0: return 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400';
        case 1: return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400';
        case 2: return 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400';
        default: return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400';
    }
}

function renderBookingList() {
    if (allBookings.length === 0) {
        $('#bookingList').addClass('hidden');
        $('#emptyBooking').removeClass('hidden');
        $('#bookingResultText').text('ไม่มีการจอง');
        return;
    }
    
    $('#emptyBooking').addClass('hidden');
    $('#bookingResultText').text(`พบ ${allBookings.length} รายการ`);
    
    let html = '';
    allBookings.forEach(b => {
        const date = formatThaiDate(b.date);
        html += `
        <div onclick="showBookingDetail(${b.id})" class="p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/50 cursor-pointer transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-${b.color || 'purple'}-100 dark:bg-${b.color || 'purple'}-900/30 rounded-xl text-3xl">
                    ${b.emoji || '🏢'}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">${escapeHtml(b.room_name || b.location)}</h4>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium ${getStatusBgClass(b.status)}">${b.status_text}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">${escapeHtml(b.purpose)}</p>
                    <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <span><i class="far fa-calendar-alt mr-1"></i>${date}</span>
                        <span><i class="far fa-clock mr-1"></i>${b.time_start.substring(0,5)} - ${b.time_end.substring(0,5)}</span>
                        <span><i class="far fa-user mr-1"></i>${escapeHtml(b.teacher_name_masked || '-')}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </div>
        </div>
        `;
    });
    
    $('#bookingList').html(html).removeClass('hidden');
}

function renderRoomList() {
    let html = '';
    allRooms.forEach(room => {
        html += `
        <div class="p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl hover:shadow-lg transition-all">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center bg-${room.color || 'blue'}-100 dark:bg-${room.color || 'blue'}-900/30 rounded-xl text-3xl">
                    ${room.emoji || '🏢'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-gray-900 dark:text-white mb-1">${escapeHtml(room.room_name)}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">${escapeHtml(room.building || '-')}</p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                            <i class="fas fa-users mr-1"></i>${room.capacity} คน
                        </span>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#roomList').html(html);
}

function showBookingDetail(id) {
    const booking = allBookings.find(b => b.id == id);
    if (!booking) return;
    
    const date = formatThaiDate(booking.date);
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 flex items-center justify-center bg-${booking.color || 'purple'}-100 dark:bg-${booking.color || 'purple'}-900/30 rounded-xl text-4xl">
                    ${booking.emoji || '🏢'}
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">${escapeHtml(booking.room_name || booking.location)}</h4>
                    <span class="px-3 py-1 rounded-full text-sm font-medium ${getStatusBgClass(booking.status)}">${booking.status_text}</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">วันที่</p>
                    <p class="font-medium text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">เวลา</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.time_start.substring(0,5)} - ${booking.time_end.substring(0,5)}</p>
                </div>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">วัตถุประสงค์</p>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.purpose)}</p>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ผู้จอง</p>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.teacher_name_masked || '-')}</p>
            </div>
            
            ${booking.media ? `
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">อุปกรณ์ที่ต้องการ</p>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.media)}</p>
            </div>
            ` : ''}
        </div>
    `;
    
    $('#modalContent').html(html);
    $('#bookingModal').removeClass('hidden');
}

function closeModal() {
    $('#bookingModal').addClass('hidden');
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 1) {
        currentMonth = 12;
        currentYear--;
    }
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
    }
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
}

function goToday() {
    currentMonth = new Date().getMonth() + 1;
    currentYear = new Date().getFullYear();
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
}

function formatThaiDate(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = thaiMonths[date.getMonth() + 1];
    const year = date.getFullYear() + 543;
    return `${day} ${month} ${year}`;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Close modal on escape
$(document).on('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Close modal on backdrop click
$('#bookingModal').on('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
