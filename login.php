<?php
/**
 * Login Page
 * Uses the new MVC layout with modern UI
 */
session_start();

// โหลด config
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
$global = $config['global'];

// เพิ่ม: เรียกใช้ LoginController
require_once __DIR__ . '/controllers/LoginController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];
    $input_role = $_POST['role'];

    $controller = new LoginController();
    $error = $controller->login($input_username, $input_password, $input_role);
}

$pageTitle = 'เข้าสู่ระบบ';

// Render view with layout
ob_start();
require 'views/auth/login.php';
$content = ob_get_clean();
require 'views/layouts/app.php';
?>

<?php if (isset($error) && $error !== 'success') { ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'เข้าสู่ระบบไม่สำเร็จ',
    text: <?= json_encode($error) ?>,
    confirmButtonText: 'ปิด',
    confirmButtonColor: '#3085d6'
});
</script>
<?php } ?>

<?php if (isset($_GET['logout']) && $_GET['logout'] == '1') { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'ออกจากระบบสำเร็จ',
    text: 'คุณได้ออกจากระบบเรียบร้อยแล้ว',
    confirmButtonText: 'ตกลง',
    confirmButtonColor: '#3085d6'
});
</script>
<?php } ?>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($error) && $error === 'success') { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'เข้าสู่ระบบสำเร็จ',
    text: 'กำลังเข้าสู่ระบบ...',
    showConfirmButton: false,
    timer: 1500
}).then(() => {
    <?php
    $redirect = 'dashboard.php';
    if (isset($_POST['role']) && $_POST['role'] === 'ครู') {
        $redirect = 'teacher/index.php';
    } else if (isset($_POST['role']) && $_POST['role'] === 'นักเรียน') {
        $redirect = 'student/index.php';
    } else if (isset($_POST['role']) && $_POST['role'] === 'เจ้าหน้าที่') {
        $redirect = 'officer/index.php';
    }
    ?>
    window.location.href = <?= json_encode($redirect) ?>;
});
</script>
<?php } ?>
