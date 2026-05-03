/**
 * Car Booking JavaScript Module
 * Modern UI with FullCalendar integration
 */

let isSubmitting = false;
let calendar;
let allBookingsData = []; // Cache bookings data globally

// Car colors for calendar
const carColorMap = {};
const carColors = [
    '#22c55e', '#3b82f6', '#f59e42', '#ef4444', '#a855f7',
    '#eab308', '#14b8a6', '#6366f1', '#f43f5e', '#0ea5e9'
];

// ==================== Initialize ====================
$(document).ready(function () {
    loadCars();
    fetchBookings();
    setupEventHandlers();
});

// ==================== Event Handlers ====================
function setupEventHandlers() {
    // Add booking button
    $('#addBookingBtn').on('click', openAddModal);

    // Close modals
    $('#closeAddBookingModal, #cancelAddBooking').on('click', () => {
        $('#addBookingModal').addClass('hidden');
        document.getElementById('addBookingForm').reset();
    });

    $('#closeEditBookingModal, #cancelEditBooking').on('click', () => {
        $('#editBookingModal').addClass('hidden');
    });

    // Close on backdrop
    $('#addBookingModal, #editBookingModal').on('click', function (e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });

    // Form submissions
    $('#addBookingForm').on('submit', submitAddBooking);
    $('#editBookingForm').on('submit', submitEditBooking);

    // View toggle
    $('#showTableBtn').on('click', function () {
        $('#tableView').removeClass('hidden');
        $('#calendarView').addClass('hidden');
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
    });

    $('#showCalendarBtn').on('click', function () {
        $('#tableView').addClass('hidden');
        $('#calendarView').removeClass('hidden');
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
        initCalendar();
    });

    // Refresh
    $('#refreshList').on('click', function () {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        fetchBookings();
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });

    // Passenger buttons
    $('#addPassengerBtn').on('click', () => addPassengerField('passengersList'));
    $('#editAddPassengerBtn').on('click', () => addPassengerField('editPassengersList'));

    // Remove passenger
    $(document).on('click', '.remove-passenger-btn', function () {
        $(this).closest('.passenger-item').remove();
        calculateTotal();
        calculateTotalEdit();
    });

    // Car selection
    $('#carSelect').on('change', function () {
        const capacity = $(this).find('option:selected').data('capacity') || 0;
        $('#carCapacity').val(capacity);
        calculateTotal();
    });

    $('#editCarSelect').on('change', function () {
        const capacity = $(this).find('option:selected').data('capacity') || 0;
        $('#editCarCapacity').val(capacity);
        calculateTotalEdit();
    });

    // Edit booking
    $(document).on('click', '.edit-booking-btn', openEditModal);

    // Delete booking
    $(document).on('click', '.delete-booking-btn', function () {
        const id = $(this).data('id');
        confirmDelete(id);
    });
}

// ==================== Load Cars ====================
function loadCars() {
    return fetch('api/car_list.php')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.cars) {
                const carSelect = document.getElementById('carSelect');
                const editCarSelect = document.getElementById('editCarSelect');

                const options = '<option value="">-- เลือกรถยนต์ --</option>' +
                    data.cars.filter(car => car.status == 1)
                        .map(car => `<option value="${car.id}" data-capacity="${car.capacity}">
                            ${car.car_model} (${car.license_plate}) - ความจุ ${car.capacity} คน
                        </option>`).join('');

                if (carSelect) carSelect.innerHTML = options;
                if (editCarSelect) editCarSelect.innerHTML = options;
            }
        })
        .catch(err => console.error('Error loading cars:', err));
}

// ==================== Fetch Bookings ====================
function fetchBookings() {
    const $tbody = $('#bookingTableBody');
    const $cardList = $('#bookingCardList');

    const loadingState = `
        <div class="text-center py-8 text-gray-400">
            <div class="loader mx-auto mb-4"></div>
            <p>กำลังโหลดข้อมูล...</p>
        </div>
    `;

    if ($tbody.length) $tbody.html(`<tr><td colspan="11" class="text-center py-8 text-gray-400">${loadingState}</td></tr>`);
    if ($cardList.length) $cardList.html(loadingState);

    $.get('api/car_booking_list.php', function (res) {
        if (!res) return;
        
        allBookingsData = Array.isArray(res.list) ? res.list : []; // Cache data here
        
        let filteredData = [];
        if (allBookingsData.length > 0) {
            filteredData = allBookingsData.filter(item => item && String(item.teacher_id) === String(window.teacher_id || teacher_id));
        }

        updateStats(filteredData);
        renderBookings(filteredData);
        updateCarLegend(allBookingsData);
        
        if (calendar) {
            updateCalendarEvents();
        }
    }, 'json').fail(function () {
        const errorState = `
            <div class="text-center py-8 text-red-500">
                <div class="text-4xl mb-4">❌</div>
                <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
            </div>
        `;
        if ($tbody.length) $tbody.html(`<tr><td colspan="11">${errorState}</td></tr>`);
        if ($cardList.length) $cardList.html(errorState);
    });
}

