@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto bg-white dark:bg-slate-800 rounded-[2.5rem] p-6 md:p-12 shadow-[0_15px_40px_rgba(0,0,0,0.06)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.3)] border border-slate-100 dark:border-slate-700/80">

    <div class="flex flex-col lg:flex-row gap-12 mb-12">
        <div class="w-full lg:w-1/2 space-y-4" x-data="{ mainImage: '{{ !empty($product->gallery) ? asset('storage/' . $product->gallery[0]) : '' }}' }">
            @if(!empty($product->gallery))
                <div class="aspect-square rounded-3xl overflow-hidden bg-slate-50 border border-slate-100 dark:border-slate-700">
                    <img :src="mainImage" class="w-full h-full object-cover transition-all duration-300" alt="{{ $product->name }}">
                </div>
                @if(count($product->gallery) > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->gallery as $img)
                        <div @click="mainImage = '{{ asset('storage/' . $img) }}'" class="aspect-square rounded-xl overflow-hidden cursor-pointer border-2 hover:border-brand transition-colors" :class="mainImage === '{{ asset('storage/' . $img) }}' ? 'border-brand opacity-100' : 'border-transparent opacity-70'">
                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover" alt="">
                        </div>
                    @endforeach
                </div>
                @endif
            @else
                <div class="aspect-square rounded-3xl bg-slate-100 dark:bg-slate-900 flex items-center justify-center">
                    <span class="text-slate-400">Không có ảnh</span>
                </div>
            @endif
        </div>

        <div class="w-full lg:w-1/2 flex flex-col">

            <!-- THÊM NÚT SỬA SẢN PHẨM CHO ADMIN -->
            @auth
                @if(auth()->user()->is_admin) {{-- Bạn hãy đổi is_admin thành logic check quyền admin thực tế của hệ thống bạn --}}
                    <div class="mb-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-amber-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Sửa sản phẩm
                        </a>
                    </div>
                @endif
            @endauth
            <!-- END NÚT SỬA -->

            <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $product->name }}</h1>

            <div class="text-3xl font-black text-brand mb-6 py-4 border-y border-slate-100 dark:border-slate-700">
                {{ number_format($product->price, 0, ',', '.') }} <span class="text-xl">VNĐ</span>
            </div>

            @if($product->video_url)
                <div class="mb-8">
                    <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Video Demo
                    </h3>
                    @php
                        // Chuyển link youtube thường sang link embed
                        $embedUrl = $product->video_url;
                        if(str_contains($embedUrl, 'watch?v=')) {
                            $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                            // Xóa các query string dư thừa nếu có (vd &t=)
                            $embedUrl = explode('&', $embedUrl)[0];
                        }
                    @endphp
                    <div class="aspect-video rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-md">
                        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            @endif
            @php
                // Use product's Zalo number, fallback to default if null or empty
                $zaloLink = $product->zalo_number ? $product->zalo_number : '0368571310';
            @endphp
            <div class="mt-auto bg-brand/5 dark:bg-brand/10 p-6 rounded-2xl border border-brand/20">
                <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4">Để mua sản phẩm này, vui lòng liên hệ trực tiếp với người bán hoặc đặt hàng qua thông tin bên dưới:</p>
                <a href="https://zalo.me/{{ $zaloLink }}" target="_blank" class="w-full block text-center bg-brand text-white font-bold py-4 rounded-xl hover:bg-brand-hover hover:shadow-lg hover:shadow-brand/30 transition-all transform hover:-translate-y-1">
                    Liên hệ Zalo / Mua ngay
                </a>
            </div>
        </div>
    </div>

    <div class="pt-12 border-t border-slate-100 dark:border-slate-700">
        <h2 class="text-2xl font-black mb-8 flex items-center gap-3 text-slate-900 dark:text-white">
            <div class="p-2.5 bg-brand-light dark:bg-brand/20 rounded-xl text-brand">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </div>
            Chi tiết sản phẩm
        </h2>

        <div class="prose prose-lg prose-slate dark:prose-invert max-w-none prose-headings:font-black prose-a:text-brand prose-img:rounded-2xl">
            {!! Str::markdown($product->description) !!}
        </div>
    </div>
</div>
@endsection
