@extends('layouts.app')

@section('title', 'Quản lý Sản phẩm')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
            <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Quản lý Sản phẩm
        </h1>
    </div>
    <a href="{{ route('products.create') }}" class="bg-brand text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-brand-hover transition-all flex items-center gap-2 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Thêm sản phẩm mới
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Sản phẩm</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Giá</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
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
                        <td class="px-6 py-4 font-bold text-brand">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-lg {{ $product->is_published ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $product->is_published ? 'Đã duyệt' : 'Chờ duyệt' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('products.edit', $product) }}" class="p-2 text-slate-400 hover:text-brand bg-slate-50 dark:bg-slate-700 rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Xóa sản phẩm này?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 dark:bg-slate-700 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
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
<div class="mt-6">{{ $products->links() }}</div>
@endsection
