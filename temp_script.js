
    let calendar;
    let currentFilter = '';
    let currentDateFilter = 'all';
    let allBookings = [];
    let currentTab = 'list';
    let carsData = []; // Store cars data from database
    let driversData = []; // Store drivers data from database

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

    $(document).ready(function () {
        fetchCarsData(); // Load cars first
        fetchDriversData(); // Load drivers
        fetchBookings();
        setupEventHandlers();
    });

    function fetchDriversData() {
        $.ajax({
            url: '../officer/api/driver_list.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    driversData = response.list || [];
                } else {
                    console.warn('Driver API error:', response.message);
                    driversData = [];
                }
            },
            error: function (xhr, status, error) {
                console.error('Failed to load drivers:', error);
                driversData = [];
            }
        });
    }

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
            events: function (fetchInfo, successCallback, failureCallback) {
                try {
                    const events = allBookings.filter(b => b.status != 'rejected' && b.status != 2).map(function (booking) {
                        try {
                            if (!booking.booking_date) return null;

                            let color = getCarColor(booking.car_id);
                            let carName = booking.car_model || 'รถยนต์';

                            // Get base date from booking_date
                            let baseDate = booking.booking_date ? booking.booking_date.split(' ')[0] : null;
                            if (!baseDate) return null;

                            // Helper function to parse datetime or time-only fields
                            function parseDateTimeField(field, fallbackDate, fallbackTime) {
                                if (!field) return { date: fallbackDate, time: fallbackTime };

                                const fieldStr = String(field).trim();

                                // Check if it contains a date (has space and starts with year)
                                if (fieldStr.includes(' ') && /^\d{4}-\d{2}-\d{2}/.test(fieldStr)) {
                                    const parts = fieldStr.split(' ');
                                    const timePart = parts[1] ? parts[1].split(':').slice(0, 2).join(':') : fallbackTime;
                                    return { date: parts[0], time: timePart || fallbackTime };
                                } else {
                                    // It's time-only, use fallback date
                                    const timePart = fieldStr.split(':').slice(0, 2).join(':');
                                    return { date: fallbackDate, time: timePart || fallbackTime };
                                }
                            }

                            // Parse start and end
                            const startInfo = parseDateTimeField(booking.start_time, baseDate, '08:00');
                            const endInfo = parseDateTimeField(booking.end_time, baseDate, '17:00');

                            // Validate dates
                            if (!startInfo.date || !endInfo.date) return null;

                            // Check if multi-day booking (only if both dates are valid)
                            const isMultiDay = startInfo.date !== endInfo.date;

                            // For multi-day events, FullCalendar needs end date to be exclusive
                            let endDateForCalendar = endInfo.date;
                            if (isMultiDay) {
                                try {
                                    const endDateObj = new Date(endInfo.date + 'T00:00:00');
                                    if (!isNaN(endDateObj.getTime())) {
                                        endDateObj.setDate(endDateObj.getDate() + 1);
                                        endDateForCalendar = endDateObj.toISOString().split('T')[0];
                                    }
                                } catch (e) {
                                    // If date parsing fails, keep original endInfo.date
                                    console.warn('Date parsing failed for:', endInfo.date);
                                }
                            }

                            return {
                                id: booking.id,
                                title: `${carName} - ${booking.destination || 'ไม่ระบุ'}`,
                                start: `${startInfo.date}T${startInfo.time}`,
                                end: isMultiDay ? endDateForCalendar : `${endInfo.date}T${endInfo.time}`,
                                allDay: isMultiDay,
                                color: (booking.status == 0 || booking.status == 'pending') ? '#fbbf24' : color,
                                extendedProps: { booking: booking }
                            };
                        } catch (bookingError) {
                            console.warn('Error processing booking:', booking.id, bookingError);
                            return null;
                        }
                    }).filter(e => e !== null);

                    successCallback(events);
                } catch (error) {
                    console.error('Error generating calendar events:', error);
                    failureCallback(error);
                }
            },
            eventClick: function (info) {
                showDetailModal(info.event.extendedProps.booking);
            }
        });
        calendar.render();
    }

    // Fetch cars from database
    function fetchCarsData() {
        $.ajax({
            url: '../officer/api/get_cars.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                carsData = response.cars || [];
                renderCarsTab();
                renderCalendarLegend();
            },
            error: function () {
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
            url: '../officer/api/car_booking_list.php',
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                $('#bookingList').html('<div class="col-span-full text-center py-12"><div class="loader mx-auto mb-4"></div><p class="text-gray-400">กำลังโหลด...</p></div>');
            },
            success: function (response) {
                let bookings = response.list || [];

                // Normalize booking ID to ensure we have a valid ID
                // Priority: booking_id_str (casted) > booking_id > id
                bookings = bookings.map(b => {
                    const rawId = b.booking_id_str || b.booking_id || b.id;
                    b.id = parseInt(rawId); // Convert back to int for consistency
                    return b;
                });

                // Debug logging
                // console.log('Bookings loaded:', bookings.length);
                if (bookings.length > 0) {
                    // console.log('Sample booking:', bookings[0], 'Raw ID source:', bookings[0].booking_id_str);
                }

                allBookings = bookings;
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
            error: function () {
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
        bookings.forEach(function (booking) {
            let statusInfo = getStatusInfo(booking.status);
            let carEmoji = getCarEmoji(booking.car_type);
            let carName = booking.car_model || 'รถยนต์';
            if (booking.license_plate) carName += ` (${booking.license_plate})`;

            // Get car color for identification
            const carColor = getCarColor(booking.car_id);

            // Format date and time in Thai
            const formattedDate = formatThaiDateShort(booking.booking_date);
            const formattedTime = formatThaiTimeRange(booking.start_time, booking.end_time);

            html += `
            <div class="booking-card bg-white dark:bg-slate-800 rounded-2xl border-l-4 shadow-sm hover:shadow-lg overflow-hidden transition-all duration-300" style="border-left-color: ${carColor}">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <span class="text-3xl">${carEmoji}</span>
                                <span class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-white dark:border-slate-800" style="background-color: ${carColor}"></span>
                            </div>
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
                            <span class="truncate">${formattedDate}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="text-emerald-500">⏰</span>
                            <span class="truncate">${formattedTime}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="text-emerald-500">👨‍🏫</span>
                            <span class="truncate" title="${booking.teacher_name}">${booking.teacher_name || 'รหัส: ' + booking.teacher_id}</span>
                        </div>
                        <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-medium">
                            <span class="text-sm">📍</span>
                            <span class="truncate" title="${booking.destination}">${booking.destination || '-'}</span>
                        </div>
                    </div>

                    ${(booking.status == 1 || booking.status == 'approved') ? `
                    <div class="mb-4 p-2 ${booking.driver_id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800' : 'bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-800'} rounded-xl border flex items-center gap-2">
                        <span class="text-lg">${booking.driver_id ? '👷' : '⚠️'}</span>
                        <div class="flex flex-col">
                            <span class="text-[9px] ${booking.driver_id ? 'text-blue-600 dark:text-blue-400' : 'text-amber-600 dark:text-amber-400'} uppercase font-bold tracking-wider">คนขับรถ</span>
                            <span class="text-xs font-bold ${booking.driver_id ? 'text-gray-900 dark:text-white' : 'text-amber-700 dark:text-amber-500'}">
                                ${booking.driver_id ? (booking.driver_name || 'รหัส: ' + booking.driver_id) : '--- ยังไม่ระบุคนขับ ---'}
                            </span>
                        </div>
                    </div>
                    ` : ''}
                    
                    <div class="mb-4 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                        <p class="text-xs text-gray-500 mb-1 font-bold uppercase tracking-widest">วัตถุประสงค์:</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">${booking.purpose || '-'}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        
                        <button onclick="updateStatus(${booking.id}, 2); closeDetailModal();" class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-bold hover:bg-red-600 transition-all hover:scale-105 shadow-md shadow-red-500/20" title="ยกเลิก">
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
        $('.tab-btn').on('click', function () {
            const tab = $(this).data('tab');
            switchTab(tab);
        });

        // Filter buttons
        $('.status-filter-btn').on('click', function () {
            $('.status-filter-btn').removeClass('ring-2 ring-emerald-500 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400');
            $(this).addClass('ring-2 ring-emerald-500 bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400');
            currentFilter = $(this).data('status');
            renderBookings(filterBookings());
        });

        // Date Filter buttons
        $('.date-filter-btn').on('click', function () {
            $('.date-filter-btn').removeClass('active ring-2 ring-blue-500 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400');
            $('.date-filter-btn').addClass('bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300');

            $(this).removeClass('bg-gray-100 text-gray-800 hover:bg-gray-200 dark:bg-slate-700 dark:text-gray-300');
            $(this).addClass('active ring-2 ring-blue-500 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400');

            currentDateFilter = $(this).data('filter');
            renderBookings(filterBookings());
        });

        // Refresh
        $('#refreshData').on('click', function () {
            fetchCarsData();
            fetchBookings();
        });
    }

    function viewBookingDetail(id) {
        const booking = allBookings.find(b => b.id == id);
        if (booking) {
            showDetailModal(booking);
        } else {
            Swal.fire('ผิดพลาด', 'ไม่พบข้อมูลการจอง', 'error');
        }
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
        // Format date and time in Thai
        const formattedDate = formatThaiDateFull(booking.booking_date);
        const formattedTime = formatThaiTimeRange(booking.start_time, booking.end_time);
        const statusInfo = getStatusInfo(booking.status);
        const carEmoji = getCarEmoji(booking.car_type);
        let carName = booking.car_model || 'รถยนต์';
        if (booking.license_plate) carName += ` (${booking.license_plate})`;

        $('#detailTitle').html(`<span class="text-2xl mr-2">${carEmoji}</span>${carName}`);

        // Get detailed date/time info for pickup and return
        const dateTimeInfo = formatThaiDateTimeDetail(booking.start_time, booking.end_time);

        $('#detailContent').html(`
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <span class="text-gray-600 dark:text-gray-400">สถานะ</span>
                ${statusInfo.badge}
            </div>
            
            ${dateTimeInfo.isMultiDay ? `
            <!-- Multi-day booking: Show pickup and return separately -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-1 font-medium">🚗 รับ</p>
                    <p class="font-bold text-gray-900 dark:text-white">${dateTimeInfo.pickup}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                    <p class="text-xs text-blue-600 dark:text-blue-400 mb-1 font-medium">🔙 ส่ง</p>
                    <p class="font-bold text-gray-900 dark:text-white">${dateTimeInfo.return}</p>
                </div>
            </div>
            ` : `
            <!-- Single day booking -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">📅 วันที่</p>
                    <p class="font-medium text-gray-900 dark:text-white">${formattedDate}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">⏰ เวลา</p>
                    <p class="font-medium text-gray-900 dark:text-white">${formattedTime}</p>
                </div>
            </div>
            `}
            
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

            ${(booking.status == 1 || booking.status == 'approved') ? `
            <div class="p-4 ${booking.driver_id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-100 dark:border-blue-800' : 'bg-amber-50 dark:bg-amber-900/10 border-amber-100 dark:border-amber-800'} rounded-xl border">
                <p class="text-xs ${booking.driver_id ? 'text-blue-600 dark:text-blue-400' : 'text-amber-600 dark:text-amber-400'} mb-1 font-bold uppercase tracking-wider">👷 คนขับรถที่มอบหมาย</p>
                <p class="font-bold ${booking.driver_id ? 'text-gray-900 dark:text-white' : 'text-amber-700 dark:text-amber-500'}">${booking.driver_id ? (booking.driver_name || 'รหัส: ' + booking.driver_id) : '--- ยังไม่ระบุคนขับ ---'}</p>
            </div>
            ` : ''}
        </div>
    `);

        
        $('#detailModal').removeClass('hidden');
    }

    function closeDetailModal() {
        $('#detailModal').addClass('hidden');
    }

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

    // Thai Date/Time Formatting Helper Functions
    const thaiMonthsShort = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    const thaiMonthsFull = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    const thaiDaysFull = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'];

    // Format date as "24 ธ.ค. 68"
    function formatThaiDateShort(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return '-';
        const day = date.getDate();
        const month = thaiMonthsShort[date.getMonth() + 1];
        const year = (date.getFullYear() + 543) % 100; // Buddhist year, last 2 digits
        return `${day} ${month} ${year}`;
    }

    // Format date as "วันอังคารที่ 24 ธันวาคม 2568"
    function formatThaiDateFull(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return '-';
        const dayName = thaiDaysFull[date.getDay()];
        const day = date.getDate();
        const month = thaiMonthsFull[date.getMonth() + 1];
        const year = date.getFullYear() + 543; // Buddhist year
        return `วัน${dayName}ที่ ${day} ${month} ${year}`;
    }

    // Format time range - handles both single day and multi-day bookings
    // Returns "08:30-14:00 น." for same day or "24 ธ.ค. 08:30 ถึง 25 ธ.ค. 14:00" for multi-day
    function formatThaiTimeRange(startTime, endTime) {
        const parseDateTime = (dateTimeStr) => {
            if (!dateTimeStr) return null;
            // Handle both "08:30:00", "08:30" and "2025-12-24 08:30:00" formats
            if (dateTimeStr.includes(' ')) {
                const [datePart, timePart] = dateTimeStr.split(' ');
                const timeFormatted = timePart.split(':').slice(0, 2).join(':');
                return { date: datePart, time: timeFormatted };
            } else {
                const timeFormatted = dateTimeStr.split(':').slice(0, 2).join(':');
                return { date: null, time: timeFormatted };
            }
        };

        const start = parseDateTime(startTime);
        const end = parseDateTime(endTime);

        if (!start || !end) {
            return `${start?.time || '08:00'}-${end?.time || '17:00'} น.`;
        }

        // Check if multi-day booking (dates are different)
        if (start.date && end.date && start.date !== end.date) {
            const startDateShort = formatThaiDateShort(start.date);
            const endDateShort = formatThaiDateShort(end.date);
            return `${startDateShort} ${start.time} ถึง ${endDateShort} ${end.time}`;
        }

        // Same day booking
        return `${start.time}-${end.time} น.`;
    }

    // Format datetime for detailed view - shows "รับ: 24 ธ.ค. 68 เวลา 08:30 น." / "ส่ง: 25 ธ.ค. 68 เวลา 14:00 น."
    function formatThaiDateTimeDetail(startTime, endTime) {
        const parseDateTime = (dateTimeStr, fallbackDate) => {
            if (!dateTimeStr) return null;
            if (dateTimeStr.includes(' ')) {
                const [datePart, timePart] = dateTimeStr.split(' ');
                const timeFormatted = timePart.split(':').slice(0, 2).join(':');
                return { date: datePart, time: timeFormatted };
            } else {
                const timeFormatted = dateTimeStr.split(':').slice(0, 2).join(':');
                return { date: fallbackDate, time: timeFormatted };
            }
        };

        const start = parseDateTime(startTime, null);
        const end = parseDateTime(endTime, null);

        if (!start || !end) {
            return {
                pickup: `${start?.time || '08:00'} น.`,
                return: `${end?.time || '17:00'} น.`,
                isMultiDay: false
            };
        }

        const isMultiDay = start.date && end.date && start.date !== end.date;

        if (isMultiDay) {
            return {
                pickup: `${formatThaiDateShort(start.date)} เวลา ${start.time} น.`,
                return: `${formatThaiDateShort(end.date)} เวลา ${end.time} น.`,
                isMultiDay: true
            };
        }

        return {
            pickup: `${start.time} น.`,
            return: `${end.time} น.`,
            isMultiDay: false
        };
    }

    // Trip Outcome Functions
    // Close modals on outside click
    $('#detailModal, #tripOutcomeModal').on('click', function (e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });
