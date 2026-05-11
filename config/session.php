<?php
/**
 * Session Configuration
 * Secure session management
 */
class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            // Ensure cookie is available across the whole site
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.cookie_secure', 0);
            ini_set('session.cookie_samesite', 'Lax');
            ini_set('session.cookie_path', '/');
            
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        session_destroy();
        $_SESSION = [];
    }
    
    public static function regenerate() {
        session_regenerate_id(true);
    }
    
    public static function flash($key, $value = null) {
        if ($value === null) {
            $val = self::get($key);
            self::remove($key);
            return $val;
        }
        self::set($key, $value);
    }
    
    public static function setLang($lang) {
        if (in_array($lang, SUPPORTED_LANGS)) {
            self::set('lang', $lang);
        }
    }
    
    public static function getLang() {
        return self::get('lang', DEFAULT_LANG);
    }
}
