<!-- Car Booking Page Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🚗</span> จองรถยนต์
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ระบบจองรถยนต์ราชการออนไลน์</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-3">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                ระบบจองรถ
            </span>
            <button id="addBookingBtn"
                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>จองรถยนต์</span>
                <span>🚗</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="glass rounded-2xl p-5 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รอพิจารณา</p>
                    <p class="text-3xl font-bold text-yellow-600" id="pendingCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/30 rounded-xl">
                    <i class="fas fa-clock text-2xl text-yellow-500"></i>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">อนุมัติแล้ว</p>
                    <p class="text-3xl font-bold text-green-600" id="approvedCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-green-100 dark:bg-green-900/30 rounded-xl">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                </div>
            </div>
        </div>
        <div class="glass rounded-2xl p-5 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รวมทั้งหมด</p>
                    <p class="text-3xl font-bold text-blue-600" id="totalCount">0</p>
                </div>
                <div class="w-14 h-14 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                    <i class="fas fa-car text-2xl text-blue-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- View Toggle & Actions -->
    <div class="glass rounded-2xl p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <!-- View Toggle -->
            <div class="flex bg-gray-100 dark:bg-slate-700 rounded-xl p-1">
                <button id="showTableBtn"
                    class="view-toggle-btn active px-6 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-table"></i>
                    <span>ตาราง</span>
                </button>
                <button id="showCalendarBtn"
                    class="view-toggle-btn px-6 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>ปฏิทิน</span>
                </button>
            </div>

            <!-- Refresh Button -->
            <button id="refreshList"
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                <i class="fas fa-sync-alt"></i>
                รีเฟรช
            </button>
        </div>
    </div>

    <!-- List View (Table on Desktop, Cards on Mobile) -->
    <div id="tableView" class="space-y-4">
        <!-- Desktop Table View -->
        <div class="hidden md:block glass rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-6">
                <div
                    class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg text-white">
                    <i class="fas fa-list-alt text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 รายการจองรถยนต์</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">รายการจองรถยนต์ทั้งหมดของคุณ</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="bookingTable" class="w-full text-sm">
                    <thead>
                        <tr
                            class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-700 dark:to-slate-600 text-gray-700 dark:text-gray-200">
                            <th class="py-4 px-4 text-center rounded-tl-xl">#</th>
                            <th class="py-4 px-4 text-left">ผู้จอง</th>
                            <th class="py-4 px-4 text-left">รถยนต์</th>
                            <th class="py-4 px-4 text-center">วันที่จอง</th>
                            <th class="py-4 px-4 text-center">วันเวลาที่ใช้</th>
                            <th class="py-4 px-4 text-left">จุดหมาย</th>
                            <th class="py-4 px-4 text-left">วัตถุประสงค์</th>
                            <th class="py-4 px-4 text-center">จำนวน</th>
                            <th class="py-4 px-4 text-left">คนขับรถ</th>
                            <th class="py-4 px-4 text-center">สถานะ</th>
                            <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTableBody">
                        <tr>
                            <td colspan="11" class="text-center py-8 text-gray-400">
                                <div class="loader mx-auto mb-4"></div>
                                <p>กำลังโหลดข้อมูล...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4" id="bookingCardList">
            <!-- JS will render cards here -->
            <div class="glass rounded-2xl p-8 text-center text-gray-400">
                <div class="loader mx-auto mb-4"></div>
                <p>กำลังโหลดข้อมูล...</p>
            </div>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="hidden animate-fade-in space-y-4">
        <!-- Legend & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="lg:col-span-3 glass rounded-2xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-xl">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">คำอธิบายสีรถ</span>
                            <p class="text-xs text-gray-500">แยกสีตามรถยนต์แต่ละคัน</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3" id="legendItems">
                    <!-- Dynamic content -->
                </div>
            </div>
            
            <div class="glass rounded-2xl p-5 flex flex-col justify-center items-center text-center">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white" id="calendarEventCount">0</div>
                <div class="text-xs text-gray-500">รายการจองในเดือนนี้</div>
            </div>
        </div>

        <div class="glass rounded-2xl p-4 md:p-8 relative min-h-[600px]">
            <!-- Calendar Loader Overlay -->
            <div id="calendarLoader" class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm rounded-2xl transition-all duration-200">
                <div class="loader mb-4 border-4 border-blue-500/20 border-t-blue-600 w-12 h-12"></div>
                <p class="text-blue-600 font-bold animate-pulse">กำลังจัดเตรียมปฏิทิน...</p>
            </div>
            
            <div id="carBookingCalendar"></div>
        </div>
    </div>
