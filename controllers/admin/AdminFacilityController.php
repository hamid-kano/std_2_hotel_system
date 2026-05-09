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
        $name_ar = $this->post('name_ar');
        $name_en = $this->post('name_en');
        $name_ku = $this->post('name_ku');
        
        if ($name_ar && $name_en && $name_ku) {
            $db = Database::getInstance();
            
            // Insert into features table (use English as default)
            $featureId = $db->insert("INSERT INTO `features`(name) VALUES (?)", [$name_en], 's');
            
            // Insert translations for all languages
            if ($featureId) {
                $db->insert(
                    "INSERT INTO `features_translations`(feature_id, lang, name) VALUES (?, 'ar', ?), (?, 'en', ?), (?, 'ku', ?)",
                    [$featureId, $name_ar, $featureId, $name_en, $featureId, $name_ku],
                    'isisisis'
                );
                Session::flash('success', lang('success_feat_added'));
            } else {
                Session::flash('error', lang('err_generic'));
            }
        } else {
            Session::flash('error', lang('err_fill_all_langs'));
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    public function removeFeature() {
        $id    = (int)$this->post('id');
        $inUse = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `room_features` WHERE features_id=?", [$id], 'i'
        ))['c'] ?? 0;

        if ($inUse > 0) {
            Session::flash('error', lang('err_feat_in_use'));
        } else {
            Database::getInstance()->delete("DELETE FROM `features` WHERE id=?", [$id], 'i');
            Session::flash('success', lang('success_feat_deleted'));
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    // ── Facilities ────────────────────────────────────────────
    public function addFacility() {
        if (!Request::hasFile('icon')) {
            Session::flash('error', lang('err_upload_icon'));
            $this->redirect(SITE_URL . 'admin/facilities');
        }
        
        $name_ar = $this->post('name_ar');
        $name_en = $this->post('name_en');
        $name_ku = $this->post('name_ku');
        $desc_ar = $this->post('desc_ar') ?: '';
        $desc_en = $this->post('desc_en') ?: '';
        $desc_ku = $this->post('desc_ku') ?: '';
        
        if (!$name_ar || !$name_en || !$name_ku) {
            Session::flash('error', lang('err_fill_all_names'));
            $this->redirect(SITE_URL . 'admin/facilities');
        }
        
        $filename = uploadImage(Request::file('icon'), FACILITIES_FOLDER);
        
        // Handle upload errors with translated messages
        if ($filename === 'inv_img') {
            Session::flash('error', lang('err_invalid_file_type'));
            $this->redirect(SITE_URL . 'admin/facilities');
        } elseif ($filename === 'inv_size') {
            Session::flash('error', lang('err_file_too_large'));
            $this->redirect(SITE_URL . 'admin/facilities');
        } elseif ($filename === 'upd_failed' || $filename === 'upload_error') {
            Session::flash('error', lang('err_upload_failed'));
            $this->redirect(SITE_URL . 'admin/facilities');
        }
        
        $db = Database::getInstance();
        
        // Insert into facilities table (use English as default)
        $facilityId = $db->insert(
            "INSERT INTO `facilities`(icon,name,description) VALUES (?,?,?)",
            [$filename, $name_en, $desc_en], 'sss'
        );
        
        // Insert translations for all languages
        if ($facilityId) {
            $db->insert(
                "INSERT INTO `facilities_translations`(facility_id, lang, name, description) VALUES (?, 'ar', ?, ?), (?, 'en', ?, ?), (?, 'ku', ?, ?)",
                [$facilityId, $name_ar, $desc_ar, $facilityId, $name_en, $desc_en, $facilityId, $name_ku, $desc_ku],
                'ississississ'
            );
            Session::flash('success', lang('admin_facility_added'));
        } else {
            Session::flash('error', lang('err_generic'));
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }

    public function removeFacility() {
        $id    = (int)$this->post('id');
        $inUse = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `room_facilities` WHERE facilities_id=?", [$id], 'i'
        ))['c'] ?? 0;

        if ($inUse > 0) {
            Session::flash('error', lang('err_fac_in_use'));
        } else {
            $img = Model::fetchOne(Database::getInstance()->select(
                "SELECT icon FROM `facilities` WHERE id=?", [$id], 'i'
            ));
            if ($img) deleteImage($img['icon'], FACILITIES_FOLDER);
            Database::getInstance()->delete("DELETE FROM `facilities` WHERE id=?", [$id], 'i');
            Session::flash('success', lang('success_fac_deleted'));
        }
        $this->redirect(SITE_URL . 'admin/facilities');
    }
}
