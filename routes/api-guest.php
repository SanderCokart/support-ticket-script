<?php

use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

//Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
//    Route::group(['prefix' => 'password'], function () {
//        Route::post('forgot', [AuthController::class, 'forgotPassword'])->name('forgot');
//        Route::post('reset', [AuthController::class, 'resetPassword'])->name('reset');
//    });
//});
