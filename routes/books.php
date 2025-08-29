<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookPreviewController;

/*
|--------------------------------------------------------------------------
| Book Management Routes
|--------------------------------------------------------------------------
*/

Route::prefix('books')->group(function () {
    // Public routes
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
    Route::post('/{book}/wishlist', [BookController::class, 'addToWishlist'])->name('books.addToWishlist');
    Route::get('/search', [BookController::class, 'search'])->name('books.search');
    Route::get('/category/{category}', [BookController::class, 'byCategory'])->name('books.category');
    
    // Book preview routes
    Route::get('/{book}/preview', [BookPreviewController::class, 'show'])->name('books.preview');
    Route::get('/{book}/preview/page/{page}', [BookPreviewController::class, 'getPage'])->name('books.preview.page');
    
    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::get('/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});

// Category routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('categories.show');
    
    Route::middleware('auth')->group(function () {
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});