// ==================== Render Bookings ====================
function renderBookings(data) {
    const $tbody = $('#bookingTableBody');
    const $cardList = $('#bookingCardList');
    
    if ($tbody.length) $tbody.empty();
    if ($cardList.length) $cardList.empty();

    if (!data || data.length === 0) {
        const emptyStateTable = `
            <tr>
                <td colspan="10" class="text-center py-8 text-gray-400">
                    <div class="text-6xl mb-4">📭</div>
                    <p>ไม่พบรายการจอง</p>
                </td>
            </tr>
        `;
        const emptyStateCard = `
            <div class="glass rounded-2xl p-8 text-center text-gray-400">
                <div class="text-6xl mb-4">📭</div>
                <p>ไม่พบรายการจอง</p>
            </div>
        `;
        if ($tbody.length) $tbody.html(emptyStateTable.replace('colspan="10"', 'colspan="11"'));
        if ($cardList.length) $cardList.html(emptyStateCard);
        return;
    }

    data.forEach((item, idx) => {
        if (!item) return;
        
        const statusBadge = getStatusBadge(item.status);
        const carColor = getCarColor(item.car_id);

        // Render Table Row
        const row = `
            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50/50 dark:hover:bg-slate-700/50 transition-colors text-xs lg:text-sm">
                <td class="py-4 px-2 text-center font-semibold text-gray-600 dark:text-gray-400">${idx + 1}</td>
                <td class="py-4 px-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center text-[10px] font-bold">
                            ${(item.teacher_name || 'U').charAt(0)}
                        </div>
                        <div class="font-medium text-gray-900 dark:text-white truncate max-w-[100px]" title="${item.teacher_name}">${item.teacher_name || '-'}</div>
                    </div>
                </td>
                <td class="py-4 px-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-base shadow-sm" style="background: ${carColor}">
                            🚗
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 dark:text-white truncate max-w-[120px]">${item.car_model || '-'}</div>
                            <div class="text-[10px] text-gray-500">${item.license_plate || '-'}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-2 text-center">
                    <div class="text-[10px] text-gray-500">${item.booking_date ? formatThaiDateOnly(item.booking_date) : '-'}</div>
                </td>
                <td class="py-4 px-2 text-center">
                    <div class="flex flex-col gap-0.5">
                        <span class="text-[10px] font-bold text-green-600">${formatThaiDateTimeShort(item.start_time)}</span>
                        <span class="text-[10px] font-bold text-red-600">${formatThaiDateTimeShort(item.end_time)}</span>
                    </div>
                </td>
                <td class="py-4 px-3">
                    <div class="max-w-[120px] truncate text-xs" title="${item.destination}">${item.destination}</div>
                </td>
                <td class="py-4 px-3">
                    <div class="max-w-[120px] truncate text-xs" title="${item.purpose}">${item.purpose}</div>
                </td>
                <td class="py-4 px-2 text-center">
                    <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-[10px] font-bold">${item.passenger_count || 0} คน</span>
                </td>
                <td class="py-4 px-3">
                    <div class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400">
                        <i class="fas fa-user-tie text-[10px]"></i>
                        <span class="text-[10px] font-bold truncate max-w-[80px]" title="${item.driver_name}">${item.driver_name || '-'}</span>
                    </div>
                </td>
                <td class="py-4 px-2 text-center">${statusBadge}</td>
                <td class="py-4 px-2 text-center">
                    <div class="flex justify-center gap-1.5">
                        <button class="edit-booking-btn w-7 h-7 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors"
                            data-id="${item.id}"
                            data-car_id="${item.car_id}"
                            data-start_time="${item.start_time}"
                            data-end_time="${item.end_time}"
                            data-destination="${encodeURIComponent(item.destination)}"
                            data-purpose="${encodeURIComponent(item.purpose)}"
                            data-notes="${encodeURIComponent(item.notes || '')}">
                            <i class="fas fa-edit text-[10px]"></i>
                        </button>
                        <button class="delete-booking-btn w-7 h-7 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors"
                            data-id="${item.id}">
                            <i class="fas fa-trash text-[10px]"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        if ($tbody.length) $tbody.append(row);

        // Render Card
        const cardBody = `
            <div class="booking-mobile-card rounded-2xl p-5 shadow-sm space-y-4" style="border-left-color: ${carColor}">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-2xl shadow-lg" style="background: ${carColor}">
                            🚗
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">${item.car_model || '-'}</h4>
                            <p class="text-xs text-gray-500 font-medium">${item.license_plate || '-'}</p>
                        </div>
                    </div>
                    ${statusBadge}
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-clock text-green-500 text-[10px]"></i> เริ่มต้น</p>
                        <p class="font-semibold text-gray-700 dark:text-gray-200 text-xs">${formatThaiDateTime(item.start_time)}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 flex items-center gap-1"><i class="fas fa-clock text-red-500 text-[10px]"></i> สิ้นสุด</p>
                        <p class="font-semibold text-gray-700 dark:text-gray-200 text-xs">${formatThaiDateTime(item.end_time)}</p>
                    </div>
                </div>
                
                <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-start gap-2 text-sm">
                        <i class="fas fa-map-marker-alt mt-1 text-blue-500 text-xs"></i>
                        <div>
                            <span class="text-[10px] text-gray-400 block uppercase tracking-wider">จุดหมาย</span>
                            <span class="text-gray-700 dark:text-gray-200 text-sm font-medium">${item.destination}</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 text-sm">
                        <i class="fas fa-bullseye mt-1 text-purple-500 text-xs"></i>
                        <div>
                            <span class="text-[10px] text-gray-400 block uppercase tracking-wider">วัตถุประสงค์</span>
                            <span class="text-gray-700 dark:text-gray-200 text-sm font-medium">${item.purpose}</span>
                        </div>
                    </div>
                    ${item.driver_id ? `
                    <div class="flex items-start gap-2 text-sm p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                        <i class="fas fa-user-tie mt-1 text-blue-600 text-xs"></i>
                        <div>
                            <span class="text-[10px] text-blue-600 block uppercase tracking-wider font-bold">คนขับรถ</span>
                            <span class="text-gray-900 dark:text-white text-sm font-bold">${item.driver_name || '-'}</span>
                        </div>
                    </div>
                    ` : ''}
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-[10px] font-bold">
                            <i class="fas fa-users mr-1"></i> ${item.passenger_count || 0} คน
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <button class="edit-booking-btn px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-xl text-xs font-bold transition-all"
                            data-id="${item.id}"
                            data-car_id="${item.car_id}"
                            data-start_time="${item.start_time}"
                            data-end_time="${item.end_time}"
                            data-destination="${encodeURIComponent(item.destination)}"
                            data-purpose="${encodeURIComponent(item.purpose)}"
                            data-notes="${encodeURIComponent(item.notes || '')}">
                            <i class="fas fa-edit mr-1"></i> แก้ไข
                        </button>
                        <button class="delete-booking-btn px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-bold transition-all"
                            data-id="${item.id}">
                            <i class="fas fa-trash mr-1"></i> ลบ
                        </button>
                    </div>
                </div>
            </div>
        `;
        if ($cardList.length) $cardList.append(cardBody);
    });
}

// ==================== Status Badge ====================
function getStatusBadge(status) {
    const statusMap = {
        'pending': { text: 'รอพิจารณา', class: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' },
        'approved': { text: 'อนุมัติ', class: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' },
        'rejected': { text: 'ไม่อนุมัติ', class: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' },
        'completed': { text: 'เสร็จสิ้น', class: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' }
    };

    const s = statusMap[status] || statusMap['pending'];
    return `<span class="status-badge ${s.class} px-3 py-1 rounded-full text-xs font-semibold">${s.text}</span>`;
}

// ==================== Stats ====================
function updateStats(data) {
    const pending = data.filter(item => item.status === 'pending').length;
    const approved = data.filter(item => item.status === 'approved').length;

    $('#pendingCount').text(pending);
    $('#approvedCount').text(approved);
    $('#totalCount').text(data.length);
}

// ==================== Car Color ====================
function getCarColor(car_id) {
    if (!carColorMap[car_id]) {
        const idx = Object.keys(carColorMap).length % carColors.length;
        carColorMap[car_id] = carColors[idx];
    }
    return carColorMap[car_id];
}

// ==================== Car Legend ====================
function updateCarLegend(bookings) {
    const $legend = $('#legendItems');
    if (!$legend.length) return;
    $legend.empty();

    const uniqueCars = [];
    const seenCars = new Set();

    if (Array.isArray(bookings)) {
        bookings.forEach(booking => {
            if (booking && booking.car_id && !seenCars.has(booking.car_id)) {
                seenCars.add(booking.car_id);
                uniqueCars.push({
                    id: booking.car_id,
                    model: booking.car_model,
                    license: booking.license_plate
                });
            }
        });
    }

    uniqueCars.forEach(car => {
        const color = getCarColor(car.id);
        $legend.append(`
            <div class="flex items-center gap-2.5 px-4 py-2 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-800 transition-all shadow-sm">
                <div class="w-2.5 h-2.5 rounded-full ring-4 ring-offset-2 ring-transparent" style="background-color: ${color}; --tw-ring-color: ${color}44"></div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">${car.model}</span>
                    <span class="text-[10px] text-gray-500 font-medium">${car.license}</span>
                </div>
            </div>
        `);
    });
}

// ==================== Calendar ====================
function hideCalendarLoader() {
    const loaderEl = document.getElementById('calendarLoader');
    if (loaderEl) {
        loaderEl.style.opacity = '0';
        loaderEl.style.pointerEvents = 'none';
        setTimeout(() => {
            loaderEl.style.display = 'none';
        }, 200);
    }
}

function initCalendar() {
    const calendarEl = document.getElementById('carBookingCalendar');
    const loaderEl = document.getElementById('calendarLoader');
    if (!calendarEl) return;

    if (calendar) {
        calendar.destroy();
        calendar = null;
    }

    if (loaderEl) {
        loaderEl.style.display = 'flex';
        loaderEl.style.opacity = '1';
        loaderEl.style.pointerEvents = 'auto';
    }

    // Render from cached data — no extra network request
    setTimeout(() => {
        try {
            renderCalendarFromData(allBookingsData);
        } catch (e) {
            console.error('Calendar render error:', e);
        } finally {
            hideCalendarLoader();
        }
    }, 50);
}

function updateCalendarEvents() {
    if (!calendar) return;
    const events = prepareCalendarEvents(allBookingsData);
    calendar.removeAllEvents();
    calendar.addEventSource(events);
}

function prepareCalendarEvents(list) {
    const isMobile = window.innerWidth < 768;
    return list.map(item => ({
        id: item.id,
        title: isMobile
            ? `${item.car_model || '-'}`
            : `${item.car_model || '-'} | ${item.teacher_name || '-'}${item.destination ? ' \n📍 ' + item.destination : ''}`,
        start: item.start_time,
        end: item.end_time,
        backgroundColor: getCarColor(item.car_id),
        borderColor: getCarColor(item.car_id),
        extendedProps: item
    }));
}

function renderCalendarFromData(list) {
    const calendarEl = document.getElementById('carBookingCalendar');
    if (!calendarEl) return;

    const isMobile = window.innerWidth < 768;
    const events = prepareCalendarEvents(list);

    // Update month event count
    const now = new Date();
    const currentMonth = now.getMonth();
    const currentYear = now.getFullYear();
    const monthEvents = list.filter(item => {
        const startTime = new Date(item.start_time);
        return startTime.getMonth() === currentMonth && startTime.getFullYear() === currentYear;
    }).length;
    $('#calendarEventCount').text(monthEvents);

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: isMobile ? 'listMonth' : 'dayGridMonth',
        locale: 'th',
        height: 650,
        contentHeight: 'auto',
        handleWindowResize: true,
        expandRows: true,
        headerToolbar: {
            left: isMobile ? 'prev,next' : 'prev,next today',
            center: 'title',
            right: isMobile ? 'dayGridMonth,listMonth' : 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        buttonText: {
            today: 'วันนี้',
            month: 'เดือน',
            week: 'สัปดาห์',
            day: 'วัน',
            list: 'รายการ'
        },
        dayMaxEvents: 3,
        events: events,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false,
            hour12: false
        },
        eventClick: function (info) {
            const b = info.event.extendedProps;
            Swal.fire({
                title: '🚗 รายละเอียดการจอง',
                html: `
                    <div class="space-y-4 text-left p-2">
                        <div class="flex items-center gap-4 mb-4 p-3 bg-gray-50 dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg" style="background: ${getCarColor(b.car_id)}">
                                🚗
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">${b.car_model || '-'}</h4>
                                <p class="text-sm text-gray-500 font-medium">${b.license_plate || '-'}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-3 text-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">ผู้จอง</p>
                                    <p class="font-bold text-gray-800 dark:text-gray-200">${b.teacher_name || '-'}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">วันเวลา</p>
                                    <p class="font-bold text-gray-800 dark:text-gray-200">${formatThaiDateTime(b.start_time)} - ${formatThaiDateTime(b.end_time)}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">จุดหมาย</p>
                                    <p class="font-bold text-gray-800 dark:text-gray-200">${b.destination || '-'}</p>
                                </div>
                            </div>
                            ${b.driver_id ? `
                            <div class="flex items-start gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-tie text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-blue-600 dark:text-blue-400 uppercase font-bold tracking-wider">คนขับรถที่มอบหมาย</p>
                                    <p class="font-bold text-blue-800 dark:text-blue-300">${b.driver_name || b.driver_id}</p>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `,
                showCloseButton: true,
                confirmButtonText: 'รับทราบ',
                confirmButtonColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-8 py-3 font-bold'
                }
            });
        },
        datesSet: function() {
            // Backup: hide loader once calendar view is fully rendered
            hideCalendarLoader();
        }
    });

    calendar.render();
}

