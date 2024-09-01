<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// *************auth***********
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/verify', [AuthenticationController::class, 'verify'])->middleware('auth:sanctum');


// *************Tags***********
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/tags', TagController::class)->except(['update']);
    Route::post('/tags/{tag}', [TagController::class, 'update']);
});



// *************posts***********
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/posts', PostController::class)->except(['update', 'restore', 'count']);
    Route::post('/posts/{post}', [PostController::class, 'update']);
    Route::post('/posts/restore/{id}', [PostController::class, 'restore']);
    Route::post('/posts/count', [PostController::class, 'count']);
});


// *************users***********

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/total', [UserController::class, 'totalUsers']);
    Route::get('/users/no-posts', [UserController::class, 'usersWithNoPosts']);
});
