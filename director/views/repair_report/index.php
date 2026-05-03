<!-- Repair Report Content -->
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🔧</span> รายงานการแจ้งซ่อม
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">สรุปข้อมูลและติดตามสถานะงานแจ้งซ่อม</p>
        </div>
        <div class="flex gap-3">
            <div class="glass px-4 py-2 rounded-xl flex items-center gap-2">
                <span class="text-2xl">📊</span>
                <div>
                    <p class="text-xs text-gray-500">รายการทั้งหมด</p>
                    <p id="totalCount" class="text-lg font-bold text-gray-800 dark:text-white">0</p>
                </div>
            </div>
            <button id="refreshList" class="px-5 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-medium hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> รีเฟรช
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-4 border-l-4 border-yellow-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">รอดำเนินการ</p>
                    <p id="pendingCount" class="text-2xl font-bold text-yellow-600">0</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">⏳</span>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-orange-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">กำลังดำเนินการ</p>
                    <p id="progressCount" class="text-2xl font-bold text-orange-600">0</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">🔄</span>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-green-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">เสร็จสิ้น</p>
                    <p id="doneCount" class="text-2xl font-bold text-green-600">0</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-fuchsia-400">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">อัตราสำเร็จ</p>
                    <p id="successRate" class="text-2xl font-bold text-fuchsia-600">0%</p>
                </div>
                <div class="w-12 h-12 bg-fuchsia-100 dark:bg-fuchsia-900/30 rounded-xl flex items-center justify-center">
                    <span class="text-2xl">📈</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass rounded-2xl p-4">
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm font-medium text-gray-600 dark:text-gray-400"><i class="fas fa-filter mr-2"></i>กรองตามสถานะ:</span>
            <div class="flex flex-wrap gap-2">
                <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm bg-gradient-to-r from-slate-100 to-gray-100 dark:from-slate-700 dark:to-gray-700 text-gray-800 dark:text-white hover:shadow-md transition-all ring-2 ring-fuchsia-500" data-status="">
                    📋 ทั้งหมด
                </button>
                <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 text-yellow-800 dark:text-yellow-300 hover:shadow-md transition-all" data-status="0">
                    ⏳ รอดำเนินการ
                </button>
                <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 text-orange-800 dark:text-orange-300 hover:shadow-md transition-all" data-status="1">
                    🔄 กำลังดำเนินการ
                </button>
                <button class="status-filter-btn px-4 py-2 rounded-xl font-medium text-sm bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 text-green-800 dark:text-green-300 hover:shadow-md transition-all" data-status="2">
                    ✅ เสร็จสิ้น
                </button>
            </div>
        </div>
    </div>

    <!-- Repair List -->
    <div class="glass rounded-2xl p-6">
        <div id="repairList" class="space-y-4 max-h-[650px] overflow-y-auto pr-2 custom-scrollbar">
            <div class="text-center py-12">
                <div class="loader mx-auto mb-4"></div>
                <p class="text-gray-400">กำลังโหลดข้อมูล...</p>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDetailModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="glass rounded-3xl p-6 m-4 shadow-2xl">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <span class="text-2xl">🔍</span> รายละเอียดการแจ้งซ่อม
                </h3>
                <button onclick="closeDetailModal()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            <div id="detailContent"></div>
        </div>
    </div>
</div>

<style>
.loader { 
    width: 50px; 
    height: 50px; 
    border: 4px solid #e5e7eb; 
    border-top-color: #d946ef; 
    border-radius: 50%; 
    animation: spin 1s linear infinite; 
}
@keyframes spin { to { transform: rotate(360deg); } }

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, #d946ef, #f97316);
    border-radius: 10px;
}

.repair-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.repair-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 40px -10px rgba(0,0,0,0.15);
}

.damage-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}
</style>

<script>
let allRepairs = [];
let currentFilter = '';

