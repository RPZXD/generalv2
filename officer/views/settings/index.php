<!-- Settings Content -->
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3">
                <span class="text-4xl">⚙️</span> ตั้งค่าระบบ
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">จัดการห้องประชุมและรถยนต์</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="glass rounded-2xl p-2">
        <div class="flex flex-wrap gap-2">
            <button class="settings-tab-btn active px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="rooms">
                <span class="text-lg">🏢</span> ห้องประชุม
            </button>
            <button class="settings-tab-btn px-6 py-3 rounded-xl font-medium text-sm transition-all flex items-center gap-2" data-tab="cars">
                <span class="text-lg">🚗</span> รถยนต์
            </button>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="settingsTabContent">
        <!-- Rooms Tab -->
        <div id="tab-rooms" class="settings-tab-pane">
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-lg text-white">
                            <i class="fas fa-door-open text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">จัดการห้องประชุม</h2>
                            <p class="text-sm text-gray-500">เพิ่ม แก้ไข ลบ ห้องประชุม</p>
                        </div>
                    </div>
                    <button onclick="openAddRoomModal()" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-xl hover:shadow-lg transition-all text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>เพิ่มห้องประชุม
                    </button>
                </div>

                <div id="roomList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-full text-center py-8 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลด...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cars Tab -->
        <div id="tab-cars" class="settings-tab-pane hidden">
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl shadow-lg text-white">
                            <i class="fas fa-car text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">จัดการรถยนต์</h2>
                            <p class="text-sm text-gray-500">เพิ่ม แก้ไข ลบ รถยนต์</p>
                        </div>
                    </div>
                    <button onclick="openAddCarModal()" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl hover:shadow-lg transition-all text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i>เพิ่มรถยนต์
                    </button>
                </div>

                <div id="carList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-full text-center py-8 text-gray-400">
                        <div class="loader mx-auto mb-4"></div>
                        <p>กำลังโหลด...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Room Modal -->
<div id="roomModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <button onclick="closeRoomModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-door-open text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="roomModalTitle">เพิ่มห้องประชุม</h3>
                <p class="text-sm text-gray-500">กรอกรายละเอียดห้องประชุม</p>
            </div>
        </div>

        <form id="roomForm" class="space-y-4">
            <input type="hidden" name="id" id="roomId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🏢 ชื่อห้องประชุม <span class="text-red-500">*</span></label>
                <input type="text" name="room_name" id="roomName" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="เช่น หอประชุมพิชัยดาบหัก" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">😊 Emoji</label>
                    <select name="emoji" id="roomEmoji" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="🏛️">🏛️ หอประชุม</option>
                        <option value="🏢">🏢 อาคาร</option>
                        <option value="📚">📚 ห้องเรียน</option>
                        <option value="💻">💻 ห้องคอม</option>
                        <option value="🎭">🎭 ห้องแสดง</option>
                        <option value="🎵">🎵 ห้องดนตรี</option>
                        <option value="🔬">🔬 ห้องแล็บ</option>
                        <option value="📖">📖 ห้องสมุด</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🎨 สี</label>
                    <select name="color" id="roomColor" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="red">🔴 แดง</option>
                        <option value="blue">🔵 น้ำเงิน</option>
                        <option value="green">🟢 เขียว</option>
                        <option value="amber">🟡 เหลือง</option>
                        <option value="purple">🟣 ม่วง</option>
                        <option value="pink">💗 ชมพู</option>
                        <option value="cyan">🩵 ฟ้า</option>
                        <option value="orange">�� ส้ม</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">👥 ความจุ (คน)</label>
                    <input type="number" name="capacity" id="roomCapacity" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="50" min="1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📍 อาคาร/สถานที่</label>
                    <input type="text" name="building" id="roomBuilding" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="เช่น อาคาร 1">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🛠️ อุปกรณ์</label>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="ไมค์" class="rounded text-fuchsia-600">
                        <span class="text-sm">🎤 ไมค์</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="โปรเจคเตอร์" class="rounded text-fuchsia-600">
                        <span class="text-sm">📽️ โปรเจคเตอร์</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="แอร์" class="rounded text-fuchsia-600">
                        <span class="text-sm">❄️ แอร์</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="คอมพิวเตอร์" class="rounded text-fuchsia-600">
                        <span class="text-sm">💻 คอมพิวเตอร์</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="เครื่องเสียง" class="rounded text-fuchsia-600">
                        <span class="text-sm">🔊 เครื่องเสียง</span>
                    </label>
                    <label class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-slate-700 rounded-lg cursor-pointer hover:bg-fuchsia-50 dark:hover:bg-fuchsia-900/20">
                        <input type="checkbox" name="equipment[]" value="WiFi" class="rounded text-fuchsia-600">
                        <span class="text-sm">📶 WiFi</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📊 สถานะ</label>
                <select name="status" id="roomStatus" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    <option value="1">✅ เปิดใช้งาน</option>
                    <option value="0">❌ ปิดใช้งาน</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-indigo-600 hover:to-purple-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span id="roomSubmitText">บันทึก</span>
            </button>
        </form>
    </div>
