<?php $__env->startSection('content'); ?>
<style nonce="<?php echo e($cspNonce); ?>">
    .color-red-fourtyseven{
        color: #ff0000;
    }
    .bc-br-color-fourtyeight{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .bc-br-color-info{
        background-color: #4de9ee; border-color: #0ce0e0; color: white;
    }
    .bc-color-csp-fortynine{
        border-color: #0b5ed7; color: #0b5ed7;
    }
    .displyay-none-fifty{
        display: none;
    }
    .height-fifty-one{
        height: 20px;
    }
    .width-fify-two{
        width: 50%;
    }
       .step-indicator {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .indicator {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: #e9ecef;
    }
    .indicator.active {
      background-color: #0d6efd;
    }
    .progress-bar {
        background-color: #0d6efd;;
    }
    input.form-control[readonly],input.form-control:disabled {
    background-color: #f8f8f8;
    border: 1px solid #f3f1f1;
    cursor: not-allowed;
}
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('failure')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('failure')); ?>

                    </div>
                <?php endif; ?>
        <h3>Application Form for ART Clinic</h3>
        <div class="progress mb-4 height-fifty-one">
            <div
            id="progress-bar" 
            class="progress-bar progress-bar-striped progress-bar-animated width-fify-two" 
            role="progressbar" 
            aria-valuenow="50" 
            aria-valuemin="0" 
            aria-valuemax="100">
            Step 1 of 2
            </div>
        </div>

            <!-- Form -->
            <form id="form-wizard" method="POST" action="<?php echo e(route('change_address.submit_application')); ?>" enctype="multipart/form-data" autocomplete="off">
              <!-- Step 1 -->
              <?php echo csrf_field(); ?>
              <div id="step-1" class="step">
                <div class="row">
                    <div class="col-md-6">
                                <h3 class=" bc-color-csp-clinic-four" >General Information and Staff Details</h3>
                            </div>
                            <div class="col-md-6">
                            <?php if(($reject ?? null) === 'Rejected'): ?>
                                <h3 class="text-success text-center">Resubmission Against Previously Rejected Application</h3>
                                <input id="r_id" name="r_id"  value="<?php echo e($encryptedAppId); ?>" type="hidden">
                            <?php endif; ?>
                            </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input id="clinic_id" name="clinic_id"  value="<?php echo e($clinic_data->clinic_id); ?>"
                                                    type="hidden"> 
                                <input id="clinic_id" name="applicationno"  value="<?php echo e($clinic_data->application_no); ?>"
                                type="hidden"> 
                                <input id="clinic_id" name="clinic_type"  value="<?php echo e($clinic_data->clinic_type); ?>"
                                                    type="hidden"> 
                                <label class="control-label" for="clinicname"><strong>Name of the Clinic</strong><span
                                        class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <input id="clinicname" name="clinicname" class="form-control" value="<?php echo e($clinic_data->name  ?? $draft_data->name ?? ''); ?>"
                                        type="text" readonly/>
                                </div>
                                <div id="errorclinicname" class="color-red-fourtyseven"></div>
                                <?php if($errors->has('clinicname')): ?>
                                    <div class="color-red-fourtyseven">
                                        <strong><?php echo e($errors->first('clinicname')); ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="address"><strong>Old Address</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <!-- <input type="text" name="" id=""
                               value="<?php echo e($clinic_data->address ?? $draft_data->address ?? ''); ?>, <?php echo e($clinic_data->district ?? ''); ?>, <?php echo e($clinic_data->state ?? ''); ?>, <?php echo e($clinic_data->pincode ?? ''); ?>"
                                class="form-control border-left-end" readonly> -->
                            <input
                                type="text"
                                class="form-control border-left-end"
                                name="old_address"
                                value="<?php echo e(implode(', ', array_filter([
                                    $clinic_data->address ?? $draft_data->address ?? null,
                                    $clinic_data->district ?? $draft_data->district ?? null,
                                    $clinic_data->state ?? $draft_data->state ?? null,
                                    $clinic_data->pincode ?? $draft_data->pincode ?? null,
                                ]))); ?>" readonly>
                            </div>
                        </div>
                </div>
                 <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="address"><strong>New Address</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="address" id="address"
                               value="<?php echo e(old('address', $draft_data->address ?? '')); ?>"
                                placeholder="Enter new address"
                                class="form-control border-left-end"
                                maxlength="100">
                        </div>
                        <div id="erroraddress" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('address')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('address')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                  <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pincode"><strong>New Pincode</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="pincode" placeholder="Pincode" id="pincode"
                                value="<?php echo e($draft_data->pincode ?? ''); ?>" class="form-control border-left-end "
                                maxlength="6"
                                >
                        </div>
                        <span id="pincodeavailability"></span>
                        <div id="errorpincode" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('pincode')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('pincode')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="district"><strong>New District</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group" id="district-container">
                            <input type="text" name="district" placeholder="District" id="district"
                                value="<?php echo e($draft_data->district ?? ''); ?>" readonly
                                class="form-control border-left-end">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="state"><strong>New State</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="state" placeholder="State" id="state"
                                value="<?php echo e($draft_data->state ?? ''); ?>"
                                class="form-control border-left-end" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="nature"><strong>Nature of the Organization</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            
                            <input type="text" class="form-control" name="nature" id="nature" value="<?php echo e(($clinic_data->nature ?? $draft_data->nature ?? '')); ?>" readonly>
                        </div>
                        <div id="errornature" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('nature')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('nature')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="email_clinic"><strong>E-mail
                                Address of the clinic</strong><span
                               class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="email_clinic" placeholder="Email email address" id="email_clinic"
                            value="<?php echo e(old('email_clinic', $draft_data ? ($draft_data->email ?? '') : ($clinic_data?->email ?? ''))); ?>" class="form-control">
                        </div>
                        <div id="erroremail_clinic" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('email_clinic')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('email_clinic')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="contactno"><strong>Contact
                                Number</strong><span
                               class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="contactno" placeholder="Contact number" id="contactno"
                                value="<?php echo e(old('contactno', $draft_data ? ($draft_data->contactno ?? '') : ($clinic_data?->contact_number_clinic ?? ''))); ?>"
                                class="form-control"
                                maxlength="11"                                
                                >
                        </div>
                        <div id="errorcontactno" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('contactno')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('contactno')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="personname"><strong>Name
                                of the Contact Person</strong> <span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="personname" placeholder="Enter contact person name" id="personname"
                            value="<?php echo e(old('personname', $draft_data ? ($draft_data->contact_person_name ?? '') : ($clinic_data?->contact_person_name ?? ''))); ?>" class="form-control"
                            >
                        </div>
                        <div id="errorpersonname" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('personname')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('personname')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mobilecontact"><strong>Mobile
                                Number</strong></label>
                                <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="mobilecontact" placeholder="Enter Mobile number" id="mobilecontact"
                            value="<?php echo e(old('mobilecontact', $draft_data ? ($draft_data->contact_person_mobile ?? '') : ($clinic_data?->mobile ?? ''))); ?>" 
                            maxlength="10"
                            class="form-control">
                        </div>
                        <div id="errormobilecontact" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('mobilecontact')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('mobilecontact')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="emailcontact"><strong>E-mail
                                of the conatct person</strong> <span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="emailcontact" placeholder="Enter Contact Email" id ="emailcontact"
                            value="<?php echo e(old('emailcontact', $draft_data ? ($draft_data->contact_person_email ?? '') : ($clinic_data?->contact_person_email ?? ''))); ?>" class="form-control">
                        </div>
                        <div id="erroremailcontact" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('emailcontact')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('emailcontact')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="cliniclevel"><strong>Applying
                                for Change Address as</strong><span
                                class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="cliniclevel1" id="cliniclevel" 
                                class="nice-select default-select wide form-control solid" disabled>
                                <option value="">Select</option>
                                <option value="Level-1"  <?php echo e(old('Level-1', $draft_data->cliniclevel ?? $clinic_data->level ?? '') == 'Level-1' ? 'selected' : ''); ?>>Level-1</option>
                                <option value="Level-2" <?php echo e(old('Level-2', $draft_data->cliniclevel ??  $clinic_data->level ?? '') == 'Level-2' ? 'selected' : ''); ?>>Level-2</option>
                            </select>
                            <input type="hidden" name="cliniclevel" value="<?php echo e($draft_data->cliniclevel ?? $clinic_data->level); ?>">

                        </div>
                         <!-- Error Message Container -->
                        <div id="errorCliniclevel" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('cliniclevel')): ?>
                                <div class="color-red-fourtyseven">
                                    <strong><?php echo e($errors->first('cliniclevel')); ?></strong>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="fax"><strong>Fax
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="fax" id="fax" placeholder="Enter fax number"
                                class="form-control" value="<?php echo e(old('fax', $draft_data ? ($draft_data->fax ?? '') : ($clinic_data?->fax ?? ''))); ?>"
                                maxlength="11">
                        </div>
                        <div id="errorfax" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('fax')): ?>
                            <div class="color-red-fourtyseven">
                                <strong><?php echo e($errors->first('fax')); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="website"><strong>Website</strong></label>
                        <div class="input-group">
                            <input type="text" name="website" id="website" placeholder="Enter website URL"
                                 class="form-control" value="<?php echo e(old('website', $draft_data ? ($draft_data->website ?? '') : ($clinic_data?->website ?? ''))); ?>">
                        </div>
                         <div id="errorwebsite" class="color-red-fourtyseven"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>
                                Date of establishment of your ART Clinic</strong><span
                                class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                               <input type="text" name="dateestab"
                                 class="datepicker-default form-control"
                                 value="<?php echo e($clinic_data->date_of_establishment ? \Carbon\Carbon::parse($clinic_data->date_of_establishment)->format('d-m-Y'): ''); ?>" 
                                 readonly>

                              <input type="hidden" name="dateestab"
                                 class="datepicker-default form-control" 
                                 value="<?php echo e($clinic_data->date_of_establishment ?? ''); ?>">
                        </div>
                        <div id="errordatepicker" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('dateestab')): ?>
                                <div class="color-red-fourtyseven">
                                    <strong><?php echo e($errors->first('dateestab')); ?></strong>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>1. Date of Registration</strong><span class="color-red-fourtyseven"></span></label>
                        <div class="input-group">
                            <input type="hidden" name="rgistration_date" class="datepicker-default form-control" value="<?php echo e($clinic_data->rgistration_date); ?>">

                            <input type="text" name="rgistration_date" class="datepicker-default form-control" value=" <?php echo e(date('d-m-Y',strtotime($clinic_data->rgistration_date ))); ?>" readonly>
                            <input type="hidden" name="current_registration_date" value="<?php echo e($clinic_data->rgistration_date ?? ''); ?>">
                            <input type="hidden" name="original_rgistration_date" value="<?php echo e($clinic_data->first_registration_date ?? ''); ?>">
                        </div>
                        <div id="errordatepicker" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('original_rgistration_date')): ?>
                                <div class="color-red-fourtyseven">
                                    <strong><?php echo e($errors->first('original_rgistration_date')); ?></strong>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mtpact"><strong>2.
                                Whether your ART Clinic is registered under MTP
                                Act</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="mtpact" id="mtpact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes" <?php echo e(old('mtpact', $draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ??'') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                <option value="No"  <?php echo e(old('mtpact',$draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                            </select>
                        </div>
                        <div id="errormtpact" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('mtpact')): ?>
                                <div class="color-red-fourtyseven">
                                    <strong><?php echo e($errors->first('mtpact')); ?></strong>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pcpndtact"><strong>3.
                                Whether your ART Clinic is registered under PCPNDT
                                Act</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="pcpndtact" id="pcpndtact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                
                                <option value="Yes" <?php echo e(old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                <option value="No" <?php echo e(old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                            </select>

                        </div>
                        <div id="errorpcpndtact" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('pcpndtact')): ?>
                        <div class="color-red-fourtyseven">
                            <strong><?php echo e($errors->first('pcpndtact')); ?></strong>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="director"><strong>4.Whether your ART Clinic has
                                Director</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select id="director" name="director"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                
                                <option value="Yes" <?php echo e(old('director', $draft_data->director ?? $clinic_data->clinic_director ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                <option value="No" <?php echo e(old('director',$draft_data->director ?? $clinic_data->clinic_director ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                            </select>
                        </div>
                        <div id="errordirector" class="color-red-fourtyseven"></div>
                        <?php if($errors->has('director')): ?>
                                <div class="color-red-fourtyseven">
                                    <strong><?php echo e($errors->first('director')); ?></strong>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>

                <div id="directory" data-section="directors" 
                        class="col-xs-12 form-group  <?php echo e(old('director', $draft_data->director ?? $clinic_data->clinic_director ??  '') == 'Yes' ? '' : 'displyay-none-fifty'); ?>">
                        <div class="table-responsive">
                            
                            <?php
                            $directorsData = old('name_director') 
                            ? collect(old('name_director'))->map(function ($name, $i) {
                            return [
                            'name_director'  => $name,
                            'quali_director' => old('quali_director.' . $i),
                            'reg_director'   => old('reg_director.' . $i),
                            ];
                            })
                            : ($directors ?? collect([[]])); // if no draft, show one empty row
                            ?>

                            <table class="table table-bordered" id="crud_table_director">
                                <tr>
                                    <th>Name<span class="color-red-fourtyseven">*</span></th>
                                    <th>Qualification<span class="color-red-fourtyseven">*</span></th>
                                    <th>Registration No. (if applicable)</th>
                                    <th></th>
                                </tr>
                                    <?php $__empty_1 = true; $__currentLoopData = $directorsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $director): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="director-row" id="drow<?php echo e($index+1); ?>">
                                            <td>
                                                <input type="text" name="name_director[]" class="form-control"
                                                    value="<?php echo e($director['name_director'] ?? ''); ?>">
                                                    <?php $__errorArgs = ['name_director.'.$loop->index];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <strong><span class="text-danger"><?php echo e($message); ?></span></strong>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </td>
                                            <td>
                                                <select name="quali_director[]" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = ['PhD','DM','MCh','PG','MD','MS','DNB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($q); ?>" <?php echo e(($director['quali_director'] ?? '') == $q ? 'selected' : ''); ?>>
                                                            <?php echo e($q); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                
                                                <!-- This span ensures the JS error displays directly below the dropdown -->
                                                <span class="errorquali_director text-danger" style="display:block; margin-top:5px;"></span>
                                                
                                                <?php $__errorArgs = ['quali_director.' . $index];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <strong>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                    </strong>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </td>
                                            <td>
                                                <input type="text" name="reg_director[]" class="form-control"
                                                    value="<?php echo e($director['reg_director'] ?? ''); ?>">
                                            </td>
                                            <td>
                                                
                                                <?php if($index > 0): ?>
                                                    <button type="button" id="<?php echo e($index+1); ?>" class="btn btn-danger btn_remove1">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                    </tr>
                                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr class="director-row" id="drow1">
                                        <td><input type="text" name="name_director[]" class="form-control"></td>
                                        <td>
                                            <select name="quali_director[]" class="form-control">
                                                <option value="">Select</option>
                                                <?php $__currentLoopData = ['PhD','DM','MCh','PG','MD','MS','DNB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($q); ?>"><?php echo e($q); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td><input type="text" name="reg_director[]" class="form-control"></td>
                                        
                                
                                        </td> 
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <div align="right">
                                <button type="button" name="adddirector" id="adddirector" 
                                 class="btn-xs bc-br-color-fourtyeight"><i class="fa fa fa-plus"></i></button>
                            </div>
                    </div>
                </div>

                <?php
                    $staffData = old('post')
                        ? collect(old('post'))->map(function ($post, $i) {
                            return [
                                'post' => $post,
                                'name' => old('name_otherstaff.'.$i),
                                'qualification' => old('quali_otherstaff.'.$i),
                                'regno' => old('regno.'.$i),
                            ];
                        })
                        : ($staff ?? collect([[]]));
                ?>
                <div id="otherstaff" class="col-xs-12 form-group">
                    <label class="control-label"><strong>5. Provide details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <thead>
                                <tr>
                                    <th>Post<span class="color-red-fourtyseven">*</span></th>
                                    <th>Name<span class="color-red-fourtyseven">*</span></th>
                                    <th>Qualification<span class="color-red-fourtyseven">*</span></th>
                                    <th>Reg No</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $staffData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="staff-row">
                                    
                                    <td>
                                    <?php
                                        $post = trim($row['post'] ?? '');

                                        $standardPosts = [
                                            'Gynecologist',
                                            'Andrologist',
                                            'Clinical Embryologist',
                                            'Counselor',
                                            'Anesthetist'
                                        ];

                                        $isOtherPost = $post !== '' && !in_array($post, $standardPosts);
                                    ?>

                                    <select name="post[]" class="form-control toggle-other">
                                        <option value="">Select</option>

                                        <?php $__currentLoopData = $standardPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item); ?>" <?php echo e($post === $item ? 'selected' : ''); ?>>
                                                <?php echo e($item); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <option value="Any Other" <?php echo e($isOtherPost ? 'selected' : ''); ?>>
                                            Any Other
                                        </option>
                                    </select>

                                    <input
                                        type="text"
                                        name="anyotherpost[]"
                                        value="<?php echo e($isOtherPost ? $post : ($row['anyotherpost'] ?? '')); ?>"
                                        class="form-control other-input"
                                        <?php echo e($isOtherPost ? '' : 'hidden'); ?>

                                    >
                                <div id="erroranyotherpost" class="color-red-fourtyseven"></div>
                                            
                                    </td>

                                    
                                    <td>
                                        <input type="text" name="name_otherstaff[]" value="<?php echo e($row['name'] ?? ''); ?>" class="form-control">
                                        <div id="errorpost" class="color-red-fourtyseven"></div>
                                    </td>

                                    
                                <td>
                                    <?php
                                        $qualification = trim($row['qualification'] ?? '');

                                        $standardQualifications = [
                                            'Doctorate',
                                            'Post Graduate',
                                            'Graduate',
                                            'Diploma',
                                            'Under Graduate'
                                        ];

                                        $isOtherQualification = $qualification !== '' &&
                                            !in_array($qualification, $standardQualifications);
                                        ?>

                                        <select name="quali_otherstaff[]" class="form-control toggle-other">
                                            <option value="">Select</option>

                                            <?php $__currentLoopData = $standardQualifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item); ?>" <?php echo e($qualification === $item ? 'selected' : ''); ?>>
                                                    <?php echo e($item); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <option value="Any Other" <?php echo e($isOtherQualification ? 'selected' : ''); ?>>
                                                Any Other
                                            </option>
                                        </select>

                                        <input
                                            type="text"
                                            name="anyotherdegree[]"
                                            value="<?php echo e($isOtherQualification ? $qualification : ''); ?>"
                                            class="form-control other-input"
                                            <?php echo e($isOtherQualification ? '' : 'hidden'); ?>

                                        >

                                    <div id="erroranyotherdegree" class="color-red-fourtyseven"></div>
                                </td>

                                    
                                    <td>
                                        <input type="text" name="regno[]" value="<?php echo e($row['regno'] ?? ''); ?>" class="form-control">
                                    </td>

                                   
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div align="right">
                            <button type="button" name="addotherstaff" id="addotherstaff" class="btn-xs bc-br-color-fourtyeight">+</button>
                        </div>
                    </div>
                </div>

            </div>
                    <button type="button" class="btn btn-primary bc-br-color-fourtyeight" id="next-step">Next</button>
                  </div>

                        <!-- Step 2 -->
                        <div id="step-2" class="step d-none">
                            <div class="row">
                                <h3 class="bc-color-csp-fortynine">Procedures</h3>
                                <?php
                                    $equipmentsData = old('equipmentname')
                                        ? collect(old('equipmentname'))->map(fn($eq) => (object)['equipmentname' => $eq])
                                        : ($equipment ?? collect([(object)['equipmentname' => '']]));
                                ?>

                                <div id="equipment" class="col-xs-12 form-group">
                                    <label class="control-label" for="">6. Provide list of Equipment's</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="crud_table_equipments">
                                            <tr>
                                                <th>Name of Equipments<span class="color-red-fourtyseven">*</span></th>
                                                <th></th>
                                            </tr>

                                            <?php $__currentLoopData = $equipmentsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="equipment-row" id="row1<?php echo e($i+1); ?>">
                                                    <td>
                                                        <input type="text" id="equipmentname" name="equipmentname[]"
                                                            value="<?php echo e($row->equipmentname ?? ''); ?>"
                                                            placeholder="" class="form-control">
                                                        <div id="errorequipmentname" class="color-red-fourtyseven"></div>
                                                        <?php $__errorArgs = ['equipmentname.' . $i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="color-red-fourtyseven"><strong><?php echo e($message); ?></strong></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </td>
                                                    <td>
                                                        <?php if($i > 0): ?> 
                                                            <button type="button" id="<?php echo e($i+1); ?>" class="btn btn-danger btn_remove_addEQ">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </table>
                                        <div align="right">
                                            <button type="button" name="addequipment" id="addequipment"
                                                    class="btn-xs bc-br-color-fourtyeight">+</button>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>7. Indicate which of the
                                                            following ART
                                                            procedures are being routinely carried out at
                                                            your ART Clinic
                                                        </strong></label>
                                                </div>
                                            </div>
                            <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="iuih"><strong>i).
                                                        Intra-uterine Insemination using Husband Semen (IUI-H)<span
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuih" id="iuih"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes" <?php echo e(old('iuih', $draft_data->iuih ??  $clinic_data->iui_h_s ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                        <option value="No" <?php echo e(old('iuih', $draft_data->iuih ??  $clinic_data->iui_h_s ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                                    </select>

                                                </div>
                                                <div id="erroriuih" class="color-red-fourtyseven"></div>
                                                <?php if($errors->has('iuih')): ?>
                                                <div class="color-red-fourtyseven">
                                                    <strong><?php echo e($errors->first('iuih')); ?></strong>
                                                </div>
                                                <?php endif; ?>
                                                </div>
                                        </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="iuid"><strong>ii).
                                                Intra-uterine Insemination using
                                                Donor Semen (IUI-D)<span
                                                    class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <select name="iuid" id="iuid"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('iuid', $draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('iuid', $draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>

                                        </div>
                                        <div id="erroriuid" class="color-red-fourtyseven"></div>
                                        <?php if($errors->has('iuid')): ?>
                                        <div class="color-red-fourtyseven">
                                            <strong><?php echo e($errors->first('iuid')); ?></strong>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="ivfet"><strong>iii). In vitro
                                                Fertilization-Embryo
                                                Transfer (IVF-ET)<span
                                                    class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">

                                            <select name="ivfet" id="ivfet"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('ivfet', $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('ivfet', $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>
                                        </div>
                                        <div id="errorivfet" class="color-red-fourtyseven"></div>
                                         <?php if($errors->has('ivfet')): ?>
                                            <div class="color-red-fourtyseven">
                                                <strong><?php echo e($errors->first('ivfet')); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="icsi"><strong>iv).
                                                Intra-cytoplasmic Sperm Injection (ICSI)<span
                                                    class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <select name="icsi" id="icsi"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>

                                        </div>
                                        <div id="erroricsi" class="color-red-fourtyseven"></div>
                                         <?php if($errors->has('icsi')): ?>
                                            <div class="color-red-fourtyseven">
                                                <strong><?php echo e($errors->first('icsi')); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="pgt"><strong>v).
                                                Pre-implantation Genetic Testing (PGT)<span
                                                    class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <select name="pgt" id="pgt"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>
                                        </div>
                                        <div id="errorpgt" class="color-red-fourtyseven"></div>
                                        <?php if($errors->has('pgt')): ?>
                                            <div class="color-red-fourtyseven">
                                                <strong><?php echo e($errors->first('pgt')); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="spermandoocyte"><strong>vi).
                                                Processing or Storage of Gametes (sperm & oocyte)of the Patient
                                                and
                                                or embryos of patient<span
                                                    class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <select name="spermandoocyte" id="spermandoocyte"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('spermandoocyte', $draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('spermandoocyte', $draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>
                                        </div>
                                        <div id="errorspermandoocyte" class="color-red-fourtyseven"></div>
                                        <?php if($errors->has('spermandoocyte')): ?>
                                            <div class="color-red-fourtyseven">
                                                <strong><?php echo e($errors->first('spermandoocyte')); ?></strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="anyotherprocedure"><strong>vii). Any Other Procedure<span class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <select name="anyotherprocedure" id='anyotherprocedure'
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"  <?php echo e(old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                                <option value="No"  <?php echo e(old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
                                            </select>
                                        </div>
                                        <div id="erroranyotherprocedure" class="color-red-fourtyseven"></div>
                                        <?php if($errors->has('anyotherprocedure')): ?>
                                        <div class="color-red-fourtyseven">
                                            <strong><?php echo e($errors->first('anyotherprocedure')); ?></strong>
                                        </div>
                                    <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3 display-none-csp-clinic-one" id='anyotherprocedurey' >
                                        <label class="text-label form-label"
                                            for="otherprocedure"><strong>If yes, please specify<span
                                            class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <input type="text" id="otherprocedure" name="otherprocedure"
                                                placeholder=""  value="<?php echo e(old('otherprocedure', $draft_data->otherprocedure ?? $clinic_data->otherprocedure ?? '')); ?>" class="form-control"
                                                maxlength="250">
                                        </div>
                                        <div id="errorotherprocedure" class="color-red-fourtyseven"></div>
                                        <?php if($errors->has('otherprocedure.*')): ?>
                                        <div class="color-red-fourtyseven">
                                            <strong><?php echo e($errors->first('otherprocedure.*')); ?></strong>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                 </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="otherdetails" class="form-label"><strong>8. Any other details</strong></label>
                                            <textarea class="form-control" id="otherdetails" name="otherdetails"rows="4" cols="163" 
                                            maxlength="500"><?php echo e(old('otherdetails', $draft_data->otherdetails ?? $clinic_data->any_other_detail ?? '')); ?></textarea>
                                                <?php if($errors->has('otherdetails')): ?>
                                                <div class="color-red-fourtyseven">
                                                    <strong><?php echo e($errors->first('otherdetails')); ?></strong>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                            </div>

                            


                                        <div class="row">
                                            <div class="col-md-9 mb-4">
                                                <input type="checkbox" id="declaration" name="declaration">
                                                <b> I hereby declare that the entries in this form and the additional
                                                    particulars , if any,furnished here with are true to the best of my
                                                    knowledge and belief.<span
                                                        class="color-red-fourtyseven">*</span> </b>
                                                        </br>
                                    <?php if(($reject ?? null) === 'Rejected'): ?>
                                    <hr>
                                        <span>✓✓ <b>Fees already paid <?php echo e($fees ?? '-'); ?>/-</b> </span>
                                    <?php endif; ?>
                                                        <?php if($errors->has('declaration')): ?>
                                    <div class="color-red-fourtyseven">
                                        <strong><?php echo e($errors->first('declaration')); ?></strong>
                                    </div>
                                <?php endif; ?>
                                            </div>

                                        </div>

                                    </div>
                    <button type="button" class="btn btn-secondary bc-br-color-fourtyeight" id="prev-step">Back</button>
                    <button type="submit" id="draftButton" name="submit_type" value="draft" class="btn btn-success bc-bc-color-csp-clinic-three">Save As draft</button>
                    <button  type="submit" id="submitButton" name="submit_type" value="final" class="btn btn-success bc-bc-color-csp-clinic-three">Submit</button>
              </div>
            </form>

</div>
</div>
</div>
</div>
</div>
</div>

<script nonce="<?php echo e($cspNonce); ?>">
document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('submitButton');
    const draftButton = document.getElementById('draftButton');
    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            if (!validatesubmit()) {
                event.preventDefault();
            }
        });
    }
    if (draftButton) {
        draftButton.addEventListener('click', function(event) {
            if (!validatesdraft()) {
                event.preventDefault();
            }
        });
    }
});

</script>

  <script nonce="<?php echo e($cspNonce); ?>">
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
</script>
<script nonce="<?php echo e($cspNonce); ?>">
    $('#director').on('change', function() {
        $("#namedirector").val('');
        $("#quali_director").val('');
        $("#regdirector").val('');
        if (this.value == 'Yes') {
            $("#directory").show();
            $("input[name='name_director[]']").prop("disabled", false).val();
            $("select[name='quali_director[]']").prop("disabled", false).val();
            $("input[name='reg_director[]']").prop("disabled", false).val();
        } else {
            $("#directory").hide();
            $("input[name='name_director[]']").prop("disabled", true).val('');
            $("select[name='quali_director[]']").prop("disabled", true).val('');
            $("input[name='reg_director[]']").prop("disabled", true).val('');
        }
    });

    $('#director').trigger('change');
    </script>
 <script nonce="<?php echo e($cspNonce); ?>">
    $(document).ready(function () {
        function toggleOtherProcedure() {
            if ($('#anyotherprocedure').val() === 'Yes') {
                $("#anyotherprocedurey").show();
                $("#otherprocedure").prop("disabled", false);
            } else {
                $("#anyotherprocedurey").hide();
                $("#otherprocedure").prop("disabled", true).val('');
            }
        }
    
        // Run once on page load (important for draft values)
        toggleOtherProcedure();
    
        // Run again whenever user changes the dropdown
        $('#anyotherprocedure').on('change', function () {
            toggleOtherProcedure();
        });
    });
</script>


<script nonce="<?php echo e($cspNonce); ?>">
    $(document).on('change', '#crud_table_otherstaff .toggle-other', function () {
        $(this).closest('td').find('.other-input').prop(
            'hidden',
            $(this).val() !== 'Any Other'
        );
});
</script>

<script nonce="<?php echo e($cspNonce); ?>">
    $(document).ready(function () {
        // Add new row
        $('#addotherstaff').click(function () {
            let newRow = $('#crud_table_otherstaff .staff-row:first').clone();
            newRow.find('input, select').val(''); // Clear input values
            $('#crud_table_otherstaff').append(newRow);
        });

        // Remove a row
        $(document).on('click', '.remove-row', function () {
            if ($('#crud_table_otherstaff .staff-row').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert("At least one row must be present.");
            }
        });
    });
</script>

<script nonce="<?php echo e($cspNonce); ?>">
    $(document).ready(function() {
        var i = 1;
        $('#adddirector').click(function() {
            i++;
            $('#crud_table_director').append('<tr class="director-row" id="row1' + i +
                '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control"><div class="error-namedirector" class="color-red-fourtyseven"></div></td><td><select id= "quali_director" name="quali_director[]" class="form-control"><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select> <div class="error-quali_director" class="color-red-fourtyseven"></div></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
                i +
                '" class="btn btn-danger btn_remove1"><i class="fa fa fa-trash"></i></button></td></tr>'
            );
        });
         $(document).on('click', '.btn_remove1', function() {
            $(this).closest('tr.director-row').remove();
        });
    });
</script>

<script nonce="<?php echo e($cspNonce); ?>">
$(document).ready(function () {

    // 1. Add equipment row
    $('#addequipment').click(function () {
        $('#crud_table_equipments').append(
            '<tr class="equipment-row">' +
                '<td>' +
                    '<input type="text" ' +
                        'name="equipmentname[]" ' +
                        'class="form-control" ' +
                        'placeholder="">' +
                '</td>' +
                '<td>' +
                    '<button type="button" ' +
                        'class="btn btn-danger btn_remove_addEQ">' +
                        '<i class="fa fa-trash"></i>' +
                    '</button>' +
                '</td>' +
            '</tr>'
        );
    });

    // 2. Remove equipment row
    $(document).on('click', '.btn_remove_addEQ', function (e) {
        e.preventDefault();

        var $tableBody = $('#crud_table_equipments');
        var $rows = $tableBody.find('.equipment-row');

        if ($rows.length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('At least one equipment row is required.');
        }
    });

    $(document).on('input', 'input[name="equipmentname[]"]', function () {
        
        var value = $(this).val();

        if (value.length > 100) {
            
            // Slice the text to 100 chars
            $(this).val(value.substring(0, 100));

            // Show the warning
            alert(
                'Maximum 100 characters allowed for each equipment entry. ' +
                'If you need to add more equipment, please click on the "+" button.'
            );
        }
    });

});
</script>
<!-- add addequipment end here date(06-01-2025)-->

<script nonce="<?php echo e($cspNonce); ?>">
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next-step').addEventListener('click', () => {
      step1.classList.add('d-none');
      step2.classList.remove('d-none');
      progressBar.style.width = '100%';
      progressBar.setAttribute('aria-valuenow', '100');
      progressBar.innerText = 'Step 2 of 2';
    });

    document.getElementById('prev-step').addEventListener('click', () => {
      step2.classList.add('d-none');
      step1.classList.remove('d-none');
      progressBar.style.width = '50%';
      progressBar.setAttribute('aria-valuenow', '50');
      progressBar.innerText = 'Step 1 of 2';
    });


  </script>

<script nonce="<?php echo e($cspNonce); ?>">
   // function validatesdraft(e) {
   //      const allInputs = document.querySelectorAll("input[type='text'], textarea");
   //          const forbiddenPattern = /[<>$%#{}[\];'"`]/; 

   //          for (let el of allInputs) {
   //              if (el.value && forbiddenPattern.test(el.value)) {
   //                  alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
   //                  el.focus();
   //                  return false;
   //              }
   //          }
   //          return true;

   //      }   
        
    function validatesubmit(e) {

        const allInputs = document.querySelectorAll("input[type='text'], textarea");

        const forbiddenPattern = /[<>$%{}[\];'"`]/;
        const addressPattern = /[<>$%{}[\];'"`]/;

        for (let el of allInputs) {
            const fieldName = (el.name || el.id || "").toLowerCase();
            const pattern = fieldName === "address" || fieldName === "old_address"
                ? addressPattern
                : forbiddenPattern;

            if (el.value && pattern.test(el.value)) {
                alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
                el.focus();
                return false;
            }
        }
    e = e || window.event;

    // ---------- helpers ----------
    const byId = (id) => document.getElementById(id);

    const setErrorForId = (id, msg) => { const el = byId(id); if (el) el.innerHTML = msg; };
    const clearErrorForId = (id) => { const el = byId(id); if (el) el.innerHTML = ""; };

    const setRowError = (row, fallbackId, inputEl, msg) => {
        // Try existing per-row error div (even if duplicated IDs, scoped query will find the one in this row)
        let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;
        if (!holder) {
            // create a lightweight inline error if not present
            holder = row.querySelector('.inline-error');
            if (!holder) {
                holder = document.createElement('div');
                holder.className = 'inline-error';
                holder.style.color = '#d33';
                holder.style.fontSize = '12px';
                holder.style.marginTop = '4px';
                // place inside same cell as the input
                (inputEl && inputEl.parentElement ? inputEl.parentElement : row).appendChild(holder);
            }
        }
        holder.textContent = msg;
    };

    const clearRowError = (row, fallbackId) => {
        if (fallbackId) {
            const holder = row.querySelector('#' + fallbackId);
            if (holder) holder.textContent = "";
        }
        const inline = row.querySelector('.inline-error');
        if (inline) inline.textContent = "";
    };

    const focusAndStop = (el) => {
        if (el && el.focus) el.focus();
        if (el && el.scrollIntoView) el.scrollIntoView({behavior: 'smooth', block: 'center'});
        return false;
    };

    document.querySelectorAll('.only-numeric').forEach(function (input) {
        input.addEventListener('keydown', function (e) {

            // Allow: backspace, delete, tab, arrows, home, end
            if (
                ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(e.key)
            ) {
                return;
            }

            // Allow only 0-9
            if (!/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Also clean pasted values
        input.addEventListener('paste', function (e) {
            e.preventDefault();

            const text = (e.clipboardData || window.clipboardData)
                .getData('text')
                .replace(/[^0-9]/g, '');

            document.execCommand('insertText', false, text);
        });
    });

    // ---------- 1) simple field validations (your original list) ----------
    const art_form_elements = [
        'clinicname',
        'address',
        'pincode',
        'district',
        'nature',
        'email_clinic',
        'contactno',
        'personname',
        'mobilecontact',
        'emailcontact'
    ];

    const art_form_labels = {
        clinicname: 'Clinic Name',
        address: 'Address',
        pincode: 'Pincode',
        district: 'District',
        nature: 'Nature of Organization',
        email_clinic: 'Clinic Email',
        contactno: 'Contact Number',
        personname: 'Person Name',
        mobilecontact: 'Mobile Contact',
        emailcontact: 'Contact Email',
        fax: 'Fax Number',
        website: 'Website'
    };

    const validationRules = {
        email_clinic: {
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            message: 'must be a valid email address.'
        },
        emailcontact: {
            regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            message: 'must be a valid email address.'
        },
        contactno: {
            regex: /^[0-9]{11}$/,
            message: 'must be a valid 11-digit mobile number.'
        },
        mobilecontact: {
            regex: /^[6-9][0-9]{9}$/,
            message: 'must be a valid 10-digit mobile number.'
        },
        pincode: {
            regex: /^[1-9][0-9]{5}$/,
            message: 'must be a valid 6-digit pincode.'
        },

       personname: {
            regex: /^[A-Za-z]+(?: [A-Za-z]+)*$/,
            message: 'must contain only alphabets and spaces.'
        },
        
        fax: {
            regex: /^[0-9+\-() ]{6,20}$/,
            message: 'must be a valid fax number.'
        },
        website: {
            regex: /^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/i,
            message: 'must be a valid website.'
        }
    };

    function getFieldLabel(id) {
        return art_form_labels[id] || id;
    }

    for (const id of art_form_elements) {

        const el = byId(id);

        if (!el || ['submit', 'button', 'checkbox', 'radio'].includes(el.type)) {
            continue;
        }

        const value = el.value.trim();
        const errId = `error${id}`;
        const label = getFieldLabel(id);

        if (!value) {
            setErrorForId(errId, `${label} is required.`);
            alert(`${label} is required.`);
            return focusAndStop(el);
        }

        if (value === 'fax' || value === 'website') {
            const rule = validationRules[value];

            if (value && !rule.regex.test(value)) {
                setErrorForId(errId, `${label} ${rule.message}`);
                alert(`${label} ${rule.message}`);
                return focusAndStop(el);
            }
        }     

        clearErrorForId(errId);

        const rule = validationRules[id];

        if (rule && !rule.regex.test(value)) {
            setErrorForId(errId, `${label} ${rule.message}`);
            alert(`${label} ${rule.message}`);
            return focusAndStop(el);
        }

        clearErrorForId(errId);
    }

    for (const [id, rule] of Object.entries(validationRules)) {

        if (art_form_elements.includes(id)) {
            continue;
        }

        const el = byId(id);

        if (!el) {
            continue;
        }

        const value = el.value.trim();
        const errId = `error${id}`;
        const label = getFieldLabel(id);

        if (!value) {
            clearErrorForId(errId);
            continue;
        }

        if (!rule.regex.test(value)) {
            setErrorForId(errId, `${label} ${rule.message}`);
            alert(`${label} ${rule.message}`);
            return focusAndStop(el);
        }

        clearErrorForId(errId);
    }

    // ---------- 2) specific single fields ----------
    // Clinic level
    {
        const el = byId("cliniclevel");
        if (el && !el.value) {
            setErrorForId("errorCliniclevel", "Clinic Level cannot be blank");
            alert("Clinic Level cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorCliniclevel");
    }

    // Establishment date
    {
        const el = byId("datepicker");
        if (el && !el.value) {
            setErrorForId("errordatepicker", "Date of establishment of your ART Clinic cannot be blank");
            alert("Date of establishment of your ART Clinic cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errordatepicker");
    }

    // Acts
    {
        const el = byId("mtpact");
        if (el && !el.value) {
            setErrorForId("errormtpact", "Whether your ART Clinic is registered under MTP Act cannot be blank");
            alert("Whether your ART Clinic is registered under MTP Act cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errormtpact");
    }
    {
        const el = byId("pcpndtact");
        if (el && !el.value) {
            setErrorForId("errorpcpndtact", "Whether your ART Clinic is registered under PCPNDT Act cannot be blank");
            alert("Whether your ART Clinic is registered under PCPNDT Act cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorpcpndtact");
    }


    {
    const directorSelect = byId("director");
    // First validate the director dropdown itself
    if (directorSelect && !directorSelect.value) {
        setErrorForId("errordirector", "Whether your ART Clinic has Director cannot be blank");
        alert("Whether your ART Clinic has Director cannot be blank");
        return focusAndStop(directorSelect);
    } else {
        clearErrorForId("errordirector");
    }
    
    // If director is "Yes", validate the director table rows
    if (directorSelect && directorSelect.value === "Yes") {
        const directorRows = document.querySelectorAll("#crud_table_director .director-row");
        
        if (directorRows.length === 0) {
            alert("Please add at least one director");
            return false;
        }
        
        for (const row of directorRows) {
            const nameInput   = row.querySelector('input[name="name_director[]"]');
            const qualiSelect = row.querySelector('select[name="quali_director[]"]');
            const regInput    = row.querySelector('input[name="reg_director[]"]');

            // Clear previous errors for this row
            clearRowError(row, "errornamedirector");
            clearRowError(row, "errorquali_director");
            clearRowError(row, "errorregdirector");

            // Validate Name - Required
           if (!nameInput || !nameInput.value.trim()) {
                setRowError(
                    row,
                    "errornamedirector",
                    nameInput,
                    "Name of the Director cannot be blank"
                );
                alert("Name of the Director cannot be blank");
                return focusAndStop(nameInput);
            }

            if (!/^[A-Za-z. ]+$/.test(nameInput.value.trim())) {
                setRowError(
                    row,
                    "errornamedirector",
                    nameInput,
                    "Name of the Director can contain only letters, spaces and dots."
                );
                alert("Name of the Director can contain only letters, spaces and dots.");
                return focusAndStop(nameInput);
            }

            const oldErr = row.querySelector('.my-qual-err');
            if (oldErr) oldErr.remove();

            if (!qualiSelect || !qualiSelect.value.trim()) {

                qualiSelect.insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger my-qual-err">Qualification cannot be blank</span>'
                );

                alert("Qualification of the Director cannot be blank");
                return focusAndStop(qualiSelect);
            }
        }
    }
}

    // ---------- 4) OTHER STAFF (dynamic table) ----------
    const rows = document.querySelectorAll("#crud_table_otherstaff .staff-row");

    for (const row of rows) {

        const postSelect  = row.querySelector('select[name="post[]"]');
        const nameInput   = row.querySelector('input[name="name_otherstaff[]"]');
        const qualiSelect = row.querySelector('select[name="quali_otherstaff[]"]');
        const anyPost     = row.querySelector('input[name="anyotherpost[]"]');
        const anyDegree   = row.querySelector('input[name="anyotherdegree[]"]');

        // Remove previous errors
        row.querySelectorAll('.staff-validation-error').forEach(el => el.remove());

        // Post
        if (postSelect && !postSelect.value.trim()) {

            postSelect.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Post of staff cannot be blank</span>'
            );

            alert("Post of staff cannot be blank");
            return focusAndStop(postSelect);
        }

        // Name
        if (nameInput && !nameInput.value.trim()) {

            nameInput.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Name of staff cannot be blank</span>'
            );

            alert("Name of staff cannot be blank");
            return focusAndStop(nameInput);
        }

        if (nameInput && !/^[A-Za-z ]+$/.test(nameInput.value.trim())) {

            nameInput.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error d-block">Name of staff must contain only alphabets and spaces</span>'
            );

            alert('Name of staff must contain only alphabets and spaces');
            nameInput.focus();
            return false;
        }

        // Qualification
        if (qualiSelect && !qualiSelect.value.trim()) {

            qualiSelect.insertAdjacentHTML(
                'afterend',
                '<span class="text-danger staff-validation-error">Qualification of staff cannot be blank</span>'
            );

            alert("Qualification of staff cannot be blank");
            return focusAndStop(qualiSelect);
        }

        // Any Other Post
        if (postSelect && postSelect.value === "Any Other") {

            if (!anyPost || !anyPost.value.trim()) {

                (anyPost || postSelect).insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger staff-validation-error">Name of the other Post cannot be blank</span>'
                );

                alert("Name of the other Post cannot be blank");
                return focusAndStop(anyPost || postSelect);
            }
        }

        // Any Other Qualification
        if (qualiSelect && qualiSelect.value === "Any Other") {

            if (!anyDegree || !anyDegree.value.trim()) {

                (anyDegree || qualiSelect).insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger staff-validation-error">Other Qualification cannot be blank</span>'
                );

                alert("Other Qualification cannot be blank");
                return focusAndStop(anyDegree || qualiSelect);
            }
        }
    }

    // ---------- 5) EQUIPMENT (dynamic rows) ----------
    {
        const eqInputs = document.querySelectorAll('input[name="equipmentname[]"]');

        if (eqInputs.length === 0) {
            setErrorForId("errorequipmentname", "Please add at least one equipment");
            alert("Please add at least one equipment");
            return false;
        }

        for (const input of eqInputs) {
            const row = input.closest("tr") || input.parentElement;
            if (row) clearRowError(row, "errorequipmentname");

            if (!input.value.trim()) {
                if (row) setRowError(row, "errorequipmentname", input, "Name of equipment cannot be blank");
                else setErrorForId("errorequipmentname", "Name of equipment cannot be blank");
                alert("Name of equipment cannot be blank");
                return focusAndStop(input);
            }
        }
    }

    // ---------- 6) Procedures (your existing single-field checks) ----------
    {
        const el = byId("iuih");
        if (el && !el.value) {
            setErrorForId("erroriuih", "Intra-uterine Insemination using Husband Semen (IUI-H) cannot be blank");
            alert("Intra-uterine Insemination using Husband Semen (IUI-H) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroriuih");
    }
    {
        const el = byId("iuid");
        if (el && !el.value) {
            setErrorForId("erroriuid", "Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank");
            alert("Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroriuid");
    }
    {
        const el = byId("ivfet");
        if (el && !el.value) {
            setErrorForId("errorivfet", "In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank");
            alert("In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorivfet");
    }
    {
        const el = byId("icsi");
        if (el && !el.value) {
            setErrorForId("erroricsi", "Intra-cytoplasmic Sperm Injection (ICSI) cannot be blank");
            alert("Intra-cytoplasmic Sperm Injection (ICSI) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroricsi");
    }
    {
        const el = byId("pgt");
        if (el && !el.value) {
            setErrorForId("errorpgt", "Pre-implantation Genetic Testing (PGT) cannot be blank");
            alert("Pre-implantation Genetic Testing (PGT) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorpgt");
    }
    {
        const el = byId("spermandoocyte");
        if (el && !el.value) {
            setErrorForId("errorspermandoocyte", "Processing/Storage of Gametes or Embryos cannot be blank");
            alert("Processing/Storage of Gametes or Embryos cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorspermandoocyte");
    }
    {
        const anyOther = byId("anyotherprocedure");
        if (anyOther && !anyOther.value) {
            setErrorForId("erroranyotherprocedure", "Any Other Procedure cannot be blank");
            alert("Any Other Procedure cannot be blank");
            return focusAndStop(anyOther);
        } else clearErrorForId("erroranyotherprocedure");

        const otherProc = byId("otherprocedure");
        if (anyOther && anyOther.value === "Yes" && otherProc && !otherProc.value.trim()) {
            setErrorForId("errorotherprocedure", "Details of any other procedure cannot be blank");
            alert("Details of any other procedure cannot be blank");
            return focusAndStop(otherProc);
        } 
        if (otherProc.value.trim().length > 250) {
            setErrorForId(
                "errorotherprocedure",
                "Details of any other procedure cannot exceed 250 characters"
            );
            alert("Details of any other procedure cannot exceed 250 characters");
            return focusAndStop(otherProc);
        }
        else clearErrorForId("errorotherprocedure");
    }

    // ---------- 7) Declaration ----------
    {
        const decl = byId("declaration");
        if (decl && !decl.checked) {
            alert("Please accept the declaration before submitting.");
            return focusAndStop(decl);
        }
    }

    // Final confirm
    const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
    return !!agree;

    return true;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/artclinic_application_form.blade.php ENDPATH**/ ?>