<!-- Newsletter Management - Modern UI with Tailwind CSS -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">📰</span> จัดการจดหมายข่าว
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">รวบรวมและจัดการจดหมายข่าวทั้งหมด</p>
        </div>
        <div class="flex gap-2">
            <button id="refreshData" class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-sky-500 text-white rounded-xl font-medium hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> รีเฟรช
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-4 border-l-4 border-cyan-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-cyan-100 dark:bg-cyan-900/30 rounded-xl text-2xl group-hover:scale-110 transition-transform">📋</div>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="statTotal">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-emerald-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-2xl group-hover:scale-110 transition-transform">📅</div>
                <div>
                    <p class="text-2xl font-bold text-emerald-600" id="statThisMonth">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">เดือนนี้</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-purple-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 rounded-xl text-2xl group-hover:scale-110 transition-transform">👥</div>
                <div>
                    <p class="text-2xl font-bold text-purple-600" id="statAuthors">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">ผู้เขียน</p>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-4 border-l-4 border-amber-500 hover:shadow-lg transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 flex items-center justify-center bg-amber-100 dark:bg-amber-900/30 rounded-xl text-2xl group-hover:scale-110 transition-transform">🆕</div>
                <div>
                    <p class="text-2xl font-bold text-amber-600" id="statRecent">0</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">7 วันล่าสุด</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="glass rounded-2xl p-2">
        <div class="flex flex-wrap gap-2">
            <button class="tab-btn active px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="grid">
                <span class="text-lg">🖼️</span> แบบการ์ด
            </button>
            <button class="tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="list">
                <span class="text-lg">📋</span> แบบรายการ
            </button>
            <button class="tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="timeline">
                <span class="text-lg">📅</span> Timeline
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="glass rounded-2xl p-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="ค้นหาจดหมายข่าว..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all">
            </div>
            <select id="sortBy" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                <option value="newest">🕐 ใหม่ล่าสุด</option>
                <option value="oldest">🕐 เก่าที่สุด</option>
                <option value="title">🔤 ชื่อ A-Z</option>
            </select>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tabContent">
        <!-- Grid Tab -->
        <div id="tab-grid" class="tab-pane">
            <div class="glass rounded-2xl p-6">
                <div id="newsletterGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <div class="col-span-full text-center py-12 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลดข้อมูล...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- List Tab -->
        <div id="tab-list" class="tab-pane hidden">
            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-cyan-500 to-sky-500 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">รูปภาพ</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">หัวข้อ</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">วันที่</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">ผู้เขียน</th>
                                <th class="px-6 py-4 text-center text-sm font-semibold">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="newsletterTable" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td colspan="6" class="text-center py-12 text-gray-400">
                                    <div class="loader mx-auto mb-4"></div>
                                    <p>กำลังโหลดข้อมูล...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Timeline Tab -->
        <div id="tab-timeline" class="tab-pane hidden">
            <div class="glass rounded-2xl p-6">
                <div id="newsletterTimeline" class="relative">
                    <div class="col-span-full text-center py-12 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลดข้อมูล...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="relative max-w-4xl max-h-[90vh] mx-4 animate-scale-in">
        <button onclick="closePreviewModal()" class="absolute -top-4 -right-4 w-10 h-10 rounded-full bg-white dark:bg-slate-800 shadow-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-600 dark:text-gray-300 flex items-center justify-center transition-colors z-10">
            <i class="fas fa-times"></i>
        </button>
        <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain">
        <div id="previewInfo" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 rounded-b-2xl">
            <h3 id="previewTitle" class="text-xl font-bold text-white mb-1"></h3>
            <p id="previewDate" class="text-sm text-gray-300"></p>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <div class="sticky top-0 bg-gradient-to-r from-cyan-600 to-sky-600 p-6 rounded-t-2xl">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="text-xl font-bold text-white flex items-center gap-2" id="detailTitle">
                <span class="text-2xl">📰</span> รายละเอียดจดหมายข่าว
            </h3>
        </div>
        <div class="p-6" id="detailContent">
            <!-- Content will be loaded here -->
        </div>
        <div class="p-6 pt-0 flex gap-3" id="detailActions">
            <!-- Actions will be loaded here -->
        </div>
    </div>
</div>

