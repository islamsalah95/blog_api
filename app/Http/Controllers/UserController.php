<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    use ResponseTrait; 


    public function totalUsers()
    {
    $totalUsers = User::count();
    $totalUsers = Cache::remember('total_users', 300, function () {
        return User::count();
    });
    return self::success($totalUsers, 'total Users retrieve successfully.');

    }


    public function usersWithNoPosts()
    {
    $usersWithNoPosts = User::doesntHave('posts')->count();
    $usersWithNoPosts = Cache::remember('users_with_no_posts', 300, function () {
        return User::doesntHave('posts')->count();
    });
    return self::success($usersWithNoPosts, 'users With No Posts retrieve successfully.');
    }



}
