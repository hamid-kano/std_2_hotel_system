-- ============================================================
--  VANA HOTEL - COMPLETE DATABASE INSTALLATION
--  نظام فندق فانا - التثبيت الكامل لقاعدة البيانات
-- ============================================================
--  This file combines:
--  1. Schema (17 base tables)
--  2. Translation Schema (3 translation tables)
--  3. Demo Data (seeder)
--  4. Translation Data
--
--  Usage:
--  mysql -u root -p homework_std_ro_db < database/install.sql
--
--  Database: homework_std_ro_db
--  Charset: utf8mb4_unicode_ci
--  Author: Vana Hotel Development Team
--  Date: 2026-05-09
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ============================================================
-- PART 1: DROP EXISTING TABLES
-- ============================================================

DROP TABLE IF EXISTS `features_translations`;
DROP TABLE IF EXISTS `facilities_translations`;
DROP TABLE IF EXISTS `rooms_translations`;
DROP TABLE IF EXISTS `rating_review`;
DROP TABLE IF EXISTS `booking_details`;
DROP TABLE IF EXISTS `booking_order`;
DROP TABLE IF EXISTS `room_images`;
DROP TABLE IF EXISTS `room_features`;
DROP TABLE IF EXISTS `room_facilities`;
DROP TABLE IF EXISTS `rooms`;
DROP TABLE IF EXISTS `features`;
DROP TABLE IF EXISTS `facilities`;
DROP TABLE IF EXISTS `carousel`;
DROP TABLE IF EXISTS `team_members`;
DROP TABLE IF EXISTS `user_queries`;
DROP TABLE IF EXISTS `balances`;
DROP TABLE IF EXISTS `user_cred`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `contact_details`;
DROP TABLE IF EXISTS `admin_cred`;

-- ============================================================
-- PART 2: CREATE BASE TABLES (17 TABLES)
-- ============================================================

-- ── 1. Admin Credentials ─────────────────────────────────────
CREATE TABLE `admin_cred` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(150) NOT NULL,
  `admin_pass` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. General Settings ──────────────────────────────────────
CREATE TABLE `settings` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `site_title` VARCHAR(100) NOT NULL,
  `site_about` TEXT NOT NULL,
  `shutdown` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. Contact Details ───────────────────────────────────────
CREATE TABLE `contact_details` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `address` VARCHAR(255) NOT NULL,
  `gmap` VARCHAR(255) NOT NULL,
  `pn1` BIGINT(20) NOT NULL,
  `pn2` BIGINT(20) DEFAULT NULL,
  `email` VARCHAR(100) NOT NULL,
  `fb` VARCHAR(255) DEFAULT NULL,
  `insta` VARCHAR(255) DEFAULT NULL,
  `tw` VARCHAR(255) DEFAULT NULL,
  `iframe` TEXT NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. Users ─────────────────────────────────────────────────
