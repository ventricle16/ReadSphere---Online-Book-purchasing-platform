<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;


/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function () {
    // Cart management routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart');
        Route::post('/add/{book}', [CartController::class, 'add'])->name('cart.add');
        Route::put('/update/{item}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
       
        // Coupon routes
        Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
        Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
    });
});



