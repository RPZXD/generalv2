<!-- Room Booking Page Content -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">🏢</span> จองห้องประชุม 
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">ระบบจองห้องประชุมออนไลน์</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                <span class="w-2 h-2 bg-purple-500 rounded-full mr-2 animate-pulse"></span>
                ระบบจองห้อง
            </span>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- ฟอร์มจองห้องประชุม (ซ้าย) -->
        <div class="glass rounded-2xl p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl shadow-lg text-white">
                    <i class="fas fa-calendar-plus text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">จองห้องประชุม</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">กรอกรายละเอียดการจอง</p>
                </div>
            </div>

            <form id="bookingForm" method="POST" class="space-y-5">
                <!-- Hidden fields สำหรับ room_id -->
                <input type="hidden" id="room_id" name="room_id" value="">
                <input type="hidden" id="location_name" name="location" value="">
                
                <!-- วันที่ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="date">
                            <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>วันที่ <span class="text-red-500">*</span>
                        </label>
                        <input type="date" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors" id="date" name="date" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="location">
                            <i class="fas fa-door-open mr-2 text-purple-500"></i>ห้องประชุม <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors" id="location" required>
                            <option value="">-- กำลังโหลดห้องประชุม... --</option>
                        </select>
                    </div>
                </div>

                <!-- เลือกเวลา -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-clock mr-2 text-purple-500"></i>เวลาที่ต้องการใช้ห้อง <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Time Selection Mode Toggle -->
                    <div class="flex gap-2 mb-4">
                        <button type="button" id="modeByPeriod" class="time-mode-btn active flex-1 py-2 px-4 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-2 bg-purple-500 text-white">
                            <i class="fas fa-th-large"></i> เลือกตามคาบ
                        </button>
                        <button type="button" id="modeByTime" class="time-mode-btn flex-1 py-2 px-4 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600">
                            <i class="fas fa-clock"></i> กำหนดเวลาเอง
                        </button>
                    </div>

                    <!-- Period Selection (default) -->
                    <div id="periodSelection" class="time-selection-panel">
                        <div class="grid grid-cols-4 gap-2 mb-3">
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="1" data-time="08:30" data-end="09:25">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 1</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">08:30-09:25</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="2" data-time="09:25" data-end="10:20">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 2</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">09:25-10:20</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="3" data-time="10:20" data-end="11:15">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 3</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">10:20-11:15</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="4" data-time="11:15" data-end="12:10">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 4</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">11:15-12:10</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="5" data-time="12:10" data-end="13:05">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 5</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">12:10-13:05</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="6" data-time="13:05" data-end="14:00">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 6</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">13:05-14:00</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="7" data-time="14:00" data-end="14:55">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 7</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">14:00-14:55</div>
                            </label>
                            <label class="period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent hover:border-purple-300">
                                <input type="checkbox" class="period-input hidden" data-period="8" data-time="14:55" data-end="15:50">
                                <div class="font-bold text-gray-700 dark:text-gray-200">คาบ 8</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">14:55-15:50</div>
                            </label>
                        </div>
                        <div class="text-center text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-slate-800 rounded-lg p-2">
                            <span id="selectedPeriods">🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)</span>
                        </div>
                    </div>

                    <!-- Custom Time Selection -->
                    <div id="customTimeSelection" class="time-selection-panel hidden">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">เวลาเริ่มต้น</label>
                                <input type="time" id="customTimeStart" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">เวลาสิ้นสุด</label>
                                <input type="time" id="customTimeEnd" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">
                            </div>
                        </div>
                        <div class="text-center text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-slate-800 rounded-lg p-2 mt-3">
                            <span id="customTimeDisplay">🕐 กรุณาระบุเวลาเริ่มต้นและสิ้นสุด</span>
                        </div>
                    </div>

                    <input type="hidden" id="time_start" name="time_start">
                    <input type="hidden" id="time_end" name="time_end">
                </div>

                <!-- รูปแบบการจัดห้อง -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-chair mr-2 text-purple-500"></i>รูปแบบการจัดโต๊ะเก้าอี้
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="theater" class="hidden">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">🎭</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">แบบโรงภาพยนตร์</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Theater Style</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="classroom" class="hidden">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">🏫</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">แบบห้องเรียน</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Classroom Style</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="u-shape" class="hidden">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">🔲</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">แบบตัว U</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">U-Shape Style</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="boardroom" class="hidden">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">📋</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">แบบโต๊ะประชุม</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Boardroom Style</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="banquet" class="hidden">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">🍽️</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">แบบโต๊ะกลม</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Banquet Style</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="none" class="hidden" checked>
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">➖</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">ไม่ระบุ</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Default</div>
                            </div>
                        </label>
                        <label class="room-layout-option cursor-pointer">
                            <input type="radio" name="room_layout" value="other" class="hidden" id="roomLayoutOther">
                            <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                                <div class="text-3xl mb-2">✏️</div>
                                <div class="font-medium text-gray-700 dark:text-gray-200 text-sm">อื่นๆ</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">กรอกเอง</div>
                            </div>
                        </label>
                    </div>
                    <!-- Custom Room Layout Description -->
                    <div id="customRoomLayoutDiv" class="mt-3 hidden">
                        <input type="text" id="customRoomLayoutText" name="room_layout_custom" placeholder="อธิบายรูปแบบการจัดโต๊ะเก้าอี้ที่ต้องการ..." class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>

                <!-- วัตถุประสงค์ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="purpose">
                        <i class="fas fa-bullseye mr-2 text-purple-500"></i>วัตถุประสงค์ <span class="text-red-500">*</span>
                    </label>
                    <textarea class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors" id="purpose" name="purpose" rows="3" placeholder="ระบุวัตถุประสงค์ในการใช้ห้อง" required></textarea>
                </div>

                <!-- อุปกรณ์ที่ต้องการ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tools mr-2 text-purple-500"></i>อุปกรณ์ที่ต้องการ
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                            <input type="checkbox" name="media_items[]" value="ไมค์" class="rounded text-purple-600 focus:ring-purple-500" onchange="updateMediaField()">
                            <span class="text-sm">🎤 ไมค์</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                            <input type="checkbox" name="media_items[]" value="โปรเจคเตอร์" class="rounded text-purple-600 focus:ring-purple-500" onchange="updateMediaField()">
                            <span class="text-sm">📽️ โปรเจคเตอร์</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                            <input type="checkbox" name="media_items[]" value="โน๊ตบุ๊ค" class="rounded text-purple-600 focus:ring-purple-500" onchange="updateMediaField()">
                            <span class="text-sm">💻 โน๊ตบุ๊ค</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                            <input type="checkbox" name="media_items[]" value="แอร์" class="rounded text-purple-600 focus:ring-purple-500" onchange="updateMediaField()">
                            <span class="text-sm">❄️ แอร์</span>
                        </label>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors">
                            <input type="checkbox" id="other_media" class="rounded text-purple-600 focus:ring-purple-500" onchange="updateMediaField()">
                            <span class="text-sm">อื่นๆ</span>
                        </label>
                        <input type="text" id="other_media_text" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-sm" placeholder="ระบุอุปกรณ์อื่นๆ" disabled onchange="updateMediaField()">
                    </div>
                    <input type="hidden" id="media_hidden" name="media">
                </div>

                <!-- เบอร์โทรติดต่อ -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="phone">
                        <i class="fas fa-phone mr-2 text-purple-500"></i>เบอร์โทรติดต่อ
                    </label>
                    <input type="tel" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors" id="phone" name="phone" placeholder="เบอร์โทรติดต่อ" value="<?= $TeacherData['Teach_phone'] ?? '' ?>">
                </div>

                <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>ยืนยันการจอง</span>
                        <span>📅</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-400 dark:text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    กรุณาจองล่วงหน้าอย่างน้อย 1 วัน
                </p>
            </div>
        </div>

        <!-- รายการจองห้องประชุม (ขวา) -->
        <div class="space-y-6">
            <!-- Filter Section -->
            <div class="glass rounded-2xl p-4">
                <form id="searchForm" class="flex flex-wrap gap-2 items-end">
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">วันที่</label>
                        <input type="date" id="searchDate" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-sm">
                    </div>
                    <div class="flex-1 min-w-[120px]">
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">ห้อง</label>
                        <select id="searchLocation" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-sm">
                            <option value="">ทั้งหมด</option>
                            <!-- Options loaded from database -->
                        </select>
                    </div>
                    <div class="flex gap-1">
                        <button type="submit" class="px-3 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg text-sm transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                        <button type="button" id="showMyBookings" class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm transition-colors" title="การจองของฉัน">
                            <i class="fas fa-user"></i>
                        </button>
                        <button type="button" id="showAllBookings" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm transition-colors" title="ทั้งหมด">
                            <i class="fas fa-globe"></i>
                        </button>
                        <button type="button" id="clearSearch" class="px-3 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg text-sm transition-colors" title="ล้าง">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Booking List -->
            <div class="glass rounded-2xl p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl shadow-lg text-white">
                            <i class="fas fa-list-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 รายการจอง</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">รายการจองห้องประชุม</p>
                        </div>
                    </div>
                    <button id="refreshList" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-medium transition-all flex items-center gap-2 shadow-lg hover:shadow-blue-500/30">
                        <i class="fas fa-sync-alt"></i>
                        รีเฟรช
                    </button>
                </div>

                <div id="bookingList" class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                    <div class="text-center py-8 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลดข้อมูล...</p>
                    </div>
                </div>
            </div>

            <!-- Calendar Section -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 flex items-center justify-center bg-gradient-to-br from-green-500 to-teal-500 rounded-xl shadow-lg text-white">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">📅 ปฏิทินการจอง</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">คลิกที่วันเพื่อเลือกวันจอง | คลิกที่รายการเพื่อดูรายละเอียด</p>
                        </div>
                    </div>
                    <button id="refreshCalendar" class="px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm transition-colors flex items-center gap-1" title="รีเฟรชปฏิทิน">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                
                <!-- Legend -->
                <div class="flex flex-wrap gap-2 mb-4 p-3 bg-gray-50 dark:bg-slate-800 rounded-xl">
                    <span class="text-xs text-gray-600 dark:text-gray-400 mr-2 font-medium">🏷️ สถานที่:</span>
                    <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span> พิชัยดาบหัก
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> ภักดิ์กมล
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> พิชยนุสรณ์
                    </span>
                    <span class="inline-flex items-center gap-1 text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> โสตทัศนศึกษา
                    </span>
                </div>
                
                <div id="calendar" class="fc-custom"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal แก้ไขการจอง -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative mx-4 animate-fade-in">
        <button id="closeEditModal" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-500 flex items-center justify-center transition-colors">
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

        <form id="editBookingForm" class="space-y-5">
            <input type="hidden" name="id" id="editId">
            <input type="hidden" id="edit_room_id" name="room_id" value="">
            <input type="hidden" id="edit_location_name" name="location" value="">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วันที่</label>
                    <input type="date" name="date" id="editDate" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ห้องประชุม</label>
                    <select id="editLocation" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" required>
                        <!-- Options loaded from database -->
                    </select>
                </div>
            </div>

            <!-- Edit Period Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">เวลาที่ต้องการใช้ห้อง</label>
                
                <!-- Time Selection Mode Toggle for Edit -->
                <div class="flex gap-2 mb-4">
                    <button type="button" id="editModeByPeriod" class="edit-time-mode-btn active flex-1 py-2 px-4 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-2 bg-purple-500 text-white">
                        <i class="fas fa-th-large"></i> เลือกตามคาบ
                    </button>
                    <button type="button" id="editModeByTime" class="edit-time-mode-btn flex-1 py-2 px-4 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-slate-600">
                        <i class="fas fa-clock"></i> กำหนดเวลาเอง
                    </button>
                </div>

                <!-- Period Selection for Edit -->
                <div id="editPeriodSelection" class="edit-time-selection-panel">
                    <div class="grid grid-cols-4 gap-2 mb-3">
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="1" data-time="08:30" data-end="09:25">
                            <div class="font-bold">คาบ 1</div>
                            <div class="text-xs text-gray-500">08:30-09:25</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="2" data-time="09:25" data-end="10:20">
                            <div class="font-bold">คาบ 2</div>
                            <div class="text-xs text-gray-500">09:25-10:20</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="3" data-time="10:20" data-end="11:15">
                            <div class="font-bold">คาบ 3</div>
                            <div class="text-xs text-gray-500">10:20-11:15</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="4" data-time="11:15" data-end="12:10">
                            <div class="font-bold">คาบ 4</div>
                            <div class="text-xs text-gray-500">11:15-12:10</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="5" data-time="12:10" data-end="13:05">
                            <div class="font-bold">คาบ 5</div>
                            <div class="text-xs text-gray-500">12:10-13:05</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="6" data-time="13:05" data-end="14:00">
                            <div class="font-bold">คาบ 6</div>
                            <div class="text-xs text-gray-500">13:05-14:00</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="7" data-time="14:00" data-end="14:55">
                            <div class="font-bold">คาบ 7</div>
                            <div class="text-xs text-gray-500">14:00-14:55</div>
                        </label>
                        <label class="edit-period-checkbox bg-gray-100 dark:bg-slate-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 p-3 rounded-xl text-sm cursor-pointer transition-all text-center border-2 border-transparent">
                            <input type="checkbox" class="edit-period-input hidden" data-period="8" data-time="14:55" data-end="15:50">
                            <div class="font-bold">คาบ 8</div>
                            <div class="text-xs text-gray-500">14:55-15:50</div>
                        </label>
                    </div>
                    <div class="text-center text-sm text-gray-600 bg-gray-50 dark:bg-slate-800 rounded-lg p-2">
                        <span id="editSelectedPeriods">🕐 เลือกคาบเรียนที่ต้องการ</span>
                    </div>
                </div>

                <!-- Custom Time Selection for Edit -->
                <div id="editCustomTimeSelection" class="edit-time-selection-panel hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">เวลาเริ่มต้น</label>
                            <input type="time" id="editCustomTimeStart" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">เวลาสิ้นสุด</label>
                            <input type="time" id="editCustomTimeEnd" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700">
                        </div>
                    </div>
                    <div class="text-center text-sm text-gray-600 bg-gray-50 dark:bg-slate-800 rounded-lg p-2 mt-3">
                        <span id="editCustomTimeDisplay">🕐 กรุณาระบุเวลาเริ่มต้นและสิ้นสุด</span>
                    </div>
                </div>

                <input type="hidden" id="editTimeStart" name="time_start">
                <input type="hidden" id="editTimeEnd" name="time_end">
            </div>

            <!-- Edit Room Layout -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">รูปแบบการจัดโต๊ะเก้าอี้</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="theater" class="hidden">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">🎭</div>
                            <div class="text-xs font-medium">โรงภาพยนตร์</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="classroom" class="hidden">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">🏫</div>
                            <div class="text-xs font-medium">ห้องเรียน</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="u-shape" class="hidden">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">🔲</div>
                            <div class="text-xs font-medium">ตัว U</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="boardroom" class="hidden">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">📋</div>
                            <div class="text-xs font-medium">โต๊ะประชุม</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="banquet" class="hidden">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">🍽️</div>
                            <div class="text-xs font-medium">โต๊ะกลม</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="none" class="hidden" checked>
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">➖</div>
                            <div class="text-xs font-medium">ไม่ระบุ</div>
                        </div>
                    </label>
                    <label class="edit-room-layout-option cursor-pointer">
                        <input type="radio" name="room_layout" value="other" class="hidden" id="editRoomLayoutOther">
                        <div class="p-3 bg-gray-50 dark:bg-slate-700 rounded-xl border-2 border-transparent hover:border-purple-300 transition-all text-center">
                            <div class="text-2xl mb-1">✏️</div>
                            <div class="text-xs font-medium">อื่นๆ</div>
                        </div>
                    </label>
                </div>
                <!-- Edit Custom Room Layout -->
                <div id="editCustomRoomLayoutDiv" class="mt-3 hidden">
                    <input type="text" id="editCustomRoomLayoutText" name="room_layout_custom" placeholder="อธิบายรูปแบบการจัดโต๊ะเก้าอี้ที่ต้องการ..." class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">วัตถุประสงค์</label>
                <textarea name="purpose" id="editPurpose" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700" required></textarea>
            </div>

            <!-- Edit Media Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">อุปกรณ์ที่ต้องการ</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer">
                        <input type="checkbox" name="edit_media_items[]" value="ไมค์" class="rounded text-purple-600" onchange="updateEditMediaField()">
                        <span class="text-sm">🎤 ไมค์</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer">
                        <input type="checkbox" name="edit_media_items[]" value="โปรเจคเตอร์" class="rounded text-purple-600" onchange="updateEditMediaField()">
                        <span class="text-sm">📽️ โปรเจคเตอร์</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer">
                        <input type="checkbox" name="edit_media_items[]" value="โน๊ตบุ๊ค" class="rounded text-purple-600" onchange="updateEditMediaField()">
                        <span class="text-sm">💻 โน๊ตบุ๊ค</span>
                    </label>
                    <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer">
                        <input type="checkbox" name="edit_media_items[]" value="แอร์" class="rounded text-purple-600" onchange="updateEditMediaField()">
                        <span class="text-sm">❄️ แอร์</span>
                    </label>
                </div>
                <div class="mt-2 flex items-center gap-2">
                    <label class="flex items-center gap-2 p-3 bg-gray-50 dark:bg-slate-700 rounded-xl cursor-pointer">
                        <input type="checkbox" id="edit_other_media" class="rounded text-purple-600" onchange="updateEditMediaField()">
                        <span class="text-sm">อื่นๆ</span>
                    </label>
                    <input type="text" id="edit_other_media_text" class="flex-1 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-sm" placeholder="ระบุอุปกรณ์อื่นๆ" disabled onchange="updateEditMediaField()">
                </div>
                <input type="hidden" id="edit_media_hidden" name="media">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">เบอร์โทรติดต่อ</label>
                <input type="tel" name="phone" id="editPhone" value="<?= $TeacherData['Teach_phone'] ?? '' ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700">
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>บันทึกการแก้ไข</span>
                <span>💾</span>
            </button>
        </form>
    </div>
