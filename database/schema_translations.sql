-- ============================================================
--  Translation Tables for Dynamic Content
--  جداول الترجمة للمحتوى الديناميكي
-- ============================================================

-- ============================================================
-- 1. Features Translations (ترجمات ميزات الغرف)
-- ============================================================
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

-- ============================================================
-- 2. Facilities Translations (ترجمات مرافق الفندق)
-- ============================================================
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

-- ============================================================
-- 3. Rooms Translations (ترجمات الغرف)
-- ============================================================
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
-- Success Message
-- ============================================================
SELECT 'Translation tables created successfully!' AS status;
