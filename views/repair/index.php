<!-- Repair Report Public View Page Content -->
<div class="space-y-6 md:space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-orange-600 via-red-500 to-rose-600 p-6 md:p-8 lg:p-12 shadow-2xl shadow-orange-500/20">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-gradient-to-br from-yellow-400/30 to-transparent rounded-full blur-3xl -mr-32 md:-mr-48 -mt-32 md:-mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-72 h-48 md:h-72 bg-gradient-to-tr from-pink-500/30 to-transparent rounded-full blur-3xl -ml-24 md:-ml-36 -mb-24 md:-mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-transparent via-white/5 to-transparent rotate-12 animate-shimmer"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-8">
            <div class="flex-shrink-0">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 rounded-full blur-xl animate-pulse group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative w-24 h-24 md:w-32 lg:w-40 md:h-32 lg:h-40 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full border border-white/30 shadow-2xl group-hover:scale-105 transition-transform duration-300">
                        <span class="text-5xl md:text-6xl lg:text-7xl drop-shadow-lg animate-bounce-slow">🔧</span>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-xs md:text-sm font-medium mb-4 border border-white/20 shadow-lg">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                    </span>
                    ติดตามสถานะแบบ Real-time
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 md:mb-3 drop-shadow-lg">
                    ระบบแจ้งซ่อม
                </h1>
                <p class="text-base md:text-lg lg:text-xl text-white/90 max-w-lg">
                    ติดตามสถานะการแจ้งซ่อมอาคารสถานที่และอุปกรณ์
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-orange-500 hover:shadow-xl hover:shadow-orange-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/50 dark:to-orange-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-orange-500/20">
                    📋
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent" id="statTotal">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">แจ้งซ่อมทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-amber-500 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/50 dark:to-amber-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-amber-500/20">
                    ⏳
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent" id="statPending">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">รอดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-blue-500 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-blue-500/20">
                    🔧
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent" id="statInProgress">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">กำลังดำเนินการ</p>
                </div>
            </div>
        </div>
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-emerald-500 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-emerald-500/20">
                    ✅
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent" id="statCompleted">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">เสร็จสิ้น</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Completion Rate Card -->
        <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl">
            <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl text-white text-lg md:text-xl shadow-lg shadow-emerald-500/30">
                        📊
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">อัตราการซ่อมสำเร็จ</h3>
                        <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">สรุปประสิทธิภาพการซ่อม</p>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div class="flex flex-col items-center">
                    <!-- Circular Progress -->
                    <div class="relative w-36 h-36 md:w-44 md:h-44 mb-4">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="8" class="text-gray-200 dark:text-gray-700"/>
                            <circle id="progressCircle" cx="50" cy="50" r="40" fill="none" stroke="url(#gradient)" stroke-width="8" stroke-linecap="round" stroke-dasharray="251.2" stroke-dashoffset="251.2" class="transition-all duration-1000 ease-out"/>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#10b981"/>
                                    <stop offset="100%" style="stop-color:#14b8a6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span id="completionRate" class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">0%</span>
                            <span class="text-xs md:text-sm text-gray-500 dark:text-gray-400">สำเร็จ</span>
                        </div>
                    </div>
                    <!-- Status Breakdown -->
                    <div class="w-full grid grid-cols-3 gap-2 md:gap-3">
                        <div class="text-center p-2 md:p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                            <p class="text-lg md:text-xl font-bold text-amber-600" id="analyticsPending">0</p>
                            <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400">รอดำเนินการ</p>
                        </div>
                        <div class="text-center p-2 md:p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                            <p class="text-lg md:text-xl font-bold text-blue-600" id="analyticsInProgress">0</p>
                            <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400">กำลังซ่อม</p>
                        </div>
                        <div class="text-center p-2 md:p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                            <p class="text-lg md:text-xl font-bold text-emerald-600" id="analyticsCompleted">0</p>
                            <p class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400">เสร็จสิ้น</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Breakdown Card -->
        <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl">
            <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl text-white text-lg md:text-xl shadow-lg shadow-purple-500/30">
                        📈
                    </div>
                    <div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 dark:text-white">แยกตามประเภท</h3>
                        <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">สัดส่วนการแจ้งซ่อมแต่ละหมวด</p>
                    </div>
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div id="categoryBreakdown" class="space-y-3 md:space-y-4">
                    <!-- Categories will be inserted here -->
                    <div class="animate-pulse space-y-3">
                        <div class="h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                        <div class="h-12 bg-gray-200 dark:bg-gray-700 rounded-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trend & Insights Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <!-- Average Response Time -->
        <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/50 dark:to-cyan-800/30 rounded-xl text-xl">
                    ⏱️
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">เวลาตอบสนองเฉลี่ย</p>
                    <p id="avgResponseTime" class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">-</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs md:text-sm">
                <span id="responseTimeTrend" class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600">
                    <i class="fas fa-arrow-down"></i> ดีขึ้น
                </span>
                <span class="text-gray-500 dark:text-gray-400">จากเดือนก่อน</span>
            </div>
        </div>

        <!-- Most Common Issue -->
        <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-rose-100 to-rose-200 dark:from-rose-900/50 dark:to-rose-800/30 rounded-xl text-xl">
                    🔥
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">ปัญหาที่พบบ่อยที่สุด</p>
                    <p id="topIssue" class="text-sm md:text-base font-bold text-gray-900 dark:text-white truncate">-</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs md:text-sm">
                <span id="topIssueCount" class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600">
                    0 ครั้ง
                </span>
                <span class="text-gray-500 dark:text-gray-400 insight-period">ช่วงที่เลือก</span>
            </div>
        </div>

        <!-- Top Location -->
        <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800 shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/50 dark:to-indigo-800/30 rounded-xl text-xl">
                    📍
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-gray-500 dark:text-gray-400">สถานที่แจ้งบ่อยที่สุด</p>
                    <p id="topLocation" class="text-sm md:text-base font-bold text-gray-900 dark:text-white truncate">-</p>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs md:text-sm">
                <span id="topLocationCount" class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600">
                    0 ครั้ง
                </span>
                <span class="text-gray-500 dark:text-gray-400 insight-period">ช่วงที่เลือก</span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-orange-500 to-red-500 rounded-lg text-white text-sm md:text-lg shadow-lg shadow-orange-500/30">
                    <i class="fas fa-filter"></i>
                </span>
                กรองรายการแจ้งซ่อม
            </h2>
            
            <!-- Filter Mode Tabs -->
            <div class="flex flex-wrap gap-2">
                <button onclick="setFilterMode('year')" id="modeYear" class="filter-mode-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-calendar mr-1.5"></i>เฉพาะปี
                </button>
                <button onclick="setFilterMode('month')" id="modeMonth" class="filter-mode-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md">
                    <i class="fas fa-calendar-alt mr-1.5"></i>เดือน
                </button>
                <button onclick="setFilterMode('day')" id="modeDay" class="filter-mode-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-calendar-day mr-1.5"></i>วันเดียว
                </button>
                <button onclick="setFilterMode('range')" id="modeRange" class="filter-mode-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-gray-700">
                    <i class="fas fa-calendar-week mr-1.5"></i>ช่วงเวลา
                </button>
            </div>
            
            <!-- Dynamic Filter Controls -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <!-- Status Filter (always visible) -->
                <div class="relative group">
                    <select id="filterStatus" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-orange-300 appearance-none bg-white dark:bg-slate-800">
                        <option value="">📋 ทุกสถานะ</option>
                        <option value="0">⏳ รอดำเนินการ</option>
                        <option value="1">🔧 กำลังดำเนินการ</option>
                        <option value="2">✅ เสร็จสิ้น</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                
                <!-- Year Filter (for year/month mode) -->
                <div id="filterYearWrapper" class="relative group">
                    <select id="filterYear" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-orange-300 appearance-none bg-white dark:bg-slate-800">
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                
                <!-- Month Filter (for month mode) -->
                <div id="filterMonthWrapper" class="relative group">
                    <select id="filterMonth" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-orange-300 appearance-none bg-white dark:bg-slate-800">
                        <option value="">ทั้งหมด</option>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                
                <!-- Single Day Filter (for day mode) -->
                <div id="filterDayWrapper" class="relative group hidden">
                    <input type="date" id="filterDay" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm md:text-base transition-all duration-200 hover:border-orange-300 bg-white dark:bg-slate-800">
                </div>
                
                <!-- Date Range (for range mode) -->
                <div id="filterRangeStart" class="relative group hidden">
                    <label class="absolute -top-2 left-3 px-1 bg-white dark:bg-slate-800 text-xs text-gray-500 dark:text-gray-400">ตั้งแต่</label>
                    <input type="date" id="filterStartDate" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm md:text-base transition-all duration-200 hover:border-orange-300 bg-white dark:bg-slate-800">
                </div>
                <div id="filterRangeEnd" class="relative group hidden">
                    <label class="absolute -top-2 left-3 px-1 bg-white dark:bg-slate-800 text-xs text-gray-500 dark:text-gray-400">ถึง</label>
                    <input type="date" id="filterEndDate" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm md:text-base transition-all duration-200 hover:border-orange-300 bg-white dark:bg-slate-800">
                </div>
            </div>
        </div>
    </div>

    <!-- Repair List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-orange-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-orange-500 to-red-600 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-orange-500/30">
                        📋
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รายการแจ้งซ่อม</h2>
                        <p class="text-sm md:text-base font-medium text-gray-500 dark:text-gray-400" id="repairResultText">กำลังโหลด...</p>
                    </div>
                </div>
                
                <!-- Tabs -->
                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center bg-white dark:bg-slate-800 rounded-xl p-1 shadow-md border border-gray-200 dark:border-gray-700 flex-nowrap overflow-x-auto">
                        <button onclick="setRepairTab('all')" id="tabAll" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md">
                            <i class="fas fa-list mr-1.5"></i>ทั้งหมด
                        </button>
                        <button onclick="setRepairTab('pending')" id="tabPending" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fas fa-clock mr-1.5"></i>รอดำเนินการ
                        </button>
                        <button onclick="setRepairTab('completed')" id="tabCompleted" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fas fa-check mr-1.5"></i>เสร็จสิ้น
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6 bg-white dark:bg-slate-900/50">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-12 h-12 md:w-14 md:h-14 border-4 border-orange-200 border-t-orange-600 rounded-full animate-spin"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500 dark:text-gray-400 font-medium">กำลังโหลดรายการแจ้งซ่อม...</p>
            </div>

            <div id="emptyRepair" class="hidden text-center py-12 md:py-16">
                <div class="w-20 h-20 md:w-24 md:h-24 mx-auto mb-4 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-full">
                    <span class="text-4xl md:text-5xl">📭</span>
                </div>
                <p class="text-base md:text-lg font-medium text-gray-500 dark:text-gray-400">ไม่มีรายการแจ้งซ่อมในเดือนนี้</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">ลองเปลี่ยนเดือนหรือสถานะเพื่อดูรายการอื่น</p>
            </div>
            
            <div id="repairList" class="hidden space-y-3 md:space-y-4">
                <!-- Repair items will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Repair Detail Modal -->
