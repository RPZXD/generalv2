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
<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-100 min-h-screen font-sans" style="font-family: 'Mali', sans-serif;">
<div class="wrapper">

    <?php require_once('wrapper.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <div class="content-header">
      <div class="container-fluid">
        
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 flex items-center gap-2">
              <span class="text-blue-600 text-2xl animate-bounce"> บันทึกการแจ้งซ่อม </span>
            </h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-blue-400 animate-fade-in flex flex-col md:flex-row gap-8">
        <!-- ฟอร์มบันทึกแจ้งซ่อม (ซ้าย) -->
        <div class="w-full md:w-1/2">
          <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl animate-bounce">🛠️</span>
            <h2 class="text-2xl font-extrabold text-blue-700">บันทึกการแจ้งซ่อม</h2>
          </div>
          <form id="addReportForm" method="POST">
            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-1" for="AddDate">วันที่แจ้ง <span class="text-red-500">*</span></label>
              <input type="date" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="AddDate" name="AddDate" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-1" for="AddLocation">สถานที่ <span class="text-red-500">*</span></label>
              <input type="text" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" id="AddLocation" name="AddLocation" placeholder="เช่น ห้องคอม(438) อาคาร 4" required>
            </div>
            <div class="mb-4">
              <h5 class="font-bold mb-2">==== มีทรัพย์สินชำรุด/เสียหาย ดังนี้ ====</h5>
              <h6 class="font-semibold">1. ครุภัณฑ์ภายในห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="topic1"></div>
              <h6 class="font-semibold mt-4">2. ทัศนูปกรณ์ประจำห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="topic2"></div>
              <h6 class="font-semibold mt-4">3. เครื่องใช้ไฟฟ้าประจำห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="topic3"></div>
            </div>
            <input type="hidden" name="teach_id" value="<?php echo $teacher_id; ?>">
            <div class="flex justify-end">
              <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-bold text-lg hover:bg-blue-700 transition-all flex items-center gap-2">
                <span>บันทึกแจ้งซ่อม</span> <span>🚀</span>
              </button>
            </div>
          </form>
          <div class="mt-6 text-center text-gray-400 text-xs">
            <span>📞 หากเร่งด่วน กรุณาติดต่อเจ้าหน้าที่โดยตรง</span>
          </div>
        </div>
        <!-- รายการแจ้งซ่อม (ขวา) -->
        <div class="w-full md:w-1/2">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">📋 รายการแจ้งซ่อม</h3>
            <button id="refreshList" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700 transition">รีเฟรช 🔄</button>
          </div>
          <div id="repairCardList" class="space-y-4">
            <!-- JS will render cards here -->
          </div>
        </div>
      </div>
      <!-- Modal แก้ไขแจ้งซ่อม -->
      <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
          <button id="closeEditModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>
          <h3 class="text-xl font-bold text-blue-700 mb-4">✏️ แก้ไขการแจ้งซ่อม</h3>
          <form id="editRepairForm">
            <input type="hidden" name="id" id="editId">
            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-1" for="editAddDate">วันที่แจ้ง <span class="text-red-500">*</span></label>
              <input type="date" name="AddDate" id="editAddDate" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 font-semibold mb-1" for="editAddLocation">สถานที่ <span class="text-red-500">*</span></label>
              <input type="text" name="AddLocation" id="editAddLocation" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
              <h5 class="font-bold mb-2">==== มีทรัพย์สินชำรุด/เสียหาย ดังนี้ ====</h5>
              <h6 class="font-semibold">1. ครุภัณฑ์ภายในห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="edit_topic1" class="border-l-4 border-blue-300 pl-4 mb-3"></div>
              <h6 class="font-semibold mt-4">2. ทัศนูปกรณ์ประจำห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="edit_topic2" class="border-l-4 border-green-300 pl-4 mb-3"></div>
              <h6 class="font-semibold mt-4">3. เครื่องใช้ไฟฟ้าประจำห้องเรียน/ห้องปฏิบัติการที่ชำรุด</h6>
              <div id="edit_topic3" class="border-l-4 border-yellow-300 pl-4 mb-3"></div>
            </div>
            <button type="submit" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-bold text-lg hover:bg-yellow-600 transition-all flex items-center justify-center gap-2">
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

<script>
  // ย้ายตัวแปร items, items2, items3 ไปไว้ด้านนอกสุดเพื่อให้ทุกฟังก์ชันเข้าถึงได้
  const items = [
    { id: 'door', label: 'ประตู', detailsId: 'doorDetails' },
    { id: 'window', label: 'หน้าต่าง', detailsId: 'windowDetails' },
    { id: 'tablest', label: 'โต๊ะนักเรียน', detailsId: 'tablestDetails' },
    { id: 'chairst', label: 'เก้าอี้นักเรียน', detailsId: 'chairstDetails' },
    { id: 'tableta', label: 'โต๊ะครู', detailsId: 'tabletaDetails' },
    { id: 'chairta', label: 'เก้าอี้ครู', detailsId: 'chairtaDetails' },
    { id: 'other1', label: 'อื่นๆ', detailsId: 'other1Details' }
  ];
  const items2 = [
    { id: 'tv', label: 'โทรทัศน์', detailsId: 'tvDetails' },
    { id: 'audio', label: 'เครื่องเสียง', detailsId: 'audioDetails' },
    { id: 'hdmi', label: 'สาย HDMI', detailsId: 'hdmiDetails' },
    { id: 'projector', label: 'จอโปรเจคเตอร์', detailsId: 'projectorDetails' },
    { id: 'other2', label: 'อื่นๆ', detailsId: 'other2Details' }
  ];
  const items3 = [
    { id: 'fan', label: 'พัดลม', detailsId: 'fanDetails' },
    { id: 'light', label: 'หลอดไฟ', detailsId: 'lightDetails' },
    { id: 'air', label: 'เครื่องปรับอากาศ', detailsId: 'airDetails' },
    { id: 'sw', label: 'สวิตซ์ไฟ', detailsId: 'swDetails' },
    { id: 'swfan', label: 'สวิตซ์พัดลม', detailsId: 'swfanDetails' },
    { id: 'plug', label: 'ปลั๊กไฟ', detailsId: 'plugDetails' },
    { id: 'other3', label: 'อื่นๆ', detailsId: 'other3Details' }
  ];

  // เพิ่ม animation เล็กน้อย
  document.addEventListener('DOMContentLoaded', function () {
    const wiggleEls = document.querySelectorAll('.animate-wiggle');
    wiggleEls.forEach(el => {
      el.style.animation = 'wiggle 1.2s infinite';
    });

    // กำหนดวันที่ปัจจุบัน
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('AddDate').value = formattedDate;

    // สร้างรายการฟอร์มสำหรับแต่ละกลุ่ม
    // ย้ายตัวแปร items, items2, items3 ไปไว้ด้านนอกสุดของ <script> เพื่อให้ทุกฟังก์ชันเข้าถึงได้
    const items = [
      { id: 'door', label: 'ประตู', detailsId: 'doorDetails' },
      { id: 'window', label: 'หน้าต่าง', detailsId: 'windowDetails' },
      { id: 'tablest', label: 'โต๊ะนักเรียน', detailsId: 'tablestDetails' },
      { id: 'chairst', label: 'เก้าอี้นักเรียน', detailsId: 'chairstDetails' },
      { id: 'tableta', label: 'โต๊ะครู', detailsId: 'tabletaDetails' },
      { id: 'chairta', label: 'เก้าอี้ครู', detailsId: 'chairtaDetails' },
      { id: 'other1', label: 'อื่นๆ', detailsId: 'other1Details' }
    ];
    const items2 = [
      { id: 'tv', label: 'โทรทัศน์', detailsId: 'tvDetails' },
      { id: 'audio', label: 'เครื่องเสียง', detailsId: 'audioDetails' },
      { id: 'hdmi', label: 'สาย HDMI', detailsId: 'hdmiDetails' },
      { id: 'projector', label: 'จอโปรเจคเตอร์', detailsId: 'projectorDetails' },
      { id: 'other2', label: 'อื่นๆ', detailsId: 'other2Details' }
    ];
    const items3 = [
      { id: 'fan', label: 'พัดลม', detailsId: 'fanDetails' },
      { id: 'light', label: 'หลอดไฟ', detailsId: 'lightDetails' },
      { id: 'air', label: 'เครื่องปรับอากาศ', detailsId: 'airDetails' },
      { id: 'sw', label: 'สวิตซ์ไฟ', detailsId: 'swDetails' },
      { id: 'swfan', label: 'สวิตซ์พัดลม', detailsId: 'swfanDetails' },
      { id: 'plug', label: 'ปลั๊กไฟ', detailsId: 'plugDetails' },
      { id: 'other3', label: 'อื่นๆ', detailsId: 'other3Details' }
    ];

    function createFormElement(item, topicId) {
      const topic = document.getElementById(topicId);
      const formCheckDiv = document.createElement('div');
      formCheckDiv.classList.add('form-check', 'mt-3', 'p-2', 'bg-gray-50', 'rounded');

      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.id = item.id;
      checkbox.classList.add('form-check-input', 'mr-2');
      checkbox.onchange = () => toggleDetails(item.id);

      const label = document.createElement('label');
      label.setAttribute('for', item.id);
      label.classList.add('form-check-label', 'font-semibold', 'cursor-pointer');
      label.innerHTML = `${item.label}`;

      formCheckDiv.appendChild(checkbox);
      formCheckDiv.appendChild(label);

      const detailsDiv = document.createElement('div');
      detailsDiv.id = item.detailsId;
      detailsDiv.style.display = 'none';
      detailsDiv.classList.add('mt-2', 'p-3', 'bg-white', 'rounded', 'border');

      // Create the input field for "อื่นๆ" only if necessary
      if (item.id.includes('other')) {
        const otherInputDiv = document.createElement('div');
        otherInputDiv.style.display = 'none';
        otherInputDiv.classList.add('mb-2');

        const otherLabel = document.createElement('label');
        otherLabel.textContent = 'โปรดระบุ:';
        otherLabel.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
        const otherInput = document.createElement('input');
        otherInput.type = 'text';
        otherInput.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
        otherInput.name = `${item.id}Details`;

        otherInputDiv.appendChild(otherLabel);
        otherInputDiv.appendChild(otherInput);
        detailsDiv.appendChild(otherInputDiv);

        otherInputDiv.dataset.otherInput = 'true';
      }

      const row = document.createElement('div');
      row.classList.add('flex', 'gap-3', 'mt-2');

      const col1 = document.createElement('div');
      col1.classList.add('w-1/4');

      const label1 = document.createElement('label');
      label1.textContent = 'จำนวน:';
      label1.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
      const inputNumber = document.createElement('input');
      inputNumber.type = 'number';
      inputNumber.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
      inputNumber.name = `${item.id}Count`;
      inputNumber.min = 0;

      col1.appendChild(label1);
      col1.appendChild(inputNumber);

      const col2 = document.createElement('div');
      col2.classList.add('w-3/4');

      const label2 = document.createElement('label');
      label2.textContent = 'ระบุความเสียหาย:';
      label2.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
      const textarea = document.createElement('textarea');
      textarea.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
      textarea.name = `${item.id}Damage`;
      textarea.rows = 2;

      col2.appendChild(label2);
      col2.appendChild(textarea);

      row.appendChild(col1);
      row.appendChild(col2);
      detailsDiv.appendChild(row);
      topic.appendChild(formCheckDiv);
      topic.appendChild(detailsDiv);
    }

    function toggleDetails(itemId) {
      const detailsDiv = document.getElementById(`${itemId}Details`);
      const checkbox = document.getElementById(itemId);

      if (checkbox.checked) {
        detailsDiv.style.display = 'block';
      } else {
        detailsDiv.style.display = 'none';
      }

      if (itemId.includes('other')) {
        const otherInputDiv = detailsDiv.querySelector('[data-other-input="true"]');
        if (otherInputDiv) {
          otherInputDiv.style.display = checkbox.checked ? 'block' : 'none';
        }
      }
    }

    // สร้างฟอร์มสำหรับแต่ละกลุ่ม
    items.forEach(item => createFormElement(item, 'topic1'));
    items2.forEach(item => createFormElement(item, 'topic2'));
    items3.forEach(item => createFormElement(item, 'topic3'));
  });
</script>
<style>
@keyframes wiggle {
  0%, 100% { transform: rotate(-5deg);}
  50% { transform: rotate(5deg);}
}
.animate-wiggle { animation: wiggle 1.2s infinite; }
@keyframes fade-in {
  from { opacity: 0;}
  to { opacity: 1;}
}
.animate-fade-in { animation: fade-in 1s; }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const teach_id = "<?php echo $teacher_id; ?>";
function fetchRepairs() {
  fetch('api/fet_report_repair.php?Teach_id=' + encodeURIComponent(teach_id))
    .then(res => res.json())
    .then(data => {
      // รองรับรูปแบบใหม่ที่ส่งกลับมาเป็น {list, term, pee}
      const list = Array.isArray(data) ? data : (data.list || []);
      const cardList = document.getElementById('repairCardList');
      cardList.innerHTML = '';
      if (!list.length) {
        cardList.innerHTML = '<div class="text-gray-400 text-center">ไม่มีข้อมูล</div>';
        return;
      }
      list.forEach(item => {
        const card = document.createElement('div');
        card.className = "bg-blue-50 border-l-4 border-blue-400 rounded-lg shadow p-4 flex flex-col md:flex-row md:items-center gap-4";
        card.innerHTML = `
          <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
              <span class="font-bold text-blue-700">📅 วันที่:</span>
              <span>${item.AddDate || '-'}</span>
            </div>
            <div class="flex items-center gap-2 mb-1">
              <span class="font-bold text-blue-700">📍 สถานที่:</span>
              <span>${item.AddLocation || '-'}</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="font-bold text-blue-700">📝 รายละเอียด:</span>
              <span>${item.doorDamage || '-'}</span>
            </div>
          </div>
          <div class="flex flex-row md:flex-col gap-2 md:items-end">
            <button class="editBtn bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-600" data-id="${item.id}">แก้ไข</button>
            <button class="deleteBtn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700" data-id="${item.id}">ลบ</button>
          </div>
        `;
        cardList.appendChild(card);
      });
    });
}
fetchRepairs();
document.getElementById('refreshList').onclick = fetchRepairs;

// เพิ่มข้อมูลใหม่
document.getElementById('addReportForm').onsubmit = function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  // ตรวจสอบว่ามี field ที่เกี่ยวข้องกับ topic1, topic2, topic3 ที่ถูกเลือกหรือไม่
  // ถ้าไม่มี checkbox ใดถูกเลือกเลย ให้เตือน
  let hasChecked = false;
  ['topic1','topic2','topic3'].forEach(topicId => {
    const topic = document.getElementById(topicId);
    if (topic && topic.querySelector('input[type="checkbox"]:checked')) {
      hasChecked = true;
    }
  });
  // ถ้าต้องการบังคับให้เลือกอย่างน้อย 1 รายการ ให้ใช้โค้ดนี้
  // if (!hasChecked) {
  //   Swal.fire('กรุณาเลือกทรัพย์สินที่ชำรุด/เสียหายอย่างน้อย 1 รายการ','','warning');
  //   return;
  // }

  fetch('api/insert_report_repair.php', {
    method: 'POST',
    body: formData
  }).then(res => res.json()).then(result => {
    if (result.success) {
      Swal.fire('สำเร็จ', 'บันทึกข้อมูลเรียบร้อย', 'success');
      this.reset();
      // รีเซ็ตวันที่เป็นวันนี้อีกครั้งหลัง reset
      const today = new Date();
      const formattedDate = today.toISOString().split('T')[0];
      document.getElementById('AddDate').value = formattedDate;
      fetchRepairs();
    } else {
      Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
    }
  }).catch(() => {
    Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
  });
};

