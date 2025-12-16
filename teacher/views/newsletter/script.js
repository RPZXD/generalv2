/**
 * Newsletter JavaScript Module
 * Modern UI with image upload and preview
 */

let isSubmitting = false;
let imageInputCount = 6;

// ==================== Initialize ====================
$(document).ready(function() {
    setDefaultDate();
    fetchNewsletters();
    setupEventHandlers();
    updateImageInputStates();
});

// ==================== Event Handlers ====================
function setupEventHandlers() {
    // Form submission
    $('#newsletterForm').on('submit', submitNewsletter);
    
    // Add image input
    $('#addImageInput').on('click', addImageInputRow);
    
    // Remove image input (delegated)
    $(document).on('click', '.remove-image-btn', function() {
        $(this).closest('.image-input-row').remove();
        updateImageInputStates();
        renumberImageInputs();
    });
    
    // Image preview (delegated)
    $(document).on('change', '.single-image-input', function() {
        const previewImg = $(this).siblings('.preview-img');
        handleImagePreview(this, previewImg[0]);
    });
    
    // Refresh button
    $('#refreshList').on('click', function() {
        const icon = $(this).find('i');
        icon.addClass('animate-spin');
        fetchNewsletters();
        setTimeout(() => icon.removeClass('animate-spin'), 1000);
    });
    
    // Show detail modal (delegated)
    $(document).on('click', '.show-detail-btn', showDetailModal);
    
    // Close detail modal
    $('#closeDetailModal').on('click', () => {
        $('#detailModal').addClass('hidden').removeClass('flex');
    });
    
    // Close modal on backdrop
    $('#detailModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden').removeClass('flex');
        }
    });
    
    // Delete newsletter (delegated)
    $(document).on('click', '.delete-newsletter-btn', deleteNewsletter);
}

// ==================== Set Default Date ====================
function setDefaultDate() {
    const dateInput = document.getElementById('news_date');
    if (dateInput) {
        const today = new Date();
        dateInput.value = today.toISOString().split('T')[0];
    }
}

// ==================== Image Input Management ====================
function updateImageInputStates() {
    const rows = document.querySelectorAll('#imageInputs .image-input-row');
    const removeButtons = document.querySelectorAll('#imageInputs .remove-image-btn');
    
    // Show/hide remove buttons (only show if more than 6 rows)
    removeButtons.forEach(btn => {
        btn.classList.toggle('hidden', rows.length <= 6);
    });
    
    // Enable/disable add button
    const addBtn = document.getElementById('addImageInput');
    if (addBtn) {
        addBtn.disabled = rows.length >= 9;
        addBtn.classList.toggle('opacity-50', rows.length >= 9);
        addBtn.classList.toggle('cursor-not-allowed', rows.length >= 9);
    }
}

function renumberImageInputs() {
    const rows = document.querySelectorAll('#imageInputs .image-input-row');
    rows.forEach((row, index) => {
        const numberSpan = row.querySelector('span');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
    });
}

