<?php
require_once __DIR__ . '/../../config/database.php';

class Diary {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($userId, $title, $content, $mood, $date, $fontFamily = 'font-poppins', $positionX = 0, $positionY = 0, $rotation = 0, $zIndex = 0, $backgroundColor = '#ffffff', $backgroundImage = null, $textColor = '#000000', $textBold = false, $textItalic = false, $textUnderline = false) {
        try {
            $stmt = $this->db->prepare("INSERT INTO diary_entries (user_id, title, content, mood, entry_date, font_family, position_x, position_y, rotation, z_index, background_color, background_image, text_color, text_bold, text_italic, text_underline, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$userId, $title, $content, $mood, $date, $fontFamily, $positionX, $positionY, $rotation, $zIndex, $backgroundColor, $backgroundImage, $textColor, $textBold, $textItalic, $textUnderline]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            return false;
        }
    }

    public function update($id, $userId, $title, $content, $mood, $fontFamily = null, $backgroundColor = null, $backgroundImage = null, $textColor = null, $textBold = null, $textItalic = null, $textUnderline = null) {
        try {
            $sql = "UPDATE diary_entries SET title = ?, content = ?, mood = ?";
            $params = [$title, $content, $mood];

            if ($fontFamily !== null) {
                $sql .= ", font_family = ?";
                $params[] = $fontFamily;
            }
            if ($backgroundColor !== null) {
                $sql .= ", background_color = ?";
                $params[] = $backgroundColor;
            }
            if ($backgroundImage !== null) {
                $sql .= ", background_image = ?";
                $params[] = $backgroundImage;
            }
            if ($textColor !== null) {
                $sql .= ", text_color = ?";
                $params[] = $textColor;
            }
            if ($textBold !== null) {
                $sql .= ", text_bold = ?";
                $params[] = $textBold;
            }
            if ($textItalic !== null) {
                $sql .= ", text_italic = ?";
                $params[] = $textItalic;
            }
            if ($textUnderline !== null) {
                $sql .= ", text_underline = ?";
                $params[] = $textUnderline;
            }

            $sql .= ", updated_at = NOW() WHERE id = ? AND user_id = ?";
            $params[] = $id;
            $params[] = $userId;

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updatePosition($id, $userId, $positionX, $positionY, $rotation, $zIndex) {
        try {
            $stmt = $this->db->prepare("UPDATE diary_entries SET position_x = ?, position_y = ?, rotation = ?, z_index = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
            return $stmt->execute([$positionX, $positionY, $rotation, $zIndex, $id, $userId]);
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

    public function getEntriesByDateAndFilters($userId, $date, $search = '', $mood = '') {
        try {
            $sql = "SELECT * FROM diary_entries WHERE user_id = ? AND entry_date = ?";
            $params = [$userId, $date];

            if (!empty($search)) {
                $sql .= " AND (title LIKE ? OR content LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }

            if (!empty($mood)) {
                $sql .= " AND mood = ?";
                $params[] = $mood;
            }

            $sql .= " ORDER BY z_index DESC, created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
?>