</div>

<style>
/* Period checkbox styles */
.period-checkbox.selected,
.edit-period-checkbox.selected {
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%) !important;
    color: white !important;
    border-color: #7c3aed !important;
}
.period-checkbox.selected .text-gray-700,
.period-checkbox.selected .text-gray-500,
.edit-period-checkbox.selected .text-gray-700,
.edit-period-checkbox.selected .text-gray-500,
.period-checkbox.selected div,
.edit-period-checkbox.selected div {
    color: white !important;
}
.period-checkbox:hover,
.edit-period-checkbox:hover {
    transform: scale(1.02);
}

/* Time mode button styles */
.time-mode-btn.active,
.edit-time-mode-btn.active {
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%) !important;
    color: white !important;
}

/* Room layout option styles */
.room-layout-option input:checked + div,
.edit-room-layout-option input:checked + div {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%) !important;
    border-color: #8b5cf6 !important;
}
.room-layout-option:hover div,
.edit-room-layout-option:hover div {
    transform: scale(1.02);
}

/* Booking card styling */
.booking-card {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
    border-left: 4px solid #8b5cf6;
    transition: all 0.3s ease;
}
.booking-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);
}

/* Calendar custom styles */
.fc-custom {
    font-family: 'Mali', sans-serif !important;
}
.fc-custom .fc-toolbar-title {
    font-size: 1.2rem !important;
    font-weight: 700 !important;
    background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.fc-custom .fc-button {
    font-size: 0.8rem !important;
    padding: 0.4rem 0.8rem !important;
    border-radius: 0.5rem !important;
    border: none !important;
    background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%) !important;
    box-shadow: 0 2px 8px rgba(139, 92, 246, 0.3) !important;
    transition: all 0.3s ease !important;
}
.fc-custom .fc-button:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4) !important;
}
.fc-custom .fc-button-active {
    background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%) !important;
}
.fc-custom .fc-today-button {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
}
.fc-custom .fc-daygrid-day {
    transition: all 0.2s ease !important;
}
.fc-custom .fc-daygrid-day:hover {
    background: rgba(139, 92, 246, 0.1) !important;
}
.fc-custom .fc-day-today {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(236, 72, 153, 0.15) 100%) !important;
}
.fc-custom .fc-daygrid-day-number {
    font-weight: 600 !important;
    padding: 8px !important;
}
.fc-custom .fc-event {
    border-radius: 6px !important;
    padding: 2px 6px !important;
    font-size: 0.7rem !important;
    font-weight: 500 !important;
    border: none !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
}
.fc-custom .fc-event:hover {
    transform: scale(1.02) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}
