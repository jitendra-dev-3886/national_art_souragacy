        <!-- Styles -->
        
    
        


        
        <?php $__env->startSection('content'); ?>       
        <section class="py-5">
            <div class="container-fluid m-2">
                <div class="row">
                    <?php if(session('status')): ?>
                        <div class="col-md-6 offset-md-3 alert alert-success mt-3"><?php echo e(session('status')); ?></div>
                    <?php endif; ?>
                    
                </div>
                <div class="row">
                    <div class="card col-md-3">
                        <div class="card-body">
                            <p>Step to be taken for registration under the National Assisted Reproductive Technology
                                and Surrogacy Registry.</p>
                            <ul>
                                <li>
                                    <p>First signup (top on right side) for creating account of the ART Clinic/Bank
                                        & Surrogacy Clinic.</p>
                                </li>
                                <li>
                                    <p>After signup, click on the link in the email sent by the National Assisted
                                        Reproductive Technology and Surrogacy Registry.</p>
                                </li>
                                <li>
                                    <p>Click on login (top on right side) and enter the registered email as User ID
                                        and Password</p>
                                </li>
                                <li>
                                    <p>Fill all details as per selected application form.</p>
                                </li>
                                <li>
                                    <p>After submission, the PDF printout of the filled-in application form duly 
                                        signed by the authorized signatory/ competent authority (with name & contact details) 
                                        on behalf of the clinic/bank, shall be submitted electronically or by registered post 
                                        or in-person to the Appropriate Authority under the Assisted Reproductive Technology 
                                        (Regulation) Act, 2021 and The Surrogacy (Regulation) Act, 2021 through the office of 
                                        Additional Chief Secretary (Health)/ Additional Secretary (Health)/ Principal Secretary 
                                        (Health)/ Secretary (Health)/ Joint Secretary (Health) of the respective State/UT 
                                        Government, <b>within 07 days of online submission of the form alongwith the prescribed fees.</b>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <style nonce="<?php echo e($cspNonce); ?>">
                        .csp-bg-blue { background-color:#00c0ef !important; }
                        .csp-bg-lightblue { background-color:#00A3CB; }
                        .csp-font-xl { font-size:100px; }
                        .csp-bg-orange { background-color:#F39C12 !important; }
                        .csp-bg-darkorange { background-color:#CF850F; }
                        .csp-bg-red { background-color:#DD4B39 !important; } 
                        .csp-bg-darkred { background-color:#BC4031; }
                    </style>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-blue">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong> <?php echo e(dashboardHelper::countClinic()); ?> </strong></h3>
                                                <h2 class="text-white">ART Clinic</h2>
                                                <p class="text-white"><b>Total Application RECEIVED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-hospital-o opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-lightblue">
                                        <p class="text-dark text-center py-1">
                                            <a href="#" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ART Clinic REGISTERED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-blue">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e($clinic ?? 0); ?></strong></h3>
                                                <h2 class="text-white">ART Clinic</h2>
                                                <p class="text-white"><b>Total Application REGISTERED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-hospital-o opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-lightblue">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'register-clinic'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ART Clinic REJECTED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-blue">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e(dashboardHelper::countClinic('Registration Rejected') + $re_artclinic); ?></strong></h3>
                                                <h2 class="text-white">ART Clinic</h2>
                                                <p class="text-white"><b>Total Application REJECTED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-hospital-o opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-lightblue">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'reject-clinic'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ART Bank RECEIVED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-orange">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e(dashboardHelper::countBank()); ?> </strong></h3>
                                                <h2 class="text-white">ART Bank</h2>
                                                <p class="text-white"><b>Total Application RECEIVED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-home opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkorange">
                                        <p class="text-dark text-center py-1">
                                            <a href="#" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ART Bank REGISTERED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-orange">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e($bank ?? 0); ?></strong></h3>
                                                <h2 class="text-white">ART Bank</h2>
                                                <p class="text-white"><b>Total Application REGISTERED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-home opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkorange">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'register-bank'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- ART Bank REJECTED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-orange">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e(dashboardHelper::countBank('Registration Rejected') + $re_artbank); ?></strong></h3>
                                                <h2 class="text-white">ART Bank</h2>
                                                <p class="text-white"><b>Total Application REJECTED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-home opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkorange">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'reject-bank'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Surrogacy Clinic RECEIVED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-red">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e(dashboardHelper::countSurrogacy()); ?></strong></h3>
                                                <h2 class="text-white">Surrogacy Clinic</h2>
                                                <p class="text-white"><b>Total Application RECEIVED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-bank opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkred">
                                        <p class="text-dark text-center py-1">
                                            <a href="#" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Surrogacy Clinic REGISTERED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-red">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e($surrogacy ?? 0); ?>  </strong></h3>
                                                <h2 class="text-white">Surrogacy Clinic</h2>
                                                <p class="text-white"><b>Total Application REGISTERED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-bank opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkred">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'register-surrogacy'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Surrogacy Clinic REJECTED -->
                            <div class="col-xl-4 col-md-6">
                                <div class="card-tiles rounded csp-bg-red">
                                    <div class="card-block p-2">
                                        <div class="row align-items-center py-2">
                                            <div class="col-8">
                                                <h3 class="text-white"><strong><?php echo e(dashboardHelper::countSurrogacy('Registration Rejected') + $re_surrogacy); ?></strong></h3>
                                                <h2 class="text-white">Surrogacy Clinic</h2>
                                                <p class="text-white"><b>Total Application REJECTED</b></p>
                                            </div>
                                            <div class="col-md-2 text-right">
                                                <i class="fa fa-bank opacity-25 csp-font-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="csp-bg-darkred">
                                        <p class="text-dark text-center py-1">
                                            <a href="<?php echo e(route('clinic.list', ['type' => 'reject-surrogacy'])); ?>" class="small-box-footer text-decoration-none text-white">
                                                More info <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!--end row-->
                            <div class="clearfix visible-sm-block"></div>
                        </div>
                    </div>
                </div>

        </section>
        <?php $__env->stopSection(); ?>
        <script nonce="<?php echo e($cspNonce); ?>" src="<?php echo e(url('public/js/jquery-3.6.0.min.js')); ?>"></script>
       
        
            <script nonce="<?php echo e($cspNonce); ?>" nonce="<?php echo e($cspNonce); ?>">
                 $(document).ready(function(){
                $('#pincode').blur(function() {
                    //console.log('check 1');
                    var pincode = $(this).val();
                    if (pincode === "") {
                        $('#state').val('');
                        $('#district').val('');
                        $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                    } else {
                        $.ajax({
                            url: "<?php echo e(route('pincode.check')); ?>", // Laravel route
                            method: "POST",
                            data: {
                                pincode: pincode,
                                _token: "<?php echo e(csrf_token()); ?>" // CSRF token for security
                            },
                            success: function(data) {
                                if (data.success) {
                                    $('#state').val(data.state);
                                    $('#district').val(data.district);
                                    $('#pincodeavailability').html('');
                                } else {
                                    $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                    $('#state').val('');
                                    $('#district').val('');
                                }
                            }
                        });
                    }
                });
            });
            </script>

            


        
    

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/dashboard.blade.php ENDPATH**/ ?>