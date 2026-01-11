<?php
require_once __DIR__ . '/../../config/database.php';

class OTP {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            $this->db = null;
        }
    }

    public function create($userId, $otp) {
        if (!$this->db) return false;
        try {
            // Delete existing OTPs for this user
            $this->deleteByUserId($userId);

            $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $stmt = $this->db->prepare("INSERT INTO otps (user_id, otp, expires_at) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $otp, $expiresAt]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function verify($userId, $otp) {
        if (!$this->db) return false;
        try {
            $stmt = $this->db->prepare("SELECT * FROM otps WHERE user_id = ? AND otp = ? AND expires_at > NOW() AND used = 0");
            $stmt->execute([$userId, $otp]);
            $result = $stmt->fetch();

            if ($result) {
                // Mark as used
                $stmt = $this->db->prepare("UPDATE otps SET used = 1 WHERE id = ?");
                $stmt->execute([$result['id']]);
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteByUserId($userId) {
        if (!$this->db) return;
        try {
            $stmt = $this->db->prepare("DELETE FROM otps WHERE user_id = ?");
            $stmt->execute([$userId]);
        } catch (Exception $e) {
            // Ignore
        }
    }

    public function cleanup() {
        if (!$this->db) return;
        try {
            $stmt = $this->db->prepare("DELETE FROM otps WHERE expires_at < NOW() OR used = 1");
            $stmt->execute();
        } catch (Exception $e) {
            // Ignore
        }
    }
}
?>