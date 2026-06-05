@extends('layouts.app')

@section('title', 'Tổng quan hệ thống')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Tổng quan hệ thống</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Chào mừng bạn quay trở lại. Dưới đây là thống kê các dữ liệu hiện có.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Khối: Bài Viết --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tổng bài viết</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['posts'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('posts.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý bài viết &rarr;</a>
        </div>
    </div>

    {{-- Khối: Sản Phẩm --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Sản phẩm</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['products'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('admin.products.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý sản phẩm &rarr;</a>
        </div>
    </div>

    {{-- Khối: Chuyên mục --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Chuyên mục</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['categories'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('categories.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý chuyên mục &rarr;</a>
        </div>
    </div>

    {{-- Khối: Thẻ (Tags) --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Thẻ (Tags)</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['tags'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('tags.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý thẻ &rarr;</a>
        </div>
    </div>

    {{-- Khối: Người dùng --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Người dùng</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['users'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('users.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý người dùng &rarr;</a>
        </div>
    </div>

    {{-- Khối: Bình luận --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Bình luận</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['comments'] ?? 0 }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('comments.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý bình luận &rarr;</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
    {{-- Biểu đồ cột: Tổng quan số lượng --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Biểu đồ tổng quan</h3>
        <div class="relative h-72 w-full">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    {{-- Biểu đồ tròn: Tỷ lệ tương tác/nội dung --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Tỷ lệ nội dung & tương tác</h3>
        <div class="relative h-72 w-full flex justify-center">
            <canvas id="doughnutChart"></canvas>
        </div>
    </div>
</div>

<div x-data="dashboardChart()" class="mt-8 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Thống kê tăng trưởng</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Số lượng nội dung được tạo mới theo thời gian</p>
        </div>

        <div class="relative w-full sm:w-auto shrink-0" @click.away="dropdownOpen = false">
            <button type="button" @click="dropdownOpen = !dropdownOpen"
                class="flex items-center justify-between w-full sm:w-[260px] bg-orange-50/80 dark:bg-slate-900/50 hover:bg-brand dark:hover:bg-brand text-slate-700 hover:text-white dark:text-slate-300 dark:hover:text-white rounded-[1.5rem] sm:rounded-full px-5 py-2.5 text-sm font-bold transition-all duration-300 group/btn shadow-sm border border-transparent hover:border-brand/20">

                <div class="flex items-center gap-2.5">
                    <div class="p-1 rounded-md bg-brand/10 group-hover/btn:bg-white/20 text-brand group-hover/btn:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span x-text="timeRangeOptions[selectedTimeRange]" class="truncate tracking-wide"></span>
                </div>

                <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover/btn:scale-110" :class="{'rotate-180': dropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="dropdownOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                class="absolute right-0 z-50 w-full sm:w-[260px] mt-3 bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl border border-brand/10 dark:border-slate-700/80 rounded-[1.5rem] shadow-[0_20px_50px_rgba(249,115,22,0.15)] overflow-hidden p-2 origin-top-right"
                style="display: none;">

                <div class="space-y-1">
                    <template x-for="(label, value) in timeRangeOptions" :key="value">
                        <button type="button" @click="selectOption(value)"
                            class="w-full text-left px-4 py-3 text-[14px] rounded-xl flex items-center justify-between transition-all duration-200"
                            :class="{
                                'bg-brand text-white font-bold shadow-md shadow-brand/20 transform scale-[1.02]': selectedTimeRange === value,
                                'text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700/50 hover:text-brand dark:hover:text-brand font-medium': selectedTimeRange !== value
                            }">
                            <span x-text="label"></span>
                            <svg x-show="selectedTimeRange === value" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="relative h-80 w-full">
        <canvas x-ref="timeSeriesCanvas"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function dashboardChart() {
        return {
            selectedTimeRange: 'monthly',
            dropdownOpen: false,
            chartInstance: null,

            timeRangeOptions: {
                'daily': 'Theo ngày (7 ngày qua)',
                'monthly': 'Theo tháng (Năm nay)',
                'yearly': 'Theo năm (5 năm qua)'
            },

            // Đã đổi @json() thành {!! json_encode() !!} để tránh lỗi dấu phẩy của Blade
            timeSeriesData: {
                daily: {
                    labels: {!! json_encode($chartData['daily']['labels'] ?? ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN']) !!} || [],
                    posts: {!! json_encode($chartData['daily']['posts'] ?? [5, 8, 12, 4, 9, 15, 10]) !!} || [],
                    products: {!! json_encode($chartData['daily']['products'] ?? [2, 5, 3, 7, 4, 8, 6]) !!} || []
                },
                monthly: {
                    labels: {!! json_encode($chartData['monthly']['labels'] ?? ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12']) !!} || [],
                    posts: {!! json_encode($chartData['monthly']['posts'] ?? [45, 52, 38, 65, 48, 55, 70, 85, 60, 75, 90, 110]) !!} || [],
                    products: {!! json_encode($chartData['monthly']['products'] ?? [15, 20, 18, 25, 30, 28, 40, 45, 35, 50, 60, 75]) !!} || []
                },
                yearly: {
                    labels: {!! json_encode($chartData['yearly']['labels'] ?? ['2022', '2023', '2024', '2025', '2026']) !!} || [],
                    posts: {!! json_encode($chartData['yearly']['posts'] ?? [300, 450, 600, 850, 1200]) !!} || [],
                    products: {!! json_encode($chartData['yearly']['products'] ?? [80, 150, 250, 400, 550]) !!} || []
                }
            },

            init() {
                setTimeout(() => {
                    this.renderChart();
                }, 100);
            },

            selectOption(value) {
                this.selectedTimeRange = value;
                this.dropdownOpen = false;
                this.updateChart();
            },

            renderChart() {
                if (!this.$refs.timeSeriesCanvas) return;
                const ctx = this.$refs.timeSeriesCanvas.getContext('2d');
                const initialData = this.timeSeriesData[this.selectedTimeRange];

                if (this.chartInstance) {
                    this.chartInstance.destroy();
                }

                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: initialData.labels || [],
                        datasets: [
                            {
                                label: 'Bài viết mới',
                                data: initialData.posts || [],
                                borderColor: 'rgba(59, 130, 246, 1)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Sản phẩm mới',
                                data: initialData.products || [],
                                borderColor: 'rgba(16, 185, 129, 1)',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: {
                            legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                            tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', titleColor: '#fff', bodyColor: '#fff', padding: 12, cornerRadius: 8 }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.1)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            },

            updateChart() {
                if (!this.chartInstance) return;

                const newData = this.timeSeriesData[this.selectedTimeRange];
                this.chartInstance.data.labels = newData.labels || [];
                this.chartInstance.data.datasets[0].data = newData.posts || [];
                this.chartInstance.data.datasets[1].data = newData.products || [];
                this.chartInstance.update();

                let rangeName = '';
                if (this.selectedTimeRange === 'daily') rangeName = '7 ngày qua';
                else if (this.selectedTimeRange === 'monthly') rangeName = 'năm nay';
                else rangeName = '5 năm qua';

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: `Đã cập nhật dữ liệu: ${rangeName}`,
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    background: '#f8fafc',
                    color: '#1e293b'
                });
            }
        };
    }

    // ----------------------------------------------------
    // VANILLA JS CHO CÁC BIỂU ĐỒ TĨNH (BAR & DOUGHNUT)
    // ----------------------------------------------------
    document.addEventListener('DOMContentLoaded', function() {

        // Trở về sử dụng echo blade thông thường cho các số nguyên
        const statsData = {
            posts: {{ $stats['posts'] ?? 0 }},
            products: {{ $stats['products'] ?? 0 }},
            categories: {{ $stats['categories'] ?? 0 }},
            tags: {{ $stats['tags'] ?? 0 }},
            users: {{ $stats['users'] ?? 0 }},
            comments: {{ $stats['comments'] ?? 0 }}
        };

        const chartColors = [
            'rgba(59, 130, 246, 0.8)', 'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)',
            'rgba(99, 102, 241, 0.8)', 'rgba(236, 72, 153, 0.8)', 'rgba(139, 92, 246, 0.8)'
        ];

        if(document.getElementById('barChart')) {
            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Bài viết', 'Sản phẩm', 'Chuyên mục', 'Thẻ', 'Người dùng', 'Bình luận'],
                    datasets: [{
                        label: 'Số lượng',
                        data: [statsData.posts, statsData.products, statsData.categories, statsData.tags, statsData.users, statsData.comments],
                        backgroundColor: chartColors,
                        borderRadius: 6,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.1)' } }, x: { grid: { display: false } } }
                }
            });
        }

        if(document.getElementById('doughnutChart')) {
            const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: ['Bài viết', 'Sản phẩm', 'Bình luận'],
                    datasets: [{
                        data: [statsData.posts, statsData.products, statsData.comments],
                        backgroundColor: [chartColors[0], chartColors[1], chartColors[5]],
                        borderWidth: 2, hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { padding: 20, usePointStyle: true } } },
                    cutout: '65%'
                }
            });
        }
    });
</script>
@endpush
