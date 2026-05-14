<?php
/**
 * DiaryApp Main Entry Point
 * 
 * This is the single entry point for all requests.
 * All URLs are routed through this file.
 */

// Load configuration
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';

// Load helpers and utilities
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/helpers/Router.php';

// Load middleware
require_once __DIR__ . '/middleware/auth.php';

// Load routes
$webRoutes = require_once __DIR__ . '/routes/web.php';
$apiRoutes = require_once __DIR__ . '/routes/api.php';

// Merge all routes
$allRoutes = array_merge($webRoutes, $apiRoutes);

// Initialize router
$router = new Router($allRoutes);
$route = $router->dispatch();

// Handle 404
if (isset($route['error'])) {
    http_response_code(404);
    echo '<h1>404 - Page Not Found</h1>';
    echo '<p>The page you requested does not exist.</p>';
    exit;
}

// Load and execute controller
try {
    if (isset($route['controller'])) {
        $controllerClass = $route['controller'];
        $controllerFile = __DIR__ . '/app/controllers/' . $controllerClass . '.php';
        
        if (!file_exists($controllerFile)) {
            throw new Exception("Controller not found: $controllerClass");
        }
        
        require_once $controllerFile;
        $controller = new $controllerClass();
        $method = $route['method'];
        
        if (!method_exists($controller, $method)) {
            throw new Exception("Method not found: $controllerClass::$method");
        }
        
        // Call controller method with parameters
        $params = $route['params'] ?? [];
        call_user_func_array([$controller, $method], $params);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo '<h1>500 - Server Error</h1>';
    echo '<p>An error occurred. Please try again later.</p>';
    if (ini_get('display_errors')) {
        echo '<pre>' . $e->getMessage() . '</pre>';
    }
}
