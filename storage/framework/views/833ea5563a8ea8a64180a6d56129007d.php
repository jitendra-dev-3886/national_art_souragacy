<?php $__env->startSection('content'); ?>

<style nonce="<?php echo e($cspNonce); ?>">
    .csp-clinic-alert-primary {
        background-color: #0b5ed7c7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-alert-primary h4 {
        color: white;
    }

    .csp-clinic-btn-view {
        background-color: #0b49f9;
        border-color: #0b5ed7;
        color: white;
    }
</style>


<div class="container mt-5">
    <div class="alert alert-primary csp-clinic-alert-primary">
        <?php if(Session()->has('success')): ?>
            <h4><?php echo e(session('success')); ?></h4>
        <?php endif; ?>

        <p><strong>Application Number:</strong> <?php echo e($appNo); ?></p>

      
       <a href="<?php echo e(route('change_address.application.view', ['encryptedId' => Crypt::encryptString($application->id)])); ?>">
    <i class="fas fa-eye"></i> View Application
</a>

    </div>
</div>


        
        
        

        
        
        
    
 
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/changes_success.blade.php ENDPATH**/ ?>