<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

require_once('header.php');

// เรียก Controller
require_once('../controllers/ReportRepairController.php');
use Controllers\ReportRepairController;

$controller = new ReportRepairController();
$repairs = $controller->getAll(); // เพิ่มฟังก์ชัน getAll() ใน Controller/Model
?>
<body class="hold-transition sidebar-mini layout-fixed light-mode">
<div class="wrapper">
    <?php require_once('wrapper.php');?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo $global['nameschool']; ?> <span class="text-blue-600">| แจ้งซ่อม</span></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-info mb-4 rounded-lg flex items-center gap-2 bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 shadow">
                    🛠️ <span>หน้านี้สำหรับตรวจสอบและจัดการรายการแจ้งซ่อม</span>
                </div>
                <!-- ตารางรายการแจ้งซ่อม -->
                <div class="card bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="card-header bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-t-xl px-6 py-4 flex items-center gap-2 text-lg font-bold">
                        📝 รายการแจ้งซ่อมทั้งหมด
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700">#</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700">📅 วันที่แจ้ง</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700">📍 รายการ</th>
                                    <th class="px-4 py-3 text-left font-semibold text-blue-700">🔖 สถานะ</th>
                                    <th class="px-4 py-3 text-center font-semibold text-blue-700">⚙️ การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody id="repair-tbody" class="divide-y divide-gray-100 bg-white">
                                <!-- JS will render rows here -->
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- จบตาราง -->

                <!-- Modal สำหรับรายละเอียดแจ้งซ่อม -->
                <div id="modal-detail-bg" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-lg max-w-lg w-full p-6 relative">
                        <button id="modal-detail-close" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-blue-700">👁️ รายละเอียดแจ้งซ่อม</h2>
                        <div id="modal-detail-content" class="space-y-2 text-gray-700">
                            <!-- JS will render detail here -->
                        </div>
                    </div>
                </div>
                <!-- /Modal -->

                <!-- Modal สำหรับอัปเดตสถานะ -->
                <div id="modal-update-bg" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-lg max-w-lg w-full p-6 relative">
                        <button id="modal-update-close" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-green-700">✏️ อัปเดตสถานะแจ้งซ่อม</h2>
                        <form id="modal-update-form" class="space-y-4">
                            <input type="hidden" name="id" id="update-id">
                            <div>
                                <label for="update-status" class="block font-semibold mb-1">สถานะใหม่</label>
                                <select name="status" id="update-status" class="w-full border rounded px-3 py-2">
                                    <option value="0">🕒 รอเจ้าหน้าที่ตรวจสอบ</option>
                                    <option value="1">🔄 รับเรื่องแล้วกำลังดำเนินการ</option>
                                    <option value="2">🛒 รอการสั่งซื้ออุปกรณ์/วัสดุ</option>
                                    <option value="3">✅ ดำเนินการแล้วเสร็จ</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow font-semibold">
                                    บันทึกการอัปเดต
                                </button>
                            </div>
                            <div id="update-result" class="text-center text-sm mt-2"></div>
                        </form>
                    </div>
                </div>
                <!-- /Modal -->

                <!-- Modal สำหรับแก้ไขรายละเอียด -->
                <div id="modal-edit-bg" class="fixed inset-0 bg-black bg-opacity-40 z-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6 relative">
                        <button id="modal-edit-close" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-yellow-700">📝 แก้ไขรายละเอียดแจ้งซ่อม</h2>
                        <form id="modal-edit-form" class="space-y-4">
                            <input type="hidden" name="id" id="edit-id">
                            <div>
                                <label class="block font-semibold mb-1">สถานที่/รายการ</label>
                                <input type="text" name="AddLocation" id="edit-AddLocation" class="w-full border rounded px-3 py-2" required>
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">รายละเอียดอื่น ๆ</label>
                                <textarea name="other1Details" id="edit-other1Details" class="w-full border rounded px-3 py-2"></textarea>
                            </div>
                            <!-- เพิ่มฟิลด์อื่น ๆ ตามต้องการ -->
                            <div>
                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded shadow font-semibold">
                                    บันทึกการแก้ไข
                                </button>
                            </div>
                            <div id="edit-result" class="text-center text-sm mt-2"></div>
                        </form>
                    </div>
                </div>
                <!-- /Modal -->

                <!-- Toast Alert -->
                <div id="toast-alert" class="fixed top-6 right-6 z-[9999] hidden">
                    <div id="toast-content" class="flex items-center px-4 py-3 rounded shadow text-white font-semibold"></div>
                </div>
                <!-- /Toast Alert -->

            </div>
        </section>
        <!-- /.content -->
    </div>
    <?php require_once('../footer.php');?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('api/repair_list.php')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('repair-tbody');
            tbody.innerHTML = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    // กำหนดสถานะและตกแต่ง
                    let badge = 'bg-gray-300 text-gray-800', icon = '⏳', statusText = 'ไม่ทราบสถานะ';
                    switch (row.status) {
                        case '0':
                        case 0:
                            badge = 'bg-yellow-200 text-yellow-800 animate-pulse';
                            icon = '🕒';
                            statusText = 'รอเจ้าหน้าที่ตรวจสอบ';
                            break;
                        case '1':
                        case 1:
                            badge = 'bg-blue-200 text-blue-800';
                            icon = '🔄';
                            statusText = 'รับเรื่องแล้วกำลังดำเนินการ';
                            break;
                        case '2':
                        case 2:
                            badge = 'bg-orange-200 text-orange-800';
                            icon = '🛒';
                            statusText = 'รอการสั่งซื้ออุปกรณ์/วัสดุ';
                            break;
                        case '3':
                        case 3:
                            badge = 'bg-green-200 text-green-800';
                            icon = '✅';
                            statusText = 'ดำเนินการแล้วเสร็จ';
                            break;
                    }
                    tbody.innerHTML += `
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-2 font-mono text-blue-900">${row.id}</td>
                            <td class="px-4 py-2">${row.AddDate}</td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <span class="text-lg">🔧</span>
                                <span>${row.AddLocation}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold ${badge}">
                                    ${icon} ${statusText}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button
                                   class="btn-detail inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150"
                                   data-id="${row.id}"
                                   title="ดูรายละเอียดแจ้งซ่อม">
                                    👁️ ดูรายละเอียด
                                </button>
                                <button
                                   class="btn-update inline-flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150 ml-1"
                                   data-id="${row.id}"
                                   title="อัปเดตสถานะ">
                                    ✏️ อัปเดต
                                </button>
                                <button
                                   class="btn-delete inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150 ml-1"
                                   data-id="${row.id}"
                                   title="ลบรายการ">
                                    🗑️ ลบ
                                </button>
                            </td>
                        </tr>
                    `;
                });

                // เพิ่ม event ให้ปุ่มดูรายละเอียด
                document.querySelectorAll('.btn-detail').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        showRepairDetailModal(id);
                    });
                });
                // เพิ่ม event ให้ปุ่มอัปเดต
                document.querySelectorAll('.btn-update').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        showRepairUpdateModal(id);
                    });
                });
                // เพิ่ม event ให้ปุ่มแก้ไข
                document.querySelectorAll('.btn-edit').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        showRepairEditModal(id);
                    });
                });
                // เพิ่ม event ให้ปุ่มลบ
                document.querySelectorAll('.btn-delete').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        // Tailwind CSS confirm dialog
                        showTailwindConfirm({
                            title: 'ยืนยันการลบ',
                            message: 'คุณต้องการลบรายการแจ้งซ่อมนี้ใช่หรือไม่?',
                            confirmText: 'ลบ',
                            cancelText: 'ยกเลิก',
                            onConfirm: () => {
                                fetch('api/repair_delete.php', {
                                    method: 'POST',
                                    headers: {'Content-Type': 'application/json'},
                                    body: JSON.stringify({id})
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data && data.success) {
                                        showToast('ลบรายการสำเร็จ', 'success');
                                        document.dispatchEvent(new Event('repair-updated'));
                                    } else {
                                        showToast('ลบรายการไม่สำเร็จ', 'error');
                                    }
                                })
                                .catch(() => {
                                    showToast('เกิดข้อผิดพลาดในการลบ', 'error');
                                });
                            }
                        });
                    });
                });
            } else {
                tbody.innerHTML = `<tr>
                    <td colspan="5" class="text-center py-6 text-gray-400 text-lg">
                        😕 ไม่พบข้อมูลแจ้งซ่อม
                    </td>
                </tr>`;
            }
        })
        .catch(() => {
            const tbody = document.getElementById('repair-tbody');
            tbody.innerHTML = `<tr>
                <td colspan="5" class="text-center py-6 text-red-400 text-lg">
                    ⚠️ ไม่สามารถโหลดข้อมูลได้
                </td>
            </tr>`;
        });

    // Modal close
    document.getElementById('modal-detail-close').onclick = function() {
        document.getElementById('modal-detail-bg').classList.add('hidden');
    };
    document.getElementById('modal-detail-bg').onclick = function(e) {
        if (e.target === this) this.classList.add('hidden');
    };

    // Modal close สำหรับอัปเดต
    document.getElementById('modal-update-close').onclick = function() {
        document.getElementById('modal-update-bg').classList.add('hidden');
    };
    document.getElementById('modal-update-bg').onclick = function(e) {
        if (e.target === this) this.classList.add('hidden');
    };

});

