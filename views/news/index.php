<!-- News/Newsletter Page Content -->
<div class="space-y-6 md:space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 p-6 md:p-8 lg:p-12">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,transparent,black)]"></div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-white/10 rounded-full blur-3xl -mr-32 md:-mr-48 -mt-32 md:-mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-72 h-48 md:h-72 bg-white/10 rounded-full blur-3xl -ml-24 md:-ml-36 -mb-24 md:-mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-8">
            <div class="flex-shrink-0">
                <div class="relative">
                    <div class="absolute inset-0 bg-white/20 rounded-full blur-xl animate-pulse"></div>
                    <div class="relative w-24 h-24 md:w-32 lg:w-40 md:h-32 lg:h-40 flex items-center justify-center bg-white/20 backdrop-blur rounded-full">
                        <span class="text-5xl md:text-6xl lg:text-7xl">📰</span>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-left text-white">
                <div class="inline-flex items-center gap-2 px-3 md:px-4 py-1.5 md:py-2 rounded-full bg-white/20 backdrop-blur-sm text-xs md:text-sm font-medium mb-3 md:mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    อัพเดทล่าสุด
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 md:mb-3">
                    ข่าวประชาสัมพันธ์
                </h1>
                <p class="text-base md:text-lg lg:text-xl text-white/80">
                    ติดตามข่าวสาร กิจกรรม และความเคลื่อนไหวล่าสุดของโรงเรียน
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-5 border-l-4 border-amber-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-2 md:gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 rounded-xl md:rounded-2xl text-xl md:text-3xl group-hover:scale-110 transition-transform">
                    📋
                </div>
                <div class="min-w-0">
                    <p class="text-lg md:text-2xl font-bold text-gray-900 dark:text-white truncate" id="statTotal">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">ข่าวทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-5 border-l-4 border-emerald-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-2 md:gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-xl md:rounded-2xl text-xl md:text-3xl group-hover:scale-110 transition-transform">
                    🆕
                </div>
                <div class="min-w-0">
                    <p class="text-lg md:text-2xl font-bold text-emerald-600 truncate" id="statRecent">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">เดือนนี้</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-5 border-l-4 border-purple-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-2 md:gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 rounded-xl md:rounded-2xl text-xl md:text-3xl group-hover:scale-110 transition-transform">
                    👁️
                </div>
                <div class="min-w-0">
                    <p class="text-lg md:text-2xl font-bold text-purple-600 truncate" id="statViews">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">ยอดอ่านรวม</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-xl md:rounded-2xl p-3 md:p-5 border-l-4 border-blue-500 hover:shadow-xl transition-all group">
            <div class="flex items-center gap-2 md:gap-4">
                <div class="w-10 h-10 md:w-14 md:h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-xl md:rounded-2xl text-xl md:text-3xl group-hover:scale-110 transition-transform">
                    📅
                </div>
                <div class="min-w-0">
                    <p class="text-lg md:text-2xl font-bold text-blue-600 truncate" id="statYear">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">ปีนี้</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6">
        <div class="flex flex-col gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-xl md:text-2xl">🔍</span> ค้นหาและกรองข่าว
            </h2>
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="ค้นหาข่าว..." 
                           class="w-full pl-10 md:pl-12 pr-4 py-2.5 md:py-3 rounded-lg md:rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all text-sm md:text-base">
                </div>
                <select id="sortBy" class="px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-amber-500 focus:border-transparent cursor-pointer text-sm md:text-base">
                    <option value="newest">🕐 ใหม่ล่าสุด</option>
                    <option value="oldest">🕐 เก่าที่สุด</option>
                    <option value="popular">🔥 ยอดนิยม</option>
                </select>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500 rounded-lg md:rounded-xl text-white text-lg md:text-xl">
                    📰
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รายการข่าว</h2>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400" id="newsResultText">กำลังโหลด...</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6">
            <!-- Loading -->
            <div id="loading" class="text-center py-8 md:py-12">
                <div class="inline-block w-10 h-10 md:w-12 md:h-12 border-4 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500 dark:text-gray-400">กำลังโหลดข่าวสาร...</p>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-8 md:py-12">
                <div class="text-5xl md:text-6xl mb-4">📭</div>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">ยังไม่มีข่าวประชาสัมพันธ์</p>
            </div>

            <!-- News Grid -->
            <div id="newsGrid" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                <!-- News cards will be inserted here -->
            </div>

            <!-- Load More -->
            <div id="loadMoreContainer" class="hidden text-center mt-6 md:mt-8">
                <button id="loadMoreBtn" onclick="loadMore()" class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg md:rounded-xl font-medium hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 text-sm md:text-base">
                    <i class="fas fa-plus"></i> โหลดเพิ่มเติม
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let allNews = [];
let filteredNews = [];
let displayCount = 12;
const perPage = 12;

