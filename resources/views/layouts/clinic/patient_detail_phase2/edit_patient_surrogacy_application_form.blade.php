@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
   input.select2-search__field {
   width: 150px !important;    
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
   .width-csp-clinic-one{
   width: 48%;
   }
   .clr-csp-clinic-two{
   display:none;
   }
   .dn-csp-clinic-three
   {
   color: grey;
   }
   .btn-csp-clinic-four
   {
   background-color: #0b5ed7; border-color: #0b5ed7; color: white;
   }
   .hidden {
   display: none;
   }

   .display-none {
    display: none;
}
</style>
<div class="container-fluid">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">
               {{ session('success') }}
            </div>
            @endif
            @if (session('message_update'))
            <div class="alert alert-success">
               {{ session('message_update') }}
            </div>
            @endif

            @if ($errors->any())
    <div class="alert alert-danger">
      
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            {{-- @if ($countries->isNotEmpty()) 
            @foreach ($countries as $country)
            <option value="{{ $country->id }}"
            {{ old('other_nationality', $uhidDetails->other_nationality ?? '') == $country->id ? 'selected' : '' }}>
            {{ $country->country_name }}
            </option>
            @endforeach
            @else
            <option value="">No Countries Available</option>
            @endif --}}
            <h3 class="card-title mb-5 text-primary">Edit Patient information form for Surrogacy Clinic </h3>
            <form name="art_clin1" method="POST" id="art_clin1" action="{{ route('clinic.patient_save_surrogacy_application_form_edit_patient') }}" enctype="multipart/form-data">
               @csrf
               @if ($uhidDetails)
               <input type="hidden" name="p_id" value="{{ $uhidDetails->id }}">
               {{-- <input type="hidden" name="report_id" value="{{ $uhidDetails->reporting_id }}"> --}}
               @endif
               @if ($clinic_id)
                <input type="hidden" name="clinic_id" value="{{ $clinic_id }}">
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
                           <input type="hidden" class="form-control width-csp-clinic-one" name="quarter" value="{{ $uhidDetails->quarter }}" readonly>
                           <input type="text" class="form-control width-csp-clinic-one"  name="year" value="{{ $uhidDetails->year }}" readonly>
                           <input type="text" class="form-control width-csp-clinic-one"  value="{{ $available_quarters['description'] ?? '' }}" readonly>
                        </div>
                     </div>
                  </div>
                  <!-- Previous Treatment Radio -->
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="form-label d-block">
                        <strong>Had received treatment from us previously</strong>
                        </label>
                        <div class="d-flex align-items-center gap-3">
                           <div class="form-check">
                              <input class="form-check-input" type="radio" name="previous_treatment1" id="previous_treatment_yes" value="Yes"{{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'Yes') ? 'checked' : '' }} disabled>
                              <label class="form-check-label" for="previous_treatment_yes">Yes</label>
                           </div>
                           <div class="form-check">
                              <input class="form-check-input" type="radio" name="previous_treatment1" id="previous_treatment_no" value="No" {{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'No') ? 'checked' : '' }} disabled>
                              <label class="form-check-label" for="previous_treatment_no">No</label>

                              <input type="hidden" value="{{ $uhidDetails->previous_treatment }}" name="previous_treatment">
                           </div>
                        </div>
                        <span id="bank_reg_numID" class="clr-csp-clinic-two"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Clinic Registration
                        Number</strong></label>
                        <div class="input-group">
                           <input type="text"
                              value="{{ $uhidDetails->cli_reg_name }}"
                              class="form-control" name="cli_reg_name"
                              id="cli_reg_name" aria-describedby="cli_reg_name"
                              placeholder="" data-validation="alphanumeric"
                              data-validation-allowing="_" readonly>
                        </div>
                        <span id="clinic_level1_reg_numID"
                           class="clr-csp-clinic-two"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Name of the
                        Clinic</strong></label>
                        <div class="input-group">
                           <input type="text" 
                           value="{{ $uhidDetails->name_of_clinic }}"
                           {{-- onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" --}}
                           class="form-control" name="name_of_clinic" id="name_of_clinic"
                           aria-describedby="name_of_clinic" placeholder="" readonly>
                        </div>
                        <span id="name_of_clinicID"
                           class="clr-csp-clinic-two"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="mb-3 ">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Patient
                        UHID</strong><span class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           <input type="text" class="form-control" name="pati_uhid"
                              id="pati_uhid" aria-describedby="patient_uhid" value="{{ $uhidDetails->pati_uhid }}" placeholder="" maxlength="10" readonly>
                        </div>
                        <!--span id="patient_uhidID" style="color: red;"></span-->
                        <span id="availability"></span>
                        @error('pati_uhid')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="mb-3">
                        <div class="col-md-12">
                           <div class="mb-3">
                              <label class="text-label form-label"
                                 for="validationCustomUsername"><strong> Case of :</strong></label>
                              <div class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="case_of"
                                    id="flexRadioDefault1" value="one"  {{ old('case_of', $uhidDetails->case_of ?? '') === 'one' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                    Couple
                                    </label>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="form-check">
                                    <input class="form-check-input" type="radio" name="case_of"
                                    id="flexRadioDefault2" value="two"  {{ old('case_of', $uhidDetails->case_of ?? '') === 'two' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                    Single Woman [widow/divorcee]
                                    </label>
                                 </div>
                              </div>
                              @error('case_of')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2 dn-csp-clinic-three" id="nationality_husband">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Nationality of the Husband</strong><span
                           class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           <select name="nationality" id="nationalityhusband" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select</b></strong>
                              </option>
                              <option value="Indian" class="p-1" {{ old('nationality', $uhidDetails->nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                              <option value="OCI Card Holders" {{ old('nationality', $uhidDetails->nationality ?? '') == 'OCI Card Holders' ? 'selected' : '' }}>OCI Card Holders</option>
                              {{-- 
                              <option value="Others" class="p-1">Others</option>
                              --}}
                           </select>
                        </div>
                        @error('nationality')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-4 dn-csp-clinic-three" id="other_nationality1" >
                     <div class="mb-3">
                        <label class="control-label"><strong>Country</strong><span
                           class="clr-csp-clinic-two">*</span></label>
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
                         {{-- <select name="other_nationality" id="other_nationality" class="form-control">
    @if (old('nationality', $uhidDetails->nationality ?? '') == 'Indian')
        <option value="Indian" {{ old('other_nationality', $uhidDetails->other_nationality ?? '') == 'Indian' ? 'selected' : '' }}>
            Indian
        </option>
    @else
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
    @endif --}}
</select>
                           {{-- 
                           <option value="">-- Select Country --</option>
                           @if ($countries->count() > 0)
                           @foreach ($countries as $country)
                           <option value="{{ $country->id }}">{{ $country->country_name }}
                           </option>
                           @endforeach
                           @else
                           <option value="">No Countries Available</option>
                           @endif --}}
                           {{-- </select> --}}
                        </div>
                     </div>
                  </div>
                  <div class="col-md-2 dn-csp-clinic-three" id="nationality_wife1" >
                     <div class="mb-3">
                        <label class="text-label form-label" id="nationality_woman_lable"
                           for="nationality_wife"><strong>Nationality</strong><span
                           class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
@php
    $selectedNationality = old('nationality_wife') ?? ($uhidDetails->nationality_wife ?? '');
    $caseOfInput = request()->input('case_of') ?? old('case_of') ?? ($uhidDetails->case_of ?? '');
@endphp

<select name="nationality_wife" id="nationality_wife" class="form-control" required>
    <option value="Indian" @selected($selectedNationality === 'Indian')>Indian</option>

    @if ($caseOfInput === 'one' || $selectedNationality === 'OCI Card Holders')
        <option value="OCI Card Holders" @selected($selectedNationality === 'OCI Card Holders')>OCI Card Holders</option>
    @endif
</select>
                   
                     
                        </div>
                        @error('nationality_wife')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>

               
                  {{-- {{ dd($uhidDetails->other_nationality_wife) }} --}}
                  <div class="col-md-4 dn-csp-clinic-three " id="other_nationality1_wife" >
                     <div class="mb-3">
                        <label class="control-label"><strong>Country</strong><span
                           class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           
                           <select name="other_nationality_wife" id="other_nationality_wife" class="form-control">
                              <option value="">-- Select Country --</option>
                              @if ($countries->count() > 0)
                              @foreach ($countries as $country)
                              <option value="{{ $country->id }}"
                              {{ old('other_nationality_wife', $uhidDetails->other_nationality_wife ?? '') == $country->id ? 'selected' : '' }}>
                              {{ $country->country_name }}
                              </option>
                              @endforeach
                              @else
                              <option value="">No Countries Available</option>
                              @endif
                           </select>
                          
    {{-- <select name="other_nationality_wife" id="other_nationality_wife" class="form-control">
    @php
        $selectedNationality = old('nationality_wife', $uhidDetails->nationality_wife ?? '');
        $selectedOtherNationality = old('other_nationality_wife', $uhidDetails->other_nationality_wife ?? '');
    @endphp

    @if ($selectedNationality === 'Indian')
        <option value="Indian" {{ $selectedOtherNationality == 'Indian' ? 'selected' : '' }}>Indian</option>
    @elseif ($selectedNationality === 'OCI Card Holders')
        @if ($countries->count() > 0)
            @foreach ($countries as $country)
                <option value="{{ $country->id }}"
                    {{ $selectedOtherNationality == $country->id ? 'selected' : '' }}>
                    {{ $country->country_name }}
                </option>
            @endforeach
        @else
            <option value="">No Countries Available</option>
        @endif
    @endif
</select> --}}



   {{-- <select name="other_nationality_wife" id="other_nationality_wife" class="form-control">
    @if (old('nationality', $uhidDetails->nationality ?? '') == 'Indian')
        <option value="Indian" {{ old('other_nationality_wife', $uhidDetails->other_nationality_wife ?? '') == 'Indian' ? 'selected' : '' }}>
            Indian
        </option>
    @else
        @if ($countries->count() > 0)
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" 
                    {{ old('other_nationality_wife', $uhidDetails->other_nationality_wife ?? '') == $country->id ? 'selected' : '' }}>
                    {{ $country->country_name }}
                </option>
            @endforeach
        @else
            <option value="">No Countries Available</option>
        @endif
    @endif
</select> --}}











                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 one selectt {{ old('age', $uhidDetails->age ?? '') ? '' : 'display:none;' }}" id="husband_age" >
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Husband Age</strong></label>
                        <div class="input-group">
                           <select name="age" id="age" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select
                                 Age</b></strong>
                              </option>
                              <?php for($i = 26; $i <= 55; $i++) {
                                 $selected = ($i == old('age', $uhidDetails->age ?? '')) ? 'selected' : '';
                                 echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                 } ?>
                           </select>
                        </div>
                        @error('age')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-3 one selectt {{ old('wife_age', $uhidDetails->wife_age ?? '') ? '' : 'display:none;' }}" id="wife_age1" >
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername" id="wife_age_label"><strong>Wife Age
                        </strong></label>
                        <div class="input-group">
                           <select name="wife_age" id="wife_age" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select
                                 Age</b></strong>
                              </option>
                              <?php for($i = 23; $i <= 50; $i++) {
                                 $selected = ($i == old('wife_age', $uhidDetails->wife_age ?? '')) ? 'selected' : '';
                                 echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                 } ?>
                           </select>
                        </div>
                        @error('wife_age')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-3 clr-csp-clinic-two  {{ old('age_of_women', $uhidDetails->age_of_women ?? '') ? '' : 'display-none' }}" id="single" >
                     <div class="mb-3">
                        <!-- <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Age of Women
                               [widow/divorcee]</strong></label> -->
                        <label class="text-label form-label"
                           for="age_of_women"><strong>Age of Woman</strong></label>
                        <div class="input-group">
                           <select name="age_of_women" id="age_of_women" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select
                                 Age</b></strong>
                              </option>
                              <?php for($i = 35; $i <= 45; $i++) {
                                 $selected = ($i == old('age_of_women', $uhidDetails->age_of_women ?? '')) ? 'selected' : '';
                                 echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                 } ?>
                           </select>
                        </div>
                        @error('age_of_women')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                

      <div class="col-md-2">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Having Surviving
                        Child</strong></label>
                        <div class="input-group">
                           <select name="num_pre_child" id="num_pre_child" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select</b></strong>
                              </option>
                              <option value="Yes" {{ old('num_pre_child', $uhidDetails->num_pre_child ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                              <option value="No" {{ old('num_pre_child', $uhidDetails->num_pre_child ?? '') == 'No' ? 'selected' : '' }}>No</option>
                           </select>
                        </div>
                        @error('num_pre_child')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- 
                  <div class="col-md-3 {{ old('child_give_details', $uhidDetails->child_give_details ?? '') ? '' : 'display:none;' }}"  id="num_per_child_details">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Details of Child</strong></label>
                        <div class="input-group">
                           <select name="child_give_details" id="give_details" class="form-control"
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select</b></strong>
                              </option>
                              <!-- <option value="Child Mentally" >
                                 Child Mentally</option> -->
                              <option value="Mentally Challenged" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Mentally Challenged' ? 'selected' : '' }}>
                              Mentally Challenged</option>
                              <option value="Physically Challenged" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Physically Challenged' ? 'selected' : '' }}>
                              Physically Challenged</option>
                              <option value="Life Threatening Disorder" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Life Threatening Disorder' ? 'selected' : '' }}>
                              Life Threatening Disorder</option>
                           </select>
                        </div>
                        @error('child_give_details')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  --}}
                  {{-- <div class="col-md-3 {{ old('num_pre_child', $uhidDetails->num_pre_child ?? '') == 'Yes' ? '' : 'd-none' }}" id="num_per_child_details"> --}}
                    <div class="col-md-3" id="num_per_child_details">
                     <div class="mb-3">
                        <label class="text-label form-label" for="give_details"><strong>Details of Child</strong></label>
                        <div class="input-group">
                           <select name="child_give_details" id="give_details" class="form-control" aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select</b></strong></option>
                              <option value="Mentally Challenged" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Mentally Challenged' ? 'selected' : '' }}>Mentally Challenged</option>
                              <option value="Physically Challenged" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Physically Challenged' ? 'selected' : '' }}>Physically Challenged</option>
                              <option value="Life Threatening Disorder" {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Life Threatening Disorder' ? 'selected' : '' }}>Life Threatening Disorder</option>
                           </select>
                        </div>
                        @error('child_give_details')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- 
                  <div class="row col-md-6" id="medical_open" style="display:none;">
                     <div class="col-md-6" id="child_medical_open" style="display:none;">
                        <div class="mb-3">
                           <label class="text-label form-label"
                              for="validationCustomUsername"><strong>Medical Certificate of Child
                           </strong><span style="color:red;">*</span></label>
                           <div class="input-group">
                              <input type="file" class="form-control"
                                 id="child_medical_certificate" name="surrogacypatient_child_medicalcertificate_docs"
                                 aria-describedby="child_medical_certificate1"
                                 onchange="validateForSize(this,50,200);">
                              <button type="button" class="btn btn-danger" onclick="removeFile1()">Remove</button>
                           </div>
                           <ul>
                              <strong>Note:- </strong>
                              <li>File Type: PDF or JPG Format only and File Size: 50 to 200 kb.
                              </li>
                           </ul>
                        </div>
                        @error('surrogacypatient_child_medicalcertificate_docs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  --}}
                  <div class="mb-3" id="file_show">
                     <label class="text-label form-label">
                     <strong>Medical Certificate of Child</strong><span class="clr-csp-clinic-two">*</span>
                     </label>
                     {{-- File Upload Section --}}
                     <div id="child_medical_upload {{ isset($existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']) ? 'display:none;' : '' }}" >
                        <div class="input-group">
                           <input type="file" class="form-control"
                              id="child_medical_certificate"
                              name="surrogacypatient_child_medicalcertificate_docs"
                              >
                           {{-- onchange="validateForSize(this,50,200);" --}}
                        </div>
                     </div>
                     {{-- Existing File Preview with Remove Button --}}
                     @if(isset($existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']))
                     <div id="existing_child_medical_file" class="mt-2">
                        <p>Uploaded File:
                           {{-- <a href="{{ asset('artprojfiles/surrogacy_patient_medical_docs/' . $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']) }}"
                              target="_blank">
                           <i class="fas fa-file-pdf fa-2x text-danger"></i>
                           </a> --}}
                            @php $file = folderpath('surrogacy_patient_medical_docs_blade') . $uhidDetails->clinic_id . '/' . $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']; @endphp
                            <a href="{{ asset($file) }}" target="_blank"><i class="fas fa-file-pdf fa-2x text-danger"></i></a>
                           <button type="button" class="btn btn-sm btn-danger ms-2"  id="removeChildMedicalFileBtn">Remove</button>
                        </p>
                        <input type="hidden" name="existing_child_medical_file" id="existing_child_medical_certificate_input"
                           value="{{ $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs'] }}">
                     </div>
                     @endif
                     <ul>
                        <strong>Note:- </strong>
                        <li>File Type: PDF Format only and File Size: 50 to 200 kb.</li>
                     </ul>
                     @error('surrogacypatient_child_medicalcertificate_docs')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
                  {{-- onclick="removeExistingChildMedicalFile()" --}}
                  <script nonce="{{ $cspNonce }}">
                     // function removeExistingChildMedicalFile() {
                     //     // Remove the existing file preview
                     //     const existingDiv = document.getElementById('existing_child_medical_file');
                     //     if (existingDiv) {
                     //         existingDiv.remove();
                     //     }
                     
                     //     // Show the file upload input again
                     //     const uploadDiv = document.getElementById('child_medical_upload');
                     //     if (uploadDiv) {
                     //         uploadDiv.style.display = 'block';
                     //     }
                     // }
                  </script>
                  <script nonce="{{ $cspNonce }}">
                     document.addEventListener("DOMContentLoaded", function () {
                         const removeButton = document.getElementById("removeChildMedicalFileBtn");
                     
                         if (removeButton) {
                             removeButton.addEventListener("click", removeExistingChildMedicalFile);
                         }
                     
                         function removeExistingChildMedicalFile() {
                             // Remove the existing file preview
                             const existingDiv = document.getElementById('existing_child_medical_file');
                             if (existingDiv) {
                                existingDiv.remove();
                             }
                     
                             // Show the file upload input again
                             const uploadDiv = document.getElementById('child_medical_upload');
                             if (uploadDiv) {
                                 uploadDiv.style.display = 'block';
                             }
                         }
                     });
                  </script>
                  <div class="border p-3 rounded">
                        <label class="form-label mb-3 d-block">
                            <strong>Medical Condition Necessitating Surrogacy</strong>
                        </label>

                        <div class="row">

                            <!-- Ultra Abnorm -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="uterus_ab"
                                        name="uterus_ab"
                                        value="Y"
                                        {{ old('uterus_ab', $uhidDetails->uterus_ab ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="uterus_ab">
                                        <strong>Uterus Abnormalities</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- IVF Failure -->
                            <div class="col-md-3">
                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="ivf_failure"
                                        name="ivf_failure"
                                        value="Y"
                                        {{ old('ivf_failure', $uhidDetails->ivf_failure ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ivf_failure">
                                        <strong>Repeated IVF Failure or Recurrent implantation failure</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Pregnancy Loss -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="preg_loss"
                                        name="preg_loss"
                                        value="Y"
                                        {{ old('preg_loss', $uhidDetails->preg_loss ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="preg_loss">
                                        <strong>Multiple Pregnancy Loss</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Life Threat -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="life_threat"
                                        name="life_threat"
                                        value="Y"
                                        {{ old('life_threat', $uhidDetails->life_threat ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="life_threat">
                                        <strong>Life Threatening illness</strong>
                                    </label>
                                </div>
                            </div>
                            <!-- Male Factor -->
                            <div class="col-md-2" id="male_factor_div">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="male_factor"
                                        name="male_factor"
                                        value="Y"
                                        {{ old('male_factor', $uhidDetails->male_factor ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male_factor">
                                        <strong>Male Factor</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Description of Cause -->
                            <div class="col-md-12 mt-3">
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control" id="medical_surrogacy" value="{{ old('medical_surrogacy', $uhidDetails->medical_surrogacy ?? '') }}"
                                    name="medical_surrogacy" aria-describedby="medical_surrogacy">
                                </div>
                                @error('medical_surrogacy')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                  <div class="mb-3">
                     <label class="text-label form-label">
                     <strong>Upload Certificate of Medical
                     Indication issued by District Medical Board</strong><span class="clr-csp-clinic-two">*</span>
                     </label>
                     {{-- File Upload Section --}}
                     <div id="medical_upload" class="{{ isset($existingDocs['target_file_surrogacypatient_medicalcertificate_docs']) ? 'display:none;' : '' }}">
                        <div class="input-group">
                           <input type="file" class="form-control"
                              id="medical_certificate"
                              name="surrogacypatient_medicalcertificate_docs"
                              >
                           {{-- onchange="validateForSize(this,50,200);" --}}
                        </div>
                     </div>
                     {{-- Existing File Preview with Remove Button --}}
                     @if(isset($existingDocs['target_file_surrogacypatient_medicalcertificate_docs']))
                     <div id="existing_medical_file" class="mt-2">
                        <p>Uploaded File:
                           {{-- <a href="{{ asset('artprojfiles/surrogacy_patient_medical_docs/' . $existingDocs['target_file_surrogacypatient_medicalcertificate_docs']) }}"
                              target="_blank">
                           <i class="fas fa-file-pdf fa-2x text-danger"></i>
                           </a> --}}
                        
                           @php $file = folderpath('surrogacy_patient_medical_docs_blade') . $uhidDetails->clinic_id . '/' . $existingDocs['target_file_surrogacypatient_medicalcertificate_docs']; @endphp
                            <a href="{{ asset($file) }}" target="_blank"><i class="fas fa-file-pdf fa-2x text-danger"></i></a>
                           <button type="button" class="btn btn-sm btn-danger ms-2"  id="remove-button">Remove</button>
                        </p>
                        {{--  onclick="removeExistingMedicalFile()" --}}
                        <input type="hidden" name="existing_medical_file"
                           value="{{ $existingDocs['target_file_surrogacypatient_medicalcertificate_docs'] }}">
                     </div>
                     @endif
                     <ul>
                        <strong>Note:- </strong>
                        <li>File Type: PDF Format only and File Size: 50 to 200 kb.</li>
                     </ul>
                     @error('surrogacypatient_child_medicalcertificate_docs')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
                  {{-- <script>
                     function removeExistingMedicalFile() {
                         // Remove the existing file preview
                         const existingDiv1 = document.getElementById('existing_medical_file');
                         if (existingDiv1) {
                             existingDiv1.remove();
                         }
                     
                         // Show the file upload input again
                         const uploadDiv1 = document.getElementById('medical_upload');
                         if (uploadDiv1) {
                             uploadDiv1.style.display = 'block';
                         }
                     }
                  </script> --}}
                  <script nonce="{{ $cspNonce }}">
                     function removeExistingMedicalFile() {
                         const existingDiv1 = document.getElementById('existing_medical_file');
                         if (existingDiv1) {
                             existingDiv1.remove();
                         }
                     
                         const uploadDiv1 = document.getElementById('medical_upload');
                         if (uploadDiv1) {
                             uploadDiv1.style.display = 'block';
                         }
                     }
                     
                     // Attach event listener
                     document.getElementById('remove-button').addEventListener('click', removeExistingMedicalFile);
                  </script>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Type of
                        Treatment</strong></label>
                        <div class="input-group">
                           {{-- <select name="types_of_treat" id="types_of_treat" class="form-control"
                              aria-label=".form-select-lg example">
                           <option value="" class="text-muted" id="typeOfTreat1" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == '' ? 'selected' : '' }}>
                           <strong><b>Select</b></strong>
                           </option>
                           <option value="Surrogacy using self gametes"
                           id="own_gametes" class="p-1" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using self gametes' ? 'selected' : '' }}>
                           Surrogacy using self gametes</option>
                           <option value="Surrogacy using donor gametes" id="d_gametes"
                           class="p-1" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using donor gametes' ? 'selected' : '' }}>
                           Surrogacy using donor gametes</option>
                           </select> --}}
                           <!-- Main Select Dropdown -->
                           <select name="types_of_treat" id="types_of_treat" class="form-control"
                              aria-label=".form-select-lg example">
                           <option value="" class="text-muted" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == '' ? 'selected' : '' }}>
                           <strong><b>Select Treatment Type</b></strong>
                           </option>
                           <option value="Surrogacy using donor gametes" id="d_gametes"
                           class="p-1" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using donor gametes' ? 'selected' : '' }}>
                           Surrogacy using donor gametes
                           </option>
                           <option value="Surrogacy using self gametes"
                           id="own_gametes" class="p-1" {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using self gametes' ? 'selected' : '' }}>
                           Surrogacy using self gametes</option>
                           </select>
                        </div>
                        @error('types_of_treat')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-4" id="ivf_donor">
                     <div class="mb-3"  id="gamete-source-section">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Gamete Source</strong></label>
                        <div class="input-group">
                           <select name="types_of_treat1" id="types_of_treat1" class="form-control"
                              aria-label=".form-select-lg example">
                           <option value="" id="tot1" class="text-muted" {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == '' ? 'selected' : '' }}>
                           <strong><b>Select</b></strong>
                           </option>
                           <option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1" {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Self Oocyte & Donor Sperm' ? 'selected' : '' }}>
                           Self Oocyte & Donor Sperm
                           </option>
                           <option value="Donor Oocyte & Self Sperm" id="o_sperm" class="p-1" {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Donor Oocyte & Self Sperm' ? 'selected' : '' }}>
                           Donor Oocyte & Self Sperm
                           </option>
                           </select>
                        </div>
                        @error('types_of_treat1')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Surrogate Mother Age
                        </strong><span class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           <select name="surrogate_mother_age" id="surrogate_mother_age"
                              class="form-control" aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select
                                 Age</b></strong>
                              </option>
                              <?php for($i = 25; $i <= 35; $i++) {
                                 $selected = ($i == old('surrogate_mother_age', $uhidDetails->surrogate_mother_age ?? '')) ? 'selected' : '';
                                 echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                 } ?>
                           </select>
                           {{-- <span id="$wife_age_id"
                              style="color: red;"></span> --}}
                        </div>
                        @error('surrogate_mother_age')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- {{ dd(old('art_undertaken', $uhidDetails->art_undertaken ?? '')) }} --}}
                  <div class="col-md-4" id="other">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>ART Procedure
                        Undertaken</strong><span class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           <select class="form-control" id="for_others" name="art_undertaken">
                           <option value="In Vitro Fertilization-Embryo Transfer(IVF-ET)"
                           {{ old('art_undertaken', $uhidDetails->art_undertaken ?? '') == 'In Vitro Fertilization-Embryo Transfer(IVF-ET)' ? 'selected' : '' }}>
                           In Vitro Fertilization-Embryo Transfer(IVF-ET)
                           </option>
                           <option value="Intra-Cytoplasmic Sperm Injection(ICSI)"
                           {{ old('art_undertaken', $uhidDetails->art_undertaken ?? '') == 'Intra-Cytoplasmic Sperm Injection(ICSI)' ? 'selected' : '' }}>
                           Intra-Cytoplasmic Sperm Injection(ICSI)
                           </option>
                           <option value="Others"
                           {{ old('art_undertaken', $uhidDetails->art_undertaken ?? '') == 'Others' ? 'selected' : '' }}>
                           Others
                           </option>
                           </select>
                        </div>
                        @error('art_undertaken')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- 
                  <div class="col-md-3 dn-csp-clinic-three" id="others_id" >
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Others</strong></label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="art_undertaken_other" value="{{ old('art_undertaken_other', $uhidDetails->art_undertaken_other ?? '') }}"
                              name="art_undertaken_other" aria-describedby="art_undertaken_other">
                        </div>
                        @error('art_undertaken_other')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  --}}
                  {{-- /////////////////////////////// --}}
                  <!-- 'Others' input field (Initially hidden) -->
                  <div class="col-md-3 dn-csp-clinic-three" id="others_id" style="display: none;">
                     <div class="mb-3">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Others</strong></label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="art_undertaken_other" value="{{ old('art_undertaken_other', $uhidDetails->art_undertaken_other ?? '') }}"
                              name="art_undertaken_other" aria-describedby="art_undertaken_other">
                        </div>
                        @error('art_undertaken_other')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-md-4" id="">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Total No. of Treatment Cycle(s) Undertaken
                        </strong></label>
                        <div class="input-group">
                           <select name="total_nun_cycles" id="total_nun_cycles" class="form-control" 
                              aria-label=".form-select-lg example">
                              <option value="" class="text-muted"><strong><b>Select</b></strong>
                              </option>
                              <?php for($i = 1; $i <= 20; $i++) {
                                 $selected = ($i == old('total_nun_cycles', $uhidDetails->total_nun_cycles ?? '')) ? 'selected' : '';
                                 echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                 } ?>
                           </select>
                           {{-- onchange="updateDependentField()"                              --}}
                        </div>
                        @error('total_nun_cycles')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- {{ dd(old('no_cycles', $uhidDetails->no_cycles ?? '')) }} --}}
                  <div class="col-md-4" id="no_cycles1">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>No. of Cycles Cancelled/Failed, if any
                        </strong></label>
                        <div class="input-group">
                           {{-- 
                           <select name="no_cycles" id="no_cycles" class="form-control"
                              aria-label=".form-select-lg example">
                              <!-- <option value="">Select an option</option> -->
                              <option value="" class="text-muted"><strong><b>Select</b></strong>
                              </option>
                           </select>
                           --}}
                           <select name="no_cycles" id="no_cycles" class="form-control" aria-label=".form-select-lg example">
                              <option value="" class="text-muted" {{ old('no_cycles', $uhidDetails->no_cycles ?? '') == '' ? 'selected' : '' }}>
                              <strong><b>Select</b></strong>
                              </option>
                              <!-- Loop to dynamically generate options from 1 to 20 -->
                              @for ($i = 1; $i <= 20; $i++)
                              <option value="{{ $i }}" {{ old('no_cycles', $uhidDetails->no_cycles ?? '') == $i ? 'selected' : '' }}>
                              {{ $i }}
                              </option>
                              @endfor
                              <!-- Option for 0, that will trigger the display of the reason field -->
                              <option value="0" {{ old('no_cycles', $uhidDetails->no_cycles ?? '') == '0' ? 'selected' : '' }}>
                              0
                              </option>
                           </select>
                        </div>
                        @error('no_cycles')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- 
                  <div class="col-md-7 dn-csp-clinic-three" id="fail_reason">
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Cycle Cancellation/failure and
                        reason</strong><span class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="Cycle_fail_reason" value="{{ old('Cycle_fail_reason', $uhidDetails->Cycle_fail_reason ?? '') }}"
                              name="Cycle_fail_reason" aria-describedby="Cycle_fail_reason">
                           <!--textarea type="text" class="form-control" id="Cycle_fail_reason"
                              name="Cycle_fail_reason" aria-describedby="Cycle_fail_reason"
                              rows="2"> </textarea-->
                        </div>
                        @error('Cycle_fail_reason')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  --}}
                  <!-- Cycle Failure Reason Input (Only Shows if No Cycles is 0) -->
                  <div class="col-md-7 dn-csp-clinic-three" id="fail_reason" style="display: none;">
                     <div class="mb-3">
                        <label class="text-label form-label" for="validationCustomUsername">
                        <strong>Cycle Cancellation reason</strong><span class="clr-csp-clinic-two">*</span>
                        </label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="Cycle_fail_reason" value="{{ old('Cycle_fail_reason', $uhidDetails->Cycle_fail_reason ?? '') }}"
                              name="Cycle_fail_reason" aria-describedby="Cycle_fail_reason">
                        </div>
                        @error('Cycle_fail_reason')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  @php
                  $selectedOutcome = old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '');
                  $showPregnancyOutcome = $selectedOutcome === 'Pregnant';
                  @endphp
                  <div class="col-md-4" id="" >
                     <div class="mb-3">
                        <label class="text-label form-label"
                           for="validationCustomUsername"><strong>Treatment
                        Outcome</strong><span class="clr-csp-clinic-two">*</span></label>
                        <div class="input-group">
                           {{-- <select class="form-control" id="tratment_Outcome"
                              name="tratment_Outcome">
                           <option value="" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == '' ? 'selected' : '' }}>Select</option>
                           <option value="Pregnant" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Pregnant' ? 'selected' : '' }}>Pregnant</option>
                           <option value="Not Pregnant" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Not Pregnant' ? 'selected' : '' }}>Not Pregnant</option>
                           </select> --}}
                           <select class="form-control" id="tratment_Outcome" name="tratment_Outcome">
                           <option value="" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == '' ? 'selected' : '' }}>Select</option>
                           <option value="Pregnant" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Pregnant' ? 'selected' : '' }}>Pregnant</option>
                           <option value="Not Pregnant" {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Not Pregnant' ? 'selected' : '' }}>Not Pregnant</option>
                           </select>
                        </div>
                        @error('tratment_Outcome')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                     </div>
                  </div>
                  {{-- @php
                  $showPregnancyOutcome = old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') === 'Pregnant';
                  @endphp --}}
                  <div class="col-md-3 dn-csp-clinic-three" id="preganancy_outcome1"  {{ $showPregnancyOutcome ? '' : 'd-none' }}>
                  <div class="mb-3">
                     <label class="text-label form-label" for="validationCustomUsername">
                     <strong>Pregnancy Outcome</strong><span class="clr-csp-clinic-two">*</span>
                     </label>
                     <div class="input-group">
                        <select class="form-control" id="preganancy_outcome" name="preganancy_outcome">
                           <option value="">Select</option>
                           <option value="live birth" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'live birth' ? 'selected' : '' }}>live birth</option>
                           <option value="Stillbirth" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Stillbirth' ? 'selected' : '' }}>Stillbirth</option>
                           <option value="Therapeutic abortion with consent of Surrogate mother & authorization by AA" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Therapeutic abortion with consent of Surrogate mother & authorization by AA' ? 'selected' : '' }}>Therapeutic abortion with consent of Surrogate mother & authorization by AA</option>
                           <option value="Spontaneous abortion" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Spontaneous abortion' ? 'selected' : '' }}>Spontaneous abortion</option>
                           {{-- <option value="Elective Termination" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Elective Termination' ? 'selected' : '' }}>Elective Termination</option> --}}
                        </select>
                     </div>
                     @error('preganancy_outcome')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
               </div>
               {{-- 
               <div class="col-md-3 dn-csp-clinic-three" id="live_birth_open">
                  <div class="mb-3">
                     <label class="text-label form-label"
                        for="validationCustomUsername"><strong>Live Birth Pregnancy
                     Outcome</strong></label>
                     <div class="input-group">
                        <select class="form-control" id="l_birth" name="l_birth">
                           <option value="">Select</option>
                           <option value="Singleton" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Singleton' ? 'selected' : '' }}>
                           Singleton
                           </option>
                           <option value="Twin" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Twin' ? 'selected' : '' }}>Twin</option>
                           <!--option value="Triplets">Triplets
                              </option-->
                           <option value="Higher Order" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Higher Order' ? 'selected' : '' }}>Higher Order</option>
                        </select>
                     </div>
                     @error('l_birth')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
               </div>
               --}}
               
               {{-- 
               <div class="col-md-4" id="gender_child1" style="display:none;">
                  <div class="mb-3">
                     <label class="text-label form-label"
                        for="validationCustomUsername"><strong>Gender of the child
                     born</strong></label>
                     <div class="input-group">
                        <select class="form-select" id="gender_child" name="gender_child[]" data-placeholder="Select" multiple>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                        </select>
                     </div>
                     @error('gender_child')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
               </div>
               --}}
               {{-- 
               <div class="col-md-3" id="other_gender_id" style="display:none;">
                  <div class="mb-3">
                     <label class="text-label form-label"
                        for="validationCustomUsername"><strong>Specify Number & Gender of the children Born</strong></label>
                     <div class="input-group">
                        <input type="text" class="form-control" id="other_gender"
                           name="other_gender" aria-describedby="other_gender">
                     </div>
                     <span id="art_undertaken_id"
                        style="color: red;"><?php //if(isset($art_undertaken)){ echo $art_undertaken;} ?></span>
                  </div>
               </div>
               --}}
               {{-- 
               <div class="col-md-6 " id="gender_child1" style="display:none;">
                  <div class="row d-flex justify-content mt-4">
                     <div class="col-md-4" id="male_hide">
                        <div class="row">
                           <div class="col-md-3 py-2">
                              <div class="form-check custom-checkbox mb-3">
                                 <input type="checkbox" name="gender_child[]" value="Male"
                                    class="form-check-input inline" id="male_female">
                                 <label class="form-check-label"
                                    for="customCheckBox1">Male</label>
                              </div>
                           </div>
                           <div class="col md-7" id="male_hidden" style="display: none;">
                              <div class="input-group">
                                 <select name="male_number" id="male_number" class="form-control">
                                    <option value="">No.</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}
                                    </option>
                                    @endfor
                                 </select>
                                 <span class="input-group-text">Number</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4" id="female_hide">
                        <div class="row d-flex gap-3">
                           <div class="col-md-3 py-2">
                              <div class="form-check custom-checkbox mb-3">
                                 <input type="checkbox" name="gender_child[]" value="Female"
                                    class="form-check-input inline" id="male_female1">
                                 <label class="form-check-label"
                                    for="customCheckBox1">Female</label>
                              </div>
                           </div>
                           <div class="col md-7" id="female_hidden" style="display: none;">
                              <div class="input-group">
                                 <select name="female_number" id="female_number" class="form-control">
                                    <option value="">No.</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}
                                    </option>
                                    @endfor
                                 </select>
                                 <span class="input-group-text">Number</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               --}}
               @php
               $gender_child = old('gender_child', isset($uhidDetails->gender_child) ? explode(',', $uhidDetails->gender_child) : []);
               $male_number = old('male_number', $uhidDetails->male_number ?? '');
               $female_number = old('female_number', $uhidDetails->female_number ?? '');
               $show_gender_section = in_array('Male', $gender_child) || in_array('Female', $gender_child);
               @endphp
               <div class="col-md-6" id="gender_child1" style="{{ $show_gender_section ? '' : 'display:none;' }}">
                  <div class="row d-flex justify-content mt-4">
                     <div class="col-md-4" id="male_hide">
                        <div class="row">
                           <div class="col-md-3 py-2">
                              <div class="form-check custom-checkbox mb-3">
                                 <input type="checkbox" name="gender_child[]" value="Male"
                                 class="form-check-input inline" id="male_female"
                                 {{ in_array('Male', $gender_child) ? 'checked' : '' }}>
                                 <label class="form-check-label" for="customCheckBox1">Male</label>
                              </div>
                           </div>
                           <div class="col md-7" id="male_hidden" {{ in_array('Male', $gender_child) ? '' : 'display:none;' }}>
                           <div class="input-group">
                              <select name="male_number" id="male_number" class="form-control">
                                 <option value="">No.</option>
                                 @for ($i = 0; $i <= 5; $i++)
                                 <option value="{{ $i }}" {{ $male_number == $i ? 'selected' : '' }}>{{ $i }}</option>
                                 @endfor
                              </select>
                              <span class="input-group-text">Number</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4" id="female_hide">
                     <div class="row d-flex gap-3">
                        <div class="col-md-3 py-2">
                           <div class="form-check custom-checkbox mb-3">
                              <input type="checkbox" name="gender_child[]" value="Female"
                              class="form-check-input inline" id="male_female1"
                              {{ in_array('Female', $gender_child) ? 'checked' : '' }}>
                              <label class="form-check-label" for="customCheckBox1">Female</label>
                           </div>
                        </div>
                        <div class="col md-7" id="female_hidden" {{ in_array('Female', $gender_child) ? '' : 'display:none;' }}>
                        <div class="input-group">
                           <select name="female_number" id="female_number" class="form-control">
                              <option value="">No.</option>
                              @for ($i = 0; $i <= 5; $i++)
                              <option value="{{ $i }}" {{ $female_number == $i ? 'selected' : '' }}>{{ $i }}</option>
                              @endfor
                           </select>
                           <span class="input-group-text">Number</span>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
      </div>

      <div class="col-md-3 dn-csp-clinic-three" id="live_birth_open" style="display: none;">
            <div class="mb-3">
                <label class="text-label form-label" for="validationCustomUsername">
                <strong>Live Birth Pregnancy Outcome</strong>
                </label>
                <div class="input-group">
                <select class="form-control" id="l_birth" name="l_birth" disabled>
                    <option value="">Select</option>
                    <option value="Singleton" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Singleton' ? 'selected' : '' }}>
                    Singleton
                    </option>
                    <option value="Twin" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Twin' ? 'selected' : '' }}>
                    Twin
                    </option>
                    <option value="Higher Order" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Higher Order' ? 'selected' : '' }}>
                    Higher Order
                    </option>
                </select>
                <input type="hidden" name="l_birth" id="l_birth_hidden" value="{{ $uhidDetails->l_birth }}">
                </div>
                @error('l_birth')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
      <script nonce="{{ $cspNonce }}">
         $(document).ready(function () {
             $('#male_female').change(function () {
                 $('#male_hidden').toggle(this.checked);
             });
         
             $('#male_female1').change(function () {
                 $('#female_hidden').toggle(this.checked);
             });
         });
      </script>
      <div class="col-md-12">
      <div class="mb-3">
      <label class="text-label form-label"
         for="validationCustomUsername"><strong>Complications, If
      any</strong></label>
      <div class="input-group">
      <textarea class="form-control" col="5" rows="3"
         name="comp_if_any">{{ old('comp_if_any', $uhidDetails->comp_if_any ?? '') }}</textarea>
      </div>
      @error('other_gender')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
      </div>
      <div class="col-md-12">
      <div class="mb-3">
      <label class="text-label form-label"
         for="validationCustomUsername"><strong>Remarks/ Any other relevant
      information</strong></label>
      <div class="input-group">
      <textarea class="form-control" col="5" rows="3"
         name="remark">{{ old('remark', $uhidDetails->remark ?? '') }}</textarea>
      </div>
      @error('remark')
      <span class="text-danger">{{ $message }}</span>
      @enderror
      </div>
      </div>
      <label class="text-label form-label"
         for="validationCustomUsername"><strong>Required Affidavit regarding
      following to be taken on record:</strong></label>
      <div class="col-12">
      <div class="form-check">
      <input class="form-check-input" type="checkbox" id="declaration" 
      name="declaration" {{ old('declaration', $uhidDetails->declaration ?? '') === 'on' ? 'checked' : '' }}>
      <label class="form-check-label" for="gridCheck">
      From Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime.<span
         class="clr-csp-clinic-two">*</span>
      </label>
      </div>
      </div>
      <div class="col-12">
      <div class="form-check">
      <input class="form-check-input" type="checkbox" id="declaration1"
      name="declaration1" {{ old('declaration1', $uhidDetails->declaration1 ?? '') === 'on' ? 'checked' : '' }}>
      <label class="form-check-label" for="gridCheck">
      From intending
      couple or single woman (widow or divorcee) that they/she
      do/does not have any surviving child biologically or through
      adoption or through surrogacy earlier .
      </label>
      </div>
      </div>
      <div class="col-12">
      <div class="form-check">
      <input class="form-check-input" type="checkbox" id="declaration3"
      name="declaration3" {{ old('declaration3', $uhidDetails->declaration3 ?? '') === 'on' ? 'checked' : '' }}>
      <label class="form-check-label" for="gridCheck">
      From Oocyte Donor that she has not donated oocytes more than once in her life time.
      </label>
      </div>
      </div>
      <div class="col-12">
      <div class="form-check">
      <input class="form-check-input" type="checkbox" id="declaration4"
      name="declaration4" {{ old('declaration4', $uhidDetails->declaration4 ?? '') === 'on' ? 'checked' : '' }}>
      <label class="form-check-label" for="gridCheck">
      From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.
      </label>
      </div>
      </div>
   </div>
   {{-- <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button> 
   --}}
   <button type="button" id="closeBtn" class="btn me-2 btn btn-danger">Close</button>
   <button type="submit" name="updatev" id="btnSubmit" 
      class="btn me-2 btn-csp-clinic-four">update</button>
       <button type="submit" value="deletebtn" name="updatev" id="deleteBtn" class="btn me-2 btn btn-danger"  data-uhid="{{ $uhidDetails->pati_uhid }}" >Delete</button>     
   {{-- <button type="submit" name="submit" value="continue" id="btnSubmit" onclick="return validatesubmit()" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" class="btn me-2">Continue patient details</button>
   <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button>         --}}
   </form>
   {{-- 
   <div> --}}
   </div>
</div>
</div>
</div>
</div>
</div>
<script nonce="{{ $cspNonce }}">
     document.addEventListener('DOMContentLoaded', function() {
    
       // Select the dropdown and the 'Others' input field div
       const treatmentSelect = document.getElementById('for_others');
       const othersDiv = document.getElementById('others_id');

       // Check if the "Others" option is selected on page load
       if (treatmentSelect.value === "Others") {
           othersDiv.style.display = 'block';
       }
   
       // Add event listener to the select dropdown
       treatmentSelect.addEventListener('change', function() {
            
           if (treatmentSelect.value === 'Others') {
               othersDiv.style.display = 'block';  // Show 'Others' input field
           } else {
               othersDiv.style.display = 'none';  // Hide 'Others' input field
           }
       });
   });
//    $(document).ready(function () {
    
//        // Function to handle the visibility of fields based on the selected radio button
//        function handleNationalityFields() {
//            // Get the selected value of the 'case_of' radio button
//            var caseOf = $('input[name="case_of"]:checked').val();
        
//            if (caseOf === 'two') {
//                // If "Single Woman" is selected
//                $('#nationality_husband').hide(); // Hide nationality of husband
//                $('#nationalityhusband').prop('disabled', true); // Disable husband nationality dropdown
//                 $('#other_nationality1').hide();
//                $('#other_nationality').prop('disabled', true); // Disable other nationality dropdown
//                $('#other_nationality_wife').prop('disabled', true); // Enable wife's nationality dropdown
//            } else {
            
//                // If "Couple" is selected
//                $('#nationality_husband').show(); // Show nationality of husband
//                $('#nationalityhusband').prop('disabled', false); // Enable husband nationality dropdown
//                $('#other_nationality').prop('disabled', false); // Enable other nationality dropdown
//                $('#other_nationality_wife').prop('disabled', false); // Enable wife's nationality dropdown
//            }
//        }

//        // Check the radio button selection on page load (whether from old data or current selection)
//        handleNationalityFields();

//        // Event listener for radio button change
//        $('input[name="case_of"]').on('change', function () {
//            handleNationalityFields(); // Update visibility when radio button changes
//        });
//    });
  
</script>


{{-- 

<script>
    // Listen for changes in radio buttons
    document.querySelectorAll('input[name="case_of"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            // When "Single Woman" (value='two') is selected, clear all fields except 'case_of'
            if (this.value === 'two' && this.checked) {
                resetForm();
            }

            // When "Couple" (value='one') is selected, clear all fields except 'case_of'
            if (this.value === 'one' && this.checked) {
                resetForm();
            }
        });
    });

    // Function to reset the form like a new insert form
    function resetForm() {
        // Find all input fields, including checkboxes, selects, and textareas
        const formFields = document.querySelectorAll('input, select, textarea');

        formFields.forEach((field) => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                field.checked = false;  // Uncheck checkboxes and radio buttons
            } else {
                field.value = '';  // Clear text inputs, selects, textareas
            }
        });
    }

    // Optional: Reset form based on initial pre-selected radio button (edit mode)
    window.addEventListener('DOMContentLoaded', () => {
        // If the form is pre-filled with "Single Woman" (value='two')
        const selectedRadio = document.querySelector('input[name="case_of"]:checked');
        if (selectedRadio && selectedRadio.value === 'two') {
            resetForm();
        }
    });
</script> --}}


 {{-- <script>
    // Listen for changes in radio buttons
    document.querySelectorAll('input[name="case_of"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            // Check if "Single Woman" radio is selected
            if (this.value === 'two' && this.checked) {
                // Find all input fields (or you can specify a more specific selector)
                const formFields = document.querySelectorAll('input, select, textarea');
                formFields.forEach((field) => {
                    if (field.name !== 'case_of') {
                        field.value = ''; // Clear the field value
                    }
                });
            }
        });
    });
</script>  --}}


{{-- <script>
    // Function to reset the form like a new insert form
    function resetForm() {
        document.getElementById('art_clin1').reset();  // Reset all fields to their default values

        // Manually clear fields that reset() doesn't clear (checkboxes, radio buttons)
        const formFields = document.querySelectorAll('input, select, textarea');
        formFields.forEach((field) => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                field.checked = false;  // Uncheck checkboxes and radio buttons
            } else {
                field.value = '';  // Clear text inputs, selects, textareas
            }
        });
    }

    // Detect when the "Single Woman" radio button is selected
    document.getElementById('case_of_single_woman').addEventListener('change', function() {
        if (this.checked) {
            resetForm();  // Reset the form as if it's a new form
        }
    });

    // Detect when the "Couple" radio button is selected
    document.getElementById('case_of_couple').addEventListener('change', function() {
        if (this.checked) {
            resetForm();  // Reset the form as if it's a new form
        }
    });

    // Optional: When the page loads (if it's an edit mode), reset based on the pre-selected radio button
    window.addEventListener('DOMContentLoaded', () => {
        // Check if the "Single Woman" radio button is already selected
        const selectedRadio = document.querySelector('input[name="case_of"]:checked');
        if (selectedRadio && selectedRadio.value === 'two') {
            resetForm();  // Reset if "Single Woman" was selected
        }
    });
</script> --}}

<script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function () {

    const caseRadios = document.querySelectorAll('input[name="case_of"]');

    const husbandNationalityDiv = document.getElementById("nationality_husband");
    const husbandNationality = document.getElementById("nationalityhusband");
    const husbandOtherDiv = document.getElementById("other_nationality1");

    const wifeNationalityDiv = document.getElementById("nationality_wife1");
    const wifeNationality = document.getElementById("nationality_wife");
    const wifeLabel = document.getElementById("nationality_woman_lable");
    const wifeOtherDiv = document.getElementById("other_nationality1_wife");

    const husbandAgeDiv = document.getElementById("husband_age");
    const wifeAgeDiv = document.getElementById("wife_age1");
    const singleAgeDiv = document.getElementById("single");
    const typesofTreatment = document.getElementById("types_of_treat");
    const gameteSourceDiv = document.getElementById("ivf_donor");
    const gameteSource = document.getElementById("types_of_treat1");
    function hideAll() {
        husbandNationalityDiv.style.display = "none";
        husbandOtherDiv.style.display = "none";
        wifeNationalityDiv.style.display = "none";
        wifeOtherDiv.style.display = "none";
        husbandAgeDiv.style.display = "none";
        wifeAgeDiv.style.display = "none";
        singleAgeDiv.style.display = "none";
        gameteSourceDiv.style.display = "none";
    }

    function handleNationalityChange(dropdown, otherDiv) {
        if (dropdown.value === "OCI Card Holders") {
            otherDiv.style.display = "block";
        } else {
            otherDiv.style.display = "none";
        }
    }

    function handleCaseChange() {
        hideAll();

        const selectedValue = document.querySelector('input[name="case_of"]:checked')?.value;

        if (selectedValue === "one") {  // Couple

            husbandNationalityDiv.style.display = "block";
            wifeNationalityDiv.style.display = "block";
            wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span style='color:red;'>*</span>";
            wifeNationality.innerHTML = '<option value="Indian">Indian</option><option value="OCI Card Holders">OCI Card Holders</option>';

            typesofTreatment.innerHTML = '<option value="Surrogacy using donor gametes">Surrogacy using donor gametes</option><option value="Surrogacy using self gametes">Surrogacy using self gametes</option>';
            gameteSource.innerHTML = '<option value="Self Oocyte & Donor Sperm">Self Oocyte & Donor Sperm</option><option value="Donor Oocyte & Self Sperm">Donor Oocyte & Self Sperm</option>';
            
            husbandAgeDiv.style.display = "block";
            wifeAgeDiv.style.display = "block";

            handleNationalityChange(husbandNationality, husbandOtherDiv);
            handleNationalityChange(wifeNationality, wifeOtherDiv);

        } else if (selectedValue === "two") {  // Single Woman

            wifeNationalityDiv.style.display = "block";
            wifeAgeDiv.style.display = "none";
            singleAgeDiv.style.display = "block";
            wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";
            typesofTreatment.innerHTML = '<option value="Surrogacy using donor gametes">Surrogacy using donor gametes</option>';
            gameteSourceDiv.style.display = "block";
            gameteSource.innerHTML = '<option value="Self Oocyte & Donor Sperm">Self Oocyte & Donor Sperm</option>';
            // Force nationality to Indian
            wifeNationality.innerHTML = '<option value="Indian">Indian</option>';

            husbandNationality.value = "";
            husbandNationality.disabled = false;

            husbandOtherDiv.style.display = "none";
            wifeOtherDiv.style.display = "none";
        }
    }

    // Radio change event
    caseRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            wifeNationality.disabled = false; // enable before re-check
            handleCaseChange();
        });
    });

    // Husband nationality change
    husbandNationality.addEventListener("change", function () {
        handleNationalityChange(husbandNationality, husbandOtherDiv);
    });

    // Wife nationality change
    wifeNationality.addEventListener("change", function () {
        handleNationalityChange(wifeNationality, wifeOtherDiv);
    });

    // Run on page load
    handleCaseChange();

});
// document.addEventListener("DOMContentLoaded", function() {
//     // console.log('Script Loaded'); // Check if the script is loaded

