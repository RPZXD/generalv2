<!-- Repair Request Page Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🛠️</span> บันทึกการแจ้งซ่อม
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">แจ้งปัญหาและติดตามสถานะการซ่อมแซม</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                <span class="w-2 h-2 bg-amber-500 rounded-full mr-2 animate-pulse"></span>
                งานซ่อมบำรุง
            </span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- ฟอร์มบันทึกแจ้งซ่อม (ซ้าย) -->
        <div class="glass rounded-2xl p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg text-white">
                    <i class="fas fa-tools text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">บันทึกการแจ้งซ่อม</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">กรอกรายละเอียดทรัพย์สินที่ชำรุด</p>
                </div>
            </div>

            <form id="addReportForm" method="POST" class="space-y-5">
                <!-- วันที่แจ้ง -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="AddDate">
                        <i class="fas fa-calendar-alt mr-2 text-amber-500"></i>วันที่แจ้ง <span class="text-red-500">*</span>
                    </label>
                    <input type="date" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors" id="AddDate" name="AddDate" required>
                </div>

                <!-- สถานที่ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="AddLocation">
                        <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>สถานที่ <span class="text-red-500">*</span>
                    </label>
                    <input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors" id="AddLocation" name="AddLocation" placeholder="เช่น ห้องคอม(438) อาคาร 4" required>
                </div>

                <!-- รายการทรัพย์สินชำรุด -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4">
                    <h5 class="font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-amber-500"></i>
                        รายการทรัพย์สินชำรุด/เสียหาย
                    </h5>
                    
                    <!-- หมวด 1 -->
                    <div class="mb-4">
                        <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs flex items-center justify-center">1</span>
                            ครุภัณฑ์ภายในห้องเรียน/ห้องปฏิบัติการ
                        </h6>
                        <div id="topic1" class="pl-8 space-y-2"></div>
                    </div>
                    
                    <!-- หมวด 2 -->
                    <div class="mb-4">
                        <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-green-500 text-white text-xs flex items-center justify-center">2</span>
                            ทัศนูปกรณ์ประจำห้องเรียน/ห้องปฏิบัติการ
                        </h6>
                        <div id="topic2" class="pl-8 space-y-2"></div>
                    </div>
                    
                    <!-- หมวด 3 -->
                    <div>
                        <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-yellow-500 text-white text-xs flex items-center justify-center">3</span>
                            เครื่องใช้ไฟฟ้าประจำห้องเรียน/ห้องปฏิบัติการ
                        </h6>
                        <div id="topic3" class="pl-8 space-y-2"></div>
                    </div>
                </div>

                <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">
                
                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>บันทึกแจ้งซ่อม</span>
                        <span>🚀</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400 dark:text-gray-500">
                    <i class="fas fa-phone mr-1"></i>
                    หากเร่งด่วน กรุณาติดต่อเจ้าหน้าที่โดยตรง
                </p>
            </div>
        </div>

        <!-- รายการแจ้งซ่อม (ขวา) -->
        <div class="glass rounded-2xl p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg text-white">
                        <i class="fas fa-list-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 รายการแจ้งซ่อม</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">รายการที่คุณแจ้งไว้</p>
                    </div>
                </div>
                <button id="refreshList" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                    <i class="fas fa-sync-alt"></i>
                    รีเฟรช
                </button>
            </div>
            
            <div id="repairCardList" class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                <!-- JS will render cards here -->
                <div class="text-center py-8 text-gray-400">
                    <div class="loader mx-auto mb-4"></div>
                    <p>กำลังโหลดข้อมูล...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal แก้ไขแจ้งซ่อม -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeEditModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">✏️ แก้ไขการแจ้งซ่อม</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">แก้ไขรายละเอียดการแจ้งซ่อม</p>
            </div>
        </div>

        <form id="editRepairForm" class="space-y-5">
            <input type="hidden" name="id" id="editId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="editAddDate">
                        <i class="fas fa-calendar-alt mr-2 text-amber-500"></i>วันที่แจ้ง <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="AddDate" id="editAddDate" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-colors" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="editAddLocation">
                        <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>สถานที่ <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="AddLocation" id="editAddLocation" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 transition-colors" required>
                </div>
            </div>

            <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-4">
                <h5 class="font-bold text-gray-800 dark:text-white mb-4">รายการทรัพย์สินชำรุด/เสียหาย</h5>
                
                <div class="mb-4">
                    <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-blue-500 text-white text-xs flex items-center justify-center">1</span>
                        ครุภัณฑ์ภายในห้องเรียน/ห้องปฏิบัติการ
                    </h6>
                    <div id="edit_topic1" class="pl-8 space-y-2"></div>
                </div>
                
                <div class="mb-4">
                    <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-green-500 text-white text-xs flex items-center justify-center">2</span>
                        ทัศนูปกรณ์ประจำห้องเรียน/ห้องปฏิบัติการ
                    </h6>
                    <div id="edit_topic2" class="pl-8 space-y-2"></div>
                </div>
                
                <div>
                    <h6 class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-yellow-500 text-white text-xs flex items-center justify-center">3</span>
                        เครื่องใช้ไฟฟ้าประจำห้องเรียน/ห้องปฏิบัติการ
                    </h6>
                    <div id="edit_topic3" class="pl-8 space-y-2"></div>
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>บันทึกการแก้ไข</span>
                <span>💾</span>
            </button>
        </form>
    </div>
