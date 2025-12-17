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

    <!-- Filter Section -->
    <div class="glass rounded-xl md:rounded-2xl p-4 md:p-6 border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-4">
            <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg text-white text-sm md:text-lg shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-filter"></i>
                </span>
                กรองตารางการจอง
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                <div class="relative group">
                    <select id="filterCar" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-emerald-300 appearance-none bg-white dark:bg-slate-800">
                        <option value="">🚗 ทุกคัน</option>
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
                <div class="relative group">
                    <select id="filterMonth" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-emerald-300 appearance-none bg-white dark:bg-slate-800">
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
                    <select id="filterYear" class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer text-sm md:text-base transition-all duration-200 hover:border-emerald-300 appearance-none bg-white dark:bg-slate-800">
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-emerald-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-emerald-500/30">
                        📅
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">ปฏิทินการจอง</h2>
                        <p class="text-sm md:text-base font-medium bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent" id="calendarTitle">กำลังโหลด...</p>
                    </div>
                </div>
                <div class="flex gap-2 justify-center sm:justify-end">
                    <button onclick="prevMonth()" class="p-2.5 md:p-3 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 dark:border-gray-700 hover:-translate-x-0.5 active:scale-95">
                        <i class="fas fa-chevron-left text-emerald-600"></i>
                    </button>
                    <button onclick="goToday()" class="px-4 md:px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-medium hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 text-sm md:text-base">
                        <i class="far fa-calendar-check mr-1.5"></i>วันนี้
                    </button>
                    <button onclick="nextMonth()" class="p-2.5 md:p-3 bg-white dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200 dark:border-gray-700 hover:translate-x-0.5 active:scale-95">
                        <i class="fas fa-chevron-right text-emerald-600"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="p-3 md:p-6 overflow-x-auto bg-white dark:bg-slate-900/50">
            <!-- Loading -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block w-12 h-12 md:w-14 md:h-14 border-4 border-emerald-200 border-t-emerald-600 rounded-full animate-spin"></div>
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
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-teal-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-teal-50 to-emerald-50 dark:from-teal-900/20 dark:to-emerald-900/20">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-teal-500/30">
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
                        <button onclick="setBookingTab('today')" id="tabToday" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md">
                            <i class="fas fa-calendar-day mr-1.5"></i>วันนี้
                        </button>
                        <button onclick="setBookingTab('all')" id="tabAll" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fas fa-list mr-1.5"></i>ทั้งหมด
                        </button>
                        <button onclick="setBookingTab('custom')" id="tabCustom" class="tab-btn flex-shrink-0 whitespace-nowrap px-3 md:px-4 py-2 rounded-lg text-xs md:text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="far fa-calendar-alt mr-1.5"></i>เลือกวัน
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Date Picker (hidden by default) -->
            <div id="customDatePicker" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <i class="far fa-calendar text-emerald-500"></i>
                        เลือกวันที่:
                    </label>
                    <input type="date" id="customDate" class="px-4 py-2.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-sm">
                    <button onclick="applyCustomDate()" class="px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl text-sm font-medium hover:from-emerald-600 hover:to-teal-700 transition-all shadow-md hover:shadow-lg active:scale-95">
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
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1" id="emptySubMessage">ลองเปลี่ยนเดือนหรือรถเพื่อดูรายการอื่น</p>
            </div>
            
            <div id="bookingList" class="hidden space-y-3 md:space-y-4">
                <!-- Booking items will be inserted here -->
            </div>
        </div>
    </div>

    <!-- Car List -->
    <div class="glass rounded-xl md:rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-800 shadow-xl shadow-cyan-500/5">
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 md:w-14 md:h-14 flex items-center justify-center bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl md:rounded-2xl text-white text-xl md:text-2xl shadow-lg shadow-cyan-500/30">
                    🚗
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white">รถราชการทั้งหมด</h2>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400">รายการรถราชการที่พร้อมให้บริการ</p>
                </div>
            </div>
        </div>
        
        <div class="p-4 md:p-6 bg-white dark:bg-slate-900/50">
            <div id="carList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                <!-- Car cards will be inserted here -->
            </div>
        </div>
    </div>
</div>

<!-- Booking Detail Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-50 hidden flex items-center justify-center p-3 md:p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl md:rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700 animate-modal-in">
        <div class="p-5 md:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30">
            <div class="flex items-center justify-between">
                <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="w-8 h-8 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg text-white text-sm">
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
    background: rgba(16, 185, 129, 0.3);
    border-radius: 4px;
}
.scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: rgba(16, 185, 129, 0.5);
}
</style>

<script>
let currentMonth = new Date().getMonth() + 1;
let currentYear = new Date().getFullYear();
let allCars = [];
let allBookings = [];
let currentTab = 'today';
let customSelectedDate = null;

