<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadSphere • Shopping Cart</title>
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

        .cart-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
        }

        .cart-items {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .cart-summary {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow);
            height: fit-content;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto auto;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
        }

        .item-details h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .item-details p {
            color: var(--text-secondary);
            margin-bottom: 5px;
        }

        .item-price {
            font-weight: 600;
            color: var(--primary);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            background: var(--card-bg);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.2s;
        }

        .quantity-btn:hover {
            background: var(--background);
        }

        .quantity-input {
            width: 50px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
        }

        .remove-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s;
        }

        .remove-btn:hover {
            background: #CC2A22;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            margin: 20px 0;
            padding-top: 15px;
            border-top: 2px solid var(--border);
        }

        .checkout-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s;
        }

        .checkout-btn:hover {
            background: #0056CC;
        }

        .checkout-btn:disabled {
            background: var(--text-secondary);
            cursor: not-allowed;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }

        .empty-cart h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-cart p {
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }

        .alert-error {
            background: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
            
            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 15px;
            }
            
            .quantity-controls, .item-actions {
                grid-column: 1 / -1;
                justify-self: start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Shopping Cart</h1>
            <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">← Continue Shopping</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($cart->item_count === 0): ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <p>Start adding some books to your cart!</p>
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">Browse Books</a>
            </div>
        <?php else: ?>
            <div class="cart-container">
                <div class="cart-items">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cart-item">
                            <img src="<?php echo e($item->book->cover_url ?? 'https://placehold.co/300x400?text=No+Cover'); ?>" 
                                 alt="<?php echo e($item->book->title); ?>" class="item-image">
                            
                            <div class="item-details">
                                <h3><?php echo e($item->book->title); ?></h3>
                                <p>by <?php echo e($item->book->author); ?></p>
                                <p class="item-price">$<?php echo e(number_format($item->price, 2)); ?></p>
                            </div>

                            <div class="quantity-controls">
                                <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button type="button" class="quantity-btn" onclick="this.parentNode.querySelector('input').stepDown()">-</button>
                                    <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1" max="10" class="quantity-input" 
                                           onchange="this.form.submit()">
                                    <button type="button" class="quantity-btn" onclick="this.parentNode.querySelector('input').stepUp()">+</button>
                                </form>
                            </div>

                            <div class="item-actions">
                                <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="cart-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-item">
                        <span>Items (<?php echo e($cart->item_count); ?>)</span>
                        <span>$<?php echo e(number_format($cart->calculateTotalAmount(), 2)); ?></span>
                    </div>
                     <!-- Coupon Section -->
                    <div class="coupon-section" style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                        <?php if($cart->discount_code): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="font-weight: 600; color: var(--success);">
                                    Discount Applied (<?php echo e($cart->discount_code); ?>): -<?php echo e($cart->discount_percent); ?>%
                                </span>
                                <form action="<?php echo e(route('cart.remove-coupon')); ?>" method="POST" style="margin: 0;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="background: var(--danger); color: white; border: none; padding: 4px 8px; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form action="<?php echo e(route('cart.apply-coupon')); ?>" method="POST" style="display: flex; gap: 10px;">
                                <?php echo csrf_field(); ?>
                                <input type="text" name="coupon_code" placeholder="Enter coupon code"
                                       style="flex: 1; padding: 8px 12px; border: 1px solid var(--border); border-radius: 6px; font-size: 14px;">
                                <button type="submit" style="background: var(--success); color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    Apply
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                     <div class="summary-item">
                        <span>Items (<?php echo e($cart->item_count); ?>)</span>
                        <span>$<?php echo e(number_format($cart->total_amount, 2)); ?></span>
                    </div>


                    <div class="summary-item">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <?php if($cart->discount_amount > 0): ?>
                        <div class="summary-item" style="color: var(--success);">
                            <span>Discount (<?php echo e($cart->discount_code); ?>)</span>
                            <span>-$<?php echo e(number_format($cart->discount_amount, 2)); ?></span>
                        </div>
                       
                        <div class="summary-item">
                            <span>Subtotal after discount</span>
                            <span>$<?php echo e(number_format($cart->subtotal_after_discount, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="summary-item">
                        <span>Tax</span>
                        <span>$<?php echo e(number_format($cart->subtotal_after_discount * 0.08, 2)); ?></span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>$<?php echo e(number_format($cart->subtotal_after_discount * 1.08, 2)); ?></span>
                    </div>

                    <form action="<?php echo e(route('checkout')); ?>" method="GET">
                        <button type="submit" class="checkout-btn">Checkout Now</button>
                    </form>

                    <form action="<?php echo e(route('cart.clear')); ?>" method="POST" style="margin-top: 10px;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="remove-btn" style="width: 100%; background: var(--text-secondary);">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-submit quantity forms when input changes
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\readsphere\resources\views/cart.blade.php ENDPATH**/ ?>