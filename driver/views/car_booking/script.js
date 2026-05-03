$(document).ready(function() {
    let allBookings = [];
    let currentFilter = 'all';
    let calendar = null;

    // Initialize
    fetchBookings();

    // Event Listeners
    $('#showTableBtn').on('click', function() {
        $(this).addClass('active');
        $('#showCalendarBtn').removeClass('active');
        $('#tableView').removeClass('hidden');
        $('#calendarView').addClass('hidden');
    });

    $('#showCalendarBtn').on('click', function() {
        $(this).addClass('active');
        $('#showTableBtn').removeClass('active');
        $('#tableView').addClass('hidden');
        $('#calendarView').removeClass('hidden');
        if (!calendar) {
            initCalendar();
        } else {
            calendar.render();
        }
    });

    $('#refreshList').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        fetchBookings();
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });

    $('.filter-btn').on('click', function() {
        $('.filter-btn').removeClass('active bg-emerald-500 bg-blue-500 text-white shadow-lg shadow-emerald-500/30 shadow-blue-500/30');
        $('.filter-btn').addClass('bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300');
        
        const filter = $(this).data('filter');
        if (filter === 'myjobs') {
            $(this).addClass('active bg-blue-500 text-white shadow-lg shadow-blue-500/30');
        } else {
            $(this).addClass('active bg-emerald-500 text-white shadow-lg shadow-emerald-500/30');
        }
        $(this).removeClass('bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300');
        
        currentFilter = filter;
        applyFilters();
    });

    $('#customRangeBtn').on('click', function() {
        currentFilter = 'custom';
        $('.filter-btn').removeClass('active bg-emerald-500 bg-blue-500 text-white shadow-lg');
        applyFilters();
    });

    // Functions
    function fetchBookings() {
        $.ajax({
            url: '../teacher/api/car_booking_list.php', 
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mapping fields correctly
                    const originalList = response.list || [];
                    allBookings = originalList.map(item => ({
                        ...item,
                        id: item.id,
                        title: item.destination,
                        start: item.start_time, // Fix: start_time column
                        end: item.end_time,     // Fix: end_time column
                        color: getCarColor(item.car_id),
                        status_text: getStatusText(item.status),
                        status_class: getStatusClass(item.status)
                    }));
                    applyFilters();
                } else {
                    Swal.fire('Error', 'ไม่สามารถโหลดข้อมูลได้: ' + (response.message || 'Unknown error'), 'error');
                }
            },
            error: function(xhr) {
                console.error(xhr);
                Swal.fire('Error', 'เกิดข้อผิดพลาดในการเชื่อมต่อ API', 'error');
            }
        });
    }

    function applyFilters() {
        let filtered = allBookings;
        const now = new Date();
        const startOfToday = new Date(now.setHours(0,0,0,0));
        const endOfToday = new Date(now.setHours(23,59,59,999));

        if (currentFilter === 'today') {
            filtered = allBookings.filter(b => {
                const bDate = new Date(b.start);
                return bDate >= startOfToday && bDate <= endOfToday;
            });
        } else if (currentFilter === 'tomorrow') {
            const startOfTomorrow = new Date(startOfToday);
            startOfTomorrow.setDate(startOfToday.getDate() + 1);
            const endOfTomorrow = new Date(endOfToday);
            endOfTomorrow.setDate(endOfToday.getDate() + 1);
            filtered = allBookings.filter(b => {
                const bDate = new Date(b.start);
                return bDate >= startOfTomorrow && bDate <= endOfTomorrow;
            });
        } else if (currentFilter === 'week') {
            const startOfWeek = new Date(startOfToday);
            startOfWeek.setDate(startOfToday.getDate() - startOfToday.getDay());
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            endOfWeek.setHours(23, 59, 59, 999);
            filtered = allBookings.filter(b => {
                const bDate = new Date(b.start);
                return bDate >= startOfWeek && bDate <= endOfWeek;
            });
        } else if (currentFilter === 'month') {
            filtered = allBookings.filter(b => {
                const bDate = new Date(b.start);
                return bDate.getMonth() === startOfToday.getMonth() && bDate.getFullYear() === startOfToday.getFullYear();
            });
        } else if (currentFilter === 'myjobs') {
            // Filter by current driver ID or if they are mentioned by name (backup)
            filtered = allBookings.filter(b => {
                const idMatch = String(b.driver_id) === String(currentUserTeachId);
                const nameMatch = (b.notes || '').includes(currentUserFullname) || (b.driver_name || '').includes(currentUserFullname);
                return idMatch || nameMatch;
            });
        } else if (currentFilter === 'custom') {
            const start = $('#startDate').val() ? new Date($('#startDate').val()) : null;
            const end = $('#endDate').val() ? new Date($('#endDate').val()) : null;
            if (start && end) {
                start.setHours(0,0,0,0);
                end.setHours(23, 59, 59, 999);
                filtered = allBookings.filter(b => {
                    const bDate = new Date(b.start);
                    return bDate >= start && bDate <= end;
                });
            }
        }

        renderTable(filtered);
        renderStats(filtered);
        if (calendar) {
            calendar.removeAllEvents();
            calendar.addEventSource(filtered);
        }
    }

    function renderStats(filtered) {
        const statsContainer = $('#statsContainer');
        statsContainer.empty();
        
        const count = filtered.length;
        const approvedCount = filtered.filter(b => b.status === 'approved').length;
        const pendingCount = filtered.filter(b => b.status === 'pending').length;
        
        statsContainer.append(`
            <div class="glass rounded-2xl p-5 border-l-4 border-emerald-500 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">งานทั้งหมดในรายการ</p>
                        <p class="text-3xl font-black text-emerald-600">${count}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600">
                        <i class="fas fa-tasks"></i>
                    </div>
                </div>
            </div>
            <div class="glass rounded-2xl p-5 border-l-4 border-blue-500 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">อนุมัติแล้ว</p>
                        <p class="text-3xl font-black text-blue-600">${approvedCount}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
            </div>
            <div class="glass rounded-2xl p-5 border-l-4 border-amber-500 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">รอพิจารณา</p>
                        <p class="text-3xl font-black text-amber-600">${pendingCount}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center text-amber-600">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        `);
    }

    function renderTable(data) {
        const tbody = $('#bookingTableBody');
        const cardList = $('#bookingCardList');
        tbody.empty();
        cardList.empty();

        if (data.length === 0) {
            tbody.append('<tr><td colspan="7" class="py-20 text-center text-gray-400 text-lg">--- ไม่พบรายการจองในช่วงที่เลือก ---</td></tr>');
            cardList.append('<div class="glass rounded-2xl p-20 text-center text-gray-400 uppercase font-bold tracking-widest">--- ว่างงาน ---</div>');
            return;
        }

        data.forEach(item => {
            const startDate = new Date(item.start);
            const endDate = new Date(item.end);
            
            const dateStr = startDate.toLocaleDateString('th-TH', { day: '2-digit', month: 'short', year: 'numeric' });
            const timeRange = `${startDate.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' })} - ${endDate.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' })}`;

            // Desktop Row
            tbody.append(`
                <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                    <td class="py-4 px-6">
                        <div class="font-bold text-gray-800 dark:text-gray-200">${dateStr}</div>
                        <div class="text-xs text-emerald-600 font-semibold">${timeRange}</div>
                    </td>
                    <td class="py-4 px-6 font-medium text-gray-700 dark:text-gray-300">
                        <span class="inline-flex items-center gap-2">
                             <span class="w-2 h-2 rounded-full" style="background-color: ${item.color}"></span>
                             ${item.car_model || item.car_name || '-'}
                             <div class="text-[10px] text-gray-400">${item.license_plate || ''}</div>
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <div class="font-bold text-blue-600 dark:text-blue-400">${item.teacher_name}</div>
                        <div class="text-xs text-gray-500 truncate max-w-xs">${item.purpose}</div>
                    </td>
                    <td class="py-4 px-6 font-bold text-gray-800 dark:text-white">
                        <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> ${item.destination}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-xs font-black">
                            ${item.passenger_count} คน
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        ${item.driver_id ? `
                            <div class="flex items-center gap-2 ${String(item.driver_id) === String(currentUserTeachId) ? 'text-blue-600 font-bold' : 'text-gray-500'}">
                                <i class="fas fa-user-tie"></i>
                                <span class="text-xs">${item.driver_name || item.driver_id}</span>
                                ${String(item.driver_id) === String(currentUserTeachId) ? '<span class="ml-1 px-1.5 py-0.5 bg-blue-100 text-blue-700 text-[8px] rounded uppercase">Me</span>' : ''}
                            </div>
                        ` : '<span class="text-gray-300 italic text-xs">ยังไม่ระบุ</span>'}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-3 py-1 ${item.status_class} rounded-full text-xs font-bold">
                            ${item.status_text}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <button onclick="viewDetail('${item.id}')" class="w-10 h-10 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/30 transition-all">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `);

            // Mobile Card
            cardList.append(`
                <div class="glass rounded-2xl p-5 border-l-4 border-emerald-500 shadow-sm card-hover">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex flex-col">
                            <span class="text-lg font-black text-gray-800 dark:text-white">${dateStr}</span>
                            <span class="text-sm font-bold text-emerald-600">${timeRange}</span>
                        </div>
                        <span class="px-3 py-1 ${item.status_class} rounded-full text-[10px] font-bold">
                            ${item.status_text}
                        </span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-emerald-500">
                                <i class="fas fa-car"></i>
                            </div>
                            <span class="font-bold text-gray-700 dark:text-gray-300">${item.car_model || item.car_name}</span>
                            <span class="text-xs text-gray-400">${item.license_plate || ''}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-blue-500">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="font-black text-gray-800 dark:text-white">${item.destination}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-gray-500 text-xs">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="text-sm font-medium">${item.teacher_name} (${item.passenger_count} คน)</span>
                        </div>
                        <div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-slate-700/50 rounded-xl border border-dashed border-gray-200 dark:border-gray-600">
                             <div class="w-8 h-8 bg-white dark:bg-slate-800 rounded-lg flex items-center justify-center text-blue-500 shadow-sm">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <span class="text-[9px] text-gray-400 block uppercase font-bold">คนขับรถ</span>
                                <span class="text-sm ${String(item.driver_id) === String(currentUserTeachId) ? 'text-blue-600 font-bold' : 'text-gray-600 dark:text-gray-300'}">
                                    ${item.driver_name || (item.driver_id ? 'รหัส: ' + item.driver_id : '--- ยังไม่ระบุ ---')}
                                    ${String(item.driver_id) === String(currentUserTeachId) ? ' <span class="text-[10px] bg-blue-500 text-white px-1.5 py-0.5 rounded ml-1">งานของคุณ</span>' : ''}
                                </span>
                            </div>
                        </div>
                    </div>
                    <button onclick="viewDetail('${item.id}')" class="w-full mt-4 py-3 bg-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/20">
                        ดูรายละเอียดครบชุด
                    </button>
                </div>
            `);
        });
    }

    function initCalendar() {
        const calendarEl = document.getElementById('carBookingCalendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            locale: 'th',
            themeSystem: 'standard',
            events: allBookings,
            eventClick: function(info) {
                viewDetail(info.event.id);
            }
        });
        calendar.render();
    }

    function getStatusText(status) {
        const map = {
            'pending': 'รออนุมัติ',
            'approved': 'อนุมัติแล้ว',
            'rejected': 'ไม่อนุมัติ',
            'completed': 'เสร็จสิ้น'
        };
        return map[status] || status;
    }

    function getStatusClass(status) {
        const map = {
            'pending': 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
            'approved': 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            'rejected': 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
            'completed': 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400'
        };
        return map[status] || 'bg-gray-100 text-gray-700';
    }

    function getCarColor(carId) {
        const colors = ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
        return colors[carId % colors.length];
    }

    // Exported to window so it can be called from onclick in HTML
    window.viewDetail = function(id) {
        const item = allBookings.find(b => b.id == id);
        if (!item) return;

        $('#detailBookingIdLabel').text(`Booking ID: #${item.id}`);
        $('#detailStart').text(new Date(item.start).toLocaleString('th-TH'));
        $('#detailEnd').text(new Date(item.end).toLocaleString('th-TH'));
        $('#detailCar').text(`${item.car_model || item.car_name} (${item.license_plate || ''})`);
        $('#detailTeacher').text(item.teacher_name);
        $('#detailDriver span').text(item.driver_name || (item.driver_id ? 'รหัส: ' + item.driver_id : 'ยังไม่ระบุคนขับ'));
        if (String(item.driver_id) === String(currentUserTeachId)) {
            $('#detailDriver').addClass('text-emerald-600 px-2 py-1 bg-emerald-100/50 rounded-lg inline-flex');
            $('#detailDriver span').append(' (งานของคุณ)');
        } else {
            $('#detailDriver').removeClass('text-emerald-600 px-2 py-1 bg-emerald-100/50 rounded-lg inline-flex');
        }
        $('#detailDestination').text(item.destination);
        $('#detailPurpose').text(item.purpose);
        $('#detailTotalPassengers').text(item.passenger_count);
        
        // Status Badge
        $('#detailStatusBadge').html(`<span class="px-6 py-2 ${item.status_class} rounded-full font-black uppercase text-sm">${item.status_text}</span>`);

        // Passengers
        const passList = $('#detailPassengersList');
        passList.empty();
        if (item.passengers_detail) {
            try {
                const passengers = JSON.parse(item.passengers_detail);
                if (Array.isArray(passengers)) {
                    passengers.forEach(p => {
                        passList.append(`<span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm">${p.trim()}</span>`);
                    });
                } else {
                    passList.append(`<span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm">${item.passengers_detail}</span>`);
                }
            } catch(e) {
                passList.append(`<span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 rounded-lg text-sm">${item.passengers_detail}</span>`);
            }
        } else {
            passList.append(`<span class="text-gray-400 italic">ไม่ระบุรายชื่อ</span>`);
        }

        // Notes
        if (item.notes && item.notes.trim()) {
            $('#detailNotes').text(item.notes);
            $('#detailNotesSection').removeClass('hidden');
        } else {
            $('#detailNotesSection').addClass('hidden');
        }

        $('#detailBookingModal').removeClass('hidden');
        setTimeout(() => {
            $('#detailModalContent').addClass('modal-anim-in');
            $('#detailModalContent').css('opacity', '1');
            $('#detailModalContent').css('transform', 'scale(1)');
        }, 10);
    };

    window.closeDetailModal = function() {
        $('#detailModalContent').removeClass('modal-anim-in');
        $('#detailModalContent').css('opacity', '0');
        $('#detailModalContent').css('transform', 'scale(0.95)');
        setTimeout(() => {
            $('#detailBookingModal').addClass('hidden');
        }, 300);
    };
});
