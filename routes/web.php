<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\DokuWebhookController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/rooms', [RoomController::class, 'listRooms'])->name('rooms.list');
Route::get('/apartments/{apartment}', [RoomController::class, 'apartmentRooms'])->name('apartment.rooms');
Route::get('/bantuan', function () {
    return view('help');
})->name('help');

// Public Booking Routes
Route::get('/booking/{room}/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking/{room}/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking:booking_code}/success', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/{booking:booking_code}/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/booking/{booking:booking_code}/payment', [BookingController::class, 'processPayment'])->name('booking.processPayment');

// Public Track Booking Route (no login required)
Route::get('/lacak-booking', [BookingController::class, 'track'])->name('booking.track');
Route::post('/lacak-booking', [BookingController::class, 'searchBooking'])->name('booking.search');

// Public Cancel Booking Route (no login required)
Route::get('/booking/{booking:booking_code}/cancel', [BookingController::class, 'cancelForm'])->name('booking.cancel');
Route::post('/booking/{booking:booking_code}/cancel', [BookingController::class, 'cancelBooking'])->name('booking.cancel');

// Public Inquiry Routes
Route::get('/hubungi-kami', [InquiryController::class, 'create'])->name('inquiry.create');
Route::post('/hubungi-kami', [InquiryController::class, 'store'])->name('inquiry.store');
Route::get('/hubungi-kami/terkirim', [InquiryController::class, 'success'])->name('inquiry.success');

// Route::get('/contact', [HomepageController::class, 'contact']);

// Public Owner Registration Routes (no login required)
Route::get('/daftarkan-apartemen', [RoomController::class, 'ownerCreate'])->name('rooms.owner.create');
Route::post('/daftarkan-apartemen', [RoomController::class, 'ownerStore'])->name('rooms.owner.store');


// Admin Login Routes (public)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/payment/redirect', [PaymentRedirectController::class, 'handleRedirect'])->name('payment.redirect');
// Halaman sukses murni
Route::get('/payment/success', [PaymentRedirectController::class, 'showSuccessPage'])->name('payment.success');

// Apartments Routes (Admin only)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('apartments', \App\Http\Controllers\ApartmentController::class);
    // tetap pertahankan CRUD room yang sudah ada (tidak diubah)

    Route::get('/rooms', [RoomController::class, 'rooms'])->name('all.rooms');


    Route::get('/apartments/{id}/rooms', [RoomController::class, 'index'])->name('apartments.rooms.index');
    Route::get('/apartments/{id}/rooms/create', [RoomController::class, 'create'])->name('apartments.rooms.create');
    Route::post('/apartments/{id}/rooms', [RoomController::class, 'store'])->name('apartments.rooms.store');
    Route::get('/apartments/rooms/{room_id}/edit', [RoomController::class, 'edit'])->name('apartments.rooms.edit');
    Route::put('/apartments/rooms/{room_id}', [RoomController::class, 'update'])->name('apartments.rooms.update');
    Route::delete('/apartments/rooms/{room_id}', [RoomController::class, 'destroy'])->name('apartments.rooms.destroy');

    // Help/Panduan Routes
    Route::get('/help', function () {
        return view('admin.help');
    })->name('help');

    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/calendar', [BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Inquiry Routes
    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('/inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

    // Banner Routes
    // Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);

    // Admin info (bank/contact) settings
    Route::get('/admin-info', [\App\Http\Controllers\Admin\AdminInfoController::class, 'edit'])->name('info.edit');
    Route::post('/admin-info', [\App\Http\Controllers\Admin\AdminInfoController::class, 'update'])->name('info.update');

    // Users/Admin management
    Route::get('/users', [\App\Http\Controllers\Admin\UserAdminController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserAdminController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserAdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserAdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserAdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserAdminController::class, 'destroy'])->name('users.destroy');
    
    // Payment Configs (manage payment gateway credentials)
    Route::resource('payment-configs', \App\Http\Controllers\PaymentConfigController::class)->except(['show']);
});


// API Routes (for calendar and availability check)
Route::middleware(['admin'])->prefix('api')->group(function () {
    Route::get('/bookings/schedule', [BookingController::class, 'getSchedule'])->name('api.bookings.schedule');
    Route::get('/bookings/availability', [BookingController::class, 'checkAvailability'])->name('api.bookings.availability');
    Route::post('/bookings/store', [BookingController::class, 'storeAdmin'])->name('api.bookings.store');
});

// Public API endpoints for payments
Route::prefix('api')->group(function () {
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'processPayment'])->name('api.checkout');
    // Webhook endpoint for Doku - place here so it uses web middleware; you can also place in a dedicated api.php without CSRF
    Route::post('/doku/webhook', [\App\Http\Controllers\DokuWebhookController::class, 'handleNotification'])->name('api.doku.webhook');
});
