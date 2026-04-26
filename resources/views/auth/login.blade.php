@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-brand/10 text-brand mb-4 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
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

            <button type="submit" class="w-full bg-brand hover:bg-brand-hover text-white font-semibold py-2.5 rounded-lg transition duration-200 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Đăng nhập
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
            Chưa có tài khoản? <a href="{{ route('register') }}" class="text-brand hover:underline font-medium">Đăng ký ngay</a>
        </p>
    </div>
</div>
@endsection
