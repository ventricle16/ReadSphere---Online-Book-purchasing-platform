<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #<?php echo e($order->id); ?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>📚 ReadSphere - Invoice</h2>
    <p><strong>Invoice ID:</strong> #<?php echo e($order->id); ?></p>
    <p><strong>User:</strong> <?php echo e($order->user->name); ?></p>
    <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
    <p><strong>Date:</strong> <?php echo e($order->created_at->format('d M, Y')); ?></p>

    <table>
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
                <td colspan="3"><strong>Grand Total After Discount:</strong></td>
                <td><strong>$ <?php echo e(number_format($order->amount, 2)); ?></strong></td>

            </tr>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\readsphere\resources\views/invoice/pdf.blade.php ENDPATH**/ ?>