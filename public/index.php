<?php

// --- BẮT ĐẦU FIX SYMLINK (GIỮ NGUYÊN /BLOG) ---
$uri_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

if ($uri_path === '/blog' || strpos($uri_path, '/blog/') === 0) {
    // 1. Khai báo Base URL cho Laravel
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF'] = '/blog/index.php';

    // 2. Chặn lỗi MethodNotAllowed (HEAD) bằng cách ngầm thêm dấu "/"
    // để biến chuỗi rỗng "" thành Route trang chủ "/"
    if ($uri_path === '/blog') {
        $query = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
        $_SERVER['REQUEST_URI'] = '/blog/' . $query;
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
