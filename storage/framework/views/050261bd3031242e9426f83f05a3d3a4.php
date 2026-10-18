        <!-- Styles -->
        
    
        


        
        <?php $__env->startSection('content'); ?>
<style nonce="<?php echo e($cspNonce); ?>">

.csp-clinic-shadow{
                background-color:#F0F8FF;
            }
          
.csp-clinic-button-danger {
    width: 93px;
}
.csp-clinic-gap{
border-top: 1px solid#888;
padding-top:15px;
font-size:85%
}

    </style>


        <section class="login-section py-2">
            <div class="login-page bg-white py-2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="shadow rounded py-2 csp-clinic-shadow">
                                <div class="row">
                                    <div class="col-md-12 pe-0">
                                        <div class="form-left h-100 py-3 px-5">
                                            <h4 class="card-title text-center mb-4" >Sign-up Form</h4>
                                            
                                            
                                            <?php if($errors->any()): ?>
                                            <div class="alert alert-danger col-sm-12">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div><?php echo e($error); ?></div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php endif; ?>
                                            
                                            <form action="<?php echo e(route('clinic.request_signup_data')); ?>" id="loginform" class="well form-horizontal" method="POST">
                                                <?php echo csrf_field(); ?>
                                               
                                               
                                                
                                                    <!-- <form class="form-valide-with-icon needs-validation" novalidate> -->
                                                        <div class="mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic)*</strong></label>
                                                            <div class="input-group">
                                                                <input id="clinicname" name="clinicname" pattern="[A-Za-z0-9 &()]*" placeholder="Name of Health Facility" class="form-control" type="text" autocomplete="off">
                                                                <?php $__errorArgs = ['clinicname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="mb-3">
                                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Address of the Organisation*</strong></label>
                                                            <div class="input-group">
                                                                <input name="address" id="address" placeholder="Address" class="form-control" type="text" autocomplete="off">
                                                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        </div>
                                                    

                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="pincode"><strong>Pincode *</strong></label>
                                                                <div class="input-group" >
                                                                    <input type="text" pattern="^[0-9]{6}$" name="pincode" maxlength="6" id="pincode" class="form-control">
                                                                    <span id="pincodeavailability"></span>
                                                                </div>
                                                                
                                                                   <?php $__errorArgs = ['pincode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                            
                                                        
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="state"><strong>State</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" name="state" id="state" placeholder="State" class="form-control" readonly>
                                                                    <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>                                                           
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="district"><strong>District</strong></label>
                                                                <div class="input-group" id="district-container">
                                                                    <input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />
                                                                </div>                                                       
                                                                   <?php $__errorArgs = ['district'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                            <div class="col-md-6 mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                                <label class="text-label form-label" for="natures"><strong>Nature*</strong></label>
                                                                <div class="input-group">
                                                                    <select name="nature" id="nature" class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="Government">Government</option>
                                                                        <option value="Private">Private</option>
                                                                    </select>
                                                                    <?php $__errorArgs = ['nature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3 <?php //echo (!empty($user_name_err)) ? 'has-error' : ''; ?>">
                                                                <label class="text-label form-label" for="contactno"><strong>Contact Number of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input name="contactno" id="contactno" placeholder="contact number should be 11 numbers" class="form-control" pattern="^[0-9]{11}$" maxlength="11" type="text">
                                                                    <?php $__errorArgs = ['contactno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email"><strong>Email Address of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control border-left-end" name="email" id="email" value="<?php echo e(old('email')); ?>" placeholder="Enter an email.." >
                                                                </div>
                                                                <div id="availability" class="mt-2"></div>
                                                                   <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email"><strong>Verify Email Address of the Organisation *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control border-left-end" name="v_email" id="v_email" value="<?php echo e(old('v_email')); ?>" placeholder="Verify your email.." >
                                                                  </div>  
                                                                    <div id="error_email_org" class="text-danger small"></div>
                                                                    <?php $__errorArgs = ['v_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                        
                                                            <!-- Mobile Number Section -->
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="personname"><strong>Name of the Contact Person *</strong></label>
                                                                <div class="input-group">
                                                                    <input id="personname" name="personname" placeholder="Name of contact Person" class="form-control" type="text"
                                                                    pattern="[A-Za-z ]*" title="Only alphabetic characters are allowed">
                                                                    <?php $__errorArgs = ['personname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="mobileno"><strong>Mobile Number *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control border-left-end" name="mobile" id="mobile" value="<?php echo e(old('mobile')); ?>" placeholder="Enter a mobile number.." pattern="^[0-9]{10}$" maxlength="10" title="This is not a valid 10-digit mobile number">
                                                                    <?php $__errorArgs = ['mobileno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-4 mb-3">
                                                                <label class="text-label form-label" for="v_mobileno"><strong>Verify Mobile Number *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control border-left-end" name="v_mobile" id="v_mobile" value="<?php echo e(old('v_mobile')); ?>" placeholder="Verify your mobile number.." pattern="^[0-9]{10}$" maxlength="10" title="This is not a valid 10-digit mobile number">
                                                                    </div>
                                                                    <div id="error_v_mobile_contact_person" class="text-danger small"></div>
                                                                    <?php $__errorArgs = ['v_mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>
                                                            <!-- email of contact person Section -->
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="email_contact_person"><strong>Email Address *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control <?php $__errorArgs = ['email_contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email_contact_person" id="email_contact_person" value="<?php echo e(old('email_contact_person')); ?>" placeholder="Enter a email address..">
                                                                    <?php $__errorArgs = ['email_contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                                </div>
                                                            </div>
                                                        
                                                            <div class="col-md-6 mb-3">
                                                                <label class="text-label form-label" for="v_email_contact_person"><strong>Verify Email Address *</strong></label>
                                                                <div class="input-group">
                                                                    <input type="email" class="form-control <?php $__errorArgs = ['error_v_email_contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="v_email_contact_person" id="v_email_contact_person" value="<?php echo e(old('v_email_contact_person')); ?>" placeholder="Verify your email address." >
                                                                    </div>  
                                                                    <div id="error_v_email_contact_person" class="text-danger small"></div>
                                                                    <?php $__errorArgs = ['v_email_contact_person'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            </div>

                                                            <!-- end the email verify -->
                                                            <div class="form-group mb-2">
                                                                <div class="captcha d-inline-flex d-flex">
                                                                    <span><?php echo captcha_img(); ?></span>
                                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                                        &#x21bb;
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-2">
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
                                                        </div>
                                                        
                                                                                        <input type="submit" class="btn btn-primary light" id="submitBtn" value="Submit">
                                                                                     
                                                                                        <button type="submit" class="btn btn-danger light csp-clinic-button-danger">Cancel</button>

                                                                                        <div class="gap-2 mt-2 csp-clinic-gap" >


                                                                                            
                                                                Already have an account! |
                                                                <a href="<?php echo e(route('clinic.loginclinicform')); ?>" class="text-dark text-decoration-none"
                                                                  id="showSignupLink">
                                                                    Login Here
                                                                </a>
                                                                <a href="<?php echo e(route('clinic.resendLink')); ?>" class="text-dark text-decoration-none">| Resend Verification Link</a>
                                                                
                                                                
                                                                
                                                                
             
                                                                
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

 <script nonce="<?php echo e($cspNonce); ?>">
document.addEventListener('DOMContentLoaded', function () {
    const link = document.getElementById('showSignupLink');

    if (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // prevent the link from navigating
            document.getElementById('loginbox')?.style.display = 'none';
            document.getElementById('signupbox')?.style.display = 'block';
        });
    }
});
</script>

           <script nonce="<?php echo e($cspNonce); ?>">
document.addEventListener('DOMContentLoaded', function () {
    // Attach input event listeners
    document.getElementById("v_email").addEventListener("input", function() {
        checkRealtimeValue(this);
    });

    document.getElementById("v_email_contact_person").addEventListener("input", function() {
        checkRealtimeValue(this);
    });

    document.getElementById("v_mobile").addEventListener("input", function() {
        checkRealtimeValue(this);
    });
});

function checkRealtimeValue(input) {
    let first_value, second_value, value_err, msg;

    if (input.id === "v_email") {
        first_value = document.getElementById("email").value;
        second_value = input.value;
        value_err = document.getElementById("error_email_org");
        msg = "Organization Email does not match";
    } else if (input.id === "v_email_contact_person") {
        first_value = document.getElementById("email_contact_person").value;
        second_value = input.value;
        value_err = document.getElementById("error_v_email_contact_person");
        msg = "Contact person Email do not match";
    } else if (input.id === "v_mobile") {
        first_value = document.getElementById("mobile").value;
        second_value = input.value;
        value_err = document.getElementById("error_v_mobile_contact_person");
        msg = "Contact person Mobile no do not match";
    }

    if (first_value !== second_value) {
        value_err.innerHTML = msg;
        input.setCustomValidity(msg);
    } else {
        value_err.innerHTML = "";
        input.setCustomValidity("");
    }
}
</script>

            </script>
             <script nonce="<?php echo e($cspNonce); ?>">
                $(document).ready(function () {
                    $('#pincode').blur(function () {
                        var pincode = $(this).val();
                        if (pincode === "") {
                            $('#state').val('');
                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                        } else {
                            $.ajax({
                                url: "<?php echo e(route('pincode.signup')); ?>",
                                method: "POST",
                                data: {
                                    pincode: pincode,
                                    _token: "<?php echo e(csrf_token()); ?>"
                                },
                                success: function (data) {
                                    if (data.success) {
                                        $('#state').val(data.state);
                                        $('#pincodeavailability').html('');

                                        if (data.districts.length > 1) {
                                            
                                            // If multiple districts, show dropdown
                                            let districtDropdown = '<select name="district" id="district" class="form-control">';
                                            //    console.log(districtDropdown);
                                            districtDropdown += '<option value="">Select District</option>';
                                            data.districts.forEach(district => {
                                                districtDropdown += `<option value="${district}">${district}</option>`;
                                            });
                                            districtDropdown += '</select>';
                                            $('#district-container').html(districtDropdown);
                                        } else if (data.districts.length === 1) {
                                            // If only one district, show input field
                                            $('#district-container').html(`<input type="text" name="district" id="district" value="${data.districts[0]}" class="form-control" readonly />`);
                                        } else {
                                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                                            $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                        }
                                    } else {
                                        $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                        $('#state').val('');
                                        $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error:', error);
                                    console.log('Response Text:', xhr.responseText);
                                }
                            });
                        }
                    });
                });
        </script>
            
        
            <script nonce="<?php echo e($cspNonce); ?>">
                document.addEventListener("DOMContentLoaded", function() {
                    let inputs = document.querySelectorAll("input");
            
                    inputs.forEach(input => {
                        input.addEventListener("keypress", function(event) {
                            let char = String.fromCharCode(event.which);
                            if (char === "<" || char === ">") {
                                alert("'<>' characters are not allowed!");
                                event.preventDefault();
                            }
                        });
                    });
                });
            
                function validateInput() {
                    let inputs = document.querySelectorAll("input");
            
                    for (let input of inputs) {
                        if (input.value.includes("<") || input.value.includes(">")) {
                            alert("'<>' characters are not allowed in input fields!");
                            input.focus();
                            return false;
                        }
                    }
            
                    return true;
                }
            </script>

            
          <script nonce="<?php echo e($cspNonce); ?>">
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("loginform");

        form.addEventListener("submit", function (e) {
            if (!validation()) {
                e.preventDefault(); // Stop form from submitting
            }
        });

        function validation() {
            if (document.getElementById("clinicname").value == "") {
                alert("Name of Health Facility (ART Clinic/ ART Bank/ Surrogacy Clinic) cannot be blank");
                document.getElementById("clinicname").focus();
                return false;
            }
            if (document.getElementById("address").value == "") {
                alert("Address of the Organisation cannot be blank");
                document.getElementById("address").focus();
                return false;
            }
            if (document.getElementById("pincode").value == "") {
                alert("Pincode cannot be blank");
                document.getElementById("pincode").focus();
                return false;
            }
            if (document.getElementById("nature").value == "") {
                alert("Nature of the Organisation cannot be blank");
                document.getElementById("nature").focus();
                return false;
            }
            if (document.getElementById("contactno").value == "") {
                alert("Contact Number of the Organisation cannot be blank");
                document.getElementById("contactno").focus();
                return false;
            }
            if (document.getElementById("email").value == "") {
                alert("Email Address cannot be blank");
                document.getElementById("email").focus();
                return false;
            }
            if (document.getElementById("v_email").value == "") {
                alert("Verify Email Address cannot be blank");
                document.getElementById("v_email").focus();
                return false;
            }

            const email = document.getElementById("email");
            const vEmail = document.getElementById("v_email");

            if (email.value !== vEmail.value) {
                vEmail.classList.add("is-invalid");
                alert("Email and Verify Email must match.");
                vEmail.focus();
                return false;
            } else {
                vEmail.classList.remove("is-invalid");
            }

            if (document.getElementById("personname").value == "") {
                alert("Name of the Contact Person cannot be blank");
                document.getElementById("personname").focus();
                return false;
            }
            if (document.getElementById("mobile").value == "") {
                alert("Mobile Number cannot be blank");
                document.getElementById("mobile").focus();
                return false;
            }
            if (!/^[0-9]+$/.test(document.getElementById("mobile").value)) {
                alert("Mobile Number should be numeric");
                document.getElementById("mobile").focus();
                return false;
            }
            if (document.getElementById("v_mobile").value == "") {
                alert("Verify Mobile Number cannot be blank");
                document.getElementById("v_mobile").focus();
                return false;
            }
            if (!/^[0-9]+$/.test(document.getElementById("v_mobile").value)) {
                alert("Verify Mobile Number should be numeric");
                document.getElementById("v_mobile").focus();
                return false;
            }

            const mobileNo = document.getElementById("mobile");
            const vMobileNo = document.getElementById("v_mobile");

            if (mobileNo.value !== vMobileNo.value) {
                vMobileNo.classList.add("is-invalid");
                alert("Mobile Number and Verify Mobile Number must match.");
                vMobileNo.focus();
                return false;
            } else {
                vMobileNo.classList.remove("is-invalid");
            }

            const emailContact = document.getElementById("email_contact_person");
            const vEmailContact = document.getElementById("v_email_contact_person");

            if (emailContact.value == "") {
                alert("Email Address of the contact person cannot be blank");
                emailContact.focus();
                return false;
            }
            if (vEmailContact.value == "") {
                alert("Verify Email Address of the contact person cannot be blank");
                vEmailContact.focus();
                return false;
            }

            if (emailContact.value !== vEmailContact.value) {
                vEmailContact.classList.add("is-invalid");
                alert("Email of contact person and Verify email must match.");
                vEmailContact.focus();
                return false;
            } else {
                vEmailContact.classList.remove("is-invalid");
            }

            const captchaInput = document.getElementById("captcha").value;
            if (captchaInput.trim() === "") {
                alert("CAPTCHA cannot be blank");
                document.getElementById("captcha").focus();
                return false;
            }

            const agree = confirm("Kindly check and confirm all details before final submission.");
            return agree;
        }
    });
</script>

             <script nonce="<?php echo e($cspNonce); ?>">
                $(document).on('blur', '#email', function () {
           // $('#email').blur(function () {
                //alert('fgfd');
                //console.log('check 1');
                var email = $(this).val();
                //console.log(email);
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            
                if (email == "") {
                    $('#availability').html('');
                } else {
                    $.ajax({
                        url: '<?php echo e(route('clinic.checkEmail')); ?>', // Laravel route
                        method: "POST",
                        data: {
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                        success: function (response) {
                            if (response.status === 'exists') {
                                $('#availability').html(
                                    '<span class="text-danger">Email ID already exists with NARTSR. Please use the another email ID.</span>'
                                );
                                $('#submitBtn').attr("disabled", true);
                            } else if (!regex.test(email)) {
                                $('#availability').html(
                                    '<span class="text-danger">Please enter a valid email id</span>'
                                );
                            } else {
                                $('#availability').html(
                                    '<span class="text-success">Email available for submission of application form.</span>'
                                );
                                $('#submitBtn').attr("disabled", false);
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
            
        </script>


        
    

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/signup.blade.php ENDPATH**/ ?>