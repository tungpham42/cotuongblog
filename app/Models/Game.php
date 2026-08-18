<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // Thêm dòng này để dùng thư viện xử lý chuỗi

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'title',
        'slug', // Thêm trường slug
        'description',
        'views',
        'initial_fen',
        'moves',
    ];

    protected $casts = [
        'moves' => 'array',
    ];

    // Tự động tìm model bằng cột 'slug' thay vì 'id' trên URL
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Tự động tạo slug khi lưu vào database
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            if (empty($game->slug)) {
                // Nếu title rỗng, mặc định là 'van-co'
                $baseTitle = !empty($game->title) ? $game->title : 'van-co';

                // Nối thêm chuỗi ngẫu nhiên (uniqid) để đảm bảo không bao giờ bị trùng slug
                $game->slug = Str::slug($baseTitle) . '-' . uniqid();
            }
        });

        // (Tùy chọn) Nếu bạn muốn slug cập nhật lại khi user đổi title:
        static::updating(function ($game) {
            if ($game->isDirty('title') && !empty($game->title)) {
                $game->slug = Str::slug($game->title) . '-' . uniqid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
