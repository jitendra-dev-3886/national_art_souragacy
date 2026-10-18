<?php $__env->startSection('content'); ?>
<div class="container-fluid">   
    <style nonce="<?php echo e($cspNonce); ?>">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
    .csp-clinic-text-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-blue {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-table-header {
        background-color: #d3d8fd;
        text-align: center;
    }
</style>


    <div class="row">
        <div class="col-12">
            

            <form action="" method="POST">
                <?php echo csrf_field(); ?>
             
                <div class="card csp-clinic-text-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            
                            <?php $__currentLoopData = $application; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application_num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          
                              <h4 class="card-title csp-clinic-text-black">
                                <strong>Application Number:</strong> <?php echo e($application_num->bapp_no->applicationno); ?>

                            </h4>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         

                            <a href="<?php echo e(route('clinic.bankgeneratePdf', ['id' => Crypt::encrypt($application_num->id)])); ?>"
                                class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
                                    Download PDF
                                </a>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th colspan="8" class="csp-clinic-table-header">ART Bank Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        <?php $__currentLoopData = $application; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application_no): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                            <th colspan="2">Name of the Bank</th>
                                            <td colspan="8"><?php echo e($application_no->clinicname); ?></td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">Address</th>
                                            <td colspan="8"><?php echo e($application_no->address); ?></td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">State</th>
                                            <td><?php echo e($application_no->state); ?></td>                                                                                     
                                            <th>District</th>
                                            <td><?php echo e($application_no->district); ?></td>
                                            <th>Pincode</th>
                                            <td><?php echo e($application_no->pincode); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nature</th>
                                            <td><?php echo e($application_no->nature); ?></td>                                                                                     
                                            <th>Email ID</th>
                                            <td><?php echo e($application_no->email); ?></td>
                                            <th>Contact Number</th>
                                            <td><?php echo e($application_no->contactno); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Fax</th>
                                            <td ><?php echo e($application_no->fax ?? '-'); ?></td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2"><?php echo e($application_no->website ?? '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your ART Bank</th>                                            
                                            
                                            <td colspan="8"><?php echo e($application_no->dateestab); ?></td>
                                        </tr> 
                                        <tr>
                                      
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                         <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td><?php echo e($application_no->contact_person_name); ?></td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2"><?php echo e($application_no->contact_person_mobile); ?></td>
                                        </tr>         
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8"><?php echo e($application_no->contact_person_email); ?></td>
                                            
                                        </tr>                                           
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       
                                        <tr>
                                        
                                                <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your ART Bank</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Name</th>
                                            <th colspan="3">Designation</th>
                                            <th colspan="3">Qualification</th>
                                            
                                        </tr>
                                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            
                                            <td colspan="3"><?php echo e($staffs->name_otherstaff); ?></td>
                                            <td colspan="3"><?php echo e($staffs->designation_otherstaff ?? '-'); ?></td>
                                            <td colspan="3"><?php echo e($staffs->quali_otherstaff); ?></td>                                           
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                        
                                             <th colspan="8" class="csp-clinic-table-header">Equipment Details</th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">Name of Equipments</th>                                            
                                        </tr>
                                        <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="8"><?php echo e($equipments->equipmentname); ?></td>                                           
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            
                                            <th colspan="8" class="csp-clinic-table-header">Procedure Undertaken</th>
                                        </tr>
                                        <?php $__currentLoopData = $application; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application_no): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th colspan="2"> a). Ejaculation</th>
                                            <td><?php echo e($application_no->ejaculation); ?></td>
                                            <th colspan="2">b). Electroejaculation (in
                                                case of retrograde ejaculation)</th>
                                            <td colspan="2"><?php echo e($application_no->electroejaculation); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> ii). Processing of Sperm</th>
                                            <td><?php echo e($application_no->processingsperm); ?></td>
                                            <th colspan="2">iii). Storage of Sperm</th>
                                            <td colspan="2"><?php echo e($application_no->storagesperm); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> iv). Provision/sourcing of
                                                Oocyte Donor</th>
                                            <td><?php echo e($application_no->oocytedonor); ?></td>
                                            <th colspan="2">5. Cryopreservation of
                                                Sperm</th>
                                            <td colspan="2"><?php echo e($application_no->cryopreservation); ?></td>
                                        </tr> 
                                       
                                        <tr>
                                            <th colspan="2"> i). Sperm Slow Freezing</th>
                                            <td><?php echo e($application_no->spermslow); ?></td>
                                            <th colspan="2">ii). Sperm Vitrification</th>
                                            <td colspan="2"><?php echo e($application_no->spermvitrification); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> 7. Whether Freezing of
                                                Testicular Tissue</th>
                                            <td><?php echo e($application_no->tisticulartissue); ?></td>
                                           
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8"><?php echo e($application_no->otherdetails); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/bank_form_view.blade.php ENDPATH**/ ?>