@extends('layouts.clinic.clinic_master')
@section('content')

<style nonce="{{$cspNonce}}">
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
.width-csp-clinic-one{
width: 48%;
}
.width-csp-clinic-two{
color: red;
}
.bcbc-csp-clinic-three{
background-color: #0b5ed7; border-color: #0b5ed7; color: white;
}
.dn-csp-clinic-four{
display:none;
}
 .hidden {
        display: none;
    }

  </style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">       
            <div class="card-body">  
                @if (session('message_update'))
    <div class="alert alert-success">
        {{ session('message_update') }}
    </div>
@endif
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

        {{-- <title>Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
            and Outside India)</title> --}}

        {{-- <div class="container mt-5"> --}}
            <h3 class="card-title mb-5 text-primary">Edit Donor information form for ART Bank testing </h3>
            
            <!-- Step Indicators -->
            {{-- <div class="step-indicator">
                <div id="indicator-1" class="indicator active"></div>
                <div id="indicator-2" class="indicator"></div>
              <div id="step-1-indicator" class="active">Step 1</div>
              <div id="step-2-indicator" class="inactive">Step 2</div>
            </div> --}}
            <!-- Progress Bar -->
  {{-- <div class="progress mb-4" style="height: 20px;">
    <div 
      id="progress-bar" 
      class="progress-bar progress-bar-striped progress-bar-animated" 
      role="progressbar" 
      style="width: 50%;" 
      aria-valuenow="50" 
      aria-valuemin="0" 
      aria-valuemax="100">
      Step 1 of 2
    </div>
  </div> --}}
            
            <!-- Form -->
            {{-- <form id="form-wizard" method="POST" action="{{ route('clinic.save_clinic_application_form') }}" enctype="multipart/form-data"> --}}
              <!-- Step 1 -->
            
              <form name="art_clin1" method="POST" action="{{ route('clinic.patient_save_art_bank_application_form_edit_patient') }}" enctype="multipart/form-data">                             
                @csrf
				 @if ($uhidDetails)
                <input type="hidden" name="report_id" value="{{ $uhidDetails->id }}">
                @endif
                <div class="row">

                        {{-- @php
                        $currentYear = date('Y');
                    @endphp --}}
                    @php
                    $currentYear = date('Y');
                    $currentQuarter = ceil(date('n') / 3);
                    @endphp

                    <div class="col-md-3">
                    <div class="mb-3">
                        {{-- <label class="form-label d-block">
                            <strong>Quarter and Year</strong>
                        </label> --}}
                        <div class="d-flex gap-3">
                          
                             <input type="hidden" class="form-control width-csp-clinic-one"  name="quarter" value="{{ $uhidDetails->quarter }}" readonly>
                            
                                <input type="hidden" class="form-control width-csp-clinic-one"  name="year" value="{{ $uhidDetails->year }}" readonly>
                        </div>                        
                    </div>
                    </div>                   

                </div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label d-block">
							<strong>Had received treatment from us previously</strong>
						</label>
						<div class="d-flex align-items-center gap-3">
							<div class="form-check">
								<input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_yes" value="Yes" {{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'Yes') ? 'checked' : '' }}>
								<label class="form-check-label" for="treatment_yes">
									Yes
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_no" value="No" {{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'No') ? 'checked' : '' }}>
								<label class="form-check-label" for="treatment_no">
									No
								</label>
							</div>
						</div>
						<span id="bank_reg_numID"  class="width-csp-clinic-two">
							<?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;} ?>
						</span>
					</div>
				</div>
                <div class="row">				
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Bank Registration
                                    Number</strong></label>
                            <div class="input-group">
                                <input type="text"
                                    value="{{ $uhidDetails->bank_reg_num }}"
                                    class="form-control" name="bank_reg_num" id="bank_reg_num"
                                    aria-describedby="bank_reg_num" placeholder="" readonly>
                            </div>
                            <span id="bank_reg_numID"
                                 class="width-csp-clinic-two"><?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;} ?></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Name of the Bank</strong></label>
                            <div class="input-group">
                                <input type="text" value="{{ $uhidDetails->name_of_bank }}"
                                    class="form-control" name="name_of_bank" id="name_of_bank"
                                    aria-describedby="name_of_bank" placeholder="" readonly>
                            </div>
                            <span id="name_of_bankID"
                                class="width-csp-clinic-two"><?php //if(isset($notice_name_of_bank)){ echo $notice_name_of_bank;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Donor UHID</strong><span class="width-csp-clinic-two"
                                    >*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="donor_id" id="donor_id"
                                    aria-describedby="donor_id" value="{{ $uhidDetails->donor_id }}" placeholder="" maxlength="10" readonly>
                            </div>
                            <span id="availability"></span>
                            @error('donor_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>                
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Gender</strong><span
                                class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="gender_donor" id="gender_donor" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Male" {{ old('nationality', $uhidDetails->gender_donor ?? '') == 'Male' ? 'selected' : '' }} class="p-1">Male</option>
                                    <option value="Female" class="p-1" {{ old('nationality', $uhidDetails->gender_donor ?? '') == 'Female' ? 'selected' : '' }}>Female</option>

                                </select>
                            </div>
                            @error('gender_donor')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-2" id="d_age" {{ old('donor_age', $uhidDetails->donor_age ?? '') ? '' : 'hidden' }}>
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age</strong><span
                                    class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">                               
                                <select name="donor_age" id="donor_age" class="form-control"
                                    aria-label=".form-select-lg example">

                                    <option value="" class="text-muted"><strong><b>Select Age</b></strong></option>
                                    <?php for($i = 21; $i <= 55; $i++) {
                                        $selected = ($i == old('donor_age', $uhidDetails->donor_age ?? '')) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    } ?>

                                </select>
                            </div>
                            @error('donor_age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>


                   


                    <div class="col-md-2" id="o_age" {{ old('oocyte_age', $uhidDetails->oocyte_age ?? '') ? '' : 'hidden' }}>
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age</strong><span
                                   class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">                               
                                <select name="oocyte_age" id="oocyte_age" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select Age</b></strong>
                                    </option>
                                    <?php for($i = 23; $i <= 35; $i++) {
                                        $selected = ($i == old('oocyte_age', $uhidDetails->oocyte_age ?? '')) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    } ?>

                                </select>

                            </div>
                            @error('oocyte_age')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Marital status</strong><span
                                    class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="marital_status" id="marital_status" class="form-control"
                                    aria-label=".form-select-lg example" >
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Married" class="p-1" {{ old('marital_status', $uhidDetails->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Single" class="p-1" {{ old('marital_status', $uhidDetails->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>

                                </select>
                            </div>
                            @error('marital_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Nationality</strong><span
                                     class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="nationality" id="nationality" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Indian" class="p-1" {{ old('nationality', $uhidDetails->nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                    <option value="Foreigner" {{ old('nationality', $uhidDetails->nationality ?? '') == 'Foreigner' ? 'selected' : '' }}>Foreigner</option>
                                    {{-- <option value="Others" class="p-1">Others</option> --}}

                                </select>

                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 dn-csp-clinic-four" id="other_nationality1" >
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span class="
                                    width-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="other_nationality" id="other_nationality" class="form-control">                               
                                    <option value="">-- Select Country --</option>
                                    @if ($countries->count() > 0)
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('other_nationality', $uhidDetails->other_nationality ?? '') == $country->id ? 'selected' : '' }}>
                                                {{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Countries Available</option>
                                    @endif
                                </select>

                            </div>
                        </div>
                    </div>
                     

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong
                                    id="heading_gamete">Oocyte details ( No of Oocyte(s) stored )
                                </strong><span  class="width-csp-clinic-two">*</span></label>
                            <div class="input-group">
                            <select name="gamete_details" id="gamete_details" class="form-control"
                                    aria-label=".form-select-lg example">

                                 <option value="" class="text-muted"><strong><b>Select Age</b></strong></option>
                                    <?php for($i = 1; $i <= 20; $i++) {
                                        $selected = ($i == old('gamete_details', $uhidDetails->gamete_details ?? '')) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    } ?>
                                   
                                </select>





                                <!--input type="number" class="form-control" name="gamete_details"
                                    id="gamete_details" min="0"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"-->

                            </div>
                            @error('gamete_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Complications, if
                                    any</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" col="5" rows="3"
                                    name="complicatoins_if_any" id="complicatoins_if_any">{{ old('complicatoins_if_any', $uhidDetails->complicatoins_if_any ?? '') }}</textarea>
                            </div>
                            <span id="complicatoins_if_anyID"
                                 class="width-csp-clinic-two"><?php // if(isset($comp_if_any)){ echo $comp_if_any;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Remarks/ Any other relevant
                                    information</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" col="5" rows="3" id="remark"
                                    name="remark">{{ old('remark', $uhidDetails->remark ?? '') }}</textarea>
                            </div>
                            <span id=""
                                 class="width-csp-clinic-two"><?php // if(isset($remark)){ echo $remark;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Required Affidavit regarding
                                    following to be taken on record:</strong></label>
                            <div class="col-12" id="declaration_hide">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                        id="declaration" name="declaration" {{ old('declaration', $uhidDetails->declaration ?? '') === 'on' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridCheck">
                                        From Oocyte Donor that she has not donated oocytes more than once in her life time.
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                        id="declaration1" name="declaration1" {{ old('declaration1', $uhidDetails->declaration1 ?? '') === 'on' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridCheck">
                                        From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                {{-- <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button>  --}}
                
                <button type="button" id="btnClose" class="btn me-2 btn btn-danger">Close</button>


                        {{-- <button type="submit" name="submit" id="btnSubmit" onclick="return validatesubmit()"
                        class="btn me-2 bcbc-csp-clinic-three" >update</button> --}}

<button type="submit" name="submit" id="btnSubmit" class="btn me-2 bcbc-csp-clinic-three">Update</button>



                {{-- <button type="submit" name="submit" value="continue" id="btnSubmit" onclick="return validatesubmit()" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" class="btn me-2">Continue patient details</button>
                <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button> --}}
            </form>



{{-- <div> --}}







</div>







    </div>
</div>
    </div>
</div>
</div>







<style>
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
  </style>
   <script nonce="{{ $cspNonce }}">
                            $(document).ready(function() {
                                // Show the fail_reason div if the value is already present
                                if ($('#other_nationality').val().trim() !== '') {
                                    $('#other_nationality1').show();
                                }           
                            });
                        </script>
   {{-- <script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#donor_age').on('input', function() {
            var age = parseInt($(this).val());
            
            if (isNaN(age)) {
                $('#ageError').text('Please enter a valid number.').show();
            } else if (age < 21 || age > 55) {
                $('#ageError').text('Age must be between 21 and 55.').show();
            } else {
                $('#ageError').hide();
            }
        });
        $('#oocyte_age').on('input', function() {
            var age = parseInt($(this).val());
            
            if (isNaN(age)) {
                $('#ageErroroocyte').text('Please enter a valid number.').show();
            } else if (age < 21 || age > 55) {
                $('#ageErroroocyte').text('Age must be between 23 and 35.').show();
            } else {
                $('#ageErroroocyte').hide();
            }
        });

    });
    </script> --}}
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const yearSelect = document.getElementById('yearSelect');
        const quarterSelect = document.getElementById('quarterSelect');

        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth() + 1; // 1-based

        // Determine current financial quarter
        let currentFinQuarter;
        if (currentMonth >= 4 && currentMonth <= 6) {
            currentFinQuarter = 1; // Q1 (Apr-Jun)
        } else if (currentMonth >= 7 && currentMonth <= 9) {
            currentFinQuarter = 2; // Q2 (Jul-Sep)
        } else if (currentMonth >= 10 && currentMonth <= 12) {
            currentFinQuarter = 3; // Q3 (Oct-Dec)
        } else {
            currentFinQuarter = 4; // Q4 (Jan-Mar)
        }

        function filterQuarters() {
            const selectedYear = parseInt(yearSelect.value);

            Array.from(quarterSelect.options).forEach(option => {
                const qNum = parseInt(option.getAttribute('data-quarter'));

                if (!qNum || isNaN(selectedYear)) {
                    option.hidden = false;
                    return;
                }

                if (selectedYear === currentYear) {
                    // Show only current financial quarter
                    option.hidden = qNum !== currentFinQuarter;
                } else {
                    option.hidden = false;
                }
            });

            const selectedOption = quarterSelect.selectedOptions[0];
            if (selectedOption && selectedOption.hidden) {
                quarterSelect.selectedIndex = 0;
            }
        }

        yearSelect.addEventListener('change', filterQuarters);
        filterQuarters();
    });
</script>



  {{-- <script nonce="{{ $cspNonce }}">
    $('#nationality').on('change', function() {
        // console.log('hello');
        //alert('helooo');
        $("#other_nationality").val('');
        if (this.value == 'Foreigner') {
            $("#country_applicant_display").show();
        } else {
            $("#country_applicant_display").hide();
        }
    });
</script> --}}
<script nonce="{{ $cspNonce }}">
    $('#gender_donor').on('change', function() {
        $("#name_spouse").val('');
        $("#aadhar_spouse").val('');
        $("#pan_spouse").val('');
        $("#dob_spouse").val('');
        if (this.value == 'Male') {
            $("#oocyte_age").show();
            $("#spouse_info").show();
            $("#copy_aadhar_card_spouse1").show();
            $("#copy_passport_spouse1").show();
            $("#sign_spouse1").show();
            $("#dob_proof_s").show();
        } else {
            $("#name_spouse_display").hide();
            $("#spouse_info").hide();
            $("#copy_aadhar_card_spouse1").hide();
            $("#copy_passport_spouse1").hide();
            $("#sign_spouse1").hide();
            $("#dob_proof_s").hide();
        }
    });
    </script>
    
    
    <script nonce="{{ $cspNonce }}">
    $('#sel2').on('change', function() {
        if (this.value == 'others') {
            $("#others_id").show();
        } else {
            $("#others_id").hide();
        }
    });
    </script>
    <script nonce="{{ $cspNonce }}">
    $('#nationality').on('change', function() {
        if (this.value == 'Foreigner') {
            $("#other_nationality1").show();
        } else {
            $("#other_nationality1").hide();
            $('#other_nationality').val('');
        }
    });
    </script>
   <script nonce="{{ $cspNonce }}">
    $('#gender_donor').on('change', function() {
        if (this.value == 'Male') {
            $("#declaration_hide").hide();
        } else {
            $("#declaration_hide").show();            
        }
    });
    </script>







    <script nonce="{{ $cspNonce }}">
    $('#gender_donor').on('change', function() {
        $("#donor_age").val('');
        $("#oocyte_age").val('');
        if (this.value == 'Male') {
            $("#d_age").show();
            $("#o_age").hide();
            $("#heading_gamete").text('Semen Detail (in vials)');
        } else if (this.value == 'Female') {
            $("#o_age").show();
            $("#d_age").hide();
            $("#heading_gamete").text('Oocyte details ( No of Oocyte(s) stored )');
        } else if (this.value == '') {
            $("#o_age").hide();
            $("#d_age").hide();
            $("#heading_gamete").text('Oocyte details ( No of Oocyte(s) stored ) )');
        }
    
    });
    </script>
     <script nonce="{{ $cspNonce }}">
    function validatesubmit() {
        if (document.getElementById("donor_id").value == "") {
            alert("Donor UHID cannot be blank");
            document.getElementById("donor_id").focus();
            return false;
        }
        if ((document.getElementById("gender_donor").value == "Female") && (!document.getElementById("declaration").checked)) {
            alert("Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time.");
            document.getElementById("declaration").focus();
            return false;
        }
        if ((document.getElementById("gender_donor").value == "Female") && (!document.getElementById("declaration1").checked)) {
            alert("Check the undertaking From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.");
            document.getElementById("declaration1").focus();
            return false;
        }
        if ((document.getElementById("gender_donor").value == "Male") && (!document.getElementById("declaration1").checked)) {
            alert("Check the undertaking From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.");
            document.getElementById("declaration1").focus();
            return false;
        }  
        if (document.getElementById("gender_donor").value == "") {
            alert("Donor Gender cannot be blank");
            document.getElementById("gender_donor").focus();
            return false;
        }
        if ((document.getElementById("gender_donor").value == "Male") && (document.getElementById(
                "donor_age").value == "")) {
            alert("Sperm Donor age cannot be blank");
            document.getElementById("donor_age").focus();
            return false;
        }
        if ((document.getElementById("gender_donor").value == "Female") && (document.getElementById(
                "oocyte_age").value == "")) {
            alert("Oocyte Donor age cannot be blank");
            document.getElementById("oocyte_age").focus();
            return false;
        }
        if (document.getElementById("marital_status").value == "") {
            alert("Marital Status cannot be blank");
            document.getElementById("marital_status").focus();
            return false;
        }        
        if (document.getElementById("nationality").value == "") {
            alert("Nationality cannot be blank");
            document.getElementById("nationality").focus();
            return false;
        }
        if ((document.getElementById("nationality").value == "Foreigner") && (document.getElementById(
                "other_nationality").value == "")) {
            alert("Please specify Country");
            document.getElementById("other_nationality").focus();
            return false;
        }
        if (document.getElementById("gamete_details").value == "") {
            alert("Oocyte/Semen Details cannot be blank");
            document.getElementById("gamete_details").focus();
            return false;
        }
        var agree = confirm(
            "Kindly check and confirm all details before final submission. There is no provision for editing/correction once form is submitted."
        );
        if (agree) {
    
            return true;
        } else {
            return false;
        }
        return true;
    }
    </script>

{{-- <script nonce="{{ $cspNonce }}">
    $(document).on('blur', '#donor_id', function () {
    var donor_id = $(this).val();  
    if (donor_id == "") {
        $('#availability').html('');
    } else {
        $.ajax({
            url: '{{ route('clinic.bankcheckuhid') }}', // Laravel route
            method: "POST",
            data: {
                donor_id: donor_id,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
            },
            success: function (response) {
                if (response.status === 'exists') {
                    $('#availability').html(
                        '<span class="text-success">UHID already exists with National ART & Surrogacy Portal.</span>'
                    );
                    $('#btnSubmit').attr("disabled", true);
                }                
                 else {
                    $('#availability').html(
                        '<span class="text-primary">UHID available for submission of application form.</span>'
                    );
                    $('#btnSubmit').attr("disabled", false);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }
});

</script> --}}
<script nonce="{{ $cspNonce }}">
function checkUHID() {
    var donor_id = $('#donor_id').val();
    var treatmentStatus = $('input[name="previous_treatment"]:checked').val();

    if (donor_id === "") {
        $('#availability').html('');
      //  $('#btnSubmit').attr("disabled", true);
        return;
    }

    $.ajax({
        url: '{{ route('clinic.bankcheckuhid') }}',
        method: "POST",
        data: {
            donor_id: donor_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // if (response.status === 'exists') {
            //     $('#availability').html(
            //         '<span class="text-success">UHID Found for this ART Bank.</span>'
            //     );
            //     if (treatmentStatus === "Yes") {
            //         $('#btnSubmit').attr("disabled", false);
            //     }
            // }
            if (response.status === 'exists') {
                if (treatmentStatus === "Yes") {
                    $('#availability').html('<span class="text-success">UHID Found for this ART Bank.</span>');
                    $('#btnSubmit').attr("disabled", false);
                } else if (treatmentStatus === "No") {
                    $('#availability').html('<span class="text-danger">UHID already exists.</span>');
                    $('#btnSubmit').attr("disabled", true);
                } else {
                    $('#availability').html('');
                    $('#btnSubmit').attr("disabled", true);
                }
            }
            
            else {
                if (treatmentStatus === "Yes") {
                    $('#availability').html('<span class="text-danger">UHID does not exist for this ART Bank. Kindly enter correct UHID.</span>');
                    $('#btnSubmit').attr("disabled", true);
                } else {
                    $('#availability').html('');
                    $('#btnSubmit').attr("disabled", false);
                }
            }
            
            
            
            
            
            
            
            
            // else if(treatmentStatus === "Yes") {
            //     $('#availability').html(
            //         '<span class="text-danger">UHID does not exist for this ART Bank. Kindly enter correct UHID.</span>'
            //     );
            //     if (treatmentStatus === "Yes") {
            //         $('#btnSubmit').attr("disabled", true);
            //     } 
            // }
            //     else {
            //         $('#availability').html('');
            //         $('#btnSubmit').attr("disabled", false);
            //     }
          //  }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// Run when donor_id input loses focus
$(document).on('blur', '#donor_id', function () {
    checkUHID();
});

// Run when previous treatment radio is changed
$(document).on('change', 'input[name="previous_treatment"]', function () {
    checkUHID();
});
// Run when donor_id input loses focus
$(document).on('blur', '#donor_id', function () {
    checkUHID();
});

// Run when previous treatment radio is changed
$(document).on('change', 'input[name="previous_treatment"]', function () {
    checkUHID();
});

  $(document).ready(function () {
        $('#btnClose').on('click', function () {
            window.location.href = "{{ route('clinic.clinicForm_list') }}";   
        });
    });


 $(document).ready(function () {
        $('#btnSubmit').on('click', function (e) {
            if (!validatesubmit()) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });

</script>


@endsection