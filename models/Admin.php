<?php
/**
 * Admin Model
 */

class Admin extends Model {
    protected static $table = 'admin_cred';
    protected static $primaryKey = 'sr_no';
    
    public static function findByName($name) {
        $result = static::db()->select(
            "SELECT * FROM `admin_cred` WHERE `admin_name` = ? LIMIT 1",
            [$name], 's'
        );
        return static::fetchOne($result);
    }
    
    public static function verifyPassword($admin, $password) {
        // Support both bcrypt and plain-text (migration)
        if (password_get_info($admin['admin_pass'])['algo']) {
            return password_verify($password, $admin['admin_pass']);
        }
        return $admin['admin_pass'] === $password;
    }
    
    public static function upgradePassword($adminId, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        return static::db()->update(
            "UPDATE `admin_cred` SET `admin_pass` = ? WHERE `sr_no` = ?",
            [$hashed, $adminId], 'si'
        );
    }
}
