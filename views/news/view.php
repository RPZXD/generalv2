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

<div class="space-y-6 md:space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 p-6 md:p-8 lg:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-white/10 rounded-full blur-3xl -mr-32 md:-mr-48 -mt-32 md:-mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-72 h-48 md:h-72 bg-white/10 rounded-full blur-3xl -ml-24 md:-ml-36 -mb-24 md:-mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative">
            <!-- Breadcrumb -->
            <nav class="mb-4 md:mb-6">
                <ol class="flex flex-wrap items-center gap-1.5 md:gap-2 text-xs md:text-sm text-white/70">
                    <li><a href="index.php" class="hover:text-white transition-colors flex items-center gap-1"><i class="fas fa-home"></i> <span class="hidden sm:inline">หน้าหลัก</span></a></li>
                    <li><i class="fas fa-chevron-right text-[10px] md:text-xs"></i></li>
                    <li><a href="news.php" class="hover:text-white transition-colors">ข่าวประชาสัมพันธ์</a></li>
                    <li><i class="fas fa-chevron-right text-[10px] md:text-xs"></i></li>
                    <li class="text-white font-medium truncate max-w-[150px] md:max-w-xs"><?php echo htmlspecialchars($news['title']); ?></li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 md:gap-6">
                <div class="flex-shrink-0 hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                        <div class="relative w-20 h-20 md:w-24 md:h-24 flex items-center justify-center bg-white/20 backdrop-blur rounded-full">
                            <span class="text-4xl md:text-5xl">📰</span>
                        </div>
                    </div>
                </div>
                <div class="text-white flex-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-xs md:text-sm font-medium mb-3">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        ข่าวประชาสัมพันธ์
                    </div>
                    <h1 class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-bold leading-tight break-words line-clamp-3 md:line-clamp-4 overflow-hidden">
                        <?php echo htmlspecialchars($news['title']); ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Meta Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4 mt-4">
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border-l-4 border-indigo-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl text-lg md:text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-user"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">โดย</p>
                    <p class="text-sm md:text-base font-bold text-gray-900 dark:text-white"><?php echo htmlspecialchars($teacher_name); ?></p>
                </div>
            </div>
        </div>
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border-l-4 border-amber-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-xl text-lg md:text-xl group-hover:scale-110 transition-transform">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">วันที่</p>
                    <p class="text-sm md:text-base font-bold text-gray-900 dark:text-white"><?php echo $date; ?></p>
                </div>
            </div>
        </div>
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-4 border-l-4 border-purple-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-xl text-lg md:text-xl group-hover:scale-110 transition-transform">
                    <i class="far fa-eye"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">อ่านแล้ว</p>
                    <p class="text-sm md:text-base font-bold text-purple-600"><?php echo number_format($views); ?> ครั้ง</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Article Card -->
    <article class="glass rounded-2xl overflow-hidden">
        <!-- Hero Image -->
        <?php if (!empty($images)): ?>
        <div class="relative aspect-[16/9] md:aspect-[21/9] bg-gray-100 dark:bg-slate-700 overflow-hidden cursor-pointer group" onclick="openGallery(0)">
            <img src="<?php echo htmlspecialchars($images[0]); ?>" 
                 alt="<?php echo htmlspecialchars($news['title']); ?>"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 onerror="this.style.display='none'">
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
            <?php if (count($images) > 1): ?>
            <div class="absolute top-3 right-3 md:top-4 md:right-4 px-2.5 py-1 md:px-3 md:py-1.5 bg-black/50 backdrop-blur text-white text-xs md:text-sm rounded-full flex items-center gap-1.5 md:gap-2">
                <i class="fas fa-images"></i> <?php echo count($images); ?> รูป
            </div>
            <?php endif; ?>
            <div class="absolute bottom-3 left-3 md:bottom-4 md:left-4 px-3 py-1.5 bg-white/90 dark:bg-slate-800/90 backdrop-blur text-gray-700 dark:text-gray-300 text-xs md:text-sm rounded-full flex items-center gap-1.5">
                <i class="fas fa-expand"></i> คลิกเพื่อดูภาพขยาย
            </div>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="p-4 md:p-6 lg:p-8">
            <div class="prose prose-sm md:prose-base lg:prose-lg max-w-none dark:prose-invert leading-relaxed">
                <?php echo nl2br(htmlspecialchars($news['detail'] ?? '')); ?>
            </div>
        </div>

        <!-- Image Gallery -->
        <?php if (count($images) > 1): ?>
        <div class="p-4 md:p-6 lg:p-8 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-3 md:mb-4 flex items-center gap-2">
                <span class="text-lg md:text-xl">📷</span> รูปภาพทั้งหมด (<?php echo count($images); ?> รูป)
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
                <?php foreach ($images as $idx => $img): ?>
                <div class="aspect-square rounded-lg md:rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-700 cursor-pointer group active:scale-[0.98] transition-transform" onclick="openGallery(<?php echo $idx; ?>)">
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
        <div class="p-4 md:p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-slate-800/50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 md:gap-4">
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 font-medium">แชร์ข่าวนี้</p>
                <div class="flex items-center gap-2 md:gap-3">
                    <button onclick="shareToFacebook()" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-blue-600 text-white rounded-full hover:bg-blue-700 active:scale-95 transition-all" title="แชร์ Facebook">
                        <i class="fab fa-facebook-f text-sm md:text-base"></i>
                    </button>
                    <button onclick="shareToLine()" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-green-500 text-white rounded-full hover:bg-green-600 active:scale-95 transition-all" title="แชร์ Line">
                        <i class="fab fa-line text-sm md:text-base"></i>
                    </button>
                    <button onclick="copyLink()" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-gray-600 text-white rounded-full hover:bg-gray-700 active:scale-95 transition-all" title="คัดลอกลิงก์">
                        <i class="fas fa-link text-sm md:text-base"></i>
                    </button>
                </div>
            </div>
        </div>
    </article>

    <!-- Back Button -->
    <div class="text-center pb-4">
        <a href="news.php" class="inline-flex items-center gap-2 px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-xl font-medium hover:from-amber-600 hover:to-orange-600 active:scale-[0.98] transition-all shadow-lg hover:shadow-xl text-sm md:text-base">
            <i class="fas fa-arrow-left"></i> กลับไปหน้าข่าวทั้งหมด
        </a>
    </div>
