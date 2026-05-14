<?php
/**
 * Authentication Middleware
 */

class AuthMiddleware {
    /**
     * Check if user is authenticated
     */
    public static function requireAuth() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please log in first';
            header('Location: ' . APP_URL . '/login');
            exit;
        }
        return true;
    }

    /**
     * Check if user is guest (not authenticated)
     */
    public static function requireGuest() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/diary');
            exit;
        }
        return true;
    }

    /**
     * Verify CSRF token
     */
    public static function verifyCsrf() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            
            if (!$token || $token !== $_SESSION['csrf_token']) {
                http_response_code(403);
                die('CSRF token validation failed');
            }
        }
    }

    /**
     * Generate CSRF token
     */
    public static function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
