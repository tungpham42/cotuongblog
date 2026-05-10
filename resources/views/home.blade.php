@extends('layouts.app')

@section('title', 'Trang chủ - Cờ tướng')

@section('content')
<div class="space-y-12">

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-6 py-4 rounded-xl font-medium flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden text-center py-20 px-6 sm:px-12">
        <div class="absolute inset-0 bg-gradient-to-b from-brand/5 to-transparent dark:from-brand/10"></div>

        <div class="relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-6">
                Cộng đồng <span class="text-brand">Cờ Tướng</span> Việt Nam
                <svg class="w-10 h-10 inline-block text-yellow-500 align-text-bottom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </h1>
            <p class="text-lg sm:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-10">
                Nơi giao lưu, học hỏi và chia sẻ những ván cờ hay, khai cuộc sắc bén và tàn cuộc đỉnh cao.
                <svg class="w-6 h-6 inline-block text-yellow-400 align-text-bottom ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-white bg-brand hover:bg-brand-hover rounded-xl shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Vào trang quản trị
                        </a>
                    @else
                        <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-700/50 px-6 py-3 rounded-xl border border-slate-100 dark:border-slate-600">
                            <span class="text-slate-700 dark:text-slate-200 font-semibold flex items-center gap-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path></svg>
                                Chào mừng, {{ auth()->user()->name }}!
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-300 font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-white bg-brand hover:bg-brand-hover rounded-xl shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v8l9-11h-7z"></path></svg>
                        Đăng ký ngay
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
                    {{ request('search') ? 'Kết quả tìm kiếm' : match(request('sort')) {
                        'oldest' => 'Bài viết cũ nhất',
                        'views_desc' => 'Bài viết xem nhiều nhất',
                        'views_asc' => 'Bài viết xem ít nhất',
                        'alpha_asc' => 'Bài viết theo tên (A - Z)',
                        'alpha_desc' => 'Bài viết theo tên (Z - A)',
                        default => 'Bài viết mới nhất',
                    } }}
                </h2>

                <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">

                    {{-- Thanh tìm kiếm tinh tế (Mở rộng mượt mà khi focus) --}}
                    <div class="relative w-full sm:w-auto group">
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Tìm bài viết..."
                            class="bg-transparent border border-transparent hover:border-slate-200 dark:hover:border-slate-700 focus:bg-white dark:focus:bg-slate-800 focus:border-brand dark:focus:border-brand focus:shadow-sm text-slate-700 dark:text-slate-300 text-sm rounded-lg block w-full sm:w-36 focus:w-full sm:focus:w-56 pl-9 p-2.5 outline-none transition-all duration-300 ease-out placeholder-slate-400 cursor-pointer focus:cursor-text">
                        <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400 group-hover:text-brand transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div x-data="{
                            open: false,
                            selected: '{{ request('sort', 'latest') }}',
                            options: {
                                'latest': 'Mới nhất',
                                'oldest': 'Cũ nhất',
                                'views_desc': 'Lượt xem (Nhiều nhất)',
                                'views_asc': 'Lượt xem (Ít nhất)',
                                'alpha_asc': 'Tên A - Z',
                                'alpha_desc': 'Tên Z - A'
                            },
                            selectOption(value) {
                                this.selected = value;
                                this.open = false;
                                setTimeout(() => this.$el.closest('form').submit(), 50);
                            }
                        }" class="relative w-full sm:w-56" @click.away="open = false">

                        <input type="hidden" name="sort" :value="selected">

                        <button type="button" @click="open = !open" class="flex items-center justify-between w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-2 focus:ring-brand focus:border-brand p-2.5 outline-none cursor-pointer transition-colors">
                            <span x-text="options[selected]" class="truncate"></span>
                            <svg class="w-4 h-4 ml-2 shrink-0 transition-transform duration-200 text-slate-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-50 w-full mt-1.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-lg overflow-hidden"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="(label, value) in options" :key="value">
                                    <div @click="selectOption(value)"
                                        class="px-4 py-2.5 text-sm cursor-pointer hover:bg-brand/5 hover:text-brand dark:hover:bg-brand/10 transition-colors flex items-center justify-between"
                                        :class="{'text-brand bg-brand/5 dark:bg-brand/10 font-medium': selected === value, 'text-slate-700 dark:text-slate-300': selected !== value}">
                                        <span x-text="label"></span>
                                        <svg x-show="selected === value" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($posts as $post)
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_20px_40px_rgba(249,115,22,0.12)] hover:border-brand/40 dark:hover:border-brand/40 transition-all duration-500 transform hover:-translate-y-2 relative">

                        <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[16/10] w-full bg-slate-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 text-slate-300 dark:text-slate-600 transition-colors duration-500 group-hover:text-brand/50">
                                    <svg class="w-16 h-16 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                            <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-800 dark:text-slate-200 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5 shadow-md transform group-hover:-translate-y-1 transition-transform duration-500">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($post->views ?? 0) }}
                            </div>
                        </a>

                        <div class="p-6 sm:p-8 flex flex-col flex-grow relative bg-white dark:bg-slate-800 z-10 rounded-b-[2rem]">

                            <div class="absolute -top-5 left-6 sm:left-8">
                                <span class="inline-flex items-center gap-1.5 bg-brand text-white text-[11px] uppercase tracking-wider font-extrabold px-4 py-2.5 rounded-xl shadow-lg shadow-brand/30 transform group-hover:-translate-y-1 transition-transform duration-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $post->created_at->locale('vi')->diffForHumans() }}
                                </span>
                            </div>

                            <header class="mb-4 mt-3">
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white group-hover:text-brand transition-colors duration-300 line-clamp-2 leading-tight">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none focus:text-brand">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                            </header>

                            <p class="text-slate-600 dark:text-slate-400 text-[15px] line-clamp-3 flex-grow leading-relaxed mb-6 font-medium">
                                {!! Str::limit(strip_tags(Str::markdown($post->excerpt ?? $post->content ?? '')), 120) !!}
                            </p>

                            <div class="flex items-center justify-between mt-auto pt-5 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-brand-light dark:bg-brand/20 flex items-center justify-center text-brand font-bold text-sm shadow-sm">
                                        {{ mb_substr($post->author->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Tác giả</span>
                                        <span class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $post->author->name ?? 'Ẩn danh' }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-1.5 text-sm font-bold text-brand opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 focus:outline-none">
                                    Đọc ngay
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 flex flex-col items-center">
                        <svg class="w-12 h-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
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
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    Chuyên mục
                </h3>
                <ul class="space-y-3">
                    @forelse ($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->slug) }}" class="group flex items-center gap-3 p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-brand/10 hover:text-brand transition-all duration-200">
                                <div class="flex-shrink-0 w-11 h-11 rounded-lg overflow-hidden border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 flex items-center justify-center">
                                    @if($category->featured_image)
                                        <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <span class="text-slate-400 group-hover:text-brand group-hover:scale-110 transition-transform duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                        </span>
                                    @endif
                                </div>

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
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Thẻ nổi bật
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
