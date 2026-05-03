<!-- Car Booking Report View -->
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 no-print-section">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">📊</span> สรุปรายงานการใช้รถยนต์
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ตรวจสอบสถิติและพิมพ์รายงานสรุปการใช้รถยนต์ส่วนกลาง</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.location.href='car_booking.php'"
                class="px-4 py-2 bg-white dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl font-medium shadow-sm border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> กลับหน้าจัดการ
            </button>
            <button onclick="exportToWord()"
                class="px-4 py-2 bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-xl font-medium shadow-lg hover:shadow-blue-500/30 transition-all flex items-center gap-2">
                <i class="fas fa-file-word"></i> ส่งออกเป็น Word
            </button>
            <button onclick="window.print()"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:scale-105 transition-all flex items-center gap-2">
                <i class="fas fa-print"></i> พิมพ์รายงาน
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass rounded-3xl p-6 shadow-sm border border-white/20 no-print-section">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">ช่วงวันที่เริ่มต้น</label>
                <div class="relative">
                    <input type="date" id="startDate" class="w-full px-4 py-3 bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">ช่วงวันที่สิ้นสุด</label>
                <div class="relative">
                    <input type="date" id="endDate" class="w-full px-4 py-3 bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300">เลือกเฉพาะรถ (เลือกได้)</label>
                <select id="carFilter" class="w-full px-4 py-3 bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <option value="">ทั้งหมดทุกคัน</option>
                    <!-- Cars will be loaded here -->
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button id="applyFilter" class="flex-1 py-3 bg-emerald-500 text-white rounded-2xl font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-search mr-2"></i> ค้นหาข้อมูล
                </button>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-2 self-center">ทางลัด:</span>
            <button onclick="setFilterRange('week')" class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-blue-500 hover:text-white transition-all">สัปดาห์นี้</button>
            <button onclick="setFilterRange('month')" class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-blue-500 hover:text-white transition-all">เดือนนี้</button>
            <button onclick="setFilterRange('lastMonth')" class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-blue-500 hover:text-white transition-all">เดือนที่แล้ว</button>
            <button onclick="setFilterRange('year')" class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-blue-500 hover:text-white transition-all">ปีนี้ (มกราคม-ปัจจุบัน)</button>
            <button onclick="setFilterRange('fiscal')" class="px-4 py-2 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-blue-500 hover:text-white transition-all">ปีงบประมาณนี้</button>
        </div>
    </div>

    <!-- Format Switcher -->
    <div class="flex bg-white dark:bg-slate-800 p-1.5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 w-full max-w-3xl mx-auto no-print-section">
        <button onclick="switchFormat(1)" id="btnFormat1" class="format-tab-btn active flex-1 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition-all">
            <span class="text-lg">📄</span> รูปแบบ 1: รายการละเอียด
        </button>
        <button onclick="switchFormat(2)" id="btnFormat2" class="format-tab-btn flex-1 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition-all">
            <span class="text-lg">📋</span> รูปแบบ 2: สถิติราชการ
        </button>
        <button onclick="switchFormat(3)" id="btnFormat3" class="format-tab-btn flex-1 py-3 px-4 rounded-xl flex items-center justify-center gap-2 text-sm font-bold transition-all">
            <span class="text-lg">📉</span> รูปแบบ 3: สรุปภาพรวม
        </button>
    </div>

    <!-- Report View Container -->
    <div id="reportContainer" class="bg-white p-2 min-h-[600px] rounded-3xl shadow-xl overflow-x-auto">
        <div id="reportLoader" class="flex flex-col items-center justify-center py-20 text-gray-400">
            <div class="loader-report mb-4"></div>
            <p class="font-medium">กำลังเตรียมข้อมูลรายงาน...</p>
        </div>
        <div id="reportContent" class="p-8">
            <!-- Report HTML will be injected here -->
        </div>
    </div>
</div>

<style>
    /* Tab Styling */
    .format-tab-btn {
        color: #64748b;
    }
    .format-tab-btn:hover {
        background: #f8fafc;
        color: #334155;
    }
    .dark .format-tab-btn:hover {
        background: #1e293b;
        color: #e2e8f0;
    }
    .format-tab-btn.active {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .loader-report {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* Print Specific Styling */
    @media print {
        @page {
            size: A4 landscape;
            margin: 0.5cm;
        }
        body {
            background: white !important;
            color: black !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        /* Hide ALL standard layout elements */
        .no-print-section, 
        .navbar, 
        .left-sidebar, 
        .sidebar,
        .card-actions, 
        button, 
        footer,
        #sidebar-wrapper,
        #header-wrapper,
        .theme-switcher,
        .user-menu,
        header, 
        aside,
        #sidebar-overlay,
        #preloader {
            display: none !important;
        }
        
        /* Reset margins/paddings from layout containers */
        .flex-1, .lg\:ml-64, main {
            margin: 0 !important;
            padding: 0 !important;
            margin-left: 0 !important;
        }
        
        /* Ensure the container takes full width and is visible */
        #reportContainer {
            display: block !important;
            visibility: visible !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            border: none !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
        }
        
        #reportContent {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .glass {
            background: transparent !important;
            backdrop-filter: none !important;
            border: none !important;
        }
        h1, h2, h3, p, span, td, th {
            color: black !important;
        }
        .report-table {
            border-collapse: collapse !important;
            width: 100% !important;
            table-layout: auto !important;
        }
        .report-table th, .report-table td {
            border: 1px solid #000 !important;
            padding: 4px 6px !important;
            font-size: 9pt !important;
            word-wrap: break-word !important;
        }
        .report-header {
            text-align: center !important;
            margin-bottom: 20px !important;
            width: 100% !important;
        }
    }

    /* Screen Table Styling */
    .report-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .report-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 12px 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }
    .report-table td {
        padding: 10px 8px;
        border: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1e293b;
    }
    .report-table tr:nth-child(even) {
        background-color: #fbfcfe;
    }
    
    .report-title {
        font-size: 20px;
        font-weight: 800;
        text-align: center;
        margin-bottom: 5px;
        color: #0f172a;
    }
    .report-subtitle {
        font-size: 16px;
        text-align: center;
        margin-bottom: 20px;
        color: #475569;
    }
</style>

<script src="views/car_booking/report.js"></script>
