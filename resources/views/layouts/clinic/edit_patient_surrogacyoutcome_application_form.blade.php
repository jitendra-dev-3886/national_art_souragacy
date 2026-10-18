@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .display-none-csp-clinic-one {
            display: none;
        }

        .color-csp-clinic-two {
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
                @if (session('upd_error'))
                <div class="alert alert-danger">
                {{ session('upd_error') }}
                </div>
                @endif
                    {{-- <h3 class="card-title mb-5 text-primary">Patient information form for Surrogacy Clinic</h3>
                    <form name="art_clin1" method="POST"
                        action="{{ route('clinic.patient_save_surrogacy_application_form') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($reporting_data)
                            <input type="hidden" name="report_id" value="{{ $reporting_data->id }}">
                        @endif --}}


                    <h3 class="card-title mb-5 text-primary">Edit Patient information form for Surrogacy Clinic </h3>
                    <form name="art_clin1" method="POST" id="art_clin1"
                        action="{{ route('clinic.patient_save_part_two_application_form_patientSurrogacy',$uhidDetails->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($uhidDetails)
                            <input type="hidden" name="p_id" value="{{ $uhidDetails->id }}">
                        @endif
                        @if ($clinic_id)
                            <input type="hidden" name="clinic_id" value="{{ $clinic_id }}">
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
                                        <input type="hidden" class="form-control width-csp-clinic-one" name="quarter"
                                            value="{{ $uhidDetails->quarter }}" disabled>
                                        <input type="text" class="form-control width-csp-clinic-one csp-readonlycolor"
                                            name="year" value="{{ $uhidDetails->year }}" disabled>
                                            <input type="hidden"  name="enc_uhid" value="{{ encrypt($uhidDetails->pati_uhid) }}" readonly>
                                        <input type="text" class="form-control width-csp-clinic-one csp-readonlycolor"
                                            value="{{ $available_quarters['description'] ?? '' }}" disabled>

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
                                                id="previous_treatment_yes" value="Yes" disabled>
                                            <label class="form-check-label" for="previous_treatment_yes"> Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="previous_treatment"
                                                id="previous_treatment_no" value="No" disabled checked>
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
                                        <input type="text" value="{{ $uhidDetails->cli_reg_name }}"
                                            class="form-control csp-readonlycolor" name="cli_reg_name" id="cli_reg_name"
                                            aria-describedby="cli_reg_name" placeholder="" data-validation="alphanumeric"
                                            data-validation-allowing="_" disabled>

                                    </div>
                                    <span id="clinic_level1_reg_numID" class="color-csp-clinic-two"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Name of the
                                            Clinic</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $uhidDetails->name_of_clinic }}"
                                            class="form-control csp-readonlycolor" name="name_of_clinic" id="name_of_clinic"
                                            aria-describedby="name_of_clinic" placeholder="" disabled>
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
                                            aria-describedby="patient_uhid" value="{{ $uhidDetails->pati_uhid }}"
                                            placeholder="" maxlength="10" disabled>
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
                                        class="form-check-input mt-2" value="art_treatment"
                                        {{ old('treatment_type', $uhidDetails->treatment_type) == 'art_treatment' ? 'checked' : '' }}
                                        disabled>
                                    <label for="art_treatment" class="m-2">Art Treatment</label>
                                    <input type="radio" name="treatment_type" id="surrogacy"
                                        class="form-check-input mt-2" value="surrogacy"
                                        {{ old('treatment_type', $uhidDetails->treatment_type) == 'surrogacy' ? 'checked' : '' }}
                                        disabled>
                                    <label for="surrogacy" class="m-2">Surrogacy Treatment</label>
                                </div>
                                @error('treatment_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="{{ old('treatment_type', $uhidDetails->treatment_type) == 'surrogacy' ? '' : 'surrogacy-form-1' }}  border p-3 rounded"
                                id="surrogacy_form_section">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><span
                                                class="color-csp-clinic-two">*</span><strong> Case of
                                                :</strong></label>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="case_of"
                                                    id="flexRadioDefault1" value="one"
                                                    {{ old('case_of', $uhidDetails->case_of ?? '') === 'one' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Couple
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="case_of"
                                                    id="flexRadioDefault2" value="two"
                                                    {{ old('case_of', $uhidDetails->case_of ?? '') === 'two' ? 'checked' : '' }}
                                                    disabled>
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
                                                for="validationCustomUsername"><strong>Nationality of the
                                                    Husband</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="nationality" id="nationality" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Indian" class="p-1"
                                                        {{ old('nationality', $uhidDetails->nationality ?? '') == 'Indian' ? 'selected' : '' }}>
                                                        Indian</option>
                                                    <option value="OCI Card Holders"
                                                        {{ old('nationality', $uhidDetails->nationality ?? '') == 'OCI Card Holders' ? 'selected' : '' }}>
                                                        OCI Card Holders</option>
                                                </select>
                                            </div>
                                            @error('nationality')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 display-none-csp-clinic-one" id="other_nationality1">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Country</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="other_nationality" id="other_nationality"
                                                    class="form-control" disabled>
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


                                    <div class="col-md-2 " id="nationality_wife1">
                                        <div class="mb-3">
                                            <label class="text-label form-label" id="nationality_woman_lable"
                                                for="nationality_wife"><strong>Nationality</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                @php
                                                    $selectedNationality =
                                                        old('nationality_wife') ??
                                                        ($uhidDetails->nationality_wife ?? '');
                                                    $caseOfInput =
                                                        request()->input('case_of') ??
                                                        (old('case_of') ?? ($uhidDetails->case_of ?? ''));
                                                @endphp

                                                <select name="nationality_wife" id="nationality_wife"
                                                    class="form-control" disabled>
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Indian" @selected($selectedNationality === 'Indian')>Indian</option>
                                                    @if ($caseOfInput === 'one' || $selectedNationality === 'OCI Card Holders')
                                                        <option value="OCI Card Holders" @selected($selectedNationality === 'OCI Card Holders')>OCI
                                                            Card Holders</option>
                                                    @endif
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
                                                <select name="other_nationality_wife" id="other_nationality_wife"
                                                    class="form-control" disabled>
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



                                    <div class="col-md-3 one selectt display-none-csp-clinic-one" id="husband_age">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Husband Age</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="age" id="age" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 26; $i <= 55; $i++) {
                                                        $selected = $i == old('age', $uhidDetails->age ?? '') ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                    } ?>


                                                </select>
                                            </div>
                                            @error('age')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3 one selectt display-none-csp-clinic-one" id="wife_age1">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Wife Age
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="wife_age" id="wife_age" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 23; $i <= 50; $i++) {
                                                        $selected = $i == old('wife_age', $uhidDetails->wife_age ?? '') ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                    } ?>


                                                </select>
                                            </div>
                                            @error('wife_age')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-3 two selectt display-none-csp-clinic-one" id="age_of_women">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Age of Woman</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="age_of_women" id="age_of_women1" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong>
                                                    </option>
                                                    <?php for ($i = 35; $i <= 45; $i++) {
                                                        $selected = $i == old('age_of_women', $uhidDetails->age_of_women ?? '') ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
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
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Yes"
                                                        {{ old('num_pre_child', $uhidDetails->num_pre_child ?? '') == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ old('num_pre_child', $uhidDetails->num_pre_child ?? '') == 'No' ? 'selected' : '' }}>
                                                        No</option>

                                                </select>
                                            </div>
                                            @error('num_pre_child')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-3" id="num_per_child_details">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Details of
                                                    Child</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="child_give_details" id="give_details" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong></option>
                                                    <option value="Mentally Challenged"
                                                        {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Mentally Challenged' ? 'selected' : '' }}>
                                                        Mentally Challenged</option>
                                                    <option value="Physically Challenged"
                                                        {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Physically Challenged' ? 'selected' : '' }}>
                                                        Physically Challenged</option>
                                                    <option value="Life Threatening Disorder"
                                                        {{ old('child_give_details', $uhidDetails->child_give_details ?? '') == 'Life Threatening Disorder' ? 'selected' : '' }}>
                                                        Life Threatening Disorder</option>

                                                </select>
                                            </div>
                                            @error('child_give_details')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>


                                    <div class="row col-md-6 " id="medical_open">
                                        <div class="col-md-6" id="child_medical_open">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>Medical Certificate of
                                                        Child issued by District Medical Board
                                                    </strong><span class="color-csp-clinic-two">*</span></label>
                                                <div id="child_medical_upload"
                                                    class="{{ isset($existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']) ? 'display-none-csp-clinic-one' : '' }}">
                                                    <div class="input-group">
                                                        <input type="file" class="form-control"
                                                            id="child_medical_certificate"
                                                            name="surrogacypatient_child_medicalcertificate_docs"
                                                            aria-describedby="child_medical_certificate1" disabled>
                                                        <button type="button" class="btn btn-danger"
                                                            id="removeFileButtonchild">Remove</button>
                                                    </div>
                                                </div>
                                                @if (isset($existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']))
                                                    <div id="existing_child_medical_file" class="mt-2">
                                                        <p>Uploaded File:
                                                            @php $file = folderpath('surrogacy_patient_medical_docs_blade') . $uhidDetails->clinic_id . '/' . $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']; @endphp
                                                            <a href="{{ asset($file) }}" target="_blank"><i
                                                                    class="fas fa-file-pdf fa-2x text-danger"></i></a>
                                                            <button type="button" class="btn btn-sm btn-danger ms-2"
                                                                id="removeChildMedicalFileBtn">Remove</button>
                                                        </p>
                                                        <input type="hidden" name="existing_child_medical_file"
                                                            id="existing_child_medical_certificate_input"
                                                            value="{{ $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs'] }}">
                                                    </div>
                                                @endif
                                                <ul><strong>Note:- </strong>
                                                    <li>File Type: PDF or JPG Format only and File Size: 50 to 200
                                                        kb.
                                                    </li>
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
                                                        name="uterus_ab" value="Y"
                                                        {{ old('uterus_ab', $uhidDetails->uterus_ab ?? '') == 'Y' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="uterus_ab">
                                                        <strong>Uterus Abnormalities</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="ivf_failure"
                                                        name="ivf_failure" value="Y"
                                                        {{ old('ivf_failure', $uhidDetails->ivf_failure ?? '') == 'Y' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="ivf_failure">
                                                        <strong>Repeated IVF failure or Recurrent implantation
                                                            failure</strong>
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="col-md-2">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="preg_loss"
                                                        name="preg_loss" value="Y"
                                                        {{ old('preg_loss', $uhidDetails->preg_loss ?? '') == 'Y' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="preg_loss">
                                                        <strong>Multiple Pregnancy Loss</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                    <input class="form-check-input me-2" type="checkbox" id="life_threat"
                                                        name="life_threat" value="Y"
                                                        {{ old('life_threat', $uhidDetails->life_threat ?? '') == 'Y' ? 'checked' : '' }}
                                                        disabled>
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
                                                        name="male_factor" value="Y"
                                                        {{ old('male_factor', $uhidDetails->male_factor ?? '') == 'Y' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="male_factor">
                                                        <strong>Male Factor</strong>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Description of Cause -->
                                            <div class="col-md-12 mt-3">
                                                <div class="input-group mt-2">
                                                    <input type="text" class="form-control" id="medical_surrogacy"
                                                        value="{{ old('medical_surrogacy', $uhidDetails->medical_surrogacy ?? '') }}"
                                                        name="medical_surrogacy" aria-describedby="medical_surrogacy"
                                                        disabled>
                                                </div>
                                                @error('medical_surrogacy')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4" id="">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Treatment
                                                            Outcome</strong><span
                                                            class="color-csp-clinic-two">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="tratment_Outcome"
                                                            name="tratment_Outcome" disabled>
                                                            <option value=""
                                                                {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == '' ? 'selected' : '' }}>
                                                                Select</option>
                                                            <option value="Pregnant"
                                                                {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Pregnant' ? 'selected' : '' }}>
                                                                Pregnant</option>
                                                            <option value="Not Pregnant"
                                                                {{ old('tratment_Outcome', $uhidDetails->tratment_Outcome ?? '') == 'Not Pregnant' ? 'selected' : '' }}>
                                                                Not Pregnant</option>
                                                        </select>
                                                    </div>
                                                    @error('tratment_Outcome')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Upload Certificate of Medical
                                                    Indication issued by District Medical Board
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div id="medical_upload"
                                                class="{{ isset($existingDocs['target_file_surrogacypatient_medicalcertificate_docs']) ? 'display-none' : '' }}">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="medical_certificate"
                                                        name="surrogacypatient_medicalcertificate_docs" disabled>
                                                </div>
                                            </div>
                                            @if (isset($existingDocs['target_file_surrogacypatient_medicalcertificate_docs']))
                                                <div id="existing_medical_file" class="mt-2">
                                                    <p>Uploaded File:
                                                        @php $file = folderpath('surrogacy_patient_medical_docs_blade') . $uhidDetails->clinic_id . '/' . $existingDocs['target_file_surrogacypatient_medicalcertificate_docs']; @endphp
                                                        <a href="{{ asset($file) }}" target="_blank"><i
                                                                class="fas fa-file-pdf fa-2x text-danger"></i></a>
                                                        <button type="button" class="btn btn-sm btn-danger ms-2"
                                                            id="remove-button">Remove</button>
                                                    </p>
                                                    {{--  onclick="removeExistingMedicalFile()" --}}
                                                    <input type="hidden" name="existing_medical_file"
                                                        value="{{ $existingDocs['target_file_surrogacypatient_medicalcertificate_docs'] }}"
                                                        disabled>
                                                </div>
                                            @endif
                                            <ul><strong>Note:- </strong>
                                                <li>File Type: PDF or JPG Format only and File Size: 50 to 200 kb.
                                                </li>
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
                                                <!-- Main Select Dropdown -->
                                                <select name="types_of_treat" id="types_of_treat" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted"
                                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == '' ? 'selected' : '' }}>
                                                        <strong><b>Select Treatment Type</b></strong>
                                                    </option>
                                                    <option value="Surrogacy using donor gametes" id="d_gametes"
                                                        class="p-1"
                                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using donor gametes' ? 'selected' : '' }}>
                                                        Surrogacy using donor gametes
                                                    </option>
                                                    <option value="Surrogacy using self gametes" id="own_gametes"
                                                        class="p-1"
                                                        {{ old('types_of_treat', $uhidDetails->types_of_treat ?? '') == 'Surrogacy using self gametes' ? 'selected' : '' }}>
                                                        Surrogacy using self gametes</option>
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
                                                for="validationCustomUsername"><strong>Gamete Source</strong><span
                                                    class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="types_of_treat1" id="types_of_treat1" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>
                                                    <option value="" id="tot1" class="text-muted"
                                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == '' ? 'selected' : '' }}>
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <option value="Self Oocyte & Donor Sperm" id="d_sperm"
                                                        class="p-1"
                                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Self Oocyte & Donor Sperm' ? 'selected' : '' }}>
                                                        Self Oocyte & Donor Sperm
                                                    </option>
                                                    <option value="Donor Oocyte & Self Sperm" id="o_sperm"
                                                        class="p-1"
                                                        {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Donor Oocyte & Self Sperm' ? 'selected' : '' }}>
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
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="surrogate_mother_age" id="surrogate_mother_age"
                                                    class="form-control" aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted"><strong><b>Select
                                                                Age</b></strong> </option>
                                                    <?php for ($i = 25; $i <= 35; $i++) {
                                                        $selected = $i == old('surrogate_mother_age', $uhidDetails->surrogate_mother_age ?? '') ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                    } ?>
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
                                                <select class="form-control" id="for_others" name="art_undertaken"
                                                    disabled>
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

                                    <div class="col-md-3" id="others_id">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Others</strong></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="art_undertaken_other"
                                                    value="{{ old('art_undertaken_other', $uhidDetails->art_undertaken_other ?? '') }}"
                                                    name="art_undertaken_other" aria-describedby="art_undertaken_other"
                                                    disabled>
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
                                                    class="form-control" aria-label=".form-select-lg example" disabled>
                                                    <option value="" class="text-muted">
                                                        <strong><b>Select</b></strong>
                                                    </option>
                                                    <?php for ($i = 1; $i <= 20; $i++) {
                                                        $selected = $i == old('total_nun_cycles', $uhidDetails->total_nun_cycles ?? '') ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                    } ?>
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
                                                    Cancelled (if any)
                                                </strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <select name="no_cycles" id="no_cycles" class="form-control"
                                                    aria-label=".form-select-lg example" disabled>

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
                                                for="validationCustomUsername"><strong>Cycle Cancellation reason</strong><span class="color-csp-clinic-two">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="Cycle_fail_reason"
                                                    value="{{ old('Cycle_fail_reason', $uhidDetails->Cycle_fail_reason ?? '') }}"
                                                    name="Cycle_fail_reason" aria-describedby="Cycle_fail_reason"
                                                    disabled>

                                            </div>
                                            @error('Cycle_fail_reason')
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
                                                <textarea class="form-control" col="5" rows="3" name="comp_if_any" disabled>{{ old('comp_if_any', $uhidDetails->comp_if_any ?? '') }}</textarea>
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
                                                <textarea class="form-control" col="5" rows="3" name="remark" disabled>{{ old('remark', $uhidDetails->remark ?? '') }}</textarea>
                                            </div>
                                            @error('remark')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>
                                            Affidavit regarding
                                            following to be taken on record:</strong></label>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration"
                                                name="declaration"
                                                {{ old('declaration', $uhidDetails->declaration ?? '') === 'on' ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="gridCheck">
                                                From Surrogate Mother that she has not acted as a surrogate mother
                                                more than once in her lifetime.<span class="color-csp-clinic-two">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration1"
                                                name="declaration1"
                                                {{ old('declaration1', $uhidDetails->declaration1 ?? '') === 'on' ? 'checked' : '' }}
                                                disabled>
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
                                                name="declaration3"
                                                {{ old('declaration3', $uhidDetails->declaration3 ?? '') === 'on' ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="gridCheck">
                                                From Oocyte Donor that she has not donated oocytes more than once in
                                                her life time.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration4"
                                                name="declaration4"
                                                {{ old('declaration4', $uhidDetails->declaration4 ?? '') === 'on' ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="gridCheck">
                                                From the ART Bank that the bank has not supplied sperm/oocyte of the
                                                same donor to more than one commissioning couple/single woman.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- =======================================================Art Treatment Start==================================================================================== --}}
                            <div class="{{ old('treatment_type', $uhidDetails->treatment_type) == 'art_treatment' ? '' : 'art_treatment' }} border p-3 rounded"
                                id="art_treatment_form_section">
                                @include('layouts.clinic.edit_patient_surrogacy_application_form_art_treatment_outcome')
                            </div>


                            <div class="col-md-12">
                                <div class="card border mb-3">

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="mb-3">
                                                <h4 class="card-title csp-clinic-text-black"><strong>Part B</strong>
                                                </h4>

                                            </div>
                                            
                                            <div class="col-md-3 dn-csp-clinic-two" id="preganancy_outcome1">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Pregnancy
                                                            Outcome</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="preganancy_outcome"
                                                            name="preganancy_outcome">
                                                            <option value="">Select</option>
                                                            <option value="live birth"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'live birth' ? 'selected' : '' }}>
                                                                live birth</option>
                                                            <option value="Stillbirth"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Stillbirth' ? 'selected' : '' }}>
                                                                Stillbirth</option>
                                                              
                                                            <option id="therapeutic_abortion"  value="Therapeutic abortion"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Therapeutic abortion' ? 'selected' : '' }}>
                                                                Therapeutic abortion</option>
                                                            <option value="Spontaneous abortion"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Spontaneous abortion' ? 'selected' : '' }}>
                                                                Spontaneous abortion / Missed abortion</option>
                                                            <option id="elective_option" value="Elective Termination"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Elective Termination' ? 'selected' : '' }}>
                                                                Elective Termination</option>

                                                                 <option id="surro_special_option" value="Therapeutic abortion with consent of Surrogate mother & authorization by AA"
                                                                {{ old('preganancy_outcome', $uhidDetails->preganancy_outcome ?? '') == 'Therapeutic abortion with consent of Surrogate mother & authorization by AA' ? 'selected' : '' }}>
                                                               Therapeutic abortion with consent of Surrogate mother & authorization by AA</option>
                                                        </select>
                                                    </div>
                                                    @error('preganancy_outcome')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>




                                            @php

                                                $male_number = old('male_number', $uhidDetails->male_number ?? '');
                                                $female_number = old(
                                                    'female_number',
                                                    $uhidDetails->female_number ?? '',
                                                );
                                                $show_gender_section = $male_number || $female_number;
                                            @endphp
                                            <div class="col-md-6 {{ $show_gender_section ? '' : 'hidden' }}"
                                                id="gender_child1">
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
                                                                    <select name="male_number" id="male_number"
                                                                        class="form-control">
                                                                        @for ($i = 0; $i <= 5; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ $male_number == $i ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
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
                                                                    <label class="form-check-label"
                                                                        for="customCheckBox1">Female</label>
                                                                </div>
                                                            </div>
                                                            <div class="col md-7">
                                                                <div class="input-group">
                                                                    <select name="female_number" id="female_number"
                                                                        class="form-control">
                                                                        @for ($i = 0; $i <= 5; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ $female_number == $i ? 'selected' : '' }}>
                                                                                {{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                    <span class="input-group-text">Number</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 dn-csp-clinic-two" id="live_birth_open">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Live Birth Pregnancy
                                                            Outcome</strong></label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="l_birth" name="l_birth"
                                                            disabled>
                                                            <option value="">Select</option>
                                                            <option value="Singleton" id="Singleton1"
                                                                {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Singleton' ? 'selected' : '' }}>
                                                                Singleton
                                                            </option>
                                                            <option value="Twin"
                                                                {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Twin' ? 'selected' : '' }}>
                                                                Twin</option>
                                                            <option value="Higher Order"
                                                                {{ old('l_birth', $uhidDetails->l_birth ?? '') == 'Higher Order' ? 'selected' : '' }}>
                                                                Higher Order</option>



                                                        </select>

                                                        <input type="hidden" name="l_birth" id="l_birth_hidden"
                                                            value="">
                                                    </div>
                                                    @error('l_birth')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <script nonce="{{ $cspNonce }}">
                                                $(document).ready(function() {
                                                    $('#male_female').change(function() {
                                                        $('#male_hidden').toggle(this.checked);
                                                    });

                                                    $('#male_female1').change(function() {
                                                        $('#female_hidden').toggle(this.checked);
                                                    });
                                                });
                                            </script>
                                            <script nonce="{{ $cspNonce }}">
                                                $(document).ready(function() {
                                                    $('#l_birth').on('change', function() {


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

                                                            maleCheckbox.on('change', function() {
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

                                                            femaleCheckbox.on('change', function() {
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

                                                            maleCheckbox.off('change').on('change', function() {
                                                                maleHidden.toggle(this.checked);
                                                            });

                                                            femaleCheckbox.off('change').on('change', function() {
                                                                femaleHidden.toggle(this.checked);
                                                            });
                                                        }
                                                    });
                                                    $('#preganancy_outcome').on('change', function() {


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

                                                            maleCheckbox.on('change', function() {
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

                                                            maleCheckbox.off('change').on('change', function() {
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

                                                document.addEventListener('DOMContentLoaded', function() {
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

                                            {{-- =================================================================ART Treatment End====================================================================================== --}}
                                        </div>
                                        <button type="submit" name="submit" value="updatev" id="btnSubmit"
                                           class="btn me-2 bc-br-color-csp-clinic-three"> Save Draft</button>
                                        <button type="button" id="closeButton"
                                            class="btn me-2 btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/add_patient_surrogacy_application_form_part_2.js') }}">
    </script>


    {{-- medical child image show --}}
    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {
            const removeButton = document.getElementById("removeChildMedicalFileBtn");
            if (removeButton) {
                removeButton.addEventListener("click", removeExistingChildMedicalFile);
            }

            function removeExistingChildMedicalFile() {

                const existingDiv = document.getElementById('existing_child_medical_file');
                if (existingDiv) {
                    existingDiv.remove();
                }
                const uploadDiv = document.getElementById('child_medical_upload');
                if (uploadDiv) {
                    uploadDiv.style.display = 'block';
                }
            }
        });
    </script>
   

    <script nonce="{{ $cspNonce }}">
        // new updation in the form 
        document.addEventListener("DOMContentLoaded", function() {

            const radios = document.querySelectorAll('input[name="treatment_type"]');
            const surrogacy_form = document.getElementById("surrogacy_form_section");
            const art_treatment_form = document.getElementById("art_treatment_form_section");
            const checkedTreatmeant = document.querySelector('input[name="treatment_type"]:checked').value;

            let findTreatmeant = '';

            radios.forEach(radio => {
                radio.addEventListener("change", function() {
                    findTreatmeant = this.value;
                    resetFormvalue(surrogacy_form, this.value === "surrogacy");
                    resetFormvalue(art_treatment_form, this.value === "art_treatment");
                });
            });

            function resetFormvalue(form, show) {
                if (checkedTreatmeant === findTreatmeant) {
                    window.location.reload();
                }
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
            let ageofWomen = document.getElementById('age_of_women');
            const forOthers = document.getElementById('for_others');



            const husband_age = document.getElementById("husband_age");
            const wife_age1 = document.getElementById("wife_age1");
            const wifeLabel = document.getElementById("nationality_woman_lable");

            const numPreChild = document.getElementById("num_pre_child");

            const numPreChildDetails = document.getElementById("num_per_child_details");
            const medicalOpen = document.getElementById("medical_open");
            const childMedicalOpen = document.getElementById("child_medical_open");
            const childMedicalUpOpen = document.getElementById("child_medical_upload");

            let selectedTotal = '{{ old('total_nun_cycles', $uhidDetails->total_nun_cycles ?? '') }}';
            let selectedCycles = '{{ old('no_cycles', $uhidDetails->no_cycles ?? '') }}';



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
                    husband_age.style.display = "block";
                    wife_age1.style.display = "block";
                    wifeLabel.innerHTML = "<strong>Nationlity of wife</strong><span style='color:red;'>*</span>";
                    $('#age_of_women').prop('selectedIndex', false);
                } else if (singleWomanRadio.checked) {
                    nationalityHusband.style.display = "none";
                    nationalityWife.style.display = "block";
                    maleFactorDive.style.display = "none";
                    ageofWomen.style.display = 'block';

                    maleFactorDive.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(
                        input => {
                            input.checked = false;
                        });
                    wifeLabel.innerHTML = "<strong>Nationality</strong><span style='color:red;'>*</span>";
                }
                // Reset and hide country fields when changing the main radio button
                // resetCountryFields();
            }

            function toggleCountryFields() {
                otherNationalityHusband.style.display = nationalityHusbandSelect.value === "OCI Card Holders" ?
                    "block" : "none";
                otherNationalityWife.style.display = nationalityWifeSelect.value === "OCI Card Holders" ? "block" :
                    "none";
            }

            function toggleNumPreChild() {
                if (numPreChild.value === 'Yes') {
                    numPreChildDetails.style.display == 'block';
                    medicalOpen.style.display == 'block';
                    childMedicalOpen.style.display == 'block';

                } else if (numPreChild.value === 'No' || numPreChild.value === '') {
                    $('#num_per_child_details').hide();
                    $('#child_medical_open').hide();
                    numPreChildDetails.style.display == 'none';
                    medicalOpen.style.display == 'none';
                    childMedicalOpen.style.display == 'none';
                }
            }



            function populateNoCycles(maxVal, selectedVal) {
                let noCycles = $('#no_cycles');
                noCycles.empty().append('<option value="">Select</option>');
                for (let i = 0; i <= maxVal; i++) {
                    let selected = (i == selectedVal) ? 'selected' : '';
                    noCycles.append('<option value="' + i + '" ' + selected + '>' + i + '</option>');
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

            function toggleothersIdUnderTaken() {
                if (forOthers.value === 'Others') {
                    $('#others_id').show();
                } else {
                    $('#others_id').hide();
                }
            }

            // Event Listeners
            coupleRadio.addEventListener("change", toggleFields);
            singleWomanRadio.addEventListener("change", toggleFields);

            nationalityHusbandSelect.addEventListener("change", toggleCountryFields);
            nationalityWifeSelect.addEventListener("change", toggleCountryFields);
            forOthers.addEventListener("change", toggleothersIdUnderTaken);

            // Ensure default visibility based on current selections
            toggleFields();
            toggleCountryFields();
            toggleNumPreChild();
            toggleothersIdUnderTaken();
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
        // $('#num_pre_child').on('change', function() {
        //     $("#give_details").val('');
        //     $("#child_medical_certificate").val('');


        //     if (this.value == 'Yes') {
        //         $("#medical_open").show();
        //         $("#child_medical_open").show();

        //         // child_medical_open
        //     } else {
        //         $("#medical_open").hide();
        //         $("#child_medical_open").hide();
        //     }
        // });
    </script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#total_nun_cycles').change(function() {
                var selectedNumber = $(this).val();
                //alert(selectedNumber);
                var optionSelect = $('#no_cycles');
                // alert(optionSelect);
                optionSelect.empty(); // Clear previous options
                optionSelect.append('<option value="">Select</option>');
                for (var i = 0; i <= selectedNumber; i++) {
                    optionSelect.append('<option value="' + i + '">' + i + '</option>');
                }
            });
            // $('#total_nun_cycles').trigger('change');
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
                        nationalitySelect.innerHTML = `<option value="" class="text-muted"><strong>Select</strong></option>
                        <option value="Indian" class="p-1">Indian</option>`;
                        womanlabel.innerHTML =
                            `<strong>Nationality</strong><span class="color-csp-clinic-two">*</span> `;
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
                        womanlabel.innerHTML =
                            `<strong>Nationlity of wife</strong><span class="color-csp-clinic-two">*</span> `;

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
            if (this.value == 'Surrogacy using self gametes') {
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
                $("#child_medical_open").show();
            } else {
                $("#num_per_child_details").hide();
                $("#child_medical_open").hide();
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
            } else {
                $("#treat_outcomes1").hide();
                $("#preganancy_outcome1").hide();
                $("#live_birth_open").hide();
                $("#gender_child1").hide();
            }
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
        document.addEventListener("DOMContentLoaded", function() {
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


            return confirm(
                "Kindly check and confirm all details before final submission. There is no provision for editing once submitted."
            );
        }
    </script>

    <script nonce="{{ $cspNonce }}">
        $('#flexRadioDefault2').on('click', function() {
            if ($('#flexRadioDefault2').is(':checked')) {
                $('#age_of_women1').val('');
                $('#male_factor').val('N');
                $('#age').val('');
                $('#wife_age').val('');
                $('#num_pre_child').prop('selectedIndex', false);
                $('#age_of_women1').prop('selectedIndex', false);
            } else {
                $('#age_of_women1').val('');
                $('#age_of_women1').prop('selectedIndex', false);
                $('#num_pre_child').val('');
                $('#num_pre_child').prop('selectedIndex', false);
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
                $('#age_of_women').prop('selectedIndex', false);
                $('#age').val('');
                $('#wife_age').val('');
                $('#num_pre_child').prop('selectedIndex', false);
            } else {
                $('#age').val('');
                $('#wife_age').val('');
                $('#age_of_women').val('');
                $('#age_of_women').prop('selectedIndex', false);
                $('#num_pre_child').prop('selectedIndex', false);
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
                            if (response.matched === 'q_not_matched') {
                                $('#availability').html(
                                    '<span class="text-success">UHID Found for this Surrogacy clinic.</span>'
                                );
                                $('#btnSubmit').attr("disabled", false);
                            } else {
                                $('#availability').html(
                                    '<span class="text-danger">UHID already exists for this quarter.</span>'
                                );
                                $('#btnSubmit').attr("disabled", true);
                            }
                        } else if (treatmentStatus === "No") {
                            $('#availability').html('<span class="text-danger">UHID already exists.</span>');
                            $('#btnSubmit').attr("disabled", true);
                        } else {
                            $('#availability').html('');
                            $('#btnSubmit').attr("disabled", true);
                        }
                    } else {
                        if (treatmentStatus === "Yes") {
                            $('#availability').html(
                                '<span class="text-danger">UHID does not exist for this Surrogacy clinic. Kindly enter correct UHID.</span>'
                            );
                            $('#btnSubmit').attr("disabled", true);
                        } else {
                            $('#availability').html('');
                            $('#btnSubmit').attr("disabled", false);
                        }
                    }
                    //  }
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


            } else if (this.value == '') {
                $("#preganancy_outcome1").hide();
                //$("#preganancy_outcome1").hide();

            } else {
                $("#preganancy_outcome1").show();
                //$("#preganancy_outcome1").hide();

            }
        });
    </script>

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#total_num_of_cyc').change(function() {
                var selectedNumber = $(this).val();
                var optionSelect = $('#no_cycles');
                optionSelect.empty(); // Clear previous options
                optionSelect.append('<option value="">Select</option>');
                for (var i = 0; i <= selectedNumber; i++) {
                    optionSelect.append('<option value="' + i + '">' + i + '</option>');
                }
            });
            $('#total_num_of_cyc').trigger('change');

            function toggleGenderFields(isOnLoad = false) {
                let outcome = $('#preganancy_outcome').val();

                $('#gender_child1').hide();
                $('#live_birth_open').hide();
                $('#l_birth').prop('disabled', true);

                if (!isOnLoad) {

                    $('#l_birth').val();
                    $('#l_birth_hidden').val();
                    $('#male_number').val();
                    $('#female_number').val();
                }

                if (outcome === 'live birth') {

                    $('#gender_child1').removeClass('hidden').show();
                    $('#live_birth_open').show();
                    $('#l_birth').prop('disabled', false);

                } else if (outcome === 'Stillbirth') {

                    $('#gender_child1').removeClass('hidden').show();
                }
            }


            toggleGenderFields();

            // On change
            $('#preganancy_outcome').on('change', function() {
                toggleGenderFields();
            });
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


        $(document).ready(function () {

    let type = $('input[name="treatment_type"]:checked').val();

    if (type) {
        handlePregnancyOptions(type);
    }

});

$('input[name="treatment_type"]').on('change', function () {
    handlePregnancyOptions($(this).val());
});

  function handlePregnancyOptions(type) {

            let specialOption = $('#surro_special_option');
            let electiveOption = $('#elective_option');
            let therapeuticabortion = $('#therapeutic_abortion');
            if (type === 'art_treatment') {


                specialOption.prop('disabled', true).hide();

               
                electiveOption.prop('disabled', false).show();
                therapeuticabortion.prop('disabled', false).show();
             
                if ($('#preganancy_outcome').val() === specialOption.val()) {
                    $('#preganancy_outcome').val('');
                }

            } else if (type === 'surrogacy') {

              
                electiveOption.prop('disabled', true).hide();
                therapeuticabortion.prop('disabled', true).hide();

              
                specialOption.prop('disabled', false).show();

              
                if ($('#preganancy_outcome').val() === electiveOption.val()) {
                    $('#preganancy_outcome').val('');
                }
                if ($('#preganancy_outcome').val() === therapeuticabortion.val()) {
                    $('#preganancy_outcome').val('');
                }
            }
        }
    </script>

    

@endsection
