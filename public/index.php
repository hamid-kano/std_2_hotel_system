<?php
/**
 * Application Entry Point
 * All requests go through this file
 */

// Load application bootstrap
require_once __DIR__ . '/../bootstrap/app.php';

// Load routes
require_once BASE_PATH . '/routes/web.php';

// Dispatch the request
Router::dispatch();
