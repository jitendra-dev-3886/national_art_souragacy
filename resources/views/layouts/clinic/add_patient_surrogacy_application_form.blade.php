@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .display-none-csp-clinic-one {
            display: none;
        }
        .color-red-fourty-three {
                    color: red;
        }
        .color-csp-clinic-two {
            color: red;
        }
        .color-red-fourty-three {
                    color: red;
        }

        .bc-br-color-csp-clinic-three {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
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

        .csp-readonlycolor {
            background-color: #e8eaec !important;
            /* light blue, change as needed */
            font-weight: bold;
            /* optional */
        }

        .indicator.active {
            background-color: #0d6efd;
        }

        .progress-bar {
            background-color: #0d6efd;
            ;
        }

        .surrogacy-form-1 {
            display: none;
        }

        .art_treatment {
            display: none;
        }
        .csp_visible {
            display: block;
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
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <h3 class="card-title mb-5 text-primary">Patient information form for Surrogacy Clinic</h3>
                    <form name="art_clin1" method="POST"
                        action="{{ route('clinic.patient_save_surrogacy_application_form') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($reporting_data)
                            <input type="hidden" name="report_id" value="{{ encrypt($reporting_data->id) }}">
                        @endif
                        <div class="row">
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
                                            <input type="text" name="year" id="year_s"
                                                value="{{ $available_years->first()->year }}"
                                                class="form-control csp-readonlycolor" readonly>
                                        @endif


                                        @if ($available_quarters->count() === 1)
                                            <input type="text" value="{{ $available_quarters->first()['description'] }}"
                                                class="form-control csp-readonlycolor" readonly>
                                            <input type="hidden" name="quarter" id="quater_s"
                                                value="{{ $available_quarters->first()['id'] }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Previous Treatment Radio -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-block">
                                        <strong>Had received treatment from us previously</strong>
                                    </label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="previous_treatment"
                                                id="previous_treatment_yes" value="Yes">
                                            <label class="form-check-label" for="previous_treatment_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="previous_treatment"
                                                id="previous_treatment_no" value="No" checked>
                                            <label class="form-check-label" for="previous_treatment_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <span id="bank_reg_numID" class="color-csp-clinic-two">
                                    </span>
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Clinic
                                            Registration Number</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->registration_no }}"
                                            class="form-control csp-readonlycolor" name="cli_reg_name" id="cli_reg_name"
                                            aria-describedby="cli_reg_name" placeholder="" data-validation="alphanumeric"
                                            data-validation-allowing="_" readonly>

                                    </div>
                                    <span id="clinic_level1_reg_numID" class="color-csp-clinic-two"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Name of the
                                            Clinic</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->name }}"
                                            class="form-control csp-readonlycolor" name="name_of_clinic" id="name_of_clinic"
                                            aria-describedby="name_of_clinic" placeholder="" readonly>
                                    </div>
                                    <span id="name_of_clinicID" class="color-csp-clinic-two"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 ">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Patient
                                            UHID</strong><span class="color-csp-clinic-two">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pati_uhid" id="pati_uhid"
                                            aria-describedby="patient_uhid" placeholder="" value="{{ old('pati_uhid', '') }}" maxlength="15" data-validation="alphanumeric">
                                    </div>
                                    <span id="availability"></span>
                                    @error('pati_uhid')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card-body">
                                <div class="col-md-5">
                                    <input type="radio" name="treatment_type" id="surrogacy"
                                        class="form-check-input mt-2" value="art_treatment" {{ old('treatment_type') == 'art_treatment' ? 'checked' : '' }}>
                                    <label for="art_treatment" class="m-2">ART Treatment</label>
                                    <input type="radio" name="treatment_type" id="surrogacy"
                                        class="form-check-input mt-2" value="surrogacy" {{ old('treatment_type') == 'surrogacy' ? 'checked' : '' }}>
                                    <label for="surrogacy" class="m-2">Surrogacy Treatment</label>
                                </div>
                                @error('treatment_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="{{ old('treatment_type') == 'surrogacy' ? '' : 'surrogacy-form-1' }} border p-3 rounded" id="surrogacy_form_section">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><span
                                                class="color-csp-clinic-two">*</span><strong> Case of
                                                :</strong></label>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="case_of"
                                                    id="flexRadioDefault1" value="one" {{ old('case_of') == 'one' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Couple
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="case_of"
                                                    id="flexRadioDefault2" value="two" {{ old('case_of') == 'two' ? 'checked' : '' }}>
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
                                <div class="row">
                                    <div class="col-md-2 display-none-csp-clinic-one" id="nationality_husband">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Nationality of
                                                    Husband</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="nationality" id="nationality" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Indian" class="p-1"  {{ old('nationality', $data->nationality ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="OCI Card Holders" {{ old('nationality', $data->nationality ?? '') == 'OCI Card Holders' ? 'selected' : '' }}>OCI Card Holders</option>
                                                </select>

                                            </div>
                                            @error('nationality')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 {{ old('nationality', $data->nationality ?? '') == 'OCI Card Holders' ? 'csp_visible' : 'display-none-csp-clinic-one' }} " id="other_nationality1">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Country</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="other_nationality" id="other_nationality"
                                                    class="form-control">
                                                    <option value="">-- Select Country --</option>
                                                    @if ($countries->count() > 0)
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}" {{ old('other_nationality', $data->other_nationality ?? '') == $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No Countries Available</option>
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                        @error('other_nationality')
                                                <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                     


                                    <div class="col-md-2" id="nationality_wife1">
                                        <div class="mb-3">
                                            <label class="text-label form-label" id="nationality_woman_lable"
                                                for="nationality_wife"><strong>Nationality</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <input type="hidden" name="nationality_wife_hidden" id="nationality_wife_hidden" value="{{ old('nationality_wife') }}">
                                                <select name="nationality_wife" id="nationality_wife"
                                                    class="form-control" aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Indian" class="p-1" {{ old('nationality_wife', $data->nationality_wife ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="OCI Card Holders" {{ old('nationality_wife', $data->nationality_wife ?? '') == 'OCI Card Holders' ? 'selected' : '' }}>OCI Card Holders</option>
                                                </select>
                                                
                                            </div>
                                            @error('nationality_wife')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 {{ old('nationality_wife', $data->nationality_wife ?? '') == 'OCI Card Holders' ? 'csp_visible' : 'display-none-csp-clinic-one' }}" id="other_nationality1_wife">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Country</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="other_nationality_wife" id="other_nationality_wife" class="form-control">
                                                    <option value="">-- Select Country --</option>
                                                    @if ($countries->count() > 0)
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}" {{ old('other_nationality_wife', $data->other_nationality_wife ?? '')  == $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No Countries Available</option>
                                                    @endif
                                                </select>
                                            </div>
                                            @error('other_nationality_wife')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                    </div>



                                    <div class="col-md-3 one selectt {{ old('case_of') == 'one' ? '' : 'display-none-csp-clinic-one' }}" id="one_couple">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Husband Age</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="age" id="age" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 26; $i <= 55; $i++) {
                                                        echo '<option value="' . $i . '" ' . (old('age') == $i ? 'selected' : '') . '>' . $i . '</option>';
                                                    }
                                                    ?>


                                                </select>
                                            </div>
                                            @error('age')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 one selectt {{ old('case_of') == 'one' ? '' : 'display-none-csp-clinic-one' }}" id="one couple">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Wife Age
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="wife_age" id="wife_age" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 23; $i <= 50; $i++) {
                                                        echo '<option value="' . $i . '"' . (old('wife_age') == $i ? 'selected' : '') . '>' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            @error('wife_age')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-3 two selectt {{ old('case_of') == 'two' ? '' : 'display-none-csp-clinic-one' }}" id="single">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Age of Woman</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="age_of_women" id="age_of_women" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 35; $i <= 45; $i++) {
                                                        echo '<option value="' . $i . '"' . (old('age_of_women') == $i ? 'selected' : '') . '>' . $i . '</option>';
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
                                                    Child</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="num_pre_child" id="num_pre_child" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Yes" {{ old('num_pre_child') == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No" {{ old('num_pre_child') == 'No' ? 'selected' : '' }}>
                                                        No</option>

                                                </select>
                                            </div>
                                            @error('num_pre_child')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-3 {{ old('num_pre_child') == 'Yes' ? '' : 'display-none-csp-clinic-one' }}" id="num_per_child_details">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Details of
                                                    Child</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="child_give_details" id="give_details" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Mentally Challenged" {{ old('child_give_details') == 'Mentally Challenged' ? 'selected' : '' }}>
                                                        Mentally Challenged</option>
                                                    <option value="Physically Challenged" {{ old('child_give_details') == 'Physically Challenged' ? 'selected' : '' }}>
                                                        Physically Challenged</option>
                                                    <option value="Life Threatening Disorder" {{ old('child_give_details') == 'Life Threatening Disorder' ? 'selected' : '' }}>
                                                        Life Threatening Disorder</option>

                                                </select>
                                            </div>
                                            @error('child_give_details')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="row col-md-6 {{ old('num_pre_child') == 'Yes' ? '' : 'display-none-csp-clinic-one' }}" id="medical_open">
                                        <div class="col-md-6 {{ old('num_pre_child') == 'Yes' ? '' : 'display-none-csp-clinic-one' }}" id="child_medical_open">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>Medical Certificate of
                                                        Child issued by District Medical Board
                                                    </strong><span class="color-csp-clinic-two">*</span></label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control"
                                                        id="child_medical_certificate"
                                                        name="surrogacypatient_child_medicalcertificate_docs"
                                                        aria-describedby="child_medical_certificate1">
                                                    <button type="button" class="btn btn-danger"
                                                        id="removeFileButtonchild">Remove</button>
                                                </div>
                                                <ul><strong>Note:- </strong>
                                                    <li>File Type: PDF or JPG Format only and File Size: 50 to 200
                                                        kb.
                                                    </li>
                                                    <!--li>File Size: 50 to 200 kb.</li-->
                                                </ul>
                                            </div>
                                            @error('surrogacypatient_child_medicalcertificate_docs')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="border p-3 rounded">
                                        <label class="form-label mb-3 d-block">
                                            <strong>Medical Indication Necessitating Surrogacy</strong><span
                                                class="color-csp-clinic-two">*</span>
                                        </label>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div
                                                    class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="uterus_ab"
                                                        name="uterus_ab" value="Y" {{ old('uterus_ab') == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="uterus_ab">
                                                        <strong>Uterus Abnormalities</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="ivf_failure"
                                                        name="ivf_failure" value="Y" {{ old('ivf_failure') == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="ivf_failure">
                                                        <strong>Repeated IVF failure or Recurrent implantation
                                                            failure</strong>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="preg_loss"
                                                        name="preg_loss" value="Y" {{ old('preg_loss') == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="preg_loss">
                                                        <strong>Multiple Pregnancy Loss</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="life_threat"
                                                        name="life_threat" value="Y" {{ old('life_threat') == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="life_threat">
                                                        <strong>Life threatening illness</strong>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Male Factor -->
                                            <div class="col-md-2" id="male_factor_div">
                                                <div
                                                    class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="male_factor"
                                                        name="male_factor" value="Y" {{ old('male_factor') == 'Y' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="male_factor">
                                                        <strong>Male Factor</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Description of Cause -->
                                            <div class="col-md-12 mt-3">
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control medical_surrogacy_length" id="medical_surrogacy"
                                                        name="medical_surrogacy" aria-describedby="medical_surrogacy"
                                                        placeholder="Please describe the Medical indication..." value="{{ old('medical_surrogacy') }}">
                                                </div>
                                                @error('medical_surrogacy')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror   
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Upload Certificate of
                                                    Medical
                                                    Indication issued by District Medical Board
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" id="medical_certificate"
                                                    name="surrogacypatient_medicalcertificate_docs"
                                                    aria-describedby="medical_surrogacy1">
                                                <button type="button" class="btn btn-danger"
                                                    id="removeFileButton">Remove</button>
                                            </div>
                                            <!--span id="medical_surrogacy_id"
                                                                                                                            class="color-csp-clinic-two"><?php //if(isset($medical_surrogacy)){ echo $medical_surrogacy;}
                                                                                                                            ?></span-->
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
                                                    Treatment</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="types_of_treat" id="types_of_treat" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted" id="typeOfTreat1">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Surrogacy using self gametes" id="own_gametes"
                                                        class="p-1" {{ old('types_of_treat') == 'Surrogacy using self gametes' ? 'selected' : '' }}>
                                                        Surrogacy using self gametes</option>
                                                    <option value="Surrogacy using donor gametes" id="d_gametes"
                                                        class="p-1" {{ old('types_of_treat') == 'Surrogacy using donor gametes' ? 'selected' : '' }}>
                                                        Surrogacy using donor gametes</option>

                                                </select>
                                            </div>
                                            @error('types_of_treat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-4 {{ old('types_of_treat') === 'Surrogacy using self gametes' ? 'surrogacy-form-1' : 'csp_visible' }}" id="ivf_donor">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Gamete Source</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="types_of_treat1" id="types_of_treat1" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" id="tot1" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Self Oocyte & Donor Sperm" id="d_sperm"
                                                        class="p-1" {{ old('types_of_treat1') == 'Self Oocyte & Donor Sperm' ? 'selected' : '' }}>
                                                        Self Oocyte &
                                                        Donor Sperm
                                                    </option>
                                                    <option value="Donor Oocyte & Self Sperm" id="o_sperm"
                                                        class="p-1" {{ old('types_of_treat1') == 'Donor Oocyte & Self Sperm' ? 'selected' : '' }}>
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
                                                    <?php for ($i = 25; $i <= 35; $i++) {
                                                        echo '<option value="' . $i . '" ' . (old('surrogate_mother_age') == $i ? 'selected' : '') . '>' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
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
                                                    <option value="In Vitro Fertilization-Embryo Transfer(IVF-ET)" {{ old('art_undertaken') == 'In Vitro Fertilization-Embryo Transfer(IVF-ET)' ? 'selected' : '' }}>
                                                        In
                                                        Vitro Fertilization-Embryo Transfer(IVF-ET)</option>
                                                    <option value="Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)" {{ old('art_undertaken') == 'Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)' ? 'selected' : '' }}>
                                                        Intra-cytoplasmic sperm injection-Embryo transfer(ICSI-ET)</option>
                                                    <option value="Others" {{ old('art_undertaken') == 'Others' ? 'selected' : '' }}>Others</option>
                                                </select>
                                            </div>
                                            @error('art_undertaken')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 display-none-csp-clinic-one" id="others_id">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Others</strong></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="art_undertaken_other"
                                                    name="art_undertaken_other" aria-describedby="art_undertaken_other" value="{{ old('art_undertaken_other') }}">
                                            </div>
                                            @error('art_undertaken_other')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Total No. of Treatment
                                                    Cycle(s) Undertaken
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="total_nun_cycles" id="total_nun_cycles"
                                                    class="form-control" aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <?php for ($i = 1; $i <= 20; $i++) {
                                                        echo '<option value="' . $i . '" ' . (old('total_nun_cycles') == $i ? 'selected' : '') . '>' . $i . '</option>';
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
                                                for="validationCustomUsername"><strong>No. of Cycles
                                                    Cancelled, if any
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <input type="hidden" id="no_cycles_hidden" value="{{ old('no_cycles') }}">
                                                <select name="no_cycles" id="no_cycles" class="form-control"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                </select>
                                            </div>
                                            @error('no_cycles')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-7 display-none-csp-clinic-one" id="fail_reason">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Cycle Cancellation
                                                    reason</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="Cycle_fail_reason" data-label="Cycle Cancellation reason"
                                                    name="Cycle_fail_reason" aria-describedby="Cycle_fail_reason" value="{{ old('Cycle_fail_reason') }}">

                                            </div>
                                            @error('Cycle_fail_reason')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-md-4" id="">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Treatment Outcome</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control" id="tratment_Outcome"
                                                    name="tratment_Outcome">
                                                    <option value="">Select</option>
                                                    <option value="Pregnant" {{ old('tratment_Outcome') == 'Pregnant' ? 'selected' : '' }}>Pregnant</option>
                                                    <option value="Not Pregnant" {{ old('tratment_Outcome') == 'Not Pregnant' ? 'selected' : '' }}>Not Pregnant</option>
                                                </select>
                                            </div>
                                            @error('tratment_Outcome')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Complications, If
                                                    any</strong></label>
                                            <div class="input-group">
                                                <textarea class="form-control" col="5" rows="3" name="comp_if_any" id="complicatoins_if_any" data-label="Complications">{{ old('comp_if_any') }}</textarea>
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
                                                <textarea class="form-control" col="5" rows="3" name="remark" id="remark" data-label="Remark">{{ old('remark') }}</textarea>
                                            </div>
                                            @error('remark')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>
                                            Required affidavit/undertaking** regarding following to be taken on record for the patient</strong></label>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration"
                                                name="declaration" {{ old('declaration') == 'on' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck">
                                                From Surrogate mother that she has not acted as a surrogate mother
                                                more than once in her lifetime.<span class="color-csp-clinic-two">*</span>
                                            </label>
                                        </div>
                                         @error('declaration')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="col-12" id="declaration2_div">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration1"
                                                name="declaration1" {{ old('declaration1') == 'on' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck">
                                                From intending couple or single woman (widow or divorcee) that they/she do/does not 
                                                have any surviving child biologically or through adoption or through surrogacy earlier .
                                            </label>

                                        </div>
                                        @error('declaration1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>

                                    <div class="col-12" id="declaration3_div">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration3"
                                                name="declaration3" {{ old('declaration3') == 'on' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck">
                                                From Oocyte Donor that she has not donated oocytes more than once in her life time.
                                            </label>
                                        </div>
                                        @error('declaration3') 
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="col-12" id="declaration4_div">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration4"
                                                name="declaration4" {{ old('declaration4') == 'on' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck">
                                                From the ART Bank that the bank has not supplied sperm/oocyte of the same 
                                                donor to more than one commissioning couple/single woman or clinic and clinic has 
                                                not used the sperm/oocyte of the same donor for more than one commissioning couple.
                                            </label>
                                        </div>
                                        @error('declaration4')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>
                                            **Note: Undertaking will be taken in retrospective cases where affidavit is not available 
                                            and the case is prior to the operationalization of the portal. i.e., for period 25.01.2022 till 20.05.2026. 
                                            However, clinics must obtain notarized affidavit for all prospective cases after the operationalization 
                                            of the portal</strong>
                                        </label>
                                </div>
                            </div>


                            {{-- =======================================================Art Treatment Start==================================================================================== --}}
                            <div class="{{ old('treatment_type') == 'art_treatment' ? '' : 'art_treatment' }} border p-3 rounded" id="art_treatment_form_section">
                                @include('layouts.clinic.add_patient_surrogacy_application_form_art_treatment')
                            </div>
                            {{-- =================================================================ART Treatment End====================================================================================== --}}
                        </div>
                        <button type="submit" name="submit" value="continue" id="btnSubmit"
                            class="btn me-2 bc-br-color-csp-clinic-three">Continue Next patient details</button>
                        <button type="button" id="closeButton" class="btn me-2 btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script nonce="{{ $cspNonce }}" src="{{ url('public/js/add_patient_surrogacy_application_form_part_2.js')}}"></script>
    <script nonce="{{ $cspNonce }}">
        // new updation in the form 
        document.addEventListener("DOMContentLoaded", function() {

            const radios = document.querySelectorAll('input[name="treatment_type"]');
            const surrogacy_form = document.getElementById("surrogacy_form_section");
            const art_treatment_form = document.getElementById("art_treatment_form_section");

            radios.forEach(radio => {
                radio.addEventListener("change", function() {

                    resetFormvalue(surrogacy_form, this.value === "surrogacy");
                    resetFormvalue(art_treatment_form, this.value === "art_treatment");
                });
            });

            function resetFormvalue(form, show) {
                form.style.display = show ? "block" : "none";
                const inputs = form.querySelectorAll("input, select, textarea");
                inputs.forEach(input => {
                    if (input.type === "radio" || input.type === "checkbox") {
                        input.checked = false;
                    } else {
                        input.value = "";
                    }
                });
            }
        });
        $('#remark,#complicatoins_if_any,#Cycle_fail_reason').on('input', function() {
        var value = $(this).val();
        if (value.length > 500) {
            $(this).val(value.substring(0, 500));
            alert('Maximum 500 characters allowed for the ' + $(this).data('label') + '.');
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
                $('#other_nationality option').filter(function() {
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
                $('#other_nationality_wife option').filter(function() {
                    return $(this).text().trim() === 'India';
                }).remove();
            } else {
                $("#other_nationality1_wife").hide();
                $('#other_nationality_wife').val('');
            }
        });
        $('.medical_surrogacy_length').on('input', function() {
			var value = $(this).val();

			if (value.length > 250) {
				$(this).val(value.substring(0, 250));
					alert('Maximum 250 characters allowed for the Medical indication.');
				
			}
		});
    </script>
    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {
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
            const nationalitySelect = document.getElementById("nationality_wife");
            let nationality_wife_hidden = document.getElementById("nationality_wife_hidden");

            let declaration3_div = document.getElementById("declaration3_div");
            let declaration4_div = document.getElementById("declaration4_div");

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
                    wifeLabel.innerHTML = "<strong>Nationality of wife</strong><span class='color-csp-clinic-two'>*</span>";
                    declaration3_div.style.display = "block";
                    declaration4_div.style.display = "block";
                    
                } else if (singleWomanRadio.checked) {
                    nationalityHusband.style.display = "none";
                    nationalityWife.style.display = "block";
                    maleFactorDive.style.display = "none";
                    maleFactorDive.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(
                        input => {
                            input.checked = false;
                        });
                    wifeLabel.innerHTML = "<strong>Nationality</strong><span class='color-csp-clinic-two'>*</span>";
                    nationalitySelect.innerHTML = `
                        <option value="" class="text-muted"><strong>Select</strong></option>
                        <option value="Indian" class="p-1" ${nationality_wife_hidden.value === 'Indian' ? 'selected' : ''}>${nationality_wife_hidden.value}</option> `;

                        declaration3_div.style.display = "none";
                      document.getElementById('declaration3').checked = false;

                }
                // Reset and hide country fields when changing the main radio button
                resetCountryFields();
            }

            function toggleCountryFields() {
                otherNationalityHusband.style.display = nationalityHusbandSelect.value === "OCI Card Holders" ?
                    "block" : "none";
                otherNationalityWife.style.display = nationalityWifeSelect.value === "OCI Card Holders" ? "block" :
                    "none";
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
                $('#declaration2_div').hide();

                // child_medical_open
            } else {
                $("#medical_open").hide();
                $("#child_medical_open").hide();
                $('#declaration2_div').show();
                $('#declaration1').prop('checked', false);
            }
        });
    </script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#total_nun_cycles').change(function() {
                var selectedNumber = $(this).val();
                var no_cycles_hidden = $('#no_cycles_hidden').val();
                //alert(selectedNumber);
                var optionSelect = $('#no_cycles');
                // alert(optionSelect);
                optionSelect.empty(); // Clear previous options
                optionSelect.append('<option value="">Select</option>');
                for (var i = 0; i <= selectedNumber; i++) {
                    // let selected = (no_cycles_hidden == i) ? 'selected' : '';
                    // optionSelect.append('<option value="' + i + '" ' + selected + '>' + i + '</option>');
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
            if (optionSelect == selectedNumber) {

                //  alert('done');

                $('#tratment_Outcome').html('<option value="Not Pregnant">Not Pregnant</option>');

            } else {
                $('#tratment_Outcome').html(
                    '<option value="">Select</option><option value="Pregnant">Pregnant</option><option value="Not Pregnant">Not Pregnant</option>'
                );

                //   //  alert('not done');
            }
        });
    </script>


    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {
            let radioSingleWoman = document.getElementById("flexRadioDefault2");
            let nationalityDiv = document.getElementById("nationality_wife1");
            let nationalitySelect = document.getElementById("nationality_wife");
            let nationalityHusband = document.getElementById("nationality_husband");
            let nationalityWife = document.getElementById("nationality_wife1");
            let otherNationalityHusband = document.getElementById("other_nationality1");
            let otherNationalityWife = document.getElementById("other_nationality1_wife");
            let typesofTreatment = document.getElementById("types_of_treat");
            let gametSource = document.getElementById("types_of_treat1");



            document.querySelectorAll('input[name="case_of"]').forEach(function(radio) {
                radio.addEventListener("change", function() {
                    const womanlabel = document.getElementById('nationality_woman_lable');
                    if (radioSingleWoman.checked) {
                        nationalityDiv.style.display = "block";
                        // Remove all options
                        nationalitySelect.innerHTML = `
                        <option value="" class="text-muted"><strong>Select</strong></option>
                        <option value="Indian" class="p-1">Indian</option> `;
                        womanlabel.innerHTML = ` <strong>Nationality</strong><span class="color-csp-clinic-two">*</span> `;
                        otherNationalityHusband.style.display = 'none';
                        document.getElementById("other_nationality").value = '';
                        otherNationalityWife.style.display = 'none';
                        document.getElementById("other_nationality_wife").value = '';
                        nationalityHusband.style.display = 'none';
                        document.getElementById("nationality").value = '';
                        typesofTreatment.innerHTML =
                            '<option value="Surrogacy using donor gametes">Surrogacy using donor gametes</option>';
                        gametSource.innerHTML =
                            '<option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">Self Oocyte & Donor Sperm </option>';


                    } else {
                        nationalityDiv.style.display = "block";
                        womanlabel.innerHTML = `<strong>Nationlity of wife</strong><span
                                    class="color-csp-clinic-two">*</span> `;

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
    <style nonce="{{ $cspNonce }}">
        input.select2-search__field {
            width: 150px !important;
        }
    </style>

    <script nonce="{{ $cspNonce }}">
        $('#types_of_treat').on('change', function() {
            $("#types_of_treat1").val('');
            if (this.value == 'Surrogacy using donor gametes') {
                $("#ivf_donor").show();
                $('#declaration3_div').show();
                $('#declaration4_div').show();
            } else {
                $("#ivf_donor").hide();
                $('#declaration3_div').hide();
                $('#declaration4_div').hide();
                $('#declaration3').prop('checked', false);
                $('#declaration4').prop('checked', false);
            }
        });
        $('#types_of_treat1').on('change', function() {
            if (this.value == 'Donor Oocyte & Self Sperm') {
                $('#declaration3_div').show();
            } else {
                $('#declaration3_div').hide();
                $('#declaration3').prop('checked', false);
            }
        });
    </script>

    {{-- <script nonce="{{ $cspNonce }}">
        // 16-07-2024
        $('#types_of_treat').on('change', function() {
            $("#types_of_treat1").val('');
            if (this.value == 'Surrogacy using self gametes') {
                $("#ivf_donor").hide();
                $('#declaration3_div').hide();
                $('#declaration4_div').hide();
                $('#declaration3').prop('checked', false);
                $('#declaration4').prop('checked', false);
            } else {
                // 10-07-2024
                // $("#ivf_donor").hide();
            }
        });
    </script> --}}
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
        });
    </script>
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
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('btnSubmit');
            const closeButton = document.getElementById('closeButton');
            const fileInputChild = document.getElementById('child_medical_certificate');
            const fileInput = document.getElementById('medical_certificate');
            const removeButtonChild = document.getElementById('removeFileButtonchild');
            const removeButton = document.getElementById('removeFileButton');
            const radioscheck = document.querySelectorAll('input[name="treatment_type"]');
            let checkedValue = "";
                radioscheck.forEach(radio => {
                    radio.addEventListener("change", function() {
                        checkedValue = this.value;
                    });
                });

            if (submitButton) {

                submitButton.addEventListener('click', function(event) {

                    if (!checkedValue) {
                        if (!validatinitialcheck()) {
                            event.preventDefault();
                            return true;
                        }
                        
                    }
             
                    if (checkedValue === "surrogacy") {
                        if (!validatesubmit()) {
                            event.preventDefault();
                            return true;
                        }
                        
                    } if(checkedValue === "art_treatment"){
                        
                        if (!validationarttreat()) {
                            event.preventDefault();
                            return true;
                        }
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

        function validatinitialcheck(){
            if (document.getElementById("pati_uhid").value == "") {
                    alert("Patient UHID cannot be blank");
                    document.getElementById("pati_uhid").focus();
                    return false;
                }
            let selectedValueChecked = document.querySelector('input[name="treatment_type"]:checked');
            if (!selectedValueChecked) {
                    alert("Treatment type cannot be blank");
                    document.getElementById("surrogacy").focus();
                    return false;
                }
            }

        function validatesubmit() {
        
            if (document.getElementById("pati_uhid").value == "") {
                    alert("Patient UHID cannot be blank");
                    document.getElementById("pati_uhid").focus();
                    return false;
                }
            let selectedValueChecked = document.querySelector('input[name="treatment_type"]:checked');
            if (!selectedValueChecked) {
                    alert("Treatment type cannot be blank");
                    document.getElementById("surrogacy").focus();
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
            if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "") {
                alert("Nationality of Husband cannot be blank");
                document.getElementById("nationality").focus();
                return false;
            }
            if ($('#flexRadioDefault1').is(':checked') && $('#nationality').val() == "OCI Card Holders" && $(
                    '#other_nationality').val() == "") {
                alert("Please specify Country of the husband.");
                document.getElementById("other_nationality").focus();
                return false;
            }
            if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "") {
                alert("Nationality of wife cannot be blank");
                document.getElementById("nationality_wife").focus();
                return false;
            }
            if ($('#flexRadioDefault1').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $(
                    '#other_nationality_wife').val() == "") {
                alert("Please specify Country of the wife");
                document.getElementById("other_nationality_wife").focus();
                return false;
            }
            if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "") {
                alert("Nationality of the woman cannot be blank");
                document.getElementById("nationality_wife").focus();
                return false;
            }
            if ($('#flexRadioDefault2').is(':checked') && $('#nationality_wife').val() == "OCI Card Holders" && $(
                    '#other_nationality_wife').val() == "") {
                alert("Please specify Country of the woman");
                document.getElementById("other_nationality_wife").focus();
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
            if ($('#flexRadioDefault2').is(':checked') && $('#age_of_women').val() == "") {
                alert("Please Select Age of woman (widow or divorcee)");
                document.getElementById("age_of_women").focus();
                return false;
            }
            if (document.getElementById("num_pre_child").value == "") {
                alert("Having Surviving Child cannot be blank");
                document.getElementById("num_pre_child").focus();
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
                alert("Upload the Medical Certificate of child issued by District Medical Board");
                document.getElementById("child_medical_certificate").focus();
                return false;
            }


            let male = document.getElementById("male_factor").checked;
            let uterus_ab = document.getElementById("uterus_ab").checked;
            let ivf_failure = document.getElementById("ivf_failure").checked;
            let preg_loss = document.getElementById("preg_loss").checked;
            let life_threat = document.getElementById("life_threat").checked;
            if (!male && !uterus_ab && !ivf_failure && !preg_loss && !life_threat) {
                alert("Please select at least one option for medical indication.");
                return false;
            }
            if (document.getElementById("medical_surrogacy").value == "") {
                alert("Description of Medical indication Necessitating Surrogacy cannot be blank");
                document.getElementById("medical_surrogacy").focus();
                return false;
            }


            if (document.getElementById("medical_certificate").value == "") {
                alert("Upload Certificate of Medical Indication issued by District Medical Board");
                document.getElementById("medical_certificate").focus();
                return false;
            }
            if (document.getElementById("medical_surrogacy").value == "") {
                alert("Medical Condition Necessitating Surrogacy cannot be blank");
                document.getElementById("medical_surrogacy").focus();
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
                alert("No. of Cycles Cancelled cannot be blank");
                document.getElementById("no_cycles").focus();
                return false;
            }

            if ((document.getElementById("no_cycles").value > 0) && (document.getElementById(
                    "Cycle_fail_reason").value == "")) {
                alert("Please specify reason for Cycle Cancellation");
                document.getElementById("Cycle_fail_reason").focus();
                return false;
            }


            if (document.getElementById("tratment_Outcome").value == "") {
                alert("Treatment Outcome cannot be blank");
                document.getElementById("tratment_Outcome").focus();
                return false;
            }

            if (!document.getElementById("declaration").checked) {
                alert(
                    "Please click on Undertaking that Affidavit/undertaking** has been taken on record From Surrogate mother that she has not acted as a surrogate mother more than once in her lifetime."
                );
                document.getElementById("declaration").focus();
                return false;
            }
            if ((document.getElementById("num_pre_child").value == "No") && (!document.getElementById("declaration1")
                    .checked)) {
                alert(
                    "Please click on Undertaking that Affidavit/undertaking** has been taken on record From intending couple or single woman (widow or divorcee) that they/she do/does not have any surviving child biologically or through adoption or through surrogacy earlier ."
                );
                document.getElementById("declaration1").focus();
                return false;
            }
            if((document.getElementById("types_of_treat").value)=== "Surrogacy using donor gametes"){

            
                if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document
                        .getElementById("declaration3")
                        .checked)) {
                    alert(
                        "Please click on Undertaking that Affidavit/undertaking** has been taken on record From Oocyte Donor that she has not donated oocytes more than once in her life time."
                    );
                    document.getElementById("declaration3").focus();
                    return false;
                }
                if ((document.getElementById("types_of_treat1").value == "Donor Oocyte & Self Sperm") && (!document
                        .getElementById("declaration4")
                        .checked)) {
                    alert(
                        "Please Click on Undertaking that Affidavit/undertaking** has been taken on record From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple."
                    );

                    document.getElementById("declaration4").focus();
                    return false;
                }
                if ((document.getElementById("types_of_treat1").value == "Self Oocyte & Donor Sperm") && (!document
                        .getElementById("declaration4")
                        .checked)) {
                    alert(
                        "Please Click on Undertaking that Affidavit/undertaking** has been taken on record From the ART Bank that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic and clinic has not used the sperm/oocyte of the same donor for more than one commissioning couple."
                    );
                    document.getElementById("declaration4").focus();
                    return false;
                }
            }

            const patient_uhid = document.getElementById("pati_uhid").value;

            var agree = confirm(
                "Kindly check & confirm all details for UHID-" + patient_uhid +
                " before continuing next patient details.After submission Patient details can be modified using view / edit option."
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
                $('#male_factor').val('N');
                $('#age').val('');
                $('#wife_age').val('');
            } else {
                $('#age_of_women').val('');
            }
        });

        $('#flexRadioDefault1').on('click', function() {

            if ($('#flexRadioDefault1').is(':checked')) {

                $('#types_of_treat').html(
                    '<option value="" class="text-muted" id="typeOfTreat1"><strong><b>Select</b></strong></option><option value="Surrogacy using self gametes" id="own_gametes" class="p-1">Surrogacy using self gametes</option><option value="Surrogacy using donor gametes" id="d_gametes" class="p-1">Surrogacy using donor gametes</option>'
                );
                $('#types_of_treat1').html(
                    '<option value="" id="tot1" class="text-muted"><strong><b>Select</b></strong></option><option value="Self Oocyte & Donor Sperm" id="d_sperm" class="p-1">Self Oocyte & Donor Sperm </option><option value="Donor Oocyte & Self Sperm" id="o_sperm" class="p-1">Donor Oocyte & Self Sperm</option>'
                );


                $('#age_of_women').val('');
                $('#age').val('');
                $('#wife_age').val('');
            } else {
                $('#age').val('');
                $('#wife_age').val('');
            }
        });
    </script>

    <script nonce="{{ $cspNonce }}">
        function checkUHID() {
            var pati_uhid = $('#pati_uhid').val();
            var yy = $('#year_s').val();
            var qq = $('#quater_s').val();
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
                    year_: yy,
                    quarter_: qq,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'exists') {
                        if (treatmentStatus === "Yes") {
                            // Always disable false
                            $('#availability').html('<span class="text-success">UHID Found for this Surrogacy clinic.</span>');
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
                                '<span class="text-danger">UHID does not exist for this Surrogacy clinic. Kindly enter correct UHID.</span>'
                            );
                            $('#btnSubmit').attr("disabled", true);
                    } else {
                            $('#availability').html('');
                            $('#btnSubmit').attr("disabled", false);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Run when donor_id input loses focus
        $(document).on('blur', '#pati_uhid', function() {
            checkUHID();
        });

        // Run when previous treatment radio is changed
        $(document).on('change', 'input[name="previous_treatment"]', function() {
            checkUHID();
        });
        // Run when donor_id input loses focus
        $(document).on('blur', '#pati_uhid', function() {
            checkUHID();
        });

        // Run when previous treatment radio is changed
        $(document).on('change', 'input[name="previous_treatment"]', function() {
            checkUHID();
        });
    </script>

@endsection
