<?php

use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
   Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
   Route::resource('books', AdminBookController::class);
   Route::get('books/{book}/download', [AdminBookController::class, 'download'])
        ->name('books.download');
   Route::resource('orders', AdminOrderController::class);
});
