<?php
/**
 * Helper Functions - Common utility functions
 */

/**
 * Generate a URL with proper index.php handling
 */
function url($path = '') {
    $base = APP_URL;
    if ($path && $path !== '/') {
        // Remove leading slash for query parameter
        $path = ltrim($path, '/');
        return $base . '?url=/' . $path;
    }
    return $base;
}

/**
 * Require a file if it exists
 */
function requireOnce($path) {
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
}

/**
 * Load a view file with provided data
 */
function view($viewPath, $data = []) {
    extract($data);
    $fullPath = __DIR__ . '/../app/views/' . $viewPath . '.php';
    if (file_exists($fullPath)) {
        include $fullPath;
    } else {
        die("View not found: $viewPath");
    }
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Get session value
 */
function session($key = null, $default = null) {
    if ($key === null) {
        return $_SESSION;
    }
    return $_SESSION[$key] ?? $default;
}

/**
 * Set session value
 */
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

/**
 * Flash message (store for next request)
 */
function flashMessage($message, $type = 'info') {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Check if user is authenticated
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user
 */
function currentUser() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Escape HTML output
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
