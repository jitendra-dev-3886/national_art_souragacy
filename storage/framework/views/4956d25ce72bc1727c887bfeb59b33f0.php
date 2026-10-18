<?php $__env->startSection('content'); ?>
<style nonce="<?php echo e($cspNonce); ?>">
	.display-none-csp-clinic-one{
	display:none;
	}
	.color-csp-clinic-two{
	color: red;
	}
	.bc-bc-color-csp-clinic-three{
	background-color: #0b5ed7; border-color: #0b5ed7; color: white;
	}
	.bc-color-csp-clinic-four{
	border-color: #0b5ed7; color: #0b5ed7;
	}
	.height-csp-clinic-five{
	height: 20px;
	}
	.width-csp-clinic-six{
	width: 70%;
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
				<h3>Change Address Form for Surrogacy Clinic</h3>
				<!-- Progress Bar -->
				<div class="progress mb-4 height-csp-clinic-five" >
					<div 
						id="progress-bar" 
						class="progress-bar progress-bar-striped progress-bar-animated" 
						role="progressbar" 
						class="width-csp-clinic-six"
						aria-valuenow="50" 
						aria-valuemin="0" 
						aria-valuemax="100">
						Step 1 of 2
					</div>
				</div>



				<!-- Form -->
				<form id="surrogacy_clinicform" method="POST" action="<?php echo e(route('change_address.submit_application')); ?>" enctype="multipart/form-data">
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
								<input id="r_id" name="r_id"  value="<?php echo e($encryptedAppId); ?>" type="hidden" readonly>
							<?php endif; ?>
							</div>
							
							
							<input id="clinic_id" name="clinic_id"  value="<?php echo e($clinic_data->clinic_id); ?>" type="hidden" readonly> 
							<input id="clinic_id" name="applicationno"  value="<?php echo e($clinic_data->application_no); ?>" type="hidden" readonly> 
							<input id="clinic_id" name="clinic_type"  value="<?php echo e($clinic_data->clinic_type); ?>"type="hidden" readonly> 
							
							<div class="col-md-4">
								<div class="mb-3">
									<label class="control-label" for="clinicname"><strong>Name of the Clinic</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input id="clinicname" name="clinicname" placeholder="Name of Clinic" class="form-control" value="<?php echo e($clinic_data->name ?? $draft_data->clinicname ?? $existing_data->clinicname); ?>"
											type="text" readonly> 
									</div>
									<div id="errorclinicname" class="color-csp-clinic-two"></div>
									<?php if($errors->has('clinicname')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('clinicname')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="address"><strong>Old Address</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<!-- <input type="text" name="address" id="address" placeholder="New Address" 
										value="<?php echo e($draft_data->address ?? $clinic_data->address); ?>, <?php echo e($clinic_data->district ?? ''); ?>, <?php echo e($draft_data->state ?? $clinic_data->state); ?>, <?php echo e($draft_data->pincode ?? $clinic_data->pincode); ?>"
											class="form-control border-left-end"> -->
										<input
											type="text"
											name="old_address"
											class="form-control border-left-end"
											value="<?php echo e(implode(', ', array_filter([
												$clinic_data->address ?? $draft_data->address ?? null,
												$clinic_data->district ?? $draft_data->district ?? null,
												$clinic_data->state ?? $draft_data->state ?? null,
												$clinic_data->pincode ?? $draft_data->pincode ?? null,
											]))); ?>"
											readonly>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="address"><strong>New Address</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="address" id="address" placeholder="New Address" value="<?php echo e($draft_data->address ?? null); ?>"
											class="form-control border-left-end"
											maxlength="100">
									</div>
									<div id="erroraddress" class="color-csp-clinic-two"></div>
									<?php if($errors->has('address')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('address')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="pincode"><strong>New Pincode</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="pincode" placeholder="New Pincode" id="pincode"
											value="<?php echo e($draft_data->pincode ?? null); ?>"
											class="form-control border-left-end"
											maxlength="6">
									</div>
									<span id="pincodeavailability"></span>
									<div id="errorpincode" class="color-csp-clinic-two"></div>
									<?php if($errors->has('pincode')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('pincode')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="district"><strong>New District</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group" id="district-container">
										<input type="text" name="district" placeholder="New District" id="district" 
											value="<?php echo e($draft_data->district ?? null); ?>"
											class="form-control border-left-end" readonly>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="state"><strong>New State</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="state" placeholder="New State" id="state"
											value="<?php echo e($draft_data->state ?? null); ?>"
											class="form-control border-left-end" readonly>
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="nature"><strong>Nature
									of the
									Organization</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										
										<input type="text"  class="form-control" name="nature" id="nature" value="<?php echo e($draft_data->nature ?? $clinic_data->nature); ?>" readonly>
									</div>
									<div id="errornature" class="color-csp-clinic-two"></div>
									<?php if($errors->has('nature')): ?>
									<div class="color-csp-clinic-two">
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
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="email_clinic" placeholder="E-mail Address of the clinic" id="email_clinic"
											value="<?php echo e(old('email_clinic', $draft_data ? ($draft_data->email ?? '') : ($clinic_data?->email ?? ''))); ?>" class="form-control">
									</div>
									<div id="erroremail_clinic" class="color-csp-clinic-two"></div>
									<?php if($errors->has('email_clinic')): ?>
									<div class="color-csp-clinic-two">
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
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="contactno" placeholder="Enter Contact number" id="contactno"
											value="<?php echo e(old('contact_number_clinic', $draft_data ? $draft_data->contactno : ($clinic_data->contact_number_clinic ?? ''))); ?>" class="form-control"
											maxlength="11">
									</div>
									<div id="errorcontactno" class="color-csp-clinic-two"></div>
									<?php if($errors->has('contactno')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('contactno')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="personname"><strong>Name
									of the Contact Person</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="personname" placeholder="Enter contact person name" id="personname"
											value="<?php echo e(old('personname', $draft_data ? ($draft_data->contact_person_name ?? '') : ($clinic_data?->contact_person_name ?? ''))); ?>" class="form-control" title="Only alphabetic characters are allowed" maxlength="100">
									</div>
									<div id="errorpersonname" class="color-csp-clinic-two"></div>
									<?php if($errors->has('personname')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('personname')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="mobilecontact"><strong>Mobile
									Number</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="mobilecontact" placeholder="Enter Mobile number" id="mobilecontact"
											value="<?php echo e(old('mobilecontact', $draft_data ? ($draft_data->contact_person_mobile ?? '') : ($clinic_data?->mobile ?? ''))); ?>" class="form-control"
											maxlength="10">
									</div>
									<div id="errormobilecontact" class="color-csp-clinic-two"></div>
									<?php if($errors->has('mobilecontact')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('mobilecontact')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="emailcontact"><strong>E-mail
									Address</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" name="emailcontact" placeholder="Enter a email address.." id = "emailcontact"
											value="<?php echo e(old('emailcontact', $draft_data ? ($draft_data->contact_person_email ?? '') : ($clinic_data?->contact_person_email ?? ''))); ?>" class="form-control">
									</div>
									<div id="erroremailcontact" class="color-csp-clinic-two"></div>
									<?php if($errors->has('emailcontact')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('emailcontact')); ?></strong>
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
										<input type="text" name="fax" placeholder="Enter fax number " id="fax"
											class="form-control" value="<?php echo e(old('fax', $draft_data ? ($draft_data->fax ?? '') : ($clinic_data?->fax_number ?? ''))); ?>"
											maxlength="11">
									</div>
									<div id="errorfax" class="color-red-fourtyseven"></div>

									<?php if($errors->has('fax')): ?>
										<div class="color-csp-clinic-two">
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
										<input type="text" name="website" placeholder="Eenter website URL" id="website"
											class="form-control" value="<?php echo e(old('website', $draft_data ? ($draft_data->website ?? '') : ($clinic_data?->website ?? ''))); ?>">
									</div>
									<div id="errorwebsite" class="color-red-fourtyseven"></div>

									<!-- <?php if($errors->has('website')): ?>
										<div class="color-csp-clinic-two">
										    <strong><?php echo e($errors->first('website')); ?></strong>
										</div>
										<?php endif; ?> -->
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="datepicker"><strong>
									Date of establishment of your Surrogacy Clinic</strong><span
										class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<input type="text" 
											name="dateestab"
			                                class="datepicker-default form-control" 
			                                value="<?php echo e($clinic_data->date_of_establishment ? \Carbon\Carbon::parse($clinic_data->date_of_establishment)->format('d-m-Y'): ''); ?>" 
			                                readonly
			                                >

		                            	<input type="hidden" 
			                             	name="dateestab"
			                                class="datepicker-default form-control" 
                                 			value="<?php echo e($clinic_data->date_of_establishment ?? ''); ?>"
                             			>
									</div>
									<div id="errordatepicker" class="color-csp-clinic-two"></div>
									<?php if($errors->has('dateestab')): ?>
									<div class="color-csp-clinic-two">
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
			                            <input type="text" name="rgistration_date" class="datepicker-default form-control" value="<?php echo e(date('d-m-Y',strtotime($clinic_data->rgistration_date ))); ?>" readonly>
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
									Whether your Surrogacy Clinic is registered under MTP
									Act</strong><span class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<select name="mtpact" id="mtpact"
											class="nice-select default-select wide form-control solid">
											<option value="">Select</option>
											<option value="Yes" <?php echo e(old('mtpact', $draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ??'') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
											<option value="No"  <?php echo e(old('mtpact', $draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
										</select>
									</div>
									<div id="errormtpact" class="color-csp-clinic-two"></div>
									<?php if($errors->has('mtpact')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('mtpact')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="mb-3">
									<label class="text-label form-label"
										for="pcpndtact"><strong>3.
									Whether your Surrogacy Clinic is registered under PCPNDT
									Act</strong><span class="color-csp-clinic-two">*</span></label>
									<div class="input-group">
										<select name="pcpndtact" id="pcpndtact"
											class="nice-select default-select wide form-control solid">
											<option value="">Select</option>
											<option value="Yes" <?php echo e(old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
											<option value="No" <?php echo e(old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ??  '') == 'No' ? 'selected' : ''); ?>>No</option>
										</select>
									</div>
									<div id="errorpcpndtact" class="color-csp-clinic-two"></div>
									<?php if($errors->has('pcpndtact')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('pcpndtact')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<label class="text-label form-label"
										for="director"><strong>4.Whether your Surrogacy Clinic has
									Director</strong><span class="color-csp-clinic-two">*</span></label>
									<div class="input-group" >
										<select id="director" name="director"
											class="nice-select default-select wide form-control solid">
											<option value="">Select</option>
											
											  <option value="Yes" <?php echo e(old('director', $draft_data->director ?? $clinic_data->clinic_director ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
                                              <option value="No" <?php echo e(old('director', $draft_data->director ?? $clinic_data->clinic_director ?? '') == 'No' ? 'selected' : ''); ?>>No</option>

										</select>
									</div>
									<div id="errordirector" class="color-csp-clinic-two"></div>
									<?php if($errors->has('director')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('director')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
							<div id="directory" data-section="directors" class="col-xs-12 form-group display-none-csp-clinic-one <?php echo e(old('director', $draft_data->director ?? $clinic_data->clinic_director ??  '') == 'Yes' ? '' : 'display:none;'); ?>" id="directors-section">
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
								        <th>Name<span class="color-csp-clinic-two">*</span></th>
								        <th>Qualification<span class="color-csp-clinic-two">*</span></th>
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
								<?php $__errorArgs = ['quali_director.'.$index];
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
				                <input type="text" name="reg_director[]" class="form-control"
				                       value="<?php echo e($director['reg_director'] ?? ''); ?>">
									  <?php $__errorArgs = ['reg_director.'.$index];
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
							    <button type="button" id="<?php echo e($index+1); ?>" class="btn btn-danger btn_remove1">
							        <i class="fa fa-trash"></i>
							    </button>
							</td>
        				</tr>
					    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
					        
					        <tr class="director-row" id="drow1">
					            <td><input type="text" name="name_director[]" class="form-control">
								
								</td>
					            <td>
					                <select name="quali_director[]" class="form-control">
					                    <option value="">Select</option>
					                    <?php $__currentLoopData = ['PhD','DM','MCh','PG','MD','MS','DNB']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					                        <option value="<?php echo e($q); ?>"><?php echo e($q); ?></option>
					                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                </select>
					            </td>
					            <td><input type="text" name="reg_director[]" class="form-control"></td>
					              <td>
					                
					              </td>
					    
					</td> 
					        </tr>
					    <?php endif; ?>
					</table>

					<div align="right">
						<button type="button" name="adddirector" id="adddirector" 
							class="btn-xs bc-bc-color-csp-clinic-three"><i class="fa fa fa-plus"></i></button>
					</div>
						</div>
					</div>
							<!--  -->
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
                    <label class="control-label"><strong>5. Provided details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <thead>
                                <tr>
                                    <th>Post<span class="color-csp-clinic-two">*</span></th>
                                    <th>Name<span class="color-csp-clinic-two">*</span></th>
                                    <th>Qualification<span class="color-csp-clinic-two">*</span></th>
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
                            <button type="button" name="addotherstaff" id="addotherstaff" class="btn-xs bc-bc-color-csp-clinic-three"><i class="fa fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
			</div>
				<button type="button" class="btn btn-primary bc-bc-color-csp-clinic-three"  id="next-step">Next</button>
			</div>
					<!-- Step 2 -->
					<div id="step-2" class="step d-none">
						<div class="row">
							<?php
							$equipmentsData = old('equipmentname')
							? collect(old('equipmentname'))->map(fn($eq) => (object)['equipmentname' => $eq])
							: ($equipment ?? collect([ (object)['equipmentname' => ''] ]));
							// dd( $equipmentsData);
							?>
							<h3 class="bc-color-csp-clinic-four">Procedures</h3>
							<div id="equipment" class="col-xs-12 form-group">
								<label class="control-label">6. Provide list of Equipment's</label>
								<div class="table-responsive">
									<table class="table table-bordered" id="crud_table_equipments">
									    <tr>
									        <th>Name of Equipments<span class="color-csp-clinic-two">*</span></th>
									        <th></th>
									    </tr>
									    <?php $__empty_1 = true; $__currentLoopData = $equipmentsData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
								        <tr class="equipment-row" id="row1<?php echo e($i+1); ?>">
								            <td>
								                <input type="text" id="equipmentname" name="equipmentname[]"
								                       value="<?php echo e($row->equipmentname ?? ''); ?>"
								                       placeholder="" class="form-control equipmentname">
								                <div id="errorequipmentname" class="color-csp-clinic-two"></div>
								                <?php $__errorArgs = ['equipmentname.' . $i];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								                <div class="color-csp-clinic-two"><strong><?php echo e($message); ?></strong></div>
								                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								            </td>
								            <td>
								                <button type="button" id="<?php echo e($i+1); ?>" class="btn btn-danger btn_remove_addEQ">
								                    <i class="fa fa-trash"></i>
								                </button>
								            </td>
								        </tr>
									    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
								        
								        <tr id="row11" class="equipment-row">
								            <td>
								                <input type="text" id="equipmentname" name="equipmentname[]"
								                       value="" placeholder="" class="form-control">
								                <div id="errorequipmentname" class="color-csp-clinic-two"></div>
								                <?php $__errorArgs = ['equipmentname.0'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								                <div class="color-csp-clinic-two"><strong><?php echo e($message); ?></strong></div>
								                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								            </td>
								            <td>
								                
								            </td>
								        </tr>
									    <?php endif; ?>
									</table>
									<div align="right">
										<button type="button" name="addequipment" id="addequipment"
											class="btn-xs bc-bc-color-csp-clinic-three">+</button>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="mb-3">
									<label class="control-label" for=""><strong>7. Indicate which of the
									following ART
									procedures are being routinely carried out at
									your Surrogacy Clinic
									</strong></label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="mb-3">
										<label class="text-label form-label"
											for="iuih"><strong>i).
										Intra-uterine Insemination using Husband Semen (IUI-H)<span
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="iuih" id="iuih"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes" <?php echo e(old('iui_h_s',$draft_data->iuih ??  $clinic_data->iui_h_s ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No" <?php echo e(old('iui_h_s', $draft_data->iuih ?? $clinic_data->iui_h_s ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="erroriuih" class="color-csp-clinic-two"></div>
										<?php if($errors->has('iuih')): ?>
										<div class="color-csp-clinic-two">
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
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="iuid" id="iuid"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes"  <?php echo e(old('iui_d_s',$draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No"  <?php echo e(old('iui_d_s', $draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="erroriuid" class="color-csp-clinic-two"></div>
										<?php if($errors->has('iuid')): ?>
										<div class="color-csp-clinic-two">
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
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="ivfet" id="ivfet"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes"  <?php echo e(old('ivf_et', $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No" <?php echo e(old('ivf_et',  $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="errorivfet" class="color-csp-clinic-two"></div>
										<?php if($errors->has('ivfet')): ?>
										<div class="color-csp-clinic-two">
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
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="icsi" id="icsi"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes" <?php echo e(old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No" <?php echo e(old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="erroricsi" class="color-csp-clinic-two"></div>
										<?php if($errors->has('icsi')): ?>
										<div class="color-csp-clinic-two">
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
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="pgt" id="pgt"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes"  <?php echo e(old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No"  <?php echo e(old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="errorpgt" class="color-csp-clinic-two"></div>
										<?php if($errors->has('pgt')): ?>
										<div class="color-csp-clinic-two">
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
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="spermandoocyte" id="spermandoocyte"
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes" <?php echo e(old('spermandoocyte', $draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No" <?php echo e(old('spermandoocyte',$draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="errorspermandoocyte" class="color-csp-clinic-two"></div>
										<?php if($errors->has('spermandoocyte')): ?>
										<div class="color-csp-clinic-two">
											<strong><?php echo e($errors->first('spermandoocyte')); ?></strong>
										</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3">
										<label class="text-label form-label"
											for="anyotherprocedure"><strong>vii). Any Other Procedure<span class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<select name="anyotherprocedure" id='anyotherprocedure'
												class="nice-select default-select wide form-control solid">
												<option value="">Select</option>
												<option value="Yes" <?php echo e(old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'Yes' ? 'selected' : ''); ?>>Yes</option>
												<option value="No" <?php echo e(old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'No' ? 'selected' : ''); ?>>No</option>
											</select>
										</div>
										<div id="erroranyotherprocedure" class="color-csp-clinic-two"></div>
										<?php if($errors->has('anyotherprocedure')): ?>
										<div class="color-csp-clinic-two">
											<strong><?php echo e($errors->first('anyotherprocedure')); ?></strong>
										</div>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="mb-3 display-none-csp-clinic-one" id='anyotherprocedurey' >
										<label class="text-label form-label"
											for="otherprocedure"><strong>If yes, please specify<span
											class="color-csp-clinic-two">*</span></strong></label>
										<div class="input-group">
											<input type="text" id="otherprocedure" name="otherprocedure"
												placeholder=""  value="<?php echo e(old('otherprocedure', $draft_data->otherprocedure ?? $clinic_data->otherprocedure ?? '')); ?>" class="form-control"
												maxlength="250">
										</div>
										<div id="errorotherprocedure" class="color-csp-clinic-two"></div>
									

										<?php if($errors->has('otherprocedure')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('otherprocedure')); ?></strong>
									</div>
									<?php endif; ?>
									</div>
								</div>
								<div class="col-md-12">
									<div class="mb-3">
										<label for="otherdetails" class="form-label"><strong>8. Any other details</strong></label>
										<textarea class="form-control" id="otherdetails" name="otherdetails"
											rows="4" cols="163" maxlength="500"><?php echo e(old('otherdetails', $draft_data->otherdetails ?? $clinic_data->any_other_detail ?? '')); ?></textarea>
										<?php if($errors->has('otherdetails')): ?>
										<div class="color-csp-clinic-two">
											<strong><?php echo e($errors->first('otherdetails')); ?></strong>
										</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-9 mb-4">
									<input type="checkbox" id="declaration" name="declaration"  >
									<b> I hereby declare that the entries in this form and the additional
									particulars , if any,furnished herewith are true to the best of my
									knowledge and belief.<span class="color-csp-clinic-two">*</span> </b>
									</br>
									<?php if(($reject ?? null) === 'Rejected'): ?>
									<hr>
										<span>✓✓ <b>Fees already paid <?php echo e($fees ?? '-'); ?>/-</b> </span>
									<?php endif; ?>
									
									<div id="errordeclaration" class="color-csp-clinic-two"></div>
									<?php if($errors->has('declaration')): ?>
									<div class="color-csp-clinic-two">
										<strong><?php echo e($errors->first('declaration')); ?></strong>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<button type="button" class="btn btn-secondary bc-bc-color-csp-clinic-three" id="prev-step">Back</button>
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
	    const draftButton = document.getElementById('draftButton');
	   if (draftButton) {
        draftButton.addEventListener('click', function(event) {
            if (!validatedraft()) {
				console.log('validate draft');
                event.preventDefault();
            }
        });
    }
});
</script><script nonce="<?php echo e($cspNonce); ?>">
function validatedraft() {
    if (!validatesubmit(true)) {   // true = draft mode
        return false;
    }
    return true; 
}
</script>

<script nonce="<?php echo e($cspNonce); ?>">
	document.addEventListener('DOMContentLoaded', function() {
	    const submitButton = document.getElementById('submitButton');
	    if (submitButton) {
	        submitButton.addEventListener('click', function(event) {
	            if (!validatesubmit()) {
			
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
	$(document).ready(function() {
	    $('#director').on('change', function() {
	        $("#namedirector").val('');
	        $("#quali_director").val('');
	        $("#regdirector").val('');
	        
	        if (this.value == 'Yes') {
	            $("#directory").show();
	            $("#namedirector").prop("disabled", false);
	            $("#quali_director").prop("disabled", false);
	            $("#regdirector").prop("disabled", false);
	        } else {
	            $("#directory").hide();
	            $("#namedirector").prop("disabled", true);
	            $("#quali_director").prop("disabled", true);
	            $("#regdirector").prop("disabled", true);
	        }
	    });
	
	    // trigger once on page load so draft value is respected
	    $('#director').trigger('change');
	});
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
	        $('#crud_table_director').append('<tr  class="director-row" id="drow1' + i +
	            '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control"></td><td><select id= "quali_director" name="quali_director[]" class="form-control"><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
	            i +
	            '" class="btn btn-danger btn_remove1"><i class="fa fa fa-trash"></i></button></td></tr>'
	        );
	    });
	  
        // Remove Director Row (keep at least 1 if director=Yes)
        $(document).on('click', '.btn_remove1', function(e) {
            e.preventDefault();
            var $tableBody = $('#crud_table_director');
            var $rows = $tableBody.find('.director-row');
            var directorVal = $('#director').val(); // Yes/No select box

            if ($rows.length > 1) {
                $(this).closest('tr').remove();
            } else {
                if (directorVal === "Yes") {
                    alert("At least one director row is required if clinic has a director.");
                } else {
                    // If director = No, allow removing the last row
                    $(this).closest('tr').remove();
                }
            }
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
<script nonce="<?php echo e($cspNonce); ?>" type="text/javascript">
	function validateAadhar(input) {
	    // Allow only numeric input
	    input.value = input.value.replace(/\D/g, '');
	
	    // Ensure the input is not more than 4 digits
	    if (input.value.length > 4) {
	        input.value = input.value.slice(0, 4);
	    }
	}
</script>
<script nonce="<?php echo e($cspNonce); ?>">

$(document).ready(function() {
    $(document).on('input.equipmentLimit', '#crud_table_equipments input[name="equipmentname[]"]', function () {
        if (this.value.length > 100) {
            this.value = this.value.substring(0, 100);
            alert(
                'Maximum 100 characters allowed for each equipment entry. ' +
                'If you need to add more equipment, please click on the "+" button.'
            );
            this.focus();
        }
    });
});

// MAIN VALIDATION FUNCTION
function validatesubmit(isDraft = false) {

    // =====================================================
    // DRAFT
    // =====================================================
    if (isDraft) {
        return confirm("Details have been saved in draft mode.");
    }

    // COMMON FUNCTIONS
    function focusElement(el) {
        if (!el) return false;

        // FIX: Handle Multi-Step Form Visibility
        // If the element is inside a hidden step, switch to that step before focusing
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        
        if (step1 && el.closest('#step-1') && step1.classList.contains('d-none')) {
            document.getElementById('prev-step').click();
        } else if (step2 && el.closest('#step-2') && step2.classList.contains('d-none')) {
            document.getElementById('next-step').click();
        }

        // Prevent native HTML5 validation bubbles from interfering
        el.removeAttribute('required');

        if (el.disabled || el.offsetParent === null) {
            return false;
        }

        el.scrollIntoView({ behavior: 'smooth', block: 'center' });

        setTimeout(function () {
            el.focus({ preventScroll: true });
        }, 300);

        return false;
    }

    function showError(el, message, errorId = null) {
        if (errorId) {
            const errorDiv = document.getElementById(errorId);
            if (errorDiv) {
                // Ensure the error displays with standard red styling
                errorDiv.innerHTML = `<strong class="text-danger">${message}</strong>`; 
            }
        }
        alert(message);
        return focusElement(el);
    }

    // SPECIAL CHARACTER VALIDATION
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

    // BASIC FIELDS
	const formFields = [
	    'clinicname', 'address', 'pincode', 'district', 'nature',
	    'email_clinic', 'contactno', 'personname', 'mobilecontact',
	    'emailcontact', 'fax', 'website'
	];

	const formLabels = {
	    clinicname: 'Clinic Name',
	    address: 'Address',
	    district: 'District',
	    pincode: 'Pincode',
	    nature: 'Nature of Organization',
	    email_clinic: 'Clinic Email',
	    contactno: 'Contact Number',
	    personname: 'Person Name',
	    mobilecontact: 'Mobile Contact',
	    emailcontact: 'Contact Email',
	    fax: 'Fax Number',
	    website: 'Website'
	};

	for (const id of formFields) {

	    const el = document.getElementById(id);
	    if (!el) continue;

	    const label = formLabels[id] || id;
	    const value = (el.value || '').trim();
	    const errorId = 'error' + id;

	    // Required except Fax and Website
	    if (!value && !['fax', 'website'].includes(id)) {
	        return showError(el, `${label} is required.`, errorId);
	    }

	    // Email
	    if (['email_clinic', 'emailcontact'].includes(id) &&
	        !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
	        return showError(el, `${label} must be a valid email address.`, errorId);
	    }

	    // Mobile
	   if (value && id === 'contactno' && !/^[0-9]{11}$/.test(value)) {
		    return showError(el, `${label} must be a valid 11-digit number.`, errorId);
		}

		if (value && id === 'mobilecontact' && !/^[0-9]{10}$/.test(value)) {
		    return showError(el, `${label} must be a valid 10-digit mobile number.`, errorId);
		}

	    // Person name
	    if (id === 'personname' && !/^[A-Za-z ]+$/.test(value)) {
	        return showError(el, `${label} must contain only alphabets and spaces.`, errorId);
	    }

	    // Pincode
	    if (id === 'pincode') {

	        const cleanPincode = value.replace(/\s/g, '');

	        if (!/^[1-9][0-9]{5}$/.test(cleanPincode)) {
	            return showError(el, `${label} must be a valid 6-digit number.`, errorId);
	        }

	        const availabilityMsg = document.getElementById('pincodeavailability');

	        if (availabilityMsg?.innerText.includes('Invalid')) {
	            return showError(el, `Please enter a real, valid Pincode.`, errorId);
	        }
	    }

	    // Optional Fax - validate only when entered
	    if (id === 'fax' && value && !/^\d{11}$/.test(value)) {
		    return showError(el, `${label} must be exactly 11 digits.`, errorId);
		}

	    // Optional Website - validate only when entered
	    if (id === 'website' && value &&
	        !/^(https?:\/\/)?([\w-]+\.)+[\w-]{2,}(\/.*)?$/i.test(value)) {
	        return showError(el, `${label} must be a valid website.`, errorId);
	    }

	    // Clear error
	    const errorDiv = document.getElementById(errorId);
	    if (errorDiv) errorDiv.innerHTML = '';
	}

    // DATE
    const datepicker = document.getElementById('datepicker');
    if (datepicker && !datepicker.value.trim()) {
        return showError(datepicker, 'Date of establishment cannot be blank', 'errordatepicker');
    }

    // MTP ACT & PCPNDT
    const mtpact = document.getElementById('mtpact');
    if (mtpact && !mtpact.value.trim()) {
        return showError(mtpact, 'MTP Act registration cannot be blank', 'errormtpact');
    }

    const pcpndtact = document.getElementById('pcpndtact');
    if (pcpndtact && !pcpndtact.value.trim()) {
        return showError(pcpndtact, 'PCPNDT Act registration cannot be blank', 'errorpcpndtact');
    }

    // DIRECTOR
    const director = document.getElementById('director');

    if (director && !director.value.trim()) {
        return showError(director, 'Whether your Clinic has Director cannot be blank', 'errordirector');
    }

    if (director && director.value === 'Yes') {
        const directorNames = document.querySelectorAll('input[name="name_director[]"]');
        const directorQualis = document.querySelectorAll('select[name="quali_director[]"]');

        // 1. FIX: Remove all old error messages before checking again
        document.querySelectorAll('.director-error').forEach(el => el.remove());

        if (directorNames.length === 0) {
            alert('At least one director row is required.');
            return false;
        }

        for (let i = 0; i < directorNames.length; i++) {

            // Director Name
            if (!directorNames[i].value.trim()) {
                // 2. FIX: Added 'd-block mt-1' to put the error on a new line below the input
                directorNames[i].insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger font-weight-bold d-block mt-1 director-error">Director Name cannot be blank</span>'
                );

                alert('Director Name cannot be blank');
                // 3. FIX: Use your custom focus function
                return focusElement(directorNames[i]); 
            }

            if (!/^[A-Za-z ]+$/.test(directorNames[i].value.trim())) {

			    directorNames[i].insertAdjacentHTML(
			        'afterend',
			        '<span class="text-danger font-weight-bold d-block mt-1 director-error">Director Name must contain only alphabets and spaces</span>'
			    );

			    alert('Director Name must contain only alphabets and spaces');
			    return focusElement(directorNames[i]);
			}

            // Director Qualification
            if (!directorQualis[i] || !directorQualis[i].value.trim()) {
                
                directorQualis[i].insertAdjacentHTML(
                    'afterend',
                    '<span class="text-danger font-weight-bold d-block mt-1 director-error">Director Qualification cannot be blank</span>'
                );

                alert('Director Qualification cannot be blank');
                return focusElement(directorQualis[i]);
            }
        }
    }

	const staffRows = document.querySelectorAll('#crud_table_otherstaff .staff-row');
	for (const row of staffRows) {

	    const postInput = row.querySelector('select[name="post[]"]');
	    const nameInput = row.querySelector('input[name="name_otherstaff[]"]');
	    const qualInput = row.querySelector('select[name="quali_otherstaff[]"]');

	    const anyPost = row.querySelector('input[name="anyotherpost[]"]');
	    const anyDegree = row.querySelector('input[name="anyotherdegree[]"]');

	    // Remove old errors
	    row.querySelectorAll('.staff-validation-error')
	        .forEach(error => error.remove());

	    // Post
	    if (postInput && !postInput.value.trim()) {

	        postInput.insertAdjacentHTML(
	            'afterend',
	            '<span class="text-danger staff-validation-error d-block">Post of staff cannot be blank</span>'
	        );

	        alert('Post of staff cannot be blank');
	        postInput.focus();
	        return false;
	    }

	    // Any Other Post
	    if (postInput && postInput.value === 'Any Other') {

	        if (!anyPost || !anyPost.value.trim()) {

	            const field = anyPost || postInput;

	            field.insertAdjacentHTML(
	                'afterend',
	                '<span class="text-danger staff-validation-error d-block">Name of the other Post cannot be blank</span>'
	            );

	            alert('Name of the other Post cannot be blank');
	            field.focus();
	            return false;
	        }
	    }

	    // Name
	    if (nameInput && !nameInput.value.trim()) {

	        nameInput.insertAdjacentHTML(
	            'afterend',
	            '<span class="text-danger staff-validation-error d-block">Name of staff cannot be blank</span>'
	        );

	        alert('Name of staff cannot be blank');
	        nameInput.focus();
	        return false;
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
	    if (qualInput && !qualInput.value.trim()) {

	        qualInput.insertAdjacentHTML(
	            'afterend',
	            '<span class="text-danger staff-validation-error d-block">Qualification of staff cannot be blank</span>'
	        );

	        alert('Qualification of staff cannot be blank');
	        qualInput.focus();
	        return false;
	    }

	    // Any Other Qualification
	    if (qualInput && qualInput.value === 'Any Other') {

	        if (!anyDegree || !anyDegree.value.trim()) {

	            const field = anyDegree || qualInput;

	            field.insertAdjacentHTML(
	                'afterend',
	                '<span class="text-danger staff-validation-error d-block">Other Qualification cannot be blank</span>'
	            );

	            alert('Other Qualification cannot be blank');
	            field.focus();
	            return false;
	        }
	    }
	}

    // EQUIPMENT
    const equipments = document.querySelectorAll('#crud_table_equipments input[name="equipmentname[]"]');

    if (equipments.length === 0) {
        alert('At least one equipment row is required.');
        return false;
    }

    for (const equipment of equipments) {
        const value = equipment.value.trim();
        if (!value) {
            return showError(equipment, 'Equipment name is required.');
        }
        if (value.length > 100) {
            return showError(equipment, 'Maximum 100 characters allowed for each equipment entry.');
        }
    }

    // PROCEDURES
    const procedureFields = [
        { id: 'iuih', msg: 'IUI-H cannot be blank' },
        { id: 'iuid', msg: 'IUI-D cannot be blank' },
        { id: 'ivfet', msg: 'IVF-ET cannot be blank' },
        { id: 'icsi', msg: 'ICSI cannot be blank' },
        { id: 'pgt', msg: 'PGT cannot be blank' },
        { id: 'spermandoocyte', msg: 'Gamete/embryo processing cannot be blank' },
        { id: 'anyotherprocedure', msg: 'Any Other Procedure cannot be blank' }
    ];

    for (const field of procedureFields) {
        const el = document.getElementById(field.id);
        if (el && !el.value.trim()) {
            return showError(el, field.msg, 'error' + field.id);
        }
    }

    // OTHER PROCEDURE
    const anyOtherProcedure = document.getElementById('anyotherprocedure');
    const otherProcedure = document.getElementById('otherprocedure');

    if (anyOtherProcedure && anyOtherProcedure.value === 'Yes') {
        if (!otherProcedure || !otherProcedure.value.trim()) {
            return showError(otherProcedure, 'Details of other procedure cannot be blank', 'errorotherprocedure');
        }
    }

    // DECLARATION
    const declaration = document.getElementById('declaration');

    if (!declaration || !declaration.checked) {
        alert('Please accept the declaration before submitting.');
        return focusElement(declaration); // uses our updated focus method
    }

    // FINAL CONFIRMATION
    return confirm(
        'Kindly check and confirm all details before final submission.' +
        'There is no provision for editing/correction once application form submitted.'
    );
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.clinic.clinic_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/change_address/surrogacy_application_form.blade.php ENDPATH**/ ?>