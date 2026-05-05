<?php
/**
 * Simple file-based cache — Vana Hotel
 * Usage:
 *   $data = cache_get('key');
 *   if($data === null){ $data = expensive_query(); cache_set('key', $data, 300); }
 */

define('CACHE_DIR', sys_get_temp_dir() . '/vana_cache/');

function cache_get(string $key){
    $file = CACHE_DIR . md5($key) . '.cache';
    if(!file_exists($file)) return null;
    $raw = unserialize(file_get_contents($file));
    if($raw['expires'] < time()){ @unlink($file); return null; }
    return $raw['data'];
}

function cache_set(string $key, $data, int $ttl = 300): void {
    if(!is_dir(CACHE_DIR)) @mkdir(CACHE_DIR, 0700, true);
    $file = CACHE_DIR . md5($key) . '.cache';
    file_put_contents($file, serialize(['expires' => time() + $ttl, 'data' => $data]), LOCK_EX);
}

function cache_delete(string $key): void {
    $file = CACHE_DIR . md5($key) . '.cache';
    if(file_exists($file)) @unlink($file);
}

function cache_flush(): void {
    if(!is_dir(CACHE_DIR)) return;
    foreach(glob(CACHE_DIR . '*.cache') as $f) @unlink($f);
}
