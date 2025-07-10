<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'เจ้าหน้าที่') {
    header('Location: ../login.php');
    exit;
}
$config = json_decode(file_get_contents('../config.json'), true);
$global = $config['global'];

$user = $_SESSION['user'];
$teacher_id = $user['Teach_id'] ?? $_SESSION['Teach_id'];

require_once __DIR__ . '/../classes/DatabaseUsers.php';
use App\DatabaseUsers;

$dbUsers = new DatabaseUsers();
$pdo = $dbUsers->getPDO();

// ใช้ method ที่ถูกต้องในการดึงข้อมูลครู
if ($teacher_id) {
    $TeacherData = $dbUsers->getTeacherById($teacher_id);
} else {
    $TeacherData = $dbUsers->getTeacherByUsername($_SESSION['username']);
}

// ตรวจสอบว่าพบข้อมูลครูหรือไม่
if (!$TeacherData) {
    // ถ้าไม่พบข้อมูลครู ให้ logout
    session_destroy();
    header('Location: ../login.php');
    exit;
}

require_once('header.php');
?>
<body class="bg-gradient-to-br from-blue-50 via-white to-green-100 min-h-screen">
<div class="wrapper">
    <?php require_once('wrapper.php');?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 flex items-center gap-2">
                            <?php echo $global['nameschool']; ?>
                            <span class="text-blue-600 text-2xl">| การจองรถยนต์ 🚗</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container mx-auto max-w-8xl bg-white rounded-xl shadow-xl p-8 mt-8 border-l-8 border-blue-400 animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2">📋 รายการจองรถยนต์ทั้งหมด</h2>
                    <button id="addBookingBtn" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-2 px-6 rounded-lg font-bold hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>+ จองรถยนต์</span> <span>🚗</span>
                    </button>
                </div>                <!-- ปุ่มสลับมุมมองที่สวยงาม -->
                <div class="flex gap-2 mb-6">
                  <div class="bg-gray-100 rounded-lg p-1 flex">
                    <button id="showTableBtn" class="view-toggle-btn active px-6 py-2 rounded-md font-medium transition-all duration-300 flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18m-7 8h7m-7 4h7m-7-8H3m0 4h7"></path>
                      </svg>
                      ตาราง
                    </button>
                    <button id="showCalendarBtn" class="view-toggle-btn px-6 py-2 rounded-md font-medium transition-all duration-300 flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                      </svg>
                      ปฏิทิน
                    </button>
                  </div>
                  <!-- สถิติด่วน -->
                  <div class="ml-auto flex gap-4 items-center">
                    <div class="bg-blue-50 rounded-lg px-4 py-2 border border-blue-200">
                      <div class="text-xs text-blue-600 font-medium">รอพิจารณา</div>
                      <div class="text-lg font-bold text-blue-700" id="pendingCount">0</div>
                    </div>
                    <div class="bg-green-50 rounded-lg px-4 py-2 border border-green-200">
                      <div class="text-xs text-green-600 font-medium">อนุมัติแล้ว</div>
                      <div class="text-lg font-bold text-green-700" id="approvedCount">0</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg px-4 py-2 border border-purple-200">
                      <div class="text-xs text-purple-600 font-medium">รวมทั้งหมด</div>
                      <div class="text-lg font-bold text-purple-700" id="totalCount">0</div>
                    </div>
                  </div>
                </div>                <!-- Filter Section ที่ปรับปรุงแล้ว -->


                <div id="tableView" class="overflow-x-auto">
                    <table id="bookingTable" class="min-w-full bg-white border border-gray-200 rounded-lg text-sm">
                        <thead>                            <tr class="bg-blue-100 text-blue-700">
                                <th class="py-3 px-4 border-b text-center">#</th>
                                <th class="py-3 px-4 border-b text-left">ผู้จอง</th>
                                <th class="py-3 px-4 border-b text-left">รถยนต์</th>
                                <th class="py-3 px-4 border-b text-center">วันที่จอง</th>
                                <th class="py-3 px-4 border-b text-center">วันเวลาที่ใช้</th>
                                <th class="py-3 px-4 border-b text-left">จุดหมาย</th>
                                <th class="py-3 px-4 border-b text-left">วัตถุประสงค์</th>
                                <th class="py-3 px-4 border-b text-center">จำนวนผู้โดยสาร</th>
                                <th class="py-3 px-4 border-b text-center">สถานะ</th>
                                <th class="py-3 px-4 border-b text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- JS render -->
                        </tbody>
                    </table>
                </div>                <div id="calendarView" class="hidden">
                  <!-- Legend สำหรับสีรถ -->
                  <div id="carLegend" class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a2 2 0 012-2z"></path>
                      </svg>
                      คำอธิบายสีรถ
                    </h4>
                    <div class="flex flex-wrap gap-2" id="legendItems">
                      <!-- จะถูกสร้างด้วย JS -->
                    </div>
                  </div>
                  <div id="carBookingCalendar" class="rounded-lg overflow-hidden shadow-lg border border-gray-200"></div>
                </div>
            </div>
        </section>
    </div>
    <?php require_once('../footer.php');?>
</div>

<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px);}
  to { opacity: 1; transform: translateY(0);}
}
.animate-fade-in { animation: fade-in 1s ease-out; }

/* ปุ่มสลับมุมมอง */
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
  background: #f3f4f6;
  color: #374151;
}

/* การ์ดสถิติ Animation */
@keyframes pulse-glow {
  0%, 100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
  50% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
}
.stat-card {
  animation: pulse-glow 2s infinite;
}

