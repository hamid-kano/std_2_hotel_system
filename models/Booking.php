<?php
/**
 * Booking Model
 * Handles all booking-related database operations
 */

class Booking extends Model {
    protected static $table = 'booking_order';
    protected static $primaryKey = 'booking_id';
    
    const STATUS_BOOKED    = 'booked';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED    = 'failed';
    
    public static function getUserBookings($userId, $limit = BOOKINGS_PER_PAGE, $offset = 0) {
        $result = static::db()->select(
            "SELECT bo.*, bd.*
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             WHERE bo.booking_status IN ('booked','cancelled','failed')
             AND bo.user_id = ?
             ORDER BY bo.booking_id DESC
             LIMIT ? OFFSET ?",
            [$userId, $limit, $offset],
            'iii'
        );
        return static::fetchAll($result);
    }
    
    public static function countUserBookings($userId) {
        return static::count(
            "booking_status IN ('booked','cancelled','failed') AND user_id = ?",
            [$userId], 'i'
        );
    }
    
    public static function findWithDetails($bookingId) {
        $result = static::db()->select(
            "SELECT bo.*, bd.*, uc.email
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             INNER JOIN `user_cred` uc ON bo.user_id = uc.id
             WHERE bo.booking_id = ?",
            [$bookingId], 'i'
        );
        return static::fetchOne($result);
    }
    
    public static function create($orderData, $detailsData) {
        $db = static::db();
        
        // Insert booking order
        $bookingId = $db->insert(
            "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `booking_status`, `order_id`, `total_pay`)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$orderData['user_id'], $orderData['room_id'], $orderData['check_in'],
             $orderData['check_out'], $orderData['status'], $orderData['order_id'], $orderData['total_pay']],
            'iissss'
        );
        
        if (!$bookingId) return false;
        
        // Insert booking details
        $db->insert(
            "INSERT INTO `booking_details`(`booking_id`, `user_name`, `phonenum`, `address`, `room_name`, `price`)
             VALUES (?, ?, ?, ?, ?, ?)",
            [$bookingId, $detailsData['user_name'], $detailsData['phonenum'],
             $detailsData['address'], $detailsData['room_name'], $detailsData['price']],
            'issssi'
        );
        
        return $bookingId;
    }
    
    public static function cancel($bookingId, $userId) {
        return static::db()->update(
            "UPDATE `booking_order` SET `booking_status` = 'cancelled', `refund` = 0
             WHERE `booking_id` = ? AND `user_id` = ?",
            [$bookingId, $userId], 'ii'
        );
    }
    
    public static function confirmArrival($bookingId) {
        return static::db()->update(
            "UPDATE `booking_order` SET `arrival` = 1 WHERE `booking_id` = ?",
            [$bookingId], 'i'
        );
    }
    
    public static function processRefund($bookingId) {
        return static::db()->update(
            "UPDATE `booking_order` SET `refund` = 1 WHERE `booking_id` = ?",
            [$bookingId], 'i'
        );
    }
    
    public static function getNewBookings() {
        $result = static::db()->select(
            "SELECT bo.*, bd.*
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             WHERE bo.booking_status = 'booked' AND bo.arrival = 0
             ORDER BY bo.booking_id DESC"
        );
        return static::fetchAll($result);
    }
    
    public static function getRefundBookings() {
        $result = static::db()->select(
            "SELECT bo.*, bd.*
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             WHERE bo.booking_status = 'cancelled' AND bo.refund = 0
             ORDER BY bo.booking_id DESC"
        );
        return static::fetchAll($result);
    }
    
    public static function getRecords($search = '', $limit = 30, $offset = 0) {
        $searchParam = "%$search%";
        $result = static::db()->select(
            "SELECT bo.*, bd.*
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             WHERE (bo.booking_status = 'booked' AND bo.arrival = 1)
                OR (bo.booking_status = 'cancelled' AND bo.refund = 1)
                OR bo.booking_status = 'failed'
             AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
             ORDER BY bo.booking_id DESC
             LIMIT ? OFFSET ?",
            [$searchParam, $searchParam, $searchParam, $limit, $offset],
            'sssii'
        );
        return static::fetchAll($result);
    }
    
    public static function getAnalytics($period = 30) {
        $dateFilter = $period === 'all' ? '' : "AND bo.datentime >= DATE_SUB(NOW(), INTERVAL $period DAY)";
        
        $result = static::db()->select(
            "SELECT
                COUNT(*) AS total_bookings,
                SUM(CASE WHEN booking_status = 'booked' THEN 1 ELSE 0 END) AS active_bookings,
                SUM(CASE WHEN booking_status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled_bookings,
                SUM(CASE WHEN booking_status = 'booked' THEN total_pay ELSE 0 END) AS active_amount,
                SUM(CASE WHEN booking_status = 'cancelled' THEN total_pay ELSE 0 END) AS cancelled_amount,
                SUM(total_pay) AS total_amount
             FROM `booking_order` bo WHERE 1=1 $dateFilter"
        );
        return static::fetchOne($result);
    }
    
    public static function getPendingCounts() {
        $result = static::db()->select(
            "SELECT
                COUNT(CASE WHEN booking_status = 'booked' AND arrival = 0 THEN 1 END) AS new_bookings,
                COUNT(CASE WHEN booking_status = 'cancelled' AND refund = 0 THEN 1 END) AS refund_bookings
             FROM `booking_order`"
        );
        return static::fetchOne($result);
    }
    
    public static function generateOrderId() {
        return 'ORD-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();
    }
}
