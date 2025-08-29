<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Invoice Routes
|--------------------------------------------------------------------------
|
| Here we define routes related to invoice generation and display.
| This will handle downloading or viewing invoices after successful
| order payment.
|
*/

// Show invoice in browser (after payment success)
Route::get('/invoice/{order}', [InvoiceController::class, 'show'])
    ->name('invoice.show');

// Download invoice as PDF
Route::get('/invoice/{order}/download', [InvoiceController::class, 'download'])
    ->name('invoice.download');
