<?php

declare(strict_types=1);

use App\Domains\Content\Controllers\API\ContentController;
use App\Domains\Content\Controllers\API\SubcategoryController;
use App\Domains\Notification\Controllers\API\EmotionController;
use App\Domains\Notification\Controllers\API\MessageController;
use App\Domains\Payment\Controllers\API\PaymentController;
use App\Domains\Payment\Controllers\API\PaymentWebhookController;
use App\Domains\Payment\Controllers\API\UpgradeAccountController;
use App\Domains\Theme\Controllers\API\MusicController;
use App\Domains\Theme\Controllers\API\WallpaperController;
use App\Domains\User\Controllers\API\AuthenticatedUserController;
use App\Domains\User\Controllers\API\PasswordResetLinkController;
use App\Domains\User\Controllers\API\ProfileController;
use App\Domains\User\Controllers\API\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.')->middleware('auth:sanctum')->group(function () {
    Route::withoutMiddleware('auth:sanctum')->group(function () {
        Route::prefix('register')->group(function () {
            Route::get('/cities', [RegisterController::class, 'cities'])->name('register.origin.cities');
            Route::post('/', [RegisterController::class, 'register'])->name('register');
            Route::post('/check-email', [RegisterController::class, 'checkEmail'])->name('register.check-email');
        });

        Route::post('login', [AuthenticatedUserController::class, 'login'])->name('login');

        Route::post('payment/webhook', PaymentWebhookController::class)->name('payment.webhook');
        Route::post('payment/webhook/pm', [PaymentWebhookController::class, 'paymentMethod'])->name('payment.webhook.pm');

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::get('emotions', [EmotionController::class, 'index'])
            ->name('emotions.index');

        Route::get('messages', [MessageController::class, 'index'])
            ->name('messages.index');
    });

    Route::post('logout', [AuthenticatedUserController::class, 'logout'])->name('logout');

    Route::post('change-password', [AuthenticatedUserController::class, 'changePassword'])->name('change-password');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::apiResource('/{category}/subcategories', SubcategoryController::class)->only('index', 'show');
    Route::apiResource('/contents', ContentController::class)->only('index', 'show');
    Route::get('/contents/{content}/image', [ContentController::class, 'getImage'])->name('contents.image');

    Route::get('/upgrade/status', [UpgradeAccountController::class, 'status'])->name('upgrade.status');
    Route::post('/upgrade', [UpgradeAccountController::class, 'createPayment'])->name('upgrade.create-payment');
    Route::post('/upgrade/cancel-payment', [UpgradeAccountController::class, 'cancelPayment'])->name('upgrade.cancel-payment');

    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');

    Route::apiResource('/wallpapers', WallpaperController::class)->only('index', 'show');
    Route::get('/wallpapers/{wallpaper}/file', [WallpaperController::class, 'getFile'])->name('wallpapers.file');
    Route::get('/wallpapers/{wallpaper}/thumbnail', [WallpaperController::class, 'getThumbnail'])->name('wallpapers.thumbnail');

    Route::apiResource('/musics', MusicController::class)->only('index', 'show');
    Route::get('/musics/{music}/file', [MusicController::class, 'getFile'])->name('musics.file');
});
