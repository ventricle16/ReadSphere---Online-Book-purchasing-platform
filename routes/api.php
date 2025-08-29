<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API Controllers
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;

// Other Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BooklistController;

Route::prefix('v1')->group(function () {
    Route::get('books/{id}', [BookController::class, 'show']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::post('users/{id}/wishlist', [WishlistController::class, 'store']);
    Route::post('orders', [PaymentController::class, 'createOrder']);
    Route::post('orders/{orderId}/pay', [PaymentController::class, 'processPayment']);
    Route::get('invoices/{invoiceId}/download', [InvoiceController::class, 'downloadInvoice']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('booklist', BooklistController::class);
});

//  Fetch Invoice Details (JSON)
Route::get('/invoices/{order}', [InvoiceController::class, 'apiShow'])
    ->name('api.invoices.show');

//  Download Invoice as PDF (for API use)
Route::get('/invoices/{order}/download', [InvoiceController::class, 'apiDownload'])
    ->name('api.invoices.download');

Route::post('/invoices', [InvoiceController::class, 'apiStore'])
    ->name('api.invoices.store');