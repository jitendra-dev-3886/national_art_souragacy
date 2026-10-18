<?php $__env->startSection('content'); ?>
<section class="login-section py-5">
    <div class="login-page bg-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="shadow rounded py-5" style="background-color:#F0F8FF;">
                        <div class="row">
                            <div class="col-md-12 pe-0">
                                <div class="form-left h-100 py-3 px-5">
                                    <h3 class="mb-3">Admin Sign In</h3>
                                    <?php if(session('error')): ?>
                                        <div class="alert alert-danger">
                                            <?php echo e(session('error')); ?>

                                        </div>
                                    <?php elseif(session('status')): ?>
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
                                    
                                    <form action="<?php echo e(route('post.login')); ?>" id="loginform" class="row g-4" method="POST" autocomplete="off">
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
                                                <input type="hidden" name="iv" id="encryptionIv">
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
                                        <div class="col-12 d-flex justify-content-end mt-2">
                                                    <span class="mx-2"></span>
                                                    <a href="<?php echo e(route('admin_password.request')); ?>" class="text-decoration-none">Forgot Password</a>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary px-4 mt-4">Login</button>
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
<!-- <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/crypto-js.min.js')); ?>"></script>
<script nonce="<?php echo e($cspNonce); ?>">
document.getElementById('loginform').addEventListener('submit', function (e) {
    try {
        const passwordInput = document.getElementById('login-password');
        const password = passwordInput.value;

        const secretKey = "my_shared_secret_1234567890123456"; // 32 chars
        const key = CryptoJS.SHA256(secretKey); // ✅ consistent 256-bit key
        const iv = CryptoJS.lib.WordArray.random(16);
        const encrypted = CryptoJS.AES.encrypt(password, key, {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        });
        // Send raw ciphertext, not base64
        const ciphertextHex = encrypted.ciphertext.toString(CryptoJS.enc.Hex);
        const ivHex = iv.toString(CryptoJS.enc.Hex);
        document.getElementById('unknown_pwd').value = ciphertextHex;
        document.getElementById('encryptionIv').value = ivHex;

        passwordInput.disabled = true;

    } catch (err) {
        alert("Encryption error: " + err.message);
        e.preventDefault(); // stop form submission on error
    }
});

</script> -->

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
    </script>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/auth/login.blade.php ENDPATH**/ ?>