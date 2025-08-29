<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| User Management Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('users')->group(function () {
    // User profile and settings
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    
    // Admin routes (if needed)
    Route::middleware('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
