@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Tổng quan hệ thống</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Chào mừng bạn quay trở lại. Dưới đây là thống kê các dữ liệu hiện có.</p>
</div>

<!-- Statistics Cards Grid -->
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

<!-- Data Visualization Charts -->
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

<!-- MỚI: Biểu đồ thống kê theo Thời gian (Ngày / Tháng / Năm) -->
<div class="mt-8 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Thống kê tăng trưởng</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Số lượng nội dung được tạo mới theo thời gian</p>
        </div>

        <!-- Dropdown chọn mốc thời gian -->
        <select id="timeRangeSelector" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-brand focus:border-brand block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white outline-none cursor-pointer">
            <option value="daily">Theo ngày (7 ngày qua)</option>
            <option value="monthly" selected>Theo tháng (Năm nay)</option>
            <option value="yearly">Theo năm (5 năm qua)</option>
        </select>
    </div>

    <div class="relative h-80 w-full">
        <canvas id="timeSeriesChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. DỮ LIỆU TỔNG QUAN ---
        const statsData = {
            posts: {{ $stats['posts'] ?? 0 }},
            products: {{ $stats['products'] ?? 0 }},
            categories: {{ $stats['categories'] ?? 0 }},
            tags: {{ $stats['tags'] ?? 0 }},
            users: {{ $stats['users'] ?? 0 }},
            comments: {{ $stats['comments'] ?? 0 }}
        };

        const chartColors = [
            'rgba(59, 130, 246, 0.8)', // Blue
            'rgba(16, 185, 129, 0.8)', // Green
            'rgba(245, 158, 11, 0.8)', // Yellow
            'rgba(99, 102, 241, 0.8)', // Indigo
            'rgba(236, 72, 153, 0.8)', // Pink
            'rgba(139, 92, 246, 0.8)'  // Purple
        ];

        // Biểu đồ Cột (Bar Chart)
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

        // Biểu đồ Tròn (Doughnut Chart)
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

        // --- 2. BIỂU ĐỒ THEO THỜI GIAN (MỚI) ---
        // Lưu ý: Bạn cần truyền dữ liệu này từ Controller sang Blade dạng JSON.
        // Đây là dữ liệu mẫu giả lập để biểu đồ có thể hiển thị hoạt động ngay.
        const timeSeriesData = {
            daily: {
                labels: {!! json_encode($chartData['daily']['labels'] ?? ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN']) !!},
                posts: {!! json_encode($chartData['daily']['posts'] ?? [5, 8, 12, 4, 9, 15, 10]) !!},
                products: {!! json_encode($chartData['daily']['products'] ?? [2, 5, 3, 7, 4, 8, 6]) !!}
            },
            monthly: {
                labels: {!! json_encode($chartData['monthly']['labels'] ?? ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12']) !!},
                posts: {!! json_encode($chartData['monthly']['posts'] ?? [45, 52, 38, 65, 48, 55, 70, 85, 60, 75, 90, 110]) !!},
                products: {!! json_encode($chartData['monthly']['products'] ?? [15, 20, 18, 25, 30, 28, 40, 45, 35, 50, 60, 75]) !!}
            },
            yearly: {
                labels: {!! json_encode($chartData['yearly']['labels'] ?? ['2022', '2023', '2024', '2025', '2026']) !!},
                posts: {!! json_encode($chartData['yearly']['posts'] ?? [300, 450, 600, 850, 1200]) !!},
                products: {!! json_encode($chartData['yearly']['products'] ?? [80, 150, 250, 400, 550]) !!}
            }
        };

        const ctxTime = document.getElementById('timeSeriesChart').getContext('2d');

        // Khởi tạo biểu đồ mặc định (Theo tháng)
        let timeChart = new Chart(ctxTime, {
            type: 'line',
            data: {
                labels: timeSeriesData.monthly.labels,
                datasets: [
                    {
                        label: 'Bài viết mới',
                        data: timeSeriesData.monthly.posts,
                        borderColor: 'rgba(59, 130, 246, 1)', // Blue
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        fill: true,
                        tension: 0.4 // Đường cong mềm mại
                    },
                    {
                        label: 'Sản phẩm mới',
                        data: timeSeriesData.monthly.products,
                        borderColor: 'rgba(16, 185, 129, 1)', // Green
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
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, padding: 20 }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(148, 163, 184, 0.1)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Xử lý sự kiện khi thay đổi Dropdown (Ngày / Tháng / Năm)
        document.getElementById('timeRangeSelector').addEventListener('change', function(e) {
            const selectedRange = e.target.value;
            const newData = timeSeriesData[selectedRange];

            // Cập nhật nhãn trục X và dữ liệu trục Y
            timeChart.data.labels = newData.labels;
            timeChart.data.datasets[0].data = newData.posts;
            timeChart.data.datasets[1].data = newData.products;

            // Render lại biểu đồ với hiệu ứng transition
            timeChart.update();
        });
    });
</script>
@endpush