// ==================== Add Modal ====================
function openAddModal() {
    loadCars().then(() => {
        // Set default datetime
        const now = new Date();
        const tomorrow = new Date(now);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const startDateTime = tomorrow.toISOString().slice(0, 16);
        const endDateTime = new Date(tomorrow.getTime() + 2 * 60 * 60 * 1000).toISOString().slice(0, 16);

        $('input[name="start_datetime"]').val(startDateTime);
        $('input[name="end_datetime"]').val(endDateTime);
        $('input[name="student_count"]').val(0);

        resetPassengersList();
        calculateTotal();

        $('#addBookingModal').removeClass('hidden');
    });
}

// ==================== Edit Modal ====================
function openEditModal() {
    const $btn = $(this);
    const data = $btn.data();

    loadCars().then(() => {
        $('#editBookingId').val(data.id);
        $('#editCarSelect').val(data.car_id);
        $('#editStartDateTime').val(toDatetimeLocal(data.start_time));
        $('#editEndDateTime').val(toDatetimeLocal(data.end_time));
        $('#editDestination').val(decodeURIComponent(data.destination));
        $('#editPurpose').val(decodeURIComponent(data.purpose));
        $('#editNotes').val(decodeURIComponent(data.notes));

        // Load additional booking details
        fetch(`api/car_booking_get.php?id=${data.id}`)
            .then(res => res.json())
            .then(bookingData => {
                if (bookingData.success && bookingData.booking) {
                    const booking = bookingData.booking;

                    $('#editTeacherName').val(booking.teacher_name || '');
                    $('#editTeacherPosition').val(booking.teacher_position || '');
                    $('#editTeacherPhone').val(booking.teacher_phone || '');

                    loadEditPassengersList(booking.passengers_detail || '');
                    $('#editStudentCount').val(booking.student_count || 0);

                    const capacity = $('#editCarSelect option:selected').data('capacity') || 0;
                    $('#editCarCapacity').val(capacity);
                    calculateTotalEdit();
                }
            });

        $('#editBookingModal').removeClass('hidden');
    });
}

