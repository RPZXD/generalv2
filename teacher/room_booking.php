<?php 
session_start();
// เช็ค session และ role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'ครู') {
    header('Location: ../login.php');
    exit;
}
// Read configuration from JSON file
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];
require_once('header.php');

?>
<body class="bg-gradient-to-br from-purple-50 via-white to-pink-100 min-h-screen font-sans" style="font-family: 'Mali', sans-serif;">
<div class="wrapper">

    <?php require_once('wrapper.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <div class="content-header">
      <div class="container-fluid">
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 flex items-center gap-2">
              <?php echo $global['nameschool']; ?>
              <span class="text-purple-600 text-2xl animate-bounce">| ครู 👨‍🏫 </span>
            </h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-purple-400 animate-fade-in flex flex-col lg:flex-row gap-8">
        <!-- ฟอร์มจองห้องประชุม (ซ้าย) -->
        <div class="w-full lg:w-1/2">
          <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl animate-bounce">🏢</span>
            <h2 class="text-2xl font-extrabold text-purple-700">จองห้องประชุม </h2>
          </div>
          <form id="bookingForm" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="date">วันที่ <span class="text-red-500">*</span></label>
                <input type="date" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" id="date" name="date" required>
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="location">สถานที่ <span class="text-red-500">*</span></label>
                <select class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" id="location" name="location" required>
                  <option value="">-- เลือกห้องประชุม --</option>
                  <option value="หอประชุมพิชัยดาบหัก">🏛️ หอประชุมพิชัยดาบหัก</option>
                  <option value="หอประชุมภักดิ์กมล">🏢 หอประชุมภักดิ์กมล</option>
                  <option value="ห้องพิชยนุสรณ์">📚 ห้องพิชยนุสรณ์</option>
                  <option value="ห้องโสตทัศนศึกษา">💻 ห้องโสตทัศนศึกษา</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="time_start">เวลาที่ต้องการใช้ห้อง <span class="text-red-500">*</span></label>
                <input type="time" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400 hidden" id="time_start" name="time_start" required>
                <div class="time-selection">
                  <div class="grid grid-cols-4 gap-2 mb-3">
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="1" data-time="08:30" data-end="09:25">
                      <div class="period-display">
                        คาบ 1<br><span class="text-xs">08:30-09:25</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="2" data-time="09:25" data-end="10:20">
                      <div class="period-display">
                        คาบ 2<br><span class="text-xs">09:25-10:20</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="3" data-time="10:20" data-end="11:15">
                      <div class="period-display">
                        คาบ 3<br><span class="text-xs">10:20-11:15</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="4" data-time="11:15" data-end="12:10">
                      <div class="period-display">
                        คาบ 4<br><span class="text-xs">11:15-12:10</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="5" data-time="12:10" data-end="13:05">
                      <div class="period-display">
                        คาบ 5<br><span class="text-xs">12:10-13:05</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="6" data-time="13:05" data-end="14:00">
                      <div class="period-display">
                        คาบ 6<br><span class="text-xs">13:05-14:00</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="7" data-time="14:00" data-end="14:55">
                      <div class="period-display">
                        คาบ 7<br><span class="text-xs">14:00-14:55</span>
                      </div>
                    </label>
                    <label class="period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="period-input hidden" data-period="8" data-time="14:55" data-end="15:50">
                      <div class="period-display">
                        คาบ 8<br><span class="text-xs">14:55-15:50</span>
                      </div>
                    </label>
                  </div>
                  <div class="text-center text-sm text-gray-600">
                    <span id="selectedPeriods">🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)</span>
                  </div>
                </div>

                <input type="time" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400 hidden" id="time_end" name="time_end" required>

              </div>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="purpose">วัตถุประสงค์ <span class="text-red-500">*</span></label>
              <textarea class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" id="purpose" name="purpose" rows="3" placeholder="ระบุวัตถุประสงค์ในการใช้ห้อง" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="media">อุปกรณ์ที่ต้องการ</label>
                <div class="space-y-2 p-3 border-2 border-gray-200 rounded-lg">
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="media_items[]" value="ไมค์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">🎤 ไมค์</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="media_items[]" value="โปรเจคเตอร์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">📽️ โปรเจคเตอร์</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="media_items[]" value="โน๊ตบุ๊ค" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">💻 โน๊ตบุ๊ค</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="media_items[]" value="แอร์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">❄️ แอร์</span>
                  </label>
                  <div class="flex items-center gap-2">
                    <input type="checkbox" id="other_media" class="text-purple-600 focus:ring-purple-500">
                    <label for="other_media" class="text-sm cursor-pointer">🔧 อื่นๆ:</label>
                    <input type="text" id="other_media_text" name="other_media" placeholder="ระบุอุปกรณ์อื่นๆ" class="flex-1 p-2 border border-gray-300 rounded text-sm" enabled>
                  </div>
                </div>
                <input type="hidden" name="media" id="media_hidden">
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="phone">เบอร์โทรติดต่อ</label>
                <input type="tel" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" id="phone" name="phone" placeholder="เบอร์โทรศัพท์">
              </div>
            </div>
            <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">
            <div class="flex justify-end">
              <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-8 rounded-lg font-bold text-lg hover:from-purple-700 hover:to-pink-700 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                <span>จองห้องประชุม</span> <span>📅</span>
              </button>
            </div>
          </form>
          <div class="mt-6 text-center text-gray-400 text-xs">
            <span>📞 หากมีข้อสงสัย กรุณาติดต่อเจ้าหน้าที่</span>
          </div>
        </div>

        <!-- รายการจองห้องประชุม (ขวา) -->
        <div class="w-full lg:w-1/2">
          <!-- Date Picker และ Filter Section -->
          <div class="mt-6 bg-gray-50 p-4 rounded-lg">
            <h4 class="text-md font-bold text-purple-700 mb-3">🔍 ค้นหาการจองทั้งหมด</h4>
            <form id="searchForm" onsubmit="return false;">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                <div>
                  <label class="block text-gray-600 text-sm mb-1">📅 วันที่</label>
                  <input type="date" id="searchDate" class="w-full p-2 border border-gray-300 rounded text-sm">
                </div>
                <div>
                  <label class="block text-gray-600 text-sm mb-1">🏢 ห้องประชุม</label>
                  <select id="searchLocation" class="w-full p-2 border border-gray-300 rounded text-sm">
                    <option value="">-- ทั้งหมด --</option>
                    <option value="หอประชุมพิชัยดาบหัก">หอประชุมพิชัยดาบหัก</option>
                    <option value="หอประชุมภักดิ์กมล">หอประชุมภักดิ์กมล</option>
                    <option value="ห้องพิชยนุสรณ์">ห้องพิชยนุสรณ์</option>
                    <option value="ห้องโสตทัศนศึกษา">ห้องโสตทัศนศึกษา</option>
                  </select>
                </div>
                <div class="flex items-end">
                  <button id="searchAllBookings" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition text-sm w-full">
                    🔍 ค้นหา
                  </button>
                </div>
              </div>
            </form>
            <div class="flex gap-2 mt-2">
              <button id="showMyBookings" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600 transition text-sm">
                📋 การจองของฉัน
              </button>
              <button id="showAllBookings" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition text-sm">
                📊 การจองทั้งหมด
              </button>
              <button id="clearSearch" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 transition text-sm">
                🗑️ ล้างตัวกรอง
              </button>
            </div>
          </div>
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-purple-700 flex items-center gap-2">📋 รายการจองของฉัน</h3>
            <button id="refreshList" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-700 transition">รีเฟรช 🔄</button>
          </div>
          <div id="bookingList" class="space-y-4 max-h-96 overflow-y-auto">
            <!-- JS will render cards here -->
          </div>

          <!-- Calendar Section -->
          <div class="mt-8">
            <h4 class="text-md font-bold text-purple-700 mb-3">📅 ปฏิทินการจองห้องประชุม</h4>
            <div id="calendar"></div>
          </div>

        </div>
      </div>

      <!-- Modal แก้ไขการจอง -->
      <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
          <button id="closeEditModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
          <h3 class="text-xl font-bold text-purple-700 mb-4">✏️ แก้ไขการจองห้องประชุม</h3>
          <form id="editBookingForm" class="space-y-4">
            <input type="hidden" name="id" id="editId">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editDate">วันที่ <span class="text-red-500">*</span></label>
                <input type="date" name="date" id="editDate" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" required>
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editLocation">สถานที่ <span class="text-red-500">*</span></label>
                <select name="location" id="editLocation" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" required>
                  <option value="">-- เลือกห้องประชุม --</option>
                  <option value="หอประชุมพิชัยดาบหัก">🏛️ หอประชุมพิชัยดาบหัก</option>
                  <option value="หอประชุมภักดิ์กมล">🏢 หอประชุมภักดิ์กมล</option>
                  <option value="ห้องพิชยนุสรณ์">📚 ห้องพิชยนุสรณ์</option>
                  <option value="ห้องโสตทัศนศึกษา">💻 ห้องโสตทัศนศึกษา</option>
                </select>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editTimeStart">เวลาเริ่ม <span class="text-red-500">*</span></label>
                <input type="time" name="time_start" id="editTimeStart" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400 hidden" required>
                <div class="edit-time-selection">
                  <div class="grid grid-cols-4 gap-2 mb-3">
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="1" data-time="08:30" data-end="09:25">
                      <div class="period-display">
                        คาบ 1<br><span class="text-xs">08:30-09:25</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="2" data-time="09:25" data-end="10:20">
                      <div class="period-display">
                        คาบ 2<br><span class="text-xs">09:25-10:20</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="3" data-time="10:20" data-end="11:15">
                      <div class="period-display">
                        คาบ 3<br><span class="text-xs">10:20-11:15</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="4" data-time="11:15" data-end="12:10">
                      <div class="period-display">
                        คาบ 4<br><span class="text-xs">11:15-12:10</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="5" data-time="12:10" data-end="13:05">
                      <div class="period-display">
                        คาบ 5<br><span class="text-xs">12:10-13:05</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="6" data-time="13:05" data-end="14:00">
                      <div class="period-display">
                        คาบ 6<br><span class="text-xs">13:05-14:00</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="7" data-time="14:00" data-end="14:55">
                      <div class="period-display">
                        คาบ 7<br><span class="text-xs">14:00-14:55</span>
                      </div>
                    </label>
                    <label class="edit-period-checkbox bg-gray-100 hover:bg-purple-200 p-2 rounded text-sm cursor-pointer transition-colors">
                      <input type="checkbox" class="edit-period-input hidden" data-period="8" data-time="14:55" data-end="15:50">
                      <div class="period-display">
                        คาบ 8<br><span class="text-xs">14:55-15:50</span>
                      </div>
                    </label>
                  </div>
                  <div class="text-center text-sm text-gray-600">
                    <span id="editSelectedPeriods">🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)</span>
                  </div>
                </div>
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editTimeEnd">เวลาสิ้นสุด <span class="text-red-500">*</span></label>
                <input type="time" name="time_end" id="editTimeEnd" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400 hidden" required>
                <div class="mt-8 text-center">
                  <button type="button" id="editClearSelection" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    🗑️ ล้างการเลือก
                  </button>
                </div>
              </div>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="editPurpose">วัตถุประสงค์ <span class="text-red-500">*</span></label>
              <textarea name="purpose" id="editPurpose" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400" rows="3" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editMedia">อุปกรณ์ที่ต้องการ</label>
                <div class="space-y-2 p-3 border-2 border-gray-200 rounded-lg">
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="edit_media_items[]" value="ไมค์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">🎤 ไมค์</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="edit_media_items[]" value="โปรเจคเตอร์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">📽️ โปรเจคเตอร์</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="edit_media_items[]" value="โน๊ตบุ๊ค" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">💻 โน๊ตบุ๊ค</span>
                  </label>
                  <label class="flex items-center gap-2 cursor-pointer hover:bg-purple-50 p-2 rounded">
                    <input type="checkbox" name="edit_media_items[]" value="แอร์" class="text-purple-600 focus:ring-purple-500">
                    <span class="text-sm">❄️ แอร์</span>
                  </label>
                  <div class="flex items-center gap-2">
                    <input type="checkbox" id="edit_other_media" class="text-purple-600 focus:ring-purple-500">
                    <label for="edit_other_media" class="text-sm cursor-pointer">🔧 อื่นๆ:</label>
                    <input type="text" id="edit_other_media_text" name="edit_other_media" placeholder="ระบุอุปกรณ์อื่นๆ" class="flex-1 p-2 border border-gray-300 rounded text-sm" disabled>
                  </div>
                </div>
                <input type="hidden" name="media" id="edit_media_hidden">
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="editPhone">เบอร์โทรติดต่อ</label>
                <input type="tel" name="phone" id="editPhone" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-400">
              </div>
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 text-white py-3 rounded-lg font-bold text-lg hover:from-yellow-600 hover:to-orange-600 transition-all flex items-center justify-center gap-2">
              <span>บันทึกการแก้ไข</span> <span>💾</span>
            </button>
          </form>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->

