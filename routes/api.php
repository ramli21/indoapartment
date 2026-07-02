<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider or application bootstrap
| within a group which is assigned the "api" middleware group.
|
*/

Route::prefix('v1')->group(function () {
    // 1. Ambil detail harga kamar setelah diskon otomatis (Global atau Room-specific)
    Route::get('/rooms/{room}/calculate-price', [DiscountController::class, 'calculatePrice']);

    // 2. Validasi & terapkan kode voucher secara real-time di halaman checkout
    Route::post('/checkout/apply-voucher', [DiscountController::class, 'applyVoucher']);

    // 3. Admin Dashboard - Kelola Diskon & Voucher (dilindungi middleware auth/admin jika diperlukan)
    Route::prefix('admin')->group(function () {
        // Kelola Diskon (Global & Spesifik Unit)
        Route::post('/discounts', [\App\Http\Controllers\Admin\AdminDiscountController::class, 'store']);
        Route::put('/discounts/{discount}', [\App\Http\Controllers\Admin\AdminDiscountController::class, 'update']);

        // Kelola Voucher
        Route::post('/vouchers', [\App\Http\Controllers\Admin\AdminVoucherController::class, 'store']);
        Route::put('/vouchers/{voucher}', [\App\Http\Controllers\Admin\AdminVoucherController::class, 'update']);
    });
});
