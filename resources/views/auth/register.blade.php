@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="max-w-md mx-auto mt-10">
    <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Đăng ký tài khoản</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Tạo tài khoản mới để bắt đầu</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Họ và tên</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-brand focus:border-brand transition">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-brand focus:border-brand transition">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Mật khẩu</label>
                <input type="password" name="password" id="password" required
                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-brand focus:border-brand transition">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-brand focus:border-brand transition">
            </div>

            <button type="submit" class="w-full bg-brand hover:bg-brand-hover text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Đăng ký
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-brand hover:underline font-medium">Đăng nhập</a>
        </p>
    </div>
</div>
@endsection