CREATE TABLE `user_cred` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `address` VARCHAR(255) NOT NULL,
  `phonenum` VARCHAR(20) NOT NULL UNIQUE,
  `pincode` INT(11) NOT NULL,
  `dob` DATE NOT NULL,
  `profile` TINYINT(1) NOT NULL DEFAULT 0,
  `profile_img` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_verified` TINYINT(1) NOT NULL DEFAULT 0,
  `token` VARCHAR(255) DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  `datentime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email` (`email`),
  KEY `idx_phone` (`phonenum`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. User Balances ─────────────────────────────────────────
CREATE TABLE `balances` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_balances_user` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6. User Queries (Contact Form) ───────────────────────────
CREATE TABLE `user_queries` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `datentime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sr_no`),
  KEY `idx_seen` (`seen`),
  KEY `idx_date` (`datentime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 7. Team Members ──────────────────────────────────────────
CREATE TABLE `team_members` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `picture` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 8. Carousel Images ───────────────────────────────────────
CREATE TABLE `carousel` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 9. Facilities (Hotel-wide) ───────────────────────────────
CREATE TABLE `facilities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `icon` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 10. Features (Room-specific) ─────────────────────────────
CREATE TABLE `features` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 11. Rooms ────────────────────────────────────────────────
CREATE TABLE `rooms` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `area` INT(11) NOT NULL COMMENT 'Area in square meters',
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Price per night',
  `quantity` INT(11) NOT NULL DEFAULT 1 COMMENT 'Number of available rooms',
  `adult` INT(11) NOT NULL DEFAULT 1 COMMENT 'Max adults',
  `children` INT(11) NOT NULL DEFAULT 0 COMMENT 'Max children',
  `description` TEXT NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `removed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Soft delete flag',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`, `removed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 12. Room Features (Many-to-Many) ─────────────────────────
CREATE TABLE `room_features` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `room_id` INT(11) NOT NULL,
  `features_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_room_feature` (`room_id`, `features_id`),
  KEY `idx_room` (`room_id`),
  KEY `idx_feature` (`features_id`),
  CONSTRAINT `fk_room_features_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_features_feature` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 13. Room Facilities (Many-to-Many) ───────────────────────
CREATE TABLE `room_facilities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `room_id` INT(11) NOT NULL,
  `facilities_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_room_facility` (`room_id`, `facilities_id`),
  KEY `idx_room` (`room_id`),
  KEY `idx_facility` (`facilities_id`),
  CONSTRAINT `fk_room_facilities_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_facilities_facility` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 14. Room Images ──────────────────────────────────────────
CREATE TABLE `room_images` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `room_id` INT(11) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `thumb` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1=Thumbnail, 0=Regular',
  PRIMARY KEY (`sr_no`),
  KEY `idx_room` (`room_id`),
  KEY `idx_thumb` (`room_id`, `thumb`),
  CONSTRAINT `fk_room_images_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 15. Booking Orders ───────────────────────────────────────
CREATE TABLE `booking_order` (
  `booking_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `check_in` DATE NOT NULL,
  `check_out` DATE NOT NULL,
  `arrival` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1=Arrived, 0=Not yet',
  `refund` TINYINT(1) DEFAULT NULL COMMENT '1=Refunded, 0=Pending, NULL=N/A',
  `booking_status` ENUM('pending','booked','cancelled','failed') NOT NULL DEFAULT 'pending',
  `order_id` VARCHAR(100) NOT NULL UNIQUE,
  `trans_id` VARCHAR(255) DEFAULT NULL,
  `trans_amt` DECIMAL(10,2) DEFAULT NULL,
  `trans_status` VARCHAR(50) DEFAULT NULL,
  `trans_resp_msg` TEXT DEFAULT NULL,
  `rate_review` TINYINT(1) DEFAULT NULL COMMENT '1=Reviewed, 0=Not reviewed',
  `datentime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_room` (`room_id`),
  KEY `idx_status` (`booking_status`),
  KEY `idx_dates` (`check_in`, `check_out`),
  KEY `idx_order` (`order_id`),
  CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_booking_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 16. Booking Details ──────────────────────────────────────
CREATE TABLE `booking_details` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `booking_id` INT(11) NOT NULL,
  `room_name` VARCHAR(150) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Price per night at booking time',
  `total_pay` DECIMAL(10,2) NOT NULL COMMENT 'Total amount paid',
  `room_no` VARCHAR(20) DEFAULT NULL COMMENT 'Assigned room number',
  `user_name` VARCHAR(100) NOT NULL,
  `phonenum` VARCHAR(20) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`),
  UNIQUE KEY `booking_id` (`booking_id`),
  CONSTRAINT `fk_booking_details` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 17. Reviews & Ratings ────────────────────────────────────
CREATE TABLE `rating_review` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `booking_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `rating` TINYINT(1) NOT NULL CHECK (`rating` BETWEEN 1 AND 5),
  `review` TEXT NOT NULL,
  `seen` TINYINT(1) NOT NULL DEFAULT 0,
  `datentime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sr_no`),
  KEY `idx_room` (`room_id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_booking` (`booking_id`),
  KEY `idx_seen` (`seen`),
  CONSTRAINT `fk_review_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_review_user` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PART 3: CREATE TRANSLATION TABLES (3 TABLES)
-- ============================================================

-- ── 18. Features Translations ────────────────────────────────
CREATE TABLE `features_translations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `feature_id` INT(11) NOT NULL,
  `lang` VARCHAR(5) NOT NULL COMMENT 'ar, en, ku',
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_feature_lang` (`feature_id`, `lang`),
  KEY `idx_feature` (`feature_id`),
  KEY `idx_lang` (`lang`),
  CONSTRAINT `fk_features_trans_feature` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 19. Facilities Translations ──────────────────────────────
CREATE TABLE `facilities_translations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `facility_id` INT(11) NOT NULL,
  `lang` VARCHAR(5) NOT NULL COMMENT 'ar, en, ku',
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_facility_lang` (`facility_id`, `lang`),
  KEY `idx_facility` (`facility_id`),
  KEY `idx_lang` (`lang`),
  CONSTRAINT `fk_facilities_trans_facility` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 20. Rooms Translations ───────────────────────────────────
CREATE TABLE `rooms_translations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `room_id` INT(11) NOT NULL,
  `lang` VARCHAR(5) NOT NULL COMMENT 'ar, en, ku',
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_room_lang` (`room_id`, `lang`),
  KEY `idx_room` (`room_id`),
  KEY `idx_lang` (`lang`),
  CONSTRAINT `fk_rooms_trans_room` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- PART 4: INSERT DEMO DATA
-- ============================================================

-- ── 1. Admin (Password: admin123) ───────────────────────────
INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(1, 'admin', '$2y$10$NtHmTjp28qX2seosp73lH.D7t5mvMDLTa9XFfYG4sBjlg4CpA49CC');

-- ── 2. Settings ──────────────────────────────────────────────
INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'Vana Hotel', 'Nestled in the heart of Erbil, Vana Hotel offers a refined and sophisticated retreat for the modern traveler. Our experienced team is dedicated to delivering the highest levels of service.', 0);

