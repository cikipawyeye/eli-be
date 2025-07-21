<?php

declare(strict_types=1);

use App\Domains\Content\Controllers\ContentController;
use App\Domains\Content\Controllers\SubcategoryController;
use App\Domains\Notification\Controllers\EmotionController;
use App\Domains\Notification\Controllers\MessageController;
use App\Domains\Payment\Controllers\PaymentController;
use App\Domains\Notification\Controllers\ReminderNotificationController;
use App\Domains\Theme\Controllers\MusicController;
use App\Domains\Theme\Controllers\WallpaperController;
use App\Domains\User\Controllers\DashboardController;
use App\Domains\User\Controllers\ProfileController;
use App\Domains\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::view('/privacy-policy', 'tnc');

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
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancelPayment'])->name('payments.cancel');

    Route::resource('/wallpapers', WallpaperController::class)->only(['index', 'store', 'destroy']);

    Route::resource('/musics', MusicController::class)->only(['index', 'store', 'destroy']);

    Route::post('/reminder-notifications/disable', [ReminderNotificationController::class, 'disable'])->name('reminder-notifications.disable');

    Route::post('/reminder-notifications/test', [ReminderNotificationController::class, 'test'])->name('reminder-notifications.test');

    Route::resource('/reminder-notifications', ReminderNotificationController::class)->except(['create', 'edit']);

    Route::post('/reminder-notifications/{reminder_notification}/set-active', [ReminderNotificationController::class, 'setActive'])->name('reminder-notifications.set-active');

    Route::resource('/emotions', EmotionController::class)->except(['create', 'edit']);

    Route::resource('/messages', MessageController::class)->only(['store', 'update', 'destroy']);
});

require __DIR__ . '/auth.php'; // NOSONAR