$(document).ready(function() {
    fetchRepairs();
    
    $('.status-filter-btn').on('click', function() {
        $('.status-filter-btn').removeClass('ring-2 ring-fuchsia-500 shadow-lg');
        $(this).addClass('ring-2 ring-fuchsia-500 shadow-lg');
        currentFilter = $(this).data('status');
        renderRepairs();
    });
    
    $('#refreshList').on('click', function() {
        $(this).find('i').addClass('animate-spin');
        fetchRepairs();
        setTimeout(() => $(this).find('i').removeClass('animate-spin'), 1000);
    });
});

function fetchRepairs() {
    $('#repairList').html('<div class="text-center py-12"><div class="loader mx-auto mb-4"></div><p class="text-gray-400">กำลังโหลดข้อมูล...</p></div>');
    
    $.get('api/repair_report_list.php', function(response) {
        allRepairs = response.list || [];
        updateStats();
        renderRepairs();
    }).fail(function() {
        $('#repairList').html('<div class="text-center py-12"><div class="text-6xl mb-4">❌</div><p class="text-red-500">ไม่สามารถโหลดข้อมูลได้</p></div>');
    });
}

function updateStats() {
    const pending = allRepairs.filter(r => r.status == 0).length;
    const progress = allRepairs.filter(r => r.status == 1).length;
    const done = allRepairs.filter(r => r.status == 2).length;
    const total = allRepairs.length;
    const rate = total > 0 ? Math.round((done / total) * 100) : 0;
    
    $('#totalCount').text(total);
    $('#pendingCount').text(pending);
    $('#progressCount').text(progress);
    $('#doneCount').text(done);
    $('#successRate').text(rate + '%');
}

