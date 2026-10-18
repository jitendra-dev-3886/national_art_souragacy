@extends('layouts.clinic.clinic_master')
@section('content')


<style nonce="{{$cspNonce}}">
    .step-indicator {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .csp-readonlycolor {
    background-color: #e8eaec !important;  /* light blue, change as needed */
    font-weight: bold;          /* optional */
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
.dn-csp-clinic-two{
    display:none;
}
.bc-csp-clinic-three{
    color:red;
}
.button-csp-clinic-four{

    background-color: #0b5ed7; border-color: #0b5ed7; color: white;
}
 
    .hidden {
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

        {{-- <title>Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
            and Outside India)</title> --}}

        {{-- <div class="container mt-5"> --}}
            <h3 class="card-title mb-5 text-primary">Edit Patient information form for ART Clinic</h3>
            
            <!-- Form -->
            {{-- <form id="form-wizard" method="POST" action="{{ route('clinic.save_clinic_application_form') }}" enctype="multipart/form-data"> --}}
              <!-- Step 1 -->
            
            <form name="art_clin1" method="POST" action="{{ route('clinic.patient_save_art_two_application_form_edit_patient', $uhidDetails->id) }}" enctype="multipart/form-data">                             
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
                    <label class="form-label d-block">
                        <strong>Year and Quarter</strong>
                    </label>
                    <div class="d-flex gap-3">
                       
                                <input type="text" class="form-control width-csp-clinic-one csp-readonlycolor" name="year" value="{{ $uhidDetails->year }}" readonly>
                                <input type="hidden" class="form-control width-csp-clinic-one"  name="quarter" value="{{ $uhidDetails->quarter }}" readonly>
                                <input type="text" class="form-control width-csp-clinic-one csp-readonlycolor"  value="{{ $available_quarters['description'] ?? '' }}" readonly>
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
                                    <input class="form-check-input" 
                                        type="radio" 
                                        name="previous_treatment" 
                                        id="previous_treatment_yes" 
                                        value="Yes"
                                        {{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'Yes') ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="previous_treatment_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="radio" 
                                        name="previous_treatment" 
                                        id="previous_treatment_no" 
                                        value="No"
                                        {{ (old('previous_treatment', $uhidDetails->previous_treatment) === 'No') ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="previous_treatment_no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <span id="bank_reg_numID" class="bc-csp-clinic-three">
                                {{-- Optional error or notice message --}}
                            </span>
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
                                    value="{{ $uhidDetails->clinic_level1_reg_num }}"
                                    class="form-control csp-readonlycolor" name="clinic_level1_reg_num"
                                    id="clinic_level1_reg_num" aria-describedby="clinic_level1_reg_num"
                                    placeholder="" readonly>
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="bc-csp-clinic-three"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Name of the
                                    Clinic</strong></label>
                            <div class="input-group">
                                <input type="text" value="{{ $uhidDetails->name_of_clinic }}"
                                    {{-- onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" --}}
                                    class="form-control csp-readonlycolor" name="name_of_clinic" id="name_of_clinic"
                                    aria-describedby="name_of_clinic" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                               class="bc-csp-clinic-three"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 ">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Patient
                                    UHID</strong><span class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="patient_uhid"
                                    id="patient_uhid" value="{{ $uhidDetails->patient_uhid }}" aria-describedby="patient_uhid" placeholder="" maxlength="10" readonly>
                            </div>
                            <!--span id="patient_uhidID" style="color: red;"></span-->
                            <span id="availability"></span>
                            @error('patient_uhid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>





                    {{-- <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Required Affidavit regarding
                                    following to be taken on record:</strong></label>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration"
                                        name="declaration">
                                    <label class="form-check-label" for="gridCheck">
                                        From Oocyte
                                        Donor that she has not donated more than once in her life
                                        time.
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration1"
                                        name="declaration1">
                                    <label class="form-check-label" for="gridCheck">
                                        From the ART
                                        Bank that the bank has not supplied sperm of the same donor
                                        to more than one commissioning couple/single woman.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong> Case of :</strong></label>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1" value="one" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Couple
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" value="two" required>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Single Woman
                                </label>
                                </div>
                            </div>
                            @error('flexRadioDefault')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div> --}}


                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-label form-label" for="validationCustomUsername">
                                    <strong>Case of :</strong>
                                </label>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="case_of"
                                            id="flexRadioDefault1" value="one" required
                                            {{ old('case_of', $uhidDetails->case_of ?? '') === 'one' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="case_of_couple">
                                            Couple
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="case_of"
                                            id="flexRadioDefault2" value="two" required
                                            {{ old('case_of', $uhidDetails->case_of ?? '') === 'two' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="case_of_single">
                                            Single Woman
                                        </label>
                                    </div>
                                </div>

                                @error('case_of')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    <div class="col-md-2 dn-csp-clinic-two" id="nationality_husband" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Nationality of the Husband</strong><span
                                    class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                <select name="nationality" id="nationality" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong></option>
                                    <option value="Indian" {{ old('nationality', $uhidDetails->nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                    <option value="Foreigner" {{ old('nationality', $uhidDetails->nationality ?? '') == 'Foreigner' ? 'selected' : '' }}>Foreigner</option>
                                </select>

                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 dn-csp-clinic-two " id="other_nationality1">
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                    class="bc-csp-clinic-three">*</span></label>
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

                    <div class="col-md-2 dn-csp-clinic-two" id="nationality_wife1" >                         
                        <div class="mb-3">
                            <label class="text-label form-label" id="nationality_woman_lable" for="nationality_wife"><strong>Nationality of the Wife</strong><span
                                  class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                            
                            @php
                                $selectedNationality = old('nationality_wife', $uhidDetails->nationality_wife ?? '');
                            @endphp

                            <select name="nationality_wife" id="nationality_wifeedit" class="form-control">
                                @php $selected = old('nationality_wife', $uhidDetails->nationality_wife ?? '') @endphp
                            <option value="Indian" @selected($selected === 'Indian')>Indian</option>
                            <option value="Foreigner" @selected($selected === 'Foreigner')>Foreigner</option>
                            </select>
                            </div>
                            @error('nationality_wife')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 dn-csp-clinic-two" id="other_nationality1_wife">
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                  class="bc-csp-clinic-three">*</span></label>
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
                                    <option value="">-- Select Country --</option>
                                    @if ($countries->count() > 0)
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Countries Available</option>
                                    @endif
                                </select> --}}

                            </div>
                        </div>
                    </div>
                    {{-- selectt {{ old('age_hus_wife', $uhidDetails->age_hus_wife ?? '') ? '' : 'hidden' }}" id="one_couple" --}}

                     {{-- style="{{ old('age_hus_wife', $uhidDetails->age_hus_wife ?? '') ? '' : 'display:none;' }}" --}}
                    <div class="col-md-3 one selectt {{ old('age_hus_wife', $uhidDetails->age_hus_wife ?? '') ? '' : 'hidden' }}" id="one_couple"  >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Husband Age</strong></label>
                            <div class="input-group">
                                <select name="age_hus_wife" id="age_hus_wife" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select Age</b></strong></option>
                                    <?php for($i = 21; $i <= 55; $i++) {
                                        $selected = ($i == old('age_hus_wife', $uhidDetails->age_hus_wife ?? '')) ? 'selected' : '';
                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                    } ?>
                                </select>
                            </div>
                            @error('age_hus_wife')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
{{-- style="{{ old('wife_age', $uhidDetails->wife_age ?? '') ? '' : 'display:none;' }}" --}}
                    <div class="col-md-3 one selectt {{ old('wife_age', $uhidDetails->wife_age ?? '') ? '' : 'hidden' }}" id="one_couple" >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Wife Age</strong></label>
                            <div class="input-group">
                                <select name="wife_age" id="wife_age" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select Age</b></strong></option>
                                    <?php for($i = 21; $i <= 50; $i++) {
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
                    <div class="col-md-3 two selectt age-women-section {{ old('age_of_women', $uhidDetails->age_of_women ?? '') ? '' : 'hidden' }}" id="single" >

{{-- style="{{ old('age_of_women', $uhidDetails->age_of_women ?? '') ? '' : 'display:none;' }}" --}}


                 
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Age of Woman</strong></label>
                            <div class="input-group">
                                <select name="age_of_women" id="age_of_women" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select Age</b></strong></option>
                                    <?php for($i = 21; $i <= 50; $i++) {
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
                    {{-- <div class="col-md-3 one selectt" id="one_couple" style="display:none;">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Husband Age</strong></label>
                            <div class="input-group">
                                <select name="age_hus_wife" id="age_hus_wife" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php //for($i=21;$i<=55;$i++){
                                        
                                      //  echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                  //  }
                                        ?>


                                </select>
                            </div>
                            @error('age_hus_wife')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-3 one selectt" id="one couple" style="display:none;">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Wife Age
                                </strong></label>
                            <div class="input-group">
                                <select name="wife_age" id="wife_age" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php //for($i=21;$i<=50;$i++){
                                        
                                      //  echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                  //  }
                                        ?>


                                </select>
                            </div>
                            @error('wife_age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}
                    {{-- <div class="col-md-3 two selectt" id="single" style="display:none;">
                        <div class="mb-3">                            
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age of Woman</strong></label>
                            <div class="input-group">
                                <select name="age_of_women" id="age_of_women" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php //for($i=21;$i<=50;$i++){
                                        
                                     //   echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                               //     }
                                        ?>
                                </select>
                            </div>
                            @error('age_of_women')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>                 --}}

                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Cause of
                                    Infertility</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cause_of_infretily"
                                    id="cause_of_infretily" aria-describedby="cause_of_infretily"
                                    placeholder="">
                            </div>
                            @error('cause_of_infretily')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}
                    <div class="border p-3 rounded">
                        <label class="form-label mb-3 d-block">
                            <strong>Cause of Infertility</strong>
                        </label>

                        <div class="row">
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

                            <!-- Female Factor -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="female_factor"
                                        name="female_factor"
                                        value="Y"
                                        {{ old('female_factor', $uhidDetails->female_factor ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female_factor">
                                        <strong>Female Factor</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Unexplained -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2"
                                        type="checkbox"
                                        id="unexplained"
                                        name="unexplained"
                                        value="Y"
                                        {{ old('unexplained', $uhidDetails->unexplained ?? '') == 'Y' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="unexplained">
                                        <strong>Unexplained</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Description of Cause -->
                            <div class="col-md-12 mt-3">
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control" name="cause_of_infretily"
                                    id="cause_of_infretily" aria-describedby="cause_of_infretily"
                                    value="{{ old('cause_of_infretily', $uhidDetails->cause_of_infretily ?? '') }}"
                                    placeholder="">
                                </div>
                                @error('cause_of_infretily')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="other">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>ART Procedure Undertaken</strong>
                            </label>
                            <div class="input-group">
                                <select name="art_proc_undertaken" id="art_proc_undertaken"
                                    class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == '' ? 'selected' : '' }}>
                                        <strong>Select</strong>
                                    </option>
                                    <option value="artificial insemination" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'artificial insemination' ? 'selected' : '' }}>
                                        Artificial insemination
                                    </option>
                                    <option value="intra-uterine insemination(IUI)" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-uterine insemination(IUI)' ? 'selected' : '' }}>
                                        Intra-uterine insemination(IUI)
                                    </option>
                                    <option value="in vitro fertilization-embryo transfer" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'in vitro fertilization-embryo transfer' ? 'selected' : '' }}>
                                        In vitro fertilization-embryo transfer(IVF-ET)
                                    </option>
                                    <option value="gamete intrafallopian tube transfer" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'gamete intrafallopian tube transfer' ? 'selected' : '' }}>
                                        Gamete intrafallopian tube transfer(GIFT)
                                    </option>
                                    <option value="intra-cytoplasmic sperm injection(ICSI)" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-cytoplasmic sperm injection(ICSI)' ? 'selected' : '' }}>
                                        Intra-cytoplasmic sperm injection(ICSI)
                                    </option>
                                    <option value="physiological Intra-cytoplasmic sperm injection" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'physiological Intra-cytoplasmic sperm injection' ? 'selected' : '' }}>
                                        Physiological Intra-cytoplasmic sperm injection(PICSI)
                                    </option>
                                    <option value="intra-cytoplasmic morphologically selected sperm injection" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'intra-cytoplasmic morphologically selected sperm injection' ? 'selected' : '' }}>
                                        Intra-cytoplasmic morphologically selected sperm injection(IMSI)
                                    </option>
                                    <option value="round spermatid nucleus injection" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'round spermatid nucleus injection' ? 'selected' : '' }}>
                                        Round spermatid nucleus injection(ROSNI)
                                    </option>
                                    <option value="Elongated spermatid injection" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'Elongated spermatid injection' ? 'selected' : '' }}>
                                        Elongated spermatid injection(ELSI)
                                    </option>
                                    <option value="Others" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'Others' ? 'selected' : '' }}>
                                        Others
                                    </option>
                                </select>
                            </div>
                            @error('art_proc_undertaken')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4" id="other">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>ART Procedure
                                    Undertaken</strong></label>
                            <div class="input-group">
                                <select name="art_proc_undertaken" id="art_proc_undertaken"
                                    class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong>Select</strong></option>
                                    <option value="artificial insemination" class="p-1">Artificial
                                        insemination
                                    </option>                                   
                                    <option value="intra-uterine insemination(IUI)" class="p-1">
                                        Intra-uterine
                                        insemination(IUI)</option>                                   
                                    <option value="in vitro fertilization-embryo transfer" class="p-1">
                                        In
                                        vitro fertilization-embryo transfer(IVE-ET)
                                    </option>
                                    <option value="gamete intrafallopian tube transfer" class="p-1">
                                        Gamete intrafallopian tube transfer(GIFT)
                                    </option>
                                    <option value="intra-cytoplasmic sperm injection(ICSI)" class="p-1">
                                        Intra-cytoplasmic sperm injection(ICSI)
                                    </option>
                                    <option value="physiological Intra-cytoplasmic sperm injection"
                                        class="p-1">Physiological Intra-cytoplasmic sperm
                                        injection(PICSI)</option>
                                    <option
                                        value="intra-cytoplasmic morphologically selected sperm injection"
                                        class="p-1">Intra-cytoplasmic morphologically selected
                                        sperm
                                        injection(IMSI)</option>
                                    <option value="round spermatid nucleus injection" class="p-1">
                                        Round spermatid nucleus injection(ROSNI)
                                    </option>

                                    <option value="Elongated spermatid injection" class="p-1">
                                        Elongated spermatid injection(ELSI)</option>
                                    <option value="Others" class="p-1">others</option>
                                </select>

                            </div>
                            @error('art_proc_undertaken')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}

                    <div class="col-md-4 dn-csp-clinic-two" id="others_id" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Others</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="art_undertaken_other"  value="{{ old('art_undertaken_other', $uhidDetails->art_undertaken_other ?? '') }}"
                                    id="art_undertaken_other" aria-describedby="art_undertaken_other">
                            </div>
                            @error('art_undertaken_other')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Type of Treatment</strong>
                            </label>
                            <div class="input-group">
                                <select name="types_of_treat" id="types_of_treat" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted" id="typeOfTreat1"
                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == '' ? 'selected' : '' }}>
                                        <strong><b>Select</b></strong>
                                    </option>
                                    <option value="ART Treatment using self gametes" class="p-1" id="own_gametes"
                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'ART Treatment using self gametes' ? 'selected' : '' }}>
                                        ART Treatment using self gametes
                                    </option>
                                    <option value="ART Treatment using donor gametes" class="p-1" id="d_gametes"
                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'ART Treatment using donor gametes' ? 'selected' : '' }}>
                                        ART Treatment using donor gametes
                                    </option>
                                </select>
                            </div>
                            @error('types_of_treat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Type of
                                    Treatment</strong></label>
                            <div class="input-group">
                                <select name="types_of_treat" id="types_of_treat" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted" id="typeOfTreat1">
                                        <strong><b>Select</b></strong>
                                    </option>
                                    <option
                                        value="ART Treatment using self gametes"
                                        class="p-1" id="own_gametes">
                                        ART Treatment using self gametes
                                    </option>
                                    <option value="ART Treatment using donor gametes" class="p-1"
                                        id="d_gametes">
                                        ART Treatment using donor gametes</option>
                                </select>
                            </div>
                            @error('types_of_treat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}

                    {{-- <div class="col-md-4" id="ivf_donor" style="display:none;">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Type of Donation</strong></label>
                            <div class="input-group">
                                <select name="types_of_treat1" id="types_of_treat1" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" id="tot1" class="text-muted">
                                        <strong><b>Select</b></strong>
                                    </option>
                                    <option value="Oocyte Donation" id="o_d" class="p-1">Oocyte Donation
                                    </option>
                                    <option value="Sperm Donation" id="s_d" class="p-1">
                                        Sperm Donation</option>
                                    <option value="Both Oocyte Donation & Sperm Donation" id="od"
                                        class="p-1">
                                        Both Oocyte Donation & Sperm Donation</option>

                                </select>
                            </div>
                            @error('types_of_treat1')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}
                    {{-- style="{{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') ? '' : 'display:none;' }}" --}}
                    <div class="col-md-4 {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') ? '' : 'hidden' }}" id="ivf_donor"  >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Type of Donation</strong>
                            </label>
                            <div class="input-group">
                                <select name="types_of_treat1" id="types_of_treat1" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" id="tot1" class="text-muted"
                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == '' ? 'selected' : '' }}>
                                        <strong><b>Select</b></strong>
                                    </option>
                                    <option value="Oocyte Donation" id="o_d" class="p-1"
                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Oocyte Donation' ? 'selected' : '' }}>
                                        Oocyte Donation
                                    </option>
                                    <option value="Sperm Donation" id="s_d" class="p-1"
                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Sperm Donation' ? 'selected' : '' }}>
                                        Sperm Donation
                                    </option>
                                    <option value="Both Oocyte Donation & Sperm Donation" id="od" class="p-1"
                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Both Oocyte Donation & Sperm Donation' ? 'selected' : '' }}>
                                        Both Oocyte Donation & Sperm Donation
                                    </option>
                                </select>
                            </div>
                            @error('types_of_treat1')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4" id="">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Total No. of Treatment Cycle(s) Undertaken</strong>
                            </label>
                            <div class="input-group">
                                <select name="total_num_of_cyc" id="total_num_of_cyc" class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted" {{ old('total_num_of_cyc', $uhidDetails->total_num_of_cyc ?? '') == '' ? 'selected' : '' }}>
                                        <strong><b>Select</b></strong>
                                    </option>
                                    @for ($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ old('total_num_of_cyc', $uhidDetails->total_num_of_cyc ?? '') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            @error('total_num_of_cyc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4" id="">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Total No. of Treatment Cycle(s) Undertaken
                                </strong></label>
                            <div class="input-group">
                                <select name="total_num_of_cyc" id="total_num_of_cyc" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <?php //for($i=1;$i<=20;$i++){                                                        
                                     //   echo'<option value="'.$i.'">'.$i.'</option>';                                                    
                                     //   }
                                    ?>
                                </select>                              
                            </div>
                            @error('total_num_of_cyc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div> --}}

                    <div class="col-md-4" id="no_cycles1">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>No. of Cycles Cancelled/Failed, if any
                                </strong></label>
                            <div class="input-group">
                                <select name="no_cycles" id="no_cycles" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>                                   
                                </select>                               
                            </div>
                            @error('no_cycles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>              

                    <div class="col-md-7 dn-csp-clinic-two" id="fail_reason" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Cycle Cancellation reason</strong><span class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cyc_canc_failure_reason"
                                    value="{{ old('cyc_canc_failure_reason', $uhidDetails->cyc_canc_failure_reason ?? '') }}" name="cyc_canc_failure_reason"
                                    aria-describedby="cyc_canc_failure_reason">                                
                            </div>
                            @error('cyc_canc_failure_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-4" id="" >
                        <div class="mb-3">
                            <label class="text-label form-label" for=""><strong>Treatment
                                    Outcome</strong></label>
                            <div class="input-group">
                            <select name="treat_outcomes" id="treat_outcomes" class="form-control"
                            aria-label=".form-select-lg example">

                            @if($uhidDetails->no_cycles == $uhidDetails->total_num_of_cyc)
                                 <option value="Not Pregnant" {{ old('treat_outcomes', $uhidDetails->treat_outcomes ?? '') == 'Not Pregnant' ? 'selected' : '' }}  selected>Not Pregnant</option>
                            @else

                                <option value="" class="text-muted"><strong><b>Select</b></strong>
                                </option>
                                <option value="Pregnant" class="p-1" {{ old('treat_outcomes', $uhidDetails->treat_outcomes ?? '') == 'Pregnant' ? 'selected' : '' }}>Pregnant</option>
                                <option value="Not Pregnant" class="p-1" {{ old('treat_outcomes', $uhidDetails->treat_outcomes ?? '') == 'Not Pregnant' ? 'selected' : '' }}>Not Pregnant
                                </option>
                            @endif

                            </select>
                            </div>
                            @error('treat_outcomes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-3 dn-csp-clinic-two" id="preganancy_outcome1" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Pregnancy
                                    Outcome</strong><span class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="preganancy_outcome"
                                    name="preganancy_outcome">
                                    <option value="">Select</option>
                                    <option value="live birth" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'live birth' ? 'selected' : '' }}>live birth</option>
                                    <option value="Stillbirth" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Stillbirth' ? 'selected' : '' }}>Stillbirth</option>
                                    <option value="Therapeutic abortion" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Therapeutic abortion' ? 'selected' : '' }}>Therapeutic abortion</option>
                                    <option value="Spontaneous abortion" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Spontaneous abortion' ? 'selected' : '' }}>Spontaneous abortion</option>
                                    <option value="Elective Termination" {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Elective Termination' ? 'selected' : '' }}>Elective Termination</option>
                                </select>
                            </div>
                            @error('preganancy_outcome')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                              
                    

                    {{-- <div class="col-md-4" id="gender_child1" style="display:none;">
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
                    </div> --}}

                    {{-- <div class="col-md-3" id="other_gender_id" style="display:none;">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Specify Number & Gender of the children Born</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="other_gender"
                                    name="other_gender" aria-describedby="other_gender">
                            </div>
                            @error('other_gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div> --}}

                    {{-- <div class="col-md-6 " id="gender_child1" style="display:none;">
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
                    </div> --}}
@php
    // $gender_child = old('gender_child', isset($uhidDetails->gender_child) ? explode(',', $uhidDetails->gender_child) : []);
    $male_number = old('male_number', $uhidDetails->male_number ?? '');
    $female_number = old('female_number', $uhidDetails->female_number ?? '');
    $show_gender_section = $male_number || $female_number
@endphp

{{-- style="{{ $show_gender_section ? '' : 'display:none;' }}" --}}
<div class="col-md-6 {{ $show_gender_section ? '' : 'hidden' }}" id="gender_child1" >
    <div class="row d-flex justify-content mt-4">
        <div class="col-md-4" id="male_hide">
            <div class="row">
                <div class="col-md-3 py-2">
                    <div class="form-check custom-checkbox mb-3">
                        <label class="form-check-label" for="customCheckBox1">Male</label>
                    </div>
                </div>
                 {{-- style="{{ in_array('Male', $gender_child) ? '' : 'display:none;' }}" --}}
                <div class="col md-7">
                    <div class="input-group">
                        <select name="male_number" id="male_number" class="form-control">
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
                        <label class="form-check-label" for="customCheckBox1">Female</label>
                    </div>
                </div>
                 {{-- style="{{ in_array('Female', $gender_child) ? '' : 'display:none;' }}" --}}
                <div class="col md-7">
                    <div class="input-group">
                        <select name="female_number" id="female_number" class="form-control">
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

<div class="col-md-3 dn-csp-clinic-two" id="live_birth_open" >
        <div class="mb-3">
            <label class="text-label form-label"
                for="validationCustomUsername"><strong>Live Birth Pregnancy
                    Outcome</strong></label>
            <div class="input-group">
                <select class="form-control" id="l_birth" name="l_birth" disabled>
                    <option value="">Select</option>
                    <option value="Singleton" id="Singleton1" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Singleton' ? 'selected' : '' }}>
                        Singleton
                    </option>
                    <option value="Twin" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Twin' ? 'selected' : '' }}>Twin</option>
                    <option value="Higher Order" {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Higher Order' ? 'selected' : '' }}>Higher Order</option>



                </select>
                
                                <input type="hidden" name="l_birth" id="l_birth_hidden" value="">
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
                    <script nonce="{{ $cspNonce }}">
                        // When checkbox is checked, show the select field, otherwise hide it
                       
                        $(document).ready(function () {
                                // $('#l_birth').on('change', function () {


                                //     let l_birth = $('#l_birth').val();
                                //     let maleSection = $('#male_hide');
                                //     let femaleSection = $('#female_hide');
                                //     let maleCheckbox = $('#male_female');
                                //     let femaleCheckbox = $('#male_female1');
                                //     let maleHidden = $('#male_hidden');
                                //     let femaleHidden = $('#female_hidden');
                                //     let maleNumber = $('#male_number');
                                //     let femaleNumber = $('#female_number');

                                //     // Reset checkboxes and number dropdowns
                                //     maleCheckbox.prop('checked', false);
                                //     femaleCheckbox.prop('checked', false);
                                //     maleHidden.hide();
                                //     femaleHidden.hide();
                                //     maleNumber.val(''); // Reset dropdown to "Select"
                                //     femaleNumber.val('');

                                //     if (l_birth === "Singleton") {
                                //         // Show gender selection but only allow one selection
                                //         maleSection.show();
                                //         femaleSection.show();

                                //         maleCheckbox.on('change', function () {
                                //         maleNumber.val(''); // Reset dropdown to "Select"
                                //         femaleNumber.val('');
                                //             if (this.checked) {
                                //                 femaleCheckbox.prop('checked', false);
                                //                 maleHidden.show();
                                //                 femaleHidden.hide();
                                //             } else {
                                //                 maleHidden.hide();
                                //             }
                                //         });

                                //         femaleCheckbox.on('change', function () {
                                //             maleNumber.val(''); // Reset dropdown to "Select"
                                //     femaleNumber.val('');
                                //             if (this.checked) {
                                //                 maleCheckbox.prop('checked', false);
                                //                 femaleHidden.show();
                                //                 maleHidden.hide();
                                //             } else {
                                //                 femaleHidden.hide();
                                //             }
                                //         });

                                //     } else {
                                //         // For Twin or Higher Order, allow both Male and Female selection
                                //         maleSection.show();
                                //         femaleSection.show();
                                //         maleHidden.hide();
                                //         femaleHidden.hide();

                                //         maleCheckbox.off('change').on('change', function () {
                                //             maleHidden.toggle(this.checked);
                                //         });

                                //         femaleCheckbox.off('change').on('change', function () {
                                //             femaleHidden.toggle(this.checked);
                                //         });
                                //     }
                                // });
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

                                // Reset checkboxes and number dropdowns
                                maleCheckbox.prop('checked', false);
                                femaleCheckbox.prop('checked', false);
                                maleHidden.hide();
                                femaleHidden.hide();
                                maleNumber.val(''); // Reset dropdown to "Select"
                                femaleNumber.val('');

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










                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label" for="complicatoins_if_any">
                                <strong>Complications, if any</strong>
                            </label>
                            <div class="input-group">
                                <textarea class="form-control" name="complicatoins_if_any" id="complicatoins_if_any" aria-describedby="complicatoins_if_any">{{ old('complicatoins_if_any', $uhidDetails->complicatoins_if_any ?? '') }}</textarea>
                            </div>
                            <span id="comp_if_any_id" class="bc-csp-clinic-three"></span>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label" for="remark">
                                <strong>Remarks / Any other relevant information</strong>
                            </label>
                            <div class="input-group">
                                <textarea class="form-control" name="remark" id="remark" rows="3" aria-describedby="remark">{{ old('remark', $uhidDetails->remark ?? '') }}</textarea>
                            </div>
                            <span id="remark_error" class="bc-csp-clinic-three"></span>
                        </div>
                    </div>

                    {{-- <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Complications, if
                                    any</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" name="complicatoins_if_any" value="{{ old('complicatoins_if_any', $uhidDetails->complicatoins_if_any ?? '') }}"
                                    id="complicatoins_if_any" aria-describedby="complicatoins_if_any"></textarea>
                            </div>
                            <span id="comp_if_any_id" style="color: red;">
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Remarks/ Any other relevant
                                    information</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" col="5" rows="3" type="text"
                                    class="form-control" name="remark" id="remark"
                                    aria-describedby="remark"></textarea>
                            </div>
                            <span id=""
                                style="color: red;">
                        </div>
                    </div> --}}

                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="text-label form-label">
                            <strong>Required Affidavit regarding following to be taken on record:</strong>
                        </label>

                        <div class="col-12" id="declaration_hide">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration" name="declaration"
                                    {{ old('declaration', $uhidDetails->declaration ?? '') === 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="declaration">
                                    From Oocyte Donor that she has not donated oocytes more than once in her lifetime.
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration1" name="declaration1"
                                    {{ old('declaration1', $uhidDetails->declaration1 ?? '') === 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="declaration1">
                                    From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Required Affidavit regarding
                                following to be taken on record:</strong></label>
                                <div class="col-12" id="declaration_hide">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            id="declaration" name="declaration">
                                        <label class="form-check-label" for="gridCheck">
                                            From Oocyte Donor that she has not donated oocytes more than once in her life time.
                                        </label>
                                    </div>
                                </div>


                       
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration1"
                                    name="declaration1">
                                <label class="form-check-label" for="gridCheck">
                                    From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.
                                </label>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!--div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck2"
                                required>
                            <label class="form-check-label" for="invalidCheck2">
                                Check Me out
                            </label>
                        </div>
                    </div-->

                    {{-- <button type="submit" name="submit" value="continue" id="btnSubmit" onclick="return validatesubmit()" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;" class="btn me-2">Continue patient details</button>
                <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button> --}}

                 <button type="button" id="closeBtn" class="btn me-2 btn btn-danger">Close</button>
               {{-- <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button>                             --}}
                        <button type="submit" name="updatev" value="updatebtn" id="btnSubmit"
                        class="btn me-2 button-csp-clinic-four" >update</button>
                          <button type="submit" value="deletebtn" name="updatev" id="deleteBtn"
                        class="btn me-2 btn btn-danger"  data-uhid="{{ $uhidDetails->patient_uhid }}" >Delete</button>
                            {{-- <button type="button" name = "delete" id="deleteBtn" class="btn me-2 btn-danger" data-quarter="{{ $uhidDetails->quarter }}"
                            data-year="{{ $uhidDetails->year }}" data-clinic="{{ $uhidDetails->clinic_id }}"
                            data-uhid="{{ $uhidDetails->patient_uhid }}">
                            Delete
                            </button> --}}
            </form>


 {{-- onclick="return validatesubmit()" --}}
{{-- <div> --}}







</div>







    </div>
</div>
    </div>
</div>
</div>




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
            if ($('#preganancy_outcome').val().trim() !== '') {
                $('#preganancy_outcome1').show();
            }
           if ($('#l_birth').val().trim() !== '') {
               $('#live_birth_open').show();
            }
        });
    </script>
  <script nonce="{{ $cspNonce }}">
    $('#nationality').on('change', function() {
        if (this.value == 'Foreigner') {
            $("#other_nationality1").show();
            $('#other_nationality option[value="248"]').remove();
        } else {
            $("#other_nationality1").hide();
            $('#other_nationality').val('');
        }
    });
    </script>
      <script nonce="{{ $cspNonce }}">
        $('#types_of_treat1').on('change', function() {
            //$('#declaration').val('');
            if (this.value == 'Sperm Donation') {
                $("#declaration_hide").hide();
                
            } else {
                $("#declaration_hide").show();
                
            }
        });
        </script>
     <script nonce="{{ $cspNonce }}">
        $('#nationality_wifeedit').on('change', function() {
            if (this.value == 'Foreigner') {
                $("#other_nationality1_wife").show();
                $('#other_nationality_wife option[value="248"]').remove();
            } else {
                $("#other_nationality1_wife").hide();
                $('#other_nationality_wife').val('');
            }
        });
        </script>
        <script nonce="{{ $cspNonce }}">
// document.addEventListener("DOMContentLoaded", function () {
    // const coupleRadio1 = document.getElementById("flexRadioDefault2");

    // if (coupleRadio1.checked) {
    //    // alert("Couple radio is selected on load");
    //     // // ✅ Show relevant fields here
    //     document.getElementById("nationality_husband").style.display = "block";
    //     document.getElementById("nationality_wife1").style.display = "block";
    // } else {
    //     // alert("Couple radio is NOT selected on load");
    // }
// });


    document.addEventListener("DOMContentLoaded", function () {
    const coupleRadio = document.getElementById("flexRadioDefault1");
    const singleWomanRadio = document.getElementById("flexRadioDefault2");
    const nationalityHusband = document.getElementById("nationality_husband");
    const maleFactorDive = document.getElementById("male_factor_div");
    const nationalityWife = document.getElementById("nationality_wife1");
    const otherNationalityHusband = document.getElementById("other_nationality1");
    const otherNationalityWife = document.getElementById("other_nationality1_wife");
    const nationalityHusbandSelect = document.getElementById("nationality");
    const nationalityWifeSelect = document.getElementById("nationality_wife");
    const wifeLabel = document.getElementById("nationality_woman_lable");
    const nationality_wifesingle = document.getElementById("nationality_wifeedit");
   // const wifeLabel = document.querySelector("label[for='validationCustomUsername']");
      if (coupleRadio.checked) {      
             //alert("Couple radio is selected on load");     
            nationalityHusband.style.display = "block";
            nationalityWife.style.display = "block";
            otherNationalityHusband.style.display = "none";
            otherNationalityWife.style.display = "none";
             maleFactorDive.style.display = "block";
            wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span style='color:red;'>*</span>";
            if(nationalityHusbandSelect.value != 'Indian'){
                otherNationalityHusband.style.display = "block";
            }
            if(nationality_wifesingle.value != 'Indian'){
                otherNationalityWife.style.display = "block";
            }
        } else if (singleWomanRadio.checked) {       
          //  alert("Couple radio is NOT selected on load");    
            nationalityHusband.style.display = "none";
            nationalityWife.style.display = "block";
            otherNationalityWife.style.display = "none";
              maleFactorDive.style.display = "none";
            wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";  
            if(nationality_wifesingle.value != 'Indian'){
                otherNationalityWife.style.display = "block";
            }
                    
        } 

    //    
        function resetCountryFields() {
            nationalityHusbandSelect.value = "";
            nationalityWifeSelect.value = "";
            otherNationalityHusband.style.display = "none";
            otherNationalityWife.style.display = "none";
        }

        function toggleFields() {
            //alert('check 1');
            if (coupleRadio.checked) {      
                //alert("Couple radio is selected on load");     
                nationalityHusband.style.display = "block";
                nationalityWife.style.display = "block";
                maleFactorDive.style.display = "block";
                wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span style='color:red;'>*</span>";
            } else if (singleWomanRadio.checked) {       
            //  alert("Couple radio is NOT selected on load");    
                nationalityHusband.style.display = "none";
                nationalityWife.style.display = "block";
                maleFactorDive.style.display = "none";
                 otherNationalityHusband.style.display = "none"; 
                maleFactorDive.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
                    input.checked = false;
                });
                wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";           
            }

            // Reset and hide country fields when changing the main radio button
            resetCountryFields();
        }

        function toggleCountryFields() {
            otherNationalityHusband.style.display = nationalityHusbandSelect.value === "Foreigner" ? "block" : "none";
            otherNationalityWife.style.display = nationalityWifeSelect.value === "Foreigner" ? "block" : "none";
        }

        // Event Listeners
        coupleRadio.addEventListener("change", toggleFields);
        singleWomanRadio.addEventListener("change", toggleFields);
        nationalityHusbandSelect.addEventListener("change", toggleCountryFields);
        nationalityWifeSelect.addEventListener("change", toggleCountryFields);

        // Ensure default visibility based on current selections
        toggleFields();
    });

        // document.addEventListener("DOMContentLoaded", function () {
        //     const coupleRadio = document.getElementById("flexRadioDefault1");
        //     const singleWomanRadio = document.getElementById("flexRadioDefault2");
        //     const nationalityHusband = document.getElementById("nationality_husband");
        //     const nationalityWife = document.getElementById("nationality_wife1");
        //     const otherNationalityHusband = document.getElementById("other_nationality1");
        //     const otherNationalityWife = document.getElementById("other_nationality1_wife");
        //     const nationalityHusbandSelect = document.getElementById("nationality");
        //     const nationalityWifeSelect = document.getElementById("nationality_wife");
        //     const wifeLabel = document.querySelector("label[for='validationCustomUsername']");
        
        //     function toggleFields() {
        //         if (coupleRadio.checked) {
        //             nationalityHusband.style.display = "block";
        //             nationalityWife.style.display = "block";
        //             wifeLabel.innerHTML = "<strong>Nationality of the Wife</strong><span style='color:red;'>*</span>";
        //         } else {
        //             nationalityHusband.style.display = "none";
        //             nationalityWife.style.display = "block";
        //             wifeLabel.innerHTML = "<strong>Nationality of the Woman</strong><span style='color:red;'>*</span>";
        //         }
        //     }
        
        //     function toggleCountryFields() {
        //         otherNationalityHusband.style.display = nationalityHusbandSelect.value === "Foreigner" ? "block" : "none";
        //         otherNationalityWife.style.display = nationalityWifeSelect.value === "Foreigner" ? "block" : "none";
        //     }
        
        //     coupleRadio.addEventListener("change", toggleFields);
        //     singleWomanRadio.addEventListener("change", toggleFields);
        //     nationalityHusbandSelect.addEventListener("change", toggleCountryFields);
        //     nationalityWifeSelect.addEventListener("change", toggleCountryFields);
        // });
    </script>
    {{-- <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function () {
            var birthSelect = document.getElementById("l_birth");
            var genderSelect = document.getElementById("gender_child");
    
            birthSelect.addEventListener("change", function () {
                if (this.value === "Singleton") {
                    genderSelect.multiple = false; // Allow only one selection
                    genderSelect.classList.add("form-control"); // Keep the input styling
                    genderSelect.selectedIndex = -1; // Reset selection
                } else {
                    genderSelect.multiple = true; // Allow multiple selections
                    genderSelect.classList.add("form-control"); // Keep the input styling
                }
            });
        });
    </script> --}}
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
    </script>
{{-- <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function() {
        let radioSingleWoman = document.getElementById("flexRadioDefault2");
        let nationalityDiv = document.getElementById("nationality_wife1");
        let nationalitySelect = document.getElementById("nationality_wife");

        document.querySelectorAll('input[name="flexRadioDefault"]').forEach(function(radio) {
            radio.addEventListener("change", function() {
                if (radioSingleWoman.checked) {
                    nationalityDiv.style.display = "block";

                    // Remove all options
                    nationalitySelect.innerHTML = `
                        <option value="" class="text-muted"><strong>Select</strong></option>
                        <option value="Indian" class="p-1">Indian</option>
                    `;
                } else {
                    nationalityDiv.style.display = "block";

                    // Restore all options
                    nationalitySelect.innerHTML = `
                        <option value="" class="text-muted"><strong>Select</strong></option>
                        <option value="Indian" class="p-1">Indian</option>
                        <option value="Foreigner" class="p-1">Foreigner</option>
                    `;
                }
            });
        });
    });
</script> --}}

  <script nonce="{{ $cspNonce }}">

$(document).ready(function () {
        $('#btnSubmit').on('click', function (e) {
            if (!validatesubmit()) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
 
    // document.addEventListener("DOMContentLoaded", function () {
    //     const form = document.getElementById("art_clin1"); // Replace with your form's actual ID
    //     const submitButton = document.getElementById("btnSubmit");

    //     submitButton.addEventListener("click", function (e) {
    //         e.preventDefault(); // Prevent default form submission
    //         if (validatesubmit()) {
    //             form.submit(); // Submit the form if validation passes
    //         }
    //     });
    // });

    function validatesubmit() {
        if (document.getElementById("patient_uhid").value == "") {
            alert("Patient UHID cannot be blank");
            document.getElementById("patient_uhid").focus();
            return false;
        }       
        var couple = document.getElementsByName('case_of');
        var genValue = false;
        for (var i = 0; i < couple.length; i++) {
            if (couple[i].checked == true) {
                genValue = true;
            }
        }
        if (!genValue) {
            alert("Please choose the couple or single woman");
            document.getElementById("flexRadioDefault").focus();
            return false;
        }
    
        if ($('#flexRadioDefault1').is(':checked') && $('#age_hus_wife').val() == "") {
            alert("Please Select Husband age");
            document.getElementById("age_hus_wife").focus();
            return false;
        }
    
        if ($('#flexRadioDefault1').is(':checked') && $('#wife_age').val() == "") {
            alert("Please Select Wife age");
            document.getElementById("wife_age").focus();
            return false;
        }

        if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "") {
            alert("Nationality of the Husband cannot be blank");
            document.getElementById("nationality").focus();
            return false;
        }

        if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "Foreigner" && $('#other_nationality').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality").focus();
            return false;
        }
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality of the Wife cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }

        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "Foreigner" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality_wife").focus();
            return false;
        }
       
        if ($('#flexRadioDefault2').is(':checked') && $('#age_of_women').val() == "") {
            alert("Please Select Age of woman");
            document.getElementById("age_of_women").focus();
            return false;
        }
        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality of the Woman cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }

        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "Foreigner" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality_wife").focus();
            return false;
        }
        


        if ($('#flexRadioDefault1').is(':checked') && $('#cause_of_infretily').val() == "") {
            alert("Cause of Infertility cannot be blank");
            document.getElementById("cause_of_infretily").focus();
            return false;
        }
        let male = document.getElementById("male_factor").checked;
        let female = document.getElementById("female_factor").checked;
        let unexplained = document.getElementById("unexplained").checked;
        if (!male && !female && !unexplained) {
            alert("Please select at least one factor.");
            return false; 
        }



        // if (document.getElementById("nationality").value == "") {
        //     alert("Nationality cannot be blank");
        //     document.getElementById("nationality").focus();
        //     return false;
        // }
        // if ((document.getElementById("nationality").value == "Foreigner") && (document.getElementById(
        //         "other_nationality").value == "")) {
        //     alert("Please specify Other Nationality");
        //     document.getElementById("other_nationality").focus();
        //     return false;
        // }
    
        // if (document.getElementById("cause_of_infretily").value == "") {
        //     alert("Cause of Infertility cannot be blank");
        //     document.getElementById("cause_of_infretily").focus();
        //     return false;
        // }
        if (document.getElementById("art_proc_undertaken").value == "") {
            alert("ART Procedure Undertaken cannot be blank");
            document.getElementById("art_proc_undertaken").focus();
            return false;
        }
        if ((document.getElementById("art_proc_undertaken").value == "Others") && (document.getElementById(
                "art_undertaken_other").value == "")) {
            alert("Please specify other ART Procedures");
            document.getElementById("art_undertaken_other").focus();
            return false;
        }
        if (document.getElementById("types_of_treat").value == "") {
            alert("Type of Treatment cannot be blank");
            document.getElementById("types_of_treat").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById(
                "types_of_treat1").value == "")) {
            alert("Type of Donation cannot be blank");
            document.getElementById("types_of_treat1").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Oocyte Donation") && (!document.getElementById("declaration")
                .checked)) {
            alert(
                "Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time. "
            );
            document.getElementById("declaration").focus();
            return false;
        }

        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Oocyte Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman."
            );
            document.getElementById("declaration1").focus();
            return false;
        }   








        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Sperm Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman."
            );
            document.getElementById("declaration1").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Both Oocyte Donation & Sperm Donation") && (!document.getElementById("declaration")
                .checked)) {
            alert(
                "Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time. "
            );
            document.getElementById("declaration").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Both Oocyte Donation & Sperm Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman."
            );
            document.getElementById("declaration1").focus();
            return false;
        }       
        if (document.getElementById("total_num_of_cyc").value == "") {
            alert("Total No. of Treatment Cycle(s) Undertaken cannot be blank");
            document.getElementById("total_num_of_cyc").focus();
            return false;
        }        
        if (document.getElementById("no_cycles").value == "") {
            alert("No. of Cycles Cancelled/Failed (if any) cannot be blank");
            document.getElementById("no_cycles").focus();
            return false;
        }
        if ((document.getElementById("no_cycles").value > 0 ) && (document.getElementById(
                "cyc_canc_failure_reason").value == "")) {
            alert("Cycle Cancellation reason cannot be blank");
            document.getElementById("cyc_canc_failure_reason").focus();
            return false;
        }
    
        if (document.getElementById("treat_outcomes").value == "") {
            alert("Treatment Outcome cannot be blank");
            document.getElementById("treat_outcomes").focus();
            return false;
        }
        
        if ((document.getElementById("treat_outcomes").value == "Pregnant") && (document.getElementById(
                "preganancy_outcome").value == "")) {
            alert("Pregnancy Outcome cannot be blank");
            document.getElementById("preganancy_outcome").focus();
            return false;
        } 
        // suman 
        if (document.getElementById("treat_outcomes").value === "Not Pregnant") {

        document.getElementById("female_number").selectedIndex = '';
        document.getElementById("male_number").selectedIndex = '';
        document.getElementById("l_birth").selectedIndex = '';
        document.getElementById("l_birth_hidden").selectedIndex = '';
         document.getElementById("preganancy_outcome").selectedIndex = '';

        return true;
        }   
        
     if (
        document.getElementById("treat_outcomes").value === "Pregnant" &&
        document.getElementById("preganancy_outcome").value === "Stillbirth"
    ) {
        document.getElementById("l_birth").disabled = true;
        document.getElementById("l_birth_hidden").value = "";
    }


   
    if (
    document.getElementById("treat_outcomes").value === "Pregnant" &&
    (
        document.getElementById("preganancy_outcome").value === "Therapeutic abortion" ||
        document.getElementById("preganancy_outcome").value === "Spontaneous abortion" ||
        document.getElementById("preganancy_outcome").value === "Elective Termination"
    )
   ) {
   
    document.getElementById("female_number").selectedIndex = '';
    document.getElementById("male_number").selectedIndex = '';
    document.getElementById("l_birth").selectedIndex = '';

    
    document.getElementById("l_birth_hidden").value = '';

    return true;
   }




 // code end suman
        
        // if ((document.getElementById("preganancy_outcome").value == "live birth") && (document.getElementById(
        //         "l_birth").value == "")) {
        //     alert("Live Birth Pregnancy Outcome cannot be blank");
        //     document.getElementById("l_birth").focus();
        //     return false;
        // }
        // if ((document.getElementById("preganancy_outcome").value == "live birth")){
        // const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
        // const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        //         if (!isChecked) {
        //             alert('Please select Gender.');
        //             document.getElementById("l_birth").focus();
        //             return false;
        //         }
              
          
        // }
        // if ((document.getElementById("preganancy_outcome").value == "Stillbirth")){
        // const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
        // const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        //         if (!isChecked) {
        //             alert('Please select Gender.');
        //             document.getElementById("male_female").focus();
        //             return false;
        //         }
              
          
        // }





        const tratment_Outcome = document.getElementById('treat_outcomes').value;
        const preganancy_outcome = document.getElementById('preganancy_outcome').value;
        const male_numberNumber = document.getElementById('male_number').value;
        const female_number = document.getElementById('female_number').value;
        const l_birth = document.getElementById('l_birth').value;
                
        if (
            tratment_Outcome === "Pregnant" &&
            (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
            male_numberNumber === ""
        ) {
            alert("Please select the number of male.");
            document.getElementById("male_number").focus();
            return false;
        }

        if (
            tratment_Outcome === "Pregnant" &&
            (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
            female_number === ""
        ) {
            alert("Please select the number of female.");
            document.getElementById("female_number").focus();
            return false;
        }  

       

 




        
        // if ((document.getElementById("preganancy_outcome").value == "Stillbirth") && (document.getElementById(
        //         "gender_child").value == "")) {
        //     alert("Gender of the Child cannot be blank");
        //     document.getElementById("gender_child").focus();
        //     return false;
        // }
        // if ((document.getElementById("l_birth").value == "Singleton") && (document.getElementById(
        //         "gender_child").value == "")) {
        //     alert("Gender of the Child cannot be blank");
        //     document.getElementById("gender_child").focus();
        //     return false;
        // }
        // if ((document.getElementById("l_birth").value == "Twin") && (document.getElementById(
        //         "gender_child").value == "")) {
        //     alert("Gender of the Child cannot be blank");
        //     document.getElementById("gender_child").focus();
        //     return false;
        // }
        // if ((document.getElementById("l_birth").value == "Higher Order") && (document.getElementById(
        //         "other_gender").value == "")) {
        //     alert("Please specify number and gender of children under higher order pregnancy");
        //     document.getElementById("other_gender").focus();
        //     return false;
        // }  
        
        
        var agree = confirm(
            "Kindly check and confirm all details before submission."
        );
        if (agree) {
    
            return true;
        } else {
            return false;
        }
        return true;
    }
    </script>
    <script nonce="{{ $cspNonce }}">
        $('#age_of_women').on('change', function() {
            if (this.value != '') {
                $("#own_gametes").removeAttr('selected');
                $("#d_gametes").attr('selected', 'selected');
                $("#d_gametes").attr('readonly', 'readonly');
                $("#ivf_donor").show();                   
                $('#types_of_treat').html(
                    '<option value="ART Treatment using donor gametes">ART Treatment using donor gametes</option>');
                $('#types_of_treat1').html(
                    '<option value="">Select</option><option value="Sperm Donation">Sperm Donation</option><option value="Both Oocyte Donation & Sperm Donation">Both Oocyte Donation & Sperm Donation</option>'
                );
            } else {
                $("#d_gametes").removeAttr('selected');
                $("#d_gametes").removeAttr('readonly');
                $('#types_of_treat').html(
                    '<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="ART Treatment using self gametes" id="own_gametes" class="p-1">ART Treatment using self gametes</option><option value="ART Treatment using donor gametes" id="d_gametes" class="p-1">ART Treatment using donor gametes</option>'
                );
                $('#types_of_treat1').html(
                    '<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Oocyte Donation" id="o_d" class="p-1">Oocyte Donation</option><option value="Sperm Donation" id="s_d" class="p-1">Sperm Donation</option><option value="Both Oocyte Donation & Sperm Donation" id="od" class="p-1">Both Oocyte Donation & Sperm Donation</option>'
                );
                $("#ivf_donor").hide();
            }        
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#num_pre_child').on('change', function() {
            if (this.value == 'Yes') {
                $("#num_per_child_details").show();
            } else {
                $("#num_per_child_details").hide();
            }
        });
        </script>
        <!--add on 09/05/2024 -->
        <script nonce="{{ $cspNonce }}">
        $('#types_of_treat').on('change', function() {
            if (this.value == 'ART Treatment using donor gametes') {
                $("#ivf_donor").show();
            } else {
                $("#ivf_donor").hide();
            }
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#types_of_treat').on('change', function() {
            $("#types_of_treat1").val('');
            if (this.value == 'Self IVF using own gametes') {
                $("#donors").removeAttr('selected');
                $("#partner_selfs").attr('selected', 'selected');
                $("#semen_source").attr('readonly', 'readonly');
                $("#donore").removeAttr('selected');
                $("#partner_selfe").attr('selected', 'selected');
                $("#egg_source").attr('readonly', 'readonly');
        
        
            } else if (this.value == 'Self IVF using donor gametes') {
                $("#partner_selfs").removeAttr('selected');
                $("#donors").attr('selected', 'selected');
                $("#semen_source").attr('readonly', 'readonly');
                $("#partner_selfe").removeAttr('selected');
                $("#donore").attr('selected', 'selected');
                $("#egg_source").attr('readonly', 'readonly');
        
            } else {
                $("#donors").removeAttr('selected');
                $("#partner_selfs").removeAttr('selected');
                $("#semen_source").removeAttr('readonly');
            }
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#types_of_treat1').on('change', function() {
            if (this.value == 'Sperm Donation') {                
                $("#NAa").attr('selected', 'selected');
                $("#egg_source").attr('readonly', 'readonly');            
            } else if (this.value == 'Oocyte Donation') {               
                $("#NAs").attr('selected', 'selected');
                $("#semen_source").attr('readonly', 'readonly');                
            }
        });
        </script>      
      
        <script nonce="{{ $cspNonce }}">
        $('#types_of_treat1').on('change', function() {
            if (this.value == 'Sperm Donation') {
                $("#oocyte_source").removeAttr('selected');
                $("#semen_source1").attr('selected', 'selected');
                $("#gamete_source").attr('readonly', 'readonly');
            } else if (this.value == 'Oocyte Donation') {
                $("#semen_source1").removeAttr('selected');
                $("#oocyte_source").attr('selected', 'selected');
                $("#gamete_source").attr('readonly', 'readonly');
            } else {
                $("#oocyte_source").removeAttr('selected');
                $("#semen_source1").removeAttr('selected');
                $("#gamete_source").removeAttr('readonly');
            }
        });
        </script>
      
        <script nonce="{{ $cspNonce }}">
        $('#total_num_of_cyc').on('change', function() {
        
            $("#treat_outcomes").val('');
        
            if (this.value == 'Completed') {
                $("#treat_outcomes1").show();
               // $("#preganancy_outcome1").show();
            } else {
                $("#treat_outcomes1").hide();
                $("#preganancy_outcome1").hide();
                $("#live_birth_open").hide();
                $("#gender_child1").hide();
                $("#other_gender_id").hide();
            }
        });
        </script>
        
        <script nonce="{{ $cspNonce }}">
        $('#treat_outcomes').on('change', function() {
            $("#preganancy_outcome").val('');
            $("#other_gender").val('');
            $("#gender_child").val('');
            $("#l_birth").val('');
            
            if (this.value == 'Not Pregnant') {
                $("#preganancy_outcome1").hide();
                $("#live_birth_open").hide();
                $("#gender_child1").hide();
                $("#other_gender_id").hide();
                
                
            }else if(this.value == ''){
                $("#preganancy_outcome1").hide();
                //$("#preganancy_outcome1").hide();
                
            }
             else {
                $("#preganancy_outcome1").show();
                //$("#preganancy_outcome1").hide();
                
            }
        });
        </script>        
      
        <script nonce="{{ $cspNonce }}">
                $(document).ready(function(){
                    $('#total_num_of_cyc').change(function(){
                        var selectedNumber = $(this).val();                       
                        var optionSelect = $('#no_cycles');                      
                        optionSelect.empty(); // Clear previous options
                        optionSelect.append('<option value="">Select</option>');
                        for(var i = 0; i <= selectedNumber; i++) {
                            optionSelect.append('<option value="' + i + '">' + i + '</option>');
                        }
                    });
                    $('#total_num_of_cyc').trigger('change');
                });
            </script>



<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        let selectedTotal = '{{ old('total_num_of_cyc', $uhidDetails->total_num_of_cyc ?? '') }}';
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
        $('#total_num_of_cyc').on('change', function() {
            let newVal = parseInt($(this).val()) || 0;
            populateNoCycles(newVal, '');
        });
    });
