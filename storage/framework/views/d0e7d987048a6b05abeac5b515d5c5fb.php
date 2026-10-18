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
                            
                          
                          
                              <h4 class="card-title csp-clinic-text-black">
                                <strong>Application Number:</strong> <?php echo e($application->applicationno); ?>

                            </h4>
                            
                         
                            <a href="<?php echo e(route('change_address.ssa.application.pdf', ['encryptedId' => Crypt::encrypt($application->id)])); ?>"class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
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
                                        
                                         <tr>
                                            <th colspan="2">Name of the Bank</th>
                                            <td colspan="8"><?php echo e($application->clinicname); ?></td>                                                                                     
                                        </tr>

                                          <tr>
                                            <th colspan="2">Old Address</th>
                                            <td colspan="8">
                                                <?php echo e(implode(', ', array_filter([
                                                $application->clinic->address ?? null,
                                                $application->clinic->district ?? null,
                                                $application->clinic->state ?? null,
                                                $application->clinic->pincode ?? null,
                                            ]))); ?></td>                                                                                     
                                        </tr> 

                                        <tr>
                                            <th colspan="2">New Address</th>
                                            <td colspan="8"><?php echo e($application->address); ?></td>                                                                                     
                                        </tr>
                                        <tr>
                                            <th colspan="2">New State</th>
                                            <td><?php echo e($application->state); ?></td>                                                                                     
                                            <th>New District</th>
                                            <td><?php echo e($application->district); ?></td>
                                            <th>New Pincode</th>
                                            <td><?php echo e($application->pincode); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nature</th>
                                            <td><?php echo e($application->nature); ?></td>                                                                                     
                                            <th>Email ID</th>
                                            <td><?php echo e($application->email); ?></td>
                                            <th>Contact Number</th>
                                            <td><?php echo e($application->contactno); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Fax</th>
                                            <td ><?php echo e($application->fax ?? '-'); ?></td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2"><?php echo e($application->website ?? '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your ART Bank</th>                                            
                                            
                                            <td colspan="1"><?php echo e($application->dateestab
                                            ? \Carbon\Carbon::parse($application->dateestab)->format('d-m-Y') 
                                            : ''); ?></td>
                                             <th colspan="1">Current Registration Date</th>
                                            <td colspan="6"><?php echo e($application->current_registration_date
                                            ? \Carbon\Carbon::parse($application->current_registration_date)->format('d-m-Y') 
                                            : ''); ?></td>
                                        </tr> 
                                        <tr>
                                      
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                         <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td><?php echo e($application->contact_person_name); ?></td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2"><?php echo e($application->contact_person_mobile); ?></td>
                                        </tr>         
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8"><?php echo e($application->contact_person_email); ?></td>
                                            
                                        </tr>                                           
                                        
                                       
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
                                            
                                            <td colspan="3"><?php echo e($staffs->name); ?></td>
                                            <td colspan="3"><?php echo e($staffs->post ?? '-'); ?></td>
                                            <td colspan="3"><?php echo e($staffs->qualification); ?></td>                                           
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
                                      
                                        <tr>
                                            <th colspan="2"> a). Ejaculation</th>
                                            <td><?php echo e($application->ejaculation); ?></td>
                                            <th colspan="2">b). Electroejaculation (in
                                                case of retrograde ejaculation)</th>
                                            <td colspan="2"><?php echo e($application->electrojaculation); ?></td>
                                        </tr> 
                                        <tr> 
                                            <th colspan="2"> ii). Processing of Sperm</th>
                                            <td><?php echo e($application->processing_sperm); ?></td>
                                            <th colspan="2">iii). Storage of Sperm</th>
                                            <td colspan="2"><?php echo e($application->storage_sperm); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> iv). Provision/sourcing of
                                                Oocyte Donor</th>
                                            <td><?php echo e($application->oocyte_doner); ?></td>
                                            <th colspan="2">5. Cryopreservation of
                                                Sperm</th>
                                            <td colspan="2"><?php echo e($application->cryopreservation_of_sperm); ?></td>
                                        </tr> 
                                       
                                        <tr>
                                            <th colspan="2"> i). Sperm Slow Freezing</th>
                                            <td><?php echo e($application->methode_of_freezing_of_sperm); ?></td>
                                            <th colspan="2">ii). Sperm Vitrification</th>
                                            <td colspan="2"><?php echo e($application->sperm_vitrification); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> 7. Whether Freezing of
                                                Testicular Tissue</th>
                                            <td><?php echo e($application->freezing_of_testicular_tissue); ?></td>
                                           
                                        </tr> 
                                        <tr>
                                            <th colspan="2">Any Other Details</th>
                                            <td colspan="8"><?php echo e($application->otherdetails); ?></td>
                                        </tr>
                                                                          
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
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/artbank_application_view.blade.php ENDPATH**/ ?>