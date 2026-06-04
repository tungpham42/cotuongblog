@extends('layouts.app')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="p-6 sm:p-10">
        <h2 class="text-3xl font-bold mb-8 text-slate-900 dark:text-white flex items-center gap-3">
            <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Thêm sản phẩm mới
        </h2>

        <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Tên sản phẩm</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Giá (VNĐ)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
                    @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Video Demo URL (Tùy chọn)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://youtube.com/watch?v=..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
            </div>

            <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-700" x-data="{ images: [] }">
                <label class="block text-sm font-semibold mb-4">Gallery Ảnh (Tối đa 12 ảnh)</label>
                <input type="file" name="gallery[]" multiple accept="image/*"
                    @change="images = []; for(let file of $event.target.files) images.push(URL.createObjectURL(file))"
                    class="block w-full text-sm file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:bg-brand-light file:text-brand cursor-pointer mb-4">
                <div class="flex flex-wrap gap-4">
                    <template x-for="img in images">
                        <img :src="img" class="h-24 w-24 object-cover rounded-lg border border-slate-200">
                    </template>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Mô tả chi tiết</label>
                <input type="hidden" name="description" id="content-hidden">
                <div id="editor-wrapper" class="bg-white rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700"></div>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            @if(auth()->user()->is_admin)
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="w-5 h-5 text-brand rounded border-slate-300 focus:ring-brand">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Xuất bản ngay lập tức</span>
                    </label>
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-700 rounded-xl">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover">Lưu sản phẩm</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/theme/toastui-editor-dark.min.css" />
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const editor = new toastui.Editor({
            el: document.querySelector('#editor-wrapper'),
            height: '500px',
            initialEditType: 'wysiwyg',
            theme: isDark ? 'dark' : 'default',
        });
        document.getElementById('product-form').addEventListener('submit', function() {
            document.getElementById('content-hidden').value = editor.getMarkdown();
        });
    });
</script>
@endsection
