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

            @if($product->video_url)
                <div class="mb-8">
                    <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> Video Demo
                    </h3>
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
                            $aspectClass = 'aspect-[9/16] max-w-sm mx-auto'; // Chuyển tỷ lệ thành 9:16 và giới hạn độ rộng tối đa
                        }
                    @endphp
                    <div class="{{ $aspectClass }} rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-md">
                        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            @php
                // Use product's Zalo number, fallback to default if null or empty
                $zaloLink = $product->zalo_number ? $product->zalo_number : '0368571310';
            @endphp

            <div class="mt-auto space-y-4">
                {{-- Nút mua hàng Zalo --}}
                <div class="bg-brand/5 dark:bg-brand/10 p-6 rounded-2xl border border-brand/20">
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 mb-4">Để mua sản phẩm này, vui lòng liên hệ trực tiếp với người bán hoặc đặt hàng qua thông tin bên dưới:</p>
                    <a href="https://zalo.me/{{ $zaloLink }}" target="_blank" class="w-full block text-center bg-brand text-white font-bold py-4 rounded-xl hover:bg-brand-hover hover:shadow-lg hover:shadow-brand/30 transition-all transform hover:-translate-y-1">
                        Liên hệ Zalo / Mua ngay
                    </a>
                </div>

                {{-- Nút chia sẻ mạng xã hội --}}
                <div class="flex items-center gap-4 px-2">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Chia sẻ:</span>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-slate-400 hover:text-[#1877F2] transition-colors" title="Chia sẻ lên Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>

                    <a href="https://x.com/intent/post?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" target="_blank" class="text-slate-400 hover:text-black dark:hover:text-white transition-colors" title="Chia sẻ lên X">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                    </a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" class="text-slate-400 hover:text-[#0A66C2] transition-colors" title="Chia sẻ lên LinkedIn">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>

                    <a href="https://threads.net/intent/post?text={{ urlencode($product->name . ' ' . request()->url()) }}" target="_blank" class="text-slate-400 hover:text-black dark:hover:text-white transition-colors" title="Chia sẻ lên Threads">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22.5c-5.799 0-10.5-4.701-10.5-10.5S6.201 1.5 12 1.5s10.5 4.701 10.5 10.5-4.701 10.5-10.5 10.5zm0-19.5c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm-1.802 12.384v-.004c-.068.002-.136.004-.204.004-2.825 0-4.664-1.874-4.664-4.884 0-3.008 1.838-4.883 4.665-4.883 2.825 0 4.663 1.875 4.663 4.883v1.177c0 1.258-.698 2.007-1.684 2.007-.803 0-1.396-.496-1.503-1.19h-.032c-.512.784-1.395 1.293-2.457 1.293-1.636 0-2.82-1.127-2.82-2.736 0-1.609 1.184-2.735 2.82-2.735 1.062 0 1.945.51 2.457 1.294h.032V8.125h2.15v5.183c0 1.851 1.272 3.125 3.036 3.125 2.035 0 3.65-1.558 3.65-3.933 0-2.375-1.615-3.932-3.65-3.932-1.764 0-3.036 1.274-3.036 3.125h-2.15c0-3.008 1.838-4.883 4.664-4.883 2.826 0 4.665 1.875 4.665 4.883 0 3.01-1.839 4.884-4.665 4.884-2.826 0-4.665-1.874-4.665-4.884zM10.02 11.23c-1.025 0-1.745.748-1.745 1.703 0 .954.72 1.703 1.745 1.703 1.026 0 1.746-.749 1.746-1.703 0-.955-.72-1.703-1.746-1.703z"/></svg>
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
@endsection
