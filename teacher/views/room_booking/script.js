/**
 * Room Booking JavaScript Module
 * Modern UI with FullCalendar integration
 */

// Global variables
let calendar;
let currentViewMode = 'my'; // 'my' or 'all'
let timeSelectionMode = 'period'; // 'period' or 'custom'
let editTimeSelectionMode = 'period'; // 'period' or 'custom'
let roomsData = []; // Store rooms data from database

// ==================== Initialize ====================
$(document).ready(function() {
    // Load rooms from database first
    loadRoomsFromDatabase();
    
    // Set default date
    $('#date').val(new Date().toISOString().split('T')[0]);
    
    // Initialize period selection
    initPeriodSelection();
    initEditPeriodSelection();
    
    // Initialize time mode selection
    initTimeModeSelection();
    initEditTimeModeSelection();
    
    // Initialize room layout selection
    initRoomLayoutSelection();
    initEditRoomLayoutSelection();
    
    // Initialize calendar
    initCalendar();
    
    // Load bookings
    fetchBookings();
    
    // Event handlers
    setupEventHandlers();
    
    // Enable/disable other media text input
    $('#other_media').change(function() {
        $('#other_media_text').prop('disabled', !this.checked);
        if (!this.checked) $('#other_media_text').val('');
        updateMediaField();
    });
    
    $('#edit_other_media').change(function() {
        $('#edit_other_media_text').prop('disabled', !this.checked);
        if (!this.checked) $('#edit_other_media_text').val('');
        updateEditMediaField();
    });
    
    // Custom time inputs
    $('#customTimeStart, #customTimeEnd').on('change', updateCustomTimeDisplay);
    $('#editCustomTimeStart, #editCustomTimeEnd').on('change', updateEditCustomTimeDisplay);
    
    // Custom room layout handlers
    initCustomRoomLayout();
    initEditCustomRoomLayout();
});

// ==================== Time Mode Selection ====================
function initTimeModeSelection() {
    $('#modeByPeriod').on('click', function() {
        timeSelectionMode = 'period';
        // Reset all buttons to inactive state
        $('#modeByTime').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
        // Set this button to active state
        $(this).removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
        $('#periodSelection').removeClass('hidden');
        $('#customTimeSelection').addClass('hidden');
        updateSelectedPeriods();
    });
    
    $('#modeByTime').on('click', function() {
        timeSelectionMode = 'custom';
        // Reset all buttons to inactive state
        $('#modeByPeriod').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
        // Set this button to active state
        $(this).removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
        $('#periodSelection').addClass('hidden');
        $('#customTimeSelection').removeClass('hidden');
        updateCustomTimeDisplay();
    });
}

function initEditTimeModeSelection() {
    $('#editModeByPeriod').on('click', function() {
        editTimeSelectionMode = 'period';
        // Reset all buttons to inactive state
        $('#editModeByTime').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
        // Set this button to active state
        $(this).removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
        $('#editPeriodSelection').removeClass('hidden');
        $('#editCustomTimeSelection').addClass('hidden');
        updateEditSelectedPeriods();
    });
    
    $('#editModeByTime').on('click', function() {
        editTimeSelectionMode = 'custom';
        // Reset all buttons to inactive state
        $('#editModeByPeriod').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
        // Set this button to active state
        $(this).removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
        $('#editPeriodSelection').addClass('hidden');
        $('#editCustomTimeSelection').removeClass('hidden');
        updateEditCustomTimeDisplay();
    });
}

// ==================== Custom Room Layout ====================
function initCustomRoomLayout() {
    // Show/hide custom input when "other" is selected
    $('input[name="room_layout"]').on('change', function() {
        if ($(this).val() === 'other') {
            $('#customRoomLayoutDiv').removeClass('hidden');
            $('#customRoomLayoutText').focus();
        } else {
            $('#customRoomLayoutDiv').addClass('hidden');
        }
    });
}

function initEditCustomRoomLayout() {
    // Show/hide custom input when "other" is selected in edit modal
    $('#editBookingForm input[name="room_layout"]').on('change', function() {
        if ($(this).val() === 'other') {
            $('#editCustomRoomLayoutDiv').removeClass('hidden');
            $('#editCustomRoomLayoutText').focus();
        } else {
            $('#editCustomRoomLayoutDiv').addClass('hidden');
        }
    });
}

function updateCustomTimeDisplay() {
    const startTime = $('#customTimeStart').val();
    const endTime = $('#customTimeEnd').val();
    const displayEl = $('#customTimeDisplay');
    
    if (startTime && endTime) {
        displayEl.html(`✅ เวลา: <strong>${startTime} - ${endTime}</strong>`);
        $('#time_start').val(startTime);
        $('#time_end').val(endTime);
    } else {
        displayEl.text('🕐 กรุณาระบุเวลาเริ่มต้นและสิ้นสุด');
        $('#time_start').val('');
        $('#time_end').val('');
    }
}

function updateEditCustomTimeDisplay() {
    const startTime = $('#editCustomTimeStart').val();
    const endTime = $('#editCustomTimeEnd').val();
    const displayEl = $('#editCustomTimeDisplay');
    
    if (startTime && endTime) {
        displayEl.html(`✅ เวลา: <strong>${startTime} - ${endTime}</strong>`);
        $('#editTimeStart').val(startTime);
        $('#editTimeEnd').val(endTime);
    } else {
        displayEl.text('🕐 กรุณาระบุเวลาเริ่มต้นและสิ้นสุด');
    }
}

