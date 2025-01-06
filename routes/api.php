<?php

use App\Domains\Content\Controllers\API\ContentController;
use App\Domains\Content\Controllers\API\SubcategoryController;
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

    Route::post('change-password', [AuthenticatedUserController::class, 'changePassword'])->name('change-password');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::apiResource('/{category}/subcategories', SubcategoryController::class)->only('index', 'show');
    Route::apiResource('/contents', ContentController::class)->only('index', 'show');
});
