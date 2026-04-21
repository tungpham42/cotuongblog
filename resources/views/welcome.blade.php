@extends('layouts.app')

@section('title', 'Trang chủ - Cờ tướng')

@section('content')
<div class="space-y-12">

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-6 py-4 rounded-xl font-medium flex items-center gap-2">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden text-center py-20 px-6 sm:px-12">
        <div class="absolute inset-0 bg-gradient-to-b from-brand/5 to-transparent dark:from-brand/10"></div>

        <div class="relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">
                Cộng đồng <span class="text-brand">Cờ Tướng</span> Việt Nam 🏆
            </h1>
            <p class="text-lg sm:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-10">
                Nơi giao lưu, học hỏi và chia sẻ những ván cờ hay, khai cuộc sắc bén và tàn cuộc đỉnh cao. 🌟
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-white bg-brand hover:bg-brand-hover rounded-xl shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                            ⚙️ Vào trang quản trị
                        </a>
                    @else
                        <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-700/50 px-6 py-3 rounded-xl border border-slate-100 dark:border-slate-600">
                            <span class="text-slate-700 dark:text-slate-200 font-semibold">👋 Chào mừng, {{ auth()->user()->name }}!</span>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 font-medium transition-colors">
                                    🚪 Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-white bg-brand hover:bg-brand-hover rounded-xl shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                        🚀 Đăng ký ngay
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl transition-all duration-200">
                        🔑 Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-4">
                📰 Bài viết mới nhất
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($posts as $post)
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:border-brand/40 dark:hover:border-brand/50 transition-all duration-300 transform hover:-translate-y-1">

                        <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[16/9] w-full bg-slate-100 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-5xl opacity-40 group-hover:scale-110 group-hover:opacity-60 transition-all duration-500">
                                    🏆
                                </div>
                            @endif

                            {{-- Views Counter Badge --}}
                            <div class="absolute top-3 right-3 bg-slate-900/70 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-lg flex items-center gap-1.5 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($post->views ?? 0) }}
                            </div>
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <header class="mb-3">
                                <div class="flex items-center gap-3 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-3">
                                    <span class="flex items-center gap-1.5 text-brand bg-brand/10 dark:bg-brand/20 px-2.5 py-1 rounded-md">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand transition-colors line-clamp-2 leading-tight">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none focus:text-brand">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                            </header>

                            {{-- Fallback to strip_tags(content) if excerpt is null to avoid broken HTML layouts --}}
                            <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 flex-grow leading-relaxed">
                                {{ Str::limit(strip_tags(Str::markdown($post->excerpt ?? $post->content ?? '')), 120) }}
                            </p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <span class="text-5xl block mb-4">📭</span>
                        <p class="text-slate-500 dark:text-slate-400 text-lg font-medium">Chưa có bài viết nào được đăng.</p>
                    </div>
                @endforelse
            </div>
            @if ($posts->hasPages())
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <div class="space-y-8 sticky top-28 self-start lg:block">

            {{-- Categories Sidebar with Featured Images --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    📂 Chuyên mục
                </h3>
                <ul class="space-y-3">
                    @forelse ($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->slug) }}" class="group flex items-center gap-3 p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-brand/10 hover:text-brand transition-all duration-200">
                                {{-- Category Featured Image --}}
                                <div class="flex-shrink-0 w-11 h-11 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 flex items-center justify-center">
                                    @if($category->featured_image)
                                        <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <span class="text-xl group-hover:scale-110 transition-transform duration-300">📂</span>
                                    @endif
                                </div>

                                {{-- Name & Arrow --}}
                                <div class="flex-grow flex items-center justify-between min-w-0 pr-1">
                                    <span class="font-semibold truncate text-sm sm:text-base">{{ $category->name }}</span>
                                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0 transition-all duration-300 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="p-3 text-sm text-slate-500 dark:text-slate-400 italic text-center">Chưa có chuyên mục.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    🏷️ Thẻ nổi bật
                </h3>
                <div class="flex flex-wrap gap-2">
                    @forelse ($tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3.5 py-1.5 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-brand hover:text-white dark:hover:bg-brand transition-all duration-200">
                            #{{ $tag->name }}
                        </a>
                    @empty
                        <span class="text-sm text-slate-500 dark:text-slate-400 italic w-full text-center py-2">Chưa có thẻ nào.</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
