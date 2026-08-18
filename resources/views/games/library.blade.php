@extends('layouts.app') {{-- Giả định tên file layout của bạn là app.blade.php --}}

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
            <div class="mt-10 w-full max-w-2xl relative group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-6 h-6 text-brand/50 group-focus-within:text-brand transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text"
                       class="block w-full pl-14 pr-32 py-5 bg-white/80 dark:bg-slate-900/50 backdrop-blur-md border-2 border-brand/10 dark:border-slate-700 rounded-2xl leading-5 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand focus:ring-4 focus:ring-brand/10 transition-all duration-300 shadow-sm font-semibold text-lg"
                       placeholder="Tìm kiếm kỳ thủ, giải đấu, thế trận...">
                <div class="absolute inset-y-0 right-2 flex items-center">
                    <button class="px-6 py-3 bg-gradient-to-r from-brand to-orange-500 hover:from-orange-500 hover:to-rose-500 text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:shadow-brand/50 hover:-translate-y-0.5 transition-all duration-300">
                        Tìm kiếm
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Filters / Categories --}}
    <div class="flex items-center gap-3 overflow-x-auto pb-4 scrollbar-hide snap-x" style="scrollbar-width: none;">
        @php
            $filters = [
                'all' => 'Mới cập nhật',
                'khai_cuoc' => 'Khai cuộc hay',
                'tan_cuoc' => 'Sát cục - Tàn cuộc',
                'danh_thu' => 'Ván cờ Danh thủ',
                'giai_dau' => 'Giải đấu lớn',
                'gian_ho' => 'Cờ giang hồ'
            ];
        @endphp

        @foreach($filters as $key => $label)
            <button @click="currentFilter = '{{ $key }}'"
                    :class="{
                        'bg-brand text-white shadow-lg shadow-brand/30 border-brand': currentFilter === '{{ $key }}',
                        'bg-white/60 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 border-brand/20 dark:border-slate-700 hover:bg-brand/10 dark:hover:bg-slate-700 hover:text-brand': currentFilter !== '{{ $key }}'
                    }"
                    class="snap-start whitespace-nowrap px-6 py-3 rounded-2xl font-bold border backdrop-blur-md transition-all duration-300">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- 3. Game Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {{-- Loop qua các ván cờ (Dùng vòng lặp giả lập cho giao diện) --}}
        @for($i = 1; $i <= 6; $i++)
        <div class="group relative bg-white/60 dark:bg-slate-800/60 backdrop-blur-xl border border-brand/10 dark:border-slate-700/60 rounded-[2rem] overflow-hidden hover:shadow-[0_20px_40px_-15px_rgba(249,115,22,0.15)] dark:hover:shadow-brand/10 transition-all duration-500 hover:-translate-y-2 flex flex-col">

            <!-- Graphic / Cover -->
            <div class="relative h-48 bg-gradient-to-br from-amber-100 to-orange-50 dark:from-slate-700 dark:to-slate-900 overflow-hidden flex items-center justify-center p-4">
                <!-- Background pattern (Bàn cờ mờ) -->
                <div class="absolute inset-0 opacity-10 dark:opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik0wIDM5LjVoNDBWNDBINHoiIGZpbGw9IiMwMDAiLz48cGF0aCBkPSJNMzkuNSAwVjQwaC41VjB6IiBmaWxsPSIjMDAwIi8+PC9zdmc+')]"></div>

                <!-- Đối đầu -->
                <div class="relative z-10 w-full flex items-center justify-between px-2">
                    <div class="flex flex-col items-center gap-2 transform group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-red-500 border-4 border-white dark:border-slate-800 shadow-xl flex items-center justify-center text-white font-black text-2xl">Đỏ</div>
                        <span class="font-bold text-slate-800 dark:text-white bg-white/50 dark:bg-slate-800/50 px-2 py-1 rounded backdrop-blur-sm">Vương Thiên Nhất</span>
                    </div>

                    <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-black italic shadow-inner">VS</div>

                    <div class="flex flex-col items-center gap-2 transform group-hover:scale-110 transition-transform duration-500">
                        <div class="w-16 h-16 rounded-full bg-slate-900 border-4 border-white dark:border-slate-800 shadow-xl flex items-center justify-center text-white font-black text-2xl">Đen</div>
                        <span class="font-bold text-slate-800 dark:text-white bg-white/50 dark:bg-slate-800/50 px-2 py-1 rounded backdrop-blur-sm">Trịnh Duy Đồng</span>
                    </div>
                </div>

                <!-- Tag Khai Cuộc -->
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-xl text-xs font-black text-brand shadow-sm border border-brand/10">
                        Phi Tượng Cuộc
                    </span>
                </div>
            </div>

            <!-- Content Info -->
            <div class="p-6 sm:p-8 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    <p class="text-sm font-semibold text-brand tracking-wide">Giáp Cấp Liên Tái 2023</p>
                    <div class="flex items-center gap-1.5 text-slate-400 dark:text-slate-500 text-sm font-semibold" data-tippy-content="Lượt xem">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        2.4k
                    </div>
                </div>

                <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 mb-2 leading-tight group-hover:text-brand transition-colors">
                    <a href="#" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        Đại chiến đỉnh cao vòng 18
                    </a>
                </h3>

                <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-6">
                    Một ván cờ cực kỳ mãn nhãn thể hiện công phu trung cuộc thâm sâu của ngoại tinh nhân Vương Thiên Nhất trước Thục Sơn thiếu hiệp.
                </p>

                <!-- Footer Card -->
                <div class="mt-auto pt-5 border-t border-brand/10 dark:border-slate-700/50 flex items-center justify-between">
                    <!-- Result Badge -->
                    <div class="flex items-center gap-2">
                        @if($i % 2 == 0)
                            <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-black uppercase">
                                <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                                Đỏ Thắng
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-black uppercase">
                                <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                Cờ Hòa
                            </span>
                        @endif
                    </div>

                    <span class="text-sm font-bold text-brand flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-300">
                        Chi tiết
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </div>
            </div>
        </div>
        @endfor
    </div>

    {{-- 4. Pagination --}}
    <div class="mt-12 flex justify-center">
        <nav class="flex items-center gap-2 bg-white/50 dark:bg-slate-800/50 p-2 rounded-2xl backdrop-blur-md border border-brand/10 dark:border-slate-700 shadow-sm">
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:bg-brand/10 hover:text-brand transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-brand text-white font-black shadow-md shadow-brand/30">1</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand transition-colors">2</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand transition-colors">3</a>
            <span class="w-10 h-10 flex items-center justify-center text-slate-400 font-bold">...</span>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-brand/10 hover:text-brand transition-colors">12</a>
            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:bg-brand/10 hover:text-brand transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </nav>
    </div>

</div>
@endsection
