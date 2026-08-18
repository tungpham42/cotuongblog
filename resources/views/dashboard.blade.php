@extends('layouts.app')

@section('title', 'Tổng quan hệ thống')

@section('content')

@php
    $hour = (int) now()->format('H');
    $greeting = $hour < 12 ? 'Chào buổi sáng' : ($hour < 18 ? 'Chào buổi chiều' : 'Chào buổi tối');

    // Bảng màu cố định cho từng loại dữ liệu — dùng xuyên suốt (thẻ số liệu, biểu đồ, hoạt động)
    $cardsConfig = [
        [
            'key'   => 'posts',
            'label' => 'Tổng bài viết',
            'route' => 'posts.index',
            'cta'   => 'Quản lý bài viết',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>',
            'bg'    => 'bg-blue-50 dark:bg-blue-500/10',
            'text'  => 'text-blue-600 dark:text-blue-400',
            'ring'  => 'ring-1 ring-inset ring-blue-100 dark:ring-blue-500/20',
            'growth' => $growth['posts'] ?? null,
        ],
        [
            'key'   => 'products',
            'label' => 'Sản phẩm',
            'route' => 'admin.products.index',
            'cta'   => 'Quản lý sản phẩm',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>',
            'bg'    => 'bg-violet-50 dark:bg-violet-500/10',
            'text'  => 'text-violet-600 dark:text-violet-400',
            'ring'  => 'ring-1 ring-inset ring-violet-100 dark:ring-violet-500/20',
            'growth' => $growth['products'] ?? null,
        ],
        [
            'key'   => 'categories',
            'label' => 'Chuyên mục',
            'route' => 'categories.index',
            'cta'   => 'Quản lý chuyên mục',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>',
            'bg'    => 'bg-teal-50 dark:bg-teal-500/10',
            'text'  => 'text-teal-600 dark:text-teal-400',
            'ring'  => 'ring-1 ring-inset ring-teal-100 dark:ring-teal-500/20',
            'growth' => null,
        ],
        [
            'key'   => 'tags',
            'label' => 'Thẻ (Tags)',
            'route' => 'tags.index',
            'cta'   => 'Quản lý thẻ',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>',
            'bg'    => 'bg-amber-50 dark:bg-amber-500/10',
            'text'  => 'text-amber-600 dark:text-amber-400',
            'ring'  => 'ring-1 ring-inset ring-amber-100 dark:ring-amber-500/20',
            'growth' => null,
        ],
        [
            'key'   => 'users',
            'label' => 'Người dùng',
            'route' => 'users.index',
            'cta'   => 'Quản lý người dùng',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
            'bg'    => 'bg-rose-50 dark:bg-rose-500/10',
            'text'  => 'text-rose-600 dark:text-rose-400',
            'ring'  => 'ring-1 ring-inset ring-rose-100 dark:ring-rose-500/20',
            'growth' => $growth['users'] ?? null,
        ],
        [
            'key'   => 'comments',
            'label' => 'Bình luận',
            'route' => 'comments.index',
            'cta'   => 'Quản lý bình luận',
            'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>',
            'bg'    => 'bg-cyan-50 dark:bg-cyan-500/10',
            'text'  => 'text-cyan-600 dark:text-cyan-400',
            'ring'  => 'ring-1 ring-inset ring-cyan-100 dark:ring-cyan-500/20',
            'growth' => $growth['comments'] ?? null,
        ],
    ];

    $maxStat = max(1, max($stats));
@endphp

<!-- ============ HERO / WELCOME BANNER ============ -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 p-8 mb-8 shadow-lg">
    <!-- Decorative glow accents -->
    <div class="pointer-events-none absolute -top-16 -right-16 h-64 w-64 rounded-full bg-indigo-500/30 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 left-1/3 h-72 w-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>

    <div class="relative flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
        <div>
            <p class="text-sm font-medium text-indigo-300">{{ $greeting }}{{ auth()->user() ? ', ' . auth()->user()->name : '' }} 👋</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mt-1 tracking-tight">Tổng quan hệ thống</h1>
            <p class="text-slate-300 mt-2 max-w-xl">{{ now()->translatedFormat('l, d/m/Y') }} — đây là bức tranh toàn cảnh về nội dung, sản phẩm và người dùng của bạn.</p>
        </div>

        <div class="flex flex-wrap gap-3">
            @if(\Illuminate\Support\Facades\Route::has('posts.create'))
            <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Bài viết mới
            </a>
            @endif
            @if(\Illuminate\Support\Facades\Route::has('products.create'))
            <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2.5 text-sm font-semibold text-white ring-1 ring-inset ring-white/20 hover:bg-white/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Sản phẩm mới
            </a>
            @endif
        </div>
    </div>
</div>

