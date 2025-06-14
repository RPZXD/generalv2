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
                            <span class="text-blue-600 text-2xl">| ตั้งค่าระบบ ⚙️</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container mx-auto max-w-7xl">
                <!-- Header Card -->
                <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold mb-2 flex items-center gap-3">
                                    <span class="bg-white bg-opacity-20 p-3 rounded-full">⚙️</span>
                                    ตั้งค่าระบบ
                                </h1>
                                <p class="text-blue-100 text-lg">จัดการห้องประชุมและรถยนต์ในระบบ</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4">
                                    <div class="text-sm text-blue-100 mb-1">สถานะระบบ</div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        <span class="font-semibold">ออนไลน์</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-white bg-opacity-10 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-purple-300 bg-opacity-20 rounded-full blur-xl"></div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-emerald-100 text-sm">ห้องประชุมทั้งหมด</p>
                                <p class="text-2xl font-bold" id="totalRooms">-</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-2xl">🏢</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">ห้องพร้อมใช้งาน</p>
                                <p class="text-2xl font-bold" id="activeRooms">-</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-2xl">✅</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm">รถยนต์ทั้งหมด</p>
                                <p class="text-2xl font-bold" id="totalCars">-</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-2xl">🚗</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">รถพร้อมใช้งาน</p>
                                <p class="text-2xl font-bold" id="activeCars">-</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-2xl">🚙</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- จัดการห้องประชุม -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 rounded-xl shadow-lg">
                                <span class="text-2xl text-white">🏢</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">จัดการห้องประชุม</h2>
                                <p class="text-gray-600">จัดการห้องประชุมที่สามารถจองได้ในระบบ</p>
                            </div>
                        </div>
                        <button id="addRoomBtn" class="bg-gradient-to-r from-emerald-500 to-blue-500 hover:from-emerald-600 hover:to-blue-600 text-white py-3 px-6 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center gap-2 group">
                            <span class="group-hover:rotate-90 transition-transform duration-300">➕</span>
                            <span>เพิ่มห้องประชุม</span>
                        </button>
                    </div>
                    
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table id="roomsTable" class="min-w-full bg-white">
                            <thead class="bg-gradient-to-r from-blue-50 to-indigo-50">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">#</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ชื่อห้องประชุม</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">ความจุ</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">อุปกรณ์</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">สถานะ</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody id="roomsTableBody" class="bg-white divide-y divide-gray-100">
                                <!-- JS render -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- จัดการรถยนต์ -->
                <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-4 rounded-xl shadow-lg">
                                <span class="text-2xl text-white">🚗</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">จัดการรถยนต์</h2>
                                <p class="text-gray-600">จัดการรถยนต์ที่สามารถจองได้ในระบบ</p>
                            </div>
                        </div>
                        <button id="addCarBtn" class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-3 px-6 rounded-xl font-bold shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center gap-2 group">
                            <span class="group-hover:rotate-90 transition-transform duration-300">➕</span>
                            <span>เพิ่มรถยนต์</span>
                        </button>
                    </div>
                    
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table id="carsTable" class="min-w-full bg-white">
                            <thead class="bg-gradient-to-r from-orange-50 to-red-50">
                                <tr>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">#</th>
                                    <th class="py-4 px-6 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ยี่ห้อ/รุ่น</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">ทะเบียน</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">ประเภท</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">ความจุ</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">สถานะ</th>
                                    <th class="py-4 px-6 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody id="carsTableBody" class="bg-white divide-y divide-gray-100">
                                <!-- JS render -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php require_once('../footer.php');?>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes pulse-slow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}

.animate-slideInUp {
    animation: slideInUp 0.5s ease-out;
}

