<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Thêm dòng này

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Thêm dòng này để Laravel sử dụng giao diện phân trang của Tailwind
        Paginator::useTailwind(); 
    }
}
