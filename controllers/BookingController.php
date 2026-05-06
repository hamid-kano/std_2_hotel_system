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
        
        $userId  = Auth::userId();
        $balance = User::getBalance($userId);
        
        if ($balance < $room['payment']) {
            Session::flash('error', 'Insufficient balance');
            $this->redirect(SITE_URL . 'booking/confirm?id=' . $room['id']);
        }
        
        $orderId = Booking::generateOrderId();
        
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
                'user_name' => $this->post('name'),
                'phonenum'  => $this->post('phonenum'),
                'address'   => $this->post('address'),
                'room_name' => $room['name'],
                'price'     => $room['price'],
            ]
        );
        
        if (!$bookingId) {
            Session::flash('error', 'Booking failed. Please try again.');
            $this->redirect(SITE_URL . 'booking/confirm?id=' . $room['id']);
        }
        
        User::deductBalance($userId, $room['payment']);
        Session::remove('room');
        
        $this->redirect(SITE_URL . 'bookings?success=1');
    }
    
    public function cancel() {
        $this->requireAuth();
        
        if (!Request::isPost()) exit;
        
        $bookingId = (int)$this->post('id');
        $userId    = Auth::userId();
        
        $result = Booking::cancel($bookingId, $userId);
        echo $result ? 1 : 0;
    }
    
    public function review() {
        $this->requireAuth();
        
        if (!Request::isPost()) exit;
        
        $bookingId = (int)$this->post('booking_id');
        $roomId    = (int)$this->post('room_id');
        $rating    = (int)$this->post('rating');
        $review    = $this->post('review');
        $userId    = Auth::userId();
        
        $result = Review::add($bookingId, $roomId, $userId, $rating, $review);
        echo $result ? 1 : 0;
    }
}
