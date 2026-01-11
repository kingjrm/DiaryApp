<?php
require_once __DIR__ . '/../models/Image.php';

class UploadController {
    private $imageModel;

    public function __construct() {
        $this->imageModel = new Image();
    }

    public function upload() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
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

                if (move_uploaded_file($tmpName, $path)) {
                    // Create thumbnail
                    $this->createThumbnail($path, $thumbnailPath);
                    $imageId = $this->imageModel->create($diaryId, $filename, $originalName, $path, $thumbnailPath);

                    $response['images'][] = [
                        'id' => $imageId,
                        'filename' => $filename,
                        'original_name' => $originalName,
                        'path' => $path,
                        'thumbnail_path' => $thumbnailPath
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
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $imageId = filter_input(INPUT_POST, 'image_id', FILTER_SANITIZE_NUMBER_INT);
        $diaryId = filter_input(INPUT_POST, 'diary_id', FILTER_SANITIZE_NUMBER_INT);

        if (!$imageId || !$diaryId) {
            http_response_code(400);
            echo json_encode(['error' => 'Image ID and Diary ID required']);
            exit;
        }

        $images = $this->imageModel->getByDiaryId($diaryId);
        $image = array_filter($images, function($img) use ($imageId) {
            return $img['id'] == $imageId;
        });

        if (empty($image)) {
            http_response_code(404);
            echo json_encode(['error' => 'Image not found']);
            exit;
        }

        $image = reset($image);
        unlink($image['path']);
        if ($image['thumbnail_path']) {
            unlink($image['thumbnail_path']);
        }

        $this->imageModel->delete($imageId, $diaryId);

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
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