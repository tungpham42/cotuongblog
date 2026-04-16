@extends('layouts.app')

@section('title', 'Cập nhật người dùng')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Chỉnh sửa thông tin</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Cập nhật tài khoản của <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $user->name }}</span>.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 p-5 rounded-xl mb-8 flex gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Họ và tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Địa chỉ Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
            </div>

            <div class="p-5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">Đổi mật khẩu</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Chỉ điền nếu bạn muốn thay đổi mật khẩu hiện tại của người dùng này. Bỏ trống để giữ nguyên mật khẩu cũ.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Mật khẩu mới</label>
                        <input type="password" name="password" placeholder="Để trống nếu không đổi"
                               class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" placeholder="Xác nhận lại mật khẩu"
                               class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('users.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Cập nhật thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
