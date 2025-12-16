<!-- Newsletter Page Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">📰</span> สร้างจดหมายข่าว
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ระบบสร้างและจัดการจดหมายข่าวออนไลน์</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-3">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                ระบบจดหมายข่าว
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="glass rounded-2xl p-5 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ฉบับร่าง</p>
                    <p class="text-3xl font-bold text-yellow-600" id="draftCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                    <i class="fas fa-edit text-2xl text-yellow-500"></i>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">เผยแพร่แล้ว</p>
                    <p class="text-3xl font-bold text-green-600" id="publishedCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-xl">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รวมทั้งหมด</p>
                    <p class="text-3xl font-bold text-blue-600" id="totalCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                    <i class="fas fa-newspaper text-2xl text-blue-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Left: Create Newsletter Form -->
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg text-white">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">📝 สร้างจดหมายข่าวใหม่</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">กรอกข้อมูลเพื่อสร้างข่าวใหม่</p>
                </div>
            </div>

            <form id="newsletterForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-heading mr-2 text-blue-500"></i>หัวข้อข่าว <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                        placeholder="เช่น กิจกรรมวันวิทยาศาสตร์">
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-2 text-green-500"></i>วันที่ <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="news_date" name="news_date" required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-images mr-2 text-purple-500"></i>อัปโหลดรูปภาพ (6-9 รูป) <span class="text-red-500">*</span>
                    </label>
                    <div id="imageInputs" class="space-y-3 max-h-64 overflow-y-auto pr-2">
                        <!-- 6 initial image inputs -->
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                        <div class="image-input-row flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400 w-6"><?php echo $i; ?></span>
                            <input type="file" name="images[]" accept="image/*" required 
                                class="single-image-input flex-1 text-sm text-gray-600 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 dark:file:bg-blue-900/50 dark:file:text-blue-400 hover:file:bg-blue-200 dark:hover:file:bg-blue-900/70 transition-all cursor-pointer" />
                            <img src="" alt="" class="preview-img w-12 h-12 object-cover rounded-lg border-2 border-gray-200 dark:border-gray-600 hidden" />
                            <button type="button" class="remove-image-btn w-8 h-8 flex items-center justify-center bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 rounded-lg transition-colors hidden" title="ลบรูปภาพนี้">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <button type="button" id="addImageInput" class="px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 rounded-xl font-medium transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span>เพิ่มรูปภาพ</span>
                        </button>
                        <span class="text-xs text-gray-400">เลือกได้ 6-9 รูป (.jpg, .jpeg, .png, .gif)</span>
                    </div>
                    <div id="imageInputError" class="text-red-500 text-sm mt-2"></div>
                </div>

                <!-- Detail -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-orange-500"></i>รายละเอียดข่าว <span class="text-red-500">*</span>
                    </label>
                    <textarea id="detail" name="detail" rows="5" required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none" 
                        placeholder="รายละเอียดข่าว..."></textarea>
                </div>

                <!-- Notice -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-600"></i>
                        </div>
                        <p class="text-sm text-yellow-700 dark:text-yellow-400">
                            ข้อมูลจะถูกเจ้าหน้าที่คัดกรองอีกที หากมีปัญหาเจ้าหน้าที่จะติดต่อกลับไป
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>บันทึกข่าว</span>
                    <span>🚀</span>
                </button>
            </form>
        </div>

        <!-- Right: Newsletter List -->
        <div class="glass rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg text-white">
                        <i class="fas fa-list-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 รายการจดหมายข่าว</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">จดหมายข่าวทั้งหมดของคุณ</p>
                    </div>
                </div>
                <button id="refreshList" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table id="newsletterTable" class="w-full text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-700 dark:to-slate-600 text-gray-700 dark:text-gray-200">
                            <th class="py-3 px-3 text-center rounded-tl-xl">#</th>
                            <th class="py-3 px-3 text-left">หัวข้อข่าว</th>
                            <th class="py-3 px-3 text-center">วันที่</th>
                            <th class="py-3 px-3 text-center">รูปภาพ</th>
                            <th class="py-3 px-3 text-center">สถานะ</th>
                            <th class="py-3 px-3 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="newsletterTableBody">
                        <!-- JS render -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span>📰</span> รายละเอียดข่าว
            </h3>
            <button id="closeDetailModal" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-500 dark:text-gray-400 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- Images Gallery -->
            <div id="modalImages" class="grid grid-cols-3 gap-3 mb-6">
                <!-- Images will be inserted here -->
            </div>
            <!-- Detail Text -->
            <div id="modalDetail" class="prose dark:prose-invert max-w-none">
                <!-- Detail will be inserted here -->
            </div>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for image inputs */
#imageInputs::-webkit-scrollbar {
    width: 6px;
}
#imageInputs::-webkit-scrollbar-track {
    background: transparent;
}
#imageInputs::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
.dark #imageInputs::-webkit-scrollbar-thumb {
    background: #475569;
}

/* Table hover effects */
#newsletterTableBody tr {
    transition: all 0.2s ease;
}
#newsletterTableBody tr:hover {
    background: linear-gradient(90deg, rgba(59, 130, 246, 0.05), rgba(147, 51, 234, 0.05));
}

/* Image preview animation */
.preview-img {
    transition: all 0.3s ease;
}
.preview-img:hover {
    transform: scale(1.5);
    z-index: 10;
}

/* Status badge shine */
.status-badge {
    position: relative;
    overflow: hidden;
}
.status-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}
.status-badge:hover::before {
    left: 100%;
}

/* Modal image gallery */
#modalImages img {
    cursor: pointer;
    transition: all 0.3s ease;
}
#modalImages img:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
}
</style>

<!-- Pass PHP variables to JavaScript -->
<script>
    const teacher_id = "<?php echo $teacher_id; ?>";
</script>

<!-- Newsletter Script -->
<script src="views/newsletter/script.js"></script>
