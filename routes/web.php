<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('/post-details/{post}', [App\Http\Controllers\WelcomeController::class, 'post'])->name('post');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('post', App\Http\Controllers\PostController::class);
Route::resource('comment', App\Http\Controllers\CommentController::class)->only(['store', 'destroy']);
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('post', App\Http\Controllers\AdminController::class);
});
