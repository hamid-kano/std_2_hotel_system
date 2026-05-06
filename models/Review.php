<?php
/**
 * Review Model
 * Handles rating and review operations
 */

class Review extends Model {
    protected static $table = 'rating_review';
    protected static $primaryKey = 'sr_no';
    
    public static function getLatest($limit = 6) {
        $result = static::db()->select(
            "SELECT rr.*, uc.name AS uname
             FROM `rating_review` rr
             INNER JOIN `user_cred` uc ON rr.user_id = uc.id
             ORDER BY rr.sr_no DESC
             LIMIT ?",
            [$limit], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function getForRoom($roomId) {
        $result = static::db()->select(
            "SELECT rr.*, uc.name AS uname
             FROM `rating_review` rr
             INNER JOIN `user_cred` uc ON rr.user_id = uc.id
             WHERE rr.room_id = ?
             ORDER BY rr.sr_no DESC",
            [$roomId], 'i'
        );
        return static::fetchAll($result);
    }
    
    public static function add($bookingId, $roomId, $userId, $rating, $review) {
        // Mark booking as reviewed
        static::db()->update(
            "UPDATE `booking_order` SET `rate_review` = 1 WHERE `booking_id` = ?",
            [$bookingId], 'i'
        );
        
        return static::db()->insert(
            "INSERT INTO `rating_review`(`booking_id`, `room_id`, `user_id`, `rating`, `review`)
             VALUES (?, ?, ?, ?, ?)",
            [$bookingId, $roomId, $userId, $rating, $review],
            'iiiis'
        );
    }
    
    public static function getUnread() {
        return static::count('`seen` = 0');
    }
    
    public static function markSeen($id) {
        return static::db()->update(
            "UPDATE `rating_review` SET `seen` = 1 WHERE `sr_no` = ?",
            [$id], 'i'
        );
    }
    
    public static function getAll() {
        $result = static::db()->select(
            "SELECT rr.*, uc.name AS uname
             FROM `rating_review` rr
             INNER JOIN `user_cred` uc ON rr.user_id = uc.id
             ORDER BY rr.sr_no DESC"
        );
        return static::fetchAll($result);
    }
}
