@extends('layouts.app') @section('title', 'Cộng Đồng Kỳ Thủ')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white">Cộng Đồng Kỳ Thủ</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Khám phá các ván cờ hay từ cộng đồng</p>
        </div>
        <a href="{{ route('games.create') }}" class="px-5 py-2.5 bg-brand hover:bg-brand-hover text-white font-bold rounded-xl shadow-lg shadow-brand/30 transition-all">
            + Đóng góp ván cờ
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($games as $game)
            <a href="{{ route('games.show', $game->slug) }}" class="group block bg-white dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-xl shadow-brand/5 border border-brand/10 dark:border-slate-700/50 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <div class="aspect-[4/3] bg-orange-50 dark:bg-slate-700/50 flex items-center justify-center p-4">
                    {{-- Gợi ý: Chỗ này sau có thể render ảnh mini của bàn cờ --}}
                    <svg class="w-16 h-16 text-brand/30 group-hover:text-brand/60 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path></svg>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white line-clamp-1 group-hover:text-brand transition-colors">{{ $game->title }}</h3>
                    <div class="flex items-center gap-2 mt-3 text-sm text-slate-500 dark:text-slate-400">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $game->user->name }}</span>
                        <span>•</span>
                        <span>{{ $game->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/50 text-sm text-slate-500 dark:text-slate-400">
                        <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> {{ number_format($game->views) }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">
                Chưa có ván cờ nào được chia sẻ.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $games->links() }}
    </div>
</div>
@endsection
