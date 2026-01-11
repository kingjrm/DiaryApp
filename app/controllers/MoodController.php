<?php
require_once __DIR__ . '/../models/Mood.php';

class MoodController {
    private $moodModel;

    public function __construct() {
        try {
            $this->moodModel = new Mood();
        } catch (Exception $e) {
            $this->moodModel = null;
        }
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!$this->moodModel) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $mood = filter_input(INPUT_POST, 'mood', FILTER_SANITIZE_STRING);
        $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);

        if (!$mood) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Mood is required']);
            exit;
        }

        $validMoods = ['Happy', 'Calm', 'Sad', 'Anxious', 'Excited', 'Tired', 'Angry', 'Loved'];
        if (!in_array($mood, $validMoods)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid mood']);
            exit;
        }

        if (strlen($note) > 500) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Note too long']);
            exit;
        }

        $result = $this->moodModel->create($_SESSION['user_id'], $mood, $note ?: null);

        if ($result) {
            // Clear the mood check-in flag
            unset($_SESSION['show_mood_checkin']);
            echo json_encode(['success' => true, 'message' => 'Mood recorded successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to save mood']);
        }
        exit;
    }

    public function getTodayMood() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        if (!$this->moodModel) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error']);
            exit;
        }

        $mood = $this->moodModel->findByUserAndDate($_SESSION['user_id'], date('Y-m-d'));

        if ($mood) {
            echo json_encode(['success' => true, 'mood' => $mood]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No mood found for today']);
        }
        exit;
    }
}