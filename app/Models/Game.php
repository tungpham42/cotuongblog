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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
