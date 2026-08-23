<?php

// --- BẮT ĐẦU FIX SYMLINK (GIỮ NGUYÊN /BLOG) ---
$uri_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Nếu đường dẫn chính xác là /blog hoặc bắt đầu bằng /blog/ (vd: /blog/cua-hang, /blog/thu-vien)
if ($uri_path === '/blog' || strpos($uri_path, '/blog/') === 0) {
    // Ép biến môi trường để khai báo với Laravel rằng Base URL của app lúc này là /blog
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF'] = '/blog/index.php';

    // === PHẦN SỬA LỖI CHO TRANG CHỦ /blog ===
    // Nếu URL thiếu dấu / ở cuối, ta tự động nối thêm vào để Laravel hiểu chính xác đây là Route trang chủ (/)
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
