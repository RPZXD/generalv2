<!-- Car Booking Management - Tab Layout with Full Calendar -->
<div class="space-y-6">
    <!-- Page Header with Stats -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🚗</span> จัดการจองรถ
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ตรวจสอบและอนุมัติการจองรถราชการ</p>
        </div>
        <div class="flex gap-2">
            <button id="refreshData" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl font-medium hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> รีเฟรช
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="glass rounded-2xl p-4 border-l-4 border-blue-500 hover:shadow-lg transition-all">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-xl text-2xl">📋</div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statTotal">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-yellow-500 hover:shadow-lg transition-all">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30 rounded-xl text-2xl">⏳</div>
                <div>
                    <p class="text-2xl font-bold text-yellow-600" id="statPending">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">รอการอนุมัติ</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-green-500 hover:shadow-lg transition-all">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-xl text-2xl">✅</div>
                <div>
                    <p class="text-2xl font-bold text-green-600" id="statApproved">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">อนุมัติแล้ว</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-red-500 hover:shadow-lg transition-all">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-red-100 dark:bg-red-900/30 rounded-xl text-2xl">❌</div>
                <div>
                    <p class="text-2xl font-bold text-red-600" id="statRejected">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ยกเลิก</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-emerald-500 hover:shadow-lg transition-all">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-2xl">📅</div>
                <div>
                    <p class="text-2xl font-bold text-emerald-600" id="statToday">0</p>
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
            <button class="tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="cars">
                <span class="text-lg">🚙</span> รถยนต์
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tabContent">
        <!-- List Tab -->
        <div id="tab-list" class="tab-pane">
            <!-- Filter Buttons -->
            <div class="glass rounded-2xl p-4 mb-6">
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 ring-2 ring-emerald-500 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400" data-status="">
                        <span class="text-lg">📋</span> ทั้งหมด
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400" data-status="pending">
                        <span class="text-lg">⏳</span> รอการอนุมัติ
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400" data-status="approved">
                        <span class="text-lg">✅</span> อนุมัติแล้ว
                    </button>
                    <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400" data-status="rejected">
                        <span class="text-lg">❌</span> ยกเลิกแล้ว
                    </button>
                </div>
                
                <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <span class="flex items-center text-sm text-gray-500 mr-2">ช่วงเวลา:</span>
                    <button class="date-filter-btn active px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 ring-2 ring-blue-500 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400" data-filter="all">
                        <span class="text-lg">📅</span> ทั้งหมด
                    </button>
                    <button class="date-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300" data-filter="today">
                        <span class="text-lg">📆</span> วันนี้
                    </button>
                    <button class="date-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300" data-filter="month">
                        <span class="text-lg">🗓️</span> เดือนนี้
                    </button>
                    <button class="date-filter-btn px-4 py-2 rounded-xl font-medium text-sm transition-all flex items-center gap-2 bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300" data-filter="year">
                        <span class="text-lg">📅</span> ปีนี้
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
                    <span class="text-gray-500">กำลังโหลดข้อมูลรถยนต์...</span>
                </div>
                
                <div id="calendar" class="fc-large"></div>
            </div>
        </div>

        <!-- Cars Tab (Dynamic from Database) -->
        <div id="tab-cars" class="tab-pane hidden">
            <div id="carsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="col-span-full text-center py-12 text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p>กำลังโหลดข้อมูลรถยนต์...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <div class="sticky top-0 bg-gradient-to-r from-emerald-600 to-teal-600 p-6 rounded-t-2xl">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-xl font-bold text-white flex items-center gap-2" id="detailTitle">
                <span class="text-2xl">🚗</span> รายละเอียดการจอง
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

