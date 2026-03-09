<!-- Home Page Content -->
<div class="space-y-8">
    <!-- Hero Section with Animated Background -->
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-8 md:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -mr-48 -mt-48 animate-pulse">
        </div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl -ml-36 -mb-36 animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="relative flex flex-col lg:flex-row items-center gap-8">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                    <img src="dist/img/<?php echo $global['logoLink'] ?? 'logo-phicha.png'; ?>"
                        alt="<?php echo $global['nameschool']; ?> Logo"
                        class="relative w-32 h-32 md:w-40 md:h-40 rounded-full shadow-2xl border-4 border-white/30 hover:scale-110 transition-transform duration-500">
                </div>
            </div>
            <div class="text-center lg:text-left text-white">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    ระบบพร้อมใช้งาน
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-3">
                    ระบบบริหารงานทั่วไป
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-6">
                    <?php echo $global['nameschool']; ?>
                </p>
                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    <span
                        class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>📋</span> แจ้งซ่อม
                    </span>
                    <span
                        class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>🏢</span> จองห้องประชุม
                    </span>
                    <span
                        class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-2">
                        <span>📰</span> ข่าวประชาสัมพันธ์
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-5 border-l-4 border-blue-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    🔧
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statRepair">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">แจ้งซ่อม</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-purple-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    🏢
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statRoom">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">จองห้อง</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-amber-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 rounded-2xl text-3xl group-hover:scale-110 transition-transform">
                    📰
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statNews">-</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">ข่าวสาร</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- แจ้งซ่อม -->
        <a href="teacher/repair_request.php" class="group">
            <div
                class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-400 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-tools text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">แจ้งซ่อม</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">แจ้งปัญหาและติดตามสถานะการซ่อมแซม</p>
                    <div class="flex items-center text-blue-600 dark:text-blue-400 font-medium text-sm">
                        เข้าใช้งาน
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- จองห้องประชุม -->
        <a href="teacher/room_booking.php" class="group">
            <div
                class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-door-open text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">จองห้องประชุม</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">ตรวจสอบและจองห้องประชุมได้สะดวก</p>
                    <div class="flex items-center text-purple-600 dark:text-purple-400 font-medium text-sm">
                        เข้าใช้งาน
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- ข่าวประชาสัมพันธ์ -->
        <a href="news.php" class="group">
            <div
                class="glass rounded-2xl p-6 h-full relative overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500 to-orange-500 opacity-20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500">
                </div>
                <div class="relative">
                    <div
                        class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl shadow-lg text-white mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-newspaper text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">ข่าวประชาสัมพันธ์</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">ติดตามข่าวสารและกิจกรรมล่าสุด</p>
                    <div class="flex items-center text-amber-600 dark:text-amber-400 font-medium text-sm">
                        ดูข่าวทั้งหมด
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Newsletter Section -->
    <div class="glass rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl text-white text-xl">
                        📰
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">ข่าวประชาสัมพันธ์ล่าสุด</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">อัพเดทข่าวสารและกิจกรรมล่าสุด</p>
                    </div>
                </div>
                <a href="news.php"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-xl font-medium hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors">
                    ดูทั้งหมด <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="p-6">
            <div id="newsletterLoading" class="text-center py-12">
                <div
                    class="inline-block w-12 h-12 border-4 border-amber-500 border-t-transparent rounded-full animate-spin">
                </div>
                <p class="mt-4 text-gray-500 dark:text-gray-400">กำลังโหลดข่าวสาร...</p>
            </div>

            <div id="newsletterEmpty" class="hidden text-center py-12">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 dark:text-gray-400">ยังไม่มีข่าวประชาสัมพันธ์</p>
            </div>

            <div id="newsletterGrid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Newsletter cards will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <span class="text-2xl">⚡</span> เข้าสู่ระบบเพื่อใช้งาน
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="login.php"
                class="group p-5 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-white/20 backdrop-blur rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-sign-in-alt text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">เข้าสู่ระบบ</h4>
                        <p class="text-sm text-white/80">สำหรับบุคลากร</p>
                    </div>
                </div>
            </a>

            <a href="officer/"
                class="group p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-shield text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">เจ้าหน้าที่</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Officer Portal</p>
                    </div>
                </div>
            </a>

            <a href="teacher/"
                class="group p-5 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl group-hover:scale-110 transition-transform">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">ครู/บุคลากร</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Teacher Portal</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="glass rounded-2xl p-6 text-center">
        <div class="text-4xl mb-3">🎓</div>
        <p class="text-gray-600 dark:text-gray-400 font-medium"><?php echo $global['nameschool']; ?></p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">General Management System v2.0</p>
    </div>
</div>

