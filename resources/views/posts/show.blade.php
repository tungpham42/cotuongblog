@extends('layouts.app')

@section('title', $post->title)

@if($post->featured_image)
    @section('og_image', asset('storage/' . $post->featured_image))
@endif

@section('meta_description', $post->excerpt ?? \Illuminate\Support\Str::limit($post->excerpt ?? $post->content, 160))

@section('content')

@php
    $htmlContent = \Illuminate\Support\Str::markdown($post->content ?? '');

    // TÍNH THỜI GIAN ĐỌC TRUNG BÌNH
    $plainText = strip_tags($htmlContent);
    $wordCount = count(preg_split('~[^\p{L}\p{N}\']+~u', $plainText, -1, PREG_SPLIT_NO_EMPTY));
    $readingTime = ceil($wordCount / 250);
    if ($readingTime < 1) $readingTime = 1;

    // TẠO MỤC LỤC (TOC)
    $toc = [];
    $htmlContent = preg_replace_callback(
        '/<h([1-6])(.*?)>(.*?)<\/h\1>/is',
        function ($matches) use (&$toc) {
            $level = $matches[1];
            $rawText = html_entity_decode(strip_tags($matches[3]), ENT_QUOTES, 'UTF-8');
            $id = \Illuminate\Support\Str::slug($rawText);

            $originalId = $id;
            $counter = 1;
            while (in_array($id, array_column($toc, 'id'))) {
                $id = $originalId . '-' . $counter;
                $counter++;
            }

            $toc[] = [
                'level' => $level,
                'id' => $id,
                'text' => trim($rawText),
            ];

            return "<h{$level} id=\"{$id}\" style=\"scroll-margin-top: 6rem;\"{$matches[2]}>{$matches[3]}</h{$level}>";
        },
        $htmlContent
    );

    // CHÈN QUẢNG CÁO VÀO NỘI DUNG
    $adCode = '
    <div class="my-8 w-full overflow-hidden flex justify-center not-prose">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536" crossorigin="anonymous"></script>
        <ins class="adsbygoogle"
             style="display:block; width:100%; height:120px; text-align:center;"
             data-ad-layout="in-article"
             data-ad-format="fluid"
             data-ad-client="ca-pub-3585118770961536"
             data-ad-slot="5187852886"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>';

    // Tách nội dung thành các đoạn (paragraphs)
    $paragraphs = explode('</p>', $htmlContent);
    $totalParagraphs = count($paragraphs);

    // Logic chèn quảng cáo ít nhất 2 lần (nếu bài viết có từ 3 đoạn trở lên)
    if ($totalParagraphs >= 3) {
        // Lấy mốc 1/3 và 2/3 bài viết để chèn
        $pos1 = (int) round($totalParagraphs * 0.33);
        $pos2 = (int) round($totalParagraphs * 0.66);

        // Đảm bảo 2 vị trí không trùng nhau nếu bài viết quá ngắn
        if ($pos1 === $pos2) {
            $pos2 = $pos1 + 1;
        }

        // Chèn vào vị trí 1
        if (isset($paragraphs[$pos1])) {
            $paragraphs[$pos1] .= $adCode;
        }

        // Chèn vào vị trí 2
        if (isset($paragraphs[$pos2]) && $pos2 < $totalParagraphs) {
            $paragraphs[$pos2] .= $adCode;
        }
    } elseif ($totalParagraphs == 2) {
        // Dự phòng cho bài cực ngắn, chèn 1 cái ở giữa
        $paragraphs[1] .= $adCode;
    }

    // Nối các đoạn lại với nhau
    $htmlContent = implode('</p>', $paragraphs);

@endphp