<!-- เพิ่ม FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
  // เพิ่ม animation เล็กน้อย
  document.addEventListener('DOMContentLoaded', function () {
    const wiggleEls = document.querySelectorAll('.animate-wiggle');
    wiggleEls.forEach(el => {
      el.style.animation = 'wiggle 1.2s infinite';
    });

    // กำหนดวันที่ปัจจุบัน
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('date').value = formattedDate;
  });
</script>
<style>
@keyframes wiggle {
  0%, 100% { transform: rotate(-5deg);}
  50% { transform: rotate(5deg);}
}
.animate-wiggle { animation: wiggle 1.2s infinite; }
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fade-in 1s ease-out; }

/* Period checkbox styles */
.period-checkbox.selected, .edit-period-checkbox.selected {
  background-color: #8b5cf6 !important;
  color: white;
}
.period-checkbox:hover, .edit-period-checkbox:hover {
  transform: scale(1.02);
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const teach_id = "<?php echo $teacher_id; ?>";

// ระบบจัดการการเลือกคาบเรียน
function updateTimeInputs() {
  const checkedInputs = document.querySelectorAll('.period-input:checked');
  const periods = Array.from(checkedInputs).map(input => ({
    period: parseInt(input.dataset.period),
    time: input.dataset.time,
    end: input.dataset.end
  })).sort((a, b) => a.period - b.period);

  if (periods.length > 0) {
    const startTime = periods[0].time;
    const endTime = periods[periods.length - 1].end;
    
    document.getElementById('time_start').value = startTime;
    document.getElementById('time_end').value = endTime;
    
    const periodNumbers = periods.map(p => `คาบ ${p.period}`).join(', ');
    document.getElementById('selectedPeriods').textContent = `📅 เลือกแล้ว: ${periodNumbers} (${startTime} - ${endTime})`;
  } else {
    document.getElementById('time_start').value = '';
    document.getElementById('time_end').value = '';
    document.getElementById('selectedPeriods').textContent = '🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)';
  }
}

function updateEditTimeInputs() {
  const checkedInputs = document.querySelectorAll('.edit-period-input:checked');
  const periods = Array.from(checkedInputs).map(input => ({
    period: parseInt(input.dataset.period),
    time: input.dataset.time,
    end: input.dataset.end
  })).sort((a, b) => a.period - b.period);

  if (periods.length > 0) {
    const startTime = periods[0].time;
    const endTime = periods[periods.length - 1].end;
    
    document.getElementById('editTimeStart').value = startTime;
    document.getElementById('editTimeEnd').value = endTime;
    
    const periodNumbers = periods.map(p => `คาบ ${p.period}`).join(', ');
    document.getElementById('editSelectedPeriods').textContent = `📅 เลือกแล้ว: ${periodNumbers} (${startTime} - ${endTime})`;
  } else {
    document.getElementById('editTimeStart').value = '';
    document.getElementById('editTimeEnd').value = '';
    document.getElementById('editSelectedPeriods').textContent = '🕐 เลือกคาบเรียนที่ต้องการ (สามารถเลือกได้หลายคาบ)';
  }
}

// ฟังก์ชันจัดการ checkbox อุปกรณ์
function updateMediaField() {
  const checkedItems = [];
  document.querySelectorAll('input[name="media_items[]"]:checked').forEach(checkbox => {
    checkedItems.push(checkbox.value);
  });
  const otherCheckbox = document.getElementById('other_media');
  const otherText = document.getElementById('other_media_text');
  // enable textbox เมื่อ checkbox ถูกติ๊ก
  if (otherCheckbox.checked) {
    otherText.disabled = false;
    if (otherText.value.trim()) {
      checkedItems.push(otherText.value.trim());
    }
  } else {
    otherText.disabled = true;
    // ไม่ต้องล้างค่า otherText.value เพื่อให้กรอกไว้ได้
  }
  document.getElementById('media_hidden').value = checkedItems.join(', ');
}

function updateEditMediaField() {
  const checkedItems = [];
  document.querySelectorAll('input[name="edit_media_items[]"]:checked').forEach(checkbox => {
    checkedItems.push(checkbox.value);
  });
  const otherCheckbox = document.getElementById('edit_other_media');
  const otherText = document.getElementById('edit_other_media_text');
  // enable textbox เมื่อ checkbox ถูกติ๊ก
  if (otherCheckbox.checked) {
    otherText.disabled = false;
    if (otherText.value.trim()) {
      checkedItems.push(otherText.value.trim());
    }
  } else {
    otherText.disabled = true;
    // ไม่ต้องล้างค่า otherText.value เพื่อให้กรอกไว้ได้
  }
  document.getElementById('edit_media_hidden').value = checkedItems.join(', ');
}

// ฟังก์ชันตั้งค่า checkbox จากข้อความ
function setMediaCheckboxes(mediaText) {
  // ล้าง checkbox เก่า
  document.querySelectorAll('input[name="edit_media_items[]"]').forEach(cb => cb.checked = false);
  document.getElementById('edit_other_media').checked = false;
  document.getElementById('edit_other_media_text').value = '';
  document.getElementById('edit_other_media_text').disabled = true;
  
  if (!mediaText) return;
  
  const items = mediaText.split(',').map(item => item.trim());
  const standardItems = ['ไมค์', 'โปรเจคเตอร์', 'โน๊ตบุ๊ค', 'แอร์'];
  const otherItems = [];
  
  items.forEach(item => {
    if (standardItems.includes(item)) {
      const checkbox = document.querySelector(`input[name="edit_media_items[]"][value="${item}"]`);
      if (checkbox) checkbox.checked = true;
    } else if (item) {
      otherItems.push(item);
    }
  });
  
  if (otherItems.length > 0) {
    document.getElementById('edit_other_media').checked = true;
    document.getElementById('edit_other_media_text').disabled = false;
    document.getElementById('edit_other_media_text').value = otherItems.join(', ');
  }
}

// ดึงข้อมูลการจอง
function getStatusBadge(status) {
  switch(status) {
    case 0:
    case '0': 
      return '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">⏳ รอการอนุมัติ</span>';
    case 1:
    case '1': 
      return '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">✅ อนุมัติแล้ว</span>';
    case 2:
    case '2': 
      return '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">❌ ยกเลิกแล้ว</span>';
    default: 
      return '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">❓ ไม่ทราบสถานะ</span>';
  }
}

function fetchBookings() {
  fetch('api/fetch_bookings.php?teach_id=' + encodeURIComponent(teach_id))
    .then(res => res.json())
    .then(data => {
      // ใช้ data.list เสมอ (API ส่งกลับมาเป็น object ที่มี list เสมอ)
      const list = Array.isArray(data.list) ? data.list : [];
      const bookingList = document.getElementById('bookingList');
      bookingList.innerHTML = '';
      if (!list.length) {
        bookingList.innerHTML = '<div class="text-gray-400 text-center py-8">📋 ไม่มีข้อมูลการจอง</div>';
        return;
      }
      list.forEach(item => {
        const card = document.createElement('div');
        card.className = "bg-gradient-to-r from-purple-50 to-pink-50 border-l-4 border-purple-400 rounded-lg shadow-md p-4 hover:shadow-lg transition-all";
        card.innerHTML = `
          <div class="flex justify-between items-start mb-2">
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-purple-700">📅 วันที่:</span>
                <span class="text-gray-800">${item.date ? item.date.substring(0, 10) : '-'}</span>
              </div>
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-purple-700">🏢 สถานที่:</span>
                <span class="text-gray-800">${item.location || '-'}</span>
              </div>
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-purple-700">⏰ เวลา:</span>
                <span class="text-gray-800">${(item.time_start || '-').substring(0,5)} - ${(item.time_end || '-').substring(0,5)}</span>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-bold text-purple-700">📝 วัตถุประสงค์:</span>
                <span class="text-gray-800 text-sm">${item.purpose ? (item.purpose.length > 50 ? item.purpose.substring(0, 50) + '...' : item.purpose) : '-'}</span>
              </div>
              ${getStatusBadge(item.status)}
            </div>
            <div class="flex flex-col gap-2 ml-4">
              <button class="editBtn bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm" data-id="${item.id}">✏️ แก้ไข</button>
              <button class="deleteBtn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 text-sm" data-id="${item.id}">🗑️ ลบ</button>
            </div>
          </div>
        `;
        bookingList.appendChild(card);
      });
    })
    .catch(err => {
      console.error('Fetch bookings error:', err);
      document.getElementById('bookingList').innerHTML = '<div class="text-red-400 text-center py-8">❌ เกิดข้อผิดพลาดในการโหลดข้อมูล</div>';
    });
}

// ฟังก์ชันสำหรับดึงข้อมูลการจองทั้งหมด
function fetchAllBookings(date = '', location = '') {
  let url = 'api/fetch_all_bookings.php?';
  const params = new URLSearchParams();
  if (date) params.append('date', date);
  if (location) params.append('location', location);
  url += params.toString();

  fetch(url)
    .then(res => res.json())
    .then(data => {
      const list = Array.isArray(data.list) ? data.list : [];
      const bookingList = document.getElementById('bookingList');
      bookingList.innerHTML = '';

      if (!list.length) {
        bookingList.innerHTML = '<div class="text-gray-400 text-center py-8">📋 ไม่พบข้อมูลการจอง</div>';
        return;
      }

      list.forEach(item => {
        const card = document.createElement('div');
        card.className = "bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-400 rounded-lg shadow-md p-4 hover:shadow-lg transition-all";
        card.innerHTML = `
          <div class="flex justify-between items-start mb-2">
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-blue-700">👨‍🏫 ผู้จอง:</span>
                <span class="text-gray-800">${item.teacher_name || item.teach_id || '-'}</span>
              </div>
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-blue-700">📅 วันที่:</span>
                <span class="text-gray-800">${item.date ? item.date.substring(0, 10) : '-'}</span>
              </div>
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-blue-700">🏢 สถานที่:</span>
                <span class="text-gray-800">${item.location || '-'}</span>
              </div>
              <div class="flex items-center gap-2 mb-1">
                <span class="font-bold text-blue-700">⏰ เวลา:</span>
                <span class="text-gray-800">${(item.time_start || '-').substring(0,5)} - ${(item.time_end || '-').substring(0,5)}</span>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-bold text-blue-700">📝 วัตถุประสงค์:</span>
                <span class="text-gray-800 text-sm">${item.purpose ? (item.purpose.length > 50 ? item.purpose.substring(0, 50) + '...' : item.purpose) : '-'}</span>
              </div>
              ${getStatusBadge(item.status)}
            </div>
            ${item.teach_id == teach_id ? `
            <div class="flex flex-col gap-2 ml-4">
              <button class="editBtn bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm" data-id="${item.id}">✏️ แก้ไข</button>
              <button class="deleteBtn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 text-sm" data-id="${item.id}">🗑️ ลบ</button>
            </div>
            ` : ''}
          </div>
        `;
        bookingList.appendChild(card);
      });
    })
    .catch(err => {
      console.error('Fetch all bookings error:', err);
      document.getElementById('bookingList').innerHTML = '<div class="text-red-400 text-center py-8">❌ เกิดข้อผิดพลาดในการโหลดข้อมูล</div>';
    });
}

// ฟังก์ชันสำหรับแปลง booking list เป็น event ของ FullCalendar
function bookingsToEvents(list) {
  return list.map(item => ({
    id: item.id,
    title: (item.location || '-') + (item.purpose ? ' : ' + item.purpose.substring(0, 20) : ''),
    start: item.date + 'T' + (item.time_start ? item.time_start.substring(0,5) : '00:00'),
    end: item.date + 'T' + (item.time_end ? item.time_end.substring(0,5) : '23:59'),
    backgroundColor: item.teach_id == teach_id ? '#a78bfa' : '#38bdf8',
    borderColor: item.teach_id == teach_id ? '#7c3aed' : '#0ea5e9',
    textColor: '#222',
    extendedProps: item
  }));
}

let calendar; // FullCalendar instance

function renderCalendar(list) {
  const calendarEl = document.getElementById('calendar');
  if (!calendar) {
    calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'th',
      height: 500,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      eventClick: function(info) {
        const item = info.event.extendedProps;
        Swal.fire({
          title: 'รายละเอียดการจอง',
          html: `
            <div class="text-left">
              <div><b>วันที่:</b> ${item.date ? item.date.substring(0,10) : '-'}</div>
              <div><b>เวลา:</b> ${(item.time_start || '-').substring(0,5)} - ${(item.time_end || '-').substring(0,5)}</div>
              <div><b>สถานที่:</b> ${item.location || '-'}</div>
              <div><b>วัตถุประสงค์:</b> ${item.purpose || '-'}</div>
              <div><b>ผู้จอง:</b> ${item.teacher_name || item.teach_id || '-'}</div>
              <div><b>สถานะ:</b> ${getStatusBadge(item.status)}</div>
            </div>
          `,
          showConfirmButton: false,
          showCloseButton: true
        });
      }
    });
    calendar.render();
  }
  calendar.removeAllEvents();
  calendar.addEventSource(bookingsToEvents(list));
}

