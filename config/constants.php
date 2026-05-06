<?php
/**
 * Application Constants
 * All application-wide constants in one place
 */

// Project Configuration
define('PROJECT_FOLDER', 'std_2_hotel_system');

// BASE_PATH = root of the project (one level above /public)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
define('PUBLIC_PATH', BASE_PATH . '/public');

// URL Configuration
define('SITE_URL', 'http://localhost/' . PROJECT_FOLDER . '/public/');
define('ASSETS_URL', SITE_URL . 'assets/');
define('IMAGES_URL', SITE_URL . 'images/');

// Image Paths (URLs)
define('ABOUT_IMG_PATH',      IMAGES_URL . 'about/');
define('CAROUSEL_IMG_PATH',   IMAGES_URL . 'carousel/');
define('FACILITIES_IMG_PATH', IMAGES_URL . 'facilities/');
define('ROOMS_IMG_PATH',      IMAGES_URL . 'rooms/');
define('USERS_IMG_PATH',      IMAGES_URL . 'users/');

// Upload Paths (Server)
define('UPLOAD_IMAGE_PATH', PUBLIC_PATH . '/images/');
define('ABOUT_FOLDER',      'about/');
define('CAROUSEL_FOLDER',   'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER',      'rooms/');
define('USERS_FOLDER',      'users/');

// Storage Paths
define('STORAGE_PATH', BASE_PATH . '/storage');
define('CACHE_PATH',   STORAGE_PATH . '/cache');
define('LOGS_PATH',    STORAGE_PATH . '/logs');

// Application Settings
define('APP_NAME', 'Vana Hotel');
define('DEFAULT_LANG', 'ar');
define('SUPPORTED_LANGS', ['ar', 'en', 'ku']);

// Security Settings
define('SESSION_LIFETIME', 7200); // 2 hours
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 600); // 10 minutes

// Pagination
define('ITEMS_PER_PAGE', 10);
define('BOOKINGS_PER_PAGE', 6);

// File Upload Limits
define('MAX_IMAGE_SIZE', 2 * 1024 * 1024); // 2MB
define('MAX_SVG_SIZE', 1 * 1024 * 1024);   // 1MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('ALLOWED_SVG_TYPES', ['image/svg+xml']);
