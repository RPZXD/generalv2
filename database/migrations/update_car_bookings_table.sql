-- อัปเดตตาราง car_bookings ให้รองรับฟิลด์ใหม่
ALTER TABLE `car_bookings` 
ADD COLUMN `teacher_name` VARCHAR(255) NULL AFTER `teacher_id`,
ADD COLUMN `teacher_position` VARCHAR(255) NULL AFTER `teacher_name`,
ADD COLUMN `teacher_phone` VARCHAR(20) NULL AFTER `teacher_position`,
ADD COLUMN `passengers_detail` TEXT NULL AFTER `purpose`,
ADD COLUMN `teacher_count` INT(11) NULL DEFAULT 1 AFTER `passengers_detail`,
ADD COLUMN `student_count` INT(11) NULL DEFAULT 0 AFTER `teacher_count`,
ADD COLUMN `total_passengers` INT(11) NULL AFTER `student_count`;

-- เปลี่ยนชื่อคอลัมน์ passenger_count เป็น total_passengers (ถ้ามี)
-- ALTER TABLE `car_bookings` CHANGE `passenger_count` `total_passengers` INT(11) NOT NULL;
