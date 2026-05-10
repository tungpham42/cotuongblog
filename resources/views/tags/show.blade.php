@extends('layouts.app')

@section('title', 'Thẻ: ' . $tag->name . ' - Cờ tướng')
@if($tag->featured_image)
    @section('og_image', asset('storage/' . $tag->featured_image))
@endif
@section('meta_description', $tag->description ? Str::limit($tag->description, 150) : 'Xem tất cả bài viết liên quan đến #' . $tag->name)

@section('content')
<div class="space-y-8">
    <nav aria-label="Breadcrumb" class="mb-2">
        <ol class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-brand transition-colors">Trang chủ</a></li>
            <li><span class="mx-1">/</span></li>
            <li class="font-medium text-slate-900 dark:text-slate-200" aria-current="page">{{ $tag->name }}</li>
        </ol>
    </nav>
    {{-- Header Section --}}
    <header class="relative bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgba(249,115,22,0.08)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden p-6 sm:p-8 transition-all duration-500 hover:shadow-[0_15px_40px_rgba(249,115,22,0.12)] dark:hover:shadow-[0_15px_40px_rgba(0,0,0,0.4)]">

        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -left-20 w-48 h-48 bg-brand/10 dark:bg-brand/20 rounded-full blur-[2.5rem]"></div>
            <div class="absolute -bottom-20 -right-20 w-48 h-48 bg-yellow-400/10 dark:bg-yellow-400/5 rounded-full blur-[2.5rem]"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent dark:via-slate-800/40"></div>
        </div>

        <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">

            <div class="shrink-0 group">
                @if($tag->featured_image)
                    <figure class="w-24 h-24 sm:w-28 sm:h-28 rounded-[1.25rem] overflow-hidden shadow-[0_4px_15px_rgba(0,0,0,0.1)] border border-white dark:border-slate-700/50 relative">
                        <img src="{{ asset('storage/' . $tag->featured_image) }}" alt="Thẻ {{ $tag->name }}" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-2 transition-all duration-500 ease-out">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </figure>
                @else
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-[1.25rem] bg-gradient-to-br from-brand/20 to-brand/5 dark:from-brand/30 dark:to-brand/10 flex items-center justify-center shadow-[0_4px_15px_rgba(249,115,22,0.1)] text-brand transform group-hover:scale-105 group-hover:-rotate-2 transition-all duration-500 border border-white dark:border-slate-700/50">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                @endif
            </div>

            <div class="flex flex-col text-center sm:text-left flex-grow justify-center min-h-[6rem] sm:min-h-[7rem]">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 mb-2 sm:mb-3">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center justify-center sm:justify-start gap-2">
                        <span class="text-slate-400 dark:text-slate-500 text-xl sm:text-2xl font-bold">Thẻ:</span>
                        <span class="text-brand">#{{ $tag->name }}</span>
                    </h1>

                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-brand/10 dark:bg-brand/20 text-brand dark:text-brand-light text-xs font-bold whitespace-nowrap self-center shadow-sm border border-brand/5">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        {{ $posts->total() }} bài viết
                    </span>
                </div>

                @if($tag->description)
                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 font-medium leading-relaxed max-w-3xl mb-0 line-clamp-2">
                        {{ $tag->description }}
                    </p>
                @endif
            </div>
        </div>
    </header>

    {{-- Bộ lọc Tìm kiếm và Sắp xếp --}}
    <div class="flex flex-col gap-5 border-b border-slate-200 dark:border-slate-700 pb-5 mb-6">

        {{-- Thanh tìm kiếm và bộ lọc chiếm toàn bộ chiều rộng --}}
        <form action="{{ route('tags.show', $tag->slug) }}" method="GET" class="relative z-30 w-full">
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
                        placeholder="Tìm trong thẻ..."
                        class="w-full bg-transparent border-none outline-none focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 pl-11 pr-14 py-2.5 text-[15px] font-medium transition-all duration-300 placeholder:font-normal [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s] [&:-webkit-autofill]:[-webkit-text-fill-color:#1e293b] dark:[&:-webkit-autofill]:[-webkit-text-fill-color:#f8fafc]">

                    {{-- Nút Tìm kiếm --}}
                    <button type="submit" aria-label="Tìm kiếm" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white dark:bg-brand/20 dark:hover:bg-brand transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/50 group-focus-within/search:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

                {{-- Vạch chia cách (Chỉ hiện trên desktop) --}}
                <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-slate-200 dark:via-slate-700 to-transparent"></div>

                {{-- Khu vực Sắp xếp (Alpine.js) --}}
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

                    {{-- Nút dropdown được mở rộng kích thước lên sm:w-[250px] --}}
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

                    {{-- Khung menu dropdown được mở rộng kích thước lên sm:w-[260px] --}}
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

        {{-- Tiêu đề được đẩy xuống dòng dưới form --}}
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2 mt-2">
            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
            {{ request('search') ? 'Kết quả tìm kiếm' : match(request('sort')) {
                'oldest' => 'Bài viết cũ nhất',
                'views_desc' => 'Bài viết xem nhiều nhất',
                'views_asc' => 'Bài viết xem ít nhất',
                'alpha_asc' => 'Bài viết theo tên (A - Z)',
                'alpha_desc' => 'Bài viết theo tên (Z - A)',
                default => 'Danh sách bài viết',
            } }}
        </h2>
    </div>

    {{-- Grid Layout Danh sách bài viết --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
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
            <div class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 dark:bg-slate-900 mb-4 text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Chưa có nội dung</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Không có bài viết nào phù hợp với tìm kiếm hoặc được gắn thẻ này.</p>
                <a href="{{ route('tags.show', $tag->slug) }}" class="inline-flex items-center px-6 py-2 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-lg shadow-brand/30 transition-all">Làm mới lại</a>
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $posts->onEachSide(1)->links('components.pagination') }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
{{-- SEO: Dynamic CollectionPage & ItemList Schema.org JSON-LD --}}
{!! $tagSchema->toScript() !!}
@endpush