/* ปรับปรุงตาราง */
#bookingTable {
  border-collapse: separate;
  border-spacing: 0;
}
#bookingTable thead th {
  background: linear-gradient(135deg, #dbeafe, #bfdbfe);
  position: sticky;
  top: 0;
  z-index: 10;
}
#bookingTable tbody tr {
  transition: all 0.2s ease;
}
#bookingTable tbody tr:hover {
  background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Loading animation */
@keyframes spin {
  to { transform: rotate(360deg); }
}
.loading-spinner {
  animation: spin 1s linear infinite;
}

/* FullCalendar customization */
.fc-toolbar-title {
  font-family: 'Sarabun', sans-serif !important;
  font-weight: 600 !important;
}
.fc-event {
  border-radius: 6px !important;
  border: none !important;
  padding: 2px 4px !important;
  font-size: 0.75rem !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
  transition: all 0.2s ease !important;
}
.fc-event:hover {
  transform: scale(1.05) !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}

/* สีสถานะ Badge */
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

/* ปุ่ม Action ที่สวยงาม */
.action-btn {
  transition: all 0.2s ease;
  position: relative;
  overflow: hidden;
}
.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
.action-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}
.action-btn:hover::before {
  left: 100%;
}

/* Filter accordion */
#advancedFilters {
  transition: all 0.3s ease;
  max-height: 0;
  overflow: hidden;
}
#advancedFilters.show {
  max-height: 200px;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}
::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #3b82f6, #1d4ed8);
  border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, #2563eb, #1e40af);
}

/* Floating action button */
.fab {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #3b82f6, #1d4ed8);
  color: white;
  border: none;
  box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 1000;
}
.fab:hover {
  transform: scale(1.1) rotate(360deg);
  box-shadow: 0 12px 35px rgba(59, 130, 246, 0.6);
}

/* Tooltip */
.tooltip {
  position: relative;
  display: inline-block;
}
.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #1f2937;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 8px;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
  font-size: 12px;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>

<!-- DataTables CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- FullCalendar CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
let isSubmitting = false;

// โหลดข้อมูลรถยนต์
function loadCars() {
    return fetch('api/car_list.php')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.cars) {
                const carSelect = document.getElementById('carSelect');
                const editCarSelect = document.getElementById('editCarSelect');
                
                // ล้างตัวเลือกเดิม
                if (carSelect) {
                    carSelect.innerHTML = '<option value="">-- เลือกรถยนต์ --</option>';
                    data.cars.forEach(car => {
                        if (car.status == 1) { // เฉพาะรถที่พร้อมใช้งาน
                            carSelect.innerHTML += `<option value="${car.id}" data-capacity="${car.capacity}">
                                ${car.car_model} (${car.license_plate}) - ความจุ ${car.capacity} คน
                            </option>`;
                        }
                    });
                }
                
                if (editCarSelect) {
                    editCarSelect.innerHTML = '<option value="">-- เลือกรถยนต์ --</option>';
                    data.cars.forEach(car => {
                        if (car.status == 1) {
                            editCarSelect.innerHTML += `<option value="${car.id}" data-capacity="${car.capacity}">
                                ${car.car_model} (${car.license_plate}) - ความจุ ${car.capacity} คน
                            </option>`;
                        }
                    });
                }
            }
        })
        .catch(err => {
            console.error('Error loading cars:', err);
        });
}

function formatThaiDateTime(dateString) {
  if (!dateString) return '-';

  const date = new Date(dateString);
  const thaiMonths = [
    "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
    "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
  ];

  const day = date.getDate();
  const month = thaiMonths[date.getMonth()];
  const year = date.getFullYear() + 543; // พ.ศ.

  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');

  return `${day} ${month} ${year} เวลา ${hours}:${minutes} น.`;
}

