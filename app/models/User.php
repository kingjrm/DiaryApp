<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            $this->db = null;
        }
    }

    public function create($email, $password, $name) {
        if (!$this->db) return false;
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (email, password, name, is_verified) VALUES (?, ?, ?, 0)");
            return $stmt->execute([$email, $hashedPassword, $name]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function findByEmail($email) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function findById($id) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function verify($userId) {
        if (!$this->db) return false;
        try {
            $stmt = $this->db->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
            return $stmt->execute([$userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updatePassword($userId, $password) {
        if (!$this->db) return false;
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateProfile($userId, $name) {
        if (!$this->db) return false;
        try {
            $stmt = $this->db->prepare("UPDATE users SET name = ? WHERE id = ?");
            return $stmt->execute([$name, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }
}
?>