function renderRepairs() {
    let repairs = currentFilter === '' ? allRepairs : allRepairs.filter(r => r.status == currentFilter);
    
    if (repairs.length === 0) {
        $('#repairList').html(`
            <div class="text-center py-16">
                <div class="text-7xl mb-4 animate-bounce">📭</div>
                <p class="text-xl text-gray-500 dark:text-gray-400 font-medium">ไม่พบรายการแจ้งซ่อม</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    repairs.forEach((r, index) => {
        // Status config
        let statusConfig = {
            0: { badge: 'bg-gradient-to-r from-yellow-400 to-amber-500', text: 'รอดำเนินการ', icon: '⏳', border: 'border-yellow-400', bg: 'from-yellow-50 to-amber-50 dark:from-yellow-900/10 dark:to-amber-900/10' },
            1: { badge: 'bg-gradient-to-r from-orange-400 to-red-500', text: 'กำลังดำเนินการ', icon: '🔄', border: 'border-orange-400', bg: 'from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10' },
            2: { badge: 'bg-gradient-to-r from-green-400 to-emerald-500', text: 'เสร็จสิ้น', icon: '✅', border: 'border-green-400', bg: 'from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10' }
        };
        let status = statusConfig[r.status] || statusConfig[0];
        
        // รายการอุปกรณ์ที่ชำรุด
        let damageItems = [];
        const damageTypes = [
            { key: 'doorDamage', label: 'ประตู', icon: '🚪', color: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' },
            { key: 'windowDamage', label: 'หน้าต่าง', icon: '🪟', color: 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300' },
            { key: 'tablestDamage', label: 'โต๊ะเรียน', icon: '🪑', color: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300' },
            { key: 'chairstDamage', label: 'เก้าอี้เรียน', icon: '💺', color: 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' },
            { key: 'tabletaDamage', label: 'โต๊ะครู', icon: '🖥️', color: 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300' },
            { key: 'chairtaDamage', label: 'เก้าอี้ครู', icon: '🪑', color: 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300' },
            { key: 'fanDamage', label: 'พัดลม', icon: '🌀', color: 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300' },
            { key: 'lightDamage', label: 'หลอดไฟ', icon: '💡', color: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' },
            { key: 'airDamage', label: 'แอร์', icon: '❄️', color: 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-300' },
            { key: 'tvDamage', label: 'ทีวี', icon: '📺', color: 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300' },
            { key: 'audioDamage', label: 'ลำโพง', icon: '🔊', color: 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300' },
            { key: 'hdmiDamage', label: 'สาย HDMI', icon: '🔌', color: 'bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-300' },
            { key: 'projectorDamage', label: 'โปรเจคเตอร์', icon: '📽️', color: 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-300' },
            { key: 'swDamage', label: 'สวิตช์ไฟ', icon: '🔘', color: 'bg-lime-100 text-lime-700 dark:bg-lime-900/30 dark:text-lime-300' },
            { key: 'swfanDamage', label: 'สวิตช์พัดลม', icon: '🎚️', color: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' },
            { key: 'plugDamage', label: 'ปลั๊กไฟ', icon: '🔌', color: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }
        ];
        
        damageTypes.forEach(type => {
            if (r[type.key] > 0) damageItems.push({ ...type, count: r[type.key] });
        });
        
        if (r.other1Details && r.other1Damage > 0) damageItems.push({ label: r.other1Details, count: r.other1Damage, icon: '🔧', color: 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300' });
        
        let damageHtml = damageItems.length > 0 
            ? damageItems.slice(0, 3).map(d => `<span class="damage-tag ${d.color}">${d.icon} ${d.label} <span class="font-bold">${d.count}</span></span>`).join('') 
            + (damageItems.length > 3 ? `<span class="damage-tag bg-gray-100 text-gray-600">+${damageItems.length - 3}</span>` : '')
            : '<span class="text-gray-400 text-sm">ไม่มีรายการ</span>';
        
        let dateDisplay = r.AddDate ? new Date(r.AddDate).toLocaleDateString('th-TH', { year: 'numeric', month: 'short', day: 'numeric' }) : '-';
        
        html += `
        <div class="repair-card bg-gradient-to-r ${status.bg} rounded-2xl border-l-4 ${status.border} shadow-sm overflow-hidden">
            <div class="p-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1 space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🏫</span>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">${r.AddLocation || 'ไม่ระบุสถานที่'}</h3>
                            <span class="px-3 py-1 ${status.badge} text-white text-[10px] font-bold rounded-full shadow-sm">
                                ${status.icon} ${status.text}
                            </span>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center gap-1"><i class="fas fa-user-edit text-fuchsia-500"></i> ${r.teacher_name || 'ไม่ทราบชื่อ'}</span>
                            <span class="flex items-center gap-1"><i class="fas fa-calendar-alt text-fuchsia-500"></i> ${dateDisplay}</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            ${damageHtml}
                        </div>
                    </div>
                    
                    <div>
                        <button onclick="showDetail(${r.id})" class="w-full lg:w-auto px-6 py-2.5 bg-white dark:bg-slate-700 text-fuchsia-600 dark:text-fuchsia-400 font-bold rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i> รายละเอียด
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
    });
    
    $('#repairList').html(html);
}