function fetchBookings() {
    // แสดง loading
    const $tbody = $('#bookingTable tbody');
    $tbody.html('<tr><td colspan="10" class="text-center py-8"><div class="loading-spinner inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full"></div><div class="mt-2 text-gray-500">กำลังโหลดข้อมูล...</div></td></tr>');
    
    $.get('api/car_booking_list.php', function(res) {
        let data = [];
        if (res && res.list) {
            data = res.list;
        }
        
        // อัปเดตสถิติ
        updateStats(data);
        
        $tbody.empty();
        
        if (data.length === 0) {
            $tbody.html('<tr><td colspan="10" class="text-center py-8 text-gray-500">ไม่พบข้อมูลการจอง</td></tr>');
            return;
        }
        
        data.forEach(function(item, idx) {
            // สถานะ
            let statusText = '';
            let statusClass = '';
            switch(item.status) {
                case 'pending':
                    statusText = 'รอพิจารณา';
                    statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                    break;
                case 'approved':
                    statusText = 'อนุมัติ';
                    statusClass = 'bg-green-100 text-green-700 border-green-200';
                    break;
                case 'rejected':
                    statusText = 'ไม่อนุมัติ';
                    statusClass = 'bg-red-100 text-red-700 border-red-200';
                    break;
                case 'completed':
                    statusText = 'เสร็จสิ้น';
                    statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                    break;
                default:
                    statusText = 'รอพิจารณา';
                    statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
            }
            
            let statusBadge = `<span class="status-badge ${statusClass} px-3 py-1 rounded-full text-xs font-semibold border">${statusText}</span>`;
            
            // ปุ่มจัดการ
            let editBtn = `<button type="button" class="edit-booking-btn text-blue-600 hover:text-blue-800 mr-2" 
                data-id="${item.id}"
                data-car_id="${item.car_id}"
                data-booking_date="${item.booking_date}"
                data-start_time="${item.start_time}"
                data-end_time="${item.end_time}"
                data-destination="${encodeURIComponent(item.destination)}"
                data-purpose="${encodeURIComponent(item.purpose)}"
                data-passenger_count="${item.passenger_count}"
                data-notes="${encodeURIComponent(item.notes || '')}"
                title="แก้ไข">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </button>`;
            
            let statusBtn = `<button type="button" class="change-status-btn bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs hover:bg-orange-200 transition mr-2" 
                data-id="${item.id}" 
                data-status="${item.status}">เปลี่ยนสถานะ</button>`;
            
            let deleteBtn = `<button type="button" class="delete-booking-btn text-red-600 hover:text-red-800" 
                data-id="${item.id}" title="ลบ">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>`;
            
            $tbody.append(`
                <tr class="hover:bg-blue-50 transition-all duration-200">
                    <td class="py-4 px-4 border-b text-center font-semibold text-gray-600">${idx + 1}</td>
                    <td class="py-4 px-4 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                ${(item.teacher_name || '?').charAt(0)}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">${item.teacher_name || '-'}</div>
                                <div class="text-sm text-gray-500">${item.teacher_position || ''}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm" style="background-color: ${getCarColor(item.car_id)}">
                                🚗
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">${item.car_model || '-'}</div>
                                <div class="text-sm text-gray-500">${item.license_plate || '-'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 border-b text-center">
                        <div class="text-sm font-medium text-gray-900">${formatThaiDateTime(item.created_at)}</div>
                    </td>
                    <td class="py-4 px-4 border-b text-center">
                        <div class="text-sm">
                            <div class="font-medium text-green-600">${formatThaiDateTime(item.start_time)}</div>
                            <div class="text-gray-400">ถึง</div>
                            <div class="font-medium text-red-600">${formatThaiDateTime(item.end_time)}</div>
                        </div>
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div class="max-w-xs truncate" title="${item.destination}">${item.destination}</div>
                    </td>
                    <td class="py-4 px-4 border-b">
                        <div class="max-w-xs truncate" title="${item.purpose}">${item.purpose}</div>
                    </td>
                    <td class="py-4 px-4 border-b text-center">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">${item.passenger_count} คน</span>
                    </td>
                    <td class="py-4 px-4 border-b text-center">${statusBadge}</td>
                    <td class="py-4 px-4 border-b text-center">
                        <div class="flex justify-center gap-1">${editBtn}${statusBtn}${deleteBtn}</div>
                    </td>
                </tr>
            `);
        });
        
        // Initialize DataTable with enhanced options
        if (!$.fn.DataTable.isDataTable('#bookingTable')) {
            $('#bookingTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
                },
                order: [[3, 'desc']], // เรียงตามวันที่สร้าง
                pageLength: 25,
                responsive: true,
                dom: '<"flex justify-between items-center mb-4"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rt<"flex justify-between items-center mt-4"ip>',
                columnDefs: [
                    { orderable: false, targets: [9] }, // ปิดการเรียงปุ่มจัดการ
                    { className: "text-center", targets: [0, 3, 4, 7, 8, 9] }
                ]
            });
        } else {
            $('#bookingTable').DataTable().destroy();
            $('#bookingTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json'
                },
                order: [[3, 'desc']],
                pageLength: 25,
                responsive: true,
                dom: '<"flex justify-between items-center mb-4"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rt<"flex justify-between items-center mt-4"ip>',
                columnDefs: [
                    { orderable: false, targets: [9] },
                    { className: "text-center", targets: [0, 3, 4, 7, 8, 9] }
                ]
            });
        }
        
    }, 'json').fail(function() {
        $tbody.html('<tr><td colspan="10" class="text-center py-8 text-red-500">เกิดข้อผิดพลาดในการโหลดข้อมูล</td></tr>');
    });
}


// เปลี่ยนสถานะการจอง
$(document).on('click', '.change-status-btn', function() {
    const id = $(this).data('id');
    const currentStatus = $(this).data('status');
    
    Swal.fire({
        title: 'เปลี่ยนสถานะการจอง',
        input: 'select',
        inputOptions: {
            'pending': 'รอพิจารณา',
            'approved': 'อนุมัติ',
            'rejected': 'ไม่อนุมัติ',
            'completed': 'เสร็จสิ้น'
        },
        inputValue: currentStatus,
        showCancelButton: true,
        confirmButtonText: 'บันทึก',
        cancelButtonText: 'ยกเลิก'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('api/car_booking_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, status: result.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('สำเร็จ!', 'อัปเดตสถานะเรียบร้อย', 'success');
                    fetchBookings();
                    window.location.reload(); // รีเฟรชหน้าเพื่ออัปเดตสถานะ
                } else {
                    Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                }
            })
            .catch(() => {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        }
    });
});

// ลบการจอง
$(document).on('click', '.delete-booking-btn', function() {
    const id = $(this).data('id');
    
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบการจองนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('api/car_booking_delete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('ลบสำเร็จ!', 'การจองถูกลบเรียบร้อยแล้ว', 'success');
                    fetchBookings();
                    window.location.reload(); // รีเฟรชหน้าเพื่ออัปเดตข้อมูล
                } else {
                    Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
                }
            })
            .catch(() => {
                Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
            });
        }
    });
});



