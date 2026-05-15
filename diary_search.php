<?php
// Wrapper to allow accessing diary search page without URL rewriting.
$_GET['url'] = '/diary/search';
require_once __DIR__ . '/index.php';