<!-- ============ KPI / STATISTICS CARDS ============ -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach($cardsConfig as $card)
    <div class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md hover:-translate-y-0.5 duration-200">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2 tabular-nums">
                    <span class="js-count" data-target="{{ $stats[$card['key']] ?? 0 }}">0</span>
                </p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $card['bg'] }} {{ $card['ring'] }} {{ $card['text'] }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route($card['route']) }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">{{ $card['cta'] }} &rarr;</a>

            @if($card['growth'])
                @php $g = $card['growth']; @endphp
                <span @class([
                    'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-semibold',
                    'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $g['trend'] === 'up',
                    'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' => $g['trend'] === 'down',
                    'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400' => $g['trend'] === 'flat',
                ]) title="So với 7 ngày trước">
                    @if($g['trend'] === 'up') ▲ @elseif($g['trend'] === 'down') ▼ @else — @endif
                    {{ abs($g['percent']) }}%
                </span>
            @endif
        </div>
    </div>
    @endforeach
</div>

<!-- ============ CHARTS: GROWTH TREND + DISTRIBUTION ============ -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    {{-- Biểu đồ đường: Tăng trưởng theo thời gian --}}
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Thống kê tăng trưởng</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Số lượng nội dung được tạo mới theo thời gian</p>
            </div>

            <div class="inline-flex rounded-lg bg-slate-100 dark:bg-slate-700/60 p-1" role="tablist">
                <button type="button" data-range-btn="daily" class="range-btn px-3.5 py-1.5 rounded-md text-sm font-medium text-slate-500 dark:text-slate-400 transition">Ngày</button>
                <button type="button" data-range-btn="monthly" class="range-btn active px-3.5 py-1.5 rounded-md text-sm font-medium bg-white dark:bg-slate-800 shadow-sm text-brand transition">Tháng</button>
                <button type="button" data-range-btn="yearly" class="range-btn px-3.5 py-1.5 rounded-md text-sm font-medium text-slate-500 dark:text-slate-400 transition">Năm</button>
            </div>
        </div>

        <div class="relative h-80 w-full">
            <canvas id="timeSeriesChart"></canvas>
        </div>
    </div>

    {{-- Biểu đồ tròn: Tỷ lệ nội dung --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 flex flex-col">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Tỷ lệ nội dung</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Bài viết · Sản phẩm · Bình luận</p>

        <div class="relative flex-1 flex items-center justify-center min-h-[220px]">
            <canvas id="doughnutChart"></canvas>
            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                <span class="text-2xl font-bold text-slate-800 dark:text-white tabular-nums">
                    {{ number_format(($stats['posts'] ?? 0) + ($stats['products'] ?? 0) + ($stats['comments'] ?? 0)) }}
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tổng cộng</span>
            </div>
        </div>
    </div>
</div>

<!-- ============ ACTIVITY FEED + QUICK OVERVIEW ============ -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    {{-- Hoạt động gần đây --}}
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Hoạt động gần đây</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Cập nhật mới nhất trên toàn hệ thống</p>

        @if($activityFeed->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Chưa có hoạt động nào gần đây.</p>
            </div>
        @else
            <ul class="relative space-y-6 before:absolute before:left-[15px] before:top-2 before:bottom-2 before:w-px before:bg-slate-100 dark:before:bg-slate-700">
                @foreach($activityFeed as $activity)
                    @php
                        $meta = match($activity['type']) {
                            'post'    => ['dot' => 'bg-blue-500', 'label' => 'Bài viết'],
                            'comment' => ['dot' => 'bg-cyan-500', 'label' => 'Bình luận'],
                            'user'    => ['dot' => 'bg-rose-500', 'label' => 'Người dùng'],
                            'product' => ['dot' => 'bg-violet-500', 'label' => 'Sản phẩm'],
                            default   => ['dot' => 'bg-slate-400', 'label' => 'Hoạt động'],
                        };

                        $title = match($activity['type']) {
                            'post'    => $activity['model']->title ?? $activity['model']->name ?? 'Bài viết mới',
                            'comment' => \Illuminate\Support\Str::limit($activity['model']->content ?? $activity['model']->body ?? 'Bình luận mới', 70),
                            'user'    => $activity['model']->name ?? $activity['model']->email ?? 'Người dùng mới',
                            'product' => $activity['model']->name ?? $activity['model']->title ?? 'Sản phẩm mới',
                            default   => 'Hoạt động mới',
                        };
                    @endphp
                    <li class="relative flex gap-4 pl-0">
                        <span class="relative z-10 mt-1 h-[10px] w-[10px] flex-shrink-0 rounded-full {{ $meta['dot'] }} ring-4 ring-white dark:ring-slate-800"></span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-400 dark:text-slate-500">{{ $meta['label'] }}</span>
                                <span class="text-xs text-slate-400 dark:text-slate-500">&middot;</span>
                                <span class="text-xs text-slate-400 dark:text-slate-500">{{ $activity['created_at']?->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-700 dark:text-slate-200 mt-0.5 truncate">{{ $title }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Tổng quan nhanh --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Tổng quan nhanh</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">So sánh khối lượng dữ liệu</p>

        <div class="space-y-4">
            @foreach($cardsConfig as $card)
                @php $value = $stats[$card['key']] ?? 0; @endphp
                <div>
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="text-slate-600 dark:text-slate-300">{{ $card['label'] }}</span>
                        <span class="font-semibold text-slate-800 dark:text-white tabular-nums">{{ number_format($value) }}</span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden">
                        <div class="h-full rounded-full {{ $card['text'] }} bg-current opacity-80" style="width: {{ round(($value / $maxStat) * 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 0. HIỆU ỨNG ĐẾM SỐ (COUNT-UP) ---
        function animateCount(el) {
            const target = parseInt(el.dataset.target, 10) || 0;
            const duration = 900;
            const start = performance.now();

            function tick(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target).toLocaleString('vi-VN');
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    el.textContent = target.toLocaleString('vi-VN');
                }
            }
            requestAnimationFrame(tick);
        }
        document.querySelectorAll('.js-count').forEach(animateCount);

        // --- 1. DỮ LIỆU TỔNG QUAN ---
        const statsData = {
            posts: {{ $stats['posts'] ?? 0 }},
            products: {{ $stats['products'] ?? 0 }},
            categories: {{ $stats['categories'] ?? 0 }},
            tags: {{ $stats['tags'] ?? 0 }},
            users: {{ $stats['users'] ?? 0 }},
            comments: {{ $stats['comments'] ?? 0 }}
        };

        const chartColors = {
            posts: 'rgba(59, 130, 246, 0.85)',    // Blue
            products: 'rgba(139, 92, 246, 0.85)', // Violet
            comments: 'rgba(6, 182, 212, 0.85)'    // Cyan
        };

        // Biểu đồ Tròn (Doughnut Chart)
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Bài viết', 'Sản phẩm', 'Bình luận'],
                datasets: [{
                    data: [statsData.posts, statsData.products, statsData.comments],
                    backgroundColor: [chartColors.posts, chartColors.products, chartColors.comments],
                    borderWidth: 2,
                    borderColor: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { padding: 16, usePointStyle: true, boxWidth: 8 } } },
                cutout: '72%'
            }
        });

        // --- 2. BIỂU ĐỒ THEO THỜI GIAN ---
        const timeSeriesData = {
            daily: {
                labels: {!! json_encode($chartData['daily']['labels'] ?? []) !!},
                posts: {!! json_encode($chartData['daily']['posts'] ?? []) !!},
                products: {!! json_encode($chartData['daily']['products'] ?? []) !!}
            },
            monthly: {
                labels: {!! json_encode($chartData['monthly']['labels'] ?? []) !!},
                posts: {!! json_encode($chartData['monthly']['posts'] ?? []) !!},
                products: {!! json_encode($chartData['monthly']['products'] ?? []) !!}
            },
            yearly: {
                labels: {!! json_encode($chartData['yearly']['labels'] ?? []) !!},
                posts: {!! json_encode($chartData['yearly']['posts'] ?? []) !!},
                products: {!! json_encode($chartData['yearly']['products'] ?? []) !!}
            }
        };

        const ctxTime = document.getElementById('timeSeriesChart').getContext('2d');

        function buildGradient(ctx, color) {
            const gradient = ctx.createLinearGradient(0, 0, 0, 320);
            gradient.addColorStop(0, color.replace('0.85', '0.25').replace('1)', '0.25)'));
            gradient.addColorStop(1, color.replace('0.85', '0').replace('1)', '0)'));
            return gradient;
        }

        let timeChart = new Chart(ctxTime, {
            type: 'line',
            data: {
                labels: timeSeriesData.monthly.labels,
                datasets: [
                    {
                        label: 'Bài viết mới',
                        data: timeSeriesData.monthly.posts,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: buildGradient(ctxTime, 'rgba(59, 130, 246, 0.85)'),
                        borderWidth: 2.5,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Sản phẩm mới',
                        data: timeSeriesData.monthly.products,
                        borderColor: 'rgba(139, 92, 246, 1)',
                        backgroundColor: buildGradient(ctxTime, 'rgba(139, 92, 246, 0.85)'),
                        borderWidth: 2.5,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointBackgroundColor: 'rgba(139, 92, 246, 1)',
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
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, padding: 20 } },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(148, 163, 184, 0.1)' }, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- 3. CHUYỂN ĐỔI KHOẢNG THỜI GIAN (Segmented control) ---
        const rangeButtons = document.querySelectorAll('[data-range-btn]');
        rangeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const selectedRange = btn.dataset.rangeBtn;
                const newData = timeSeriesData[selectedRange];

                timeChart.data.labels = newData.labels;
                timeChart.data.datasets[0].data = newData.posts;
                timeChart.data.datasets[1].data = newData.products;
                timeChart.update();

                rangeButtons.forEach(b => {
                    b.classList.remove('active', 'bg-white', 'dark:bg-slate-800', 'shadow-sm', 'text-brand');
                    b.classList.add('text-slate-500', 'dark:text-slate-400');
                });
                btn.classList.add('active', 'bg-white', 'dark:bg-slate-800', 'shadow-sm', 'text-brand');
                btn.classList.remove('text-slate-500', 'dark:text-slate-400');
            });
        });
    });
</script>
@endpush
