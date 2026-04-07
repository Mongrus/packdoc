<?php

use App\Http\Controllers\DocumentPackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account', [UserProfileController::class, 'edit'])->name('account');
    Route::put('/user-profile', [UserProfileController::class, 'update'])->name('user-profile.update');

    Route::get('/packages', [DocumentPackageController::class, 'index'])->name('packages.index');
    Route::get('/packages/create', [DocumentPackageController::class, 'create'])->name('packages.create');
    Route::get('/packages/create/{category}', [DocumentPackageController::class, 'questionnaire'])->name('packages.questionnaire');
    Route::post('/packages/{package}/duplicate', [DocumentPackageController::class, 'duplicate'])->name('packages.duplicate');
    Route::delete('/packages/{package}', [DocumentPackageController::class, 'destroy'])->name('packages.destroy');
});

require __DIR__.'/auth.php';