// ฟอร์มแก้ไข: สร้าง element เหมือนฟอร์มบันทึก
function createEditFormElement(item, topicId) {
  const topic = document.getElementById(topicId);
  if (!topic) return;

  const formCheckDiv = document.createElement('div');
  formCheckDiv.classList.add('form-check', 'mt-3', 'p-2', 'bg-gray-50', 'rounded');

  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.id = 'edit_' + item.id;
  checkbox.classList.add('form-check-input', 'mr-2');
  checkbox.onchange = function() { toggleEditDetails(item.id); };

  const label = document.createElement('label');
  label.setAttribute('for', 'edit_' + item.id);
  label.classList.add('form-check-label', 'font-semibold', 'cursor-pointer');
  label.innerHTML = `${item.label}`;

  formCheckDiv.appendChild(checkbox);
  formCheckDiv.appendChild(label);

  const detailsDiv = document.createElement('div');
  detailsDiv.id = 'edit_' + item.detailsId;
  detailsDiv.style.display = 'none';
  detailsDiv.classList.add('mt-2', 'p-3', 'bg-white', 'rounded', 'border');

  if (item.id.includes('other')) {
    const otherInputDiv = document.createElement('div');
    otherInputDiv.style.display = 'none';
    otherInputDiv.classList.add('mb-2');

    const otherLabel = document.createElement('label');
    otherLabel.textContent = 'โปรดระบุ:';
    otherLabel.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
    const otherInput = document.createElement('input');
    otherInput.type = 'text';
    otherInput.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
    otherInput.name = `${item.id}Details`;

    otherInputDiv.appendChild(otherLabel);
    otherInputDiv.appendChild(otherInput);
    detailsDiv.appendChild(otherInputDiv);

    otherInputDiv.dataset.otherInput = 'true';
  }

  const row = document.createElement('div');
  row.classList.add('flex', 'gap-3', 'mt-2');

  const col1 = document.createElement('div');
  col1.classList.add('w-1/4');

  const label1 = document.createElement('label');
  label1.textContent = 'จำนวน:';
  label1.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
  const inputNumber = document.createElement('input');
  inputNumber.type = 'number';
  inputNumber.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
  inputNumber.name = `${item.id}Count`;
  inputNumber.min = 0;

  col1.appendChild(label1);
  col1.appendChild(inputNumber);

  const col2 = document.createElement('div');
  col2.classList.add('w-3/4');

  const label2 = document.createElement('label');
  label2.textContent = 'ระบุความเสียหาย:';
  label2.classList.add('block', 'text-sm', 'font-medium', 'mb-1');
  const textarea = document.createElement('textarea');
  textarea.classList.add('form-control', 'w-full', 'p-2', 'border', 'rounded');
  textarea.name = `${item.id}Damage`;
  textarea.rows = 2;

  col2.appendChild(label2);
  col2.appendChild(textarea);

  row.appendChild(col1);
  row.appendChild(col2);
  detailsDiv.appendChild(row);
  topic.appendChild(formCheckDiv);
  topic.appendChild(detailsDiv);
}

