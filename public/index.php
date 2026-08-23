<?php

// --- BẮT ĐẦU FIX SYMLINK ---
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Kiểm tra nếu URL bắt đầu bằng /blog
if (strpos($uri, '/blog') === 0) {
    // 1. Cắt /blog khỏi REQUEST_URI
    $newUri = substr($uri, 5);
    $_SERVER['REQUEST_URI'] = ($newUri === '' || $newUri[0] !== '/') ? '/' . $newUri : $newUri;

    // 2. Cắt /blog khỏi SCRIPT_NAME (Rất quan trọng để Laravel không tạo sai Route)
    if (isset($_SERVER['SCRIPT_NAME']) && strpos($_SERVER['SCRIPT_NAME'], '/blog') === 0) {
        $_SERVER['SCRIPT_NAME'] = substr($_SERVER['SCRIPT_NAME'], 5);
    }

    // 3. Cắt /blog khỏi PHP_SELF
    if (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], '/blog') === 0) {
        $_SERVER['PHP_SELF'] = substr($_SERVER['PHP_SELF'], 5);
    }
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
