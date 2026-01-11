<?php
require_once __DIR__ . '/../../config/database.php';

class Image {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($diaryId, $filename, $originalName, $path, $thumbnailPath) {
        try {
            $stmt = $this->db->prepare("INSERT INTO diary_images (diary_entry_id, filename, original_name, path, thumbnail_path, uploaded_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$diaryId, $filename, $originalName, $path, $thumbnailPath]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getByDiaryId($diaryId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM diary_images WHERE diary_entry_id = ? ORDER BY uploaded_at ASC");
            $stmt->execute([$diaryId]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function delete($id, $diaryId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM diary_images WHERE id = ? AND diary_entry_id = ?");
            return $stmt->execute([$id, $diaryId]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteByDiaryId($diaryId) {
        try {
            $stmt = $this->db->prepare("DELETE FROM diary_images WHERE diary_entry_id = ?");
            return $stmt->execute([$diaryId]);
        } catch (Exception $e) {
            return false;
        }
    }
}
?>