function toggleEditDetails(itemId) {
  const detailsDiv = document.getElementById(`edit_${itemId}Details`);
  const checkbox = document.getElementById('edit_' + itemId);

  // ป้องกัน error ถ้า element ไม่เจอ
  if (!detailsDiv || !checkbox) return;

  if (checkbox.checked) {
    detailsDiv.style.display = 'block';
  } else {
    detailsDiv.style.display = 'none';
  }

  if (itemId.includes('other')) {
    const otherInputDiv = detailsDiv.querySelector('[data-other-input="true"]');
    if (otherInputDiv) {
      otherInputDiv.style.display = checkbox.checked ? 'block' : 'none';
    }
  }
}

function renderEditFormFields(report = {}) {
  // ลบฟอร์มเดิม
  ['edit_topic1','edit_topic2','edit_topic3'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.innerHTML = '';
  });
  // สร้างฟอร์มใหม่
  items.forEach(item => createEditFormElement(item, 'edit_topic1'));
  items2.forEach(item => createEditFormElement(item, 'edit_topic2'));
  items3.forEach(item => createEditFormElement(item, 'edit_topic3'));

  // กรอกข้อมูลเดิม (ถ้ามี)
  if (report && typeof report === 'object') {
    [...items, ...items2, ...items3].forEach(item => {
      const checkbox = document.getElementById('edit_' + item.id);
      const detailsDiv = document.getElementById(`edit_${item.detailsId}`);
      const checked = (report[item.id + 'Count'] && report[item.id + 'Count'] > 0) ||
                      (report[item.id + 'Damage'] && report[item.id + 'Damage'] !== '') ||
                      (report[item.id + 'Details'] && report[item.id + 'Details'] !== '');
      if (checkbox) checkbox.checked = checked;
      toggleEditDetails(item.id);

      // จำนวน
      const inputNumber = detailsDiv ? detailsDiv.querySelector(`input[name="${item.id}Count"]`) : null;
      if (inputNumber && report[item.id + 'Count'] !== undefined) inputNumber.value = report[item.id + 'Count'] || '';

      // ความเสียหาย
      const textarea = detailsDiv ? detailsDiv.querySelector(`textarea[name="${item.id}Damage"]`) : null;
      if (textarea && report[item.id + 'Damage'] !== undefined) textarea.value = report[item.id + 'Damage'] || '';

      // รายละเอียดอื่นๆ
      if (item.id.includes('other')) {
        const otherInput = detailsDiv ? detailsDiv.querySelector(`input[name="${item.id}Details"]`) : null;
        if (otherInput && report[item.id + 'Details'] !== undefined) otherInput.value = report[item.id + 'Details'] || '';
      }
    });
  }
}

