<?php
require_once __DIR__ . '/config/app.php';

// Simple convenience entry that's equivalent to /auth/login route
// It includes the login view so users can access /DiaryApp/login.php directly.
include __DIR__ . '/app/views/auth/login.php';
