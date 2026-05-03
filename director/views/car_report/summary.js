/**
 * Car Booking Report Logic
 */

let currentFormat = 1;
let reportData = null;

$(document).ready(function() {
    // Initial dates - current month
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    
    $('#startDate').val(firstDay.toISOString().split('T')[0]);
    $('#endDate').val(lastDay.toISOString().split('T')[0]);

    fetchCars();
    fetchReportData();

    $('#applyFilter').on('click', function() {
        fetchReportData();
    });
});

function fetchCars() {
    $.get('../officer/api/get_cars.php', function(response) {
        if (response.cars) {
            let html = '<option value="">ทั้งหมดทุกคัน</option>';
            response.cars.forEach(car => {
                html += `<option value="${car.id}">${car.car_model} (${car.license_plate})</option>`;
            });
            $('#carFilter').html(html);
        }
    });
}

function setFilterRange(type) {
    const today = new Date();
    let start, end;

    if (type === 'week') {
        const first = today.getDate() - today.getDay();
        start = new Date(today.setDate(first));
        end = new Date(today.setDate(first + 6));
    } else if (type === 'month') {
        start = new Date(today.getFullYear(), today.getMonth(), 1);
        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    } else if (type === 'lastMonth') {
        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
        end = new Date(today.getFullYear(), today.getMonth(), 0);
    } else if (type === 'year') {
        start = new Date(today.getFullYear(), 0, 1);
        end = today;
    } else if (type === 'fiscal') {
        const year = today.getFullYear();
        // Thai Fiscal Year: Oct (Prev Year) to Sep (Current Year)
        if (today.getMonth() >= 9) { // Oct or later
            start = new Date(year, 9, 1);
            end = new Date(year + 1, 8, 30);
        } else {
            start = new Date(year - 1, 9, 1);
            end = new Date(year, 8, 30);
        }
    }

    $('#startDate').val(start.toISOString().split('T')[0]);
    $('#endDate').val(end.toISOString().split('T')[0]);
    fetchReportData();
}

function fetchReportData() {
    const filters = {
        start_date: $('#startDate').val(),
        end_date: $('#endDate').val(),
        car_id: $('#carFilter').val()
    };

    $('#reportLoader').removeClass('hidden');
    $('#reportContent').addClass('opacity-50');

    $.get('../officer/api/report_data.php', filters, function(response) {
        $('#reportLoader').addClass('hidden');
        $('#reportContent').removeClass('opacity-50');
        
        if (response.success) {
            reportData = response.data;
            renderReport();
        } else {
            Swal.fire('ผิดพลาด', response.message, 'error');
        }
    });
}

function switchFormat(id) {
    currentFormat = id;
    $('.format-tab-btn').removeClass('active');
    $(`#btnFormat${id}`).addClass('active');
    renderReport();
}

function renderReport() {
    if (!reportData) return;

    if (currentFormat === 1) renderFormat1();
    else if (currentFormat === 2) renderFormat2();
    else if (currentFormat === 3) renderFormat3();
}

function getThaiMonthName(dateStr) {
    const d = new Date(dateStr);
    const months = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
    return months[d.getMonth()];
}

function getBuddhistYear(dateStr) {
    const d = new Date(dateStr);
    return d.getFullYear() + 543;
}

function formatThaiDateShort(dateStr) {
    if (!dateStr) return '-';
    const d = new Date(dateStr);
    const day = d.getDate();
    const month = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'][d.getMonth()];
    const year = (d.getFullYear() + 543).toString().substring(2);
    return `${day} ${month} ${year}`;
}

