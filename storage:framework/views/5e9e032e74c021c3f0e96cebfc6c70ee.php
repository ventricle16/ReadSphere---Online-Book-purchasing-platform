<?php $__env->startPush('head'); ?>
<script src="https://js.stripe.com/v3/"></script>
<?php $__env->stopPush(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadSphere • Checkout</title>
    <style>
        :root {
            --primary: #007AFF;
            --secondary: #5856D6;
            --success: #34C759;
            --danger: #FF3B30;
            --warning: #FF9500;
            --background: #F2F2F7;
            --card-bg: #FFFFFF;
            --text-primary: #000000;
            --text-secondary: #8E8E93;
            --border: #C6C6C8;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--background);
            color: var(--text-primary);
            line-height: 1.6;
        }


        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }


        .header {
            background: var(--card-bg);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }


        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }


        .back-btn {
            background: var(--primary);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }


        .back-btn:hover {
            background: #0056CC;
        }


        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
        }


        .checkout-form {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow);
        }


        .order-summary {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            height: fit-content;
        }


        .form-section {
            margin-bottom: 30px;
        }


        .form-section h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
        }


        .form-group {
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }


        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.2s;
        }


        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }


        .form-group textarea {
            height: 100px;
            resize: vertical;
        }


        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }


        .payment-method {
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }


        .payment-method:hover {
            border-color: var(--primary);
        }


        .payment-method.selected {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
        }


        .payment-method input {
            display: none;
        }


        .summary-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary);
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
        }


        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }


        .order-item:last-child {
            border-bottom: none;
        }


        .item-details h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }


        .item-details p {
            color: var(--text-secondary);
            font-size: 14px;
        }


        .item-price {
            font-weight: 600;
            color: var(--primary);
        }


        .summary-totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid var(--border);
        }


        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }


        .grand-total {
            font-size: 18px;
            font-weight: 700;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid var(--border);
        }


        .checkout-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 20px;
        }


        .checkout-btn:hover {
            background: #0056CC;
        }


        .checkout-btn:disabled {
            background: var(--text-secondary);
            cursor: not-allowed;
        }


        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }


        .alert-error {
            background: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }


        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
           
            .payment-methods {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💳 Checkout</h1>
            <a href="<?php echo e(route('cart')); ?>" class="back-btn">← Back to Cart</a>
        </div>


        <?php if(session('error')): ?>
            <div class="alert alert-error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>


        <form action="<?php echo e(route('checkout.process')); ?>" method="POST">
            <?php echo csrf_field(); ?>
           
            <div class="checkout-container">
                <div class="checkout-form">
                    <div class="form-section">
                        <h2>Shipping Information</h2>
                       
                        <div class="form-group">
                            <label for="shipping_address">Shipping Address *</label>
                            <textarea
                                id="shipping_address"
                                name="shipping_address"
                                placeholder="Enter your complete shipping address"
                                required
                            ><?php echo e(old('shipping_address', $user->shipping_address ?? '')); ?></textarea>
                        </div>
                    </div>


                    <div class="form-section">
                        <h2>Billing Information</h2>
                       
                        <div class="form-group">
                            <label for="billing_address">Billing Address *</label>
                            <textarea
                                id="billing_address"
                                name="billing_address"
                                placeholder="Enter your complete billing address"
                                required
                            ><?php echo e(old('billing_address', $user->billing_address ?? '')); ?></textarea>
                        </div>
                    </div>


                    <div class="form-section">
                        <h2>Payment Method</h2>
                       
                        <div class="payment-methods">
                            <label class="payment-method <?php echo e(old('payment_method') == 'Card' ? 'selected' : ''); ?>">
                                <input type="radio" name="payment_method" value="card" <?php echo e(old('payment_method') == 'card' ? 'checked' : 'checked'); ?>>
                                💳 Card
                            </label>
                           
                            <label class="payment-method <?php echo e(old('payment_method') == 'Bkash' ? 'selected' : ''); ?>">
                                <input type="radio" name="payment_method" value="Bkash" <?php echo e(old('payment_method') == 'Bkash' ? 'checked' : ''); ?>>
                                📧 Bkash
                            </label>
                           
                            <label class="payment-method <?php echo e(old('payment_method') == 'bank_transfer' ? 'selected' : ''); ?>">
                                <input type="radio" name="payment_method" value="bank_transfer" <?php echo e(old('payment_method') == 'bank_transfer' ? 'checked' : ''); ?>>
                                🏦 Bank Transfer
                            </label>
                        </div>
                    </div>
                </div>


                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                   
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="order-item">
                            <div class="item-details">
                                <h4><?php echo e($item->book->title); ?></h4>
                                <p>Qty: <?php echo e($item->quantity); ?> × $<?php echo e(number_format($item->price, 2)); ?></p>
                            </div>
                            <div class="item-price">
                                $<?php echo e(number_format($item->subtotal, 2)); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>$<?php echo e(number_format($cart->total_amount, 2)); ?></span>
                        </div>
                        <?php if($cart->discount_amount > 0): ?>
                            <div class="total-row" style="color: var(--success);">
                                <span>Discount (<?php echo e($cart->discount_code); ?>)</span>
                                <span>-$<?php echo e(number_format($cart->discount_amount, 2)); ?></span>
                            </div>
                           
                            <div class="total-row">
                                <span>Subtotal after discount</span>
                                <span>$<?php echo e(number_format($cart->subtotal_after_discount, 2)); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                       
                        <div class="total-row">
                            <span>Tax (8%)</span>
                            <span>$<?php echo e(number_format(($cart->discount_amount > 0 ? $cart->subtotal_after_discount : $cart->total_amount) * 0.08, 2)); ?></span>
                        </div>
                       
                        <div class="grand-total">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($cart->discount_amount > 0 ? $cart->final_total : $cart->total_amount * 1.08, 2)); ?></span>
                        </div>
                    </div>


                    <button type="submit" class="checkout-btn">
                        Complete Purchase
                    </button>
                </div>
            </div>
        </form>
    </div>


    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input').checked = true;
            });
        });


        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const shippingAddress = document.getElementById('shipping_address').value.trim();
            const billingAddress = document.getElementById('billing_address').value.trim();
           
            if (!shippingAddress || !billingAddress) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    </script>
</body>
</html>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/checkout.blade.php ENDPATH**/ ?>