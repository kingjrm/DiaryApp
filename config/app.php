<?php
// Load environment variables
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new Exception('.env file not found');
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

loadEnv(__DIR__ . '/../.env');

// Define constants
define('APP_URL', getenv('APP_URL'));
define('APP_SECRET', getenv('APP_SECRET'));
define('UPLOAD_PATH', getenv('UPLOAD_PATH'));
define('TEMP_UPLOAD_PATH', getenv('TEMP_UPLOAD_PATH'));
define('MAX_FILE_SIZE', getenv('MAX_FILE_SIZE'));
define('ALLOWED_EXTENSIONS', explode(',', getenv('ALLOWED_EXTENSIONS')));
define('SESSION_LIFETIME', getenv('SESSION_LIFETIME'));

// Start session
ini_set('session.save_path', __DIR__ . '/../storage/sessions');
session_set_cookie_params(3600, '/DiaryApp/');
session_start();

// CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function verifyCSRF() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
    // Regenerate token after successful verification
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>