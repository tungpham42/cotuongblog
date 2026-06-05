<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan Dashboard.
     */
    public function index()
    {
        // 1. Dữ liệu số lượng tổng quan
        $stats = [
            'posts'      => Post::count(),
            'categories' => Category::count(),
            'tags'       => Tag::count(),
            'users'      => User::count(),
            'comments'   => Comment::count(),
            'products'   => Product::count(),
        ];

        $now = Carbon::now();

        // --- CÁC HÀM TRỢ GIÚP TỐI ƯU TRUY VẤN SQL ---

        // Lấy dữ liệu 7 ngày qua
        $getDailyData = function ($model) use ($now) {
            $startDate = $now->copy()->subDays(6)->startOfDay();
            return $model::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray();
        };

        // Lấy dữ liệu 12 tháng của năm hiện tại
        $getMonthlyData = function ($model) use ($now) {
            return $model::select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as count'))
                ->whereYear('created_at', $now->year)
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();
        };

        // Lấy dữ liệu 5 năm qua
        $getYearlyData = function ($model) use ($now) {
            $startYear = $now->year - 4;
            return $model::select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as count'))
                ->whereYear('created_at', '>=', $startYear)
                ->groupBy('year')
                ->pluck('count', 'year')
                ->toArray();
        };

        // --- THỰC THI TRUY VẤN (Chỉ tốn tổng cộng 6 câu Query) ---
        $dailyPostsData    = $getDailyData(Post::class);
        $dailyProductsData = $getDailyData(Product::class);

        $monthlyPostsData    = $getMonthlyData(Post::class);
        $monthlyProductsData = $getMonthlyData(Product::class);

        $yearlyPostsData    = $getYearlyData(Post::class);
        $yearlyProductsData = $getYearlyData(Product::class);

        // --- MAPPING DỮ LIỆU ĐỂ TRẢ VỀ VIEW ---

        // 2. Chuẩn bị mảng NGÀY (7 ngày qua)
        $dailyLabels = [];
        $dailyPosts = [];
        $dailyProducts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $dateString = $date->toDateString(); // YYYY-MM-DD

            $dailyLabels[] = $date->format('d/m');
            $dailyPosts[] = $dailyPostsData[$dateString] ?? 0;       // Lấy data hoặc mặc định là 0
            $dailyProducts[] = $dailyProductsData[$dateString] ?? 0;
        }

        // 3. Chuẩn bị mảng THÁNG (12 tháng)
        $monthlyLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];
        $monthlyPosts = [];
        $monthlyProducts = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyPosts[] = $monthlyPostsData[$i] ?? 0;
            $monthlyProducts[] = $monthlyProductsData[$i] ?? 0;
        }

        // 4. Chuẩn bị mảng NĂM (5 năm gần nhất)
        $yearlyLabels = [];
        $yearlyPosts = [];
        $yearlyProducts = [];

        for ($i = 4; $i >= 0; $i--) {
            $year = $now->year - $i;
            $yearlyLabels[] = (string) $year;

            $yearlyPosts[] = $yearlyPostsData[$year] ?? 0;
            $yearlyProducts[] = $yearlyProductsData[$year] ?? 0;
        }

        // 5. Đóng gói dữ liệu thành mảng cuối cùng
        $chartData = [
            'daily' => [
                'labels'   => $dailyLabels,
                'posts'    => $dailyPosts,
                'products' => $dailyProducts,
            ],
            'monthly' => [
                'labels'   => $monthlyLabels,
                'posts'    => $monthlyPosts,
                'products' => $monthlyProducts,
            ],
            'yearly' => [
                'labels'   => $yearlyLabels,
                'posts'    => $yearlyPosts,
                'products' => $yearlyProducts,
            ]
        ];

        // Trả về view kèm dữ liệu
        return view('dashboard', compact('stats', 'chartData'));
    }
}