// ฟังก์ชันดึงข้อมูลรายละเอียดและแสดง modal
function showRepairDetailModal(id) {
    const modalBg = document.getElementById('modal-detail-bg');
    const modalContent = document.getElementById('modal-detail-content');
    modalContent.innerHTML = '<div class="text-center text-blue-500 py-4">⏳ กำลังโหลด...</div>';
    modalBg.classList.remove('hidden');
    fetch('api/repair_detail.php?id=' + encodeURIComponent(id))
        .then(res => res.json())
        .then(data => {
            if (data && data.id) {
                // สร้างตารางรายละเอียด
                let html = `
                    <div class="mb-2"><b>เลขที่แจ้งซ่อม:</b> ${data.id}</div>
                    <div class="mb-2"><b>วันที่แจ้ง:</b> ${data.AddDate || '-'}</div>
                    <div class="mb-2"><b>สถานที่/รายการ:</b> ${data.AddLocation || '-'}</div>
                    <div class="mb-2"><b>สถานะ:</b> ${getStatusText(data.status)}</div>
                    <div class="overflow-x-auto">
                    <table class="min-w-full text-xs border mt-4">
                        <thead>
                            <tr class="bg-blue-100 text-blue-700">
                                <th class="px-2 py-1 border">รายการ</th>
                                <th class="px-2 py-1 border">จำนวน</th>
                                <th class="px-2 py-1 border">รายละเอียดความเสียหาย</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="border px-2 py-1">🚪 ประตู</td><td class="border px-2 py-1">${data.doorCount ?? '-'}</td><td class="border px-2 py-1">${data.doorDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🪟 หน้าต่าง</td><td class="border px-2 py-1">${data.windowCount ?? '-'}</td><td class="border px-2 py-1">${data.windowDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🪑 โต๊ะนักเรียน</td><td class="border px-2 py-1">${data.tablestCount ?? '-'}</td><td class="border px-2 py-1">${data.tablestDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🪑 เก้าอี้นักเรียน</td><td class="border px-2 py-1">${data.chairstCount ?? '-'}</td><td class="border px-2 py-1">${data.chairstDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🪑 โต๊ะอาจารย์</td><td class="border px-2 py-1">${data.tabletaCount ?? '-'}</td><td class="border px-2 py-1">${data.tabletaDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🪑 เก้าอี้อาจารย์</td><td class="border px-2 py-1">${data.chairtaCount ?? '-'}</td><td class="border px-2 py-1">${data.chairtaDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">📋 อื่นๆ 1</td><td class="border px-2 py-1">${data.other1Count ?? '-'}</td><td class="border px-2 py-1">${data.other1Details || '-'}<br>${data.other1Damage || ''}</td></tr>
                            <tr><td class="border px-2 py-1">📺 ทีวี</td><td class="border px-2 py-1">${data.tvCount ?? '-'}</td><td class="border px-2 py-1">${data.tvDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🔊 เครื่องเสียง</td><td class="border px-2 py-1">${data.audioCount ?? '-'}</td><td class="border px-2 py-1">${data.audioDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🔌 HDMI</td><td class="border px-2 py-1">${data.hdmiCount ?? '-'}</td><td class="border px-2 py-1">${data.hdmiDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">📽️ โปรเจคเตอร์</td><td class="border px-2 py-1">${data.projectorCount ?? '-'}</td><td class="border px-2 py-1">${data.projectorDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">📋 อื่นๆ 2</td><td class="border px-2 py-1">${data.other2Count ?? '-'}</td><td class="border px-2 py-1">${data.other2Details || '-'}<br>${data.other2Damage || ''}</td></tr>
                            <tr><td class="border px-2 py-1">🌀 พัดลม</td><td class="border px-2 py-1">${data.fanCount ?? '-'}</td><td class="border px-2 py-1">${data.fanDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">💡 ไฟ</td><td class="border px-2 py-1">${data.lightCount ?? '-'}</td><td class="border px-2 py-1">${data.lightDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">❄️ แอร์</td><td class="border px-2 py-1">${data.airCount ?? '-'}</td><td class="border px-2 py-1">${data.airDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🔘 สวิตช์ไฟ</td><td class="border px-2 py-1">${data.swCount ?? '-'}</td><td class="border px-2 py-1">${data.swDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🔘 สวิตช์พัดลม</td><td class="border px-2 py-1">${data.swfanCount ?? '-'}</td><td class="border px-2 py-1">${data.swfanDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">🔌 ปลั๊กไฟ</td><td class="border px-2 py-1">${data.plugCount ?? '-'}</td><td class="border px-2 py-1">${data.plugDamage || '-'}</td></tr>
                            <tr><td class="border px-2 py-1">📋 อื่นๆ 3</td><td class="border px-2 py-1">${data.other3Count ?? '-'}</td><td class="border px-2 py-1">${data.other3Details || '-'}<br>${data.other3Damage || ''}</td></tr>
                        </tbody>
                    </table>
                    </div>
                `;
                modalContent.innerHTML = html;
            } else {
                modalContent.innerHTML = '<div class="text-center text-red-500 py-4">ไม่พบข้อมูล</div>';
            }
        })
        .catch(() => {
            modalContent.innerHTML = '<div class="text-center text-red-500 py-4">เกิดข้อผิดพลาดในการโหลดข้อมูล</div>';
        });
}

