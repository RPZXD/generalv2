<!-- Car Booking Public View Page Content -->
<div class="space-y-6 md:space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 p-6 md:p-8 lg:p-12 shadow-2xl shadow-emerald-500/20">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-gradient-to-br from-yellow-400/30 to-transparent rounded-full blur-3xl -mr-32 md:-mr-48 -mt-32 md:-mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-72 h-48 md:h-72 bg-gradient-to-tr from-cyan-400/30 to-transparent rounded-full blur-3xl -ml-24 md:-ml-36 -mb-24 md:-mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-transparent via-white/5 to-transparent rotate-12 animate-shimmer"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-8">
            <div class="flex-shrink-0">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 rounded-full blur-xl animate-pulse group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative w-24 h-24 md:w-32 lg:w-40 md:h-32 lg:h-40 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full border border-white/30 shadow-2xl group-hover:scale-105 transition-transform duration-300">
                        <span class="text-5xl md:text-6xl lg:text-7xl drop-shadow-lg animate-bounce-slow">🚐</span>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-xs md:text-sm font-medium mb-4 border border-white/20 shadow-lg">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                    </span>
                    ดูตารางการจอง
                </div>
                <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-2 md:mb-3 drop-shadow-lg">
                    จองรถราชการ
                </h1>
                <p class="text-base md:text-lg lg:text-xl text-white/90 max-w-lg">
                    ตรวจสอบตารางการจองรถราชการของโรงเรียน
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-emerald-500 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-emerald-500/20">
                    📋
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent" id="statTotal">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">จองทั้งหมด</p>
                </div>
            </div>
        </div>
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-green-500 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/50 dark:to-green-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-green-500/20">
                    ✅
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent" id="statApproved">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">อนุมัติแล้ว</p>
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
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">รออนุมัติ</p>
                </div>
            </div>
        </div>
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-cyan-500 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-cyan-100 to-cyan-200 dark:from-cyan-900/50 dark:to-cyan-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-cyan-500/20">
                    🚗
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent" id="statCars">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">รถราชการ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts Section -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800 shadow-xl shadow-emerald-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-teal-500 to-emerald-500 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-teal-500/30">
                📊
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">สถิติเชิงวิเคราะห์</h2>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">ข้อมูลเชิงสถิติการจองรถราชการ</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Status Distribution - Donut Chart -->
            <div class="group relative overflow-hidden bg-white dark:bg-slate-800/80 rounded-xl md:rounded-2xl p-4 md:p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/50 dark:to-teal-900/30 rounded-lg md:rounded-xl text-lg md:text-xl">📈</span>
                            <h3 class="font-bold text-sm md:text-base text-gray-900 dark:text-white">สถานะการจอง</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] md:text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full">เดือนนี้</span>
                    </div>
                    <div class="relative aspect-square max-h-48 md:max-h-56 mx-auto">
                        <canvas id="statusChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center">
                                <div class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent" id="statusChartTotal">0</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">รายการ</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 mt-4 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-emerald-400 to-green-500"></span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">อนุมัติ</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-amber-400 to-orange-500"></span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">รออนุมัติ</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-red-400 to-rose-500"></span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">ไม่อนุมัติ</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Car Usage - Bar Chart -->
            <div class="group relative overflow-hidden bg-white dark:bg-slate-800/80 rounded-xl md:rounded-2xl p-4 md:p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-cyan-100 to-blue-100 dark:from-cyan-900/50 dark:to-blue-900/30 rounded-lg md:rounded-xl text-lg md:text-xl">🚗</span>
                            <h3 class="font-bold text-sm md:text-base text-gray-900 dark:text-white">การใช้งานรถ</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] md:text-xs font-medium bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-full">Top 5</span>
                    </div>
                    <div class="relative h-48 md:h-56">
                        <canvas id="carUsageChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-2 mt-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/30 dark:to-blue-900/30 rounded-full text-xs font-medium text-cyan-600 dark:text-cyan-400">
                            <i class="fas fa-chart-bar text-[10px]"></i>
                            <span id="carUsageTopCar">-</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Booking Trend - Line Chart -->
            <div class="group relative overflow-hidden bg-white dark:bg-slate-800/80 rounded-xl md:rounded-2xl p-4 md:p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-teal-100 to-green-100 dark:from-teal-900/50 dark:to-green-900/30 rounded-lg md:rounded-xl text-lg md:text-xl">📆</span>
                            <h3 class="font-bold text-sm md:text-base text-gray-900 dark:text-white">แนวโน้มการจอง</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] md:text-xs font-medium bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 rounded-full">รายวัน</span>
                    </div>
                    <div class="relative h-48 md:h-56">
                        <canvas id="trendChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-teal-400 to-emerald-500"></span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">จำนวนการจอง</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-percentage text-emerald-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">อัตราอนุมัติ</span>
                </div>
                <div class="text-lg md:text-xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent" id="approvalRate">-%</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-xl border border-cyan-100 dark:border-cyan-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-fire text-cyan-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">รถยอดนิยม</span>
                </div>
                <div class="text-sm md:text-base font-bold text-gray-900 dark:text-white truncate" id="popularCar">-</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-users text-amber-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">รวมผู้โดยสาร</span>
                </div>
                <div class="text-lg md:text-xl font-bold text-gray-900 dark:text-white" id="totalPassengers">- คน</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20 rounded-xl border border-rose-100 dark:border-rose-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-calendar-day text-rose-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">วันยอดนิยม</span>
                </div>
                <div class="text-sm md:text-base font-bold text-gray-900 dark:text-white" id="peakDay">-</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6">
        <div class="flex flex-col gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="text-xl md:text-2xl">🔍</span> กรองตารางการจอง
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                <select id="filterCar" class="w-full px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent cursor-pointer text-sm md:text-base">
                    <option value="">🚗 ทุกคัน</option>
                </select>
                <select id="filterMonth" class="w-full px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent cursor-pointer text-sm md:text-base">
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
                <select id="filterYear" class="w-full px-3 md:px-4 py-2.5 md:py-3 rounded-lg md:rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent cursor-pointer text-sm md:text-base">
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg md:rounded-xl text-white text-lg md:text-xl">
                        📅
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">ปฏิทินการจอง</h2>
                        <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400" id="calendarTitle">กำลังโหลด...</p>
                    </div>
                </div>
                <div class="flex gap-2 justify-center sm:justify-end">
                    <button onclick="prevMonth()" class="p-2 md:p-2.5 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="goToday()" class="px-3 md:px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg font-medium hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors text-sm md:text-base">
                        วันนี้
                    </button>
                    <button onclick="nextMonth()" class="p-2 md:p-2.5 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-3 md:p-6 overflow-x-auto">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-10 h-10 md:w-12 md:h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500 dark:text-gray-400">กำลังโหลดตารางการจอง...</p>
            </div>

            <!-- Calendar -->
            <div id="calendarContainer" class="hidden min-w-[320px]">
                <!-- Calendar Header -->
                <div class="grid grid-cols-7 gap-0.5 md:gap-1 mb-2">
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-red-500">อา</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400">จ</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400">อ</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400">พ</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400">พฤ</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400">ศ</div>
                    <div class="text-center py-1.5 md:py-2 text-xs md:text-sm font-bold text-blue-500">ส</div>
                </div>
                <!-- Calendar Grid -->
                <div id="calendarGrid" class="grid grid-cols-7 gap-0.5 md:gap-1">
                    <!-- Days will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Booking List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-teal-500 to-emerald-500 rounded-lg md:rounded-xl text-white text-lg md:text-xl">
                    📋
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รายการจอง</h2>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400" id="bookingResultText">กำลังโหลด...</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6">
            <div id="emptyBooking" class="hidden text-center py-8 md:py-12">
                <div class="text-5xl md:text-6xl mb-4">📭</div>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">ไม่มีการจองในเดือนนี้</p>
            </div>
            
            <div id="bookingList" class="hidden space-y-3 md:space-y-4">
                <!-- Booking items will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Car List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg md:rounded-xl text-white text-lg md:text-xl">
                    🚗
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รถราชการทั้งหมด</h2>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400">รายการรถราชการที่พร้อมให้บริการ</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6">
            <div id="carList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                <!-- Car cards will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Booking Detail Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-3 md:p-4">
    <div class="bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รายละเอียดการจอง</h3>
                <button onclick="closeModal()" class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-slate-700 rounded-full transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div id="modalContent" class="p-4 md:p-6">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
