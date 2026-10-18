<?php $__env->startSection('content'); ?>

    <style nonce="<?php echo e($cspNonce); ?>">
        .csp-clinic-alert {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-clinic-btn {
            background-color: #0b49f9;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-clinic-table {
            min-width: 845px;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?php if(session('success')): ?>
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show csp-clinic-alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>

                            <p class=""><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Applications</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display csp-clinic-table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Clinic Name</th>
                                        <th>Address</th>
                                        <th>Clinic level</th>
                                        <th>Application Number</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    

                                    <?php $i=1 ?>
                                    <?php if(!empty($clinicForms['artClinics']) && count($clinicForms['artClinics']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['artClinics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname); ?></td>
                                                <td><?php echo e($form->address); ?></td>
                                                <td><?php echo e($form->cliniclevel); ?></td>
                                                <td><?php echo e($form->applicationno ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('clinic.clinicForm_view', ['id' => encrypt($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td><?php echo e($form->appstatus); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($clinicForms['bankClinics']) && count($clinicForms['bankClinics']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['bankClinics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname); ?></td>
                                                <td><?php echo e($form->address); ?></td>
                                                <td><?php echo e($form->cliniclevel ?? '-'); ?></td>
                                                <td><?php echo e($form->applicationno ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('clinic.bankForm_view', ['id' => encrypt($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td><?php echo e($form->appstatus); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($clinicForms['surrogacyClinics']) && count($clinicForms['surrogacyClinics']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['surrogacyClinics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname); ?></td>
                                                <td><?php echo e($form->address); ?></td>
                                                <td><?php echo e($form->cliniclevel); ?></td>
                                                <td><?php echo e($form->applicationno ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('clinic.sclinicForm_view', ['id' => encrypt($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td><?php echo e($form->appstatus); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($clinicForms['renewalsurrogacyClinics']) && count($clinicForms['renewalsurrogacyClinics']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['renewalsurrogacyClinics']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname ?? ''); ?></td>
                                                <td><?php echo e($form->address ?? ''); ?></td>
                                                <td><?php echo e($form->cliniclevel ?? ''); ?></td>
                                                <td><?php echo e($form->applicationno ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('renewal.sc_renewalform_view', ['encryptedId' => Crypt::encryptString($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if($form->appstatus == 'Rejected'): ?>
                                                        <span>Rejected, <br>please resubmit <br>the renewal form</span>
                                                    <?php else: ?>
                                                        <span><?php echo e($form->appstatus); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <?php if(!empty($clinicForms['change_address']) && count($clinicForms['change_address']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['change_address']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname ?? ''); ?></td>
                                                <td><?php echo e($form->address ?? ''); ?></td>
                                                <td><?php echo e($form->cliniclevel ?? ''); ?></td>
                                                <td><?php echo e($form->applicationno ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('change_address.application.view', ['encryptedId' => Crypt::encryptString($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td><?php echo e($form->appstatus); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                    <?php if(!empty($clinicForms['change_name']) && count($clinicForms['change_name']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['change_name']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->name ?? ''); ?></td>
                                                <td><?php echo e($form->address ?? ''); ?></td>
                                                <td><?php echo e($form->level ?? ''); ?></td>
                                                <td><?php echo e($form->application_no ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('cn.application.view', ['encryptedId' => Crypt::encryptString($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal<?php echo e($form->id); ?>">
                                                        <?php echo e($form->appstatus); ?>

                                                    </a>
                                                  </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php if(!empty($clinicForms['changeManpower']) && count($clinicForms['changeManpower']) > 0): ?>
                                        <?php $__currentLoopData = $clinicForms['changeManpower']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($i++); ?></td>
                                                <td><?php echo e($form->clinicname ?? ''); ?></td>
                                                <td><?php echo e($form->address ?? ''); ?></td>
                                                <td><?php echo e($form->level ?? ''); ?></td>
                                                <td><?php echo e($form->application_no ?? '-'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('manpower.ssaChangeManpowerView', ['encryptedId' => Crypt::encryptString($form->id)])); ?>"
                                                        class="btn btn csp-clinic-btn">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php if($form->app_status == 'Rejected'): ?>
                                                        <a type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#manpowerejectresion<?php echo e($form->id); ?>"><?php echo e($form->app_status); ?></a>
                                                    <?php else: ?>
                                                        <?php echo e($form->app_status); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="manpowerejectresion<?php echo e($form->id); ?>"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                                <?php echo e($form->clinicname ?? ''); ?></h5>
                                                            
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo e($form->remark ?? ''); ?>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>



                                    

                                </tbody>
                            </table>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal<?php echo e($form->id); ?>" tabindex="-1"
        aria-labelledby="statusModalLabel<?php echo e($form->id); ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel<?php echo e($form->id); ?>">Reason for Rejection:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">


                    <?php echo e($form->reason_for_rejection ?? 'No rejection reason available.'); ?>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    </td>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/clinic_form_list.blade.php ENDPATH**/ ?>