// ==================== Room Layout Selection ====================
function initRoomLayoutSelection() {
    $('.room-layout-option input').on('change', function() {
        // Visual feedback handled by CSS
    });
}

function initEditRoomLayoutSelection() {
    document.querySelectorAll('.edit-room-layout-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove selection from all options
            document.querySelectorAll('.edit-room-layout-option').forEach(opt => {
                const div = opt.querySelector('div');
                div.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/30');
                div.classList.add('border-transparent');
            });
            
            // Add selection to clicked option
            const div = this.querySelector('div');
            div.classList.add('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/30');
            div.classList.remove('border-transparent');
        });
    });
}

// ==================== Load Rooms from Database ====================
function loadRoomsFromDatabase() {
    $.ajax({
        url: '../officer/api/get_rooms.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            roomsData = response.rooms || [];
            populateRoomDropdowns();
        },
        error: function() {
            console.error('Failed to load rooms from database');
            // Set default option if failed
            $('#location, #editLocation').html('<option value="">-- ไม่สามารถโหลดห้องได้ --</option>');
        }
    });
}

function populateRoomDropdowns() {
    // Main form dropdown
    let mainOptions = '<option value="">-- เลือกห้องประชุม --</option>';
    let filterOptions = '<option value="">ทั้งหมด</option>';
    let editOptions = '';
    
    roomsData.forEach(room => {
        if (room.status != 1) return; // Only active rooms
        const emoji = room.emoji || '🏢';
        // ใช้ room_id เป็น value และเก็บชื่อห้องใน data-name
        mainOptions += `<option value="${room.id}" data-name="${room.room_name}">${emoji} ${room.room_name}</option>`;
        filterOptions += `<option value="${room.room_name}">${room.room_name}</option>`;
        editOptions += `<option value="${room.id}" data-name="${room.room_name}">${emoji} ${room.room_name}</option>`;
    });
    
    $('#location').html(mainOptions);
    $('#searchLocation').html(filterOptions);
    $('#editLocation').html(editOptions || '<option value="">-- ไม่มีห้องประชุม --</option>');
    
    // เพิ่ม event listener เพื่ออัพเดท hidden field room_id เมื่อเลือกห้อง
    $('#location').off('change.roomId').on('change.roomId', function() {
        const selectedOption = $(this).find('option:selected');
        $('#room_id').val($(this).val());
        $('#location_name').val(selectedOption.data('name') || '');
    });
    
    $('#editLocation').off('change.roomId').on('change.roomId', function() {
        const selectedOption = $(this).find('option:selected');
        $('#edit_room_id').val($(this).val());
        $('#edit_location_name').val(selectedOption.data('name') || '');
    });
}

// Get room color from database
function getRoomColor(roomName) {
    const room = roomsData.find(r => roomName && (roomName.includes(r.room_name) || r.room_name.includes(roomName)));
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

// Get room emoji from database
function getRoomEmoji(roomName) {
    const room = roomsData.find(r => roomName && (roomName.includes(r.room_name) || r.room_name.includes(roomName)));
    return room ? (room.emoji || '🏢') : '🏢';
}

// Get room gradient color class from database
function getRoomGradient(roomName) {
    const room = roomsData.find(r => roomName && (roomName.includes(r.room_name) || r.room_name.includes(roomName)));
    if (room) {
        const gradientMap = {
            'red': 'from-red-500 to-rose-500',
            'blue': 'from-blue-500 to-cyan-500',
            'green': 'from-green-500 to-emerald-500',
            'amber': 'from-amber-500 to-orange-500',
            'purple': 'from-purple-500 to-violet-500',
            'pink': 'from-pink-500 to-rose-500',
            'cyan': 'from-cyan-500 to-teal-500',
            'orange': 'from-orange-500 to-red-500'
        };
        return gradientMap[room.color] || 'from-purple-500 to-pink-500';
    }
    return 'from-purple-500 to-pink-500';
}

// ==================== Period Selection ====================
function initPeriodSelection() {
    const periodCheckboxes = document.querySelectorAll('.period-checkbox');
    
    periodCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            const input = this.querySelector('.period-input');
            input.checked = !input.checked;
            this.classList.toggle('selected', input.checked);
            updateSelectedPeriods();
        });
    });
}

function initEditPeriodSelection() {
    const editPeriodCheckboxes = document.querySelectorAll('.edit-period-checkbox');
    
    editPeriodCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function() {
            const input = this.querySelector('.edit-period-input');
            input.checked = !input.checked;
            this.classList.toggle('selected', input.checked);
            updateEditSelectedPeriods();
        });
    });
}

