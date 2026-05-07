<?php
/**
 * Application Bootstrap
 * Loads all necessary files and initializes the app
 */

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path — only if not already defined (constants.php may define it)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Load configuration
require_once BASE_PATH . '/config/constants.php';
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/config/session.php';

// Load core classes
require_once BASE_PATH . '/core/Request.php';
require_once BASE_PATH . '/core/Response.php';
require_once BASE_PATH . '/core/Validator.php';
require_once BASE_PATH . '/core/Auth.php';
require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Model.php';

// Load helpers
require_once BASE_PATH . '/helpers/functions.php';
require_once BASE_PATH . '/helpers/cache.php';

// Load models
require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Admin.php';
require_once BASE_PATH . '/models/Room.php';
require_once BASE_PATH . '/models/Booking.php';
require_once BASE_PATH . '/models/Review.php';
require_once BASE_PATH . '/models/Facility.php';
require_once BASE_PATH . '/models/Setting.php';

// Load controllers
require_once BASE_PATH . '/controllers/BaseController.php';
require_once BASE_PATH . '/controllers/AuthController.php';
require_once BASE_PATH . '/controllers/HomeController.php';
require_once BASE_PATH . '/controllers/RoomController.php';
require_once BASE_PATH . '/controllers/BookingController.php';
require_once BASE_PATH . '/controllers/UserController.php';

// Load admin controllers
require_once BASE_PATH . '/controllers/admin/AdminBaseController.php';
require_once BASE_PATH . '/controllers/admin/AdminDashboardController.php';
require_once BASE_PATH . '/controllers/admin/AdminBookingController.php';
require_once BASE_PATH . '/controllers/admin/AdminRoomController.php';
require_once BASE_PATH . '/controllers/admin/AdminUserController.php';
require_once BASE_PATH . '/controllers/admin/AdminFacilityController.php';
require_once BASE_PATH . '/controllers/admin/AdminReviewController.php';
require_once BASE_PATH . '/controllers/admin/AdminSettingsController.php';

// Start session
Session::start();

// Create storage directories if they don't exist
if (!is_dir(CACHE_PATH)) mkdir(CACHE_PATH, 0755, true);
if (!is_dir(LOGS_PATH)) mkdir(LOGS_PATH, 0755, true);
