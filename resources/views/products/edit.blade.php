@extends('layouts.app')

@section('title', 'Cập nhật: ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="p-6 sm:p-10">
        <h2 class="text-3xl font-bold mb-8">Sửa sản phẩm</h2>

        <form id="product-form" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Tên sản phẩm</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Giá (VNĐ)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Số Zalo liên hệ (Tùy chọn)</label>
                    <input type="text" name="zalo_number" value="{{ old('zalo_number', $product->zalo_number) }}" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Video Demo URL</label>
                <input type="url" name="video_url" value="{{ old('video_url', $product->video_url) }}" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand">
            </div>

            @php
                $existingImages = empty($product->gallery) ? '[]' : json_encode(array_map(function($img) {
                    return ['url' => asset('storage/'.$img), 'path' => $img];
                }, $product->gallery));
            @endphp

            {{-- INTERACTIVE DRAG & DROP REORDER GALLERY --}}
            <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-700"
                 x-data="{
                    isDraggingZone: false,
                    dragIndex: null,
                    items: [
                        ...{{ $existingImages }}.map((img, i) => ({
                            id: 'old_' + i,
                            type: 'old',
                            path: img.path,
                            preview: img.url
                        }))
                    ],
                    getNewFileIndex(id) {
                        return this.items.filter(i => i.type === 'new').findIndex(i => i.id === id);
                    },
                    addFiles(files) {
                        for (let i = 0; i < files.length; i++) {
                            if (this.items.length >= 48) {
                                alert('Tối đa 48 ảnh tổng cộng!');
                                break;
                            }
                            let file = files[i];
                            let id = 'new_' + Date.now() + Math.random();
                            let preview = file.name.match(/\.(heic|heif)$/i)
                                ? 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'100\'><rect width=\'100\' height=\'100\' fill=\'%23e2e8f0\'/><text x=\'50%\' y=\'50%\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'16\' font-weight=\'bold\' fill=\'%2364748b\'>HEIC</text></svg>'
                                : URL.createObjectURL(file);
                            this.items.push({ id, type: 'new', file, preview });
                        }
                        this.sync();
                    },
                    removeItem(id) {
                        this.items = this.items.filter(f => f.id !== id);
                        this.sync();
                    },
                    handleDrop(index) {
                        if (this.dragIndex !== null && this.dragIndex !== index) {
                            const draggedItem = this.items[this.dragIndex];
                            this.items.splice(this.dragIndex, 1);
                            this.items.splice(index, 0, draggedItem);
                            this.sync();
                        }
                        this.dragIndex = null;
                    },
                    sync() {
                        let dt = new DataTransfer();
                        this.items.filter(i => i.type === 'new').forEach(f => dt.items.add(f.file));
                        this.$refs.fileInput.files = dt.files;
                    }
                 }">
                <label class="block text-sm font-semibold mb-4">Gallery Ảnh <span class="font-normal text-slate-400">(Tối đa 48 ảnh - Kéo thả ảnh để thay đổi thứ tự giữa ảnh cũ và mới)</span></label>

                <div @dragover.prevent="isDraggingZone = true"
                     @dragleave.prevent="isDraggingZone = false"
                     @drop.prevent="isDraggingZone = false; addFiles($event.dataTransfer.files)"
                     @click="$refs.filePicker.click()"
                     :class="isDraggingZone ? 'border-brand bg-brand/5' : 'border-slate-300 dark:border-slate-600 border-dashed bg-white dark:bg-slate-800'"
                     class="border-2 rounded-xl p-8 text-center cursor-pointer transition-all flex flex-col items-center justify-center hover:bg-slate-50 dark:hover:bg-slate-700">
                    <svg class="w-10 h-10 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Click hoặc kéo thả thêm ảnh mới vào đây</p>
                    <p class="text-xs text-slate-500 mt-1">Hỗ trợ JPG, PNG, WEBP, HEIC</p>
                </div>

                <input type="file" name="gallery[]" multiple accept="image/*,.heic,.heif" class="hidden" x-ref="fileInput">
                <input type="file" multiple accept="image/*,.heic,.heif" class="hidden" x-ref="filePicker" @change="addFiles($event.target.files); $event.target.value=''">

                <div class="flex flex-wrap gap-4 mt-6" style="display: none;" x-show="items.length > 0">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div draggable="true"
                             @dragstart="dragIndex = index; $event.dataTransfer.effectAllowed = 'move';"
                             @dragover.prevent="$event.dataTransfer.dropEffect = 'move';"
                             @drop.prevent="handleDrop(index)"
                             @dragend="dragIndex = null"
                             :class="dragIndex === index ? 'opacity-40 scale-95 border-brand border-2' : 'border-slate-200 dark:border-slate-700 border'"
                             class="relative group h-28 w-28 rounded-xl overflow-hidden shadow-sm cursor-move transition-all duration-200 bg-white">

                            <input type="hidden" name="gallery_sort_order[]" :value="item.type === 'old' ? 'old:' + item.path : 'new:' + getNewFileIndex(item.id)">

                            <template x-if="item.type === 'new'">
                                <div class="absolute top-0 left-0 bg-brand text-white text-[10px] font-bold px-1.5 py-0.5 rounded-br-lg z-10 pointer-events-none">MỚI</div>
                            </template>

                            <img :src="item.preview" class="h-full w-full object-cover pointer-events-none">

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center z-20">
                                <button type="button" @click.stop="removeItem(item.id)" class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transform scale-75 group-hover:scale-100 transition-all cursor-pointer" title="Xóa ảnh này">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Mô tả chi tiết</label>
                <input type="hidden" name="description" id="content-hidden">
                <div id="editor-wrapper" class="bg-white rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700"></div>
            </div>

            @if(auth()->user()->is_admin)
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ $product->is_published ? 'checked' : '' }} class="w-5 h-5 text-brand rounded border-slate-300 focus:ring-brand">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Công khai sản phẩm này</span>
                    </label>
                </div>
            @endif

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 bg-slate-100 dark:bg-slate-700 rounded-xl">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/theme/toastui-editor-dark.min.css" />
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initialContent = {!! json_encode(old('description', $product->description)) !!};
        const isDark = document.documentElement.classList.contains('dark');
        const editor = new toastui.Editor({
            el: document.querySelector('#editor-wrapper'),
            height: '500px',
            initialEditType: 'wysiwyg',
            theme: isDark ? 'dark' : 'default',
            initialValue: initialContent,
        });
        document.getElementById('product-form').addEventListener('submit', function() {
            document.getElementById('content-hidden').value = editor.getMarkdown();
        });
    });
</script>
@endsection
