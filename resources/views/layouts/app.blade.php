<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cờ tướng')</title>
    <meta name="description" content="Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng. Học hỏi từ các kỳ thủ hàng đầu và tham gia cộng đồng yêu thích cờ tướng.">
    <meta name="keywords" content="cờ tướng, blog cờ tướng, chiến thuật cờ tướng, tin tức cờ tướng, học cờ tướng, cộng đồng cờ tướng">
    <meta name="author" content="Tùng Phạm">
    <meta property="og:title" content="@yield('title', 'Cờ tướng')">
    <meta property="og:description" content="Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng. Học hỏi từ các kỳ thủ hàng đầu và tham gia cộng đồng yêu thích cờ tướng.">
    <meta property="og:image" content="{{ (isset($post) && $post->featured_image) ? asset('storage/' . $post->featured_image) : url('/') . '/img/1200x630.jpg' }}">
    <meta property="og:image:width" content="1200" >
    <meta property="og:image:height" content="630" >
    <meta property="og:image:alt" content="Cờ tướng 2 người" >
    <link rel="apple-touch-icon" href="{{ url('/') }}/img/app-icons/apple-touch-icon-iphone-game.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/') }}/img/app-icons/apple-touch-icon-ipad-game.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/') }}/img/app-icons/apple-touch-icon-iphone-retina-game.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/') }}/img/app-icons/apple-touch-icon-ipad-retina-game.png">
    <link rel="icon" sizes="32x32" href="{{ url('/') }}/img/favicon-32x32-game.png" >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
                            DEFAULT: '#f97316', // Warm Orange
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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536" crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QEW6K9YPY7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QEW6K9YPY7');
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-sans antialiased transition-colors duration-300">

    <nav class="bg-white dark:bg-slate-800 shadow-sm sticky top-0 z-50 transition-colors duration-300" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-brand flex items-center gap-2">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path></svg>
                        Cờ tướng
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:space-x-6">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('dashboard') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Tổng quan</a>
                            <a href="{{ route('posts.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Bài viết</a>
                            <a href="{{ route('categories.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Chuyên mục</a>
                            <a href="{{ route('tags.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Thẻ</a>
                            <a href="{{ route('users.index') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Người dùng</a>
                        @else
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Xin chào, {{ auth()->user()->name }}</span>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                            @csrf
                            <button type="submit" class="text-slate-600 dark:text-slate-300 hover:text-red-500 dark:hover:text-red-500 font-medium transition">Đăng xuất</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-300 hover:text-brand dark:hover:text-brand font-medium transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="bg-brand hover:bg-brand-hover text-white px-4 py-2 rounded-lg font-medium transition">Đăng ký</a>
                    @endauth

                    <button @click="darkMode = !darkMode" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                </div>

                <div class="flex items-center sm:hidden gap-4">
                    <button @click="darkMode = !darkMode" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>
                    <button @click="open = !open" class="text-slate-500 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" class="sm:hidden border-t border-slate-100 dark:border-slate-700" style="display: none;" x-transition>
            <div class="pt-2 pb-3 space-y-1">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Tổng quan</a>
                        <a href="{{ route('posts.index') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Bài viết</a>
                        <a href="{{ route('categories.index') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Chuyên mục</a>
                        <a href="{{ route('tags.index') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Thẻ</a>
                        <a href="{{ route('users.index') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Người dùng</a>
                    @else
                        <div class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-500 font-medium">Xin chào, {{ auth()->user()->name }}</div>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block pl-3 pr-4 py-3 border-l-4 border-transparent text-red-500 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-3 border-l-4 border-transparent text-brand hover:bg-slate-50 dark:hover:bg-slate-700 font-medium">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @stack('scripts')

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
