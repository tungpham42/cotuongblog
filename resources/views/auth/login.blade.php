@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Đăng nhập</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Chào mừng bạn quay trở lại</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Mật khẩu</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-brand focus:ring-brand dark:bg-slate-900 dark:border-slate-600">
                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Ghi nhớ đăng nhập</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-brand hover:bg-brand-hover text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Đăng nhập
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
            Chưa có tài khoản? <a href="{{ route('register') }}" class="text-brand hover:underline font-medium">Đăng ký ngay</a>
        </p>
    </div>
</div>
@endsection
