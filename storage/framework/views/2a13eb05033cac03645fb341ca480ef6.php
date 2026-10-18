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
                            
                            <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong> <?php echo e($application_num->app_no->applicationno); ?></h4>


                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           
                            <a href="<?php echo e(route('clinic.clinicgeneratePdf', ['id' => Crypt::encrypt($application_num->id)])); ?>"class="link btn btn-primary csp-clinic-btn-blue" target="_blank">
                                    Download PDF
                            </a>


                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                                    <thead>
                                        <tr>
                                          
                                            <th colspan="8" class="csp-clinic-table-header">ART Clinic Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Applicant Details -->
                                        <?php $__currentLoopData = $application; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application_no): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr>
                                            <th colspan="2">Name of the Clinic</th>
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
                                            <th colspan="2">Date of establishment of your ART Clinic</th>                                            
                                            
                                            <td colspan="8"><?php echo e($application_no->dateestab); ?></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic is registered under MTP Act</th>
                                            <td><?php echo e($application_no->mtpact); ?></td>
                                            <th colspan="2">Whether your ART Clinic is registered under PCPNDT Act</th>
                                            <td colspan="2"><?php echo e($application_no->pcpndtact); ?></td>
                                        </tr>
                                        <tr>
                                        
                                            <th colspan="8" class="csp-clinic-table-header">Contact person details</th>
                                        </tr>
                                        <tr>                                                                                                                            
                                            <th colspan="2">Name of the Contact Person</th>
                                            <td colspan="8"><?php echo e($application_no->contact_person_name); ?></td>
                                        </tr>   
                                        <tr>
                                            <th colspan="2">Mobile Number</th>
                                            <td colspan="8"><?php echo e($application_no->contact_person_mobile); ?></td>
                                        </tr>      
                                        <tr>
                                            <th colspan="2">Email</th>
                                            <td colspan="8"><?php echo e($application_no->contact_person_email); ?></td>
                                            
                                        </tr>                             
                                        <tr>
                                           
                                            <th colspan="8" class="csp-clinic-table-header">Details of the Director Available at your ART Clinic</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Whether your ART Clinic has Director</th>
                                            <td colspan="8"><?php echo e($application_no->director); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th colspan="3">Name</th>
                                            <th colspan="3">Qualification</th>
                                            <th colspan="3">Registration No. (if applicable)</th>
                                        </tr>
                                        <?php $__currentLoopData = $directors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $director): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="3"><?php echo e($director->name_director); ?></td>
                                            <td colspan="3"><?php echo e($director->quali_director); ?></td>
                                            <td colspan="3"><?php echo e($director->reg_director ?? '-'); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                           
                                            <th colspan="8" class="csp-clinic-table-header">Details of the Staff Available at your ART Clinic</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Name of the Post</th>
                                            <th colspan="2">Name of the Staff</th>
                                            <th colspan="2">Qualification</th>
                                            <th colspan="2">Registration No (if applicable)</th>
                                        </tr>
                                        <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staffs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td colspan="2"><?php echo e($staffs->post_otherstaff); ?></td>
                                            <td colspan="2"><?php echo e($staffs->name_otherstaff); ?></td>
                                            <td colspan="2"><?php echo e($staffs->quali_otherstaff); ?></td>
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
                                        <?php $__currentLoopData = $application; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application_no): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th colspan="2"> Intra-uterine Insemination using Husband Semen (IUI-H)</th>
                                            <td><?php echo e($application_no->iuih); ?></td>
                                            <th colspan="2">Intra-uterine Insemination using Donor Semen (IUI-D)</th>
                                            <td colspan="2"><?php echo e($application_no->iuid); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2">  In vitro Fertilization-Embryo Transfer (IVF-ET)</th>
                                            <td><?php echo e($application_no->ivfet); ?></td>
                                            <th colspan="2">Intra-cytoplasmic Sperm Injection (ICSI)</th>
                                            <td colspan="2"><?php echo e($application_no->icsi); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Pre-implantation Genetic Testing (PGT)</th>
                                            <td><?php echo e($application_no->pgt); ?></td>
                                            <th colspan="2">Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient</th>
                                            <td colspan="2"><?php echo e($application_no->spermandoocyte); ?></td>
                                        </tr> 
                                        <tr>
                                            <th colspan="2"> Any Other Procedure</th>
                                            <td><?php echo e($application_no->anyotherprocedure); ?></td>
                                            <th colspan="2">If yes, please specify</th>
                                            <td colspan="2"><?php echo e($application_no->otherprocedure); ?></td>
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
                    
                    


                    
                    

                    

                    
                    
                    <!-- Other Sections: Purpose Details, Clinic Details, Documents, etc. -->
                    <!-- Similar structure as the Personal Details section above -->

                    

                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/clinic/clinic_form_view.blade.php ENDPATH**/ ?>