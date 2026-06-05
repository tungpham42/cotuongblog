@extends('layouts.app')

{{-- Khai báo Title --}}
@section('title', $product->name)

{{-- Khai báo Meta Description lấy từ một phần description của sản phẩm --}}
@section('meta_description', Str::limit(strip_tags(Str::markdown($product->description)), 160))

{{-- Khai báo og:image tương thích với @yield('og_image') trong app.blade.php --}}
@if(!empty($product->gallery) && count($product->gallery) > 0)
    @section('og_image', asset('storage/' . $product->gallery[0]))
@endif

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

            @auth
                @if(auth()->user()->is_admin)
                    <div class="mb-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-amber-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Sửa sản phẩm
                        </a>
                    </div>
                @endif
            @endauth
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $product->name }}</h1>

            <div class="text-3xl font-black text-brand mb-6 py-4 border-y border-slate-100 dark:border-slate-700">
                {{ number_format($product->price, 0, ',', '.') }} <span class="text-xl">VNĐ</span>
            </div>

            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                {{ number_format($product->views) }} lượt xem
            </div>

            @if($product->video_url)
                <div class="mb-8">
                    @php
                        $embedUrl = $product->video_url;
                        $aspectClass = 'aspect-video'; // Tỷ lệ mặc định 16/9

                        // Xử lý link watch?v= (Video YouTube thường)
                        if(str_contains($embedUrl, 'watch?v=')) {
                            $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                            $embedUrl = explode('&', $embedUrl)[0]; // Xóa query param dư thừa
                        }
                        // Xử lý link Youtube Shorts
                        elseif (str_contains($embedUrl, '/shorts/')) {
                            $embedUrl = str_replace('/shorts/', '/embed/', $embedUrl);
                            $embedUrl = explode('?', $embedUrl)[0]; // Xóa query param nếu có
                            $aspectClass = 'aspect-[9/16] max-w-sm mx-auto'; // Chuyển tỷ lệ thành 9:16
                        }
                        // Xử lý link Facebook Reels
                        elseif (str_contains($embedUrl, 'facebook.com/reel') || str_contains($embedUrl, '/reels/')) {
                            $embedUrl = 'https://www.facebook.com/plugins/video.php?href=' . urlencode($embedUrl) . '&show_text=false';
                            $aspectClass = 'aspect-[9/16] max-w-sm mx-auto'; // Giữ tỷ lệ dọc 9:16 cho Reel
                        }
                    @endphp
                    <div class="{{ $aspectClass }} rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-md">
                        <iframe src="{{ $embedUrl }}" class="w-full h-full" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div>
            @endif

            @php
                // Use product's Zalo number, fallback to default if null or empty
                $zaloLink = $product->zalo_number ? $product->zalo_number : '0869456592';
            @endphp

            <div class="mt-auto space-y-4">
                {{-- Nút mua hàng Zalo --}}
                <div class="bg-brand/5 dark:bg-brand/10 p-6 rounded-2xl border border-brand/20">
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4">Để mua sản phẩm này, vui lòng liên hệ trực tiếp với người bán hoặc đặt hàng qua thông tin bên dưới:</p>
                    <a href="https://zalo.me/0368571310" target="_blank" class="w-full block text-center bg-brand text-white font-bold py-4 rounded-xl hover:bg-brand-hover hover:shadow-lg hover:shadow-brand/30 transition-all transform hover:-translate-y-1">
                        Liên hệ Zalo / Mua ngay
                    </a>
                </div>

                {{-- Nút chia sẻ mạng xã hội --}}
                <div class="flex items-center gap-4 px-2">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Chia sẻ:</span>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-slate-400 hover:text-[#1877F2] transition-colors" title="Chia sẻ lên Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                    </a>

                    <a href="https://x.com/intent/post?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" target="_blank" class="text-slate-400 hover:text-black dark:hover:text-white transition-colors" title="Chia sẻ lên X">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.96H5.078z"></path></svg>
                    </a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="text-slate-400 hover:text-[#0A66C2] transition-colors" title="Chia sẻ lên LinkedIn">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path></svg>
                    </a>

                    <a href="https://threads.net/intent/post?text={{ urlencode($product->name . ' ' . request()->url()) }}" target="_blank" class="text-slate-400 hover:text-black dark:hover:text-white transition-colors" title="Chia sẻ lên Threads">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 192 192"><path d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.708C154.894 45.6981 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 28.1872C147.036 10.146 124.965 0.217327 97.0132 0C64.714 0.238473 43.606 9.88283 29.597 27.6974C15.8608 45.1633 8.85075 68.618 8.60522 96C8.85075 123.382 15.8608 146.837 29.597 164.303C43.606 182.117 64.714 191.761 97.0135 192C124.935 191.782 146.873 181.865 161.68 163.791C178.077 143.774 175.433 121.229 166.726 100.916C161.854 89.545 153.308 80.5342 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6189 115.343C76.2234 107.925 82.3506 102.321 96.195 101.405C104.28 100.869 111.411 101.353 118.232 102.731C117.067 112.585 111.954 120.301 105.148 124.9C103.111 126.276 100.887 127.284 98.4405 129.507Z"/></svg>
                    </a>
                </div>
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
{{-- Render Schema.org JSON-LD --}}
@push('scripts')
    @isset($productSchema)
        {!! $productSchema->toScript() !!}
    @endisset

    @isset($breadcrumbSchema)
        {!! $breadcrumbSchema->toScript() !!}
    @endisset
@endpush
@endsection