// Modal เพิ่มการจองใหม่
if (!document.getElementById('addBookingModal')) {
    $('body').append(`    <div id="addBookingModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-4xl max-h-[90vh] overflow-y-auto relative">
            <button id="closeAddBookingModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button><h3 class="text-xl font-bold text-blue-700 mb-6">🚗 จองรถยนต์ใหม่</h3>
            <form id="addBookingForm" class="space-y-6">
                
                <!-- ข้อมูลผู้จอง -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-blue-700 mb-4">👤 ข้อมูลผู้จอง</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" >
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ชื่อ-นามสกุล <span class="text-red-500">*</span></label>
                            <input type="text" name="teacher_name" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล" value="<?=$TeacherData['Teach_name']?>" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ตำแหน่ง <span class="text-red-500">*</span></label>
                            <input type="text" name="teacher_position" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ตำแหน่ง" value="<?= ($TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (บกศ.)" || $TeacherData['Teach_Position2'] == "ลูกจ้างชั่วคราว (สพฐ.)") ? "ครูอัตราจ้าง" : $TeacherData['Teach_Position2']; ?>
                            " readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">เบอร์โทร <span class="text-red-500">*</span></label>
                            <input type="tel" name="teacher_phone" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="เบอร์โทรศัพท์" value="<?= $TeacherData['Teach_phone'] ?? '' ?>">
                        </div>
                    </div>
                </div>

                <!-- ข้อมูลการจอง -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-green-700 mb-4">📋 ข้อมูลการจอง</h4>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">เลือกรถยนต์ <span class="text-red-500">*</span></label>
                        <select name="car_id" id="carSelect" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                            <option value="">-- เลือกรถยนต์ --</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">วันเวลาเริ่มต้น <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_datetime" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">วันเวลาสิ้นสุด <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_datetime" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ขออนุญาตใช้รถ (ไปไหน) <span class="text-red-500">*</span></label>
                            <input type="text" name="destination" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="สถานที่ที่ต้องการไป">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">จุดประสงค์ (เพื่อ) <span class="text-red-500">*</span></label>
                            <input type="text" name="purpose" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="วัตถุประสงค์">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">รายชื่อผู้โดยสาร (ครู/เจ้าหน้าที่)</label>
                        <div id="passengersList" class="space-y-2">
                            <div class="passenger-item flex gap-2">
                                <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล ครู/เจ้าหน้าที่" value="<?=$TeacherData['Teach_name']?>" readonly>
                                <span class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg">หัวหน้าคณะ</span>
                            </div>
                        </div>
                        <button type="button" id="addPassengerBtn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                            <span>+</span> เพิ่มผู้โดยสาร
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">จำนวนนักเรียน (คน)</label>
                            <input type="number" name="student_count" min="0" value="0" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" onchange="calculateTotal()">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">รวมผู้โดยสาร (คน) <span class="text-red-500">*</span></label>
                            <input type="number" name="total_passengers" readonly class="w-full p-3 border-2 border-gray-300 rounded-lg bg-gray-100 font-bold text-blue-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ความจุรถ (คน)</label>
                            <input type="number" id="carCapacity" readonly class="w-full p-3 border-2 border-gray-300 rounded-lg bg-gray-100 font-bold text-green-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">หมายเหตุ</label>
                        <textarea name="notes" rows="2" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="หมายเหตุเพิ่มเติม (ไม่บังคับ)"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" id="cancelAddBooking" class="bg-gray-300 text-gray-700 py-3 px-8 rounded-lg font-bold hover:bg-gray-400 transition">ยกเลิก</button>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-3 px-8 rounded-lg font-bold hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>บันทึกการจอง</span> <span>🚀</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    `);
}

// Modal แก้ไขการจอง
if (!document.getElementById('editBookingModal')) {
    $('body').append(`
    <div id="editBookingModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
            <button id="closeEditBookingModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-2xl">&times;</button>            <h3 class="text-xl font-bold text-blue-700 mb-6">✏️ แก้ไขการจอง</h3>
            <form id="editBookingForm" class="space-y-6">
                <input type="hidden" name="id" id="editBookingId">
                
                <!-- ข้อมูลผู้จอง -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-blue-700 mb-4">👤 ข้อมูลผู้จอง</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ชื่อ-นามสกุล <span class="text-red-500">*</span></label>
                            <input type="text" name="teacher_name" id="editTeacherName" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ตำแหน่ง <span class="text-red-500">*</span></label>
                            <input type="text" name="teacher_position" id="editTeacherPosition" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">เบอร์โทร <span class="text-red-500">*</span></label>
                            <input type="tel" name="teacher_phone" id="editTeacherPhone" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>

                <!-- ข้อมูลการจอง -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-green-700 mb-4">📋 ข้อมูลการจอง</h4>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">เลือกรถยนต์ <span class="text-red-500">*</span></label>
                        <select name="car_id" id="editCarSelect" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                            <option value="">-- เลือกรถยนต์ --</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">วันเวลาเริ่มต้น <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="start_datetime" id="editStartDateTime" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">วันเวลาสิ้นสุด <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="end_datetime" id="editEndDateTime" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ขออนุญาตใช้รถ (ไปไหน) <span class="text-red-500">*</span></label>
                            <input type="text" name="destination" id="editDestination" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">จุดประสงค์ (เพื่อ) <span class="text-red-500">*</span></label>
                            <input type="text" name="purpose" id="editPurpose" required class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">รายชื่อผู้โดยสาร (ครู/เจ้าหน้าที่)</label>
                        <div id="editPassengersList" class="space-y-2">
                            <!-- Dynamic content -->
                        </div>
                        <button type="button" id="editAddPassengerBtn" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                            <span>+</span> เพิ่มผู้โดยสาร
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">จำนวนนักเรียน (คน)</label>
                            <input type="number" name="student_count" id="editStudentCount" min="0" value="0" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" onchange="calculateTotalEdit()">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">รวมผู้โดยสาร (คน) <span class="text-red-500">*</span></label>
                            <input type="number" name="total_passengers" id="editTotalPassengers" readonly class="w-full p-3 border-2 border-gray-300 rounded-lg bg-gray-100 font-bold text-blue-600">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">ความจุรถ (คน)</label>
                            <input type="number" id="editCarCapacity" readonly class="w-full p-3 border-2 border-gray-300 rounded-lg bg-gray-100 font-bold text-green-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">หมายเหตุ</label>
                        <textarea name="notes" id="editNotes" rows="2" class="w-full p-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" id="cancelEditBooking" class="bg-gray-300 text-gray-700 py-3 px-8 rounded-lg font-bold hover:bg-gray-400 transition">ยกเลิก</button>
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-green-500 text-white py-3 px-8 rounded-lg font-bold hover:from-blue-700 hover:to-green-600 transition-all flex items-center gap-2 shadow-lg transform hover:scale-105">
                        <span>บันทึกการแก้ไข</span> <span>💾</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    `);
}