// ดึงข้อมูลทั้งหมดสำหรับปฏิทิน
function fetchCalendarBookings() {
  fetch('api/fetch_all_bookings.php')
    .then(res => res.json())
    .then(data => {
      const list = Array.isArray(data.list) ? data.list : [];
      renderCalendar(list);
    })
    .catch(err => {
      document.getElementById('calendar').innerHTML = '<div class="text-red-400 text-center py-8">❌ ไม่สามารถโหลดปฏิทิน</div>';
    });
}

// เรียกเมื่อโหลดหน้า
document.addEventListener('DOMContentLoaded', function() {
  fetchCalendarBookings();
});

// Event listeners สำหรับ filter section
document.getElementById('searchForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const date = document.getElementById('searchDate').value;
  const location = document.getElementById('searchLocation').value;
  fetchAllBookings(date, location);
});

document.getElementById('showMyBookings').addEventListener('click', function() {
  fetchBookings();
});

document.getElementById('showAllBookings').addEventListener('click', function() {
  fetchAllBookings();
});

document.getElementById('clearSearch').addEventListener('click', function() {
  document.getElementById('searchDate').value = '';
  document.getElementById('searchLocation').value = '';
  fetchBookings();
});

// Event listeners สำหรับ period selection
document.addEventListener('change', function(e) {
  if (e.target.classList.contains('period-input')) {
    const label = e.target.closest('.period-checkbox');
    if (e.target.checked) {
      label.classList.add('selected');
    } else {
      label.classList.remove('selected');
    }
    updateTimeInputs();
  }
  
  if (e.target.classList.contains('edit-period-input')) {
    const label = e.target.closest('.edit-period-checkbox');
    if (e.target.checked) {
      label.classList.add('selected');
    } else {
      label.classList.remove('selected');
    }
    updateEditTimeInputs();
  }
});