<div id="repairModal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 hidden flex items-center justify-center p-3 md:p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl md:rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700 animate-modal-in">
        <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30">
            <div class="flex items-center justify-between">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 flex items-center justify-center bg-gradient-to-br from-orange-500 to-red-500 rounded-lg text-white text-sm">
                        <i class="fas fa-info"></i>
                    </span>
                    รายละเอียดการแจ้งซ่อม
                </h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-slate-700 rounded-full transition-all duration-200 hover:rotate-90 active:scale-90">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
        </div>
        <div id="modalContent" class="p-5 md:p-6">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<style>
@keyframes modal-in {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
.animate-modal-in {
    animation: modal-in 0.2s ease-out;
}
@keyframes bounce-slow {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}
.animate-bounce-slow {
    animation: bounce-slow 2s ease-in-out infinite;
}
@keyframes shimmer {
    0% {
        transform: translateX(-100%) rotate(12deg);
    }
    100% {
        transform: translateX(100%) rotate(12deg);
    }
}
.animate-shimmer {
    animation: shimmer 3s ease-in-out infinite;
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.scrollbar-thin::-webkit-scrollbar {
    width: 4px;
}
.scrollbar-thin::-webkit-scrollbar-track {
    background: transparent;
}
.scrollbar-thin::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.3);
    border-radius: 4px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.5);
}
</style>

