<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;


/*
|--------------------------------------------------------------------------
| Wishlist Management Routes
|--------------------------------------------------------------------------
*/


Route::middleware(['auth'])->group(function () {


    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/add/{book}', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::delete('/remove/{book}', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::post('/toggle/{book}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::get('/user/{user}', [WishlistController::class, 'userWishlist'])->name('wishlist.user');
    });


});