// ---------------- Format 1: Detailed Trip Report ----------------
function renderFormat1() {
    const start = $('#startDate').val();
    const month = getThaiMonthName(start);
    const year = getBuddhistYear(start);

    let html = `
        <div class="report-header">
            <h1 class="report-title">รายงานการใช้รถยนต์ส่วนกลาง (ราชการ)</h1>
            <h2 class="report-subtitle">โรงเรียนพิชัย ประจำปีงบประมาณ ${reportData.db_fiscal_year || '.....................'} ประจำเดือน ${month} ${year}</h2>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>เลขที่</th>
                    <th>วันเริ่มใช้รถ</th>
                    <th>วันสิ้นสุดใช้รถ</th>
                    <th>ทะเบียนรถ</th>
                    <th>ผู้ขอใช้รถ</th>
                    <th>เรื่อง/กิจกรรม</th>
                    <th>สถานที่ไปราชการ</th>
                    <th>จำนวน (คน)</th>
                    <th>คนขับรถ</th>
                    <th>โครงการ/กิจกรรม (น้ำมัน)</th>
                    <th>ค่าน้ำมัน (บาท)</th>
                    <th>เลขไมล์ล่าสุด</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (reportData.bookings.length === 0) {
        html += `<tr><td colspan="13" class="text-center py-10 text-gray-400">--- ไม่พบข้อมูลการใช้รถในช่วงเวลาที่เลือก ---</td></tr>`;
    } else {
        reportData.bookings.forEach((b, i) => {
            html += `
                <tr>
                    <td class="text-center">${i + 1}</td>
                    <td class="text-center">${formatThaiDateShort(b.start_time)}</td>
                    <td class="text-center">${formatThaiDateShort(b.end_time)}</td>
                    <td class="text-center">${b.license_plate || '-'}</td>
                    <td>${b.requester_name || '-'}</td>
                    <td>${b.purpose || '-'}</td>
                    <td>${b.destination || '-'}</td>
                    <td class="text-center">${b.total_passengers || b.passenger_count || 0}</td>
                    <td>${b.driver_name_full || '-'}</td>
                    <td>${b.fuel_project || '-'}</td>
                    <td class="text-right">${b.fuel_cost ? parseFloat(b.fuel_cost).toLocaleString() : '-'}</td>
                    <td class="text-right">${b.mileage_end || '-'}</td>
                    <td>${b.notes || ''}</td>
                </tr>
            `;
        });
    }

    html += `</tbody></table>`;
    $('#reportContent').html(html);
}

// ---------------- Format 2: Statistics Report ----------------
function renderFormat2() {
    const start = $('#startDate').val();
    const month = getThaiMonthName(start);
    const year = getBuddhistYear(start);

    let html = `
        <div class="report-header">
            <h1 class="report-title">สถิติการใช้รถยนต์ส่วนกลาง (ราชการ)</h1>
            <h2 class="report-subtitle">โรงเรียนพิชัย ประจำปีงบประมาณ ${reportData.db_fiscal_year || '.....................'} ประจำเดือน ${month} ${year}</h2>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>ลำดับที่</th>
                    <th>วัน/เดือน/ปี<br>ขอใช้รถไปราชการ</th>
                    <th>ผู้ขอใช้รถ</th>
                    <th>หน่วยงานภายใน</th>
                    <th>หน่วยงานภายนอก</th>
                    <th>จำนวนครู (คน)</th>
                    <th>จำนวนนักเรียน (คน)</th>
                    <th>ประเภทรถ</th>
                    <th>ทะเบียนรถ</th>
                    <th>พนักงานขับรถ</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
    `;

    if (reportData.bookings.length === 0) {
        html += `<tr><td colspan="11" class="text-center py-10 text-gray-400">--- ไม่พบข้อมูลสถิติในช่วงเวลาที่เลือก ---</td></tr>`;
    } else {
        reportData.bookings.forEach((b, i) => {
            html += `
                <tr>
                    <td class="text-center">${i + 1}</td>
                    <td class="text-center">${formatThaiDateShort(b.start_time)}</td>
                    <td>${b.requester_name || '-'}</td>
                    <td class="text-center">${b.agency_type === 'internal' ? '✓' : ''}</td>
                    <td class="text-center">${b.agency_type === 'external' ? '✓' : ''}</td>
                    <td class="text-center">${(b.passenger_count || 0) - (b.student_count || 0)}</td>
                    <td class="text-center">${b.student_count || 0}</td>
                    <td class="text-center">${b.car_type || '-'}</td>
                    <td class="text-center">${b.license_plate || '-'}</td>
                    <td>${b.driver_name_full || '-'}</td>
                    <td>${b.notes || ''}</td>
                </tr>
            `;
        });
    }

    html += `</tbody></table>`;
    $('#reportContent').html(html);
}

// ---------------- Format 3: Summary Aggregated Report ----------------
function renderFormat3() {
    const start = $('#startDate').val();
    const month = getThaiMonthName(start);
    const year = getBuddhistYear(start);

    let html = `
        <div class="report-header">
            <h1 class="report-title">สรุปสถิติการใช้รถยนต์ส่วนกลาง โรงเรียนพิชัย</h1>
            <h2 class="report-subtitle">ประจำปีงบประมาณ ${reportData.db_fiscal_year || '.....................'} ประจำเดือน ${month} ${year}</h2>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th rowspan="2">ลำดับที่</th>
                    <th rowspan="2">ประเภทรถ / ทะเบียนรถ</th>
                    <th rowspan="2">จำนวนการใช้<br>(ครั้ง)</th>
                    <th colspan="2">จำนวนผู้รับบริการ (ภายใน)</th>
                    <th colspan="2">จำนวนผู้รับบริการ (ภายนอก)</th>
                    <th rowspan="2">รวม</th>
                </tr>
                <tr>
                    <th>ครู (คน)</th>
                    <th>นักเรียน (คน)</th>
                    <th>ครู (คน)</th>
                    <th>นักเรียน (คน)</th>
                </tr>
            </thead>
            <tbody>
    `;

    let totalTrips = 0;
    let totalIntTeacher = 0;
    let totalIntStudent = 0;
    let totalExtTeacher = 0;
    let totalExtStudent = 0;
    let totalAll = 0;

    if (reportData.summary.length === 0) {
        html += `<tr><td colspan="8" class="text-center py-10 text-gray-400">--- ไม่พบข้อมูลสรุปในช่วงเวลาที่เลือก ---</td></tr>`;
    } else {
        reportData.summary.forEach((s, i) => {
            const rowTotal = parseInt(s.internal_teacher_sum) + parseInt(s.internal_student_sum) + parseInt(s.external_teacher_sum) + parseInt(s.external_student_sum);
            
            totalTrips += parseInt(s.trip_count || 0);
            totalIntTeacher += parseInt(s.internal_teacher_sum || 0);
            totalIntStudent += parseInt(s.internal_student_sum || 0);
            totalExtTeacher += parseInt(s.external_teacher_sum || 0);
            totalExtStudent += parseInt(s.external_student_sum || 0);
            totalAll += rowTotal;

            html += `
                <tr>
                    <td class="text-center">${i + 1}</td>
                    <td>${s.car_model} / ${s.license_plate}</td>
                    <td class="text-center font-bold">${s.trip_count || 0}</td>
                    <td class="text-center">${s.internal_teacher_sum || 0}</td>
                    <td class="text-center">${s.internal_student_sum || 0}</td>
                    <td class="text-center">${s.external_teacher_sum || 0}</td>
                    <td class="text-center">${s.external_student_sum || 0}</td>
                    <td class="text-center font-bold">${rowTotal.toLocaleString()}</td>
                </tr>
            `;
        });
    }

    html += `
            </tbody>
            <tfoot>
                <tr class="bg-gray-100 font-bold">
                    <td colspan="2" class="text-center py-4">รวม</td>
                    <td class="text-center">${totalTrips}</td>
                    <td class="text-center">${totalIntTeacher}</td>
                    <td class="text-center">${totalIntStudent}</td>
                    <td class="text-center">${totalExtTeacher}</td>
                    <td class="text-center">${totalExtStudent}</td>
                    <td class="text-center text-blue-600">${totalAll.toLocaleString()}</td>
                </tr>
            </tfoot>
        </table>
    `;

    $('#reportContent').html(html);
}

// ---------------- Export to Word ----------------
function exportToWord() {
    const reportContent = document.getElementById('reportContent').innerHTML;
    const header = `
        <html xmlns:o='urn:schemas-microsoft-com:office:office' 
              xmlns:w='urn:schemas-microsoft-com:office:word' 
              xmlns='http://www.w3.org/TR/REC-html40'>
        <head>
            <meta charset="utf-8">
            <style>
                @page WordSection1 { size: 841.9pt 595.3pt; mso-page-orientation: landscape; margin: 0.5in 0.5in 0.5in 0.5in; }
                div.WordSection1 { page: WordSection1; }
                table { border-collapse: collapse; width: 100%; border: 1px solid black; }
                th { background-color: #f3f4f6; border: 1px solid black; padding: 5px; font-family: 'Tahoma', sans-serif; font-size: 10pt; font-weight: bold; }
                td { border: 1px solid black; padding: 5px; font-family: 'Tahoma', sans-serif; font-size: 10pt; }
                .report-header { text-align: center; margin-bottom: 20px; }
                .report-title { font-size: 16pt; font-weight: bold; margin: 0; }
                .report-subtitle { font-size: 12pt; margin: 5px 0; }
                .text-center { text-align: center; }
                .font-bold { font-weight: bold; }
            </style>
        </head>
        <body>
            <div class="WordSection1">
    `;
    const footer = "</div></body></html>";
    const sourceHTML = header + reportContent + footer;
    
    const blob = new Blob(['\ufeff', sourceHTML], {
        type: 'application/msword'
    });
    
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'รายงานการใช้รถ_' + new Date().getTime() + '.doc';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

