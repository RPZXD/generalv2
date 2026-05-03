<!-- User Management View -->
<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3 my-8">
                จัดการผู้ใช้งาน
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400 mt-4">กำหนดสิทธิ์การใช้งานและจัดการบัญชีผู้ใช้บุคลากร</p>
        </div>
    </div>

    <!-- User List Table -->
    <div class="glass rounded-3xl p-6 shadow-sm border border-white/20">
        <div class="overflow-x-auto">
            <table id="userTable" class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-sm uppercase tracking-wider">
                        <th class="px-4 py-4 font-semibold border-b border-gray-100 dark:border-gray-700">รูป</th>
                        <th class="px-4 py-4 font-semibold border-b border-gray-100 dark:border-gray-700">เลขประจำตัว
                        </th>
                        <th class="px-4 py-4 font-semibold border-b border-gray-100 dark:border-gray-700">ชื่อ-นามสกุล
                        </th>
                        <th class="px-4 py-4 font-semibold border-b border-gray-100 dark:border-gray-700">สิทธิ์ปัจจุบัน
                        </th>
                        <th class="px-4 py-4 font-semibold border-b border-gray-100 dark:border-gray-700 text-center">
                            จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300">
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div id="roleModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeRoleModal()">
            <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom glass rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/30 animate-slide-up">
            <div class="p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        กำหนดสิทธิ์ผู้ใช้
                    </h3>
                    <button onclick="closeRoleModal()"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <div
                        class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-slate-800/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div id="modalUserPhoto"
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-fuchsia-500 to-pink-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg overflow-hidden">
                            <!-- User initials or photo -->
                        </div>
                        <div>
                            <p id="modalUserName" class="text-lg font-bold text-gray-800 dark:text-white"></p>
                            <p id="modalUserId" class="text-sm text-gray-500"></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">เลือกบทบาทการใช้งาน</label>
                        <div class="grid grid-cols-1 gap-3" id="roleOptions">
                            <!-- Role radio buttons will be here -->
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button onclick="closeRoleModal()"
                        class="flex-1 px-6 py-3 bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-gray-300 rounded-2xl font-bold hover:bg-gray-200 dark:hover:bg-slate-700 transition-all">ยกเลิก</button>
                    <button onclick="saveUserRole()"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white rounded-2xl font-bold shadow-lg shadow-fuchsia-500/30 hover:scale-[1.02] transition-all">บันทึกการเปลี่ยนสิทธิ์</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const userRoles = {
        'ADM': { name: 'แอดมิน (Admin)', color: 'bg-red-500', icon: 'fa-user-shield' },
        'VP': { name: 'รองผู้อำนวยการ (VP)', color: 'bg-purple-500', icon: 'fa-user-tie' },
        'DIR': { name: 'ผู้อำนวยการ (Director)', color: 'bg-indigo-600', icon: 'fa-university' },
        'OF': { name: 'เจ้าหน้าที่ (Officer)', color: 'bg-blue-500', icon: 'fa-briefcase' },
        'T': { name: 'ครู (Teacher)', color: 'bg-emerald-500', icon: 'fa-chalkboard-teacher' },
        'HOD': { name: 'หัวหน้ากลุ่มสาระ (HOD)', color: 'bg-orange-500', icon: 'fa-users-cog' },
        'DRV': { name: 'พนักงานขับรถ (Driver)', color: 'bg-slate-600', icon: 'fa-bus' }
    };

    let selectedUserId = null;
    let dataTable = null;

    $(document).ready(function () {
        loadUsers();
    });

    function loadUsers() {
        if (dataTable) dataTable.destroy();

        $.get('api/user_list.php', function (response) {
            if (response.success) {
                const tbody = $('#userTable tbody');
                tbody.empty();

                response.users.forEach(user => {
                    const role = userRoles[user.role_general] || { name: 'ทั่วไป', color: 'bg-gray-400', icon: 'fa-user' };

                    tbody.append(`
                        <tr class="hover:bg-white/50 dark:hover:bg-slate-800/30 transition-colors border-b border-gray-50 dark:border-gray-800">
                            <td class="px-4 py-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-fuchsia-400 to-pink-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    ${user.Teach_photo ? `<img src="https://std.phichai.ac.th/teacher/uploads/phototeach/${user.Teach_photo}" class="w-full h-full rounded-full object-cover">` : user.Teach_name.substring(0, 2)}
                                </div>
                            </td>
                            <td class="px-4 py-4 font-mono font-medium text-blue-600 dark:text-blue-400">${user.Teach_id}</td>
                            <td class="px-4 py-4 font-semibold text-gray-800 dark:text-white">${user.Teach_name}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white ${role.color}">
                                    <i class="fas ${role.icon} mr-1.5"></i> ${role.name}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="editRole('${user.Teach_id}', '${user.Teach_name.replace(/'/g, "\\'")}', '${user.role_general}', '${user.Teach_photo}')" 
                                            class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 transition-colors" title="แก้ไขสิทธิ์">
                                        <i class="fas fa-user-tag"></i>
                                    </button>
                                    <button onclick="resetPassword('${user.Teach_id}', '${user.Teach_name.replace(/'/g, "\\'")}')" 
                                            class="p-2 bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-lg hover:bg-orange-100 transition-colors" title="รีเซ็ตรหัสผ่าน">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                dataTable = $('#userTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/th.json'
                    },
                    pageLength: 20
                });
            }
        });
    }

    function editRole(id, name, currentRole, photo) {
        selectedUserId = id;
        $('#modalUserName').text(name);
        $('#modalUserId').text('ID: ' + id);

        if (photo) {
            $('#modalUserPhoto').html(`<img src="../dist/img/teacher/${photo}" class="w-full h-full object-cover">`);
        } else {
            $('#modalUserPhoto').text(name.substring(0, 2)).html();
        }

        const options = $('#roleOptions');
        options.empty();

        Object.keys(userRoles).forEach(key => {
            const r = userRoles[key];
            const isSelected = key === currentRole;
            options.append(`
                <label class="relative flex items-center p-4 cursor-pointer rounded-2xl border-2 ${isSelected ? 'border-fuchsia-500 bg-fuchsia-50 dark:bg-fuchsia-900/20' : 'border-gray-100 dark:border-gray-700'} hover:bg-gray-50 dark:hover:bg-slate-800 transition-all">
                    <input type="radio" name="role" value="${key}" ${isSelected ? 'checked' : ''} class="hidden">
                    <div class="w-10 h-10 ${r.color} rounded-xl flex items-center justify-center text-white mr-4">
                        <i class="fas ${r.icon}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 dark:text-white">${r.name}</p>
                        <p class="text-xs text-gray-500 uppercase">${key}</p>
                    </div>
                    ${isSelected ? '<i class="fas fa-check-circle text-fuchsia-500 text-xl"></i>' : ''}
                </label>
            `);
        });

        // Add event listener to radio labels
        $('#roleOptions label').on('click', function () {
            $('#roleOptions label').removeClass('border-fuchsia-500 bg-fuchsia-50 dark:bg-fuchsia-900/20').addClass('border-gray-100 dark:border-gray-700');
            $('#roleOptions label i.fa-check-circle').remove();
            $(this).removeClass('border-gray-100 dark:border-gray-700').addClass('border-fuchsia-500 bg-fuchsia-50 dark:bg-fuchsia-900/20');
            $(this).append('<i class="fas fa-check-circle text-fuchsia-500 text-xl"></i>');
        });

        $('#roleModal').removeClass('hidden');
    }

    function closeRoleModal() {
        $('#roleModal').addClass('hidden');
    }

    function saveUserRole() {
        const role = $('input[name="role"]:checked').val();
        if (!role) return;

        Swal.fire({
            title: 'ยืนยันการเปลี่ยนสิทธิ์',
            text: `ต้องการเปลี่ยนสิทธิ์เป็น "${userRoles[role].name}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#d946ef'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/user_update.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        teach_id: selectedUserId,
                        action: 'update_role',
                        role: role
                    }),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('สำเร็จ', response.message, 'success');
                            closeRoleModal();
                            loadUsers();
                        } else {
                            Swal.fire('ผิดพลาด', response.message, 'error');
                        }
                    }
                });
            }
        });
    }

    function resetPassword(id, name) {
        Swal.fire({
            title: 'รีเซ็ตรหัสผ่าน?',
            text: `ยืนยันการรีเซ็ตรหัสผ่านของ "${name}" กลับเป็นรหัสเริ่มต้น (หมายเลขประจำตัว) ใช่หรือไม่?`,
            icon: 'caution',
            showCancelButton: true,
            confirmButtonText: 'รีเซ็ตทันที',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#f97316'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/user_update.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        teach_id: id,
                        action: 'reset_password'
                    }),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('สำเร็จ', response.message, 'success');
                        } else {
                            Swal.fire('ผิดพลาด', response.message, 'error');
                        }
                    }
                });
            }
        });
    }
</script>

<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        @apply bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-1.5 outline-none focus:ring-2 focus:ring-fuchsia-500 transition-all;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-gradient-to-r from-fuchsia-600 to-pink-600 border-none text-white !important rounded-xl;
    }
</style>