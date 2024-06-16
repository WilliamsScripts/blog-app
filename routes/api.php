<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAuth;


Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::get('/posts', [App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/posts/{post}', [App\Http\Controllers\Api\PostController::class, 'show']);

Route::middleware(['auth:sanctum', UserAuth::class])->group(function () {
    Route::post('/posts', [App\Http\Controllers\Api\PostController::class, 'store']);
    Route::put('/posts/{post}', [App\Http\Controllers\Api\PostController::class, 'update']);
    Route::delete('/posts/{post}', [App\Http\Controllers\Api\PostController::class, 'destroy']);
    Route::post('/comment', [App\Http\Controllers\Api\CommentController::class, 'store']);
});
