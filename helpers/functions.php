<?php
/**
 * Helper Functions - Common utility functions
 */

/**
 * Generate a URL with proper index.php handling
 */
function appBaseUrl() {
    return preg_replace('#/index\.php$#', '', APP_URL);
}

function authPageUrl($page) {
    $page = ltrim($page, '/');
    return appBaseUrl() . '/' . $page . '.php';
}

function url($path = '') {
    if (!$path || $path === '/') {
        return APP_URL;
    }

    $path = ltrim($path, '/');

    if (in_array($path, ['login', 'register', 'verify-otp'], true)) {
        return authPageUrl($path);
    }

    // If there's a PHP wrapper file at project root for this path, prefer it.
    // Support both 'diary.php' and 'diary_create.php' style wrappers for nested routes.
    $wrapperCandidates = [
        __DIR__ . '/../' . $path . '.php',
        __DIR__ . '/../' . str_replace('/', '_', $path) . '.php'
    ];
    foreach ($wrapperCandidates as $candidate) {
        if (file_exists($candidate)) {
            $fileName = basename($candidate);
            return appBaseUrl() . '/' . $fileName;
        }
    }

    return appBaseUrl() . '/' . $path;
}

function assetUrl($path = '') {
    if (!$path) {
        return '';
    }

    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    $path = ltrim($path, '/');

    if (strpos($path, 'public/') === 0) {
        return appBaseUrl() . '/' . $path;
    }

    if (strpos($path, 'uploads/') === 0) {
        return appBaseUrl() . '/public/' . $path;
    }

    return appBaseUrl() . '/public/uploads/' . $path;
}

function storagePath($path = '') {
    if (!$path) {
        return '';
    }

    $path = ltrim($path, '/');

    if (preg_match('#^(https?://|data:)#i', $path)) {
        return $path;
    }

    if (strpos($path, 'uploads/') === 0) {
        $path = 'public/' . $path;
    } elseif (strpos($path, 'public/') !== 0) {
        $path = 'public/uploads/' . $path;
    }

    return __DIR__ . '/../' . $path;
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
