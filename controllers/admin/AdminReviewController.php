<?php
class AdminReviewController extends AdminBaseController {

    public function reviews() {
        $reviews = Review::getAll();
        $flash   = Session::flash('success');
        $this->adminView('reviews', compact('reviews', 'flash'));
    }

    public function markReviewSeen() {
        $id = (int)$this->post('id');
        Review::markSeen($id);
        $this->redirect(SITE_URL . 'admin/reviews');
    }

    public function queries() {
        $rows  = Model::fetchAll(Database::getInstance()->select(
            "SELECT * FROM `user_queries` ORDER BY sr_no DESC"
        ));
        $flash = Session::flash('success');
        $this->adminView('queries', ['queries' => $rows, 'flash' => $flash]);
    }

    public function markQuerySeen() {
        $id = (int)$this->post('id');
        Database::getInstance()->update(
            "UPDATE `user_queries` SET `seen`=1 WHERE `sr_no`=?", [$id], 'i'
        );
        $this->redirect(SITE_URL . 'admin/queries');
    }
}
