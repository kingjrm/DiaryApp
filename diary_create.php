<?php
// Wrapper to allow accessing diary create page without URL rewriting.
$_GET['url'] = '/diary/create';
require_once __DIR__ . '/index.php';
