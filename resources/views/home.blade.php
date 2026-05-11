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

    <div class="relative bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-[0_15px_40px_rgba(249,115,22,0.1)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.4)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden text-center py-12 px-6 sm:px-12 sm:py-16 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)]">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -left-32 w-72 h-72 bg-brand/10 dark:bg-brand/20 rounded-full blur-[3rem]"></div>
            <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-yellow-400/10 dark:bg-yellow-400/5 rounded-full blur-[3rem]"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/50 to-transparent dark:via-slate-800/50"></div>
        </div>

        <div class="relative z-10">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight mb-4">
                Cộng đồng <a target="_blank" href="https://cotuong.top" class="text-brand inline-block transform hover:scale-105 hover:opacity-80 transition-all duration-500 ease-in-out">Cờ Tướng</a> Việt Nam
                <svg class="w-8 h-8 sm:w-10 sm:h-10 inline-block text-yellow-500 align-text-bottom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-8 font-medium leading-relaxed">
                Nơi giao lưu, học hỏi và chia sẻ những ván cờ hay, khai cuộc sắc bén và tàn cuộc đỉnh cao.
                <svg class="w-5 h-5 inline-block text-yellow-400 align-text-bottom ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </p>

            <div class="flex flex-wrap justify-center gap-4 relative z-20">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-bold text-white bg-brand hover:bg-brand-hover rounded-2xl shadow-lg shadow-brand/30 transition-all duration-300 hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Vào trang quản trị
                        </a>
                    @else
                        <div class="flex items-center gap-4 bg-white dark:bg-slate-800 shadow-[0_4px_15px_rgba(0,0,0,0.05)] dark:shadow-[0_4px_15px_rgba(0,0,0,0.2)] px-6 py-3 rounded-2xl border border-slate-100 dark:border-slate-700 hover:border-brand/30 transition-colors duration-300">
                            <span class="text-slate-800 dark:text-slate-200 font-bold flex items-center gap-2">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand/10 text-brand text-sm">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </span>
                                Chào mừng, {{ auth()->user()->name }}!
                            </span>
                            <div class="w-px h-6 bg-slate-200 dark:bg-slate-700"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                                @csrf
                                <button type="submit" class="text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 font-semibold transition-colors flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-bold text-white bg-brand hover:bg-brand-hover rounded-2xl shadow-lg shadow-brand/30 transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v8l9-11h-7z"></path></svg>
                        Đăng ký ngay
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-base font-bold text-slate-700 dark:text-slate-200 bg-white hover:bg-slate-50 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-2xl shadow-[0_4px_15px_rgba(0,0,0,0.05)] border border-slate-100 dark:border-slate-700 transition-all duration-300 hover:-translate-y-1 hover:border-brand/30 hover:text-brand">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <div class="flex flex-col gap-5 border-b border-slate-200 dark:border-slate-700 pb-5">

                {{-- Thanh tìm kiếm và bộ lọc chiếm toàn bộ chiều rộng --}}
                <form action="{{ route('home') }}" method="GET" class="relative z-30 w-full">
                    <div class="flex flex-col sm:flex-row items-center w-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-[2rem] sm:rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-200/80 dark:border-slate-700/80 p-1.5 gap-2 transition-all duration-500 hover:shadow-[0_15px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_15px_40px_rgba(249,115,22,0.1)] hover:border-brand/40 focus-within:ring-4 focus-within:ring-brand/10 focus-within:border-brand dark:focus-within:border-brand">

                        {{-- Khu vực Tìm kiếm (Dãn tối đa để lấp đầy khoảng trống) --}}
                        <div class="relative flex items-center w-full flex-grow group/search">
                            <div class="absolute left-4 text-brand/60 group-focus-within/search:text-brand transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            {{-- Ô nhập liệu với fix lỗi nền trắng (autofill) --}}
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Bạn muốn tìm gì hôm nay?"
                                class="w-full bg-transparent border-none outline-none focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 pl-11 pr-14 py-2.5 text-[15px] font-medium transition-all duration-300 placeholder:font-normal [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s] [&:-webkit-autofill]:[-webkit-text-fill-color:#1e293b] dark:[&:-webkit-autofill]:[-webkit-text-fill-color:#f8fafc]">

                            {{-- Nút Tìm kiếm --}}
                            <button type="submit" aria-label="Tìm kiếm" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white dark:bg-brand/20 dark:hover:bg-brand transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/50 group-focus-within/search:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                        {{-- Vạch chia cách --}}
                        <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-slate-200 dark:via-slate-700 to-transparent"></div>

                        {{-- Khu vực Sắp xếp (Không thay đổi logic, chỉ khóa chiều rộng cố định) --}}
                        <div x-data="{
                                open: false,
                                selected: '{{ request('sort', 'latest') }}',
                                options: {
                                    'latest': 'Mới nhất',
                                    'oldest': 'Cũ nhất',
                                    'views_desc': 'Lượt xem (Cao - Thấp)',
                                    'views_asc': 'Lượt xem (Thấp - Cao)',
                                    'alpha_asc': 'Tên (A - Z)',
                                    'alpha_desc': 'Tên (Z - A)'
                                },
                                selectOption(value) {
                                    this.selected = value;
                                    this.open = false;
                                    setTimeout(() => this.$el.closest('form').submit(), 150);
                                }
                            }" class="relative w-full sm:w-auto shrink-0" @click.away="open = false">

                            <input type="hidden" name="sort" :value="selected">

                            <button type="button" @click="open = !open"
                                class="flex items-center justify-between w-full sm:w-[220px] bg-slate-50 dark:bg-slate-900/50 hover:bg-brand dark:hover:bg-brand text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-[1.5rem] sm:rounded-full px-5 py-2.5 text-sm font-bold transition-all duration-300 ease-out cursor-pointer group/btn">

                                <div class="flex items-center gap-2.5">
                                    <div class="p-1 rounded-md bg-slate-200/50 dark:bg-slate-700/50 group-hover/btn:bg-white/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                                    </div>
                                    <span x-text="options[selected]" class="truncate tracking-wide"></span>
                                </div>

                                <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover/btn:scale-110" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                class="absolute right-0 z-50 w-full sm:w-[240px] mt-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-slate-100 dark:border-slate-700/80 rounded-[1.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] overflow-hidden p-2 origin-top-right"
                                style="display: none;">

                                <div class="space-y-1">
                                    <template x-for="(label, value) in options" :key="value">
                                        <button type="button" @click="selectOption(value)"
                                            class="w-full text-left px-4 py-3 text-[14px] rounded-xl flex items-center justify-between transition-all duration-200"
                                            :class="{
                                                'bg-brand text-white font-bold shadow-md shadow-brand/20 transform scale-[1.02]': selected === value,
                                                'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-brand dark:hover:text-brand font-medium': selected !== value
                                            }">
                                            <span x-text="label"></span>
                                            <svg x-show="selected === value" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Tiêu đề được đẩy xuống dòng dưới form --}}
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2 mt-2">
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
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($posts as $post)
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_20px_40px_rgba(249,115,22,0.12)] hover:border-brand/40 dark:hover:border-brand/40 transition-all duration-500 transform hover:-translate-y-2 relative">

                        <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[1200/630] w-full bg-slate-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
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
                <div class="mt-12 flex justify-center">
                    {{ $posts->onEachSide(1)->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="space-y-6 sticky top-28 self-start lg:block">

            {{-- Widget Chuyên mục --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 p-5 sm:p-6 relative overflow-hidden group/widget">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-brand/5 dark:bg-brand/10 rounded-full blur-3xl pointer-events-none group-hover/widget:bg-brand/15 transition-colors duration-700"></div>

                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4 flex items-center gap-2.5 relative z-10">
                    <div class="p-2 bg-brand-light dark:bg-brand/20 rounded-xl text-brand shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                    Chuyên mục
                </h3>

                <ul class="space-y-1 relative z-10">
                    @forelse ($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category->slug) }}" class="group flex items-center gap-3 p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-700/50 border border-transparent hover:border-slate-100 dark:hover:border-slate-600 transition-all duration-300">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl overflow-hidden shadow-sm group-hover:shadow-md border border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-900 flex items-center justify-center transition-all duration-300">
                                    @if($category->featured_image)
                                        <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                                    @else
                                        <span class="text-slate-300 dark:text-slate-600 group-hover:text-brand transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </span>
                                    @endif
                                </div>

                                <div class="flex-grow flex items-center justify-between min-w-0">
                                    <span class="font-bold text-[14px] text-slate-700 dark:text-slate-200 group-hover:text-brand transition-colors truncate pr-2">{{ $category->name }}</span>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="p-4 text-sm text-slate-500 dark:text-slate-400 font-medium text-center bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                            Chưa có chuyên mục.
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Widget Thẻ nổi bật --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 p-5 sm:p-6 relative overflow-hidden group/widget">
                <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-brand/5 dark:bg-brand/10 rounded-full blur-3xl pointer-events-none group-hover/widget:bg-brand/15 transition-colors duration-700"></div>

                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4 flex items-center gap-2.5 relative z-10">
                    <div class="p-2 bg-brand-light dark:bg-brand/20 rounded-xl text-brand shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    Thẻ nổi bật
                </h3>

                <div class="flex flex-wrap gap-2 relative z-10">
                    @forelse ($tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-brand hover:text-white dark:hover:bg-brand dark:hover:text-white hover:border-brand dark:hover:border-brand shadow-sm hover:shadow-[0_4px_10px_rgba(249,115,22,0.25)] transition-all duration-300 transform hover:-translate-y-0.5">
                            #{{ $tag->name }}
                        </a>
                    @empty
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400 text-center w-full bg-slate-50 dark:bg-slate-900/50 py-3 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                            Chưa có thẻ nào.
                        </span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
