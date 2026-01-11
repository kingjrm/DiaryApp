<?php
require_once __DIR__ . '/../vendor/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/src/SMTP.php';
require_once __DIR__ . '/../vendor/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {
    private static $instance = null;
    private $mailer;

    private function __construct() {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = getenv('SMTP_HOST');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = getenv('SMTP_USER');
        $this->mailer->Password = getenv('SMTP_PASS');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = getenv('SMTP_PORT');

        // Disable SSL verification (for development/testing)
        $this->mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Sender
        $this->mailer->setFrom(getenv('SMTP_FROM'), getenv('SMTP_FROM_NAME'));
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Mail();
        }
        return self::$instance;
    }

    public function sendOTP($to, $otp) {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Your OTP for Diary App';
            $this->mailer->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9;'>
                    <h2 style='color: #333;'>Welcome to Diary App</h2>
                    <p>Your One-Time Password (OTP) is:</p>
                    <div style='font-size: 24px; font-weight: bold; color: #007bff; text-align: center; padding: 10px; background-color: #fff; border: 1px solid #ddd; margin: 20px 0;'>$otp</div>
                    <p>This OTP will expire in 10 minutes.</p>
                    <p>If you didn't request this, please ignore this email.</p>
                </div>
            ";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Mail error: " . $this->mailer->ErrorInfo);
            return false;
        }
    }
}
?>