<?php $__env->startSection('title', '403 Server Error'); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('message'); ?>
    <?php echo e($message ?? 'Access denied.'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('error_ref'); ?>
    <?php if(isset($error_ref)): ?>
        <p class="mt-4 text-sm text-gray-600">
            Error Reference:
            <span class="font-mono text-red-600"><?php echo e($error_ref); ?></span>
        </p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.fancy', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/errors/403.blade.php ENDPATH**/ ?>