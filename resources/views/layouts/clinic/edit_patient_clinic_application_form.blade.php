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
@if (session('upd_error'))
<div class="alert alert-danger">
    {{ session('upd_error') }}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops! Something went wrong.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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
                                <input type="hidden"  name="enc_uhid" value="{{ encrypt($uhidDetails->id) }}" readonly>
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

                    <div class="col-md-2 {{ blank($uhidDetails->nationality) ? 'dn-csp-clinic-two' : '' }}" id="nationality_husband" >
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
                  
                    <div class="col-md-4 {{ blank($uhidDetails->other_nationality) ? 'dn-csp-clinic-two' : '' }}" id="other_nationality1">
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

                    <div class="col-md-2 {{ blank($uhidDetails->nationality_wife) ? 'dn-csp-clinic-two' : '' }}" id="nationality_wife1" >                         
                        <div class="mb-3">
                            <label class="text-label form-label" id="nationality_woman_lable" for="nationality_wife"><strong>Nationality of the Wife</strong><span
                                  class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                            
                            @php
                                $selectedNationality = old('nationality_wife', $uhidDetails->nationality_wife ?? '');
                            @endphp

                            <select name="nationality_wife" id="nationality_wife" class="form-control">
                                @php $selected = old('nationality_wife', $uhidDetails->nationality_wife ?? '') @endphp
                            <option value="">Select</option>
                            <option value="Indian" @selected($selected === 'Indian')>Indian</option>
                            <option value="Foreigner" @selected($selected === 'Foreigner')>Foreigner</option>
                            </select>
                            </div>
                            @error('nationality_wife')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 {{ blank($uhidDetails->other_nationality_wife) ? 'dn-csp-clinic-two' : '' }}" id="other_nationality1_wife">
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
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 one selectt {{ blank($uhidDetails->age_hus_wife) ? 'dn-csp-clinic-two' : '' }}" id="one_couple"  >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Husband Age</strong><span class="bc-csp-clinic-three">*</span></label>
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

                    <div class="col-md-3 one selectt {{ blank($uhidDetails->wife_age) ? 'dn-csp-clinic-two' : '' }}" id="one_couple" >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Wife Age</strong><span class="bc-csp-clinic-three">*</span></label>
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

                    <div class="col-md-3 two selectt age-women-section {{ blank($uhidDetails->age_of_women) ? 'dn-csp-clinic-two' : '' }}" id="single" >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Age of Woman</strong><span class="bc-csp-clinic-three">*</span></label>
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
                    
                    <div class="border p-3 rounded">
                        <label class="form-label mb-3 d-block">
                            <strong>Cause of Infertility</strong><span class="bc-csp-clinic-three">*</span>
                        </label>

                        <div class="row">
                            <!-- Male Factor -->
                            <div class="col-md-2 {{ blank($uhidDetails->male_factor) ? 'dn-csp-clinic-two' : '' }}" id="male_factor_div">
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
                            <div class="col-md-2 {{ blank($uhidDetails->female_factor) ? 'dn-csp-clinic-two' : '' }}">
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
                            <div class="col-md-2 {{ blank($uhidDetails->unexplained) ? 'dn-csp-clinic-two' : '' }}">
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
                            <div class="col-md-12 mt-3 {{ blank($uhidDetails->cause_of_infretily) ? 'dn-csp-clinic-two' : '' }}">
                                <div class="input-group mt-2">
                                    <input type="text" class="form-control cause_of_infretily_length" name="cause_of_infretily"
                                    id="cause_of_infretily" aria-describedby="cause_of_infretily"
                                    value="{{ old('cause_of_infretily', $uhidDetails->cause_of_infretily ?? '') }}"
                                    placeholder="Please describe the cause of infertility...">
                                </div>
                                @error('cause_of_infretily')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 {{ blank($uhidDetails->art_proc_undertaken) ? 'dn-csp-clinic-two' : '' }}" id="other">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>ART Procedure Undertaken</strong><span class="bc-csp-clinic-three">*</span>
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
                                    <option value="Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)" {{ old('art_proc_undertaken', $uhidDetails->art_proc_undertaken ?? '') == 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)' ? 'selected' : '' }}>
                                        Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)
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

                    <div class="col-md-4 {{ blank($uhidDetails->art_undertaken_other) ? 'dn-csp-clinic-two' : '' }}" id="others_id" >
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

                    <div class="col-md-4 {{ blank($uhidDetails->types_of_treat) ? 'dn-csp-clinic-two' : '' }}">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Type of Treatment</strong><span class="bc-csp-clinic-three">*</span>
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
                    
                    <div class="col-md-4 {{ blank($uhidDetails->types_of_treat1) ? 'dn-csp-clinic-two' : '' }}" id="ivf_donor"  >
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Type of Donation</strong><span class="bc-csp-clinic-three">*</span>
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

                    <div class="col-md-4 {{ blank($uhidDetails->total_num_of_cyc) ? 'dn-csp-clinic-two' : '' }}" id="">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername">
                                <strong>Total No. of Treatment Cycle(s) Undertaken</strong><span class="bc-csp-clinic-three">*</span>
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

                    <div class="col-md-4 {{ blank($uhidDetails->no_cycles) ? 'dn-csp-clinic-two' : '' }}" id="no_cycles1">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>No. of Cycles Cancelled, if any
                                </strong><span class="bc-csp-clinic-three">*</span></label>
                            <div class="input-group">
                                <select name="no_cycles" id="no_cycles" class="form-control"
                                    data-db-value="{{ $uhidDetails->no_cycles ?? ''}}"
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

                    <div class="col-md-7 {{ blank($uhidDetails->cyc_canc_failure_reason) ? 'dn-csp-clinic-two' : '' }}" id="fail_reason" >
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

                    <div class="col-md-4 {{ blank($uhidDetails->treat_outcomes) ? 'dn-csp-clinic-two' : '' }}" id="" >
                        <div class="mb-3">
                            <label class="text-label form-label" for=""><strong>Treatment
                                    Outcome</strong><span class="bc-csp-clinic-three">*</span></label>
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
                @php
                    // $gender_child = old('gender_child', isset($uhidDetails->gender_child) ? explode(',', $uhidDetails->gender_child) : []);
                    $male_number = old('male_number', $uhidDetails->male_number ?? '');
                    $female_number = old('female_number', $uhidDetails->female_number ?? '');
                    $show_gender_section = $male_number || $female_number
                @endphp
    
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


                    <div class="col-md-12 {{ blank($uhidDetails->complicatoins_if_any) ? 'dn-csp-clinic-two' : '' }}">
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



                    <div class="col-md-12 {{ blank($uhidDetails->remark) ? 'dn-csp-clinic-two' : '' }}">
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
                </div>
                <div class="col-md-12">
                    <div class="mb-3" id="declaration_both">
                        <label class="text-label form-label">
                            <strong>Required Affidavit/Undertaking** regarding following to be taken on record for the patient:</strong>
                        </label>
                        
                        <div class="col-12" id="declaration_hide">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration" name="declaration"
                                    {{ old('declaration', $uhidDetails->declaration ?? '') === 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="declaration">
                                    Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration1" name="declaration1"
                                    {{ old('declaration1', $uhidDetails->declaration1 ?? '') === 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="declaration1">
                                    Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.
                                </label>
                            </div>
                        </div>

                        <label class="form-check-label" for="declaration1">
                                    **Note: Undertaking will be taken in retrospective cases where affidavit is not available and the case is prior to the operationalization of the portal.
                        </label>
                    </div>
                </div>
                <!--div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck2"
                                required>
                            <label class="form-check-label" for="invalidCheck2">
                                Check Me out
                            </label>
                        </div>
                    </div-->

                 <button type="button" id="closeBtn" class="btn me-2 btn btn-danger">Close</button>
              
                        <button type="submit" name="updatev" value="updatebtn" id="btnSubmit"
                        class="btn me-2 button-csp-clinic-four" >update</button>
                          <button type="submit" value="deletebtn" name="updatev" id="deleteBtn"
                        class="btn me-2 btn btn-danger"  data-uhid="{{ $uhidDetails->patient_uhid }}" >Delete</button>
            </form>

    </div>
</div>
    </div>
</div>
</div>

<!-- Start of onload function for populating entries from the database -->
<!-- <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", () => {

        const show = id => $("#" + id).show();
        const hide = id => $("#" + id).hide();

        // CLOSE BUTTON

        $("#closeBtn").click(() => {
            window.location.href = "{{ route('clinic.clinicForm_list') }}";
        });

        // PRELOAD SECTIONS FROM DATABASE

        // Failure Reason
        if ($("#cyc_canc_failure_reason").val()) {
            show("fail_reason");
        }

        // NATIONALITY
        if ($("#nationality").val() === "Foreigner") {
            show("other_nationality1");
        } else {
            hide("other_nationality1");
        }

        if ($("#nationality_wifeedit").val() === "Foreigner") {
            show("other_nationality1_wife");
        } else {
            hide("other_nationality1_wife");
        }

        // CASE TYPE
        function toggleCaseType() {

            const isCouple = $("#flexRadioDefault1").is(":checked");

            $("#nationality_husband").toggle(isCouple);

            $("#male_factor_div").toggle(isCouple);

            $("#nationality_wife1").show();

            $("#nationality_woman_lable").html(
                isCouple
                    ? "<strong>Nationality of Wife</strong><span class='bc-csp-clinic-three'>*</span>"
                    : "<strong>Nationality</strong><span class='bc-csp-clinic-three'>*</span>"
            );
        }

        toggleCaseType();

        // TYPES OF TREATMENT
        if ($("#types_of_treat").val() === "ART Treatment using donor gametes") {

            show("ivf_donor");

            show("declaration_both");

        } else {

            hide("ivf_donor");

            hide("declaration_both");
        }

        // TYPES OF TREATMENT 1
        const treatType = $("#types_of_treat1").val();

        if (treatType === "Sperm Donation") {

            hide("declaration_hide");

        }

        // CYCLES
       $(document).ready(function(){

            $('#total_num_of_cyc').change(function(){

                var selectedNumber = $(this).val();

                var optionSelect = $('#no_cycles');

                optionSelect.empty();

                optionSelect.append('<option value="">Select</option>');

                for(var i = 0; i <= selectedNumber; i++) {
                    optionSelect.append('<option value="' + i + '">' + i + '</option>');
                }
            });

            $('#total_num_of_cyc').trigger('change');

            var dbValue = $('#no_cycles').attr('data-db-value');

            if(dbValue != '' && dbValue != null){
                $('#no_cycles').val(dbValue);
            }

        });

        // Show treat outcomes
        $("#treat_outcomes").toggle(totalCycles > 0);

        // Show fail reason
        $("#fail_reason").toggle(selectedCycle > 0);

        // ART PROCEDURE
        if ($("#art_proc_undertaken").val() === "Others") {

            show("others_id");

        } else {

            hide("others_id");
        }

        // DELETE BUTTON
        $("#deleteBtn").click(function () {

            return confirm(
                "Are you sure you want to delete Patient UHID: " +
                $(this).data("uhid") + "?"
            );
        });

        // RADIO BUTTON TOGGLE
        $('input[type="radio"]').click(function () {

            $(".selectt").hide();

            $("." + $(this).val()).show();
        });

        // FORM VALIDATION
        $("#btnSubmit").click(function (e) {

            if (!validatesubmit()) {

                e.preventDefault();
            }
        });
    });
</script> -->
<!-- End of onload function for populating entries from the database -->

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
        document.getElementById("declaration").checked = false;
    } else {
        $("#declaration_hide").show();
        
    }
});
</script>
 <script nonce="{{ $cspNonce }}">
    $('#nationality_wife').on('change', function() {
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
    document.addEventListener("DOMContentLoaded", function () {
const coupleRadio = document.getElementById("flexRadioDefault1");
const singleWomanRadio = document.getElementById("flexRadioDefault2");
const maleFactorDive = document.getElementById("male_factor_div");
const nationalityHusband = document.getElementById("nationality_husband");
const nationalityWife = document.getElementById("nationality_wife1");
const otherNationalityHusband = document.getElementById("other_nationality1");
const otherNationalityWife = document.getElementById("other_nationality1_wife");
const nationalityHusbandSelect = document.getElementById("nationality");
const nationalityWifeSelect = document.getElementById("nationality_wife");
const wifeLabel = document.getElementById("nationality_woman_lable");
// const wifeLabel = document.querySelector("label[for='validationCustomUsername']");

function resetCountryFields() {
nationalityHusbandSelect.value = "";
nationalityWifeSelect.value = "";
otherNationalityHusband.style.display = "none";
otherNationalityWife.style.display = "none";
}

function toggleFields() {
//alert('check 1');
let nationalityHusband = document.getElementById("nationality_husband");
let nationalityWife = document.getElementById("nationality_wife1");
let otherNationalityHusband = document.getElementById("other_nationality1");
let otherNationalityWife = document.getElementById("other_nationality1_wife");
if (coupleRadio.checked) {           
    nationalityHusband.style.display = "block";
    nationalityWife.style.display = "block";
    wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span class='bc-csp-clinic-three'>*</span>";
    maleFactorDive.style.display = "block";
} else if (singleWomanRadio.checked) {           
    nationalityHusband.style.display = "none";
    nationalityWife.style.display = "block";
    maleFactorDive.style.display = "none";
    maleFactorDive.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
        input.checked = false;
    });

    wifeLabel.innerHTML = "<strong>Nationality</strong><span class='color-red-fourty-three'>*</span>"; 
    otherNationalityHusband.style.display = 'none';
    document.getElementById("other_nationality").value = '';
    otherNationalityWife.style.display = 'none';
    document.getElementById("other_nationality_wife").value = '';
    nationalityHusband.style.display = 'none';
    document.getElementById("nationality").value = '';          
}

// Reset and hide country fields when changing the main radio button
// resetCountryFields();
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
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "") {
            alert("Nationality of the Husband cannot be blank");
            document.getElementById("nationality").focus();
            return false;
        }
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "Foreigner" && $('#other_nationality').val() == "") {
            alert("Please specify Country of the husband");
            document.getElementById("other_nationality").focus();
            return false;
        }
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality of the Wife cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }
        if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "Foreigner" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country of the wife");
            document.getElementById("other_nationality_wife").focus();
            return false;
        }
        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "") {
            alert("Nationality of the Woman cannot be blank");
            document.getElementById("nationality_wife").focus();
            return false;
        }
        if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "Foreigner" && $('#other_nationality_wife').val() == "") {
            alert("Please specify Country of the woman");
            document.getElementById("other_nationality_wife").focus();
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
        if ($('#flexRadioDefault2').is(':checked') && $('#age_of_women').val() == "") {
            alert("Please Select Age of woman");
            document.getElementById("age_of_women").focus();
            return false;
        }
        let male = document.getElementById("male_factor").checked;
        let female = document.getElementById("female_factor").checked;
        let unexplained = document.getElementById("unexplained").checked;
        if (!male && !female && !unexplained) {
            alert("Please select at least one option for cause of infertility.");
            return false; 
        }     
        if ($('#cause_of_infretily').val() == "") {
            alert("Cause of Infertility cannot be blank");
            document.getElementById("cause_of_infretily").focus();
            return false;
        }

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
        if (document.getElementById("total_num_of_cyc").value == "") {
            alert("Total No. of Treatment Cycle(s) Undertaken cannot be blank");
            document.getElementById("total_num_of_cyc").focus();
            return false;
        }        
        if (document.getElementById("no_cycles").value == "") {
            alert("No. of Cycles Cancelled (if any) cannot be blank");
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
        
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Oocyte Donation") && (!document.getElementById("declaration")
                .checked)) {
            alert(
                "Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time."
            );
            document.getElementById("declaration").focus();
            return false;
        }

        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Oocyte Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple."
            );
            document.getElementById("declaration1").focus();
            return false;
        }   
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Sperm Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple."
            );
            document.getElementById("declaration1").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Both Oocyte Donation & Sperm Donation") && (!document.getElementById("declaration")
                .checked)) {
            alert(
                "Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time."
            );
            document.getElementById("declaration").focus();
            return false;
        }
        if ((document.getElementById("types_of_treat").value == "ART Treatment using donor gametes") && (document.getElementById("types_of_treat1").value == "Both Oocyte Donation & Sperm Donation") && (!document.getElementById("declaration1")
                .checked)) {
            alert(
                "Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple."
            );
            document.getElementById("declaration1").focus();
            return false;
        }  
        
        const patient_uhid = document.getElementById("patient_uhid").value;
 
        var agree = confirm(
            "Kindly check & confirm all details for UHID-" + patient_uhid + " before continuing next patient details.After submission Patient details can be modified using view / edit options."
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
                                
            }        
        });
        $('.cause_of_infretily_length').on('input', function() {
			var value = $(this).val();

			if (value.length > 250) {
				$(this).val(value.substring(0, 250));
					alert('Maximum 250 characters allowed for the cause of infertility.');
				
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
                $("#declaration_both").show();
            } else {
                $("#ivf_donor").hide();
                $("#declaration_both").hide();
                $('#declaration').prop('checked', false);
                $('#declaration1').prop('checked', false);
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
        $(document).ready(function(){
            $('#total_num_of_cyc').change(function(){
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
            $('#total_num_of_cyc').trigger('change');          
            // Trigger the change event on page load to populate options based on the default selected value
            
        });
</script>
<script nonce="{{ $cspNonce }}">
    $('#no_cycles').on('change', function() {
        var selectedNumber = $(this).val();
        var optionSelect = $('#total_num_of_cyc').val();

        //alert(optionSelect);
        if (optionSelect == selectedNumber){

          //  alert('done');

            $('#treat_outcomes').html('<option value="Not Pregnant">Not Pregnant</option>');

        }
         else{
            $('#treat_outcomes').html('<option value="">Select</option><option value="Pregnant">Pregnant</option><option value="Not Pregnant">Not Pregnant</option>');

        //   //  alert('not done');
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
    $('input[name="case_of"]').
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
                if ($("#types_of_treat1").val() === "Sperm Donation") {
                    $('#declaration_hide').hide();
                    $("#declaration").prop('checked',false);
                }
            }else if (isCouple && (artValue === 'intra-uterine insemination(IUI)' || artValue === 'artificial insemination') && treatValue === 'ART Treatment using donor gametes') {
                $('#types_of_treat1').html(
                    '<option value="Sperm Donation">Sperm Donation</option>'
                );
                if ($("#types_of_treat1").val() === "Sperm Donation") {
                    $('#declaration_hide').hide();
                    $("#declaration").prop('checked',false);
                }

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
        $('#male_factor').val('N');
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
        $('#wife_age').val('');
        $('#male_factor').val('Y');
        $('#nationality').val('');
        $('#other_nationality').val(''); 
        

    } else{
        $('#age_hus_wife').val('');
        $('#wife_age').val('');
        $('#nationality').val('');
        $('#other_nationality').val('');
    }
});
</script>

<script nonce="{{ $cspNonce }}">
function checkUHID() {
    var patient_uhid = $('#patient_uhid').val();
    var treatmentStatus = $('input[name="previous_treatment"]:checked').val();
    var yy = $('#year_s').val();
    var qq = $('#quater_s').val();
    if (patient_uhid === "") {
        $('#availability').html('');
      //  $('#btnSubmit').attr("disabled", true);
        return;
    }

    $.ajax({
        url: '{{ route("clinic.checkuhid") }}',
        method: "POST",
        data: {
            patient_uhid: patient_uhid,
            year_: yy,
            quarter_: qq,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'exists') {
                if (treatmentStatus === "Yes") {
                    // Always disable false
                    $('#availability').html('<span class="text-success">UHID Found for this ART clinic.</span>');
                    $('#btnSubmit').attr("disabled", false);
                
                } else if (treatmentStatus === "No") {
                    // Disable True when quater match when UHID exists 
                    $('#availability').html('<span class="text-danger">UHID already exists.</span>');
                    $('#btnSubmit').attr("disabled", true);
                } else {
                $('#availability').html('');
                $('#btnSubmit').attr("disabled", true);
                }
            } else if(treatmentStatus === "Yes") {
                $('#availability').html(
                    '<span class="text-danger">UHID does not exist for this ART clinic. Kindly enter correct UHID.</span>'
                );
                    $('#btnSubmit').attr("disabled", true);
             
            }
                else {
                    $('#availability').html('');
                    $('#btnSubmit').attr("disabled", false);
                } 
            //}
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// Run when donor_id input loses focus
$(document).on('blur', '#patient_uhid', function () {
    checkUHID();
});

// Run when previous treatment radio is changed
$(document).on('change', 'input[name="previous_treatment"]', function () {
    checkUHID();
});
// Run when donor_id input loses focus
$(document).on('blur', '#patient_uhid', function () {
    checkUHID();
});

// Run when previous treatment radio is changed
$(document).on('change', 'input[name="previous_treatment"]', function () {
    checkUHID();
});

// No of cycle set value @start(26-05-2026)
    $(document).ready(function () {

        let oldValue = "{{ old('no_cycles') }}";

        let dbValue = $('#no_cycles').attr('data-db-value') || '';

        let selectedValue = oldValue !== "" ? oldValue : dbValue;

        let options = `<option value="">Select</option>`;

        for (let i = 0; i <= 20; i++) {
            let selected = (selectedValue == i) ? 'selected' : '';
            options += `<option value="${i}" ${selected}>${i}</option>`;
        }

        $('#no_cycles').html(options);
    });

    $(document).ready(function () {
        $('#btnSubmit').on('click', function (e) {
            if (!validatesubmit()) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
    
     $("#closeBtn").click(() => {
            window.location.href = "{{ route('clinic.clinicForm_list') }}";
        });

       $("#deleteBtn").click(function () {

            return confirm(
                "Are you sure you want to delete Patient UHID: " +
                $(this).data("uhid") + "?"
            );
        });
    // No of cycle set value @end(26-05-2026)
</script>
@endsection