</div>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 bg-black/95 z-50 hidden flex items-center justify-center p-2 md:p-4">
    <button onclick="closeGallery()" class="absolute top-2 right-2 md:top-4 md:right-4 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center text-white/80 hover:text-white text-2xl md:text-3xl z-10 bg-white/10 rounded-full hover:bg-white/20 transition-colors">
        <i class="fas fa-times"></i>
    </button>
    
    <button onclick="prevImage()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white rounded-full transition-colors active:scale-95">
        <i class="fas fa-chevron-left text-lg md:text-xl"></i>
    </button>
    
    <button onclick="nextImage()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white rounded-full transition-colors active:scale-95">
        <i class="fas fa-chevron-right text-lg md:text-xl"></i>
    </button>
    
    <div class="max-w-5xl max-h-[90vh] w-full px-12 md:px-16">
        <img id="galleryImage" src="" alt="" class="max-w-full max-h-[80vh] md:max-h-[85vh] mx-auto rounded-lg shadow-2xl">
        <p id="galleryCaption" class="text-center text-white/80 mt-3 md:mt-4 text-sm md:text-base"></p>
    </div>
</div>

<script>
const images = <?php echo json_encode($images); ?>;
let currentImageIndex = 0;
let galleryTouchStartX = 0;
let galleryTouchEndX = 0;

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

// Swipe gesture for gallery
const galleryModal = document.getElementById('galleryModal');
galleryModal.addEventListener('touchstart', function(e) {
    galleryTouchStartX = e.changedTouches[0].screenX;
}, { passive: true });

galleryModal.addEventListener('touchend', function(e) {
    galleryTouchEndX = e.changedTouches[0].screenX;
    handleGallerySwipe();
}, { passive: true });

function handleGallerySwipe() {
    const swipeThreshold = 50;
    const diff = galleryTouchStartX - galleryTouchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextImage(); // Swipe left = next
        } else {
            prevImage(); // Swipe right = prev
        }
    }
}

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
