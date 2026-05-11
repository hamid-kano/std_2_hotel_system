<?php
/**
 * User Controller
 * Handles user profile and balance
 */

class UserController extends BaseController {
    
    public function profile() {
        $this->requireAuth();

        $error   = null;
        $success = null;

        if (Request::isPost()) {
            $formType = $this->post('form_type');

            if ($formType === 'info') {
                $data = [
                    'name'     => $this->post('name'),
                    'email'    => $this->post('email'),
                    'phonenum' => $this->post('phonenum'),
                    'address'  => $this->post('address'),
                ];
                $result = User::updateProfile(Auth::userId(), $data);
                if ($result !== false) {
                    $success = lang('changes_saved');
                } else {
                    $error = lang('err_update_failed');
                }
            } elseif ($formType === 'password') {
                $currentPass = Request::post('current_pass');
                $newPass     = Request::post('new_pass');
                $confirmPass = Request::post('confirm_pass');

                if ($newPass !== $confirmPass) {
                    $error = lang('err_pass_mismatch');
                } else {
                    $user = User::find(Auth::userId());
                    if (!User::verifyPassword($user, $currentPass)) {
                        $error = lang('err_curr_pass');
                    } else {
                        $result = User::updatePassword(Auth::userId(), $newPass);
                        $success = ($result !== false) ? lang('pass_updated') : lang('err_update_failed');
                    }
                }
            }
        }

        $user = User::find(Auth::userId());
        $this->view('pages/profile', compact('user', 'error', 'success'));
    }
    
    public function addBalance() {
        $this->requireAuth();
        
        if (!Request::isPost()) exit;
        
        $userId   = Auth::userId();
        $amount   = filter_var(Request::post('amount'), FILTER_VALIDATE_FLOAT);
        $password = Request::post('password');
        
        if (!$amount || $amount <= 0) {
            $this->json(['success' => false, 'message' => 'Invalid amount']);
        }
        
        $user = User::find($userId);
        if (!User::verifyPassword($user, $password)) {
            $this->json(['success' => false, 'message' => 'Invalid password']);
        }
        
        $result = User::addBalance($userId, $amount);
        $this->json([
            'success' => (bool)$result,
            'message' => $result ? 'Balance added successfully' : 'Failed to add balance'
        ]);
    }
    
    public function updateAvatar() {
        $this->requireAuth();
        
        if (!Request::hasFile('profile_img')) {
            $this->json(0);
        }
        
        $filename = uploadImage(Request::file('profile_img'), USERS_FOLDER);
        
        if (in_array($filename, ['inv_img', 'inv_size', 'upd_failed'])) {
            $this->json($filename);
        }
        
        $result = User::updateAvatar(Auth::userId(), $filename);
        $this->json($result ? $filename : 0);
    }
}
