<?php

// --- BẮT ĐẦU FIX SYMLINK ---
$uri = $_SERVER['REQUEST_URI'] ?? '';
// Nếu URL bắt đầu bằng /blog, ta cắt bỏ chữ /blog đi để Laravel hiểu đây là trang chủ (/)
if (strpos($uri, '/blog') === 0) {
    $newUri = substr($uri, 5);
    $_SERVER['REQUEST_URI'] = ($newUri === '' || $newUri[0] !== '/') ? '/' . $newUri : $newUri;
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
