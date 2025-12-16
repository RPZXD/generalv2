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
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                ระบบจองรถ
            </span>
            <button id="addBookingBtn" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>จองรถยนต์</span>
                <span>🚗</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                <button id="showTableBtn" class="view-toggle-btn active px-6 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-table"></i>
                    <span>ตาราง</span>
                </button>
                <button id="showCalendarBtn" class="view-toggle-btn px-6 py-2 rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span>ปฏิทิน</span>
                </button>
            </div>

            <!-- Refresh Button -->
            <button id="refreshList" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                <i class="fas fa-sync-alt"></i>
                รีเฟรช
            </button>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView" class="glass rounded-2xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg text-white">
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
                    <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-700 dark:to-slate-600 text-gray-700 dark:text-gray-200">
                        <th class="py-4 px-4 text-center rounded-tl-xl">#</th>
                        <th class="py-4 px-4 text-left">ผู้จอง</th>
                        <th class="py-4 px-4 text-left">รถยนต์</th>
                        <th class="py-4 px-4 text-center">วันที่จอง</th>
                        <th class="py-4 px-4 text-center">วันเวลาที่ใช้</th>
                        <th class="py-4 px-4 text-left">จุดหมาย</th>
                        <th class="py-4 px-4 text-left">วัตถุประสงค์</th>
                        <th class="py-4 px-4 text-center">จำนวน</th>
                        <th class="py-4 px-4 text-center">สถานะ</th>
                        <th class="py-4 px-4 text-center rounded-tr-xl">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="bookingTableBody">
                    <tr>
                        <td colspan="10" class="text-center py-8 text-gray-400">
                            <div class="loader mx-auto mb-4"></div>
                            <p>กำลังโหลดข้อมูล...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="hidden">
        <!-- Legend -->
        <div class="glass rounded-2xl p-4 mb-4">
            <div class="flex items-center gap-3 mb-3">
                <i class="fas fa-palette text-blue-500"></i>
                <span class="font-medium text-gray-700 dark:text-gray-300">คำอธิบายสีรถ</span>
            </div>
            <div class="flex flex-wrap gap-2" id="legendItems">
                <!-- Dynamic content -->
            </div>
        </div>

        <div class="glass rounded-2xl p-6">
            <div id="carBookingCalendar"></div>
        </div>
    </div>
</div>