</div>

<style>
/* Loading spinner */
.loader {
    border: 3px solid rgba(59, 130, 246, 0.2);
    border-top: 3px solid #3b82f6;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

/* Repair card styling */
.repair-card {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
    border-left: 4px solid #3b82f6;
    transition: all 0.3s ease;
}
.repair-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
}

/* Form checkbox styling */
.form-check {
    background: rgba(255, 255, 255, 0.5);
    border-radius: 0.75rem;
    transition: all 0.2s ease;
}
.form-check:hover {
    background: rgba(255, 255, 255, 0.8);
}
.dark .form-check {
    background: rgba(30, 41, 59, 0.5);
}
.dark .form-check:hover {
    background: rgba(30, 41, 59, 0.8);
}

/* Custom checkbox */
.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 0.375rem;
    border: 2px solid #d1d5db;
    cursor: pointer;
}
.form-check-input:checked {
    background-color: #f59e0b;
    border-color: #f59e0b;
}
</style>

<script>
// Items configuration
const items = [
    { id: 'door', label: 'ประตู', detailsId: 'doorDetails' },
    { id: 'window', label: 'หน้าต่าง', detailsId: 'windowDetails' },
    { id: 'tablest', label: 'โต๊ะนักเรียน', detailsId: 'tablestDetails' },
    { id: 'chairst', label: 'เก้าอี้นักเรียน', detailsId: 'chairstDetails' },
    { id: 'tableta', label: 'โต๊ะครู', detailsId: 'tabletaDetails' },
    { id: 'chairta', label: 'เก้าอี้ครู', detailsId: 'chairtaDetails' },
    { id: 'other1', label: 'อื่นๆ', detailsId: 'other1Details' }
];
const items2 = [
    { id: 'tv', label: 'โทรทัศน์', detailsId: 'tvDetails' },
    { id: 'audio', label: 'เครื่องเสียง', detailsId: 'audioDetails' },
    { id: 'hdmi', label: 'สาย HDMI', detailsId: 'hdmiDetails' },
    { id: 'projector', label: 'จอโปรเจคเตอร์', detailsId: 'projectorDetails' },
    { id: 'other2', label: 'อื่นๆ', detailsId: 'other2Details' }
];
const items3 = [
    { id: 'fan', label: 'พัดลม', detailsId: 'fanDetails' },
    { id: 'light', label: 'หลอดไฟ', detailsId: 'lightDetails' },
    { id: 'air', label: 'เครื่องปรับอากาศ', detailsId: 'airDetails' },
    { id: 'sw', label: 'สวิตซ์ไฟ', detailsId: 'swDetails' },
    { id: 'swfan', label: 'สวิตซ์พัดลม', detailsId: 'swfanDetails' },
    { id: 'plug', label: 'ปลั๊กไฟ', detailsId: 'plugDetails' },
    { id: 'other3', label: 'อื่นๆ', detailsId: 'other3Details' }
];