function updateSelectedPeriods() {
    const selected = document.querySelectorAll('.period-input:checked');
    const displayEl = document.getElementById('selectedPeriods');
    const timeStartEl = document.getElementById('time_start');
    const timeEndEl = document.getElementById('time_end');
    
    if (selected.length === 0) {
        displayEl.textContent = '🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)';
        timeStartEl.value = '';
        timeEndEl.value = '';
        return;
    }
    
    // Get periods and times
    const periods = [];
    let minTime = '23:59';
    let maxTime = '00:00';
    
    selected.forEach(input => {
        periods.push(`คาบ ${input.dataset.period}`);
        if (input.dataset.time < minTime) minTime = input.dataset.time;
        if (input.dataset.end > maxTime) maxTime = input.dataset.end;
    });
    
    displayEl.innerHTML = `✅ เลือก: <strong>${periods.join(', ')}</strong> (${minTime} - ${maxTime})`;
    timeStartEl.value = minTime;
    timeEndEl.value = maxTime;
}

function updateEditSelectedPeriods() {
    const selected = document.querySelectorAll('.edit-period-input:checked');
    const displayEl = document.getElementById('editSelectedPeriods');
    const timeStartEl = document.getElementById('editTimeStart');
    const timeEndEl = document.getElementById('editTimeEnd');
    
    if (selected.length === 0) {
        displayEl.textContent = '🕐 เลือกคาบเรียนที่ต้องการ';
        timeStartEl.value = '';
        timeEndEl.value = '';
        return;
    }
    
    const periods = [];
    let minTime = '23:59';
    let maxTime = '00:00';
    
    selected.forEach(input => {
        periods.push(`คาบ ${input.dataset.period}`);
        if (input.dataset.time < minTime) minTime = input.dataset.time;
        if (input.dataset.end > maxTime) maxTime = input.dataset.end;
    });
    
    displayEl.innerHTML = `✅ เลือก: <strong>${periods.join(', ')}</strong> (${minTime} - ${maxTime})`;
    timeStartEl.value = minTime;
    timeEndEl.value = maxTime;
}

// ==================== Media Field ====================
function updateMediaField() {
    const checkboxes = document.querySelectorAll('input[name="media_items[]"]:checked');
    const items = [];
    
    checkboxes.forEach(cb => {
        items.push(cb.value);
    });
    
    if ($('#other_media').is(':checked') && $('#other_media_text').val()) {
        items.push($('#other_media_text').val());
    }
    
    $('#media_hidden').val(items.join(', '));
}

function updateEditMediaField() {
    const checkboxes = document.querySelectorAll('input[name="edit_media_items[]"]:checked');
    const items = [];
    
    checkboxes.forEach(cb => {
        items.push(cb.value);
    });
    
    if ($('#edit_other_media').is(':checked') && $('#edit_other_media_text').val()) {
        items.push($('#edit_other_media_text').val());
    }
    
    $('#edit_media_hidden').val(items.join(', '));
}

// ==================== Event Handlers ====================
function setupEventHandlers() {
    // Form submit
    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();
        submitBooking();
    });
    
    // Edit form submit
    $('#editBookingForm').on('submit', function(e) {
        e.preventDefault();
        updateBooking();
    });
    
    // Search form
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        searchBookings();
    });
    
    // Show my bookings
    $('#showMyBookings').on('click', function() {
        currentViewMode = 'my';
        $(this).addClass('ring-2 ring-offset-2 ring-blue-500');
        $('#showAllBookings').removeClass('ring-2 ring-offset-2 ring-green-500');
        fetchBookings();
    });
    
    // Show all bookings
    $('#showAllBookings').on('click', function() {
        currentViewMode = 'all';
        $(this).addClass('ring-2 ring-offset-2 ring-green-500');
        $('#showMyBookings').removeClass('ring-2 ring-offset-2 ring-blue-500');
        fetchAllBookings();
    });
    
    // Clear search
    $('#clearSearch').on('click', function() {
        $('#searchDate').val('');
        $('#searchLocation').val('');
        if (currentViewMode === 'my') {
            fetchBookings();
        } else {
            fetchAllBookings();
        }
    });
    
    // Refresh list
    $('#refreshList').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        
        if (currentViewMode === 'my') {
            fetchBookings();
        } else {
            fetchAllBookings();
        }
        
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });
    
    // Close edit modal
    $('#closeEditModal').on('click', function() {
        $('#editModal').addClass('hidden');
    });
    
    // Close modal on backdrop click
    $('#editModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
}