// ==================== Submit Add ====================
function submitAddBooking(e) {
    e.preventDefault();

    if (isSubmitting) return false;
    isSubmitting = true;

    const $btn = $(this).find('button[type="submit"]');
    const originalText = $btn.html();
    $btn.html('<i class="fas fa-spinner animate-spin mr-2"></i> กำลังบันทึก...');
    $btn.prop('disabled', true);

    const formData = new FormData(this);

    // Parse datetime
    const startDateTime = formData.get('start_datetime');
    const endDateTime = formData.get('end_datetime');

    if (startDateTime) {
        const [date, time] = startDateTime.split('T');
        formData.append('booking_date', date);
        formData.append('start_time', time);
    }

    if (endDateTime) {
        const [, endTime] = endDateTime.split('T');
        formData.append('end_time', endTime);
    }

    // Collect passengers
    const passengers = [];
    document.querySelectorAll('#passengersList input[name="passengers[]"]').forEach(input => {
        if (input.value.trim()) passengers.push(input.value.trim());
    });
    formData.append('passengers_detail', JSON.stringify(passengers));

    const studentCount = parseInt(formData.get('student_count')) || 0;
    formData.append('passenger_count', passengers.length + studentCount);
    formData.append('teacher_id', teacher_id);

    fetch('api/car_booking_add.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ! 🎉',
                    text: 'บันทึกการจองเรียบร้อยแล้ว',
                    confirmButtonColor: '#3b82f6',
                    timer: 2000,
                    timerProgressBar: true
                });
                $('#addBookingModal').addClass('hidden');
                document.getElementById('addBookingForm').reset();
                fetchBookings();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: data.message || 'เกิดข้อผิดพลาด',
                    confirmButtonColor: '#ef4444'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        })
        .finally(() => {
            isSubmitting = false;
            $btn.html(originalText);
            $btn.prop('disabled', false);
        });
}

