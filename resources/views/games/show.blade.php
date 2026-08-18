@extends('layouts.app')

@section('title', $game->title)
@section('og_image', 'https://placehold.co/1200x630/BB5F1A/FFFFFF?text=' . urlencode($game->title))
@section('meta_description', Str::limit($game->description, 150))

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Kicker badge --}}
    <div class="flex justify-center mb-6 animate-fade-in-up">
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-brand/10 dark:bg-brand/15 text-brand text-[11px] font-black uppercase tracking-widest border border-brand/20 shadow-sm">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.538 1.118l-3.367-2.447a1 1 0 00-1.176 0l-3.367 2.447c-.783.57-1.838-.196-1.538-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.062 9.385c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.951-.69l1.286-3.958z"></path></svg>
            Kỳ phổ ván đấu
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">
            <div class="relative overflow-hidden bg-white dark:bg-slate-800/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl shadow-xl shadow-brand/5 dark:shadow-black/20 border border-brand/10 dark:border-slate-700/50 animate-fade-in-up">

                {{-- Ambient glow accents --}}
                <div class="absolute -top-20 -right-20 w-56 h-56 bg-brand/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-56 h-56 bg-amber-400/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative flex justify-center w-full max-w-[500px] mx-auto bg-gradient-to-br from-[#f0d3a8] to-[#d9a565] border-2 sm:border-4 border-[#8b4513] rounded-lg p-1 sm:p-2 shadow-[inset_0_2px_10px_rgba(0,0,0,0.25),0_15px_35px_-10px_rgba(184,93,25,0.35)] box-border">
                    <div id="xiangqi-board" style="width: 100%"></div>
                </div>

                {{-- Progress bar --}}
                <div class="relative mt-5 max-w-[500px] mx-auto">
                    <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-700/60 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-brand via-orange-500 to-amber-400 rounded-full transition-all duration-300 ease-out" style="width:0%"></div>
                    </div>
                </div>

                {{-- Controls toolbar --}}
                <div class="relative flex items-center justify-center gap-2 sm:gap-3 mt-5 flex-wrap">
                    <div class="flex items-center gap-1 sm:gap-2 bg-slate-50/80 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-1.5 sm:p-2 shadow-inner">
                        <button id="btn-start" class="p-2 rounded-full bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-tippy-content="Về đầu">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                        </button>
                        <button id="btn-prev" class="p-2 rounded-full bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-tippy-content="Lùi 1 bước">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>

                        <button id="btn-autoplay" class="relative p-3 sm:p-3.5 rounded-full bg-brand text-white shadow-lg shadow-brand/30 hover:bg-brand-hover hover:scale-110 active:scale-95 transition-all duration-200 mx-1" data-tippy-content="Phát tự động">
                            <span class="absolute inset-0 rounded-full bg-brand/40 animate-ping-slow"></span>
                            <svg id="icon-play" class="relative w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                            <svg id="icon-pause" class="relative w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                        </button>

                        <button id="btn-next" class="p-2 rounded-full bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-tippy-content="Tới 1 bước">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                        <button id="btn-end" class="p-2 rounded-full bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:shadow-md hover:-translate-y-0.5 transition-all duration-200" data-tippy-content="Tới cuối">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        </button>
                    </div>

                    <div x-data="{
                            open: false,
                            speed: '1000',
                            options: [
                                { value: '4000', label: '0.25x' },
                                { value: '2000', label: '0.5x' },
                                { value: '1000', label: '1.0x' },
                                { value: '666', label: '1.5x' },
                                { value: '500', label: '2.0x' }
                            ],
                            get currentLabel() {
                                return this.options.find(opt => opt.value === this.speed).label;
                            },
                            updateSpeed(newSpeed) {
                                this.speed = newSpeed;
                                this.open = false;
                                // Cập nhật giá trị vào select ẩn và trigger event cho jQuery
                                $nextTick(() => {
                                    let selectEl = document.getElementById('autoplay-speed');
                                    selectEl.value = newSpeed;
                                    selectEl.dispatchEvent(new Event('change'));
                                });
                            }
                        }"
                        @click.away="open = false"
                        class="relative z-20">

                        <button @click="open = !open"
                                type="button"
                                class="flex items-center justify-between gap-2 min-w-[84px] bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-sm rounded-2xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand/50 cursor-pointer border border-slate-100 dark:border-slate-700/50 hover:border-brand/40 hover:shadow-md transition-all">
                            <span x-text="currentLabel">1.0x</span>
                            <svg :class="{'rotate-180': open}" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                            class="absolute right-0 bottom-full mb-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] dark:shadow-slate-900/80 border border-slate-100 dark:border-slate-700 overflow-hidden"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="option in options" :key="option.value">
                                    <button @click="updateSpeed(option.value)"
                                            type="button"
                                            :class="{'bg-brand/10 text-brand': speed === option.value, 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700': speed !== option.value}"
                                            class="w-full text-left px-4 py-2 text-sm font-bold transition-colors flex items-center justify-between">
                                        <span x-text="option.label"></span>
                                        <svg x-show="speed === option.value" class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <select id="autoplay-speed" class="hidden">
                            <option value="4000">0.25x</option>
                            <option value="2000">0.5x</option>
                            <option value="1000" selected>1.0x</option>
                            <option value="666">1.5x</option>
                            <option value="500">2.0x</option>
                        </select>
                    </div>
                </div>

                <div class="relative mt-4 text-center font-mono font-bold text-slate-500 dark:text-slate-400 text-sm">
                    Bước: <span id="current-step" class="text-brand text-lg">0</span> / <span id="total-steps">0</span>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="relative overflow-hidden bg-white dark:bg-slate-800/80 backdrop-blur-xl p-6 rounded-3xl shadow-xl shadow-brand/5 dark:shadow-black/20 border border-brand/10 dark:border-slate-700/50 animate-fade-in-up delay-1">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-brand/10 to-amber-400/10 rounded-full blur-2xl pointer-events-none"></div>

                <h1 class="relative text-2xl font-black text-slate-800 dark:text-white mb-1 leading-tight">{{ $game->title }}</h1>
                <div class="w-12 h-1 rounded-full bg-gradient-to-r from-brand to-amber-400 mb-4"></div>

                {{-- Stat chips --}}
                <div class="relative flex flex-wrap gap-2 mb-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand/5 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-xs font-bold">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ number_format($game->views) }} lượt xem
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand/5 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-xs font-bold">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $game->created_at->format('d/m/Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-brand/5 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 text-xs font-bold">
                        <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span id="stat-total-moves">0</span> nước đi
                    </span>
                </div>

                <div class="relative flex items-center gap-3 mb-6 pb-6 border-b border-slate-100 dark:border-slate-700/50">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-orange-400 flex items-center justify-center text-white font-bold shadow-sm ring-2 ring-brand/20">
                        {{ substr($game->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $game->user->name }}</p>
                        <p class="text-xs text-slate-500">Tác giả ván cờ</p>
                    </div>
                </div>

                @if($game->description)
                    <div class="relative prose prose-sm dark:prose-invert prose-orange max-w-none text-slate-600 dark:text-slate-300 mb-6">
                        <p>{{ $game->description }}</p>
                    </div>
                @endif

                @auth
                    @if(auth()->id() === $game->user_id)
                    <div class="relative pt-4 mt-2">
                        <a href="{{ route('games.edit', $game->slug) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-brand/10 text-brand hover:bg-brand hover:text-white hover:shadow-lg hover:shadow-brand/30 font-bold rounded-xl transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Chỉnh sửa ván cờ
                        </a>
                    </div>
                    @endif
                @endauth

                <div class="relative mt-6 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Chia sẻ ván cờ</p>
                    <div class="flex items-center gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="p-2.5 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white hover:scale-110 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-blue-600 transition-all duration-200" data-tippy-content="Chia sẻ Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($game->title) }}" target="_blank" class="p-2.5 rounded-full bg-slate-100 text-slate-800 hover:bg-black hover:text-white hover:scale-110 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-black transition-all duration-200" data-tippy-content="Chia sẻ X (Twitter)">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
                        </a>

                        {{-- Nút chia sẻ Threads --}}
                        <a href="https://www.threads.net/intent/post?text={{ urlencode($game->title . ' ' . url()->current()) }}" target="_blank" class="p-2.5 rounded-full bg-slate-100 text-slate-800 hover:bg-black hover:text-white hover:scale-110 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-black transition-all duration-200" data-tippy-content="Chia sẻ Threads">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 192 192"><path d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.708C154.894 45.6981 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 28.1872C147.036 10.146 124.965 0.217327 97.0132 0C64.714 0.238473 43.606 9.88283 29.597 27.6974C15.8608 45.1633 8.85075 68.618 8.60522 96C8.85075 123.382 15.8608 146.837 29.597 164.303C43.606 182.117 64.714 191.761 97.0135 192C124.935 191.782 146.873 181.865 161.68 163.791C178.077 143.774 175.433 121.229 166.726 100.916C161.854 89.545 153.308 80.5342 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6189 115.343C76.2234 107.925 82.3506 102.321 96.195 101.405C104.28 100.869 111.411 101.353 118.232 102.731C117.067 112.585 111.954 120.301 105.148 124.9C103.111 126.276 100.887 127.284 98.4405 129.507Z"/></svg>
                        </a>

                        <button onclick="navigator.clipboard.writeText(window.location.href); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Đã sao chép liên kết!', showConfirmButton: false, timer: 2000});" class="p-2.5 rounded-full bg-slate-100 text-slate-600 hover:bg-brand hover:text-white hover:scale-110 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-brand transition-all duration-200" data-tippy-content="Sao chép liên kết">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800/80 backdrop-blur-xl p-6 rounded-3xl shadow-xl shadow-brand/5 dark:shadow-black/20 border border-brand/10 dark:border-slate-700/50 flex flex-col h-[400px] animate-fade-in-up delay-2">
                <h3 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Biên bản ván cờ
                </h3>

                <div id="moves-list" class="flex-1 overflow-y-auto pr-2 custom-scrollbar grid grid-cols-[auto_1fr_1fr] gap-x-2 gap-y-1 text-sm font-mono text-slate-700 dark:text-slate-300 content-start">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/xiangqiboard-0.3.3.css') }}" />