let currentMonth = new Date().getMonth() + 1;
let currentYear = new Date().getFullYear();
let allCars = [];
let allBookings = [];

// Chart instances
let statusChart = null;
let carUsageChart = null;
let trendChart = null;

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

$(document).ready(function() {
    initFilters();
    loadData();
    
    $('#filterCar, #filterMonth, #filterYear').on('change', function() {
        currentMonth = parseInt($('#filterMonth').val());
        currentYear = parseInt($('#filterYear').val());
        loadData();
    });
});

function initFilters() {
    // Set current month
    $('#filterMonth').val(currentMonth);
    
    // Generate year options
    const thisYear = new Date().getFullYear();
    let yearHtml = '';
    for (let y = thisYear - 2; y <= thisYear + 2; y++) {
        yearHtml += `<option value="${y}" ${y === thisYear ? 'selected' : ''}>${y + 543}</option>`;
    }
    $('#filterYear').html(yearHtml);
}

function loadData() {
    const carId = $('#filterCar').val();
    let url = `api/public_car_booking.php?month=${currentMonth}&year=${currentYear}`;
    if (carId) url += `&car_id=${carId}`;
    
    $('#loading').removeClass('hidden');
    $('#calendarContainer').addClass('hidden');
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            if (response.success) {
                allCars = response.cars;
                allBookings = response.bookings;
                
                updateStats(response.stats, allCars.length);
                updateCarFilter();
                renderCalendar();
                renderBookingList();
                renderCarList();
                renderCharts(response.stats);
                renderAnalytics();
            }
        },
        error: function() {
            $('#loading').addClass('hidden');
            Swal.fire('ผิดพลาด', 'ไม่สามารถโหลดข้อมูลได้', 'error');
        }
    });
}

