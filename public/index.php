<?php

// --- BẮT ĐẦU ĐIỀU HƯỚNG SYMLINK & INDEX.PHP ---
$requestUri = $_SERVER['REQUEST_URI'] ?? '';

// Nếu đường dẫn truy cập bắt đầu bằng /blog
if (strpos($requestUri, '/blog') === 0) {
    // Ép SCRIPT_NAME và PHP_SELF để Laravel luôn hiểu Base URL là /blog/index.php
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF']    = '/blog/index.php';

    // Nếu người dùng vào chính xác /blog (thiếu dấu /), tự động chuẩn hóa để tránh lỗi 404
    if ($requestUri === '/blog' || $requestUri === '/blog/') {
        $parsed = parse_url($requestUri);
        $query  = isset($parsed['query']) ? '?' . $parsed['query'] : '';
        $_SERVER['REQUEST_URI'] = '/blog/' . $query;
    }
}
// --- KẾT THÚC ĐIỀU HƯỚNG ---

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
