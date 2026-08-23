<?php

// --- BẮT ĐẦU FIX SYMLINK (GIỮ NGUYÊN /BLOG) ---
$uri_path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// 1. DỌN DẸP URL: Bắt lỗi Web Server tự động chèn chữ /public/
if (strpos($uri_path, '/public/blog') === 0) {
    // Tách lấy phần đuôi phía sau (vd: "/", "/cua-hang", "?page=2")
    $suffix = substr($_SERVER['REQUEST_URI'], strlen('/public/blog'));

    // Nếu URL thiếu dấu / (chỉ là rỗng hoặc bắt đầu bằng ?), ta chèn thêm / vào để tránh lặp redirect
    if ($suffix === '' || strpos($suffix, '?') === 0) {
        $suffix = '/' . $suffix;
    }

    // Ép trình duyệt quay trở lại đường dẫn sạch đẹp
    header('Location: /blog' . $suffix, true, 301);
    exit;
}

// 2. FIX THIẾU TRAILING SLASH CHO TRANG CHỦ
if ($uri_path === '/blog') {
    $query = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
    $_SERVER['REQUEST_URI'] = '/blog/' . $query;
    $uri_path = '/blog/'; // Cập nhật lại đường dẫn để lọt vào điều kiện số 3
}

// 3. KHAI BÁO BASE URL CHO LARAVEL
if (strpos($uri_path, '/blog/') === 0) {
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
