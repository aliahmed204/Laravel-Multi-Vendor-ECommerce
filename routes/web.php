<?php

use App\Http\Controllers\Front\FrontEndController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::view('/example-auth', 'example-auth');
Route::controller(FrontEndController::class)->group(function(){
    Route::get('/','homePage')->name('home-page');
});
