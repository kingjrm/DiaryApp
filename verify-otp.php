<?php
// Wrapper to allow accessing verify-otp page without URL rewriting.
$_GET['url'] = '/verify-otp';
require_once __DIR__ . '/index.php';
