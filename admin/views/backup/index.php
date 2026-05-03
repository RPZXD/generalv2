<div class="space-y-6 animate-fadeIn">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <i class="fas fa-database text-fuchsia-600"></i>
                สำรองข้อมูลระบบ
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">จัดการการสำรองข้อมูลฐานข้อมูลและไฟล์ที่เกี่ยวข้อง</p>
        </div>
        <button onclick="createBackup()" class="px-6 py-3 bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white rounded-2xl font-bold shadow-lg shadow-fuchsia-500/30 hover:scale-[1.02] transition-all flex items-center gap-2">
            <i class="fas fa-plus"></i>
            สร้างจุดสำรองข้อมูลใหม่
        </button>
    </div>

    <!-- Backup List -->
    <div class="glass rounded-3xl overflow-hidden border border-white/20 shadow-xl">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                รายการไฟล์สำรอง
            </h2>
            <span id="backupCount" class="px-3 py-1 bg-fuchsia-100 dark:bg-fuchsia-900/30 text-fuchsia-600 dark:text-fuchsia-400 text-xs font-bold rounded-full">
                กำลังโหลด...
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="backupTable">
                <thead class="bg-gray-50/50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">ชื่อไฟล์</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">วันที่สร้าง</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">ขนาด</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">ประเภท</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300 divide-y divide-gray-100 dark:divide-gray-800">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
        <div id="loadingState" class="p-12 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-fuchsia-500 border-t-transparent mb-4"></div>
            <p class="text-gray-500">กำลังดึงข้อมูลไฟล์สำรอง...</p>
        </div>
        <div id="emptyState" class="hidden p-12 text-center">
            <i class="fas fa-folder-open text-5xl text-gray-200 dark:text-gray-700 mb-4"></i>
            <p class="text-gray-500">ยังไม่มีไฟล์สำรองข้อมูลในระบบ</p>
        </div>
    </div>

    <!-- Information Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass p-6 rounded-3xl border border-white/20 flex gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-white mb-1">คำแนะนำการสำรองข้อมูล</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">ควรสำรองข้อมูลฐานข้อมูลอย่างน้อยสัปดาห์ละครั้ง หรือก่อนมีการอัปเดตระบบครั้งใหญ่ เพื่อป้องกันการสูญเสียข้อมูลสำคัญ</p>
            </div>
        </div>
        <div class="glass p-6 rounded-3xl border border-white/20 flex gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-white mb-1">ข้อควรระวัง</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">การลบไฟล์สำรองข้อมูลจะไม่สามารถเรียกคืนได้ กรุณาตรวจสอบให้แน่ใจก่อนทำการลบไฟล์ออกจากเซิร์ฟเวอร์</p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    loadBackups();
});

function loadBackups() {
    $('#loadingState').show();
    $('#emptyState').hide();
    $('#backupTable tbody').empty();

    $.ajax({
        url: 'api/backup_list.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loadingState').hide();
            if (response.success && response.list.length > 0) {
                $('#backupCount').text(response.list.length + ' ไฟล์');
                response.list.forEach(file => {
                    $('#backupTable tbody').append(`
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center text-gray-500">
                                        <i class="fas fa-file-code"></i>
                                    </div>
                                    <span class="font-medium text-gray-800 dark:text-white">${file.name}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">${file.date}</td>
                            <td class="px-6 py-4 text-sm">${file.size}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[10px] font-bold rounded uppercase">
                                    ${file.type}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="../backups/${file.name}" download class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center hover:bg-emerald-100 transition-colors" title="ดาวน์โหลด">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button onclick="deleteBackup('${file.name}')" class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center hover:bg-red-100 transition-colors" title="ลบ">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            } else {
                $('#emptyState').show();
                $('#backupCount').text('0 ไฟล์');
            }
        },
        error: function() {
            $('#loadingState').hide();
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลไฟล์สำรองได้', 'error');
        }
    });
}

function createBackup() {
    Swal.fire({
        title: 'กำลังสร้างไฟล์สำรอง...',
        text: 'กรุณารอสักครู่ ระบบกำลังรวบรวมข้อมูลฐานข้อมูล',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: 'api/backup_create.php',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำรองข้อมูลสำเร็จ',
                    text: 'ไฟล์สำรองถูกสร้างเรียบร้อยแล้ว: ' + response.filename,
                    confirmButtonColor: '#d33',
                });
                loadBackups();
            } else {
                Swal.fire('ผิดพลาด', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('ผิดพลาด', 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้', 'error');
        }
    });
}

function deleteBackup(filename) {
    Swal.fire({
        title: 'ยืนยันการลบไฟล์?',
        text: "คุณต้องการลบไฟล์สำรอง " + filename + " หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'ยืนยันการลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'api/backup_delete.php',
                type: 'POST',
                data: { filename: filename },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire('ลบสำเร็จ', 'ลบไฟล์สำรองเรียบร้อยแล้ว', 'success');
                        loadBackups();
                    } else {
                        Swal.fire('ผิดพลาด', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('ผิดพลาด', 'ไม่สามารถลบไฟล์ได้', 'error');
                }
            });
        }
    });
}
</script>
