<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/OTP.php';
require_once __DIR__ . '/../../config/mail.php';

class AuthController {
    private $userModel;
    private $otpModel;

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
    }
    public function index() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/dashboard');
        } else {
            header('Location: ' . APP_URL . '/login');
        }
        exit;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->userModel) {
                $_SESSION['error'] = 'Database configuration error. Please check your setup.';
                header('Location: ' . APP_URL . '/register');
                exit;
            }
            // Process registration
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            if (!$email || !$password || !$name) {
                $_SESSION['error'] = 'All fields are required';
                header('Location: ' . APP_URL . '/register');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
                header('Location: ' . APP_URL . '/register');
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'Password must be at least 6 characters';
                header('Location: ' . APP_URL . '/register');
                exit;
            }

            $existingUser = $this->userModel->findByEmail($email);
            if ($existingUser) {
                $_SESSION['error'] = 'Email already exists';
                header('Location: ' . APP_URL . '/register');
                exit;
            }

            if ($this->userModel->create($email, $password, $name)) {
                $user = $this->userModel->findByEmail($email);
                $otp = rand(100000, 999999);
                $this->otpModel->create($user['id'], $otp);

                $mail = Mail::getInstance();
                if ($mail->sendOTP($email, $otp)) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['success'] = 'Registration successful. Please check your email for OTP.';
                    header('Location: ' . APP_URL . '/verify-otp');
                } else {
                    $_SESSION['error'] = 'Failed to send OTP. Please try again.';
                    header('Location: ' . APP_URL . '/register');
                }
            } else {
                $_SESSION['error'] = 'Registration failed';
                header('Location: ' . APP_URL . '/register');
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
                header('Location: ' . APP_URL . '/login');
                exit;
            }
            // Process login
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $_SESSION['error'] = 'Email and password are required';
                header('Location: ' . APP_URL . '/login');
                exit;
            }

            $user = $this->userModel->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['error'] = 'Invalid credentials';
                header('Location: ' . APP_URL . '/login');
                exit;
            }

            if (!$user['is_verified']) {
                $_SESSION['user_id'] = $user['id'];
                $otp = rand(100000, 999999);
                $this->otpModel->create($user['id'], $otp);
                $mail = Mail::getInstance();
                $mail->sendOTP($email, $otp);
                $_SESSION['success'] = 'Please verify your account. OTP sent to your email.';
                header('Location: ' . APP_URL . '/verify-otp');
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        } else {
            // Show login form
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function verifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process OTP verification
            $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_NUMBER_INT);

            if (!$otp || !isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Invalid request';
                header('Location: ' . APP_URL . '/verify-otp');
                exit;
            }

            if ($this->otpModel->verify($_SESSION['user_id'], $otp)) {
                $this->userModel->verify($_SESSION['user_id']);
                $user = $this->userModel->findById($_SESSION['user_id']);
                $_SESSION['user_name'] = $user['name'];
                unset($_SESSION['user_id']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = 'Account verified successfully';
                header('Location: ' . APP_URL . '/dashboard');
            } else {
                $_SESSION['error'] = 'Invalid or expired OTP';
                header('Location: ' . APP_URL . '/verify-otp');
            }
            exit;
        } else {
            // Show OTP verification form
            include __DIR__ . '/../views/auth/verify_otp.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . APP_URL . '/login');
        exit;
    }

    public function resendOTP() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
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
        header('Location: ' . APP_URL . '/verify-otp');
        exit;
    }
}
?>