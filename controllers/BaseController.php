<?php
/**
 * Base Controller
 * All controllers extend this class
 */

abstract class BaseController {
    
    protected function view($viewPath, $data = []) {
        // Always inject settings & contact for header/footer
        if (!isset($data['settings'])) {
            $data['settings'] = Cache::remember('settings_1', 300, fn() => Setting::get());
        }
        if (!isset($data['contact'])) {
            $data['contact'] = Cache::remember('contact_1', 300, fn() => Setting::getContact());
        }

        extract($data);
        $viewFile = BASE_PATH . '/views/' . $viewPath . '.php';
        
        if (!file_exists($viewFile)) {
            Response::serverError("View not found: $viewPath");
        }
        
        require $viewFile;
    }
    
    protected function json($data, $status = 200) {
        Response::json($data, $status);
    }
    
    protected function success($message, $data = []) {
        Response::success($message, $data);
    }
    
    protected function error($message, $status = 400) {
        Response::error($message, $status);
    }
    
    protected function redirect($url) {
        Response::redirect($url);
    }
    
    protected function requireAuth() {
        Auth::requireUser();
    }
    
    protected function requireAdmin() {
        Auth::requireAdmin();
    }
    
    protected function input($key, $default = null) {
        return Request::sanitize(Request::input($key, $default));
    }
    
    protected function post($key, $default = null) {
        return Request::sanitize(Request::post($key, $default));
    }
    
    protected function get($key, $default = null) {
        return Request::sanitize(Request::get($key, $default));
    }
    
    protected function validate($rules) {
        $data = Request::all();
        $validator = Validator::make($data, $rules);
        
        if (!$validator->validate()) {
            if (Request::isAjax()) {
                Response::error('Validation failed', 422, $validator->errors());
            }
            Session::flash('errors', $validator->errors());
            Response::back();
        }
        
        return true;
    }
}
