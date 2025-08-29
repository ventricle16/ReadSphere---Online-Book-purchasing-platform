

<?php $__env->startSection('content'); ?>
<div class="container text-center">
    <h2 class="text-success">🎉 Payment Successful!</h2>
    <p>Your order has been placed successfully.</p>
    <p>Thank you for your purchase at <strong>ReadSphere</strong>.</p>

    <div class="card mt-4">
        <div class="card-body">
            <h5>Order ID: <?php echo e($order->id); ?></h5>
            <p><strong>Name:</strong> <?php echo e($order->customer_name); ?></p>
            <p><strong>Mobile:</strong> <?php echo e($order->customer_mobile); ?></p>
            <p><strong>Total Paid:</strong> $ <?php echo e(number_format($finalAmount, 2)); ?></p>
        </div>
    </div>
    
        <?php if(session('order_id')): ?>
            <?php
                $orderId = session('order_id');
            ?>
            <div class="mt-4">
                <?php echo $__env->make('invoice.show', ['order' => \App\Models\Order::with('items.book')->find($orderId)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        <?php endif; ?>
<a href="<?php echo e(route('invoice.show', $order->id)); ?>" class="btn btn-primary" style="background-color: blue; color: white;">View Invoice</a>
<a href="<?php echo e(route('invoice.download', $order->id)); ?>" class="btn btn-primary" style="background-color: blue; color: white;">Download Invoice</a>

<a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary mt-3" style="background-color: blue; color: white;">Go Back to Home</a>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/stripe/success.blade.php ENDPATH**/ ?>