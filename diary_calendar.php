<?php
// Wrapper to allow accessing diary calendar page without URL rewriting.
$_GET['url'] = '/diary/calendar';
require_once __DIR__ . '/index.php';
