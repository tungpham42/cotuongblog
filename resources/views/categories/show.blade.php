@extends('layouts.app')

@section('title', $category->name . ' - Cờ tướng')
@if($category->featured_image)
    @section('og_image', asset('storage/' . $category->featured_image))
@endif
@section('meta_description', $category->description ? Str::limit($category->description, 150) : 'Khám phá các bài viết hấp dẫn trong chuyên mục ' . $category->name)

@section('content')
<div class="space-y-8">
    <nav aria-label="Breadcrumb" class="mb-2">
        <ol class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
            <li><a href="{{ route('home') }}" class="hover:text-brand transition-colors">Trang chủ</a></li>
            <li><span class="mx-1">/</span></li>
            <li class="font-medium text-slate-900 dark:text-slate-200" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <header class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 sm:p-12 text-center flex flex-col items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-brand/5 to-transparent dark:from-brand/10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center">
            @if($category->featured_image)
                <figure class="w-24 h-24 sm:w-28 sm:h-28 mb-6 rounded-2xl overflow-hidden shadow-md border border-white/50 dark:border-slate-600 bg-white dark:bg-slate-700">
                    <img src="{{ asset('storage/' . $category->featured_image) }}" alt="Ảnh đại diện chuyên mục {{ $category->name }}" class="w-full h-full object-cover">
                </figure>
            @else
                <div class="w-20 h-20 mb-6 rounded-2xl bg-brand/10 dark:bg-brand/20 flex items-center justify-center shadow-inner text-brand">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
            @endif

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">
                {{ $category->name }}
            </h1>

            @if($category->description)
                <p class="text-slate-600 dark:text-slate-300 max-w-2xl mx-auto mb-6 text-lg leading-relaxed">
                    {{ $category->description }}
                </p>
            @endif

            <div class="inline-flex items-center justify-center px-5 py-2 rounded-full bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-300 text-sm font-semibold shadow-sm border border-slate-200 dark:border-slate-700">
                <svg class="w-4 h-4 mr-2 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Tổng số {{ $posts->total() }} bài viết
            </div>
        </div>
    </header>

    <section aria-label="Danh sách bài viết trong chuyên mục">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse ($posts as $post)
                <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:border-brand/40 dark:hover:border-brand/50 transition-all duration-300 transform hover:-translate-y-1">

                    <a href="{{ route('posts.show', $post->slug) }}" class="block aspect-[16/9] w-full bg-slate-100 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                        @if($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Ảnh thu nhỏ của bài viết: {{ $post->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 group-hover:text-brand opacity-40 group-hover:scale-110 group-hover:opacity-60 transition-all duration-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
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
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 dark:bg-slate-900 mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Chưa có bài viết nào</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto mb-6">Chuyên mục này hiện tại chưa có bài viết nào. Hãy quay lại sau nhé!</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-brand text-white font-medium rounded-xl hover:bg-brand-hover transition-colors shadow-sm shadow-brand/30">
                        ← Quay về trang chủ
                    </a>
                </div>
            @endforelse
        </div>
    </section>

    @if ($posts->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
