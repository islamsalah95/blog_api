<?php
namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function saved(Post $post)
    {
        Cache::forget('users_with_no_posts');
    }

    public function deleted(Post $post)
    {
        Cache::forget('users_with_no_posts');
    }
}
