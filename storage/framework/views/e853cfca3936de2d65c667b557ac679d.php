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
            .csp-clinic-shadow{
                background-color:#F0F8FF;
            }
        </style>
        <section class="login-section py-5">
            <div class="login-page bg-white py-5">
                <div class="container">
                    <div class="row">
                        
                        <?php if(session('error')): ?>
                        <?php endif; ?>
                        <div class="col-lg-6 offset-lg-3">
                            <div class="shadow rounded py-5 csp-clinic-shadow" >
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h3 class="mb-3">Forget password</h3>
                                            <!-- Display success message -->
                                            <?php if(session('status')): ?>
                                            <div class="alert alert-success">
                                                <?php echo e(session('status')); ?>

                                            </div>
                                            <?php endif; ?>
                                            <?php if($errors->any()): ?>
                                            <div class="alert alert-danger col-sm-12">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><?php echo e($error); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <form id="forgetpwd" action="<?php echo e(route('admin_password.email')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="email">Email Address</label>
                                                    <input type="email" name="email" id="email" class="form-control" required>
                                                    <small id="emailError" style="color:red;"></small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" name="username" id="username" class="form-control" required>
                                                    <small id="usernameError" style="color:red;"></small>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <div class="captcha d-inline-flex d-flex">
                                                        <span><?php echo captcha_img(); ?></span>
                                                        <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                            &#x21bb;
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
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
                                                <button type="submit" class="btn btn-primary mt-3">Send Reset Link</button>
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
                    url: '<?php echo e(route('admin.adminreloadCaptcha')); ?>',
                    success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
            })
            document.addEventListener("DOMContentLoaded", function () {

                const forgetpwdform = document.getElementById("forgetpwd");
                const emailInput = document.getElementById("email");
                const usernameInput = document.getElementById("username");
                const emailError = document.getElementById("emailError");
                const usernameError = document.getElementById("usernameError");
                // Email validation function
                function validateEmail() {
                    const emailValue = emailInput.value.trim();
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (emailValue === "") {
                        emailError.textContent = "Email is required.";
                        emailInput.classList.add("is-invalid");
                        return false;
                    }

                    if (!emailPattern.test(emailValue)) {
                        emailError.textContent = "Please enter a valid email address.";
                        emailInput.classList.add("is-invalid");
                        return false;
                    }
                    emailError.textContent = "";
                    emailInput.classList.remove("is-invalid");
                    emailInput.classList.add("is-valid");
                    return true;
                }
                // Username validation function
                function validateUsername() {
                        const usernameInput = document.getElementById("username");
                        const usernameError = document.getElementById("usernameError");
                        const usernameValue = usernameInput.value.trim();
                        // Allow letters, numbers, space, dot, underscore
                        const usernamePattern = /^[a-zA-Z0-9._ ]{4,30}$/;
                        if (usernameValue === "") {
                            usernameError.textContent = "Username is required.";
                            usernameInput.classList.add("is-invalid");
                            return false;
                        }
                        if (!usernamePattern.test(usernameValue)) {
                            usernameError.textContent =
                                "Username can contain letters, numbers, spaces, dot (.), and underscore (_) only.";
                            usernameInput.classList.add("is-invalid");
                            return false;
                        }
                        usernameError.textContent = "";
                        usernameInput.classList.remove("is-invalid");
                        usernameInput.classList.add("is-valid");
                        return true;
                    }
                // Real-time validation
                emailInput.addEventListener("input", validateEmail);
                usernameInput.addEventListener("input", validateUsername);
                // On form submit
                forgetpwdform.addEventListener("submit", function (e) {
                    const isEmailValid = validateEmail();
                    const isUsernameValid = validateUsername();
                    if (!isEmailValid || !isUsernameValid) {
                        e.preventDefault(); // stop submission
                    }
                });
            });
            </script>
            
    </body>
</html>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/forget_password.blade.php ENDPATH**/ ?>