@extends('layouts.app')

@section('title', $post->title)

@if($post->featured_image)
    @section('og_image', asset('storage/' . $post->featured_image))
@endif

@section('content')

@php
    // 1. Parse nội dung bài viết (Giả sử nội dung đang lưu dưới dạng Markdown)
    // Nếu bạn lưu thẳng HTML trong database, hãy bỏ qua dòng Str::markdown() và gán $htmlContent = $post->content;
    $htmlContent = \Illuminate\Support\Str::markdown($post->content ?? '');

    // 2. Trích xuất các thẻ Heading (H1-H6) để tạo TOC tĩnh
    $toc = [];
    $htmlContent = preg_replace_callback(
        '/<h([1-6])(.*?)>(.*?)<\/h\1>/is',
        function ($matches) use (&$toc) {
            $level = $matches[1];
            $text = strip_tags($matches[3]);
            $id = \Illuminate\Support\Str::slug($text);
            
            // Đảm bảo ID không bị trùng lặp trong cùng 1 bài viết
            $originalId = $id;
            $counter = 1;
            while (in_array($id, array_column($toc, 'id'))) {
                $id = $originalId . '-' . $counter;
                $counter++;
            }

            $toc[] = [
                'level' => $level,
                'id' => $id,
                'text' => trim($text),
            ];

            // Trả về thẻ heading đã được bổ sung ID và khoảng cách cuộn (scroll-margin-top)
            return "<h{$level} id=\"{$id}\" style=\"scroll-margin-top: 6rem;\"{$matches[2]}>{$matches[3]}</h{$level}>";
        },
        $htmlContent
    );
@endphp

<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">

    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 sm:h-80 object-cover">
    @endif

    <div class="px-6 py-8 sm:p-10">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight mb-4">{{ $post->title }}</h1>

        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-500 dark:text-slate-400 mb-8 pb-8 border-b border-slate-100 dark:border-slate-700">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Đăng bởi: <strong class="ml-1">{{ $post->author->name ?? 'Khách' }}</strong>
            </span>
            <span class="hidden sm:inline text-slate-300 dark:text-slate-600">•</span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ $post->created_at->format('d/m/Y H:i') }}
            </span>
            
            @if($post->category)
            <span class="hidden sm:inline text-slate-300 dark:text-slate-600">•</span>
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                <a href="{{ route('categories.show', $post->category) }}" class="hover:text-brand font-medium transition">{{ $post->category->name }}</a>
            </span>
            @endif
        </div>

        {{-- Bắt đầu render Mục Lục Tĩnh --}}
        @if(!empty($toc))
        <div id="toc-container" class="mb-8 p-6 bg-slate-50 dark:bg-slate-800/40 rounded-xl border border-slate-100 dark:border-slate-700 transition-colors">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Nội dung chính</h3>
            </div>
            <ul class="space-y-2.5 text-slate-600 dark:text-slate-300">
                @foreach($toc as $item)
                    @php
                        // Thụt lề dựa trên cấp độ thẻ (H1 -> 0, H2 -> 1.2rem, H3 -> 2.4rem...)
                        $marginLeft = $item['level'] > 1 ? ($item['level'] - 1) * 1.2 . 'rem' : '0';
                    @endphp
                    <li style="margin-left: {{ $marginLeft }}">
                        <a href="#{{ $item['id'] }}" class="hover:text-brand font-medium transition-colors block">
                            {{ $item['text'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif
        {{-- Kết thúc render Mục Lục --}}

        {{-- Nội dung bài viết (Sử dụng prose để styling cho HTML thô) --}}
        <div class="mb-10 text-left prose prose-slate dark:prose-invert max-w-none">
            {!! $htmlContent !!}
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
            <div class="flex flex-wrap gap-2">
                @if($post->tags && $post->tags->count() > 0)
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tags.show', $tag) }}" class="px-3 py-1.5 text-xs font-medium bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-brand hover:text-white dark:hover:bg-brand transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                @endif
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400 mr-1">Chia sẻ:</span>
                
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 hover:bg-[#1877F2] hover:text-white transition-colors" title="Chia sẻ qua Facebook">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                </a>
                
                <a href="https://x.com/intent/post?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-colors" title="Chia sẻ qua X">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.96H5.078z"></path></svg>
                </a>
                
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700/50 text-slate-500 hover:bg-[#0A66C2] hover:text-white transition-colors" title="Chia sẻ qua LinkedIn">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-700">
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Bình luận ({{ $post->comments->count() }})</h3>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Tham gia thảo luận về bài viết này.</p>
            </div>

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10 space-y-4">
                    @csrf
                    <div>
                        <textarea name="content" rows="3" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none custom-scrollbar" placeholder="Viết bình luận của bạn..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                            Gửi bình luận
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700 text-center mb-10">
                    <p class="text-slate-600 dark:text-slate-300">Vui lòng <a href="{{ route('login') }}" class="text-brand font-semibold hover:underline">đăng nhập</a> để bình luận.</p>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-5 border border-slate-200 dark:border-slate-700 transition-colors">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-brand-light dark:bg-brand/20 flex items-center justify-center text-brand font-bold border border-brand/10">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white">{{ $comment->user->name }}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if(auth()->check() && auth()->user()->is_admin)
                                <div class="ml-auto">
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="delete-comment-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 dark:hover:text-red-400 text-sm font-medium transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $comment->content }}</p>
                    </div>
                @empty
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-8 border border-slate-200 dark:border-slate-700 text-center">
                        <p class="text-slate-500 dark:text-slate-400 italic">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
{{-- Đã xóa thư viện và JS khởi tạo ToastUI --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-comment-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); 
                
                const isDark = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Bạn sẽ không thể khôi phục bình luận này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#64748b',  
                    confirmButtonText: 'Vâng, xóa nó!',
                    cancelButtonText: 'Hủy',
                    background: isDark ? '#1e293b' : '#ffffff', 
                    color: isDark ? '#f8fafc' : '#0f172a',     
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        
        // Cải thiện cuộn mượt (Smooth scroll) cho các link của ToC
        document.querySelectorAll('#toc-container a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    history.pushState(null, null, targetId);
                }
            });
        });
    });
</script>
@endpush
@endsection