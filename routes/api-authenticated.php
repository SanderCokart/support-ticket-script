<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;
use App\Http\Controllers\UpdateEmailController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UpdateProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::apiResource('categories', CategoryController::class);

    Route::putPatch('/tickets/{ticket}/assign', [TicketController::class, 'assign'])
        ->name('tickets.assign');
    Route::putPatch('/tickets/{ticket}/resolve', [TicketController::class, 'resolve'])
        ->name('tickets.resolve');
    Route::apiResource('tickets', TicketController::class)
        ->only('index', 'store', 'show', 'update');

    Route::apiResource('tickets.responses', TicketResponseController::class)
        ->only('index', 'store', 'update');

    Route::get('/users/admins', [UserController::class, 'admins'])
        ->name('users.admins');
});

Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
    Route::get('/user', [AuthController::class, 'user'])
        ->name('user');

    Route::putPatch('/', UpdateProfileController::class)
        ->name('update.profile');

    Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
//        Route::post('verify', [AuthController::class, 'verifyEmail'])
//            ->name('verify');
//        Route::post('resend', [AuthController::class, 'resendEmailVerification'])
//            ->name('resend');
        Route::putPatch('/', UpdateEmailController::class)
            ->name('update.email');
    });
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::putPatch('/', UpdatePasswordController::class)
            ->name('update.password');
    });
});
