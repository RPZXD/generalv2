<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'ครู') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];
require_once('header.php');
?>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-100 min-h-screen font-sans" style="font-family: 'Mali', sans-serif;">
<div class="wrapper">
    <?php require_once('wrapper.php');?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 flex items-center gap-2">
                            <?php echo $global['nameschool']; ?>
                            <span class="text-blue-600 text-2xl">| สร้างจดหมายข่าว 📰</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container mx-auto max-w-6xl bg-white rounded-xl shadow-xl p-4 md:p-8 mt-8 border-l-8 border-blue-400 animate-fade-in">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- ซ้าย: ฟอร์มบันทึกจดหมายข่าว -->
                    <div class="w-full lg:w-1/2">
                        <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-xl shadow p-4 md:p-6 border border-blue-100">
                            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">📰 สร้างจดหมายข่าวใหม่</h2>
                            <form id="newsletterForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="title">หัวข้อข่าว <span class="text-red-500">*</span></label>
                                    <input type="text" id="title" name="title" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="เช่น กิจกรรมวันวิทยาศาสตร์">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="news_date">วันที่ <span class="text-red-500">*</span></label>
                                    <input type="date" id="news_date" name="news_date" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2">อัปโหลดรูปภาพ (6-9 รูป) <span class="text-red-500">*</span></label>
                                    <div id="imageInputs" class="space-y-2">
                                        <!-- ช่องเลือกไฟล์ภาพ 6 ช่องเริ่มต้น -->
                                        <?php for ($i = 1; $i <= 6; $i++): ?>
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3">
                                            <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                            <img src="" alt="" class="preview-img w-20 h-20 object-cover rounded border hidden" />
                                            <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg hidden" title="ลบรูปภาพนี้">✖</button>
                                        </div>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <button type="button" id="addImageInput" class="bg-blue-100 text-blue-700 px-4 py-2 rounded hover:bg-blue-200 transition text-sm">+ เพิ่มรูปภาพ</button>
                                        <span class="text-xs text-gray-400">เลือกได้ 6-9 รูป (ไฟล์ .jpg, .jpeg, .png, .gif)</span>
                                    </div>
                                    <div id="imageInputError" class="text-red-500 text-sm mt-1"></div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-semibold mb-2" for="detail">รายละเอียดข่าว <span class="text-red-500">*</span></label>
                                    <textarea id="detail" name="detail" rows="6" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="รายละเอียดข่าว..."></textarea>
                                </div>
                                <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center gap-2">
                                    <span class="text-red-500 text-xs md:text-sm">ข้อมูลจะถูกเจ้าหน้าที่คัดกรองอีกที หากมีปัญหาเจ้าหน้าที่จะติดต่อกลับไป</span>
                                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-3 px-8 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105 mt-2 md:mt-0">
                                        <span>บันทึกข่าว</span> <span>🚀</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ขวา: ตารางรายการจดหมายข่าว -->
                    <div class="w-full lg:w-1/2">
                        <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-xl shadow p-4 md:p-6 border border-green-100">
                            <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">📋 รายการจดหมายข่าวของคุณ</h2>
                            <div class="overflow-x-auto">
                                <table id="newsletterTable" class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
                                    <thead>
                                        <tr class="bg-blue-100 text-blue-700">
                                            <th class="py-2 px-2 border-b">#</th>
                                            <th class="py-2 px-2 border-b">หัวข้อข่าว</th>
                                            <th class="py-2 px-2 border-b">วันที่</th>
                                            <th class="py-2 px-2 border-b">รูปภาพ</th>
                                            <th class="py-2 px-2 border-b">รายละเอียด</th>
                                            <th class="py-2 px-2 border-b">สถานะ</th>
                                            <th class="py-2 px-2 border-b">ลบ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- JS render -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
/* Responsive tweaks */
@media (max-width: 1024px) {
  .container.mx-auto.max-w-6xl { padding: 0.5rem !important; }
  .flex.flex-col.lg\:flex-row.gap-8 { gap: 1.5rem !important; }
}
@media (max-width: 768px) {
  .container.mx-auto.max-w-6xl { padding: 0.25rem !important; }
  .flex.flex-col.lg\:flex-row.gap-8 { flex-direction: column !important; gap: 1rem !important; }
  .w-full.lg\:w-1\/2 { width: 100% !important; }
  .p-4.md\:p-6 { padding: 1rem !important; }
}
@media (max-width: 640px) {
  .p-4.md\:p-6 { padding: 0.5rem !important; }
  .rounded-xl { border-radius: 0.5rem !important; }
  .text-2xl { font-size: 1.25rem !important; }
  .py-3 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
  .px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
}
</style>
<script>
// เพิ่มตัวแปรป้องกันการส่งซ้ำ
let isSubmitting = false;

function updateImageInputStates() {
    const imageInputs = document.querySelectorAll('#imageInputs .single-image-input');
    const removeBtns = document.querySelectorAll('#imageInputs .remove-image-btn');
    removeBtns.forEach(btn => btn.classList.toggle('hidden', imageInputs.length <= 6));
    document.getElementById('addImageInput').disabled = imageInputs.length >= 9;
}

function validateImageInputs() {
    const imageInputs = document.querySelectorAll('#imageInputs .single-image-input');
    let valid = true;
    let error = '';
    const filled = Array.from(imageInputs).filter(input => input.files.length > 0);
    if (filled.length < 6) {
        valid = false;
        error = 'กรุณาเลือกรูปภาพอย่างน้อย 6 รูป';
    }
    if (imageInputs.length > 9) {
        valid = false;
        error = 'เลือกได้สูงสุด 9 รูป';
    }
    document.getElementById('imageInputError').textContent = error;
    return valid;
}

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