//     // Get the radio buttons and div
//     const radioSingle = document.getElementById('flexRadioDefault2');
//     const radioCouple = document.getElementById('flexRadioDefault1');
//     const singleDiv = document.getElementById('single');
//     const wife_age1 = document.getElementById("wife_age1");


//     if(radioSingle.checked){
        
//         singleDiv.style.display = 'none';
//         wife_age1.style.display= 'none';

//     }else{
//         singleDiv.style.display = 'block';
//         wife_age1.style.display= 'block';
//     }

//     // console.log(radioSingle, radioCouple, singleDiv); // Ensure elements are correct

//     // Function to toggle visibility without CSS class
//     function toggleSingleDiv() {
//         // console.log('Radio Single Checked:', radioSingle.checked); // Debug the checked status
//         if (radioSingle.checked) {
//             // console.log('Single Woman selected');
//             singleDiv.style.display = 'block'; // Make it visible by setting display to block
//         } else {
//             // console.log('Couple selected');
//             singleDiv.style.display = 'none'; // Hide it by setting display to none
//         }
//     }

//     // Call the function to check initial state on page load
//     toggleSingleDiv();

//     // Add event listeners to toggle visibility when the radio buttons change
//     radioSingle.addEventListener('change', toggleSingleDiv);
//     radioCouple.addEventListener('change', toggleSingleDiv);
// });
</script>
<script nonce="{{ $cspNonce }}">
   document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('tratment_Outcome');
        const section = document.getElementById('preganancy_outcome1');
        const liveBirthOpen = document.getElementById('live_birth_open');
        const totalNunCycles = document.getElementById('total_nun_cycles');
        const noCycles = document.getElementById('no_cycles');
            
       const gender_child1 = document.getElementById("gender_child1");
   
       function updateVisibility() {
           if (select.value === 'Pregnant') {
               section.classList.remove('d-none');
           } else {
               section.classList.add('d-none');
               gender_child1.style.display = "none";
           }
       }
   
       // Check visibility on initial load
       updateVisibility();
   
       // Update visibility when dropdown changes
       select.addEventListener('change', updateVisibility);
   });
