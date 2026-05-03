<!-- Repair Report View -->
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 no-print-section">
        <div>
            <h1 class="text-3xl font-black gradient-text flex items-center gap-3">
                <span class="text-4xl">📊</span> สรุปรายงานการแจ้งซ่อม
            </h1>
            <p class="mt-1 text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-xs">ตรวจสอบสถิติและพิมพ์รายงานสรุปงานซ่อมบำรุง</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.location.href='repair.php'"
                class="px-4 py-2 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> กลับหน้าจัดการ
            </button>
            <button onclick="window.print()"
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-fuchsia-600 text-white rounded-xl font-black shadow-lg shadow-indigo-500/30 hover:scale-105 transition-all flex items-center gap-2">
                <i class="fas fa-print"></i> พิมพ์รายงาน
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-md rounded-[2.5rem] p-8 border border-white/20 shadow-xl no-print-section">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">ช่วงวันที่เริ่มต้น</label>
                <input type="date" id="startDate" class="w-full px-5 py-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold text-slate-700 dark:text-white">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">ช่วงวันที่สิ้นสุด</label>
                <input type="date" id="endDate" class="w-full px-5 py-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold text-slate-700 dark:text-white">
            </div>
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">สถานะงานซ่อม</label>
                <select id="statusFilter" class="w-full px-5 py-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 focus:ring-2 focus:ring-indigo-500 outline-none transition-all font-bold text-slate-700 dark:text-white">
                    <option value="">ทั้งหมดทุกสถานะ</option>
                    <option value="0">รายการแจ้งใหม่</option>
                    <option value="1">รอพิจารณา/งบ</option>
                    <option value="2">กำลังดำเนินการ</option>
                    <option value="3">ตรวจสอบ/ทดสอบ</option>
                    <option value="4">ดำเนินการเสร็จสิ้น</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button id="applyFilter" class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl font-black hover:shadow-lg hover:shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> ค้นหาข้อมูล
                </button>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-slate-100 dark:border-slate-700">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2 self-center">ทางลัด:</span>
            <button onclick="setFilterRange('week')" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">สัปดาห์นี้</button>
            <button onclick="setFilterRange('month')" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">เดือนนี้</button>
            <button onclick="setFilterRange('year')" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">ปีนี้</button>
        </div>
    </div>

    <!-- Report View Container -->
    <div id="reportContainer" class="bg-white p-2 min-h-[600px] rounded-[3rem] shadow-2xl overflow-x-auto border border-slate-100">
        <div id="reportLoader" class="flex flex-col items-center justify-center py-20 text-slate-400">
            <div class="loader-report mb-4"></div>
            <p class="font-black uppercase tracking-widest text-xs">กำลังเตรียมข้อมูลรายงาน...</p>
        </div>
        <div id="reportContent" class="p-12">
            <!-- Report HTML will be injected here -->
        </div>
    </div>
</div>

<style>
    .loader-report {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #6366f1;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    @media print {
        @page { size: A4 landscape; margin: 1cm; }
        .no-print-section, .navbar, .left-sidebar, .sidebar, footer, #sidebar-wrapper, #header-wrapper { display: none !important; }
        .lg\:ml-64, main { margin: 0 !important; padding: 0 !important; margin-left: 0 !important; }
        #reportContainer { border: none !important; box-shadow: none !important; margin: 0 !important; width: 100% !important; }
        .report-table { border-collapse: collapse !important; width: 100% !important; }
        .report-table th, .report-table td { border: 0.5pt solid #000 !important; padding: 6px !important; font-size: 10pt !important; }
        .report-header { text-align: center !important; margin-bottom: 20px !important; }
    }

    .report-table { width: 100%; border-collapse: collapse; }
    .report-table th { background-color: #f8fafc; color: #475569; font-weight: 800; padding: 15px 10px; border: 1px solid #e2e8f0; text-align: center; font-size: 11px; text-transform: uppercase; }
    .report-table td { padding: 12px 10px; border: 1px solid #e2e8f0; vertical-align: middle; color: #1e293b; font-size: 12px; }
    .report-table tr:nth-child(even) { background-color: #fbfcfe; }
    .report-title { font-size: 24px; font-weight: 900; text-align: center; margin-bottom: 10px; color: #1e293b; }
    .report-subtitle { font-size: 14px; font-weight: 700; text-align: center; margin-bottom: 30px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
</style>

<script src="views/repair/report.js"></script>
