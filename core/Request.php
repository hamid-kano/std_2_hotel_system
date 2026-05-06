<?php
/**
 * Request Handler
 * Handles HTTP requests and input validation
 */

class Request {
    
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public static function isPost() {
        return self::method() === 'POST';
    }
    
    public static function isGet() {
        return self::method() === 'GET';
    }
    
    public static function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    public static function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    public static function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    public static function input($key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }
    
    public static function all() {
        return $_REQUEST;
    }
    
    public static function has($key) {
        return isset($_REQUEST[$key]);
    }
    
    public static function file($key) {
        return $_FILES[$key] ?? null;
    }
    
    public static function hasFile($key) {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK;
    }
    
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        
        return $data;
    }
    
    public static function validate($rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = self::input($field);
            $ruleList = explode('|', $rule);
            
            foreach ($ruleList as $r) {
                if ($r === 'required' && empty($value)) {
                    $errors[$field][] = "$field is required";
                }
                
                if (str_starts_with($r, 'min:')) {
                    $min = (int)substr($r, 4);
                    if (strlen($value) < $min) {
                        $errors[$field][] = "$field must be at least $min characters";
                    }
                }
                
                if (str_starts_with($r, 'max:')) {
                    $max = (int)substr($r, 4);
                    if (strlen($value) > $max) {
                        $errors[$field][] = "$field must not exceed $max characters";
                    }
                }
                
                if ($r === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = "$field must be a valid email";
                }
                
                if ($r === 'numeric' && !is_numeric($value)) {
                    $errors[$field][] = "$field must be numeric";
                }
            }
        }
        
        return empty($errors) ? true : $errors;
    }
    
    public static function ip() {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    public static function userAgent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }
    
    public static function uri() {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
