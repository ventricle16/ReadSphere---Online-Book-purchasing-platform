<?php

// routes/web.php
use App\Http\Controllers\StripeController;

Route::middleware('auth')->group(function () {
    Route::get('/pay/stripe/{order}', [StripeController::class,'redirectToStripe'])
        ->name('stripe.pay');                       // your CheckoutController redirects here
    Route::get('/stripe/view/{order}', [StripeController::class,'showStripePaymentForm'])
        ->name('stripe.view');                       // New route for stripe.blade.php view
    Route::get('/stripe/success', [StripeController::class,'success'])
        ->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class,'cancel'])
        ->name('stripe.cancel');
    // Optional webhook (step 7)
    Route::post('/stripe/webhook', [StripeController::class,'webhook'])
        ->name('stripe.webhook');
});




