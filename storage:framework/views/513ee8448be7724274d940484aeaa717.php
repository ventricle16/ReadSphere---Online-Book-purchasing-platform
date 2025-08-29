

<?php $__env->startSection('content'); ?>
<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center">📚 ReadSphere - Invoice</h2>
        <p><strong>Invoice ID:</strong> #<?php echo e($order->id); ?></p>
        <p><strong>User:</strong> <?php echo e($order->user->name); ?></p>
        <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
        <p><strong>Date:</strong> <?php echo e($order->created_at->format('d M, Y')); ?></p>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <div>
                <div><strong>Subtotal:</strong> $<?php echo e(number_format($subtotal, 2)); ?></div>
                
                <div style="color: green;">
                    <strong>Discount</strong> -$<?php echo e(number_format($discountAmount, 2)); ?>

                </div>    
                <div><strong>Shipping:</strong> <?php echo e($shipping); ?></div>
                <div><strong>Tax (8%):</strong> $<?php echo e(number_format($tax, 2)); ?></div>
                <div><strong>Total After Discount:</strong> $<?php echo e(number_format($order->amount, 2)); ?></div>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Qty</th>
                    <th>Price ($)</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->book->title); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td><?php echo e(number_format($item->price, 2)); ?></td>
                    <td><?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                <tr>
                    <td colspan="3" class="text-end"><strong>Grand Total After Discount:</strong></td>
                    <td><strong>$ <?php echo e(number_format($order->amount, 2)); ?></strong></td>

                </tr>
            </tbody>
        </table>

        <div class="mt-4 text-center">
            <a href="<?php echo e(route('invoice.download', $order->id)); ?>" class="btn btn-primary">
                Download Invoice (PDF)
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/invoice/show.blade.php ENDPATH**/ ?>