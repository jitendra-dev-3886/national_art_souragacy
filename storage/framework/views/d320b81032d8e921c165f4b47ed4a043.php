<?php $__env->startSection('content'); ?>
<div class="container-fluid">   
    <style nonce="<?php echo e($cspNonce); ?>">
    .table tbody tr td:last-child {
        text-align: start !important ;
        padding-right: 1.563rem;
    }
    .csp-clinic-card-left {
        text-align: left;
    }

    .csp-clinic-text-black {
        color: black;
    }

    .csp-clinic-btn-primary {
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
                
                <div class="card csp-clinic-card-left">
                    <div class="col-lg-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            
                           
                           
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> <?php echo e($application->applicationno); ?></h4>

                            
                           <a href="<?php echo e(route('change_address.ssa.application.pdf', ['encryptedId' => Crypt::encrypt($application->id)])); ?>"class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
                                    Download PDF
                            </a>
                       <!--      
 -->

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                            
                                            <th colspan="8" class="csp-clinic-table-header">Surrogacy Clinic Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        
                                         <tr>
                                            <th colspan="2">Name of the Clinic</th>
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
                                            <td colspan="2"><?php echo e($application->fax ?? '-'); ?></td>
                                            <th colspan="2">Website</th>
                                            <td colspan="2"><?php echo e($application->website ?? '-'); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Date of establishment of your Surrogacy Clinic</th>                                            
                                            
                                            <td colspan="1"><?php echo e($application->dateestab
                                            ? \Carbon\Carbon::parse($application->dateestab)->format('d-m-Y') 
                                            : ''); ?></td>
                                            <th colspan="1">Current Registration Date</th>
                                            <td colspan="6"><?php echo e($application->current_registration_date
                                            ? \Carbon\Carbon::parse($application->current_registration_date)->format('d-m-Y') 
                                            : ''); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td><?php echo e($application->mtpact); ?></td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2"><?php echo e($application->pcpndtact); ?></td>
                                        </tr>  
                                        
                                        <tr>
                                        
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td colspan="2"><?php echo e($application->contact_person_name); ?></td>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="2"><?php echo e($application->contact_person_mobile); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8"><?php echo e($application->email); ?></td>
                                            
                                        </tr>
                                                                            
                                        <tr>
                                               <th colspan="8" class="csp-clinic-table-header">Details of the Director Available at your Surrogacy Clinic</th>
                                            
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic has Director</th>
                                            <td colspan="8"><?php echo e($application->director); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <th colspan="2">Name</th>
                                            <th colspan="2">Qualification</th>
                                            <th colspan="3">Registration No. (if applicable)</th>
                                        </tr>
                                        <?php $__currentLoopData = $directors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $director): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="2"><?php echo e($director->name_director); ?></td>
                                            <td colspan="2"><?php echo e($director->quali_director); ?></td>
                                            <td colspan="3"><?php echo e($director->reg_director ?? '-'); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                               <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your Surrogacy Clinic</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Name of the Post</th>
                                            <th colspan="2">Name of the Staff</th>
                                            <th colspan="2">Qualification</th>
                                            <th colspan="2">Registration No (if applicable)</th>
                                        </tr>
                                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="2"><?php echo e($staffs->post); ?></td>
                                            <td colspan="2"><?php echo e($staffs->name); ?></td>
                                            <td colspan="2"><?php echo e($staffs->qualification); ?></td>
                                            <td colspan="2"><?php echo e($staffs->regno ?? '-'); ?></td>
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
                                            <th colspan="2"> Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                                            <td><?php echo e($application->iuih); ?></td>
                                            <th colspan="2">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                                            <td colspan="2"><?php echo e($application->iuid); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">  In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                                            <td><?php echo e($application->ivfet); ?></td>
                                            <th colspan="2">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                                            <td colspan="2"><?php echo e($application->icsi); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Pre-implantation Genetic Testing (PGT)</th>
                                            <td><?php echo e($application->pgt); ?></td>
                                            <th colspan="2">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                                            <td colspan="2"><?php echo e($application->spermandoocyte); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Any Other Procedure</th>
                                            <td><?php echo e($application->anyotherprocedure); ?></td>
                                            <th colspan="2">If yes, please specify</th>
                                            <td colspan="2"><?php echo e($application->otherprocedure); ?></td>
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
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/surrogacy_application_view.blade.php ENDPATH**/ ?>