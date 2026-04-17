@extends('layouts.app')

@section('title', 'Thẻ: ' . $tag->name . ' - Cờ tướng')

@section('content')
<div class="space-y-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">
            🏷️ Thẻ: <span class="text-brand">#{{ $tag->name }}</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 font-medium">
            Tìm thấy {{ $posts->total() }} bài viết liên quan
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-md hover:border-brand/50 transition-all duration-300">
                <div class="aspect-[16/9] w-full bg-slate-100 dark:bg-slate-700 relative overflow-hidden flex items-center justify-center">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <span class="text-5xl opacity-50 group-hover:scale-110 transition-transform duration-500">🏆</span>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-xs font-semibold text-brand mb-3 uppercase tracking-wider">
                        <span>📁 {{ $post->category->name ?? 'Chưa phân loại' }}</span>
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <span class="text-slate-500 dark:text-slate-400 normal-case font-medium flex items-center gap-1">🕒 {{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-brand transition-colors line-clamp-2 leading-snug">
                        {{ $post->title }}
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-4 flex-grow leading-relaxed">
                        {{ Str::limit(strip_tags($post->content ?? $post->excerpt), 120) }}
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700">
                <span class="text-5xl block mb-4">📭</span>
                <p class="text-slate-500 dark:text-slate-400 text-lg font-medium">Chưa có bài viết nào gắn thẻ này.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 text-brand hover:underline font-medium">← Quay lại trang chủ</a>
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