// ฟังก์ชันสำหรับตั้งค่าคาบจากเวลา (สำหรับ edit modal)
window.setPeriodsFromTime = function(startTime, endTime) {
  // ล้างการเลือกเก่า
  document.querySelectorAll('.edit-period-input').forEach(input => {
    input.checked = false;
    input.closest('.edit-period-checkbox').classList.remove('selected');
  });

  // หาคาบที่ตรงกับเวลา
  const periods = [
    {period: 1, start: '08:30', end: '09:25'},
    {period: 2, start: '09:25', end: '10:20'},
    {period: 3, start: '10:20', end: '11:15'},
    {period: 4, start: '11:15', end: '12:10'},
    {period: 5, start: '12:10', end: '13:05'},
    {period: 6, start: '13:05', end: '14:00'},
    {period: 7, start: '14:00', end: '14:55'},
    {period: 8, start: '14:55', end: '15:50'}
  ];

  // แปลงเวลาให้เป็นรูปแบบ HH:mm
  const formatTime = (time) => time.substring(0, 5);
  const formattedStartTime = formatTime(startTime);
  const formattedEndTime = formatTime(endTime);

  periods.forEach(period => {
    // ตรวจสอบว่าคาบนี้อยู่ในช่วงเวลาที่เลือกหรือไม่
    if (period.start >= formattedStartTime && period.start < formattedEndTime) {
      const input = document.querySelector(`.edit-period-input[data-period="${period.period}"]`);
      if (input) {
        input.checked = true;
        input.closest('.edit-period-checkbox').classList.add('selected');
      }
    }
  });

  updateEditTimeInputs();
};

