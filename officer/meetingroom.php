<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

require_once('header.php');
?>
<body class="hold-transition sidebar-mini layout-fixed light-mode">
<div class="wrapper">
    <?php require_once('wrapper.php');?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo $global['nameschool']; ?> <span class="text-blue-600">| จัดการจองห้องประชุม</span></h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
        <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-blue-400 animate-fade-in flex flex-col lg:flex-row gap-8">
            <!-- รายการจองห้องประชุม (ซ้าย) -->
            <div class="w-full">
                <!-- Date Picker และ Filter Section -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">📋 รายการจองห้องประชุม</h3>
                    <div class="flex gap-2">
                        <button class="status-filter-btn bg-yellow-100 text-yellow-800 px-3 py-1 rounded hover:bg-yellow-200 text-sm" data-status="0">
                            ⏳ รอการอนุมัติ
                        </button>
                        <button class="status-filter-btn bg-green-100 text-green-800 px-3 py-1 rounded hover:bg-green-200 text-sm" data-status="1">
                            ✅ อนุมัติแล้ว
                        </button>
                        <button class="status-filter-btn bg-red-100 text-red-800 px-3 py-1 rounded hover:bg-red-200 text-sm" data-status="2">
                            ❌ ยกเลิกแล้ว
                        </button>
                        <button class="status-filter-btn bg-gray-100 text-gray-800 px-3 py-1 rounded hover:bg-gray-200 text-sm" data-status="">
                            ทั้งหมด
                        </button>
                        <button id="refreshList" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 transition">รีเฟรช 🔄</button>
                    </div>
                </div>
                <div id="bookingList" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- JS will render cards here -->
                </div>

                <!-- Calendar Section -->
                <div class="mt-8">
                    <h4 class="text-md font-bold text-blue-700 mb-3">📅 ปฏิทินการจองห้องประชุม</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Modal แก้ไขการจอง -->
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
                <button id="closeEditModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
                <h3 class="text-xl font-bold text-blue-700 mb-4">✏️ แก้ไขการจองห้องประชุม</h3>
                <form id="editBookingForm" class="space-y-4">
                    <input type="hidden" name="id" id="editId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1" for="editDate">วันที่ <span class="text-red-500">*</span></label>
                            <input type="date" name="date" id="editDate" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1" for="editLocation">สถานที่ <span class="text-red-500">*</span></label>
                            <select name="location" id="editLocation" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
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
                            <input type="time" name="time_start" id="editTimeStart" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1" for="editTimeEnd">เวลาสิ้นสุด <span class="text-red-500">*</span></label>
                            <input type="time" name="time_end" id="editTimeEnd" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1" for="editPurpose">วัตถุประสงค์ <span class="text-red-500">*</span></label>
                        <textarea name="purpose" id="editPurpose" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" rows="3" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1" for="editMedia">อุปกรณ์ที่ต้องการ</label>
                            <input type="text" name="media" id="editMedia" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1" for="editPhone">เบอร์โทรติดต่อ</label>
                            <input type="tel" name="phone" id="editPhone" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-lg font-bold text-lg hover:from-blue-600 hover:to-blue-800 transition-all flex items-center justify-center gap-2">
                        <span>บันทึกการแก้ไข</span> <span>💾</span>
                    </button>
                </form>
            </div>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <?php require_once('../footer.php');?>
</div>
<!-- ./wrapper -->

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fade-in 1s ease-out; }
</style>
<script>
// ฟังก์ชันแสดง badge สถานะ
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

let currentStatusFilter = '';

// เพิ่ม event listener หลัง DOM โหลดเสร็จ
document.addEventListener('DOMContentLoaded', function() {
  // ปุ่ม filter สถานะ
  document.querySelectorAll('.status-filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      currentStatusFilter = this.dataset.status;
    //   console.log('Filter clicked:', currentStatusFilter);
      
      // ไฮไลท์ปุ่มที่เลือก
      document.querySelectorAll('.status-filter-btn').forEach(b => {
        b.classList.remove('ring', 'ring-2', 'ring-blue-400');
      });
      this.classList.add('ring', 'ring-2', 'ring-blue-400');
      
      // ดึงข้อมูลใหม่ตามสถานะที่เลือกทันที
      fetchAllBookings('', '', currentStatusFilter);
    });
  });

  // Modal แก้ไข event listeners
  document.getElementById('closeEditModal').addEventListener('click', function() {
    document.getElementById('editModal').classList.add('hidden');
  });
  document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
      this.classList.add('hidden');
    }
  });

  // ฟอร์มแก้ไขข้อมูล
  document.getElementById('editBookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('api/edit_booking_by_officer.php', {
      method: 'POST',
      body: formData
    }).then(res => res.json()).then(result => {
      if (result.success) {
        Swal.fire('สำเร็จ! 🎉', 'แก้ไขการจองเรียบร้อย', 'success').then(() => {
          document.getElementById('editModal').classList.add('hidden');
          fetchAllBookings();
          fetchCalendarBookings();
        });
      } else {
        Swal.fire('ผิดพลาด! ❌', result.message || 'เกิดข้อผิดพลาด', 'error');
      }
    }).catch(err => {
      Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
    });
  });

  // โหลดข้อมูลเริ่มต้น
  fetchAllBookings();
  fetchCalendarBookings();
});