<!-- Newsletter Preview Modal -->
<div id="previewModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closePreviewModal()"></div>
    <div class="absolute inset-4 md:inset-10 flex items-center justify-center">
        <div class="relative max-w-4xl w-full max-h-full overflow-auto">
            <button onclick="closePreviewModal()"
                class="absolute -top-4 -right-4 z-10 w-10 h-10 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-2xl">
                <img id="previewImage" src="" alt="Preview"
                    class="w-full h-auto max-h-[70vh] object-contain bg-gray-100 dark:bg-slate-700">
                <div class="p-6">
                    <h3 id="previewTitle" class="text-xl font-bold text-gray-900 dark:text-white mb-2"></h3>
                    <p id="previewDate" class="text-gray-500 dark:text-gray-400"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-grid-white\/10 {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgba(255,255,255,0.1)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

<script>
    $(document).ready(function () {
        loadNewsletters();
        loadStats();
    });

    function loadStats() {
        // Load stats from public API
        $.ajax({
            url: 'api/public_stats.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.stats) {
                    $('#statRepair').text(response.stats.repair.toLocaleString());
                    $('#statRoom').text(response.stats.room.toLocaleString());
                    $('#statNews').text(response.stats.news.toLocaleString());
                }
            },
            error: function () {
                $('#statRepair').text('0');
                $('#statRoom').text('0');
                $('#statNews').text('0');
            }
        });
    }

    function loadNewsletters() {
        $.ajax({
            url: 'api/public_newsletter_list.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#newsletterLoading').addClass('hidden');

                const newsletters = response.list || [];

                if (newsletters.length === 0) {
                    $('#newsletterEmpty').removeClass('hidden');
                    return;
                }

                // Show only latest 6 newsletters
                const latestNews = newsletters.slice(0, 6);
                let html = '';

                latestNews.forEach((n, index) => {
                    const imagePath = getFirstImage(n.images);
                    const date = formatDate(n.news_date || n.created_at);
                    const colors = [
                        'from-cyan-500 to-blue-500',
                        'from-purple-500 to-pink-500',
                        'from-emerald-500 to-teal-500',
                        'from-amber-500 to-orange-500',
                        'from-rose-500 to-red-500',
                        'from-indigo-500 to-violet-500'
                    ];
                    const colorClass = colors[index % colors.length];

                    html += `
                <div class="group bg-white dark:bg-slate-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="aspect-[4/3] bg-gray-100 dark:bg-slate-600 overflow-hidden relative cursor-pointer" onclick="openPreview('${imagePath}', '${escapeHtml(n.title || 'ไม่มีชื่อ')}', '${date}')">
                        ${imagePath ? `
                            <img src="${imagePath}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}\\'><span class=\\'text-5xl\\'>\ud83d\udcf0</span></div>'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-3 left-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-white/90 dark:bg-slate-800/90 rounded-full text-xs font-medium text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-search-plus"></i> ดูภาพขยาย
                                </span>
                            </div>
                        ` : `
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}">
                                <span class="text-5xl">📰</span>
                            </div>
                        `}
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 min-h-[3rem]">${escapeHtml(n.title || 'ไม่มีชื่อ')}</h3>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <i class="far fa-calendar-alt"></i> ${date}
                            </span>
                            <a href="newsletter_view.php?id=${n.id}" class="text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300 transition-colors">
                                อ่านเพิ่มเติม <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                `;
                });

                $('#newsletterGrid').html(html).removeClass('hidden');
            },
            error: function () {
                $('#newsletterLoading').addClass('hidden');
                $('#newsletterEmpty').removeClass('hidden').html('<div class="text-6xl mb-4">❌</div><p class="text-gray-500 dark:text-gray-400">ไม่สามารถโหลดข่าวสารได้</p>');
            }
        });
    }

    function getFirstImage(imagesData) {
        if (!imagesData) return null;
        try {
            if (typeof imagesData === 'string') {
                if (imagesData.startsWith('[')) {
                    const images = JSON.parse(imagesData);
                    return images.length > 0 ? images[0] : null;
                }
                return imagesData;
            }
            if (Array.isArray(imagesData)) {
                return imagesData.length > 0 ? imagesData[0] : null;
            }
            return null;
        } catch (e) {
            return null;
        }
    }

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('th-TH', options);
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function openPreview(imagePath, title, date) {
        if (!imagePath) return;
        $('#previewImage').attr('src', imagePath);
        $('#previewTitle').text(title);
        $('#previewDate').text(date);
        $('#previewModal').removeClass('hidden');
    }

    function closePreviewModal() {
        $('#previewModal').addClass('hidden');
    }

    // Close modal on escape key
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            closePreviewModal();
        }
    });
</script>