<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];
require_once('header.php');
?>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-100 min-h-screen " >
<div class="wrapper">
    <?php require_once('wrapper.php');?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 flex items-center gap-2">
                            <?php echo $global['nameschool']; ?>
                            <span class="text-blue-600 text-2xl">| จดหมายข่าว 📰</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-blue-400 animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2">📋 รายการจดหมายข่าวทั้งหมด</h2>
                    <button id="addNewsletterBtn" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-2 px-6 rounded-lg font-bold hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>+ บันทึกข่าว</span> <span>📰</span>
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table id="newsletterTable" class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
                        <thead>
    <tr class="bg-blue-100 text-blue-700">
        <th class="py-2 px-2 border-b text-center">#</th>
        <th class="py-2 px-2 border-b text-center">หัวข้อข่าว</th>
        <th class="py-2 px-2 border-b text-center">วันที่</th>
        <th class="py-2 px-2 border-b text-center">ฉบับที่</th>
        <th class="py-2 px-2 border-b text-center">รูปภาพ</th>
        <th class="py-2 px-2 border-b text-center">รายละเอียด</th>
        <th class="py-2 px-2 border-b text-center">สถานะ</th>
        <th class="py-2 px-2 border-b text-center">ผู้สร้าง</th>
    </tr>
</thead>
<tbody>
    <!-- JS render -->
</tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->
<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fade-in 1s ease-out; }
</style>
<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// เพิ่มตัวแปรป้องกันการส่งซ้ำ
let isSubmitting = false;

function updateImageInputStates() {
    // ซ่อนปุ่มลบถ้ามี <= 4 ช่อง, แสดงถ้ามี > 4 ช่อง
    const imageInputs = document.querySelectorAll('#addImageInputs .single-image-input');
    const removeBtns = document.querySelectorAll('#addImageInputs .remove-image-btn');
    removeBtns.forEach(btn => btn.classList.toggle('hidden', imageInputs.length <= 6));
    // ปิดปุ่มเพิ่มถ้าครบ 8 ช่อง
    document.getElementById('addMoreImageInput').disabled = imageInputs.length >= 9;
}

function validateImageInputs() {
    const imageInputs = document.querySelectorAll('#addImageInputs .single-image-input');
    let valid = true;
    let error = '';
    // ต้องมีอย่างน้อย 4 ช่องที่มีไฟล์
    const filled = Array.from(imageInputs).filter(input => input.files.length > 0);
    if (filled.length < 6) {
        valid = false;
        error = 'กรุณาเลือกรูปภาพอย่างน้อย 6 รูป';
    }
    if (imageInputs.length > 9) {
        valid = false;
        error = 'เลือกได้สูงสุด 9 รูป';
    }
    document.getElementById('addImageInputError').textContent = error;
    return valid;
}

// แสดง preview รูป
function handleImagePreview(input, previewImg) {
    input.addEventListener('change', function() {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImg.src = evt.target.result;
                previewImg.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
        }
    });
}