function updateStats(stats, carCount) {
    $('#statTotal').text(stats.total.toLocaleString());
    $('#statApproved').text(stats.approved.toLocaleString());
    $('#statPending').text(stats.pending.toLocaleString());
    $('#statCars').text(carCount.toLocaleString());
    $('#statusChartTotal').text(stats.total.toLocaleString());
}

// Chart rendering functions
function renderCharts(stats) {
    renderStatusChart(stats);
    renderCarUsageChart();
    renderTrendChart();
}

function renderStatusChart(stats) {
    const ctx = document.getElementById('statusChart');
    if (!ctx) return;
    
    // Destroy existing chart
    if (statusChart) {
        statusChart.destroy();
    }
    
    const data = {
        labels: ['อนุมัติแล้ว', 'รออนุมัติ', 'ไม่อนุมัติ'],
        datasets: [{
            data: [stats.approved || 0, stats.pending || 0, stats.rejected || 0],
            backgroundColor: [
                'rgba(16, 185, 129, 0.8)',  // emerald
                'rgba(245, 158, 11, 0.8)',  // amber
                'rgba(239, 68, 68, 0.8)'    // red
            ],
            borderColor: [
                'rgba(16, 185, 129, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(239, 68, 68, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 8
        }]
    };
    
    statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { family: 'Mali', size: 14 },
                    bodyFont: { family: 'Mali', size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${context.raw} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true
            }
        }
    });
}

