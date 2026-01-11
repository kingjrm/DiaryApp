<?php
require_once __DIR__ . '/../../config/database.php';

class Diary {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $title, $content, $mood, $date) {
        try {
            $stmt = $this->db->prepare("INSERT INTO diary_entries (user_id, title, content, mood, entry_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$userId, $title, $content, $mood, $date]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($id, $userId, $title, $content, $mood) {
        try {
            $stmt = $this->db->prepare("UPDATE diary_entries SET title = ?, content = ?, mood = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
            return $stmt->execute([$title, $content, $mood, $id, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete($id, $userId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM diary_entries WHERE id = ? AND user_id = ?");
            return $stmt->execute([$id, $userId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function findById($id, $userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM diary_entries WHERE id = ? AND user_id = ?");
            $stmt->execute([$id, $userId]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function findByDate($userId, $date) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM diary_entries WHERE user_id = ? AND entry_date = ?");
            $stmt->execute([$userId, $date]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function getAllByUser($userId, $limit = null, $offset = 0) {
        try {
            $sql = "SELECT * FROM diary_entries WHERE user_id = ? ORDER BY entry_date DESC";
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$userId, $limit, $offset]);
            } else {
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$userId]);
            }
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function search($userId, $query) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM diary_entries WHERE user_id = ? AND (title LIKE ? OR content LIKE ?) ORDER BY entry_date DESC");
            $searchTerm = "%$query%";
            $stmt->execute([$userId, $searchTerm, $searchTerm]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getEntriesByMonth($userId, $year, $month) {
        try {
            $stmt = $this->db->prepare("SELECT entry_date FROM diary_entries WHERE user_id = ? AND YEAR(entry_date) = ? AND MONTH(entry_date) = ?");
            $stmt->execute([$userId, $year, $month]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>