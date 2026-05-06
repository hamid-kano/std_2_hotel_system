<?php
/**
 * Simple File-based Cache
 */

class Cache {
    
    public static function get($key) {
        $file = CACHE_PATH . '/' . md5($key) . '.cache';
        
        if (!file_exists($file)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($file));
        
        // Check expiration
        if ($data['expires'] > 0 && time() > $data['expires']) {
            unlink($file);
            return null;
        }
        
        return $data['value'];
    }
    
    public static function set($key, $value, $ttl = 300) {
        if (!is_dir(CACHE_PATH)) {
            mkdir(CACHE_PATH, 0755, true);
        }
        
        $file = CACHE_PATH . '/' . md5($key) . '.cache';
        $data = [
            'value' => $value,
            'expires' => $ttl > 0 ? time() + $ttl : 0
        ];
        
        return file_put_contents($file, serialize($data)) !== false;
    }
    
    public static function has($key) {
        return self::get($key) !== null;
    }
    
    public static function forget($key) {
        $file = CACHE_PATH . '/' . md5($key) . '.cache';
        return file_exists($file) && unlink($file);
    }
    
    public static function clear() {
        if (!is_dir(CACHE_PATH)) return true;
        
        $files = glob(CACHE_PATH . '/*.cache');
        foreach ($files as $file) {
            unlink($file);
        }
        return true;
    }
    
    public static function remember($key, $ttl, $callback) {
        $value = self::get($key);
        
        if ($value !== null) {
            return $value;
        }
        
        $value = $callback();
        self::set($key, $value, $ttl);
        
        return $value;
    }
}

// Legacy functions for backward compatibility
function cache_get($key) {
    return Cache::get($key);
}

function cache_set($key, $value, $ttl = 300) {
    return Cache::set($key, $value, $ttl);
}
