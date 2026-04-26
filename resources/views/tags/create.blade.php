@extends('layouts.app')

@section('title', 'Thêm thẻ mới')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Thêm thẻ mới
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Gắn thẻ giúp phân loại nội dung chi tiết và cải thiện SEO bài viết.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 p-5 rounded-xl mb-8 flex gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tags.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tên thẻ</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Khai cuộc, Trung cuộc..."
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Mô tả thẻ (Không bắt buộc)</label>
                <textarea name="description" rows="3" placeholder="Nhập mô tả ngắn gọn về thẻ này..."
                          class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Ảnh đại diện thẻ (Không bắt buộc)</label>
                <input type="file" name="featured_image" accept="image/*"
                       class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 transition-all cursor-pointer">
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('tags.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Lưu thẻ mới
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