-- ── 3. Contact Details ───────────────────────────────────────
INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `pn2`, `email`, `fb`, `insta`, `tw`, `iframe`) VALUES
(1, 'Erbil, Kurdistan Region, Iraq', 'https://maps.app.goo.gl/Cjk46hd6ZtnJ2N2o8', 9647501234567, 9647509876543, 'info@vanahotel.com', 'https://facebook.com/vanahotel', 'https://instagram.com/vanahotel', 'https://twitter.com/vanahotel', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d103031.92458615714!2d44.00896305!3d36.19701874210335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x400722fe13443461:0x3e01d63391de79d1!2z2KfYsdio2YrZhCwgS3VyZGlzdGFuIFJlZ2lvbtiMINin2YTYudix2KfZgg!5e0!3m2!1sar!2s!4v1710944568233!5m2!1sar!2s');

-- ── 4. Carousel ──────────────────────────────────────────────
INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(1, 'IMG_19327.png'), (2, 'IMG_57805.png'), (3, 'IMG_5.png');

-- ── 5. Features ──────────────────────────────────────────────
INSERT INTO `features` (`id`, `name`) VALUES
(1, 'Free Wi-Fi'), (2, 'Air Conditioning'), (3, 'Balcony'), (4, 'Kitchen'), (5, 'Room Service'),
(6, 'Mini Bar'), (7, 'Jacuzzi'), (8, 'Sea View'), (9, 'City View'), (10, 'Smart TV');

-- ── 6. Facilities ────────────────────────────────────────────
INSERT INTO `facilities` (`id`, `icon`, `name`, `description`) VALUES
(1, 'IMG_45307.svg', 'Air Conditioning', 'Climate control in all rooms'),
(2, 'IMG_15151.svg', 'Spa & Wellness', 'Full-service spa and wellness center'),
(3, 'IMG_54631.svg', 'Restaurant', 'Fine dining with international cuisine'),
(4, 'IMG_18593.svg', 'Concierge', '24/7 concierge services'),
(5, 'IMG_45039.svg', 'High-Speed Wi-Fi', 'Complimentary high-speed internet'),
(6, 'IMG_83389.svg', 'Business Center', 'Fully equipped business center'),
(7, 'IMG_89768.svg', 'Conference Rooms', 'Modern meeting and event spaces'),
(8, 'IMG_61046.svg', 'Swimming Pool', 'Outdoor heated swimming pool');

-- ── 7. Rooms ─────────────────────────────────────────────────
INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(1, 'Standard Room', 25, 80, 10, 2, 1, 'A comfortable standard room with all essential amenities, perfect for solo travelers or couples. Features a queen-size bed, en-suite bathroom, and city views.', 1, 0),
(2, 'Deluxe Room', 35, 150, 8, 2, 2, 'Spacious deluxe room with modern decor, premium bedding, and a stunning view. Includes a sitting area, minibar, and luxury bathroom with rain shower.', 1, 0),
(3, 'Studio Suite', 45, 200, 5, 2, 2, 'Open-plan suite combining bedroom and living area with a fully equipped kitchenette. Ideal for extended stays with a king-size bed and panoramic city views.', 1, 0),
(4, 'One-Bedroom Suite', 60, 280, 4, 2, 3, 'Elegant suite with a separate bedroom and spacious living room. Features premium furnishings, a dining area, and a luxurious bathroom with jacuzzi.', 1, 0),
(5, 'Family Room', 55, 220, 6, 2, 4, 'Designed for families, this room features two queen beds, a play area for children, and a large bathroom. Includes complimentary breakfast for all guests.', 1, 0),
(6, 'Presidential Suite', 120, 600, 2, 4, 2, 'The pinnacle of luxury — a sprawling suite with a private terrace, butler service, grand living room, two bedrooms, and breathtaking panoramic views of Erbil.', 1, 0);

-- ── 8. Room Features ─────────────────────────────────────────
INSERT INTO `room_features` (`room_id`, `features_id`) VALUES
(1,1),(1,2),(1,10), (2,1),(2,2),(2,3),(2,6),(2,10), (3,1),(3,2),(3,3),(3,4),(3,5),(3,10),
(4,1),(4,2),(4,3),(4,5),(4,6),(4,7),(4,10), (5,1),(5,2),(5,4),(5,5),(5,10),
(6,1),(6,2),(6,3),(6,4),(6,5),(6,6),(6,7),(6,8),(6,9),(6,10);

-- ── 9. Room Facilities ───────────────────────────────────────
INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES
(1,1),(1,5), (2,1),(2,4),(2,5), (3,1),(3,3),(3,4),(3,5),
(4,1),(4,2),(4,3),(4,4),(4,5),(4,6), (5,1),(5,3),(5,4),(5,5),(5,8),
(6,1),(6,2),(6,3),(6,4),(6,5),(6,6),(6,7),(6,8);

-- ── 10. Room Images ──────────────────────────────────────────
INSERT INTO `room_images` (`room_id`, `image`, `thumb`) VALUES
(1,'IMG_36840.png',1), (1,'IMG_44615.png',0), (2,'IMG_58588.png',1), (2,'IMG_36840.png',0),
(3,'IMG_81645.png',1), (3,'IMG_46752.png',0), (4,'IMG_54129.jpg',1), (4,'IMG_31704.png',0),
(5,'IMG_62925.png',1), (5,'IMG_94743.png',0), (6,'IMG_94743.png',1), (6,'IMG_62925.png',0);

-- ── 11. Team Members ─────────────────────────────────────────
INSERT INTO `team_members` (`sr_no`, `name`, `picture`) VALUES
(1, 'Ahmed Al-Rashid', 'IMG_35847.jpg'), (2, 'Sara Hassan', 'IMG_94008.webp'),
(3, 'Omar Khalid', 'IMG_14806.webp'), (4, 'Narin Aziz', 'IMG_95291.jpg');

-- ── 12. Users (Password: password123) ────────────────────────
INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `status`, `datentime`) VALUES
(1, 'Ahmed Ali', 'ahmed@demo.com', 'Erbil, Kurdistan', '07501111111', 44001, '1990-05-15', 0, '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-01-10 09:00:00'),
(2, 'Sara Hassan', 'sara@demo.com', 'Sulaymaniyah', '07502222222', 46001, '1995-08-22', 0, '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-02-14 10:30:00'),
(3, 'Omar Khalid', 'omar@demo.com', 'Duhok, Kurdistan', '07503333333', 42001, '1988-12-01', 0, '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-03-05 14:00:00'),
(4, 'Layla Nouri', 'layla@demo.com', 'Baghdad, Iraq', '07504444444', 10001, '1992-03-18', 0, '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-04-20 08:15:00'),
(5, 'Karwan Aziz', 'karwan@demo.com', 'Erbil, Kurdistan', '07505555555', 44002, '1997-07-30', 0, '$2y$10$RAbSdtV39PhveSXla7BjQ.XkFDGMnHg8zK8.ibKHu3mO86NA6P56m', 1, NULL, 1, '2024-05-11 16:45:00');

