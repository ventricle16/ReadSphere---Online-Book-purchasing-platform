<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Dashboard and User Management Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::get('/uploads', [AdminBookController::class, 'index'])->name('uploads');



    // Admin Dashboard
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    // User Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::put('/', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    });
    
    // User Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [UserController::class, 'settings'])->name('settings');
        Route::put('/password', [UserController::class, 'updatePassword'])->name('settings.password');
        Route::put('/preferences', [UserController::class, 'updatePreferences'])->name('settings.preferences');
    });
});
