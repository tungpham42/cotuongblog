@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">

    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 sm:h-80 object-cover">
    @endif

    <div class="px-6 py-8 sm:p-10">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight mb-4">{{ $post->title }}</h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400 mb-8 pb-8 border-b border-slate-100 dark:border-slate-700">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Đăng bởi: <strong class="ml-1">{{ $post->author->name ?? 'Khách' }}</strong>
            </span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-600">•</span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ $post->created_at->format('d/m/Y H:i') }}
            </span>
        </div>

        <div id="viewer-wrapper" class="mb-12 text-left"></div>

        <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-700">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Bình luận ({{ $post->comments->count() }})</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Tham gia thảo luận về bài viết này.</p>
            </div>

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10 space-y-4">
                    @csrf
                    <div>
                        <textarea name="content" rows="3" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none custom-scrollbar" placeholder="Viết bình luận của bạn..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700 text-center mb-10">
                    <p class="text-slate-600 dark:text-slate-300">Vui lòng <a href="{{ route('login') }}" class="text-brand font-semibold hover:underline">đăng nhập</a> để bình luận.</p>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-5 border border-slate-200 dark:border-slate-700 transition-colors">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full bg-brand-light dark:bg-brand/20 flex items-center justify-center text-brand font-bold border border-brand/10">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $comment->user->name }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $comment->content }}</p>
                    </div>
                @empty
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-8 border border-slate-200 dark:border-slate-700 text-center">
                        <p class="text-slate-500 dark:text-slate-400 italic">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/theme/toastui-editor-dark.min.css" />
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
        const initialContent = {!! json_encode($post->content) !!};

        // Fixed: Use the 'Editor' constructor with the 'viewer: true' property
        const viewer = new toastui.Editor({
            el: document.querySelector('#viewer-wrapper'),
            viewer: true,
            initialValue: initialContent,
            theme: isDarkMode ? 'dark' : 'default'
        });
    });
</script>
@endsection
