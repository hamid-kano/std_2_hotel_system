-- ============================================================
--  Vana Hotel — Database Schema
--  قاعدة بيانات فندق فانا - البنية الأساسية
--  Run this BEFORE seeder.sql
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Drop existing tables if they exist
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
DROP TABLE IF EXISTS `team_detalis3`;
DROP TABLE IF EXISTS `user_queries1`;
DROP TABLE IF EXISTS `balances`;
DROP TABLE IF EXISTS `user_cred`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `contact_details`;
DROP TABLE IF EXISTS `admin_cred`;

-- ============================================================
-- 1. Admin Credentials
-- ============================================================
CREATE TABLE `admin_cred` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(150) NOT NULL,
  `admin_pass` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. General Settings
-- ============================================================
CREATE TABLE `settings` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `site_title` VARCHAR(100) NOT NULL,
  `site_about` TEXT NOT NULL,
  `shutdown` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. Contact Details
-- ============================================================
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

-- ============================================================
-- 4. Users
-- ============================================================
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

-- ============================================================
-- 5. User Balances
-- ============================================================
CREATE TABLE `balances` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_balances_user` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. User Queries (Contact Form)
-- ============================================================
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

-- ============================================================
-- 7. Team Members
-- ============================================================
CREATE TABLE `team_members` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `picture` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. Carousel Images
-- ============================================================
CREATE TABLE `carousel` (
  `sr_no` INT(11) NOT NULL AUTO_INCREMENT,
  `image` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`sr_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. Facilities (Hotel-wide)
-- ============================================================
CREATE TABLE `facilities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `icon` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 10. Features (Room-specific)
-- ============================================================
CREATE TABLE `features` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 11. Rooms
-- ============================================================
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

-- ============================================================
-- 12. Room Features (Many-to-Many)
-- ============================================================
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

-- ============================================================
-- 13. Room Facilities (Many-to-Many)
-- ============================================================
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

-- ============================================================
-- 14. Room Images
-- ============================================================
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

-- ============================================================
-- 15. Booking Orders
-- ============================================================
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

-- ============================================================
-- 16. Booking Details
-- ============================================================
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

-- ============================================================
-- 17. Reviews & Ratings
-- ============================================================
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

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- Success Message
-- ============================================================
SELECT 'Schema created successfully! Now run seeder.sql' AS status;