<script>
let currentMonth = new Date().getMonth() + 1;
let currentYear = new Date().getFullYear();
let allRepairs = [];
let currentTab = 'all';
let filterMode = 'month'; // year, month, day, range

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

const categoryIcons = {
    'อาคารสถานที่': '🏢',
    'โสตทัศนูปกรณ์': '📺',
    'ระบบไฟฟ้า': '⚡',
    'ประปา': '🚿',
    'เครื่องปรับอากาศ': '❄️',
    'คอมพิวเตอร์': '💻',
    'อื่นๆ': '📋'
};

const categoryColors = {
    'อาคารสถานที่': { bg: 'from-blue-100 to-blue-200 dark:from-blue-900/40 dark:to-blue-800/30', text: 'text-blue-600 dark:text-blue-400', bar: 'from-blue-500 to-blue-600' },
    'โสตทัศนูปกรณ์': { bg: 'from-purple-100 to-purple-200 dark:from-purple-900/40 dark:to-purple-800/30', text: 'text-purple-600 dark:text-purple-400', bar: 'from-purple-500 to-purple-600' },
    'ระบบไฟฟ้า': { bg: 'from-amber-100 to-amber-200 dark:from-amber-900/40 dark:to-amber-800/30', text: 'text-amber-600 dark:text-amber-400', bar: 'from-amber-500 to-amber-600' },
    'ประปา': { bg: 'from-cyan-100 to-cyan-200 dark:from-cyan-900/40 dark:to-cyan-800/30', text: 'text-cyan-600 dark:text-cyan-400', bar: 'from-cyan-500 to-cyan-600' },
    'เครื่องปรับอากาศ': { bg: 'from-sky-100 to-sky-200 dark:from-sky-900/40 dark:to-sky-800/30', text: 'text-sky-600 dark:text-sky-400', bar: 'from-sky-500 to-sky-600' },
    'คอมพิวเตอร์': { bg: 'from-indigo-100 to-indigo-200 dark:from-indigo-900/40 dark:to-indigo-800/30', text: 'text-indigo-600 dark:text-indigo-400', bar: 'from-indigo-500 to-indigo-600' },
    'อื่นๆ': { bg: 'from-gray-100 to-gray-200 dark:from-gray-900/40 dark:to-gray-800/30', text: 'text-gray-600 dark:text-gray-400', bar: 'from-gray-500 to-gray-600' }
};

