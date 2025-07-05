<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VehicleController;

Route::get('/', function () {
    return auth()->guest() ? redirect()->route('login') : redirect()->route('dashboard');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});


Route::middleware(['auth'])->group(function () {

    // === Rute Umum untuk Semua Role (Admin & Approver) ===
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === Rute Khusus untuk Approver ===
    Route::prefix('approvals/{approval}')->name('approvals.')->group(function () {
        Route::post('/approve', [DashboardController::class, 'approve'])->name('approve');
        Route::post('/reject', [DashboardController::class, 'reject'])->name('reject');
    });

    Route::middleware(['admin'])->group(function () {

        // Manajemen Pemesanan
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

        // Manajemen Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
        Route::get('vehicles', function () {
            return view('vehicles.index');
        })->name('vehicles.index');
        Route::get('vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

        Route::get('drivers', function () {
            return view('drivers.index');
        })->name('drivers.index');
    });
});