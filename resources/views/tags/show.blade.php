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

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white mb-4">
            🏷️ Thẻ: <span class="text-brand">#{{ $tag->name }}</span>
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

    {{-- Grid Layout --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse ($posts as $post)
            <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:border-brand/40 dark:hover:border-brand/50 transition-all duration-300 transform hover:-translate-y-1">

                <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[16/9] w-full bg-slate-100 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl opacity-40 group-hover:scale-110 group-hover:opacity-60 transition-all duration-500">
                            🏆
                        </div>
                    @endif

                    {{-- Views Counter Badge --}}
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

                    {{-- Fallback to strip_tags(content) if excerpt is null to avoid broken HTML layouts --}}
                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 flex-grow leading-relaxed">
                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}
                    </p>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-slate-300 dark:border-slate-700">
                <span class="text-6xl block mb-4">📭</span>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Chưa có nội dung</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Không có bài viết nào được gắn thẻ này.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-2 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-lg shadow-brand/30 transition-all">← Quay về trang chủ</a>
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
