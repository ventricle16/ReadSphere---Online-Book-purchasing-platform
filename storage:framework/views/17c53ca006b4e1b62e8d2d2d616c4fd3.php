


<?php $__env->startSection('title', 'Manage Orders'); ?>


<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Manage Orders</h1>


    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-4 flex gap-2">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search orders..." class="border rounded px-3 py-2 flex-grow" />
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Statuses</option>
            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
            <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
            <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    </form>


    <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4 border-b">Order ID</th>
                <th class="py-2 px-4 border-b">User</th>
                <th class="py-2 px-4 border-b">Books Ordered</th>
                <th class="py-2 px-4 border-b">Total Amount</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Payment Method</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-4"><?php echo e($order->id); ?></td>
                <td class="py-2 px-4"><?php echo e($order->user->name ?? 'N/A'); ?></td>
                <td class="py-2 px-4"><?php echo e($order->items->sum('quantity')); ?></td>
                <td class="py-2 px-4">$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                <td class="py-2 px-4 capitalize"><?php echo e($order->status); ?></td>
                <td class="py-2 px-4"><?php echo e($order->payment_method); ?></td>
                <td class="py-2 px-4">
                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="text-blue-600 hover:underline">View</a> |
                    <a href="<?php echo e(route('admin.orders.edit', $order->id)); ?>" class="text-yellow-600 hover:underline">Edit</a> |
                    <form action="<?php echo e(route('admin.orders.destroy', $order->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:underline bg-transparent border-none p-0 m-0 cursor-pointer">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="py-4 px-4 text-center text-gray-500">No orders found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>


    <div class="mt-4">
        <?php echo e($orders->withQueryString()->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>