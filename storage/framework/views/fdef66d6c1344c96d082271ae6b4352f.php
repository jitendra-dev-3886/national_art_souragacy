Sidebar start
***********************************-->

<?php
    use App\Models\renewal\RenewalSCApplication;
    use App\Models\ChangeAddress\ChangeAddressApplication;

    use App\Models\clinic\ClinicWithdrawal;
    use App\Models\clinic\ClinicRevocation;
    use App\Models\clinic\ClinicRegistrationModel;



    use App\Models\ChangeManpower\ChangeManpowerApplication;

    $stateName = session('state_name');

    // Fetch clinic types from both tables (distinct to avoid duplicates)
    $renewalClinics = RenewalSCApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $changeAddressClinics = ChangeAddressApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $withdrawalClinics = ClinicWithdrawal::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $changeManpowserClinics = ChangeManpowerApplication::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicForSuspension = ClinicRegistrationModel::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicForRevocation = ClinicRevocation::where('state', $stateName)
        ->where('status', 1)
        ->distinct()
        ->pluck('clinic_type')
        ->toArray();

    $clinicsWithData = array_unique(array_merge($renewalClinics, $changeAddressClinics,$changeManpowserClinics, $clinicForSuspension, $clinicForRevocation));

    // Static clinic map (define once)
    $clinics = [
        'ARTCLINIC' => 'ART Clinic',
        'ARTBANK' => 'ART Bank',
        'ARTSURROGACY' => 'Clinic Surrogacy',
    ];
?>

<style nonce="<?php echo e($cspNonce); ?>">
    .csp-admin-state-session {
        border-color: #0b5ed7;
        color: #0b5ed7;
    }