function renderCarUsageChart() {
    const ctx = document.getElementById('carUsageChart');
    if (!ctx) return;
    
    if (carUsageChart) {
        carUsageChart.destroy();
    }
    
    // Calculate car usage from bookings
    const carUsage = {};
    allBookings.forEach(booking => {
        const carName = booking.car_model || 'ไม่ระบุ';
        carUsage[carName] = (carUsage[carName] || 0) + 1;
    });
    
    // Sort by usage and take top 5
    const sortedCars = Object.entries(carUsage)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 5);
    
    const labels = sortedCars.map(c => c[0].length > 15 ? c[0].substring(0, 15) + '...' : c[0]);
    const values = sortedCars.map(c => c[1]);
    
    // Update top car indicator
    if (sortedCars.length > 0) {
        $('#carUsageTopCar').text(`🏆 ${sortedCars[0][0]}`);
        $('#popularCar').text(sortedCars[0][0]);
    }
    
    const gradientColors = [
        'rgba(6, 182, 212, 0.8)',    // cyan
        'rgba(59, 130, 246, 0.7)',   // blue
        'rgba(99, 102, 241, 0.6)',   // indigo
        'rgba(139, 92, 246, 0.5)',   // violet
        'rgba(168, 85, 247, 0.4)'    // purple
    ];
    
    carUsageChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'จำนวนการจอง',
                data: values,
                backgroundColor: gradientColors,
                borderColor: gradientColors.map(c => c.replace('0.8', '1').replace('0.7', '1').replace('0.6', '1').replace('0.5', '1').replace('0.4', '1')),
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { family: 'Mali', size: 14 },
                    bodyFont: { family: 'Mali', size: 13 },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: { family: 'Mali', size: 11 },
                        stepSize: 1
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { family: 'Mali', size: 11 }
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
}

