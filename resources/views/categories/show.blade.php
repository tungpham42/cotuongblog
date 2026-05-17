@extends('layouts.app')

@php
    // Kiểm tra xem đây có phải là chuyên mục Tiếng Anh không
    $isEn = $category->slug === 'english-articles';
@endphp

@section('title', $category->name . ($isEn ? ' - Xiangqi' : ' - Cờ tướng'))
@if($category->featured_image)
    @section('og_image', asset('storage/' . $category->featured_image))
@endif
@section('meta_description', $category->description ? Str::limit($category->description, 150) : ($isEn ? 'Explore fascinating articles in ' . $category->name : 'Khám phá các bài viết hấp dẫn trong chuyên mục ' . $category->name))

@section('content')
<div class="space-y-8">
    <nav aria-label="Breadcrumb" class="mb-2">
        <ol class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-brand transition-colors font-semibold">{{ $isEn ? 'Home' : 'Trang chủ' }}</a></li>
            <li><span class="mx-1 opacity-50">/</span></li>
            <li class="font-bold text-slate-900 dark:text-slate-200" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    {{-- Stunning Animated Category Header --}}
    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        @keyframes gradient-x {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 7s ease-in-out 3s infinite; }
        .animate-gradient-x { animation: gradient-x 4s ease infinite; background-size: 200% 200%; }
    </style>

    <div x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 100)"
         class="transition-all duration-1000 transform" :class="mounted ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">

        <header class="relative bg-white/60 dark:bg-slate-800/70 backdrop-blur-2xl rounded-[2.5rem] shadow-[0_15px_40px_rgba(249,115,22,0.08)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.4)] border border-white/80 dark:border-slate-700/60 overflow-hidden p-8 sm:p-10 lg:p-12 transition-all duration-700 hover:shadow-[0_25px_50px_rgba(249,115,22,0.12)] dark:hover:shadow-[0_25px_50px_rgba(0,0,0,0.5)] group">

            {{-- Animated Background Orbs --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-32 -left-32 w-72 h-72 bg-brand/20 dark:bg-brand/20 rounded-full blur-[5rem] animate-float opacity-70 group-hover:bg-brand/30 transition-colors duration-1000"></div>
                <div class="absolute -bottom-32 -right-32 w-72 h-72 bg-amber-400/20 dark:bg-yellow-500/10 rounded-full blur-[5rem] animate-float-delayed opacity-70 group-hover:bg-amber-400/30 transition-colors duration-1000"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/30 to-white/60 dark:via-slate-800/50 dark:to-slate-900/80 z-0"></div>
            </div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8">

                <div class="shrink-0 group/img relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-brand to-amber-400 rounded-[1.5rem] blur opacity-25 group-hover/img:opacity-50 transition duration-500"></div>
                    @if($category->featured_image)
                        <figure class="w-28 h-28 sm:w-32 sm:h-32 rounded-[1.25rem] overflow-hidden shadow-xl border-2 border-white dark:border-slate-700/80 relative z-10 bg-white dark:bg-slate-800">
                            <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover transform group-hover/img:scale-110 group-hover/img:rotate-3 transition-all duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/img:opacity-100 transition-opacity duration-300"></div>
                        </figure>
                    @else
                        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-[1.25rem] bg-gradient-to-br from-brand/20 to-brand/5 dark:from-brand/30 dark:to-brand/10 flex items-center justify-center shadow-xl text-brand transform group-hover/img:scale-105 group-hover/img:-rotate-3 transition-all duration-500 border-2 border-white dark:border-slate-700/80 relative z-10 backdrop-blur-sm">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col text-center sm:text-left flex-grow justify-center min-h-[7rem]">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-3 sm:mb-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight drop-shadow-sm">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand via-orange-500 to-rose-500 animate-gradient-x pb-1 inline-block">
                                {{ $category->name }}
                            </span>
                        </h1>

                        <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-white/80 dark:bg-slate-800/80 text-brand dark:text-brand-light text-sm font-bold whitespace-nowrap self-center shadow-sm border border-brand/20 dark:border-brand/30 backdrop-blur-md transform hover:scale-105 transition-transform duration-300 cursor-default">
                            <span class="flex w-2 h-2 rounded-full bg-brand animate-pulse mr-2 shadow-[0_0_8px_rgba(249,115,22,0.8)]"></span>
                            {{ $posts->total() }} {{ $isEn ? 'articles' : 'bài viết' }}
                        </span>
                    </div>

                    @if($category->description)
                        <p class="text-base sm:text-lg text-slate-700 dark:text-slate-300 font-medium leading-relaxed max-w-4xl mb-0 line-clamp-3 relative z-10 drop-shadow-sm">
                            {{ $category->description }}
                        </p>
                    @endif
                </div>
            </div>
        </header>
    </div>

    <div class="flex flex-col gap-5 border-b border-slate-200 dark:border-slate-700 pb-5 mb-6">
        {{-- Thanh tìm kiếm --}}
        <form action="{{ route($isEn ? 'categories.show.en' : 'categories.show', $category->slug) }}" method="GET" class="relative z-30 w-full">
            <div class="flex flex-col sm:flex-row items-center w-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-[2rem] sm:rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-200/80 dark:border-slate-700/80 p-1.5 gap-2 transition-all duration-500 hover:shadow-[0_15px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_15px_40px_rgba(249,115,22,0.1)] hover:border-brand/40 focus-within:ring-4 focus-within:ring-brand/10 focus-within:border-brand dark:focus-within:border-brand">

                <div class="relative flex items-center w-full flex-grow group/search">
                    <div class="absolute left-4 text-brand/60 group-focus-within/search:text-brand transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="{{ $isEn ? 'Search articles...' : 'Tìm trong chuyên mục...' }}"
                        class="w-full bg-transparent border-none outline-none focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 pl-11 pr-14 py-2.5 text-[15px] font-medium transition-all duration-300 placeholder:font-normal [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s] [&:-webkit-autofill]:[-webkit-text-fill-color:#1e293b] dark:[&:-webkit-autofill]:[-webkit-text-fill-color:#f8fafc]">

                    <button type="submit" aria-label="Tìm kiếm" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white dark:bg-brand/20 dark:hover:bg-brand transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/50 group-focus-within/search:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

                <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-slate-200 dark:via-slate-700 to-transparent"></div>

                <div x-data="{
                        open: false,
                        selected: '{{ request('sort', 'latest') }}',
                        options: {
                            'latest': '{{ $isEn ? "Latest" : "Mới nhất" }}',
                            'oldest': '{{ $isEn ? "Oldest" : "Cũ nhất" }}',
                            'views_desc': '{{ $isEn ? "Most Viewed" : "Lượt xem (Cao - Thấp)" }}',
                            'views_asc': '{{ $isEn ? "Least Viewed" : "Lượt xem (Thấp - Cao)" }}',
                            'alpha_asc': '{{ $isEn ? "A - Z" : "Tên (A - Z)" }}',
                            'alpha_desc': '{{ $isEn ? "Z - A" : "Tên (Z - A)" }}'
                        },
                        selectOption(value) {
                            this.selected = value;
                            this.open = false;
                            setTimeout(() => this.$el.closest('form').submit(), 150);
                        }
                    }" class="relative w-full sm:w-auto shrink-0" @click.away="open = false">

                    <input type="hidden" name="sort" :value="selected">

                    <button type="button" @click="open = !open"
                        class="flex items-center justify-between w-full sm:w-[250px] bg-slate-50 dark:bg-slate-900/50 hover:bg-brand dark:hover:bg-brand text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-[1.5rem] sm:rounded-full px-5 py-2.5 text-sm font-bold transition-all duration-300 ease-out cursor-pointer group/btn">

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
                        class="absolute right-0 z-50 w-full sm:w-[260px] mt-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-slate-100 dark:border-slate-700/80 rounded-[1.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] overflow-hidden p-2 origin-top-right"
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

        <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2 mt-2">
            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
            @php
                if ($isEn) {
                    $headerText = request('search') ? 'Search Results' : match(request('sort')) {
                        'oldest' => 'Oldest Articles',
                        'views_desc' => 'Most Viewed',
                        'views_asc' => 'Least Viewed',
                        'alpha_asc' => 'Alphabetical (A - Z)',
                        'alpha_desc' => 'Alphabetical (Z - A)',
                        default => 'Latest Articles',
                    };
                } else {
                    $headerText = request('search') ? 'Kết quả tìm kiếm' : match(request('sort')) {
                        'oldest' => 'Bài viết cũ nhất',
                        'views_desc' => 'Bài viết xem nhiều nhất',
                        'views_asc' => 'Bài viết xem ít nhất',
                        'alpha_asc' => 'Bài viết theo tên (A - Z)',
                        'alpha_desc' => 'Bài viết theo tên (Z - A)',
                        default => 'Danh sách bài viết',
                    };
                }
            @endphp
            {{ $headerText }}
        </h2>
    </div>

    <section aria-label="Danh sách bài viết trong chuyên mục">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse ($posts as $post)
                <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgba(249,115,22,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-brand/5 dark:border-slate-700/80 overflow-hidden hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] transition-all duration-500 transform hover:-translate-y-2 relative">

                    <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[1200/630] w-full bg-orange-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-out">
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
                                {{ $post->created_at->locale($isEn ? 'en' : 'vi')->diffForHumans() }}
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
                                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">{{ $isEn ? 'Author' : 'Tác giả' }}</span>
                                    <span class="text-sm font-black text-slate-800 dark:text-slate-200">{{ $post->author->name ?? ($isEn ? 'Anonymous' : 'Ẩn danh') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center gap-1.5 text-sm font-black text-brand opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 focus:outline-none">
                                {{ $isEn ? 'Read now' : 'Đọc ngay' }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 dark:bg-slate-900 mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">{{ $isEn ? 'No articles found' : 'Chưa có bài viết nào' }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-6">{{ $isEn ? 'This category currently has no articles. Please check back later!' : 'Chuyên mục này hiện tại chưa có bài viết nào. Hãy quay lại sau nhé!' }}</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-brand text-white font-medium rounded-xl hover:bg-brand-hover transition-colors shadow-sm shadow-brand/30">
                        ← {{ $isEn ? 'Back to Home' : 'Quay về trang chủ' }}
                    </a>
                </div>
            @endforelse
        </div>
    </section>

    @if ($posts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $posts->onEachSide(1)->links('components.pagination') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
{{-- SEO: Dynamic CollectionPage & ItemList Schema.org JSON-LD --}}
{!! $categorySchema->toScript() !!}
@endpush
