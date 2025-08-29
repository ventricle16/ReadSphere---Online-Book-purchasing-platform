

<?php $__env->startSection('content'); ?>
<h1><?php echo e($user->name); ?></h1>
<p><?php echo e($user->bio); ?></p>
<form method="POST" action="<?php echo e($user->id ? route('users.update', $user->id) : '#'); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <input type="text" name="name" placeholder="Name" value="<?php echo e($user->name); ?>">
    <textarea name="bio" placeholder="Bio"><?php echo e($user->bio); ?></textarea>
    <button type="submit">Update</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/users/profile.blade.php ENDPATH**/ ?>