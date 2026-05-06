<?php
/**
 * Setting Model
 */

class Setting extends Model {
    protected static $table = 'settings';
    protected static $primaryKey = 'sr_no';
    
    public static function get() {
        $result = static::db()->select(
            "SELECT * FROM `settings` WHERE `sr_no` = 1 LIMIT 1"
        );
        return static::fetchOne($result);
    }
    
    public static function getContact() {
        $result = static::db()->select(
            "SELECT * FROM `contact_details` WHERE `sr_no` = 1 LIMIT 1"
        );
        return static::fetchOne($result);
    }
}
