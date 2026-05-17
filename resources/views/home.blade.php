@extends('layouts.app')

@section('title', 'Trang chủ - Cờ tướng')

@section('content')
<div class="space-y-12">

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-6 py-4 rounded-xl font-bold flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stunning Animated Hero Banner --}}
    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        @keyframes shine {
            to { background-position: 200% center; }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 7s ease-in-out 3s infinite; }
        .animate-gradient-x { animation: gradient-x 4s ease infinite; background-size: 200% 200%; }
        .animate-shine { background-size: 200% auto; animation: shine 3s linear infinite; }
    </style>

    <div x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 150)"
         class="relative bg-white/40 dark:bg-slate-800/60 backdrop-blur-3xl rounded-[3rem] shadow-[0_20px_50px_rgba(249,115,22,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] border border-white/60 dark:border-slate-700/60 overflow-hidden text-center py-16 px-6 sm:px-12 lg:py-24 transition-all duration-700 hover:shadow-[0_30px_60px_rgba(249,115,22,0.15)] group">

        {{-- Animated Background Ambient Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-[30rem] h-[30rem] bg-brand/20 dark:bg-brand/20 rounded-full blur-[6rem] animate-float opacity-70 group-hover:bg-brand/30 transition-colors duration-1000"></div>
            <div class="absolute -bottom-40 -right-40 w-[30rem] h-[30rem] bg-amber-400/20 dark:bg-yellow-500/10 rounded-full blur-[6rem] animate-float-delayed opacity-70 group-hover:bg-amber-400/30 transition-colors duration-1000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-b from-transparent via-white/50 to-white/90 dark:via-slate-800/70 dark:to-slate-900/90 z-0"></div>
        </div>

        {{-- Floating Decorative Icons --}}
        <div class="absolute top-12 left-10 lg:left-20 text-brand/10 dark:text-brand/20 animate-float pointer-events-none hidden md:block">
            <svg class="w-20 h-20 transform -rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3 4h-6l3-4zm-4 5h8v2H8V7zm-2 3h12v2H6v-2zm-2 3h16v2H4v-2zm3 3h10l-1 6H8l-1-6z"/></svg>
        </div>
        <div class="absolute bottom-16 right-10 lg:right-20 text-amber-500/10 dark:text-amber-500/20 animate-float-delayed pointer-events-none hidden md:block">
            <svg class="w-24 h-24 transform rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2 4 4 1-3 3 1 4-4-2-4 2 1-4-3-3 4-1 2-4zm-6 18h12v2H6v-2z"/></svg>
        </div>

        <div class="relative z-10 transition-all duration-1000 transform" :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-12 opacity-0'">

            {{-- Pulsing Badge --}}
            <div class="inline-flex items-center justify-center px-4 py-1.5 mb-8 rounded-full bg-white/80 dark:bg-slate-800/80 border border-brand/20 dark:border-brand/30 shadow-sm backdrop-blur-md hover:scale-105 transition-transform duration-300 cursor-default">
                <span class="flex w-2.5 h-2.5 rounded-full bg-brand animate-pulse mr-2 shadow-[0_0_8px_rgba(249,115,22,0.8)]"></span>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-widest">Nền tảng cờ tướng hàng đầu</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-slate-900 dark:text-white tracking-tight mb-6 leading-tight">
                Cộng đồng
                <span class="relative inline-block whitespace-nowrap">
                    <a target="_blank" href="https://cotuong.top" class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-brand via-rose-500 to-amber-500 animate-gradient-x hover:scale-105 inline-block transition-transform duration-300 drop-shadow-md pb-3">
                        Cờ Tướng
                    </a>
                    <span class="absolute -bottom-1 left-0 w-full h-4 bg-brand/20 dark:bg-brand/30 blur-md rounded-full -z-10"></span>
                </span>
                Việt Nam
                <svg class="w-10 h-10 sm:w-12 sm:h-12 inline-block text-amber-500 align-baseline drop-shadow-xl animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </h1>

            <p class="text-lg sm:text-xl text-slate-700 dark:text-slate-300 max-w-3xl mx-auto mb-10 font-medium leading-relaxed drop-shadow-sm">
                Nơi giao lưu, học hỏi và chia sẻ những ván cờ hay, khai cuộc sắc bén và tàn cuộc đỉnh cao. Khám phá kỳ đạo ngay hôm nay!
            </p>

            <div class="flex flex-wrap justify-center gap-5 relative z-20">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="group relative inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-brand via-rose-500 to-brand animate-shine rounded-2xl shadow-xl shadow-brand/30 transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-white/20">
                            <span class="absolute inset-0 w-full h-full bg-white/20 group-hover:scale-110 transition-transform duration-500 rounded-2xl"></span>
                            <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="relative z-10">Vào trang quản trị</span>
                        </a>
                    @else
                        <div class="flex items-center gap-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl shadow-[0_8px_20px_rgba(249,115,22,0.08)] dark:shadow-[0_8px_20px_rgba(0,0,0,0.3)] px-6 py-3 rounded-2xl border border-brand/20 dark:border-slate-600 hover:border-brand/40 hover:shadow-brand/20 transition-all duration-300 transform hover:-translate-y-1">
                            <span class="text-slate-800 dark:text-slate-200 font-bold flex items-center gap-3">
                                <span class="relative flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-brand to-orange-400 text-white shadow-md text-sm group">
                                    <span class="absolute inset-0 rounded-full bg-brand animate-ping opacity-20"></span>
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </span>
                                Chào mừng, {{ auth()->user()->name }}!
                            </span>
                            <div class="w-px h-8 bg-brand/20 dark:bg-slate-600"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 flex items-center">
                                @csrf
                                <button type="submit" class="group text-slate-500 hover:text-red-500 dark:text-slate-400 dark:hover:text-red-400 font-semibold transition-colors flex items-center gap-1.5">
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-brand via-orange-400 to-brand animate-shine rounded-2xl shadow-xl shadow-brand/30 transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-white/20">
                        <svg class="w-5 h-5 relative z-10 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v8l9-11h-7z"></path></svg>
                        <span class="relative z-10">Đăng ký ngay</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-bold text-slate-800 dark:text-slate-200 bg-white/80 backdrop-blur-md hover:bg-orange-50 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-2xl shadow-[0_8px_20px_rgba(249,115,22,0.06)] border border-brand/20 dark:border-slate-600 transition-all duration-300 hover:-translate-y-1 hover:border-brand/50 hover:text-brand hover:shadow-brand/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Đăng nhập
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <div class="flex flex-col gap-5 border-b border-brand/10 dark:border-slate-700 pb-5">

                {{-- Search & Filter --}}
                <form action="{{ route('home') }}" method="GET" class="relative z-30 w-full">
                    <div class="flex flex-col sm:flex-row items-center w-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-[2rem] sm:rounded-full shadow-[0_8px_30px_rgba(249,115,22,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-brand/10 dark:border-slate-700/80 p-1.5 gap-2 transition-all duration-500 hover:shadow-[0_15px_40px_rgba(249,115,22,0.15)] hover:border-brand/30 focus-within:ring-4 focus-within:ring-brand/10 focus-within:border-brand">

                        <div class="relative flex items-center w-full flex-grow group/search">
                            <div class="absolute left-4 text-brand/50 group-focus-within/search:text-brand transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>

                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Bạn muốn tìm gì hôm nay?"
                                class="w-full bg-transparent border-none outline-none focus:ring-0 text-slate-900 dark:text-slate-100 placeholder-slate-400 pl-11 pr-14 py-2.5 text-[15px] font-bold transition-all duration-300 placeholder:font-normal [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s]">

                            <button type="submit" aria-label="Tìm kiếm" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/50 group-focus-within/search:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                        <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-brand/10 to-transparent"></div>

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
                                class="flex items-center justify-between w-full sm:w-[220px] bg-orange-50/80 dark:bg-slate-900/50 hover:bg-brand dark:hover:bg-brand text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-[1.5rem] sm:rounded-full px-5 py-2.5 text-sm font-bold transition-all duration-300 group/btn">

                                <div class="flex items-center gap-2.5">
                                    <div class="p-1 rounded-md bg-brand/10 group-hover/btn:bg-white/20 text-brand group-hover/btn:text-white transition-colors">
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
                                class="absolute right-0 z-50 w-full sm:w-[240px] mt-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-brand/10 dark:border-slate-700/80 rounded-[1.5rem] shadow-[0_20px_50px_rgba(249,115,22,0.15)] overflow-hidden p-2 origin-top-right"
                                style="display: none;">

                                <div class="space-y-1">
                                    <template x-for="(label, value) in options" :key="value">
                                        <button type="button" @click="selectOption(value)"
                                            class="w-full text-left px-4 py-3 text-[14px] rounded-xl flex items-center justify-between transition-all duration-200"
                                            :class="{
                                                'bg-brand text-white font-bold shadow-md shadow-brand/20 transform scale-[1.02]': selected === value,
                                                'text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700/50 hover:text-brand dark:hover:text-brand font-medium': selected !== value
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

                <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2 mt-2">
                    <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
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
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgba(249,115,22,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-brand/5 dark:border-slate-700/80 overflow-hidden hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] transition-all duration-500 transform hover:-translate-y-2 relative">

                        <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[1200/630] w-full bg-orange-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-orange-100 to-white dark:from-slate-800 dark:to-slate-900 text-brand/30 dark:text-slate-600 transition-colors duration-500 group-hover:text-brand/50">
                                    <svg class="w-16 h-16 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                            <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-800 dark:text-slate-200 text-xs font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5 shadow-[0_4px_10px_rgba(249,115,22,0.2)] transform group-hover:-translate-y-1 transition-transform duration-500">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($post->views ?? 0) }}
                            </div>
                        </a>

                        <div class="p-6 sm:p-8 flex flex-col flex-grow relative bg-white dark:bg-slate-800 z-10 rounded-b-[2rem]">

                            <div class="absolute -top-5 left-6 sm:left-8">
                                <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-brand to-orange-400 text-white text-[11px] uppercase tracking-wider font-black px-4 py-2.5 rounded-xl shadow-lg shadow-brand/40 transform group-hover:-translate-y-1 transition-transform duration-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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

                            <div class="flex items-center justify-between mt-auto pt-5 border-t border-brand/10 dark:border-slate-700/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-orange-50 dark:bg-brand/20 flex items-center justify-center text-brand font-black text-sm shadow-sm border border-brand/10">
                                        {{ mb_substr($post->author->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">Tác giả</span>
                                        <span class="text-sm font-black text-slate-800 dark:text-slate-200">{{ $post->author->name ?? 'Ẩn danh' }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-1.5 text-sm font-black text-brand opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 focus:outline-none">
                                    Đọc ngay
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-2xl border border-brand/10 dark:border-slate-700 flex flex-col items-center shadow-sm">
                        <svg class="w-12 h-12 text-brand/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-slate-500 dark:text-slate-400 text-lg font-bold">Chưa có bài viết nào được đăng.</p>
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
            {{-- Widget Đặc biệt: English Articles --}}
            <div class="bg-slate-900 dark:bg-slate-950 rounded-[2rem] shadow-[0_15px_30px_rgba(0,0,0,0.2)] border border-slate-700/80 p-1.5 relative overflow-hidden group/enwidget transform hover:-translate-y-1 transition-all duration-500">
                {{-- Lưu ý: Sửa 'english-articles' thành slug thực tế của bạn --}}
                <a href="{{ route('categories.show', 'english-articles') }}" class="block relative rounded-[1.5rem] overflow-hidden">

                    {{-- Hình ảnh Banner (Sửa lại đường dẫn ảnh cho đúng) --}}
                    <img src="{{ asset('storage/categories/xiangqi-english-banner.jpg') }}" alt="Xiangqi English Articles" class="w-full aspect-[1200/630] object-cover transform group-hover/enwidget:scale-105 transition-transform duration-700 ease-out">

                    {{-- Lớp phủ tối màu (Overlay) --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                    {{-- Nội dung chữ --}}
                    <div class="absolute bottom-0 left-0 w-full p-5">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="flex w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                            <span class="text-blue-300 text-[11px] font-black uppercase tracking-widest">Global Readers</span>
                        </div>
                        <h3 class="text-white text-xl font-black leading-tight group-hover/enwidget:text-blue-400 transition-colors">
                            English Articles
                        </h3>
                        <div class="mt-3 flex items-center gap-1.5 text-sm font-bold text-white/70 group-hover/enwidget:text-white transition-colors">
                            Explore guides & tactics
                            <svg class="w-4 h-4 transform group-hover/enwidget:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
            </div>
            {{-- Widget Chuyên mục --}}
            <div class="bg-white/90 backdrop-blur-xl dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgba(249,115,22,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-brand/10 dark:border-slate-700/80 p-5 sm:p-6 relative overflow-hidden group/widget">
                <div class="absolute -top-12 -right-12 w-40 h-40 bg-brand/10 dark:bg-brand/10 rounded-full blur-3xl pointer-events-none group-hover/widget:bg-brand/20 transition-colors duration-700"></div>

                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4 flex items-center gap-2.5 relative z-10">
                    <div class="p-2 bg-brand/10 dark:bg-brand/20 border border-brand/20 rounded-xl text-brand shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                    Chuyên mục
                </h3>

                <ul class="space-y-1 relative z-10">
                    @forelse ($categories as $category)
                        @if($category->slug !== 'english-articles')
                            <li>
                                <a href="{{ route('categories.show', $category->slug) }}" class="group flex items-center gap-3 p-2 rounded-2xl hover:bg-orange-50 dark:hover:bg-slate-700/50 border border-transparent hover:border-brand/10 dark:hover:border-slate-600 transition-all duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-xl overflow-hidden shadow-sm group-hover:shadow-[0_4px_10px_rgba(249,115,22,0.2)] border border-brand/10 dark:border-slate-700 bg-white dark:bg-slate-900 flex items-center justify-center transition-all duration-300">
                                        @if($category->featured_image)
                                            <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                                        @else
                                            <span class="text-brand/30 dark:text-slate-600 group-hover:text-brand transition-colors duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex-grow flex items-center justify-between min-w-0">
                                        <span class="font-bold text-[14px] text-slate-700 dark:text-slate-200 group-hover:text-brand transition-colors truncate pr-2">{{ $category->name }}</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @empty
                        <li class="p-4 text-sm text-slate-500 dark:text-slate-400 font-bold text-center bg-orange-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-brand/20 dark:border-slate-700">
                            Chưa có chuyên mục.
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- Widget Thẻ nổi bật --}}
            <div class="bg-white/90 backdrop-blur-xl dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgba(249,115,22,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-brand/10 dark:border-slate-700/80 p-5 sm:p-6 relative overflow-hidden group/widget">
                <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-brand/10 dark:bg-brand/10 rounded-full blur-3xl pointer-events-none group-hover/widget:bg-brand/20 transition-colors duration-700"></div>

                <h3 class="text-lg font-black text-slate-900 dark:text-white mb-4 flex items-center gap-2.5 relative z-10">
                    <div class="p-2 bg-brand/10 dark:bg-brand/20 border border-brand/20 rounded-xl text-brand shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    Thẻ nổi bật
                </h3>

                <div class="flex flex-wrap gap-2 relative z-10">
                    @forelse ($tags as $tag)
                        <a href="{{ route('tags.show', $tag->slug) }}" class="px-3 py-1.5 rounded-xl text-xs font-black bg-orange-50 dark:bg-slate-900 border border-brand/10 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-gradient-to-r hover:from-brand hover:to-orange-400 hover:text-white dark:hover:bg-brand dark:hover:text-white hover:border-transparent shadow-sm hover:shadow-[0_4px_10px_rgba(249,115,22,0.3)] transition-all duration-300 transform hover:-translate-y-0.5">
                            #{{ $tag->name }}
                        </a>
                    @empty
                        <span class="text-sm font-bold text-slate-500 dark:text-slate-400 text-center w-full bg-orange-50 dark:bg-slate-900/50 py-3 rounded-2xl border border-dashed border-brand/20 dark:border-slate-700">
                            Chưa có thẻ nào.
                        </span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
