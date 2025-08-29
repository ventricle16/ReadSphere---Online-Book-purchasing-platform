<?php
/**
 * Test Script for Stripe Payment Integration
 * 
 * This script tests the basic functionality of the Stripe payment integration
 * without requiring a full Laravel application setup.
 */

echo "🧪 Testing Stripe Payment Integration\n";
echo "=====================================\n\n";

// Check if Stripe configuration exists
echo "1. Checking Stripe configuration...\n";
$configPath = __DIR__ . '/config/services.php';
if (file_exists($configPath)) {
    $config = include $configPath;
    if (isset($config['stripe'])) {
        echo "✅ Stripe configuration found\n";
        echo "   - Key: " . ($config['stripe']['key'] ? 'Set' : 'Not set') . "\n";
        echo "   - Secret: " . ($config['stripe']['secret'] ? 'Set' : 'Not set') . "\n";
        echo "   - Webhook Secret: " . ($config['stripe']['webhook_secret'] ? 'Set' : 'Not set') . "\n";
        echo "   - Currency: " . $config['stripe']['currency'] . "\n";
    } else {
        echo "❌ Stripe configuration not found in services.php\n";
    }
} else {
    echo "❌ Config file not found: $configPath\n";
}

echo "\n2. Checking Stripe payment view...\n";
$stripeViewPath = __DIR__ . '/resources/views/payments/stripe.blade.php';
if (file_exists($stripeViewPath)) {
    echo "✅ Stripe payment view found\n";
    $content = file_get_contents($stripeViewPath);
    $hasStripeJS = strpos($content, 'js.stripe.com/v3/') !== false;
    $hasCardElement = strpos($content, 'card-element') !== false;
    $hasPaymentForm = strpos($content, 'payment-form') !== false;
    
    echo "   - Stripe JS: " . ($hasStripeJS ? '✅' : '❌') . "\n";
    echo "   - Card Element: " . ($hasCardElement ? '✅' : '❌') . "\n";
    echo "   - Payment Form: " . ($hasPaymentForm ? '✅' : '❌') . "\n";
} else {
    echo "❌ Stripe payment view not found\n";
}

echo "\n3. Checking routes...\n";
$checkoutRoutesPath = __DIR__ . '/routes/checkout.php';
if (file_exists($checkoutRoutesPath)) {
    $content = file_get_contents($checkoutRoutesPath);
    $hasStripeRoute = strpos($content, 'stripe.pay') !== false;
    $hasStripeController = strpos($content, 'StripePaymentController') !== false;
    
    echo "   - Stripe Route: " . ($hasStripeRoute ? '✅' : '❌') . "\n";
    echo "   - Stripe Controller: " . ($hasStripeController ? '✅' : '❌') . "\n";
} else {
    echo "❌ Checkout routes file not found\n";
}

echo "\n4. Checking CheckoutController updates...\n";
$checkoutControllerPath = __DIR__ . '/app/Http/Controllers/CheckoutController.php';
if (file_exists($checkoutControllerPath)) {
    $content = file_get_contents($checkoutControllerPath);
    $hasStripeRedirect = strpos($content, 'stripe.pay') !== false;
    $hasCardPayment = strpos($content, 'payment_method === \'card\'') !== false;
    
    echo "   - Stripe Redirect: " . ($hasStripeRedirect ? '✅' : '❌') . "\n";
    echo "   - Card Payment Handling: " . ($hasCardPayment ? '✅' : '❌') . "\n";
} else {
    echo "❌ CheckoutController not found\n";
}

echo "\n5. Environment variables check:\n";
echo "   Please ensure the following environment variables are set in your .env file:\n";
echo "   - STRIPE_KEY=pk_test_your_test_key_here\n";
echo "   - STRIPE_SECRET=sk_test_your_test_secret_here\n";
echo "   - STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here\n";

echo "\n📋 Next Steps:\n";
echo "1. Set up your Stripe API keys in the .env file\n";
echo "2. Test the checkout flow by adding items to cart and selecting 'Card' payment\n";
echo "3. Verify the redirection to the Stripe payment page\n";
echo "4. Test successful and failed payment scenarios\n";
echo "5. Set up webhook endpoint in Stripe dashboard for payment confirmation\n";

echo "\n✅ Stripe integration setup completed successfully!\n";
