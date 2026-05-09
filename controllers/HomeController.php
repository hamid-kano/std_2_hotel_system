<?php
/**
 * Home Controller
 * Handles main pages: home, about, contact, facilities
 */

class HomeController extends BaseController {
    
    public function index() {
        $rooms      = Model::fetchAll(Room::getActiveLimit(3));
        $ids        = array_column($rooms, 'id');
        $features   = Room::bulkGetFeatures($ids);
        $facilities = Room::bulkGetFacilities($ids);
        $thumbnails = Room::bulkGetThumbnails($ids);
        $ratings    = Room::bulkGetRatings($ids);
        
        $carouselResult = Database::getInstance()->selectAll('carousel');
        $carousel = Model::fetchAll($carouselResult);
        
        $facilitiesResult = Facility::getLimit(5);
        $facilitiesList   = Model::fetchAll($facilitiesResult);
        
        $testimonials = Review::getLatest(6);
        $maxGuests    = Room::getMaxGuests();
        
        $settings = Cache::remember('settings_1', 300, fn() => Setting::get());
        $contact  = Cache::remember('contact_1',  300, fn() => Setting::getContact());
        
        $this->view('pages/home', compact(
            'rooms', 'features', 'facilities', 'thumbnails', 'ratings',
            'carousel', 'facilitiesList', 'testimonials', 'maxGuests',
            'settings', 'contact'
        ));
    }
    
    public function about() {
        $teamResult = Database::getInstance()->selectAll('team_members');
        $team       = Model::fetchAll($teamResult);
        $settings   = Cache::remember('settings_1', 300, fn() => Setting::get());
        $contact    = Cache::remember('contact_1',  300, fn() => Setting::getContact());
        $this->view('pages/about', compact('team', 'settings', 'contact'));
    }
    
    public function facilities() {
        $facilitiesResult = Facility::getActive();
        $facilities = Model::fetchAll($facilitiesResult);
        $settings   = Cache::remember('settings_1', 300, fn() => Setting::get());
        $contact    = Cache::remember('contact_1',  300, fn() => Setting::getContact());
        $this->view('pages/facilities', compact('facilities', 'settings', 'contact'));
    }
    
    public function contact() {
        $settings = Cache::remember('settings_1', 300, fn() => Setting::get());
        $contact  = Cache::remember('contact_1',  300, fn() => Setting::getContact());
        
        if (Request::isPost()) {
            $data = [
                'name'    => $this->post('name'),
                'email'   => $this->post('email'),
                'subject' => $this->post('subject'),
                'message' => $this->post('message'),
            ];
            
            $result = Database::getInstance()->insert(
                "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)",
                array_values($data),
                'ssss'
            );
            
            Session::flash('contact_status', $result ? 'success' : 'error');
            $this->redirect(SITE_URL . 'contact');
        }
        
        $this->view('pages/contact', compact('contact', 'settings'));
    }
    
    public function setLang() {
        $lang = Request::get('set_lang', DEFAULT_LANG);
        Session::setLang($lang);
        
        $referer = strtok($_SERVER['HTTP_REFERER'] ?? SITE_URL, '?');
        $this->redirect($referer);
    }
}