function fetchNewsletters() {
    $.get('api/newsletter_list.php', function(res) {
        let data = [];
        if (res && res.list) {
            data = res.list;
        }
        const $tbody = $('#newsletterTable tbody');
        $tbody.empty();
        data.forEach(function(item, idx) {
            let images = [];
            try { images = JSON.parse(item.images.replace(/\\\//g, '/')); } catch {}
            images = images.map(src => src.replace(/^teacher\//, ''));
            let imgHtml = images.length
                ? `<img src="../${images[0]}" class="w-12 h-12 object-cover rounded-lg border-2 border-blue-200 shadow-sm hover:scale-110 transition-transform duration-200" alt="img">`
                : '';
            // สถานะ: 0=draft, 1=published, 2=archived
            let statusText = '';
            let status = (typeof item.status !== 'undefined') ? item.status : 0;
            if (status == 1 || status === '1') {
                statusText = '<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold shadow">เผยแพร่</span>';
            } else if (status == 2 || status === '2') {
                statusText = '<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold shadow">เก็บถาวร</span>';
            } else {
                statusText = '<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold shadow">ฉบับร่าง</span>';
            }
            // ฉบับที่
            let issueNo = item.issue_no ? `<span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold border border-blue-200 shadow">${item.issue_no}</span>` : '<span class="text-gray-400 text-xs">-</span>';
            // ปุ่ม
            let detailBtn = `<button type="button" class="show-detail-btn text-blue-600 underline hover:text-blue-900 transition" data-detail="${encodeURIComponent(item.detail)}" data-images='${JSON.stringify(images)}'>ดูรายละเอียด</button>`;
            let editBtn = `<button type="button" class="edit-newsletter-btn text-yellow-600 underline ml-2 hover:text-yellow-800 transition"
                data-id="${item.id}"
                data-title="${encodeURIComponent(item.title)}"
                data-news_date="${item.news_date}"
                data-detail="${encodeURIComponent(item.detail)}"
                data-images='${JSON.stringify(images)}'
            >แก้ไข</button>`;
            let statusBtn = `<button type="button" class="change-status-btn bg-blue-100 text-blue-700 px-2 py-1 rounded ml-2 text-xs hover:bg-blue-200 transition" data-id="${item.id}" data-status="${status}">เปลี่ยนสถานะ</button>`;
            let deleteBtn = `<button type="button" class="delete-newsletter-btn text-red-600 hover:text-red-800 ml-2" data-id="${item.id}" data-status="${status}" title="ลบ">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>`;
            let exportBtn = '';
            if (status == 1 || status === '1') {
                exportBtn = `<button type="button" class="export-newsletter-btn bg-orange-100 text-orange-700 px-2 py-1 rounded ml-2 text-xs hover:bg-orange-200 transition" data-id="${item.id}">Export</button>`;
            }
            $tbody.append(`
                <tr class="hover:bg-blue-50 transition">
                    <td class="py-2 px-2 border-b text-center font-semibold">${idx + 1}</td>
                    <td class="py-2 px-2 border-b font-medium">${item.title}</td>
                    <td class="py-2 px-2 border-b text-center">${item.news_date}</td>
                    <td class="py-2 px-2 border-b text-center">${issueNo}</td>
                    <td class="py-2 px-2 border-b text-center">${imgHtml}</td>
                    <td class="py-2 px-2 border-b text-center">${detailBtn}${editBtn}</td>
                    <td class="py-2 px-2 border-b text-center">${statusText}${statusBtn}${exportBtn}</td>
                    <td class="py-2 px-2 border-b text-center">${item.teacher_name || '-'}${deleteBtn}</td>
                </tr>
            `);
        });
        if (!$.fn.DataTable.isDataTable('#newsletterTable')) {
            $('#newsletterTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
                }
            });
        }
    }, 'json');
}

// แสดงรายละเอียดข่าว
$(document).on('click', '.show-detail-btn', function() {
    const detail = decodeURIComponent($(this).data('detail'));
    let images = $(this).data('images');
    if (typeof images === 'string') {
        try { images = JSON.parse(images.replace(/\\\//g, '/')); } catch { images = []; }
    }
    images = images.map(src => src.replace(/^teacher\//, ''));
    let imgHtml = '';
    if (Array.isArray(images)) {
        imgHtml = images.map(src => `<img src="../${src}" class="w-24 h-24 object-cover rounded border m-1 inline-block" alt="img">`).join('');
    }
    Swal.fire({
        title: 'รายละเอียดข่าว',
        html: `<div class="mb-2">${imgHtml}</div><div class="text-left">${detail}</div>`,
        width: 700,
        showCloseButton: true
    });
});

// เปลี่ยนสถานะจดหมายข่าว
$(document).on('click', '.change-status-btn', function() {
    const id = $(this).data('id');
    const currentStatus = $(this).data('status');
    Swal.fire({
        title: 'เปลี่ยนสถานะจดหมายข่าว',
        input: 'select',
        inputOptions: {
            0: 'ฉบับร่าง',
            1: 'เผยแพร่',
            2: 'เก็บถาวร'
        },
        inputValue: currentStatus,
        showCancelButton: true,
        confirmButtonText: 'บันทึก',
        cancelButtonText: 'ยกเลิก'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('api/newsletter_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: result.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('สำเร็จ!', 'อัปเดตสถานะเรียบร้อย', 'success');
                    fetchNewsletters();
                } else {
                    Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                }
            })
            .catch(() => {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        }
    });
});

// ลบจดหมายข่าว
$(document).on('click', '.delete-newsletter-btn', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบจดหมายข่าวนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('api/newsletter_delete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('ลบสำเร็จ!', 'จดหมายข่าวถูกลบเรียบร้อยแล้ว', 'success');
                    fetchNewsletters();
                } else {
                    Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                }
            })
            .catch(() => {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        }
    });
});

// Modal แก้ไขจดหมายข่าว
if (!document.getElementById('editNewsletterModal')) {
    $('body').append(`
    <div id="editNewsletterModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
            <button id="closeEditNewsletterModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
            <h3 class="text-xl font-bold text-blue-700 mb-4">✏️ แก้ไขจดหมายข่าว</h3>
            <form id="editNewsletterForm" class="space-y-4">
                <input type="hidden" name="id" id="editNewsletterId">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="editNewsletterTitle">หัวข้อข่าว <span class="text-red-500">*</span></label>
                    <input type="text" id="editNewsletterTitle" name="title" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="editNewsletterDate">วันที่ <span class="text-red-500">*</span></label>
                    <input type="date" id="editNewsletterDate" name="news_date" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="editNewsletterDetail">รายละเอียดข่าว <span class="text-red-500">*</span></label>
                    <textarea id="editNewsletterDetail" name="detail" rows="6" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">รูปภาพ (ไม่สามารถแก้ไขได้ที่นี่)</label>
                    <div id="editNewsletterImages" class="flex flex-wrap gap-2"></div>
                    <div class="text-xs text-gray-400 mt-1">* หากต้องการเปลี่ยนรูปภาพ กรุณาติดต่อผู้ดูแลระบบ</div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-3 px-8 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>บันทึกการแก้ไข</span> <span>💾</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    `);
    // ปิด modal
    $(document).on('click', '#closeEditNewsletterModal', function() {
        $('#editNewsletterModal').addClass('hidden');
    });
    $(document).on('click', '#editNewsletterModal', function(e) {
        if (e.target === this) {
            $('#editNewsletterModal').addClass('hidden');
        }
    });
}

// เปิด modal แก้ไขจดหมายข่าว
$(document).on('click', '.edit-newsletter-btn', function() {
    const id = $(this).data('id');
    const title = decodeURIComponent($(this).data('title'));
    const news_date = $(this).data('news_date');
    const detail = decodeURIComponent($(this).data('detail'));
    let images = $(this).data('images');
    if (typeof images === 'string') {
        try { images = JSON.parse(images); } catch { images = []; }
    }
    images = images.map(src => src.replace(/^teacher\//, ''));
    $('#editNewsletterId').val(id);
    $('#editNewsletterTitle').val(title);
    $('#editNewsletterDate').val(news_date);
    $('#editNewsletterDetail').val(detail);
    let imgHtml = '';
    if (Array.isArray(images)) {
        imgHtml = images.map(src => `<img src="../${src}" class="w-16 h-16 object-cover rounded border m-1 inline-block" alt="img">`).join('');
    }
    $('#editNewsletterImages').html(imgHtml);
    $('#editNewsletterModal').removeClass('hidden');
});

// บันทึกการแก้ไขจดหมายข่าว
$(document).on('submit', '#editNewsletterForm', function(e) {
    e.preventDefault();
    const formData = {
        id: $('#editNewsletterId').val(),
        title: $('#editNewsletterTitle').val(),
        news_date: $('#editNewsletterDate').val(),
        detail: $('#editNewsletterDetail').val()
    };
    fetch('api/newsletter_edit.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('สำเร็จ!', 'บันทึกการแก้ไขเรียบร้อย', 'success');
            $('#editNewsletterModal').addClass('hidden');
            fetchNewsletters();
        } else {
            Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
        }
    })
    .catch(() => {
        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
    });
});

// Export newsletter (open new window)
$(document).on('click', '.export-newsletter-btn', function() {
    const id = $(this).data('id');
    window.open('newsletter_export.php?id=' + encodeURIComponent(id), '_blank');
});

// Modal เพิ่มจดหมายข่าวใหม่
if (!document.getElementById('addNewsletterModal')) {
    $('body').append(`
    <div id="addNewsletterModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
            <button id="closeAddNewsletterModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
            <h3 class="text-xl font-bold text-blue-700 mb-4">📰 สร้างจดหมายข่าวใหม่</h3>
            <form id="addNewsletterForm" class="space-y-6" enctype="multipart/form-data">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="addNewsletterTitle">หัวข้อข่าว <span class="text-red-500">*</span></label>
                    <input type="text" id="addNewsletterTitle" name="title" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="เช่น กิจกรรมวันวิทยาศาสตร์">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="addNewsletterDate">วันที่ <span class="text-red-500">*</span></label>
                    <input type="date" id="addNewsletterDate" name="news_date" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">อัปโหลดรูปภาพ (6-9 รูป) <span class="text-red-500">*</span></label>
                    <div id="addImageInputs" class="space-y-2">
                        <!-- ช่องเลือกไฟล์ภาพ 6 ช่องเริ่มต้น -->
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                        </div>
                    </div>
                    <button type="button" id="addMoreImageInput" class="mt-2 bg-blue-100 text-blue-700 px-4 py-2 rounded hover:bg-blue-200 transition text-sm">+ เพิ่มรูปภาพ</button>
                    <div class="text-xs text-gray-400 mt-1">เลือกได้ 6-9 รูป (ไฟล์ .jpg, .jpeg, .png, .gif)</div>
                    <div id="addImageInputError" class="text-red-500 text-sm mt-1"></div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="addNewsletterDetail">รายละเอียดข่าว <span class="text-red-500">*</span></label>
                    <textarea id="addNewsletterDetail" name="detail" rows="6" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="รายละเอียดข่าว..."></textarea>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" id="cancelAddNewsletter" class="bg-gray-300 text-gray-700 py-3 px-8 rounded-lg font-bold hover:bg-gray-400 transition">ยกเลิก</button>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-3 px-8 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>บันทึกข่าว</span> <span>🚀</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    `);
    
    // ปิด modal
    $(document).on('click', '#closeAddNewsletterModal, #cancelAddNewsletter', function() {
        $('#addNewsletterModal').addClass('hidden');
        document.getElementById('addNewsletterForm').reset();
        document.querySelectorAll('#addImageInputs .preview-img').forEach(img => {
            img.src = '';
            img.classList.add('hidden');
        });
    });
    
    $(document).on('click', '#addNewsletterModal', function(e) {
        if (e.target === this) {
            $('#addNewsletterModal').addClass('hidden');
            document.getElementById('addNewsletterForm').reset();
        }
    });
}

// เปิด modal เพิ่มจดหมายข่าว
$(document).on('click', '#addNewsletterBtn', function() {
    // ตั้งค่าวันที่ปัจจุบัน
    const today = new Date();
    document.getElementById('addNewsletterDate').value = today.toISOString().split('T')[0];
    
    // จัดการ image inputs
    updateImageInputStates();
    
    // จัดการ preview และ remove สำหรับ input เริ่มต้น
    document.querySelectorAll('#addImageInputs .flex').forEach(div => {
        const input = div.querySelector('.single-image-input');
        const previewImg = div.querySelector('.preview-img');
        const removeBtn = div.querySelector('.remove-image-btn');
        
        // ลบ event listeners เก่า
        input.removeEventListener('change', handleImagePreview);
        
        // เพิ่ม event listeners ใหม่
        handleImagePreview(input, previewImg);
        
        removeBtn.addEventListener('click', function() {
            div.remove();
            updateImageInputStates();
        });
    });
    
    $('#addNewsletterModal').removeClass('hidden');
});

// เพิ่มช่อง input รูปภาพใน modal
$(document).on('click', '#addMoreImageInput', function() {
    const imageInputs = document.querySelectorAll('#addImageInputs .single-image-input');
    if (imageInputs.length >= 9) return;
    
    const div = document.createElement('div');
    div.className = "flex items-center gap-3";
    div.innerHTML = `
        <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <img src="" alt="" class="preview-img w-16 h-16 object-cover rounded border hidden" />
        <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg" title="ลบรูปภาพนี้">✖</button>
    `;
    document.getElementById('addImageInputs').appendChild(div);
    updateImageInputStates();

    // preview
    const input = div.querySelector('.single-image-input');
    const previewImg = div.querySelector('.preview-img');
    handleImagePreview(input, previewImg);

    // remove
    div.querySelector('.remove-image-btn').addEventListener('click', function() {
        div.remove();
        updateImageInputStates();
    });
});

// บันทึกจดหมายข่าวใหม่
$(document).on('submit', '#addNewsletterForm', function(e) {
    e.preventDefault();
    
    // ป้องกันการส่งซ้ำ
    if (isSubmitting) {
        return false;
    }
    
    if (!validateImageInputs()) {
        return false;
    }

    // ตั้งสถานะกำลังส่ง
    isSubmitting = true;
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>กำลังบันทึก...</span> <span>⏳</span>';
    submitBtn.disabled = true;

    const form = this;
    const formData = new FormData(form);

    // เพิ่ม create_by (officer)
    formData.append('create_by', "<?php echo $teacher_id; ?>");
    // หน่วงเวลา 1 วินาทีก่อนส่งข้อมูล
    setTimeout(() => {
        fetch('api/newsletter_upload.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                Swal.fire('สำเร็จ!', 'เผยแพร่จดหมายข่าวเรียบร้อยแล้ว', 'success').then(() => {
                    form.reset();
                    // ล้าง preview รูป
                    document.querySelectorAll('#addImageInputs .preview-img').forEach(img => {
                        img.src = '';
                        img.classList.add('hidden');
                    });
                    $('#addNewsletterModal').addClass('hidden');
                    fetchNewsletters(); // โหลดรายการใหม่
                });
            } else {
                Swal.fire('ผิดพลาด!', result.message || 'เกิดข้อผิดพลาด', 'error');
            }
        })
        .catch(() => {
            Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
        })
        .finally(() => {
            // คืนสถานะปุ่มและอนุญาตให้ส่งได้อีก
            isSubmitting = false;
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }, 1000); // หน่วงเวลา 1 วินาที
});

$(document).ready(function() {
    fetchNewsletters();
});
</script>
<?php require_once('script.php'); ?>
</body>
</html>
