@extends('layouts.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                </thead>
            <tbody id="sortable-products" class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($products as $product)
                    <tr data-id="{{ $product->id }}" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors cursor-move">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <svg class="w-5 h-5 text-slate-400 cursor-move shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>

                                <div class="h-16 w-16 shrink-0 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-700">
                                    @if(!empty($product->gallery))
                                        <img class="h-full w-full object-cover" src="{{ asset('storage/' . $product->gallery[0]) }}" alt="">
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-slate-900 dark:text-white hover:text-brand line-clamp-1">
                                        {{ $product->name }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-10 text-slate-500">Chưa có sản phẩm nào.</td></tr>
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
