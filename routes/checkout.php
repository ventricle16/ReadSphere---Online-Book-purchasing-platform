<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\StripeWebhookController;

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Checkout routes
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'show'])->name('checkout');
        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
        Route::post('/create-payment-intent', [CheckoutController::class,'createPaymentIntent'])->name('checkout.createPaymentIntent');
        Route::get('/success', [CheckoutController::class,'success'])->name('checkout.success');
    });

    // Stripe payment routes
    Route::prefix('pay')->group(function () {
        Route::get('/stripe/{order}', [StripeController::class, 'redirectToStripe'])->name('stripe.pay');
    });

Route::post('/stripe/webhook', [StripeWebhookController::class,'handle'])->name('stripe.webhook');

});