</script>
<script nonce="{{ $cspNonce }}">
   document.addEventListener('DOMContentLoaded', function() {
       const numPreChildSelect = document.getElementById('num_pre_child');
       const childDetailsDiv = document.getElementById('num_per_child_details');
   
       function toggleChildDetails() {
           if (numPreChildSelect.value === 'Yes') {
               childDetailsDiv.classList.remove('d-none');
           } else {
               childDetailsDiv.classList.add('d-none');
               // Optional: clear child_give_details selection on hiding
               document.getElementById('give_details').value = '';
           }
       }
   
       // Run on page load
       toggleChildDetails();
   
       // Run on select change
       numPreChildSelect.addEventListener('change', toggleChildDetails);
   });
</script>
<script nonce="{{ $cspNonce }}">
   document.addEventListener('DOMContentLoaded', function () {
       const outcomeSelect = document.getElementById('preganancy_outcome');
       const liveBirthDiv = document.getElementById('live_birth_open');
       const  selectl_birth = document.getElementById('l_birth');
       const selectl_birth_hidden = document.getElementById('l_birth_hidden');
   
       function toggleLiveBirthField() {
       
           if (outcomeSelect.value === 'live birth') {
               liveBirthDiv.style.display = 'block';
           } else {
               liveBirthDiv.style.display = 'none';
               selectl_birth.value = '';
               selectl_birth_hidden.value='';
           }
       }
   
       toggleLiveBirthField();
   
       outcomeSelect.addEventListener('change', toggleLiveBirthField);
   });
