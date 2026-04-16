<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAdmin;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

// Public Front Page
Route::get('/', function () {
    // Lấy danh sách để hiển thị ngoài trang chủ
    $posts = Post::latest()->take(6)->get(); // Lấy 6 bài mới nhất
    $categories = Category::all();
    $tags = Tag::all();

    return view('welcome', compact('posts', 'categories', 'tags'));
})->name('home');

// Guest Routes (Login / Register)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

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
});

// Normal Authenticated Users (Chỉ cần đăng nhập)
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
