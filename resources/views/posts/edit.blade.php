@extends('layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Chỉnh sửa bài viết</h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 line-clamp-1">{{ $post->title }}</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 p-5 rounded-xl mb-8 flex gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Chuyên mục</label>
                    <select name="category_id" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none appearance-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Thẻ (Tags)</label>
                    @php $postTags = $post->tags->pluck('id')->toArray(); @endphp
                    <select name="tags[]" multiple class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none h-32">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $postTags)) ? 'selected' : '' }} class="py-1">
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nội dung</label>
                <textarea name="content" rows="12" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none resize-y">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700" x-data="{ imageUrl: '{{ $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}' }">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-4">Ảnh đại diện <span class="text-slate-400 font-normal">(Bỏ trống nếu giữ nguyên)</span></label>
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
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" id="is_published" value="1"
                       {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                       class="h-5 w-5 text-brand focus:ring-brand/50 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-600 rounded cursor-pointer transition-colors">
                <label for="is_published" class="ml-3 block text-sm font-medium text-slate-900 dark:text-white cursor-pointer">
                    Trạng thái xuất bản
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 font-normal">Bật để hiển thị bài viết công khai.</p>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('posts.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Cập nhật thay đổi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
