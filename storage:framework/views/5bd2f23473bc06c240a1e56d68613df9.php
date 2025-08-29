

<?php $__env->startSection('content'); ?>
<div style="max-width: 400px; margin: 50px auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px #ccc;">
    <h2 style="text-align: center; margin-bottom: 20px;">Readsphere</h2>
    <p style="text-align: center; margin-bottom: 20px;">Sign in to start your session</p>

    <?php if(session('error')): ?>
        <div style="color: red; margin-bottom: 10px;"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div style="margin-bottom: 15px;">
            <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" style="width: 100%; padding: 10px; box-sizing: border-box;" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: red;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div style="margin-bottom: 15px;">
            <input type="password" name="password" placeholder="Password" style="width: 100%; padding: 10px; box-sizing: border-box;" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: red;"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <button type="submit" style="width: 100%; background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 3px;">Login</button>
    </form>

    <p style="margin-top: 15px; text-align: center;">
        <a href="#" style="color: #007bff; text-decoration: none;">I forgot my password</a>
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\readsphere\resources\views/auth/login.blade.php ENDPATH**/ ?>