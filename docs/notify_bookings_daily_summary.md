# คู่มือการตั้งค่าสคริปต์แจ้งเตือนการจองห้องและจองรถยนต์รายวัน (Daily Booking Notifications Summary)

สคริปต์ [cron/notify_bookings_daily.php](file:///c:/xampp/htdocs/generalv2/cron/notify_bookings_daily.php) ทำหน้าที่สรุปการจองห้องประชุมและจองรถยนต์ราชการแบบรายวัน โดยจะประมวลผลตามช่วงเวลาของวันโดยอัตโนมัติ และส่งการแจ้งเตือนไปยังห้อง LINE หรือช่องทาง Discord ตามการตั้งค่าในระบบฐานข้อมูล

---

## 🛠️ คุณสมบัติการทำงาน (Key Features)

1. **Auto-Round Detection (ระบบตรวจจับรอบอัตโนมัติ)**:
   - **รันก่อนเวลา 12:00 น.** (รอบเช้า): จะสรุปรายการจองของ **"วันนี้"**
   - **รันตั้งแต่เวลา 12:00 น. เป็นต้นไป** (รอบเย็น): จะสรุปรายการจองของ **"วันพรุ่งนี้"**
2. **Database-Driven Settings (ความปลอดภัยสูง)**:
   - โหลด API Token, Group ID, และ Webhook URL ทั้งหมดจากตารางฐานข้อมูล `system_settings` เพื่อหลีกเลี่ยงการ Hardcode ข้อมูลสำคัญในโค้ด
3. **Resilient Data Resolution (การเชื่อมข้อมูลสมบูรณ์)**:
   - คิวรีข้อมูลจากระบบบริการทั่วไป (`phichaia_general`) เพื่อหาประวัติการจองและชื่อห้อง/รถยนต์
   - เชื่อมต่อกับระบบข้อมูลนักเรียน/ครู (`phichaia_student`) อัตโนมัติเพื่อแปลง Username/Teach_id ของครูผู้จองให้เป็นชื่อจริง-นามสกุลจริง เพื่อแสดงผลบนการแจ้งเตือน
4. **Smart Skip (ข้ามการส่งเมื่อไม่มีรายการ)**:
   - สคริปต์จะไม่ส่งข้อความแจ้งเตือนเปล่าหากไม่มีรายการจองในวันนั้น ๆ เพื่อลดความรบกวน

---

## 📅 การตั้งค่าตารางรันอัตโนมัติ (Cron Job Configuration)

แนะนำให้ตั้งค่า Task Scheduler (Windows) หรือ Crontab (Linux/Server) ให้รันสคริปต์ดังนี้:

### 1. รอบเช้า (05:00 น.) - สรุปรายการของวันนี้
ส่งข้อมูลสรุปรายการจองทั้งหมดที่จะเกิดขึ้นในวันนี้ เพื่อให้บุคลากรเตรียมความพร้อม
- **Linux Crontab**:
  ```bash
  0 5 * * * /usr/bin/php /path/to/generalv2/cron/notify_bookings_daily.php morning
  ```
- **Windows Task Scheduler (Action)**:
  - Program/script: `C:\xampp\php\php.exe`
  - Add arguments: `-f C:\xampp\htdocs\generalv2\cron\notify_bookings_daily.php morning`

### 2. รอบเย็น (18:00 น.) - สรุปรายการของวันพรุ่งนี้
ส่งข้อมูลสรุปรายการจองที่จะเกิดขึ้นในวันพรุ่งนี้ เพื่อแจ้งเตือนพนักงานขับรถหรือผู้รับผิดชอบห้องล่วงหน้า
- **Linux Crontab**:
  ```bash
  0 18 * * * /usr/bin/php /path/to/generalv2/cron/notify_bookings_daily.php evening
  ```
- **Windows Task Scheduler (Action)**:
  - Program/script: `C:\xampp\php\php.exe`
  - Add arguments: `-f C:\xampp\htdocs\generalv2\cron\notify_bookings_daily.php evening`

---

## 💻 การทดสอบและพารามิเตอร์การเรียกใช้งาน (Execution & Testing)

สคริปต์รองรับการทำงานทั้งผ่าน Command Line (CLI) และผ่าน Web Browser (URL):

### 1. เรียกใช้ผ่าน Command Line (CLI)
คุณสามารถบังคับรอบส่งข้อความได้โดยส่งพารามิเตอร์ต่อท้าย:
```bash
# ทดสอบรอบเช้า (บังคับส่งของวันนี้)
C:\xampp\php\php.exe -f cron/notify_bookings_daily.php morning

# ทดสอบรอบเย็น (บังคับส่งของวันพรุ่งนี้)
C:\xampp\php\php.exe -f cron/notify_bookings_daily.php evening

# ทดสอบแบบตรวจจับเวลาเครื่องอัตโนมัติ (ขึ้นกับเวลาปัจจุบันของระบบ)
C:\xampp\php\php.exe -f cron/notify_bookings_daily.php
```

### 2. เรียกใช้ผ่าน Web Browser (URL)
ใช้ในกรณีต้องการกดทดสอบระบบหรือรันผ่าน Cron Web Service:
- **รอบเช้า**: `http://localhost/generalv2/cron/notify_bookings_daily.php?round=morning`
- **รอบเย็น**: `http://localhost/generalv2/cron/notify_bookings_daily.php?round=evening`
- **อัตโนมัติ**: `http://localhost/generalv2/cron/notify_bookings_daily.php`

---

## 📝 รูปแบบข้อความตัวอย่างที่ส่งไปยัง LINE/Discord (Message Preview)

### 🏢 สรุปรายการจองห้องประชุม
```text
-----------------------------
📢 สรุปรายการจองห้องประชุม
สำหรับวันนี้ (19 พ.ค. 2569)
-----------------------------
1. 🏢 ห้องโสตทัศนศึกษา
   ⏰ เวลา: 09:00 - 12:00 น.
   👤 ผู้จอง: ครู สมชาย ใจดี (โทร: 0891234567)
   🎯 วัตถุประสงค์: ประชุมคณะกรรมการสถานศึกษา
   🪑 จัดห้อง: 🔲 ตัว U
   📺 อุปกรณ์: ไมโครโฟน 2 ตัว, เครื่องฉายโปรเจคเตอร์
   สถานะ: ✅ อนุมัติแล้ว
-----------------------------
```

### 🚐 สรุปรายการจองรถยนต์ราชการ
```text
-----------------------------
📢 สรุปรายการจองรถยนต์ราชการ
สำหรับวันนี้ (19 พ.ค. 2569)
-----------------------------
1. 🚐 Toyota Fortuner (กข 1234 พิชัย)
   ⏰ เวลา: 08:00 - 16:30 น.
   👤 ผู้จอง: ครู สมศรี รักเรียน (ครูผู้ช่วย)
   📍 ปลายทาง: สำนักงานเขตพื้นที่การศึกษา
   🎯 วัตถุประสงค์: นำส่งเอกสารการประเมินวิทยฐานะ
   สถานะ: ✅ อนุมัติแล้ว
-----------------------------
```
