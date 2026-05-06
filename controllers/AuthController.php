<?php
/**
 * Auth Controller
 * Handles login, register, logout
 */

class AuthController extends BaseController {
    
    public function login() {
        if (!Request::isPost()) {
            $this->error('Method not allowed', 405);
        }
        
        // Rate limiting
        if (!Auth::checkRateLimit('login')) {
            $this->json('rate_limit');
        }
        
        $identifier = $this->post('email_mob');
        $password   = $this->post('pass');
        
        $user = User::findByEmailOrPhone($identifier);
        
        if (!$user) {
            $this->json('inv_email_mob');
        }
        
        if ($user['status'] == 0) {
            $this->json('inactive');
        }
        
        if (!User::verifyPassword($user, $password)) {
            $this->json('invalid_pass');
        }
        
        Auth::loginUser($user['id'], $user['name'], $user['phonenum']);
        Auth::resetRateLimit('login');
        
        $this->json(1);
    }
    
    public function register() {
        if (!Request::isPost()) {
            $this->error('Method not allowed', 405);
        }
        
        $data = [
            'name'     => $this->post('name'),
            'email'    => $this->post('email'),
            'phonenum' => $this->post('phonenum'),
            'address'  => $this->post('address'),
            'pincode'  => $this->post('pincode'),
            'dob'      => $this->post('dob'),
            'pass'     => Request::post('pass'),
            'cpass'    => Request::post('cpass'),
        ];
        
        if ($data['pass'] !== $data['cpass']) {
            $this->json('pass_mismatch');
        }
        
        if (User::emailExists($data['email'])) {
            $this->json('email_already');
        }
        
        if (User::phoneExists($data['phonenum'])) {
            $this->json('phone_already');
        }
        
        $result = User::register($data);
        
        $this->json($result ? 1 : 'ins_failed');
    }
    
    public function logout() {
        Auth::logoutUser();
        $this->redirect(SITE_URL);
    }
    
    public function adminLogin() {
        if (!Request::isPost()) {
            $this->view('admin/login');
            return;
        }
        
        $name     = $this->post('admin_name');
        $password = Request::post('admin_pass');
        
        $admin = Admin::findByName($name);
        
        if (!$admin || !Admin::verifyPassword($admin, $password)) {
            Session::flash('error', 'Invalid credentials');
            $this->view('admin/login', ['error' => 'Invalid credentials']);
            return;
        }
        
        // Upgrade plain-text password to bcrypt
        if (!password_get_info($admin['admin_pass'])['algo']) {
            Admin::upgradePassword($admin['sr_no'], $password);
        }
        
        Auth::loginAdmin($admin['sr_no']);
        $this->redirect(SITE_URL . 'admin/dashboard');
    }
    
    public function adminLogout() {
        Auth::logoutAdmin();
        $this->redirect(SITE_URL . 'admin/login');
    }
}