// เพิ่มข้อมูลใหม่
document.getElementById('bookingForm').onsubmit = function(e) {
  e.preventDefault();
  
  // ตรวจสอบว่าเลือกคาบแล้วหรือยัง
  const checkedInputs = document.querySelectorAll('.period-input:checked');
  if (checkedInputs.length === 0) {
    Swal.fire('ผิดพลาด! ❌', 'กรุณาเลือกคาบเรียนที่ต้องการจอง', 'error');
    return;
  }

  const formData = new FormData(this);

  // ตรวจสอบข้อมูลในฟอร์ม
  // console.log('Form data:');
  // for (let [key, value] of formData.entries()) {
  //   console.log(key, value);
  // }

  fetch('api/insert_booking.php', {
    method: 'POST',
    body: formData
  }).then(res => res.json()).then(result => {
    // console.log('Server response:', result);
    if (result.success) {
      Swal.fire('สำเร็จ! 🎉', 'จองห้องประชุมเรียบร้อย', 'success');
      this.reset();
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('date').value = today;
      // ล้างการเลือกคาบ
      document.querySelectorAll('.period-input').forEach(input => {
        input.checked = false;
        input.closest('.period-checkbox').classList.remove('selected');
      });
      updateTimeInputs();
      fetchBookings();
    } else {
      Swal.fire('ผิดพลาด! ❌', result.message || 'เกิดข้อผิดพลาด', 'error');
    }
  }).catch(err => {
    console.error('Error:', err);
    Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
  });
};

