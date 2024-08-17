<?php

use App\Http\Controllers\Seller\AccountController;
use App\Http\Controllers\Seller\Auth\AuthController;
use App\Http\Controllers\Seller\Auth\ForgetPasswordController;
use App\Http\Controllers\Seller\SellerController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'seller',
    'as'     => 'seller.'
], function(){

    Route::middleware(['guest:seller', 'prevent-back-history'])->group(function (){

        // register
        Route::view('register-page', 'back.pages.seller.auth.register')->name('register');
        Route::post('register', [AuthController::class, 'register'])->name('register.post');

        // verify
        Route::get('account/verify/{token}', [AuthController::class, 'verify'])->name('verify');
        Route::view('register-success', 'back.pages.seller.auth.register-success')->name('register-success');;

        // login
        Route::view('login', 'back.pages.seller.auth.login')->name('login');
        Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

        // forget password
        Route::view('/forget-password', 'back.pages.seller.auth.forget-password')->name('forget-password');
        Route::group([
            'controller' => ForgetPasswordController::class,
        ],function () {
            Route::post('/send-password-reset-link', 'sendPasswordLink')->name('send-password-reset-link');
            Route::get('/reset-password/{token}', 'resetPasswordForm')->name('reset-password');
            Route::post('/reset-password', 'updatePassword')->name('update-password');
            Route::post('reset-password-handler/{token}', 'resetPasswordHandler')->name('reset-password-handler');
        });
    });

    Route::middleware(['auth:seller', 'verified', 'prevent-back-history'])->group(function (){
        Route::get('/',[SellerController::class, 'home'])->name('home');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    });

});