</style>
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <?php //if(@$row['role_id'] == 1) {
        ?>
        <a class="nav-link " href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
            <div class="header-info2 align-items-center">
                <!--img src="images/profile/pic1.jpg" alt=""-->
                <div class="align-items-center sidebar-info text-center">

                    <small class="text-end font-w500 text-dark mt-2">Welcome:</small>
                    <span class="font-w400 d-block csp-admin-state-session"><?php echo e(session('state_name')); ?></span>



                </div>

            </div>
        </a>
        <?php //}
        ?>
        <ul class="metismenu" id="menu">
            <li><a href="<?php echo e(route('ssa.dashboard')); ?>" class="" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

           
            <li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-address-card" aria-hidden="true"></i>
                    <span class="nav-text">Reg. Details</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href=" <?php echo e(route('admin.reg_ssaForm_list')); ?>">ART Clinic (View/upload)</a></li>
                    <li><a href="<?php echo e(route('admin.bank_reg_ssaForm_list')); ?>">ART Bank (View/upload)</a></li>
                    <li><a href="<?php echo e(route('admin.surrogacy_reg_ssaForm_list')); ?>">Surrogacy Clinic (View/upload)</a>
                    </li>
                    
                    
                    
                </ul>

            </li>

            <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Renewal</span></a>
                    <ul aria-expanded="false">
                        <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a href="<?php echo e(route('registration.clinic-list', Crypt::encryptString($key))); ?>">
                                        <?php echo e($label); ?> (View/Upload)
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php
                $changeNames = [
                    'ARTCLINIC' => 'ARTCLINIC',
                   
                ];
               
            ?>

            <li>
                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                    <i class="fa fa-address-card"></i>
                    <span class="nav-text">Change of Name</span>
                </a>

                <ul aria-expanded="false">

                    <?php $__currentLoopData = $changeNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if(in_array($key, $changeNames)): ?>
                               
                                 <li>
                            <a href="<?php echo e(route('admin.change_name', Crypt::encryptString($key))); ?>">
                              Application Change
                            </a>
                        </li>
                            <?php endif; ?>
                       
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <!-- Change address -->
            <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Change Address</span></a>
                    <ul aria-expanded="false">
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a
                                        href="<?php echo e(route('change_address.registration.clinic_list', Crypt::encryptString($key))); ?>">
                                        Applications
                                    </a>
                                </li>
                            <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
             <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Change Manpower</span></a>
                    <ul aria-expanded="false">
                        <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a href="<?php echo e(route('change_manpower.clinic_list', Crypt::encryptString($key))); ?>">
                                        <?php echo e($label); ?> (View/Upload)
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Withdrawal</span></a>
                    <ul aria-expanded="false">
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a href="<?php echo e(route('withdrawal.sa.clinic_list', Crypt::encryptString($key))); ?>">
                                        Applications
                                    </a>
                                </li>
                            <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?> 

            <!-- Suspension -->
            <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Suspension</span></a>
                    <ul aria-expanded="false">
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a href="<?php echo e(route('suspension.sa.clinic_list', Crypt::encryptString($key))); ?>">
                                        Applications
                                    </a>
                                </li>
                            <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?> 

            <!-- Suspension -->

            <?php if(!empty($clinicsWithData)): ?>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Revocation</span></a>
                    <ul aria-expanded="false">
                            <?php if(in_array($key, $clinicsWithData)): ?>
                                <li>
                                    <a href="<?php echo e(route('revocation.sa.clinic_list', Crypt::encryptString($key))); ?>">
                                        Applications
                                    </a>
                                </li>
                            <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Archive Panel</span>
                </a>
                <ul aria-expanded="false">
                   
                    <li><a href="<?php echo e(route('admin.archived_apps')); ?>">List of Archive</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Clinic Access change</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('clinic.email_change')); ?>">Email Change</a></li>
                    <li><a href="<?php echo e(route('clinic.access.changelist')); ?>">Email Change Requests</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Quarterly Report</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('report.Quarterlyreport')); ?>">Quarterly Report Form</a></li>
                    <li><a href="<?php echo e(route('report.QuarterlyreportList', ['flagid' => 2])); ?>">Quarterly Report View</a>
                    </li>
                    <!--Coded by manoj-->
                    <li><a href="<?php echo e(route('report.surrogacyArtClinic')); ?>">Detail Reports ART Clinic for Surrogacy</a>
                    </li>
                </ul>
            </li>
            <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <span class="nav-text">Patient Reports</span>
                    </a>
                    <ul aria-expanded="false">
                        
                         <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Reports</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo e(route('report.clinicReportOneForm')); ?>">Detail Reports ART (Level 1)</a></li>
                                <li><a href="<?php echo e(route('report.clinicReportLevelTwoForm')); ?>">Detail Reports ART (Level 2)</a></li>
                                <li><a href="<?php echo e(route('report.bankClinicReport')); ?>">Detail Reports ART Bank</a></li>
                                <li><a href="<?php echo e(route('report.surrogacyClinicReport')); ?>">Detail Reports Surrogacy Clinic</a></li>
                                <li><a href="<?php echo e(route('report.surrogacyArtClinic')); ?>">Detail Reports ART Treatment for Surrogacy Clinic</a></li>
                                
                            </ul>
                        </li>
                    
                        <li>
                            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Reports Clinic-wise</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="<?php echo e(route('admin.clinic_patient_list', ['type' => 'artclinic'])); ?>">ART Clinic</a></li>
                                <li><a href="<?php echo e(route('admin.clinic_patient_list', ['type' => 'artbank'])); ?>">ART Bank</a></li>
                                <li><a href="<?php echo e(route('admin.clinic_patient_list', ['type' => 'artsurrogacy'])); ?>">Surrogacy Clinic</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrowd" href="<?php echo e(route('admin.patient_detail_consolidated')); ?>" aria-expanded="false">
                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                <span class="nav-text">Patient Detail Filling status</span>
                            </a>
                        </li>
                        
                    </ul>
                </li> 
            <li>
                <a class="has-arrow " href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="nav-text">Reports</span>
                </a>
                <ul aria-expanded="false">
                    
                    <li><a href="<?php echo e(route('admin.monthly_report')); ?>">Summary of Clinic</a></li>
                    <li><a href="<?php echo e(route('admin.state_wise_report')); ?>">State Wise Report</a></li>
                    <li><a href="<?php echo e(route('admin.view_applications')); ?>">view applications</a></li>                       
                    
                </ul>
            </li>
            



            

            

            

            
            

            
            



            

        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
<?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/ssa_siderbar_nav.blade.php ENDPATH**/ ?>