const thaiMonths = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
                    'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

$(document).ready(function() {
    initFilters();
    loadData();
    
    // Set default date for custom date picker
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    $('#customDate').val(todayStr);
    
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
        <div class="min-h-[70px] md:min-h-[90px] p-1 md:p-2 ${isToday ? 'bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/40 dark:to-teal-900/40 ring-2 ring-emerald-500 shadow-lg shadow-emerald-500/20' : hasBookings ? 'bg-white dark:bg-slate-800 shadow-sm' : 'bg-gray-50 dark:bg-slate-800/50'} rounded-xl hover:shadow-md transition-all duration-200 group cursor-pointer">
            <div class="text-right mb-1">
                <span class="inline-flex items-center justify-center w-6 h-6 md:w-8 md:h-8 text-xs md:text-sm font-bold ${isToday ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-full shadow-md' : isSunday ? 'text-red-500' : isSaturday ? 'text-blue-500' : 'text-gray-700 dark:text-gray-300'}">${day}</span>
            </div>
            <div class="space-y-0.5 md:space-y-1 max-h-[42px] md:max-h-[54px] overflow-y-auto scrollbar-thin">
                ${dayBookings.slice(0, 2).map(b => `
                    <div onclick="event.stopPropagation(); showBookingDetail(${b.id})" class="text-[9px] md:text-xs px-1.5 md:px-2 py-0.5 md:py-1 rounded-md cursor-pointer truncate font-medium transition-all hover:scale-[1.02] ${getStatusBgClass(b.status)}" title="${b.car_model || 'รถ'} - ${b.destination}">
                        <span class="hidden sm:inline">${b.emoji || '🚗'} ${b.license_plate ? b.license_plate.substring(0, 8) : ''}</span>
                        <span class="sm:hidden">${b.emoji || '🚗'}</span>
                    </div>
                `).join('')}
                ${dayBookings.length > 2 ? `<div class="text-[9px] md:text-xs text-center text-emerald-600 dark:text-emerald-400 font-medium bg-emerald-50 dark:bg-emerald-900/30 rounded-md py-0.5">+${dayBookings.length - 2} เพิ่มเติม</div>` : ''}
            </div>
        </div>
        `;
    }
    
    $('#calendarGrid').html(html);
    $('#calendarContainer').removeClass('hidden');
}

function getStatusBgClass(status) {
    // Handle both string status and numeric status_value
    if (status === 'pending' || status === 0) return 'bg-gradient-to-r from-amber-100 to-orange-100 dark:from-amber-900/40 dark:to-orange-900/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800';
    if (status === 'approved' || status === 1) return 'bg-gradient-to-r from-emerald-100 to-green-100 dark:from-emerald-900/40 dark:to-green-900/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800';
    if (status === 'rejected' || status === 2) return 'bg-gradient-to-r from-red-100 to-rose-100 dark:from-red-900/40 dark:to-rose-900/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800';
    return 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400 border border-gray-200 dark:border-gray-700';
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
        const date = formatThaiDate(b.booking_date);
        const startTime = b.start_time ? b.start_time.substring(11, 16) : '-';
        const statusIcon = b.status === 'approved' || b.status === 1 ? '✓' : b.status === 'pending' || b.status === 0 ? '⏳' : '✗';
        html += `
        <div onclick="showBookingDetail(${b.id})" class="group relative p-4 md:p-5 bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl hover:shadow-xl cursor-pointer transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: fadeInUp 0.3s ease-out ${index * 0.05}s both;">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    ${b.emoji || '🚗'}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white truncate">${escapeHtml(b.car_model || 'ไม่ระบุรถ')}</h4>
                        <span class="inline-flex items-center gap-1 px-2 md:px-2.5 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-semibold flex-shrink-0 ${getStatusBgClass(b.status)}">
                            <span>${statusIcon}</span> ${b.status_text}
                        </span>
                    </div>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-1 truncate max-w-full overflow-hidden">${escapeHtml(b.license_plate || '-')}</p>
                    <p class="text-xs md:text-sm text-gray-600 dark:text-gray-400 mb-1.5 md:mb-2 flex items-start gap-2 overflow-hidden">
                        <i class="fas fa-map-marker-alt mt-0.5 text-red-500 flex-shrink-0"></i>
                        <span class="truncate flex-1 w-0">${escapeHtml(b.destination || '-')}</span>
                    </p>
                    <div class="flex flex-wrap items-center gap-2 md:gap-3 text-[10px] md:text-xs text-gray-500 dark:text-gray-400">
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-calendar-alt text-emerald-500"></i>${date}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <i class="far fa-clock text-blue-500"></i>${startTime}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hidden sm:inline-flex min-w-0 max-w-[160px]">
                            <i class="far fa-user text-teal-500 flex-shrink-0"></i>
                            <span class="truncate">${escapeHtml(b.teacher_name_masked || '-')}</span>
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
            return allBookings.filter(b => b.booking_date === todayStr);
        case 'all':
            return allBookings;
        case 'custom':
            if (customSelectedDate) {
                return allBookings.filter(b => b.booking_date === customSelectedDate);
            }
            return allBookings;
        default:
            return allBookings;
    }
}

