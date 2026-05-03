<!-- Repair Kanban Board - Ultra Premium UI -->
<div class="space-y-6 animate-fade-in px-2">
    <!-- Compact Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/40 dark:bg-slate-800/40 backdrop-blur-md p-4 rounded-[2rem] border border-white/20 shadow-xl shadow-slate-200/20 dark:shadow-black/20">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-fuchsia-600 text-white rounded-2xl shadow-lg shadow-indigo-500/20">
                <i class="fas fa-tasks text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-800 dark:text-white">Management Board</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Repair Tracking
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden lg:flex items-center gap-6 px-6 border-r border-slate-200 dark:border-slate-700 mr-2">
                <div class="text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase">Total Tasks</p>
                    <p class="text-lg font-black text-slate-800 dark:text-white" id="total-tasks">0</p>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase">In Progress</p>
                    <p class="text-lg font-black text-emerald-500" id="total-progress">0</p>
                </div>
            </div>
            <button onclick="window.location.href='repair_report.php'" class="px-5 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:-translate-y-0.5 active:scale-95 transition-all flex items-center gap-2 font-bold text-sm">
                <i class="fas fa-file-invoice"></i>
                <span class="hidden sm:inline">สรุปรายงาน</span>
            </button>
            <button id="refreshList" class="p-3 bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 rounded-xl shadow-sm hover:shadow-md hover:scale-105 transition-all border border-slate-100 dark:border-slate-600">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <!-- Kanban Board Grid -->
    <div class="flex overflow-x-auto pb-8 custom-scrollbar-ultra min-h-[75vh]" style="gap: var(--column-gap, 1rem)">
        
        <?php
        $columns = [
            ['id' => 0, 'name' => 'รายการแจ้งใหม่', 'icon' => 'fa-inbox', 'color' => '#38bdf8', 'bg' => 'sky'],
            ['id' => 1, 'name' => 'รอพิจารณา/งบ', 'icon' => 'fa-clock', 'color' => '#f43f5e', 'bg' => 'rose'],
            ['id' => 2, 'name' => 'กำลังดำเนินการ', 'icon' => 'fa-wrench', 'color' => '#10b981', 'bg' => 'emerald'],
            ['id' => 3, 'name' => 'ตรวจสอบ/ทดสอบ', 'icon' => 'fa-microscope', 'color' => '#6366f1', 'bg' => 'indigo'],
            ['id' => 4, 'name' => 'ดำเนินการเสร็จสิ้น', 'icon' => 'fa-check-circle', 'color' => '#f59e0b', 'bg' => 'amber'],
        ];

        foreach ($columns as $col):
            $bg = $col['bg'];
        ?>
        <div class="kanban-col-ultra group/col" data-status="<?php echo $col['id']; ?>">
            <div class="p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg shadow-<?php echo $bg; ?>-500/20 bg-gradient-to-br from-<?php echo $bg; ?>-400 to-<?php echo $bg; ?>-600">
                        <i class="fas <?php echo $col['icon']; ?>"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-sm text-slate-800 dark:text-white leading-tight"><?php echo $col['name']; ?></h3>
                        <p class="text-[9px] font-black uppercase text-slate-400 tracking-tighter">Phase <?php echo $col['id'] + 1; ?></p>
                    </div>
                </div>
                <span class="w-6 h-6 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-black text-slate-500" id="count-<?php echo $col['id']; ?>">0</span>
            </div>
            
            <div id="column-<?php echo $col['id']; ?>" class="kanban-list-ultra custom-scrollbar-thin" data-status="<?php echo $col['id']; ?>">
                <!-- Cards -->
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- Modal stays same but styled -->
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl relative z-10 border border-white/20">
        <div class="p-8 overflow-y-auto max-h-[90vh] custom-scrollbar-thin" id="detailContent"></div>
    </div>
</div>

<style>
    /* Ultra Modern Styles */
    :root {
        --column-width: 280px;
        --column-gap: 1.25rem;
    }

    .kanban-col-ultra {
        flex: 0 0 var(--column-width);
        background: rgba(255, 255, 255, 0.5);
        border-radius: 2rem;
        display: flex;
        flex-direction: column;
        max-height: calc(100vh - 180px);
        border: 1px solid rgba(226, 232, 240, 0.6);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }
    .dark .kanban-col-ultra {
        background: rgba(30, 41, 59, 0.4);
        border-color: rgba(51, 65, 85, 0.5);
    }

    .kanban-list-ultra {
        flex: 1;
        padding: 1rem;
        overflow-y: auto;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

.card-ultra {
    background: white;
    border-radius: 1.5rem;
    padding: 1.25rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    cursor: grab;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}
.dark .card-ultra {
    background: #1e293b;
    border-color: #334155;
}
.card-ultra:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    border-color: #e2e8f0;
}
.card-ultra:active { cursor: grabbing; }

.card-accent-bar {
    position: absolute;
    left: 0; top: 1.5rem; bottom: 1.5rem;
    width: 4px;
    border-radius: 0 4px 4px 0;
}

