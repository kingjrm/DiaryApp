<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

// Simple MVC Router
$request = $_SERVER['REQUEST_URI'];
$basePath = '/DiaryApp/public';
$request = str_replace($basePath, '', $request);
$request = explode('?', $request)[0];
$request = rtrim($request, '/');
$request = $request ?: '/';

$routes = [
    '/' => ['controller' => 'AuthController', 'method' => 'index'],
    '/login' => ['controller' => 'AuthController', 'method' => 'login'],
    '/register' => ['controller' => 'AuthController', 'method' => 'register'],
    '/verify-otp' => ['controller' => 'AuthController', 'method' => 'verifyOTP'],
    '/dashboard' => ['controller' => 'DiaryController', 'method' => 'index'],
    '/diary' => ['controller' => 'DiaryController', 'method' => 'index'],
    '/diary/create' => ['controller' => 'DiaryController', 'method' => 'create'],
    '/diary/calendar' => ['controller' => 'DiaryController', 'method' => 'calendar'],
    '/diary/search' => ['controller' => 'DiaryController', 'method' => 'search'],
];

function matchRoute($request, $routes) {
    // Exact match
    if (isset($routes[$request])) {
        return $routes[$request];
    }

    // Pattern matching for dynamic routes
    foreach ($routes as $route => $handler) {
        $pattern = preg_replace('/\/:([^\/]+)/', '/([^/]+)', $route);
        if (preg_match('#^' . $pattern . '$#', $request, $matches)) {
            array_shift($matches);
            $handler['params'] = $matches;
            return $handler;
        }
    }

    // Dynamic routes
    if (preg_match('#^/diary/view/(\d+)$#', $request, $matches)) {
        return ['controller' => 'DiaryController', 'method' => 'view', 'params' => [$matches[1]]];
    }
    if (preg_match('#^/diary/edit/(\d+)$#', $request, $matches)) {
        return ['controller' => 'DiaryController', 'method' => 'edit', 'params' => [$matches[1]]];
    }
    if (preg_match('#^/diary/delete/(\d+)$#', $request, $matches)) {
        return ['controller' => 'DiaryController', 'method' => 'delete', 'params' => [$matches[1]]];
    }

    // Auth routes
    if (preg_match('#^/auth/(\w+)$#', $request, $matches)) {
        $method = $matches[1];
        if (in_array($method, ['login', 'register', 'logout', 'verifyOTP', 'resendOTP'])) {
            return ['controller' => 'AuthController', 'method' => $method];
        }
    }

    // API routes
    if (preg_match('#^/api/(\w+)$#', $request, $matches)) {
        $method = $matches[1];
        if ($method === 'upload') {
            return ['controller' => 'UploadController', 'method' => 'upload'];
        }
        if ($method === 'delete-image') {
            return ['controller' => 'UploadController', 'method' => 'delete'];
        }
        if ($method === 'send-otp') {
            return ['controller' => 'OTPController', 'method' => 'send'];
        }
        if ($method === 'verify-otp') {
            return ['controller' => 'OTPController', 'method' => 'verify'];
        }
        if ($method === 'submit-mood') {
            return ['controller' => 'MoodController', 'method' => 'submit'];
        }
        if ($method === 'get-today-mood') {
            return ['controller' => 'MoodController', 'method' => 'getTodayMood'];
        }
        if ($method === 'update-position') {
            return ['controller' => 'DiaryController', 'method' => 'updatePosition'];
        }
    }

    return null;
}

$route = matchRoute($request, $routes);

if ($route) {
    $controllerName = $route['controller'];
    $method = $route['method'];
    $params = $route['params'] ?? [];

    require_once __DIR__ . '/../app/controllers/' . $controllerName . '.php';

    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        http_response_code(404);
        echo 'Method not found';
    }
} else {
    http_response_code(404);
    echo 'Page not found';
}
?>