// ==================== Calendar ====================
function initCalendar() {
    const calendarEl = document.getElementById('calendar');
    
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        buttonText: {
            today: 'วันนี้',
            month: 'เดือน',
            week: 'สัปดาห์',
            list: 'รายการ'
        },
        height: 'auto',
        dayMaxEvents: 3,
        moreLinkText: 'เพิ่มเติม',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: 'api/fetch_all_bookings.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const bookings = response.list || response.data || [];
                    if (bookings.length > 0) {
                        const events = bookings.map(function(booking) {
                            // Color based on location from database
                            let color = getRoomColor(booking.location);
                            let emoji = getRoomEmoji(booking.location);
                            
                            // Get room layout text
                            let layoutText = '-';
                            if (booking.room_layout) {
                                const layoutMap = {
                                    'theater': '🎭 โรงภาพยนตร์',
                                    'classroom': '🏫 ห้องเรียน',
                                    'u-shape': '🔲 ตัว U',
                                    'boardroom': '📋 โต๊ะประชุม',
                                    'banquet': '🍽️ โต๊ะกลม',
                                    'none': '-'
                                };
                                if (booking.room_layout.startsWith('custom:')) {
                                    layoutText = '✏️ ' + booking.room_layout.substring(7);
                                } else {
                                    layoutText = layoutMap[booking.room_layout] || '-';
                                }
                            }
                            
                            // Get status text
                            let statusText = '⏳ รอการอนุมัติ';
                            let statusClass = 'text-yellow-600';
                            if (booking.status == 1) { statusText = '✅ อนุมัติแล้ว'; statusClass = 'text-green-600'; }
                            else if (booking.status == 2) { statusText = '❌ ยกเลิก'; statusClass = 'text-red-600'; }
                            
                            // Check if it's user's booking
                            const isOwner = booking.teach_id == teach_id;
                            
                            // Short location name for display (truncate if too long)
                            let shortLocation = booking.location;
                            if (shortLocation.length > 15) {
                                shortLocation = shortLocation.substring(0, 12) + '...';
                            }
                            
                            const timeStart = (booking.time_start || '08:30').substring(0, 5);
                            const timeEnd = (booking.time_end || '16:30').substring(0, 5);
                            
                            return {
                                id: booking.id,
                                title: `${emoji} ${shortLocation}`,
                                start: booking.date + 'T' + (booking.time_start || '08:30'),
                                end: booking.date + 'T' + (booking.time_end || '16:30'),
                                color: color,
                                textColor: '#ffffff',
                                borderColor: isOwner ? '#fbbf24' : color,
                                className: isOwner ? 'fc-event-owner' : '',
                                extendedProps: {
                                    booking: booking,
                                    location: booking.location,
                                    purpose: booking.purpose,
                                    teacher_name: booking.teacher_name || booking.teach_id,
                                    teach_id: booking.teach_id,
                                    time: `${timeStart} - ${timeEnd}`,
                                    media: booking.media || '-',
                                    phone: booking.phone || '-',
                                    room_layout: layoutText,
                                    status: booking.status,
                                    statusText: statusText,
                                    statusClass: statusClass,
                                    isOwner: isOwner
                                }
                            };
                        });
                        successCallback(events);
                    } else {
                        successCallback([]);
                    }
                },
                error: function() {
                    failureCallback();
                }
            });
        },
        eventClick: function(info) {
            const event = info.event;
            const props = event.extendedProps;
            const dateObj = new Date(event.start);
            const formattedDate = dateObj.toLocaleDateString('th-TH', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
            
            // Get location emoji and color from database
            let locationEmoji = getRoomEmoji(props.location);
            let locationColor = getRoomGradient(props.location);
            
            // Status badge
            let statusBadge = '';
            if (props.status == 1) {
                statusBadge = `<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-lg shadow-green-500/30">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    อนุมัติแล้ว
                </span>`;
            } else if (props.status == 2) {
                statusBadge = `<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-red-400 to-rose-500 text-white shadow-lg shadow-red-500/30">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    ยกเลิกแล้ว
                </span>`;
            } else {
                statusBadge = `<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-semibold bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-lg shadow-yellow-500/30 animate-pulse">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    รอการอนุมัติ
                </span>`;
            }
            
            Swal.fire({
                html: `
                    <div class="relative">
                        <!-- Header with gradient -->
                        <div class="bg-gradient-to-r ${locationColor} -mx-6 -mt-6 px-6 pt-8 pb-6 rounded-t-2xl">
                            <div class="text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl mb-3 shadow-xl">
                                    <span class="text-4xl">${locationEmoji}</span>
                                </div>
                                <h2 class="text-xl font-bold text-white drop-shadow-lg">${props.location}</h2>
                                <div class="mt-3">${statusBadge}</div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="pt-6 space-y-4">
                            <!-- Date & Time Row -->
                            <div class="flex gap-3">
                                <div class="flex-1 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-purple-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-purple-500 rounded-lg text-white text-sm">📅</span>
                                        <span class="text-xs font-medium text-purple-600 dark:text-purple-400 uppercase tracking-wide">วันที่</span>
                                    </div>
                                    <div class="font-bold text-gray-800 dark:text-white text-sm">${formattedDate}</div>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-blue-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-lg text-white text-sm">⏰</span>
                                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wide">เวลา</span>
                                    </div>
                                    <div class="font-bold text-gray-800 dark:text-white">${props.time} น.</div>
                                </div>
                            </div>
                            
                            <!-- Purpose -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-green-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-lg text-white text-sm">🎯</span>
                                    <span class="text-xs font-medium text-green-600 dark:text-green-400 uppercase tracking-wide">วัตถุประสงค์</span>
                                </div>
                                <div class="font-semibold text-gray-800 dark:text-white">${props.purpose || '-'}</div>
                            </div>
                            
                            <!-- Room Layout & Equipment Row -->
                            <div class="flex gap-3">
                                <div class="flex-1 bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-amber-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-amber-500 rounded-lg text-white text-sm">🪑</span>
                                        <span class="text-xs font-medium text-amber-600 dark:text-amber-400 uppercase tracking-wide">รูปแบบห้อง</span>
                                    </div>
                                    <div class="font-semibold text-gray-800 dark:text-white text-sm">${props.room_layout}</div>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-pink-50 to-rose-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-pink-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-pink-500 rounded-lg text-white text-sm">🛠️</span>
                                        <span class="text-xs font-medium text-pink-600 dark:text-pink-400 uppercase tracking-wide">อุปกรณ์</span>
                                    </div>
                                    <div class="font-semibold text-gray-800 dark:text-white text-sm">${props.media}</div>
                                </div>
                            </div>
                            
                            <!-- Teacher & Contact Row -->
                            <div class="flex gap-3">
                                <div class="flex-1 bg-gradient-to-br from-indigo-50 to-violet-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-indigo-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-indigo-500 rounded-lg text-white text-sm">👨‍🏫</span>
                                        <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 uppercase tracking-wide">ผู้จอง</span>
                                    </div>
                                    <div class="font-bold text-gray-800 dark:text-white">${props.teacher_name}</div>
                                </div>
                                <div class="flex-1 bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-2xl border border-teal-100 dark:border-slate-600 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="flex items-center justify-center w-8 h-8 bg-teal-500 rounded-lg text-white text-sm">📞</span>
                                        <span class="text-xs font-medium text-teal-600 dark:text-teal-400 uppercase tracking-wide">ติดต่อ</span>
                                    </div>
                                    <div class="font-bold text-gray-800 dark:text-white">${props.phone}</div>
                                </div>
                            </div>
                            
                            ${props.isOwner ? `
                            <!-- Owner Badge -->
                            <div class="text-center pt-2">
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full text-sm font-medium shadow-lg shadow-purple-500/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    นี่คือการจองของคุณ
                                </span>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `,
                showCloseButton: true,
                showConfirmButton: props.isOwner,
                confirmButtonText: props.isOwner ? '<i class="fas fa-edit mr-2"></i>แก้ไข' : '',
                confirmButtonColor: '#8b5cf6',
                showCancelButton: props.isOwner,
                cancelButtonText: props.isOwner ? '<i class="fas fa-trash mr-2"></i>ลบ' : '',
                cancelButtonColor: '#ef4444',
                width: '520px',
                padding: 0,
                customClass: {
                    popup: 'rounded-3xl overflow-hidden',
                    htmlContainer: 'p-6 pt-0 m-0',
                    actions: 'px-6 pb-6',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all',
                    cancelButton: 'rounded-xl px-6 py-3 font-semibold shadow-lg shadow-red-500/30 hover:shadow-red-500/50 transition-all'
                }
            }).then((result) => {
                if (result.isConfirmed && props.isOwner) {
                    openEditModal(event.id);
                } else if (result.dismiss === Swal.DismissReason.cancel && props.isOwner) {
                    confirmDelete(event.id);
                }
            });
        },
        dateClick: function(info) {
            $('#date').val(info.dateStr);
            // Scroll to form
            $('html, body').animate({
                scrollTop: $('#bookingForm').offset().top - 100
            }, 500);
            
            // Flash effect on date input
            $('#date').addClass('ring-2 ring-purple-500');
            setTimeout(() => $('#date').removeClass('ring-2 ring-purple-500'), 2000);
        },
        eventDidMount: function(info) {
            // Add tooltip
            if (info.event.extendedProps.isOwner) {
                info.el.style.borderWidth = '2px';
                info.el.style.borderStyle = 'solid';
            }
        }
    });
    
    calendar.render();
    
    // Refresh calendar button
    $('#refreshCalendar').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        calendar.refetchEvents();
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });
}

// ==================== Fetch Bookings ====================
function fetchBookings() {
    const searchDate = $('#searchDate').val();
    const searchLocation = $('#searchLocation').val();
    
    $.ajax({
        url: 'api/fetch_bookings.php',
        type: 'GET',
        data: { 
            teach_id: teach_id
        },
        dataType: 'json',
        beforeSend: function() {
            $('#bookingList').html(`
                <div class="text-center py-8 text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p>กำลังโหลดข้อมูล...</p>
                </div>
            `);
        },
        success: function(response) {
            // API returns 'list' instead of 'data'
            let bookings = response.list || response.data || [];
            
            // Filter by date if specified
            if (searchDate) {
                bookings = bookings.filter(b => b.date === searchDate);
            }
            
            // Filter by location if specified
            if (searchLocation) {
                bookings = bookings.filter(b => b.location === searchLocation);
            }
            
            if (bookings.length > 0) {
                renderBookingList(bookings, true);
            } else {
                $('#bookingList').html(`
                    <div class="text-center py-8">
                        <div class="text-6xl mb-4">📭</div>
                        <p class="text-gray-500 dark:text-gray-400">ไม่พบรายการจอง</p>
                        <p class="text-sm text-gray-400">ลองจองห้องประชุมดูสิ!</p>
                    </div>
                `);
            }
        },
        error: function() {
            $('#bookingList').html(`
                <div class="text-center py-8 text-red-500">
                    <div class="text-6xl mb-4">❌</div>
                    <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
                </div>
            `);
        }
    });
}

function fetchAllBookings() {
    const date = $('#searchDate').val();
    const location = $('#searchLocation').val();
    
    $.ajax({
        url: 'api/fetch_all_bookings.php',
        type: 'GET',
        data: { 
            date: date,
            location: location
        },
        dataType: 'json',
        beforeSend: function() {
            $('#bookingList').html(`
                <div class="text-center py-8 text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p>กำลังโหลดข้อมูลทั้งหมด...</p>
                </div>
            `);
        },
        success: function(response) {
            // API returns 'list' instead of 'data'
            const bookings = response.list || response.data || [];
            if (bookings.length > 0) {
                renderBookingList(bookings, false);
            } else {
                $('#bookingList').html(`
                    <div class="text-center py-8">
                        <div class="text-6xl mb-4">📭</div>
                        <p class="text-gray-500 dark:text-gray-400">ไม่พบรายการจอง</p>
                    </div>
                `);
            }
        },
        error: function() {
            $('#bookingList').html(`
                <div class="text-center py-8 text-red-500">
                    <div class="text-6xl mb-4">❌</div>
                    <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
                </div>
            `);
        }
    });
}

function searchBookings() {
    if (currentViewMode === 'my') {
        fetchBookings();
    } else {
        fetchAllBookings();
    }
}

// ==================== Render Booking List ====================
function renderBookingList(bookings, showActions) {
    let html = '';
    
    bookings.forEach(booking => {
        const dateObj = new Date(booking.date);
        const formattedDate = dateObj.toLocaleDateString('th-TH', { 
            weekday: 'short', 
            day: 'numeric', 
            month: 'short', 
            year: '2-digit' 
        });
        
        // Get room emoji from database
        let roomEmoji = getRoomEmoji(booking.location);
        
        const isOwner = booking.teach_id === teach_id;
        
        // Get room layout display
        const layoutIcons = {
            'theater': '🎭 โรงภาพยนตร์',
            'classroom': '🏫 ห้องเรียน',
            'u-shape': '🔲 ตัว U',
            'boardroom': '📋 โต๊ะประชุม',
            'banquet': '🍽️ โต๊ะกลม',
            'none': '',
            'other': '✏️ อื่นๆ'
        };
        
        let layoutDisplay = '';
        if (booking.room_layout) {
            if (booking.room_layout.startsWith('custom:')) {
                // Custom layout - show the custom text
                layoutDisplay = '✏️ ' + booking.room_layout.substring(7);
            } else if (layoutIcons[booking.room_layout]) {
                layoutDisplay = layoutIcons[booking.room_layout];
            }
        }
        
        html += `
            <div class="booking-card rounded-xl p-4 dark:bg-slate-700/50 ${isOwner ? 'bg-purple-50' : 'bg-gray-50'}">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-2xl">${roomEmoji}</span>
                            <h4 class="font-bold text-gray-900 dark:text-white">${booking.location}</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-calendar text-purple-400"></i>
                                <span>${formattedDate}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class="fas fa-clock text-blue-400"></i>
                                <span>${booking.time_start || '08:30'} - ${booking.time_end || '16:30'}</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 line-clamp-2">
                            <i class="fas fa-bullseye text-green-400 mr-1"></i>
                            ${booking.purpose || 'ไม่ระบุวัตถุประสงค์'}
                        </p>
                        ${layoutDisplay ? `<p class="mt-1 text-xs text-blue-600 dark:text-blue-400"><i class="fas fa-chair mr-1"></i>${layoutDisplay}</p>` : ''}
                        ${booking.media ? `<p class="mt-1 text-xs text-gray-500"><i class="fas fa-tools mr-1"></i>${booking.media}</p>` : ''}
                        ${!isOwner && booking.teacher_name ? `<p class="mt-1 text-xs text-purple-600"><i class="fas fa-user mr-1"></i>${booking.teacher_name}</p>` : ''}
                    </div>
                    ${showActions && isOwner ? `
                        <div class="flex gap-1 ml-2">
                            <button onclick="openEditModal(${booking.id})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-100 hover:bg-yellow-200 text-yellow-600 transition-colors" title="แก้ไข">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="confirmDelete(${booking.id})" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition-colors" title="ลบ">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    $('#bookingList').html(html);
}

// ==================== Submit Booking ====================
function submitBooking() {
    // Validate time selection based on mode
    const timeStart = $('#time_start').val();
    const timeEnd = $('#time_end').val();
    
    if (!timeStart || !timeEnd) {
        if (timeSelectionMode === 'period') {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกคาบเรียน',
                text: 'กรุณาเลือกอย่างน้อย 1 คาบ',
                confirmButtonColor: '#8b5cf6'
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาระบุเวลา',
                text: 'กรุณาระบุเวลาเริ่มต้นและสิ้นสุด',
                confirmButtonColor: '#8b5cf6'
            });
        }
        return;
    }
    
    // Validate time order
    if (timeStart >= timeEnd) {
        Swal.fire({
            icon: 'warning',
            title: 'เวลาไม่ถูกต้อง',
            text: 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด',
            confirmButtonColor: '#8b5cf6'
        });
        return;
    }
    
    const formData = new FormData($('#bookingForm')[0]);
    formData.append('teach_id', teach_id);
    
    $.ajax({
        url: 'api/insert_booking.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังบันทึก...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ! 🎉',
                    text: 'จองห้องประชุมเรียบร้อยแล้ว',
                    confirmButtonColor: '#8b5cf6',
                    timer: 2000,
                    timerProgressBar: true
                });
                
                // Reset form
                $('#bookingForm')[0].reset();
                $('#date').val(new Date().toISOString().split('T')[0]);
                
                // Reset period selection
                document.querySelectorAll('.period-checkbox').forEach(el => {
                    el.classList.remove('selected');
                    el.querySelector('.period-input').checked = false;
                });
                updateSelectedPeriods();
                
                // Reset custom time inputs
                $('#customTimeStart').val('');
                $('#customTimeEnd').val('');
                updateCustomTimeDisplay();
                
                // Reset time mode to period
                timeSelectionMode = 'period';
                $('#modeByPeriod').click();
                
                // Reset room layout
                $('input[name="room_layout"][value="none"]').prop('checked', true);
                $('#customRoomLayoutDiv').addClass('hidden');
                $('#customRoomLayoutText').val('');
                
                // Reset visual selection for room layout
                document.querySelectorAll('.room-layout-option').forEach(option => {
                    const div = option.querySelector('div');
                    div.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/30');
                    div.classList.add('border-transparent');
                });
                
                // Reset media checkboxes
                document.querySelectorAll('input[name="media_items[]"]').forEach(cb => cb.checked = false);
                $('#other_media').prop('checked', false);
                $('#other_media_text').val('').prop('disabled', true);
                $('#media_hidden').val('');
                
                // Refresh list and calendar
                fetchBookings();
                calendar.refetchEvents();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: response.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        }
    });
}

// ==================== Edit Booking ====================
function openEditModal(bookingId) {
    $.ajax({
        url: 'api/fetch_booking_detail.php',
        type: 'GET',
        data: { id: bookingId },
        dataType: 'json',
        success: function(response) {
            // API returns 'booking' instead of 'data'
            const booking = response.booking || response.data;
            if (response.success && booking) {
                // Populate form
                $('#editId').val(booking.id);
                $('#editDate').val(booking.date);
                
                // Set room - ใช้ room_id ถ้ามี ไม่งั้นหาจากชื่อห้อง
                if (booking.room_id) {
                    $('#editLocation').val(booking.room_id);
                    $('#edit_room_id').val(booking.room_id);
                    $('#edit_location_name').val(booking.location);
                } else {
                    // Fallback: หาห้องจากชื่อ
                    const room = roomsData.find(r => r.room_name === booking.location);
                    if (room) {
                        $('#editLocation').val(room.id);
                        $('#edit_room_id').val(room.id);
                        $('#edit_location_name').val(booking.location);
                    } else {
                        $('#editLocation').val('');
                        $('#edit_room_id').val('');
                        $('#edit_location_name').val(booking.location);
                    }
                }
                
                $('#editPurpose').val(booking.purpose);
                $('#editPhone').val(booking.phone || '');
                
                // Determine time mode and set accordingly
                const isPeriodTime = isPeriodBasedTime(booking.time_start, booking.time_end);
                
                if (isPeriodTime) {
                    // Period-based time
                    editTimeSelectionMode = 'period';
                    $('#editModeByPeriod').removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
                    $('#editModeByTime').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
                    $('#editPeriodSelection').removeClass('hidden');
                    $('#editCustomTimeSelection').addClass('hidden');
                    setEditPeriodsByTime(booking.time_start, booking.time_end);
                } else {
                    // Custom time
                    editTimeSelectionMode = 'custom';
                    $('#editModeByTime').removeClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300').addClass('bg-purple-500 text-white');
                    $('#editModeByPeriod').removeClass('bg-purple-500 text-white').addClass('bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300');
                    $('#editPeriodSelection').addClass('hidden');
                    $('#editCustomTimeSelection').removeClass('hidden');
                    $('#editCustomTimeStart').val(booking.time_start);
                    $('#editCustomTimeEnd').val(booking.time_end);
                    $('#editTimeStart').val(booking.time_start);
                    $('#editTimeEnd').val(booking.time_end);
                    updateEditCustomTimeDisplay();
                }
                
                // Set room layout in edit form
                let roomLayoutValue = booking.room_layout || 'none';
                let customLayoutText = '';
                
                // Check if it's a custom layout
                if (roomLayoutValue.startsWith('custom:')) {
                    customLayoutText = roomLayoutValue.substring(7);
                    roomLayoutValue = 'other';
                }
                
                // Set the radio button
                $(`#editBookingForm input[name="room_layout"][value="${roomLayoutValue}"]`).prop('checked', true);
                
                // Handle custom layout text
                if (roomLayoutValue === 'other') {
                    $('#editCustomRoomLayoutDiv').removeClass('hidden');
                    $('#editCustomRoomLayoutText').val(customLayoutText);
                } else {
                    $('#editCustomRoomLayoutDiv').addClass('hidden');
                    $('#editCustomRoomLayoutText').val('');
                }
                
                // Update visual selection for room layout
                document.querySelectorAll('.edit-room-layout-option').forEach(option => {
                    const input = option.querySelector('input');
                    const div = option.querySelector('div');
                    if (input.checked) {
                        div.classList.add('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/30');
                        div.classList.remove('border-transparent');
                    } else {
                        div.classList.remove('border-purple-500', 'bg-purple-50', 'dark:bg-purple-900/30');
                        div.classList.add('border-transparent');
                    }
                });
                
                // Set media checkboxes
                setEditMediaCheckboxes(booking.media);
                
                // Show modal
                $('#editModal').removeClass('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่พบข้อมูล',
                    text: 'ไม่พบรายการจองนี้',
                    confirmButtonColor: '#ef4444'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถโหลดข้อมูลได้',
                confirmButtonColor: '#ef4444'
            });
        }
    });
}

