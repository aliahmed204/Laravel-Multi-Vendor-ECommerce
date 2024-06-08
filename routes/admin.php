<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::view('/example-pages', 'example-page');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin', 'prevent-back-history'])->group(function (){
        Route::view('/login', 'back.pages.auth.login')->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    });

    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function (){
        Route::view('/home', 'back.pages.home')->name('home');
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
