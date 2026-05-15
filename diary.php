<?php
// Wrapper to allow accessing the diary index without URL rewriting.
// Sets the 'url' GET param so the Router dispatches to '/diary'.
$_GET['url'] = '/diary';
require_once __DIR__ . '/index.php';
