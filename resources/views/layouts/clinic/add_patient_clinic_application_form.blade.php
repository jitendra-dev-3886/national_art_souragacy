@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{ $cspNonce }}">
     .color-red-fourty-three{
        color: #ff0000;
    }
    .displyay-none-fifty{
        display: none;
    }
    .bc-br-color-fourtyeight{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }

    .csp-readonlycolor {
    background-color: #e8eaec !important;  /* light blue, change as needed */
    font-weight: bold;          /* optional */
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
            <h3 class="card-title mb-5 text-primary">Patient information form for ART Clinic</h3>
            
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
            
              <form name="art_clin1" method="POST" action="{{ route('clinic.save_patientclinic_application_form') }}" enctype="multipart/form-data" autocomplete="off">                             
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
                    <label class="form-label d-block">
                        <strong>Year and Quarter</strong>
                    </label>
                    <div class="d-flex gap-3">
                            @if ($available_years->count() === 1)
                            {{-- <input type="text" class="form-control" name="year"
                                   value="{{ $available_years->first()->year }}"
                                   readonly> --}}
                            <input type="text" name="year" value="{{ $available_years->first()->year }}" id="year_s" class="form-control csp-readonlycolor" readonly>
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
                        @if ($available_quarters->count() === 1)
                        {{-- <input type="text" class="form-control" name="quarter"
                               value="{{ $available_quarters->first()['description'] }}" readonly> --}}
                        <input type="hidden" name="quarter" class="form-control" id="quater_s" value="{{ $available_quarters->first()['id'] }}" readonly>
                         <input type="text"  class="form-control csp-readonlycolor" value="{{ $available_quarters->first()['description'] }}" readonly>
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
								<input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_yes" value="Yes">
								<label class="form-check-label" for="previous_treatment_yes">
									Yes
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="previous_treatment" id="previous_treatment_no" value="No" checked>
								<label class="form-check-label" for="previous_treatment_no">
									No
								</label>
							</div>
						</div>
						<span id="bank_reg_numID" class="color-red-fourty-three">
							<?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;} ?>
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
                                    value="{{ $patient_list->registration_no }}"
                                    class="form-control csp-readonlycolor" name="clinic_level1_reg_num"
                                    id="clinic_level1_reg_num" aria-describedby="clinic_level1_reg_num"
                                    placeholder="" readonly>
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="color-red-fourty-three"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Name of the
                                    Clinic</strong></label>
                            <div class="input-group">
                                <input type="text" value="{{ $patient_list->name }}"
                                    class="form-control csp-readonlycolor" name="name_of_clinic" id="name_of_clinic"
                                    aria-describedby="name_of_clinic" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                                class="color-red-fourty-three"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3 ">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Patient
                                    UHID</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="patient_uhid"
                                    id="patient_uhid" aria-describedby="patient_uhid" placeholder="" maxlength="20">
                            </div>
                            <!--span id="patient_uhidID" class="color-red-fourty-three"></span-->
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
                                    Single Woman
                                </label>
                                </div>
                            </div>
                            @error('flexRadioDefault')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-2 displyay-none-fifty" id="nationality_husband">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Nationality of the Husband</strong><span
                                    class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="nationality" id="nationality" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Indian" class="p-1">Indian</option>
                                    <option value="Foreigner">Foreigner</option>
                                    {{-- <option value="Others" class="p-1">Others</option> --}}

                                </select>

                            </div>
                            @error('nationality')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 displyay-none-fifty" id="other_nationality1">
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                    class="color-red-fourty-three">*</span></label>
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

                    <div class="col-md-2 displyay-none-fifty" id="nationality_wife1">
                        <div class="mb-3">
                            <label class="text-label form-label" id="nationality_woman_lable" for="nationality_wife"><strong>Nationality</strong><span
                                    class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="nationality_wife" id="nationality_wife" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Indian" class="p-1">Indian</option>
                                    <option value="Foreigner">Foreigner</option>
                                    {{-- <option value="Others" class="p-1">Others</option> --}}

                                </select>

                            </div>
                            @error('nationality_wife')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 displyay-none-fifty" id="other_nationality1_wife">
                        <div class="mb-3">
                            <label class="control-label"><strong>Country</strong><span
                                    class="color-red-fourty-three">*</span></label>
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


                    <div class="col-md-3 one selectt displyay-none-fifty" id="one_couple">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Husband Age</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="age_hus_wife" id="age_hus_wife" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=21;$i<=55;$i++){
                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>'; 

                                   
                                    }
                                        ?>


                                </select>
                            </div>
                            @error('age_hus_wife')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-3 one selectt displyay-none-fifty" id="one_couple">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Wife Age
                                </strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="wife_age" id="wife_age" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=21;$i<=50;$i++){
                                        
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
                    <div class="col-md-3 two selectt displyay-none-fifty" id="single">
                        <div class="mb-3">
                            <!-- <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age of Women
                                    [widow/divorcee]</strong></label> -->
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Age of Woman</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="age_of_women" id="age_of_women" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select
                                                Age</b></strong>
                                    </option>
                                    <?php for($i=21;$i<=50;$i++){
                                        
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

                    <div class="border p-3 rounded">
                        <label class="form-label mb-3 d-block">
                            <strong>Cause of Infertility</strong> <span class="color-red-fourty-three">*</span>
                        </label>

                        <div class="row">
                            <!-- Male Factor -->
                            <div class="col-md-2" id="male_factor_div">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2" type="checkbox" id="male_factor" name="male_factor" value="Y">
                                    <label class="form-check-label" for="male_factor">
                                        <strong>Male Factor</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Female Factor -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2" type="checkbox" id="female_factor" name="female_factor" value="Y">
                                    <label class="form-check-label" for="female_factor">
                                        <strong>Female Factor</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Unexplained -->
                            <div class="col-md-2">
                                <div class="form-check mb-2 d-flex align-items-center justify-content-center">
                                    <input class="form-check-input me-2" type="checkbox" id="unexplained" name="unexplained" value="Y">
                                    <label class="form-check-label" for="unexplained">
                                        <strong>Unexplained</strong>
                                    </label>
                                </div>
                            </div>

                            <!-- Description of Cause -->
                            <div class="col-md-12 mt-3">
                                <div class="input-group mt-2">
                                    <input type="text" 
                                        class="form-control cause_of_infretily_length" 
                                        name="cause_of_infretily" 
                                        id="cause_of_infretily" 
                                        aria-describedby="cause_of_infretily" 
                                        placeholder="Please describe the cause of infertility...">
                                </div>
                                @error('cause_of_infretily')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-4" id="other">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>ART Procedure Undertaken</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="art_proc_undertaken" id="art_proc_undertaken"
                                    class="form-control" aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong>Select</strong></option>
                                    <option value="artificial insemination" class="p-1">Artificial
                                        insemination
                                    </option>
                                    <!--option value="artificial insemination with donor semen"
                                        class="p-1">Artificial insemination with donor semen(AID)
                                    </option-->
                                    <option value="intra-uterine insemination(IUI)" class="p-1">
                                        Intra-uterine insemination(IUI)</option>
                                    <!--option value="intra-uterine insemination using donor semen"
                                        class="p-1">Intra-uterine insemination using donor
                                        semen(IUI-D)</option-->
                                    <option value="in vitro fertilization-embryo transfer" class="p-1">
                                        In vitro fertilization-embryo transfer(IVF-ET)
                                    </option>
                                    <option value="gamete intrafallopian tube transfer" class="p-1">
                                        Gamete intrafallopian tube transfer(GIFT)
                                    </option>
                                    <option value="Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)" class="p-1">
                                        Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)
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
                    </div>

                    <div class="col-md-4 displyay-none-fifty" id="others_id">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Others</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="art_undertaken_other"
                                    id="art_undertaken_other" aria-describedby="art_undertaken_other">
                            </div>
                            @error('art_undertaken_other')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Type of
                                    Treatment</strong><span class="color-red-fourty-three">*</span></label>
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

                                    <!-- <option value="Self IVF using own gametes" class="p-1">
                                        Self IVF using own gametes</option>
                                    <option value="Self IVF using donor gametes" class="p-1">
                                        Self IVF using donor gametes</option> -->

                                </select>
                            </div>
                            @error('types_of_treat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>

                    <div class="col-md-4 displyay-none-fifty" id="ivf_donor">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Type of Donation</strong><span class="color-red-fourty-three">*</span></label>
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
                    </div>

                    <div class="col-md-4" id="">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Total No. of Treatment Cycle(s) Undertaken
                                </strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="total_num_of_cyc" id="total_num_of_cyc" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <?php for($i=1;$i<=20;$i++){                                                        
                                        echo'<option value="'.$i.'">'.$i.'</option>';                                                    
                                        }
                                    ?>
                                </select>                              
                            </div>
                            @error('total_num_of_cyc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-4" id="no_cycles1">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>No. of Cycles Cancelled, if any
                                </strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="no_cycles" id="no_cycles" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <?php //for($i=0;$i<=20;$i++){                                                        
                                      //  echo'<option value="'.$i.'">'.$i.'</option>';                                                    
                                      //  }
                                    ?>
                                </select>
                                <!--input type="number" class="form-control" id="no_cycles"
                                    name="no_cycles" min="0" max="25"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                    aria-describedby="no_cycles"-->
                                <!--span id="$wife_age_id"
                                    class="color-red-fourty-three"><?php //if(isset($wife_age)){ echo $wife_age;} ?></span-->
                            </div>
                            @error('no_cycles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>              

                    <div class="col-md-7 displyay-none-fifty" id="fail_reason">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Cycle Cancellation reason</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cyc_canc_failure_reason"
                                    name="cyc_canc_failure_reason" data-label="Cycle Cancellation reason"
                                    aria-describedby="cyc_canc_failure_reason">

                                <!--textarea type="text" class="form-control"
                                    name="cyc_canc_failure_reason" id="cyc_canc_failure_reason"
                                    aria-describedby="cyc_canc_failure_reason" rows="2"></textarea-->
                            </div>
                            @error('cyc_canc_failure_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-4" id="">
                         <div class="mb-3">
                            <label class="text-label form-label" for=""><strong>Treatment
                                    Outcome</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select name="treat_outcomes" id="treat_outcomes" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <option value="Pregnant" class="p-1">Pregnant</option>
                                    <option value="Not Pregnant" class="p-1">Not Pregnant
                                    </option>
                                </select>
                            </div>
                            @error('treat_outcomes')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div>
                  {{-- <div class="col-md-3 displyay-none-fifty" id="preganancy_outcome1">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Pregnancy
                                    Outcome</strong><span class="color-red-fourty-three">*</span></label>
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
                    </div> --}}

                    

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

                    {{-- <div class="col-md-6 displyay-none-fifty" id="gender_child1">
                        <div class="row d-flex justify-content mt-4">
                            <div class="col-md-4" id="male_hide">
                                <div class="row">
                                    <div class="col-md-3 py-2">
                                        <div class="form-check custom-checkbox mb-3">
                                            <label class="form-check-label"
                                                for="customCheckBox1">Male</label>
                                        </div>
                                    </div>
                                    <div class="col md-7">
                                        <div class="input-group">
                                            <select name="male_number" id="male_number" class="form-control">
                                                @for ($i = 0; $i <= 5; $i++)
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
                                            <label class="form-check-label"
                                                for="customCheckBox1">Female</label>
                                        </div>
                                    </div>
                                    <div class="col md-7">
                                        <div class="input-group">
                                            <select name="female_number" id="female_number" class="form-control">
                                                @for ($i = 0; $i <= 5; $i++)
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

                    <div class="col-md-3 displyay-none-fifty" id="live_birth_open">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Live Birth Pregnancy
                                    Outcome</strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                                <select class="form-control" id="l_birth" name="l_birth" disabled>
                                    <option value="">Select</option>
                                    <option value="Singleton" id="Singleton1">
                                        Singleton
                                    </option>
                                    <option value="Twin">Twin</option>
                                    <option value="Higher Order">Higher Order</option>

                                </select>
                                <input type="hidden" name="l_birth" id="l_birth_hidden" value="">
                            </div>
                            @error('l_birth')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        </div>
                    </div> --}}

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
                                // $('#preganancy_outcome').on('change', function () {


                                // $("#l_birth").prop("selectedIndex", -1);
                                // let maleSection = $('#male_hide');
                                // let femaleSection = $('#female_hide');
                                // let maleCheckbox = $('#male_female');
                                // let femaleCheckbox = $('#male_female1');
                                // let maleHidden = $('#male_hidden');
                                // let femaleHidden = $('#female_hidden');
                                // let maleNumber = $('#male_number');
                                // let femaleNumber = $('#female_number');

                                // // Reset checkboxes and number dropdowns
                                // maleCheckbox.prop('checked', false);
                                // femaleCheckbox.prop('checked', false);
                                // maleHidden.hide();
                                // femaleHidden.hide();
                                // maleNumber.val(''); // Reset dropdown to "Select"
                                // femaleNumber.val('');
                                // });
                            });

            
                        // $('#male_female1').change(function() {
                        //     if ($(this).is(':checked')) {
                        //         $('#female_hidden').show();
                        //     } else {
                        //         $('#female_hidden').hide();
                        //     }
                        // });
                        // $('#l_birth').change(function() {
                        //     if ($(this).is(':checked')) {
                        //         $('#female_hidden').show();
                        //     } else {
                        //         $('#female_hidden').hide();
                        //     }
                        // });
                        // document.addEventListener('DOMContentLoaded', function () {
                        //     const maleSelect = document.getElementById('male_number');
                        //     const femaleSelect = document.getElementById('female_number');
                        //     const birthSelect = document.getElementById('l_birth');
                        //     const birthHidden = document.getElementById('l_birth_hidden');

                        //     function updateBirthType() {
                        //         const male = parseInt(maleSelect.value) || 0;
                        //         const female = parseInt(femaleSelect.value) || 0;
                        //         const total = male + female;
                        //         // Clear previous selection
                        //         birthSelect.selectedIndex = 0;

                        //         // Choose visible dropdown option
                        //         if (total > 2) {
                        //             birthSelect.value = 'Higher Order';
                        //             birthHidden.value = 'Higher Order';
                        //         } else if (total === 2) {
                        //             birthSelect.value = 'Twin';
                        //             birthHidden.value = 'Twin';
                        //         } else if (total === 1) {
                        //             birthSelect.value = 'Singleton';
                        //             birthHidden.value = 'Singleton';
                        //         } else {
                        //             birthSelect.value = '';
                        //             birthHidden.value = '';
                        //         }
                        //     }
                        //     maleSelect.addEventListener('change', updateBirthType);
                        //     femaleSelect.addEventListener('change', updateBirthType);
                        // });
                        

                       

                   </script>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Complications, if
                                    any</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" name="complicatoins_if_any"
                                    id="complicatoins_if_any" data-label="Complications"
                                    aria-describedby="complicatoins_if_any"></textarea>
                            </div>
                            <span id="comp_if_any_id"
                                class="color-red-fourty-three"><?php //if(isset($complicatoins_if_any)){ echo $complicatoins_if_any;} ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Remarks/ Any other relevant
                                    information</strong></label>
                            <div class="input-group">
                                <textarea class="form-control" col="5" rows="3" type="text"
                                    class="form-control" name="remark" id="remark" data-label="Remark"
                                    aria-describedby="remark"></textarea>
                            </div>
                            <span id=""
                                class="color-red-fourty-three"><?php // if(isset($remark)){ echo $remark;} ?></span>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <div class="mb-3" id="declaration_both">
                        <label class="text-label form-label"
                            for="validationCustomUsername"><strong>Required Affidavit/Undertaking** regarding
                                following to be taken on record for the patient:</strong></label>
                                <div class="col-12" id="declaration_hide">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                            id="declaration" name="declaration">
                                        <label class="form-check-label" for="gridCheck">
                                            Please click that affidavit/undertaking** has been taken on record from Oocyte Donor that she has not donated oocytes more than once in her life time.
                                        </label>
                                    </div>
                                </div>


                       
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="declaration1"
                                    name="declaration1">
                                <label class="form-check-label" for="gridCheck">
                                    Please click on undertaking that affidavit/undertaking** has been taken on record from the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple.
                                </label>
                            </div>
                        </div>
                            <label class="form-check-label" for="gridCheck">
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
                    <button type="submit" name="submit" value="continue" id="btnSubmit" class="btn me-2 bc-br-color-fourtyeight">Continue Next patient details</button>
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
    const clinicNameInput = document.getElementById('name_of_clinic');
    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            if (!validatesubmit()) {
                event.preventDefault();
            }
        });
    }
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            window.location.href = '{{ route("clinic.clinicForm_list") }}';
        });
    }
    if (clinicNameInput) {
        clinicNameInput.addEventListener('keypress', function(event) {
            const charCode = event.charCode;
            if (!((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123))) {
                event.preventDefault();
            }
        });
    }
});
$('#remark,#complicatoins_if_any,#cyc_canc_failure_reason').on('input', function() {
    var value = $(this).val();
    if (value.length > 500) {
        $(this).val(value.substring(0, 500));
        alert('Maximum 500 characters allowed for the ' + $(this).data('label') + '.');
    }
    });
