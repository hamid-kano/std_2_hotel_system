<?php
/**
 * Admin Base Controller
 */
class AdminBaseController extends BaseController {

    public function __construct() {
        Auth::requireAdmin();
    }

    protected function adminView(string $view, array $data = [], string $scripts = '') {
        // Inject settings & contact for layout
        if (!isset($data['settings'])) {
            $data['settings'] = Cache::remember('settings_1', 300, fn() => Setting::get());
        }
        if (!isset($data['contact'])) {
            $data['contact'] = Cache::remember('contact_1', 300, fn() => Setting::getContact());
        }
        $data['scripts'] = $scripts;

        // Render inner view to buffer
        extract($data);
        ob_start();
        $viewFile = BASE_PATH . '/views/admin/' . $view . '.php';
        if (file_exists($viewFile)) require $viewFile;
        $content = ob_get_clean();

        // Render layout
        require BASE_PATH . '/views/admin/layout.php';
        exit;
    }

    protected function jsonOk(array $data = []) {
        $this->json(array_merge(['success' => true], $data));
    }

    protected function jsonFail(string $message = 'Error') {
        $this->json(['success' => false, 'message' => $message]);
    }
}