// แก้ไขข้อมูล
document.getElementById('editBookingForm').onsubmit = function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);

  fetch('api/update_booking.php', {
    method: 'POST',
    body: formData
  }).then(res => res.json()).then(result => {
    // console.log('Update response:', result);
    if (result.success) {
      Swal.fire('สำเร็จ! 🎉', 'แก้ไขการจองเรียบร้อย', 'success');
      document.getElementById('editModal').classList.add('hidden');
      fetchBookings();
    } else {
      Swal.fire('ผิดพลาด! ❌', result.message || 'เกิดข้อผิดพลาด', 'error');
    }
  }).catch(err => {
    console.error('Error:', err);
    Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
  });
};

// ลบการจอง
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('deleteBtn')) {
    const bookingId = e.target.dataset.id;
    Swal.fire({
      title: 'ยืนยันการลบ?',
      text: "คุณต้องการลบการจองนี้หรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'ใช่, ลบเลย!',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('api/delete_booking.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ id: bookingId })
        }).then(res => res.json()).then(result => {
          // console.log('Delete response:', result);
          if (result.success) {
            Swal.fire('ลบสำเร็จ!', 'การจองถูกลบเรียบร้อยแล้ว', 'success');
            fetchBookings();
          } else {
            Swal.fire('ผิดพลาด! ❌', result.message || 'เกิดข้อผิดพลาด', 'error');
          }
        }).catch(err => {
          console.error('Error:', err);
          Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
        });
      }
    });
  }
});

