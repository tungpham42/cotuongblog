<?php

// --- BẮT ĐẦU FIX SYMLINK (GIỮ NGUYÊN /BLOG) ---
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$parsedUrl  = parse_url($requestUri);
$uriPath    = $parsedUrl['path'] ?? '';
$queryStr   = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';

// 1. Nếu truy cập đúng /blog (thiếu dấu / ở cuối), tự động chuẩn hóa thành /blog/
// để Laravel hiểu đây là trang chủ "/"
if ($uriPath === '/blog') {
    $_SERVER['REQUEST_URI'] = '/blog/' . $queryStr;
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF']    = '/blog/index.php';
}
// 2. Nếu truy cập các trang con (vd: /blog/cua-hang, /blog/thu-vien)
elseif (strpos($uriPath, '/blog/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF']    = '/blog/index.php';
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
