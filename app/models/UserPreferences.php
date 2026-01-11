<?php
require_once __DIR__ . '/../../config/database.php';

class UserPreferences {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            $this->db = null;
        }
    }

    public function getPreferences($userId) {
        if (!$this->db) return $this->getDefaults();
        try {
            $stmt = $this->db->prepare("SELECT * FROM user_preferences WHERE user_id = ?");
            $stmt->execute([$userId]);
            $prefs = $stmt->fetch();
            return $prefs ?: $this->getDefaults();
        } catch (Exception $e) {
            return $this->getDefaults();
        }
    }

    public function updatePreferences($userId, $preferences) {
        if (!$this->db) return false;
        try {
            $stmt = $this->db->prepare("INSERT INTO user_preferences (user_id, writing_font, scrapbook_theme, avatar_path, bio, timezone, date_format) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE writing_font = VALUES(writing_font), scrapbook_theme = VALUES(scrapbook_theme), avatar_path = VALUES(avatar_path), bio = VALUES(bio), timezone = VALUES(timezone), date_format = VALUES(date_format), updated_at = CURRENT_TIMESTAMP");
            return $stmt->execute([
                $userId,
                $preferences['writing_font'] ?? 'Poppins',
                $preferences['scrapbook_theme'] ?? 'classic',
                $preferences['avatar_path'] ?? null,
                $preferences['bio'] ?? null,
                $preferences['timezone'] ?? 'UTC',
                $preferences['date_format'] ?? 'Y-m-d'
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    private function getDefaults() {
        return [
            'writing_font' => 'Poppins',
            'scrapbook_theme' => 'classic',
            'avatar_path' => null,
            'bio' => null,
            'timezone' => 'UTC',
            'date_format' => 'Y-m-d'
        ];
    }

    public function getAvailableFonts() {
        return [
            'Poppins' => ['name' => 'Poppins', 'category' => 'Modern', 'weights' => '300,400,500,600,700'],
            'Inter' => ['name' => 'Inter', 'category' => 'Modern', 'weights' => '300,400,500,600,700'],
            'Playfair Display' => ['name' => 'Playfair Display', 'category' => 'Serif', 'weights' => '400,500,600,700,800,900'],
            'Pixelify Sans' => ['name' => 'Pixelify Sans', 'category' => 'Retro', 'weights' => '400,500,600,700'],
            'Dancing Script' => ['name' => 'Dancing Script', 'category' => 'Handwritten', 'weights' => '400,500,600,700'],
            'Caveat' => ['name' => 'Caveat', 'category' => 'Handwritten', 'weights' => '400,500,600,700'],
            'Kalam' => ['name' => 'Kalam', 'category' => 'Handwritten', 'weights' => '300,400,700'],
            'Shadows Into Light' => ['name' => 'Shadows Into Light', 'category' => 'Handwritten', 'weights' => '400'],
            'Amatic SC' => ['name' => 'Amatic SC', 'category' => 'Handwritten', 'weights' => '400,700'],
            'Permanent Marker' => ['name' => 'Permanent Marker', 'category' => 'Handwritten', 'weights' => '400'],
            'Fredoka One' => ['name' => 'Fredoka One', 'category' => 'Fun', 'weights' => '400'],
            'Comfortaa' => ['name' => 'Comfortaa', 'category' => 'Rounded', 'weights' => '300,400,500,600,700'],
            'Nunito' => ['name' => 'Nunito', 'category' => 'Rounded', 'weights' => '200,300,400,500,600,700,800,900'],
            'Quicksand' => ['name' => 'Quicksand', 'category' => 'Rounded', 'weights' => '300,400,500,600,700']
        ];
    }
}