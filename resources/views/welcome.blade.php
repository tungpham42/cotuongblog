@extends('layouts.app')

@section('title', 'Trang chủ - Cờ tướng')

@section('content')

@if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-12">
    <div class="px-6 py-16 sm:px-12 sm:py-24 lg:py-32 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl lg:text-6xl">
            Cộng đồng <span class="text-brand">Cờ Tướng</span> Việt Nam
        </h1>
        <p class="mt-6 max-w-2xl mx-auto text-lg leading-8 text-slate-600 dark:text-slate-400">
            Nơi giao lưu, học hỏi và chia sẻ những ván cờ hay, khai cuộc sắc bén và tàn cuộc đỉnh cao.
        </p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-brand px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand transition-all">
                        Vào trang quản trị &rarr;
                    </a>
                @else
                    <span class="text-lg font-medium text-slate-700 dark:text-slate-300">
                        Chào mừng, {{ auth()->user()->name }}! ♟️
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold leading-6 text-red-500 hover:text-red-700 transition-colors">
                            Đăng xuất
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('register') }}" class="rounded-lg bg-brand px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-hover transition-all">
                    Đăng ký ngay
                </a>
                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-slate-900 dark:text-white hover:text-brand dark:hover:text-brand transition-colors">
                    Đăng nhập <span aria-hidden="true">→</span>
                </a>
            @endauth
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-12">
    <div class="lg:col-span-3">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Bài viết mới nhất</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse ($posts as $post)
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-md transition">
                    <div class="h-48 bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                        <span class="text-4xl">♟️</span>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs text-slate-500 dark:text-slate-400">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 hover:text-brand transition cursor-pointer">
                            {{ $post->title }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3">
                            {{ Str::limit($post->content ?? $post->excerpt, 100) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 text-slate-500 dark:text-slate-400">
                    Chưa có bài viết nào được đăng.
                </div>
            @endforelse
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Chuyên mục</h3>
            <ul class="space-y-3">
                @forelse ($categories as $category)
                    <li>
                        <a href="#" class="flex items-center justify-between text-slate-600 dark:text-slate-400 hover:text-brand dark:hover:text-brand transition">
                            <span>{{ $category->name }}</span>
                        </a>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Chưa có chuyên mục.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Thẻ (Tags)</h3>
            <div class="flex flex-wrap gap-2">
                @forelse ($tags as $tag)
                    <a href="#" class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 hover:bg-brand hover:text-white dark:hover:bg-brand dark:hover:text-white transition">
                        #{{ $tag->name }}
                    </a>
                @empty
                    <span class="text-sm text-slate-500">Chưa có thẻ nào.</span>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
