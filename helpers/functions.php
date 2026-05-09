<?php
/**
 * Helper Functions
 * Global utility functions
 */

function lang($key) {
    static $translations = null;
    if ($translations === null) {
        $lang = Session::getLang();
        $file = BASE_PATH . '/lang/' . $lang . '.php';
        $translations = file_exists($file) ? require $file : [];
    }
    return $translations[$key] ?? $key;
}

/**
 * Translate dynamic content (from database)
 * Gets translation from translation tables based on current language
 * 
 * @param string $table The translation table (features_translations, facilities_translations, rooms_translations)
 * @param int $id The ID of the item
 * @param string $field The field to translate (name, description)
 * @param string $fallback Fallback value if translation not found
 * @return string Translated text
 */
function getTranslation($table, $id, $field = 'name', $fallback = '') {
    static $cache = [];
    $lang = Session::getLang();
    $cacheKey = "{$table}_{$id}_{$field}_{$lang}";
    
    if (isset($cache[$cacheKey])) {
        return $cache[$cacheKey];
    }
    
    $db = Database::getInstance();
    
    // Map table names to their ID column names
    $columnMap = [
        'features_translations' => 'feature_id',
        'facilities_translations' => 'facility_id',
        'rooms_translations' => 'room_id'
    ];
    
    $idColumn = $columnMap[$table] ?? str_replace('_translations', '', $table) . '_id';
    
    $result = $db->select(
        "SELECT `{$field}` FROM `{$table}` WHERE `{$idColumn}` = ? AND `lang` = ? LIMIT 1",
        [$id, $lang],
        'is'
    );
    
    $row = Model::fetchOne($result);
    $translation = $row ? $row[$field] : $fallback;
    
    $cache[$cacheKey] = $translation;
    return $translation;
}

function redirect($url) {
    Response::redirect($url);
}

function alert($type, $message) {
    $class = ($type === 'success') ? 'alert-success' : 'alert-danger';
    return "<div class='alert $class alert-dismissible fade show custom-alert' role='alert'>
                <strong class='me-3'>$message</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
}

function uploadImage($file, $folder) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return 'upload_error';
    }
    
    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
        return 'inv_img';
    }
    
    if ($file['size'] > MAX_IMAGE_SIZE) {
        return 'inv_size';
    }
    
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'IMG_' . random_int(11111, 99999) . '.' . $ext;
    $path = UPLOAD_IMAGE_PATH . $folder . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $filename;
    }
    
    return 'upd_failed';
}

function deleteImage($filename, $folder) {
    $path = UPLOAD_IMAGE_PATH . $folder . $filename;
    return file_exists($path) && unlink($path);
}

function formatDate($date, $format = 'd-m-Y') {
    return date($format, strtotime($date));
}

function formatDateTime($datetime, $format = 'h:ia | d-m-Y') {
    return date($format, strtotime($datetime));
}

function sanitize($data) {
    return Request::sanitize($data);
}

function old($key, $default = '') {
    return Session::flash('old_' . $key) ?? $default;
}

function errors($key = null) {
    $errors = Session::flash('errors') ?? [];
    return $key ? ($errors[$key] ?? []) : $errors;
}

function hasError($key) {
    $errors = errors();
    return isset($errors[$key]);
}

function asset($path) {
    return ASSETS_URL . ltrim($path, '/');
}

function image($path) {
    return IMAGES_URL . ltrim($path, '/');
}