// ==================== Submit Edit ====================
function submitEditBooking(e) {
    e.preventDefault();

    if (isSubmitting) return false;
    isSubmitting = true;

    const $btn = $(this).find('button[type="submit"]');
    const originalText = $btn.html();
    $btn.html('<i class="fas fa-spinner animate-spin mr-2"></i> กำลังบันทึก...');
    $btn.prop('disabled', true);

    const formData = new FormData(this);

    const startDateTime = formData.get('start_datetime');
    const endDateTime = formData.get('end_datetime');

    if (startDateTime) {
        const [date, time] = startDateTime.split('T');
        formData.append('booking_date', date);
        formData.append('start_time', time);
    }

    if (endDateTime) {
        const [, endTime] = endDateTime.split('T');
        formData.append('end_time', endTime);
    }

    const passengers = [];
    document.querySelectorAll('#editPassengersList input[name="passengers[]"]').forEach(input => {
        if (input.value.trim()) passengers.push(input.value.trim());
    });
    formData.append('passengers_detail', JSON.stringify(passengers));

    const studentCount = parseInt(formData.get('student_count')) || 0;
    formData.append('passenger_count', passengers.length + studentCount);

    fetch('api/car_booking_edit.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ! 🎉',
                    text: 'บันทึกการแก้ไขเรียบร้อยแล้ว',
                    confirmButtonColor: '#3b82f6',
                    timer: 2000,
                    timerProgressBar: true
                });
                $('#editBookingModal').addClass('hidden');
                fetchBookings();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: data.message || 'เกิดข้อผิดพลาด',
                    confirmButtonColor: '#ef4444'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        })
        .finally(() => {
            isSubmitting = false;
            $btn.html(originalText);
            $btn.prop('disabled', false);
        });
}

