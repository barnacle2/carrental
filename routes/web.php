<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('web')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminController::class, 'login'])->name('login.post');
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('dashboard', [AdminController::class, 'dashboard']);
        Route::get('users', [AdminController::class, 'showUsers'])->name('users');
        Route::get('cars', [AdminController::class, 'showCars'])->name('cars');
        Route::get('bookings', [AdminController::class, 'showBookings'])->name('bookings');
        
        // Car management
        Route::post('cars', [AdminController::class, 'storeCar'])->name('cars.store');
        Route::put('cars/{car}', [AdminController::class, 'updateCar'])->name('cars.update');
        Route::delete('cars/{car}', [AdminController::class, 'deleteCar'])->name('cars.delete');
        
        // Booking management
        Route::put('bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
        
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
    });
});

// Public Routes
Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return Inertia::render('LandingPage');
    });

    // User Routes
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [RentalController::class, 'index'])->name('dashboard');
        Route::get('/choose-cars', [CarController::class, 'index'])->name('cars.index');
        Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
        Route::post('/rentals/{car}', [RentalController::class, 'store'])->name('rentals.store');
        Route::get('/rentals/{rental}/receipt', [RentalController::class, 'showReceipt'])->name('rentals.receipt');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
