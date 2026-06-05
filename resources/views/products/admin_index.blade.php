@extends('layouts.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 text-sm">
                    <th class="px-6 py-4 font-bold">Sản phẩm</th>
                    <th class="px-6 py-4 font-bold text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody id="sortable-products" class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($products as $product)
                    <tr data-id="{{ $product->id }}" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors cursor-move">
                        <td class="px-6 py-4 w-full">
                            <div class="flex items-center gap-4">
                                <svg class="w-5 h-5 text-slate-400 cursor-move shrink-0 hover:text-brand transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>

                                <div class="h-16 w-16 shrink-0 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-700">
                                    @if(!empty($product->gallery))
                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $product->gallery[0]) }}" alt="">
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-slate-900 dark:text-white hover:text-brand transition-colors line-clamp-1">
                                        {{ $product->name }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2" x-data>
                                {{-- Nút Sửa --}}
                                <a href="{{ route('products.edit', $product->id) }}" class="p-2 text-slate-400 hover:text-brand bg-slate-50 hover:bg-brand/10 dark:bg-slate-700 dark:hover:bg-brand/20 rounded-lg transition-colors" title="Sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                {{-- Nút Xóa (Kích hoạt Swal qua AlpineJS) --}}
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        @click="
                                            const isDark = document.documentElement.classList.contains('dark');
                                            Swal.fire({
                                                title: 'Xác nhận xóa?',
                                                text: 'Sản phẩm này sẽ bị xóa vĩnh viễn và không thể khôi phục!',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ef4444',
                                                cancelButtonColor: '#64748b',
                                                confirmButtonText: 'Đồng ý xóa',
                                                cancelButtonText: 'Hủy bỏ',
                                                background: isDark ? '#1e293b' : '#ffffff',
                                                color: isDark ? '#f8fafc' : '#0f172a',
                                                reverseButtons: true
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $event.target.closest('form').submit();
                                                }
                                            })
                                        "
                                        class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 dark:bg-slate-700 dark:hover:bg-red-500/10 rounded-lg transition-colors cursor-pointer" title="Xóa">
                                        {{-- pointer-events-none để đảm bảo $event.target luôn nhắm đúng vào <button> thay vì thẻ <svg> --}}
                                        <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center py-10 text-slate-500 font-medium">Chưa có sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('sortable-products');
        if (el) {
            Sortable.create(el, {
                animation: 150,
                ghostClass: 'bg-orange-50',
                handle: '.cursor-move', // Chỉ cho phép kéo thả khi nắm vào icon kéo hoặc khu vực được chỉ định
                onEnd: function (evt) {
                    let order = [];
                    // Extract the new order of product IDs
                    document.querySelectorAll('#sortable-products tr[data-id]').forEach(function(row) {
                        order.push(row.getAttribute('data-id'));
                    });

                    // Send the new order to the backend
                    fetch('{{ route('admin.products.update-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            const isDark = document.documentElement.classList.contains('dark');
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Đã cập nhật thứ tự sản phẩm',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                background: isDark ? '#1e293b' : '#ffffff',
                                color: isDark ? '#f8fafc' : '#0f172a',
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        }
    });
</script>
@endpush
