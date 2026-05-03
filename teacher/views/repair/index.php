<!-- Repair Request - Teacher View Modernized -->
<div class="space-y-8 animate-fade-in px-2 pb-12">
    <!-- Page Header -->
    <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/40 dark:bg-slate-800/40 backdrop-blur-md p-6 rounded-[2.5rem] border border-white/20 shadow-xl">
        <div class="flex items-center gap-5">
            <div
                class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-amber-400 to-orange-600 text-white rounded-[1.5rem] shadow-lg shadow-amber-500/20 text-2xl">
                <i class="fas fa-tools"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-800 dark:text-white">แจ้งซ่อม</h1>
                <p
                    class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    ระบบแจ้งซ่อมออนไลน์ สำหรับบุคลากร
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button id="refreshList"
                class="p-4 bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 rounded-2xl shadow-sm hover:shadow-md hover:scale-105 transition-all border border-slate-100 dark:border-slate-600">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- New Request Form (Left) -->
        <div
            class="lg:col-span-5 bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 border border-slate-100 dark:border-slate-800 shadow-2xl">
            <div class="flex items-center gap-3 mb-8">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                    <i class="fas fa-edit"></i>
                </div>
                <h2 class="text-xl font-black text-slate-800 dark:text-white">แบบฟอร์มแจ้งซ่อม</h2>
            </div>

            <form id="addReportForm" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">วันที่แจ้ง</label>
                        <input type="date" name="AddDate" id="AddDate"
                            class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none focus:ring-2 focus:ring-amber-500 transition-all font-bold text-slate-700 dark:text-white"
                            required>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 pl-1">สถานที่/ห้อง</label>
                        <input type="text" name="AddLocation" id="AddLocation"
                            class="w-full px-5 py-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none focus:ring-2 focus:ring-amber-500 transition-all font-bold text-slate-700 dark:text-white"
                            placeholder="เช่น ห้อง 431" required>
                    </div>
                </div>

                <div class="space-y-4">
                    <label
                        class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">เลือกรายการที่เสียหาย</label>
                    <div
                        class="bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] p-6 space-y-6 border border-slate-100 dark:border-slate-800">
                        <!-- Categories dynamically loaded -->
                        <div id="topic1" class="space-y-3"></div>
                        <div class="border-t border-slate-200 dark:border-slate-700 my-4"></div>
                        <div id="topic2" class="space-y-3"></div>
                        <div class="border-t border-slate-200 dark:border-slate-700 my-4"></div>
                        <div id="topic3" class="space-y-3"></div>
                    </div>
                </div>

                <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">

                <button type="submit"
                    class="w-full py-5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-black rounded-2xl shadow-xl shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-1 active:scale-95 transition-all flex items-center justify-center gap-3">
                    <i class="fas fa-paper-plane"></i>
                    ส่งข้อมูลแจ้งซ่อม
                </button>
            </form>
        </div>

        <!-- Request History (Right) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="flex items-center gap-3 mb-4 pl-4">
                <div
                    class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <i class="fas fa-history"></i>
                </div>
                <h2 class="text-xl font-black text-slate-800 dark:text-white">สถานะการแจ้งซ่อมของคุณ</h2>
            </div>

            <div id="repairCardList" class="space-y-4 max-h-[800px] overflow-y-auto pr-2 custom-scrollbar-thin">
                <!-- Cards render here -->
                <div class="flex flex-col items-center justify-center py-20 opacity-30">
                    <div class="loader mb-4"></div>
                    <p class="font-black uppercase text-xs tracking-widest">กำลังโหลดข้อมูล...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    <div
        class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl relative z-10 border border-white/20">
        <div class="p-8 overflow-y-auto max-h-[90vh] custom-scrollbar-thin" id="editModalContent">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black text-slate-800 dark:text-white">แก้ไขข้อมูลการแจ้งซ่อม</h2>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-rose-500 transition-colors"><i
                        class="fas fa-times text-xl"></i></button>
            </div>
            <form id="editRepairForm" class="space-y-6">
                <input type="hidden" name="id" id="editId">
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="AddDate" id="editAddDate"
                        class="w-full p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none font-bold" required>
                    <input type="text" name="AddLocation" id="editAddLocation"
                        class="w-full p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border-none font-bold" required>
                </div>
                <div id="edit_topics_container" class="bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] p-6 space-y-6">
                    <div id="edit_topic1"></div>
                    <div id="edit_topic2"></div>
                    <div id="edit_topic3"></div>
                </div>
                <button type="submit"
                    class="w-full py-5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-black rounded-2xl shadow-lg">บันทึกการแก้ไข</button>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeDetailModal()"></div>
    <div class="bg-white dark:bg-slate-900 rounded-[3rem] w-full max-w-2xl max-h-[85vh] overflow-hidden shadow-2xl relative z-10 border border-white/20 transform transition-all scale-100">
        <div class="p-8 md:p-12 overflow-y-auto max-h-[85vh] custom-scrollbar-thin">
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-600 text-2xl">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 dark:text-white">รายละเอียดการแจ้งซ่อม</h2>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest" id="detailTicketId">Ticket #000</p>
                    </div>
                </div>
                <button onclick="closeDetailModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-rose-500 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="space-y-8">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-[1.5rem] border border-slate-100 dark:border-slate-800">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">วันที่แจ้ง</span>
                        <p class="font-bold text-slate-700 dark:text-white" id="detailDate">-</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-[1.5rem] border border-slate-100 dark:border-slate-800">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">สถานที่</span>
                        <p class="font-bold text-slate-700 dark:text-white" id="detailLocation">-</p>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                        รายการที่แจ้งเสียหาย
                    </h3>
                    <div id="detailItemsList" class="space-y-3">
                        <!-- Items will be injected here -->
                    </div>
                </div>

                <!-- Status Progress -->
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest">สถานะปัจจุบัน</h3>
                        <div id="detailStatusBadge" class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">
                            -
                        </div>
                    </div>
                    <div class="flex gap-2" id="detailSteps">
                        <!-- Steps injected here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Teacher Specific Styles */
    .repair-card-teacher {
        background: white;
        border-radius: 2rem;
        padding: 1.5rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
        position: relative;
    }

    .dark .repair-card-teacher {
        background: #1e293b;
        border-color: #334155;
    }

    .repair-card-teacher:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .status-step {
        flex: 1;
        height: 4px;
        border-radius: 10px;
        background: #e2e8f0;
        position: relative;
    }

    .dark .status-step {
        background: #334155;
    }

    .status-step.active {
        background: var(--step-color);
    }

    .checkbox-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        background: transparent;
    }

    .checkbox-modern:hover {
        background: rgba(0, 0, 0, 0.02);
    }

    .dark .checkbox-modern:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .input-number-modern {
        width: 60px;
        padding: 8px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        text-align: center;
        font-weight: bold;
    }

    .dark .input-number-modern {
        background: #0f172a;
        border-color: #334155;
    }

    .custom-scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar-thin::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar-thin::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .dark .custom-scrollbar-thin::-webkit-scrollbar-thumb {
        background: #334155;
    }