<script src="{{ asset('js/xiangqiboard-0.3.3.js') }}"></script>
<script src="{{ asset('js/xiangqi.js') }}"></script>

<script>
    $(document).ready(function() {
        const dbInitialFen = @json($game->initial_fen);
        const movesData = @json($game->moves) || [];

        let startFen = dbInitialFen;
        if (!startFen || startFen === 'start') {
            startFen = 'rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR w - - 0 1';
        }

        const fenHistory = [startFen];
        const vnNotationHistory = [];
        let gameLogic = null;

        try {
            gameLogic = new Xiangqi(startFen);
        } catch (e) {
            gameLogic = new Xiangqi();
            fenHistory[0] = gameLogic.fen();
        }

        function toVietnameseNotation(move, color) {
            if (!move) return '...';

            const pieceMap = {
                'k': 'Tướng', 'a': 'Sĩ', 'b': 'Tượng', 'e': 'Tượng', 'v': 'Tượng',
                'n': 'Mã', 'h': 'Mã', 'r': 'Xe', 'c': 'Pháo', 'p': 'Chốt'
            };
            let pieceName = pieceMap[move.piece.toLowerCase()] || move.piece.toUpperCase();

            const isRed = (color === 'w' || color === 'r');

            const fCode = move.from.charCodeAt(0);
            const fRank = parseInt(move.from.charAt(1));
            const fFile = isRed ? (10 - (fCode - 96)) : (fCode - 96);

            const tCode = move.to.charCodeAt(0);
            const tRank = parseInt(move.to.charAt(1));
            const tFile = isRed ? (10 - (tCode - 96)) : (tCode - 96);

            let action = ' bình ';
            if (fRank !== tRank) {
                if (isRed) action = tRank > fRank ? ' tấn ' : ' thoái ';
                else action = tRank < fRank ? ' tấn ' : ' thoái ';
            }

            let target = tFile;
            if (action.includes('bình')) {
                target = tFile;
            } else {
                const isStep = ['r', 'c', 'p', 'k'].includes(move.piece.toLowerCase());
                if (isStep) target = Math.abs(tRank - fRank);
            }

            return `${pieceName} ${fFile}${action}${target}`;
        }

        if (Array.isArray(movesData)) {
            movesData.forEach(move => {
                if (!move) return;
                try {
                    const color = gameLogic.turn();
                    const result = gameLogic.move({ from: move.from, to: move.to });

                    if (result) {
                        fenHistory.push(gameLogic.fen());
                        vnNotationHistory.push(toVietnameseNotation(result, color));
                    } else {
                        fenHistory.push(gameLogic.fen());
                        vnNotationHistory.push('Lỗi nước đi');
                    }
                } catch (e) {
                    fenHistory.push(gameLogic.fen());
                    vnNotationHistory.push('Lỗi dữ liệu');
                }
            });
        }

        let board = null;
        let currentStep = 0;
        const totalSteps = fenHistory.length - 1;

        function getBoardFen(fen) {
            if (!fen || fen === 'start') return 'start';
            return fen.split(' ')[0];
        }

        board = Xiangqiboard('xiangqi-board', {
            position: getBoardFen(fenHistory[0]),
            showNotation: false,
            draggable: false,
            pieceTheme: '{{ asset('img/xiangqipieces/wikipedia/{piece}.svg') }}'
        });

        $(window).on('resize', function() {
            if (board) {
                board.resize();
            }
        });

        function renderMovesList() {
            const listContainer = $('#moves-list');
            listContainer.empty();

            $('#stat-total-moves').text(totalSteps);

            if (totalSteps === 0) {
                listContainer.html('<div class="col-span-2 text-center text-slate-400 italic mt-4">Chưa có nước đi hợp lệ nào.</div>');
                $('#total-steps').text(0);
                return;
            }

            $('#total-steps').text(totalSteps);

            for (let i = 1; i <= totalSteps; i++) {
                const isRed = (i % 2 !== 0);
                const stepNumber = Math.ceil(i / 2);

                if (isRed) {
                    listContainer.append(`<div class="text-left text-slate-400/70 select-none py-1.5 w-6">${stepNumber}.</div>`);
                }

                const vnMove = vnNotationHistory[i - 1];
                const dotColor = isRed ? 'bg-rose-500' : 'bg-slate-700 dark:bg-slate-300';
                const moveBtn = $(`<button class="flex items-center gap-1.5 text-left px-3 py-1.5 rounded-lg hover:bg-brand/10 hover:text-brand transition-colors move-btn" data-step="${i}"><span class="inline-block w-1.5 h-1.5 rounded-full ${dotColor} shrink-0"></span>${vnMove}</button>`);
                listContainer.append(moveBtn);
            }
        }

        function updateProgressBar() {
            const pct = totalSteps > 0 ? (currentStep / totalSteps) * 100 : 0;
            $('#progress-bar').css('width', pct + '%');
        }

        function goToStep(step) {
            if (step < 0) step = 0;
            if (step > totalSteps) step = totalSteps;

            currentStep = step;
            $('#current-step').text(currentStep);
            updateProgressBar();

            $('.move-btn').removeClass('bg-brand/20 text-brand font-bold');
            if (currentStep > 0) {
                const activeBtn = $(`.move-btn[data-step="${currentStep}"]`);
                activeBtn.addClass('bg-brand/20 text-brand font-bold');
            }
            board.position(getBoardFen(fenHistory[currentStep]));
        }

        // ==========================================
        // TÍNH NĂNG AUTOPLAY (PHÁT TỰ ĐỘNG)
        // ==========================================
        let playInterval = null;
        let isPlaying = false;

        function startAutoplay() {
            if (totalSteps === 0) return;

            // Nếu đã ở cuối, tự động quay về đầu để phát lại
            if (currentStep >= totalSteps) {
                goToStep(0);
            }

            isPlaying = true;
            $('#icon-play').addClass('hidden');
            $('#icon-pause').removeClass('hidden');

            // Đổi giao diện nút thành màu Đỏ (Pause)
            const btnPlay = $('#btn-autoplay');
            btnPlay.removeClass('bg-brand hover:bg-brand-hover shadow-brand/30')
                   .addClass('bg-rose-500 hover:bg-rose-600 shadow-rose-500/30');

            if (btnPlay[0]._tippy) btnPlay[0]._tippy.setContent('Tạm dừng');

            const speed = parseInt($('#autoplay-speed').val());

            playInterval = setInterval(() => {
                if (currentStep < totalSteps) {
                    goToStep(currentStep + 1);
                } else {
                    stopAutoplay();
                }
            }, speed);
        }

        function stopAutoplay() {
            if (!isPlaying) return;

            isPlaying = false;
            clearInterval(playInterval);
            $('#icon-pause').addClass('hidden');
            $('#icon-play').removeClass('hidden');

            // Trả nút về màu Cam (Play) ban đầu
            const btnPlay = $('#btn-autoplay');
            btnPlay.removeClass('bg-rose-500 hover:bg-rose-600 shadow-rose-500/30')
                   .addClass('bg-brand hover:bg-brand-hover shadow-brand/30');

            if (btnPlay[0]._tippy) btnPlay[0]._tippy.setContent('Phát tự động');
        }

        $('#btn-autoplay').click(function() {
            if (isPlaying) stopAutoplay();
            else startAutoplay();
        });

        // Thay đổi tốc độ (Real-time)
        $('#autoplay-speed').change(function() {
            if (isPlaying) {
                stopAutoplay();
                startAutoplay();
            }
        });

        // ==========================================
        // GÁN SỰ KIỆN ĐIỀU HƯỚNG BẰNG TAY
        // (Tự động tắt Autoplay nếu người dùng can thiệp)
        // ==========================================
        $('#btn-start').click(() => { stopAutoplay(); goToStep(0); });
        $('#btn-prev').click(() => { stopAutoplay(); goToStep(currentStep - 1); });
        $('#btn-next').click(() => { stopAutoplay(); goToStep(currentStep + 1); });
        $('#btn-end').click(() => { stopAutoplay(); goToStep(totalSteps); });

        $('#moves-list').on('click', '.move-btn', function() {
            stopAutoplay();
            goToStep(parseInt($(this).data('step')));
        });

        $(document).keydown(function(e) {
            if (e.keyCode == 37) { stopAutoplay(); goToStep(currentStep - 1); }
            if (e.keyCode == 39) { stopAutoplay(); goToStep(currentStep + 1); }
            // Phím Space để Play/Pause
            if (e.keyCode == 32 && e.target === document.body) {
                e.preventDefault();
                if (isPlaying) stopAutoplay();
                else startAutoplay();
            }
        });

        // Khởi động UI
        renderMovesList();
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out both; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }

    @keyframes pingSlow {
        0% { transform: scale(1); opacity: 0.6; }
        70%, 100% { transform: scale(1.6); opacity: 0; }
    }
    .animate-ping-slow { animation: pingSlow 2s cubic-bezier(0, 0, 0.2, 1) infinite; }
</style>
@endpush
