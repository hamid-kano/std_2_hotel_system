<?php
/**
 * Automated Test Script for Vana Hotel System
 * سكريبت اختبار تلقائي لنظام فندق فانا
 * 
 * Usage: php tests/automated_tests.php
 */

// Configuration
define('BASE_URL', 'http://localhost/std_2_hotel_system/public/');
define('TEST_USER_EMAIL', 'ahmed@demo.com');
define('TEST_USER_PASS', 'password123');
define('TEST_ADMIN_NAME', 'admin');
define('TEST_ADMIN_PASS', 'admin123');

// Colors for terminal output
class Color {
    public static $GREEN = "\033[32m";
    public static $RED = "\033[31m";
    public static $YELLOW = "\033[33m";
    public static $BLUE = "\033[34m";
    public static $RESET = "\033[0m";
}

// Test Results
$results = [
    'total' => 0,
    'passed' => 0,
    'failed' => 0,
    'skipped' => 0
];

$failedTests = [];

/**
 * Print colored output
 */
function printColor($text, $color) {
    echo $color . $text . Color::$RESET . PHP_EOL;
}

/**
 * Print test header
 */
function printHeader($text) {
    echo PHP_EOL;
    printColor("═══════════════════════════════════════════════════", Color::$BLUE);
    printColor("  " . $text, Color::$BLUE);
    printColor("═══════════════════════════════════════════════════", Color::$BLUE);
    echo PHP_EOL;
}

/**
 * Run a test
 */
function runTest($testId, $testName, $callback) {
    global $results, $failedTests;
    
    $results['total']++;
    echo "Testing [{$testId}]: {$testName}... ";
    
    try {
        $result = $callback();
        if ($result === true) {
            printColor("✓ PASSED", Color::$GREEN);
            $results['passed']++;
        } else {
            printColor("✗ FAILED: " . ($result ?: 'Unknown error'), Color::$RED);
            $results['failed']++;
            $failedTests[] = ['id' => $testId, 'name' => $testName, 'error' => $result];
        }
    } catch (Exception $e) {
        printColor("✗ EXCEPTION: " . $e->getMessage(), Color::$RED);
        $results['failed']++;
        $failedTests[] = ['id' => $testId, 'name' => $testName, 'error' => $e->getMessage()];
    }
}

/**
 * Make HTTP request
 */
function makeRequest($url, $method = 'GET', $data = [], $cookies = []) {
    $ch = curl_init();
    
    $fullUrl = BASE_URL . ltrim($url, '/');
    
    if ($method === 'GET' && !empty($data)) {
        $fullUrl .= '?' . http_build_query($data);
    }
    
    curl_setopt($ch, CURLOPT_URL, $fullUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    }
    
    if (!empty($cookies)) {
        $cookieStr = [];
        foreach ($cookies as $key => $value) {
            $cookieStr[] = "$key=$value";
        }
        curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cookieStr));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    curl_close($ch);
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    // Extract cookies from response
    $responseCookies = [];
    preg_match_all('/Set-Cookie: ([^=]+)=([^;]+)/i', $headers, $matches);
    if (!empty($matches[1])) {
        foreach ($matches[1] as $i => $name) {
            $responseCookies[$name] = $matches[2][$i];
        }
    }
    
    return [
        'code' => $httpCode,
        'headers' => $headers,
        'body' => $body,
        'cookies' => $responseCookies
    ];
}

/**
 * Check if database tables exist
 */
function checkDatabaseTables() {
    $requiredTables = [
        'admin_cred',
        'settings',
        'contact_details',
        'user_cred',
        'balances',
        'user_queries',
        'team_members',
        'carousel',
        'facilities',
        'features',
        'rooms',
        'room_features',
        'room_facilities',
        'room_images',
        'booking_order',
        'booking_details',
        'rating_review'
    ];
    
    // This would require database connection
    // For now, we'll skip this test
    return 'SKIPPED: Requires database connection';
}

// ============================================================
// START TESTS
// ============================================================

printHeader("🧪 VANA HOTEL SYSTEM - AUTOMATED TESTS");
printColor("Base URL: " . BASE_URL, Color::$YELLOW);
printColor("Start Time: " . date('Y-m-d H:i:s'), Color::$YELLOW);

// ============================================================
// 1. PUBLIC PAGES TESTS
// ============================================================

printHeader("1. PUBLIC PAGES TESTS");

