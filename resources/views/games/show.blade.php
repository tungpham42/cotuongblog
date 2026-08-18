@extends('layouts.app')

@section('title', $game->title)
@section('meta_description', Str::limit($game->description, 150))

@section('content')
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-slate-800/80 backdrop-blur-xl p-4 sm:p-6 rounded-3xl shadow-sm border border-brand/10 dark:border-slate-700/50">
            <div class="flex justify-center w-full max-w-[500px] mx-auto bg-[#e5c49b] border-2 sm:border-4 border-[#8b4513] rounded-sm p-1 sm:p-2 shadow-inner box-border">
                <div id="xiangqi-board" style="width: 100%"></div>
            </div>

            <div class="flex items-center justify-center gap-2 sm:gap-4 mt-6 flex-wrap">
                <button id="btn-start" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:bg-orange-50 transition-colors" data-tippy-content="Về đầu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                </button>
                <button id="btn-prev" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:bg-orange-50 transition-colors" data-tippy-content="Lùi 1 bước">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <button id="btn-autoplay" class="p-3 rounded-full bg-brand text-white shadow-lg shadow-brand/30 hover:bg-brand-hover hover:scale-105 transition-all" data-tippy-content="Phát tự động">
                    <svg id="icon-play" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                    <svg id="icon-pause" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"></path></svg>
                </button>

                <button id="btn-next" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:bg-orange-50 transition-colors" data-tippy-content="Tới 1 bước">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
                <button id="btn-end" class="p-2 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-brand hover:bg-orange-50 transition-colors" data-tippy-content="Tới cuối">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </button>

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
                    class="relative ml-1 sm:ml-2 z-20">

                    <button @click="open = !open"
                            type="button"
                            class="flex items-center justify-between gap-2 min-w-[80px] bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-sm rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand/50 cursor-pointer border border-transparent dark:border-slate-700/50 hover:border-brand/30 dark:hover:border-brand/50 transition-all">
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

            <div class="mt-4 text-center font-mono font-bold text-slate-500 dark:text-slate-400 text-sm">
                Bước: <span id="current-step" class="text-brand text-lg">0</span> / <span id="total-steps">0</span>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-slate-800/80 backdrop-blur-xl p-6 rounded-3xl shadow-sm border border-brand/10 dark:border-slate-700/50">
            <h1 class="text-2xl font-black text-slate-800 dark:text-white mb-4">{{ $game->title }}</h1>
            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-100 dark:border-slate-700/50">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand to-orange-400 flex items-center justify-center text-white font-bold shadow-sm">
                    {{ substr($game->user->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $game->user->name }}</p>
                    <p class="text-xs text-slate-500">{{ $game->created_at->format('d/m/Y') }} • Lượt xem: {{ number_format($game->views) }}</p>
                </div>
            </div>

            @if($game->description)
                <div class="prose prose-sm dark:prose-invert prose-orange max-w-none text-slate-600 dark:text-slate-300 mb-6">
                    <p>{{ $game->description }}</p>
                </div>
            @endif

            @auth
                @if(auth()->id() === $game->user_id)
                <div class="pt-4 mt-2">
                    <a href="{{ route('games.edit', $game->slug) }}" class="block w-full text-center px-4 py-2 bg-brand/10 text-brand hover:bg-brand hover:text-white font-bold rounded-xl transition-all">
                        Chỉnh sửa ván cờ
                    </a>
                </div>
                @endif
            @endauth

            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700/50">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Chia sẻ ván cờ</p>
                <div class="flex items-center gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="p-2.5 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-blue-600 transition-colors" data-tippy-content="Chia sẻ Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"></path></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($game->title) }}" target="_blank" class="p-2.5 rounded-full bg-slate-100 text-slate-800 hover:bg-black hover:text-white dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-black transition-colors" data-tippy-content="Chia sẻ X (Twitter)">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Đã sao chép liên kết!', showConfirmButton: false, timer: 2000});" class="p-2.5 rounded-full bg-slate-100 text-slate-600 hover:bg-brand hover:text-white dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-brand transition-colors" data-tippy-content="Sao chép liên kết">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800/80 backdrop-blur-xl p-6 rounded-3xl shadow-sm border border-brand/10 dark:border-slate-700/50 flex flex-col h-[400px]">
            <h3 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Biên bản ván cờ
            </h3>

            <div id="moves-list" class="flex-1 overflow-y-auto pr-2 custom-scrollbar grid grid-cols-[auto_1fr_1fr] gap-x-2 gap-y-1 text-sm font-mono text-slate-700 dark:text-slate-300 content-start">
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
                'n': 'Mã', 'h': 'Mã', 'r': 'Xe', 'c': 'Pháo', 'p': 'Binh'
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
                const moveBtn = $(`<button class="text-left px-3 py-1.5 rounded hover:bg-brand/10 hover:text-brand transition-colors move-btn" data-step="${i}">${vnMove}</button>`);
                listContainer.append(moveBtn);
            }
        }

        function goToStep(step) {
            if (step < 0) step = 0;
            if (step > totalSteps) step = totalSteps;

            currentStep = step;
            $('#current-step').text(currentStep);

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
</style>
@endpush