document.addEventListener('DOMContentLoaded', function () {
    // กำหนดวันที่ปัจจุบัน
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('AddDate').value = formattedDate;

    function createFormElement(item, topicId) {
        const topic = document.getElementById(topicId);
        const formCheckDiv = document.createElement('div');
        formCheckDiv.classList.add('form-check', 'p-3', 'rounded-lg', 'flex', 'items-start', 'gap-3');

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = item.id;
        checkbox.classList.add('form-check-input', 'mt-1');
        checkbox.onchange = () => toggleDetails(item.id);

        const labelWrapper = document.createElement('div');
        labelWrapper.classList.add('flex-1');
        
        const label = document.createElement('label');
        label.setAttribute('for', item.id);
        label.classList.add('font-medium', 'cursor-pointer', 'text-gray-700', 'dark:text-gray-300');
        label.innerHTML = item.label;
        labelWrapper.appendChild(label);

        formCheckDiv.appendChild(checkbox);
        formCheckDiv.appendChild(labelWrapper);

        const detailsDiv = document.createElement('div');
        detailsDiv.id = item.detailsId;
        detailsDiv.style.display = 'none';
        detailsDiv.classList.add('ml-8', 'mt-2', 'p-4', 'bg-white', 'dark:bg-slate-700', 'rounded-xl', 'border', 'border-gray-200', 'dark:border-gray-600', 'space-y-3');

        if (item.id.includes('other')) {
            const otherInputDiv = document.createElement('div');
            otherInputDiv.classList.add('mb-2');
            const otherLabel = document.createElement('label');
            otherLabel.textContent = 'โปรดระบุ:';
            otherLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-600', 'dark:text-gray-400', 'mb-1');
            const otherInput = document.createElement('input');
            otherInput.type = 'text';
            otherInput.classList.add('w-full', 'p-2', 'border', 'rounded-lg', 'text-gray-900', 'dark:text-white', 'dark:bg-slate-600');
            otherInput.name = `${item.id}Details`;
            otherInputDiv.appendChild(otherLabel);
            otherInputDiv.appendChild(otherInput);
            detailsDiv.appendChild(otherInputDiv);
        }

        const row = document.createElement('div');
        row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-3');

        const col1 = document.createElement('div');
        const label1 = document.createElement('label');
        label1.textContent = 'จำนวน:';
        label1.classList.add('block', 'text-sm', 'font-medium', 'text-gray-600', 'dark:text-gray-400', 'mb-1');
        const inputNumber = document.createElement('input');
        inputNumber.type = 'number';
        inputNumber.classList.add('w-full', 'p-2', 'border', 'rounded-lg', 'text-gray-900', 'dark:text-white', 'dark:bg-slate-600');
        inputNumber.name = `${item.id}Count`;
        inputNumber.min = 0;
        col1.appendChild(label1);
        col1.appendChild(inputNumber);

        const col2 = document.createElement('div');
        col2.classList.add('md:col-span-3');
        const label2 = document.createElement('label');
        label2.textContent = 'ระบุความเสียหาย:';
        label2.classList.add('block', 'text-sm', 'font-medium', 'text-gray-600', 'dark:text-gray-400', 'mb-1');
        const textarea = document.createElement('textarea');
        textarea.classList.add('w-full', 'p-2', 'border', 'rounded-lg', 'text-gray-900', 'dark:text-white', 'dark:bg-slate-600');
        textarea.name = `${item.id}Damage`;
        textarea.rows = 2;
        col2.appendChild(label2);
        col2.appendChild(textarea);

        row.appendChild(col1);
        row.appendChild(col2);
        detailsDiv.appendChild(row);
        topic.appendChild(formCheckDiv);
        topic.appendChild(detailsDiv);
    }

    function toggleDetails(itemId) {
        const detailsDiv = document.getElementById(`${itemId}Details`);
        const checkbox = document.getElementById(itemId);
        if (checkbox.checked) {
            detailsDiv.style.display = 'block';
        } else {
            detailsDiv.style.display = 'none';
        }
    }

    items.forEach(item => createFormElement(item, 'topic1'));
    items2.forEach(item => createFormElement(item, 'topic2'));
    items3.forEach(item => createFormElement(item, 'topic3'));
});

const teach_id = "<?php echo $teacher_id; ?>";

