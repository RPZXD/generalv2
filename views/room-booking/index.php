<!-- Room Booking Public View Page Content -->
<div class="space-y-6 md:space-y-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-700 p-6 md:p-8 lg:p-12 shadow-2xl shadow-purple-500/20">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.15&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-gradient-to-br from-pink-500/30 to-transparent rounded-full blur-3xl -mr-32 md:-mr-48 -mt-32 md:-mt-48 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-48 md:w-72 h-48 md:h-72 bg-gradient-to-tr from-blue-500/30 to-transparent rounded-full blur-3xl -ml-24 md:-ml-36 -mb-24 md:-mb-36 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-transparent via-white/5 to-transparent rotate-12 animate-shimmer"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-8">
            <div class="flex-shrink-0">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/30 to-white/10 rounded-full blur-xl animate-pulse group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative w-24 h-24 md:w-32 lg:w-40 md:h-32 lg:h-40 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full border border-white/30 shadow-2xl group-hover:scale-105 transition-transform duration-300">
                        <span class="text-5xl md:text-6xl lg:text-7xl drop-shadow-lg animate-bounce-slow">🏢</span>
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
                    จองห้องประชุม
                </h1>
                <p class="text-base md:text-lg lg:text-xl text-white/90 max-w-lg">
                    ตรวจสอบตารางการจองห้องประชุมและสถานที่ต่างๆ
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-purple-500 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/50 dark:to-purple-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-purple-500/20">
                    📋
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent" id="statTotal">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">จองทั้งหมด</p>
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
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent" id="statApproved">-</p>
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
        <div class="group relative overflow-hidden glass rounded-xl md:rounded-2xl p-4 md:p-5 border-l-4 border-blue-500 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center gap-3 md:gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/50 dark:to-blue-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg shadow-blue-500/20">
                    🏢
                </div>
                <div class="min-w-0">
                    <p class="text-xl md:text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent" id="statRooms">-</p>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium">ห้องประชุม</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts Section -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800 shadow-xl shadow-purple-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-fuchsia-500 to-pink-500 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-fuchsia-500/30">
                📊
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">สถิติเชิงวิเคราะห์</h2>
                <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">ข้อมูลเชิงสถิติการจองห้องประชุม</p>
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

            <!-- Room Usage - Bar Chart -->
            <div class="group relative overflow-hidden bg-white dark:bg-slate-800/80 rounded-xl md:rounded-2xl p-4 md:p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/50 dark:to-indigo-900/30 rounded-lg md:rounded-xl text-lg md:text-xl">🏢</span>
                            <h3 class="font-bold text-sm md:text-base text-gray-900 dark:text-white">การใช้งานห้อง</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] md:text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full">Top 5</span>
                    </div>
                    <div class="relative h-48 md:h-56">
                        <canvas id="roomUsageChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-2 mt-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full text-xs font-medium text-blue-600 dark:text-blue-400">
                            <i class="fas fa-chart-bar text-[10px]"></i>
                            <span id="roomUsageTopRoom">-</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Booking Trend - Line Chart -->
            <div class="group relative overflow-hidden bg-white dark:bg-slate-800/80 rounded-xl md:rounded-2xl p-4 md:p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 hover:-translate-y-1">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/50 dark:to-pink-900/30 rounded-lg md:rounded-xl text-lg md:text-xl">📆</span>
                            <h3 class="font-bold text-sm md:text-base text-gray-900 dark:text-white">แนวโน้มการจอง</h3>
                        </div>
                        <span class="px-2.5 py-1 text-[10px] md:text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-full">รายวัน</span>
                    </div>
                    <div class="relative h-48 md:h-56">
                        <canvas id="trendChart"></canvas>
                    </div>
                    <div class="flex justify-center gap-4 mt-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-purple-400 to-pink-500"></span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">จำนวนการจอง</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Summary -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">
            <div class="p-4 bg-gradient-to-br from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-xl border border-violet-100 dark:border-violet-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-percentage text-violet-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">อัตราอนุมัติ</span>
                </div>
                <div class="text-lg md:text-xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent" id="approvalRate">-%</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 rounded-xl border border-cyan-100 dark:border-cyan-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-fire text-cyan-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">ห้องยอดนิยม</span>
                </div>
                <div class="text-sm md:text-base font-bold text-gray-900 dark:text-white truncate" id="popularRoom">-</div>
            </div>
            <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-clock text-amber-500 text-sm"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">ช่วงเวลายอดนิยม</span>
                </div>
                <div class="text-sm md:text-base font-bold text-gray-900 dark:text-white" id="peakTime">-</div>
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
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg text-white text-sm md:text-lg shadow-lg shadow-purple-500/30">
                    <i class="fas fa-filter"></i>
                </span>
                กรองตารางการจอง
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                <div class="relative group">
                    <select id="filterRoom" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-purple-300 appearance-none bg-white dark:bg-slate-800">
                        <option value="">🏢 ทุกห้อง</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                <div class="relative group">
                    <select id="filterMonth" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-purple-300 appearance-none bg-white dark:bg-slate-800">
                        <option value="1">📅 มกราคม</option>
                        <option value="2">📅 กุมภาพันธ์</option>
                        <option value="3">📅 มีนาคม</option>
                        <option value="4">📅 เมษายน</option>
                        <option value="5">📅 พฤษภาคม</option>
                        <option value="6">📅 มิถุนายน</option>
                        <option value="7">📅 กรกฎาคม</option>
                        <option value="8">📅 สิงหาคม</option>
                        <option value="9">📅 กันยายน</option>
                        <option value="10">📅 ตุลาคม</option>
                        <option value="11">📅 พฤศจิกายน</option>
                        <option value="12">📅 ธันวาคม</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                <div class="relative group">
                    <select id="filterYear" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-purple-300 appearance-none bg-white dark:bg-slate-800">
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-purple-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-purple-500/30">
                        📅
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">ปฏิทินการจอง</h2>
                        <p class="text-sm md:text-base font-medium bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent" id="calendarTitle">กำลังโหลด...</p>
                    </div>
                </div>
                <div class="flex gap-2 justify-center sm:justify-end">
                    <button onclick="prevMonth()" class="p-2.5 md:p-3 bg-white dark:bg-slate-800 hover:bg-purple-50 dark:hover:bg-slate-700 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 dark:border-gray-700 hover:-translate-x-0.5 active:scale-95">
                        <i class="fas fa-chevron-left text-purple-600"></i>
                    </button>
                    <button onclick="goToday()" class="px-4 md:px-5 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl font-medium hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg shadow-purple-500/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 text-sm md:text-base">
                        <i class="far fa-calendar-check mr-1.5"></i>วันนี้
                    </button>
                    <button onclick="nextMonth()" class="p-2.5 md:p-3 bg-white dark:bg-slate-800 hover:bg-purple-50 dark:hover:bg-slate-700 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 dark:border-gray-700 hover:translate-x-0.5 active:scale-95">
                        <i class="fas fa-chevron-right text-purple-600"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-3 md:p-6 overflow-x-auto bg-white dark:bg-slate-900/50">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-12 h-12 md:w-14 md:h-14 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500 dark:text-gray-400 font-medium">กำลังโหลดตารางการจอง...</p>
            </div>

            <!-- Calendar -->
            <div id="calendarContainer" class="hidden w-full sm:min-w-[320px]">
                <!-- Calendar Header -->
                <div class="grid grid-cols-7 gap-1 md:gap-2 mb-2">
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-red-500 bg-red-50 dark:bg-red-900/20 rounded-lg">อา</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg">จ</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg">อ</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg">พ</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg">พฤ</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg">ศ</div>
                    <div class="text-center py-2 md:py-3 text-xs md:text-sm font-bold text-blue-500 bg-blue-50 dark:bg-blue-900/20 rounded-lg">ส</div>
                </div>
                <!-- Calendar Grid -->
                <div id="calendarGrid" class="grid grid-cols-7 gap-1 md:gap-2">
                    <!-- Days will be inserted here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Booking List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-indigo-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-indigo-500/30">
                        📋
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รายการจอง</h2>
                        <p class="text-sm md:text-base font-medium text-gray-500 dark:text-gray-400" id="bookingResultText">กำลังโหลด...</p>
                    </div>
                </div>
                
                <!-- Tabs -->
                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center bg-white dark:bg-slate-800 rounded-xl p-1 shadow-md border border-gray-200 dark:border-gray-700 flex-nowrap overflow-x-auto">
                        <button onclick="setBookingTab('today')" id="tabToday" class="tab-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-md flex-shrink-0 whitespace-nowrap">
                            <i class="fas fa-calendar-day mr-1.5"></i>วันนี้
                        </button>
                        <button onclick="setBookingTab('all')" id="tabAll" class="tab-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 flex-shrink-0 whitespace-nowrap">
                            <i class="fas fa-list mr-1.5"></i>ทั้งหมด
                        </button>
                        <button onclick="setBookingTab('custom')" id="tabCustom" class="tab-btn px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 flex-shrink-0 whitespace-nowrap">
                            <i class="far fa-calendar-alt mr-1.5"></i>เลือกวัน
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Date Picker (hidden by default) -->
            <div id="customDatePicker" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <i class="far fa-calendar text-purple-500"></i>
                        เลือกวันที่:
                    </label>
                    <input type="date" id="customDate" class="px-4 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 text-sm">
                    <button onclick="applyCustomDate()" class="px-4 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl text-sm font-medium hover:from-purple-600 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg active:scale-95">
                        <i class="fas fa-search mr-1.5"></i>ค้นหา
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6 bg-white dark:bg-slate-900/50">
            <div id="emptyBooking" class="hidden text-center py-12 md:py-16">
                <div class="w-20 h-20 md:w-24 md:h-24 mx-auto mb-4 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-full">
                    <span class="text-4xl md:text-5xl">📭</span>
                </div>
                <p class="text-base md:text-lg font-medium text-gray-500 dark:text-gray-400" id="emptyMessage">ไม่มีการจองในเดือนนี้</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1" id="emptySubMessage">ลองเปลี่ยนเดือนหรือห้องเพื่อดูรายการอื่น</p>
            </div>
            
            <div id="bookingList" class="hidden space-y-3 md:space-y-4">
                <!-- Booking items will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Room List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-blue-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-blue-500/30">
                    🏢
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">ห้องประชุมทั้งหมด</h2>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">รายการห้องประชุมที่พร้อมให้บริการ</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6 bg-white dark:bg-slate-900/50">
            <div id="roomList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                <!-- Room cards will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Booking Detail Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 hidden flex items-center justify-center p-3 md:p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl md:rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700 animate-modal-in">
        <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/30 dark:to-indigo-900/30">
            <div class="flex items-center justify-between">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 flex items-center justify-center bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg text-white text-sm">
                        <i class="fas fa-info"></i>
                    </span>
                    รายละเอียดการจอง
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
    background: rgba(139, 92, 246, 0.3);
    border-radius: 4px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(139, 92, 246, 0.5);
}
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
let currentMonth = new Date().getMonth() + 1;
let currentYear = new Date().getFullYear();
let allRooms = [];
let allBookings = [];
let currentTab = 'today';
let customSelectedDate = null;

