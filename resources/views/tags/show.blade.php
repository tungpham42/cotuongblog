@extends('layouts.app')

@section('title', 'Thẻ: ' . $tag->name . ' - Cờ tướng')
@if($tag->featured_image)
    @section('og_image', asset('storage/' . $tag->featured_image))
@endif
@section('meta_description', $tag->description ? Str::limit($tag->description, 150) : 'Xem tất cả bài viết liên quan đến #' . $tag->name)

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 sm:p-12 text-center flex flex-col items-center">
        @if($tag->featured_image)
            <div class="w-24 h-24 mb-6 rounded-2xl overflow-hidden shadow-md border border-white dark:border-slate-600">
                <img src="{{ asset('storage/' . $tag->featured_image) }}" alt="{{ $tag->name }}" class="w-full h-full object-cover">
            </div>
        @endif

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-4 flex items-center justify-center gap-3">
            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            <span>Thẻ: <span class="text-brand">#{{ $tag->name }}</span></span>
        </h1>

        @if($tag->description)
            <p class="text-slate-600 dark:text-slate-300 max-w-2xl mx-auto mb-6 text-lg leading-relaxed">
                {{ $tag->description }}
            </p>
        @endif

        <div class="px-5 py-1.5 rounded-full bg-brand/10 text-brand text-sm font-bold border border-brand/20 shadow-sm">
            {{ $posts->total() }} bài viết liên quan
        </div>
    </div>

    {{-- Bộ lọc Tìm kiếm và Sắp xếp --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
            Danh sách bài viết
        </h2>

        <form action="{{ route('tags.show', $tag->slug) }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm trong thẻ..." class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full pl-10 p-2.5 outline-none transition-all">
                <svg class="w-4 h-4 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <select name="sort" onchange="this.form.submit()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-brand focus:border-brand block w-full sm:w-auto p-2.5 outline-none cursor-pointer">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="alpha_asc" {{ request('sort') == 'alpha_asc' ? 'selected' : '' }}>Từ A - Z</option>
                <option value="alpha_desc" {{ request('sort') == 'alpha_desc' ? 'selected' : '' }}>Từ Z - A</option>
            </select>
        </form>
    </div>

    {{-- Grid Layout Danh sách bài viết (giữ nguyên như cũ) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse ($posts as $post)
            <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:border-brand/40 dark:hover:border-brand/50 transition-all duration-300 transform hover:-translate-y-1">
                <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[16/9] w-full bg-slate-100 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400 group-hover:text-brand opacity-40 group-hover:scale-110 group-hover:opacity-60 transition-all duration-500">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <div class="absolute top-3 right-3 bg-slate-900/70 backdrop-blur-sm text-white text-xs font-bold px-2.5 py-1 rounded-lg flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        {{ number_format($post->views ?? 0) }}
                    </div>
                </a>

                <div class="p-6 flex flex-col flex-grow">
                    <header class="mb-3">
                        <div class="flex items-center gap-3 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-3">
                            <span class="flex items-center gap-1.5 text-brand bg-brand/10 dark:bg-brand/20 px-2.5 py-1 rounded-md">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $post->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand transition-colors line-clamp-2 leading-tight">
                            <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none focus:text-brand">
                                {{ $post->title }}
                            </a>
                        </h3>
                    </header>

                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 flex-grow leading-relaxed">
                        {{ Str::limit(strip_tags(Str::markdown($post->excerpt ?? $post->content ?? '')), 120) }}
                    </p>
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
        <div class="mt-10 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