</div>

<!-- Car Modal -->
<div id="carModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass rounded-2xl shadow-2xl p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto relative mx-4 animate-scale-in">
        <button onclick="closeCarModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-100 hover:bg-red-200 dark:bg-red-900/30 text-red-500 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 flex items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl shadow-lg text-white">
                <i class="fas fa-car text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="carModalTitle">เพิ่มรถยนต์</h3>
                <p class="text-sm text-gray-500">กรอกรายละเอียดรถยนต์</p>
            </div>
        </div>

        <form id="carForm" class="space-y-4">
            <input type="hidden" name="id" id="carId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🚗 ชื่อรถ/รุ่น <span class="text-red-500">*</span></label>
                <input type="text" name="car_model" id="carModel" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="เช่น Toyota Hiace" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🔢 ทะเบียน <span class="text-red-500">*</span></label>
                    <input type="text" name="license_plate" id="carPlate" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" placeholder="กข 1234" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📋 ประเภท</label>
                    <select name="car_type" id="carType" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                        <option value="รถตู้">🚐 รถตู้</option>
                        <option value="รถเก๋ง">🚗 รถเก๋ง</option>
                        <option value="รถกระบะ">🛻 รถกระบะ</option>
                        <option value="รถบัส">🚌 รถบัส</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">👥 ความจุ (คน)</label>
                <input type="number" name="capacity" id="carCapacity" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white" value="8" min="1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📊 สถานะ</label>
                <select name="status" id="carStatus" class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white">
                    <option value="1">✅ พร้อมใช้งาน</option>
                    <option value="0">❌ ไม่พร้อมใช้งาน</option>
                </select>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span id="carSubmitText">บันทึก</span>
            </button>
        </form>
    </div>
</div>