.custom-scrollbar-ultra::-webkit-scrollbar { height: 10px; }
.custom-scrollbar-ultra::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar-ultra::-webkit-scrollbar-thumb { 
    background: #e2e8f0; 
    border: 3px solid transparent;
    background-clip: padding-box;
    border-radius: 10px; 
}
.dark .custom-scrollbar-ultra::-webkit-scrollbar-thumb { background: #334155; }

.loader-modern {
    width: 32px; height: 32px;
    border: 3px solid #f3f4f6;
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.sortable-ghost { opacity: 0.2; transform: scale(0.95); }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
let allRepairs = [];
const damageTypes = [
    { key: 'doorDamage', label: 'ประตู', icon: '🚪' },
    { key: 'windowDamage', label: 'หน้าต่าง', icon: '🪟' },
    { key: 'tablestDamage', label: 'โต๊ะเรียน', icon: '🪑' },
    { key: 'chairstDamage', label: 'เก้าอี้เรียน', icon: '💺' },
    { key: 'tabletaDamage', label: 'โต๊ะครู', icon: '🖥️' },
    { key: 'chairtaDamage', label: 'เก้าอี้ครู', icon: '🪑' },
    { key: 'fanDamage', label: 'พัดลม', icon: '🌀' },
    { key: 'lightDamage', label: 'หลอดไฟ', icon: '💡' },
    { key: 'airDamage', label: 'แอร์', icon: '❄️' },
    { key: 'tvDamage', label: 'ทีวี', icon: '📺' },
    { key: 'audioDamage', label: 'ลำโพง', icon: '🔊' },
    { key: 'hdmiDamage', label: 'สาย HDMI', icon: '🔌' },
    { key: 'projectorDamage', label: 'โปรเจคเตอร์', icon: '📽️' },
    { key: 'swDamage', label: 'สวิตช์ไฟ', icon: '🔘' },
    { key: 'swfanDamage', label: 'สวิตช์พัดลม', icon: '🎚️' },
    { key: 'plugDamage', label: 'ปลั๊กไฟ', icon: '🔌' }
];

const statusConfig = {
    0: { color: '#38bdf8', label: 'แจ้งใหม่' },
    1: { color: '#f43f5e', label: 'รอพิจารณา' },
    2: { color: '#10b981', label: 'ดำเนินการ' },
    3: { color: '#6366f1', label: 'ตรวจสอบ' },
    4: { color: '#f59e0b', label: 'เสร็จสิ้น' }
};

$(document).ready(function() {
    fetchRepairs();
    initSortable();
    $('#refreshList').on('click', fetchRepairs);
});

function initSortable() {
    [0, 1, 2, 3, 4].forEach(status => {
        new Sortable(document.getElementById(`column-${status}`), {
            group: 'repairs',
            animation: 400,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                const repairId = evt.item.getAttribute('data-id');
                const newStatus = evt.to.getAttribute('data-status');
                if (newStatus !== evt.from.getAttribute('data-status')) {
                    updateRepairStatus(repairId, newStatus, evt);
                }
            }
        });
    });
}

function fetchRepairs() {
    $('.kanban-list-ultra').html('<div class="flex justify-center py-12"><div class="loader-modern"></div></div>');
    $.get('api/repair_list.php', function(response) {
        allRepairs = response.list || [];
        renderRepairs();
    });
}

function renderRepairs() {
    [0, 1, 2, 3, 4].forEach(s => { $(`#column-${s}`).empty(); $(`#count-${s}`).text('0'); });
    
    let stats = { total: allRepairs.length, inProgress: 0 };
    let columnCounts = { 0:0, 1:0, 2:0, 3:0, 4:0 };

    allRepairs.forEach(repair => {
        const status = parseInt(repair.status);
        columnCounts[status]++;
        if (status === 2) stats.inProgress++;

        const dateObj = new Date(repair.AddDate);
        const dateStr = dateObj.toLocaleDateString('th-TH', { day: 'numeric', month: 'short' });
        
        // Priority check (older than 3 days)
        const isPriority = (new Date() - dateObj) > (3 * 24 * 60 * 60 * 1000) && status < 4;

        let damageTags = '';
        let count = 0;
        damageTypes.forEach(t => {
            if (repair[t.key] > 0 && count < 2) {
                damageTags += `<span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 rounded-lg text-[9px] font-black text-slate-500">${t.icon} ${t.label}</span>`;
                count++;
            }
        });

        const card = `
        <div class="card-ultra group" data-id="${repair.id}">
            <div class="card-accent-bar" style="background: ${statusConfig[status].color}"></div>
            <div class="flex justify-between items-start mb-3 pl-2">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Ticket ID</span>
                    <span class="text-xs font-black text-slate-800 dark:text-white">#${repair.id}</span>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Received</span>
                    <span class="text-xs font-black text-slate-800 dark:text-white">${dateStr}</span>
                </div>
            </div>
            
            <h4 class="font-black text-slate-800 dark:text-white text-sm mb-1 pl-2 line-clamp-1">${repair.AddLocation || 'Unnamed Area'}</h4>
            <div class="flex items-center gap-2 mb-4 pl-2">
                <div class="w-4 h-4 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-[8px] text-indigo-600">
                    <i class="fas fa-user"></i>
                </div>
                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 truncate">${repair.teacher_name || 'Guest'}</span>
            </div>

            <div class="flex flex-wrap gap-1.5 mb-4 pl-2">
                ${damageTags}
                ${isPriority ? '<span class="px-2 py-1 bg-rose-100 text-rose-600 rounded-lg text-[9px] font-black animate-pulse">URGENT</span>' : ''}
            </div>

            <div class="pt-3 border-t border-slate-50 dark:border-slate-800/50 flex justify-between items-center pl-2">
                <button onclick="showDetail(${repair.id})" class="text-[10px] font-black text-indigo-600 hover:text-indigo-700 uppercase tracking-widest">
                    Open Details
                </button>
                <i class="fas fa-ellipsis-v text-slate-300 text-[10px]"></i>
            </div>
        </div>
        `;
        $(`#column-${status}`).append(card);
    });

    // Update Headers
    $('#total-tasks').text(stats.total);
    $('#total-progress').text(stats.inProgress);
    [0, 1, 2, 3, 4].forEach(s => {
        $(`#count-${s}`).text(columnCounts[s]);
        if (columnCounts[s] === 0) {
            $(`#column-${s}`).html('<div class="flex flex-col items-center justify-center py-12 opacity-20"><i class="fas fa-layer-group text-3xl mb-2"></i><p class="text-[10px] font-black uppercase">No Tasks</p></div>');
        }
    });
}

function updateRepairStatus(id, status, evt) {
    $.ajax({
        url: 'api/repair_update.php', type: 'POST', contentType: 'application/json',
        data: JSON.stringify({ id, status }),
        success: function(res) {
            if (res.success) {
                // Update local data
                const repairIndex = allRepairs.findIndex(r => r.id == id);
                if (repairIndex !== -1) {
                    allRepairs[repairIndex].status = status;
                }
                
                renderRepairs();
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Status Synchronized', showConfirmButton: false, timer: 1500 });
            } else { fetchRepairs(); }
        }
    });
}

function showDetail(id) {
    const r = allRepairs.find(x => x.id == id);
    if (!r) return;
    
    let tableRows = damageTypes.map(t => {
        const total = r[t.key.replace('Damage', 'Count')] || 0;
        const damaged = r[t.key] || 0;
        if (total > 0 || damaged > 0) {
            return `<tr class="border-b border-slate-50 dark:border-slate-800/50">
                <td class="py-4 font-bold text-slate-700 dark:text-slate-300 flex items-center gap-3">
                    <span class="text-xl">${t.icon}</span> ${t.label}
                </td>
                <td class="py-4 text-center font-black text-slate-400">${total}</td>
                <td class="py-4 text-center">
                    ${damaged > 0 ? `<span class="px-3 py-1 bg-rose-100 text-rose-600 rounded-full font-black text-xs">${damaged}</span>` : '-'}
                </td>
            </tr>`;
        }
        return '';
    }).join('');

    $('#detailContent').html(`
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white">Request Details</h2>
            <button onclick="closeDetailModal()" class="text-slate-400 hover:text-rose-500 transition-colors"><i class="fas fa-times text-xl"></i></button>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-[2rem] mb-6 flex items-center gap-6">
            <div class="w-16 h-16 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center text-3xl shadow-sm">📍</div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Location</p>
                <p class="text-xl font-black text-slate-800 dark:text-white leading-tight">${r.AddLocation || '-'}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl">
                <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Reporter</p>
                <p class="font-black text-xs text-slate-800 dark:text-white">${r.teacher_name || '-'}</p>
            </div>
            <div class="p-4 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl">
                <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Phone</p>
                <p class="font-black text-xs text-slate-800 dark:text-white">${r.teacher_phone || '-'}</p>
            </div>
            <div class="p-4 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl">
                <p class="text-[9px] font-black text-slate-400 uppercase mb-1">Date</p>
                <p class="font-black text-xs text-slate-800 dark:text-white">${r.AddDate || '-'}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-[2rem] overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr><th class="py-3 px-6 text-[10px] font-black text-slate-400 uppercase">Item</th><th class="py-3 px-6 text-center text-[10px] font-black text-slate-400 uppercase">Total</th><th class="py-3 px-6 text-center text-[10px] font-black text-slate-400 uppercase">Damage</th></tr>
                </thead>
                <tbody class="px-6">${tableRows || '<tr><td colspan="3" class="py-12 text-center text-slate-300 font-black uppercase">No Items Reported</td></tr>'}</tbody>
            </table>
        </div>
    `);
    $('#detailModal').removeClass('hidden');
}

function closeDetailModal() { $('#detailModal').addClass('hidden'); }
$(document).keydown(e => { if (e.key === 'Escape') closeDetailModal(); });
</script>
