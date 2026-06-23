<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\AuthController;

// ========================================
// LAYAR PUBLIC (Tanpa Autentikasi)
// ========================================

// Halaman utama / landing
Route::get('/', [QueueController::class, 'indexPublic'])->name('home');

// Layar Antrian Obat (Display TV di ruang tunggu)
Route::get('/display', [QueueController::class, 'display'])->name('display');

// ========================================
// AUTENTIKASI
// ========================================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================================
// AREA TERLINDUNGI (Wajib Login)
// ========================================
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [QueueController::class, 'dashboard'])->name('dashboard');

    // CRUD Antrian
    Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');
    Route::put('/queues/{id}', [QueueController::class, 'update'])->name('queues.update');
    Route::delete('/queues/{id}', [QueueController::class, 'destroy'])->name('queues.destroy');
    Route::post('/queues/{id}/call', [QueueController::class, 'callQueue'])->name('queues.call');

    // ====================================
    // KHUSUS SUPERADMIN
    // ====================================
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/users', [AuthController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AuthController::class, 'create'])->name('users.create');
        Route::post('/users', [AuthController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AuthController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [AuthController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('users.destroy');
    });
});