<style>
/* Loader */
.loader {
    width: 48px;
    height: 48px;
    border: 4px solid #e5e7eb;
    border-top-color: #10b981;
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
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}
.tab-btn.active {
    background: linear-gradient(135deg, #10b981, #14b8a6);
    color: white;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}
.dark .tab-btn {
    color: #9ca3af;
}
.dark .tab-btn:hover {
    color: #10b981;
}

/* Car Stat Badge */
.car-stat-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 9999px;
    background: rgba(0,0,0,0.05);
}
.dark .car-stat-badge {
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
    background: linear-gradient(135deg, #10b981, #14b8a6) !important;
    border: none !important;
}
.fc-large .fc-button-primary:hover {
    background: linear-gradient(135deg, #059669, #0d9488) !important;
}
.fc-large .fc-button-primary:disabled {
    background: linear-gradient(135deg, #10b981, #14b8a6) !important;
    opacity: 0.7;
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

/* Dark Mode Calendar */
.dark .fc-large .fc-toolbar-title,
.dark .fc-large .fc-col-header-cell-cushion,
.dark .fc-large .fc-daygrid-day-number {
    color: #e5e7eb !important;
}
.dark .fc-large .fc-day {
    background: rgba(30, 41, 59, 0.5) !important;
}
.dark .fc-large .fc-day-today {
    background: rgba(16, 185, 129, 0.1) !important;
}

/* Custom Scrollbar */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #10b981; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #059669; }

/* Card Hover Effect */
.booking-card {
    transition: all 0.3s ease;
}
.booking-card:hover {
    transform: translateY(-2px);
}
</style>

<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
let calendar;
let currentFilter = '';
let currentDateFilter = 'all';
let allBookings = [];
let currentTab = 'list';
let carsData = []; // Store cars data from database

// Color palette for cars
const carColors = [
    { bg: '#3b82f6', name: 'blue', light: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' },
    { bg: '#10b981', name: 'emerald', light: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' },
    { bg: '#f59e0b', name: 'amber', light: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' },
    { bg: '#8b5cf6', name: 'purple', light: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' },
    { bg: '#ec4899', name: 'pink', light: 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' },
    { bg: '#06b6d4', name: 'cyan', light: 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' },
    { bg: '#f97316', name: 'orange', light: 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' },
    { bg: '#ef4444', name: 'red', light: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }
];

$(document).ready(function() {
    fetchCarsData(); // Load cars first
    fetchBookings();
    setupEventHandlers();
});

function initCalendar(forceReinit = false) {
    // If calendar already exists and not forcing reinit, just refetch
    if (calendar && !forceReinit) {
        calendar.refetchEvents();
        return;
    }
    
    // Destroy existing calendar if reinitializing
    if (calendar) {
        calendar.destroy();
        calendar = null;
    }
    
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error('Calendar element not found');
        return;
    }
    
    // Find the most recent booking date to set as initial date
    let initialDate = new Date().toISOString().split('T')[0]; // Default to today YYYY-MM-DD
    if (allBookings.length > 0) {
        // Sort bookings by date descending and get the most recent one
        const sortedBookings = [...allBookings].sort((a, b) => new Date(b.booking_date) - new Date(a.booking_date));
        const mostRecentDate = sortedBookings[0].booking_date;
        if (mostRecentDate) {
            initialDate = mostRecentDate.split(' ')[0]; // Ensure YYYY-MM-DD
        }
    }
    
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        initialDate: initialDate,
        locale: 'th',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },  
        height: 700,
        dayMaxEvents: 3,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            try {
                const events = allBookings.filter(b => b.status != 'rejected' && b.status != 2).map(function(booking) {
                    if (!booking.booking_date) return null;

                    let color = getCarColor(booking.car_id);
                    let carName = booking.car_model || 'รถยนต์';
                    
                    // Ensure date format YYYY-MM-DD
                    let datePart = booking.booking_date.split(' ')[0];
                    
                    // Handle time format - ensure proper format
                    let startTime = booking.start_time || '08:00';
                    let endTime = booking.end_time || '17:00';
                    
                    // If it contains date (has space), take the second part
                    if (startTime.includes(' ')) {
                        startTime = startTime.split(' ')[1];
                    }
                    if (endTime.includes(' ')) {
                        endTime = endTime.split(' ')[1];
                    }
                    
                    // Remove seconds if present
                    if (startTime.includes(':') && startTime.split(':').length >= 3) {
                        startTime = startTime.split(':').slice(0, 2).join(':');
                    }
                    if (endTime.includes(':') && endTime.split(':').length >= 3) {
                        endTime = endTime.split(':').slice(0, 2).join(':');
                    }
                    
                    return {
                        id: booking.id,
                        title: `${carName} - ${booking.destination || 'ไม่ระบุ'}`,
                        start: `${datePart}T${startTime}`,
                        end: `${datePart}T${endTime}`,
                        color: (booking.status == 0 || booking.status == 'pending') ? '#fbbf24' : color,
                        extendedProps: { booking: booking }
                    };
                }).filter(e => e !== null);
                
                successCallback(events);
            } catch (error) {
                console.error('Error generating calendar events:', error);
                failureCallback(error);
            }
        },
        eventClick: function(info) {
            showDetailModal(info.event.extendedProps.booking);
        }
    });
    calendar.render();
}

// Fetch cars from database
function fetchCarsData() {
    $.ajax({
        url: 'api/get_cars.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            carsData = response.cars || [];
            renderCarsTab();
            renderCalendarLegend();
        },
        error: function() {
            console.error('Failed to load cars');
            carsData = [];
        }
    });
}

// Get color for car based on its index
function getCarColor(carId) {
    const idx = carsData.findIndex(c => c.id == carId);
    return carColors[idx % carColors.length]?.bg || '#3b82f6';
}

// Get color class for car
function getCarColorClass(carId) {
    const idx = carsData.findIndex(c => c.id == carId);
    return carColors[idx % carColors.length]?.light || carColors[0].light;
}

// Render Cars Tab with dynamic data
function renderCarsTab() {
    if (carsData.length === 0) {
        $('#carsGrid').html('<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">🚗</div><p class="text-gray-500">ยังไม่มีรถยนต์ในระบบ</p><p class="text-sm text-gray-400 mt-2">กรุณาเพิ่มรถยนต์ในหน้าตั้งค่า</p></div>');
        return;
    }
    
    let html = '';
    carsData.forEach((car, idx) => {
        if (car.status != 1 && car.status != 'active') return; // Only show active cars
        
        const colorIdx = idx % carColors.length;
        const gradientColors = [
            'from-blue-500 to-indigo-600',
            'from-emerald-500 to-teal-600',
            'from-amber-500 to-orange-600',
            'from-purple-500 to-violet-600',
            'from-pink-500 to-rose-600',
            'from-cyan-500 to-sky-600',
            'from-orange-500 to-red-600',
            'from-red-500 to-rose-600'
        ];
        const textColors = [
            'text-blue-500',
            'text-emerald-500',
            'text-amber-500',
            'text-purple-500',
            'text-pink-500',
            'text-cyan-500',
            'text-orange-500',
            'text-red-500'
        ];
        
        const gradient = gradientColors[colorIdx];
        const textColor = textColors[colorIdx];
        const carEmoji = getCarEmoji(car.car_type);
        
        html += `
        <div class="glass rounded-2xl overflow-hidden group hover:shadow-xl transition-all">
            <div class="h-32 bg-gradient-to-br ${gradient} flex items-center justify-center relative">
                <span class="text-6xl transform group-hover:scale-110 transition-transform">${carEmoji}</span>
                <div class="absolute top-3 right-3">
                    <span class="px-2 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                        ${car.capacity || 4} ที่นั่ง
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">${car.car_model || 'ไม่ระบุรุ่น'}</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p><i class="fas fa-hashtag mr-2 ${textColor}"></i>ทะเบียน: ${car.license_plate || '-'}</p>
                    <p><i class="fas fa-car mr-2 ${textColor}"></i>ประเภท: ${car.car_type || '-'}</p>
                    <p><i class="fas fa-palette mr-2 ${textColor}"></i>สี: ${car.color || '-'}</p>
                </div>
                <div class="mt-4 flex gap-2 flex-wrap">
                    <span class="car-stat-badge" data-car-id="${car.id}" data-type="pending">⏳ 0</span>
                    <span class="car-stat-badge" data-car-id="${car.id}" data-type="approved">✅ 0</span>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#carsGrid').html(html || '<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">🚗</div><p class="text-gray-500">ไม่มีรถยนต์ที่เปิดใช้งาน</p></div>');
}

// Get car emoji based on type
function getCarEmoji(carType) {
    if (!carType) return '🚗';
    const type = carType.toLowerCase();
    if (type.includes('รถตู้') || type.includes('van')) return '🚐';
    if (type.includes('รถบัส') || type.includes('bus')) return '🚌';
    if (type.includes('กระบะ') || type.includes('pickup')) return '🛻';
    if (type.includes('suv')) return '🚙';
    if (type.includes('มอเตอร์ไซค์') || type.includes('motorcycle')) return '🏍️';
    return '🚗';
}

// Render Calendar Legend dynamically
function renderCalendarLegend() {
    if (carsData.length === 0) {
        $('#calendarLegend').html('<span class="text-gray-500">ไม่มีข้อมูลรถยนต์</span>');
        return;
    }
    
    let html = '<span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 font-medium text-sm mr-2"><span class="w-3 h-3 rounded-full bg-yellow-500"></span> รออนุมัติ</span>';
    
    carsData.forEach((car, idx) => {
        if (car.status != 1 && car.status != 'active') return;
        const colorIdx = idx % carColors.length;
        const color = carColors[colorIdx];
        const carEmoji = getCarEmoji(car.car_type);
        
        html += `
        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-lg ${color.light} font-medium text-sm">
            <span class="w-3 h-3 rounded-full" style="background-color: ${color.bg}"></span> ${carEmoji} ${car.car_model || 'รถยนต์'}
        </span>
        `;
    });
    
    $('#calendarLegend').html(html || '<span class="text-gray-500">ไม่มีรถยนต์ที่เปิดใช้งาน</span>');
}

function fetchBookings() {
    $.ajax({
        url: 'api/car_booking_list.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $('#bookingList').html('<div class="col-span-full text-center py-12"><div class="loader mx-auto mb-4"></div><p class="text-gray-400">กำลังโหลด...</p></div>');
        },
        success: function(response) {
            allBookings = response.list || [];
            updateStats();
            renderBookings(filterBookings());
            updateCarStats();
            // Reinit calendar if on calendar tab, or just refetch if it exists
            if (currentTab === 'calendar') {
                initCalendar(true); // Force reinit to update initialDate
            } else if (calendar) {
                calendar.refetchEvents();
            }
        },
        error: function() {
            $('#bookingList').html('<div class="col-span-full text-center py-12 text-red-500"><i class="fas fa-exclamation-circle text-5xl mb-4"></i><p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>');
        }
    });
}

function updateStats() {
    const today = new Date().toISOString().split('T')[0];
    const pending = allBookings.filter(b => b.status == 0 || b.status == 'pending').length;
    const approved = allBookings.filter(b => b.status == 1 || b.status == 'approved').length;
    const rejected = allBookings.filter(b => b.status == 2 || b.status == 'rejected').length;
    const todayCount = allBookings.filter(b => b.booking_date === today && (b.status == 1 || b.status == 'approved')).length;
    
    $('#statTotal').text(allBookings.length);
    $('#statPending').text(pending);
    $('#statApproved').text(approved);
    $('#statRejected').text(rejected);
    $('#statToday').text(todayCount);
}

function updateCarStats() {
    carsData.forEach(car => {
        if (car.status != 1 && car.status != 'active') return;
        const pending = allBookings.filter(b => b.car_id == car.id && (b.status == 0 || b.status == 'pending')).length;
        const approved = allBookings.filter(b => b.car_id == car.id && (b.status == 1 || b.status == 'approved')).length;
        $(`.car-stat-badge[data-car-id="${car.id}"][data-type="pending"]`).text(`⏳ ${pending}`);
        $(`.car-stat-badge[data-car-id="${car.id}"][data-type="approved"]`).text(`✅ ${approved}`);
    });
}

function filterBookings() {
    let filtered = allBookings;
    
    // Filter by status
    if (currentFilter !== '') {
        filtered = filtered.filter(b => {
            if (currentFilter === 'pending') return b.status == 0 || b.status == 'pending';
            if (currentFilter === 'approved') return b.status == 1 || b.status == 'approved';
            if (currentFilter === 'rejected') return b.status == 2 || b.status == 'rejected';
            return true;
        });
    }
    
    // Filter by date
    if (currentDateFilter !== 'all') {
        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth();
        const currentDate = today.getDate();
        
        filtered = filtered.filter(b => {
            const bookingDate = new Date(b.booking_date);
            const bookingYear = bookingDate.getFullYear();
            const bookingMonth = bookingDate.getMonth();
            const bookingDay = bookingDate.getDate();
            
            if (currentDateFilter === 'today') {
                return bookingYear === currentYear && bookingMonth === currentMonth && bookingDay === currentDate;
            } else if (currentDateFilter === 'month') {
                return bookingYear === currentYear && bookingMonth === currentMonth;
            } else if (currentDateFilter === 'year') {
                return bookingYear === currentYear;
            }
            return true;
        });
    }
    
    return filtered;
}

function renderBookings(bookings) {
    if (bookings.length === 0) {
        $('#bookingList').html('<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">📭</div><p class="text-gray-500">ไม่พบรายการจอง</p></div>');
        return;
    }

    let html = '';
    bookings.forEach(function(booking) {
        let statusInfo = getStatusInfo(booking.status);
        let carEmoji = getCarEmoji(booking.car_type);
        let carName = booking.car_model || 'รถยนต์';
        if (booking.license_plate) carName += ` (${booking.license_plate})`;
        
        const dateObj = new Date(booking.booking_date);
        const formattedDate = dateObj.toLocaleDateString('th-TH', { weekday: 'short', day: 'numeric', month: 'short', year: '2-digit' });

        html += `
        <div class="booking-card bg-white dark:bg-slate-800 rounded-2xl border-l-4 ${statusInfo.border} shadow-sm hover:shadow-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">${carEmoji}</span>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">${carName}</h4>
                            <p class="text-xs text-gray-500">#${booking.id}</p>
                        </div>
                    </div>
                    ${statusInfo.badge}
                </div>
                
                <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-emerald-500">📅</span>
                        <span>${formattedDate}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-emerald-500">⏰</span>
                        <span>${booking.start_time || '08:00'} - ${booking.end_time || '17:00'}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-emerald-500">👨‍🏫</span>
                        <span class="truncate">${booking.teacher_name || 'รหัส: ' + booking.teacher_id}</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                        <span class="text-emerald-500">📍</span>
                        <span class="truncate">${booking.destination || '-'}</span>
                    </div>
                </div>
                
                <div class="mb-4 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>🎯 วัตถุประสงค์:</strong> ${booking.purpose || '-'}</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <button onclick='showDetailModal(${JSON.stringify(booking).replace(/'/g, "\\'")})' class="flex-1 px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors">
                        <i class="fas fa-eye mr-1"></i>ดู
                    </button>
                    ${statusInfo.statusText === 'pending' ? `
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
        $('.status-filter-btn').removeClass('ring-2 ring-emerald-500 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400');
        $(this).addClass('ring-2 ring-emerald-500 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400');
        currentFilter = $(this).data('status');
        renderBookings(filterBookings());
    });

    // Date Filter buttons
    $('.date-filter-btn').on('click', function() {
        $('.date-filter-btn').removeClass('active ring-2 ring-blue-500 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400');
        $('.date-filter-btn').addClass('bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300');
        
        $(this).removeClass('bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300');
        $(this).addClass('active ring-2 ring-blue-500 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400');
        
        currentDateFilter = $(this).data('filter');
        renderBookings(filterBookings());
    });

    // Refresh
    $('#refreshData').on('click', function() {
        fetchCarsData();
        fetchBookings();
    });
}

function switchTab(tab) {
    currentTab = tab;
    $('.tab-btn').removeClass('active');
    $(`.tab-btn[data-tab="${tab}"]`).addClass('active');
    $('.tab-pane').addClass('hidden');
    $(`#tab-${tab}`).removeClass('hidden');
    
    if (tab === 'calendar') {
        setTimeout(() => {
            // Force reinit if calendar doesn't exist yet
            if (!calendar) {
                initCalendar(true);
            } else {
                // If calendar exists, ensure we jump to the latest data date
                if (allBookings.length > 0) {
                    const sortedBookings = [...allBookings].sort((a, b) => new Date(b.booking_date) - new Date(a.booking_date));
                    const mostRecentDate = sortedBookings[0].booking_date;
                    if (mostRecentDate) {
                        let datePart = mostRecentDate.split(' ')[0];
                        calendar.gotoDate(datePart);
                    }
                }
                calendar.refetchEvents();
                calendar.render(); // Force layout update
            }
        }, 100);
    }
}

function showDetailModal(booking) {
    const dateObj = new Date(booking.booking_date);
    const formattedDate = dateObj.toLocaleDateString('th-TH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    const statusInfo = getStatusInfo(booking.status);
    const carEmoji = getCarEmoji(booking.car_type);
    let carName = booking.car_model || 'รถยนต์';
    if (booking.license_plate) carName += ` (${booking.license_plate})`;
    
    $('#detailTitle').html(`<span class="text-2xl mr-2">${carEmoji}</span>${carName}`);
    
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
                    <p class="font-medium text-gray-900 dark:text-white">${booking.start_time || '08:00'} - ${booking.end_time || '17:00'} น.</p>
                </div>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">📍 จุดหมายปลายทาง</p>
                <p class="font-medium text-gray-900 dark:text-white">${booking.destination || '-'}</p>
            </div>
            
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">🎯 วัตถุประสงค์</p>
                <p class="font-medium text-gray-900 dark:text-white">${booking.purpose || '-'}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">👨‍🏫 ผู้จอง</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.teacher_name || 'รหัส: ' + booking.teacher_id}</p>
                    ${booking.teacher_position ? `<p class="text-sm text-gray-500">${booking.teacher_position}</p>` : ''}
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">📞 เบอร์โทร</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.teacher_phone || booking.phone || '-'}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">👥 จำนวนผู้โดยสาร</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.passenger_count || '-'} คน</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">🚗 ประเภทรถ</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.car_type || '-'}</p>
                </div>
            </div>
        </div>
    `);
    
    let actionsHtml = '';
    
    if (statusInfo.statusText === 'pending') {
        actionsHtml = `
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

function updateStatus(id, status) {
    const action = status == 1 ? 'อนุมัติ' : 'ยกเลิก';
    const statusMap = {0: 'pending', 1: 'approved', 2: 'rejected'};
    
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
            $.ajax({
                url: '/officer/api/car_booking_status.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: id, status: statusMap[status] || status }),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({icon: 'success', title: 'สำเร็จ!', text: `${action}เรียบร้อยแล้ว`, timer: 1500, showConfirmButton: false});
                        fetchBookings();
                    } else {
                        Swal.fire({icon: 'error', title: 'ผิดพลาด', text: response.message || 'ไม่สามารถอัปเดตสถานะได้'});
                    }
                },
                error: function() {
                    Swal.fire({icon: 'error', title: 'ผิดพลาด', text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ'});
                }
            });
        }
    });
}

// Helper Functions
function getStatusInfo(status) {
    let statusText = '';
    if (status == 0 || status == 'pending') {
        statusText = 'pending';
        return { 
            badge: '<span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full font-medium">⏳ รอการอนุมัติ</span>', 
            border: 'border-yellow-400',
            statusText: statusText
        };
    } else if (status == 1 || status == 'approved') {
        statusText = 'approved';
        return { 
            badge: '<span class="px-3 py-1 text-xs bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full font-medium">✅ อนุมัติแล้ว</span>', 
            border: 'border-green-400',
            statusText: statusText
        };
    } else {
        statusText = 'rejected';
        return { 
            badge: '<span class="px-3 py-1 text-xs bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 rounded-full font-medium">❌ ยกเลิก</span>', 
            border: 'border-red-400',
            statusText: statusText
        };
    }
}

// Close modals on outside click
$('#detailModal').on('click', function(e) {
    if (e.target === this) {
        $(this).addClass('hidden');
    }
});
</script>
