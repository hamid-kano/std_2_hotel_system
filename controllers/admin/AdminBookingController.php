<?php
class AdminBookingController extends AdminBaseController {

    // ── New Bookings ──────────────────────────────────────────
    public function newBookings() {
        $search   = Request::get('search', '');
        $bookings = $this->fetchNewBookings($search);
        $this->adminView('new_bookings', compact('bookings', 'search'));
    }

    public function assignRoom() {
        $bookingId = (int)Request::post('booking_id');
        $roomNo    = $this->post('room_no');

        if ($bookingId && $roomNo) {
            Database::getInstance()->update(
                "UPDATE `booking_order` bo
                 INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                 SET bo.arrival=1, bo.rate_review=0, bd.room_no=?
                 WHERE bo.booking_id=?",
                [$roomNo, $bookingId], 'si'
            );
            Session::flash('success', 'Room assigned successfully.');
        }
        $this->redirect(SITE_URL . 'admin/bookings/new');
    }

    public function cancelBooking() {
        $bookingId = (int)Request::post('booking_id');
        if ($bookingId) {
            Database::getInstance()->update(
                "UPDATE `booking_order` SET `booking_status`='cancelled', `refund`=0 WHERE `booking_id`=?",
                [$bookingId], 'i'
            );
            Session::flash('success', 'Booking cancelled.');
        }
        $this->redirect(SITE_URL . 'admin/bookings/new');
    }

    private function fetchNewBookings(string $search): array {
        $s = "%$search%";
        return Model::fetchAll(Database::getInstance()->select(
            "SELECT bo.*, bd.* FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
             WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
             AND bo.booking_status='booked' AND bo.arrival=0
             ORDER BY bo.booking_id ASC",
            [$s, $s, $s], 'sss'
        ));
    }

    // ── Refund Bookings ───────────────────────────────────────
    public function refundBookings() {
        $search   = Request::get('search', '');
        $bookings = $this->fetchRefundBookings($search);
        $this->adminView('refund_bookings', compact('bookings', 'search'));
    }

    public function processRefund() {
        $bookingId = (int)Request::post('booking_id');
        if ($bookingId) {
            $db      = Database::getInstance();
            $booking = Model::fetchOne($db->select(
                "SELECT bo.user_id, bd.total_pay FROM `booking_order` bo
                 JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                 WHERE bo.booking_id=?", [$bookingId], 'i'
            ));
            if ($booking) {
                $db->update("UPDATE `booking_order` SET `refund`=1 WHERE `booking_id`=?", [$bookingId], 'i');
                $db->update("UPDATE `balances` SET `balance`=`balance`+? WHERE `user_id`=?",
                    [$booking['total_pay'], $booking['user_id']], 'di');
                Session::flash('success', 'Refund processed successfully.');
            }
        }
        $this->redirect(SITE_URL . 'admin/bookings/refunds');
    }

    private function fetchRefundBookings(string $search): array {
        $s = "%$search%";
        return Model::fetchAll(Database::getInstance()->select(
            "SELECT bo.*, bd.* FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
             WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
             AND bo.booking_status='cancelled' AND bo.refund=0
             ORDER BY bo.booking_id ASC",
            [$s, $s, $s], 'sss'
        ));
    }

    // ── Booking Records ───────────────────────────────────────
    public function records() {
        $search   = Request::get('search', '');
        $page     = max(1, (int)Request::get('page', 1));
        $perPage  = 20;
        $offset   = ($page - 1) * $perPage;
        $s        = "%$search%";

        $total = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
             WHERE ((bo.booking_status='booked' AND bo.arrival=1)
                OR (bo.booking_status='cancelled' AND bo.refund=1)
                OR bo.booking_status='failed')
             AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)",
            [$s, $s, $s], 'sss'
        ))['c'] ?? 0;

        $bookings = Model::fetchAll(Database::getInstance()->select(
            "SELECT bo.*, bd.* FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
             WHERE ((bo.booking_status='booked' AND bo.arrival=1)
                OR (bo.booking_status='cancelled' AND bo.refund=1)
                OR bo.booking_status='failed')
             AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
             ORDER BY bo.booking_id DESC LIMIT ? OFFSET ?",
            [$s, $s, $s, $perPage, $offset], 'sssii'
        ));

        $totalPages = ceil($total / $perPage);
        $this->adminView('booking_records', compact('bookings', 'search', 'page', 'totalPages'));
    }
}