// Check if time is based on standard periods
function isPeriodBasedTime(startTime, endTime) {
    const periodStarts = ['08:30', '09:25', '10:20', '11:15', '12:10', '13:05', '14:00', '14:55'];
    const periodEnds = ['09:25', '10:20', '11:15', '12:10', '13:05', '14:00', '14:55', '15:50'];
    
    return periodStarts.includes(startTime) && periodEnds.includes(endTime);
}

function setEditPeriodsByTime(startTime, endTime) {
    const periodTimes = {
        '08:30': 1, '09:25': 2, '10:20': 3, '11:15': 4,
        '12:10': 5, '13:05': 6, '14:00': 7, '14:55': 8
    };
    const periodEnds = {
        '09:25': 1, '10:20': 2, '11:15': 3, '12:10': 4,
        '13:05': 5, '14:00': 6, '14:55': 7, '15:50': 8
    };
    
    // Reset all
    document.querySelectorAll('.edit-period-checkbox').forEach(el => {
        el.classList.remove('selected');
        el.querySelector('.edit-period-input').checked = false;
    });
    
    // Find start and end periods
    const startPeriod = periodTimes[startTime] || 1;
    const endPeriod = periodEnds[endTime] || 8;
    
    // Select periods in range
    document.querySelectorAll('.edit-period-input').forEach(input => {
        const period = parseInt(input.dataset.period);
        if (period >= startPeriod && period <= endPeriod) {
            input.checked = true;
            input.closest('.edit-period-checkbox').classList.add('selected');
        }
    });
    
    updateEditSelectedPeriods();
}

