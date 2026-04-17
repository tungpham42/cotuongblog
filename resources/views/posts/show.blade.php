@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">

    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
    @endif

    <div class="p-8">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-4">{{ $post->title }}</h1>

        <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-8 pb-8 border-b border-slate-100 dark:border-slate-700">
            <span>Đăng bởi: <strong>{{ $post->author->name ?? 'Khách' }}</strong></span>
            <span>•</span>
            <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="prose dark:prose-invert max-w-none mb-12">
            {{ $post->content }}
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-700">
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Bình luận ({{ $post->comments->count() }})</h3>

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10">
                    @csrf
                    <textarea name="content" rows="3" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-brand focus:border-brand p-4" placeholder="Viết bình luận của bạn..." required></textarea>
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="bg-brand hover:bg-brand-hover text-white px-6 py-2 rounded-lg font-semibold transition">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-6 text-center mb-10 border border-slate-100 dark:border-slate-600">
                    <p class="text-slate-600 dark:text-slate-300">Vui lòng <a href="{{ route('login') }}" class="text-brand font-semibold hover:underline">đăng nhập</a> để bình luận.</p>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="bg-slate-50 dark:bg-slate-700/30 rounded-xl p-5 border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center text-brand font-bold">
                                {{ substr($comment->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-white">{{ $comment->user->name }}</h4>
                                <p class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-slate-700 dark:text-slate-300">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-slate-500 dark:text-slate-400 text-center italic">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
