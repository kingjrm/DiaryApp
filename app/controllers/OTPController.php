<?php
require_once __DIR__ . '/../models/OTP.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/mail.php';

class OTPController {
    private $otpModel;
    private $userModel;

    public function __construct() {
        $this->otpModel = new OTP();
        $this->userModel = new User();
    }

    public function send() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            exit;
        }

        $otp = rand(100000, 999999);
        $this->otpModel->create($user['id'], $otp);

        $mail = Mail::getInstance();
        if ($mail->sendOTP($user['email'], $otp)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send OTP']);
        }
        exit;
    }

    public function verify() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $otp = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_NUMBER_INT);

        if (!$otp) {
            http_response_code(400);
            echo json_encode(['error' => 'OTP required']);
            exit;
        }

        if ($this->otpModel->verify($_SESSION['user_id'], $otp)) {
            $this->userModel->verify($_SESSION['user_id']);
            $user = $this->userModel->findById($_SESSION['user_id']);
            $_SESSION['user_name'] = $user['name'];
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Account verified successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid or expired OTP']);
        }
        exit;
    }
}
?>