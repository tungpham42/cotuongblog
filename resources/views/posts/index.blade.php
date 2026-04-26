@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
                Bài viết của bạn
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Quản lý và chỉnh sửa các nội dung bạn đã chia sẻ.</p>
        </div>
        <a href="{{ route('posts.create') }}" class="bg-brand text-white px-5 py-2.5 rounded-xl shadow-md shadow-brand/30 hover:bg-brand-hover hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Viết bài mới
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
        @forelse($posts as $post)
            <article class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-xl dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-1">
                @if($post->featured_image)
                    <img class="h-52 w-full object-cover" src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}">
                @else
                    <div class="h-52 w-full bg-slate-100 dark:bg-slate-700 flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-medium">Không có ảnh</span>
                    </div>
                @endif

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand bg-brand-light dark:bg-brand/20 dark:text-brand-light px-2.5 py-1 rounded-md">{{ $post->category->name ?? 'Chưa phân loại' }}</span>
                        <span class="text-sm text-slate-400 dark:text-slate-500 font-medium">{{ $post->created_at->format('d/m/Y') }}</span>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 dark:text-white line-clamp-2 mt-1 leading-tight">{{ $post->title }}</h2>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">#{{ $tag->name }}</span>
                        @endforeach
                    </div>

                    <div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-100 dark:border-slate-700 mt-6">
                        <span class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg {{ $post->is_published ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $post->is_published ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            {{ $post->is_published ? 'Đã xuất bản' : 'Chờ duyệt' }}
                        </span>

                        <div class="flex space-x-2">
                            {{-- Nút duyệt bài dành cho Admin --}}
                            @if(auth()->user()->is_admin && !$post->is_published)
                                <form action="{{ route('posts.approve', $post) }}" method="POST" class="inline m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-emerald-500 bg-slate-50 hover:bg-emerald-50 dark:bg-slate-700 dark:hover:bg-emerald-500/20 rounded-lg transition-colors" title="Duyệt bài này">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('posts.edit', $post) }}" class="p-2 text-slate-400 hover:text-brand dark:hover:text-brand bg-slate-50 hover:bg-brand-light dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition-colors" title="Sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <form id="delete-form-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>

                            <button type="button" onclick="confirmDelete({{ $post->id }})" class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 dark:bg-slate-700 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Xóa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <svg class="w-20 h-20 mb-4 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <p class="text-lg font-medium">Chưa có bài viết nào.</p>
                <p class="text-sm mt-1 mb-6">Hãy chia sẻ câu chuyện đầu tiên của bạn!</p>
                <a href="{{ route('posts.create') }}" class="text-brand font-semibold hover:underline">Tạo bài viết mới</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
@endsection

@stack('scripts')
<script>
    function confirmDelete(postId) {
        const isDark = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Xóa bài viết này?',
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
                document.getElementById('delete-form-' + postId).submit();
            }
        });
    }
</script>
