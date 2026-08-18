<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\UserGameRequest;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Hiển thị danh sách TẤT CẢ ván cờ (Chỉ user đã đăng nhập mới thấy)
     */
    public function index()
    {
        $games = Game::with('user')->latest()->paginate(15);
        return view('games.index', compact('games'));
    }

    /**
     * Quản lý ván cờ CỦA RIÊNG MÌNH
     */
    public function myGames()
    {
        // Chắc chắn auth()->id() luôn tồn tại vì đã có middleware
        $games = Game::where('user_id', auth()->id())->latest()->paginate(15);
        return view('games.my_games', compact('games'));
    }

    public function create()
    {
        $game = new Game([
            'initial_fen' => 'rnbakabnr/9/1c5c1/p1p1p1p1p/9/9/P1P1P1P1P/1C5C1/9/RNBAKABNR r - - 0 1'
        ]);
        return view('games.form', compact('game'));
    }

    public function store(UserGameRequest $request)
    {
        $data = $request->validated();
        if (!empty($data['moves'])) {
            $data['moves'] = json_decode($data['moves'], true);
        }

        $data['user_id'] = auth()->id();

        Game::create($data);

        return redirect()->route('games.my_games')
            ->with('success', 'Bạn đã chia sẻ ván cờ thành công!');
    }

    public function show(Game $game)
    {
        $game->increment('views');
        return view('games.show', compact('game'));
    }

    public function edit(Game $game)
    {
        // Vẫn cần chặn: Dù đã đăng nhập, nhưng chỉ được sửa bài CỦA MÌNH
        abort_if($game->user_id !== auth()->id(), 403, 'Bạn không có quyền sửa ván cờ này.');
        return view('games.form', compact('game'));
    }

    public function update(UserGameRequest $request, Game $game)
    {
        abort_if($game->user_id !== auth()->id(), 403, 'Bạn không có quyền sửa ván cờ này.');

        $data = $request->validated();
        if (!empty($data['moves'])) {
            $data['moves'] = json_decode($data['moves'], true);
        }

        $game->update($data);

        return redirect()->route('games.my_games')
            ->with('success', 'Cập nhật ván cờ thành công!');
    }

    public function destroy(Game $game)
    {
        abort_if($game->user_id !== auth()->id(), 403, 'Bạn không có quyền xóa ván cờ này.');

        $game->delete();

        return redirect()->route('games.my_games')
            ->with('success', 'Đã xóa ván cờ!');
    }

    /**
     * Thư viện ván cờ công khai (có tính năng tìm kiếm và sắp xếp)
     */
    public function library(Request $request)
    {
        // Bỏ 'latest()' ở đây để có thể tùy chỉnh sắp xếp bên dưới
        $query = Game::with('user');

        // Xử lý Tìm kiếm
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                // Tìm kiếm theo tiêu đề hoặc mô tả
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  // Tìm kiếm theo tên người dùng (kỳ thủ)
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Xử lý Sắp xếp
        $sort = $request->input('sort', 'latest');

        match ($sort) {
            'oldest'     => $query->oldest(),
            'views_desc' => $query->orderBy('views', 'desc'),
            'views_asc'  => $query->orderBy('views', 'asc'),
            'alpha_asc'  => $query->orderBy('title', 'asc'),
            'alpha_desc' => $query->orderBy('title', 'desc'),
            default      => $query->latest(), // 'latest' là mặc định
        };

        // withQueryString() giúp giữ lại các tham số 'search' và 'sort' khi chuyển trang
        $games = $query->paginate(12)->withQueryString();

        return view('games.library', compact('games'));
    }
}
