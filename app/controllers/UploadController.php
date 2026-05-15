<?php
require_once __DIR__ . '/../models/Image.php';

class UploadController {
    private $imageModel;

    public function __construct() {
        try {
            $this->imageModel = new Image();
        } catch (Exception $e) {
            $this->imageModel = null;
        }
    }

    public function upload() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if (!$this->imageModel) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $diaryId = filter_input(INPUT_POST, 'diary_id', FILTER_SANITIZE_NUMBER_INT);
        if (!$diaryId) {
            http_response_code(400);
            echo json_encode(['error' => 'Diary ID required']);
            exit;
        }

        $response = ['success' => false, 'images' => []];

        if (!empty($_FILES['images'])) {
            $uploadDir = UPLOAD_PATH;
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['images']['name'][$key];
                $fileSize = $_FILES['images']['size'][$key];

                // Validate file
                if ($fileSize > MAX_FILE_SIZE) {
                    $response['error'] = 'File too large';
                    continue;
                }

                $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                if (!in_array($ext, ALLOWED_EXTENSIONS)) {
                    $response['error'] = 'Invalid file type';
                    continue;
                }

                $filename = uniqid() . '.' . $ext;
                $path = $uploadDir . $filename;
                $thumbnailPath = $uploadDir . 'thumb_' . $filename;
                $webPath = 'public/uploads/' . $filename;
                $webThumbnailPath = 'public/uploads/thumb_' . $filename;

                if (move_uploaded_file($tmpName, $path)) {
                    // Create thumbnail
                    $this->createThumbnail($path, $thumbnailPath);
                    $imageId = $this->imageModel->create($diaryId, $filename, $originalName, $webPath, $webThumbnailPath);

                    $response['images'][] = [
                        'id' => $imageId,
                        'filename' => $filename,
                        'original_name' => $originalName,
                        'path' => $webPath,
                        'thumbnail_path' => $webThumbnailPath
                    ];
                }
            }

            if (!empty($response['images'])) {
                $response['success'] = true;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit;
        }

        if (!$this->imageModel) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Database error']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            exit;
        }

        // Parse JSON input
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
            exit;
        }

        $imageId = intval($input['image_id'] ?? 0);
        $diaryId = intval($input['diary_id'] ?? 0);

        if (!$imageId || !$diaryId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Image ID and Diary ID required']);
            exit;
        }

        $images = $this->imageModel->getByDiaryId($diaryId);
        $image = array_filter($images, function($img) use ($imageId) {
            return $img['id'] == $imageId;
        });

        if (empty($image)) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Image not found']);
            exit;
        }

        $image = reset($image);
        
        // Delete files from filesystem
        $imagePath = storagePath($image['path']);
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (!empty($image['thumbnail_path'])) {
            $thumbnailPath = storagePath($image['thumbnail_path']);
            if ($thumbnailPath && file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }

        // Delete from database
        $this->imageModel->delete($imageId, $diaryId);

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
        exit;
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
}
?>