.fc-custom .fc-event-title {
    font-weight: 600 !important;
}
.fc-custom .fc-col-header-cell {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%) !important;
    padding: 10px 0 !important;
}
.fc-custom .fc-col-header-cell-cushion {
    font-weight: 700 !important;
    color: #7c3aed !important;
}
.fc-custom .fc-scrollgrid {
    border-radius: 12px !important;
    overflow: hidden !important;
    border: 1px solid rgba(139, 92, 246, 0.2) !important;
}
.fc-custom .fc-scrollgrid td, .fc-custom .fc-scrollgrid th {
    border-color: rgba(139, 92, 246, 0.1) !important;
}
.fc-custom .fc-list-event:hover td {
    background: rgba(139, 92, 246, 0.1) !important;
}
.fc-custom .fc-list-day-cushion {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.2) 100%) !important;
}

/* Dark mode calendar */
.dark .fc-custom .fc-col-header-cell-cushion {
    color: #a78bfa !important;
}
.dark .fc-custom .fc-daygrid-day-number {
    color: #e5e7eb !important;
}
.dark .fc-custom .fc-scrollgrid {
    border-color: rgba(139, 92, 246, 0.3) !important;
}
.dark .fc-custom .fc-scrollgrid td, .dark .fc-custom .fc-scrollgrid th {
    border-color: rgba(139, 92, 246, 0.15) !important;
}

/* Owner event highlight */
.fc-event-owner {
    animation: pulse-border 2s infinite;
}
@keyframes pulse-border {
    0%, 100% { box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7); }
    50% { box-shadow: 0 0 0 4px rgba(251, 191, 36, 0); }
}

/* Loader animation */
.loader {
    width: 40px;
    height: 40px;
    border: 4px solid #e5e7eb;
    border-top-color: #8b5cf6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Animate spin for refresh buttons */
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>

<!-- FullCalendar (v6 doesn't have separate CSS file) -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<!-- Room Booking Script -->
<script src="views/room_booking/script.js"></script>
<script>
    // Pass PHP variable to JavaScript
    const teach_id = "<?php echo $teacher_id; ?>";
</script>
