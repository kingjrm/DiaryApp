<?php
// Wrapper to allow accessing login page without URL rewriting.
$_GET['url'] = '/login';
require_once __DIR__ . '/index.php';