function fetchRepairs() {
    const cardList = document.getElementById('repairCardList');
    cardList.innerHTML = '<div class="text-center py-8 text-gray-400"><div class="loader mx-auto mb-4"></div><p>กำลังโหลดข้อมูล...</p></div>';
    
    fetch('api/fet_report_repair.php?Teach_id=' + encodeURIComponent(teach_id))
        .then(res => res.json())
        .then(data => {
            const list = Array.isArray(data) ? data : (data.list || []);
            cardList.innerHTML = '';
            
            if (!list.length) {
                cardList.innerHTML = '<div class="text-center py-8 text-gray-400"><i class="fas fa-inbox text-4xl mb-2"></i><p>ไม่มีข้อมูลการแจ้งซ่อม</p></div>';
                return;
            }
            
            list.forEach(item => {
                const card = document.createElement('div');
                card.className = "repair-card rounded-xl p-4 dark:bg-slate-700/50";
                card.innerHTML = `
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg text-xs font-medium">
                                    <i class="fas fa-calendar-alt mr-1"></i>${item.AddDate || '-'}
                                </span>
                            </div>
                            <div class="font-semibold text-gray-800 dark:text-white mb-1">
                                <i class="fas fa-map-marker-alt mr-2 text-amber-500"></i>${item.AddLocation || '-'}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                ${item.doorDamage || 'ไม่มีรายละเอียด'}
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="editBtn px-4 py-2 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:hover:bg-yellow-900/50 text-yellow-700 dark:text-yellow-400 rounded-lg font-medium transition-colors flex items-center gap-1" data-id="${item.id}">
                                <i class="fas fa-edit"></i> แก้ไข
                            </button>
                            <button class="deleteBtn px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg font-medium transition-colors flex items-center gap-1" data-id="${item.id}">
                                <i class="fas fa-trash"></i> ลบ
                            </button>
                        </div>
                    </div>
                `;
                cardList.appendChild(card);
            });
        })
        .catch(() => {
            cardList.innerHTML = '<div class="text-center py-8 text-red-500"><i class="fas fa-exclamation-triangle text-4xl mb-2"></i><p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>';
        });
}

fetchRepairs();
document.getElementById('refreshList').onclick = fetchRepairs;

// Form submit
document.getElementById('addReportForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('api/insert_report_repair.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'บันทึกข้อมูลเรียบร้อย',
                confirmButtonColor: '#f59e0b'
            });
            this.reset();
            const today = new Date();
            document.getElementById('AddDate').value = today.toISOString().split('T')[0];
            fetchRepairs();
        } else {
            Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
        }
    }).catch(() => {
        Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
    });
};

// Edit form elements
function createEditFormElement(item, topicId) {
    const topic = document.getElementById(topicId);
    if (!topic) return;

    const formCheckDiv = document.createElement('div');
    formCheckDiv.classList.add('form-check', 'p-3', 'rounded-lg', 'flex', 'items-start', 'gap-3');

    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.id = 'edit_' + item.id;
    checkbox.classList.add('form-check-input', 'mt-1');
    checkbox.onchange = function() { toggleEditDetails(item.id); };

    const labelWrapper = document.createElement('div');
    labelWrapper.classList.add('flex-1');
    
    const label = document.createElement('label');
    label.setAttribute('for', 'edit_' + item.id);
    label.classList.add('font-medium', 'cursor-pointer', 'text-gray-700', 'dark:text-gray-300');
    label.innerHTML = item.label;
    labelWrapper.appendChild(label);

    formCheckDiv.appendChild(checkbox);
    formCheckDiv.appendChild(labelWrapper);

    const detailsDiv = document.createElement('div');
    detailsDiv.id = 'edit_' + item.detailsId;
    detailsDiv.style.display = 'none';
    detailsDiv.classList.add('ml-8', 'mt-2', 'p-4', 'bg-white', 'dark:bg-slate-700', 'rounded-xl', 'border', 'space-y-3');

    if (item.id.includes('other')) {
        const otherInputDiv = document.createElement('div');
        otherInputDiv.classList.add('mb-2');
        const otherLabel = document.createElement('label');
        otherLabel.textContent = 'โปรดระบุ:';
        otherLabel.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
        const otherInput = document.createElement('input');
        otherInput.type = 'text';
        otherInput.classList.add('w-full', 'p-2', 'border', 'rounded-lg');
        otherInput.name = `${item.id}Details`;
        otherInputDiv.appendChild(otherLabel);
        otherInputDiv.appendChild(otherInput);
        detailsDiv.appendChild(otherInputDiv);
    }

    const row = document.createElement('div');
    row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-4', 'gap-3');

    const col1 = document.createElement('div');
    const label1 = document.createElement('label');
    label1.textContent = 'จำนวน:';
    label1.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
    const inputNumber = document.createElement('input');
    inputNumber.type = 'number';
    inputNumber.classList.add('w-full', 'p-2', 'border', 'rounded-lg');
    inputNumber.name = `${item.id}Count`;
    inputNumber.min = 0;
    col1.appendChild(label1);
    col1.appendChild(inputNumber);

    const col2 = document.createElement('div');
    col2.classList.add('md:col-span-3');
    const label2 = document.createElement('label');
    label2.textContent = 'ระบุความเสียหาย:';
    label2.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
    const textarea = document.createElement('textarea');
    textarea.classList.add('w-full', 'p-2', 'border', 'rounded-lg');
    textarea.name = `${item.id}Damage`;
    textarea.rows = 2;
    col2.appendChild(label2);
    col2.appendChild(textarea);

    row.appendChild(col1);
    row.appendChild(col2);
    detailsDiv.appendChild(row);
    topic.appendChild(formCheckDiv);
    topic.appendChild(detailsDiv);
}