$(document).ready(function() {
    loadNews();
    
    $('#searchInput').on('input', debounce(filterAndRender, 300));
    $('#sortBy').on('change', filterAndRender);
});

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function loadNews() {
    $.ajax({
        url: 'api/public_newsletter_list.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            allNews = response.list || [];
            
            if (allNews.length === 0) {
                $('#emptyState').removeClass('hidden');
                $('#newsResultText').text('ไม่มีข่าว');
                return;
            }
            
            updateStats();
            filterAndRender();
        },
        error: function() {
            $('#loading').addClass('hidden');
            $('#emptyState').removeClass('hidden')
                .html('<div class="text-6xl mb-4">❌</div><p class="text-gray-500 dark:text-gray-400">ไม่สามารถโหลดข่าวสารได้</p>');
        }
    });
}

function updateStats() {
    const now = new Date();
    const thisMonth = now.getMonth();
    const thisYear = now.getFullYear();
    
    const thisMonthCount = allNews.filter(n => {
        const date = new Date(n.news_date || n.created_at);
        return date.getMonth() === thisMonth && date.getFullYear() === thisYear;
    }).length;
    
    const thisYearCount = allNews.filter(n => {
        const date = new Date(n.news_date || n.created_at);
        return date.getFullYear() === thisYear;
    }).length;
    
    const totalViews = allNews.reduce((sum, n) => sum + (parseInt(n.view_count) || 0), 0);
    
    $('#statTotal').text(allNews.length.toLocaleString());
    $('#statRecent').text(thisMonthCount.toLocaleString());
    $('#statViews').text(totalViews.toLocaleString());
    $('#statYear').text(thisYearCount.toLocaleString());
}

function filterAndRender() {
    const searchTerm = $('#searchInput').val().toLowerCase();
    const sortBy = $('#sortBy').val();
    
    // Filter
    filteredNews = allNews.filter(n => {
        const title = (n.title || '').toLowerCase();
        const detail = (n.detail || '').toLowerCase();
        return title.includes(searchTerm) || detail.includes(searchTerm);
    });
    
    // Sort
    filteredNews.sort((a, b) => {
        if (sortBy === 'newest') {
            return new Date(b.news_date || b.created_at) - new Date(a.news_date || a.created_at);
        } else if (sortBy === 'oldest') {
            return new Date(a.news_date || a.created_at) - new Date(b.news_date || b.created_at);
        } else if (sortBy === 'popular') {
            return (parseInt(b.view_count) || 0) - (parseInt(a.view_count) || 0);
        }
        return 0;
    });
    
    displayCount = perPage;
    render();
}

function render() {
    if (filteredNews.length === 0) {
        $('#newsGrid').addClass('hidden');
        $('#emptyState').removeClass('hidden').html('<div class="text-6xl mb-4">🔍</div><p class="text-gray-500 dark:text-gray-400">ไม่พบข่าวที่ค้นหา</p>');
        $('#loadMoreContainer').addClass('hidden');
        $('#newsResultText').text('ไม่พบข่าว');
        return;
    }
    
    $('#emptyState').addClass('hidden');
    $('#newsResultText').text(`พบ ${filteredNews.length} ข่าว`);
    
    const newsToShow = filteredNews.slice(0, displayCount);
    let html = '';
    
    const colors = [
        'from-cyan-500 to-blue-500',
        'from-purple-500 to-pink-500',
        'from-emerald-500 to-teal-500',
        'from-amber-500 to-orange-500',
        'from-rose-500 to-red-500',
        'from-indigo-500 to-violet-500'
    ];
    
    newsToShow.forEach((n, index) => {
        const imagePath = getFirstImage(n.images);
        const date = formatDate(n.news_date || n.created_at);
        const views = parseInt(n.view_count) || 0;
        const colorClass = colors[index % colors.length];
        
        html += `
        <a href="newsletter_view.php?id=${n.id}" class="group bg-white dark:bg-slate-700 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
            <div class="aspect-[4/3] bg-gray-100 dark:bg-slate-600 overflow-hidden relative">
                ${imagePath ? `
                    <img src="${imagePath}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                         onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}\\'><span class=\\'text-5xl\\'>📰</span></div>'">
                ` : `
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}">
                        <span class="text-5xl">📰</span>
                    </div>
                `}
                <div class="absolute top-3 right-3 px-2.5 py-1 bg-black/50 backdrop-blur text-white text-xs rounded-full flex items-center gap-1">
                    <i class="far fa-eye"></i> ${views.toLocaleString()}
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            <div class="p-4">
                <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 min-h-[3rem]">${escapeHtml(n.title || 'ไม่มีชื่อ')}</h3>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <i class="far fa-calendar-alt"></i> ${date}
                    </span>
                    <span class="text-amber-600 dark:text-amber-400 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                        อ่านต่อ <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </div>
            </div>
        </a>
        `;
    });
    
    $('#newsGrid').html(html).removeClass('hidden');
    
    // Show/hide load more button
    if (displayCount < filteredNews.length) {
        $('#loadMoreContainer').removeClass('hidden');
    } else {
        $('#loadMoreContainer').addClass('hidden');
    }
}

function loadMore() {
    displayCount += perPage;
    render();
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
    const months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>