// Chart instances
let statusChart = null;
let roomUsageChart = null;
let trendChart = null;

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

$(document).ready(function() {
    initFilters();
    loadData();
    
    // Set default date for custom date picker
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    $('#customDate').val(todayStr);
    
    $('#filterRoom, #filterMonth, #filterYear').on('change', function() {
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
    const roomId = $('#filterRoom').val();
    let url = `api/public_room_booking.php?month=${currentMonth}&year=${currentYear}`;
    if (roomId) url += `&room_id=${roomId}`;
    
    $('#loading').removeClass('hidden');
    $('#calendarContainer').addClass('hidden');
    
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').addClass('hidden');
            
            if (response.success) {
                allRooms = response.rooms;
                allBookings = response.bookings;
                
                updateStats(response.stats, allRooms.length);
                updateRoomFilter();
                renderCalendar();
                renderBookingList();
                renderRoomList();
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

function updateStats(stats, roomCount) {
    $('#statTotal').text(stats.total.toLocaleString());
    $('#statApproved').text(stats.approved.toLocaleString());
    $('#statPending').text(stats.pending.toLocaleString());
    $('#statRooms').text(roomCount.toLocaleString());
    $('#statusChartTotal').text(stats.total.toLocaleString());
}

// Chart rendering functions
function renderCharts(stats) {
    renderStatusChart(stats);
    renderRoomUsageChart();
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

function renderRoomUsageChart() {
    const ctx = document.getElementById('roomUsageChart');
    if (!ctx) return;
    
    if (roomUsageChart) {
        roomUsageChart.destroy();
    }
    
    // Calculate room usage from bookings
    const roomUsage = {};
    allBookings.forEach(booking => {
        const roomName = booking.room_name || 'ไม่ระบุ';
        roomUsage[roomName] = (roomUsage[roomName] || 0) + 1;
    });
    
    // Sort by usage and take top 5
    const sortedRooms = Object.entries(roomUsage)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 5);
    
    const labels = sortedRooms.map(r => r[0].length > 12 ? r[0].substring(0, 12) + '...' : r[0]);
    const values = sortedRooms.map(r => r[1]);
    
    // Update top room indicator
    if (sortedRooms.length > 0) {
        $('#roomUsageTopRoom').text(`🏆 ${sortedRooms[0][0]}`);
        $('#popularRoom').text(sortedRooms[0][0]);
    }
    
    const gradientColors = [
        'rgba(59, 130, 246, 0.8)',   // blue
        'rgba(99, 102, 241, 0.7)',   // indigo
        'rgba(139, 92, 246, 0.6)',   // violet
        'rgba(168, 85, 247, 0.5)',   // purple
        'rgba(192, 132, 252, 0.4)'   // purple lighter
    ];
    
    roomUsageChart = new Chart(ctx, {
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
        if (bookingsByDate.hasOwnProperty(booking.date)) {
            bookingsByDate[booking.date]++;
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
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderColor: 'rgba(139, 92, 246, 1)',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: 'rgba(236, 72, 153, 1)',
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
    const approved = allBookings.filter(b => parseInt(b.status) === 1).length;
    const approvalRate = total > 0 ? ((approved / total) * 100).toFixed(1) : 0;
    $('#approvalRate').text(`${approvalRate}%`);
    
    // Find peak time
    const timeSlots = {};
    allBookings.forEach(b => {
        if (b.time_start) {
            const hour = parseInt(b.time_start.substring(0, 2));
            timeSlots[hour] = (timeSlots[hour] || 0) + 1;
        }
    });
    
    const peakHour = Object.entries(timeSlots).sort((a, b) => b[1] - a[1])[0];
    if (peakHour) {
        $('#peakTime').text(`${String(peakHour[0]).padStart(2, '0')}:00 น.`);
    }
    
    // Find peak day of week
    const dayCount = { 0: 0, 1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0 };
    const thaiDays = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'];
    
    allBookings.forEach(b => {
        const day = new Date(b.date).getDay();
        dayCount[day]++;
    });
    
    const peakDay = Object.entries(dayCount).sort((a, b) => b[1] - a[1])[0];
    if (peakDay && parseInt(peakDay[1]) > 0) {
        $('#peakDay').text(`วัน${thaiDays[peakDay[0]]}`);
    }
}

function updateRoomFilter() {
    const currentVal = $('#filterRoom').val();
    let html = '<option value="">🏢 ทุกห้อง</option>';
    allRooms.forEach(room => {
        html += `<option value="${room.id}" ${currentVal == room.id ? 'selected' : ''}>${room.emoji || '🏢'} ${room.room_name}</option>`;
    });
    $('#filterRoom').html(html);
}

function renderCalendar() {
    $('#calendarTitle').text(`${thaiMonths[currentMonth]} ${currentYear + 543}`);
    
    const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
    const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
    const today = new Date();
    
    // Group bookings by date
    const bookingsByDate = {};
    allBookings.forEach(b => {
        const date = b.date;
        if (!bookingsByDate[date]) bookingsByDate[date] = [];
        bookingsByDate[date].push(b);
    });
    
    let html = '';
    
    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        html += '<div class="min-h-[70px] md:min-h-[90px] p-1 md:p-2 bg-gray-50/50 dark:bg-slate-800/20 rounded-xl"></div>';
    }
    
    // Days
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayBookings = bookingsByDate[dateStr] || [];
        const isToday = today.getDate() === day && today.getMonth() === currentMonth - 1 && today.getFullYear() === currentYear;
        const dayOfWeek = new Date(currentYear, currentMonth - 1, day).getDay();
        const isSunday = dayOfWeek === 0;
        const isSaturday = dayOfWeek === 6;
        const hasBookings = dayBookings.length > 0;
        
        html += `
        <div class="min-h-[70px] md:min-h-[90px] p-1 md:p-2 ${isToday ? 'bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/40 dark:to-indigo-900/40 ring-2 ring-purple-500 shadow-lg shadow-purple-500/20' : hasBookings ? 'bg-white dark:bg-slate-800 shadow-sm' : 'bg-gray-50 dark:bg-slate-800/50'} rounded-xl hover:shadow-md transition-all duration-200 group cursor-pointer">
            <div class="text-right mb-1">
                <span class="inline-flex items-center justify-center w-6 h-6 md:w-8 md:h-8 text-xs md:text-sm font-bold ${isToday ? 'bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-full shadow-md' : isSunday ? 'text-red-500' : isSaturday ? 'text-blue-500' : 'text-gray-700 dark:text-gray-300'}">${day}</span>
            </div>
            <div class="space-y-0.5 md:space-y-1 max-h-[42px] md:max-h-[54px] overflow-y-auto scrollbar-thin">
                ${dayBookings.slice(0, 2).map(b => `
                    <div onclick="event.stopPropagation(); showBookingDetail(${b.id})" class="text-[9px] md:text-xs px-1.5 md:px-2 py-0.5 md:py-1 rounded-md cursor-pointer truncate font-medium transition-all hover:scale-[1.02] ${getStatusBgClass(b.status)}" title="${b.room_name} - ${b.purpose}">
                        <span class="hidden sm:inline">${b.room_name ? b.room_name.substring(0, 10) : ''}</span>
                        <span class="sm:hidden">${b.room_name ? b.room_name.substring(0, 5) : '📋'}</span>
                    </div>
                `).join('')}
                ${dayBookings.length > 2 ? `<div class="text-[9px] md:text-xs text-center text-purple-600 dark:text-purple-400 font-medium bg-purple-50 dark:bg-purple-900/30 rounded-md py-0.5">+${dayBookings.length - 2} เพิ่มเติม</div>` : ''}
            </div>
        </div>
        `;
    }
    
    $('#calendarGrid').html(html);
    $('#calendarContainer').removeClass('hidden');
}

function getStatusBgClass(status) {
    switch(parseInt(status)) {
        case 0: return 'bg-gradient-to-r from-amber-100 to-orange-100 dark:from-amber-900/40 dark:to-orange-900/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800';
        case 1: return 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/40 dark:to-green-900/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800';
        case 2: return 'bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/40 dark:to-rose-900/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800';
        default: return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
    }
}

function renderBookingList() {
    // Filter bookings based on current tab
    let filteredBookings = filterBookingsByTab();
    
    if (filteredBookings.length === 0) {
        $('#bookingList').addClass('hidden');
        $('#emptyBooking').removeClass('hidden');
        updateEmptyMessage();
        return;
    }
    
    $('#emptyBooking').addClass('hidden');
    updateBookingResultText(filteredBookings.length);
    
    let html = '';
    filteredBookings.forEach((b, index) => {
        const date = formatThaiDate(b.date);
        const statusIcon = b.status == 1 ? '✓' : b.status == 0 ? '⏳' : '✗';
        html += `
        <div onclick="showBookingDetail(${b.id})" class="group relative p-4 md:p-5 bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl hover:shadow-xl cursor-pointer transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: fadeInUp 0.3s ease-out ${index * 0.05}s both;">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 flex items-center justify-center bg-gradient-to-br from-${b.color || 'purple'}-100 to-${b.color || 'purple'}-200 dark:from-${b.color || 'purple'}-900/50 dark:to-${b.color || 'purple'}-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    ${b.emoji || '🏢'}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white truncate">${escapeHtml(b.room_name || b.location)}</h4>
                        <span class="inline-flex items-center gap-1 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-semibold flex-shrink-0 ${getStatusBgClass(b.status)}">
                            <span>${statusIcon}</span> ${b.status_text}
                        </span>
                    </div>
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-1">${escapeHtml(b.purpose)}</p>
                    <div class="flex flex-wrap items-center gap-2 md:gap-3 text-[10px] md:text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-calendar-alt text-purple-500"></i>${date}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-clock text-blue-500"></i>${b.time_start.substring(0,5)} - ${b.time_end.substring(0,5)}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-user text-emerald-500"></i>${escapeHtml(b.teacher_name_masked || '-')}
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
    
    $('#bookingList').html(html).removeClass('hidden');
}

function filterBookingsByTab() {
    const today = new Date();
    const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
    
    switch(currentTab) {
        case 'today':
            return allBookings.filter(b => b.date === todayStr);
        case 'all':
            return allBookings;
        case 'custom':
            if (customSelectedDate) {
                return allBookings.filter(b => b.date === customSelectedDate);
            }
            return allBookings;
        default:
            return allBookings;
    }
}

function setBookingTab(tab) {
    currentTab = tab;
    
    // Update tab buttons style
    $('.tab-btn').removeClass('bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-md')
        .addClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700');
    
    const activeBtn = $(`#tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`);
    activeBtn.removeClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700')
        .addClass('bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-md');
    
    // Show/hide date picker
    if (tab === 'custom') {
        $('#customDatePicker').removeClass('hidden');
    } else {
        $('#customDatePicker').addClass('hidden');
    }
    
    // Re-render booking list
    renderBookingList();
}

function applyCustomDate() {
    const dateInput = $('#customDate').val();
    if (dateInput) {
        customSelectedDate = dateInput;
        renderBookingList();
    }
}

function updateEmptyMessage() {
    const today = new Date();
    const todayFormatted = formatThaiDate(`${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`);
    
    switch(currentTab) {
        case 'today':
            $('#emptyMessage').text('ไม่มีการจองในวันนี้');
            $('#emptySubMessage').text(todayFormatted);
            $('#bookingResultText').text('ไม่มีการจองวันนี้');
            break;
        case 'all':
            $('#emptyMessage').text('ไม่มีการจองในเดือนนี้');
            $('#emptySubMessage').text('ลองเปลี่ยนเดือนหรือห้องเพื่อดูรายการอื่น');
            $('#bookingResultText').text('ไม่มีการจอง');
            break;
        case 'custom':
            if (customSelectedDate) {
                const dateFormatted = formatThaiDate(customSelectedDate);
                $('#emptyMessage').text('ไม่มีการจองในวันที่เลือก');
                $('#emptySubMessage').text(dateFormatted);
                $('#bookingResultText').text('ไม่มีการจอง');
            } else {
                $('#emptyMessage').text('กรุณาเลือกวันที่');
                $('#emptySubMessage').text('เลือกวันที่ที่ต้องการดูรายการจอง');
                $('#bookingResultText').text('เลือกวันที่');
            }
            break;
    }
}

function updateBookingResultText(count) {
    const today = new Date();
    const todayFormatted = formatThaiDate(`${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`);
    
    switch(currentTab) {
        case 'today':
            $('#bookingResultText').html(`<span class="text-purple-600 dark:text-purple-400">วันนี้</span> พบ ${count} รายการ`);
            break;
        case 'all':
            $('#bookingResultText').text(`พบ ${count} รายการในเดือนนี้`);
            break;
        case 'custom':
            if (customSelectedDate) {
                const dateFormatted = formatThaiDate(customSelectedDate);
                $('#bookingResultText').html(`<span class="text-purple-600 dark:text-purple-400">${dateFormatted}</span> พบ ${count} รายการ`);
            }
            break;
    }
}

function renderRoomList() {
    let html = '';
    allRooms.forEach((room, index) => {
        html += `
        <div class="group relative p-4 md:p-5 bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: fadeInUp 0.3s ease-out ${index * 0.05}s both;">
            <div class="absolute inset-0 bg-gradient-to-br from-${room.color || 'blue'}-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 flex items-center justify-center bg-gradient-to-br from-${room.color || 'blue'}-100 to-${room.color || 'blue'}-200 dark:from-${room.color || 'blue'}-900/50 dark:to-${room.color || 'blue'}-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    ${room.emoji || '🏢'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-1 truncate">${escapeHtml(room.room_name)}</h4>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-2 truncate flex items-center gap-1">
                        <i class="fas fa-building text-gray-400"></i> ${escapeHtml(room.building || '-')}
                    </p>
                    <div class="flex flex-wrap gap-2 text-[10px] md:text-xs">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-blue-100 to-cyan-100 dark:from-blue-900/40 dark:to-cyan-900/40 text-blue-600 dark:text-blue-400 rounded-full font-medium border border-blue-200 dark:border-blue-800">
                            <i class="fas fa-users"></i>${room.capacity} คน
                        </span>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    
    $('#roomList').html(html);
}

function showBookingDetail(id) {
    const booking = allBookings.find(b => b.id == id);
    if (!booking) return;
    
    const date = formatThaiDate(booking.date);
    const statusIcon = booking.status == 1 ? '✓' : booking.status == 0 ? '⏳' : '✗';
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-${booking.color || 'purple'}-50 to-indigo-50 dark:from-${booking.color || 'purple'}-900/30 dark:to-indigo-900/30 rounded-2xl">
                <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center bg-gradient-to-br from-${booking.color || 'purple'}-100 to-${booking.color || 'purple'}-200 dark:from-${booking.color || 'purple'}-900/50 dark:to-${booking.color || 'purple'}-800/30 rounded-2xl text-4xl md:text-5xl shadow-lg">
                    ${booking.emoji || '🏢'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white truncate">${escapeHtml(booking.room_name || booking.location)}</h4>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold mt-2 ${getStatusBgClass(booking.status)}">
                        <span>${statusIcon}</span> ${booking.status_text}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-purple-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-calendar-alt text-purple-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">วันที่</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-blue-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-clock text-blue-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">เวลา</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${booking.time_start.substring(0,5)} - ${booking.time_end.substring(0,5)}</p>
                </div>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-amber-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-bullseye text-amber-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">วัตถุประสงค์</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.purpose)}</p>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-emerald-50 to-green-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-emerald-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="far fa-user text-emerald-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">ผู้จอง</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.teacher_name_masked || '-')}</p>
            </div>
            
            ${booking.media ? `
            <div class="p-4 bg-gradient-to-br from-rose-50 to-pink-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-rose-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-tv text-rose-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">อุปกรณ์ที่ต้องการ</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.media)}</p>
            </div>
            ` : ''}
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