// เพิ่มช่อง input รูปภาพ
document.getElementById('addImageInput').addEventListener('click', function() {
    const imageInputs = document.querySelectorAll('#imageInputs .single-image-input');
    if (imageInputs.length >= 9) return;
    const div = document.createElement('div');
    div.className = "flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3";
    div.innerHTML = `
        <input type="file" name="images[]" accept="image/*" required class="single-image-input block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        <img src="" alt="" class="preview-img w-20 h-20 object-cover rounded border hidden" />
        <button type="button" class="remove-image-btn text-red-500 hover:text-red-700 text-lg" title="ลบรูปภาพนี้">✖</button>
    `;
    document.getElementById('imageInputs').appendChild(div);
    updateImageInputStates();

    const input = div.querySelector('.single-image-input');
    const previewImg = div.querySelector('.preview-img');
    handleImagePreview(input, previewImg);

    div.querySelector('.remove-image-btn').addEventListener('click', function() {
        div.remove();
        updateImageInputStates();
    });
});

// จัดการ preview และ remove สำหรับ 6 ช่องแรก
document.querySelectorAll('#imageInputs .flex').forEach(div => {
    const input = div.querySelector('.single-image-input');
    const previewImg = div.querySelector('.preview-img');
    handleImagePreview(input, previewImg);
    const removeBtn = div.querySelector('.remove-image-btn');
    removeBtn.addEventListener('click', function() {
        div.remove();
        updateImageInputStates();
    });
});

updateImageInputStates();

// ส่งข้อมูลแบบ AJAX (adddata)
document.getElementById('newsletterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (isSubmitting) return false;
    if (!validateImageInputs()) return false;

    isSubmitting = true;
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>กำลังบันทึก...</span> <span>⏳</span>';
    submitBtn.disabled = true;

    const form = this;
    const formData = new FormData(form);
    formData.append('create_by', "<?php echo $teacher_id; ?>");

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
                    document.querySelectorAll('.preview-img').forEach(img => {
                        img.src = '';
                        img.classList.add('hidden');
                    });
                    var dateInput = document.getElementById('news_date');
                    if (dateInput) {
                        const today = new Date();
                        dateInput.value = today.toISOString().split('T')[0];
                    }
                    fetchNewsletters();
                });
            } else {
                Swal.fire('ผิดพลาด!', result.message || 'เกิดข้อผิดพลาด', 'error');
            }
        })
        .catch(() => {
            Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
        })
        .finally(() => {
            isSubmitting = false;
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }, 500); // ลดเวลาหน่วงเหลือ 0.5 วินาที
});

// ตั้งค่าวันที่ปัจจุบันเป็นค่า default
document.addEventListener('DOMContentLoaded', function() {
    var dateInput = document.getElementById('news_date');
    if (dateInput) {
        const today = new Date();
        dateInput.value = today.toISOString().split('T')[0];
    }
});
</script>
<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
// ฟังก์ชันโหลดรายการจดหมายข่าว
function fetchNewsletters() {
    $.get('api/newsletter_list.php?create_by=<?php echo $teacher_id; ?>', function(res) {
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
                ? `<img src="../${images[0]}" class="w-12 h-12 object-cover rounded border inline-block" alt="img">`
                : '';
            let statusText = '';
            let status = (typeof item.status !== 'undefined') ? item.status : 0;
            if (status == 1 || status === '1') {
                statusText = '<span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">เผยแพร่</span>';
            } else if (status == 2 || status === '2') {
                statusText = '<span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs">เก็บถาวร</span>';
            } else {
                statusText = '<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">ฉบับร่าง</span>';
            }
            $tbody.append(`
                <tr>
                    <td class="py-2 px-2 border-b text-center">${idx + 1}</td>
                    <td class="py-2 px-2 border-b">${item.title}</td>
                    <td class="py-2 px-2 border-b">${item.news_date}</td>
                    <td class="py-2 px-2 border-b">${imgHtml}</td>
                    <td class="py-2 px-2 border-b">
                        <button type="button" class="show-detail-btn text-blue-600 underline" data-detail="${encodeURIComponent(item.detail)}" data-images='${JSON.stringify(images)}'>ดูรายละเอียด</button>
                    </td>
                    <td class="py-2 px-2 border-b text-center">${statusText}</td>
                    <td class="py-2 px-2 border-b text-center">
                        <button type="button" class="delete-newsletter-btn text-red-600 hover:text-red-800" data-id="${item.id}" data-status="${status}" title="ลบ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </button>
                    </td>
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
    // กรณี images เป็น string ให้ parse ใหม่
    if (typeof images === 'string') {
        try { images = JSON.parse(images.replace(/\\\//g, '/')); } catch { images = []; }
    }
    // ปรับ path รูปภาพให้ถูกต้อง (ลบ teacher/ ออก)
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

// โหลดรายการเมื่อหน้าโหลดเสร็จ
$(document).ready(function() {
    fetchNewsletters();
});

// ลบจดหมายข่าว
$(document).on('click', '.delete-newsletter-btn', function() {
    const id = $(this).data('id');
    // ตรวจสอบสถานะก่อนลบ (อนุญาตลบเฉพาะ status = 0)
    const status = $(this).data('status');
    if (status != 0 && status !== '0') {
        Swal.fire('ไม่สามารถลบได้', 'สามารถลบได้เฉพาะจดหมายข่าวที่เป็นฉบับร่างเท่านั้น', 'warning');
        return;
    }
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
</script>
<?php require_once('script.php'); ?>
</body>
</html>
</html>