// ==================== Delete ====================
function confirmDelete(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบการจองนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteBooking(id);
        }
    });
}

function deleteBooking(id) {
    fetch('api/car_booking_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'ลบสำเร็จ! 🗑️',
                    text: 'การจองถูกลบเรียบร้อยแล้ว',
                    confirmButtonColor: '#3b82f6',
                    timer: 2000,
                    timerProgressBar: true
                });
                fetchBookings();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: data.message || 'เกิดข้อผิดพลาด',
                    confirmButtonColor: '#ef4444'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        });
}

// ==================== Passengers ====================
function addPassengerField(containerId) {
    const container = document.getElementById(containerId);
    const passengerItem = document.createElement('div');
    passengerItem.className = 'passenger-item flex gap-2';
    passengerItem.innerHTML = `
        <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="ชื่อ-นามสกุล" onchange="calculateTotal(); calculateTotalEdit();">
        <button type="button" class="remove-passenger-btn px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(passengerItem);

    if (containerId === 'passengersList') {
        calculateTotal();
    } else {
        calculateTotalEdit();
    }
}

function resetPassengersList() {
    const container = document.getElementById('passengersList');
    container.innerHTML = `
        <div class="passenger-item flex gap-2">
            <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="${teacherName}" readonly>
            <span class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-xl text-sm">หัวหน้าคณะ</span>
        </div>
    `;
}

function loadEditPassengersList(passengersJson) {
    const container = document.getElementById('editPassengersList');
    container.innerHTML = '';

    try {
        const passengers = passengersJson ? JSON.parse(passengersJson) : [];

        if (passengers.length === 0) {
            container.innerHTML = `
                <div class="passenger-item flex gap-2">
                    <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" value="${teacherName}" readonly>
                    <span class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 rounded-xl text-sm">หัวหน้าคณะ</span>
                </div>
            `;
            return;
        }

        passengers.forEach((passenger, index) => {
            const passengerItem = document.createElement('div');
            passengerItem.className = 'passenger-item flex gap-2';

            if (index === 0) {
                passengerItem.innerHTML = `
                    <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" value="${passenger}" readonly>
                    <span class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 rounded-xl text-sm">หัวหน้าคณะ</span>
                `;
            } else {
                passengerItem.innerHTML = `
                    <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" value="${passenger}" onchange="calculateTotalEdit();">
                    <button type="button" class="remove-passenger-btn px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                `;
            }

            container.appendChild(passengerItem);
        });
    } catch (e) {
        console.error('Error parsing passengers:', e);
        container.innerHTML = `
            <div class="passenger-item flex gap-2">
                <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" value="${teacherName}" readonly>
                <span class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 rounded-xl text-sm">หัวหน้าคณะ</span>
            </div>
        `;
    }
}

