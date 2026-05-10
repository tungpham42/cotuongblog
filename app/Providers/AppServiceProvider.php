<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Spatie\SchemaOrg\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share the base Xiangqi Blog schema to all views
        View::composer('layouts.app', function ($view) {
            $blogSchema = Schema::blog()
                ->name('Cộng Đồng Cờ Tướng Việt Nam')
                ->description('Blog về cờ tướng, chia sẻ kiến thức, chiến thuật và tin tức mới nhất về cờ tướng. Học hỏi từ các kỳ thủ hàng đầu và tham gia cộng đồng yêu thích cờ tướng.')
                ->url(url('/'))
                ->inLanguage('vi-VN')
                ->about(
                    Schema::thing()
                        ->name('Xiangqi')
                        ->alternateName('Cờ Tướng')
                        ->description('Một trò chơi chiến thuật bàn cờ dành cho hai người.')
                )
                ->publisher(
                    Schema::organization()
                        ->name('Cộng Đồng Cờ Tướng')
                        ->logo(Schema::imageObject()->url(asset('img/app-icons/icon-512-game.png')))
                );

            $view->with('globalSchema', $blogSchema);
        });
    }
}