// แปลงรหัสสถานะเป็นข้อความ
function getStatusText(status) {
    switch (status) {
        case '0':
        case 0: return '🕒 รอเจ้าหน้าที่ตรวจสอบ';
        case '1':
        case 1: return '🔄 รับเรื่องแล้วกำลังดำเนินการ';
        case '2':
        case 2: return '🛒 รอการสั่งซื้ออุปกรณ์/วัสดุ';
        case '3':
        case 3: return '✅ ดำเนินการแล้วเสร็จ';
        default: return 'ไม่ทราบสถานะ';
    }
}

// ฟังก์ชันแสดง modal อัปเดต
function showRepairUpdateModal(id) {
    document.getElementById('update-id').value = id;
    document.getElementById('update-status').selectedIndex = 0;
    document.getElementById('update-result').innerHTML = '';
    document.getElementById('modal-update-bg').classList.remove('hidden');
    // ดึงสถานะปัจจุบันมาแสดง (optional)
    fetch('api/repair_detail.php?id=' + encodeURIComponent(id))
        .then(res => res.json())
        .then(data => {
            if (data && typeof data.status !== 'undefined') {
                document.getElementById('update-status').value = data.status;
            }
        });
}



// จัดการ submit อัปเดตสถานะ
document.getElementById('modal-update-form').onsubmit = function(e) {
    e.preventDefault();
    const id = document.getElementById('update-id').value;
    const status = document.getElementById('update-status').value;
    const resultDiv = document.getElementById('update-result');
    resultDiv.innerHTML = '<span class="text-blue-500">⏳ กำลังบันทึก...</span>';
    fetch('api/repair_update.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id, status})
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.success) {
            showToast('อัปเดตสถานะสำเร็จ', 'success');
            setTimeout(() => {
                document.getElementById('modal-update-bg').classList.add('hidden');
                // อัปเดตแถวในตารางโดยไม่ต้อง reload ทั้งหน้า
                document.dispatchEvent(new Event('repair-updated'));
            }, 800);
        } else {
            showToast('อัปเดตไม่สำเร็จ', 'error');
        }
    })
    .catch(() => {
        showToast('เกิดข้อผิดพลาด', 'error');
    });
};



