<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\TicketController;

Route::apiResources([
    'tickets'    => TicketController::class,
    'categories' => CategoryController::class,
]);

Route::apiResource('tickets.responses', ResponseController::class)
    ->only('store');
Route::apiResource('tickets.responses', ResponseController::class)
    ->only('destroy', 'update')
    ->middleware('owner:response');

Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout');
Route::get('user', [AuthController::class, 'user'])
    ->name('user');
