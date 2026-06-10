@extends('layouts.app')

@section('title', 'Thêm bài viết mới')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden transition-colors duration-300">
    <div class="px-6 py-8 sm:p-10">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Tạo bài viết mới
            </h2>
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

        <form id="post-form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tiêu đề</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết..."
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border {{ $errors->has('title') || $errors->has('slug') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all placeholder-slate-400 dark:placeholder-slate-500 outline-none">

                {{-- Hiển thị lỗi tiêu đề --}}
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                {{-- Hiển thị lỗi slug (nếu tiêu đề hợp lệ nhưng slug bị trùng) --}}
                @if (!$errors->has('title'))
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-50">
                {{-- AlpineJS Category Single Select --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Chuyên mục</label>
                    <div x-data="{
                            open: false,
                            selectedId: '{{ old('category_id') }}',
                            selectedName: 'Chọn chuyên mục...',
                            options: [
                                @foreach($categories as $category)
                                    { id: '{{ $category->id }}', name: '{{ $category->name }} ({{ $category->posts_count }})' },
                                @endforeach
                            ],
                            init() {
                                if (this.selectedId) {
                                    let selected = this.options.find(o => o.id == this.selectedId);
                                    if (selected) this.selectedName = selected.name;
                                }
                            },
                            selectOption(option) {
                                this.selectedId = option.id;
                                this.selectedName = option.name;
                                this.open = false;
                            }
                        }"
                        class="relative"
                        @click.away="open = false">

                        <input type="hidden" name="category_id" :value="selectedId">

                        <button type="button" @click="open = !open"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none flex justify-between items-center text-left">
                            <span x-text="selectedName" :class="{ 'text-slate-500 dark:text-slate-400': !selectedId }"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-20 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="option in options" :key="option.id">
                                    <div @click="selectOption(option)"
                                        class="px-4 py-2 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 flex justify-between items-center text-slate-700 dark:text-slate-300 transition-colors">
                                        <span x-text="option.name"></span>
                                        <svg x-show="selectedId == option.id" class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- AlpineJS Tags Multiple Select --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Thẻ (Tags)</label>
                    <div x-data="{
                            open: false,
                            selectedIds: {{ json_encode(old('tags', [])) }}.map(String),
                            options: [
                                @foreach($tags as $tag)
                                    { id: '{{ $tag->id }}', name: '{{ $tag->name }}', count: '{{ $tag->posts_count }}' },
                                @endforeach
                            ],
                            get selectedOptions() {
                                return this.options.filter(o => this.selectedIds.includes(o.id));
                            },
                            toggleOption(id) {
                                let strId = String(id);
                                let index = this.selectedIds.indexOf(strId);
                                if (index > -1) {
                                    this.selectedIds.splice(index, 1);
                                } else {
                                    this.selectedIds.push(strId);
                                }
                            }
                        }"
                        class="relative"
                        @click.away="open = false">

                        <template x-for="id in selectedIds">
                            <input type="hidden" name="tags[]" :value="id">
                        </template>

                        <div @click="open = !open"
                            class="w-full min-h-[50px] px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus-within:ring-2 focus-within:ring-brand/50 focus-within:border-brand transition-all cursor-text flex flex-wrap gap-2 items-center relative">

                            <template x-if="selectedIds.length === 0">
                                <span class="text-slate-400 dark:text-slate-500 ml-1 select-none absolute left-3 top-3">Chọn thẻ...</span>
                            </template>

                            <template x-for="option in selectedOptions" :key="option.id">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-brand/10 dark:bg-brand/20 text-brand dark:text-brand-light text-sm font-medium z-10">
                                    <span x-text="option.name"></span>
                                    <button type="button" @click.stop="toggleOption(option.id)" class="hover:text-red-500 dark:hover:text-red-400 transition-colors focus:outline-none">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </span>
                            </template>
                        </div>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-20 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="option in options" :key="option.id">
                                    <div @click="toggleOption(option.id)"
                                        class="px-4 py-2 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 flex justify-between items-center text-slate-700 dark:text-slate-300 transition-colors">
                                        <div>
                                            <span x-text="option.name"></span>
                                            <span class="text-xs text-slate-400 ml-1" x-text="`(${option.count})`"></span>
                                        </div>
                                        <div class="w-5 h-5 border rounded flex items-center justify-center transition-colors"
                                             :class="selectedIds.includes(option.id) ? 'bg-brand border-brand' : 'border-slate-300 dark:border-slate-600'">
                                            <svg x-show="selectedIds.includes(option.id)" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nội dung</label>
                <input type="hidden" name="content" id="content-hidden">
                <div id="editor-wrapper" class="bg-white rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 text-left"></div>
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

            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-xl border border-slate-200 dark:border-slate-700 mt-6">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Đường dẫn Video (Tùy chọn)</label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 font-normal">Nhập liên kết (URL) của video Youtube, Vimeo hoặc URL video trực tiếp (.mp4).</p>
                <input type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/..."
                    class="w-full px-4 py-3 bg-white dark:bg-slate-900 border {{ $errors->has('video_url') ? 'border-red-500' : 'border-slate-200 dark:border-slate-700' }} rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none">
                @error('video_url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            @if(auth()->user()->is_admin)
                <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-700">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Trạng thái xuất bản</label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 font-normal">Chọn trạng thái hiển thị cho bài viết này khi tạo mới.</p>

                    <div x-data="{
                            open: false,
                            selectedValue: '{{ old('is_published', '1') }}',
                            selectedLabel: '',
                            options: [
                                { value: '1', label: 'Có (Xuất bản ngay)' },
                                { value: '0', label: 'Không (Lưu thành Bản nháp)' }
                            ],
                            init() {
                                let selected = this.options.find(o => o.value == this.selectedValue);
                                if (selected) this.selectedLabel = selected.label;
                            },
                            selectOption(option) {
                                this.selectedValue = option.value;
                                this.selectedLabel = option.label;
                                this.open = false;
                            }
                        }"
                        class="relative w-full md:w-1/2"
                        @click.away="open = false">

                        {{-- Hidden input để gửi data về server --}}
                        <input type="hidden" name="is_published" :value="selectedValue">

                        <button type="button" @click="open = !open"
                            class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-brand/50 focus:border-brand text-slate-900 dark:text-white transition-all outline-none flex justify-between items-center text-left shadow-sm">
                            <span x-text="selectedLabel"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-20 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden"
                            style="display: none;">
                            <div class="py-1">
                                <template x-for="option in options" :key="option.value">
                                    <div @click="selectOption(option)"
                                        class="px-4 py-3 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 flex justify-between items-center text-slate-700 dark:text-slate-300 transition-colors">
                                        <span x-text="option.label"></span>
                                        <svg x-show="selectedValue === option.value" class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 bg-brand-light/50 dark:bg-brand/10 border border-brand/20 rounded-xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-brand shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="text-sm font-semibold text-brand dark:text-brand-light">Chờ phê duyệt</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Bài viết của bạn sẽ được gửi tới Ban quản trị để duyệt trước khi hiển thị công khai.</p>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('posts.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition font-medium text-center">Hủy</a>
                <button type="submit" class="px-6 py-2.5 bg-brand text-white rounded-xl hover:bg-brand-hover shadow-md shadow-brand/30 transition font-medium text-center">
                    Lưu bài viết
                </button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
<link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/theme/toastui-editor-dark.min.css" />
<script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
        const hiddenInput = document.getElementById('content-hidden');
        const initialContent = {!! json_encode(old('content', '')) !!};

        const editor = new toastui.Editor({
            el: document.querySelector('#editor-wrapper'),
            height: '500px',
            initialEditType: 'wysiwyg',
            previewStyle: 'vertical',
            theme: isDarkMode ? 'dark' : 'default',
            initialValue: initialContent,
            hooks: {
                addImageBlobHook: (blob, callback) => {
                    const formData = new FormData();
                    formData.append('file', blob);

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                    fetch('{{ route('image.upload') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.location) {
                            callback(data.location, blob.name || 'image');
                        } else {
                            alert('Tải ảnh thất bại.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Lỗi mạng khi tải ảnh lên.');
                    });
                }
            }
        });

        // Sync editor content to hidden textarea right before form submission
        document.getElementById('post-form').addEventListener('submit', function() {
            hiddenInput.value = editor.getMarkdown();
        });

        // Dynamic theme switching handler
        window.addEventListener('theme-changed', function(e) {
            const isDark = e.detail;
            const editorUI = document.querySelector('.toastui-editor-defaultUI');
            if (editorUI) {
                if (isDark) {
                    editorUI.classList.add('toastui-editor-dark');
                } else {
                    editorUI.classList.remove('toastui-editor-dark');
                }
            }
        });
    });
</script>
@endsection
