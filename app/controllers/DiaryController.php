<?php
require_once __DIR__ . '/../models/Diary.php';
require_once __DIR__ . '/../models/Image.php';

class DiaryController {
    private $diaryModel;
    private $imageModel;

    public function __construct() {
        $this->diaryModel = new Diary();
        $this->imageModel = new Image();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $date = $_GET['date'] ?? date('Y-m-d');
        $search = $_GET['search'] ?? '';
        $mood = $_GET['mood'] ?? '';

        $entries = $this->diaryModel->getEntriesByDateAndFilters($_SESSION['user_id'], $date, $search, $mood);
        include __DIR__ . '/../views/diary/index.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->store();
        } else {
            $date = $_GET['date'] ?? date('Y-m-d');
            include __DIR__ . '/../views/diary/create.php';
        }
    }

    private function store() {
        // Verify CSRF token
        verifyCSRF();

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $mood = filter_input(INPUT_POST, 'mood', FILTER_SANITIZE_STRING);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $fontFamily = filter_input(INPUT_POST, 'font_family', FILTER_SANITIZE_STRING) ?: 'font-poppins';

        if (!$title || !$content || !$date) {
            $_SESSION['error'] = 'Title, content, and date are required';
            header('Location: ' . APP_URL . '/diary/create?date=' . $date);
            exit;
        }

        $entryId = $this->diaryModel->create($_SESSION['user_id'], $title, $content, $mood, $date, $fontFamily);

        if (!$entryId) {
            $_SESSION['error'] = 'Failed to create entry';
            header('Location: ' . APP_URL . '/diary/create?date=' . $date);
            exit;
        }

        // Calculate position for new entry to avoid overlapping
        $existingEntries = $this->diaryModel->getEntriesByDateAndFilters($_SESSION['user_id'], $date, '', '');
        $entryCount = count($existingEntries);
        
        // Simple grid positioning: 3 cards per row, 100px spacing
        $cardsPerRow = 3;
        $spacingX = 280; // card width + margin
        $spacingY = 320; // card height + margin
        
        $row = floor($entryCount / $cardsPerRow);
        $col = $entryCount % $cardsPerRow;
        
        $positionX = $col * $spacingX + 20; // 20px margin from left
        $positionY = $row * $spacingY + 20; // 20px margin from top
        
        // Update the entry with calculated position
        $this->diaryModel->updatePosition($entryId, $_SESSION['user_id'], $positionX, $positionY, 0, $entryCount);

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $this->handleImageUploads($entryId);
        }

        $_SESSION['success'] = 'Entry created successfully';
        header('Location: ' . APP_URL . '/diary');
        exit;
    }

    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $entry = $this->diaryModel->findById($id, $_SESSION['user_id']);
        if (!$entry) {
            $_SESSION['error'] = 'Entry not found';
            header('Location: ' . APP_URL . '/diary');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->update($id);
        } else {
            $images = $this->imageModel->getByDiaryId($id);
            include __DIR__ . '/../views/diary/edit.php';
        }
    }

    private function update($id) {
        // Verify CSRF token
        verifyCSRF();

        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $content = $_POST['content'];
        $mood = filter_input(INPUT_POST, 'mood', FILTER_SANITIZE_STRING);
        $fontFamily = filter_input(INPUT_POST, 'font_family', FILTER_SANITIZE_STRING);

        if (!$title || !$content) {
            $_SESSION['error'] = 'Title and content are required';
            header('Location: ' . APP_URL . '/diary/edit/' . $id);
            exit;
        }

        $this->diaryModel->update($id, $_SESSION['user_id'], $title, $content, $mood, $fontFamily);

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $this->handleImageUploads($id);
        }

        $_SESSION['success'] = 'Entry updated successfully';
        header('Location: ' . APP_URL . '/diary');
        exit;
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $entry = $this->diaryModel->findById($id, $_SESSION['user_id']);
        if (!$entry) {
            $_SESSION['error'] = 'Entry not found';
            header('Location: ' . APP_URL . '/diary');
            exit;
        }

        // Delete images
        $images = $this->imageModel->getByDiaryId($id);
        foreach ($images as $image) {
            unlink($image['path']);
            if ($image['thumbnail_path']) {
                unlink($image['thumbnail_path']);
            }
        }
        $this->imageModel->deleteByDiaryId($id);

        $this->diaryModel->delete($id, $_SESSION['user_id']);
        $_SESSION['success'] = 'Entry deleted successfully';
        header('Location: ' . APP_URL . '/diary');
        exit;
    }

    public function view($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $entry = $this->diaryModel->findById($id, $_SESSION['user_id']);
        if (!$entry) {
            $_SESSION['error'] = 'Entry not found';
            header('Location: ' . APP_URL . '/diary');
            exit;
        }

        $images = $this->imageModel->getByDiaryId($id);
        include __DIR__ . '/../views/diary/view.php';
    }

    public function search() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $query = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
        $entries = [];
        if ($query) {
            $entries = $this->diaryModel->search($_SESSION['user_id'], $query);
        }

        include __DIR__ . '/../views/diary/search.php';
    }

    public function calendar() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');

        $entries = $this->diaryModel->getEntriesByMonth($_SESSION['user_id'], $year, $month);
        $entryDates = array_column($entries, 'entry_date');

        include __DIR__ . '/../views/diary/calendar.php';
    }

    private function handleImageUploads($entryId) {
        $uploadDir = UPLOAD_PATH;
        $tempDir = TEMP_UPLOAD_PATH;

        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) continue;

            $originalName = $_FILES['images']['name'][$key];
            $fileSize = $_FILES['images']['size'][$key];
            $fileType = $_FILES['images']['type'][$key];

            // Validate file
            if ($fileSize > MAX_FILE_SIZE) continue;
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            if (!in_array($ext, ALLOWED_EXTENSIONS)) continue;

            $filename = uniqid() . '.' . $ext;
            $path = $uploadDir . $filename;
            $thumbnailPath = $uploadDir . 'thumb_' . $filename;

            if (move_uploaded_file($tmpName, $path)) {
                // Create thumbnail
                $this->createThumbnail($path, $thumbnailPath);
                $this->imageModel->create($entryId, $filename, $originalName, $path, $thumbnailPath);
            }
        }
    }

    private function createThumbnail($source, $destination) {
        $image = null;
        $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'png':
                $image = imagecreatefrompng($source);
                break;
            case 'gif':
                $image = imagecreatefromgif($source);
                break;
        }

        if ($image) {
            $width = imagesx($image);
            $height = imagesy($image);
            $newWidth = 200;
            $newHeight = ($height / $width) * $newWidth;

            $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($thumbnail, $destination, 90);
                    break;
                case 'png':
                    imagepng($thumbnail, $destination);
                    break;
                case 'gif':
                    imagegif($thumbnail, $destination);
                    break;
            }

            imagedestroy($image);
            imagedestroy($thumbnail);
        }
    }

    public function updatePosition() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $entryId = $input['entry_id'] ?? null;
        $positionX = $input['position_x'] ?? 0;
        $positionY = $input['position_y'] ?? 0;
        $rotation = $input['rotation'] ?? 0;
        $zIndex = $input['z_index'] ?? 0;

        if (!$entryId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Entry ID required']);
            return;
        }

        $result = $this->diaryModel->updatePosition($entryId, $_SESSION['user_id'], $positionX, $positionY, $rotation, $zIndex);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update position']);
        }
    }
}
?>