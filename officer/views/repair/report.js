$(document).ready(function() {
    // Set default dates (start of month to today)
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    $('#startDate').val(firstDay.toISOString().split('T')[0]);
    $('#endDate').val(today.toISOString().split('T')[0]);

    fetchReportData();

    $('#applyFilter').on('click', fetchReportData);
});

function setFilterRange(range) {
    const today = new Date();
    let start, end = today;

    if (range === 'week') {
        start = new Date(today.setDate(today.getDate() - today.getDay()));
    } else if (range === 'month') {
        start = new Date(today.getFullYear(), today.getMonth(), 1);
    } else if (range === 'year') {
        start = new Date(today.getFullYear(), 0, 1);
    }

    $('#startDate').val(start.toISOString().split('T')[0]);
    $('#endDate').val(new Date().toISOString().split('T')[0]);
    fetchReportData();
}

function fetchReportData() {
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();
    const status = $('#statusFilter').val();

    $('#reportLoader').removeClass('hidden');
    $('#reportContent').addClass('opacity-50');

    $.ajax({
        url: 'api/fetch_repair_report.php',
        type: 'GET',
        data: { startDate, endDate, status },
        success: function(res) {
            $('#reportLoader').addClass('hidden');
            $('#reportContent').removeClass('opacity-50');
            renderReport(res.list || [], startDate, endDate);
        },
        error: function() {
            $('#reportLoader').addClass('hidden');
            $('#reportContent').removeClass('opacity-50');
            Swal.fire('Error', 'ไม่สามารถดึงข้อมูลรายงานได้', 'error');
        }
    });
}

function renderReport(list, start, end) {
    const statusMap = {
        0: 'แจ้งใหม่',
        1: 'รอพิจารณา/งบ',
        2: 'กำลังดำเนินการ',
        3: 'ตรวจสอบ',
        4: 'เสร็จสิ้น'
    };

    let html = `
        <div class="report-header">
            <h2 class="report-title">รายงานสรุปผลการแจ้งซ่อมบำรุง</h2>
            <p class="report-subtitle">ประจำวันที่ ${formatThaiDate(start)} ถึง ${formatThaiDate(end)}</p>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th width="50">ลำดับ</th>
                    <th width="100">วันที่แจ้ง</th>
                    <th width="120">สถานที่</th>
                    <th width="120">ผู้แจ้ง</th>
                    <th>รายละเอียดความเสียหาย</th>
                    <th width="120">สถานะ</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (list.length === 0) {
        html += `<tr><td colspan="6" class="text-center py-10 font-bold text-slate-400">ไม่พบข้อมูลในช่วงเวลาที่เลือก</td></tr>`;
    } else {
        list.forEach((item, index) => {
            // Construct details summary
            let details = [];
            const fields = [
                'door', 'window', 'tablest', 'chairst', 'tableta', 'chairta', 
                'tv', 'audio', 'hdmi', 'projector', 'fan', 'light', 'air', 'sw', 'swfan', 'plug'
            ];
            const labels = {
                'door': 'ประตู', 'window': 'หน้าต่าง', 'tablest': 'โต๊ะนักเรียน',
                'chairst': 'เก้าอี้นักเรียน', 'tableta': 'โต๊ะอาจารย์', 'chairta': 'เก้าอี้อาจารย์',
                'tv': 'ทีวี', 'audio': 'เครื่องเสียง', 'hdmi': 'HDMI', 'projector': 'โปรเจคเตอร์',
                'fan': 'พัดลม', 'light': 'ไฟ', 'air': 'แอร์', 'sw': 'สวิตช์ไฟ',
                'swfan': 'สวิตช์พัดลม', 'plug': 'ปลั๊กไฟ'
            };

            fields.forEach(f => {
                if (item[f + 'Count'] > 0 || item[f + 'Damage']) {
                    details.push(`${labels[f]} (${item[f + 'Count']}): ${item[f + 'Damage'] || '-'}`);
                }
            });

            for(let i=1; i<=3; i++) {
                if (item[`other${i}Details`]) {
                    details.push(`${item[`other${i}Details`]} (${item[`other${i}Count`]}): ${item[`other${i}Damage`] || '-'}`);
                }
            }

            html += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${formatThaiDate(item.AddDate)}</td>
                    <td class="text-center">${item.AddLocation || '-'}</td>
                    <td class="text-center">${item.teach_name || item.teach_id}</td>
                    <td class="text-sm">${details.join('<br>') || '-'}</td>
                    <td class="text-center font-bold">${statusMap[item.status] || item.status}</td>
                </tr>
            `;
        });
    }

    html += `
            </tbody>
        </table>
        <div class="mt-8 text-right no-print-section">
            <p class="text-[10px] font-bold text-slate-400">ออกรายงานเมื่อ: ${new Date().toLocaleString('th-TH')}</p>
        </div>
    `;

    $('#reportContent').html(html);
}

function formatThaiDate(dateStr) {
    if (!dateStr) return '-';
    const date = new Date(dateStr);
    const months = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear() + 543}`;
}
