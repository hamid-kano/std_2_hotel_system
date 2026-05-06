<?php
/**
 * Authentication Handler
 * Manages user and admin authentication
 */

class Auth {
    
    // User Authentication
    public static function loginUser($id, $name, $phone) {
        Session::regenerate();
        Session::set('login', true);
        Session::set('uId', $id);
        Session::set('uName', $name);
        Session::set('uPhone', $phone);
    }
    
    public static function logoutUser() {
        Session::remove('login');
        Session::remove('uId');
        Session::remove('uName');
        Session::remove('uPhone');
    }
    
    public static function isUserLoggedIn() {
        return Session::get('login') === true;
    }
    
    public static function userId() {
        return Session::get('uId');
    }
    
    public static function userName() {
        return Session::get('uName');
    }
    
    public static function requireUser() {
        if (!self::isUserLoggedIn()) {
            Response::redirect(SITE_URL);
        }
    }
    
    // Admin Authentication
    public static function loginAdmin($id) {
        Session::regenerate();
        Session::set('adminLogin', true);
        Session::set('adminId', $id);
    }
    
    public static function logoutAdmin() {
        Session::remove('adminLogin');
        Session::remove('adminId');
    }
    
    public static function isAdminLoggedIn() {
        return Session::get('adminLogin') === true;
    }
    
    public static function adminId() {
        return Session::get('adminId');
    }
    
    public static function requireAdmin() {
        if (!self::isAdminLoggedIn()) {
            Response::redirect(SITE_URL . 'admin/login');
        }
    }
    
    // Rate Limiting
    public static function checkRateLimit($action, $maxAttempts = MAX_LOGIN_ATTEMPTS, $timeout = LOGIN_TIMEOUT) {
        $ip = Request::ip();
        $key = $action . '_' . md5($ip);
        
        if (!Session::has($key)) {
            Session::set($key, ['count' => 0, 'time' => time()]);
        }
        
        $data = Session::get($key);
        
        // Reset if timeout passed
        if (time() - $data['time'] > $timeout) {
            Session::set($key, ['count' => 0, 'time' => time()]);
            return true;
        }
        
        // Check limit
        if ($data['count'] >= $maxAttempts) {
            return false;
        }
        
        // Increment counter
        $data['count']++;
        Session::set($key, $data);
        
        return true;
    }
    
    public static function resetRateLimit($action) {
        $ip = Request::ip();
        $key = $action . '_' . md5($ip);
        Session::remove($key);
    }
}
