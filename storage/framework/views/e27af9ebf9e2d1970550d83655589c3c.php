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
            .csp-admin-shadow{
                background-color:#F0F8FF;
            }
            .csp-admin-margin-div{
                margin-top: 10px;
            }
        </style>
        <section class="login-section py-5">
            <div class="login-page bg-white py-5">
                <div class="container">
                    <div class="row">
                        
                        <?php if(session('error')): ?>
                        <?php endif; ?>
                        <div class="col-lg-6 offset-lg-3">
                            <div class="shadow rounded py-5 csp-admin-shadow">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">State Authority Sign In</h3>
                                            <?php if(session('status')): ?>
                                            <div class="alert alert-success">
                                                <?php echo e(session('status')); ?>

                                            </div>
                                            <?php elseif(session('message')): ?>
                                        <div id="warning-message" class="alert me-4 alert-warning csp-admin-margin-div">
                                            <?php echo e(session('message')); ?>


                                        </div>
                                            <?php endif; ?>
                                            <?php if($errors->any()): ?>
                                            <div class="alert alert-danger col-sm-12">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><?php echo e($error); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <form action="<?php echo e(route('admin.loginssaformdata')); ?>" id="loginform" class="row g-4" method="POST" autocomplete="off">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-12">
                                                    <label>Username<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                                        <input id="login-username" type="email" class="form-control"
                                                            name="email" placeholder="Enter email" value="<?php echo e(old('email')); ?>">
                                                    </div>
                                                </div>
        
                                                <div class="col-12">
                                                    <label>Password<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                                        <input type="password" id="login-password" class="form-control"
                                                            name="password" placeholder="Enter Password" autocomplete="new-password">
                                                        <input type="hidden" name="_password" id="encrypted_password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
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
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary px-4 mt-4">Login</button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end mt-2">
                                                    
                                                    
                                                    
                                                </div>
                                                
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
        <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jsencrypt.min.js')); ?>"></script>
        <script nonce="<?php echo e($cspNonce); ?>">
        document.addEventListener('DOMContentLoaded', function () {
            let PUBLIC_KEY = '';
            const form = document.getElementById('loginform');
            const passwordInput = document.getElementById('login-password');
            const encryptedInput = document.getElementById('encrypted_password');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Disable submit button until public key is loaded
            submitBtn.disabled = true;
            //url = '<?php echo e(url('publickey')); ?>';
            //alert(url);

            // Load public key from Laravel
            fetch('<?php echo e(url('publickey')); ?>', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch public key');
                    }
                    return response.text();
                })
                .then(key => {
                    PUBLIC_KEY = key.trim(); // remove extra whitespace/newlines
                    if (!PUBLIC_KEY.startsWith('-----BEGIN PUBLIC KEY-----')) {
                        throw new Error('Invalid public key format');
                    }
                    submitBtn.disabled = false;
                })
                .catch(err => {
                    console.error('Error loading public key:', err);
                    alert('Encryption setup failed. Please reload the page.');
                });

            // On form submit: encrypt password and disable plain input
            form.addEventListener('submit', function (e) {
                try {
                    if (!PUBLIC_KEY) {
                        alert('Encryption key not loaded yet. Please wait.');
                        e.preventDefault();
                        return;
                    }

                    const password = passwordInput.value;
                    if (!password) {
                        alert('Please enter your password.');
                        e.preventDefault();
                        return;
                    }

                    const encrypt = new JSEncrypt();
                    encrypt.setPublicKey(PUBLIC_KEY);

                    const encrypted = encrypt.encrypt(password);
                    if (!encrypted) {
                        alert('Password encryption failed.');
                        e.preventDefault();
                        return;
                    }

                    encryptedInput.value = encrypted;
                    passwordInput.disabled = true; // block plain-text from being submitted
                    //alert(encryptedInput.value);
                } catch (err) {
                    console.error('Encryption error:', err);
                    alert('An error occurred while encrypting the password.');
                    e.preventDefault();
                }
            });
        });
        </script>
        <?php $__env->stopSection(); ?>
        <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
        <script nonce="<?php echo e($cspNonce); ?>" type="text/javascript">
            $(document).ready(function(){
                $('#reload').click(function () {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo e(route('noc.reloadCaptcha')); ?>',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            </script>

            
        
    </body>
</html>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/loginssaform.blade.php ENDPATH**/ ?>