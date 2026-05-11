<?php
/**
 * Auth Controller
 * Handles login, register, logout
 */

class AuthController extends BaseController {

    public function loginPage() {
        if (Auth::isUserLoggedIn()) {
            $this->redirect(SITE_URL);
        }

        $error = null;

        if (Request::isPost()) {
            if (!Auth::checkRateLimit('login')) {
                $error = lang('err_rate_limit');
            } else {
                $identifier = $this->post('email_mob');
                $password   = Request::post('pass');
                $user       = User::findByEmailOrPhone($identifier);

                if (!$user) {
                    Auth::incrementRateLimit('login');
                    $error = lang('err_inv_email_mob');
                } elseif ($user['status'] == 0) {
                    $error = lang('err_inactive');
                } elseif (!User::verifyPassword($user, $password)) {
                    Auth::incrementRateLimit('login');
                    $error = lang('err_invalid_pass');
                } else {
                    Auth::loginUser($user['id'], $user['name'], $user['phonenum']);
                    Auth::resetRateLimit('login');
                    $this->redirect(SITE_URL);
                }
            }
        }

        $lang = Session::getLang();
        require BASE_PATH . '/views/auth/login.php';
        exit;
    }

    public function registerPage() {
        if (Auth::isUserLoggedIn()) {
            $this->redirect(SITE_URL);
        }

        $error = null;

        if (Request::isPost()) {
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
                $error = lang('err_pass_mismatch');
            } elseif (User::emailExists($data['email'])) {
                $error = lang('err_email_exists');
            } elseif (User::phoneExists($data['phonenum'])) {
                $error = lang('err_phone_exists');
            } else {
                $result = User::register($data);
                if ($result) {
                    $this->redirect(SITE_URL . 'login');
                } else {
                    $error = lang('err_reg_failed');
                }
            }
        }

        $lang = Session::getLang();
        require BASE_PATH . '/views/auth/register.php';
        exit;
    }

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
            Auth::incrementRateLimit('login');
            $this->json('inv_email_mob');
        }

        if ($user['status'] == 0) {
            $this->json('inactive');
        }

        if (!User::verifyPassword($user, $password)) {
            Auth::incrementRateLimit('login');
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
        if (Auth::isAdminLoggedIn()) {
            $this->redirect(SITE_URL . 'admin/dashboard');
        }

        if (!Request::isPost()) {
            require BASE_PATH . '/views/admin/login.php';
            exit;
        }

        $name     = $this->post('admin_name');
        $password = Request::post('admin_pass');

        $admin = Admin::findByName($name);

        if (!$admin || !Admin::verifyPassword($admin, $password)) {
            $error = 'Invalid credentials. Please try again.';
            require BASE_PATH . '/views/admin/login.php';
            exit;
        }

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
