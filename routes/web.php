<?php

use Illuminate\Support\Facades\Route;

use App\Models\Vehicle;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgencyController;

Route::get('/', function () {
    $vehicles = Vehicle::with(['agency', 'photos'])->where('is_available', true)->take(3)->get();
    return view('index', compact('vehicles'));
});

Route::get('/search', [BookingController::class, 'search']);
Route::get('/vehicle/{id}', [BookingController::class, 'show']);
Route::get('/compare', [BookingController::class, 'compare'])->name('compare');
Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Booking Flow
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::get('/booking/success/{id}', [BookingController::class, 'success'])->name('booking.success');
});

// Agency Routes
Route::middleware(['auth', 'role:agency'])->group(function () {
    Route::get('/agency/pending', function () {
        return view('agency.pending');
    })->name('agency.pending');

    Route::middleware(['approved_agency'])->group(function () {
        Route::get('/agency/dashboard', [AgencyController::class, 'dashboard'])->name('agency.dashboard');
        Route::get('/agency/vehicles', [AgencyController::class, 'vehicles'])->name('agency.vehicles');
        Route::get('/agency/vehicles/create', [AgencyController::class, 'createVehicle'])->name('agency.vehicles.create');
        Route::post('/agency/vehicles', [AgencyController::class, 'storeVehicle'])->name('agency.vehicles.store');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/agencies', [AdminController::class, 'agencies'])->name('admin.agencies');
    Route::patch('/admin/agencies/{id}/approve', [AdminController::class, 'approveAgency'])->name('admin.agencies.approve');
    Route::patch('/admin/agencies/{id}/reject', [AdminController::class, 'rejectAgency'])->name('admin.agencies.reject');
});
