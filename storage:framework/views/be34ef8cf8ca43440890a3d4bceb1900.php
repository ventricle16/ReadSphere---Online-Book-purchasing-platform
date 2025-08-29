

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Manage Books</h5>
                    <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">Add New Book</a>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>Price</th>
                                    <th>Rating</th>   <!-- ⭐ Added new column -->
                                    <th>Featured</th>
                                    <th>Active</th>
                                    <th>Wishlist Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <?php if($book->cover_url): ?>
                                                <img src="<?php echo e(Storage::url($book->cover_url)); ?>" alt="<?php echo e($book->title); ?>" style="width: 50px; height: 75px; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 50px; height: 75px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                    <small>No Cover</small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($book->title); ?></td>
                                        <td><?php echo e($book->author); ?></td>
                                        <td><?php echo e($book->genre); ?></td>
                                        <td>$<?php echo e(number_format($book->price, 2)); ?></td>

                                        <!-- ⭐ Show rating -->
                                        <td>
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $book->rating): ?>
                                                    ⭐
                                                <?php else: ?>
                                                    ☆
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </td>

                                        <td>
                                            <span class="badge badge-<?php echo e($book->is_featured ? 'success' : 'secondary'); ?>">
                                                <?php echo e($book->is_featured ? 'Yes' : 'No'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo e($book->is_active ? 'success' : 'danger'); ?>">
                                                <?php echo e($book->is_active ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </td>
                                        
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.books.edit', $book)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="<?php echo e(route('admin.books.destroy', $book)); ?>" method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        <?php echo e($books->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/admin/books/index.blade.php ENDPATH**/ ?>