.glass-effect {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.loading-spinner {
    width: 20px;
    height: 20px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.table-row-hover {
    transition: all 0.2s ease;
}

.table-row-hover:hover {
    background: linear-gradient(90deg, rgba(59, 130, 246, 0.05) 0%, rgba(147, 51, 234, 0.05) 100%);
    transform: scale(1.01);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ค่าคงที่และ configuration
const API_ENDPOINTS = {
    room: {
        get: 'api/get_rooms.php',
        save: 'api/save_room.php',
        delete: 'api/delete_room.php'
    },
    car: {
        get: 'api/get_cars.php',
        save: 'api/save_car.php',
        delete: 'api/delete_car.php'
    }
};

const MODAL_CONFIG = {
    room: {
        modal: 'roomModal',
        title: 'roomModalTitle',
        form: 'roomForm',
        fields: ['roomId', 'roomName', 'roomCapacity', 'roomEquipment', 'roomStatus']
    },
    car: {
        modal: 'carModal',
        title: 'carModalTitle', 
        form: 'carForm',
        fields: ['carId', 'carModel', 'carPlate', 'carType', 'carCapacity', 'carStatus']
    }
};

// Global modal functions
window.showModal = modalId => {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const content = modal.querySelector('.modal-content');
    modal.classList.remove('hidden');
    setTimeout(() => {
        if (content) Object.assign(content.style, { transform: 'scale(1)', opacity: '1' });
    }, 10);
};

window.hideModal = modalId => {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const content = modal.querySelector('.modal-content');
    if (content) Object.assign(content.style, { transform: 'scale(0.95)', opacity: '0' });
    setTimeout(() => modal.classList.add('hidden'), 300);
};

// Toast notification utility using Tailwind CSS
function showToast(type, title, message) {
    // Remove existing toast if present
    let oldToast = document.getElementById('tailwind-toast');
    if (oldToast) oldToast.remove();

    const isSuccess = type === 'success';
    const isError = type === 'error';
    const isWarning = type === 'warning';
    const isInfo = type === 'info';

    let bg = 'bg-green-500', icon = '✅';
    if (isError) { bg = 'bg-red-500'; icon = '❌'; }
    else if (isWarning) { bg = 'bg-yellow-500'; icon = '⚠️'; }
    else if (isInfo) { bg = 'bg-blue-500'; icon = 'ℹ️'; }

    const toast = document.createElement('div');
    toast.id = 'tailwind-toast';
    toast.className = `fixed top-6 right-6 z-[9999] flex items-center gap-4 px-6 py-4 rounded-xl shadow-2xl text-white ${bg} animate-slideInUp`;
    toast.style.minWidth = '280px';
    toast.innerHTML = `
        <span class="text-2xl">${icon}</span>
        <div>
            <div class="font-bold text-lg">${title}</div>
            <div class="text-sm">${message || ''}</div>
        </div>
        <button class="ml-4 text-white text-xl font-bold focus:outline-none hover:opacity-70" onclick="this.parentElement.remove()">×</button>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 400);
    }, isSuccess ? 2500 : 4000);
}

// Replace showAlert with showToast
const showAlert = (type, title, message) => {
    showToast(type, title, message);
};

const createStatusBadge = (status, activeText, inactiveText) => {
    const isActive = status == 1;
    const styles = isActive 
        ? 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 border-emerald-200' 
        : 'bg-gradient-to-r from-red-100 to-pink-100 text-red-700 border-red-200';
    const icon = isActive ? '✅' : '❌';
    const text = isActive ? activeText : inactiveText;
    
    return `<span class="${styles} px-3 py-1 rounded-full text-xs font-semibold border inline-flex items-center gap-1">
        <span>${icon}</span>
        <span>${text}</span>
    </span>`;
};

const showLoading = (show = true) => {
    const loadingElements = document.querySelectorAll('.loading-indicator');
    loadingElements.forEach(el => {
        el.style.display = show ? 'flex' : 'none';
    });
};

const fetchData = async (url) => {
    try {
        console.log('Fetching data from:', url);
        showLoading(true);
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const text = await response.text();
        console.log('Response text:', text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            throw new Error('Invalid JSON response');
        }
        
        showLoading(false);
        console.log('Parsed data:', data);
        return data;
    } catch (error) {
        showLoading(false);
        console.error('Fetch error:', error);
        showAlert('error', 'ข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์: ' + error.message);
        return { success: false, message: error.message };
    }
};

const postData = async (url, data) => {
    try {
        console.log('Posting data to:', url, data);
        
        const options = {
            method: 'POST'
        };
        
        if (data instanceof FormData) {
            options.body = data;
        } else {
            options.headers = { 'Content-Type': 'application/json' };
            options.body = JSON.stringify(data);
        }
        
        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const text = await response.text();
        console.log('Response text:', text);
        
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            throw new Error('Invalid JSON response');
        }
        
        console.log('Parsed result:', result);
        return result;
    } catch (error) {
        console.error('Post error:', error);
        showAlert('error', 'ข้อผิดพลาด!', 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์: ' + error.message);
        return { success: false, message: error.message };
    }
};

// Modal management functions
window.openModal = (type, mode = 'add', data = null) => {
    console.log('Opening modal:', type, mode, data);
    
    const config = MODAL_CONFIG[type];
    if (!config) {
        console.error('Invalid modal type:', type);
        return;
    }
    
    const titleElement = document.getElementById(config.title);
    const formElement = document.getElementById(config.form);
    
    if (!titleElement || !formElement) {
        console.error('Modal elements not found');
        return;
    }
    
    const isEdit = mode === 'edit';
    const itemName = type === 'room' ? 'ห้องประชุม' : 'รถยนต์';
    
    titleElement.textContent = `${isEdit ? 'แก้ไข' : 'เพิ่ม'}${itemName}`;
    formElement.reset();
    
    if (isEdit && data) {
        const fieldMappings = {
            room: {
                roomId: 'id',
                roomName: 'room_name', 
                roomCapacity: 'capacity',
                roomEquipment: 'equipment',
                roomStatus: 'status'
            },
            car: {
                carId: 'id',
                carModel: 'car_model',
                carPlate: 'license_plate',
                carType: 'car_type',
                carCapacity: 'capacity',
                carStatus: 'status'
            }
        };
        
        Object.entries(fieldMappings[type]).forEach(([fieldId, dataKey]) => {
            const element = document.getElementById(fieldId);
            if (element && data[dataKey] !== undefined) {
                element.value = data[dataKey] || '';
                console.log('Set field:', fieldId, 'to:', data[dataKey]);
            }
        });
    }
    
    showModal(config.modal);
};

window.closeModal = (type) => {
    const config = MODAL_CONFIG[type];
    if (config) {
        hideModal(config.modal);
    }
};

// Delete confirmation with proper JSON encoding
window.confirmDelete = async (type, id) => {
    console.log('Confirming delete:', type, id);
    
    const itemName = type === 'room' ? 'ห้องประชุม' : 'รถยนต์';
    const endpoint = API_ENDPOINTS[type].delete;
    const loadFunction = type === 'room' ? loadRooms : loadCars;
    
    const result = await Swal.fire({
        title: 'ยืนยันการลบ?',
        text: `คุณต้องการลบ${itemName}นี้หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    });
    
    if (result.isConfirmed) {
        const data = await postData(endpoint, { id: id });
        if (data.success) {
            showAlert('success', 'ลบสำเร็จ!', `${itemName}ถูกลบเรียบร้อยแล้ว`);
            loadFunction();
        } else {
            showAlert('error', 'ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด');
        }
    }
};

// Form submission handler
const handleFormSubmit = async (type, formData) => {
    console.log('Handling form submit:', type, formData);
    for (let [key, value] of formData.entries()) {
        console.log('Form data:', key, '=', value);
    }
    const endpoint = API_ENDPOINTS[type].save;
    const itemName = type === 'room' ? 'ห้องประชุม' : 'รถยนต์';
    const loadFunction = type === 'room' ? loadRooms : loadCars;
    console.log('Using endpoint:', endpoint);

    const data = await postData(endpoint, formData);
    closeModal(type);
    
    if (data.success) {
        showAlert('success', 'สำเร็จ!', `บันทึกข้อมูล${itemName}เรียบร้อยแล้ว`);
        setTimeout(() => loadFunction(), 500);
    } else {
        showAlert('error', 'ผิดพลาด!', data.message || 'เกิดข้อผิดพลาด');
    }
};

// Enhanced data loading functions
const loadRooms = async () => {
    console.log('Loading rooms...');
    const data = await fetchData(API_ENDPOINTS.room.get);
    const tbody = document.getElementById('roomsTableBody');
    
    if (!tbody) {
        console.error('Room table body not found');
        return;
    }
    
    tbody.innerHTML = '';
    
    if (data.success && data.rooms && Array.isArray(data.rooms)) {
        console.log('Rooms loaded:', data.rooms.length);
        
        // Update statistics
        const totalRoomsEl = document.getElementById('totalRooms');
        const activeRoomsEl = document.getElementById('activeRooms');
        
        if (totalRoomsEl) totalRoomsEl.textContent = data.rooms.length;
        if (activeRoomsEl) activeRoomsEl.textContent = data.rooms.filter(r => r.status == 1).length;
        
        tbody.innerHTML = data.rooms.map((room, index) => {
            const statusText = createStatusBadge(room.status, 'เปิดใช้งาน', 'ปิดใช้งาน');
            // Properly escape JSON for HTML attributes
            const roomJsonStr = JSON.stringify(room).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            
            return `
                <tr class="table-row-hover">
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">${index + 1}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <span class="text-blue-600">🏢</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">${room.room_name || 'N/A'}</div>
                                <div class="text-xs text-gray-500">ห้องประชุม</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                            ${room.capacity || 0} คน
                        </span>
                    </td>
                    <td class="py-4 px-6 text-sm text-gray-600 max-w-xs">
                        <div class="truncate" title="${room.equipment || '-'}">${room.equipment || '-'}</div>
                    </td>
                    <td class="py-4 px-6 text-center">${statusText}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editRoom('${roomJsonStr}')" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transform hover:scale-105 transition-all duration-200 flex items-center gap-1">
                                <span>✏️</span>
                                <span>แก้ไข</span>
                            </button>
                            <button onclick="confirmDelete('room', '${room.id}')" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transform hover:scale-105 transition-all duration-200 flex items-center gap-1">
                                <span>🗑️</span>
                                <span>ลบ</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    } else {
        console.log('No rooms data or failed to load');
        tbody.innerHTML = '<tr><td colspan="6" class="py-8 text-center text-gray-500">ไม่พบข้อมูลห้องประชุม</td></tr>';
        
        // Reset statistics
        const totalRoomsEl = document.getElementById('totalRooms');
        const activeRoomsEl = document.getElementById('activeRooms');
        if (totalRoomsEl) totalRoomsEl.textContent = '0';
        if (activeRoomsEl) activeRoomsEl.textContent = '0';
    }
};

const loadCars = async () => {
    console.log('Loading cars...');
    const data = await fetchData(API_ENDPOINTS.car.get);
    const tbody = document.getElementById('carsTableBody');
    
    if (!tbody) {
        console.error('Car table body not found');
        return;
    }
    
    tbody.innerHTML = '';
    
    if (data.success && data.cars && Array.isArray(data.cars)) {
        console.log('Cars loaded:', data.cars.length);
        
        // Update statistics
        const totalCarsEl = document.getElementById('totalCars');
        const activeCarsEl = document.getElementById('activeCars');
        
        if (totalCarsEl) totalCarsEl.textContent = data.cars.length;
        if (activeCarsEl) activeCarsEl.textContent = data.cars.filter(c => c.status == 1).length;
        
        tbody.innerHTML = data.cars.map((car, index) => {
            const statusText = createStatusBadge(car.status, 'พร้อมใช้งาน', 'ไม่พร้อมใช้งาน');
            // Properly escape JSON for HTML attributes
            const carJsonStr = JSON.stringify(car).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            
            const typeColors = {
                'รถเก๋ง': 'bg-blue-100 text-blue-700',
                'รถตู้': 'bg-green-100 text-green-700',
                'รถกระบะ': 'bg-yellow-100 text-yellow-700',
                'รถบัส': 'bg-purple-100 text-purple-700'
            };
            
            return `
                <tr class="table-row-hover">
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">${index + 1}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center">
                            <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                <span class="text-orange-600">🚗</span>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900">${car.car_model || 'N/A'}</div>
                                <div class="text-xs text-gray-500">รถยนต์</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-mono">
                            ${car.license_plate || 'N/A'}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="${typeColors[car.car_type] || 'bg-gray-100 text-gray-700'} px-3 py-1 rounded-full text-sm font-medium">
                            ${car.car_type || 'N/A'}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <span class="bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-sm font-medium">
                            ${car.capacity || 0} คน
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">${statusText}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="editCar('${carJsonStr}')" class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transform hover:scale-105 transition-all duration-200 flex items-center gap-1">
                                <span>✏️</span>
                                <span>แก้ไข</span>
                            </button>
                            <button onclick="confirmDelete('car', '${car.id}')" class="bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transform hover:scale-105 transition-all duration-200 flex items-center gap-1">
                                <span>🗑️</span>
                                <span>ลบ</span>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    } else {
        console.log('No cars data or failed to load');
        tbody.innerHTML = '<tr><td colspan="7" class="py-8 text-center text-gray-500">ไม่พบข้อมูลรถยนต์</td></tr>';
        
        // Reset statistics
        const totalCarsEl = document.getElementById('totalCars');
        const activeCarsEl = document.getElementById('activeCars');
        if (totalCarsEl) totalCarsEl.textContent = '0';
        if (activeCarsEl) activeCarsEl.textContent = '0';
    }
};

// Separate edit functions for better JSON handling
window.editRoom = (roomJsonStr) => {
    try {
        const roomData = JSON.parse(roomJsonStr.replace(/&quot;/g, '"').replace(/&#39;/g, "'"));
        openModal('room', 'edit', roomData);
    } catch (e) {
        console.error('Error parsing room data:', e);
        showAlert('error', 'ข้อผิดพลาด!', 'ไม่สามารถโหลดข้อมูลห้องประชุมได้');
    }
};

window.editCar = (carJsonStr) => {
    try {
        const carData = JSON.parse(carJsonStr.replace(/&quot;/g, '"').replace(/&#39;/g, "'"));
        openModal('car', 'edit', carData);
    } catch (e) {
        console.error('Error parsing car data:', e);
        showAlert('error', 'ข้อผิดพลาด!', 'ไม่สามารถโหลดข้อมูลรถยนต์ได้');
    }
};

// Event listeners
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing...');
    
    // Load initial data
    loadRooms();
    loadCars();
    
    // Add button listeners
    const addRoomBtn = document.getElementById('addRoomBtn');
    const addCarBtn = document.getElementById('addCarBtn');
    
    if (addRoomBtn) {
        addRoomBtn.addEventListener('click', () => openModal('room'));
    }
    
    if (addCarBtn) {
        addCarBtn.addEventListener('click', () => openModal('car'));
    }
    
    // Close modal listeners
    ['closeRoomModal', 'cancelRoom'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('click', () => closeModal('room'));
        }
    });
    
    ['closeCarModal', 'cancelCar'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('click', () => closeModal('car'));
        }
    });
    
    // Form submission listeners with better debugging
    const roomForm = document.getElementById('roomForm');
    if (roomForm) {
        roomForm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Room form submitted');
            const formData = new FormData(e.target);
            console.log('Room form data created:', formData);
            handleFormSubmit('room', formData);
        });
    }
    
    const carForm = document.getElementById('carForm');
    if (carForm) {
        carForm.addEventListener('submit', (e) => {
            e.preventDefault();
            console.log('Car form submitted');
            const formData = new FormData(e.target);
            console.log('Car form data created:', formData);
            handleFormSubmit('car', formData);
        });
    }
    
    console.log('Initialization complete');
});
</script>