function renderTrendChart() {
    const ctx = document.getElementById('trendChart');
    if (!ctx) return;
    
    if (trendChart) {
        trendChart.destroy();
    }
    
    // Group bookings by date for trend
    const bookingsByDate = {};
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    
    // Initialize all days with 0
    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
        bookingsByDate[dateStr] = 0;
    }
    
    // Count bookings per day
    allBookings.forEach(booking => {
        if (bookingsByDate.hasOwnProperty(booking.booking_date)) {
            bookingsByDate[booking.booking_date]++;
        }
    });
    
    const labels = Object.keys(bookingsByDate).map(date => {
        return new Date(date).getDate(); // Just show day number
    });
    const values = Object.values(bookingsByDate);
    
    trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'จำนวนการจอง',
                data: values,
                fill: true,
                backgroundColor: 'rgba(20, 184, 166, 0.1)',
                borderColor: 'rgba(20, 184, 166, 1)',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: 'rgba(20, 184, 166, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { family: 'Mali', size: 14 },
                    bodyFont: { family: 'Mali', size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        title: function(context) {
                            return `วันที่ ${context[0].label} ${thaiMonths[currentMonth]}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: { family: 'Mali', size: 10 },
                        maxTicksLimit: 10
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: { family: 'Mali', size: 11 },
                        stepSize: 1
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

function renderAnalytics() {
    // Calculate approval rate
    const total = allBookings.length;
    const approved = allBookings.filter(b => b.status === 'approved').length;
    const approvalRate = total > 0 ? ((approved / total) * 100).toFixed(1) : 0;
    $('#approvalRate').text(`${approvalRate}%`);
    
    // Calculate total passengers
    let totalPassengers = 0;
    allBookings.forEach(b => {
        if (b.passenger_count) {
            totalPassengers += parseInt(b.passenger_count) || 0;
        }
    });
    $('#totalPassengers').text(`${totalPassengers.toLocaleString()} คน`);
    
    // Find peak day of week
    const dayCount = { 0: 0, 1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0 };
    const thaiDays = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'];
    
    allBookings.forEach(b => {
        if (b.booking_date) {
            const day = new Date(b.booking_date).getDay();
            dayCount[day]++;
        }
    });
    
    const peakDay = Object.entries(dayCount).sort((a, b) => b[1] - a[1])[0];
    if (peakDay && parseInt(peakDay[1]) > 0) {
        $('#peakDay').text(`วัน${thaiDays[peakDay[0]]}`);
    }
}

function updateCarFilter() {
    const currentVal = $('#filterCar').val();
    let html = '<option value="">🚗 ทุกคัน</option>';
    allCars.forEach(car => {
        html += `<option value="${car.id}" ${currentVal == car.id ? 'selected' : ''}>${car.emoji || '🚗'} ${car.car_model} (${car.license_plate})</option>`;
    });
    $('#filterCar').html(html);
}

function renderCalendar() {
    $('#calendarTitle').text(`${thaiMonths[currentMonth]} ${currentYear + 543}`);
    
    const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    const today = new Date();
    
    // Group bookings by date
    const bookingsByDate = {};
    allBookings.forEach(b => {
        const date = b.booking_date;
        if (!bookingsByDate[date]) bookingsByDate[date] = [];
        bookingsByDate[date].push(b);
    });
    
    let html = '';
    
    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        html += '<div class="min-h-[60px] md:min-h-[80px] p-0.5 md:p-1 bg-gray-50 dark:bg-slate-800/30 rounded-lg"></div>';
    }
    
    // Days
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayBookings = bookingsByDate[dateStr] || [];
        const isToday = today.getDate() === day && today.getMonth() === currentMonth - 1 && today.getFullYear() === currentYear;
        const dayOfWeek = new Date(currentYear, currentMonth - 1, day).getDay();
        const isSunday = dayOfWeek === 0;
        const isSaturday = dayOfWeek === 6;
        
        html += `
        <div class="min-h-[60px] md:min-h-[80px] p-0.5 md:p-1 ${isToday ? 'bg-emerald-100 dark:bg-emerald-900/30 ring-2 ring-emerald-500' : 'bg-gray-50 dark:bg-slate-800/50'} rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700/50 transition-colors">
            <div class="text-right mb-0.5 md:mb-1">
                <span class="inline-flex items-center justify-center w-5 h-5 md:w-7 md:h-7 text-xs md:text-sm font-bold ${isToday ? 'bg-emerald-500 text-white rounded-full' : isSunday ? 'text-red-500' : isSaturday ? 'text-blue-500' : 'text-gray-700 dark:text-gray-300'}">${day}</span>
            </div>
            <div class="space-y-0.5 md:space-y-1 max-h-[40px] md:max-h-[60px] overflow-y-auto">
                ${dayBookings.slice(0, 2).map(b => `
                    <div onclick="showBookingDetail(${b.id})" class="text-[10px] md:text-xs px-1 md:px-1.5 py-0.5 rounded cursor-pointer truncate ${getStatusBgClass(b.status)}" title="${b.car_model || 'รถ'} - ${b.destination}">
                        <span class="hidden sm:inline">${b.emoji || '🚗'} ${b.license_plate ? b.license_plate.substring(0, 8) : ''}</span>
                        <span class="sm:hidden">${b.emoji || '🚗'}</span>
                    </div>
                `).join('')}
                ${dayBookings.length > 2 ? `<div class="text-[10px] md:text-xs text-center text-gray-500">+${dayBookings.length - 2}</div>` : ''}
            </div>
        </div>
        `;
    }
    
    $('#calendarGrid').html(html);
    $('#calendarContainer').removeClass('hidden');
}

function getStatusBgClass(status) {
    // Handle both string status and numeric status_value
    if (status === 'pending' || status === 0) return 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400';
    if (status === 'approved' || status === 1) return 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400';
    if (status === 'rejected' || status === 2) return 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400';
    return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400';
}

function renderBookingList() {
    if (allBookings.length === 0) {
        $('#bookingList').addClass('hidden');
        $('#emptyBooking').removeClass('hidden');
        $('#bookingResultText').text('ไม่มีการจอง');
        return;
    }
    
    $('#emptyBooking').addClass('hidden');
    $('#bookingResultText').text(`พบ ${allBookings.length} รายการ`);
    
    let html = '';
    allBookings.forEach(b => {
        const date = formatThaiDate(b.booking_date);
        const startTime = b.start_time ? b.start_time.substring(11, 16) : '-';
        html += `
        <div onclick="showBookingDetail(${b.id})" class="p-3 md:p-4 bg-gray-50 dark:bg-slate-800/50 rounded-lg md:rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/50 cursor-pointer transition-colors active:scale-[0.99]">
            <div class="flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-lg md:rounded-xl text-2xl md:text-3xl">
                    ${b.emoji || '🚗'}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-1.5 md:gap-2 mb-1">
                        <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white truncate">${escapeHtml(b.car_model || 'ไม่ระบุรถ')}</h4>
                        <span class="px-1.5 md:px-2 py-0.5 rounded-full text-[10px] md:text-xs font-medium flex-shrink-0 ${getStatusBgClass(b.status)}">${b.status_text}</span>
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1">${escapeHtml(b.license_plate || '-')}</p>
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 truncate mb-1.5 md:mb-2"><i class="fas fa-map-marker-alt mr-1 text-red-500"></i>${escapeHtml(b.destination || '-')}</p>
                    <div class="flex flex-wrap items-center gap-2 md:gap-4 text-[10px] md:text-sm text-gray-500 dark:text-gray-400">
                        <span><i class="far fa-calendar-alt mr-1"></i>${date}</span>
                        <span><i class="far fa-clock mr-1"></i>${startTime}</span>
                        <span class="hidden sm:inline"><i class="far fa-user mr-1"></i>${escapeHtml(b.teacher_name_masked || '-')}</span>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 hidden sm:block"></i>
            </div>
        </div>
        `;
    });
    
    $('#bookingList').html(html).removeClass('hidden');
}

function renderCarList() {
    let html = '';
    allCars.forEach(car => {
        html += `
        <div class="p-3 md:p-4 bg-gray-50 dark:bg-slate-800/50 rounded-lg md:rounded-xl hover:shadow-lg transition-all">
            <div class="flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-11 h-11 md:w-14 md:h-14 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-lg md:rounded-xl text-2xl md:text-3xl">
                    ${car.emoji || '🚗'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-0.5 md:mb-1 truncate">${escapeHtml(car.car_model)}</h4>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1.5 md:mb-2">${escapeHtml(car.license_plate)}</p>
                    <div class="flex flex-wrap gap-1.5 md:gap-2 text-[10px] md:text-xs">
                        <span class="px-1.5 md:px-2 py-0.5 md:py-1 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 rounded-full">
                            ${escapeHtml(car.car_type)}
                        </span>
                        <span class="px-1.5 md:px-2 py-0.5 md:py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">
                            <i class="fas fa-users mr-1"></i>${car.capacity} คน
                        </span>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#carList').html(html);
}

function showBookingDetail(id) {
    const booking = allBookings.find(b => b.id == id);
    if (!booking) return;
    
    const date = formatThaiDate(booking.booking_date);
    const startTime = booking.start_time ? booking.start_time.substring(11, 16) : '-';
    const endTime = booking.end_time ? booking.end_time.substring(11, 16) : '-';
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-4xl">
                    ${booking.emoji || '🚗'}
                </div>
                <div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">${escapeHtml(booking.car_model || 'ไม่ระบุรถ')}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${escapeHtml(booking.license_plate || '-')}</p>
                    <span class="px-3 py-1 rounded-full text-sm font-medium ${getStatusBgClass(booking.status)}">${booking.status_text}</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">วันที่</p>
                    <p class="font-medium text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">เวลา</p>
                    <p class="font-medium text-gray-900 dark:text-white">${startTime} - ${endTime} น.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">จำนวนผู้โดยสาร</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.passenger_count || '-'} คน</p>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ความจุรถ</p>
                    <p class="font-medium text-gray-900 dark:text-white">${booking.capacity || '-'} คน</p>
                </div>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ปลายทาง</p>
                <p class="font-medium text-gray-900 dark:text-white"><i class="fas fa-map-marker-alt mr-1 text-red-500"></i>${escapeHtml(booking.destination || '-')}</p>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">วัตถุประสงค์</p>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.purpose || '-')}</p>
            </div>
            
            <div class="p-3 bg-gray-50 dark:bg-slate-700/50 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">ผู้จอง</p>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.teacher_name_masked || '-')}</p>
            </div>
        </div>
    `;
    
    $('#modalContent').html(html);
    $('#bookingModal').removeClass('hidden');
}

function closeModal() {
    $('#bookingModal').addClass('hidden');
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 1) {
        currentMonth = 12;
        currentYear--;
    }
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 12) {
        currentMonth = 1;
        currentYear++;
    }
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
}

function goToday() {
    currentMonth = new Date().getMonth() + 1;
    currentYear = new Date().getFullYear();
    $('#filterMonth').val(currentMonth);
    $('#filterYear').val(currentYear);
    loadData();
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
$('#bookingModal').on('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
