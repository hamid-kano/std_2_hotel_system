<?php
class AdminFacilityController extends AdminBaseController {

    public function index() {
        $features   = Model::fetchAll(Database::getInstance()->selectAll('features'));
        $facilities = Model::fetchAll(Database::getInstance()->selectAll('facilities'));
        $flash = Session::flash('success');
        $error = Session::flash('error');
        $this->adminView('facilities', compact('features', 'facilities', 'flash', 'error'));
    }

    // ── Features ──────────────────────────────────────────────
    public function addFeature() {
        $name = $this->post('name');
        if ($name) {
            Database::getInstance()->insert("INSERT INTO `features`(name) VALUES (?)", [$name], 's');
            Session::flash('success', "Feature \"$name\" added.");
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    public function removeFeature() {
        $id    = (int)$this->post('id');
        $inUse = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `room_features` WHERE features_id=?", [$id], 'i'
        ))['c'] ?? 0;

        if ($inUse > 0) {
            Session::flash('error', 'Cannot delete — feature is used by a room.');
        } else {
            Database::getInstance()->delete("DELETE FROM `features` WHERE id=?", [$id], 'i');
            Session::flash('success', 'Feature deleted.');
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    // ── Facilities ────────────────────────────────────────────
    public function addFacility() {
        if (!Request::hasFile('icon')) {
            Session::flash('error', 'Please upload an icon.');
            $this->redirect(SITE_URL . 'admin/facilities');
        }
        $filename = uploadImage(Request::file('icon'), FACILITIES_FOLDER);
        if (in_array($filename, ['inv_img', 'inv_size', 'upd_failed'])) {
            Session::flash('error', "Upload failed: $filename");
            $this->redirect(SITE_URL . 'admin/facilities');
        }
        Database::getInstance()->insert(
            "INSERT INTO `facilities`(icon,name,description) VALUES (?,?,?)",
            [$filename, $this->post('name'), $this->post('desc')], 'sss'
        );
        Session::flash('success', 'Facility added.');
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    public function removeFacility() {
        $id    = (int)$this->post('id');
        $inUse = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `room_facilities` WHERE facilities_id=?", [$id], 'i'
        ))['c'] ?? 0;

        if ($inUse > 0) {
            Session::flash('error', 'Cannot delete — facility is used by a room.');
        } else {
            $img = Model::fetchOne(Database::getInstance()->select(
                "SELECT icon FROM `facilities` WHERE id=?", [$id], 'i'
            ));
            if ($img) deleteImage($img['icon'], FACILITIES_FOLDER);
            Database::getInstance()->delete("DELETE FROM `facilities` WHERE id=?", [$id], 'i');
            Session::flash('success', 'Facility deleted.');
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }
}
