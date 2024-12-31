<?php

declare(strict_types=1);

use App\Domains\Content\Controllers\ContentController;
use App\Domains\Content\Controllers\SubcategoryController;
use App\Domains\User\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => false,
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/subcategories', SubcategoryController::class)->except(['edit']);
    Route::resource('/contents', ContentController::class)->only(['store', 'update', 'destroy']);
    Route::get('/contents/{content}/image', [ContentController::class, 'getImage'])->name('contents.image');
});

require __DIR__ . '/auth.php'; // NOSONAR