</script>





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
  </style>
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
            wifeLabel.innerHTML = "<strong>Nationality of Wife</strong><span class='color-red-fourty-three'>*</span>";
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
    {{-- <script nonce="{{ $cspNonce }}">
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
    </script> --}}
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
        
        // if ((document.getElementById("treat_outcomes").value == "Pregnant") && (document.getElementById(
        //         "preganancy_outcome").value == "")) {
        //     alert("Pregnancy Outcome cannot be blank");
        //     document.getElementById("preganancy_outcome").focus();
        //     return false;
        // }       
        // const treat_outcomes = document.getElementById('treat_outcomes').value;
        // const preganancy_outcome = document.getElementById('preganancy_outcome').value;
        // const male_numberNumber = document.getElementById('male_number').value;
        // const female_number = document.getElementById('female_number').value;
                
        // if (
        //     treat_outcomes === "Pregnant" &&
        //     (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
        //     male_numberNumber === ""
        // ) {
        //     alert("Please select the number of male.");
        //     document.getElementById("male_number").focus();
        //     return false;
        // }

        // if (
        //     treat_outcomes === "Pregnant" &&
        //     (preganancy_outcome === "live birth" || preganancy_outcome === "Stillbirth") &&
        //     female_number === ""
        // ) {
        //     alert("Please select the number of female.");
        //     document.getElementById("female_number").focus();
        //     return false;
        // }
        // if ($("#preganancy_outcome").val() !== "live birth") {
        //     $("#l_birth_hidden").val('');
        // }
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
            
        // $('#treat_outcomes').on('change', function() {
        //     $("#preganancy_outcome").val('');
        //     $("#other_gender").val('');
        //     $("#gender_child").val('');
        //     $("#l_birth").val('');
            
        //     if (this.value == 'Not Pregnant') {
        //         $("#preganancy_outcome1").hide();
        //         $("#live_birth_open").hide();
        //         $("#gender_child1").hide();
        //         $("#other_gender_id").hide();
                
                
        //     }else if(this.value == ''){
        //         $("#preganancy_outcome1").hide();
        //         //$("#preganancy_outcome1").hide();
                
        //     }
        //      else {
        //         $("#preganancy_outcome1").show();
        //         //$("#preganancy_outcome1").hide();
                
        //     }
        // });
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
        {{-- // comment on 12-02-2025 --}}
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
        {{-- --end-- --}}
         {{--  <script nonce="{{ $cspNonce }}">
        $('#preganancy_outcome').on('change', function() {
            $("#l_birth").prop("selectedIndex", -1);
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
        </script> --}}
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
            </script>

@endsection
