<div class="space-y-6 animate-fadeIn">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-history text-fuchsia-600"></i>
                บันทึกการใช้งานระบบ
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">ติดตามกิจกรรมและความเคลื่อนไหวที่เกิดขึ้นภายในระบบ</p>
        </div>
        <div class="flex gap-2">
            <button onclick="loadLogs()" class="w-12 h-12 glass rounded-2xl flex items-center justify-center text-gray-600 hover:text-fuchsia-600 transition-all">
                <i class="fas fa-sync-alt"></i>
            </button>
            <div class="relative group">
                <input type="text" id="logSearch" placeholder="ค้นหาบันทึก..." class="px-6 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-100 dark:border-gray-800 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all w-64 shadow-sm">
                <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="glass rounded-3xl overflow-hidden border border-white/20 shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="logsTable">
                <thead class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">วันเวลา</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">ผู้ใช้งาน</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">กิจกรรม</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">โมดูล</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-800">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
        <div id="loadingState" class="p-12 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-fuchsia-500 border-t-transparent mb-4"></div>
            <p class="text-gray-500">กำลังดึงบันทึกการใช้งาน...</p>
        </div>
        <div id="emptyState" class="hidden p-12 text-center">
            <i class="fas fa-ghost text-5xl text-gray-200 dark:text-gray-700 mb-4"></i>
            <p class="text-gray-500">ไม่พบข้อมูลบันทึกการใช้งาน</p>
        </div>
        
        <!-- Pagination -->
        <div class="p-6 bg-gray-50/30 dark:bg-slate-800/30 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <p class="text-sm text-gray-500" id="logInfo">แสดง 0 รายการ</p>
            <div class="flex gap-2" id="pagination">
                <!-- Pagination buttons -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadLogs();
    
    $('#logSearch').on('keyup', function() {
        // Implement local search or wait for API search
        const value = $(this).val().toLowerCase();
        $("#logsTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function loadLogs(page = 1) {
    $('#loadingState').show();
    $('#emptyState').hide();
    
    $.ajax({
        url: 'api/logs_list.php',
        type: 'GET',
        data: { page: page },
        dataType: 'json',
        success: function(response) {
            $('#loadingState').hide();
            if (response.success && response.list.length > 0) {
                renderLogs(response.list);
                renderPagination(response.total_pages, response.current_page);
                $('#logInfo').text(`แสดง ${response.list.length} รายการ จากทั้งหมด ${response.total_records} รายการ`);
            } else {
                $('#logsTable tbody').empty();
                $('#emptyState').show();
                $('#logInfo').text('แสดง 0 รายการ');
            }
        },
        error: function() {
            $('#loadingState').hide();
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลบันทึกได้', 'error');
        }
    });
}

function renderLogs(logs) {
    const tbody = $('#logsTable tbody');
    tbody.empty();
    
    logs.forEach(log => {
        const typeClass = getLogTypeClass(log.type);
        tbody.append(`
            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                <td class="px-6 py-4 text-sm font-medium text-gray-500">${log.created_at}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-600 flex items-center justify-center text-white text-[10px] font-bold">
                            ${log.user_initials || 'U'}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800 dark:text-white">${log.user_name}</p>
                            <p class="text-[10px] text-gray-400">${log.user_role}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm">${log.action}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 ${typeClass} text-[10px] font-bold rounded-full uppercase tracking-wider">
                        ${log.module}
                    </span>
                </td>
                <td class="px-6 py-4 text-xs font-mono text-gray-400">${log.ip_address || '-'}</td>
            </tr>
        `);
    });
}

function getLogTypeClass(type) {
    switch(type) {
        case 'create': return 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400';
        case 'update': return 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400';
        case 'delete': return 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400';
        case 'login': return 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400';
        default: return 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400';
    }
}

function renderPagination(total, current) {
    const pagin = $('#pagination');
    pagin.empty();
    
    if (total <= 1) return;
    
    // Previous
    pagin.append(`<button onclick="loadLogs(${current - 1})" ${current === 1 ? 'disabled' : ''} class="w-10 h-10 flex items-center justify-center rounded-xl glass hover:text-fuchsia-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all"><i class="fas fa-chevron-left"></i></button>`);
    
    // Pages (Simplified)
    for(let i = 1; i <= total; i++) {
        if (i === current) {
            pagin.append(`<button class="w-10 h-10 flex items-center justify-center rounded-xl bg-fuchsia-600 text-white font-bold shadow-lg shadow-fuchsia-500/30">${i}</button>`);
        } else if (i <= 3 || i > total - 1 || (i >= current - 1 && i <= current + 1)) {
            pagin.append(`<button onclick="loadLogs(${i})" class="w-10 h-10 flex items-center justify-center rounded-xl glass hover:text-fuchsia-600 transition-all">${i}</button>`);
        } else if (i === 4 || i === total - 1) {
            pagin.append(`<span class="w-10 h-10 flex items-center justify-center text-gray-400">...</span>`);
        }
    }
    
    // Next
    pagin.append(`<button onclick="loadLogs(${current + 1})" ${current === total ? 'disabled' : ''} class="w-10 h-10 flex items-center justify-center rounded-xl glass hover:text-fuchsia-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all"><i class="fas fa-chevron-right"></i></button>`);
}
</script>
