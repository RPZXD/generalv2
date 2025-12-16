<!-- Newsletter View Page Content -->
<?php
// รูปภาพ
$images = [];
try { 
    $images = json_decode($news['images'], true); 
} catch (\Throwable $e) {}
if (!is_array($images)) $images = [];

// Format date
function thai_date_full_view($date_str) {
    $months = [
        "", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
    ];
    $time = strtotime($date_str);
    $day = date('j', $time);
    $month = $months[(int)date('n', $time)];
    $year = date('Y', $time) + 543;
    return "$day $month $year";
}

$date = isset($news['news_date']) ? thai_date_full_view($news['news_date']) : '';
$views = isset($news['view_count']) ? intval($news['view_count']) : 0;
?>

<div class="space-y-8">
    <!-- Breadcrumb -->
    <nav class="glass rounded-xl p-4">
        <ol class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <li><a href="index.php" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors flex items-center gap-1"><i class="fas fa-home"></i> หน้าหลัก</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li><a href="news.php" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">ข่าวประชาสัมพันธ์</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-900 dark:text-white font-medium truncate max-w-xs"><?php echo htmlspecialchars($news['title']); ?></li>
        </ol>
    </nav>

    <!-- Article Card -->
    <article class="glass rounded-2xl overflow-hidden">
        <!-- Hero Image -->
        <?php if (!empty($images)): ?>
        <div class="relative aspect-[21/9] bg-gray-100 dark:bg-slate-700 overflow-hidden cursor-pointer" onclick="openGallery(0)">
            <img src="<?php echo htmlspecialchars($images[0]); ?>" 
                 alt="<?php echo htmlspecialchars($news['title']); ?>"
                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                 onerror="this.style.display='none'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"><?php echo htmlspecialchars($news['title']); ?></h1>
            </div>
            <?php if (count($images) > 1): ?>
            <div class="absolute top-4 right-4 px-3 py-1.5 bg-black/50 backdrop-blur text-white text-sm rounded-full flex items-center gap-2">
                <i class="fas fa-images"></i> <?php echo count($images); ?> รูป
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-500 to-orange-500">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white"><?php echo htmlspecialchars($news['title']); ?></h1>
        </div>
        <?php endif; ?>

        <!-- Meta Info -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50">
            <div class="flex flex-wrap items-center gap-6 text-sm">
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <div class="w-10 h-10 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-500">โดย</p>
                        <p class="font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($teacher_name); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <div class="w-10 h-10 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-full">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-500">วันที่</p>
                        <p class="font-medium text-gray-900 dark:text-white"><?php echo $date; ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <div class="w-10 h-10 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-full">
                        <i class="far fa-eye"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-500">อ่านแล้ว</p>
                        <p class="font-medium text-gray-900 dark:text-white"><?php echo number_format($views); ?> ครั้ง</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 md:p-8">
            <div class="prose prose-lg max-w-none dark:prose-invert">
                <?php echo nl2br(htmlspecialchars($news['detail'] ?? '')); ?>
            </div>
        </div>

        <!-- Image Gallery -->
        <?php if (count($images) > 1): ?>
        <div class="p-6 md:p-8 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="text-xl">📷</span> รูปภาพทั้งหมด (<?php echo count($images); ?> รูป)
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($images as $idx => $img): ?>
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-700 cursor-pointer group" onclick="openGallery(<?php echo $idx; ?>)">
                    <img src="<?php echo htmlspecialchars($img); ?>" 
                         alt="รูปที่ <?php echo $idx + 1; ?>"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                         onerror="this.parentElement.style.display='none'">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Share & Actions -->
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-gray-600 dark:text-gray-400 font-medium">แชร์ข่าวนี้</p>
                <div class="flex items-center gap-3">
                    <button onclick="shareToFacebook()" class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors" title="แชร์ Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button onclick="shareToLine()" class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors" title="แชร์ Line">
                        <i class="fab fa-line"></i>
                    </button>
                    <button onclick="copyLink()" class="w-10 h-10 flex items-center justify-center bg-gray-600 text-white rounded-full hover:bg-gray-700 transition-colors" title="คัดลอกลิงก์">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </article>

    <!-- Back Button -->
    <div class="text-center">
        <a href="news.php" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-medium hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
            <i class="fas fa-arrow-left"></i> กลับไปหน้าข่าวทั้งหมด
        </a>
    </div>
</div>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4">
    <button onclick="closeGallery()" class="absolute top-4 right-4 w-12 h-12 flex items-center justify-center text-white/80 hover:text-white text-3xl z-10">
        <i class="fas fa-times"></i>
    </button>
    
    <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white rounded-full transition-colors">
        <i class="fas fa-chevron-left text-xl"></i>
    </button>
    
    <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white rounded-full transition-colors">
        <i class="fas fa-chevron-right text-xl"></i>
    </button>
    
    <div class="max-w-5xl max-h-[90vh] w-full">
        <img id="galleryImage" src="" alt="" class="max-w-full max-h-[85vh] mx-auto rounded-lg shadow-2xl">
        <p id="galleryCaption" class="text-center text-white/80 mt-4"></p>
    </div>
</div>

<script>
const images = <?php echo json_encode($images); ?>;
let currentImageIndex = 0;

function openGallery(index) {
    currentImageIndex = index;
    updateGalleryImage();
    document.getElementById('galleryModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeGallery() {
    document.getElementById('galleryModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function updateGalleryImage() {
    if (images.length === 0) return;
    document.getElementById('galleryImage').src = images[currentImageIndex];
    document.getElementById('galleryCaption').textContent = `รูปที่ ${currentImageIndex + 1} / ${images.length}`;
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateGalleryImage();
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateGalleryImage();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('galleryModal').classList.contains('hidden')) {
        if (e.key === 'Escape') closeGallery();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    }
});

// Share functions
function shareToFacebook() {
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`, '_blank', 'width=600,height=400');
}

function shareToLine() {
    window.open(`https://social-plugins.line.me/lineit/share?url=${encodeURIComponent(window.location.href)}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'คัดลอกลิงก์แล้ว!',
            text: 'ลิงก์ถูกคัดลอกไปยังคลิปบอร์ด',
            timer: 2000,
            showConfirmButton: false
        });
    });
}
</script>