function toggleEditDetails(itemId) {
    const detailsDiv = document.getElementById(`edit_${itemId}Details`);
    const checkbox = document.getElementById('edit_' + itemId);
    if (!detailsDiv || !checkbox) return;
    detailsDiv.style.display = checkbox.checked ? 'block' : 'none';
}

function renderEditFormFields(report = {}) {
    ['edit_topic1','edit_topic2','edit_topic3'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.innerHTML = '';
    });
    items.forEach(item => createEditFormElement(item, 'edit_topic1'));
    items2.forEach(item => createEditFormElement(item, 'edit_topic2'));
    items3.forEach(item => createEditFormElement(item, 'edit_topic3'));

    if (report && typeof report === 'object') {
        [...items, ...items2, ...items3].forEach(item => {
            const checkbox = document.getElementById('edit_' + item.id);
            const detailsDiv = document.getElementById(`edit_${item.detailsId}`);
            const checked = (report[item.id + 'Count'] && report[item.id + 'Count'] > 0) ||
                          (report[item.id + 'Damage'] && report[item.id + 'Damage'] !== '') ||
                          (report[item.id + 'Details'] && report[item.id + 'Details'] !== '');
            if (checkbox) checkbox.checked = checked;
            toggleEditDetails(item.id);

            const inputNumber = detailsDiv ? detailsDiv.querySelector(`input[name="${item.id}Count"]`) : null;
            if (inputNumber && report[item.id + 'Count'] !== undefined) inputNumber.value = report[item.id + 'Count'] || '';

            const textarea = detailsDiv ? detailsDiv.querySelector(`textarea[name="${item.id}Damage"]`) : null;
            if (textarea && report[item.id + 'Damage'] !== undefined) textarea.value = report[item.id + 'Damage'] || '';

            if (item.id.includes('other')) {
                const otherInput = detailsDiv ? detailsDiv.querySelector(`input[name="${item.id}Details"]`) : null;
                if (otherInput && report[item.id + 'Details'] !== undefined) otherInput.value = report[item.id + 'Details'] || '';
            }
        });
    }
}

// Edit button click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editBtn') || e.target.closest('.editBtn')) {
        const btn = e.target.classList.contains('editBtn') ? e.target : e.target.closest('.editBtn');
        const id = btn.dataset.id;
        fetch('api/fetch_report_detail.php?id=' + encodeURIComponent(id))
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    document.getElementById('editId').value = result.report.id;
                    document.getElementById('editAddDate').value = result.report.AddDate;
                    document.getElementById('editAddLocation').value = result.report.AddLocation;
                    renderEditFormFields(result.report);
                    document.getElementById('editModal').classList.remove('hidden');
                } else {
                    Swal.fire('ผิดพลาด', result.message || 'ไม่พบข้อมูล', 'error');
                }
            });
    }
});

// Close modal
document.getElementById('closeEditModal').onclick = function() {
    document.getElementById('editModal').classList.add('hidden');
};

// Edit form submit
document.getElementById('editRepairForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('api/update_report_repair.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!',
                text: 'แก้ไขข้อมูลเรียบร้อย',
                confirmButtonColor: '#f59e0b'
            });
            document.getElementById('editModal').classList.add('hidden');
            fetchRepairs();
        } else {
            Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
        }
    });
};

// Delete button click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('deleteBtn') || e.target.closest('.deleteBtn')) {
        const btn = e.target.classList.contains('deleteBtn') ? e.target : e.target.closest('.deleteBtn');
        const id = btn.dataset.id;
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบรายการนี้หรือไม่',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then(result => {
            if (result.isConfirmed) {
                fetch('api/del_report_repair.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(id)
                })
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire('ลบแล้ว', '', 'success');
                        fetchRepairs();
                    } else {
                        Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
                });
            }
        });
    }
});
</script>
