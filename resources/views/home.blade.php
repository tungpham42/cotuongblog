@extends('layouts.app')

@section('title', 'Trang chủ - Góc nhỏ Cờ Tướng')

@section('content')
<style>
    /* Custom animations for a "wow" cozy feel */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>

<div class="space-y-16">

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-6 py-4 rounded-2xl font-medium flex items-center gap-3 shadow-sm animate-bounce-short">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Hero Section: Warmer, Cozy, and Inviting --}}
    <div class="relative bg-gradient-to-br from-orange-50/80 via-amber-50/80 to-brand-light/50 dark:from-slate-800 dark:via-slate-800/90 dark:to-orange-950/30 rounded-[3rem] shadow-sm border border-orange-100 dark:border-slate-700/50 overflow-hidden text-center py-24 px-6 sm:px-12 isolate">

        <div class="absolute top-0 -left-4 w-72 h-72 bg-orange-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10 animate-blob -z-10"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10 animate-blob animation-delay-2000 -z-10"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-brand rounded-full mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-10 animate-blob animation-delay-4000 -z-10"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 dark:bg-slate-700/50 backdrop-blur-md border border-orange-200/50 dark:border-slate-600 text-brand font-medium text-sm mb-6 shadow-sm">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-brand"></span>
                </span>
                Góc nhỏ ấm áp của những người yêu cờ
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6 leading-tight">
                Cộng đồng <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand to-yellow-500">Cờ Tướng</span> Việt Nam
                <span class="inline-block hover:rotate-12 transition-transform duration-300 cursor-default">☕</span>
            </h1>

            <p class="text-lg sm:text-xl text-slate-600 dark:text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                Ngồi xuống đây, pha một ấm trà nóng và cùng nhau thưởng thức những ván cờ hay, những thế khai cuộc sắc bén và tàn cuộc đỉnh cao.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-brand to-orange-500 hover:from-brand-hover hover:to-orange-600 rounded-2xl shadow-lg shadow-orange-500/30 transition-all duration-300 hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Vào trang quản trị
                        </a>
                    @else
                        <div class="flex items-center gap-4 bg-white/80 backdrop-blur-sm dark:bg-slate-800/80 px-8 py-3.5 rounded-2xl border border-orange-100 dark:border-slate-600 shadow-sm">
                            <span class="text-slate-800 dark:text-slate-100 font-bold flex items-center gap-2">
                                <span class="text-2xl">👋</span>
                                Chào mừng, {{ auth()->user()->name }}!
                            </span>
                            <div class="w-px h-6 bg-slate-200 dark:bg-slate-600"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                                @csrf
                                <button type="submit" class="text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 font-semibold transition-colors flex items-center gap-1">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-brand to-orange-500 hover:from-brand-hover hover:to-orange-600 rounded-2xl shadow-lg shadow-orange-500/30 transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v8l9-11h-7z"></path></svg>
                        Tham gia ngay
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-orange-50 dark:hover:bg-slate-700 border border-transparent hover:border-orange-200 dark:hover:border-slate-600 rounded-2xl shadow-sm transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Main Content Area --}}
        <div class="lg:col-span-8 space-y-8">

            {{-- Friendly Section Header & Filters --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-white dark:bg-slate-800 p-4 rounded-3xl border border-orange-50 dark:border-slate-700/50 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-800 dark:text-white flex items-center gap-3 pl-2">
                    <span class="p-2 bg-orange-100 dark:bg-orange-500/20 text-brand rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
                    </span>
                    {{ request('search') ? 'Khu vực tìm kiếm' : match(request('sort')) {
                        'oldest' => 'Hồi ức xa xưa',
                        'views_desc' => 'Được yêu thích nhất',
                        'views_asc' => 'Ít người lui tới',
                        'alpha_asc' => 'Xếp theo tên (A - Z)',
                        'alpha_desc' => 'Xếp theo tên (Z - A)',
                        default => 'Câu chuyện mới nhất',
                    } }}
                </h2>

                <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-auto group">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Tìm kiếm bài viết..."
                            class="bg-slate-50 dark:bg-slate-900 border-none focus:ring-2 focus:ring-brand focus:bg-white dark:focus:bg-slate-800 text-slate-700 dark:text-slate-300 text-sm font-medium rounded-2xl block w-full sm:w-48 focus:w-full sm:focus:w-64 pl-10 p-3 outline-none transition-all duration-300 ease-out placeholder-slate-400">
                        <svg class="w-4 h-4 absolute left-4 top-3.5 text-slate-400 group-hover:text-brand transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <select name="sort" onchange="this.form.submit()" class="bg-slate-50 dark:bg-slate-900 border-none font-medium text-slate-700 dark:text-slate-300 text-sm rounded-2xl focus:ring-2 focus:ring-brand block w-full sm:w-auto p-3 pl-4 outline-none cursor-pointer transition-all hover:bg-orange-50 dark:hover:bg-slate-800">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>🌟 Mới đăng</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>🕰️ Cũ nhất</option>
                        <option value="views_desc" {{ request('sort') == 'views_desc' ? 'selected' : '' }}>🔥 Xem nhiều</option>
                        <option value="views_asc" {{ request('sort') == 'views_asc' ? 'selected' : '' }}>🌱 Khám phá</option>
                    </select>
                </form>
            </div>

            {{-- Post Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                @forelse ($posts as $post)
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-orange-500/10 border border-transparent hover:border-orange-100 dark:border-slate-700 dark:hover:border-slate-600 overflow-hidden transition-all duration-500 transform hover:-translate-y-2">

                        <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[4/3] w-full bg-slate-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600 bg-orange-50/50 dark:bg-slate-800 group-hover:bg-orange-100/50 dark:group-hover:bg-slate-700 transition-colors duration-500">
                                    <svg class="w-20 h-20 opacity-50 group-hover:scale-110 group-hover:text-brand transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                </div>
                            @endif

                            {{-- Cozy View Badge --}}
                            <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-700 dark:text-slate-200 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm transform translate-y-0 group-hover:-translate-y-1 transition-transform duration-300">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($post->views ?? 0) }}
                            </div>
                        </a>

                        <div class="p-6 sm:p-8 flex flex-col flex-grow relative">
                            <header class="mb-4">
                                <div class="flex flex-wrap items-center gap-2 mb-4">
                                    @if($post->category)
                                        <a href="{{ route('categories.show', $post->category->slug) }}" class="text-[11px] font-bold uppercase tracking-wider text-brand bg-orange-50 dark:bg-orange-500/10 px-3 py-1 rounded-full hover:bg-orange-100 dark:hover:bg-orange-500/20 transition-colors">
                                            {{ $post->category->name }}
                                        </a>
                                    @endif
                                    <span class="flex items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $post->created_at->locale('vi')->diffForHumans() }}
                                    </span>
                                </div>

                                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white group-hover:text-brand transition-colors line-clamp-2 leading-tight">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none before:absolute before:inset-0">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                            </header>

                            <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 flex-grow leading-relaxed font-medium">
                                {!! Str::limit(strip_tags(Str::markdown($post->excerpt ?? $post->content ?? '')), 120) !!}
                            </p>

                            {{-- Read more visual cue --}}
                            <div class="mt-6 flex items-center text-brand font-bold text-sm opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                                Xem chi tiết <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-[2rem] border border-dashed border-orange-200 dark:border-slate-700 flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-orange-50 dark:bg-slate-700 rounded-full flex items-center justify-center mb-6">
                            <span class="text-4xl">🪴</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Chưa có bài viết nào!</h3>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Khu vườn này vẫn đang chờ những hạt giống đầu tiên. Hãy quay lại sau nhé!</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        {{-- Sticky Sidebar --}}
        <div class="lg:col-span-4 space-y-8 sticky top-28 self-start">

            {{-- Categories Widget --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-orange-50 dark:border-slate-700/50 p-6 sm:p-8">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="p-2 bg-orange-100 dark:bg-orange-500/20 text-brand rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </span>
                    Góc Chuyên Mục
                </h3>
                <ul class="space-y-4">
                    @forelse ($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->slug) }}" class="group flex items-center gap-4 p-3 rounded-2xl text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700 hover:text-brand dark:hover:text-brand transition-all duration-300 border border-transparent hover:border-orange-100 dark:hover:border-slate-600">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-600 bg-white dark:bg-slate-800 flex items-center justify-center transform group-hover:rotate-3 transition-transform duration-300">
                                    @if($category->featured_image)
                                        <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-orange-300 dark:text-slate-500 group-hover:text-brand">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                        </span>
                                    @endif
                                </div>

                                <div class="flex-grow flex items-center justify-between min-w-0 pr-2">
                                    <span class="font-bold truncate text-base">{{ $category->name }}</span>
                                    <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center group-hover:bg-brand group-hover:text-white transition-colors duration-300">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl text-sm font-medium text-slate-500 dark:text-slate-400 text-center border border-dashed border-slate-200 dark:border-slate-700">
                            Chưa có chuyên mục nào.
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Tags Widget --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-orange-50 dark:border-slate-700/50 p-6 sm:p-8">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="p-2 bg-orange-100 dark:bg-orange-500/20 text-brand rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </span>
                    Từ khóa nổi bật
                </h3>
                <div class="flex flex-wrap gap-2.5">
                    @forelse ($tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-slate-50 dark:bg-slate-900 text-slate-600 dark:text-slate-300 hover:bg-brand hover:text-white dark:hover:bg-brand border border-transparent hover:border-brand transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:shadow-orange-500/20">
                            #{{ $tag->name }}
                        </a>
                    @empty
                        <span class="p-4 w-full bg-slate-50 dark:bg-slate-900 rounded-2xl text-sm font-medium text-slate-500 dark:text-slate-400 text-center border border-dashed border-slate-200 dark:border-slate-700">
                            Chưa có từ khóa nào.
                        </span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