</script>
<!-- JavaScript to Show/Hide Failure Reason Field -->
<script nonce="{{ $cspNonce }}">
   document.addEventListener('DOMContentLoaded', function () {
       const noCyclesSelect = document.getElementById('no_cycles');
       const failReasonDiv = document.getElementById('fail_reason');
       
       // Check if the current value is '0' on page load and show the reason field if it is
       if (noCyclesSelect.value >'0') {
           failReasonDiv.style.display = 'block';
       }
   
       // Add event listener to show or hide the failure reason field based on selected value
       noCyclesSelect.addEventListener('change', function () {
           if (noCyclesSelect.value > '0') {
               failReasonDiv.style.display = 'block';  // Show reason field
           } else {
               failReasonDiv.style.display = 'none';  // Hide reason field
           }
       });
   });
</script>

<script nonce="{{ $cspNonce }}">
   document.addEventListener('DOMContentLoaded', function() {
       // Select the dropdown and the 'Others' input field div
       const treatmentSelect = document.getElementById('for_others');
       const othersDiv = document.getElementById('others_id');
       // Check if the "Others" option is selected on page load
       if (treatmentSelect.value === 'Others') {
        
           othersDiv.style.display = 'block';
       }else{
        othersDiv.style.display = 'none';
       }
       // Add event listener to the select dropdown
       treatmentSelect.addEventListener('change', function() {
    
           if (treatmentSelect.value === 'Others') {
               othersDiv.style.display = 'block';  // Show 'Others' input field
           } else {
               othersDiv.style.display = 'none';  // Hide 'Others' input field
           }
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
   // JavaScript to show or hide Gamete Source dropdown based on 'types_of_treat' selection
   document.addEventListener('DOMContentLoaded', function () {
       const treatmentSelect = document.getElementById('types_of_treat');
       const gameteSourceSection = document.getElementById('gamete-source-section');
       const ivfDonor = document.getElementById('ivf_donor');
       
       // Check initial value and show/hide the Gamete Source dropdown accordingly
       if (treatmentSelect.value === 'Surrogacy using donor gametes') {
           ivfDonor.style.display = 'block';
       }else{
            ivfDonor.style.display = 'none';
       }
       // Add an event listener for changes in the 'types_of_treat' dropdown
       treatmentSelect.addEventListener('change', function () {
           if (treatmentSelect.value === 'Surrogacy using donor gametes') {
               ivfDonor.style.display = 'block';
           } else {
               ivfDonor.style.display = 'none';
           }
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
   document.addEventListener("DOMContentLoaded", function () {
       const closeButton = document.getElementById("closeBtn");
   
       if (closeButton) {
           closeButton.addEventListener("click", function () {
               window.location.href = "{{ route('clinic.clinicForm_list') }}";
           });
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       // Show the fail_reason div if the value is already present
       if ($('#nationalityhusband').val().trim() !== '') {
           $('#nationality_husband').show();
       }          
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       // Show the fail_reason div if the value is already present
       if ($('#preganancy_outcome').val().trim() !== '') {
           $('#preganancy_outcome1').show();
       }
      if ($('#l_birth').val().trim() !== '') {
          $('#live_birth_open').show();
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   function removeFile() {
       document.getElementById('medical_certificate').value = "";
   }
   function removeFile1() {
       document.getElementById('child_medical_certificate').value = "";
   }
</script>
<script nonce="{{ $cspNonce }}">
   // When checkbox is checked, show the select field, otherwise hide it
   
   $(document).ready(function () {
        //    $('#l_birth').on('change', function () {
   
   
        //        let l_birth = $('#l_birth').val();
        //        let maleSection = $('#male_hide');
        //        let femaleSection = $('#female_hide');
        //        let maleCheckbox = $('#male_female');
        //        let femaleCheckbox = $('#male_female1');
        //        let maleHidden = $('#male_hidden');
        //        let femaleHidden = $('#female_hidden');
        //        let maleNumber = $('#male_number');
        //        let femaleNumber = $('#female_number');
   
        //        // Reset checkboxes and number dropdowns
        //        maleCheckbox.prop('checked', false);
        //        femaleCheckbox.prop('checked', false);
        //        maleHidden.hide();
        //        femaleHidden.hide();
        //        maleNumber.val(''); // Reset dropdown to "Select"
        //        femaleNumber.val('');
   
        //        if (l_birth === "Singleton") {
        //            // Show gender selection but only allow one selection
        //            maleSection.show();
        //            femaleSection.show();
   
        //            maleCheckbox.on('change', function () {
        //            maleNumber.val(''); // Reset dropdown to "Select"
        //            femaleNumber.val('');
        //                if (this.checked) {
        //                    femaleCheckbox.prop('checked', false);
        //                    maleHidden.show();
        //                    femaleHidden.hide();
        //                } else {
        //                    maleHidden.hide();
        //                }
        //            });
   
        //            femaleCheckbox.on('change', function () {
        //                maleNumber.val(''); // Reset dropdown to "Select"
        //        femaleNumber.val('');
        //                if (this.checked) {
        //                    maleCheckbox.prop('checked', false);
        //                    femaleHidden.show();
        //                    maleHidden.hide();
        //                } else {
        //                    femaleHidden.hide();
        //                }
        //            });
   
        //        } else {
        //            // For Twin or Higher Order, allow both Male and Female selection
        //            maleSection.show();
        //            femaleSection.show();
        //            maleHidden.hide();
        //            femaleHidden.hide();
   
        //            maleCheckbox.off('change').on('change', function () {
        //                maleHidden.toggle(this.checked);
        //            });
   
        //            femaleCheckbox.off('change').on('change', function () {
        //                femaleHidden.toggle(this.checked);
        //            });
        //        }
        //    });
        $('#preganancy_outcome').on('change', function () {
   
            
           let l_birth = $('#l_birth').val();
           let maleSection = $('#male_hide');
           let femaleSection = $('#female_hide');
           let maleCheckbox = $('#male_female');
           let femaleCheckbox = $('#male_female1');
           let maleHidden = $('#male_hidden');
           let femaleHidden = $('#female_hidden');
           let maleNumber = $('#male_number');
           let femaleNumber = $('#female_number');
           let l_birth_hidden = $('#l_birth_hidden');
   
           // Reset checkboxes and number dropdowns
           maleCheckbox.prop('checked', false);
           femaleCheckbox.prop('checked', false);
           maleHidden.hide();
           femaleHidden.hide();
           maleNumber.val(''); // Reset dropdown to "Select"
           femaleNumber.val('');
           l_birth.val('');
           l_birth_hidden.val('');
         

   
           if (l_birth === "Stillbirth") {
               // Show gender selection but only allow one selection
               maleSection.show();
               femaleSection.show();
   
               maleCheckbox.on('change', function () {
                   maleNumber.val(''); // Reset dropdown to "Select"
           femaleNumber.val('');
                   if (this.checked) {
                       femaleCheckbox.prop('checked', false);
                       maleHidden.show();
                       femaleHidden.show();
                   } 
               });
   
   
   
           } else {
               // For Twin or Higher Order, allow both Male and Female selection
               maleSection.show();
               femaleSection.show();
               maleHidden.hide();
               femaleHidden.hide();
   
               maleCheckbox.off('change').on('change', function () {
                   maleHidden.toggle(this.checked);
               });
   
   
           }
           });
       });
   
   
   $('#male_female1').change(function() {
       if ($(this).is(':checked')) {
           $('#female_hidden').show();
       } else {
           $('#female_hidden').hide();
       }
   });
   $('#l_birth').change(function() {
       if ($(this).is(':checked')) {
           $('#female_hidden').show();
       } else {
           $('#female_hidden').hide();
       }
   });

   document.addEventListener('DOMContentLoaded', function () {
        const maleSelect = document.getElementById('male_number');
        const femaleSelect = document.getElementById('female_number');
        const birthSelect = document.getElementById('l_birth');
        const birthHidden = document.getElementById('l_birth_hidden');

        function updateBirthType() {
            const male = parseInt(maleSelect.value) || 0;
            const female = parseInt(femaleSelect.value) || 0;
            const total = male + female;
            // Clear previous selection
            birthSelect.selectedIndex = 0;

            // Choose visible dropdown option
            if (total > 2) {
                birthSelect.value = 'Higher Order';
                birthHidden.value = 'Higher Order';
            } else if (total === 2) {
                birthSelect.value = 'Twin';
                birthHidden.value = 'Twin';
            } else if (total === 1) {
                birthSelect.value = 'Singleton';
                birthHidden.value = 'Singleton';
            } else {
                birthSelect.value = '';
                birthHidden.value = '';
            }
        }

        maleSelect.addEventListener('change', updateBirthType);
        femaleSelect.addEventListener('change', updateBirthType);
    });
   
   
   
</script>
<script nonce="{{ $cspNonce }}">
   $('#nationalityhusband').on('change', function() {
       if (this.value == 'OCI Card Holders') {
           $("#other_nationality1").show();
        //    $('#other_nationality option[value="248"]').remove();
           $('#other_nationality option').filter(function () {
                        return $(this).text().trim() === 'India';
                    }).remove();
       } else {
           $("#other_nationality1").hide();
           $('#other_nationality').val('');
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
    $('#nationality_wife').on('change', function() {
       if (this.value == 'OCI Card Holders') {
           $("#other_nationality1_wife").show();
        //    $('#other_nationality_wife option[value="248"]').remove();
           $('#other_nationality_wife option').filter(function () {
                        return $(this).text().trim() === 'India';
                    }).remove();
       } else {
            $("#other_nationality1_wife").hide();
            $('#other_nationality_wife').val('');
       }
    });
</script>
<script nonce="{{ $cspNonce }}">
document.addEventListener("DOMContentLoaded", function () {
  
const coupleRadio = document.getElementById("flexRadioDefault1");
const singleWomanRadio = document.getElementById("flexRadioDefault2");
const nationalityHusband = document.getElementById("nationality_husband");
const CoupleRadionatinaltyHusband = document.getElementById("nationalityhusband");
const maleFactorDive = document.getElementById("male_factor_div");
const nationalityWife = document.getElementById("nationality_wife1");
const otherNationalityHusband = document.getElementById("other_nationality1");
const otherNationalityWife = document.getElementById("other_nationality1_wife");
const nationalityHusbandSelect = document.getElementsByName("nationality");
const nationalityWifeSelect = document.getElementById("nationality_wife");
const husbandAge = document.getElementById("husband_age");
const wifeAge = document.getElementById("wife_age1");
const age_of_women = document.getElementById("single");

const tratmentOutcome = document.getElementById("tratment_Outcome");
const failReason = document.getElementById("fail_reason");


// const wifeAgeLabel = document.getElementById("wife_age_label");

   
if (coupleRadio.checked) {
    // Show all couple-related fields
    // nationalityHusband.style.display = "block";
    // nationalityWife.style.display = "block";
    // age_of_women.style.display = "none";
    // husbandAge.style.display = "block";
    // wifeAge.style.display = "block";
    // maleFactorDive.style.display = "block";
    // otherNationalityHusband.style.display = "block";
    
    // wifeAgeLabel.innerHTML ="<strong>Wife Age</strong>";
    // if (CoupleRadionatinaltyHusband.value != "Indian") {
    //         otherNationalityHusband.style.display = "block";
    //     } else {
    //         otherNationalityHusband.style.display = "none";
    //     }

    //     if (nationalityWifeSelect.value !== "Indian") {
    //         otherNationalityWife.style.display = "block";
    //     } else {
    //         otherNationalityWife.style.display = "none";
    //     }
    
} else if (singleWomanRadio.checked) {
    // Hide husband-related fields
    // nationalityHusband.style.display = "none";
    // nationalityHusband.value = "";

    // nationalityWife.style.display = "block";
    // age_of_women.style.display = "block";
    // otherNationalityHusband.style.display = "none";

    // // Hide other nationality fields
    // otherNationalityWife.style.display = "none";
    

    // // Optionally clear the 'other nationality' input values
    // // otherNationalityHusband.value = "";
    // otherNationalityWife.value = "";

    // // Hide husband and wife age (assuming these should not show for single woman)
    // husbandAge.style.display = "none";
    // wifeAge.style.display = "none";
    maleFactorDive.style.display = "none";
    maleFactorDive.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
                input.checked = false;
            });
    
    // wifeAgeLabel.innerHTML ="<strong>Age</strong>";
        
}   
        const liveBirthOpen = document.getElementById('live_birth_open');
        const totalNunCycles = document.getElementById('total_nun_cycles');
        const noCycles = document.getElementById('no_cycles');
        
        if(totalNunCycles.value === noCycles.value ){
            if(tratmentOutcome.value === 'Not Pregnant'){
                    liveBirthOpen.style.display = 'none';

            }
            $('#tratment_Outcome').html('<option value="Not Pregnant">Not Pregnant</option>');
            
            
        }

        if(no_cycles.value == 0){
           failReason.style.display = 'none'; 
        }
   
   function resetCountryFields() {
       nationalityHusbandSelect.value = "";
       nationalityWifeSelect.value = "";
       otherNationalityHusband.style.display = "none";
       otherNationalityWife.style.display = "none";
   }
   
   function toggleFields() {
       if (coupleRadio.checked) {
           nationalityHusband.style.display = "block";
           nationalityWife.style.display = "block";
           maleFactorDive.style.display = "block";
           wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span style='color:red;'>*</span>";
           wifeAgeLabel.innerHTML ="<strong>Wife Age</strong>";
       } else if (singleWomanRadio.checked) {
           nationalityHusband.style.display = "none";
           nationalityWife.style.display = "block";
            maleFactorDive.style.display = "none";
           wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";
           wifeAgeLabel.innerHTML ="<strong>Age</strong>";
           
       }
   
       // Reset and hide country fields when changing the main radio button
       resetCountryFields();
   }
   
   function toggleCountryFields() {
       otherNationalityHusband.style.display = nationalityHusbandSelect.value === "OCI Card Holders" ? "block" : "none";
       otherNationalityWife.style.display = nationalityWifeSelect.value === "OCI Card Holders" ? "block" : "none";
   }
   
   // Event Listeners
   coupleRadio.addEventListener("change", toggleFields);
   singleWomanRadio.addEventListener("change", toggleFields);
   nationalityHusbandSelect.addEventListener("change", toggleCountryFields);
   nationalityWifeSelect.addEventListener("change", toggleCountryFields);
   
   // Ensure default visibility based on current selections
   toggleFields();
   });

    if ( document.getElementById("tratment_Outcome").value === "Pregnant" && (document.getElementById("preganancy_outcome").value === "Therapeutic abortion with consent of Surrogate mother & authorization by AA" || document.getElementById("preganancy_outcome").value === "Spontaneous abortion"))
    {
        document.getElementById('gender_child1').style.display ="none";
    }
   
     
</script>
<script nonce="{{ $cspNonce }}">
   var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".png"];
   
   function validateForSize(oInput, minSize, maxSizejpeg) {
    //    console.log("Triggered validateForSize for ID:", oInput.id);
   
       if (oInput.type == "file") {
           var sFileName = oInput.value;
           if (sFileName.length > 0) {
               var blnValid = false;
               for (var j = 0; j < _validFilejpeg.length; j++) {
                   var sCurExtension = _validFilejpeg[j];
                   if (sFileName.toLowerCase().endsWith(sCurExtension.toLowerCase())) {
                       blnValid = true;
                       break;
                   }
               }
   
               if (!blnValid) {
                   alert("Sorry, this file is invalid. Allowed extensions: " + _validFilejpeg.join(", "));
                   oInput.value = "";
                   return false;
               }
           }
       }
   
       fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
   }
   
   function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
       if (fdata.files && fdata.files[0]) {
           var fsize = fdata.files[0].size / 1024;
           if (fsize > maxSizejpeg || fsize < minSize) {
               alert('This file size is: ' + fsize.toFixed(2) +
                     "KB. Files should be between " + minSize + " and " + maxSizejpeg + " KB.");
               fdata.value = "";
               return false;
           }
       }
   }
   
   // ✅ Attach listeners using IDs
   document.addEventListener("DOMContentLoaded", function() {
       const medicalInput = document.getElementById("medical_certificate");
       const childMedicalInput = document.getElementById("child_medical_certificate");
   
       if (medicalInput) {
           medicalInput.addEventListener("change", function() {
               validateForSize(this, 50, 200);
           });
       }
   
       if (childMedicalInput) {
           childMedicalInput.addEventListener("change", function() {
               validateForSize(this, 50, 200);
           });
       }
   });
   
   
   
   
   
   
   
   
   // var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".png"];
   
   // function validateForSize(oInput, minSize, maxSizejpeg) {
   //     //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
   //     if (oInput.type == "file") {
   //         var sFileName = oInput.value;
   //         if (sFileName.length > 0) {
   //             var blnValid = false;
   //             for (var j = 0; j < _validFilejpeg.length; j++) {
   //                 var sCurExtension = _validFilejpeg[j];
   //                 if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
   //                     .toLowerCase() == sCurExtension.toLowerCase()) {
   //                     blnValid = true;
   //                     break;
   //                 }
   //             }
   
   //             if (!blnValid) {
   //                 alert("Sorry, this file is invalid, allowed extension is: " + _validFilejpeg.join(", "));
   //                 oInput.value = "";
   //                 return false;
   //             }
   //         }
   //     }
   
   //     fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
   // }
   
   // function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
   //     if (fdata.files && fdata.files[0]) {
   //         var fsize = fdata.files[0].size /
   //             1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
   //         //alert(fsize)
   //         if (fsize > maxSizejpeg || fsize < minSize) {
   //             alert('This file size is: ' + fsize.toFixed(2) +
   //                 "KB. Files should be in " + (minSize) + " to " + (maxSizejpeg) + " KB ");
   //             fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
   //             return false;
   //         } else {
   //             console.log("");
   //         }
   //     }
   // }
</script>
<script nonce="{{ $cspNonce }}">
    if($("#num_pre_child").val() == 'Yes'){
        $('#file_show').show();
        $("#num_per_child_details").show();
    }else{
        $('#file_show').hide();
        $("#num_per_child_details").hide();
    }
   $('#num_pre_child').on('change', function() {

       $("#give_details").val('');
       $("#child_medical_certificate").val('');
   
   
       if (this.value == 'Yes') {
           $("#medical_open").show();
           $("#child_medical_open").show();
           $("#existing_child_medical_file").show();
           $("#child_medical_upload").show();
           $("#file_show").show();
           
   
           // child_medical_open
       } else {
           $("#medical_open").hide();
           $("#child_medical_open").hide();
        //    $("#child_medical_certificate").hide();
           $("#existing_child_medical_file").hide();
           $("#child_medical_upload").hide();
           $("#file_show").hide();
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function(){
       $('#total_nun_cycles').change(function(){
           var selectedNumber = $(this).val();
           //alert(selectedNumber);
           var optionSelect = $('#no_cycles');
          // alert(optionSelect);
           optionSelect.empty(); // Clear previous options
           optionSelect.append('<option value="">Select</option>');
           for(var i = 0; i <= selectedNumber; i++) {
               optionSelect.append('<option value="' + i + '">' + i + '</option>');
           }
       });
       $('#total_nun_cycles').trigger('change');          
       // Trigger the change event on page load to populate options based on the default selected value
       
   });
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function() {
       let selectedTotal = '{{ old('total_nun_cycles', $uhidDetails->total_nun_cycles ?? '') }}';
       let selectedCycles = '{{ old('no_cycles', $uhidDetails->no_cycles ?? '') }}';
   
       function populateNoCycles(maxVal, selectedVal) {
           let $noCycles = $('#no_cycles');
           $noCycles.empty().append('<option value="">Select</option>');
           for (let i = 0; i <= maxVal; i++) {
               let selected = (i == selectedVal) ? 'selected' : '';
               $noCycles.append('<option value="' + i + '" ' + selected + '>' + i + '</option>');
           }
       }
   
       // Initial load from database
       if (selectedTotal) {
           populateNoCycles(parseInt(selectedTotal), selectedCycles);
       }
   
       // Update on change
       $('#total_nun_cycles').on('change', function() {
           let newVal = parseInt($(this).val()) || 0;
           populateNoCycles(newVal, '');
       });
   });
</script>
<script nonce="{{ $cspNonce }}">
   $('#no_cycles').on('change', function() {
      var selectedNumber = $(this).val();
      var optionSelect = $('#total_nun_cycles').val();
   
      //alert(optionSelect);
      if (optionSelect == selectedNumber){
   
        //  alert('done');
   
          $('#tratment_Outcome').html('<option value="Not Pregnant">Not Pregnant</option>');
           $("#preganancy_outcome1").hide();
           $("#live_birth_open").hide();
           $("#gender_child1").hide();
           $("#other_gender_id").hide();
   
      }
       else{
          $('#tratment_Outcome').html('<option value="">Select</option><option value="Pregnant">Pregnant</option><option value="Not Pregnant">Not Pregnant</option>');
   
      //   //  alert('not done');
       }
   });
</script>
{{-- <script nonce="{{ $cspNonce }}">
   document.addEventListener("DOMContentLoaded", function() {
       let radioSingleWoman = document.getElementById("flexRadioDefault2");
       let nationalityDiv = document.getElementById("nationality_wife1");
       let nationalitySelect = document.getElementById("nationality_wife");
       let nationalityWifeAge = document.getElementById("wife_age1");
       
   
       document.querySelectorAll('input[name="case_of"]').forEach(function(radio) {
           radio.addEventListener("change", function() {
            
            nationalityDiv.style.display = "block";
               if (radioSingleWoman.checked) {
                   
                   nationalityWifeAge.style.display ="none";
   
                   // Remove all options
                   nationalitySelect.innerHTML = `
                       <option value="" class="text-muted"><strong>Select</strong></option>
                       <option value="Indian" class="p-1">India</option>
                   `;
               } else {
                  
   
                   // Restore all options
                   nationalitySelect.innerHTML = `
                       <option value="" class="text-muted"><strong>Select</strong></option>
                       <option value="Indian" class="p-1">India</option>
                       <option value="OCI Card Holders" class="p-1">OCI Card Holders</option>
                   `;
               }
           });
       });
   });
</script> --}}
<!-- <select class="form-control" id="tratment_Outcome"
   name="tratment_Outcome">
   <option value="">Select</option>
   <option value="Pregnant">Pregnant</option>
   <option value="Not Pregnant">Not Pregnant</option>
   </select> -->
<!--script>
   function updateDependentField() {
       // Get the value of the number input field
       var numberInput = document.getElementById("total_nun_cycles").value;
   
      // alert(numberInput);
       // Get the dependent field dropdown
       var dependentField = document.getElementById("no_cycles");
       alert(dependentField);
       // Clear existing options
       dependentField.innerHTML = '';
   
       // Add a default option
       var defaultOption = document.createElement('option');
       defaultOption.value = '';
       defaultOption.text = 'Select an option';
       no_cycles.appendChild(defaultOption);
   
       // Populate the dropdown with options based on the number input value
       if (numberInput == 4) {
           for (var i = 1; i < numberInput; i++) {
               var option = document.createElement('option');
               option.value = i;
               option.text = i;
               dependentField.appendChild(option);
           }
       }
   }
   </script-->
<script nonce="{{ $cspNonce }}">
   $('#gender_child').select2({
       theme: "bootstrap-5",
       width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
           'w-100') ? '100%' : 'style',
       placeholder: $(this).data('placeholder'),
       closeOnSelect: false,
   });
</script>
<script nonce="{{ $cspNonce }}">
   $('#types_of_treat').on('change', function() {
       $("#types_of_treat1").val('');
       if (this.value == 'Surrogacy using donor gametes') {
           $("#ivf_donor").show();
       } else if (this.value == 'Surrogacy using self gametes') {
            $("#ivf_donor").hide();
        } else {
           // 10-07-2024
          // $("#ivf_donor").hide();
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   // 16-07-2024
//    $('#types_of_treat').on('change', function() {
//    $("#types_of_treat1").val('');
//    if (this.value == 'Surrogacy using self gametes') {
//        $("#ivf_donor").hide();
//    } else {
//        // 10-07-2024
//       // $("#ivf_donor").hide();
//    }
//    });
</script>
<script nonce="{{ $cspNonce }}">
   $('#num_pre_child').on('change', function() {
       if (this.value == 'Yes') {
           $("#num_per_child_details").show();
           $("#child_medical_upload").show();
       } else {
           $("#num_per_child_details").hide();
           $("#child_medical_upload").hide();
       }
   });
</script>
<!-- 04-07-2024 -->
<script nonce="{{ $cspNonce }}">
   $('#no_cycles').on('change', function() {
       var num_of_child = $('#no_cycles').val();
       if (num_of_child > 0) {
           $('#fail_reason').show();
       } else {
           $('#fail_reason').hide();
           $('#Cycle_fail_reason').val('');
       }
   
   });
</script>
<script nonce="{{ $cspNonce }}">
   $('#total_nun_cycles').on('change', function() {
       $("#tratment_Outcome").val('');
   
   
       if (this.value == 'Completed') {
           $("#tratment_Outcome1").show();
           //$("#preganancy_outcome1").show();
       } else {
           $("#tratment_Outcome1").hide();
           $("#preganancy_outcome1").hide();
           $("#live_birth_open").hide();
           $("#gender_child1").hide();
       }
   });
</script>
<script nonce="{{ $cspNonce }}">
   $('#tratment_Outcome').on('change', function() {
       $("#preganancy_outcome").val('');
       $("#l_birth").val('');
       $("#gender_child").val('');    
       $("#other_gender").val('');
      
      // gender_child
       if (this.value == 'Not Pregnant') {
           $("#preganancy_outcome1").hide();
           $("#live_birth_open").hide();
           $("#gender_child1").hide();
           $("#other_gender_id").hide();
   
   
       } else if (this.value == '') {
           $("#preganancy_outcome1").hide();
           //$("#preganancy_outcome1").hide();
   
       } else {
           $("#preganancy_outcome1").show();
           //$("#preganancy_outcome1").hide();
   
       }
   });
</script>
<!--script>
   $('#tratment_Outcome').on('change', function() {
       $("#preganancy_outcome").val('');
   
       if (this.value == 'Pregnant') {
           $("#preganancy_outcome1").show();
           //$("#preganancy_outcome1").show();
       } else {
           $("#preganancy_outcome1").hide();
           //$("#preganancy_outcome1").hide();
       }
   });
   </script-->
<script nonce="{{ $cspNonce }}">
   $('#age_of_women').on('change', function() {
   
       if (this.value != '') {
           $("#own_gametes").removeAttr('selected');
           $("#d_gametes").attr('selected', 'selected');
           $("#d_gametes").attr('readonly', 'readonly');
           $("#o_sperm").removeAttr('selected');
           $("#d_sperm").attr('selected', 'selected');
           $("#d_sperm").attr('readonly', 'readonly');
           $('#types_of_treat').html(
               '<option value="Surrogacy using donor gametes">Surrogacy using donor gametes</option>');
           $('#types_of_treat1').html(
               '<option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">Self Oocyte & Donor Sperm </option>'
           );
       } else {
           $("#d_gametes").removeAttr('selected');
           $("#d_gametes").removeAttr('readonly');
           $('#types_of_treat').html(
               '<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="Surrogacy using own gametes" id="own_gametes" class="p-1">Surrogacy using own gametes</option><option value="Surrogacy using donor gametes" id="d_gametes" class="p-1">Surrogacy using donor gametes</option>'
           );
       }
   
       // } else if (this.value == 'Self IVF using donor gametes') {
       //     $("#partner_selfs").removeAttr('selected');
       //     $("#donors").attr('selected', 'selected');
       //     $("#semen_source").attr('readonly', 'readonly');
       //     $("#partner_selfe").removeAttr('selected');
       //     $("#donore").attr('selected', 'selected');
       //     $("#egg_source").attr('readonly', 'readonly');
   
       // } else {
       //     $("#donors").removeAttr('selected');
       //     $("#partner_selfs").removeAttr('selected');
       //     $("#semen_source").removeAttr('readonly');
       // }
   });
</script>
<script nonce="{{ $cspNonce }}" type="text/javascript">
   $(document).ready(function() {
       $('input[type="radio"]').
       click(
           function() {
               const inputValue =
                   $(this).attr("value");
               const targetBox =
                   $("." + inputValue);
               $(".selectt").
               not(targetBox).hide();
               $(targetBox).show();
           }
       );
   });
</script>
{{-- <script nonce="{{ $cspNonce }}">
   $('#l_birth').on('change', function() {
       $("#gender_child").val('');
       $("#other_gender").val('');
   
       if (this.value == 'Higher Order') {
           $("#other_gender_id").show();
           $("#gender_child1").hide();
       } else if (this.value == 'Singleton') {
           $("#other_gender_id").hide();
           $("#gender_child1").show();
       } else if (this.value == 'Twin') {
           $("#other_gender_id").hide();
           $("#gender_child1").show();
       } else {
           $("#other_gender_id").hide();
           $("#gender_child1").hide();
       }
   });
</script> --}}
<!--script>
   $('#preganancy_outcome').on('change', function() {
       if (this.value == 'stillbirth') {
           $("#gender_child1").show();
       } else {
           $("#gender_child1").hide();
       }
   });
   </script-->
<script nonce="{{ $cspNonce }}">
   $('#preganancy_outcome').on('change', function() {
       $("#gender_child").val('');
       $("#l_birth").val('');
       // alert(this.value);
       if (this.value == 'live birth') {
           $("#live_birth_open").show();
           $("#gender_child1").show();
       } else if (this.value == 'Stillbirth') {
           $("#gender_child1").show();
           $("#live_birth_open").hide();
           $('#l_birth_hidden').val('');
       } else if (this.value == 'Therapeutic abortion with consent of Surrogate mother & authorization by AA') {
           $("#gender_child1").hide();
           $("#live_birth_open").hide();
       } else if (this.value == 'Spontaneous abortion') {
           $("#gender_child1").hide();
           $("#live_birth_open").hide();
       } 
       //{{--else if (this.value == 'Elective Termination') {
       //    $("#gender_child1").hide();
       //    $("#live_birth_open").hide();
       //} --}} 
       else if (this.value == '') {
           $("#gender_child1").hide();
           $("#live_birth_open").hide();
       } else {
           $("#live_birth_open").hide();
           $("#gender_child1").hide();
       }
   });
</script>
<!--script>
   $('#preganancy_outcome').on('change', function() {
       if (this.value == 'live birth') {
           $("#live_birth_open").show();
           //$("#gender_child1").show();
       } else {
           $("#live_birth_open").hide();
           // $("#gender_child1").hide();
       }
   });
   </script-->
<script nonce="{{ $cspNonce }}">
   $('#total_nun_cycles').on('change', function() {
       if (this.value == 'Cancelled') {
           $("#fail_reason").show();
       } else if (this.value == 'Failed') {
           $("#fail_reason").show();
       } else {
           $("#fail_reason").hide();
       }
   
   });
</script>
<script nonce="{{ $cspNonce }}">
   document.addEventListener("DOMContentLoaded", function () {
       var birthSelect = document.getElementById("l_birth");
       var genderSelect = document.getElementById("gender_child");
   
       function updateGenderSelection() {
           if (birthSelect.value === "Singleton") {
               genderSelect.multiple = false; // Allow only one selection
               genderSelect.classList.add("form-control"); // Keep the input styling
               genderSelect.selectedIndex = -1; // Reset selection
           } else {
               genderSelect.multiple = true; // Allow multiple selections
               genderSelect.classList.add("form-control"); // Keep the input styling
           }
       }
   
       // Run once on page load
       updateGenderSelection();
   
       // Listen for changes in the Live Birth dropdown
       birthSelect.addEventListener("change", updateGenderSelection);
   });
   //         function validateForm() {
   //     const existingFileValue = document.getElementById("existing_medical_file_input")?.value.trim();
   //     const newFile = document.getElementById("medical_certificate").value.trim();
   
   //     // Case: No existing file AND no new file
   //     if (existingFileValue === "" && newFile === "") {
   //         alert("Upload Certificate of Medical Indication issued by District Medical Board");
   //         document.getElementById("medical_certificate").focus();
   //         return false;
   //     }
   
   //     return true;
   // }
   // function removeExistingMedicalFile() {
   //     // Remove preview
   //     const existingDiv = document.getElementById('existing_medical_file');
   //     if (existingDiv) {
   //         existingDiv.remove();
   //     }
   
   //     // Clear hidden input
   //     const existingInput = document.getElementById('existing_medical_file_input');
   //     if (existingInput) {
   //         existingInput.value = '';
   //     }
   
   //     // Show file input (if hidden previously)
   //     const uploadDiv = document.getElementById('medical_upload');
   //     if (uploadDiv) {
   //         uploadDiv.style.display = 'block';
   //     }
   // }
</script>
<script nonce="{{ $cspNonce }}">
   $(document).ready(function () {
           $('#btnSubmit').on('click', function (e) {
               if (!validatesubmit()) {
                    e.preventDefault();
                }
           });
       });
     
       function validatesubmit() {

    const isCouple = $('#flexRadioDefault1').is(':checked');
    const isSingle = $('#flexRadioDefault2').is(':checked');

    const getVal = id => document.getElementById(id)?.value.trim();
    const isEmpty = id => !getVal(id);
    /* ================= BASIC ================= */

    if (isEmpty("pati_uhid")) {
        alert("Patient UHID cannot be blank");
        $("#pati_uhid").focus();
        return false;
    }

    if (!isCouple && !isSingle) {
        alert("Please select either the couple or single woman");
        $("#flexRadioDefault1").focus();
        return false;
    }

    /* ================= COUPLE CASE ================= */

    if (isCouple) {

        if (isEmpty("age")) {
            alert("Please Select Husband age");
            $("#age").focus();
            return false;
        }

        if (isEmpty("wife_age")) {
            alert("Please Select Wife age");
            $("#wife_age").focus();
            return false;
        }
        if (getVal("nationality")) {
            alert("Nationality of the Husband cannot be blank");
            $("#nationality").focus();
            return false;
        }

        if (getVal("nationality") === "OCI Card Holders" && isEmpty("other_nationality")) {
            alert("Please specify Country");
            $("#other_nationality").focus();
            return false;
        }

        if (isEmpty("nationality_wife")) {
            alert("Nationality cannot be blank");
            $("#nationality_wife").focus();
            return false;
        }

        if (getVal("nationality_wife") === "OCI Card Holders" && isEmpty("other_nationality_wife")) {
            alert("Please specify Country");
            $("#other_nationality_wife").focus();
            return false;
        }
    }
    if(getVal("for_others") === 'Others'){
    }else{
        $('#art_undertaken_other').val('');
    }
    if(getVal("tratment_Outcome") === 'Not Pregnant'){
            $('#l_birth_hidden').val('');
    }
    if(getVal(no_cycles) == 0){
        $('#Cycle_fail_reason').val('');
    }
    /* ================= SINGLE WOMAN ================= */

    if (isSingle) {

        // if (isEmpty("age_of_women")) {
        //     alert("Please Select Age of woman (widow or divorcee)");
        //     $("#age_of_women").focus();
        //     return false;
        // }

        if (isEmpty("nationality_wife")) {
            alert("Nationality cannot be blank");
            $("#nationality_wife").focus();
            return false;
        }
    }
    /* ================= HAVING CHILD ================= */
    if (document.getElementById("num_pre_child").value == "") {
                 alert("Having Surviving Child cannot be blank");
                 document.getElementById("num_pre_child").focus();
                 return false;
             }
    if ((document.getElementById("num_pre_child").value == "No") && (!document.getElementById("declaration1").checked)) {
                 alert("Check the undertaking from intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier"
                 );
                 document.getElementById("declaration1").focus();
                 return false;
             }
    if ((document.getElementById("num_pre_child").value == "Yes") && (document.getElementById( "give_details").value == "")) {
                 alert("Details of child cannot be blank");
                 document.getElementById("give_details").focus();
                 return false;
             }  
    if (document.getElementById("num_pre_child").value === "Yes" && document.getElementById("child_medical_certificate").files.length === 0 && !document.getElementById("existing_child_medical_certificate_input")) {
                 alert("Upload the Medical Certificate of child");
                 document.getElementById("child_medical_certificate").focus();
                 return false;
             }  
    /* ================= MEDICAL FACTOR ================= */

    const factors = [
        "male_factor",
        "uterus_ab",
        "ivf_failure",
        "preg_loss",
        "life_threat"
    ];

    const factorSelected = factors.some(id => document.getElementById(id).checked);

    if (!factorSelected) {
        alert("Please select at least one medical indication.");
        return false;
    }

    if (isEmpty("medical_surrogacy")) {
        alert("Medical Condition Necessitating Surrogacy cannot be blank");
        $("#medical_surrogacy").focus();
        return false;
    }

    /* ================= TREATMENT ================= */

    if (isEmpty("types_of_treat")) {
        alert("Type of Treatment cannot be blank");
        $("#types_of_treat").focus();
        return false;
    }

    if (getVal("types_of_treat") === "Surrogacy using donor gametes" && isEmpty("types_of_treat1")) {
        alert("Gamete Source cannot be blank");
        $("#types_of_treat1").focus();
        return false;
    }
    if (document.getElementById("surrogate_mother_age").value == "") {
                 alert("Surrogate Mother Age cannot be blank");
                 document.getElementById("surrogate_mother_age").focus();
                 return false;
             }
    if (document.getElementById("for_others").value == "") {
                alert("ART Procedure Undertaken cannot be blank");
                document.getElementById("for_others").focus();
                return false;
            }
    if ((document.getElementById("for_others").value == "Others") && (document.getElementById(
                    "art_undertaken_other").value == "")) {
                alert("Please specify other ART Procedures");
                document.getElementById("art_undertaken_other").focus();
                return false;
            }
    if (document.getElementById("total_nun_cycles").value == "") {
                alert("Total No. of Treatment Cycle(s) Undertaken cannot be blank");
                document.getElementById("total_nun_cycles").focus();
                return false;
            }
        
    if (document.getElementById("no_cycles").value == "") {
                alert("No. of Cycles Cancelled/Failed cannot be blank");
                document.getElementById("no_cycles").focus();
                return false;
            }
    
    if ((document.getElementById("no_cycles").value > 0 ) && (document.getElementById(
                    "Cycle_fail_reason").value == "")) {
                alert("Please specify reason for Cycle Cancellation");
                document.getElementById("Cycle_fail_reason").focus();
                return false;
            }

    /* ================= OUTCOME ================= */

    const outcome = getVal("tratment_Outcome");
    const pregOutcome = getVal("preganancy_outcome");
  
    if (isEmpty("tratment_Outcome")) {
        alert("Treatment Outcome cannot be blank");
        $("#tratment_Outcome").focus();
        return false;
    }
        

            if (outcome === "Pregnant" && isEmpty("preganancy_outcome")) {
                alert("Pregnancy Outcome cannot be blank");
                $("#preganancy_outcome").focus();
                return false;
            }

            if (pregOutcome === "live birth" && isEmpty("l_birth")) {
                alert("Live Birth Pregnancy Outcome cannot be blank");
                $("#l_birth").focus();
                return false;
            }

            /* ================= DECLARATION ================= */

            if (!document.getElementById("declaration").checked) {
                alert("Check the undertaking from Surrogate Mother.");
                $("#declaration").focus();
                return false;
            }
            if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration3").checked)) {
                 alert("Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time.");
                 document.getElementById("declaration3").focus();
                 return false;
            }
            if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration4").checked)) {
                 alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman");
                 document.getElementById("declaration4").focus();
                 return false;
            }
            if ((document.getElementById("types_of_treat1").value == "Self Oocyte & Donor Sperm") && (!document.getElementById("declaration4")
                     .checked)) {
                 alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman");
                 document.getElementById("declaration4").focus();
                 return false;
            }
   
    /* ================= FINAL CONFIRM ================= */

    return confirm(
        "Kindly check and confirm all details before final submission. There is no provision for editing once submitted."
    );
}
            $('#deleteBtn').on('click', function () {
                            let patientUhid = $(this).data('uhid');

                if (!confirm('Are you sure you want to delete Patient UHID: ' + patientUhid + '?')) {
                    return false;
                }
                });
// function validatesubmit() {
//            if (document.getElementById("pati_uhid").value == "") {
//                alert("Patient UHID cannot be blank");
//                document.getElementById("pati_uhid").focus();
//                return false;
//            }        
//            var couple = document.getElementsByName('case_of');
//            var genValue = false;
//            for (var i = 0; i < couple.length; i++) {
//                if (couple[i].checked == true) {
//                    genValue = true;
//                }
//            }
//            if (!genValue) {
//                alert("Please select either the couple or single woman");
//                document.getElementById("flexRadioDefault1").focus();
//                return false;
//            }

//            if ($('#flexRadioDefault1').is(':checked') && $('#age').val() == "") {
//                alert("Please Select Husband age");
//                document.getElementById("age").focus();
//                return false;
//            }
       
//            if ($('#flexRadioDefault1').is(':checked') && $('#wife_age').val() == "") {
//                alert("Please Select Wife age");
//                document.getElementById("wife_age").focus();
//                return false;
//            }

//             if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val().trim() === "") {
//                 alert("Nationality of the Husband cannot be blank");
//                 $('#nationality').focus();
//                 return false;
//             }
   
//            if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "OCI Card Holders" && $('#other_nationality').val() == "") {
//                alert("Please specify Country");
//                document.getElementById("other_nationality").focus();
//                return false;
//            }
//            if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "") {
//                alert("Nationality cannot be blank");
//                document.getElementById("nationality_wife").focus();
//                return false;
//            }
   
//            if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $('#other_nationality_wife').val() == "") {
//                alert("Please specify Country");
//                document.getElementById("other_nationality_wife").focus();
//                return false;
//            }
       
//            if ($('#flexRadioDefault2').is(':checked') && $('#age_of_women').val() == "") {
//                alert("Please Select Age of woman (widow or divorcee)");
//                document.getElementById("age_of_women").focus();
//                return false;
//            }
//             const isChecked = $('#flexRadioDefault2').prop('checked'); 
   
//         if (isChecked && $('#age_of_women').val().trim() === "") {
//             alert("Please Select Age of woman (widow or divorcee)");
//             $('#age_of_women').focus();
//             return false;
//         }
    
//         // return true;
        
//             if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "") {
//                 alert("Nationality cannot be blank");
//                 document.getElementById("nationality_wife").focus();
//                 return false;
//             }
    
//             if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $('#other_nationality_wife').val() == "") {
//                 alert("Please specify Country");
//                 document.getElementById("other_nationality_wife").focus();
//                 return false;
//             } 
//             if (document.getElementById("num_pre_child").value == "") {
//                 alert("Having Surviving Child cannot be blank");
//                 document.getElementById("num_pre_child").focus();
//                 return false;
//             }
        
//             if ((document.getElementById("num_pre_child").value == "No") && (!document.getElementById("declaration1").checked)) {
//                 alert("Check the undertaking from intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier"
//                 );
//                 document.getElementById("declaration1").focus();
//                 return false;
//             }
            
//                 let male = document.getElementById("male_factor").checked;
//                 let uterus_ab = document.getElementById("uterus_ab").checked;
//                 let ivf_failure = document.getElementById("ivf_failure").checked;
//                 let preg_loss = document.getElementById("preg_loss").checked;
//                 let life_threat = document.getElementById("life_threat").checked;
//                 if (!male && !uterus_ab && !ivf_failure && !preg_loss && !life_threat) {
//                     alert("Please select at least one factor.");
//                     return false; 
//                 }
//                 if (document.getElementById("medical_surrogacy").value == "") {
//                     alert("Medical Condition Necessitating Surrogacy cannot be blank");
//                     document.getElementById("medical_surrogacy").focus();
//                     return false;
//                     }
//             if ( document.getElementById("medical_certificate").value.trim() === "" && document.getElementById("existing_medical_file_input")?.value.trim() === "" ) {
//                 alert("Upload Certificate of Medical Indication issued by District Medical Board");
//                 document.getElementById("medical_certificate").focus();
//                 return false;
//             }
//             if ((document.getElementById("num_pre_child").value == "Yes") && (document.getElementById( "give_details").value == "")) {
//                 alert("Details of child cannot be blank");
//                 document.getElementById("give_details").focus();
//                 return false;
//             }  
//             if (document.getElementById("num_pre_child").value === "Yes" && document.getElementById("child_medical_certificate").value.trim() === "" && document.getElementById("existing_child_medical_certificate_input")?.value.trim() === "") {
//                 alert("Upload the Medical Certificate of child");
//                 document.getElementById("child_medical_certificate").focus();
//                 return false;
//             }   
    
//                 let male = document.getElementById("male_factor").checked;
//                 let uterus_ab = document.getElementById("uterus_ab").checked;
//                 let ivf_failure = document.getElementById("ivf_failure").checked;
//                 let preg_loss = document.getElementById("preg_loss").checked;
//                 let life_threat = document.getElementById("life_threat").checked;
//             if (!male && !uterus_ab && !ivf_failure && !preg_loss && !life_threat) {
//                 alert("Please select at least one option for medical indication.");
//                 return false; 
//             }

//             if (document.getElementById("medical_surrogacy").value == "") {
//                 alert("Medical Condition Necessitating Surrogacy cannot be blank");
//                 document.getElementById("medical_surrogacy").focus();
//                 return false;
//             }
        
//             if ((document.getElementById("num_pre_child").value == "Yes") && (document.getElementById(
//                     "child_medical_certificate").value == "")) {
//                 alert("Upload the Medical Certificate of child");
//                 document.getElementById("child_medical_certificate").focus();
//                 return false;
//             }
        
//             if (document.getElementById("types_of_treat").value == "") {
//                 alert("Type of Treatment cannot be blank");
//                 document.getElementById("types_of_treat").focus();
//                 return false;
//             }
//             if ((document.getElementById("types_of_treat").value == "Surrogacy using donor gametes") && (document.getElementById("types_of_treat1").value == "")) {
//                 alert("Gamete Source cannot be blank");
//                 document.getElementById("types_of_treat1").focus();
//                 return false;
//             }
            
//             if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration3").checked)) {
//                 alert("Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time.");
//                 document.getElementById("declaration3").focus();
//                 return false;
//             }
//             if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration4").checked)) {
//                 alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman");
//                 document.getElementById("declaration4").focus();
//                 return false;
//             }
//             if ((document.getElementById("types_of_treat1").value == "Self Oocyte & Donor Sperm") && (!document.getElementById("declaration4")
//                     .checked)) {
//                 alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman");
//                 document.getElementById("declaration4").focus();
//                 return false;
//             }
        
//             if (document.getElementById("surrogate_mother_age").value == "") {
//                 alert("Surrogate Mother Age cannot be blank");
//                 document.getElementById("surrogate_mother_age").focus();
//                 return false;
//             }
//             if (document.getElementById("sel2").value == "") {
//                 alert("ART Procedure Undertaken cannot be blank");
//                 document.getElementById("sel2").focus();
//                 return false;
//             }
//             if ((document.getElementById("sel2").value == "Others") && (document.getElementById(
//                     "art_undertaken_other").value == "")) {
//                 alert("Please specify other ART Procedures");
//                 document.getElementById("art_undertaken_other").focus();
//                 return false;
//             }
//             if (document.getElementById("total_nun_cycles").value == "") {
//                 alert("Total No. of Treatment Cycle(s) Undertaken cannot be blank");
//                 document.getElementById("total_nun_cycles").focus();
//                 return false;
//             }
            
//             if (document.getElementById("no_cycles").value == "") {
//                 alert("No. of Cycles Cancelled/Failed cannot be blank");
//                 document.getElementById("no_cycles").focus();
//                 return false;
//             }
        
//             if ((document.getElementById("no_cycles").value > 0 ) && (document.getElementById(
//                     "Cycle_fail_reason").value == "")) {
//                 alert("Please specify reason for Cycle Cancellation/failure");
//                 document.getElementById("Cycle_fail_reason").focus();
//                 return false;
//             }
        
            
//             if (document.getElementById("tratment_Outcome").value == "") {
//                 alert("Treatment Outcome cannot be blank");
//                 document.getElementById("tratment_Outcome").focus();
//                 return false;
//             }
//             if ((document.getElementById("tratment_Outcome").value == "Pregnant") && (document.getElementById(
//                     "preganancy_outcome").value == "")) {
//                 alert("Pregnancy Outcome cannot be blank");
//                 document.getElementById("preganancy_outcome").focus();
//                 return false;
//             }
            
            
        
//             if ((document.getElementById("preganancy_outcome").value == "live birth") && (document.getElementById("l_birth").value == "")) {
//                 alert("Live Birth Pregnancy Outcome cannot be blank");
//                 document.getElementById("l_birth").focus();
//                 return false;
//             }
//             if ((document.getElementById("preganancy_outcome").value == "live birth")){
//             const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
//             const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
//                 if (!isChecked) {
//                     alert('Please select Gender.');
//                     document.getElementById("l_birth").focus();
//                     return false;
//                 }    
//             }
//             if (document.getElementById("preganancy_outcome").value == "Stillbirth"){
//             const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
//             const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
//                 if (!isChecked) {
//                     alert('Please select Gender.');
//                     document.getElementById("male_female").focus();
//                     return false;
//                 } 
//             }
    
//             if (document.getElementById("tratment_Outcome").value === "Not Pregnant") {

//                 document.getElementById("female_number").selectedIndex = '';
//                 document.getElementById("male_number").selectedIndex = '';
//                 document.getElementById("l_birth").selectedIndex = '';
//                 document.getElementById("l_birth_hidden").value = '';
// //                 return true;
//             }

//              if (document.getElementById("tratment_Outcome").value === "Pregnant" && document.getElementById("preganancy_outcome").value === "Stillbirth") {
//                     document.getElementById("l_birth").disabled = true;
//                     document.getElementById("l_birth_hidden").value = "";
//                 // return true;
//             }

//             if ( document.getElementById("tratment_Outcome").value === "Pregnant" && (
//                 document.getElementById("preganancy_outcome").value === "Therapeutic abortion with consent of Surrogate mother & authorization by AA" ||
//                 document.getElementById("preganancy_outcome").value === "Spontaneous abortion")){

//                     document.getElementById("female_number").selectedIndex = '';
//                     document.getElementById("male_number").selectedIndex = '';
//                     document.getElementById("l_birth").selectedIndex = '';
//                     document.getElementById("l_birth_hidden").value = '';
//                 //     return true;
//               }

//                 const tratment_Outcome = document.getElementById('tratment_Outcome').value;
//                 const preganancy_outcome = document.getElementById('preganancy_outcome').value;
//                 const male_numberNumber = document.getElementById('male_number').value;
//                 const female_number = document.getElementById('female_number').value;
                        
//                 if (
//                     tratment_Outcome === "Pregnant" &&
//                     (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
//                     male_numberNumber === ""
//                 ) {
//                     alert("Please select the number of male.");
//                     document.getElementById("male_number").focus();
//                     return false;
//                 }
//                 if (
//                     tratment_Outcome === "Pregnant" &&
//                     (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
//                     female_number === ""
//                 ) {
//                     alert("Please select the number of female.");
//                     document.getElementById("female_number").focus();
//                     return false;
//                 } 
//                 if (!document.getElementById("declaration").checked) {
//                     alert(
//                         "Check the undertaking from Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime."
//                     );
//                     document.getElementById("declaration").focus();
//                     return false;
//                 }
        
//                 var agree = confirm( "Kindly check and confirm all details before final submission. There is no provision for editing/correction once the form is submitted." );
//                 if (agree) {
//                     return true;
//                 } else {
//                     return false;
//                 }   
//        }

       
</script> 
<script nonce="{{ $cspNonce }}">
   $('#flexRadioDefault2').on('click', function() {
       if ($('#flexRadioDefault2').is(':checked')) {
           $('#age_of_women').val('');
           $('#age').val('');
           $('#wife_age').val('');
       } else {
           $('#age_of_women').val('');
       }
   });
   
//    $('#flexRadioDefault1').on('click', function() {
//        if ($('#flexRadioDefault1').is(':checked')) {
   
//            $('#types_of_treat').html('<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="Surrogacy using self gametes" id="own_gametes" class="p-1">Surrogacy using self gametes</option><option value="Surrogacy using donor gametes" id="d_gametes" class="p-1">Surrogacy using donor gametes</option>');
//            $('#types_of_treat1').html('<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">Self Oocyte & Donor Sperm </option><option value="Donor Oocyte & Self Sperm" id="o_sperm" class="p-1">Donor Oocyte & Self Sperm</option>');
           
   
//            $('#age_of_women').val('');
//            $('#male_factor').val('N');
//            $('#age').val('');
//            $('#wife_age').val('');
//        } else {
//            $('#age').val('');
//            $('#wife_age').val('');
//        }
//    });
</script>
{{-- <script nonce="{{ $cspNonce }}">
   $('#pati_uhid').blur(function() {
       var pati_uhid = $(this).val();
       //var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
   
       if (pati_uhid == "") {
           $('#availability').html('');
       } else {
           $.ajax({
               url: 'check_pati_uhid.php',
               method: "POST",
               data: {
                   pati_uhid: pati_uhid
               },
               success: function(data) {
                   if (data == 1) {
                       $('#availability').html(
                           '<span class="text-danger">UHID already exists with National ART & Surrogacy Portal.UHID has to be unique for every stakeholder.</span>'
                       );
                       $('#btnSubmit').attr("disabled", true);
                   } 
                   // else if (!regex.test(pati_uhid)) {
                   //     $('#availability').html(
                   //         '<span class="text-danger">Please enter a valid Stakeholder UHID</span>');
                   // } 
                   else {
                       $('#availability').html(
                           '<span class="text-success">UHID available for submission of application form.</span>'
                       );
                       $('#btnSubmit').attr("disabled", false);
                   }
               }
           })
       }
   });
</script> --}}
<script nonce="{{ $cspNonce }}">
   function checkUHID() {
       var pati_uhid = $('#pati_uhid').val();
       var treatmentStatus = $('input[name="previous_treatment"]:checked').val();
   
       if (pati_uhid === "") {
           $('#availability').html('');
         //  $('#btnSubmit').attr("disabled", true);
           return;
       }
   
       $.ajax({
           url: '{{ route('clinic.surrogacycheckuhid') }}',
           method: "POST",
           data: {
               pati_uhid: pati_uhid,
               _token: $('meta[name="csrf-token"]').attr('content')
           },
           success: function (response) {
               if (response.status === 'exists') {
                   if (treatmentStatus === "Yes") {
               $('#availability').html('<span class="text-success">UHID Found for this Surrogacy clinic.</span>');
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
               $('#availability').html('<span class="text-danger">UHID does not exist for this Surrogacy clinic. Kindly enter correct UHID.</span>');
               $('#btnSubmit').attr("disabled", true);
           } else {
               $('#availability').html('');
               $('#btnSubmit').attr("disabled", false);
           }
       }
             //  }
           },
           error: function (xhr) {
               console.error(xhr.responseText);
           }
       });
   }
   
   // Run when donor_id input loses focus
   $(document).on('blur', '#pati_uhid', function () {
       checkUHID();
   });
   
   // Run when previous treatment radio is changed
   $(document).on('change', 'input[name="previous_treatment"]', function () {
       checkUHID();
   });
   // Run when donor_id input loses focus
   $(document).on('blur', '#pati_uhid', function () {
       checkUHID();
   });
   
   // Run when previous treatment radio is changed
   $(document).on('change', 'input[name="previous_treatment"]', function () {
       checkUHID();
   });
</script>
{{-- <script nonce="{{ $cspNonce }}">
   $(document).on('blur', '#pati_uhid', function () {
   // $('#email').blur(function () {
   //alert('fgfd');
   //console.log('check 1');
   var pati_uhid = $(this).val();
   //console.log(email);
   //var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
   if (pati_uhid == "") {
       $('#availability').html('');
   } else {
       $.ajax({
           url: '{{ route('clinic.surrogacycheckuhid') }}', // Laravel route
           method: "POST",
           data: {
               pati_uhid: pati_uhid,
               _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
           },
           success: function (response) {
               if (response.status === 'exists') {
                   $('#availability').html(
                       '<span class="text-danger">UHID already exists with National ART & Surrogacy Portal. UHID has to be unique for every stakeholder.</span>'
                   );
                   $('#btnSubmit').attr("disabled", true);
               } 
               // else if (!regex.test(email)) {
               //     $('#availability').html(
               //         '<span class="text-danger">Please enter a valid email id</span>'
               //     );
               // }
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
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Select dropdown and Others div
    const treatmentSelect = document.getElementById('for_others');
    const othersDiv = document.getElementById('others_id');

    // Safety check (important)
    if (!treatmentSelect || !othersDiv) return;

    // Function to toggle Others field
    function toggleOthers() {
        if (treatmentSelect.value === 'Others') {
            othersDiv.style.display = 'block';
        } else {
            othersDiv.style.display = 'none';
        }
    }
    // Check on page load
    toggleOthers();

    // On change event
    treatmentSelect.addEventListener('change', toggleOthers);

});
</script>

@endsection