</div>

<!-- Modal เพิ่มการจอง -->
<div id="addBookingModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div
        class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeAddBookingModal"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div
                class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-green-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-car text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">🚗 จองรถยนต์ใหม่</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">กรอกรายละเอียดการจอง</p>
            </div>
        </div>

        <form id="addBookingForm" class="space-y-6">
            <!-- ข้อมูลผู้จอง -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5">
                <h4 class="text-lg font-semibold text-blue-700 dark:text-blue-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-user"></i> ข้อมูลผู้จอง
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ชื่อ-นามสกุล
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="teacher_name" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            value="<?= $TeacherData['Teach_name'] ?>" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ตำแหน่ง <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="teacher_position" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            value="<?= ($TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (บกศ.)" || $TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (สพฐ.)") ? "ครูอัตราจ้าง" : $TeacherData['Teach_Position2']; ?>"
                            readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทร <span
                                class="text-red-500">*</span></label>
                        <input type="tel" name="teacher_phone" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            value="<?= $TeacherData['Teach_phone'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- ข้อมูลการจอง -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-5">
                <h4 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> ข้อมูลการจอง
                </h4>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เลือกรถยนต์ <span
                            class="text-red-500">*</span></label>
                    <select name="car_id" id="carSelect" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="">-- เลือกรถยนต์ --</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาเริ่มต้น
                            <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_datetime" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาสิ้นสุด
                            <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_datetime" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ขออนุญาตใช้รถ
                            (ไปไหน) <span class="text-red-500">*</span></label>
                        <input type="text" name="destination" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            placeholder="สถานที่ที่ต้องการไป">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จุดประสงค์
                            (เพื่อ) <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            placeholder="วัตถุประสงค์">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รายชื่อผู้โดยสาร
                        (ครู/เจ้าหน้าที่)</label>
                    <div id="passengersList" class="space-y-2">
                        <div class="passenger-item flex gap-2">
                            <input type="text" name="passengers[]"
                                class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                                value="<?= $TeacherData['Teach_name'] ?>" readonly>
                            <span
                                class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-xl text-sm">หัวหน้าคณะ</span>
                        </div>
                    </div>
                    <button type="button" id="addPassengerBtn"
                        class="mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> เพิ่มผู้โดยสาร
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จำนวนนักเรียน
                            (คน)</label>
                        <input type="number" name="student_count" min="0" value="0"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            onchange="calculateTotal()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รวมผู้โดยสาร
                            (คน)</label>
                        <input type="number" name="total_passengers" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-blue-600 dark:text-blue-400 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ความจุรถ
                            (คน)</label>
                        <input type="number" id="carCapacity" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-green-600 dark:text-green-400 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ</label>
                    <textarea name="notes" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                        placeholder="หมายเหตุเพิ่มเติม (ไม่บังคับ)"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" id="cancelAddBooking"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-colors">
                    ยกเลิก
                </button>
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>บันทึกการจอง</span>
                    <span>🚀</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal แก้ไขการจอง -->
