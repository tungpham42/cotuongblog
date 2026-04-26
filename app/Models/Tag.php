<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'featured_image', 'order'];
    public function posts(): BelongsToMany {
        return $this->belongsToMany(Post::class);
    }
}
