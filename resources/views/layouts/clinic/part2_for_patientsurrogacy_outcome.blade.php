@extends('layouts.clinic.clinic_master')
@section('content')


    <style nonce="{{ $cspNonce }}">
        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .csp-readonlycolor {
            background-color: #e8eaec !important;
            /* light blue, change as needed */
            font-weight: bold;
            /* optional */
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
            background-color: #0d6efd;
            ;
        }


        .width-csp-clinic-one {
            width: 48%;
        }

        .dn-csp-clinic-two {
            display: none;
        }

        .bc-csp-clinic-three {
            color: red;
        }

        .button-csp-clinic-four {

            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        .hidden {
            display: none;
        }

        hr {
            border: none;
            height: 2px;
            background: #6366f1;
            box-shadow: 0 0 10px #6366f1;
        }

        .hide {
            display: none;
        }

        #art_treatment_form_section,
        #surrogacy_form_section {
            display: none;
        }

        #art_other_nationality1 {
            display: none;
        }

        #art_other_nationality_wife {
            display: none;
        }

        .hide-important {
            display: none !important;
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
                    <link href="{{ url('public/css/select2.min.css') }}" rel="stylesheet">


                    <h3 class="card-title mb-5 text-primary">Edit Patient information form for Surrogacy Clinic</h3>


                    <div id="quarterSection" class="hide">

                        <h3 class="card-title mb-5 text-primary">Quarter wise Filed Reports:</h3>

                        <table id="quarterTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Quarter & Year</th>
                                   

                                </tr>
                            </thead>
                            <tbody id="quarterTableBody"></tbody>
                        </table>

                    </div>


                    <div id="editForm" class="card mt-3">

                        <form name="art_clin1" method="POST" id="art_clin1"
                            action="{{ route('clinic.patientartparttwoapplicationformSubmitpatientSurrogacynew') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="p_id" id="p_id" value="">



                            <input type="hidden" name="clinic_id" id="clinic_id" value="">


                            @php
                                $currentYear = date('Y');
                                $currentQuarter = ceil(date('n') / 3);
                            @endphp

                            <div class="row">

                                <div class="card border mb-3">
                                    <div class="col-md-4">
                                        <div class="mb-3 ">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Patient
                                                    UHID</strong><span class="bc-csp-clinic-three">*</span></label>
                                            <div class="input-group">
                                                <select name="patient_uhid" id="patient_uhid" class="form-control"
                                                    aria-label=".form-select-lg example" aria-describedby="patient_uhid"
                                                    maxlength="10">
                                                    <option value="">-- Select Patient --</option>
                                                </select>
                                            </div>
                                            <span id="availability"></span>
                                            @error('patient_uhid')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="card-body">

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
                                                        <input type="hidden" class="form-control width-csp-clinic-one"
                                                            name="quarter" value="" disabled>
                                                        <input type="text"
                                                            class="form-control width-csp-clinic-one csp-readonlycolor"
                                                            name="year" id="year" value="" disabled>
                                                        <input type="text"
                                                            class="form-control width-csp-clinic-one csp-readonlycolor"
                                                            value="" id="quarter" disabled>

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
                                                        <input class="form-check-input" type="radio"
                                                            name="previous_treatment" id="previous_treatment_yes"
                                                            value="Yes" disabled>
                                                        <label class="form-check-label" for="previous_treatment_yes">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="previous_treatment" id="previous_treatment_no"
                                                            value="No" disabled>
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
                                                        for="validationCustomUsername"><strong>Clinic
                                                            Registration Number</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value=""
                                                            class="form-control csp-readonlycolor" name="cli_reg_name"
                                                            id="clinic_level1_reg_num" aria-describedby="cli_reg_name"
                                                            placeholder="" data-validation="alphanumeric"
                                                            data-validation-allowing="_" readonly>

                                                    </div>
                                                    <span id="clinic_level1_reg_numID"
                                                        class="color-csp-clinic-two"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Name of the
                                                            Clinic</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" value=""
                                                            class="form-control csp-readonlycolor" name="name_of_clinic"
                                                            id="name_of_clinic" aria-describedby="name_of_clinic"
                                                            placeholder="" disabled>
                                                    </div>
                                                    <span id="name_of_clinicID" class="color-csp-clinic-two"></span>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="card-body">
                                                    <div class="col-md-5">
                                                        <input type="radio" name="treatment_type" id="art_treatment"
                                                            class="form-check-input mt-2" value="art_treatment"
                                                            {{ old('treatment_type') == 'art_treatment' ? 'checked' : '' }}
                                                            disabled>
                                                        <label for="art_treatment" class="m-2">Art Treatment</label>

                                                        <input type="radio" name="treatment_type" id="surrogacy"
                                                            class="form-check-input mt-2" value="surrogacy"
                                                            {{ old('treatment_type') == 'surrogacy' ? 'checked' : '' }}
                                                            disabled>
                                                        <label for="surrogacy" class="m-2">Surrogacy Treatment</label>
                                                    </div>


                                                    @error('treatment_type')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="border p-3 rounded" id="surrogacy_form_section">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="text-label form-label"
                                                                for="validationCustomUsername"><span
                                                                    class="color-csp-clinic-two">*</span><strong> Case of
                                                                    :</strong></label>
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="case_of" id="flexRadioDefault1"
                                                                        value="one"
                                                                        {{ old('case_of' ?? '') === 'one' ? 'checked' : '' }}
                                                                        disabled>
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault1">
                                                                        Couple
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="case_of" id="flexRadioDefault2"
                                                                        value="two"
                                                                        {{ old('case_of' ?? '') === 'two' ? 'checked' : '' }}
                                                                        disabled>
                                                                    <label class="form-check-label"
                                                                        for="flexRadioDefault2">
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
                                                        <div class="col-md-2 display-none-csp-clinic-one"
                                                            id="nationality_husband">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Nationality of
                                                                        the
                                                                        Husband</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="nationality" id="nationality"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
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
                                                        <div class="col-md-4 display-none-csp-clinic-one"
                                                            id="other_nationality1">
                                                            <div class="mb-3">
                                                                <label class="control-label"><strong>Country</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div cla ss="input-group">
                                                                    <select name="other_nationality"
                                                                        id="other_nationality" class="form-control"
                                                                        disabled>
                                                                        <option value="">-- Select Country --
                                                                        </option>

                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>





                                                        <div class="col-md-2 " id="nationality_wife1">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    id="nationality_woman_lable"
                                                                    for="nationality_wife"><strong>Nationality</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    @php
                                                                        $selectedNationality =
                                                                            old('nationality_wife') ??
                                                                            ($uhidDetails->nationality_wife ?? '');
                                                                        $caseOfInput =
                                                                            request()->input('case_of') ??
                                                                            (old('case_of') ??
                                                                                ($uhidDetails->case_of ?? ''));
                                                                    @endphp

                                                                    <select name="nationality_wife" id="nationality_wife"
                                                                        class="form-control" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select</b></strong>
                                                                        </option>
                                                                        <option value="Indian"
                                                                            @selected($selectedNationality === 'Indian')>Indian</option>
                                                                        @if ($caseOfInput === 'one' || $selectedNationality === 'OCI Card Holders')
                                                                            <option value="OCI Card Holders"
                                                                                @selected($selectedNationality === 'OCI Card Holders')>OCI Card
                                                                                Holders</option>
                                                                        @endif
                                                                    </select>

                                                                </div>
                                                                @error('nationality_wife')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 display-none-csp-clinic-one"
                                                            id="other_nationality1_wife">
                                                            <div class="mb-3">
                                                                <label class="control-label"><strong>Country</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="other_nationality_wife"
                                                                        id="other_nationality_wife" class="form-control"
                                                                        disabled>
                                                                        <option value="">-- Select Country --
                                                                        </option>
                                                                        @if (!empty($countries) && $countries->count() > 0)
                                                                            @foreach ($countries as $country)
                                                                                <option value="{{ $country->id }}"
                                                                                    {{ old('other_nationality_wife', $uhidDetails->other_nationality_wife ?? '') == $country->id ? 'selected' : '' }}>
                                                                                    {{ $country->country_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        @else
                                                                            <option value="">No Countries Available
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-3 one selectt display-none-csp-clinic-one"
                                                            id="husband_age">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Husband
                                                                        Age</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="age" id="age"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select
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

                                                        <div class="col-md-3 one selectt display-none-csp-clinic-one"
                                                            id="wife_age1">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Wife Age
                                                                    </strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="wife_age" id="wife_age"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select
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
                                                        <div class="col-md-3 two selectt display-none-csp-clinic-one"
                                                            id="age_of_women">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Age of
                                                                        Woman</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="age_of_women" id="age_of_women1"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select
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
                                                                        Child</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="num_pre_child" id="num_pre_child"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select</b></strong>
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

                                                        <div class="col-md-3" id="num_per_child_details">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Details of
                                                                        Child</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="child_give_details" id="give_details"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select</b></strong>
                                                                        </option>
                                                                        <option value="Mentally Challenged">Mentally
                                                                            Challenged</option>
                                                                        <option value="Physically Challenged">Physically
                                                                            Challenged</option>
                                                                        <option value="Life Threatening Disorder">Life
                                                                            Threatening Disorder</option>

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
                                                                        for="validationCustomUsername"><strong>Medical
                                                                            Certificate of
                                                                            Child issued by District Medical Board
                                                                        </strong><span
                                                                            class="color-csp-clinic-two">*</span></label>
                                                                    <div id="child_medical_upload" class="">
                                                                        <div class="input-group">
                                                                            <input type="file" class="form-control"
                                                                                id="child_medical_certificate"
                                                                                name="surrogacypatient_child_medicalcertificate_docs"
                                                                                aria-describedby="child_medical_certificate1"
                                                                                disabled>
                                                                            <button type="button" class="btn btn-danger"
                                                                                id="removeFileButtonchild">Remove</button>
                                                                        </div>
                                                                    </div>
                                                                    @if (isset($existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs']))
                                                                        <div id="existing_child_medical_file"
                                                                            class="mt-2">
                                                                            <p>Uploaded File:

                                                                            </p>
                                                                            <input type="hidden"
                                                                                name="existing_child_medical_file"
                                                                                id="existing_child_medical_certificate_input"
                                                                                value="{{ $existingDocs['target_file_surrogacypatient_child_medicalcertificate_docs'] }}">
                                                                        </div>
                                                                    @endif
                                                                    <ul><strong>Note:- </strong>
                                                                        <li>File Type: PDF or JPG Format only and File Size:
                                                                            50 to 200
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
                                                                <strong>Medical Indication Necessitating
                                                                    Surrogacy</strong><span
                                                                    class="color-csp-clinic-two">*</span>
                                                            </label>

                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div
                                                                        class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                                        <input class="form-check-input me-2"
                                                                            type="checkbox" id="uterus_ab"
                                                                            name="uterus_ab" value="Y" disabled>
                                                                        <label class="form-check-label" for="uterus_ab">
                                                                            <strong>Uterus Abnormalities</strong>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div
                                                                        class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                                        <input class="form-check-input me-2"
                                                                            type="checkbox" id="ivf_failure"
                                                                            name="ivf_failure" value="Y" disabled>
                                                                        <label class="form-check-label" for="ivf_failure">
                                                                            <strong>Repeated IVF failure or Recurrent
                                                                                implantation
                                                                                failure</strong>
                                                                        </label>
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-2">
                                                                    <div
                                                                        class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                                        <input class="form-check-input me-2"
                                                                            type="checkbox" id="preg_loss"
                                                                            name="preg_loss" value="Y" disabled>
                                                                        <label class="form-check-label" for="preg_loss">
                                                                            <strong>Multiple Pregnancy Loss</strong>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div
                                                                        class="form-check mb-2 d-flex align-items-top justify-content-center">
                                                                        <input class="form-check-input me-2"
                                                                            type="checkbox" id="life_threat"
                                                                            name="life_threat" value="Y" disabled>
                                                                        <label class="form-check-label" for="life_threat">
                                                                            <strong>Life threatening illness</strong>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!-- Male Factor -->
                                                                <div class="col-m e_factor_div">
                                                                    <div
                                                                        class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                                        <input class="form-check-input me-2"
                                                                            type="checkbox" id="male_factor"
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
                                                                        <input type="text" class="form-control"
                                                                            id="medical_surrogacy" value=""
                                                                            name="medical_surrogacy"
                                                                            aria-describedby="medical_surrogacy" disabled>
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
                                                                    for="validationCustomUsername"><strong>Upload
                                                                        Certificate of Medical Indication issued by District
                                                                        Medical Board
                                                                    </strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div id="medical_upload" class="">
                                                                    <div class="input-group">
                                                                        <input type="file" class="form-control"
                                                                            id="medical_certificate"
                                                                            name="surrogacypatient_medicalcertificate_docs"
                                                                            disabled>
                                                                    </div>
                                                                </div>
                                                                @if (isset($existingDocs['target_file_surrogacypatient_medicalcertificate_docs']))
                                                                    <div id="existing_medical_file" class="mt-2">
                                                                        <p>Uploaded File:

                                                                        </p>
                                                                        {{--  onclick="removeExistingMedicalFile()" --}}
                                                                        <input type="hidden" name="existing_medical_file"
                                                                            value="{{ $existingDocs['target_file_surrogacypatient_medicalcertificate_docs'] }}"
                                                                            disabled>
                                                                    </div>
                                                                @endif
                                                                <ul><strong>Note:- </strong>
                                                                    <li>File Type: PDF or JPG Format only and File Size: 50
                                                                        to 200 kb.
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
                                                                        Treatment</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <!-- Main Select Dropdown -->
                                                                    <select name="types_of_treat" id="types_of_treat"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>

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
                                                                    for="validationCustomUsername"><strong>Gamete
                                                                        Source</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="types_of_treat1" id="types_of_treat1"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" id="tot1"
                                                                            class="text-muted"
                                                                            {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == '' ? 'selected' : '' }}>
                                                                            <strong><b>Select</b></strong>
                                                                        </option>
                                                                        <option value="Self Oocyte & Donor Sperm"
                                                                            id="d_sperm" class="p-1"
                                                                            {{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') == 'Self Oocyte & Donor Sperm' ? 'selected' : '' }}>
                                                                            Self Oocyte & Donor Sperm
                                                                        </option>
                                                                        <option value="Donor Oocyte & Self Sperm"
                                                                            id="o_sperm" class="p-1"
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
                                                                    for="validationCustomUsername"><strong>Surrogate Mother
                                                                        Age
                                                                    </strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="surrogate_mother_age"
                                                                        id="surrogate_mother_age" class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
                                                                        <option value="" class="text-muted">
                                                                            <strong><b>Select Age</b></strong>
                                                                        </option>
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
                                                                        Undertaken</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select class="form-control" id="for_others"
                                                                        name="art_undertaken" disabled>
                                                                        <option
                                                                            value="In Vitro Fertilization-Embryo Transfer(IVF-ET)"
                                                                            {{ old('art_undertaken', $uhidDetails->art_undertaken ?? '') == 'In Vitro Fertilization-Embryo Transfer(IVF-ET)' ? 'selected' : '' }}>
                                                                            In Vitro Fertilization-Embryo Transfer(IVF-ET)
                                                                        </option>
                                                                        <option
                                                                            value="Intra-Cytoplasmic Sperm Injection(ICSI)"
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
                                                                    <input type="text" class="form-control"
                                                                        id="art_undertaken_other" value=""
                                                                        name="art_undertaken_other"
                                                                        aria-describedby="art_undertaken_other" disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" id="">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Total No. of
                                                                        Treatment
                                                                        Cycle(s) Undertaken
                                                                    </strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select name="total_nun_cycles" id="total_nun_cycles"
                                                                        class="form-control"
                                                                        aria-label=".form-select-lg example" disabled>
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
                                                                        Cancelled
                                                                    </strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">

                                                                    <input type="text" class="form-control"
                                                                        id="no_cycles" value="" name="no_cycles"
                                                                        aria-describedby="no_cycles" disabled>
                                                                </div>
                                                                @error('no_cycles')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-7 display-none-csp-clinic-one"
                                                            id="fail_reason">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Cycle
                                                                        Cancellation reason</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                        id="Cycle_fail_reason" value=""
                                                                        name="Cycle_fail_reason"
                                                                        aria-describedby="Cycle_fail_reason" disabled>

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
                                                                        Outcome</strong><span
                                                                        class="color-csp-clinic-two">*</span></label>
                                                                <div class="input-group">
                                                                    <select class="form-control" id="tratment_Outcome"
                                                                        name="tratment_Outcome" disabled>
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

                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Complications,
                                                                        If
                                                                        any</strong></label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" col="5" rows="3" name="comp_if_any" id="comp_if_any" disabled></textarea>
                                                                </div>
                                                                @error('other_gender')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="text-label form-label"
                                                                    for="validationCustomUsername"><strong>Remarks/ Any
                                                                        other relevant
                                                                        information</strong></label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" col="5" rows="3" name="remark" id="remark" disabled></textarea>
                                                                </div>
                                                                @error('remark')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <label class="text-label form-label"
                                                            for="validationCustomUsername"><strong>
                                                                Affidavit regarding
                                                                following to be taken on record:</strong></label>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="declaration" name="declaration" disabled>
                                                                <label class="form-check-label" for="gridCheck">
                                                                    From Surrogate Mother that she has not acted as a
                                                                    surrogate mother
                                                                    more than once in her lifetime.<span
                                                                        class="color-csp-clinic-two">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="declaration1" name="declaration1" disabled>
                                                                <label class="form-check-label" for="gridCheck">
                                                                    From intending
                                                                    couple or single woman (widow or divorcee) that they/she
                                                                    do/does not have any surviving child biologically or
                                                                    through
                                                                    adoption or through surrogacy earlier .
                                                                </label>

                                                            </div>
                                                        </div>


                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="declaration3" name="declaration3" disabled>
                                                                <label class="form-check-label" for="gridCheck">
                                                                    From Oocyte Donor that she has not donated oocytes more
                                                                    than once in
                                                                    her life time.
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="declaration4" name="declaration4" disabled>
                                                                <label class="form-check-label" for="gridCheck">
                                                                    From the ART Bank that the bank has not supplied
                                                                    sperm/oocyte of the
                                                                    same donor to more than one commissioning couple/single
                                                                    woman.
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- =======================================================Art Treatment Start==================================================================================== --}}
                                                <div class=" border p-3 rounded" id="art_treatment_form_section">
                                                    @include('layouts.clinic.edit_patient_surrogacy_application_form_art_treatment_outcome')
                                                </div>


                                                {{-- =================================================================ART Treatment End====================================================================================== --}}
                                            </div>



                                            <div class="col-md-12 mt-2 p-3">
                                                <div class="card border mb-3">

                                                    <div class="card-body">
                                                        <div class="row d-none" id="partB_section">


                                                            <h4 class="card-title csp-clinic-text-black"><strong>Part
                                                                    B</strong>
                                                            </h4>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="text-label form-label"
                                                                        for="validationCustomUsername"><strong>Pregnancy
                                                                            Outcome</strong><span
                                                                            class="bc-csp-clinic-three">*</span></label>
                                                                    <div class="input-group">
                                                                        <select class="form-control"
                                                                            id="preganancy_outcome"
                                                                            name="preganancy_outcome" >
                                                                            <option value="">Select</option>
                                                                            <option value="live birth">live birth</option>
                                                                            <option value="Stillbirth">Stillbirth</option>
                                                                            <option id="therapeutic_abortion"
                                                                                value="Therapeutic abortion">
                                                                                Therapeutic abortion</option>
                                                                            <option value="Spontaneous abortion">
                                                                                Spontaneous abortion / Missed abortion
                                                                            </option>
                                                                            <option id="elective_option"
                                                                                value="Elective Termination">Elective
                                                                                Termination</option>
                                                                            <option id="surro_special_option"
                                                                                value="Therapeutic abortion with consent of Surrogate mother & authorization by AA">
                                                                                Therapeutic abortion with consent of
                                                                                Surrogate mother & authorization by AA
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    @error('preganancy_outcome')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror

                                                                </div>
                                                            </div>




                                                            @php

                                                                $male_number = old(
                                                                    'male_number',
                                                                    $uhidDetails->male_number ?? '',
                                                                );
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
                                                                                <div
                                                                                    class="form-check custom-checkbox mb-3">
                                                                                    <label class="form-check-label"
                                                                                        for="customCheckBox1">Male</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col md-7">
                                                                                <div class="input-group">
                                                                                    <select name="male_number"
                                                                                        id="male_number"
                                                                                        class="form-control">
                                                                                        @for ($i = 0; $i <= 5; $i++)
                                                                                            <option
                                                                                                value="{{ $i }}">
                                                                                                {{ $i }}
                                                                                            </option>
                                                                                        @endfor
                                                                                    </select>
                                                                                    <span
                                                                                        class="input-group-text">Number</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4" id="female_hide">
                                                                        <div class="row d-flex gap-3">
                                                                            <div class="col-md-3 py-2">
                                                                                <div
                                                                                    class="form-check custom-checkbox mb-3">
                                                                                    <label class="form-check-label"
                                                                                        for="customCheckBox1">Female</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col md-7">
                                                                                <div class="input-group">
                                                                                    <select name="female_number"
                                                                                        id="female_number"
                                                                                        class="form-control">
                                                                                        @for ($i = 0; $i <= 5; $i++)
                                                                                            <option
                                                                                                value="{{ $i }}">
                                                                                                {{ $i }}
                                                                                            </option>
                                                                                        @endfor
                                                                                    </select>
                                                                                    <span
                                                                                        class="input-group-text">Number</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 dn-csp-clinic-two" id="live_birth_open">
                                                                <div class="mb-3">
                                                                    <label class="text-label form-label"
                                                                        for="validationCustomUsername"><strong>Live Birth
                                                                            Pregnancy
                                                                            Outcome</strong></label>
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="l_birth"
                                                                            name="l_birth" disabled>
                                                                            <option value="">Select</option>
                                                                            <option value="Singleton" id="Singleton1">
                                                                                Singleton
                                                                            </option>
                                                                            <option value="Twin">Twin</option>
                                                                            <option value="Higher Order">Higher Order
                                                                            </option>



                                                                        </select>

                                                                        <input type="hidden" name="l_birth"
                                                                            id="l_birth_hidden" value="">
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
                                                        </div>
                                                        <br>





                                                        <button type="button" id="closeBtn"
                                                            class="btn me-2 btn btn-danger">Close</button>
                                                        <button type="submit" name="updatev" value="Continue"
                                                            class="btn me-2 button-csp-clinic-four">Continue</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

    </div>






    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/select2.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        function fillForm(item) {
            console.log(item);

            $('#patient_uhid').val(item.pati_uhid).trigger('change');
            $('#p_id').val(item.id);
            $('#clinic_id').val(item.clinic_id);
            $('#quarter').val(item.quarter_name);
            $('#year').val(item.year);
            $('#clinic_level1_reg_num').val(item.cli_reg_name);
            $('#name_of_clinic').val(item.name_of_clinic);
            $('input[name="previous_treatment"][value="' + item.previous_treatment + '"]').prop('checked', true);
            $('input[name="art_case_of"][value="' + item.art_case_of + '"]').prop('checked', true);
            toggleCaseOf(item.art_case_of);
            $('#art_nationality').val(item.art_nationality);
            $('#art_nationality_wife').val(item.art_nationality_wife);
            toggleNationality('#art_nationality', '#art_other_nationality1');

            $('input[name="case_of"][value="' + item.case_of + '"]').prop('checked', true);
            $('#art_other_nationality_wife').val(item.art_other_nationality_wife);
            $('#other_nationality').val(item.other_nationality);
            $('#nationality_wifeedit').val(item.nationality_wife);
            $('#nationality').val(item.nationality);
            $('#other_nationality').val(item.other_nationality);
            $('#nationality_wife').val(item.nationality_wife);
            $('#other_nationality_wife').val(item.other_nationality_wife);
            $('#age').val(item.age);
            $('#wife_age').val(item.wife_age);
            $('#age_of_women1').val(item.age_of_women1);
            $('#num_pre_child').val(item.num_pre_child);
            $('#give_details').val(item.child_give_details);
            $('#child_medical_certificate').val(item.surrogacypatient_child_medicalcertificate_docs);
            $('#uterus_ab').prop('checked', item.uterus_ab === 'Y');
            $('#ivf_failure').prop('checked', item.ivf_failure === 'Y');
            $('#preg_loss').prop('checked', item.preg_loss === 'Y');
            $('#life_threat').prop('checked', item.life_threat === 'Y');
            $('#male_factor').prop('checked', item.male_factor === 'Y');
            $('#art_age_hus_wife').val(item.art_age_hus_wife);
            $('input[name="treatment_type"][value="' + item.treatment_type + '"]').prop('checked', true).trigger('change');
            handlePregnancyOptions(item.treatment_type);
            $('#art_wife_age').val(item.art_wife_age);
            $('#art_age_of_women').val(item.art_age_of_women);
            $('#art_cause_of_infretily').val(item.art_cause_of_infretily);
            $('#art_male_factor').prop('checked', item.art_male_factor === 'Y');
            $('#art_female_factor').prop('checked', item.art_female_factor === 'Y');
            $('#art_unexplained').prop('checked', item.art_unexplained === 'Y');
            setSelect('#art_proc_undertaken', item.art_proc_undertaken);
            setSelect('#art_undertaken_other', item.art_undertaken_other);
            setSelect('#art_types_of_treat', item.art_types_of_treat);
            setSelect('#art_types_of_treat1', item.art_types_of_treat1);
            setSelect('#art_total_num_of_cyc', item.art_total_num_of_cyc);
            setSelect('#art_no_cycles', item.art_no_cycles);
            $('#art_complicatoins_if_any').val(item.art_complicatoins_if_any);
            setSelect('#art_treat_outcomes', item.art_treat_outcomes);
            if (item.preganancy_outcome) {
                $('#preganancy_outcome').val(item.preganancy_outcome).trigger('change');
            }

            $('#l_birth').val(item.l_birth);
            $('#male_number').val(item.male_number ?? '0');
            $('#female_number').val(item.female_number ?? '0');
            $('#complicatoins_if_any').val(item.complicatoins_if_any);
            $('#art_remark').val(item.art_remark);
            $('#for_others').val(item.art_undertaken);
            $('#surrogate_mother_age').val(item.surrogate_mother_age);
            $('#medical_surrogacy').val(item.medical_surrogacy);
            setSelect('#types_of_treat', item.types_of_treat);
            setSelect('#types_of_treat1', item.types_of_treat1);
            $('#art_undertaken_other').val(item.art_undertaken_other);
            setSelect('#total_nun_cycles', item.total_nun_cycles);
            $('#no_cycles').val(item.no_cycles);
            setSelect('#tratment_Outcome', item.tratment_Outcome);
            $('#Cycle_fail_reason').val(item.Cycle_fail_reason);
            $('#remark').val(item.remark);
            $('#comp_if_any').val(item.comp_if_any);

            $('#art_treatment_form_section').prop('checked', item.art_treatment_form_section == 'on');
            $('#art_declaration1').prop('checked', item.art_declaration1 == 'on');
            $('#declaration').prop('checked', item.declaration == 'on');
            $('#declaration1').prop('checked', item.declaration1 == 'on');
            $('#declaration3').prop('checked', item.declaration3 == 'on');
            $('#declaration4').prop('checked', item.declaration4 == 'on');

            togglePregnancy(item);
            $('#partB_section').removeClass('d-none');
        }

        function setSelect(id, value) {
            if (value) {
                $(id).html(`<option value="${value}" selected>${value}</option>`);
            } else {
                $(id).html(`<option value="">Select</option>`);
            }
        }

        function toggleCaseOf(value) {
            if (value === 'one') {
                // Couple
                $('#art_nationality_husband').show();
                $('#art_other_nationality1').show();
                $('#art_nationality_wife1').show();
                $('#art_other_nationality1_wife').show();
                $('.one').show();
                $('.two').hide();
            } else if (value === 'two') {
                // Single Woman
                $('#art_nationality_husband').hide();
                $('#art_other_nationality1').hide();
                $('#art_nationality_wife1').show();
                $('#art_other_nationality1_wife').show();
                $('.one').hide();
                $('.two').show();
            }
        }

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


        function toggleNationality() {
            let husbandVal = $('#art_nationality').val();
            let wifeVal = $('#art_nationality_wife').val();


            if (husbandVal === 'Foreigner') {
                $('#art_other_nationality1').removeClass('hide-important');
            } else {
                $('#art_other_nationality1').addClass('hide-important');
                $('#art_other_nationality').val('');
            }


            if (wifeVal === 'Foreigner') {
                $('#art_other_nationality1_wife').removeClass('hide-important');
            } else {
                $('#art_other_nationality1_wife').addClass('hide-important');
                $('#art_other_nationality_wife').val('');
            }
        }

        function togglePregnancy(item) {

            let artOutcome = (item.art_treat_outcomes || '').toLowerCase().trim();
            let surroOutcome = (item.tratment_Outcome || '').toLowerCase().trim();

            if (artOutcome === 'Pregnant' && surroOutcome === 'Pregnant') {


                $('#partB_section').removeClass('d-none');


                $('#preganancy_outcome1').show();

                $('#gender_child1').removeClass('hidden');
                $('#live_birth_open').show();

                $('#l_birth').prop('disabled', false);

            } else {

                $('#partB_section').addClass('d-none');

                $('#preganancy_outcome1').hide();
                $('#gender_child1').addClass('hidden');
                $('#live_birth_open').hide();

                $('#l_birth').prop('disabled', true).val('');
            }
        }

        let patientData = [];
        $('#partB_section').addClass('d-none');
        $(document).on('click', '.openForm', function(e) {
            e.preventDefault();

            let quarter = $(this).data('quarter');
            let year = $(this).data('year');

            let item = patientData.find(p =>
                p.quarter == quarter && p.year == year
            );

            if (item) {
                fillForm(item);
                $('#editForm').show();

                $('html, body').animate({
                    scrollTop: $('#editForm').offset().top
                }, 500);
            }
        });
        $('#patient_uhid').on('select2:select', function(e) {

            let selectedId = e.params.data.id;

            if (!selectedId) {
                alert('Enter UHID');
                return;
            }

            $('#quarterSection').hide();
            $('#editForm').hide();
            $('#quarterTableBody').html('');

            $.ajax({
                url: "{{ route('search.uhid_formsurrogacy') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    uhid: selectedId
                },

                success: function(response) {

                    if (!response.status || !response.data.length) {
                        alert(response.message || 'No data found');
                        return;
                        $('#partB_section').addClass('d-none');
                    }
                    $('#partB_section').removeClass('d-none');
                    patientData = response.data;
                    console.log(patientData);

                    let grouped = {};

                    patientData.forEach(item => {

                        let key = item.quarter + '_' + item.year;

                        if (!grouped[key]) {
                            grouped[key] = {
                                quarter: item.quarter,
                                year: item.year
                            };
                        }
                    });

                    let groupArray = Object.values(grouped);
                    if (groupArray.length === 1) {

                        let g = groupArray[0];

                        let item = patientData.find(p =>
                            p.quarter == g.quarter && p.year == g.year
                        );

                        fillForm(item);  
                        $('#editForm').show();
                        return;
                    }
                    let rows = '';
                    let i = 1;
                groupArray.forEach(g => {

    // Find full data for this quarter/year
    let item = patientData.find(p =>
        p.quarter == g.quarter && p.year == g.year
    );

    

    let treatmentValue = '-';

    if (item?.treatment_type === 'art_treatment') {
        treatmentValue = item.art_types_of_treat ?? '-';
    } else if (item?.treatment_type === 'surrogacy') {
        treatmentValue = item.types_of_treat ?? '-';
    }
     let treatmentoutcome = '-';

    if (item?.treatment_type === 'art_treatment') {
        treatmentoutcome = item.art_treat_outcomes ?? '-';
    } else if (item?.treatment_type === 'surrogacy') {
        treatmentoutcome = item.tratment_Outcome ?? '-';
    }


    rows += `
        <tr>
            <td>${i++}</td>
            <td>
                <a href="#" class="openForm"
                    data-quarter="${g.quarter}"
                    data-year="${g.year}">
                    Q${g.quarter}, ${g.year}
                </a>
            </td>
            
        </tr>
    `;
});
                    $('#quarterTableBody').html(rows);
                    $('#quarterSection').show();
                }
            });
        });


        $('#patient_uhid').select2({
            placeholder: "Search UHID",
            allowClear: true,
            ajax: {
                url: "{{ route('search.uhidsurro') }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>


    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {
            const closeButton = document.getElementById("closeBtn");

            if (closeButton) {
                closeButton.addEventListener("click", function() {
                    window.location.href = "{{ route('clinic.list_surrogacy_patient_outcome_view') }}";
                });
            }
        });
    </script>


    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/add_patient_surrogacy_application_form_part_2.js') }}">
    </script>




    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {

            function toggleForm(value) {
                if (value === "art_treatment") {
                    $('#art_treatment_form_section').show();
                    $('#surrogacy_form_section').hide();
                } else if (value === "surrogacy") {
                    $('#surrogacy_form_section').show();
                    $('#art_treatment_form_section').hide();
                } else {

                    $('#art_treatment_form_section').hide();
                    $('#surrogacy_form_section').hide();
                }
            }
            let selected = $('input[name="treatment_type"]:checked').val();
            toggleForm(selected);
            $('input[name="treatment_type"]').on('change', function() {
                toggleForm(this.value);
            });

        });



        $(document).ready(function() {

            let selected = $('input[name="art_case_of"]:checked').val();
            if (selected) {
                toggleCaseOf(selected);
            }

            $('input[name="art_case_of"]').on('change', function() {
                toggleCaseOf($(this).val());
            });

        });


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

            if (selectedTotal) {
                populateNoCycles(parseInt(selectedTotal), selectedCycles);
            }

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


            coupleRadio.addEventListener("change", toggleFields);
            singleWomanRadio.addEventListener("change", toggleFields);

            nationalityHusbandSelect.addEventListener("change", toggleCountryFields);
            nationalityWifeSelect.addEventListener("change", toggleCountryFields);
            forOthers.addEventListener("change", toggleothersIdUnderTaken);


            toggleFields();
            toggleCountryFields();
            toggleNumPreChild();
            toggleothersIdUnderTaken();
        });

        $('#no_cycles').on('change', function() {
            var num_of_child = $('#no_cycles').val();
            if (num_of_child > 0) {
                $('#fail_reason').show();
            } else {
                $('#fail_reason').hide();
                $('#Cycle_fail_reason').val('');
            }

        });






        //part b 
    </script>

    <script nonce="{{ $cspNonce }}">
        $('#preganancy_outcome').on('change', function() {
            $("#l_birth").val('');

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
            } else if (this.value ==
                'Therapeutic abortion with consent of Surrogate mother & authorization by AA') {
                $("#gender_child1").hide();
                $("#live_birth_open").hide();
            }

        });


        $('#preganancy_outcome').on('change', function() {

            let value = $(this).val();

            if (value === 'live birth') {


                $('#live_birth_open').show();
                $('#gender_child1').removeClass('hidden').show();

                $('#l_birth').prop('disabled', false);

            } else {


                $('#live_birth_open').hide();
                $('#gender_child1').addClass('hidden');

                $('#l_birth').prop('disabled', true);


                $('#l_birth').val('');
                $('#male_number').val('0');
                $('#female_number').val('0');
            }
        });
    </script>


@endsection
