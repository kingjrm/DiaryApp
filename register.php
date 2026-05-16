<?php
// Wrapper to allow accessing register page without URL rewriting.
$_GET['url'] = '/register';
require_once __DIR__ . '/index.php';
