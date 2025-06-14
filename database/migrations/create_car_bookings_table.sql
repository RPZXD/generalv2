-- สร้างตาราง car_bookings สำหรับเก็บข้อมูลการจองรถ
CREATE TABLE IF NOT EXISTS `car_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `teacher_id` varchar(50) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `destination` text NOT NULL,
  `purpose` text NOT NULL,
  `passenger_count` int(11) NOT NULL,
  `notes` text,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `booking_date` (`booking_date`),
  KEY `status` (`status`),
  FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
