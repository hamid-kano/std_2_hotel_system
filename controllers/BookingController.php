<?php
/**
 * Booking Controller
 * Handles booking flow: confirm, pay, cancel
 */

class BookingController extends BaseController {
    
    public function index() {
        $this->requireAuth();
        
        $userId = Auth::userId();
        $page   = max(1, (int)Request::get('page', 1));
        $offset = ($page - 1) * BOOKINGS_PER_PAGE;
        
        $bookings    = Booking::getUserBookings($userId, BOOKINGS_PER_PAGE, $offset);
        $totalRows   = Booking::countUserBookings($userId);
        $totalPages  = ceil($totalRows / BOOKINGS_PER_PAGE);
        
        $this->view('pages/bookings', compact('bookings', 'page', 'totalPages'));
    }
    
    public function confirm() {
        $this->requireAuth();
        
        $id = (int)Request::get('id');
        if (!$id) $this->redirect(SITE_URL . 'rooms');
        
        $room = Room::find($id);
        if (!$room || !$room['status'] || $room['removed']) {
            $this->redirect(SITE_URL . 'rooms');
        }
        
        // Store room in session for payment
        Session::set('room', [
            'id'        => $room['id'],
            'name'      => $room['name'],
            'price'     => $room['price'],
            'available' => false,
        ]);
        
        $user      = User::find(Auth::userId());
        $thumbnail = Room::getThumbnail($id);
        $rating    = Room::getAverageRating($id);
        
        $this->view('pages/confirm_booking', compact('room', 'user', 'thumbnail', 'rating'));
    }
    
    public function checkAvailability() {
        if (!Request::isPost()) exit;
        
        $checkIn  = $this->post('check_in');
        $checkOut = $this->post('check_out');
        
        $today    = new DateTime(date('Y-m-d'));
        $ciDate   = new DateTime($checkIn);
        $coDate   = new DateTime($checkOut);
        
        if ($ciDate == $coDate) {
            $this->json(['status' => 'check_in_out_equal']);
        }
        
        if ($coDate < $ciDate) {
            $this->json(['status' => 'check_out_earlier']);
        }
        
        if ($ciDate < $today) {
            $this->json(['status' => 'check_in_earlier']);
        }
        
        $room = Session::get('room');
        if (!$room) {
            $this->json(['status' => 'session_expired']);
        }
        
        $available = Room::checkAvailability($room['id'], $checkIn, $checkOut);
        
        if (!$available) {
            $this->json(['status' => 'unavailable']);
        }
        
        $days    = date_diff($ciDate, $coDate)->days;
        $payment = $room['price'] * $days;
        
        // Update session
        $room['payment']   = $payment;
        $room['available'] = true;
        $room['check_in']  = $checkIn;
        $room['check_out'] = $checkOut;
        Session::set('room', $room);
        
        $this->json(['status' => 'available', 'days' => $days, 'payment' => $payment]);
    }
    
    public function pay() {
        $this->requireAuth();

        if (!Request::isPost()) {
            $this->redirect(SITE_URL . 'rooms');
        }

        $room = Session::get('room');
        if (!$room || !$room['available']) {
            $this->redirect(SITE_URL . 'rooms');
        }

        // Store guest details in session, then go to mock payment page
        Session::set('booking_guest', [
            'name'    => $this->post('name'),
            'phonenum'=> $this->post('phonenum'),
            'address' => $this->post('address'),
        ]);

        $this->redirect(SITE_URL . 'booking/payment');
    }

    public function paymentPage() {
        $this->requireAuth();

        $room  = Session::get('room');
        $guest = Session::get('booking_guest');

        if (!$room || !$room['available'] || !$guest) {
            $this->redirect(SITE_URL . 'rooms');
        }

        $this->view('pages/payment', compact('room', 'guest'));
    }

    public function processPayment() {
        $this->requireAuth();

        if (!Request::isPost()) {
            $this->redirect(SITE_URL . 'rooms');
        }

        $room  = Session::get('room');
        $guest = Session::get('booking_guest');

        if (!$room || !$room['available'] || !$guest) {
            $this->redirect(SITE_URL . 'rooms');
        }

        $cardNumber = $this->post('card_number');
        $cleanCard  = preg_replace('/\s+/', '', $cardNumber);

        if (str_starts_with($cleanCard, '0000')) {
            Session::set('payment_error', 'Card declined. Please try another card.');
            $this->redirect(SITE_URL . 'booking/payment');
        }

        $userId   = Auth::userId();
        $orderId  = Booking::generateOrderId();

        $bookingId = Booking::create(
            [
                'user_id'   => $userId,
                'room_id'   => $room['id'],
                'check_in'  => $room['check_in'],
                'check_out' => $room['check_out'],
                'status'    => Booking::STATUS_BOOKED,
                'order_id'  => $orderId,
                'total_pay' => $room['payment'],
            ],
            [
                'user_name' => $guest['name'],
                'phonenum'  => $guest['phonenum'],
                'address'   => $guest['address'],
                'room_name' => $room['name'],
                'price'     => $room['price'],
            ]
        );

        if (!$bookingId) {
            Session::set('payment_error', 'Booking failed. Please try again.');
            $this->redirect(SITE_URL . 'booking/payment');
        }

        Session::remove('room');
        Session::remove('booking_guest');

        $this->redirect(SITE_URL . 'booking/success?order=' . $orderId);
    }

    public function paymentSuccess() {
        $this->requireAuth();

        $orderId = Request::get('order');
        if (!$orderId) $this->redirect(SITE_URL . 'bookings');

        $result = Database::getInstance()->select(
            "SELECT bo.*, bd.*, uc.email
             FROM `booking_order` bo
             INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
             INNER JOIN `user_cred` uc ON bo.user_id = uc.id
             WHERE bo.order_id = ? AND bo.user_id = ? LIMIT 1",
            [$orderId, Auth::userId()], 'si'
        );
        $booking = Model::fetchOne($result);

        if (!$booking) $this->redirect(SITE_URL . 'bookings');

        $this->view('pages/payment_success', compact('booking'));
    }
    
    public function cancel() {
        $this->requireAuth();

        if (!Request::isPost()) {
            $this->redirect(SITE_URL . 'bookings');
        }

        $bookingId = (int)$this->post('id');
        Booking::cancel($bookingId, Auth::userId());
        $this->redirect(SITE_URL . 'bookings');
    }

    public function review() {
        $this->requireAuth();

        if (!Request::isPost()) {
            $this->redirect(SITE_URL . 'bookings');
        }

        $bookingId = (int)$this->post('booking_id');
        $roomId    = (int)$this->post('room_id');
        $rating    = (int)$this->post('rating');
        $review    = $this->post('review');

        Review::add($bookingId, $roomId, Auth::userId(), $rating, $review);
        $this->redirect(SITE_URL . 'bookings');
    }
}
