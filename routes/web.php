<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\IsAdmin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

Route::get('/test-redis', function () {
    if (Cache::has('browser_test')) {
        return "Loaded from Redis Cache: " . Cache::get('browser_test');
    }
    $message = "This is fresh data created at " . now();
    Cache::put('browser_test', $message, 60);
    return "Saved to Redis. Refresh the page! Data: " . $message;
});

// Public Front Page
Route::get('/', [PostController::class, 'home'])->name('home');

// Admin Routes (Chỉ Admin mới được vào)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'users' => User::count(),
            'comments' => Comment::count(),
            'products' => Product::count(),
        ];
        return view('dashboard', compact('stats'));
    })->name('dashboard');

    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');
    Route::post('tags/update-order', [TagController::class, 'updateOrder'])->name('tags.update-order');

    Route::resource('categories', CategoryController::class)->except(['show']);;
    Route::resource('tags', TagController::class)->except(['show']);;
    Route::resource('users', UserController::class);

    Route::patch('/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');

    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Normal Authenticated Users (Chỉ cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class)->except(['show']);
    Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('image.upload');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// ==========================================
// 301 Redirects for Old URLs
// ==========================================
Route::get('/posts/{slug}', function ($slug) {
    return redirect('/' . $slug, 301);
});

Route::get('/categories/{slug}', function ($slug) {
    return redirect('/chuyen-muc/' . $slug, 301);
});

Route::get('/tags/{slug}', function ($slug) {
    return redirect('/the/' . $slug, 301);
});


// ==========================================
// New Public Routes for Categories and Tags
// ==========================================
Route::get('/chuyen-muc/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Thêm Route dành riêng cho giao diện Tiếng Anh:
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show.en');

Route::get('/the/{tag:slug}', [TagController::class, 'show'])->name('tags.show');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/api/v1/posts', [PostController::class, 'apiIndex'])->name('api.posts.index');
Route::post('/chat', [ChatController::class, 'sendMessage'])->name('chat.send');

// 1. Dành cho Public (Ai cũng xem được)
Route::get('/cua-hang', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// 2. Dành cho Admin (Khu vực quản lý bên trong Group middleware auth + IsAdmin)
Route::middleware(['auth', IsAdmin::class])->group(function () {
    // Đặt tên route admin tránh trùng lặp với route public
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// ==========================================
// New Public Route for Post
// IMPORTANT: Keep this at the absolute bottom
// so it doesn't intercept other root requests
// (like /login or /sitemap.xml)
// ==========================================
Route::get('/{post:slug}', [PostController::class, 'show'])->name('posts.show');
