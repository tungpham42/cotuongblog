@extends('layouts.app')

@section('title', 'Quản lý bình luận')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Quản lý bình luận
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Kiểm duyệt và quản lý bình luận trên hệ thống.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 p-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-sm uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                        <th class="px-6 py-4 font-semibold w-1/4">Người dùng</th>
                        <th class="px-6 py-4 font-semibold w-2/4">Nội dung</th>
                        <th class="px-6 py-4 font-semibold w-1/4">Bài viết</th>
                        <th class="px-6 py-4 font-semibold text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-brand-light dark:bg-brand/20 text-brand flex items-center justify-center font-bold text-sm">
                                        {{ Str::substr($comment->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $comment->user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                <p class="line-clamp-2 text-sm">{{ $comment->content }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" class="text-sm text-brand hover:underline line-clamp-1" title="{{ $comment->post->title }}">
                                    {{ $comment->post->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form id="delete-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" onclick="confirmDelete({{ $comment->id }})" class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 dark:bg-slate-700 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center bg-slate-50/50 dark:bg-slate-800/50 border-t border-dashed border-slate-200 dark:border-slate-700">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <p class="text-slate-500 dark:text-slate-400 text-lg font-medium">Chưa có bình luận nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $comments->links() }}
    </div>
@endsection

@stack('scripts')
<script>
    function confirmDelete(commentId) {
        const isDark = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Xóa bình luận này?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: isDark ? '#475569' : '#94a3b8',
            background: isDark ? '#1e293b' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a',
            confirmButtonText: 'Đồng ý, xóa!',
            cancelButtonText: 'Hủy',
            customClass: {
                popup: 'rounded-2xl'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + commentId).submit();
            }
        });
    }
</script>
