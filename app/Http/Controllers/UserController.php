<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['posts', 'comments'])->latest()->paginate(12);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Hash mật khẩu trước khi lưu
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Tạo người dùng thành công!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Password là tùy chọn khi update
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Nếu user có nhập password mới thì hash và cập nhật, nếu không thì bỏ qua
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    public function destroy(User $user)
    {
        // Ngăn không cho user tự xóa chính mình (nếu đang đăng nhập)
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa!');
    }
}