</style>

<script>
    const items = [
        { id: 'door', label: 'ประตู', detailsId: 'doorDetails' },
        { id: 'window', label: 'หน้าต่าง', detailsId: 'windowDetails' },
        { id: 'tablest', label: 'โต๊ะนักเรียน', detailsId: 'tablestDetails' },
        { id: 'chairst', label: 'เก้าอี้นักเรียน', detailsId: 'chairstDetails' },
        { id: 'tableta', label: 'โต๊ะครู', detailsId: 'tabletaDetails' },
        { id: 'chairta', label: 'เก้าอี้ครู', detailsId: 'chairtaDetails' }
    ];
    const items2 = [
        { id: 'tv', label: 'โทรทัศน์', detailsId: 'tvDetails' },
        { id: 'audio', label: 'เครื่องเสียง', detailsId: 'audioDetails' },
        { id: 'hdmi', label: 'สาย HDMI', detailsId: 'hdmiDetails' },
        { id: 'projector', label: 'จอโปรเจคเตอร์', detailsId: 'projectorDetails' }
    ];
    const items3 = [
        { id: 'fan', label: 'พัดลม', detailsId: 'fanDetails' },
        { id: 'light', label: 'หลอดไฟ', detailsId: 'lightDetails' },
        { id: 'air', label: 'แอร์', detailsId: 'airDetails' },
        { id: 'plug', label: 'ปลั๊กไฟ', detailsId: 'plugDetails' }
    ];

    const statusMap = {
        0: { label: 'แจ้งใหม่', color: '#38bdf8', icon: 'fa-inbox' },
        1: { label: 'รอพิจารณา', color: '#f43f5e', icon: 'fa-clock' },
        2: { label: 'กำลังดำเนินการ', color: '#10b981', icon: 'fa-wrench' },
        3: { label: 'ตรวจสอบ', color: '#6366f1', icon: 'fa-microscope' },
        4: { label: 'เสร็จสิ้น', color: '#f59e0b', icon: 'fa-check-circle' }
    };

    const teach_id = "<?php echo $teacher_id; ?>";

    $(document).ready(function () {
        // Set default date
        $('#AddDate').val(new Date().toISOString().split('T')[0]);

        // Load Form Elements
        renderFormElements();
        fetchRepairs();

        $('#refreshList').on('click', fetchRepairs);
        $('#addReportForm').on('submit', handleAddSubmit);
    });

    function renderFormElements() {
        const render = (arr, topicId) => {
            const container = $(`#${topicId}`);
            arr.forEach(item => {
                container.append(`
                <div class="space-y-2">
                    <div class="checkbox-modern">
                        <input type="checkbox" id="${item.id}" class="w-5 h-5 rounded-md border-slate-300 text-amber-500 focus:ring-amber-500" onchange="toggleDetails('${item.id}')">
                        <label for="${item.id}" class="flex-1 font-bold text-slate-700 dark:text-slate-300 cursor-pointer text-sm">${item.label}</label>
                    </div>
                    <div id="${item.detailsId}" class="hidden pl-10 pr-4 pb-4 space-y-3 animate-fade-in">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black uppercase text-slate-400">จำนวน</span>
                            <input type="number" name="${item.id}Count" class="input-number-modern" min="0" value="1" disabled>
                            <span class="text-[10px] font-black uppercase text-slate-400">อาการเสีย</span>
                            <input type="text" name="${item.id}Damage" class="flex-1 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-xl p-2 text-xs" placeholder="ระบุอาการ..." disabled>
                        </div>
                    </div>
                </div>
            `);
            });
        };
        render(items, 'topic1');
        render(items2, 'topic2');
        render(items3, 'topic3');
    }

    function toggleDetails(id) {
        const isChecked = $(`#${id}`).is(':checked');
        const $details = $(`#${id}Details`);
        $details.toggleClass('hidden', !isChecked);
        $details.find('input').prop('disabled', !isChecked);
    }

    function fetchRepairs() {
        $('#repairCardList').html('<div class="flex flex-col items-center justify-center py-20 opacity-30"><div class="loader mb-4"></div><p class="font-black">กำลังโหลดข้อมูล...</p></div>');
        $.get('api/fet_report_repair.php?Teach_id=' + encodeURIComponent(teach_id), function (data) {
            const list = Array.isArray(data) ? data : (data.list || []);
            $('#repairCardList').empty();

            if (!list.length) {
                $('#repairCardList').html('<div class="text-center py-20 opacity-20"><i class="fas fa-inbox text-6xl mb-4"></i><p class="font-black uppercase tracking-widest">No Requests Found</p></div>');
                return;
            }

            list.forEach(item => {
                const status = parseInt(item.status || 0);
                const conf = statusMap[status];

                // Generate Steps
                let stepsHtml = '';
                for (let i = 0; i < 5; i++) {
                    const isActive = i <= status;
                    const color = isActive ? statusMap[i].color : '#e2e8f0';
                    stepsHtml += `<div class="status-step ${isActive ? 'active' : ''}" style="--step-color: ${color}"></div>`;
                }

                const card = `
                <div class="repair-card-teacher animate-fade-in group/card cursor-pointer" onclick="viewDetail(${item.id})">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-xl shadow-sm border border-slate-100 dark:border-slate-700 group-hover/card:bg-blue-500 group-hover/card:text-white transition-all">
                                📍
                            </div>
                            <div>
                                <h3 class="font-black text-slate-800 dark:text-white text-md group-hover/card:text-blue-600 transition-colors">${item.AddLocation || '-'}</h3>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Date: ${item.AddDate || '-'}</p>
                            </div>
                        </div>
                        <div class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest flex items-center gap-2" style="background: ${conf.color}15; color: ${conf.color}">
                            <i class="fas ${conf.icon}"></i>
                            ${conf.label}
                        </div>
                    </div>

                    <div class="flex gap-2 mb-6">
                        ${stepsHtml}
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                        <div class="flex gap-4">
                            ${status === 0 ? `
                                <button onclick="event.stopPropagation(); editRepair(${item.id})" class="text-[10px] font-black text-blue-500 hover:text-blue-600 uppercase tracking-widest flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button onclick="event.stopPropagation(); deleteRepair(${item.id})" class="text-[10px] font-black text-rose-500 hover:text-rose-600 uppercase tracking-widest flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            ` : `
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-lock text-[8px]"></i> Locked for Processing
                                </div>
                            `}
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest opacity-0 group-hover/card:opacity-100 transition-opacity">View Details <i class="fas fa-chevron-right ml-1"></i></span>
                            <span class="text-[10px] font-black text-slate-300 tracking-tighter">TICKET #${item.id}</span>
                        </div>
                    </div>
                </div>
            `;
                $('#repairCardList').append(card);
            });
        });
    }

    function handleAddSubmit(e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: 'api/insert_report_repair.php', type: 'POST', data: formData, processData: false, contentType: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'ส่งข้อมูลเรียบร้อย', showConfirmButton: false, timer: 1500 });
                    $('#addReportForm')[0].reset();
                    $('#AddDate').val(new Date().toISOString().split('T')[0]);
                    $('.animate-fade-in.pl-10').addClass('hidden'); // Hide all details
                    fetchRepairs();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    }

    function editRepair(id) {
        $.get('api/fetch_report_detail.php?id=' + id, function (res) {
            if (res.success) {
                const r = res.report;
                $('#editId').val(r.id);
                $('#editAddDate').val(r.AddDate);
                $('#editAddLocation').val(r.AddLocation);

                // Render Edit Form Fields (Simplified for now)
                renderEditFields(r);
                $('#editModal').removeClass('hidden');
            }
        });
    }

    function renderEditFields(r) {
        const containers = ['edit_topic1', 'edit_topic2', 'edit_topic3'];
        containers.forEach(c => $(`#${c}`).empty());

        const render = (arr, topicId) => {
            arr.forEach(item => {
                const count = r[item.id + 'Count'] || 0;
                const damage = r[item.id + 'Damage'] || '';
                const checked = count > 0 || damage !== '';

                $(`#${topicId}`).append(`
                <div class="space-y-2 mb-2">
                    <div class="checkbox-modern">
                        <input type="checkbox" id="edit_${item.id}" class="w-5 h-5 rounded-md text-blue-500" ${checked ? 'checked' : ''} onchange="const $d = $('#edit_${item.id}Details'); $d.toggleClass('hidden', !this.checked); $d.find('input').prop('disabled', !this.checked);">
                        <label for="edit_${item.id}" class="flex-1 font-bold text-slate-700 dark:text-slate-300 cursor-pointer text-sm">${item.label}</label>
                    </div>
                    <div id="edit_${item.id}Details" class="${checked ? '' : 'hidden'} pl-10 pr-4 pb-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <input type="number" name="${item.id}Count" class="input-number-modern" min="0" value="${count}" ${checked ? '' : 'disabled'}>
                            <input type="text" name="${item.id}Damage" class="flex-1 bg-white dark:bg-slate-700 border rounded-xl p-2 text-xs" value="${damage}" placeholder="ระบุอาการ..." ${checked ? '' : 'disabled'}>
                        </div>
                    </div>
                </div>
            `);
            });
        };
        render(items, 'edit_topic1');
        render(items2, 'edit_topic2');
        render(items3, 'edit_topic3');
    }

    $('#editRepairForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        $.ajax({
            url: 'api/update_report_repair.php', type: 'POST', data: formData, processData: false, contentType: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'บันทึกแก้ไขเรียบร้อย', showConfirmButton: false, timer: 1500 });
                    closeEditModal();
                    fetchRepairs();
                }
            }
        });
    });

    function deleteRepair(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?', text: "ข้อมูลจะถูกลบออกจากระบบ", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#f43f5e', confirmButtonText: 'ลบข้อมูล'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('api/del_report_repair.php', { id }, function (res) {
                    if (res.success) {
                        Swal.fire('Deleted!', 'ข้อมูลถูกลบแล้ว', 'success');
                        fetchRepairs();
                    }
                });
            }
        });
    }

    function viewDetail(id) {
        $.get('api/fetch_report_detail.php?id=' + id, function(res) {
            if (res.success) {
                const r = res.report;
                $('#detailTicketId').text('Ticket #' + r.id);
                $('#detailDate').text(r.AddDate);
                $('#detailLocation').text(r.AddLocation);
                
                // Render Items
                const list = $('#detailItemsList').empty();
                [...items, ...items2, ...items3].forEach(item => {
                    const count = r[item.id + 'Count'];
                    const damage = r[item.id + 'Damage'];
                    if (count > 0 || (damage && damage !== '')) {
                        list.append(`
                            <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white dark:bg-slate-700 rounded-xl flex items-center justify-center font-black text-blue-500 shadow-sm border border-slate-100 dark:border-slate-600">
                                        ${count || 1}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 dark:text-white text-sm">${item.label}</p>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${damage || 'ไม่มีรายละเอียดอาการเสีย'}</p>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                });

                // Render Steps
                const status = parseInt(r.status || 0);
                const conf = statusMap[status];
                $('#detailStatusBadge').text(conf.label).css({ background: conf.color + '15', color: conf.color });
                
                const steps = $('#detailSteps').empty();
                for(let i=0; i<5; i++) {
                    const isActive = i <= status;
                    const color = isActive ? statusMap[i].color : '#e2e8f0';
                    steps.append(`<div class="status-step ${isActive ? 'active' : ''}" style="--step-color: ${color}"></div>`);
                }

                $('#detailModal').removeClass('hidden');
            }
        });
    }

    function closeDetailModal() { $('#detailModal').addClass('hidden'); }
    function closeEditModal() { $('#editModal').addClass('hidden'); }
</script>