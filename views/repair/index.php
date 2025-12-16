<!-- Repair Report Public View Page Content -->
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 p-8 md:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -ml-36 -mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative flex flex-col lg:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                    <div class="relative w-32 h-32 md:w-40 md:h-40 flex items-center justify-center bg-white/20 backdrop-blur rounded-full">
                        <span class="text-6xl md:text-7xl">🧰</span>
                    </div>
                </div>
            </div>
            <div class="text-center lg:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    ติดตามสถานะ
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3">
                    แจ้งซ่อม
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-6">
                    ติดตามสถานะการแจ้งซ่อมอาคารสถานที่และอุปกรณ์
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-5 border-l-4 border-orange-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    📋
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statTotal">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">แจ้งซ่อมทั้งหมด</p>
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">รอดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-blue-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    🔧
                </div>
                <div>
                    <p class="text-2xl font-bold text-blue-600" id="statInProgress">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">กำลังดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-green-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    ✅
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600" id="statCompleted">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">เสร็จสิ้น</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-2xl">🔍</span> กรองรายการแจ้งซ่อม
            </h2>
            <div class="flex flex-col sm:flex-row gap-4">
                <select id="filterStatus" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent cursor-pointer min-w-[180px]">
                    <option value="">📋 ทุกสถานะ</option>
                    <option value="0">⏳ รอดำเนินการ</option>
                    <option value="1">🔧 กำลังดำเนินการ</option>
                    <option value="2">✅ เสร็จสิ้น</option>
                </select>
                <select id="filterMonth" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent cursor-pointer">
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
                <select id="filterYear" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent cursor-pointer">
                </select>
            </div>
        </div>
    </div>

    <!-- Repair List -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-orange-500 to-red-500 rounded-xl text-white text-xl">
                    📋
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">รายการแจ้งซ่อม</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400" id="repairResultText">กำลังโหลด...</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-12 h-12 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="mt-4 text-gray-500 dark:text-gray-400">กำลังโหลดรายการแจ้งซ่อม...</p>
            </div>

            <div id="emptyRepair" class="hidden text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 dark:text-gray-400">ไม่มีรายการแจ้งซ่อมในเดือนนี้</p>
            </div>
            
            <div id="repairList" class="hidden space-y-4">
                <!-- Repair items will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Repair Detail Modal -->
<div id="repairModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">รายละเอียดการแจ้งซ่อม</h3>
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
let allRepairs = [];

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

const categoryIcons = {
    'อาคารสถานที่': '🏢',
    'โสตทัศนูปกรณ์': '📺',
    'ระบบไฟฟ้า': '⚡'
};

$(document).ready(function() {
    initFilters();
    loadData();
    
    $('#filterStatus, #filterMonth, #filterYear').on('change', function() {
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
    const status = $('#filterStatus').val();
    let url = `api/public_repair.php?month=${currentMonth}&year=${currentYear}`;
    if (status !== '') url += `&status=${status}`;
    
    $('#loading').removeClass('hidden');
    $('#repairList').addClass('hidden');
    $('#emptyRepair').addClass('hidden');
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            if (response.success) {
                allRepairs = response.repairs;
                updateStats(response.stats);
                renderRepairList();
            }
        },
        error: function() {
            $('#loading').addClass('hidden');
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
        }
    });
}

function updateStats(stats) {
    $('#statTotal').text(stats.total.toLocaleString());
    $('#statPending').text(stats.pending.toLocaleString());
    $('#statInProgress').text(stats.in_progress.toLocaleString());
    $('#statCompleted').text(stats.completed.toLocaleString());
}

function getStatusBgClass(status) {
    const s = parseInt(status);
    if (s === 0) return 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400';
    if (s === 1) return 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400';
    if (s === 2) return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400';
    return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400';
}

function getStatusIcon(status) {
    const s = parseInt(status);
    if (s === 0) return '⏳';
    if (s === 1) return '🔧';
    if (s === 2) return '✅';
    return '❓';
}

function renderRepairList() {
    if (allRepairs.length === 0) {
        $('#repairList').addClass('hidden');
        $('#emptyRepair').removeClass('hidden');
        $('#repairResultText').text('ไม่มีรายการ');
        return;
    }
    
    $('#emptyRepair').addClass('hidden');
    $('#repairResultText').text(`พบ ${allRepairs.length} รายการ`);
    
    let html = '';
    allRepairs.forEach(r => {
        const date = formatThaiDate(r.AddDate);
        const categories = [...new Set(r.damages_summary.map(d => d.category))];
        
        html += `
        <div onclick="showRepairDetail(${r.id})" class="p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/50 cursor-pointer transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-shrink-0 w-16 h-16 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-xl text-3xl">
                    ${getStatusIcon(r.status)}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-900 dark:text-white">${escapeHtml(r.AddLocation || 'ไม่ระบุสถานที่')}</h4>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium ${getStatusBgClass(r.status)}">${r.status_text}</span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                        ${categories.map(c => `<span class="mr-2">${categoryIcons[c] || '📋'} ${c}</span>`).join('')}
                    </p>
                    <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                        <span><i class="far fa-calendar-alt mr-1"></i>${date}</span>
                        <span><i class="fas fa-tools mr-1"></i>${r.total_items} รายการ</span>
                        <span><i class="far fa-user mr-1"></i>${escapeHtml(r.teacher_name_masked || '-')}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </div>
        </div>
        `;
    });
    
    $('#repairList').html(html).removeClass('hidden');
}

function showRepairDetail(id) {
    const repair = allRepairs.find(r => r.id == id);
    if (!repair) return;
    
    const date = formatThaiDate(repair.AddDate);
    
    // Group damages by category
    const groupedDamages = {};
    repair.damages_summary.forEach(d => {
        if (!groupedDamages[d.category]) groupedDamages[d.category] = [];
        groupedDamages[d.category].push(d);
    });
    
    let damagesHtml = '';
    for (const [category, items] of Object.entries(groupedDamages)) {
        damagesHtml += `
            <div class="mb-4">
                <h5 class="font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <span>${categoryIcons[category] || '📋'}</span> ${category}
                </h5>
                <div class="space-y-2 pl-6">
                    ${items.map(item => `
                        <div class="p-2 bg-white dark:bg-slate-800 rounded-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-900 dark:text-white">${escapeHtml(item.name)}</span>
                                <span class="text-sm text-gray-500">${item.count} จุด</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${escapeHtml(item.damage)}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 flex items-center justify-center bg-orange-100 dark:bg-orange-900/30 rounded-xl text-4xl">
                    ${getStatusIcon(repair.status)}
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">${escapeHtml(repair.AddLocation || 'ไม่ระบุสถานที่')}</h4>
                    <span class="px-3 py-1 rounded-full text-sm font-medium ${getStatusBgClass(repair.status)}">${repair.status_text}</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">วันที่แจ้ง</p>
                    <p class="font-medium text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ผู้แจ้ง</p>
                    <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(repair.teacher_name_masked || '-')}</p>
                </div>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">รายการที่ต้องซ่อม (${repair.total_items} รายการ)</p>
                ${damagesHtml || '<p class="text-gray-500">ไม่มีรายการ</p>'}
            </div>
        </div>
    `;
    
    $('#modalContent').html(html);
    $('#repairModal').removeClass('hidden');
}

function closeModal() {
    $('#repairModal').addClass('hidden');
}

function formatThaiDate(dateStr) {
    if (!dateStr) return '-';
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
$('#repairModal').on('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
