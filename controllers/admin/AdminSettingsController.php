<?php
class AdminSettingsController extends AdminBaseController {

    public function index() {
        $general  = Setting::get();
        $contacts = Setting::getContact();
        $members  = Model::fetchAll(Database::getInstance()->selectAll('team_members'));
        $flash    = Session::flash('success');
        $error    = Session::flash('error');
        $this->adminView('settings', compact('general', 'contacts', 'members', 'flash', 'error'));
    }

    public function updateGeneral() {
        Database::getInstance()->update(
            "UPDATE `settings` SET `site_title`=?,`site_about`=? WHERE `sr_no`=1",
            [$this->post('site_title'), $this->post('site_about')], 'ss'
        );
        Cache::forget('settings_1');
        Session::flash('success', 'General settings saved.');
        $this->redirect(SITE_URL . 'admin/settings');
    }

    public function updateContacts() {
        $fields = ['address','gmap','pn1','pn2','email','fb','insta','tw','iframe'];
        $values = array_map(fn($f) => $this->post($f) ?? '', $fields);
        $values[] = 1;
        Database::getInstance()->update(
            "UPDATE `contact_details` SET
             `address`=?,`gmap`=?,`pn1`=?,`pn2`=?,`email`=?,`fb`=?,`insta`=?,`tw`=?,`iframe`=?
             WHERE `sr_no`=?",
            $values, 'sssssssssi'
        );
        Cache::forget('contact_1');
        Session::flash('success', 'Contact details saved.');
        $this->redirect(SITE_URL . 'admin/settings');
    }

    public function addMember() {
        if (!Request::hasFile('picture')) {
            Session::flash('error', 'Please upload a photo.');
            $this->redirect(SITE_URL . 'admin/settings');
        }
        $filename = uploadImage(Request::file('picture'), ABOUT_FOLDER);
        if (in_array($filename, ['inv_img', 'inv_size', 'upd_failed'])) {
            Session::flash('error', "Upload failed: $filename");
            $this->redirect(SITE_URL . 'admin/settings');
        }
        Database::getInstance()->insert(
            "INSERT INTO `team_members`(name,picture) VALUES (?,?)",
            [$this->post('name'), $filename], 'ss'
        );
        Session::flash('success', 'Team member added.');
        $this->redirect(SITE_URL . 'admin/settings');
    }

    public function removeMember() {
        $id  = (int)$this->post('id');
        $img = Model::fetchOne(Database::getInstance()->select(
            "SELECT picture FROM `team_members` WHERE sr_no=?", [$id], 'i'
        ));
        if ($img) deleteImage($img['picture'], ABOUT_FOLDER);
        Database::getInstance()->delete("DELETE FROM `team_members` WHERE sr_no=?", [$id], 'i');
        Session::flash('success', 'Member removed.');
        $this->redirect(SITE_URL . 'admin/settings');
    }

    // ── Carousel ──────────────────────────────────────────────
    public function carousel() {
        $images = Model::fetchAll(Database::getInstance()->selectAll('carousel'));
        $flash  = Session::flash('success');
        $error  = Session::flash('error');
        $this->adminView('carousel', compact('images', 'flash', 'error'));
    }

    public function addCarousel() {
        if (!Request::hasFile('picture')) {
            Session::flash('error', 'Please select an image.');
            $this->redirect(SITE_URL . 'admin/carousel');
        }
        $filename = uploadImage(Request::file('picture'), CAROUSEL_FOLDER);
        if (in_array($filename, ['inv_img', 'inv_size', 'upd_failed'])) {
            Session::flash('error', "Upload failed: $filename");
            $this->redirect(SITE_URL . 'admin/carousel');
        }
        Database::getInstance()->insert("INSERT INTO `carousel`(image) VALUES (?)", [$filename], 's');
        Session::flash('success', 'Image added.');
        $this->redirect(SITE_URL . 'admin/carousel');
    }

    public function removeCarousel() {
        $id  = (int)$this->post('id');
        $img = Model::fetchOne(Database::getInstance()->select(
            "SELECT image FROM `carousel` WHERE sr_no=?", [$id], 'i'
        ));
        if ($img) deleteImage($img['image'], CAROUSEL_FOLDER);
        Database::getInstance()->delete("DELETE FROM `carousel` WHERE sr_no=?", [$id], 'i');
        Session::flash('success', 'Image deleted.');
        $this->redirect(SITE_URL . 'admin/carousel');
    }
}
