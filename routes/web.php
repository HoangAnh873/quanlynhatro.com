<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;

/**
 * Routes cho giao diện người dùng
 */
Route::get('/', function () {
    return view('user.pages.home');
})->name('home');

Route::get('/rooms', function () {
    return view('user.pages.rooms');
})->name('rooms');

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

// Route cho host
Route::middleware('auth')->group(function () {
    Route::get('/host/dashboard', [HostController::class, 'dashboard'])->name('host.dashboard');
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
