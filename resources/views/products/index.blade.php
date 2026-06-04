@extends('layouts.app')

@section('title', 'Cửa hàng Kỳ Đạo')

@section('og:image', asset('img/cua-hang.jpg'))

@section('content')
<div class="mb-12 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Cửa hàng <span class="text-brand">Kỳ Đạo</span></h1>
    <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Trang bị cho mình những bộ cờ, sách học cờ và khóa học chất lượng nhất.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($products as $product)
        <a href="{{ route('products.show', $product->slug) }}" class="group bg-white dark:bg-slate-800 rounded-3xl shadow-sm hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] border border-slate-100 dark:border-slate-700/80 overflow-hidden transition-all duration-300 transform hover:-translate-y-2 flex flex-col">

            <div class="aspect-square bg-slate-50 dark:bg-slate-900 relative overflow-hidden">
                @if(!empty($product->gallery))
                    <img src="{{ asset('storage/' . $product->gallery[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm10 8l-3-4-2.5 3-1.5-2L7 14h9z"/></svg>
                    </div>
                @endif
            </div>

            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand transition-colors line-clamp-2 mb-2">{{ $product->name }}</h3>
                <div class="mt-auto pt-4 flex items-center justify-between border-t border-slate-100 dark:border-slate-700">
                    <span class="text-xl font-black text-brand">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    <span class="text-sm font-bold bg-brand/10 text-brand px-3 py-1.5 rounded-lg group-hover:bg-brand group-hover:text-white transition-colors">Xem chi tiết</span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-span-full py-16 text-center border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-3xl">
            <p class="text-slate-500 font-bold">Hiện chưa có sản phẩm nào.</p>
        </div>
    @endforelse
</div>

<div class="mt-12">{{ $products->links() }}</div>
@endsection