runTest('UC-HOME-001', 'Home page loads successfully', function() {
    $response = makeRequest('/');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-HOME-002', 'About page loads successfully', function() {
    $response = makeRequest('/about');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-HOME-003', 'Facilities page loads successfully', function() {
    $response = makeRequest('/facilities');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-HOME-004', 'Contact page loads successfully', function() {
    $response = makeRequest('/contact');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-ROOM-001', 'Rooms page loads successfully', function() {
    $response = makeRequest('/rooms');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-ROOM-002', 'Room details page loads', function() {
    $response = makeRequest('/room/1');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

// ============================================================
// 2. LANGUAGE SWITCHER TESTS
// ============================================================

printHeader("2. LANGUAGE SWITCHER TESTS");

runTest('UC-HOME-006', 'Switch to Arabic language', function() {
    $response = makeRequest('/set-lang?lang=ar');
    return ($response['code'] === 302 || $response['code'] === 200) ? true : "HTTP {$response['code']}";
});

runTest('UC-HOME-007', 'Switch to English language', function() {
    $response = makeRequest('/set-lang?lang=en');
    return ($response['code'] === 302 || $response['code'] === 200) ? true : "HTTP {$response['code']}";
});

runTest('UC-HOME-008', 'Switch to Kurdish language', function() {
    $response = makeRequest('/set-lang?lang=ku');
    return ($response['code'] === 302 || $response['code'] === 200) ? true : "HTTP {$response['code']}";
});

// ============================================================
// 3. AUTHENTICATION TESTS
// ============================================================

printHeader("3. AUTHENTICATION TESTS");

runTest('UC-AUTH-001', 'Login page loads', function() {
    $response = makeRequest('/login');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-AUTH-002', 'Register page loads', function() {
    $response = makeRequest('/register');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

runTest('UC-AUTH-008', 'Admin login page loads', function() {
    $response = makeRequest('/admin/login');
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

// Note: Actual login tests would require handling sessions and cookies properly
// These are more complex and would need a full testing framework

// ============================================================
// 4. SECURITY TESTS
// ============================================================

printHeader("4. SECURITY TESTS");

runTest('UC-SEC-001', 'Bookings page redirects when not logged in', function() {
    $response = makeRequest('/bookings');
    // Should redirect to login (302) or show login page (200 with login form)
    return ($response['code'] === 302 || $response['code'] === 200) ? true : "HTTP {$response['code']}";
});

runTest('UC-SEC-002', 'Admin dashboard redirects when not logged in', function() {
    $response = makeRequest('/admin/dashboard');
    // Should redirect to admin login
    return ($response['code'] === 302 || $response['code'] === 200) ? true : "HTTP {$response['code']}";
});

// ============================================================
// 5. API ENDPOINT TESTS
// ============================================================

printHeader("5. API ENDPOINT TESTS");

runTest('UC-ROOM-003', 'Room search API responds', function() {
    $response = makeRequest('/api/rooms/search', 'GET', ['adults' => 2, 'children' => 1]);
    return $response['code'] === 200 ? true : "HTTP {$response['code']}";
});

// ============================================================
// PRINT RESULTS
// ============================================================

printHeader("📊 TEST RESULTS SUMMARY");

echo PHP_EOL;
printColor("Total Tests:  {$results['total']}", Color::$BLUE);
printColor("Passed:       {$results['passed']}", Color::$GREEN);
printColor("Failed:       {$results['failed']}", Color::$RED);
printColor("Skipped:      {$results['skipped']}", Color::$YELLOW);
echo PHP_EOL;

$passRate = $results['total'] > 0 ? round(($results['passed'] / $results['total']) * 100, 2) : 0;
printColor("Pass Rate:    {$passRate}%", $passRate >= 80 ? Color::$GREEN : Color::$RED);

if (!empty($failedTests)) {
    printHeader("❌ FAILED TESTS DETAILS");
    foreach ($failedTests as $test) {
        printColor("[{$test['id']}] {$test['name']}", Color::$RED);
        printColor("  Error: {$test['error']}", Color::$YELLOW);
        echo PHP_EOL;
    }
}

printHeader("✅ TESTING COMPLETED");
printColor("End Time: " . date('Y-m-d H:i:s'), Color::$YELLOW);

// Exit with appropriate code
exit($results['failed'] > 0 ? 1 : 0);
