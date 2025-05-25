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
      <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-blue-400 animate-fade-in flex flex-col lg:flex-row gap-8">
        <!-- ฟอร์มจองรถราชการ (ซ้าย) -->
        <div class="w-full lg:w-1/2">
          <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl animate-bounce">🚗</span>
            <h2 class="text-2xl font-extrabold text-blue-700">จองรถราชการ</h2>
          </div>
          <form id="carBookingForm" method="POST" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="date">วันที่ <span class="text-red-500">*</span></label>
                <input type="date" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="date" name="date" required>
              </div>
              <div>
                <label class="block text-gray-700 font-semibold mb-1" for="time">เวลา <span class="text-red-500">*</span></label>
                <input type="time" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="time" name="time" required>
              </div>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="car_type">ประเภทรถ <span class="text-red-500">*</span></label>
              <select class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="car_type" name="car_type" required>
                <option value="">-- เลือกประเภทรถ --</option>
                <option value="รถตู้">🚐 รถตู้</option>
                <option value="รถเก๋ง">🚗 รถเก๋ง</option>
                <option value="รถกระบะ">🚙 รถกระบะ</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="destination">จุดหมายปลายทาง <span class="text-red-500">*</span></label>
              <input type="text" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="destination" name="destination" placeholder="เช่น ศาลากลางจังหวัด" required>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="purpose">วัตถุประสงค์ <span class="text-red-500">*</span></label>
              <textarea class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="purpose" name="purpose" rows="2" placeholder="ระบุวัตถุประสงค์ในการใช้รถ" required></textarea>
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="passengers">ผู้เดินทาง</label>
              <input type="text" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="passengers" name="passengers" placeholder="ชื่อผู้ร่วมเดินทาง (ถ้ามี)">
            </div>
            <div>
              <label class="block text-gray-700 font-semibold mb-1" for="phone">เบอร์โทรติดต่อ</label>
              <input type="tel" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="phone" name="phone" placeholder="เบอร์โทรศัพท์">
            </div>
            <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">
            <div class="flex justify-end">
              <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white py-3 px-8 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-blue-500 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                <span>จองรถราชการ</span> <span>🚗</span>
              </button>
            </div>
          </form>
          <div class="mt-6 text-center text-gray-400 text-xs">
            <span>📞 หากมีข้อสงสัย กรุณาติดต่อเจ้าหน้าที่</span>
          </div>
        </div>

        <!-- รายการจองรถราชการ (ขวา) -->
        <div class="w-full lg:w-1/2">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">📋 รายการจองของฉัน</h3>
            <button id="refreshList" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 transition">รีเฟรช 🔄</button>
          </div>
          <div id="carBookingList" class="space-y-4 max-h-96 overflow-y-auto">
            <!-- JS will render cards here -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->
<?php require_once('script.php');?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const teach_id = "<?php echo $teacher_id; ?>";
function fetchCarBookings() {
    fetch('api/fetch_car_bookings.php?teach_id=' + encodeURIComponent(teach_id))
        .then(res => res.json())
        .then(data => {
            const list = Array.isArray(data.list) ? data.list : [];
            const carBookingList = document.getElementById('carBookingList');
            carBookingList.innerHTML = '';
            if (!list.length) {
                carBookingList.innerHTML = '<div class="text-gray-400 text-center py-8">ไม่มีข้อมูลการจอง</div>';
                return;
            }
            list.forEach(item => {
                const card = document.createElement('div');
                card.className = "bg-blue-50 border-l-4 border-blue-400 rounded-lg shadow-md p-4";
                card.innerHTML = `
                    <div class="mb-1"><b>วันที่:</b> ${item.date || '-'} <b>เวลา:</b> ${item.time || '-'}</div>
                    <div class="mb-1"><b>ประเภทรถ:</b> ${item.car_type || '-'} <b>จุดหมาย:</b> ${item.destination || '-'}</div>
                    <div class="mb-1"><b>วัตถุประสงค์:</b> ${item.purpose || '-'}</div>
                    <div class="mb-1"><b>ผู้เดินทาง:</b> ${item.passengers || '-'}</div>
                    <div class="mb-1"><b>เบอร์โทร:</b> ${item.phone || '-'}</div>
                `;
                carBookingList.appendChild(card);
            });
        });
}
document.getElementById('carBookingForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('api/insert_car_booking.php', {
        method: 'POST',
        body: formData
    }).then(res => res.json()).then(result => {
        if (result.success) {
            Swal.fire('สำเร็จ!', 'จองรถราชการเรียบร้อย', 'success');
            this.reset();
            fetchCarBookings();
        } else {
            Swal.fire('ผิดพลาด!', result.message || 'เกิดข้อผิดพลาด', 'error');
        }
    });
};
document.getElementById('refreshList').onclick = fetchCarBookings;
fetchCarBookings();
</script>
</body>
</html>