function setBookingTab(tab) {
    currentTab = tab;
    
    // Update tab buttons style
    $('.tab-btn').removeClass('bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md')
        .addClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700');
    
    const activeBtn = $(`#tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`);
    activeBtn.removeClass('text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700')
        .addClass('bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md');
    
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
            $('#emptySubMessage').text('ลองเปลี่ยนเดือนหรือรถเพื่อดูรายการอื่น');
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
            $('#bookingResultText').html(`<span class="text-emerald-600 dark:text-emerald-400">วันนี้</span> พบ ${count} รายการ`);
            break;
        case 'all':
            $('#bookingResultText').text(`พบ ${count} รายการในเดือนนี้`);
            break;
        case 'custom':
            if (customSelectedDate) {
                const dateFormatted = formatThaiDate(customSelectedDate);
                $('#bookingResultText').html(`<span class="text-emerald-600 dark:text-emerald-400">${dateFormatted}</span> พบ ${count} รายการ`);
            }
            break;
    }
}

function renderCarList() {
    let html = '';
    allCars.forEach((car, index) => {
        html += `
        <div class="group relative p-4 md:p-5 bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700 overflow-hidden" style="animation: fadeInUp 0.3s ease-out ${index * 0.05}s both;">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-start gap-3 md:gap-4">
                <div class="flex-shrink-0 w-14 h-14 md:w-16 md:h-16 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/30 rounded-xl md:rounded-2xl text-2xl md:text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-lg">
                    ${car.emoji || '🚗'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-sm md:text-base text-gray-900 dark:text-white mb-1 truncate">${escapeHtml(car.car_model)}</h4>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-2">${escapeHtml(car.license_plate)}</p>
                    <div class="flex flex-wrap gap-2 text-[10px] md:text-xs">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-cyan-100 to-blue-100 dark:from-cyan-900/40 dark:to-blue-900/40 text-cyan-600 dark:text-cyan-400 rounded-full font-medium border border-cyan-200 dark:border-cyan-800">
                            ${escapeHtml(car.car_type)}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 dark:from-blue-900/40 dark:to-indigo-900/40 text-blue-600 dark:text-blue-400 rounded-full font-medium border border-blue-200 dark:border-blue-800">
                            <i class="fas fa-users"></i>${car.capacity} คน
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
    const statusIcon = booking.status === 'approved' || booking.status === 1 ? '✓' : booking.status === 'pending' || booking.status === 0 ? '⏳' : '✗';
    
    const html = `
        <div class="space-y-4">
            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-2xl">
                <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/50 dark:to-emerald-800/30 rounded-2xl text-4xl md:text-5xl shadow-lg">
                    ${booking.emoji || '🚗'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white truncate">${escapeHtml(booking.car_model || 'ไม่ระบุรถ')}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${escapeHtml(booking.license_plate || '-')}</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold mt-2 ${getStatusBgClass(booking.status)}">
                        <span>${statusIcon}</span> ${booking.status_text}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="p-4 bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-emerald-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-calendar-alt text-emerald-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">วันที่</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${date}</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-blue-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="far fa-clock text-blue-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">เวลา</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${startTime} - ${endTime} น.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div class="p-4 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-purple-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-users text-purple-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">จำนวนผู้โดยสาร</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${booking.passenger_count || '-'} คน</p>
                </div>
                <div class="p-4 bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-cyan-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-car text-cyan-500"></i>
                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">ความจุรถ</p>
                    </div>
                    <p class="font-bold text-gray-900 dark:text-white">${booking.capacity || '-'} คน</p>
                </div>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-red-50 to-rose-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-red-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-map-marker-alt text-red-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">ปลายทาง</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.destination || '-')}</p>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-amber-50 to-orange-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-amber-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-bullseye text-amber-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">วัตถุประสงค์</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white">${escapeHtml(booking.purpose || '-')}</p>
            </div>
            
            <div class="p-4 bg-gradient-to-br from-teal-50 to-green-50 dark:from-slate-700/50 dark:to-slate-700/30 rounded-xl border border-teal-100 dark:border-gray-700">
                <div class="flex items-center gap-2 mb-1">
                    <i class="far fa-user text-teal-500"></i>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">ผู้จอง</p>
                </div>
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