<style>
/* Loader */
.loader {
    width: 48px;
    height: 48px;
    border: 4px solid #e5e7eb;
    border-top-color: #06b6d4;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Scale In Animation */
@keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.animate-scale-in { animation: scale-in 0.2s ease-out; }

/* Tab Styles */
.tab-btn {
    background: transparent;
    color: #6b7280;
}
.tab-btn:hover {
    background: rgba(6, 182, 212, 0.1);
    color: #06b6d4;
}
.tab-btn.active {
    background: linear-gradient(135deg, #06b6d4, #0ea5e9);
    color: white;
    box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
}
.dark .tab-btn {
    color: #9ca3af;
}
.dark .tab-btn:hover {
    color: #06b6d4;
}

/* Card Hover Effect */
.newsletter-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.newsletter-card:hover {
    transform: translateY(-8px);
}
.newsletter-card:hover .card-image {
    transform: scale(1.05);
}
.card-image {
    transition: transform 0.5s ease;
}

/* Timeline */
.timeline-line {
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #06b6d4, #0ea5e9);
}
.timeline-item {
    position: relative;
    padding-left: 50px;
    padding-bottom: 30px;
}
.timeline-item:last-child {
    padding-bottom: 0;
}
.timeline-dot {
    position: absolute;
    left: 12px;
    top: 0;
    width: 18px;
    height: 18px;
    background: linear-gradient(135deg, #06b6d4, #0ea5e9);
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
}
.dark .timeline-dot {
    border-color: #1e293b;
}

/* Table Row Hover */
.table-row {
    transition: all 0.2s ease;
}
.table-row:hover {
    background: rgba(6, 182, 212, 0.05);
}
.dark .table-row:hover {
    background: rgba(6, 182, 212, 0.1);
}

/* Custom Scrollbar */
::-webkit-scrollbar { width: 6px; height: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #06b6d4; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #0891b2; }

/* Gradient Text */
.text-gradient {
    background: linear-gradient(135deg, #06b6d4, #0ea5e9);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<script>
let allNewsletters = [];
let filteredNewsletters = [];
let currentTab = 'grid';

// Helper function to parse images JSON and get first image path
function getFirstImage(imagesData) {
    if (!imagesData) return null;
    try {
        // ถ้าเป็น JSON string ให้ parse ก่อน
        if (typeof imagesData === 'string') {
            // ตรวจสอบว่าเป็น JSON array หรือไม่
            if (imagesData.startsWith('[')) {
                const images = JSON.parse(imagesData);
                return images.length > 0 ? images[0] : null;
            }
            // ถ้าเป็น string ธรรมดา (path เดียว)
            return imagesData;
        }
        // ถ้าเป็น array อยู่แล้ว
        if (Array.isArray(imagesData)) {
            return imagesData.length > 0 ? imagesData[0] : null;
        }
        return null;
    } catch (e) {
        console.error('Error parsing images:', e);
        return null;
    }
}

// Helper function to get all images as array
function getAllImages(imagesData) {
    if (!imagesData) return [];
    try {
        if (typeof imagesData === 'string') {
            if (imagesData.startsWith('[')) {
                return JSON.parse(imagesData);
            }
            return [imagesData];
        }
        if (Array.isArray(imagesData)) {
            return imagesData;
        }
        return [];
    } catch (e) {
        console.error('Error parsing images:', e);
        return [];
    }
}

$(document).ready(function() {
    fetchNewsletters();
    setupEventHandlers();
});

function setupEventHandlers() {
    // Tab switching
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        switchTab(tab);
    });

    // Search
    $('#searchInput').on('input', debounce(function() {
        filterAndRender();
    }, 300));

    // Sort
    $('#sortBy').on('change', function() {
        filterAndRender();
    });

    // Refresh
    $('#refreshData').on('click', function() {
        $(this).find('i').addClass('animate-spin');
        fetchNewsletters().then(() => {
            setTimeout(() => $(this).find('i').removeClass('animate-spin'), 500);
        });
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function fetchNewsletters() {
    return $.ajax({
        url: 'api/newsletter_list.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            showLoading();
        },
        success: function(response) {
            allNewsletters = response.list || [];
            updateStats();
            filterAndRender();
        },
        error: function() {
            showError();
        }
    });
}

function showLoading() {
    const loadingHtml = '<div class="col-span-full text-center py-12"><div class="loader mx-auto mb-4"></div><p class="text-gray-400">กำลังโหลดข้อมูล...</p></div>';
    $('#newsletterGrid').html(loadingHtml);
    $('#newsletterTable').html('<tr><td colspan="6" class="text-center py-12 text-gray-400">' + loadingHtml + '</td></tr>');
    $('#newsletterTimeline').html(loadingHtml);
}

function showError() {
    const errorHtml = '<div class="col-span-full text-center py-12 text-red-500"><i class="fas fa-exclamation-circle text-5xl mb-4"></i><p>เกิดข้อผิดพลาดในการโหลดข้อมูล</p></div>';
    $('#newsletterGrid').html(errorHtml);
    $('#newsletterTable').html('<tr><td colspan="6">' + errorHtml + '</td></tr>');
    $('#newsletterTimeline').html(errorHtml);
}

function updateStats() {
    const now = new Date();
    const thisMonth = now.getMonth();
    const thisYear = now.getFullYear();
    const sevenDaysAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
    
    const thisMonthCount = allNewsletters.filter(n => {
        const date = new Date(n.news_date || n.created_at);
        return date.getMonth() === thisMonth && date.getFullYear() === thisYear;
    }).length;
    
    const recentCount = allNewsletters.filter(n => {
        const date = new Date(n.news_date || n.created_at);
        return date >= sevenDaysAgo;
    }).length;
    
    const authors = [...new Set(allNewsletters.map(n => n.create_by).filter(Boolean))].length;
    
    $('#statTotal').text(allNewsletters.length);
    $('#statThisMonth').text(thisMonthCount);
    $('#statAuthors').text(authors);
    $('#statRecent').text(recentCount);
}

function filterAndRender() {
    const searchTerm = $('#searchInput').val().toLowerCase();
    const sortBy = $('#sortBy').val();
    
    // Filter
    filteredNewsletters = allNewsletters.filter(n => {
        const title = (n.title || '').toLowerCase();
        const author = (n.teacher_name || '').toLowerCase();
        return title.includes(searchTerm) || author.includes(searchTerm);
    });
    
    // Sort
    filteredNewsletters.sort((a, b) => {
        if (sortBy === 'newest') {
            return new Date(b.news_date || b.created_at) - new Date(a.news_date || a.created_at);
        } else if (sortBy === 'oldest') {
            return new Date(a.news_date || a.created_at) - new Date(b.news_date || b.created_at);
        } else if (sortBy === 'title') {
            return (a.title || '').localeCompare(b.title || '');
        }
        return 0;
    });
    
    renderGrid();
    renderList();
    renderTimeline();
}

function renderGrid() {
    if (filteredNewsletters.length === 0) {
        $('#newsletterGrid').html('<div class="col-span-full text-center py-12"><div class="text-6xl mb-4">📭</div><p class="text-gray-500 dark:text-gray-400">ไม่พบจดหมายข่าว</p></div>');
        return;
    }
    
    let html = '';
    filteredNewsletters.forEach((n, index) => {
        const imagePath = getFirstImage(n.images) || n.file_path;
        const date = formatDate(n.news_date || n.created_at);
        const colors = ['from-cyan-500 to-sky-500', 'from-purple-500 to-pink-500', 'from-emerald-500 to-teal-500', 'from-amber-500 to-orange-500'];
        const colorClass = colors[index % colors.length];
        
        html += `
        <div class="newsletter-card bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden group">
            <div class="aspect-[4/3] bg-gray-100 dark:bg-slate-700 overflow-hidden relative cursor-pointer" onclick="openPreview(${n.id})">
                ${imagePath ? `
                    <img src="../${imagePath}" class="card-image w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}\\'><span class=\\'text-6xl\\'>📰</span></div>'">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                        <div class="opacity-0 group-hover:opacity-100 transition-all transform scale-50 group-hover:scale-100">
                            <div class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center text-cyan-600">
                                <i class="fas fa-search-plus text-xl"></i>
                            </div>
                        </div>
                    </div>
                ` : `
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br ${colorClass}">
                        <span class="text-6xl">📰</span>
                    </div>
                `}
            </div>
            <div class="p-5">
                <h3 class="font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 min-h-[3rem]">${escapeHtml(n.title || 'ไม่มีชื่อ')}</h3>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <span class="text-cyan-500">📅</span>
                    <span>${date}</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <span class="text-cyan-500">👤</span>
                    <span class="truncate">${escapeHtml(n.teacher_name || 'ไม่ระบุ')}</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="showDetail(${n.id})" class="flex-1 px-4 py-2.5 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-400 rounded-xl text-sm font-medium hover:bg-cyan-200 dark:hover:bg-cyan-900/50 transition-colors">
                        <i class="fas fa-eye mr-1"></i> ดู
                    </button>
                    <button onclick="exportNewsletter(${n.id})" class="px-4 py-2.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm font-medium hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors" title="Export/พิมพ์">
                        <i class="fas fa-print"></i>
                    </button>
                    <button onclick="deleteNewsletter(${n.id})" class="px-4 py-2.5 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-xl text-sm font-medium hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#newsletterGrid').html(html);
}

function renderList() {
    if (filteredNewsletters.length === 0) {
        $('#newsletterTable').html('<tr><td colspan="6" class="text-center py-12"><div class="text-6xl mb-4">📭</div><p class="text-gray-500">ไม่พบจดหมายข่าว</p></td></tr>');
        return;
    }
    
    let html = '';
    filteredNewsletters.forEach((n, index) => {
        const imagePath = getFirstImage(n.images) || n.file_path;
        const date = formatDate(n.news_date || n.created_at);
        
        html += `
        <tr class="table-row bg-white dark:bg-slate-800">
            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">${index + 1}</td>
            <td class="px-6 py-4">
                <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 dark:bg-slate-700 cursor-pointer" onclick="openPreview(${n.id})">
                    ${imagePath ? `
                        <img src="../${imagePath}" class="w-full h-full object-cover hover:scale-110 transition-transform" onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center text-gray-400\\'><i class=\\'fas fa-newspaper\\'></i></div>'">
                    ` : `
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    `}
                </div>
            </td>
            <td class="px-6 py-4">
                <p class="font-medium text-gray-900 dark:text-white truncate max-w-xs">${escapeHtml(n.title || 'ไม่มีชื่อ')}</p>
            </td>
            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">${date}</td>
            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">${escapeHtml(n.teacher_name || '-')}</td>
            <td class="px-6 py-4">
                <div class="flex justify-center gap-2">
                    <button onclick="showDetail(${n.id})" class="p-2 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-lg hover:bg-cyan-200 dark:hover:bg-cyan-900/50 transition-colors" title="ดูรายละเอียด">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="exportNewsletter(${n.id})" class="p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors" title="Export/พิมพ์">
                        <i class="fas fa-print"></i>
                    </button>
                    <button onclick="deleteNewsletter(${n.id})" class="p-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" title="ลบ">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
        `;
    });
    
    $('#newsletterTable').html(html);
}

function renderTimeline() {
    if (filteredNewsletters.length === 0) {
        $('#newsletterTimeline').html('<div class="text-center py-12"><div class="text-6xl mb-4">📭</div><p class="text-gray-500">ไม่พบจดหมายข่าว</p></div>');
        return;
    }
    
    let html = '<div class="timeline-line"></div>';
    
    filteredNewsletters.forEach((n, index) => {
        const imagePath = getFirstImage(n.images) || n.file_path;
        const date = formatDate(n.news_date || n.created_at);
        const fullDate = formatFullDate(n.news_date || n.created_at);
        
        html += `
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition-all">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-48 h-32 md:h-auto bg-gray-100 dark:bg-slate-700 overflow-hidden cursor-pointer" onclick="openPreview(${n.id})">
                        ${imagePath ? `
                            <img src="../${imagePath}" class="w-full h-full object-cover hover:scale-105 transition-transform" onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center\\'><i class=\\'fas fa-newspaper text-4xl text-gray-400\\'></i></div>'">
                        ` : `
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-newspaper text-4xl text-gray-400"></i>
                            </div>
                        `}
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white mb-1">${escapeHtml(n.title || 'ไม่มีชื่อ')}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">${fullDate}</p>
                            </div>
                            <span class="px-3 py-1 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-400 text-xs rounded-full font-medium">
                                #${index + 1}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span><i class="fas fa-user mr-1 text-cyan-500"></i> ${escapeHtml(n.teacher_name || 'ไม่ระบุ')}</span>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <button onclick="showDetail(${n.id})" class="px-4 py-2 bg-cyan-500 text-white rounded-xl text-sm font-medium hover:bg-cyan-600 transition-colors">
                                <i class="fas fa-eye mr-1"></i> ดูรายละเอียด
                            </button>
                            <button onclick="exportNewsletter(${n.id})" class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-sm font-medium hover:bg-emerald-600 transition-colors">
                                <i class="fas fa-print mr-1"></i> Export
                            </button>
                            <button onclick="deleteNewsletter(${n.id})" class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm font-medium hover:bg-red-600 transition-colors">
                                <i class="fas fa-trash mr-1"></i> ลบ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#newsletterTimeline').html(html);
}

function switchTab(tab) {
    currentTab = tab;
    $('.tab-btn').removeClass('active');
    $(`.tab-btn[data-tab="${tab}"]`).addClass('active');
    $('.tab-pane').addClass('hidden');
    $(`#tab-${tab}`).removeClass('hidden');
}

function openPreview(id) {
    const newsletter = allNewsletters.find(n => n.id == id);
    if (!newsletter) return;
    
    const imagePath = getFirstImage(newsletter.images) || newsletter.file_path;
    if (!imagePath) return;
    
    const title = newsletter.title || 'ไม่มีชื่อ';
    const date = formatDate(newsletter.news_date || newsletter.created_at);
    
    $('#previewImage').attr('src', `../${imagePath}`);
    $('#previewTitle').text(title);
    $('#previewDate').text(date);
    $('#previewModal').removeClass('hidden');
}

function closePreviewModal() {
    $('#previewModal').addClass('hidden');
}

function showImagePreview(imagePath) {
    if (!imagePath) return;
    $('#previewImage').attr('src', `../${imagePath}`);
    $('#previewTitle').text('รูปภาพจดหมายข่าว');
    $('#previewDate').text('');
    $('#previewModal').removeClass('hidden');
}

function showDetail(id) {
    const newsletter = allNewsletters.find(n => n.id == id);
    if (!newsletter) return;
    
    const allImages = getAllImages(newsletter.images);
    const firstImage = allImages.length > 0 ? allImages[0] : newsletter.file_path;
    const date = formatFullDate(newsletter.news_date || newsletter.created_at);
    
    // สร้าง gallery ถ้ามีหลายรูป
    let imagesHtml = '';
    if (allImages.length > 0) {
        imagesHtml = `
            <div class="grid grid-cols-${Math.min(allImages.length, 3)} gap-2">
                ${allImages.map((img, idx) => `
                    <div class="rounded-xl overflow-hidden cursor-pointer aspect-video bg-gray-100 dark:bg-slate-700" onclick="showImagePreview('${img}')">
                        <img src="../${img}" class="w-full h-full object-cover hover:scale-105 transition-transform" onerror="this.style.display='none'">
                    </div>
                `).join('')}
            </div>
        `;
    }
    
    $('#detailTitle').html(`<span class="text-2xl mr-2">📰</span> ${escapeHtml(newsletter.title || 'ไม่มีชื่อ')}`);
    
    $('#detailContent').html(`
        <div class="space-y-4">
            ${imagesHtml}
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">📅 วันที่</p>
                    <p class="font-medium text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                    <p class="text-xs text-gray-500 mb-1">👤 ผู้เขียน</p>
                    <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(newsletter.teacher_name || 'ไม่ระบุ')}</p>
                </div>
            </div>
            
            ${newsletter.detail ? `
            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                <p class="text-xs text-gray-500 mb-1">📝 รายละเอียด</p>
                <p class="text-gray-900 dark:text-white whitespace-pre-wrap">${escapeHtml(newsletter.detail)}</p>
            </div>
            ` : ''}
        </div>
    `);
    
    $('#detailActions').html(`
        <button onclick="exportNewsletter(${newsletter.id})" class="flex-1 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-print"></i> Export/พิมพ์
        </button>
        <button onclick="deleteNewsletter(${newsletter.id}); closeDetailModal();" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition-colors flex items-center justify-center gap-2">
            <i class="fas fa-trash"></i> ลบจดหมายข่าว
        </button>
    `);
    
    $('#detailModal').removeClass('hidden');
}

function closeDetailModal() {
    $('#detailModal').addClass('hidden');
}

function deleteNewsletter(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'ต้องการลบจดหมายข่าวนี้หรือไม่ การลบจะไม่สามารถกู้คืนได้',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'api/newsletter_delete.php',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ!',
                            text: 'จดหมายข่าวถูกลบเรียบร้อยแล้ว',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        fetchNewsletters();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด',
                            text: response.message || 'ไม่สามารถลบได้'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ'
                    });
                }
            });
        }
    });
}

// Helper Functions
function formatDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    return date.toLocaleDateString('th-TH', { day: 'numeric', month: 'short', year: '2-digit' });
}

function formatFullDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    return date.toLocaleDateString('th-TH', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Export Newsletter Function
function exportNewsletter(id) {
    window.open(`newsletter_export.php?id=${id}`, '_blank');
}

// Close modals on outside click
$('#previewModal').on('click', function(e) {
    if (e.target === this) closePreviewModal();
});

$('#detailModal').on('click', function(e) {
    if (e.target === this) closeDetailModal();
});

// Keyboard shortcuts
$(document).on('keydown', function(e) {
    if (e.key === 'Escape') {
        closePreviewModal();
        closeDetailModal();
    }
});
</script>
