<?php
require_once __DIR__ . '/config/app.php';

// If this is a POST, forward to the router so the AuthController handles it.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Tell the router we want the '/login' route and dispatch via index.php
	$_GET['url'] = '/login';
	require_once __DIR__ . '/index.php';
	exit;
}

// GET: show the login view directly for convenience
include __DIR__ . '/app/views/auth/login.php';
