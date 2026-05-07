<?php
/**
 * Simple Router
 * Handles routing for the application
 */

class Router {
    private static $routes = [];
    
    public static function get($uri, $action) {
        self::$routes['GET'][$uri] = $action;
    }
    
    public static function post($uri, $action) {
        self::$routes['POST'][$uri] = $action;
    }
    
    public static function any($uri, $action) {
        self::$routes['GET'][$uri] = $action;
        self::$routes['POST'][$uri] = $action;
    }
    
    public static function dispatch() {
        $method = Request::method();
        $uri    = Request::uri();

        // Remove query string
        $uri = strtok($uri, '?');

        // Strip the base path dynamically using PROJECT_FOLDER constant
        $basePath = '/' . PROJECT_FOLDER . '/public';
        if (str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        // Ensure leading slash
        if (empty($uri) || !str_starts_with($uri, '/')) {
            $uri = '/' . ltrim($uri, '/');
        }
        
        // Check for exact match
        if (isset(self::$routes[$method][$uri])) {
            return self::execute(self::$routes[$method][$uri]);
        }
        
        // Check for pattern match
        foreach (self::$routes[$method] ?? [] as $route => $action) {
            $pattern = self::convertToRegex($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                return self::execute($action, $matches);
            }
        }
        
        Response::notFound();
    }
    
    private static function convertToRegex($route) {
        $route = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
        return '#^' . $route . '$#';
    }
    
    private static function execute($action, $params = []) {
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }
        
        if (is_string($action)) {
            [$controller, $method] = explode('@', $action);
            
            // Search in controllers/ then controllers/admin/
            $paths = [
                BASE_PATH . '/controllers/' . $controller . '.php',
                BASE_PATH . '/controllers/admin/' . $controller . '.php',
            ];
            
            $controllerFile = null;
            foreach ($paths as $path) {
                if (file_exists($path)) {
                    $controllerFile = $path;
                    break;
                }
            }
            
            if (!$controllerFile) {
                Response::serverError("Controller not found: $controller");
            }
            
            require_once $controllerFile;
            
            if (!class_exists($controller)) {
                Response::serverError("Controller class not found: $controller");
            }
            
            $instance = new $controller();
            
            if (!method_exists($instance, $method)) {
                Response::serverError("Method not found: $controller@$method");
            }
            
            return call_user_func_array([$instance, $method], $params);
        }
    }
}
