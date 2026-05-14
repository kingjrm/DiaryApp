<?php
/**
 * Router - Handles routing and request matching
 */

class Router {
    private $routes;
    private $request;
    private $basePath = '/DiaryApp';

    public function __construct($routes) {
        $this->routes = $routes;
        $this->parseRequest();
    }

    private function parseRequest() {
        // Check for query parameter first (cleaner URLs)
        if (isset($_GET['url']) && !empty($_GET['url'])) {
            $request = $_GET['url'];
        } else {
            // Fall back to REQUEST_URI
            $request = $_SERVER['REQUEST_URI'];
            // Remove base path
            $request = str_replace($this->basePath, '', $request);
            // Remove index.php from path
            $request = str_replace('/index.php', '', $request);
            // Remove query string
            $request = explode('?', $request)[0];
        }
        
        // Normalize the request
        $request = rtrim($request, '/');
        $this->request = $request ?: '/';
    }

    public function dispatch() {
        // Exact match
        if (isset($this->routes[$this->request])) {
            return $this->routes[$this->request];
        }

        // Dynamic routes
        if (preg_match('#^/diary/view/(\d+)$#', $this->request, $matches)) {
            return ['controller' => 'DiaryController', 'method' => 'view', 'params' => [$matches[1]]];
        }
        if (preg_match('#^/diary/edit/(\d+)$#', $this->request, $matches)) {
            return ['controller' => 'DiaryController', 'method' => 'edit', 'params' => [$matches[1]]];
        }
        if (preg_match('#^/diary/delete/(\d+)$#', $this->request, $matches)) {
            return ['controller' => 'DiaryController', 'method' => 'delete', 'params' => [$matches[1]]];
        }
        if (preg_match('#^/api/upload/(\d+)$#', $this->request, $matches)) {
            return ['controller' => 'UploadController', 'method' => 'upload', 'params' => [$matches[1]]];
        }

        // 404
        http_response_code(404);
        return ['error' => 'Route not found'];
    }

    public function getRequest() {
        return $this->request;
    }
}
