<?php
/**
 * Facility Model
 */

class Facility extends Model {
    protected static $table = 'facilities';
    
    public static function getActive() {
        return static::db()->select(
            "SELECT * FROM `facilities` ORDER BY `id` DESC"
        );
    }
    
    public static function getLimit($limit = 5) {
        return static::db()->select(
            "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT ?",
            [$limit], 'i'
        );
    }
}