<!-- Modal เพิ่มการจอง -->
<div id="addBookingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeAddBookingModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-green-500 rounded-xl shadow-lg text-white">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ชื่อ-นามสกุล <span class="text-red-500">*</span></label>
                        <input type="text" name="teacher_name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="<?=$TeacherData['Teach_name']?>" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ตำแหน่ง <span class="text-red-500">*</span></label>
                        <input type="text" name="teacher_position" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="<?= ($TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (บกศ.)" || $TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (สพฐ.)") ? "ครูอัตราจ้าง" : $TeacherData['Teach_Position2']; ?>" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทร <span class="text-red-500">*</span></label>
                        <input type="tel" name="teacher_phone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="<?= $TeacherData['Teach_phone'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- ข้อมูลการจอง -->
            <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-5">
                <h4 class="text-lg font-semibold text-green-700 dark:text-green-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list"></i> ข้อมูลการจอง
                </h4>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เลือกรถยนต์ <span class="text-red-500">*</span></label>
                    <select name="car_id" id="carSelect" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="">-- เลือกรถยนต์ --</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาเริ่มต้น <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_datetime" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาสิ้นสุด <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_datetime" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ขออนุญาตใช้รถ (ไปไหน) <span class="text-red-500">*</span></label>
                        <input type="text" name="destination" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="สถานที่ที่ต้องการไป">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จุดประสงค์ (เพื่อ) <span class="text-red-500">*</span></label>
                        <input type="text" name="purpose" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="วัตถุประสงค์">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รายชื่อผู้โดยสาร (ครู/เจ้าหน้าที่)</label>
                    <div id="passengersList" class="space-y-2">
                        <div class="passenger-item flex gap-2">
                            <input type="text" name="passengers[]" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="<?=$TeacherData['Teach_name']?>" readonly>
                            <span class="px-4 py-2 bg-gray-100 dark:bg-slate-600 text-gray-500 dark:text-gray-400 rounded-xl text-sm">หัวหน้าคณะ</span>
                        </div>
                    </div>
                    <button type="button" id="addPassengerBtn" class="mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> เพิ่มผู้โดยสาร
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จำนวนนักเรียน (คน)</label>
                        <input type="number" name="student_count" min="0" value="0" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" onchange="calculateTotal()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รวมผู้โดยสาร (คน)</label>
                        <input type="number" name="total_passengers" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-blue-600 dark:text-blue-400 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ความจุรถ (คน)</label>
                        <input type="number" id="carCapacity" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-green-600 dark:text-green-400 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ</label>
                    <textarea name="notes" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="หมายเหตุเพิ่มเติม (ไม่บังคับ)"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" id="cancelAddBooking" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-colors">
                    ยกเลิก
                </button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>บันทึกการจอง</span>
                    <span>🚀</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal แก้ไขการจอง -->
<div id="editBookingModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeEditBookingModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-yellow-500 to-amber-500 rounded-xl shadow-lg text-white">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ชื่อ-นามสกุล</label>
                        <input type="text" name="teacher_name" id="editTeacherName" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ตำแหน่ง</label>
                        <input type="text" name="teacher_position" id="editTeacherPosition" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทร</label>
                        <input type="tel" name="teacher_phone" id="editTeacherPhone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
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
                    <select name="car_id" id="editCarSelect" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="">-- เลือกรถยนต์ --</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาเริ่มต้น</label>
                        <input type="datetime-local" name="start_datetime" id="editStartDateTime" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันเวลาสิ้นสุด</label>
                        <input type="datetime-local" name="end_datetime" id="editEndDateTime" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ขออนุญาตใช้รถ (ไปไหน)</label>
                        <input type="text" name="destination" id="editDestination" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จุดประสงค์ (เพื่อ)</label>
                        <input type="text" name="purpose" id="editPurpose" required class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รายชื่อผู้โดยสาร</label>
                    <div id="editPassengersList" class="space-y-2">
                        <!-- Dynamic content -->
                    </div>
                    <button type="button" id="editAddPassengerBtn" class="mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl transition-colors flex items-center gap-2">
                        <i class="fas fa-plus"></i> เพิ่มผู้โดยสาร
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">จำนวนนักเรียน (คน)</label>
                        <input type="number" name="student_count" id="editStudentCount" min="0" value="0" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" onchange="calculateTotalEdit()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">รวมผู้โดยสาร (คน)</label>
                        <input type="number" name="total_passengers" id="editTotalPassengers" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-blue-600 dark:text-blue-400 font-bold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ความจุรถ (คน)</label>
                        <input type="number" id="editCarCapacity" readonly class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-slate-600 text-green-600 dark:text-green-400 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">หมายเหตุ</label>
                    <textarea name="notes" id="editNotes" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" id="cancelEditBooking" class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-slate-600 dark:hover:bg-slate-500 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-colors">
                    ยกเลิก
                </button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
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
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.view-toggle-btn:hover:not(.active) {
    background: rgba(59, 130, 246, 0.1);
}

/* Table row hover */
#bookingTable tbody tr {
    transition: all 0.2s ease;
}
#bookingTable tbody tr:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(99, 102, 241, 0.05));
    transform: translateY(-1px);
}

/* Status badge animation */
.status-badge {
    position: relative;
    overflow: hidden;
}
.status-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}
.status-badge:hover::before {
    left: 100%;
}

/* FullCalendar custom */
.fc-event {
    border-radius: 8px !important;
    border: none !important;
    padding: 2px 6px !important;
    font-size: 0.75rem !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.2s ease !important;
}
.fc-event:hover {
    transform: scale(1.02) !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
}
</style>

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- Pass PHP variables to JavaScript -->
<script>
    const teacher_id = "<?php echo $teacher_id; ?>";
    const teacherName = "<?php echo $TeacherData['Teach_name']; ?>";
</script>

<!-- Car Booking Script -->
<script src="views/car_booking/script.js"></script>
