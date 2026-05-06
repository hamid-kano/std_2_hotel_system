<?php
/**
 * User Model
 * Handles all user-related database operations
 */

class User extends Model {
    protected static $table = 'user_cred';
    protected static $primaryKey = 'id';
    
    public static function findByEmail($email) {
        $result = static::db()->select(
            "SELECT * FROM `user_cred` WHERE `email` = ? LIMIT 1",
            [$email], 's'
        );
        return static::fetchOne($result);
    }
    
    public static function findByPhone($phone) {
        $result = static::db()->select(
            "SELECT * FROM `user_cred` WHERE `phonenum` = ? LIMIT 1",
            [$phone], 's'
        );
        return static::fetchOne($result);
    }
    
    public static function findByEmailOrPhone($identifier) {
        $result = static::db()->select(
            "SELECT * FROM `user_cred` WHERE `email` = ? OR `phonenum` = ? LIMIT 1",
            [$identifier, $identifier], 'ss'
        );
        return static::fetchOne($result);
    }
    
    public static function emailExists($email) {
        return static::count('`email` = ?', [$email], 's') > 0;
    }
    
    public static function phoneExists($phone) {
        return static::count('`phonenum` = ?', [$phone], 's') > 0;
    }
    
    public static function register($data) {
        $hashedPass = password_hash($data['pass'], PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(16));
        
        return static::db()->insert(
            "INSERT INTO `user_cred`(`name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `password`, `token`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [$data['name'], $data['email'], $data['address'], $data['phonenum'],
             $data['pincode'], $data['dob'], $hashedPass, $token],
            'ssssssss'
        );
    }
    
    public static function verifyPassword($user, $password) {
        return password_verify($password, $user['password']);
    }
    
    public static function updateProfile($userId, $data) {
        return static::db()->update(
            "UPDATE `user_cred` SET `name` = ?, `email` = ?, `phonenum` = ?, `address` = ? WHERE `id` = ?",
            [$data['name'], $data['email'], $data['phonenum'], $data['address'], $userId],
            'ssssi'
        );
    }
    
    public static function updatePassword($userId, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        return static::db()->update(
            "UPDATE `user_cred` SET `password` = ? WHERE `id` = ?",
            [$hashed, $userId], 'si'
        );
    }
    
    public static function updateAvatar($userId, $imageName) {
        return static::db()->update(
            "UPDATE `user_cred` SET `profile_img` = ? WHERE `id` = ?",
            [$imageName, $userId], 'si'
        );
    }
    
    public static function toggleStatus($userId, $status) {
        return static::db()->update(
            "UPDATE `user_cred` SET `status` = ? WHERE `id` = ?",
            [$status, $userId], 'ii'
        );
    }
    
    public static function getBalance($userId) {
        $result = static::db()->select(
            "SELECT `balance` FROM `balances` WHERE `user_id` = ? LIMIT 1",
            [$userId], 'i'
        );
        $row = static::fetchOne($result);
        return $row ? (float)$row['balance'] : 0.0;
    }
    
    public static function addBalance($userId, $amount) {
        return static::db()->update(
            "UPDATE `balances` SET `balance` = `balance` + ? WHERE `user_id` = ?",
            [$amount, $userId], 'di'
        );
    }
    
    public static function deductBalance($userId, $amount) {
        return static::db()->update(
            "UPDATE `balances` SET `balance` = `balance` - ? WHERE `user_id` = ?",
            [$amount, $userId], 'di'
        );
    }
    
    public static function getStats() {
        $result = static::db()->select(
            "SELECT
                COUNT(id) AS total,
                COUNT(CASE WHEN `status` = 1 THEN 1 END) AS active,
                COUNT(CASE WHEN `status` = 0 THEN 1 END) AS inactive
             FROM `user_cred`"
        );
        return static::fetchOne($result);
    }
}
