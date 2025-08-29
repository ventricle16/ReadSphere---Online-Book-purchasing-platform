<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books - ReadSphere</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
    <div class="container">
        <h1>Books</h1>
        
        <div class="grid">
            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card">
                    <img src="<?php echo e($book->cover_url); ?>" alt="<?php echo e($book->title); ?>">
                    <h2><?php echo e($book->title); ?></h2>
                    <p>Author: <?php echo e($book->author); ?></p>
                    <p>Genre: <?php echo e($book->genre); ?></p>
                    <div class="card-actions">
                        <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-primary">View Details</a>
                        <a href="<?php echo e(route('books.preview', $book->id)); ?>" class="btn btn-info">Preview</a>
                        <form action="<?php echo e(route('books.addToWishlist', $book->id)); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary">Add to Wishlist</button>
                        </form>
                        
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php echo e($books->links()); ?> <!-- Pagination links -->
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\readsphere\resources\views/books/index.blade.php ENDPATH**/ ?>