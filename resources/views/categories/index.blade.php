@extends('layouts.app')

@section('title', 'Quản lý chuyên mục')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Chuyên mục</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Quản lý các chuyên mục phân loại bài viết.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="bg-brand text-white px-5 py-2.5 rounded-xl shadow-md shadow-brand/30 hover:bg-brand-hover hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm chuyên mục
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase text-slate-700 dark:text-slate-300 font-semibold border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 w-16">Ảnh</th>
                        <th scope="col" class="px-6 py-4">Tên chuyên mục</th>
                        <th scope="col" class="px-6 py-4">Slug</th>
                        <th scope="col" class="px-6 py-4 text-center">Số bài viết</th>
                        <th scope="col" class="px-6 py-4 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                @if($category->featured_image)
                                    <img src="{{ asset('storage/' . $category->featured_image) }}" alt="{{ $category->name }}" class="w-12 h-12 rounded-lg object-cover shadow-sm border border-slate-100 dark:border-slate-600">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center shadow-sm text-slate-400 dark:text-slate-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-900 dark:text-white block">{{ $category->name }}</span>
                                @if($category->description)
                                    <span class="text-xs text-slate-400 mt-1 line-clamp-1 block">{{ $category->description }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-brand-light dark:bg-brand/20 text-brand px-2.5 py-1 rounded-lg font-semibold">{{ $category->posts_count }}</span>
                            </td>
                            <td class="px-6 py-4 flex justify-end gap-2 items-center h-full mt-2">
                                <a href="{{ route('categories.edit', $category) }}" class="p-2 text-slate-400 hover:text-brand dark:hover:text-brand bg-slate-50 hover:bg-brand-light dark:bg-slate-700 dark:hover:bg-slate-600 rounded-lg transition-colors" title="Sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" onclick="confirmDelete({{ $category->id }})" class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 dark:bg-slate-700 dark:hover:bg-red-500/20 rounded-lg transition-colors" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">
                                Chưa có chuyên mục nào. <a href="{{ route('categories.create') }}" class="text-brand hover:underline font-medium">Tạo mới ngay</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        {{ $categories->links() }}
    </div>
@endsection

@stack('scripts')
<script>
    function confirmDelete(id) {
        const isDark = document.documentElement.classList.contains('dark');
        Swal.fire({
            title: 'Xóa chuyên mục này?',
            text: "Nếu chuyên mục đang có bài viết, bạn sẽ không thể xóa nó!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: isDark ? '#475569' : '#94a3b8',
            background: isDark ? '#1e293b' : '#ffffff',
            color: isDark ? '#f8fafc' : '#0f172a',
            confirmButtonText: 'Đồng ý, xóa!',
            cancelButtonText: 'Hủy',
            customClass: { popup: 'rounded-2xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
