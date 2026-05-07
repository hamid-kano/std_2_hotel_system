<?php
class AdminRoomController extends AdminBaseController {

    public function index() {
        $rooms      = Model::fetchAll(Database::getInstance()->select(
            "SELECT * FROM `rooms` WHERE `removed`=0 ORDER BY `id` DESC"
        ));
        $features   = Model::fetchAll(Database::getInstance()->selectAll('features'));
        $facilities = Model::fetchAll(Database::getInstance()->selectAll('facilities'));
        $flash      = Session::flash('success');
        $error      = Session::flash('error');
        $this->adminView('rooms', compact('rooms', 'features', 'facilities', 'flash', 'error'));
    }

    public function addRoom() {
        $features   = array_map('intval', json_decode($this->post('features') ?? '[]', true));
        $facilities = array_map('intval', json_decode($this->post('facilities') ?? '[]', true));

        $roomId = Database::getInstance()->insert(
            "INSERT INTO `rooms`(`name`,`area`,`price`,`quantity`,`adult`,`children`,`description`)
             VALUES (?,?,?,?,?,?,?)",
            [$this->post('name'), (int)$this->post('area'), (int)$this->post('price'),
             (int)$this->post('quantity'), (int)$this->post('adult'),
             (int)$this->post('children'), $this->post('desc')],
            'siiiiis'
        );

        if ($roomId) {
            Room::syncFeatures($roomId, $features);
            Room::syncFacilities($roomId, $facilities);
            Session::flash('success', 'Room added successfully.');
        } else {
            Session::flash('error', 'Failed to add room.');
        }
        $this->redirect(SITE_URL . 'admin/rooms');
    }

    public function editRoom() {
        $id         = (int)$this->post('room_id');
        $features   = array_map('intval', json_decode($this->post('features') ?? '[]', true));
        $facilities = array_map('intval', json_decode($this->post('facilities') ?? '[]', true));

        Database::getInstance()->update(
            "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=?
             WHERE `id`=?",
            [$this->post('name'), (int)$this->post('area'), (int)$this->post('price'),
             (int)$this->post('quantity'), (int)$this->post('adult'),
             (int)$this->post('children'), $this->post('desc'), $id],
            'siiiiisi'
        );
        Room::syncFeatures($id, $features);
        Room::syncFacilities($id, $facilities);

        Session::flash('success', 'Room updated.');
        $this->redirect(SITE_URL . 'admin/rooms');
    }

    public function toggleStatus() {
        $id     = (int)$this->post('room_id');
        $status = (int)$this->post('status');
        Room::toggleStatus($id, $status);
        $this->redirect(SITE_URL . 'admin/rooms');
    }

    public function removeRoom() {
        $id     = (int)$this->post('room_id');
        $images = Model::fetchAll(Database::getInstance()->select(
            "SELECT image FROM `room_images` WHERE room_id=?", [$id], 'i'
        ));
        foreach ($images as $img) deleteImage($img['image'], ROOMS_FOLDER);
        Database::getInstance()->delete("DELETE FROM `room_images` WHERE room_id=?", [$id], 'i');
        Room::syncFeatures($id, []);
        Room::syncFacilities($id, []);
        Room::softDelete($id);
        Session::flash('success', 'Room removed.');
        $this->redirect(SITE_URL . 'admin/rooms');
    }

    // ── Room Images ───────────────────────────────────────────
    public function images($roomId) {
        $room   = Room::findOrFail((int)$roomId);
        $images = Model::fetchAll(Database::getInstance()->select(
            "SELECT * FROM `room_images` WHERE room_id=?", [(int)$roomId], 'i'
        ));
        $flash = Session::flash('success');
        $error = Session::flash('error');
        $this->adminView('room_images', compact('room', 'images', 'flash', 'error'));
    }

    public function addImage($roomId) {
        $id = (int)$roomId;
        if (Request::hasFile('image')) {
            $filename = uploadImage(Request::file('image'), ROOMS_FOLDER);
            if (!in_array($filename, ['inv_img', 'inv_size', 'upd_failed', 'upload_error'])) {
                Database::getInstance()->insert(
                    "INSERT INTO `room_images`(room_id,image) VALUES (?,?)", [$id, $filename], 'is'
                );
                Session::flash('success', 'Image added.');
            } else {
                Session::flash('error', "Upload failed: $filename");
            }
        }
        $this->redirect(SITE_URL . "admin/rooms/$id/images");
    }

    public function removeImage($roomId) {
        $imgId = (int)$this->post('image_id');
        $id    = (int)$roomId;
        $img   = Model::fetchOne(Database::getInstance()->select(
            "SELECT image FROM `room_images` WHERE sr_no=? AND room_id=?", [$imgId, $id], 'ii'
        ));
        if ($img) {
            deleteImage($img['image'], ROOMS_FOLDER);
            Database::getInstance()->delete(
                "DELETE FROM `room_images` WHERE sr_no=? AND room_id=?", [$imgId, $id], 'ii'
            );
            Session::flash('success', 'Image deleted.');
        }
        $this->redirect(SITE_URL . "admin/rooms/$id/images");
    }

    public function setThumb($roomId) {
        $imgId = (int)$this->post('image_id');
        $id    = (int)$roomId;
        Database::getInstance()->update("UPDATE `room_images` SET thumb=0 WHERE room_id=?", [$id], 'i');
        Database::getInstance()->update("UPDATE `room_images` SET thumb=1 WHERE sr_no=? AND room_id=?", [$imgId, $id], 'ii');
        Session::flash('success', 'Thumbnail updated.');
        $this->redirect(SITE_URL . "admin/rooms/$id/images");
    }
}