<!-- Enhanced Modal ห้องประชุม -->
<div id="roomModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <button id="closeRoomModal" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-50 transition-all duration-200">&times;</button>
        
        <div class="flex items-center gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl">
                <span class="text-white text-xl">🏢</span>
            </div>
            <div>
                <h3 id="roomModalTitle" class="text-2xl font-bold text-gray-800">เพิ่มห้องประชุม</h3>
                <p class="text-gray-600 text-sm">กรอกข้อมูลห้องประชุมในระบบ</p>
            </div>
        </div>
        
        <form id="roomForm" class="space-y-6">
            <input type="hidden" name="room_id" id="roomId">
            
            <div class="space-y-2">
                <label class="block text-gray-700 font-semibold text-sm">ชื่อห้องประชุม <span class="text-red-500">*</span></label>
                <input type="text" id="roomName" name="room_name" required 
                    class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" 
                    placeholder="เช่น ห้องประชุมใหญ่">
            </div>
            
            <div class="space-y-2">
                <label class="block text-gray-700 font-semibold text-sm">ความจุ (คน) <span class="text-red-500">*</span></label>
                <input type="number" id="roomCapacity" name="capacity" required min="1" max="500" 
                    class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" 
                    placeholder="50">
            </div>
            
            <div class="space-y-2">
                <label class="block text-gray-700 font-semibold text-sm">อุปกรณ์ในห้อง</label>
                <textarea id="roomEquipment" name="equipment" rows="4" 
                    class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white resize-none" 
                    placeholder="เช่น โปรเจคเตอร์, ไมโครโฟน, เครื่องเสียง"></textarea>
            </div>
            
            <div class="space-y-2">
                <label class="block text-gray-700 font-semibold text-sm">สถานะ</label>
                <select id="roomStatus" name="status" 
                    class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                    <option value="1">🟢 เปิดใช้งาน</option>
                    <option value="0">🔴 ปิดใช้งาน</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-4 pt-6 border-t">
                <button type="button" id="cancelRoom" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-8 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105">
                    ยกเลิก
                </button>
                <button type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 px-8 rounded-xl font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                    <span>💾</span>
                    <span>บันทึก</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Modal รถยนต์ -->
