<?php

// --- BẮT ĐẦU FIX SYMLINK (GIỮ NGUYÊN /BLOG) ---
$uri_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// Nếu đường dẫn chính xác là /blog hoặc bắt đầu bằng /blog/ (vd: /blog/cua-hang, /blog/thu-vien)
if ($uri_path === '/blog' || strpos($uri_path, '/blog/') === 0) {
    // Ép biến môi trường để khai báo với Laravel rằng Base URL của app lúc này là /blog
    $_SERVER['SCRIPT_NAME'] = '/blog/index.php';
    $_SERVER['PHP_SELF'] = '/blog/index.php';

    // FIX PHẦN CHƯA WORK: Xử lý riêng khi URL chính xác là "/blog" (thiếu dấu / ở cuối)
    if ($uri_path === '/blog') {
        // Lấy lại các tham số phía sau (nếu có, vd: ?page=2)
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $query = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';

        // Thêm dấu '/' vào cuối để Laravel hiểu đây là request vào trang chủ (/)
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
