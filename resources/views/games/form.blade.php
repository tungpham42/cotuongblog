@extends('layouts.app')

@section('title', $game->exists ? 'Cập nhật ván cờ' : 'Thêm ván cờ mới')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ $game->exists ? 'Cập nhật ván cờ' : 'Thêm ván cờ mới' }}</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Chia sẻ thế cờ hoặc một trận đấu hay của bạn</p>
    </div>

    <form id="gameForm" action="{{ $game->exists ? route('games.update', $game->slug) : route('games.store') }}" method="POST" class="bg-white dark:bg-slate-800/80 backdrop-blur-xl p-6 sm:p-8 rounded-3xl shadow-sm border border-brand/10 dark:border-slate-700/50">
        @csrf
        @if($game->exists)
            @method('PUT')
        @endif

        <div class="space-y-6">
            {{-- Tiêu đề --}}
            <div>
                <label for="title" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tiêu đề ván cờ <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $game->title) }}" required
                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('title') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand/50 transition-colors"
                    placeholder="VD: Cờ tàn thực chiến: Đơn Xe phá Sĩ Tượng toàn">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mô tả --}}
            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Mô tả chi tiết</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('description') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand/50 transition-colors"
                    placeholder="Vài dòng giới thiệu về bối cảnh hoặc điểm mấu chốt của ván cờ...">{{ old('description', $game->description) }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Mã FEN --}}
            <div>
                <label for="initial_fen" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Mã FEN ban đầu <span class="text-red-500">*</span></label>
                <input type="text" name="initial_fen" id="initial_fen" value="{{ old('initial_fen', $game->initial_fen) }}" required
                    class="w-full font-mono text-sm px-4 py-3 rounded-xl border {{ $errors->has('initial_fen') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand/50 transition-colors">
                @error('initial_fen') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nước đi (Moves) - Cho phép paste chuỗi văn bản --}}
            <div>
                <label for="raw_moves" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Biên bản nước đi <span class="text-red-500">*</span></label>

                {{-- Textarea để nhập text thuần (C2=5). Dữ liệu cũ sẽ được JS tự điền --}}
                <textarea id="raw_moves" rows="5" name="raw_moves"
                    class="w-full font-mono text-sm px-4 py-3 rounded-xl border {{ $errors->has('moves') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand/50 transition-colors"
                    placeholder="VD: C2=5 n8+7 N2+3 r9=8...">{{ is_string(old('raw_moves')) ? old('raw_moves') : '' }}</textarea>

                <p class="text-xs text-slate-500 mt-1">Dán kỳ phổ dạng chuỗi (C2=5 n8+7...). Hệ thống sẽ tự động format JSON khi lưu và dịch sang Tiếng Việt khi hiển thị.</p>

                {{-- Input ẨN lưu JSON mảng [{from, to}] gửi xuống backend --}}
                <input type="hidden" name="moves" id="hidden_moves" value="">

                @error('moves') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-4 border-t border-slate-100 dark:border-slate-700/50 pt-6">
            <a href="{{ route('games.my_games') }}" class="px-5 py-2.5 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl font-bold transition-colors">Hủy</a>
            <button type="submit" class="px-8 py-2.5 bg-brand hover:bg-brand-hover text-white font-bold rounded-xl shadow-lg shadow-brand/30 transition-all">
                {{ $game->exists ? 'Lưu thay đổi' : 'Tạo ván cờ' }}
            </button>
        </div>
    </form>
</div>