<style>
.settings-tab-btn {
    background: transparent;
    color: #6b7280;
}
.settings-tab-btn:hover {
    background: rgba(217, 70, 239, 0.1);
    color: #d946ef;
}
.settings-tab-btn.active {
    background: linear-gradient(135deg, #d946ef, #a855f7);
    color: white;
    box-shadow: 0 4px 15px rgba(217, 70, 239, 0.3);
}
.dark .settings-tab-btn { color: #9ca3af; }
.dark .settings-tab-btn:hover { color: #d946ef; }

.loader {
    width: 40px;
    height: 40px;
    border: 4px solid #e5e7eb;
    border-top-color: #d946ef;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.animate-scale-in { animation: scale-in 0.2s ease-out; }
</style>

<script>
$(document).ready(function() {
    fetchRooms();
    fetchCars();
    setupTabHandlers();
});

function setupTabHandlers() {
    $('.settings-tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        $('.settings-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.settings-tab-pane').addClass('hidden');
        $(`#tab-${tab}`).removeClass('hidden');
    });
}

// ============ ROOMS ============
function fetchRooms() {
    $.get('api/get_rooms.php', function(response) {
        let rooms = response.rooms || response.list || [];
        if (rooms.length === 0) {
            $('#roomList').html('<div class="col-span-full text-center py-8 text-gray-400"><div class="text-5xl mb-4">🏢</div><p>ยังไม่มีห้องประชุม</p></div>');
            return;
        }
        
        let html = '';
        rooms.forEach(r => {
            const emoji = r.emoji || '🏢';
            const color = r.color || 'blue';
            const colorClasses = getColorClasses(color);
            const equipment = r.equipment ? r.equipment.split(',').map(e => `<span class="px-2 py-1 bg-gray-100 dark:bg-slate-600 rounded text-xs">${e.trim()}</span>`).join(' ') : '-';
            const statusBadge = r.status == 1 
                ? '<span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs">✅ เปิดใช้งาน</span>'
                : '<span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs">❌ ปิดใช้งาน</span>';
            
            html += `
            <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all border-l-4 ${colorClasses.border}">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 flex items-center justify-center ${colorClasses.bg} rounded-xl text-2xl">
                                ${emoji}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">${r.room_name}</h4>
                                <p class="text-xs text-gray-500">${r.building || '-'}</p>
                            </div>
                        </div>
                        ${statusBadge}
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <p><i class="fas fa-users mr-2 ${colorClasses.text}"></i>ความจุ: ${r.capacity || 0} คน</p>
                        <div><i class="fas fa-tools mr-2 ${colorClasses.text}"></i>อุปกรณ์: ${equipment}</div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button onclick="editRoom(${r.id})" class="flex-1 px-3 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-xl text-sm font-medium hover:bg-yellow-200 transition-colors">
                            <i class="fas fa-edit mr-1"></i>แก้ไข
                        </button>
                        <button onclick="deleteRoom(${r.id})" class="px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-xl text-sm font-medium hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        });
        $('#roomList').html(html);
    });
}

function getColorClasses(color) {
    const colors = {
        'red': { bg: 'bg-red-100 dark:bg-red-900/30', text: 'text-red-500', border: 'border-red-500' },
        'blue': { bg: 'bg-blue-100 dark:bg-blue-900/30', text: 'text-blue-500', border: 'border-blue-500' },
        'green': { bg: 'bg-green-100 dark:bg-green-900/30', text: 'text-green-500', border: 'border-green-500' },
        'amber': { bg: 'bg-amber-100 dark:bg-amber-900/30', text: 'text-amber-500', border: 'border-amber-500' },
        'purple': { bg: 'bg-purple-100 dark:bg-purple-900/30', text: 'text-purple-500', border: 'border-purple-500' },
        'pink': { bg: 'bg-pink-100 dark:bg-pink-900/30', text: 'text-pink-500', border: 'border-pink-500' },
        'cyan': { bg: 'bg-cyan-100 dark:bg-cyan-900/30', text: 'text-cyan-500', border: 'border-cyan-500' },
        'orange': { bg: 'bg-orange-100 dark:bg-orange-900/30', text: 'text-orange-500', border: 'border-orange-500' }
    };
    return colors[color] || colors['blue'];
}

function openAddRoomModal() {
    $('#roomModalTitle').text('เพิ่มห้องประชุม');
    $('#roomSubmitText').text('เพิ่มห้องประชุม');
    $('#roomForm')[0].reset();
    $('#roomId').val('');
    $('input[name="equipment[]"]').prop('checked', false);
    $('#roomModal').removeClass('hidden');
}

function editRoom(id) {
    $.get('api/get_rooms.php', { id: id }, function(response) {
        const room = response.room || (response.rooms && response.rooms[0]);
        if (room) {
            $('#roomModalTitle').text('แก้ไขห้องประชุม');
            $('#roomSubmitText').text('บันทึกการแก้ไข');
            $('#roomId').val(room.id);
            $('#roomName').val(room.room_name);
            $('#roomEmoji').val(room.emoji || '🏢');
            $('#roomColor').val(room.color || 'blue');
            $('#roomCapacity').val(room.capacity);
            $('#roomBuilding').val(room.building || '');
            $('#roomStatus').val(room.status);
            
            // Set equipment checkboxes
            $('input[name="equipment[]"]').prop('checked', false);
            if (room.equipment) {
                const equipList = room.equipment.split(',').map(e => e.trim());
                equipList.forEach(eq => {
                    $(`input[name="equipment[]"][value="${eq}"]`).prop('checked', true);
                });
            }
            
            $('#roomModal').removeClass('hidden');
        }
    }, 'json');
}

function closeRoomModal() {
    $('#roomModal').addClass('hidden');
}

$('#roomForm').on('submit', function(e) {
    e.preventDefault();
    
    const equipmentArr = [];
    $('input[name="equipment[]"]:checked').each(function() {
        equipmentArr.push($(this).val());
    });
    
    const data = {
        id: $('#roomId').val(),
        room_name: $('#roomName').val(),
        emoji: $('#roomEmoji').val(),
        color: $('#roomColor').val(),
        capacity: $('#roomCapacity').val(),
        building: $('#roomBuilding').val(),
        equipment: equipmentArr.join(', '),
        status: $('#roomStatus').val()
    };
    
    $.post('api/save_room.php', data, function(response) {
        if (response.success) {
            Swal.fire({icon: 'success', title: 'สำเร็จ!', text: data.id ? 'แก้ไขเรียบร้อย' : 'เพิ่มเรียบร้อย', timer: 1500, showConfirmButton: false});
            closeRoomModal();
            fetchRooms();
        } else {
            Swal.fire({icon: 'error', title: 'ผิดพลาด', text: response.message || 'ไม่สามารถบันทึกได้'});
        }
    }, 'json');
});

function deleteRoom(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'ห้องประชุมนี้จะถูกลบออกจากระบบ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api/delete_room.php', { id: id }, function(response) {
                if (response.success) {
                    Swal.fire({icon: 'success', title: 'ลบเรียบร้อย', timer: 1500, showConfirmButton: false});
                    fetchRooms();
                }
            }, 'json');
        }
    });
}

// ============ CARS ============
function fetchCars() {
    $.get('api/get_cars.php', function(response) {
        let cars = response.cars || response.list || [];
        if (cars.length === 0) {
            $('#carList').html('<div class="col-span-full text-center py-8 text-gray-400"><div class="text-5xl mb-4">🚗</div><p>ยังไม่มีรถยนต์</p></div>');
            return;
        }
        
        let html = '';
        cars.forEach(c => {
            const typeEmoji = {'รถตู้': '��', 'รถเก๋ง': '🚗', 'รถกระบะ': '🛻', 'รถบัส': '🚌'}[c.car_type] || '🚗';
            const statusBadge = c.status == 1 
                ? '<span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs">✅ พร้อมใช้</span>'
                : '<span class="px-2 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs">❌ ไม่พร้อม</span>';
            
            html += `
            <div class="bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all border-l-4 border-emerald-500">
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-2xl">
                                ${typeEmoji}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white">${c.car_model}</h4>
                                <p class="text-xs text-gray-500">${c.license_plate}</p>
                            </div>
                        </div>
                        ${statusBadge}
                    </div>
                    
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <p><i class="fas fa-car mr-2 text-emerald-500"></i>ประเภท: ${c.car_type}</p>
                        <p><i class="fas fa-users mr-2 text-emerald-500"></i>ความจุ: ${c.capacity || 0} คน</p>
                    </div>
                    
                    <div class="flex gap-2">
                        <button onclick="editCar(${c.id})" class="flex-1 px-3 py-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-xl text-sm font-medium hover:bg-yellow-200 transition-colors">
                            <i class="fas fa-edit mr-1"></i>แก้ไข
                        </button>
                        <button onclick="deleteCar(${c.id})" class="px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-xl text-sm font-medium hover:bg-red-200 transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        });
        $('#carList').html(html);
    });
}

function openAddCarModal() {
    $('#carModalTitle').text('เพิ่มรถยนต์');
    $('#carSubmitText').text('เพิ่มรถยนต์');
    $('#carForm')[0].reset();
    $('#carId').val('');
    $('#carModal').removeClass('hidden');
}

function editCar(id) {
    $.get('api/get_cars.php', { id: id }, function(response) {
        const car = response.car || (response.cars && response.cars[0]);
        if (car) {
            $('#carModalTitle').text('แก้ไขรถยนต์');
            $('#carSubmitText').text('บันทึกการแก้ไข');
            $('#carId').val(car.id);
            $('#carModel').val(car.car_model);
            $('#carPlate').val(car.license_plate);
            $('#carType').val(car.car_type);
            $('#carCapacity').val(car.capacity);
            $('#carStatus').val(car.status);
            $('#carModal').removeClass('hidden');
        }
    }, 'json');
}

function closeCarModal() {
    $('#carModal').addClass('hidden');
}

$('#carForm').on('submit', function(e) {
    e.preventDefault();
    
    const data = {
        id: $('#carId').val(),
        car_model: $('#carModel').val(),
        license_plate: $('#carPlate').val(),
        car_type: $('#carType').val(),
        capacity: $('#carCapacity').val(),
        status: $('#carStatus').val()
    };
    
    $.post('api/save_car.php', data, function(response) {
        if (response.success) {
            Swal.fire({icon: 'success', title: 'สำเร็จ!', text: data.id ? 'แก้ไขเรียบร้อย' : 'เพิ่มเรียบร้อย', timer: 1500, showConfirmButton: false});
            closeCarModal();
            fetchCars();
        } else {
            Swal.fire({icon: 'error', title: 'ผิดพลาด', text: response.message || 'ไม่สามารถบันทึกได้'});
        }
    }, 'json');
});

function deleteCar(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'รถยนต์นี้จะถูกลบออกจากระบบ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('api/delete_car.php', { id: id }, function(response) {
                if (response.success) {
                    Swal.fire({icon: 'success', title: 'ลบเรียบร้อย', timer: 1500, showConfirmButton: false});
                    fetchCars();
                }
            }, 'json');
        }
    });
}

// Close modals on outside click
$('#roomModal, #carModal').on('click', function(e) {
    if (e.target === this) $(this).addClass('hidden');
});
</script>
