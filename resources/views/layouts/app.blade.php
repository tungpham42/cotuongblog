<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: document.documentElement.classList.contains('dark'),
          initTheme() {
              this.$watch('darkMode', val => {
                  localStorage.setItem('darkMode', val);
                  window.dispatchEvent(new CustomEvent('theme-changed', { detail: val }));
              });
              window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                  if (!localStorage.getItem('darkMode')) {
                      this.darkMode = e.matches;
                  }
              });
          }
      }"
      x-init="initTheme()"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO: Optimized Title Tag Formulation --}}
    <title>@hasSection('title') @yield('title') | Cộng Đồng Cờ Tướng @else Cộng Đồng Cờ Tướng Việt Nam @endif</title>

    {{-- SEO: Canonical URL to prevent duplicate content indexing --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- SEO: Meta Robots Directives for optimal crawling --}}
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO: Standard Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng. Học hỏi từ các kỳ thủ hàng đầu và tham gia cộng đồng yêu thích cờ tướng.')">
    <meta name="keywords" content="cờ tướng, blog cờ tướng, chiến thuật cờ tướng, tin tức cờ tướng, học cờ tướng, cộng đồng cờ tướng">
    <meta name="author" content="Tùng Phạm">

    {{-- SEO: Complete Open Graph Protocol (Facebook, LinkedIn, Zalo) --}}
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@hasSection('title') @yield('title') | Cộng Đồng Cờ Tướng @else Cộng Đồng Cờ Tướng Việt Nam @endif">
    <meta property="og:description" content="@yield('meta_description', 'Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng. Học hỏi từ các kỳ thủ hàng đầu và tham gia cộng đồng yêu thích cờ tướng.')">
    <meta property="og:image" content="@yield('og_image', asset('img/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Cờ tướng 2 người')">

    {{-- SEO: Twitter Cards for better visibility on X/Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@hasSection('title') @yield('title') | Cộng Đồng Cờ Tướng @else Cộng Đồng Cờ Tướng Việt Nam @endif">
    <meta name="twitter:description" content="@yield('meta_description', 'Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng.')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og_image.jpg'))">

    {{-- Favicons & App Icons --}}
    <link rel="apple-touch-icon" href="{{ url('/') }}/img/app-icons/apple-touch-icon-iphone-game.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/') }}/img/app-icons/apple-touch-icon-ipad-game.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/') }}/img/app-icons/apple-touch-icon-iphone-retina-game.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/') }}/img/app-icons/apple-touch-icon-ipad-retina-game.png">
    <link rel="icon" sizes="32x32" href="{{ url('/') }}/img/favicon-32x32-game.png">

    {{-- Performance: Preconnect to Font APIs --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#f97316',
                            hover: '#ea580c',
                            light: '#ffedd5',
                        }
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @guest
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-QEW6K9YPY7"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-QEW6K9YPY7');
        </script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536" crossorigin="anonymous"></script>
    @endguest
    {{-- SEO: Base Schema.org JSON-LD dynamically generated via Spatie --}}
    {!! $globalSchema->toScript() !!}
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-sans antialiased transition-colors duration-300">
    {{-- Redesigned Floating Navbar --}}
    <div class="sticky top-4 z-50 px-4 sm:px-6 lg:px-8 pointer-events-none">
        <nav class="pointer-events-auto max-w-7xl mx-auto bg-white/85 dark:bg-slate-800/85 backdrop-blur-xl shadow-lg shadow-brand/5 border border-white/50 dark:border-slate-700/50 rounded-2xl transition-all duration-300" x-data="{ open: false }">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <a href="/" title="Trang chủ Cờ Tướng" class="group flex items-center gap-3">
                            <div class="p-2.5 bg-gradient-to-br from-brand-light to-white dark:from-slate-700 dark:to-slate-800 rounded-xl shadow-sm border border-brand/20 dark:border-slate-600 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-brand" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                            </div>
                            <span class="text-2xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-brand to-orange-400 group-hover:from-orange-500 group-hover:to-red-500 transition-all duration-300">Cờ tướng</span>
                        </a>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:space-x-2">
                        @auth
                            <a href="{{ route('posts.index') }}" class="px-4 py-2 text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand hover:bg-brand/10 dark:hover:bg-slate-700/50 rounded-xl font-semibold transition-all duration-300">Bài viết</a>

                            <div class="relative ml-2" x-data="{ dropdownOpen: false }">
                                <button aria-expanded="dropdownOpen" aria-label="Menu người dùng" @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-2 pl-3 pr-2 py-1.5 bg-slate-50 dark:bg-slate-700/50 border border-slate-100 dark:border-slate-600 rounded-full hover:bg-brand-light/50 dark:hover:bg-slate-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/30">
                                    <div class="w-7 h-7 rounded-full bg-brand flex items-center justify-center text-white font-bold text-xs shadow-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</span>
                                    <svg aria-hidden="true" :class="{'rotate-180': dropdownOpen}" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div x-show="dropdownOpen"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                    x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                    class="absolute right-0 mt-3 w-64 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700/50 z-50 overflow-hidden"
                                    style="display: none;">

                                    <div class="px-4 py-3 flex items-center gap-3 border-b border-slate-50 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50">
                                        <div class="w-10 h-10 rounded-full bg-brand/10 dark:bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email ?? 'Thành viên' }}</p>
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        @if(auth()->user()->is_admin)
                                            <div class="px-3 py-2 text-[10px] font-black text-brand uppercase tracking-wider">Khu vực Quản trị</div>

                                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/5 dark:hover:bg-slate-700 hover:text-brand dark:hover:text-brand font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                                Tổng quan
                                            </a>
                                            <a href="{{ route('categories.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/5 dark:hover:bg-slate-700 hover:text-brand font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                Chuyên mục
                                            </a>
                                            <a href="{{ route('tags.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/5 dark:hover:bg-slate-700 hover:text-brand font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                                Thẻ (Tags)
                                            </a>
                                            <a href="{{ route('users.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/5 dark:hover:bg-slate-700 hover:text-brand font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                Người dùng
                                            </a>
                                            <a href="{{ route('comments.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/5 dark:hover:bg-slate-700 hover:text-brand font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                                Bình luận
                                            </a>
                                            <div class="border-t border-slate-100 dark:border-slate-700/50 my-1"></div>
                                        @endif

                                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-600 dark:text-slate-300 hover:text-brand font-bold rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-300">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-brand to-orange-500 hover:from-orange-500 hover:to-red-500 text-white font-bold rounded-xl shadow-md shadow-brand/30 hover:shadow-lg hover:shadow-brand/40 hover:-translate-y-0.5 transition-all duration-300">Đăng ký ngay</a>
                        @endauth

                        <div class="pl-2 border-l border-slate-200 dark:border-slate-700 ml-2">
                            <button aria-label="Chuyển đổi chế độ sáng/tối" @click="darkMode = !darkMode" class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 hover:text-brand transition-all duration-300">
                                <svg aria-hidden="true" x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                                <svg aria-hidden="true" x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center sm:hidden gap-3">
                        <button aria-label="Chuyển đổi chế độ sáng/tối" @click="darkMode = !darkMode" class="p-2 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-300">
                            <svg aria-hidden="true" x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            <svg aria-hidden="true" x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </button>
                        <button aria-label="Mở menu điều hướng" @click="open = !open" class="p-2 rounded-xl bg-brand/10 text-brand hover:bg-brand/20 focus:outline-none transition-colors">
                            <svg aria-hidden="true" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="sm:hidden border-t border-slate-100 dark:border-slate-700/50 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-b-2xl overflow-hidden"
                style="display: none;">
                <div class="px-4 pt-3 pb-5 space-y-2">
                    @auth
                        <div class="flex items-center gap-3 px-3 py-3 mb-2 bg-slate-50 dark:bg-slate-700/30 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-brand flex items-center justify-center text-white font-bold text-lg shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email ?? 'Thành viên' }}</p>
                            </div>
                        </div>

                        <a href="{{ route('posts.index') }}" class="block px-4 py-3 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-semibold transition-colors">Bài viết</a>

                        @if(auth()->user()->is_admin)
                            <div class="px-4 pt-4 pb-1 text-xs font-black text-brand uppercase tracking-wider">Quản trị</div>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/30 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-medium">Tổng quan</a>
                                <a href="{{ route('categories.index') }}" class="block px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/30 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-medium">Chuyên mục</a>
                                <a href="{{ route('tags.index') }}" class="block px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/30 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-medium">Thẻ (Tags)</a>
                                <a href="{{ route('users.index') }}" class="block px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/30 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-medium">Người dùng</a>
                                <a href="{{ route('comments.index') }}" class="block px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-700/30 text-sm text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand font-medium col-span-2">Bình luận</a>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full text-center block px-4 py-3 rounded-xl bg-red-50 dark:bg-red-500/10 text-red-500 hover:bg-red-100 font-bold transition-colors">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block text-center px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-700/50 text-slate-700 dark:text-slate-200 font-bold mb-2">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="block text-center px-4 py-3 rounded-xl bg-gradient-to-r from-brand to-orange-500 text-white font-bold shadow-md shadow-brand/30">Đăng ký ngay</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @stack('scripts')

    <div x-data="{ showTop: false, showBottom: true }"
        x-init="
            const toggleButtons = () => {
                showTop = window.scrollY > 250;
                showBottom =
                    (window.innerHeight + window.scrollY)
                    < (document.documentElement.scrollHeight - 250);
            };

            toggleButtons();
            window.addEventListener('scroll', toggleButtons);
            window.addEventListener('resize', toggleButtons);
        "
        class="fixed bottom-6 right-6 z-50 flex flex-col gap-3">

        <button aria-label="Cuộn lên đầu trang"
                x-show="showTop"
                x-transition
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="h-12 w-12 rounded-full bg-brand text-white shadow-lg hover:bg-brand-hover flex items-center justify-center">
            <svg aria-hidden="true" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
        </button>

        <button aria-label="Cuộn xuống cuối trang"
                x-show="showBottom"
                x-transition
                @click="window.scrollTo({
                    top: document.documentElement.scrollHeight,
                    behavior: 'smooth'
                })"
                class="h-12 w-12 rounded-full bg-slate-800 dark:bg-slate-700 text-white shadow-lg flex items-center justify-center">
            <svg aria-hidden="true" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </button>

    </div>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#0f172a',
            });
        });
    </script>
    @endif
</body>
</html>