function setEditMediaCheckboxes(mediaStr) {
    // Reset all
    document.querySelectorAll('input[name="edit_media_items[]"]').forEach(cb => cb.checked = false);
    $('#edit_other_media').prop('checked', false);
    $('#edit_other_media_text').val('').prop('disabled', true);
    
    if (!mediaStr) return;
    
    const items = mediaStr.split(',').map(s => s.trim());
    const knownItems = ['ไมค์', 'โปรเจคเตอร์', 'โน๊ตบุ๊ค', 'แอร์'];
    const otherItems = [];
    
    items.forEach(item => {
        if (knownItems.includes(item)) {
            document.querySelector(`input[name="edit_media_items[]"][value="${item}"]`).checked = true;
        } else if (item) {
            otherItems.push(item);
        }
    });
    
    if (otherItems.length > 0) {
        $('#edit_other_media').prop('checked', true);
        $('#edit_other_media_text').val(otherItems.join(', ')).prop('disabled', false);
    }
    
    updateEditMediaField();
}

function updateBooking() {
    // Validate time selection based on mode
    const timeStart = $('#editTimeStart').val();
    const timeEnd = $('#editTimeEnd').val();
    
    if (!timeStart || !timeEnd) {
        if (editTimeSelectionMode === 'period') {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกคาบเรียน',
                text: 'กรุณาเลือกอย่างน้อย 1 คาบ',
                confirmButtonColor: '#8b5cf6'
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาระบุเวลา',
                text: 'กรุณาระบุเวลาเริ่มต้นและสิ้นสุด',
                confirmButtonColor: '#8b5cf6'
            });
        }
        return;
    }
    
    // Validate time order
    if (timeStart >= timeEnd) {
        Swal.fire({
            icon: 'warning',
            title: 'เวลาไม่ถูกต้อง',
            text: 'เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด',
            confirmButtonColor: '#8b5cf6'
        });
        return;
    }
    
    const formData = new FormData($('#editBookingForm')[0]);
    
    $.ajax({
        url: 'api/update_booking.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังบันทึก...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ! 🎉',
                    text: 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                    confirmButtonColor: '#8b5cf6',
                    timer: 2000,
                    timerProgressBar: true
                });
                
                $('#editModal').addClass('hidden');
                fetchBookings();
                calendar.refetchEvents();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: response.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        }
    });
}

// ==================== Delete Booking ====================
function confirmDelete(bookingId) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบรายการจองนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteBooking(bookingId);
        }
    });
}

function deleteBooking(bookingId) {
    $.ajax({
        url: 'api/delete_booking.php',
        type: 'POST',
        data: JSON.stringify({ id: bookingId }),
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            Swal.fire({
                title: 'กำลังลบ...',
                text: 'กรุณารอสักครู่',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'ลบเรียบร้อย! 🗑️',
                    text: 'ยกเลิกการจองเรียบร้อยแล้ว',
                    confirmButtonColor: '#8b5cf6',
                    timer: 2000,
                    timerProgressBar: true
                });
                
                fetchBookings();
                calendar.refetchEvents();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สำเร็จ',
                    text: response.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                    confirmButtonColor: '#ef4444'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                confirmButtonColor: '#ef4444'
            });
        }
    });
}
