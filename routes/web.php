<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\IsAdmin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

Route::get('/test-redis', function () {
    // Check if the cache exists
    if (Cache::has('browser_test')) {
        return "Loaded from Redis Cache: " . Cache::get('browser_test');
    }

    // If not, set it for 1 minute (60 seconds)
    $message = "This is fresh data created at " . now();
    Cache::put('browser_test', $message, 60);

    return "Saved to Redis. Refresh the page! Data: " . $message;
});

// Public Front Page
Route::get('/', function () {
    // Lấy danh sách để hiển thị ngoài trang chủ
    $posts = Post::where('is_published', true)->latest()->paginate(6);
    $categories = Category::all();
    $tags = Tag::all();

    return view('welcome', compact('posts', 'categories', 'tags'));
})->name('home');

// Admin Routes (Chỉ Admin mới được vào)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'users' => User::count(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    // Admin CMS
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('users', UserController::class);
    Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('image.upload'); // Renamed route
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Normal Authenticated Users (Chỉ cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Route hiển thị bài viết public
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->where('is_published', true)->name('posts.show');

// Thêm 2 route này cho Category và Tag (Sử dụng slug)
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Guest Routes (Login / Register)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
