@extends('layouts.app')

@section('title', 'Quản lý ván cờ của tôi')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white">Ván cờ của tôi</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Quản lý những ván cờ bạn đã chia sẻ</p>
        </div>
        <a href="{{ route('games.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-brand to-orange-500 text-white font-bold rounded-xl shadow-lg shadow-brand/30 hover:-translate-y-0.5 transition-all">
            + Tạo ván cờ mới
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl shadow-sm border border-brand/10 dark:border-slate-700/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50/50 dark:bg-slate-700/30 text-slate-600 dark:text-slate-300 text-sm uppercase tracking-wider">
                        <th class="p-4 font-bold">Tiêu đề</th>
                        <th class="p-4 font-bold text-center">Lượt xem</th>
                        <th class="p-4 font-bold">Ngày tạo</th>
                        <th class="p-4 font-bold text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand/5 dark:divide-slate-700/50 text-slate-700 dark:text-slate-200">
                    @forelse ($games as $game)
                        <tr class="hover:bg-orange-50/30 dark:hover:bg-slate-700/20 transition-colors">
                            <td class="p-4">
                                <a href="{{ route('games.show', $game->slug) }}" class="font-bold text-brand hover:underline block truncate max-w-[300px]">
                                    {{ $game->title }}
                                </a>
                                @if($game->description)
                                    <span class="text-xs text-slate-500 truncate block max-w-[300px] mt-1">{{ $game->description }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-center font-medium">{{ number_format($game->views) }}</td>
                            <td class="p-4 text-sm">{{ $game->created_at->format('d/m/Y') }}</td>
                            <td class="p-4 text-right space-x-2">
                                <a href="{{ route('games.edit', $game->slug) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 transition-colors" data-tippy-content="Chỉnh sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('games.destroy', $game->slug) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ván cờ này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-500/10 dark:text-red-400 transition-colors" data-tippy-content="Xóa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">
                                Bạn chưa tạo ván cờ nào. <a href="{{ route('games.create') }}" class="text-brand hover:underline">Tạo ngay!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $games->links() }}
    </div>
</div>
@endsection
