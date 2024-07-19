<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use Illuminate\Support\Facades\Route;

Route::view('/example-pages', 'example-page');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['guest:admin', 'prevent-back-history'])->group(function (){

        Route::view('/login', 'back.pages.auth.login')->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
        Route::view('/forget-password', 'back.pages.auth.forget-password')->name('forget-password');
        Route::group([
            'controller' => ForgotPasswordController::class,
        ],function () {
            Route::post('/send-password-reset-link', 'sendPasswordLink')->name('send-password-reset-link');
            Route::get('/reset-password/{token}', 'resetPassword')->name('reset-password');
            Route::post('/reset-password', 'updatePassword')->name('update-password');
            Route::post('reset-password-handler/{token}', 'resetPasswordHandler')->name('reset-password-handler');
        });

    });

    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function (){
        Route::view('/home', 'back.pages.home')->name('home');
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
