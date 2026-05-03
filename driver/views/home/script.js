$(document).ready(function() {
    // Initial fetch
    fetchDashboardStats();

    function fetchDashboardStats() {
        $.ajax({
            url: '../teacher/api/car_booking_list.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const originalList = response.list || [];
                    const bookings = originalList.map(item => ({
                        ...item,
                        start: item.start_time || '',
                        end: item.end_time || ''
                    }));
                    
                    const now = new Date();
                    const today = now.toISOString().split('T')[0];
                    
                    // Filter stats
                    const todayJobs = bookings.filter(b => b.start && b.start.startsWith(today)).length;
                    
                    // Tomorrow
                    const tomorrow = new Date(now);
                    tomorrow.setDate(now.getDate() + 1);
                    const tomorrowStr = tomorrow.toISOString().split('T')[0];
                    const tomorrowJobs = bookings.filter(b => b.start && b.start.startsWith(tomorrowStr)).length;

                    // Week
                    const startOfWeek = new Date(now);
                    startOfWeek.setDate(now.getDate() - now.getDay());
                    const endOfWeek = new Date(startOfWeek);
                    endOfWeek.setDate(startOfWeek.getDate() + 6);
                    const weekJobs = bookings.filter(b => {
                        if (!b.start) return false;
                        const bDate = new Date(b.start);
                        return bDate >= startOfWeek && bDate <= endOfWeek;
                    }).length;

                    // Month
                    const monthJobs = bookings.filter(b => {
                        if (!b.start) return false;
                        const bDate = new Date(b.start);
                        return bDate.getMonth() === now.getMonth() && bDate.getFullYear() === now.getFullYear();
                    }).length;

                    // Update UI
                    $('#todayJobsCount').text(todayJobs);
                    $('#tomorrowJobsCount').text(tomorrowJobs);
                    $('#weekJobsCount').text(weekJobs);
                    $('#monthJobsCount').text(monthJobs);

                    renderUpcomingJobs(bookings);
                }
            },
            error: function() {
                $('#upcomingJobsList').html('<div class="py-10 text-center text-red-500">❌ ไม่สามารถโหลดข้อมูลได้</div>');
            }
        });
    }

    function renderUpcomingJobs(bookings) {
        const container = $('#upcomingJobsList');
        container.empty();

        // Sort by start date (ascending) and filter only future/current approved/pending jobs
        const upcoming = bookings
            .filter(b => new Date(b.start) >= new Date().setHours(0,0,0,0))
            .sort((a, b) => new Date(a.start) - new Date(b.start))
            .slice(0, 5);

        if (upcoming.length === 0) {
            container.append(`
                <div class="py-10 text-center text-gray-400">
                    <i class="fas fa-calendar-check text-4xl mb-3 block opacity-20"></i>
                    ไม่มีง่านที่กำลังจะมาถึง
                </div>
            `);
            return;
        }

        upcoming.forEach(job => {
            const startDate = new Date(job.start);
            const dateStr = startDate.toLocaleDateString('th-TH', { day: '2-digit', month: 'short' });
            const timeStr = startDate.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' });
            
            const statusClass = job.status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 
                               (job.status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700');
            const statusText = job.status === 'approved' ? 'อนุมัติแล้ว' : 
                              (job.status === 'pending' ? 'รออนุมัติ' : job.status);

            const dateParts = dateStr.split(' ');
            const dayPart = dateParts[0] || '';
            const monthPart = dateParts[1] || '';

            container.append(`
                <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex flex-col items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <span class="text-xs font-bold leading-tight uppercase opacity-80">${monthPart}</span>
                        <span class="text-xl font-black">${dayPart}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-black text-emerald-600">${timeStr} น.</span>
                            <span class="px-2 py-0.5 ${statusClass} rounded-full text-[10px] font-bold uppercase">${statusText}</span>
                        </div>
                        <h4 class="font-bold text-gray-800 dark:text-white truncate uppercase">${job.destination}</h4>
                        <div class="flex items-center gap-4 mt-1">
                            <p class="text-[10px] text-gray-500 truncate italic"><i class="fas fa-car mr-1"></i> ${job.car_model || job.car_name}</p>
                            ${job.driver_id ? `<p class="text-[10px] text-blue-600 font-bold"><i class="fas fa-user-tie mr-1"></i> ${job.driver_name || job.driver_id}</p>` : ''}
                        </div>
                    </div>
                    <button onclick="location.href='car_booking.php'" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            `);
        });
    }
});