function showDetail(id) {
    const repair = allRepairs.find(r => r.id == id);
    if (!repair) return;
    
    const allDamageTypes = [
        { key: 'doorCount', damageKey: 'doorDamage', label: 'ประตู', icon: '🚪' },
        { key: 'windowCount', damageKey: 'windowDamage', label: 'หน้าต่าง', icon: '🪟' },
        { key: 'tablestCount', damageKey: 'tablestDamage', label: 'โต๊ะนักเรียน', icon: '🪑' },
        { key: 'chairstCount', damageKey: 'chairstDamage', label: 'เก้าอี้นักเรียน', icon: '💺' },
        { key: 'tabletaCount', damageKey: 'tabletaDamage', label: 'โต๊ะครู', icon: '🖥️' },
        { key: 'chairtaCount', damageKey: 'chairtaDamage', label: 'เก้าอี้ครู', icon: '🪑' },
        { key: 'fanCount', damageKey: 'fanDamage', label: 'พัดลม', icon: '🌀' },
        { key: 'lightCount', damageKey: 'lightDamage', label: 'หลอดไฟ', icon: '💡' },
        { key: 'airCount', damageKey: 'airDamage', label: 'แอร์', icon: '❄️' },
        { key: 'tvCount', damageKey: 'tvDamage', label: 'ทีวี', icon: '📺' },
        { key: 'audioCount', damageKey: 'audioDamage', label: 'ลำโพง', icon: '🔊' },
        { key: 'hdmiCount', damageKey: 'hdmiDamage', label: 'สาย HDMI', icon: '🔌' },
        { key: 'projectorCount', damageKey: 'projectorDamage', label: 'โปรเจคเตอร์', icon: '📽️' },
        { key: 'swCount', damageKey: 'swDamage', label: 'สวิตช์ไฟ', icon: '🔘' },
        { key: 'swfanCount', damageKey: 'swfanDamage', label: 'สวิตช์พัดลม', icon: '🎚️' },
        { key: 'plugCount', damageKey: 'plugDamage', label: 'ปลั๊กไฟ', icon: '🔌' }
    ];
    
    let detailRows = allDamageTypes.map(type => {
        const total = repair[type.key] || 0;
        const damaged = repair[type.damageKey] || 0;
        if (total > 0 || damaged > 0) {
            return `
                <tr class="border-b border-gray-100 dark:border-gray-700">
                    <td class="py-3 px-4">
                        <span class="text-lg mr-2">${type.icon}</span>
                        ${type.label}
                    </td>
                    <td class="py-3 px-4 text-center font-medium">${total}</td>
                    <td class="py-3 px-4 text-center">
                        ${damaged > 0 ? `<span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300 rounded-full font-bold">${damaged}</span>` : '<span class="text-gray-400">-</span>'}
                    </td>
                </tr>
            `;
        }
        return '';
    }).join('');

    let statusConfig = {
        0: { badge: 'bg-yellow-100 text-yellow-800', text: 'รอดำเนินการ', icon: '⏳' },
        1: { badge: 'bg-orange-100 text-orange-800', text: 'กำลังดำเนินการ', icon: '🔄' },
        2: { badge: 'bg-green-100 text-green-800', text: 'เสร็จสิ้น', icon: '✅' }
    };
    let status = statusConfig[repair.status] || statusConfig[0];
    
    $('#detailContent').html(`
        <div class="space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 p-4 bg-gradient-to-r from-fuchsia-50 to-pink-50 dark:from-fuchsia-900/20 dark:to-pink-900/20 rounded-2xl">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🏫</span>
                    <div>
                        <p class="text-sm text-gray-500">สถานที่</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">${repair.AddLocation || '-'}</p>
                    </div>
                </div>
                <span class="px-4 py-2 ${status.badge} rounded-full font-medium">
                    ${status.icon} ${status.text}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 mb-1">👤 ผู้แจ้ง</p>
                    <p class="font-bold text-gray-800 dark:text-white">${repair.teacher_name || 'ไม่ทราบชื่อ'}</p>
                </div>
                <div class="p-4 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 mb-1">📞 เบอร์โทร</p>
                    <p class="font-bold text-gray-800 dark:text-white">${repair.teacher_phone || '-'}</p>
                </div>
                <div class="p-4 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-xs text-gray-500 mb-1">📅 วันที่แจ้ง</p>
                    <p class="font-bold text-gray-800 dark:text-white">${repair.AddDate || '-'}</p>
                </div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 border-b border-gray-100 dark:border-gray-700">
                    <h4 class="font-bold text-gray-800 dark:text-white">🔧 รายการอุปกรณ์</h4>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">รายการ</th>
                            <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">ทั้งหมด</th>
                            <th class="py-3 px-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">ชำรุด</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        ${detailRows || '<tr><td colspan="3" class="py-8 text-center text-gray-400">ไม่มีรายการ</td></tr>'}
                    </tbody>
                </table>
            </div>
        </div>
    `);
    
    $('#detailModal').removeClass('hidden').addClass('flex');
}

function closeDetailModal() {
    $('#detailModal').removeClass('flex').addClass('hidden');
}

$(document).keydown(function(e) {
    if (e.key === 'Escape') closeDetailModal();
});
</script>
