<?php
class AdminDashboardController extends AdminBaseController {

    public function index() {
        $db = Database::getInstance();

        $pending = Booking::getPendingCounts();

        $unreadQueries = Model::fetchOne($db->select(
            "SELECT COUNT(sr_no) AS count FROM `user_queries` WHERE `seen`=0"
        ))['count'] ?? 0;

        $unreadReviews = Model::fetchOne($db->select(
            "SELECT COUNT(sr_no) AS count FROM `rating_review` WHERE `seen`=0"
        ))['count'] ?? 0;

        $users = User::getStats();

        // Default analytics (last 30 days)
        $analytics = $this->fetchBookingAnalytics(1);
        $activity   = $this->fetchUserAnalytics(1);

        $this->adminView('dashboard', compact(
            'pending', 'unreadQueries', 'unreadReviews',
            'users', 'analytics', 'activity'
        ));
    }

    // Called via POST form for period change (traditional form submit)
    public function analytics() {
        $period   = (int)Request::post('period', 1);
        $type     = Request::post('type', 'booking');
        $pending  = Booking::getPendingCounts();
        $users    = User::getStats();
        $db       = Database::getInstance();

        $unreadQueries = Model::fetchOne($db->select(
            "SELECT COUNT(sr_no) AS count FROM `user_queries` WHERE `seen`=0"
        ))['count'] ?? 0;
        $unreadReviews = Model::fetchOne($db->select(
            "SELECT COUNT(sr_no) AS count FROM `rating_review` WHERE `seen`=0"
        ))['count'] ?? 0;

        $analytics = $this->fetchBookingAnalytics($type === 'booking' ? $period : 1);
        $activity   = $this->fetchUserAnalytics($type === 'user' ? $period : 1);

        $this->adminView('dashboard', compact(
            'pending', 'unreadQueries', 'unreadReviews',
            'users', 'analytics', 'activity',
            'period', 'type'
        ));
    }

    private function fetchBookingAnalytics(int $period): array {
        $cond = match($period) {
            1 => "AND bo.datentime >= NOW() - INTERVAL 30 DAY",
            2 => "AND bo.datentime >= NOW() - INTERVAL 90 DAY",
            3 => "AND bo.datentime >= NOW() - INTERVAL 1 YEAR",
            default => ''
        };
        return Model::fetchOne(Database::getInstance()->select(
            "SELECT
                COUNT(CASE WHEN bo.booking_status != 'pending' THEN 1 END) AS total_bookings,
                SUM(CASE WHEN bo.booking_status != 'pending' THEN bd.total_pay END) AS total_pay,
                COUNT(CASE WHEN bo.booking_status='booked' AND bo.arrival=0 THEN 1 END) AS active_bookings,
                SUM(CASE WHEN bo.booking_status='booked' AND bo.arrival=0 THEN bd.total_pay END) AS active_amt,
                COUNT(CASE WHEN bo.booking_status='cancelled' AND bo.refund=1 THEN 1 END) AS cancelled_bookings,
                SUM(CASE WHEN bo.booking_status='cancelled' AND bo.refund=1 THEN bd.total_pay END) AS cancelled_amt
             FROM `booking_order` bo
             LEFT JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
             WHERE 1=1 $cond"
        )) ?? [];
    }

    private function fetchUserAnalytics(int $period): array {
        $cond = match($period) {
            1 => "WHERE datentime >= NOW() - INTERVAL 30 DAY",
            2 => "WHERE datentime >= NOW() - INTERVAL 90 DAY",
            3 => "WHERE datentime >= NOW() - INTERVAL 1 YEAR",
            default => ''
        };
        $db = Database::getInstance();
        return [
            'reviews' => Model::fetchOne($db->select("SELECT COUNT(sr_no) AS c FROM `rating_review` $cond"))['c'] ?? 0,
            'queries' => Model::fetchOne($db->select("SELECT COUNT(sr_no) AS c FROM `user_queries` $cond"))['c'] ?? 0,
            'new_reg' => Model::fetchOne($db->select("SELECT COUNT(id) AS c FROM `user_cred` $cond"))['c'] ?? 0,
        ];
    }
}