function addImageInputRow() {
    const container = document.getElementById('imageInputs');
    const rows = container.querySelectorAll('.image-input-row');
    
    if (rows.length >= 9) return;
    
    const newIndex = rows.length + 1;
    const div = document.createElement('div');
    div.className = 'image-input-row flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl';
    div.innerHTML = `
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-6">${newIndex}</span>
        <input type="file" name="images[]" accept="image/*" required 
            class="single-image-input flex-1 text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 dark:file:bg-blue-900/50 dark:file:text-blue-400 hover:file:bg-blue-200 dark:hover:file:bg-blue-900/70 transition-all cursor-pointer" />
        <img src="" alt="" class="preview-img w-12 h-12 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600 hidden" />
        <button type="button" class="remove-image-btn w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 rounded-lg transition-colors" title="ลบรูปภาพนี้">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(div);
    updateImageInputStates();
    
    // Scroll to new input
    div.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function handleImagePreview(input, previewImg) {
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
}

function validateImageInputs() {
    const imageInputs = document.querySelectorAll('#imageInputs .single-image-input');
    const filledInputs = Array.from(imageInputs).filter(input => input.files.length > 0);
    
    let valid = true;
    let error = '';
    
    if (filledInputs.length < 6) {
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

// ==================== Submit Newsletter ====================
function submitNewsletter(e) {
    e.preventDefault();
    
    if (isSubmitting) return false;
    if (!validateImageInputs()) return false;
    
    isSubmitting = true;
    
    const $btn = $(this).find('button[type="submit"]');
    const originalText = $btn.html();
    $btn.html('<i class="fas fa-spinner animate-spin mr-2"></i> กำลังบันทึก...');
    $btn.prop('disabled', true);
    
    const formData = new FormData(this);
    formData.append('create_by', teacher_id);
    
    fetch('api/newsletter_upload.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ! 🎉',
                text: 'เผยแพร่จดหมายข่าวเรียบร้อยแล้ว',
                confirmButtonColor: '#3b82f6',
                timer: 2000,
                timerProgressBar: true
            }).then(() => {
                // Reset form
                document.getElementById('newsletterForm').reset();
                
                // Clear previews
                document.querySelectorAll('.preview-img').forEach(img => {
                    img.src = '';
                    img.classList.add('hidden');
                });
                
                // Reset date
                setDefaultDate();
                
                // Reload list
                fetchNewsletters();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'ไม่สำเร็จ',
                text: data.message || 'เกิดข้อผิดพลาด',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
            confirmButtonColor: '#ef4444'
        });
    })
    .finally(() => {
        isSubmitting = false;
        $btn.html(originalText);
        $btn.prop('disabled', false);
    });
}

// ==================== Fetch Newsletters ====================
function fetchNewsletters() {
    const $tbody = $('#newsletterTableBody');
    $tbody.html(`
        <tr>
            <td colspan="6" class="text-center py-8 text-gray-400">
                <div class="loader mx-auto mb-4"></div>
                <p>กำลังโหลดข้อมูล...</p>
            </td>
        </tr>
    `);
    
    $.get(`api/newsletter_list.php?create_by=${teacher_id}`, function(res) {
        let data = [];
        if (res && res.list) {
            data = res.list;
        }
        
        updateStats(data);
        renderNewsletterTable(data);
    }, 'json').fail(function() {
        $tbody.html(`
            <tr>
                <td colspan="6" class="text-center py-8 text-red-500">
                    <div class="text-4xl mb-4">❌</div>
                    <p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p>
                </td>
            </tr>
        `);
    });
}

// ==================== Render Table ====================
function renderNewsletterTable(data) {
    const $tbody = $('#newsletterTableBody');
    $tbody.empty();
    
    if (data.length === 0) {
        $tbody.html(`
            <tr>
                <td colspan="6" class="text-center py-8 text-gray-400">
                    <div class="text-6xl mb-4">📭</div>
                    <p>ยังไม่มีจดหมายข่าว</p>
                    <p class="text-sm">ลองสร้างจดหมายข่าวใหม่ดูสิ!</p>
                </td>
            </tr>
        `);
        return;
    }
    
    data.forEach((item, idx) => {
        let images = parseImages(item.images);
        const imgHtml = images.length > 0 
            ? `<img src="../${images[0]}" class="w-12 h-12 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600" alt="img" onerror="this.src='../plugins/fontawesome-free/svgs/regular/image.svg'">`
            : '<span class="text-gray-400">-</span>';
        
        const statusBadge = getStatusBadge(item.status);
        
        const row = `
            <tr class="border-b border-gray-100 dark:border-gray-700">
                <td class="py-4 px-3 text-center font-semibold text-gray-600 dark:text-gray-400">${idx + 1}</td>
                <td class="py-4 px-3">
                    <div class="font-medium text-gray-900 dark:text-white max-w-[150px] truncate" title="${item.title}">${item.title}</div>
                </td>
                <td class="py-4 px-3 text-center text-sm">${formatThaiDate(item.news_date)}</td>
                <td class="py-4 px-3 text-center">${imgHtml}</td>
                <td class="py-4 px-3 text-center">${statusBadge}</td>
                <td class="py-4 px-3 text-center">
                    <div class="flex justify-center gap-2">
                        <button class="show-detail-btn w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-600 transition-colors"
                            data-detail="${encodeURIComponent(item.detail)}"
                            data-images='${JSON.stringify(images)}'
                            title="ดูรายละเอียด">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="delete-newsletter-btn w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 transition-colors ${item.status != 0 ? 'opacity-50 cursor-not-allowed' : ''}"
                            data-id="${item.id}"
                            data-status="${item.status}"
                            title="${item.status != 0 ? 'ลบได้เฉพาะฉบับร่าง' : 'ลบ'}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $tbody.append(row);
    });
}