// เปิด modal เพิ่มการจองใหม่
$(document).on('click', '#addBookingBtn', function() {
    // โหลดข้อมูลรถยนต์ก่อน
    loadCars().then(() => {
        // ตั้งค่าเริ่มต้น
        const now = new Date();
        const tomorrow = new Date(now);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const startDateTime = tomorrow.toISOString().slice(0, 16);
        const endDateTime = new Date(tomorrow.getTime() + 2 * 60 * 60 * 1000).toISOString().slice(0, 16);
        
        document.querySelector('input[name="start_datetime"]').value = startDateTime;
        document.querySelector('input[name="end_datetime"]').value = endDateTime;
        document.querySelector('input[name="student_count"]').value = 0;
        
        // รีเซ็ตรายชื่อผู้โดยสาร
        resetPassengersList();
        calculateTotal();
        
        $('#addBookingModal').removeClass('hidden');
    });
});

// เปิด modal แก้ไขการจอง
$(document).on('click', '.edit-booking-btn', function() {
    const data = $(this).data();
    
    // โหลดข้อมูลรถยนต์ก่อน
    loadCars().then(() => {
        $('#editBookingId').val(data.id);
        $('#editCarSelect').val(data.car_id);

        // --- แก้ไขจุดนี้: แปลง start_time, end_time เป็น datetime-local ---
        function toDatetimeLocal(dt) {
            if (!dt) return '';
            // dt: "2025-06-15 10:16:00" => "2025-06-15T10:16"
            return dt.replace(' ', 'T').slice(0, 16);
        }
        $('#editStartDateTime').val(toDatetimeLocal(data.start_time));
        $('#editEndDateTime').val(toDatetimeLocal(data.end_time));
        // -------------------------------------------------------------

        $('#editDestination').val(decodeURIComponent(data.destination));
        $('#editPurpose').val(decodeURIComponent(data.purpose));
        $('#editNotes').val(decodeURIComponent(data.notes));
        
        // โหลดข้อมูลการจองเฉพาะเพื่อดึงข้อมูลเพิ่มเติม
        fetch(`api/car_booking_get.php?id=${data.id}`)
            .then(res => res.json())
            .then(bookingData => {
                if (bookingData.success && bookingData.booking) {
                    const booking = bookingData.booking;
                    
                    // ตั้งค่าข้อมูลครู
                    $('#editTeacherName').val(booking.teacher_name || '');
                    $('#editTeacherPosition').val(booking.teacher_position || '');
                    $('#editTeacherPhone').val(booking.teacher_phone || '');
                    
                    // ตั้งค่ารายชื่อผู้โดยสาร
                    loadEditPassengersList(booking.passengers_detail || '');
                    
                    // ตั้งค่าจำนวนนักเรียน
                    $('#editStudentCount').val(booking.student_count || 0);
                    
                    // อัปเดตความจุรถและคำนวณรวม
                    const selectedOption = $('#editCarSelect option:selected');
                    const capacity = selectedOption.data('capacity') || 0;
                    $('#editCarCapacity').val(capacity);
                    calculateTotalEdit();
                }
            })
            .catch(err => {
                console.error('Error loading booking details:', err);
            });
        
        $('#editBookingModal').removeClass('hidden');
    });
});

// ปิด modals
$(document).on('click', '#closeAddBookingModal, #cancelAddBooking', function() {
    $('#addBookingModal').addClass('hidden');
    document.getElementById('addBookingForm').reset();
});

$(document).on('click', '#closeEditBookingModal, #cancelEditBooking', function() {
    $('#editBookingModal').addClass('hidden');
});

