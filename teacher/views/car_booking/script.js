/**
 * Car Booking JavaScript Module
 * Modern UI with FullCalendar integration
 */

let isSubmitting = false;
let calendar;

// Car colors for calendar
const carColorMap = {};
const carColors = [
    '#22c55e', '#3b82f6', '#f59e42', '#ef4444', '#a855f7',
    '#eab308', '#14b8a6', '#6366f1', '#f43f5e', '#0ea5e9'
];

// ==================== Initialize ====================
$(document).ready(function() {
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
    $('#addBookingModal, #editBookingModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
    
    // Form submissions
    $('#addBookingForm').on('submit', submitAddBooking);
    $('#editBookingForm').on('submit', submitEditBooking);
    
    // View toggle
    $('#showTableBtn').on('click', function() {
        $('#tableView').removeClass('hidden');
        $('#calendarView').addClass('hidden');
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
    });
    
    $('#showCalendarBtn').on('click', function() {
        $('#tableView').addClass('hidden');
        $('#calendarView').removeClass('hidden');
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
        initCalendar();
    });
    
    // Refresh
    $('#refreshList').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        fetchBookings();
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });
    
    // Passenger buttons
    $('#addPassengerBtn').on('click', () => addPassengerField('passengersList'));
    $('#editAddPassengerBtn').on('click', () => addPassengerField('editPassengersList'));
    
    // Remove passenger
    $(document).on('click', '.remove-passenger-btn', function() {
        $(this).closest('.passenger-item').remove();
        calculateTotal();
        calculateTotalEdit();
    });
    
    // Car selection
    $('#carSelect').on('change', function() {
        const capacity = $(this).find('option:selected').data('capacity') || 0;
        $('#carCapacity').val(capacity);
        calculateTotal();
    });
    
    $('#editCarSelect').on('change', function() {
        const capacity = $(this).find('option:selected').data('capacity') || 0;
        $('#editCarCapacity').val(capacity);
        calculateTotalEdit();
    });
    
    // Edit booking
    $(document).on('click', '.edit-booking-btn', openEditModal);
    
    // Delete booking
    $(document).on('click', '.delete-booking-btn', function() {
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
    $tbody.html(`
        <tr>
            <td colspan="10" class="text-center py-8 text-gray-400">
                <div class="loader mx-auto mb-4"></div>
                <p>กำลังโหลดข้อมูล...</p>
            </td>
        </tr>
    `);
    
    $.get('api/car_booking_list.php', function(res) {
        let data = [];
        if (res && res.list) {
            data = res.list.filter(item => String(item.teacher_id) === String(teacher_id));
        }
        
        updateStats(data);
        renderBookingTable(data);
        updateCarLegend(res.list || []);
    }, 'json').fail(function() {
        $tbody.html(`
            <tr>
                <td colspan="10" class="text-center py-8 text-red-500">
                    <div class="text-4xl mb-4">❌</div>
                    <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
                </td>
            </tr>
        `);
    });
}

// ==================== Render Table ====================
function renderBookingTable(data) {
    const $tbody = $('#bookingTableBody');
    $tbody.empty();
    
    if (data.length === 0) {
        $tbody.html(`
            <tr>
                <td colspan="10" class="text-center py-8 text-gray-400">
                    <div class="text-6xl mb-4">📭</div>
                    <p>ไม่พบรายการจอง</p>
                    <p class="text-sm">ลองจองรถยนต์ดูสิ!</p>
                </td>
            </tr>
        `);
        return;
    }
    
    data.forEach((item, idx) => {
        const statusBadge = getStatusBadge(item.status);
        const row = `
            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-blue-50/50 dark:hover:bg-slate-700/50">
                <td class="py-4 px-4 text-center font-semibold text-gray-600 dark:text-gray-400">${idx + 1}</td>
                <td class="py-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            ${(item.teacher_name || '?').charAt(0)}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">${item.teacher_name || '-'}</div>
                            <div class="text-xs text-gray-500">${item.teacher_position || ''}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-lg" style="background: ${getCarColor(item.car_id)}">
                            🚗
                        </div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">${item.car_model || '-'}</div>
                            <div class="text-xs text-gray-500">${item.license_plate || '-'}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-4 text-center text-sm">${formatThaiDateTime(item.created_at)}</td>
                <td class="py-4 px-4 text-center">
                    <div class="text-xs">
                        <div class="text-green-600 font-medium">${formatThaiDateTime(item.start_time)}</div>
                        <div class="text-gray-400">ถึง</div>
                        <div class="text-red-600 font-medium">${formatThaiDateTime(item.end_time)}</div>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <div class="max-w-[150px] truncate text-sm" title="${item.destination}">${item.destination}</div>
                </td>
                <td class="py-4 px-4">
                    <div class="max-w-[150px] truncate text-sm" title="${item.purpose}">${item.purpose}</div>
                </td>
                <td class="py-4 px-4 text-center">
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-xs font-semibold">${item.passenger_count} คน</span>
                </td>
                <td class="py-4 px-4 text-center">${statusBadge}</td>
                <td class="py-4 px-4 text-center">
                    <div class="flex justify-center gap-2">
                        <button class="edit-booking-btn w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:hover:bg-yellow-900/50 text-yellow-600 transition-colors"
                            data-id="${item.id}"
                            data-car_id="${item.car_id}"
                            data-start_time="${item.start_time}"
                            data-end_time="${item.end_time}"
                            data-destination="${encodeURIComponent(item.destination)}"
                            data-purpose="${encodeURIComponent(item.purpose)}"
                            data-notes="${encodeURIComponent(item.notes || '')}"
                            title="แก้ไข">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-booking-btn w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 transition-colors"
                            data-id="${item.id}" title="ลบ">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $tbody.append(row);
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
    $legend.empty();
    
    const uniqueCars = [];
    const seenCars = new Set();
    
    bookings.forEach(booking => {
        if (!seenCars.has(booking.car_id)) {
            seenCars.add(booking.car_id);
            uniqueCars.push({
                id: booking.car_id,
                model: booking.car_model,
                license: booking.license_plate
            });
        }
    });
    
    uniqueCars.forEach(car => {
        const color = getCarColor(car.id);
        $legend.append(`
            <div class="flex items-center gap-2 px-3 py-1.5 bg-white dark:bg-slate-700 rounded-full border border-gray-200 dark:border-gray-600 shadow-sm">
                <div class="w-3 h-3 rounded-full" style="background-color: ${color}"></div>
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">${car.model} (${car.license})</span>
            </div>
        `);
    });
}

// ==================== Calendar ====================
function initCalendar() {
    const calendarEl = document.getElementById('carBookingCalendar');
    if (!calendarEl) return;
    
    // Clear existing calendar
    calendarEl.innerHTML = '';
    
    fetch('api/car_booking_list.php')
        .then(res => res.json())
        .then(data => {
            const events = (data.list || []).map(item => ({
                id: item.id,
                title: `${item.car_model || '-'} | ${item.teacher_name || '-'}\n${item.destination || ''}`,
                start: item.start_time,
                end: item.end_time,
                backgroundColor: getCarColor(item.car_id),
                borderColor: getCarColor(item.car_id),
                extendedProps: item
            }));
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'th',
                height: 650,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'วันนี้',
                    month: 'เดือน',
                    week: 'สัปดาห์',
                    day: 'วัน',
                    list: 'รายการ'
                },
                events: events,
                eventClick: function(info) {
                    const b = info.event.extendedProps;
                    Swal.fire({
                        title: '🚗 รายละเอียดการจอง',
                        html: `
                            <div class="text-left space-y-2">
                                <p><strong>รถ:</strong> ${b.car_model || '-'}</p>
                                <p><strong>ทะเบียน:</strong> ${b.license_plate || '-'}</p>
                                <p><strong>ผู้จอง:</strong> ${b.teacher_name || '-'}</p>
                                <p><strong>เวลา:</strong> ${formatThaiDateTime(b.start_time)} - ${formatThaiDateTime(b.end_time)}</p>
                                <p><strong>จุดหมาย:</strong> ${b.destination}</p>
                                <p><strong>วัตถุประสงค์:</strong> ${b.purpose}</p>
                                <p><strong>ผู้โดยสาร:</strong> ${b.passenger_count} คน</p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'ปิด',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            });
            
            calendar.render();
        });
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

function toDatetimeLocal(dt) {
    if (!dt) return '';
    return dt.replace(' ', 'T').slice(0, 16);
}
