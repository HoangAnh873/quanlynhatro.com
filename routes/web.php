<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Rental_ReceiptController;
use App\Http\Controllers\ContractController;

/**
 * Routes cho giao diện người dùng
 */
Route::get('/', function () {
    return view('user.pages.home');
})->name('home');

Route::get('/apartments/list', [ApartmentController::class, 'list'])->name('user.apartments.list');
Route::get('/apartments/search', [ApartmentController::class, 'search'])->name('user.apartments.search');
Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('user.apartments.show');

Route::get('/rooms/search', [RoomController::class, 'search'])->name('user.rooms.search');

Route::get('/rooms/rentals/{id}', [Rental_ReceiptController::class, 'index'])->name('user.rentals.index');
Route::post('/rooms/rentals', [Rental_ReceiptController::class, 'store'])->name('user.rentals.store');

Route::get('/contact', function () {
    return view('user.pages.contact');
})->name('contact');

/**
 * Routes cho dashboard và xác thực
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route cho host
Route::middleware('auth')->prefix('host')->name('host.')->group(function () {
    Route::get('/dashboard', [HostController::class, 'dashboard'])->name('dashboard');

    // Routes quản lý khu trọ
    Route::resource('apartments', ApartmentController::class)->names('apartments');

    // Routes quản lý loại phòng (types)
    Route::resource('types', RoomTypeController::class)->names('types');

    // Routes cho phòng (rooms)
    Route::resource('rooms', RoomController::class)->names('rooms');

    // Thêm routes cho duyệt phiếu thuê phòng
    Route::get('rentals', [Rental_ReceiptController::class, 'show'])->name('rentals.show');
    Route::patch('rentals/{id}/approve', [Rental_ReceiptController::class, 'approve'])->name('rentals.approve');
    Route::patch('rentals/{id}/reject', [Rental_ReceiptController::class, 'reject'])->name('rentals.reject');

    // Thêm routes cho quản lý hợp đồng
    Route::get('contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('contracts/by-apartment/{apartmentId}', [ContractController::class, 'getContractsByApartment']);
    Route::patch('contracts/{contract}/cancel', [ContractController::class, 'cancel'])->name('contracts.cancel');


});


/**
 * Routes cho quản trị viên (Admin)
 */
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('hosts', HostController::class);
    Route::resource('schools', SchoolController::class);
    Route::resource('users', UserController::class);
});


require __DIR__.'/auth.php';