// บันทึกการจองใหม่
$(document).on('submit', '#addBookingForm', function(e) {
    e.preventDefault();
    
    if (isSubmitting) return false;
    isSubmitting = true;
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>กำลังบันทึก...</span> <span>⏳</span>';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    // แปลงวันเวลาให้เป็นรูปแบบที่เหมาะสม
    const startDateTime = formData.get('start_datetime');
    const endDateTime = formData.get('end_datetime');
    
    if (startDateTime) {
        const [date, time] = startDateTime.split('T');
        formData.append('booking_date', date);
        formData.append('start_time', time);
    }
    
    if (endDateTime) {
        const [, endTime] = endDateTime.split('T');
        formData.append('end_time', endTime);
    }
    
    // รวบรวมรายชื่อผู้โดยสาร
    const passengers = [];
    document.querySelectorAll('#passengersList input[name="passengers[]"]').forEach(input => {
        if (input.value.trim()) {
            passengers.push(input.value.trim());
        }
    });
    formData.append('passengers_detail', JSON.stringify(passengers));
    
    // คำนวณจำนวนผู้โดยสารรวม
    const passengerCount = passengers.length;
    const studentCount = parseInt(formData.get('student_count')) || 0;
    formData.append('passenger_count', passengerCount + studentCount);
    
    // เพิ่ม teacher_id จาก session
    formData.append('teacher_id', "<?php echo $teacher_id; ?>");
    
    fetch('api/car_booking_add.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('สำเร็จ!', 'บันทึกการจองเรียบร้อยแล้ว', 'success');
            $('#addBookingModal').addClass('hidden');
            this.reset();
            fetchBookings();
            window.location.reload(); // รีเฟรชหน้าเพื่ออัปเดตข้อมูล
        } else {
            Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
        }
    })
    .catch(() => {
        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
    })
    .finally(() => {
        isSubmitting = false;
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// บันทึกการแก้ไข
$(document).on('submit', '#editBookingForm', function(e) {
    e.preventDefault();
    
    if (isSubmitting) return false;
    isSubmitting = true;
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span>กำลังบันทึก...</span> <span>⏳</span>';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    // เพิ่มข้อมูลเพิ่มเติม
    const startDateTime = formData.get('start_datetime');
    const endDateTime = formData.get('end_datetime');
    
    if (startDateTime) {
        const [date, time] = startDateTime.split('T');
        formData.append('booking_date', date);
        formData.append('start_time', time);
    }
    
    if (endDateTime) {
        const [, endTime] = endDateTime.split('T');
        formData.append('end_time', endTime);
    }
    
    // รวบรวมรายชื่อผู้โดยสาร
    const passengers = [];
    document.querySelectorAll('#editPassengersList input[name="passengers[]"]').forEach(input => {
        if (input.value.trim()) {
            passengers.push(input.value.trim());
        }
    });
    formData.append('passengers_detail', JSON.stringify(passengers));
    
    // คำนวณจำนวนผู้โดยสารรวม
    const passengerCount = passengers.length;
    const studentCount = parseInt(formData.get('student_count')) || 0;
    formData.append('passenger_count', passengerCount + studentCount);
    
    fetch('api/car_booking_edit.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('สำเร็จ!', 'บันทึกการแก้ไขเรียบร้อยแล้ว', 'success');
            $('#editBookingModal').addClass('hidden');
            fetchBookings();
            window.location.reload(); // รีเฟรชหน้าเพื่ออัปเดตข้อมูล
        } else {
            Swal.fire('ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด', 'error');
        }
    })
    .catch(() => {
        Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์', 'error');
    })
    .finally(() => {
        isSubmitting = false;
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// สลับมุมมอง ตาราง/ปฏิทิน
$(document).on('click', '#showTableBtn', function() {
  $('#tableView').show();
  $('#calendarView').hide();
  $('.view-toggle-btn').removeClass('active');
  $(this).addClass('active');
});

$(document).on('click', '#showCalendarBtn', function() {
  $('#tableView').hide();
  $('#calendarView').show();
  $('.view-toggle-btn').removeClass('active');
  $(this).addClass('active');
  // รีเฟรชปฏิทินใหม่ทุกครั้ง
  $('#carBookingCalendar').remove();
  $('#calendarView').append('<div id="carBookingCalendar" class="rounded-lg overflow-hidden shadow-lg border border-gray-200"></div>');
  initCalendar();
});




// ฟังก์ชันคำนวณสถิติ
function updateStats(data) {
  const pending = data.filter(item => item.status === 'pending').length;
  const approved = data.filter(item => item.status === 'approved').length;
  const total = data.length;
  
  $('#pendingCount').text(pending);
  $('#approvedCount').text(approved);
  $('#totalCount').text(total);
  
  // เพิ่ม animation
  $('.stat-card').addClass('animate-pulse');
  setTimeout(() => $('.stat-card').removeClass('animate-pulse'), 1000);
}

// อัปเดต car filter และ legend
function updateCarFilter(cars) {
  const $filterCar = $('#filterCar');
  $filterCar.html('<option value="">ทุกคัน</option>');
  
  if (cars && cars.length > 0) {
    cars.forEach(car => {
      $filterCar.append(`<option value="${car.id}">${car.car_model} (${car.license_plate})</option>`);
    });
  }
}

function updateCarLegend(bookings) {
  const $legend = $('#legendItems');
  $legend.empty();
  
  // สร้าง unique car list
  const uniqueCars = [];
  const seenCars = new Set();
  
  bookings.forEach(booking => {
    if (!seenCars.has(booking.car_id)) {
      seenCars.add(booking.car_id);
      uniqueCars.push({
        id: booking.car_id,
        model: booking.car_model,
        license: booking.license_plate
      });
    }
  });
  
  uniqueCars.forEach(car => {
    const color = getCarColor(car.id);
    $legend.append(`
      <div class="flex items-center gap-2 px-3 py-1 bg-white rounded-full border border-gray-200 shadow-sm">
        <div class="w-3 h-3 rounded-full" style="background-color: ${color}"></div>
        <span class="text-xs font-medium text-gray-700">${car.model} (${car.license})</span>
      </div>
    `);
  });
}

// ฟังก์ชันสุ่ม/วนลูปสีสำหรับแต่ละ car_id
const carColorMap = {};
const carColors = [
  '#22c55e', // เขียว
  '#3b82f6', // น้ำเงิน
  '#f59e42', // ส้ม
  '#ef4444', // แดง
  '#a855f7', // ม่วง
  '#eab308', // เหลือง
  '#14b8a6', // teal
  '#6366f1', // indigo
  '#f43f5e', // pink
  '#0ea5e9'  // sky
];
function getCarColor(car_id) {
  if (!carColorMap[car_id]) {
    // กำหนดสีใหม่ถ้ายังไม่มี
    const idx = Object.keys(carColorMap).length % carColors.length;
    carColorMap[car_id] = carColors[idx];
  }
  return carColorMap[car_id];
}

function bookingsToEvents(bookings) {
  return bookings.map(item => ({
    id: item.id,
    title: (item.car_model || '-') + ' | ' + (item.teacher_name || '-') + '\n' + (item.destination || ''),
    start: item.start_time, // ใช้ datetime เต็ม
    end: item.end_time,     // ใช้ datetime เต็ม
    backgroundColor: getCarColor(item.car_id),
    borderColor: getCarColor(item.car_id),
    extendedProps: item
  }));
}

// ฟังก์ชันเริ่มต้น FullCalendar
function initCalendar() {
  fetch('api/car_booking_list.php')
    .then(res => res.json())
    .then(data => {
      const events = bookingsToEvents(data.list || []);
      const calendarEl = document.getElementById('carBookingCalendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'th',
        height: 650,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: events,
        eventClick: function(info) {
          const b = info.event.extendedProps;
          Swal.fire({
            title: 'รายละเอียดการจอง',
            html: `<b>รถ:</b> ${b.car_model || '-'}<br><b>ทะเบียน:</b> ${b.license_plate || '-'}<br><b>ผู้จอง:</b> ${b.teacher_name || '-'}<br><b>วันที่:</b> ${b.booking_date}<br><b>เวลา:</b> ${b.start_time} - ${b.end_time}<br><b>จุดหมาย:</b> ${b.destination}<br><b>วัตถุประสงค์:</b> ${b.purpose}<br><b>จำนวนผู้โดยสาร:</b> ${b.passenger_count} คน<br><b>สถานะ:</b> ${b.status}`,
            icon: 'info'
          });
        }
      });
      calendar.render();
    });
}

$(document).ready(function() {
    loadCars(); // โหลดข้อมูลรถยนต์
    fetchBookings();
    // เริ่มต้นแสดงตาราง
    $('#tableView').show();
    $('#calendarView').hide();
});

// ตรวจสอบความจุรถเมื่อเลือกรถหรือเปลี่ยนจำนวนผู้โดยสาร
$(document).on('change', '#carSelect, input[name="passenger_count"]', function() {
    const carId = $('#carSelect').val();
    const passengerCount = parseInt($('input[name="passenger_count"]').val()) || 0;
    
    if (carId && passengerCount > 0) {
        const selectedOption = $('#carSelect option:selected');
        const capacity = parseInt(selectedOption.data('capacity')) || 0;
        
        if (passengerCount > capacity) {
            Swal.fire({
                icon: 'warning',
                title: 'จำนวนผู้โดยสารเกินความจุ',
                text: `รถยนต์คันนี้มีความจุ ${capacity} คน กรุณาเลือกรถอื่นหรือลดจำนวนผู้โดยสาร`,
                confirmButtonText: 'รับทราบ'
            });
        }
    }
});

$(document).on('change', '#editCarSelect, #editPassengerCount', function() {
    const carId = $('#editCarSelect').val();
    const passengerCount = parseInt($('#editPassengerCount').val()) || 0;
    
    if (carId && passengerCount > 0) {
        const selectedOption = $('#editCarSelect option:selected');
        const capacity = parseInt(selectedOption.data('capacity')) || 0;
        
        if (passengerCount > capacity) {
            Swal.fire({
                icon: 'warning',
                title: 'จำนวนผู้โดยสารเกินความจุ',
                text: `รถยนต์คันนี้มีความจุ ${capacity} คน กรุณาเลือกรถอื่นหรือลดจำนวนผู้โดยสาร`,
                confirmButtonText: 'รับทราบ'
            });
        }
    }
});

// ฟังก์ชันคำนวณจำนวนผู้โดยสารรวม
function calculateTotal() {
    const passengerInputs = document.querySelectorAll('#passengersList input[name="passengers[]"]');
    const passengerCount = Array.from(passengerInputs).filter(input => input.value.trim() !== '').length;
    const studentCount = parseInt(document.querySelector('input[name="student_count"]').value) || 0;
    const totalPassengers = passengerCount + studentCount;
    
    document.querySelector('input[name="total_passengers"]').value = totalPassengers;
    
    // ตรวจสอบความจุรถ
    const capacity = parseInt(document.getElementById('carCapacity').value) || 0;
    if (capacity > 0 && totalPassengers > capacity) {
        Swal.fire({
            icon: 'warning',
            title: 'จำนวนผู้โดยสารเกินความจุ',
            text: `รถยนต์คันนี้มีความจุ ${capacity} คน กรุณาเลือกรถอื่นหรือลดจำนวนผู้โดยสาร (ปัจจุบัน: ${totalPassengers} คน)`,
            confirmButtonText: 'รับทราบ'
        });
    }
}

// ฟังก์ชันคำนวณสำหรับ modal แก้ไข
function calculateTotalEdit() {
    const passengerInputs = document.querySelectorAll('#editPassengersList input[name="passengers[]"]');
    const passengerCount = Array.from(passengerInputs).filter(input => input.value.trim() !== '').length;
    const studentCount = parseInt(document.querySelector('#editStudentCount').value) || 0;
    const totalPassengers = passengerCount + studentCount;
    
    document.querySelector('#editTotalPassengers').value = totalPassengers;
    
    // ตรวจสอบความจุรถ
    const capacity = parseInt(document.getElementById('editCarCapacity').value) || 0;
    if (capacity > 0 && totalPassengers > capacity) {
        Swal.fire({
            icon: 'warning',
            title: 'จำนวนผู้โดยสารเกินความจุ',
            text: `รถยนต์คันนี้มีความจุ ${capacity} คน กรุณาเลือกรถอื่นหรือลดจำนวนผู้โดยสาร (ปัจจุบัน: ${totalPassengers} คน)`,
            confirmButtonText: 'รับทราบ'
        });
    }
}

// เพิ่มผู้โดยสาร
$(document).on('click', '#addPassengerBtn', function() {
    addPassengerField('passengersList');
});

$(document).on('click', '#editAddPassengerBtn', function() {
    addPassengerField('editPassengersList');
});

// ลบผู้โดยสาร
$(document).on('click', '.remove-passenger-btn', function() {
    $(this).closest('.passenger-item').remove();
    calculateTotal();
    calculateTotalEdit();
});

// อัปเดตความจุรถเมื่อเลือกรถ
$(document).on('change', '#carSelect', function() {
    const selectedOption = $(this).find('option:selected');
    const capacity = selectedOption.data('capacity') || 0;
    $('#carCapacity').val(capacity);
    calculateTotal();
});

$(document).on('change', '#editCarSelect', function() {
    const selectedOption = $(this).find('option:selected');
    const capacity = selectedOption.data('capacity') || 0;
    $('#editCarCapacity').val(capacity);
    calculateTotalEdit();
});

// ฟังก์ชันเพิ่มช่องผู้โดยสาร
function addPassengerField(containerId) {
    const container = document.getElementById(containerId);
    const passengerItem = document.createElement('div');
    passengerItem.className = 'passenger-item flex gap-2';
    passengerItem.innerHTML = `
        <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล ครู/เจ้าหน้าที่" onchange="calculateTotal(); calculateTotalEdit();">
        <button type="button" class="remove-passenger-btn px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
            <span>×</span>
        </button>
    `;
    container.appendChild(passengerItem);
    
    // คำนวณใหม่
    if (containerId === 'passengersList') {
        calculateTotal();
    } else {
        calculateTotalEdit();
    }
}

// รีเซ็ตรายชื่อผู้โดยสาร
function resetPassengersList() {
    const container = document.getElementById('passengersList');
    container.innerHTML = `
        <div class="passenger-item flex gap-2">
            <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล ครู/เจ้าหน้าที่" value="<?=$TeacherData['Teach_name']?>" readonly>
            <span class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg">หัวหน้าคณะ</span>
        </div>
    `;
}

// ฟังก์ชันโหลดรายชื่อผู้โดยสารในการแก้ไข
function loadEditPassengersList(passengersJson) {
    const container = document.getElementById('editPassengersList');
    container.innerHTML = '';
    
    try {
        const passengers = passengersJson ? JSON.parse(passengersJson) : [];
        
        if (passengers.length === 0) {
            // ถ้าไม่มีข้อมูล ให้ใส่แค่หัวหน้าคณะ (ใช้ชื่อจาก booking หรือว่าง)
            container.innerHTML = `
                <div class="passenger-item flex gap-2">
                    <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล ครู/เจ้าหน้าที่" value="" readonly>
                    <span class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg">หัวหน้าคณะ</span>
                </div>
            `;
        } else {
            passengers.forEach((passenger, index) => {
                const passengerItem = document.createElement('div');
                passengerItem.className = 'passenger-item flex gap-2';
                
                if (index === 0) {
                    // รายการแรกเป็นหัวหน้าคณะ
                    passengerItem.innerHTML = `
                        <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" value="${passenger}" readonly>
                        <span class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg">หัวหน้าคณะ</span>
                    `;
                } else {
                    // รายการอื่นๆ สามารถลบได้
                    passengerItem.innerHTML = `
                        <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" value="${passenger}" onchange="calculateTotalEdit();">
                        <button type="button" class="remove-passenger-btn px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            <span>×</span>
                        </button>
                    `;
                }
                
                container.appendChild(passengerItem);
            });
        }
    } catch (e) {
        console.error('Error parsing passengers data:', e);
        // ถ้าเกิดข้อผิดพลาด ให้ใส่แค่หัวหน้าคณะ (ว่าง)
        container.innerHTML = `
            <div class="passenger-item flex gap-2">
                <input type="text" name="passengers[]" class="flex-1 p-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="ชื่อ-นามสกุล ครู/เจ้าหน้าที่" value="" readonly>
                <span class="px-3 py-2 bg-gray-100 text-gray-500 rounded-lg">หัวหน้าคณะ</span>
            </div>
        `;
    }
}
</script>
<?php require_once('script.php'); ?>
</body>
</html>
