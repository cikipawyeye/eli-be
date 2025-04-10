<?php

declare(strict_types=1);

use App\Domains\Content\Controllers\ContentController;
use App\Domains\Content\Controllers\SubcategoryController;
use App\Domains\Payment\Controllers\PaymentController;
use App\Domains\Theme\Controllers\WallpaperController;
use App\Domains\User\Controllers\DashboardController;
use App\Domains\User\Controllers\ProfileController;
use App\Domains\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/subcategories', SubcategoryController::class)->except(['edit']);
    Route::resource('/contents', ContentController::class)->only(['store', 'update', 'destroy']);

    Route::resource('/users', UserController::class);
    Route::post('/users/{user}/add-payment', [UserController::class, 'addPayment'])->name('users.add-payment');

    Route::resource('/payments', PaymentController::class)->except(['create', 'edit']);

    Route::resource('/wallpapers', WallpaperController::class)->only(['index', 'store', 'destroy']);
});

require __DIR__.'/auth.php'; // NOSONAR
