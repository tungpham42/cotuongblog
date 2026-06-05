@extends('layouts.app')

@section('title', 'Cửa hàng Kỳ Đạo')

@section('og_image', asset('img/cua-hang.jpg'))

@section('content')
<div class="mb-12 text-center">
    <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">Cửa hàng <span class="text-brand">Kỳ Đạo</span></h1>
    <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Trang bị cho mình những bộ cờ, sách học cờ và khóa học chất lượng nhất.</p>
</div>

{{-- Search & Sort Filter Bar (Matching Category Style) --}}
<div class="flex flex-col gap-5 pb-5 mb-6 pt-4">
    <form action="{{ route('products.index') }}" method="GET" class="relative z-30 w-full">
        <div class="flex flex-col sm:flex-row items-center w-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-[2rem] sm:rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-200/80 dark:border-slate-700/80 p-1.5 gap-2 transition-all duration-500 hover:shadow-[0_15px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_15px_40px_rgba(249,115,22,0.1)] hover:border-brand/40 focus-within:ring-4 focus-within:ring-brand/10 focus-within:border-brand dark:focus-within:border-brand">

            <div class="relative flex items-center w-full flex-grow group/search">
                <div class="absolute left-4 text-brand/60 group-focus-within/search:text-brand transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Tìm kiếm sản phẩm..."
                    class="w-full bg-transparent border-none outline-none focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 pl-11 pr-14 py-2.5 text-[15px] font-medium transition-all duration-300 placeholder:font-normal [&:-webkit-autofill]:[transition:background-color_5000s_ease-in-out_0s] [&:-webkit-autofill]:[-webkit-text-fill-color:#1e293b] dark:[&:-webkit-autofill]:[-webkit-text-fill-color:#f8fafc]">

                <button type="submit" aria-label="Tìm kiếm" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-brand/10 hover:bg-brand text-brand hover:text-white dark:bg-brand/20 dark:hover:bg-brand transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand/50 group-focus-within/search:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-slate-200 dark:via-slate-700 to-transparent"></div>

            <div x-data="{
                    open: false,
                    selected: '{{ request('sort', 'latest') }}',
                    options: {
                        'latest': 'Mặc định / Mới nhất',
                        'price_asc': 'Giá: Thấp đến Cao',
                        'price_desc': 'Giá: Cao đến Thấp',
                        'oldest': 'Cũ nhất'
                    },
                    selectOption(value) {
                        this.selected = value;
                        this.open = false;
                        setTimeout(() => this.$el.closest('form').submit(), 150);
                    }
                }" class="relative w-full sm:w-auto shrink-0" @click.away="open = false">

                <input type="hidden" name="sort" :value="selected">

                <button type="button" @click="open = !open"
                    class="flex items-center justify-between w-full sm:w-[250px] bg-slate-50 dark:bg-slate-900/50 hover:bg-brand dark:hover:bg-brand text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-[1.5rem] sm:rounded-full px-5 py-2.5 text-sm font-bold transition-all duration-300 ease-out cursor-pointer group/btn">

                    <div class="flex items-center gap-2.5">
                        <div class="p-1 rounded-md bg-slate-200/50 dark:bg-slate-700/50 group-hover/btn:bg-white/20 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                        </div>
                        <span x-text="options[selected]" class="truncate tracking-wide"></span>
                    </div>

                    <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover/btn:scale-110" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute right-0 z-50 w-full sm:w-[260px] mt-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-slate-100 dark:border-slate-700/80 rounded-[1.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] overflow-hidden p-2 origin-top-right"
                    style="display: none;">

                    <div class="space-y-1">
                        <template x-for="(label, value) in options" :key="value">
                            <button type="button" @click="selectOption(value)"
                                class="w-full text-left px-4 py-3 text-[14px] rounded-xl flex items-center justify-between transition-all duration-200"
                                :class="{
                                    'bg-brand text-white font-bold shadow-md shadow-brand/20 transform scale-[1.02]': selected === value,
                                    'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-brand dark:hover:text-brand font-medium': selected !== value
                                }">
                                <span x-text="label"></span>
                                <svg x-show="selected === value" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Search Header --}}
    @if(request()->has('search') || request()->has('sort'))
        <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2 mt-2 px-2">
            <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h3m-3 4h3m-6-4h.01M6 15h.01M8 20h8"></path></svg>
            @php
                $headerText = request('search') ? 'Kết quả tìm kiếm cho: "' . request('search') . '"' : match(request('sort')) {
                    'price_asc' => 'Sản phẩm giá thấp đến cao',
                    'price_desc' => 'Sản phẩm giá cao đến thấp',
                    'oldest' => 'Sản phẩm cũ nhất',
                    default => 'Danh sách sản phẩm',
                };
            @endphp
            {{ $headerText }}
            @if(request()->has('search'))
                <a href="{{ route('products.index') }}" class="ml-2 text-sm text-brand hover:underline font-medium">(Xóa bộ lọc)</a>
            @endif
        </h2>
    @endif
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
            <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-slate-500 font-bold text-lg">Không tìm thấy sản phẩm nào.</p>
            @if(request()->has('search') || request()->has('sort'))
                <a href="{{ route('products.index') }}" class="inline-block mt-4 text-brand hover:text-brand-hover font-bold">Quay lại tất cả sản phẩm</a>
            @endif
        </div>
    @endforelse
</div>

<div class="mt-12">{{ $products->links() }}</div>
@endsection
