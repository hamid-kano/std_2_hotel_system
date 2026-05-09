<?php
/**
 * Room Controller
 * Handles room listing, search, and details
 */

class RoomController extends BaseController {
    
    public function index() {
        $rooms = Model::fetchAll(Room::getActive());
        $ids   = array_column($rooms, 'id');
        
        $features   = Room::bulkGetFeatures($ids);
        $facilities = Room::bulkGetFacilities($ids);
        $thumbnails = Room::bulkGetThumbnails($ids);
        $ratings    = Room::bulkGetRatings($ids);
        $maxGuests  = Room::getMaxGuests();
        $facilities_list = Model::fetchAll(Facility::getActive());
        
        $this->view('pages/rooms', compact(
            'rooms', 'features', 'facilities', 'thumbnails',
            'ratings', 'maxGuests', 'facilities_list'
        ));
    }
    
    public function search() {
        if (!isset($_GET['fetch_rooms'])) exit;
        
        $chkAvail  = json_decode(Request::get('chk_avail', '{}'), true);
        $guests    = json_decode(Request::get('guests', '{}'), true);
        $facFilter = json_decode(Request::get('facility_list', '{"facilities":[]}'), true);
        
        $checkIn  = $chkAvail['checkin']  ?? '';
        $checkOut = $chkAvail['checkout'] ?? '';
        $adults   = max(0, (int)($guests['adults']   ?? 0));
        $children = max(0, (int)($guests['children'] ?? 0));
        
        // Validate dates
        if ($checkIn && $checkOut) {
            $today    = new DateTime(date('Y-m-d'));
            $ciDate   = new DateTime($checkIn);
            $coDate   = new DateTime($checkOut);
            
            if ($ciDate >= $coDate || $ciDate < $today) {
                echo "<div class='empty-state'><i class='bi bi-calendar-x'></i><p>Invalid dates.</p></div>";
                exit;
            }
        }
        
        $roomsResult = Room::search($adults, $children);
        $rooms = Model::fetchAll($roomsResult);
        
        if (empty($rooms)) {
            echo "<div class='empty-state'><i class='bi bi-door-closed'></i><p>No rooms available.</p></div>";
            exit;
        }
        
        $ids = array_column($rooms, 'id');
        $features   = Room::bulkGetFeatures($ids);
        $facilities = Room::bulkGetFacilities($ids);
        $thumbnails = Room::bulkGetThumbnails($ids);
        $avail      = ($checkIn && $checkOut) ? Room::bulkGetAvailability($ids, $checkIn, $checkOut) : [];
        
        $selectedFacs = $facFilter['facilities'] ?? [];
        $login = Auth::isUserLoggedIn() ? 1 : 0;
        $output = '';
        $count  = 0;
        
        foreach ($rooms as $room) {
            $rid = $room['id'];
            
            // Facility filter
            if (!empty($selectedFacs)) {
                $roomFacIds = array_column($facilities[$rid] ?? [], 'id');
                foreach ($selectedFacs as $sf) {
                    if (!in_array($sf, $roomFacIds)) continue 2;
                }
            }
            
            // Availability filter
            if ($checkIn && $checkOut) {
                $booked = $avail[$rid] ?? 0;
                if (($room['quantity'] - $booked) <= 0) continue;
            }
            
            $featHtml = '';
            foreach ($features[$rid] ?? [] as $feat) {
                $featName = getTranslation('features_translations', $feat['id'], 'name', $feat['name']);
                $featHtml .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$featName</span> ";
            }
            
            $facHtml = '';
            foreach ($facilities[$rid] ?? [] as $f) {
                $facName = getTranslation('facilities_translations', $f['id'], 'name', $f['name']);
                $facHtml .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>$facName</span> ";
            }
            
            $thumb = $thumbnails[$rid] ?? ROOMS_IMG_PATH . 'thumbnail.jpg';
            $roomName = getTranslation('rooms_translations', $rid, 'name', $room['name']);
            
            $bookBtn = "<button onclick='checkLoginToBook($login,$rid)'
                            class='btn btn-sm w-100 text-white custom-bg shadow-none mb-2'>
                            " . lang('book_now') . "
                        </button>";
            
            $output .= "
                <div class='card room-card mb-4'>
                    <div class='row g-0 p-3 align-items-center'>
                        <div class='col-md-4 mb-lg-0 mb-3'>
                            <img src='$thumb' class='img-fluid rounded' alt='$roomName' loading='lazy'>
                        </div>
                        <div class='col-md-6 px-lg-3 px-md-3 px-0'>
                            <h5 class='mb-2 fw-bold'>$roomName</h5>
                            <div class='features mb-2'>
                                <small class='fw-bold text-muted text-uppercase'>Features</small><br>$featHtml
                            </div>
                            <div class='facilities mb-2'>
                                <small class='fw-bold text-muted text-uppercase'>Facilities</small><br>$facHtml
                            </div>
                            <div class='guests'>
                                <small class='fw-bold text-muted text-uppercase'>Guests</small><br>
                                <span class='badge rounded-pill text-bg-light'>{$room['adult']} Adults</span>
                                <span class='badge rounded-pill text-bg-light'>{$room['children']} Children</span>
                            </div>
                        </div>
                        <div class='col-md-2 mt-lg-0 mt-4 text-center'>
                            <h6 class='mb-3'>{$room['price']} " . lang('per_night') . "</h6>
                            $bookBtn
                            <a href='" . SITE_URL . "room/{$rid}' class='btn btn-sm w-100 btn-outline-dark shadow-none'>
                                " . lang('room_details') . "
                            </a>
                        </div>
                    </div>
                </div>";
            $count++;
        }
        
        echo $count > 0 ? $output
            : "<div class='empty-state'><i class='bi bi-search'></i><p>No rooms match your filters.</p></div>";
    }
    
    public function show($id) {
        $room = Room::getWithDetails((int)$id);
        if (!$room) Response::notFound();
        
        $reviews = Review::getForRoom((int)$id);
        $this->view('pages/room_details', compact('room', 'reviews'));
    }
}
