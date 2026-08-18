@extends('layouts.app')

@section('title', 'Thư Viện Ván Cờ')
@section('meta_description', 'Khám phá hàng ngàn ván cờ tướng kinh điển, các thế khai cuộc và tàn cuộc đỉnh cao từ các danh thủ.')

@section('content')
<div class="space-y-12 pb-12" x-data="{ currentFilter: 'all' }">

    {{-- 1. Hero Section --}}
    <div class="relative overflow-hidden rounded-[2.5rem] bg-white/40 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-slate-700/50 shadow-[0_20px_60px_-15px_rgba(249,115,22,0.1)] dark:shadow-none">
        <!-- Decorative Background Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-gradient-to-br from-brand/20 to-orange-400/20 blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-gradient-to-tr from-rose-400/20 to-brand/20 blur-3xl opacity-50 pointer-events-none"></div>

        <div class="relative px-6 py-16 sm:px-12 sm:py-24 lg:px-20 flex flex-col items-center text-center">
            <span class="px-4 py-1.5 rounded-full bg-brand/10 dark:bg-brand/20 text-brand font-black text-sm tracking-widest uppercase mb-6 shadow-sm border border-brand/20">
                Kho Tàng Kỳ Phổ
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 dark:text-white mb-6">
                Thư Viện <span class="bg-clip-text text-transparent bg-gradient-to-r from-brand via-orange-500 to-rose-500 drop-shadow-sm">Ván Cờ</span>
            </h1>
            <p class="mt-4 text-lg sm:text-xl text-slate-600 dark:text-slate-300 max-w-2xl font-medium">
                Khám phá và học hỏi từ hàng ngàn ván đấu kinh điển của các Đặc Cấp Đại Sư hàng đầu. Nâng cao kỳ nghệ của bạn ngay hôm nay.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('games.library') }}" method="GET" class="mt-10 w-full max-w-2xl relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-6 h-6 text-brand/50 group-focus-within:text-brand transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="block w-full pl-14 pr-32 py-5 bg-white/80 dark:bg-slate-900/50 backdrop-blur-md border-2 border-brand/10 dark:border-slate-700 rounded-2xl leading-5 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand focus:ring-4 focus:ring-brand/10 transition-all duration-300 shadow-sm font-semibold text-lg"
                       placeholder="Tìm kiếm kỳ thủ, giải đấu, thế trận...">
                <div class="absolute inset-y-0 right-2 flex items-center">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-brand to-orange-500 hover:from-orange-500 hover:to-rose-500 text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-brand/50 hover:-translate-y-0.5 transition-all duration-300">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. Game Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($games as $game)
        <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl border border-brand/10 dark:border-slate-700/60 rounded-[2rem] overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(249,115,22,0.15)] dark:hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 flex flex-col">

            <!-- Graphic / Cover -->
            <div class="block aspect-[1200/630] w-full bg-orange-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                <img src="https://placehold.co/1200x630/BB5F1A/FFFFFF?text={{ urlencode($game->title) }}" alt="{{ $game->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-out">
            </div>

            <!-- Content Info -->
            <div class="p-6 sm:p-8 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-sm font-semibold text-brand tracking-wide">
                        {{ $game->user->name ?? 'Cộng đồng' }}
                    </p>
                    <div class="flex items-center gap-1.5 text-slate-400 dark:text-slate-500 text-sm font-semibold" data-tippy-content="Lượt xem">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($game->views) }}
                    </div>
                </div>

                <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 mb-2 leading-tight group-hover:text-brand transition-colors">
                    <a href="{{ route('games.show', $game->slug) }}" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        {{ $game->title }}
                    </a>
                </h3>

                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-6">
                    {{ $game->description ?? 'Không có mô tả cho ván cờ này.' }}
                </p>

                <!-- Footer Card -->
                <div class="mt-auto pt-5 border-t border-brand/10 dark:border-slate-700/50 flex items-center justify-between">
                    <!-- Result Badge -->
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-black uppercase">
                            {{ $game->created_at ? $game->created_at->locale('vi')->diffForHumans() : '' }}
                        </span>
                    </div>

                    <span class="text-sm font-bold text-brand flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-300">
                        Chi tiết
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-slate-500 dark:text-slate-400 font-medium text-lg">
            Chưa có ván cờ nào trong thư viện.
        </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $games->links() }}
    </div>

</div>
@endsection
