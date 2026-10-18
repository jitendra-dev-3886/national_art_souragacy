@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
    .display-none-csp-clinic-one{
    display:none;
    }
    .color-csp-clinic-two{
        color: red;
    }
    .bc-br-color-csp-clinic-three{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
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
            <h3 class="card-title mb-5 text-primary">Patient information form for Surrogacy Clinic</h3>
            
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
            
              <form name="art_clin1" method="POST" action="{{ route('clinic.patient_save_surrogacy_application_form') }}" enctype="multipart/form-data">                             
                @csrf
                @if ($reporting_data)
                <input type="hidden" name="report_id" value="{{ $reporting_data->id }}">
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
                       
                        @if ($available_quarters->count() === 1)
                        {{-- <input type="text" class="form-control" name="quarter"
                               value="{{ $available_quarters->first()['description'] }}" readonly> --}}
                        <input type="hidden" name="quarter" value="{{ $available_quarters->first()['id'] }}">
                        {{-- @else
                        <select class="form-select" name="quarter" id="quarterSelect" style="width: 60%;">
                            <option value="">Select Quarter</option>
                            @foreach ($available_quarters as $q)
                                <option value="{{ $q['id'] }}"
                                    @if ((old('quarter') ?? ($previous_data->quarter ?? '')) == $q['id']) selected @endif>
                                    {{ $q['description'] }}
                                </option>
                            @endforeach
                        </select> --}}
                        @endif
                    
                        
                        @if ($available_years->count() === 1)
                            {{-- <input type="text" class="form-control" name="year"
                                   value="{{ $available_years->first()->year }}"
                                   readonly> --}}
                            <input type="hidden" name="year" value="{{ $available_years->first()->year }}">
                        {{-- @else
                            <select class="form-select" name="year" id="yearSelect" style="width: 60%;">
                                <option value="">Select Year</option>
                                @foreach ($available_years as $y)
                                    <option value="{{ $y->year }}"
                                        @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y->year) selected @endif>
                                        {{ $y->year }}
                                    </option>
                                @endforeach
                            </select> --}}
                        @endif
                    </div>                        
                </div>
                </div>
                {{-- <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label d-block">
                        <strong>Quarter and Year</strong>
                    </label>
                    <div class="d-flex align-items-center">
                        @php
                            // Map quarter ID to month range
                            $quarterMap = [
                                4 => 'January – March',
                                1 => 'April – June',
                                2 => 'July – September',
                                3 => 'October – December',
                            ];
            
                            // Get selected quarter object and year
                            $selectedQuarter = $available_quarters->count() === 1
                                ? $available_quarters->first()
                                : $available_quarters->firstWhere('id', old('quarter') ?? ($previous_data->quarter ?? null));
            
                            $selectedQuarterText = $quarterMap[$selectedQuarter['id']] ?? 'N/A';
            
                            $selectedYear = $available_years->count() === 1
                                ? $available_years->first()->year
                                : (old('year') ?? ($previous_data->year ?? $currentYear));
                        @endphp
            
                        <div>
                            {{ $selectedQuarterText }},  {{ $selectedYear }}
                        </div>
                    </div>
                </div>
                    </div> --}}

            {{-- </div> --}}

                                    
                    <!-- Previous Treatment Radio -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>Had received treatment from us previously</strong>
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_yes" value="Yes">
                                    <label class="form-check-label" for="previous_treatment_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_no" value="No">
                                    <label class="form-check-label" for="previous_treatment_no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <span id="bank_reg_numID" class="color-csp-clinic-two">
                                <?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;} ?>
                            </span>
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
                                    value="{{ $patient_list->surrogacy_reg_no->registration_no }}"
                                    class="form-control" name="cli_reg_name"
                                    id="cli_reg_name" aria-describedby="cli_reg_name"
                                    placeholder="" data-validation="alphanumeric"
                                    data-validation-allowing="_" readonly>
                                  
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="color-csp-clinic-two"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Name of the
                                    Clinic</strong></label>
                            <div class="input-group">
                                <input type="text" 
                                value="{{ $patient_list->clinicname }}"
                                    class="form-control" name="name_of_clinic" id="name_of_clinic"
                                    aria-describedby="name_of_clinic" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                                class="color-csp-clinic-two"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 ">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Patient
                                    UHID</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pati_uhid"
                                    id="pati_uhid" aria-describedby="patient_uhid" placeholder="" maxlength="10">
                            </div>
                            <!--span id="patient_uhidID" class="color-csp-clinic-two"></span-->
                            <span id="availability"></span>
                            @error('pati_uhid')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            {{-- <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Required Affidavit regarding
                                    following to be taken on record:</strong></label>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration"
                                        name="declaration">
                                    <label class="form-check-label" for="gridCheck">
                                        From Surrogate Mother that she has has not acted as a surrogate
                                        mother more than once in her lifetime.<span
                                            class="color-csp-clinic-two">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration1"
                                        name="declaration1">
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
                                        name="declaration3">
                                    <label class="form-check-label" for="gridCheck">
                                        From Oocyte
                                        Donor that she has not donated more than once in her life
                                        time.
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="declaration4"
                                        name="decladeclaration4">
                                    <label class="form-check-label" for="gridCheck">
                                        From the ART
                                        Bank that the bank has not supplied sperm of the same donor
                                        to more than one commissioning couple/single woman.
                                    </label>
                                </div>
                            </div> --}}


                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong> Case of :</strong></label>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="case_of"
                                            id="flexRadioDefault1" value="one" required>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Couple
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="case_of"
                                            id="flexRadioDefault2" value="two" required>
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

                            {{-- <div class="col-md-12">
                                <div class="mb-3">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="flexRadioDefault" id="flexRadioDefault1" value="one"
                                            required>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            In case of Couple
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="flexRadioDefault" id="flexRadioDefault2" value="two"
                                            required>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            In case of Single Woman [widow/divorcee]
                                        </label>
                                    </div>
                                </div>
                            </div>                                            --}}
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
                                        time.<span class="color-csp-clinic-two">*</span>
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
                                        to more than one commissioning couple/single woman.<span
                                            class="color-csp-clinic-two">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-12">
                        <div class="mb-3">

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1" value="one" required>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    In case of Couple
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" value="two" required>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    In case of Single Woman
                                </label>
                            </div>




                        </div>
                    </div> --}}

                    <div class="col-md-2 display-none-csp-clinic-one" id="nationality_husband" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Nationality of the Husband</strong><span
                                    class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="nationality" id="nationality" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Indian" class="p-1">Indian</option>
                                    <option value="OCI Card Holders">OCI Card Holders</option>
                                    {{-- <option value="Others" class="p-1">Others</option> --}}

                                </select>

                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 display-none-csp-clinic-one" id="other_nationality1" >
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                    class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="other_nationality" id="other_nationality" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @if ($countries->count() > 0)
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Countries Available</option>
                                    @endif
                                </select>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-2 " id="nationality_wife1" >
                        <div class="mb-3">
                            <label class="text-label form-label" id="validationCustomUsername"
                                for="validationCustomUsername"><strong>Nationality</strong><span
                                    class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="nationality_wife" id="nationality_wife" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Indian" class="p-1">Indian</option>
                                    <option value="OCI Card Holders">OCI Card Holders</option>
                                    {{-- <option value="Others" class="p-1">Others</option> --}}

                                </select>

                            </div>
                            @error('nationality_wife')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 display-none-csp-clinic-one" id="other_nationality1_wife">
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                    class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="other_nationality_wife" id="other_nationality_wife" class="form-control">
                                    <option value="">-- Select Country --</option>
                                    @if ($countries->count() > 0)
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No Countries Available</option>
                                    @endif
                                </select>

                            </div>
                        </div>
                    </div>

               

                    <div class="col-md-3 one selectt display-none-csp-clinic-one" id="one_couple" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Husband Age</strong></label>
                            <div class="input-group">
                                <select name="age" id="age" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=26;$i<=55;$i++){
                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                    }
                                        ?>


                                </select>
                            </div>
                            @error('age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-3 one selectt display-none-csp-clinic-one" id="one couple" >
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
                                    <?php for($i=23;$i<=50;$i++){
                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                    }
                                        ?>


                                </select>
                            </div>
                            @error('wife_age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-3 two selectt display-none-csp-clinic-one" id="single" >
                        <div class="mb-3">
                            <!-- <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age of Women
                                    [widow/divorcee]</strong></label> -->
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age of Woman</strong></label>
                            <div class="input-group">
                                <select name="age_of_women" id="age_of_women" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=35;$i<=45;$i++){
                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>'; 
                                    }
                                        ?>


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
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>

                                </select>
                            </div>
                            @error('num_pre_child')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>

                    <div class="col-md-3 display-none-csp-clinic-one"  id="num_per_child_details">
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
                                    <option value="Mentally Challenged">
                                        Mentally Challenged</option>
                                    <option value="Physically Challenged">
                                        Physically Challenged</option>
                                    <option value="Life Threatening Disorder">
                                        Life Threatening Disorder</option>

                                </select>
                            </div>
                            @error('child_give_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>

                    <div class="row col-md-6 display-none-csp-clinic-one" id="medical_open">
                        <div class="col-md-6 display-none-csp-clinic-one" id="child_medical_open" >
                            <div class="mb-3">
                                <label class="text-label form-label"
                                    for="validationCustomUsername"><strong>Medical Certificate of Child
                                    </strong><span class="color-csp-clinic-two">*</span></label>
                                <div class="input-group">
                                    <input type="file" class="form-control"
                                        id="child_medical_certificate" name="surrogacypatient_child_medicalcertificate_docs"
                                        aria-describedby="child_medical_certificate1">
                                        <button type="button" class="btn btn-danger" id="removeFileButtonchild">Remove</button>
                                </div>
                                <!--span id="medical_surrogacy_id"
                                    class="color-csp-clinic-two"><?php //if(isset($medical_surrogacy)){ echo $medical_surrogacy;} ?></span-->
                                <ul><strong>Note:- </strong>
                                    <li>File Type: PDF or JPG Format only and File Size: 50 to 200 kb.
                                    </li>
                                    <!--li>File Size: 50 to 200 kb.</li-->
                                </ul>
                            </div>
                            @error('surrogacypatient_child_medicalcertificate_docs')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Medical Condition
                                    Necessitating
                                    Surrogacy</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="medical_surrogacy"
                                    name="medical_surrogacy" aria-describedby="medical_surrogacy">
                            </div>
                            @error('medical_surrogacy')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Upload Certificate of Medical
                                    Indication issued by District Medical Board
                                </strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="medical_certificate"
                                    name="surrogacypatient_medicalcertificate_docs" aria-describedby="medical_surrogacy1">
                                    <button type="button" class="btn btn-danger" id="removeFileButton">Remove</button>
                            </div>
                            <!--span id="medical_surrogacy_id"
                                    class="color-csp-clinic-two"><?php //if(isset($medical_surrogacy)){ echo $medical_surrogacy;} ?></span-->
                            <ul><strong>Note:- </strong>
                                <li>File Type: PDF or JPG Format only and File Size: 50 to 200 kb.
                                </li>
                                <!--li>File Size: 50 to 200 kb.</li-->
                            </ul>
                            @error('surrogacypatient_medicalcertificate_docs')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
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
                                    <option value="Surrogacy using own gametes(Self Egg and Self Sperm)"
                                        id="own_gametes" class="p-1">
                                        Surrogacy using own gametes(Self Egg and Self Sperm)</option>
                                    <option value="Surrogacy using donor gametes" id="d_gametes"
                                        class="p-1">
                                        Surrogacy using donor gametes</option>

                                </select>
                            </div>
                            @error('types_of_treat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-4" id="ivf_donor">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Gamete Source</strong></label>
                            <div class="input-group">
                                <select name="types_of_treat1" id="types_of_treat1" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" id="tot1" class="text-muted">
                                        <strong><b>Select</b></strong>
                                    </option>
                                    <option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">
                                        Self Oocyte &
                                        Donor Sperm
                                    </option>
                                    <option value="Donor Oocyte & Self Sperm" id="o_sperm" class="p-1">
                                        Donor Oocyte & Self Sperm</option>
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
                                </strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select name="surrogate_mother_age" id="surrogate_mother_age"
                                    class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=25;$i<=35;$i++){
                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                    }
                                        ?>


                                </select>
                                {{-- <span id="$wife_age_id"
                                    class="color-csp-clinic-two"></span> --}}
                            </div>
                            @error('surrogate_mother_age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-4" id="other">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>ART Procedure
                                    Undertaken</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="sel2" name="art_undertaken">
                                    <option value="">Select</option>
                                    <option value="In Vitro Fertilization-Embryo Transfer(IVF-ET)">In
                                        Vitro Fertilization-Embryo Transfer(IVF-ET)</option>
                                    <option value="Intra-Cytoplasmic Sperm Injection(ICSI)">
                                        Intra-Cytoplasmic Sperm Injection(ICSI)</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            @error('art_undertaken')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-3 display-none-csp-clinic-one" id="others_id" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Others</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="art_undertaken_other"
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
                                    <?php for($i=1;$i<=20;$i++){                                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>';                                                    
                                        }
                                    ?>
                                </select>                               
                            </div>
                            @error('total_nun_cycles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="col-md-4" id="no_cycles1">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>No. of Cycles Cancelled/Failed, if any
                                </strong></label>
                            <div class="input-group">
                                <select name="no_cycles" id="no_cycles" class="form-control"
                                    aria-label=".form-select-lg example">
                                     <!-- <option value="">Select an option</option> -->
                                     <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>                                 
                                </select>                               
                            </div>
                            @error('no_cycles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-7 display-none-csp-clinic-one" id="fail_reason" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Cycle Cancellation/failure and
                                    reason</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="Cycle_fail_reason"
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



                    <div class="col-md-4" id="">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Treatment
                                    Outcome</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="tratment_Outcome"
                                    name="tratment_Outcome">
                                    <option value="">Select</option>
                                    <option value="Pregnant">Pregnant</option>
                                    <option value="Not Pregnant">Not Pregnant</option>
                                </select>
                            </div>
                            @error('tratment_Outcome')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-3 display-none-csp-clinic-one" id="preganancy_outcome1" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Pregnancy
                                    Outcome</strong><span class="color-csp-clinic-two">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="preganancy_outcome"
                                    name="preganancy_outcome">
                                    <option value="">Select</option>
                                    <option value="live birth">
                                        live birth
                                    </option>
                                    <option value="Stillbirth">Stillbirth</option>
                                    <option value="Therapeutic abortion">Therapeutic abortion</option>
                                    <option value="Spontaneous abortion">Spontaneous abortion</option>
                                    <option value="Elective Termination">Elective Termination</option>
                                </select>
                            </div>
                            @error('preganancy_outcome')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>

                    <div class="col-md-3 display-none-csp-clinic-one" id="live_birth_open" >
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Live Birth Pregnancy
                                    Outcome</strong></label>
                            <div class="input-group">
                                <select class="form-control" id="l_birth" name="l_birth">
                                    <option value="">Select</option>
                                    <option value="Singleton">
                                        Singleton
                                    </option>
                                    <option value="Twin">Twin</option>
                                    <!--option value="Triplets">Triplets
                                    </option-->
                                    <option value="Higher Order">Higher Order</option>

                                </select>
                            </div>
                            @error('l_birth')
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
                            <span id="art_undertaken_id"
                                class="color-csp-clinic-two"><?php //if(isset($art_undertaken)){ echo $art_undertaken;} ?></span>
                        </div>
                    </div> --}}
                    <div class="col-md-6 display-none-csp-clinic-one" id="gender_child1" >
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
                                    <div class="col md-7 display-none-csp-clinic-one" id="male_hidden">
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
                                <!--inner-->
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
                                    <div class="col md-7 display-none-csp-clinic-one" id="female_hidden">
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
                                <!--inner-->
                            </div>
                        </div>
                    </div>










                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Complications, If
                                    any</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" col="5" rows="3"
                                    name="comp_if_any"></textarea>
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
                                    name="remark"></textarea>
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
                            name="declaration">
                        <label class="form-check-label" for="gridCheck">
                            From Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime.<span
                                class="color-csp-clinic-two">*</span>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="declaration1"
                            name="declaration1">
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
                            name="declaration3">
                        <label class="form-check-label" for="gridCheck">
                            From Oocyte Donor that she has not donated oocytes more than once in her life time.
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="declaration4"
                            name="declaration4">
                        <label class="form-check-label" for="gridCheck">
                            From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.
                        </label>
                    </div>
                </div>
                </div>      
                <button type="submit" name="submit" value="continue" id="btnSubmit"  class="btn me-2 bc-br-color-csp-clinic-three">Continue patient details</button>
                <button type="button" id="closeButton" class="btn me-2 btn btn-danger">Close</button>        
                {{-- <button type="submit" name="submit" id="btnSubmit" onclick="return validatesubmit()"
                    class="btn me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">Submit</button> --}}
                <!--button type="submit" class="btn btn-danger light">Cancel</button-->
            </form>
</div>
    </div>
</div>
    </div>
</div>
</div>


<script nonce="{{$cspNonce}}">
document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('btnSubmit');
    const closeButton = document.getElementById('closeButton');
    const fileInputChild = document.getElementById('child_medical_certificate');
    const fileInput = document.getElementById('medical_certificate');
    const removeButtonChild = document.getElementById('removeFileButtonchild');
    const removeButton = document.getElementById('removeFileButton');

    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            if (!validatesubmit()) {
                event.preventDefault();
            }
        });
    }
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            window.location.href = '{{ route('clinic.clinicForm_list') }}';
        });
    }
    if (fileInputChild) {
        fileInputChild.addEventListener('change', function() {
            validateForSize(this, 50, 200);
        });
    }
    if (removeButtonChild && fileInputChild) {
        removeButtonChild.addEventListener('click', function() {
            removeFile1();
        });
    }
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            validateForSize(this, 50, 200);
        });
    }
    if (removeButton && fileInput) {
        removeButton.addEventListener('click', function() {
            removeFile();
        });
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
            $('#l_birth').on('change', function () {


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

                if (l_birth === "Singleton") {
                    // Show gender selection but only allow one selection
                    maleSection.show();
                    femaleSection.show();

                    maleCheckbox.on('change', function () {
                    maleNumber.val(''); // Reset dropdown to "Select"
                    femaleNumber.val('');
                        if (this.checked) {
                            femaleCheckbox.prop('checked', false);
                            maleHidden.show();
                            femaleHidden.hide();
                        } else {
                            maleHidden.hide();
                        }
                    });

                    femaleCheckbox.on('change', function () {
                        maleNumber.val(''); // Reset dropdown to "Select"
                femaleNumber.val('');
                        if (this.checked) {
                            maleCheckbox.prop('checked', false);
                            femaleHidden.show();
                            maleHidden.hide();
                        } else {
                            femaleHidden.hide();
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

                    femaleCheckbox.off('change').on('change', function () {
                        femaleHidden.toggle(this.checked);
                    });
                }
            });
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

   

</script>

          <script nonce="{{ $cspNonce }}">
            $('#nationality').on('change', function() {
                if (this.value == 'OCI Card Holders') {
                    $("#other_nationality1").show();
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
            const nationalityWife = document.getElementById("nationality_wife1");
            const otherNationalityHusband = document.getElementById("other_nationality1");
            const otherNationalityWife = document.getElementById("other_nationality1_wife");
            const nationalityHusbandSelect = document.getElementById("nationality");
            const nationalityWifeSelect = document.getElementById("nationality_wife");
            //const wifeLabel = document.querySelector("label[for='validationCustomUsername']");
            const wifeLabel = document.getElementById("validationCustomUsername");
            
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
                    wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";
                } else if (singleWomanRadio.checked) {
                    nationalityHusband.style.display = "none";
                    nationalityWife.style.display = "block";
                    wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";
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
        
              
            </script>
<script nonce="{{ $cspNonce }}">
    var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".png"];
    
    function validateForSize(oInput, minSize, maxSizejpeg) {
        //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFilejpeg.length; j++) {
                    var sCurExtension = _validFilejpeg[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                        .toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
    
                if (!blnValid) {
                    alert("Sorry, this file is invalid, allowed extension is: " + _validFilejpeg.join(", "));
                    oInput.value = "";
                    return false;
                }
            }
        }
    
        fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
    }
    
    function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
        if (fdata.files && fdata.files[0]) {
            var fsize = fdata.files[0].size /
                1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
            //alert(fsize)
            if (fsize > maxSizejpeg || fsize < minSize) {
                alert('This file size is: ' + fsize.toFixed(2) +
                    "KB. Files should be in " + (minSize) + " to " + (maxSizejpeg) + " KB ");
                fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
                return false;
            } else {
                console.log("");
            }
        }
    }
    </script>
    
    <script nonce="{{ $cspNonce }}">
    $('#num_pre_child').on('change', function() {
        $("#give_details").val('');
        $("#child_medical_certificate").val('');
    
    
        if (this.value == 'Yes') {
            $("#medical_open").show();
            $("#child_medical_open").show();
    
            // child_medical_open
        } else {
            $("#medical_open").hide();
            $("#child_medical_open").hide();
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
             $('#no_cycles').on('change', function() {
                var selectedNumber = $(this).val();
                var optionSelect = $('#total_nun_cycles').val();
    
                //alert(optionSelect);
                if (optionSelect == selectedNumber){
    
                  //  alert('done');
    
                    $('#tratment_Outcome').html('<option value="Not Pregnant">Not Pregnant</option>');
    
                }
                 else{
                    $('#tratment_Outcome').html('<option value="">Select</option><option value="Pregnant">Pregnant</option><option value="Not Pregnant">Not Pregnant</option>');
    
                //   //  alert('not done');
                 }
           });
            </script>


<script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function() {
        let radioSingleWoman = document.getElementById("flexRadioDefault2");
        let nationalityDiv = document.getElementById("nationality_wife1");
        let nationalitySelect = document.getElementById("nationality_wife");

        document.querySelectorAll('input[name="case_of"]').forEach(function(radio) {
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
                        <option value="OCI Card Holders" class="p-1">OCI Card Holders</option>
                    `;
                }
            });
        });
    });
</script>
    
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
        <style nonce="{{$cspNonce}}">
    
    input.select2-search__field {
        width: 150px !important;    
    }
    </style>
    
    <script nonce="{{ $cspNonce }}">
    $('#types_of_treat').on('change', function() {
        $("#types_of_treat1").val('');
        if (this.value == 'Surrogacy using donor gametes') {
            $("#ivf_donor").show();
        } else {
            // 10-07-2024
           // $("#ivf_donor").hide();
        }
    });
    </script>
    
    <script nonce="{{ $cspNonce }}">
        // 16-07-2024
    $('#types_of_treat').on('change', function() {
        $("#types_of_treat1").val('');
        if (this.value == 'Surrogacy using own gametes(Self Egg and Self Sperm)') {
            $("#ivf_donor").hide();
        } else {
            // 10-07-2024
           // $("#ivf_donor").hide();
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
            $("#treat_outcomes1").show();
            //$("#preganancy_outcome1").show();
        } else {
            $("#treat_outcomes1").hide();
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
    $('#sel2').on('change', function() {
        if (this.value == 'Others') {
            $("#others_id").show();
        } else {
            $("#others_id").hide();
            $('#art_undertaken_other').val('');
        }
    });
    </script>
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
    </script>
    <script nonce="{{ $cspNonce }}">
    function validatesubmit() {
        if (document.getElementById("pati_uhid").value == "") {
            alert("Patient UHID cannot be blank");
            document.getElementById("pati_uhid").focus();
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
            alert("Please select either the couple or single woman");
            document.getElementById("flexRadioDefault1").focus();
            return false;
        }
      
       
    
        if ($('#flexRadioDefault1').is(':checked') && $('#age').val() == "") {
            alert("Please Select Husband age");
            document.getElementById("age").focus();
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

        if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "OCI Card Holders" && $('#other_nationality').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality").focus();
            return false;
        }
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }

        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality_wife").focus();
            return false;
        }
    
        if ($('#flexRadioDefault2').is(':checked') && $('#age_of_women').val() == "") {
            alert("Please Select Age of woman (widow or divorcee)");
            document.getElementById("age_of_women").focus();
            return false;
        }
        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }

        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country");
            document.getElementById("other_nationality_wife").focus();
            return false;
        } 
        if (document.getElementById("num_pre_child").value == "") {
            alert("Having Surviving Child cannot be blank");
            document.getElementById("num_pre_child").focus();
            return false;
        }
    
        if ((document.getElementById("num_pre_child").value == "No") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Check the undertaking from intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier"
            );
            document.getElementById("declaration1").focus();
            return false;
        }
        if (document.getElementById("medical_surrogacy").value == "") {
            alert("Medical Condition Necessitating Surrogacy cannot be blank");
            document.getElementById("medical_surrogacy").focus();
            return false;
        }
        if (document.getElementById("medical_certificate").value == "") {
            alert("Upload Certificate of Medical Indication issued by District Medical Board");
            document.getElementById("medical_certificate").focus();
            return false;
        }
        if ((document.getElementById("num_pre_child").value == "Yes") && (document.getElementById(
                "give_details").value == "")) {
            alert("Details of child cannot be blank");
            document.getElementById("give_details").focus();
            return false;
        }      
    
        if ((document.getElementById("num_pre_child").value == "Yes") && (document.getElementById(
                "child_medical_certificate").value == "")) {
            alert("Upload the Medical Certificate of child");
            document.getElementById("child_medical_certificate").focus();
            return false;
        }
    
        if (document.getElementById("types_of_treat").value == "") {
            alert("Type of Treatment cannot be blank");
            document.getElementById("types_of_treat").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "Surrogacy using donor gametes") && (document
                .getElementById(
                    "types_of_treat1").value == "")) {
            alert("Gamete Source cannot be blank");
            document.getElementById("types_of_treat1").focus();
            return false;
        }
       
        if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration3")
                .checked)) {
            alert("Check the undertaking from Oocyte Donor that she has not donated oocytes more than once in her life time.");
            document.getElementById("declaration3").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document.getElementById("declaration4")
                .checked)) {
            alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman.");
            document.getElementById("declaration4").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat1").value == "Self Oocyte & Donor Sperm") && (!document.getElementById("declaration4")
                .checked)) {
            alert("Check the undertaking from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman");
            document.getElementById("declaration4").focus();
            return false;
        }
    
        if (document.getElementById("surrogate_mother_age").value == "") {
            alert("Surrogate Mother Age cannot be blank");
            document.getElementById("surrogate_mother_age").focus();
            return false;
        }
        if (document.getElementById("sel2").value == "") {
            alert("ART Procedure Undertaken cannot be blank");
            document.getElementById("sel2").focus();
            return false;
        }
        if ((document.getElementById("sel2").value == "Others") && (document.getElementById(
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
            alert("Please specify reason for Cycle Cancellation/failure");
            document.getElementById("Cycle_fail_reason").focus();
            return false;
        }
    
     
        if (document.getElementById("tratment_Outcome").value == "") {
            alert("Treatment Outcome cannot be blank");
            document.getElementById("tratment_Outcome").focus();
            return false;
        }
        if ((document.getElementById("tratment_Outcome").value == "Pregnant") && (document.getElementById(
                "preganancy_outcome").value == "")) {
            alert("Pregnancy Outcome cannot be blank");
            document.getElementById("preganancy_outcome").focus();
            return false;
        }
       
        
    
        if ((document.getElementById("preganancy_outcome").value == "live birth") && (document.getElementById(
                "l_birth").value == "")) {
            alert("Live Birth Pregnancy Outcome cannot be blank");
            document.getElementById("l_birth").focus();
            return false;
        }
        if ((document.getElementById("preganancy_outcome").value == "live birth")){
        const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
        const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                if (!isChecked) {
                    alert('Please select Gender.');
                    document.getElementById("l_birth").focus();
                    return false;
                }
              
          
        }
        if ((document.getElementById("preganancy_outcome").value == "Stillbirth")){
        const checkboxes = document.querySelectorAll('input[name="gender_child[]"]');
        const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                if (!isChecked) {
                    alert('Please select Gender.');
                    document.getElementById("male_female").focus();
                    return false;
                }
              
          
        }





        const male_femaleChecked = document.getElementById('male_female').checked;
        const male_female1Checked = document.getElementById('male_female1').checked;
        const male_numberNumber = document.getElementById('male_number').value;
        const female_number = document.getElementById('female_number').value;
                

                if (male_femaleChecked && male_numberNumber === "") {
                    alert("Please select the number of male.");
                    document.getElementById("male_number").focus();
                    return false;
                }

                if (male_female1Checked && female_number === "") {
                    alert("Please select the number of female.");
                    document.getElementById("female_number").focus();
                    return false;
                }       
        if (!document.getElementById("declaration").checked) {
            alert(
                "Check the undertaking from Surrogate Mother that she has not acted as a surrogate mother more than once in her lifetime."
            );
            document.getElementById("declaration").focus();
            return false;
        }
    
        var agree = confirm(
            "Kindly check and confirm all details before final submission. There is no provision for editing/correction once the form is submitted."
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
    $('#flexRadioDefault2').on('click', function() {
        if ($('#flexRadioDefault2').is(':checked')) {
            $('#age_of_women').val('');
            $('#age').val('');
            $('#wife_age').val('');
        } else {
            $('#age_of_women').val('');
        }
    });
    
    $('#flexRadioDefault1').on('click', function() {
    
        if ($('#flexRadioDefault1').is(':checked')) {
    
            $('#types_of_treat').html('<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="Surrogacy using own gametes(Self Egg and Self Sperm)" id="own_gametes" class="p-1">Surrogacy using own gametes(Self Egg and Self Sperm)</option><option value="Surrogacy using donor gametes" id="d_gametes" class="p-1">Surrogacy using donor gametes</option>');
            $('#types_of_treat1').html('<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">Self Oocyte & Donor Sperm </option><option value="Donor Oocyte & Self Sperm" id="o_sperm" class="p-1">Donor Oocyte & Self Sperm</option>');
            
    
            $('#age_of_women').val('');
            $('#age').val('');
            $('#wife_age').val('');
        } else {
            $('#age').val('');
            $('#wife_age').val('');
        }
    });
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
    



@endsection