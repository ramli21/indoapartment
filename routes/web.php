<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomepageController::class, 'index']);

Route::get('/contact', [HomepageController::class, 'contact']);

// Public Owner Registration Routes (no login required)
Route::get('/daftarkan-apartemen', [ApartmentController::class, 'ownerCreate'])->name('apartments.owner.create');
Route::post('/daftarkan-apartemen', [ApartmentController::class, 'ownerStore'])->name('apartments.owner.store');

// Admin Login Routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Apartments Routes (Admin only)
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::resource('apartments', ApartmentController::class);
});