// ปิด modal แก้ไข
document.getElementById('closeEditModal').onclick = function() {
  document.getElementById('editModal').classList.add('hidden');
};

// ปิด modal เมื่อคลิกพื้นหลัง
document.getElementById('editModal').onclick = function(e) {
  if (e.target === this) {
    this.classList.add('hidden');
  }
};

// แสดง modal แก้ไข
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('editBtn')) {
    const bookingId = e.target.dataset.id;
    fetch('api/fetch_booking_detail.php?id=' + encodeURIComponent(bookingId))
      .then(res => res.json())
      .then(data => {
        if (data.success && data.booking) {
          const booking = data.booking;
          document.getElementById('editId').value = booking.id;
          document.getElementById('editDate').value = booking.date;
          document.getElementById('editLocation').value = booking.location;
          document.getElementById('editPurpose').value = booking.purpose;
          document.getElementById('editPhone').value = booking.phone || '';
          
          // ตั้งค่าอุปกรณ์
          setMediaCheckboxes(booking.media);
          
          // ตั้งค่าเวลาเริ่มและเวลาสิ้นสุด
          document.getElementById('editTimeStart').value = booking.time_start;
          document.getElementById('editTimeEnd').value = booking.time_end;

          // ตั้งค่าคาบเรียนที่เลือก
          setPeriodsFromTime(booking.time_start, booking.time_end);

          // แสดง modal
          document.getElementById('editModal').classList.remove('hidden');
        } else {
          Swal.fire('ผิดพลาด! ❌', 'ไม่สามารถโหลดข้อมูลการจองได้', 'error');
        }
      })
      .catch(err => {
        console.error('Error:', err);
        Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
      });
  }
});

document.getElementById('refreshList').onclick = fetchBookings;
fetchBookings();
</script>
<?php require_once('script.php');?>
</body>
</html>
