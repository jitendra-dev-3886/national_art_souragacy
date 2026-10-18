<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>National ART & Surrogacy Portal</title> 
    </head>
    <body class="antialiased">
        
        <?php $__env->startSection('content'); ?>
                    
            <style nonce="<?php echo e($cspNonce); ?>">
                .csp-clinic-shadow-box {
                    background-color: #F0F8FF;
                }
            </style>

        <section class="login-section py-5">
            <div class="login-page bg-white py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                                
                                <div class="shadow rounded py-5 csp-clinic-shadow-box">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">Send Verification Link</h3>

                                            <!-- Display success message -->
                                            <?php if(session('success')): ?>
                                            <div class="alert alert-success">
                                                <?php echo e(session('success')); ?>

                                            </div>
                                            <?php elseif(session('failure')): ?>
                                            <div class="alert alert-danger">
                                                <?php echo e(session('failure')); ?>

                                            </div>
                                            <?php endif; ?>
                                            <?php if($errors->any()): ?>
                                            <div class="alert alert-danger col-sm-12">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><?php echo e($error); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <form action="<?php echo e(route('clinic.resendVerificationEmail')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="text" name="email" id="email" class="form-control" required>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <div class="captcha d-inline-flex d-flex">
                                                        <span><?php echo captcha_img(); ?></span>
                                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                            &#x21bb;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-4">
                                                    <input id="captcha" type="text" class="form-control <?php $__errorArgs = ['captcha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                                    <?php if($errors->has('captcha')): ?>
                                                            <span class="text-danger"><?php echo e($errors->first('captcha')); ?></span>
                                                        <?php endif; ?>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">submit </button>
                                            </form>
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php $__env->stopSection(); ?>
         <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
        <script nonce="<?php echo e($cspNonce); ?>" type="text/javascript">
            $(document).ready(function(){
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo e(route('clinic.reloadCaptcha')); ?>',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>

        
    </body>
</html>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/resend-verification-link.blade.php ENDPATH**/ ?>