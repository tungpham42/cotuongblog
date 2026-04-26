@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Tổng quan hệ thống</h1>
    <p class="text-slate-600 dark:text-slate-400 mt-2">Chào mừng bạn quay trở lại. Dưới đây là thống kê các dữ liệu hiện có.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tổng bài viết</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['posts'] }}</p>
            </div>
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
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
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            </div>
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
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
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
            <div class="text-brand dark:text-brand-light">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <a href="{{ route('users.index') }}" class="text-brand hover:text-brand-hover text-sm font-medium transition">Quản lý người dùng &rarr;</a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 transition hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Bình luận</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $stats['comments'] }}</p>
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
@endsection
