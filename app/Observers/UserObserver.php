<?php
namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    public function saved(User $user)
    {
        Cache::forget('total_users');
        Cache::forget('users_with_no_posts');
    }

    public function deleted(User $user)
    {
        Cache::forget('total_users');
        Cache::forget('users_with_no_posts');
    }
}
