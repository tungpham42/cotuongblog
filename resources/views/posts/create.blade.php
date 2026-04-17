@extends('layouts.app')

@section('title', 'Thêm bài viết mới')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Tạo bài viết mới</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Bắt đầu chia sẻ kiến thức hoặc câu chuyện của bạn.</p>
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

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết..."
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Chuyên mục</label>
                    <select name="category_id" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none appearance-none">
                        <option value="" class="text-slate-500">Chọn chuyên mục...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Thẻ (Tags)</label>
                    <select name="tags[]" multiple class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none h-32 custom-scrollbar">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" class="py-1">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Giữ <kbd class="px-1.5 py-0.5 bg-slate-100 dark:bg-slate-700 rounded border border-slate-200 dark:border-slate-600 font-sans mx-1">Ctrl/Cmd</kbd> để chọn nhiều thẻ.
                    </p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nội dung</label>
                <textarea id="content-editor" name="content" rows="12" placeholder="Viết nội dung của bạn ở đây..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none resize-y placeholder-slate-400 dark:placeholder-slate-500">{{ old('content') }}</textarea>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700" x-data="{ imageUrl: '' }">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Ảnh đại diện</label>
                <div class="flex items-center gap-6">
                    <div class="flex-1">
                        <input type="file" name="featured_image" accept="image/*"
                            @change="imageUrl = URL.createObjectURL($event.target.files[0])"
                            class="block w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-light dark:file:bg-brand/20 file:text-brand hover:file:bg-brand-light/80 dark:hover:file:bg-brand/30 transition-colors cursor-pointer">
                    </div>
                    <template x-if="imageUrl">
                        <div class="relative">
                            <img :src="imageUrl" class="h-24 w-32 object-cover rounded-lg shadow-sm border border-slate-200 dark:border-slate-600" alt="Preview">
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex items-center p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
                <input type="checkbox" name="is_published" id="is_published" value="1" class="h-5 w-5 text-brand focus:ring-brand/50 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-600 rounded cursor-pointer transition-colors">
                <label for="is_published" class="ml-3 block text-sm font-medium text-slate-900 dark:text-white cursor-pointer">
                    Xuất bản ngay
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-normal">Bài viết sẽ hiển thị công khai trên trang web.</p>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('posts.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Lưu bài viết
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;

        tinymce.init({
            selector: '#content-editor',
            license_key: 'gpl',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'image media | removeformat | help', // Thêm nút 'image' vào toolbar

            // Tự động điều chỉnh giao diện Sáng/Tối
            skin: isDarkMode ? 'oxide-dark' : 'oxide',
            content_css: isDarkMode ? 'dark' : 'default',

            // ==========================================
            // CẤU HÌNH UPLOAD ẢNH
            // ==========================================
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',

            images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('tinymce.upload') }}');

                // Lấy CSRF token của Laravel
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                               || '{{ csrf_token() }}';
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({ message: 'Lỗi xác thực: ' + xhr.status, remove: true });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('Lỗi HTTP: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        reject('JSON không hợp lệ: ' + xhr.responseText);
                        return;
                    }

                    // Trả về URL ảnh để TinyMCE hiển thị
                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Lỗi mạng khi tải ảnh lên.');
                };

                const formData = new FormData();
                // Nối file ảnh vào formData với key là 'file' (khớp với validate ở Backend)
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            }),

            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            },
            promotion: false,
            branding: false,
        });
    });
</script>
@endsection