<div id="carModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <button id="closeCarModal" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-red-50 transition-all duration-200">&times;</button>
        
        <div class="flex items-center gap-4 mb-6">
            <div class="bg-gradient-to-r from-orange-500 to-red-500 p-3 rounded-xl">
                <span class="text-white text-xl">🚗</span>
            </div>
            <div>
                <h3 id="carModalTitle" class="text-2xl font-bold text-gray-800">เพิ่มรถยนต์</h3>
                <p class="text-gray-600 text-sm">กรอกข้อมูลรถยนต์ในระบบ</p>
            </div>
        </div>
        
        <form id="carForm" class="space-y-6">
            <input type="hidden" name="car_id" id="carId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold text-sm">ยี่ห้อ/รุ่น <span class="text-red-500">*</span></label>
                    <input type="text" id="carModel" name="car_model" required 
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" 
                        placeholder="เช่น Toyota Vios">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold text-sm">ทะเบียนรถ <span class="text-red-500">*</span></label>
                    <input type="text" id="carPlate" name="license_plate" required 
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" 
                        placeholder="เช่น กข 1234 กรุงเทพ">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold text-sm">ประเภทรถ <span class="text-red-500">*</span></label>
                    <select id="carType" name="car_type" required 
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                        <option value="">-- เลือกประเภทรถ --</option>
                        <option value="รถเก๋ง">🚗 รถเก๋ง</option>
                        <option value="รถตู้">🚐 รถตู้</option>
                        <option value="รถกระบะ">🛻 รถกระบะ</option>
                        <option value="รถบัส">🚌 รถบัส</option>
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-gray-700 font-semibold text-sm">ความจุ (คน) <span class="text-red-500">*</span></label>
                    <input type="number" id="carCapacity" name="capacity" required min="1" max="50" 
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" 
                        placeholder="4">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-gray-700 font-semibold text-sm">สถานะ</label>
                <select id="carStatus" name="status" 
                    class="w-full p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white">
                    <option value="1">🟢 พร้อมใช้งาน</option>
                    <option value="0">🔴 ไม่พร้อมใช้งาน</option>
                </select>
            </div>
            
            <div class="flex justify-end gap-4 pt-6 border-t">
                <button type="button" id="cancelCar" 
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-8 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105">
                    ยกเลิก
                </button>
                <button type="submit" 
                    class="bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white py-3 px-8 rounded-xl font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center gap-2">
                    <span>💾</span>
                    <span>บันทึก</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Indicators -->
<div class="loading-indicator fixed top-4 right-4 bg-white rounded-lg shadow-lg p-4 z-50 hidden">
    <div class="flex items-center gap-3">
        <div class="loading-spinner"></div>
        <span class="text-gray-600">กำลังโหลด...</span>
    </div>
</div>

<script>
// Remove the duplicate enhanced modal animations section and existing conflicting code
</script>

<?php require_once('script.php'); ?>
</body>
</html>