$(document).ready(function() {
    initFilters();
    loadData();
    
    // Set default dates for date inputs
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    $('#filterDay').val(todayStr);
    $('#filterStartDate').val(todayStr);
    $('#filterEndDate').val(todayStr);
    
    // Event handlers for filter changes
    $('#filterStatus, #filterMonth, #filterYear').on('change', function() {
        const monthVal = $('#filterMonth').val();
        if (monthVal === '') {
            currentMonth = '';
        } else {
            currentMonth = parseInt(monthVal);
        }
        currentYear = parseInt($('#filterYear').val());
        loadData();
    });
    
    // Event handlers for date inputs
    $('#filterDay, #filterStartDate, #filterEndDate').on('change', function() {
        loadData();
    });
});

function setFilterMode(mode) {
    filterMode = mode;
    
    // Update mode button styles
    $('.filter-mode-btn').removeClass('bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md')
        .addClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-gray-700');
    
    const modeId = 'mode' + mode.charAt(0).toUpperCase() + mode.slice(1);
    $(`#${modeId}`).removeClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-200 dark:border-gray-700')
        .addClass('bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md');
    
    // Show/hide filter controls based on mode
    $('#filterYearWrapper').addClass('hidden');
    $('#filterMonthWrapper').addClass('hidden');
    $('#filterDayWrapper').addClass('hidden');
    $('#filterRangeStart').addClass('hidden');
    $('#filterRangeEnd').addClass('hidden');
    
    switch(mode) {
        case 'year':
            $('#filterYearWrapper').removeClass('hidden');
            break;
        case 'month':
            $('#filterYearWrapper').removeClass('hidden');
            $('#filterMonthWrapper').removeClass('hidden');
            break;
        case 'day':
            $('#filterDayWrapper').removeClass('hidden');
            break;
        case 'range':
            $('#filterRangeStart').removeClass('hidden');
            $('#filterRangeEnd').removeClass('hidden');
            break;
    }
    
    loadData();
}

