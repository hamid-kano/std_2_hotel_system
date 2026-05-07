<?php
/**
 * Response Handler
 * Handles HTTP responses
 */

class Response {
    
    public static function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    public static function success($message, $data = []) {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    
    public static function error($message, $statusCode = 400, $errors = []) {
        self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }
    
    public static function redirect($url) {
        header("Location: $url");
        exit;
    }
    
    public static function back() {
        $referer = $_SERVER['HTTP_REFERER'] ?? SITE_URL;
        self::redirect($referer);
    }
    
    public static function view($viewPath, $data = []) {
        // Always inject settings & contact for header/footer
        if (!isset($data['settings'])) {
            $data['settings'] = Cache::remember('settings_1', 300, fn() => Setting::get());
        }
        if (!isset($data['contact'])) {
            $data['contact'] = Cache::remember('contact_1', 300, fn() => Setting::getContact());
        }

        extract($data);
        
        $viewFile = BASE_PATH . '/views/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            self::error("View not found: $viewPath", 404);
        }
        
        require $viewFile;
        exit;
    }
    
    public static function notFound() {
        http_response_code(404);
        self::view('errors/404');
    }
    
    public static function unauthorized() {
        http_response_code(401);
        self::view('errors/401');
    }
    
    public static function forbidden() {
        http_response_code(403);
        self::view('errors/403');
    }
    
    public static function serverError($message = 'Internal Server Error') {
        http_response_code(500);
        error_log($message);
        // Render directly — avoid calling view() which may itself throw
        $viewFile = BASE_PATH . '/views/errors/500.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo '<h1>500 — Internal Server Error</h1><p>' . htmlspecialchars($message) . '</p>';
        }
        exit;
    }
}
