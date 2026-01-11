<?php
require_once __DIR__ . '/../../config/database.php';

class Mood {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            $this->db = null;
        }
    }

    public function create($userId, $mood, $note = null, $date = null) {
        if (!$this->db) return false;
        try {
            $moodDate = $date ?: date('Y-m-d');
            $stmt = $this->db->prepare("INSERT INTO daily_moods (user_id, mood, note, mood_date) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE mood = VALUES(mood), note = VALUES(note), updated_at = CURRENT_TIMESTAMP");
            return $stmt->execute([$userId, $mood, $note, $moodDate]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function findByUserAndDate($userId, $date) {
        if (!$this->db) return null;
        try {
            $stmt = $this->db->prepare("SELECT * FROM daily_moods WHERE user_id = ? AND mood_date = ?");
            $stmt->execute([$userId, $date]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function hasSubmittedToday($userId) {
        return $this->findByUserAndDate($userId, date('Y-m-d')) !== false;
    }

    public function getUserMoods($userId, $limit = null, $offset = 0) {
        if (!$this->db) return [];
        try {
            $sql = "SELECT * FROM daily_moods WHERE user_id = ? ORDER BY mood_date DESC";
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
            }
            $stmt = $this->db->prepare($sql);
            if ($limit) {
                $stmt->execute([$userId, $limit, $offset]);
            } else {
                $stmt->execute([$userId]);
            }
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getMoodStats($userId, $days = 30) {
        if (!$this->db) return [];
        try {
            $stmt = $this->db->prepare("SELECT mood, COUNT(*) as count FROM daily_moods WHERE user_id = ? AND mood_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY mood ORDER BY count DESC");
            $stmt->execute([$userId, $days]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}