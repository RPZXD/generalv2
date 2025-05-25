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
              <?php echo $global['nameschool']; ?>
              <span class="text-blue-600 text-2xl animate-bounce">| ครู 👨‍🏫</span>
            </h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->
        <div class="alert alert-success bg-green-100 border-l-4 border-green-400 text-green-700 rounded-lg shadow p-4 mb-6 flex items-center gap-2">
          <span class="text-2xl animate-bounce">👋</span>
          <span>ยินดีต้อนรับเข้าสู่ระบบ</span>
        </div>
    <section class="content">
      <div class="container-fluid">
        <!-- กล่องแนะนำระบบบริหารงานทั่วไป -->
        <div class="mb-8 max-w-4xl mx-auto bg-white border-l-8 border-blue-400 rounded-2xl shadow-xl p-6 flex flex-col md:flex-row items-center gap-6 animate-fade-in">
          <div class="text-6xl md:text-7xl mb-2 md:mb-0 animate-wiggle">🛠️🏢🚗</div>
          <div>
            <h2 class="text-2xl font-extrabold text-blue-700 mb-2 flex items-center gap-2">
              ระบบบริหารงานทั่วไป <span class="animate-pulse">✨</span>
            </h2>
            <ul class="list-none space-y-1 text-gray-700">
              <li class="flex items-center gap-2">
                <span class="text-blue-500 text-xl">📋</span>
                <span><b>แจ้งซ่อม</b> - แจ้งปัญหาและติดตามสถานะการซ่อมแซม</span>
              </li>
              <li class="flex items-center gap-2">
                <span class="text-indigo-500 text-xl">🏢</span>
                <span><b>จองห้องประชุม</b> - ตรวจสอบและจองห้องประชุมได้อย่างสะดวก</span>
              </li>
              <li class="flex items-center gap-2">
                <span class="text-green-500 text-xl">🚗</span>
                <span><b>จองรถ</b> - จองรถสำหรับภารกิจต่าง ๆ ของโรงเรียน</span>
              </li>
            </ul>
            <div class="mt-2 text-xs text-gray-400">* สำหรับครูสามารถใช้งานทุกฟังก์ชันได้ในระบบนี้</div>
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

<script>
  // เพิ่ม animation เล็กน้อย
  document.addEventListener('DOMContentLoaded', function () {
    const wiggleEls = document.querySelectorAll('.animate-wiggle');
    wiggleEls.forEach(el => {
      el.style.animation = 'wiggle 1.2s infinite';
    });
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
<?php require_once('script.php');?>
</body>
</html>