// เปิด modal แก้ไข
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('editBtn')) {
    // ให้แน่ใจว่า modal ถูก render แล้วก่อนเรียก renderEditFormFields
    // ไม่ต้อง setTimeout เพราะ modal และ div edit_topic1-3 มีอยู่ใน DOM แล้ว
    const id = e.target.dataset.id;
    fetch('api/fetch_report_detail.php?id=' + encodeURIComponent(id))
      .then(res => res.json())
      .then(result => {
        if (result.success) {
          document.getElementById('editId').value = result.report.id;
          document.getElementById('editAddDate').value = result.report.AddDate;
          document.getElementById('editAddLocation').value = result.report.AddLocation;
          renderEditFormFields(result.report);
          document.getElementById('editModal').classList.remove('hidden');
        } else {
          Swal.fire('ผิดพลาด', result.message || 'ไม่พบข้อมูล', 'error');
        }
      });
  }
});

// ปิด modal แก้ไข
document.getElementById('closeEditModal').onclick = function() {
  document.getElementById('editModal').classList.add('hidden');
};

// บันทึกการแก้ไข
document.getElementById('editRepairForm').onsubmit = function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('api/update_report_repair.php', {
    method: 'POST',
    body: formData
  }).then(res => res.json()).then(result => {
    if (result.success) {
      Swal.fire('สำเร็จ', 'แก้ไขข้อมูลเรียบร้อย', 'success');
      document.getElementById('editModal').classList.add('hidden');
      fetchRepairs();
    } else {
      Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
    }
  });
};

// ลบข้อมูล
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('deleteBtn')) {
    const id = e.target.dataset.id;
    Swal.fire({
      title: 'ยืนยันการลบ?',
      text: 'คุณต้องการลบรายการนี้หรือไม่',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'ลบ',
      cancelButtonText: 'ยกเลิก'
    }).then(result => {
      if (result.isConfirmed) {
        fetch('api/del_report_repair.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            Swal.fire('ลบแล้ว', '', 'success');
            fetchRepairs();
          } else {
            // แสดงข้อความ error ที่ได้จาก API
            Swal.fire('ผิดพลาด', result.message || 'เกิดข้อผิดพลาด', 'error');
          }
        })
        .catch(() => {
          Swal.fire('ผิดพลาด', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
        });
      }
    });
  }
});
</script>
<?php require_once('script.php');?>
</body>
</html>
