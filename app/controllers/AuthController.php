<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/OTP.php';
require_once __DIR__ . '/../models/Mood.php';
require_once __DIR__ . '/../../config/mail.php';

class AuthController {
    private $userModel;
    private $otpModel;
    private $moodModel;

    public function __construct() {
        if (!class_exists('User')) {
            $this->userModel = null;
        } else {
            try {
                $this->userModel = new User();
            } catch (Exception $e) {
                $this->userModel = null;
            }
        }

        if (!class_exists('OTP')) {
            $this->otpModel = null;
        } else {
            try {
                $this->otpModel = new OTP();
            } catch (Exception $e) {
                $this->otpModel = null;
            }
        }

        if (!class_exists('Mood')) {
            $this->moodModel = null;
        } else {
            try {
                $this->moodModel = new Mood();
            } catch (Exception $e) {
                $this->moodModel = null;
            }
        }
    }

    public function landing() {
        // Show the public landing page for all users. Logging in should redirect to the user's dashboard.
        include __DIR__ . '/../views/landing/index.php';
        exit;
    }

    public function index() {
        header('Location: ' . url('diary/create'));
        exit;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->userModel) {
                $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                header('Location: ' . authPageUrl('register'));
                exit;
            }
            // Process registration
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $name = filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW);

            if (!$email || !$password || !$name) {
                $_SESSION['error'] = 'All fields are required';
                header('Location: ' . authPageUrl('register'));
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
                header('Location: ' . authPageUrl('register'));
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
                header('Location: ' . authPageUrl('register'));
                exit;
            }

            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = 'Email already exists';
                header('Location: ' . authPageUrl('register'));
                exit;
            }

            if ($this->userModel->create($email, $password, $name)) {
                $user = $this->userModel->findByEmail($email);
                $otp = rand(100000, 999999);
                if ($this->otpModel) {
                    $this->otpModel->create($user['id'], $otp);
                    try {
                        $mail = Mail::getInstance();
                        if ($mail->sendOTP($email, $otp)) {
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['success'] = 'Registration successful. Please check your email for OTP.';
                            header('Location: ' . authPageUrl('verify-otp'));
                        } else {
                            $_SESSION['error'] = 'Failed to send OTP. Please try again.';
                            header('Location: ' . authPageUrl('register'));
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = 'Failed to send OTP. Please check email configuration.';
                        header('Location: ' . authPageUrl('register'));
                    }
                } else {
                    $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                    header('Location: ' . authPageUrl('register'));
                }
            } else {
                $_SESSION['error'] = 'Registration failed';
                header('Location: ' . authPageUrl('register'));
            }
            exit;
        } else {
            // Show registration form
            include __DIR__ . '/../views/auth/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->userModel) {
                $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                header('Location: ' . authPageUrl('login'));
                exit;
            }
            // Process login
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $_SESSION['error'] = 'Email and password are required';
                header('Location: ' . authPageUrl('login'));
                exit;
            }

            $user = $this->userModel->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['error'] = 'Invalid credentials';
                header('Location: ' . authPageUrl('login'));
                exit;
            }

            if (!$user['is_verified']) {
                $_SESSION['user_id'] = $user['id'];
                $otp = rand(100000, 999999);
                if ($this->otpModel) {
                    $this->otpModel->create($user['id'], $otp);
                    try {
                        $mail = Mail::getInstance();
                        $mail->sendOTP($email, $otp);
                        $_SESSION['success'] = 'Please verify your account. OTP sent to your email.';
                    } catch (Exception $e) {
                        $_SESSION['error'] = 'Failed to send OTP. Please try again.';
                    }
                } else {
                    $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                }
                header('Location: ' . authPageUrl('verify-otp'));
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Check if user has submitted mood for today
            if ($this->moodModel && !$this->moodModel->hasSubmittedToday($user['id'])) {
                $_SESSION['show_mood_checkin'] = true;
            }

            header('Location: ' . url('diary'));
            exit;
        } else {
            // Show login form
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process OTP verification
            $otp = '';

            // Try to get combined OTP first (from hidden field)
            if (isset($_POST['otp']) && !empty($_POST['otp'])) {
                $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_NUMBER_INT);
            } else {
                // Combine individual OTP fields
                for ($i = 1; $i <= 6; $i++) {
                    $field = 'otp' . $i;
                    if (isset($_POST[$field])) {
                        $otp .= filter_input(INPUT_POST, $field, FILTER_SANITIZE_NUMBER_INT);
                    }
                }
            }

            if (strlen($otp) !== 6 || !isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Please enter the complete 6-digit OTP';
                header('Location: ' . authPageUrl('verify-otp'));
                exit;
            }

            if (!$this->otpModel || !$this->userModel) {
                $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                header('Location: ' . authPageUrl('verify-otp'));
                exit;
            }

            if ($this->otpModel->verify($_SESSION['user_id'], $otp)) {
                $this->userModel->verify($_SESSION['user_id']);
                $user = $this->userModel->findById($_SESSION['user_id']);
                $_SESSION['user_name'] = $user['name'];
                unset($_SESSION['user_id']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = 'Account verified successfully';
                header('Location: ' . url('dashboard'));
            } else {
                $_SESSION['error'] = 'Invalid or expired OTP';
                header('Location: ' . authPageUrl('verify-otp'));
            }
            exit;
        } else {
            // Show OTP verification form
            include __DIR__ . '/../views/auth/verify-otp.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . authPageUrl('login'));
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . authPageUrl('login'));
            exit;
        }

        require_once __DIR__ . '/../models/UserPreferences.php';
        $preferencesModel = new UserPreferences();
        $userPreferences = $preferencesModel->getPreferences($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findById($_SESSION['user_id']);
            
            // Check which form was submitted by checking the presence of fields
            if (isset($_POST['name'])) {
                // Profile info form
                $name = trim($_POST['name']);
                $bio = trim($_POST['bio'] ?? '');
                
                if (!empty($name)) {
                    $this->userModel->updateProfile($_SESSION['user_id'], $name);
                    $_SESSION['user_name'] = $name;
                }
                
                // Only update bio, keep other preferences intact
                $preferencesModel->updatePreferences($_SESSION['user_id'], [
                    'writing_font' => $userPreferences['writing_font'] ?? 'Poppins',
                    'scrapbook_theme' => $userPreferences['scrapbook_theme'] ?? 'classic',
                    'bio' => $bio,
                    'timezone' => $userPreferences['timezone'] ?? 'UTC',
                    'date_format' => $userPreferences['date_format'] ?? 'Y-m-d'
                ]);
            } elseif (isset($_POST['writing_font'])) {
                // Writing preferences form
                $writingFont = $_POST['writing_font'] ?? 'Poppins';
                $scrapbookTheme = $_POST['scrapbook_theme'] ?? 'classic';
                $timezone = $_POST['timezone'] ?? 'UTC';
                $dateFormat = $_POST['date_format'] ?? 'Y-m-d';
                
                // Update preferences, keep bio intact
                $preferencesModel->updatePreferences($_SESSION['user_id'], [
                    'writing_font' => $writingFont,
                    'scrapbook_theme' => $scrapbookTheme,
                    'bio' => $userPreferences['bio'] ?? '',
                    'timezone' => $timezone,
                    'date_format' => $dateFormat
                ]);
            }

            $_SESSION['success'] = 'Profile updated successfully!';
            header('Location: ' . url('profile'));
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);
        include __DIR__ . '/../views/auth/profile.php';
    }

    public function resendOTP() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . authPageUrl('login'));
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);
        $otp = rand(100000, 999999);
        $this->otpModel->create($user['id'], $otp);
        $mail = Mail::getInstance();
        if ($mail->sendOTP($user['email'], $otp)) {
            $_SESSION['success'] = 'OTP resent successfully';
        } else {
            $_SESSION['error'] = 'Failed to resend OTP';
        }
        header('Location: ' . authPageUrl('verify-otp'));
        exit;
    }
}
?>