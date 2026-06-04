<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'user_id', // Thêm user_id vào đây
        'name', 'slug', 'price', 'description',
        'video_url', 'gallery', 'is_published'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
    ];

    // Định nghĩa quan hệ: 1 Sản phẩm thuộc về 1 User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