// ==================== Calculate Total ====================
function calculateTotal() {
    const passengerInputs = document.querySelectorAll('#passengersList input[name="passengers[]"]');
    const passengerCount = Array.from(passengerInputs).filter(input => input.value.trim() !== '').length;
    const studentCount = parseInt(document.querySelector('input[name="student_count"]')?.value) || 0;
    const totalPassengers = passengerCount + studentCount;

    const totalInput = document.querySelector('input[name="total_passengers"]');
    if (totalInput) totalInput.value = totalPassengers;

    const capacity = parseInt(document.getElementById('carCapacity')?.value) || 0;
    if (capacity > 0 && totalPassengers > capacity) {
        Swal.fire({
            icon: 'warning',
            title: 'จำนวนผู้โดยสารเกินความจุ',
            text: `รถยนต์คันนี้มีความจุ ${capacity} คน (ปัจจุบัน: ${totalPassengers} คน)`,
            confirmButtonText: 'รับทราบ',
            confirmButtonColor: '#f59e0b'
        });
    }
}

function calculateTotalEdit() {
    const passengerInputs = document.querySelectorAll('#editPassengersList input[name="passengers[]"]');
    const passengerCount = Array.from(passengerInputs).filter(input => input.value.trim() !== '').length;
    const studentCount = parseInt(document.getElementById('editStudentCount')?.value) || 0;
    const totalPassengers = passengerCount + studentCount;

    const totalInput = document.getElementById('editTotalPassengers');
    if (totalInput) totalInput.value = totalPassengers;

    const capacity = parseInt(document.getElementById('editCarCapacity')?.value) || 0;
    if (capacity > 0 && totalPassengers > capacity) {
        Swal.fire({
            icon: 'warning',
            title: 'จำนวนผู้โดยสารเกินความจุ',
            text: `รถยนต์คันนี้มีความจุ ${capacity} คน (ปัจจุบัน: ${totalPassengers} คน)`,
            confirmButtonText: 'รับทราบ',
            confirmButtonColor: '#f59e0b'
        });
    }
}

// ==================== Utility ====================
function formatThaiDateTime(dateString) {
    if (!dateString) return '-';

    const date = new Date(dateString);
    const thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];

    const day = date.getDate();
    const month = thaiMonths[date.getMonth()];
    const year = (date.getFullYear() + 543).toString().slice(-2);
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');

    return `${day} ${month} ${year} ${hours}:${minutes}`;
}

function formatThaiDateOnly(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    const day = date.getDate();
    const month = thaiMonths[date.getMonth()];
    const year = (date.getFullYear() + 543).toString().slice(-2);
    return `${day} ${month} ${year}`;
}

function formatThaiDateTimeShort(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    const day = date.getDate();
    const month = thaiMonths[date.getMonth()];
    const year = (date.getFullYear() + 543).toString().slice(-2);
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${day} ${month} ${year} ${hours}:${minutes}`;
}

function toDatetimeLocal(dt) {
    if (!dt) return '';
    return dt.replace(' ', 'T').slice(0, 16);
}
