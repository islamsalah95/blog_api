<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'body',
        'image',
        'pinned',
        'user_id',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($post) {
            Cache::forget('users_with_no_posts');
        });

        static::deleted(function ($post) {
            Cache::forget('users_with_no_posts');
        });
    }
}