<!-- Bổ sung thư viện xiangqi.js vào form để bắt tọa độ -->
<script src="{{ asset('js/xiangqi.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dbMoves = @json($game->moves) || [];
        const initialFenInput = document.getElementById('initial_fen');
        const rawMovesTextarea = document.getElementById('raw_moves');

        // ========================================================
        // HÀM 1: Dịch Tọa độ ({from, to}) sang WXF (VD: C2=5)
        // ========================================================
        function convertMoveToWXF(move, color) {
            let piece = move.piece.toUpperCase();
            if (piece === 'E' || piece === 'V') piece = 'B';
            if (piece === 'H') piece = 'N';

            // SỬA LỖI: Nhận diện chính xác phe Đỏ (w hoặc r)
            const isRed = (color === 'w' || color === 'r');

            const fCode = move.from.charCodeAt(0);
            const fRank = parseInt(move.from.charAt(1));
            const fFile = isRed ? (10 - (fCode - 96)) : (fCode - 96);

            const tCode = move.to.charCodeAt(0);
            const tRank = parseInt(move.to.charAt(1));
            const tFile = isRed ? (10 - (tCode - 96)) : (tCode - 96);

            let action = '=';
            if (fRank !== tRank) {
                if (isRed) action = tRank > fRank ? '+' : '-';
                else action = tRank < fRank ? '+' : '-';
            }

            let target = tFile;
            if (action !== '=') {
                const isStep = ['R', 'C', 'P', 'K'].includes(piece);
                if (isStep) target = Math.abs(tRank - fRank);
            }

            return piece + fFile + action + target;
        }

        // ========================================================
        // HÀM 2: Dịch WXF (C2=5) sang Tọa độ ({from, to})
        // ========================================================
        function parseWXFToMove(userStr, game) {
            const str = userStr.trim().toLowerCase();
            const regex = /^([+-]?)([a-z])(\d)([=+\-.])(\d)$/;
            const match = str.match(regex);

            if (!match) return null;

            let uPiece = match[2];
            const fFile = parseInt(match[3]);
            let action = match[4];
            if (action === '.') action = '=';
            const target = parseInt(match[5]);

            if (uPiece === 'e' || uPiece === 'v' || uPiece === 't') uPiece = 'b';
            if (uPiece === 'h') uPiece = 'n';

            const color = game.turn();
            // SỬA LỖI: Nhận diện chính xác phe Đỏ
            const isRed = (color === 'w' || color === 'r');

            const legalMoves = game.moves({ verbose: true });

            for (let move of legalMoves) {
                let mPiece = move.piece.toLowerCase();
                if (mPiece === 'e' || mPiece === 'v') mPiece = 'b';
                if (mPiece === 'h') mPiece = 'n';
                if (mPiece !== uPiece) continue;

                const mc = move.from.charCodeAt(0);
                const mr = parseInt(move.from.charAt(1));
                const mFromFile = isRed ? (10 - (mc - 96)) : (mc - 96);
                if (mFromFile !== fFile) continue;

                const tc = move.to.charCodeAt(0);
                const tr = parseInt(move.to.charAt(1));
                const mToFile = isRed ? (10 - (tc - 96)) : (tc - 96);

                let mAction = '=';
                if (mr !== tr) {
                    if (isRed) mAction = tr > mr ? '+' : '-';
                    else mAction = tr < mr ? '+' : '-';
                }
                if (mAction !== action) continue;

                let mTarget = mToFile;
                if (mAction !== '=') {
                    const isStep = ['r', 'c', 'p', 'k'].includes(mPiece);
                    if (isStep) mTarget = Math.abs(tr - mr);
                }
                if (mTarget !== target) continue;

                return move;
            }
            return null;
        }

        // 1. KHI LOAD FORM
        if (dbMoves.length > 0 && typeof dbMoves[0] === 'object') {
            try {
                const initialFen = initialFenInput.value || 'start';
                const tempGame = new Xiangqi(initialFen === 'start' ? undefined : initialFen);
                let wxfArray = [];

                dbMoves.forEach(move => {
                    const color = tempGame.turn();
                    const res = tempGame.move({ from: move.from, to: move.to });
                    if (res) wxfArray.push(convertMoveToWXF(res, color));
                });
                rawMovesTextarea.value = wxfArray.join(' ');
            } catch (e) {
                console.error("Lỗi khôi phục biên bản:", e);
            }
        }

        // 2. KHI SUBMIT
        document.getElementById('gameForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const rawInput = rawMovesTextarea.value.trim();
            const initialFen = initialFenInput.value || 'start';
            let movesArray = [];

            if (rawInput) {
                const rawMoves = rawInput.split(/[\s,\n]+/).filter(m => m.length > 0);
                try {
                    const game = new Xiangqi(initialFen === 'start' ? undefined : initialFen);

                    for (let i = 0; i < rawMoves.length; i++) {
                        const moveObj = parseWXFToMove(rawMoves[i], game);

                        if (moveObj) {
                            movesArray.push({ from: moveObj.from, to: moveObj.to });
                            game.move({ from: moveObj.from, to: moveObj.to });
                        } else {
                            alert(`Nước đi không hợp lệ tại: ${rawMoves[i]} (Bước số ${i + 1}) \nVui lòng kiểm tra lại tính hợp lệ của kỳ phổ.`);
                            return false;
                        }
                    }
                } catch (err) {
                    alert('Lỗi FEN hoặc định dạng. Vui lòng kiểm tra lại!');
                    return false;
                }
            }

            document.getElementById('hidden_moves').value = JSON.stringify(movesArray);
            this.submit();
        });
    });
</script>
@endsection
