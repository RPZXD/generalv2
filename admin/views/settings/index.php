<?php
// Ensure config is available
if (!isset($config)) {
    $config = json_decode(file_get_contents(__DIR__ . '/../../../config.json'), true);
}
?>

<div class="space-y-6 animate-fade-in">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold gradient-text flex items-center gap-3 my-8">
                ตั้งค่าระบบ
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400 mt-4">จัดการข้อมูลทั่วไปและกำหนดเงื่อนไขการใช้งานของระบบ</p>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="glass rounded-3xl overflow-hidden shadow-sm border border-white/20">
        <div class="flex border-b border-gray-100 dark:border-gray-800 overflow-x-auto">
            <button onclick="switchTab('global')" id="tab-global" class="tab-btn active px-8 py-4 font-bold text-sm transition-all border-b-2 border-transparent">
                ตั้งค่าทั่วไป
            </button>
            <button onclick="switchTab('car')" id="tab-car" class="tab-btn px-8 py-4 font-bold text-sm transition-all border-b-2 border-transparent">
                ระบบจองรถ
            </button>
            <button onclick="switchTab('meeting')" id="tab-meeting" class="tab-btn px-8 py-4 font-bold text-sm transition-all border-b-2 border-transparent">
                ระบบห้องประชุม
            </button>
            <button onclick="switchTab('repair')" id="tab-repair" class="tab-btn px-8 py-4 font-bold text-sm transition-all border-b-2 border-transparent">
                ระบบแจ้งซ่อม
            </button>
            <button onclick="switchTab('notifications')" id="tab-notifications" class="tab-btn px-8 py-4 font-bold text-sm transition-all border-b-2 border-transparent">
                การแจ้งเตือน
            </button>
        </div>

        <form id="settingsForm" class="p-8">
            <!-- Global Settings -->
            <div id="content-global" class="tab-content space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ชื่อโรงเรียน</label>
                        <input type="text" name="global[nameschool]" value="<?php echo htmlspecialchars($config['global']['nameschool']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">หัวข้อหน้าเว็บ</label>
                        <input type="text" name="global[pageTitle]" value="<?php echo htmlspecialchars($config['global']['pageTitle']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ชื่อย่อระบบ</label>
                        <input type="text" name="global[nameTitle]" value="<?php echo htmlspecialchars($config['global']['nameTitle']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ไฟล์โลโก้ (ชื่อไฟล์ใน dist/img)</label>
                        <input type="text" name="global[logoLink]" value="<?php echo htmlspecialchars($config['global']['logoLink']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ข้อความเครดิตท้ายเว็บ</label>
                    <textarea name="global[footerCredit]" rows="2" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all"><?php echo htmlspecialchars($config['global']['footerCredit']); ?></textarea>
                </div>
            </div>

            <!-- Car Settings -->
            <div id="content-car" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">จำนวนวันจองล่วงหน้า</label>
                        <input type="number" name="car[advance_days]" value="<?php echo htmlspecialchars($config['car']['advance_days']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="flex items-center space-x-3 pt-8">
                        <input type="hidden" name="car[require_approval]" value="false">
                        <input type="checkbox" id="car-approval" name="car[require_approval]" value="true" <?php echo ($config['car']['require_approval'] == true) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                        <label for="car-approval" class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ต้องได้รับการอนุมัติ</label>
                    </div>
                </div>
            </div>

            <!-- Meeting Settings -->
            <div id="content-meeting" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">เวลาเริ่มให้จอง</label>
                        <input type="time" name="meeting[start_time]" value="<?php echo htmlspecialchars($config['meeting']['start_time']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">เวลาสิ้นสุดการจอง</label>
                        <input type="time" name="meeting[end_time]" value="<?php echo htmlspecialchars($config['meeting']['end_time']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">จำนวนวันจองล่วงหน้า</label>
                        <input type="number" name="meeting[advance_days]" value="<?php echo htmlspecialchars($config['meeting']['advance_days']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ชั่วโมงขั้นต่ำในการจอง</label>
                        <input type="number" name="meeting[min_hours]" value="<?php echo htmlspecialchars($config['meeting']['min_hours']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Repair Settings -->
            <div id="content-repair" class="tab-content hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ระยะเวลาดำเนินการพื้นฐาน (วัน)</label>
                        <input type="number" name="repair[default_days]" value="<?php echo htmlspecialchars($config['repair']['default_days']); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all">
                    </div>
                    <div class="flex items-center space-x-3 pt-8">
                        <input type="hidden" name="repair[email_notification]" value="false">
                        <input type="checkbox" id="repair-email" name="repair[email_notification]" value="true" <?php echo ($config['repair']['email_notification'] == true) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                        <label for="repair-email" class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">แจ้งเตือนผ่านอีเมล</label>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div id="content-notifications" class="tab-content hidden space-y-8">
                <div class="p-6 bg-blue-50 dark:bg-blue-900/10 rounded-3xl border border-blue-100 dark:border-blue-900/20">
                    <h4 class="text-lg font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center gap-2">
                        Discord Webhook
                    </h4>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Webhook URL สำหรับการจองรถ</label>
                                <input type="text" name="notifications[car_discord_webhook]" value="<?php echo htmlspecialchars($config['notifications']['car_discord_webhook'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="https://discord.com/api/webhooks/...">
                                <div class="flex items-center space-x-3 mt-2">
                                    <input type="hidden" name="notifications[car_discord_enabled]" value="false">
                                    <input type="checkbox" id="car-discord-enabled" name="notifications[car_discord_enabled]" value="true" <?php echo ($config['notifications']['car_discord_enabled'] ?? true) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="car-discord-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งานการแจ้งเตือนจองรถ</label>
                                </div>
                            </div>
                            <div class="space-y-2 border-t border-gray-100 dark:border-gray-800 pt-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Webhook URL สำหรับแจ้งซ่อม</label>
                                <input type="text" name="notifications[repair_discord_webhook]" value="<?php echo htmlspecialchars($config['notifications']['repair_discord_webhook'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="https://discord.com/api/webhooks/...">
                                <div class="flex items-center space-x-3 mt-2">
                                    <input type="hidden" name="notifications[repair_discord_enabled]" value="false">
                                    <input type="checkbox" id="repair-discord-enabled" name="notifications[repair_discord_enabled]" value="true" <?php echo ($config['notifications']['repair_discord_enabled'] ?? true) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="repair-discord-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งานการแจ้งเตือนแจ้งซ่อม</label>
                                </div>
                            </div>
                            <div class="space-y-2 border-t border-gray-100 dark:border-gray-800 pt-6">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Webhook URL สำหรับกลุ่มคนขับรถ (สรุปงานรายวัน)</label>
                                <input type="text" name="notifications[driver_discord_webhook]" value="<?php echo htmlspecialchars($config['notifications']['driver_discord_webhook'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="https://discord.com/api/webhooks/...">
                                <div class="flex items-center space-x-3 mt-2">
                                    <input type="hidden" name="notifications[driver_discord_enabled]" value="false">
                                    <input type="checkbox" id="driver-discord-enabled" name="notifications[driver_discord_enabled]" value="true" <?php echo ($config['notifications']['driver_discord_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="driver-discord-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งานการแจ้งเตือนกลุ่มคนขับรถ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-green-50 dark:bg-green-900/10 rounded-3xl border border-green-100 dark:border-green-900/20">
                    <h4 class="text-lg font-bold text-green-800 dark:text-green-300 mb-4 flex items-center gap-2">
                        Line Notify
                    </h4>
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Token สำหรับแจ้งบุคลากรทั่วไป (จองรถ/แจ้งซ่อม)</label>
                                <input type="text" name="notifications[line_token]" value="<?php echo htmlspecialchars($config['notifications']['line_token'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="ระบุ Token ของ Line Notify">
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="hidden" name="notifications[line_enabled]" value="false">
                                <input type="checkbox" id="line-enabled" name="notifications[line_enabled]" value="true" <?php echo ($config['notifications']['line_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                <label for="line-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งานการแจ้งเตือนผ่าน Line (ทั่วไป)</label>
                            </div>
                        </div>
                        <div class="space-y-4 border-t border-gray-100 dark:border-gray-800 pt-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Token สำหรับกลุ่มคนขับรถ (สรุปงานรายวัน)</label>
                                <input type="text" name="notifications[driver_line_token]" value="<?php echo htmlspecialchars($config['notifications']['driver_line_token'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="ระบุ Token ของ Line Notify">
                            </div>
                            <div class="flex items-center space-x-3">
                                <input type="hidden" name="notifications[driver_line_enabled]" value="false">
                                <input type="checkbox" id="driver-line-enabled" name="notifications[driver_line_enabled]" value="true" <?php echo ($config['notifications']['driver_line_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                <label for="driver-line-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งานการแจ้งเตือนผ่าน Line (กลุ่มคนขับ)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-sky-50 dark:bg-sky-900/10 rounded-3xl border border-sky-100 dark:border-sky-900/20">
                    <h4 class="text-lg font-bold text-sky-800 dark:text-sky-300 mb-4 flex items-center gap-2">
                        Telegram
                    </h4>
                    <div class="space-y-6">
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Telegram Bot Token</label>
                                <input type="text" name="notifications[telegram_bot_token]" value="<?php echo htmlspecialchars($config['notifications']['telegram_bot_token'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="123456789:ABCDefgh...">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Chat ID สำหรับทั่วไป</label>
                                    <input type="text" name="notifications[telegram_chat_id]" value="<?php echo htmlspecialchars($config['notifications']['telegram_chat_id'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="-100123456789">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="hidden" name="notifications[telegram_enabled]" value="false">
                                    <input type="checkbox" id="telegram-enabled" name="notifications[telegram_enabled]" value="true" <?php echo ($config['notifications']['telegram_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="telegram-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งาน Telegram (ทั่วไป)</label>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Chat ID สำหรับงานแจ้งซ่อม</label>
                                    <input type="text" name="notifications[telegram_repair_chat_id]" value="<?php echo htmlspecialchars($config['notifications']['telegram_repair_chat_id'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="-100555666777">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="hidden" name="notifications[telegram_repair_enabled]" value="false">
                                    <input type="checkbox" id="telegram-repair-enabled" name="notifications[telegram_repair_enabled]" value="true" <?php echo ($config['notifications']['telegram_repair_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="telegram-repair-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งาน Telegram (แจ้งซ่อม)</label>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Chat ID สำหรับกลุ่มคนขับรถ</label>
                                    <input type="text" name="notifications[telegram_driver_chat_id]" value="<?php echo htmlspecialchars($config['notifications']['telegram_driver_chat_id'] ?? ''); ?>" class="w-full px-4 py-3 bg-white dark:bg-slate-800 dark:text-white border border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-fuchsia-500 outline-none transition-all" placeholder="-100987654321">
                                </div>
                                <div class="flex items-center space-x-3">
                                    <input type="hidden" name="notifications[telegram_driver_enabled]" value="false">
                                    <input type="checkbox" id="telegram-driver-enabled" name="notifications[telegram_driver_enabled]" value="true" <?php echo ($config['notifications']['telegram_driver_enabled'] ?? false) ? 'checked' : ''; ?> class="w-5 h-5 rounded border-gray-300 text-fuchsia-600 focus:ring-fuchsia-500">
                                    <label for="telegram-driver-enabled" class="text-sm text-gray-600 dark:text-gray-400">เปิดใช้งาน Telegram (คนขับ)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 dark:border-gray-800 flex justify-end">
                <button type="submit" class="px-10 py-4 bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white rounded-2xl font-bold shadow-lg shadow-fuchsia-500/30 hover:scale-[1.02] transition-all">
                    บันทึกการตั้งค่า
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all contents
        $('.tab-content').addClass('hidden');
        // Show selected content
        $(`#content-${tabId}`).removeClass('hidden');
        
        // Update tab buttons
        $('.tab-btn').removeClass('active border-fuchsia-500 text-fuchsia-600').addClass('border-transparent text-gray-500');
        $(`#tab-${tabId}`).addClass('active border-fuchsia-500 text-fuchsia-600').removeClass('border-transparent text-gray-500');
    }

    // Initialize tabs
    $(document).ready(function() {
        switchTab('global');
        
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            
            // Collect form data into nested object structure
            const formData = {};
            const serialized = $(this).serializeArray();
            
            serialized.forEach(item => {
                // Parse names like global[nameschool]
                const match = item.name.match(/^(.+)\[(.+)\]$/);
                if (match) {
                    const group = match[1];
                    const key = match[2];
                    
                    if (!formData[group]) formData[group] = {};
                    
                    // Convert types
                    let value = item.value;
                    if (value === 'true') value = true;
                    if (value === 'false') value = false;
                    if (!isNaN(value) && value !== '' && group !== 'global') value = Number(value);
                    
                    formData[group][key] = value;
                }
            });

            Swal.fire({
                title: 'ยืนยันการบันทึก',
                text: 'คุณต้องการบันทึกการเปลี่ยนแปลงการตั้งค่าใช่หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#d946ef'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'api/settings_save.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(formData),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('สำเร็จ', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('ผิดพลาด', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('ผิดพลาด', 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

<style>
    .tab-btn.active {
        @apply text-fuchsia-600 border-fuchsia-500;
    }
</style>
