<?php

// --- BẮT ĐẦU FIX SYMLINK ---
$uri_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

if ($uri_path === '/blog' || strpos($uri_path, '/blog/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF'] = '/blog/index.php';
}
// --- KẾT THÚC FIX SYMLINK ---

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