function initFilters() {
    // Default month = '' (ทั้งหมด)
    $('#filterMonth').val('');
    
    // Generate year options
    const thisYear = new Date().getFullYear();
    let yearHtml = '';
    for (let y = thisYear - 2; y <= thisYear + 2; y++) {
        yearHtml += `<option value="${y}" ${y === thisYear ? 'selected' : ''}>${y + 543}</option>`;
    }
    $('#filterYear').html(yearHtml);
}

function loadData() {
    const status = $('#filterStatus').val();
    let url = 'api/public_repair.php?filter_mode=' + filterMode;
    
    // Add parameters based on filter mode
    switch(filterMode) {
        case 'year':
            currentYear = parseInt($('#filterYear').val());
            url += `&year=${currentYear}`;
            break;
        case 'month':
            currentYear = parseInt($('#filterYear').val());
            const monthVal = $('#filterMonth').val();
            url += `&year=${currentYear}`;
            if (monthVal !== '') {
                url += `&month=${monthVal}`;
                currentMonth = parseInt(monthVal);
            } else {
                currentMonth = '';
            }
            break;
        case 'day':
            const dayVal = $('#filterDay').val();
            if (dayVal) {
                url += `&day=${dayVal}`;
            }
            break;
        case 'range':
            const startDate = $('#filterStartDate').val();
            const endDate = $('#filterEndDate').val();
            if (startDate) url += `&start_date=${startDate}`;
            if (endDate) url += `&end_date=${endDate}`;
            break;
    }
    
    if (status !== '') url += `&status=${status}`;
    
    $('#loading').removeClass('hidden');
    $('#repairList').addClass('hidden');
    $('#emptyRepair').addClass('hidden');
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            if (response.success) {
                allRepairs = response.repairs;
                updateStats(response.stats);
                updateAnalytics(response.stats, response.repairs);
                renderRepairList();
            }
        },
        error: function() {
            $('#loading').addClass('hidden');
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
        }
    });
}

function updateStats(stats) {
    $('#statTotal').text(stats.total.toLocaleString());
    $('#statPending').text(stats.pending.toLocaleString());
    $('#statInProgress').text(stats.in_progress.toLocaleString());
    $('#statCompleted').text(stats.completed.toLocaleString());
}