<div class="max-w-4xl mx-auto relative">
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-brand/10 dark:bg-brand/20 rounded-full blur-[4rem] pointer-events-none"></div>
    <div class="absolute top-40 -right-20 w-72 h-72 bg-yellow-400/10 dark:bg-yellow-400/5 rounded-full blur-[4rem] pointer-events-none"></div>

    {{-- Khối bài viết chính --}}
    <article class="relative z-10 bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-[0_15px_40px_rgba(0,0,0,0.06)] dark:shadow-[0_15px_40px_rgba(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden transition-colors duration-300">

        {{-- Ảnh bìa --}}
        @if($post->featured_image)
            <figure class="w-full aspect-[1200/630] sm:aspect-[2/1] relative overflow-hidden bg-slate-100 dark:bg-slate-900 group">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transform transition-transform duration-1000 ease-out hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
            </figure>
        @endif

        <div class="p-6 sm:p-10 lg:p-12">

            {{-- Category, Date & Reading Time --}}
            <div class="flex flex-wrap items-center gap-4 mb-6">
                @if($post->category)
                    <a href="{{ route('categories.show', $post->category) }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-brand bg-brand-light dark:bg-brand/20 dark:text-brand-light px-3.5 py-1.5 rounded-xl shadow-sm hover:-translate-y-0.5 transition-transform">
                        {{ $post->category->name }}
                    </a>
                @endif

                <div class="flex items-center gap-3">
                    {{-- Ngày đăng --}}
                    <span class="text-slate-500 dark:text-slate-400 text-sm font-semibold flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $post->created_at->format('d/m/Y') }}
                    </span>

                    {{-- Dấu chấm phân cách --}}
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600"></span>

                    {{-- Thời gian đọc --}}
                    <span class="text-slate-500 dark:text-slate-400 text-sm font-semibold flex items-center gap-1.5" title="Thời gian đọc ước tính">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $readingTime }} phút đọc
                    </span>
                </div>
            </div>

            {{-- Tiêu đề --}}
            <h1 class="text-[clamp(1.75rem,5vw,3rem)] font-black text-slate-900 dark:text-white tracking-tight leading-snug mb-8">
                {{ $post->title }}
            </h1>

            {{-- Tác giả & Lượt xem --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-5 border-y border-slate-100 dark:border-slate-700/80 mb-10 bg-slate-50/50 dark:bg-slate-800/50 rounded-2xl px-4 sm:px-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-brand-light dark:bg-brand/20 flex items-center justify-center text-brand font-black text-lg shadow-sm border border-brand/10">
                        {{ mb_substr($post->author->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider mb-0.5">Tác giả</div>
                        <div class="font-bold text-slate-900 dark:text-slate-100 text-base">{{ $post->author->name ?? 'Khách truy cập' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 px-4 py-2 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 font-semibold text-sm">
                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    {{ number_format($post->views ?? 0) }} lượt xem
                </div>
            </div>

            {{-- Mục Lục Tĩnh --}}
            @if(!empty($toc))
            <div id="toc-container" class="mb-10 p-6 sm:p-8 bg-brand/5 dark:bg-brand/10 rounded-[2rem] border border-brand/10 dark:border-brand/20 relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-5 relative z-10">
                    <div class="p-2.5 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-brand">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    </div>
                    <h3 id="toc-heading" class="text-xl font-black text-slate-900 dark:text-white" style="scroll-margin-top: 6rem;">Mục lục</h3>
                </div>
                <ul class="space-y-3 text-slate-700 dark:text-slate-300 font-medium relative z-10">
                    @foreach($toc as $item)
                        @php
                            $marginLeft = $item['level'] > 1 ? ($item['level'] - 1) * 1.5 . 'rem' : '0';
                        @endphp
                        <li style="margin-left: {{ $marginLeft }}">
                            <a href="#{{ $item['id'] }}" class="hover:text-brand dark:hover:text-brand transition-colors flex items-start gap-2 group/link">
                                <span class="text-brand/50 mt-1.5 opacity-0 group-hover/link:opacity-100 transition-opacity">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8"></circle></svg>
                                </span>
                                {{ $item['text'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Nội dung bài viết --}}
            <div class="mb-12 text-left prose prose-lg prose-slate dark:prose-invert max-w-none prose-headings:font-black prose-a:text-brand hover:prose-a:text-brand-hover prose-img:rounded-2xl prose-img:shadow-md">
                {!! $htmlContent !!}
            </div>

            {{-- Thẻ (Tags) & Chia sẻ --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 py-6 border-y border-slate-100 dark:border-slate-700/80 mb-12">
                <div class="flex flex-wrap gap-2.5">
                    @if($post->tags && $post->tags->count() > 0)
                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag) }}" class="px-4 py-2 text-sm font-bold bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-brand hover:text-white dark:hover:bg-brand dark:hover:text-white hover:border-brand shadow-sm hover:shadow-[0_4px_15px_rgba(249,115,22,0.25)] transition-all duration-300 hover:-translate-y-0.5">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    @endif
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-sm font-bold text-slate-500 dark:text-slate-400 mr-2 uppercase tracking-wider">Chia sẻ</span>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] shadow-sm hover:shadow-[0_4px_15px_rgba(24,119,242,0.3)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                    </a>

                    {{-- X / Twitter --}}
                    <a href="https://x.com/intent/post?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black shadow-sm hover:shadow-[0_4px_15px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua X">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.96H5.078z"></path></svg>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] shadow-sm hover:shadow-[0_4px_15px_rgba(10,102,194,0.3)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path></svg>
                    </a>

                    {{-- Reddit --}}
                    <a href="https://reddit.com/submit?url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-[#FF4500] hover:text-white hover:border-[#FF4500] shadow-sm hover:shadow-[0_4px_15px_rgba(255,69,0,0.3)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua Reddit">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.505 1.204-.863 2.88-1.43 4.734-1.498l.886-4.144a.2.2 0 0 1 .238-.152l2.846.598a1.254 1.254 0 0 1 1.317-.811zm-8.083 8.358c-.71 0-1.285.576-1.285 1.285 0 .71.576 1.285 1.285 1.285.71 0 1.285-.575 1.285-1.285 0-.71-.575-1.285-1.285-1.285zm7.143 0c-.71 0-1.285.576-1.285 1.285 0 .71.576 1.285 1.285 1.285.71 0 1.285-.575 1.285-1.285 0-.71-.575-1.285-1.285-1.285zm-3.571 3.322c-1.57 0-2.48.513-2.553.555a.2.2 0 0 0-.083.27.2.2 0 0 0 .27.082c.045-.022.841-.468 2.366-.468 1.527 0 2.325.448 2.368.47a.2.2 0 0 0 .27-.084.2.2 0 0 0-.084-.27c-.074-.042-.983-.555-2.554-.555z"/></svg>
                    </a>

                    {{-- Threads --}}
                    <a href="https://threads.net/intent/post?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black shadow-sm hover:shadow-[0_4px_15px_rgba(0,0,0,0.2)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua Threads">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 192 192"><path d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.708C154.894 45.6981 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 28.1872C147.036 10.146 124.965 0.217327 97.0132 0C64.714 0.238473 43.606 9.88283 29.597 27.6974C15.8608 45.1633 8.85075 68.618 8.60522 96C8.85075 123.382 15.8608 146.837 29.597 164.303C43.606 182.117 64.714 191.761 97.0135 192C124.935 191.782 146.873 181.865 161.68 163.791C178.077 143.774 175.433 121.229 166.726 100.916C161.854 89.545 153.308 80.5342 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6189 115.343C76.2234 107.925 82.3506 102.321 96.195 101.405C104.28 100.869 111.411 101.353 118.232 102.731C117.067 112.585 111.954 120.301 105.148 124.9C103.111 126.276 100.887 127.284 98.4405 129.507Z"/></svg>
                    </a>

                    {{-- Telegram --}}
                    <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-700 text-slate-500 hover:bg-[#229ED9] hover:text-white hover:border-[#229ED9] shadow-sm hover:shadow-[0_4px_15px_rgba(34,158,217,0.3)] transition-all duration-300 hover:-translate-y-1" title="Chia sẻ qua Telegram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    </a>

                </div>
            </div>

            {{-- Khu vực Bình luận --}}
            <div class="mt-8">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                        <div class="p-2.5 bg-brand-light dark:bg-brand/20 rounded-xl text-brand shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        </div>
                        Bình luận ({{ $post->comments->count() }})
                    </h3>
                </div>

                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-12">
                        @csrf
                        <div class="relative">
                            <textarea name="content" rows="3" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-[1.5rem] focus:ring-4 focus:ring-brand/20 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none resize-none shadow-inner" placeholder="Chia sẻ suy nghĩ của bạn..." required></textarea>
                            <div class="absolute bottom-3 right-3">
                                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-lg shadow-brand/30 transition-all duration-300 font-bold hover:-translate-y-0.5">
                                    Gửi ngay
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-slate-50 dark:bg-slate-900/50 p-8 rounded-[1.5rem] border border-dashed border-slate-200 dark:border-slate-700 text-center mb-12">
                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <p class="text-slate-600 dark:text-slate-300 font-medium">Bạn cần <a href="{{ route('login') }}" class="text-brand font-bold hover:underline">đăng nhập</a> để tham gia thảo luận.</p>
                    </div>
                @endauth

                <div class="space-y-6">
                    @forelse($post->comments as $comment)
                        <div class="bg-white dark:bg-slate-800 rounded-[1.5rem] p-6 border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand/20 to-brand/5 flex items-center justify-center text-brand font-black text-lg border border-brand/10 shadow-sm">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-lg">{{ $comment->user->name }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>

                                @if(auth()->check() && auth()->user()->is_admin)
                                    <div class="ml-auto">
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-comment-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 dark:bg-slate-700 dark:hover:bg-red-500/20 p-2.5 rounded-xl transition-colors" title="Xóa bình luận">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <p class="text-slate-700 dark:text-slate-300 leading-relaxed font-medium pl-16">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-slate-400 dark:text-slate-500 font-medium italic">Chưa có bình luận nào. Hãy chia sẻ suy nghĩ đầu tiên của bạn!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </article>

    {{-- Bài viết liên quan --}}
    @if ($relatedPosts->count() > 0)
        <section class="mt-16">
            <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-8 flex items-center gap-3 relative z-10">
                <div class="p-2.5 bg-brand-light dark:bg-brand/20 rounded-xl text-brand shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v4a2 2 0 002 2h4"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 9h10M7 13h10M7 17h10"></path>
                    </svg>
                </div>
                Bài viết liên quan
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                @foreach ($relatedPosts as $rPost)
                    <article class="group flex flex-col bg-white dark:bg-slate-800 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.06)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)] border border-slate-100/80 dark:border-slate-700/80 overflow-hidden hover:shadow-[0_20px_40px_rgba(249,115,22,0.15)] dark:hover:shadow-[0_20px_40px_rgba(249,115,22,0.12)] hover:border-brand/40 transition-all duration-500 transform hover:-translate-y-2 relative">

                        <a href="{{ route('posts.show', $rPost->slug) }}" class="block aspect-[1200/630] w-full bg-slate-50 dark:bg-slate-900 relative overflow-hidden focus:outline-none">
                            @if($rPost->featured_image)
                                <img src="{{ asset('storage/' . $rPost->featured_image) }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-all duration-700 ease-out">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 text-slate-300 dark:text-slate-600 transition-colors duration-500 group-hover:text-brand/50">
                                    <svg class="w-12 h-12 transform group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-slate-800 dark:text-slate-200 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md transform group-hover:-translate-y-1 transition-transform duration-500">
                                <svg class="w-3.5 h-3.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                {{ number_format($rPost->views ?? 0) }}
                            </div>
                        </a>

                        <div class="p-6 flex flex-col flex-grow relative bg-white dark:bg-slate-800 z-10 rounded-b-[2rem]">
                            <div class="absolute -top-4 left-6">
                                <span class="inline-flex items-center gap-1 bg-brand text-white text-[10px] uppercase tracking-wider font-extrabold px-3 py-1.5 rounded-lg shadow-md shadow-brand/30 transform group-hover:-translate-y-1 transition-transform duration-500">
                                    {{ $rPost->created_at->locale('vi')->diffForHumans() }}
                                </span>
                            </div>

                            <h4 class="text-xl font-black text-slate-900 dark:text-white group-hover:text-brand transition-colors duration-300 line-clamp-2 leading-tight mt-2 mb-4">
                                <a href="{{ route('posts.show', $rPost->slug) }}" class="focus:outline-none focus:text-brand">
                                    {{ $rPost->title }}
                                </a>
                            </h4>

                            <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700/50 flex justify-end">
                                <a href="{{ route('posts.show', $rPost->slug) }}" class="flex items-center gap-1 text-sm font-bold text-brand opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                                    Đọc ngay
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>

{{-- Nút Trở về Mục lục (Floating nổi bật) --}}
@if(!empty($toc))
    <div x-data="{ showTocBtn: false }"
            @scroll.window="
            const toc = document.getElementById('toc-container');
            showTocBtn = toc ? window.scrollY > (toc.offsetTop + toc.offsetHeight + 42) : false;
            "
            x-show="showTocBtn"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-8 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-90"
            class="fixed bottom-6 left-6 lg:left-8 z-50 hidden sm:block"
            style="display: none;">

        <button @click="document.getElementById('toc-heading').scrollIntoView({ behavior: 'smooth' })"
                class="flex items-center gap-2.5 px-5 py-3.5 bg-brand text-white shadow-[0_10px_25px_rgba(249,115,22,0.4)] dark:shadow-[0_10px_25px_rgba(249,115,22,0.3)] rounded-full hover:bg-brand-hover transition-all duration-300 group hover:-translate-y-1.5 outline-none font-bold ring-4 ring-white/50 dark:ring-slate-800/50 hover:ring-brand/30">

            <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>

            <span class="text-sm tracking-wide">Mục lục</span>

            <svg class="w-4 h-4 ml-0.5 group-hover:-translate-y-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
            </svg>
        </button>
    </div>
@endif

@push('scripts')
{{-- SEO: Dynamic BlogPosting Schema.org JSON-LD --}}
{!! $postSchema->toScript() !!}

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const deleteForms = document.querySelectorAll('.delete-comment-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    title: 'Xóa bình luận này?',
                    text: "Hành động này không thể hoàn tác!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: isDark ? '#475569' : '#94a3b8',
                    confirmButtonText: 'Đồng ý, xóa!',
                    cancelButtonText: 'Hủy',
                    background: isDark ? '#1e293b' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#0f172a',
                    customClass: { popup: 'rounded-2xl' },
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Smooth scroll for TOC
        document.querySelectorAll('#toc-container a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const idWithoutHash = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(idWithoutHash);

                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                    history.pushState(null, null, '#' + idWithoutHash);
                }
            });
        });
    });
</script>
@endpush
@endsection