-- ── 13. Balances ─────────────────────────────────────────────
INSERT INTO `balances` (`user_id`, `balance`) VALUES
(1, 5000.00), (2, 3200.00), (3, 8500.00), (4, 1200.00), (5, 9999.00);

-- ── 14. Bookings ─────────────────────────────────────────────
INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_status`, `rate_review`, `datentime`) VALUES
(1, 1, 1, '2024-06-01', '2024-06-03', 1, NULL, 'booked', 'ORD-DEMO-001', 'success', 1, '2024-05-28 10:00:00'),
(2, 2, 2, '2024-06-05', '2024-06-08', 1, NULL, 'booked', 'ORD-DEMO-002', 'success', 1, '2024-06-01 11:00:00'),
(3, 3, 3, '2024-06-10', '2024-06-12', 1, NULL, 'booked', 'ORD-DEMO-003', 'success', 1, '2024-06-07 09:30:00'),
(4, 4, 4, '2024-06-15', '2024-06-18', 1, NULL, 'booked', 'ORD-DEMO-004', 'success', 1, '2024-06-12 14:00:00'),
(5, 5, 5, '2024-06-20', '2024-06-22', 1, NULL, 'booked', 'ORD-DEMO-005', 'success', 1, '2024-06-18 08:00:00'),
(6, 1, 2, '2025-12-01', '2025-12-05', 0, NULL, 'booked', 'ORD-DEMO-006', 'success', 0, '2025-11-20 10:00:00'),
(7, 2, 4, '2025-12-10', '2025-12-14', 0, NULL, 'booked', 'ORD-DEMO-007', 'success', 0, '2025-11-25 12:00:00'),
(8, 3, 1, '2024-07-01', '2024-07-03', 0, 1, 'cancelled', 'ORD-DEMO-008', 'success', NULL, '2024-06-28 09:00:00'),
(9, 4, 2, '2024-07-10', '2024-07-12', 0, 0, 'cancelled', 'ORD-DEMO-009', 'success', NULL, '2024-07-08 11:00:00');

INSERT INTO `booking_details` (`booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(1, 'Standard Room', 80, 160, '101', 'Ahmed Ali', '07501111111', 'Erbil, Kurdistan'),
(2, 'Deluxe Room', 150, 450, '205', 'Sara Hassan', '07502222222', 'Sulaymaniyah'),
(3, 'Studio Suite', 200, 400, '310', 'Omar Khalid', '07503333333', 'Duhok, Kurdistan'),
(4, 'One-Bedroom Suite', 280, 840, '401', 'Layla Nouri', '07504444444', 'Baghdad, Iraq'),
(5, 'Family Room', 220, 440, '502', 'Karwan Aziz', '07505555555', 'Erbil, Kurdistan'),
(6, 'Deluxe Room', 150, 600, NULL, 'Ahmed Ali', '07501111111', 'Erbil, Kurdistan'),
(7, 'One-Bedroom Suite', 280, 1120, NULL, 'Sara Hassan', '07502222222', 'Sulaymaniyah'),
(8, 'Standard Room', 80, 160, NULL, 'Omar Khalid', '07503333333', 'Duhok, Kurdistan'),
(9, 'Deluxe Room', 150, 300, NULL, 'Layla Nouri', '07504444444', 'Baghdad, Iraq');