<div id="editBookingModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div
        class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeEditBookingModal"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div
                class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-edit text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">✏️ แก้ไขการจอง</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">แก้ไขรายละเอียดการจอง</p>
            </div>
        </div>

        <form id="editBookingForm" class="space-y-6">
            <input type="hidden" name="id" id="editBookingId">

            <!-- ข้อมูลผู้จอง -->
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5">
                <h4 class="text-lg font-semibold text-blue-700 dark:text-blue-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-user"></i> ข้อมูลผู้จอง
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ชื่อ-นามสกุล</label>
                        <input type="text" name="teacher_name" id="editTeacherName" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ตำแหน่ง</label>
                        <input type="text" name="teacher_position" id="editTeacherPosition" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทร</label>
                        <input type="tel" name="teacher_phone" id="editTeacherPhone" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- ข้อมูลการจอง -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-5">
                <h4 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> ข้อมูลการจอง
                </h4>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เลือกรถยนต์</label>
                    <select name="car_id" id="editCarSelect" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="">-- เลือกรถยนต์ --</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาเริ่มต้น</label>
                        <input type="datetime-local" name="start_datetime" id="editStartDateTime" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาสิ้นสุด</label>
                        <input type="datetime-local" name="end_datetime" id="editEndDateTime" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ขออนุญาตใช้รถ
                            (ไปไหน)</label>
                        <input type="text" name="destination" id="editDestination" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จุดประสงค์
                            (เพื่อ)</label>
                        <input type="text" name="purpose" id="editPurpose" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="mb-4">
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รายชื่อผู้โดยสาร</label>
                    <div id="editPassengersList" class="space-y-2">
                        <!-- Dynamic content -->
                    </div>
                    <button type="button" id="editAddPassengerBtn"
                        class="mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> เพิ่มผู้โดยสาร
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จำนวนนักเรียน
                            (คน)</label>
                        <input type="number" name="student_count" id="editStudentCount" min="0" value="0"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"
                            onchange="calculateTotalEdit()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รวมผู้โดยสาร
                            (คน)</label>
                        <input type="number" name="total_passengers" id="editTotalPassengers" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-blue-600 dark:text-blue-400 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ความจุรถ
                            (คน)</label>
                        <input type="number" id="editCarCapacity" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-green-600 dark:text-green-400 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ</label>
                    <textarea name="notes" id="editNotes" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" id="cancelEditBooking"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-colors">
                    ยกเลิก
                </button>
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>บันทึกการแก้ไข</span>
                    <span>💾</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* View toggle styles */
    .view-toggle-btn {
        color: #6b7280;
        background: transparent;
    }

    .view-toggle-btn.active {
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .view-toggle-btn:hover:not(.active) {
        background: rgba(59, 130, 246, 0.08);
        color: #3b82f6;
    }

    /* Table row hover */
    #bookingTable tbody tr {
        transition: all 0.2s ease;
    }

    #bookingTable tbody tr:hover {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(99, 102, 241, 0.05));
        transform: translateY(-1px);
    }

    /* Responsive Card List */
    .booking-mobile-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-left: 4px solid #3b82f6;
        transition: all 0.3s ease;
    }

    .dark .booking-mobile-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-left: 4px solid #3b82f6;
    }

    .booking-mobile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.1);
    }

    /* FullCalendar Premium Styles */
    #carBookingCalendar {
        font-family: 'Mali', sans-serif;
    }

    .fc {
        --fc-border-color: rgba(0, 0, 0, 0.05);
        --fc-today-bg-color: rgba(59, 130, 246, 0.05);
        --fc-button-bg-color: #3b82f6;
        --fc-button-border-color: #3b82f6;
        --fc-button-hover-bg-color: #2563eb;
        --fc-button-hover-border-color: #2563eb;
        --fc-button-active-bg-color: #1e40af;
        --fc-button-active-border-color: #1e40af;
        --fc-event-border-color: transparent;
        --fc-list-event-hover-bg-color: rgba(59, 130, 246, 0.05);
    }

    .dark .fc {
        --fc-border-color: rgba(255, 255, 255, 0.05);
        --fc-today-bg-color: rgba(59, 130, 246, 0.1);
        --fc-page-bg-color: transparent;
    }

    .fc .fc-toolbar-title {
        font-size: 1.5rem !important;
        font-weight: 800 !important;
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .fc .fc-button {
        border-radius: 12px !important;
        font-weight: 600 !important;
        text-transform: none !important;
        padding: 0.6rem 1.2rem !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    }

    .fc .fc-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3) !important;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active, 
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #1e40af !important;
        transform: translateY(0);
    }

    .fc-event {
        cursor: pointer;
        transition: all 0.2s ease !important;
        border-radius: 6px !important;
        padding: 2px 4px !important;
        font-size: 0.85rem !important;
    }

    .fc-event:hover {
        transform: scale(1.02);
        filter: brightness(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border: 1px solid var(--fc-border-color) !important;
    }

    .fc .fc-col-header-cell-cushion {
        padding: 12px 4px !important;
        font-weight: 700 !important;
        color: #6b7280;
    }

    .dark .fc .fc-col-header-cell-cushion {
        color: #9ca3af;
    }

    .fc .fc-daygrid-day-number {
        padding: 8px !important;
        font-weight: 500;
        color: #9ca3af;
    }

    .fc .fc-day-today .fc-daygrid-day-number {
        color: #3b82f6;
        font-weight: 800;
    }

    @media (max-width: 767px) {
        .fc .fc-toolbar {
            flex-direction: column;
            gap: 1rem;
        }
        .fc .fc-toolbar-title {
            font-size: 1.25rem !important;
        }
    }
</style>

<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- Pass PHP variables to JavaScript -->
<script>
    const teacher_id = "<?php echo $teacher_id; ?>";
    const teacherName = "<?php echo $TeacherData['Teach_name']; ?>";
</script>

<!-- Car Booking Script -->
<script src="views/car_booking/script.js"></script>