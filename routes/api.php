<?php

use App\Domains\User\Controllers\API\AuthenticatedUserController;
use App\Domains\User\Controllers\API\ProfileController;
use App\Domains\User\Controllers\API\RegisterController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->name('api.')->middleware('auth:sanctum')->group(function () {
    Route::withoutMiddleware('auth:sanctum')->group(function () {
        Route::prefix('register')->group(function () {
            Route::get('/cities', [RegisterController::class, 'cities'])->name('register.origin.cities');
            Route::post('/', [RegisterController::class, 'register'])->name('register');
        });

        Route::post('login', [AuthenticatedUserController::class, 'login'])->name('login');
    });

    Route::post('logout', [AuthenticatedUserController::class, 'logout'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'show'])->name('user.profile');
});
