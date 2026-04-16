@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Tổng quan hệ thống</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Chào mừng bạn quay trở lại. Dưới đây là thống kê các dữ liệu hiện có.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tổng bài viết</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['posts'] }}</p>
            </div>
            <div class="text-4xl">📝</div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('posts.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý bài viết &rarr;</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Chuyên mục</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['categories'] }}</p>
            </div>
            <div class="text-4xl">🗂️</div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('categories.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý chuyên mục &rarr;</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Thẻ (Tags)</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['tags'] }}</p>
            </div>
            <div class="text-4xl">🏷️</div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('tags.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý thẻ &rarr;</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Người dùng</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['users'] }}</p>
            </div>
            <div class="text-4xl">👥</div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('users.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý người dùng &rarr;</a>
        </div>
    </div>
</div>
@endsection
