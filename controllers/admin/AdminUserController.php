<?php
class AdminUserController extends AdminBaseController {

    public function index() {
        $search = Request::get('search', '');
        $page   = max(1, (int)Request::get('page', 1));
        $perPage = 20;
        $offset  = ($page - 1) * $perPage;
        $s       = "%$search%";

        $total = Model::fetchOne(Database::getInstance()->select(
            "SELECT COUNT(*) AS c FROM `user_cred`
             WHERE `name` LIKE ? OR `email` LIKE ? OR `phonenum` LIKE ?",
            [$s, $s, $s], 'sss'
        ))['c'] ?? 0;

        $users = Model::fetchAll(Database::getInstance()->select(
            "SELECT * FROM `user_cred`
             WHERE `name` LIKE ? OR `email` LIKE ? OR `phonenum` LIKE ?
             ORDER BY id DESC LIMIT ? OFFSET ?",
            [$s, $s, $s, $perPage, $offset], 'sssii'
        ));

        $totalPages = ceil($total / $perPage);
        $flash = Session::flash('success');
        $this->adminView('users', compact('users', 'search', 'page', 'totalPages', 'flash'));
    }

    public function toggleStatus() {
        $id     = (int)$this->post('user_id');
        $status = (int)$this->post('status');
        User::toggleStatus($id, $status);
        $this->redirect(SITE_URL . 'admin/users?' . http_build_query([
            'search' => Request::post('search', ''),
            'page'   => Request::post('page', 1),
        ]));
    }

    public function removeUser() {
        $id = (int)$this->post('user_id');
        Database::getInstance()->delete("DELETE FROM `user_cred` WHERE `id`=?", [$id], 'i');
        Session::flash('success', 'User removed.');
        $this->redirect(SITE_URL . 'admin/users');
    }
}