function fetchAllBookings(date = '', location = '', status = undefined) {
  if (typeof status === 'undefined') status = currentStatusFilter;
  
  let url = '../teacher/api/fetch_all_bookings.php?';
  const params = new URLSearchParams();
  if (date) params.append('date', date);
  if (location) params.append('location', location);
  if (status !== '' && status !== null && typeof status !== 'undefined') {
    params.append('status', status);
  }
  url += params.toString();
  
//   console.log('Fetching URL:', url);

  fetch(url)
    .then(res => res.json())
    .then(data => {
    //   console.log('Received data:', data);
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
            <div class="flex flex-col gap-2 ml-4">
              <button class="edit-btn bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm" data-id="${item.id}">✏️ แก้ไข</button>
              <button class="delete-btn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700 text-sm" data-id="${item.id}">🗑️ ลบ</button>
              <button class="status-btn bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm" data-id="${item.id}" data-status="${item.status}">อัปเดตสถานะ</button>
            </div>
          </div>
        `;
        bookingList.appendChild(card);
        
        // Add event listeners immediately after creating the card
        const editBtn = card.querySelector('.edit-btn');
        const deleteBtn = card.querySelector('.delete-btn');
        const statusBtn = card.querySelector('.status-btn');
        
        editBtn.addEventListener('click', function() {
          const bookingId = this.dataset.id;
        //   console.log('Edit button clicked for booking ID:', bookingId);
          fetch('../teacher/api/fetch_booking_detail.php?id=' + encodeURIComponent(bookingId))
            .then(res => res.json())
            .then(data => {
              if (data.success && data.booking) {
                const booking = data.booking;
                document.getElementById('editId').value = booking.id;
                document.getElementById('editDate').value = booking.date;
                document.getElementById('editLocation').value = booking.location;
                document.getElementById('editPurpose').value = booking.purpose;
                document.getElementById('editPhone').value = booking.phone || '';
                document.getElementById('editMedia').value = booking.media || '';
                document.getElementById('editTimeStart').value = booking.time_start;
                document.getElementById('editTimeEnd').value = booking.time_end;
                document.getElementById('editModal').classList.remove('hidden');
              } else {
                Swal.fire('ผิดพลาด! ❌', 'ไม่สามารถโหลดข้อมูลการจองได้', 'error');
              }
            })
            .catch(err => {
              console.error('Error:', err);
              Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        });
        
        deleteBtn.addEventListener('click', function() {
          const bookingId = this.dataset.id;
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
              fetch('../teacher/api/delete_booking.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: bookingId })
              }).then(res => res.json()).then(result => {
                if (result.success) {
                  Swal.fire('ลบสำเร็จ!', 'การจองถูกลบเรียบร้อยแล้ว', 'success');
                  fetchAllBookings();
                  fetchCalendarBookings();
                } else {
                  Swal.fire('ผิดพลาด! ❌', result.message || 'เกิดข้อผิดพลาด', 'error');
                }
              }).catch(err => {
                Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
              });
            }
          });
        });
        
        statusBtn.addEventListener('click', function() {
          const bookingId = this.dataset.id;
          const currentStatus = parseInt(this.dataset.status);
          Swal.fire({
            title: 'อัปเดตสถานะ',
            input: 'select',
            inputOptions: {
              0: '⏳ รอการอนุมัติ',
              1: '✅ อนุมัติแล้ว',
              2: '❌ ยกเลิกแล้ว'
            },
            inputValue: currentStatus,
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก'
          }).then(result => {
            if (result.isConfirmed) {
              fetch('../teacher/api/update_booking_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: bookingId, status: result.value })
              })
              .then(res => res.json())
              .then(data => {
                if (data.success) {
                  Swal.fire('สำเร็จ!', 'อัปเดตสถานะเรียบร้อย', 'success');
                  fetchAllBookings();
                  fetchCalendarBookings();
                } else {
                  Swal.fire('ผิดพลาด! ❌', data.message || 'เกิดข้อผิดพลาด', 'error');
                }
              })
              .catch(() => {
                Swal.fire('ผิดพลาด! ❌', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
              });
            }
          });
        });
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
    backgroundColor: '#38bdf8',
    borderColor: '#0ea5e9',
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
  fetch('../teacher/api/fetch_all_bookings.php')
    .then(res => res.json())
    .then(data => {
      const list = Array.isArray(data.list) ? data.list : [];
      renderCalendar(list);
    })
    .catch(err => {
      document.getElementById('calendar').innerHTML = '<div class="text-red-400 text-center py-8">❌ ไม่สามารถโหลดปฏิทิน</div>';
    });
}

// Event listeners สำหรับ filter section
document.getElementById('searchForm').addEventListener('submit', function(e) {
  e.preventDefault();
  currentStatusFilter = document.getElementById('searchStatus') ? document.getElementById('searchStatus').value : '';
  document.querySelectorAll('.status-filter-btn').forEach(b => b.classList.remove('ring', 'ring-2', 'ring-blue-400'));
  fetchAllBookings(
    document.getElementById('searchDate').value,
    document.getElementById('searchLocation').value,
    currentStatusFilter
  );
});

document.getElementById('showAllBookings').addEventListener('click', function() {
  currentStatusFilter = '';
  document.querySelectorAll('.status-filter-btn').forEach(b => b.classList.remove('ring', 'ring-2', 'ring-blue-400'));
  fetchAllBookings();
});

document.getElementById('clearSearch').addEventListener('click', function() {
  document.getElementById('searchDate').value = '';
  document.getElementById('searchLocation').value = '';
  if (document.getElementById('searchStatus')) document.getElementById('searchStatus').value = '';
  currentStatusFilter = '';
  document.querySelectorAll('.status-filter-btn').forEach(b => b.classList.remove('ring', 'ring-2', 'ring-blue-400'));
  fetchAllBookings();
});

// ปรับปุ่ม refresh ให้รีเซ็ต filter
document.getElementById('refreshList').onclick = function() {
  currentStatusFilter = '';
  document.querySelectorAll('.status-filter-btn').forEach(b => {
    b.classList.remove('ring', 'ring-2', 'ring-blue-400');
  });
  fetchAllBookings();
};
</script>
<?php require_once('script.php'); ?>
</body>
</html>