// อัปเดตข้อมูลในตารางหลังอัปเดตสถานะ
document.addEventListener('repair-updated', function() {
    // โหลดข้อมูลใหม่
    fetch('api/repair_list.php')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('repair-tbody');
            tbody.innerHTML = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    let badge = 'bg-gray-300 text-gray-800', icon = '⏳', statusText = 'ไม่ทราบสถานะ';
                    switch (row.status) {
                        case '0':
                        case 0:
                            badge = 'bg-yellow-200 text-yellow-800 animate-pulse';
                            icon = '🕒';
                            statusText = 'รอเจ้าหน้าที่ตรวจสอบ';
                            break;
                        case '1':
                        case 1:
                            badge = 'bg-blue-200 text-blue-800';
                            icon = '🔄';
                            statusText = 'รับเรื่องแล้วกำลังดำเนินการ';
                            break;
                        case '2':
                        case 2:
                            badge = 'bg-orange-200 text-orange-800';
                            icon = '🛒';
                            statusText = 'รอการสั่งซื้ออุปกรณ์/วัสดุ';
                            break;
                        case '3':
                        case 3:
                            badge = 'bg-green-200 text-green-800';
                            icon = '✅';
                            statusText = 'ดำเนินการแล้วเสร็จ';
                            break;
                    }
                    // เงื่อนไข: ถ้าสถานะ == 3 (ดำเนินการแล้วเสร็จ) ไม่แสดงปุ่มอัปเดต
                    tbody.innerHTML += `
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-2 font-mono text-blue-900">${row.id}</td>
                            <td class="px-4 py-2">${row.AddDate}</td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <span class="text-lg">🔧</span>
                                <span>${row.AddLocation}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold ${badge}">
                                    ${icon} ${statusText}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button
                                   class="btn-detail inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150"
                                   data-id="${row.id}"
                                   title="ดูรายละเอียดแจ้งซ่อม">
                                    👁️ ดูรายละเอียด
                                </button>
                                ${
                                    row.status == 3 || row.status == '3'
                                    ? ''
                                    : `<button
                                        class="btn-update inline-flex items-center gap-1 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150 ml-1"
                                        data-id="${row.id}"
                                        title="อัปเดตสถานะ">
                                        ✏️ อัปเดต
                                    </button>`
                                }
                                <button
                                   class="btn-delete inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium shadow transition duration-150 ml-1"
                                   data-id="${row.id}"
                                   title="ลบรายการ">
                                    🗑️ ลบ
                                </button>
                            </td>
                        </tr>
                    `;
                });

                // รีผูก event ให้ปุ่มใหม่
                document.querySelectorAll('.btn-detail').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        showRepairDetailModal(id);
                    });
                });
                document.querySelectorAll('.btn-update').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        showRepairUpdateModal(id);
                    });
                });
                document.querySelectorAll('.btn-delete').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        // Tailwind CSS confirm dialog
                        showTailwindConfirm({
                            title: 'ยืนยันการลบ',
                            message: 'คุณต้องการลบรายการแจ้งซ่อมนี้ใช่หรือไม่?',
                            confirmText: 'ลบ',
                            cancelText: 'ยกเลิก',
                            onConfirm: () => {
                                fetch('api/repair_delete.php', {
                                    method: 'POST',
                                    headers: {'Content-Type': 'application/json'},
                                    body: JSON.stringify({id})
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data && data.success) {
                                        showToast('ลบรายการสำเร็จ', 'success');
                                        document.dispatchEvent(new Event('repair-updated'));
                                    } else {
                                        showToast('ลบรายการไม่สำเร็จ', 'error');
                                    }
                                })
                                .catch(() => {
                                    showToast('เกิดข้อผิดพลาดในการลบ', 'error');
                                });
                            }
                        });
                    });
                });
            } else {
                tbody.innerHTML = `<tr>
                    <td colspan="5" class="text-center py-6 text-gray-400 text-lg">
                        😕 ไม่พบข้อมูลแจ้งซ่อม
                    </td>
                </tr>`;
            }
        });
});