</script>
        <script nonce="{{ $cspNonce }}">
                 $('#no_cycles').on('change', function() {
                    var selectedNumber = $(this).val();
                    var optionSelect = $('#total_num_of_cyc').val();
        
                    //alert(optionSelect);
                    if (optionSelect == selectedNumber){
        
                       // alert('done');
        
                        $('#treat_outcomes').html('<option value="Not Pregnant">Not Pregnant</option>');
        
                    }
                     else{
                        $('#treat_outcomes').html('<option value="">Select</option><option value="Pregnant">Pregnant</option><option value="Not Pregnant">Not Pregnant</option>');
        
                    //   //  alert('not done');
                     }
               });
                </script>
        
        
        
        <!-- 04-07-2024 -->
        {{-- <script nonce="{{ $cspNonce }}">
        $('#no_cycles').on('blur', function() {
            var num_of_child = $('#no_cycles').val();
            if (num_of_child > 0) {
                $('#fail_reason').show();
            } else {
                $('#fail_reason').hide();
            }
        
        });
        </script> --}}
        <script nonce="{{ $cspNonce }}">
     $(document).ready(function() {
        // Show the fail_reason div if the value is already present
        if ($('#cyc_canc_failure_reason').val().trim() !== '') {
            $('#fail_reason').show();
        }
    });
