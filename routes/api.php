<?php
/**
 * API Routes - AJAX/JSON endpoints
 */

return [
    '/api/update-position' => ['controller' => 'DiaryController', 'method' => 'updatePosition', 'method_type' => 'POST'],
    '/api/delete-image' => ['controller' => 'UploadController', 'method' => 'delete', 'method_type' => 'POST'],
    '/api/submit-mood' => ['controller' => 'MoodController', 'method' => 'submit', 'method_type' => 'POST'],
    '/api/autosave' => ['controller' => 'DiaryController', 'method' => 'autosave', 'method_type' => 'POST'],
];