-- ── 15. Reviews ──────────────────────────────────────────────
INSERT INTO `rating_review` (`booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(1, 1, 1, 5, 'Excellent stay! The room was spotless and the staff were incredibly helpful. Will definitely return.', 1, '2024-06-04 10:00:00'),
(2, 2, 2, 4, 'Very comfortable room with great amenities. The view from the balcony was stunning. Highly recommended.', 1, '2024-06-09 11:00:00'),
(3, 3, 3, 5, 'The studio suite exceeded all expectations. Perfect for a couple getaway. The kitchenette was a great bonus.', 0, '2024-06-13 09:00:00'),
(4, 4, 4, 3, 'Good room overall but the jacuzzi was not working during our stay. Staff resolved it quickly though.', 0, '2024-06-19 14:00:00'),
(5, 5, 5, 5, 'Perfect for our family! Kids loved the play area and the breakfast was delicious. 10/10.', 0, '2024-06-23 08:00:00');

-- ── 16. User Queries ─────────────────────────────────────────
INSERT INTO `user_queries` (`name`, `email`, `subject`, `message`, `datentime`, `seen`) VALUES
('Ahmed Ali', 'ahmed@demo.com', 'Room Availability', 'Hello, I would like to know if the Presidential Suite is available for New Year\'s Eve. Please let me know the rates.', '2024-11-01 10:00:00', 1),
('Sara Hassan', 'sara@demo.com', 'Special Request', 'We are celebrating our anniversary. Is it possible to arrange a special decoration in the room?', '2024-11-05 14:30:00', 1),
('Omar Khalid', 'omar@demo.com', 'Group Booking', 'We have a group of 15 people coming for a conference. Do you have special rates for group bookings?', '2024-11-10 09:15:00', 0),
('Layla Nouri', 'layla@demo.com', 'Cancellation Policy', 'What is your cancellation policy for bookings made more than 30 days in advance?', '2024-11-15 16:00:00', 0),
('Karwan Aziz', 'karwan@demo.com', 'Airport Transfer', 'Do you provide airport transfer services? If yes, what are the charges from Erbil International Airport?', '2024-11-20 11:45:00', 0);

-- ============================================================
-- PART 5: INSERT TRANSLATION DATA (72 RECORDS)
-- ============================================================

-- ── Features Translations (30 records) ───────────────────────
INSERT INTO `features_translations` (`feature_id`, `lang`, `name`) VALUES
(1,'en','Free Wi-Fi'), (1,'ar','واي فاي مجاني'), (1,'ku','Wi-Fi Belaş'),
(2,'en','Air Conditioning'), (2,'ar','تكييف هواء'), (2,'ku','Klîma'),
(3,'en','Balcony'), (3,'ar','شرفة'), (3,'ku','Balkon'),
(4,'en','Kitchen'), (4,'ar','مطبخ'), (4,'ku','Mitbax'),
(5,'en','Room Service'), (5,'ar','خدمة الغرف'), (5,'ku','Xizmeta Odeyê'),
(6,'en','Mini Bar'), (6,'ar','ميني بار'), (6,'ku','Mînî Bar'),
(7,'en','Jacuzzi'), (7,'ar','جاكوزي'), (7,'ku','Jakûzî'),
(8,'en','Sea View'), (8,'ar','إطلالة بحرية'), (8,'ku','Dîtina Deryayê'),
(9,'en','City View'), (9,'ar','إطلالة على المدينة'), (9,'ku','Dîtina Bajarê'),
(10,'en','Smart TV'), (10,'ar','تلفاز ذكي'), (10,'ku','TV Zîrek');

-- ── Facilities Translations (24 records) ─────────────────────
INSERT INTO `facilities_translations` (`facility_id`, `lang`, `name`, `description`) VALUES
(1,'en','Air Conditioning','Climate control in all rooms'),
(1,'ar','تكييف هواء','تحكم بالمناخ في جميع الغرف'),
(1,'ku','Klîma','Kontrola hewayê li hemû odeyan'),
(2,'en','Spa & Wellness','Full-service spa and wellness center'),
(2,'ar','سبا ومركز صحي','مركز سبا وعافية متكامل الخدمات'),
(2,'ku','Spa û Tenduristî','Navenda spa û tenduristiyê bi xizmetên tevahî'),
(3,'en','Restaurant','Fine dining with international cuisine'),
(3,'ar','مطعم','تناول طعام فاخر مع مأكولات عالمية'),
(3,'ku','Xwarinxane','Xwarina xweş bi xwarinên navneteweyî'),
(4,'en','Concierge','24/7 concierge services'),
(4,'ar','خدمة الكونسيرج','خدمات الكونسيرج على مدار الساعة'),
(4,'ku','Xizmeta Mêvan','Xizmetên mêvan 24/7'),
(5,'en','High-Speed Wi-Fi','Complimentary high-speed internet'),
(5,'ar','إنترنت عالي السرعة','إنترنت مجاني عالي السرعة'),
(5,'ku','Înternet Bilez','Înternet bilez belaş'),
(6,'en','Business Center','Fully equipped business center'),
(6,'ar','مركز أعمال','مركز أعمال مجهز بالكامل'),
(6,'ku','Navenda Karsaziyê','Navenda karsaziyê bi tevahî amade'),
(7,'en','Conference Rooms','Modern meeting and event spaces'),
(7,'ar','قاعات مؤتمرات','قاعات اجتماعات وفعاليات حديثة'),
(7,'ku','Salên Konferansê','Cihên civîn û bûyeran ên modern'),
(8,'en','Swimming Pool','Outdoor heated swimming pool'),
(8,'ar','مسبح','مسبح خارجي مُدفأ'),
(8,'ku','Hewza Avê','Hewza avê ya derveyî ya germ');

-- ── Rooms Translations (18 records) ──────────────────────────
INSERT INTO `rooms_translations` (`room_id`, `lang`, `name`, `description`) VALUES
(1,'en','Standard Room','A comfortable standard room with all essential amenities, perfect for solo travelers or couples. Features a queen-size bed, en-suite bathroom, and city views.'),
(1,'ar','غرفة قياسية','غرفة قياسية مريحة مع جميع وسائل الراحة الأساسية، مثالية للمسافرين الفرديين أو الأزواج. تحتوي على سرير كوين، حمام داخلي، وإطلالة على المدينة.'),
(1,'ku','Odeya Standard','Odeyek standard a rehet bi hemû amûrên bingehîn, ji bo rêwîtiyên yekane an hevjînan baş e. Nivînek queen-size, banyoyek hundurîn û dîtina bajarê heye.'),
(2,'en','Deluxe Room','Spacious deluxe room with modern decor, premium bedding, and a stunning view. Includes a sitting area, minibar, and luxury bathroom with rain shower.'),
(2,'ar','غرفة ديلوكس','غرفة ديلوكس واسعة مع ديكور عصري، فراش فاخر، وإطلالة خلابة. تشمل منطقة جلوس، ميني بار، وحمام فاخر مع دش مطري.'),
(2,'ku','Odeya Deluxe','Odeyek deluxe a fireh bi dekorasyoneke modern, nivîneke premium û dîtinek ecêb. Cihek rûniştinê, mînî bar û banyoyek lûks bi duşa baranê heye.'),
(3,'en','Studio Suite','Open-plan suite combining bedroom and living area with a fully equipped kitchenette. Ideal for extended stays with a king-size bed and panoramic city views.'),
(3,'ar','جناح استوديو','جناح مفتوح يجمع بين غرفة النوم ومنطقة المعيشة مع مطبخ صغير مجهز بالكامل. مثالي للإقامات الطويلة مع سرير كينج وإطلالة بانورامية على المدينة.'),
(3,'ku','Stûdyo Suite','Suite-yek vekirî ku odeya razanê û cihê jiyanê bi mitbaxeke piçûk a bi tevahî amade dike yek. Ji bo mayînên dirêj bi nivîneke king-size û dîtina panoramîk a bajarê baş e.'),
(4,'en','One-Bedroom Suite','Elegant suite with a separate bedroom and spacious living room. Features premium furnishings, a dining area, and a luxurious bathroom with jacuzzi.'),
(4,'ar','جناح بغرفة نوم واحدة','جناح أنيق مع غرفة نوم منفصلة وغرفة معيشة واسعة. يحتوي على أثاث فاخر، منطقة طعام، وحمام فاخر مع جاكوزي.'),
(4,'ku','Suite bi Yek Odeya Razanê','Suite-yek xweşik bi odeya razanê ya veqetandî û salona jiyanê ya fireh. Mobilyayên premium, cihek xwarinê û banyoyek lûks bi jakûzî heye.'),
(5,'en','Family Room','Designed for families, this room features two queen beds, a play area for children, and a large bathroom. Includes complimentary breakfast for all guests.'),
(5,'ar','غرفة عائلية','مصممة للعائلات، تحتوي هذه الغرفة على سريرين كوين، منطقة لعب للأطفال، وحمام كبير. تشمل إفطار مجاني لجميع الضيوف.'),
(5,'ku','Odeya Malbatê','Ji bo malbatan hatiye çêkirin, ev ode du nivînên queen, cihek lîstikê ji zarokan û banyoyek mezin heye. Taştê sibehê ji hemû mêvanan re belaş e.'),
(6,'en','Presidential Suite','The pinnacle of luxury — a sprawling suite with a private terrace, butler service, grand living room, two bedrooms, and breathtaking panoramic views of Erbil.'),
(6,'ar','الجناح الرئاسي','قمة الفخامة - جناح واسع مع تراس خاص، خدمة خادم شخصي، غرفة معيشة كبيرة، غرفتي نوم، وإطلالات بانورامية خلابة على أربيل.'),
(6,'ku','Suite ya Serokê','Bilindahiya lûksê - suite-yek mezin bi teraseke taybet, xizmeta butler, salona jiyanê ya mezin, du odeyan razanê û dîtinên panoramîk ên ecêb ên Hewlêrê.');

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- INSTALLATION COMPLETE!
-- ============================================================
SELECT '✅ Installation completed successfully!' AS status,
       '20 tables created (17 base + 3 translation)' AS tables,
       '72 translation records inserted' AS translations,
       'Database: homework_std_ro_db' AS database_name;
