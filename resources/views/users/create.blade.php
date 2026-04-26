@extends('layouts.app')

@section('title', 'Thêm người dùng mới')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tạo người dùng mới
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Thêm tài khoản mới vào hệ thống của bạn.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 p-5 rounded-xl mb-8 flex gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Họ và tên</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập tên người dùng..."
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Địa chỉ Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="example@domain.com"
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Mật khẩu</label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('users.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Tạo tài khoản
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
