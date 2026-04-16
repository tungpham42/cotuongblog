<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin không
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Nếu không phải admin, đẩy về trang chủ kèm thông báo lỗi
        return redirect('/')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
    }
}