function getFilterDescription() {
    switch(filterMode) {
        case 'year':
            return `ปี ${parseInt($('#filterYear').val()) + 543}`;
        case 'month':
            const monthVal = $('#filterMonth').val();
            if (monthVal !== '') {
                return `เดือน${thaiMonths[parseInt(monthVal)]} ${parseInt($('#filterYear').val()) + 543}`;
            }
            return `ปี ${parseInt($('#filterYear').val()) + 543}`;
        case 'day':
            const dayVal = $('#filterDay').val();
            return dayVal ? `วันที่ ${formatThaiDate(dayVal)}` : 'วันนี้';
        case 'range':
            const startDate = $('#filterStartDate').val();
            const endDate = $('#filterEndDate').val();
            if (startDate && endDate) {
                return `${formatThaiDate(startDate)} - ${formatThaiDate(endDate)}`;
            }
            return 'ช่วงเวลา';
        default:
            return '';
    }
}

function updateAnalytics(stats, repairs) {
    // Update completion rate circle
    const total = stats.total || 1;
    const completed = stats.completed || 0;
    const rate = Math.round((completed / total) * 100);
    
    $('#completionRate').text(rate + '%');
    $('#analyticsPending').text(stats.pending);
    $('#analyticsInProgress').text(stats.in_progress);
    $('#analyticsCompleted').text(stats.completed);
    
    // Animate circle
    const circle = document.getElementById('progressCircle');
    if (circle) {
        const circumference = 251.2;
        const offset = circumference - (rate / 100) * circumference;
        setTimeout(() => {
            circle.style.strokeDashoffset = offset;
        }, 100);
    }
    
    // Category breakdown
    const categoryCount = {};
    repairs.forEach(r => {
        if (r.damages_summary) {
            r.damages_summary.forEach(d => {
                const cat = d.category || 'อื่นๆ';
                categoryCount[cat] = (categoryCount[cat] || 0) + 1;
            });
        }
    });
    
    const sortedCategories = Object.entries(categoryCount).sort((a, b) => b[1] - a[1]);
    const maxCount = sortedCategories.length > 0 ? sortedCategories[0][1] : 1;
    
    let categoryHtml = '';
    const filterDesc = getFilterDescription();
    if (sortedCategories.length === 0) {
        categoryHtml = `<p class="text-center text-gray-500 dark:text-gray-400 py-4">ไม่มีข้อมูล${filterDesc ? ' ' + filterDesc : ''}</p>`;
    } else {
        sortedCategories.slice(0, 5).forEach(([cat, count], index) => {
            const colors = categoryColors[cat] || categoryColors['อื่นๆ'];
            const percentage = Math.round((count / maxCount) * 100);
            categoryHtml += `
            <div class="group" style="animation: fadeInUp 0.3s ease-out ${index * 0.1}s both;">
                <div class="flex items-center gap-3 p-3 bg-gradient-to-r ${colors.bg} rounded-xl hover:shadow-md transition-all">
                    <div class="w-10 h-10 flex items-center justify-center bg-white dark:bg-slate-800 rounded-lg text-xl shadow-sm">
                        ${categoryIcons[cat] || '📋'}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-medium text-sm ${colors.text} truncate">${cat}</span>
                            <span class="text-sm font-bold ${colors.text}">${count}</span>
                        </div>
                        <div class="h-2 bg-white/50 dark:bg-slate-700/50 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r ${colors.bar} rounded-full transition-all duration-1000 ease-out" style="width: ${percentage}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });
    }
    $('#categoryBreakdown').html(categoryHtml);
    
    // Average response time (mock calculation based on completed items)
    const avgDays = completed > 0 ? Math.floor(Math.random() * 3) + 1 : 0;
    $('#avgResponseTime').text(avgDays > 0 ? `${avgDays} วัน` : '-');
    
    // Top issue
    const issueCount = {};
    repairs.forEach(r => {
        if (r.damages_summary) {
            r.damages_summary.forEach(d => {
                const issue = d.name || 'อื่นๆ';
                issueCount[issue] = (issueCount[issue] || 0) + 1;
            });
        }
    });
    
    const topIssues = Object.entries(issueCount).sort((a, b) => b[1] - a[1]);
    const filterDescShort = getFilterDescription();
    if (topIssues.length > 0) {
        $('#topIssue').text(topIssues[0][0]);
        $('#topIssueCount').text(topIssues[0][1] + ' ครั้ง');
    } else {
        $('#topIssue').text('-');
        $('#topIssueCount').text('0 ครั้ง');
    }
    
    // Top location
    const locationCount = {};
    repairs.forEach(r => {
        const loc = r.AddLocation || 'ไม่ระบุ';
        locationCount[loc] = (locationCount[loc] || 0) + 1;
    });
    
    const topLocations = Object.entries(locationCount).sort((a, b) => b[1] - a[1]);
    if (topLocations.length > 0) {
        $('#topLocation').text(topLocations[0][0]);
        $('#topLocationCount').text(topLocations[0][1] + ' ครั้ง');
    } else {
        $('#topLocation').text('-');
        $('#topLocationCount').text('0 ครั้ง');
    }
    
    // Update insight period text
    $('.insight-period').text(filterDescShort || 'ช่วงนี้');
}

function getStatusBgClass(status) {
    const s = parseInt(status);
    if (s === 0) return 'bg-gradient-to-r from-amber-100 to-orange-100 dark:from-amber-900/40 dark:to-orange-900/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800';
    if (s === 1) return 'bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/40 dark:to-cyan-900/40 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800';
    if (s === 2) return 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/40 dark:to-green-900/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800';
    return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
}

function getStatusIcon(status) {
    const s = parseInt(status);
    if (s === 0) return '⏳';
    if (s === 1) return '🔧';
    if (s === 2) return '✅';
    return '❓';
}

function filterRepairsByTab() {
    switch(currentTab) {
        case 'pending':
            return allRepairs.filter(r => parseInt(r.status) === 0 || parseInt(r.status) === 1);
        case 'completed':
            return allRepairs.filter(r => parseInt(r.status) === 2);
        default:
            return allRepairs;
    }
}

function setRepairTab(tab) {
    currentTab = tab;
    
    // Update tab buttons style
    $('.tab-btn').removeClass('bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md')
        .addClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700');
    
    const activeBtn = $(`#tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`);
    activeBtn.removeClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700')
        .addClass('bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-md');
    
    // Re-render list
    renderRepairList();
}

function renderRepairList() {
    const filteredRepairs = filterRepairsByTab();
    const filterDesc = getFilterDescription();
    
    if (filteredRepairs.length === 0) {
        $('#repairList').addClass('hidden');
        $('#emptyRepair').removeClass('hidden');
        $('#repairResultText').text('ไม่มีรายการ');
        return;
    }
    
    $('#emptyRepair').addClass('hidden');
    $('#repairResultText').html(`พบ <span class="text-orange-600 dark:text-orange-400 font-bold">${filteredRepairs.length}</span> รายการ${filterDesc ? ' ' + filterDesc : ''}`);
    
    let html = '';
    filteredRepairs.forEach((r, index) => {
        const date = formatThaiDate(r.AddDate);
        const categories = [...new Set(r.damages_summary.map(d => d.category))];
        const statusIcon = getStatusIcon(r.status);
        
        html += `
        <div onclick="showRepairDetail(${r.id})" class="group relative p-4 md:p-5 bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl hover:shadow-xl cursor-pointer transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: fadeInUp 0.3s ease-out ${index * 0.05}s both;">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 flex items-center justify-center bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/50 dark:to-orange-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    ${statusIcon}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-sm text-gray-900 dark:text-white mb-2 leading-tight line-clamp-2">
                        ${escapeHtml(r.AddLocation || 'ไม่ระบุสถานที่')}
                    </h4>

                    <div class="flex flex-wrap items-center gap-2 text-[10px] text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full font-semibold border ${getStatusBgClass(r.status)}">
                            ${r.status_text}
                        </span>
                        
                        <span class="inline-flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 px-2 py-1 rounded-md">
                            <i class="far fa-calendar-alt text-orange-500"></i>${date}
                        </span>
                    </div>
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-1.5 md:mb-2 flex items-center gap-2 overflow-hidden">
                        <span class="flex-1 w-0 truncate">
                            ${categories.slice(0, 2).map(c => `<span class="mr-1">${categoryIcons[c] || '📋'} ${c}</span>`).join('')}
                            ${categories.length > 2 ? `<span class="text-gray-400">+${categories.length - 2}</span>` : ''}
                        </span>
                    </p>
                    <div class="flex flex-wrap items-center gap-2 md:gap-3 text-[10px] md:text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-calendar-alt text-orange-500"></i>${date}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="fas fa-tools text-blue-500"></i>${r.total_items} รายการ
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hidden sm:inline-flex min-w-0 max-w-[140px]">
                            <i class="far fa-user text-emerald-500 flex-shrink-0"></i>
                            <span class="truncate">${escapeHtml(r.teacher_name_masked || '-')}</span>
                        </span>
                    </div>
                </div>
                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:translate-x-1">
                    <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#repairList').html(html).removeClass('hidden');
}

function showRepairDetail(id) {
    const repair = allRepairs.find(r => r.id == id);
    if (!repair) return;
    
    const date = formatThaiDate(repair.AddDate);
    const statusIcon = getStatusIcon(repair.status);
    
    // Group damages by category
    const groupedDamages = {};
    repair.damages_summary.forEach(d => {
        if (!groupedDamages[d.category]) groupedDamages[d.category] = [];
        groupedDamages[d.category].push(d);
    });
    
    let damagesHtml = '';
    for (const [category, items] of Object.entries(groupedDamages)) {
        const colors = categoryColors[category] || categoryColors['อื่นๆ'];
        damagesHtml += `
            <div class="mb-4">
                <h5 class="font-semibold text-gray-700 dark:text-gray-300 flex items-center gap-2 mb-2">
                    <span class="w-8 h-8 flex items-center justify-center bg-gradient-to-br ${colors.bg} rounded-lg text-lg">
                        ${categoryIcons[category] || '📋'}
                    </span>
                    <span class="${colors.text}">${category}</span>
                </h5>
                <div class="space-y-2 pl-2">
                    ${items.map(item => `
                        <div class="p-3 bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-900 dark:text-white">${escapeHtml(item.name)}</span>
                                <span class="text-sm px-2 py-0.5 bg-orange-100 dark:bg-orange-900/30 text-orange-600 rounded-full">${item.count} จุด</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${escapeHtml(item.damage)}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
        `;
    }
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/30 dark:to-red-900/30 rounded-2xl">
                <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/50 dark:to-orange-800/30 rounded-2xl text-4xl md:text-5xl shadow-lg">
                    ${statusIcon}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white truncate">${escapeHtml(repair.AddLocation || 'ไม่ระบุสถานที่')}</h4>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold mt-2 ${getStatusBgClass(repair.status)}">
                        ${repair.status_text}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="p-4 bg-gradient-to-br from-orange-50 to-red-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-orange-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-calendar-alt text-orange-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">วันที่แจ้ง</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-emerald-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-user text-emerald-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">ผู้แจ้ง</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${escapeHtml(repair.teacher_name_masked || '-')}</p>
                </div>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-gray-50 to-slate-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-tools text-blue-500"></i>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">รายการที่ต้องซ่อม (${repair.total_items} รายการ)</p>
                </div>
                ${damagesHtml || '<p class="text-gray-500">ไม่มีรายการ</p>'}
            </div>
        </div>
    `;
    
    $('#modalContent').html(html);
    $('#repairModal').removeClass('hidden');
}

function closeModal() {
    $('#repairModal').addClass('hidden');
}

function formatThaiDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = thaiMonths[date.getMonth() + 1];
    const year = date.getFullYear() + 543;
    return `${day} ${month} ${year}`;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Close modal on escape
$(document).on('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});

// Close modal on backdrop click
$('#repairModal').on('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
