<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KprController;
use App\Http\Controllers\LwDebiturController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/', [KprController::class, 'index'])->name('kpr.index');
    
    // Master Debitur LW Routes
    Route::get('/master-debitur', [LwDebiturController::class, 'index'])->name('debitur.index');
    Route::get('/master-debitur/{id}', [LwDebiturController::class, 'show'])->name('debitur.show');
    
    // KPR Dashboard Routes
    Route::post('/kpr/store', [KprController::class, 'store'])->name('kpr.store');
    Route::post('/kpr/{id}/update', [KprController::class, 'update'])->name('kpr.update');
    Route::post('/kpr/{id}/status', [KprController::class, 'updateStatus'])->name('kpr.status');
    Route::delete('/kpr/{id}', [KprController::class, 'destroy'])->name('kpr.destroy');
    Route::get('/kpr/export-csv', [KprController::class, 'exportCsv'])->name('kpr.export');
});
