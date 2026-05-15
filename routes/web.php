<?php
/**
 * Web Routes - All public and authenticated web pages
 */

return [
    // Landing and Auth
    '/' => ['controller' => 'AuthController', 'method' => 'landing'],
    '/login' => ['controller' => 'AuthController', 'method' => 'login'],
    '/register' => ['controller' => 'AuthController', 'method' => 'register'],
    '/verify-otp' => ['controller' => 'AuthController', 'method' => 'verifyOTP'],
    '/resend-otp' => ['controller' => 'AuthController', 'method' => 'resendOTP'],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    '/profile' => ['controller' => 'AuthController', 'method' => 'profile'],

    // Diary Management
    '/dashboard' => ['controller' => 'DiaryController', 'method' => 'index'],
    '/diary' => ['controller' => 'DiaryController', 'method' => 'index'],
    '/diary/create' => ['controller' => 'DiaryController', 'method' => 'create'],
    '/diary/calendar' => ['controller' => 'DiaryController', 'method' => 'calendar'],
    '/diary/search' => ['controller' => 'DiaryController', 'method' => 'search'],
    
    // Dynamic routes (pattern matching in router)
];