</script>
        <script nonce="{{ $cspNonce }}">
            $('#no_cycles').on('change', function() {
                var num_of_child = $('#no_cycles').val();
                if (num_of_child > 0) {
                    $('#fail_reason').show();
                } else {
                    $('#fail_reason').hide();
                    $('#cyc_canc_failure_reason').val('');
                    
                }
            
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
        <script nonce="{{ $cspNonce }}">
        $('#gamete_source').on('change', function() {
            if (this.value == 'Semen source') {
                $("#semen_sources").show();
            } else {
                $("#semen_sources").hide();
            }
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#gamete_source').on('change', function() {
            if (this.value == 'Egg/oocyte source') {
                $("#egg_oocyte").show();
            } else {
                $("#egg_oocyte").hide();
            }
        });
        </script>
        
        <script nonce="{{ $cspNonce }}">
        $('#art_proc_undertaken').on('change', function() {
            if (this.value == 'Others') {
                $("#others_id").show();
            } else {
                $("#others_id").hide();
                $('#art_undertaken_other').val('');
            }
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#total_num_of_cyc').on('change', function() {
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
        $('#preganancy_outcome').on('change', function() {
            $("#l_birth").val('');
            // alert(this.value);
            if (this.value == 'live birth') {
                $("#live_birth_open").show();
                $("#gender_child1").show();
            } else if (this.value == 'Stillbirth') {
                $("#gender_child1").show();
                $("#live_birth_open").hide();
            } else if (this.value == 'Therapeutic abortion') {
                $("#gender_child1").hide();
                $("#live_birth_open").hide();
            } else if (this.value == 'Spontaneous abortion') {
                $("#gender_child1").hide();
                $("#live_birth_open").hide();
            } else if (this.value == 'Elective Termination') {
                $("#gender_child1").hide();
                $("#live_birth_open").hide();
            } else if (this.value == '') {
                $("#gender_child1").hide();
                $("#live_birth_open").hide();
            }
            //else {
            //    $("#live_birth_open").hide();
            //    $("#gender_child1").hide();
            //}
        });
        </script>
        <script nonce="{{ $cspNonce }}">
        $('#gender_child').on('change', function() {
            if (this.value == 'other') {
                $("#other_gender_id").show();
            } else {
                $("#other_gender_id").hide();
            }
        });
        </script>

         <script nonce="{{ $cspNonce }}">
            $(document).ready(function () {
                function updateTreatment1Options() {
                    const artValue = $('#art_proc_undertaken').val();
                    const treatValue = $('#types_of_treat').val();
                    const isSingleWoman = $('#flexRadioDefault2').is(':checked');
                    const isCouple = $('#flexRadioDefault1').is(':checked');
                    if (isSingleWoman && (artValue === 'intra-uterine insemination(IUI)' || artValue === 'artificial insemination') && treatValue === 'ART Treatment using donor gametes') {
                        $('#types_of_treat1').html(
                            '<option value="Sperm Donation">Sperm Donation</option>'
                        );
                    }else if (isCouple && artValue === ('intra-uterine insemination(IUI)' || artValue === 'artificial insemination') && treatValue === 'ART Treatment using donor gametes') {
                        $('#types_of_treat1').html(
                            '<option value="Sperm Donation">Sperm Donation</option>'
                        );
                    } else {
                        $('#types_of_treat1').html(
                            '<option value="">Select</option>' +
                            '<option value="Oocyte Donation">Oocyte Donation</option>' +
                            '<option value="Sperm Donation">Sperm Donation</option>' +
                            '<option value="Both Oocyte Donation & Sperm Donation">Both Oocyte Donation & Sperm Donation</option>'
                        );
                    }
                }

                $('#flexRadioDefault2').on('click', function() {
                    if ($(this).is(':checked')) {
                        $('#age_of_women, #male_factor, #age_hus_wife, #wife_age, #nationality, #other_nationality').val('');
                        $('#male_factor').val('N');
                        $("#ivf_donor").show();

                        $('#types_of_treat').html(
                            '<option value="">Select</option>' +
                            '<option value="ART Treatment using self gametes">ART Treatment using self gametes</option>' +
                            '<option value="ART Treatment using donor gametes" id="d_gametes">ART Treatment using donor gametes</option>'
                        );

                        updateTreatment1Options();
                    } else {
                        $("#ivf_donor").hide();
                    }
                });

                $('#flexRadioDefault1').on('click', function() {
                    if ($(this).is(':checked')) {
                        $('#age_of_women, #age_hus_wife, #wife_age, #nationality, #other_nationality').val('');
                        
                        $("#ivf_donor").show();
                        $('#types_of_treat').html(
                            '<option value="">Select</option>' +
                            '<option value="ART Treatment using self gametes">ART Treatment using self gametes</option>' +
                            '<option value="ART Treatment using donor gametes" id="d_gametes">ART Treatment using donor gametes</option>'
                        );

                        updateTreatment1Options();
                    }
                });

                $('#art_proc_undertaken, #types_of_treat').on('change', function () {
                    updateTreatment1Options();
                });
            });
        </script>
        
        <script nonce="{{ $cspNonce }}">
        $('#flexRadioDefault2').on('click', function() {
            if ($('#flexRadioDefault2').is(':checked')) {
                $('#age_of_women').val('');
                $('#age_hus_wife').val('');
                $('#wife_age').val('');
                $('#nationality').val('');
                $('#other_nationality').val('');
                $('#types_of_treat1').html(
                        '<option value="">Select</option><option value="Sperm Donation">Sperm Donation</option><option value="Both Oocyte Donation & Sperm Donation">Both Oocyte Donation & Sperm Donation</option>'
                    );
                    
                    $("#ivf_donor").show();  
                    
                $("#d_gametes").attr('selected', 'selected');
                $("#d_gametes").attr('readonly', 'readonly'); 
            } else{
                $('#age_of_women').val('');
                
                $('#types_of_treat').html(
                    '<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="ART Treatment using self gametes" id="own_gametes" class="p-1">ART Treatment using self gametes</option><option value="ART Treatment using donor gametes" id="d_gametes" class="p-1">ART Treatment using donor gametes</option>'
                );
                $('#types_of_treat1').html(
                    '<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Oocyte Donation" id="o_d" class="p-1">Oocyte Donation</option><option value="Sperm Donation" id="s_d" class="p-1">Sperm Donation</option><option value="Both Oocyte Donation & Sperm Donation" id="od" class="p-1">Both Oocyte Donation & Sperm Donation</option>'
                );
                
                $("#ivf_donor").hide();
                
                $("#d_gametes").removeAttr('selected');
                $("#d_gametes").removeAttr('readonly');
            }
        });
        
        $('#flexRadioDefault1').on('click', function() {
            
           // $('#types_of_treat').val('');
           // $('#types_of_treat1').val('');
            if ($('#flexRadioDefault1').is(':checked')) {
        
                $('#types_of_treat').html('<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="ART Treatment using self gametes" class="p-1" id="own_gametes">ART Treatment using self gametes</option><option value="ART Treatment using donor gametes" class="p-1" id="d_gametes">ART Treatment using donor gametes</option>');
                $('#types_of_treat1').html('<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Oocyte Donation" id="o_d" class="p-1">Oocyte Donation</option><option value="Sperm Donation" id="s_d" class="p-1">Sperm Donation</option><option value="Both Oocyte Donation & Sperm Donation" id="od" class="p-1">Both Oocyte Donation & Sperm Donation</option>');
        
                $('#age_of_women').val('');
                $('#age_hus_wife').val('');
                $('#male_factor').val('N');
                $('#wife_age').val('');
                $('#nationality').val('');
                $('#other_nationality').val('');

            } else{
                $('#age_hus_wife').val('');
                $('#wife_age').val('');
                $('#nationality').val('');
                $('#other_nationality').val('');
            }
        });

        //delete 
            $('#deleteBtn').on('click', function () {
                  let patientUhid = $(this).data('uhid');

                if (!confirm('Are you sure you want to delete Patient UHID: ' + patientUhid + '?')) {
                    return false;
                }
            });
        </script>
       




        


@endsection