// ==================== Parse Images ====================
function parseImages(imagesStr) {
    let images = [];
    try {
        images = JSON.parse(imagesStr.replace(/\\\//g, '/'));
    } catch {}
    
    // Remove 'teacher/' prefix if exists
    return images.map(src => src.replace(/^teacher\//, ''));
}

// ==================== Status Badge ====================
function getStatusBadge(status) {
    const statusMap = {
        0: { text: 'ฉบับร่าง', class: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' },
        1: { text: 'เผยแพร่', class: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' },
        2: { text: 'เก็บถาวร', class: 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400' }
    };
    
    const s = statusMap[status] || statusMap[0];
    return `<span class="status-badge ${s.class} px-3 py-1 rounded-full text-xs font-semibold">${s.text}</span>`;
}

// ==================== Stats ====================
function updateStats(data) {
    const draft = data.filter(item => item.status == 0).length;
    const published = data.filter(item => item.status == 1).length;
    
    $('#draftCount').text(draft);
    $('#publishedCount').text(published);
    $('#totalCount').text(data.length);
}

// ==================== Show Detail Modal ====================
function showDetailModal() {
    const detail = decodeURIComponent($(this).data('detail'));
    let images = $(this).data('images');
    
    // Parse images if string
    if (typeof images === 'string') {
        try { 
            images = JSON.parse(images.replace(/\\\//g, '/')); 
        } catch { 
            images = []; 
        }
    }
    
    // Remove 'teacher/' prefix
    images = images.map(src => src.replace(/^teacher\//, ''));
    
    // Render images
    const $modalImages = $('#modalImages');
    $modalImages.empty();
    
    if (Array.isArray(images) && images.length > 0) {
        images.forEach(src => {
            $modalImages.append(`
                <img src="../${src}" 
                    class="w-full aspect-square object-cover rounded-xl border-2 border-gray-200 dark:border-gray-600" 
                    alt="img"
                    onerror="this.src='../plugins/fontawesome-free/svgs/regular/image.svg'"
                    onclick="window.open('../${src}', '_blank')">
            `);
        });
    } else {
        $modalImages.html('<p class="col-span-3 text-center text-gray-400">ไม่มีรูปภาพ</p>');
    }
    
    // Render detail
    $('#modalDetail').html(`<p class="whitespace-pre-wrap">${detail}</p>`);
    
    // Show modal
    $('#detailModal').removeClass('hidden').addClass('flex');
}

// ==================== Delete Newsletter ====================
function deleteNewsletter() {
    const id = $(this).data('id');
    const status = $(this).data('status');
    
    // Only allow deletion of draft (status = 0)
    if (status != 0) {
        Swal.fire({
            icon: 'warning',
            title: 'ไม่สามารถลบได้',
            text: 'สามารถลบได้เฉพาะจดหมายข่าวที่เป็นฉบับร่างเท่านั้น',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }
    
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบจดหมายข่าวนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'ลบ',
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
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ! 🗑️',
                        text: 'จดหมายข่าวถูกลบเรียบร้อยแล้ว',
                        confirmButtonColor: '#3b82f6',
                        timer: 2000,
                        timerProgressBar: true
                    });
                    fetchNewsletters();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'ไม่สำเร็จ',
                        text: data.message || 'เกิดข้อผิดพลาด',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// ==================== Utility ====================
function formatThaiDate(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const thaiMonths = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    
    const day = date.getDate();
    const month = thaiMonths[date.getMonth()];
    const year = (date.getFullYear() + 543).toString().slice(-2);
    
    return `${day} ${month} ${year}`;
}