// ฟังก์ชันแสดง toast alert
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast-alert');
    const content = document.getElementById('toast-content');
    content.textContent = message;
    content.className = "flex items-center px-4 py-3 rounded shadow text-white font-semibold";
    if (type === 'success') {
        content.classList.add('bg-green-600');
    } else if (type === 'error') {
        content.classList.add('bg-red-600');
    } else {
        content.classList.add('bg-gray-700');
    }
    toast.classList.remove('hidden');
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 2000);
}

// ฟังก์ชันแสดง tailwind confirm
function showTailwindConfirm({ title, message, confirmText = 'ตกลง', cancelText = 'ยกเลิก', onConfirm }) {
    // ลบ dialog เดิมถ้ามี
    let old = document.getElementById('tailwind-confirm-bg');
    if (old) old.remove();

    const bg = document.createElement('div');
    bg.id = 'tailwind-confirm-bg';
    bg.className = 'fixed inset-0 z-[99999] flex items-center justify-center bg-black bg-opacity-40';

    const box = document.createElement('div');
    box.className = 'bg-white rounded-xl shadow-xl max-w-xs w-full p-6 text-center';

    const h = document.createElement('h3');
    h.className = 'text-lg font-bold mb-2 text-red-600';
    h.textContent = title;

    const msg = document.createElement('div');
    msg.className = 'mb-4 text-gray-700';
    msg.textContent = message;

    const btnGroup = document.createElement('div');
    btnGroup.className = 'flex justify-center gap-3';

    const btnConfirm = document.createElement('button');
    btnConfirm.className = 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold';
    btnConfirm.textContent = confirmText;

    const btnCancel = document.createElement('button');
    btnCancel.className = 'bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-semibold';
    btnCancel.textContent = cancelText;

    btnGroup.appendChild(btnConfirm);
    btnGroup.appendChild(btnCancel);

    box.appendChild(h);
    box.appendChild(msg);
    box.appendChild(btnGroup);
    bg.appendChild(box);
    document.body.appendChild(bg);

    btnCancel.onclick = () => bg.remove();
    btnConfirm.onclick = () => {
        bg.remove();
        if (typeof onConfirm === 'function') onConfirm();
    };
    // ปิด dialog เมื่อคลิกพื้นหลัง
    bg.onclick = (e) => { if (e.target === bg) bg.remove(); };
}
</script>
<?php require_once('script.php'); ?>
</body>
</html>
