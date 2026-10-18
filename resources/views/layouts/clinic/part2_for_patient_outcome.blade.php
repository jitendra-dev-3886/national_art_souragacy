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

                    {{-- <title>Application form for transfer of Gametes (sperms Oocyte)/Embryos (Within
            and Outside India)</title> --}}

                    {{-- <div class="container mt-5"> --}}
                    <h3 class="card-title mb-5 text-primary">Edit Patient information form for ART Clinic</h3>


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

                        <form id="art_clin1" name="art_clin1" method="POST"
                            action="{{ route('clinic.patient_save_part_two_application_form_patientnew') }}"
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

                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label d-block">
                                                    <strong>Year and Quarter</strong>
                                                </label>
                                                <div class="d-flex gap-3">

                                                    <input type="text"
                                                        class="form-control width-csp-clinic-one csp-readonlycolor"
                                                        name="year" id="year" value="" disabled>
                                                    <input type="hidden" class="form-control width-csp-clinic-one"
                                                        name="quarter" value="" disabled>

                                                    <input type="text"
                                                        class="form-control width-csp-clinic-one csp-readonlycolor"
                                                        id="quarter" value=""readonly>
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
                                                        for="validationCustomUsername"><strong>Clinic Registration
                                                            Number</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control csp-readonlycolor"
                                                            name="clinic_level1_reg_num" id="clinic_level1_reg_num"
                                                            aria-describedby="clinic_level1_reg_num" placeholder=""
                                                            disabled>
                                                    </div>
                                                    <span id="clinic_level1_reg_numID" class="bc-csp-clinic-three"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Name of the
                                                            Clinic</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control csp-readonlycolor"
                                                            name="name_of_clinic" id="name_of_clinic"
                                                            aria-describedby="name_of_clinic" placeholder="" disabled>
                                                    </div>
                                                    <span id="name_of_clinicID" class="bc-csp-clinic-three"></span>
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
                                                                id="flexRadioDefault1" value="one" required disabled>
                                                            <label class="form-check-label" for="case_of_couple">
                                                                Couple
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="case_of"
                                                                id="flexRadioDefault2" value="two" required disabled>
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


                                            <div class="col-md-2 dn-csp-clinic-two" id="nationality_husband">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Nationality of the
                                                            Husband</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">

                                                        <input name="nationality" id="nationality" class="form-control"
                                                            aria-label=".form-select-lg example" disabled>



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

                                                        <input name="other_nationality" id="other_nationality"
                                                            class="form-control" disabled>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 dn-csp-clinic-two" id="nationality_wife1">
                                                <div class="mb-3">
                                                    <label class="text-label form-label" id="nationality_woman_lable"
                                                        for="nationality_wife"><strong>Nationality of the
                                                            Wife</strong><span class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">

                                                        @php
                                                            $selectedNationality = old('nationality_wife' ?? '');
                                                        @endphp
                                                        <input name="nationality_wife" id="nationality_wifeedit"
                                                            class="form-control" aria-label=".form-select-lg example"
                                                            disabled>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 dn-csp-clinic-two" id="other_nationality1_wife">
                                                <div class="mb-3">
                                                    <label class="control-label"><strong>Country</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <input name="other_nationality_wife" id="other_nationality_wife"
                                                            class="form-control" disabled>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 one selectt {{ old('age_hus_wife' ?? '') ? '' : 'hidden' }}"
                                                id="one_couple">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Husband Age</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <select name="age_hus_wife" id="age_hus_wife"
                                                            class="form-control" aria-label=".form-select-lg example"
                                                            disabled>
                                                            <option value="" class="text-muted"><strong><b>Select
                                                                        Age</b></strong></option>
                                                            <?php for ($i = 21; $i <= 55; $i++) {
                                                                $selected = $i == old('age_hus_wife', $uhidDetails->age_hus_wife ?? '') ? 'selected' : '';
                                                                echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    @error('age_hus_wife')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3 one selectt {{ old('wife_age' ?? '') ? '' : 'hidden' }}"
                                                id="one_couple">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Wife Age</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <select name="wife_age" id="wife_age" class="form-control"
                                                            aria-label=".form-select-lg example" disabled>
                                                            <option value="" class="text-muted"><strong><b>Select
                                                                        Age</b></strong></option>
                                                            <?php for ($i = 21; $i <= 50; $i++) {
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
                                            <div class="col-md-3 two selectt age-women-section {{ old('age_of_women' ?? '') ? '' : 'hidden' }}"
                                                id="single">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Age of Woman</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <select name="age_of_women" id="age_of_women"
                                                            class="form-control" disabled>
                                                            <option value="">Select Age</option>

                                                            @for ($i = 21; $i <= 50; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor

                                                        </select>
                                                    </div>
                                                    @error('age_of_women')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="border p-3 rounded">
                                                <label class="form-label mb-3 d-block">
                                                    <strong>Cause of Infertility</strong><span
                                                        class="bc-csp-clinic-three">*</span>
                                                </label>

                                                <div class="row">
                                                    <div class="col-md-2" id="male_factor_div">
                                                        <div
                                                            class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                            <input class="form-check-input me-2" type="checkbox"
                                                                id="male_factor" name="male_factor" value="Y"
                                                                disabled>
                                                            <label class="form-check-label" for="male_factor">
                                                                <strong>Male Factor</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div
                                                            class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                            <input class="form-check-input me-2" type="checkbox"
                                                                id="female_factor" name="female_factor" value="Y"
                                                                disabled>
                                                            <label class="form-check-label" for="female_factor">
                                                                <strong>Female Factor</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div
                                                            class="form-check mb-2 d-flex align-items-center justify-content-center">
                                                            <input class="form-check-input me-2" type="checkbox"
                                                                id="unexplained" name="unexplained" disabled>
                                                            <label class="form-check-label" for="unexplained">
                                                                <strong>Unexplained</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="input-group mt-2">
                                                            <input type="text" class="form-control"
                                                                name="cause_of_infretily" id="cause_of_infretily"
                                                                aria-describedby="cause_of_infretily" placeholder=""
                                                                disabled>
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
                                                        <strong>ART Procedure Undertaken</strong><span
                                                            class="bc-csp-clinic-three">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="art_proc_undertaken" id="art_proc_undertaken"
                                                            class="form-control" aria-label=".form-select-lg example"
                                                            disabled>

                                                        </select>
                                                    </div>
                                                    @error('art_proc_undertaken')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-md-4 dn-csp-clinic-two" id="others_id">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Others</strong></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            name="art_undertaken_other" id="art_undertaken_other"
                                                            aria-describedby="art_undertaken_other" disabled>
                                                    </div>
                                                    @error('art_undertaken_other')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="text-label form-label" for="validationCustomUsername">
                                                        <strong>Type of Treatment</strong><span
                                                            class="bc-csp-clinic-three">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="types_of_treat" id="types_of_treat"
                                                            class="form-control" aria-label=".form-select-lg example"
                                                            disabled>

                                                        </select>
                                                    </div>
                                                    @error('types_of_treat')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="type_of_donation_section">
                                                <div class="mb-3">
                                                    <label class="text-label form-label" for="validationCustomUsername">
                                                        <strong>Type of Donation</strong><span
                                                            class="bc-csp-clinic-three">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="types_of_treat1"
                                                            id="types_of_treat1" aria-describedby="types_of_treat1"
                                                            disabled>
                                                    </div>
                                                    @error('types_of_treat1')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- style="{{ old('types_of_treat1', $uhidDetails->types_of_treat1 ?? '') ? '' : 'display:none;' }}" --}}

                                            <div class="col-md-4" id="">
                                                <div class="mb-3">
                                                    <label class="text-label form-label" for="validationCustomUsername">
                                                        <strong>Total No. of Treatment Cycle(s) Undertaken</strong><span
                                                            class="bc-csp-clinic-three">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <select name="total_num_of_cyc" id="total_num_of_cyc"
                                                            class="form-control" aria-label=".form-select-lg example"
                                                            disabled>

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
                                                        for="validationCustomUsername"><strong>No. of Cycles Cancelled, if
                                                            any </strong>
                                                        <span class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="no_cycles"
                                                            value="" name="no_cycles" aria-describedby="no_cycles"
                                                            disabled>
                                                    </div>
                                                    @error('no_cycles')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-7 dn-csp-clinic-two" id="fail_reason">
                                                <div class="mb-3">
                                                    <label class="text-label form-label"
                                                        for="validationCustomUsername"><strong>Cycle Cancellation
                                                            reason</strong><span
                                                            class="bc-csp-clinic-three">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            id="cyc_canc_failure_reason" name="cyc_canc_failure_reason"
                                                            aria-describedby="cyc_canc_failure_reason" disabled>
                                                    </div>
                                                    @error('cyc_canc_failure_reason')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="text-label form-label" for="complicatoins_if_any">
                                                        <strong>Complications, if any</strong>
                                                    </label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="complicatoins_if_any" id="complicatoins_if_any"
                                                            aria-describedby="complicatoins_if_any" disabled></textarea>
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
                                                        <textarea class="form-control" name="remark" id="remark" rows="3" aria-describedby="remark" disabled></textarea>
                                                    </div>
                                                    <span id="remark_error" class="bc-csp-clinic-three"></span>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="text-label form-label">
                                                        <strong>Required Affidavit regarding following to be taken on
                                                            record:</strong>
                                                    </label>

                                                    <div class="col-12" id="declaration_hide">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="declaration" name="declaration" disabled>
                                                            <label class="form-check-label" for="declaration">
                                                                From Oocyte Donor that she has not donated oocytes more than
                                                                once in her lifetime.
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="declaration1" name="declaration1" disabled>
                                                            <label class="form-check-label" for="declaration1">
                                                                From the ART Bank that the bank has not supplied
                                                                sperm/oocyte of the same donor to more than one
                                                                commissioning couple/single woman.
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">

                                            <div class="card-body">
                                                <div class="row">

                                                    <div class="mb-3">
                                                        <h4 class="card-title csp-clinic-text-black"><strong>Part
                                                                B</strong>
                                                        </h4>

                                                        <div class ="row">
                                                            <div class="col-md-12">


                                                                <div class="col-md-3 dn-csp-clinic-two"
                                                                    id="aadhar_no_hus_div">
                                                                    <div class="mb-3">
                                                                        <label class="text-label form-label"
                                                                            for="aadhar_no_hus">
                                                                            <strong>Aadhar No. of the husband</strong>
                                                                            <span class="bc-csp-clinic-three">*</span>
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <input name="aadhar_no_hus" id="aadhar_no_hus"
                                                                                class="form-control"
                                                                                aria-label=".form-select-lg example">
                                                                        </div>
                                                                        <span id="aadhar_no_hus_error"
                                                                            class="text-danger"></span>
                                                                        @error('aadhar_no_hus')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 dn-csp-clinic-two"
                                                                    id="aadhar_no_wife_div">
                                                                    <div class="mb-3">
                                                                        <label class="text-label form-label"
                                                                            for="aadhar_no_wife">
                                                                            <strong>Aadhar No. of Wife</strong>
                                                                            <span class="bc-csp-clinic-three">*</span>
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <input name="aadhar_no_wife"
                                                                                id="aadhar_no_wife" class="form-control"
                                                                                aria-label=".form-select-lg example">
                                                                        </div>
                                                                        <span id="aadhar_no_wife_error"
                                                                            class="text-danger"></span>
                                                                        @error('aadhar_no_wife')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 dn-csp-clinic-two"
                                                                    id="aadhar_no_sw_div">
                                                                    <div class="mb-3">
                                                                        <label class="text-label form-label"
                                                                            for="aadhar_no_sw">
                                                                            <strong>Aadhar No. of Single women</strong>
                                                                            <span class="bc-csp-clinic-three">*</span>
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <input name="aadhar_no_sw" id="aadhar_no_sw"
                                                                                class="form-control"
                                                                                aria-label=".form-select-lg example">
                                                                        </div>
                                                                        <span id="aadhar_no_sw_error"
                                                                            class="text-danger"></span>
                                                                        @error('aadhar_no_sw')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 dn-csp-clinic-two"
                                                                    id="aadhar_no_oocyte_div">
                                                                    <div class="mb-3">
                                                                        <label class="text-label form-label"
                                                                            for="aadhar_no_oocyte">
                                                                            <strong>Aadhar No. of oocyte Donor (if
                                                                                any)</strong>
                                                                            <span class="bc-csp-clinic-three">*</span>
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <input name="aadhar_no_oocyte"
                                                                                id="aadhar_no_oocyte" class="form-control"
                                                                                aria-label=".form-select-lg example">
                                                                        </div>
                                                                        <span id="aadhar_no_oocyte_error"
                                                                            class="text-danger"></span>
                                                                        @error('aadhar_no_oocyte')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3 dn-csp-clinic-two mt-3"
                                                                    id="aadhar_no_semen_div">
                                                                    <div class="mb-3">
                                                                        <label class="text-label form-label"
                                                                            for="aadhar_no_semen">
                                                                            <strong>Aadhar No. of semen Donor (if
                                                                                any)</strong>
                                                                            <span class="bc-csp-clinic-three">*</span>
                                                                        </label>

                                                                        <div class="input-group">
                                                                            <input name="aadhar_no_semen"
                                                                                id="aadhar_no_semen" class="form-control"
                                                                                aria-label=".form-select-lg example">
                                                                        </div>
                                                                        <span id="aadhar_no_semen_error"
                                                                            class="text-danger"></span>
                                                                        @error('aadhar_no_semen')
                                                                            <span
                                                                                class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>



                                                                <div class="col-md-12 dn-csp-clinic-two"
                                                                    id="semen_details_div">

                                                                    <div class="mb-3">
                                                                        <h5><strong>Semen Details</strong></h5>
                                                                        <hr>
                                                                    </div>

                                                                    <div class="row">

                                                                        <!-- Husband -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label" for="husband_semen">
                                                                                <strong>Husband</strong>
                                                                            </label>
                                                                            <input type="text" name="husband_semen"
                                                                                id="husband_semen" class="form-control">

                                                                            <span class="text-danger"
                                                                                id="husband_semen_error"></span>
                                                                            @error('husband_semen')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Donor -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label" for="donor_semen">
                                                                                <strong>Donor</strong>
                                                                            </label>
                                                                            <input type="text" name="donor_semen"
                                                                                id="donor_semen" class="form-control">
                                                                            <span class="text-danger"
                                                                                id="donor_semen_error"></span>
                                                                            @error('donor_semen')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Semen Vials Used -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label"
                                                                                for="no_of_semen_vials_used">
                                                                                <strong>No. of Semen Vials Used</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_semen_vials_used"
                                                                                id="no_of_semen_vials_used"
                                                                                class="form-control">
                                                                            <span class="text-danger"
                                                                                id="no_of_semen_vials_used_error"></span>
                                                                            @error('no_of_semen_vials_used')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Semen Vials Discarded -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label"
                                                                                for="no_of_semen_vials_discarded">
                                                                                <strong>No. of Semen Vials Discarded (if
                                                                                    any)</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_semen_vials_discarded"
                                                                                id="no_of_semen_vials_discarded"
                                                                                class="form-control">
                                                                            <span class="text-danger"
                                                                                id="no_of_semen_vials_discarded_error"></span>
                                                                            @error('no_of_semen_vials_discarded')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <!-- Semen Vials Frozen -->
                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label"
                                                                                for="no_of_semen_vials_frozen">
                                                                                <strong>No. of Semen Vials Frozen</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_semen_vials_frozen"
                                                                                id="no_of_semen_vials_frozen"
                                                                                class="form-control">
                                                                            <span class="text-danger"
                                                                                id="no_of_semen_vials_frozen_error"></span>
                                                                            @error('no_of_semen_vials_frozen')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-12 dn-csp-clinic-two"
                                                                    id="oocyte_details_div">

                                                                    <div class="mb-3">
                                                                        <h5><strong>Oocyte Details</strong></h5>
                                                                        <hr>
                                                                    </div>

                                                                    <div class="row">


                                                                        <div class="col-md-6 mb-3">
                                                                            <label
                                                                                class="form-label"><strong>Self</strong></label>
                                                                            <input type="text" name="self_oocyte"
                                                                                id="self_oocyte" class="form-control">
                                                                                <span class="text-danger" id="self_oocyte_error"></span>
                                                                            @error('self_oocyte')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                        <div class="col-md-6 mb-3">
                                                                            <label
                                                                                class="form-label"><strong>Donor</strong></label>
                                                                            <input type="text" name="donor_oocyte"
                                                                                id="donor_oocyte" class="form-control">
                                                                                <span class="text-danger" id="donor_oocyte_error"></span>
                                                                            @error('donor_oocyte')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of Oocytes Retrieved</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_oocytes_used_retrived"
                                                                                id="no_of_oocytes_used_retrived"
                                                                                class="form-control">
                                                                                <span class="text-danger" id="no_of_oocytes_used_retrived_error"></span>
                                                                            @error('no_of_oocytes_used_retrived')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of Oocytes Used for Embryo
                                                                                    Creation</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_oocyted_used_for_embryo_creation"
                                                                                id="no_of_oocyted_used_for_embryo_creation"
                                                                                class="form-control">
                                                                                <span class="text-danger" id="no_of_oocyted_used_for_embryo_creation_error"></span>
                                                                            @error('no_of_oocyted_used_for_embryo_creation')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of Oocytes Discarded (if
                                                                                    any)</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_oocyte_discarded"
                                                                                id="no_of_oocyte_discarded"
                                                                                class="form-control">

                                                                                <span class="text-danger" id="no_of_oocyte_discarded_error"></span>

                                                                            @error('no_of_oocyte_discarded')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>


                                                                        <div class="col-md-6 mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of Frozen Oocytes</strong>
                                                                            </label>
                                                                            <input type="text"
                                                                                name="no_of_frozen_oocyte"
                                                                                id="no_of_frozen_oocyte"
                                                                                class="form-control">

                                                                                <span class="text-danger" id="no_of_frozen_oocyte_error"></span>
                                                                            @error('no_of_frozen_oocyte')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>

                                                                    </div>

                                                                </div>


                                                                <div class="row" id="embryo_details_of_patient_div">
                                                                    <div class="col-md-12 mt-3">
                                                                        <h5><strong>Embryo details of patient:</strong></h5>
                                                                        <hr>
                                                                    </div>
                                                                    <!-- Embryo Transferred -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of embryos transferred
                                                                                    (ET/FET)</strong>
                                                                            </label>

                                                                            <input type="text"
                                                                                name="no_of_embryos_transferred"
                                                                                id="no_of_embryos_transferred"
                                                                                class="form-control">

                                                                            @error('no_of_embryos_transferred')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- Discarded Embryos -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of discarded embryos (if
                                                                                    any)</strong>
                                                                            </label>

                                                                            <input type="text"
                                                                                name="no_of_embryos_discarded"
                                                                                id="no_of_embryos_discarded"
                                                                                class="form-control">

                                                                            @error('no_of_embryos_discarded')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- Frozen Embryos -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>No. of frozen embryos</strong>
                                                                            </label>

                                                                            <input type="text"
                                                                                name="no_of_frozen_embryos"
                                                                                id="no_of_frozen_embryos"
                                                                                class="form-control">

                                                                            @error('no_of_frozen_embryos')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- Heading -->
                                                                    <div class="col-md-12 mt-3">
                                                                        <h5><strong>No. of procedures conducted at your
                                                                                center</strong></h5>
                                                                        <hr>
                                                                    </div>

                                                                    <!-- IUI -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>IUI</strong>
                                                                            </label>

                                                                            <input type="text" name="iui"
                                                                                id="iui" class="form-control">

                                                                            @error('iui')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- IVF-ET -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>IVF-ET</strong>
                                                                            </label>

                                                                            <input type="text" name="ivf_et"
                                                                                id="ivf_et" class="form-control">

                                                                            @error('ivf_et')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- ICSI-ET -->
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">
                                                                                <strong>ICSI-ET</strong>
                                                                            </label>

                                                                            <input type="text" name="icsi_et"
                                                                                id="icsi_et" class="form-control">

                                                                            @error('icsi_et')
                                                                                <span
                                                                                    class="text-danger">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4" id="">

                                                        <div class="mb-3">
                                                            <label class="text-label form-label"
                                                                for=""><strong>Treatment
                                                                    Outcome</strong><span
                                                                    class="bc-csp-clinic-three">*</span></label>
                                                            <div class="input-group">
                                                                <select name="treat_outcomes" id="treat_outcomes"
                                                                    class="form-control"
                                                                    aria-label=".form-select-lg example" disabled>



                                                                </select>
                                                            </div>
                                                            @error('treat_outcomes')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                        </div>
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
                                                                    <option value="live birth">live birth</option>
                                                                    <option value="Stillbirth">Stillbirth</option>
                                                                    <option value="Therapeutic abortion">Therapeutic
                                                                        abortion</option>
                                                                    <option value="Spontaneous abortion">Spontaneous
                                                                        abortion / Missed abortion</option>
                                                                    <option value="Elective Termination">Elective
                                                                        Termination</option>
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
                                                                                    <option value="{{ $i }}">
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
                                                                            <select name="female_number"
                                                                                id="female_number" class="form-control">
                                                                                @for ($i = 0; $i <= 5; $i++)
                                                                                    <option value="{{ $i }}">
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
                                                                <select class="form-control" id="l_birth"
                                                                    name="l_birth" disabled>
                                                                    <option value="">Select</option>
                                                                    <option value="Singleton" id="Singleton1">
                                                                        Singleton
                                                                    </option>
                                                                    <option value="Twin">Twin</option>
                                                                    <option value="Higher Order">Higher Order</option>



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
                                                                birthSelect.selec tedIndex = 0;

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
                                                            .

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







    </div>
    </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>

    </div>
    </div>
    </div>

    </div>

    </div>

    </div>
    </div>
    </div>
    </div>
    </div>








    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/select2.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        function fillForm(item) {


            $('#patient_uhid').val(item.patient_uhid);
            $('#p_id').val(item.id);
            $('#clinic_id').val(item.clinic_id);
            $('#quarter').val(item.quarter_description);
            $('#year').val(item.year);
            $('#clinic_level1_reg_num').val(item.clinic_level1_reg_num);
            $('#name_of_clinic').val(item.name_of_clinic);

            $('input[name="previous_treatment"][value="' + item.previous_treatment + '"]')
                .prop('checked', true);

            $('input[name="case_of"][value="' + item.case_of + '"]')
                .prop('checked', true);

            $('#nationality').val(item.nationality);
            $('#other_nationality').val(item.other_nationality);

            $('#nationality_wifeedit').val(item.nationality_wife);
            $('#other_nationality_wife').val(item.other_nationality_wife);

            $('#age_hus_wife').val(item.age_hus_wife);
            $('#wife_age').val(item.wife_age);
            $('#age_of_women').val(item.age_of_women);

            $('#cause_of_infretily').val(item.cause_of_infretily);

            $('#male_factor').prop('checked', item.male_factor === 'Y');
            $('#female_factor').prop('checked', item.female_factor === 'Y');
            $('#unexplained').prop('checked', item.unexplained === 'Y');

            setSelect('#art_proc_undertaken', item.art_proc_undertaken);
            setSelect('#art_undertaken_other', item.art_undertaken_other);
            setSelect('#types_of_treat', item.types_of_treat);

            $('#types_of_treat1').val(item.types_of_treat1).trigger('change');
            setSelect('#total_num_of_cyc', item.total_num_of_cyc);

            $('#no_cycles').val(item.no_cycles);
            $('#cyc_canc_failure_reason').val(item.cyc_canc_failure_reason);

            setSelect('#treat_outcomes', item.treat_outcomes);

            $('#preganancy_outcome').val(item.preganancy_outcome);

            $('#l_birth').val(item.l_birth);

            $('#male_number').val(item.male_number ?? '0');
            $('#female_number').val(item.female_number ?? '0');

            $('#complicatoins_if_any').val(item.complicatoins_if_any);

            $('#remark').val(item.remark);

            $('#declaration').prop('checked', item.declaration == 'on');
            $('#declaration1').prop('checked', item.declaration1 == 'on');


            if (item.case_of === 'one') {

                $('#nationality_husband').show();
                $('#nationality_wife1').show();

                $('#other_nationality1').show();
                $('#other_nationality1_wife').show();

                $('#age_hus_wife').closest('.col-md-3').show();
                $('#wife_age').closest('.col-md-3').show();

                $('#age_of_women').closest('.col-md-3').hide();

                $('#aadhar_no_hus_div').show();
                $('#aadhar_no_wife_div').show();
                $('#aadhar_no_sw_div').hide();
                $('#aadhar_no_oocyte_div').show();
                $('#aadhar_no_semen_div').hide();

            } else if (item.case_of === 'two') {

                $('#nationality_husband').hide();
                $('#nationality_wife1').show();

                $('#other_nationality1').hide();
                $('#other_nationality1_wife').show();

                $('#age_hus_wife').closest('.col-md-3').hide();
                $('#wife_age').closest('.col-md-3').hide();

                $('#age_of_women').closest('.col-md-3').show();

                $('#aadhar_no_hus_div').hide();
                $('#aadhar_no_wife_div').hide();
                $('#aadhar_no_sw_div').show();
                $('#aadhar_no_oocyte_div').hide();
            }

            if (item.types_of_treat1 === 'Oocyte Donation') {
                $('#aadhar_no_oocyte_div').show();
                $('#aadhar_no_semen_div').hide();
               // $('#semen_details_div').hide();
                $('#oocyte_details_div').show();
                $('#embryo_details_of_patient_div').show();

            } else if (item.types_of_treat1 === 'Sperm Donation') {
                $('#aadhar_no_oocyte_div').hide();
                $('#aadhar_no_semen_div').show();
               //s $('#semen_details_div').show();
                $('#oocyte_details_div').hide();
                $('#embryo_details_of_patient_div').show();
            }


            if (item.nationality === 'Foreigner') {
                $('#other_nationality1').show();
            } else {
                $('#other_nationality1').hide();
            }

            if (item.nationality_wife === 'Foreigner') {
                $('#other_nationality1_wife').show();
            } else {
                $('#other_nationality1_wife').hide();
            }

            togglePregnancy(item);
        }

        function setSelect(id, value) {
            if (value) {
                $(id).html(`<option value="${value}" selected>${value}</option>`);
            } else {
                $(id).html(`<option value="">Select</option>`);
            }
        }

        function handleOutcomeChange(value) {

            if (value === 'live birth') {

                $('#gender_child1').removeClass('hidden');
                $('#live_birth_open').show();
                $('#l_birth').prop('disabled', false);

            } else if (value === 'Stillbirth') {

                $('#gender_child1').removeClass('hidden');
                $('#live_birth_open').hide();

                $('#l_birth').prop('disabled', true);
                $('#l_birth').val('');

            } else {

                $('#gender_child1').addClass('hidden');
                $('#live_birth_open').hide();

                $('#l_birth').prop('disabled', true);
                $('#l_birth').val('');
            }
        }

        function togglePregnancy(item) {
            if (item.treat_outcomes) {
                $('#preganancy_outcome1').show();
                handleOutcomeChange(item.preganancy_outcome);
            } else {
                $('#preganancy_outcome1').hide();
                $('#gender_child1').addClass('hidden');
                $('#live_birth_open').hide();
            }
        }

        let patientData = [];

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
                url: "{{ route('search.uhid_form') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    uhid: selectedId
                },

                success: function(response) {

                    if (!response.status || !response.data.length) {
                        alert(response.message || 'No data found');
                        return;
                    }

                    patientData = response.data;

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

                    groupArray.forEach(item => {
                        rows += `
                        <tr>
                            <td>${i++}</td>
                            <td>
                                <a href="#" class="openForm"
                                    data-quarter="${item.quarter}"
                                    data-year="${item.year}">
                                    Q${item.quarter}, ${item.year}
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

        // ✅ SELECT2 INIT
        $('#patient_uhid').select2({
            placeholder: "Search UHID",
            allowClear: true,
            ajax: {
                url: "{{ route('search.uhid') }}",
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
                    window.location.href = "{{ route('clinic.list_artclinic_patient_view_outcome') }}";
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
        $(document).ready(function() {
            $('#btnSubmit').on('click', function(e) {
                if (!validatesubmit()) {
                    e.preventDefault(); // Prevent form submission if validation fails
                }
            });
        });

        function validatesubmit() {


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

                document.getElementById("female_number").value = '';
                document.getElementById("male_number").value = '';
                document.getElementById("l_birth").value = '';


                document.getElementById("l_birth_hidden").value = '';

                return true;
            }






            // code end suman

            if ((document.getElementById("preganancy_outcome").value == "live birth") && (document.getElementById(
                    "l_birth").value == "")) {
                alert("Live Birth Pregnancy Outcome cannot be blank");
                document.getElementById("l_birth").focus();
                return false;
            }


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

            if ((document.getElementById("preganancy_outcome").value == "Stillbirth") && (document.getElementById(
                    "gender_child").value == "")) {
                alert("Gender of the Child cannot be blank");
                document.getElementById("gender_child").focus();
                return false;
            }
            if ((document.getElementById("l_birth").value == "Singleton") && (document.getElementById(
                    "gender_child").value == "")) {
                alert("Gender of the Child cannot be blank");
                document.getElementById("gender_child").focus();
                return false;
            }
            if ((document.getElementById("l_birth").value == "Twin") && (document.getElementById(
                    "gender_child").value == "")) {
                alert("Gender of the Child cannot be blank");
                document.getElementById("gender_child").focus();
                return false;
            }
            if ((document.getElementById("l_birth").value == "Higher Order") && (document.getElementById(
                    "other_gender").value == "")) {
                alert("Please specify number and gender of children under higher order pregnancy");
                document.getElementById("other_gender").focus();
                return false;
            }


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


            function togglePregnancyOutcome() {
                var value = $('#treat_outcomes').val();

                if (value === 'Pregnant') {
                    $('#preganancy_outcome1').show();
                } else {
                    $('#preganancy_outcome1').hide();
                }
            }


            togglePregnancyOutcome();


            $('#treat_outcomes').on('change', function() {
                togglePregnancyOutcome();
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
        $(document).ready(function() {

            // Allow only numbers and max 12 digits
            const ids = [
                'aadhar_no_hus',
                'aadhar_no_wife',
                'aadhar_no_sw',
                'aadhar_no_oocyte',
                'aadhar_no_semen'
            ];

            ids.forEach(function(id) {

                $("#" + id).on("input", function() {

                    this.value = this.value.replace(/\D/g, '');

                    if (this.value.length > 12) {
                        this.value = this.value.substring(0, 12);
                    }

                });

            });

            // Form Submit Validation
            $("#art_clin1").on("submit", function(e) {
                if (!validateAadharFields()) {
                    e.preventDefault();
                    return false;
                }
            });

        });


     function validateAadharFields() {

    $(".text-danger").text("");

    // Aadhaar Validation
    const aadhaarFields = [
        { id: "aadhar_no_hus", div: "aadhar_no_hus_div", error: "aadhar_no_hus_error", label: "Husband Aadhaar No." },
        { id: "aadhar_no_wife", div: "aadhar_no_wife_div", error: "aadhar_no_wife_error", label: "Wife Aadhaar No." },
        { id: "aadhar_no_sw", div: "aadhar_no_sw_div", error: "aadhar_no_sw_error", label: "Single Woman Aadhaar No." },
        { id: "aadhar_no_oocyte", div: "aadhar_no_oocyte_div", error: "aadhar_no_oocyte_error", label: "Oocyte Donor Aadhaar No." },
        { id: "aadhar_no_semen", div: "aadhar_no_semen_div", error: "aadhar_no_semen_error", label: "Semen Donor Aadhaar No." }
    ];

    for (let field of aadhaarFields) {

        if ($("#" + field.div).is(":visible")) {

            let value = $.trim($("#" + field.id).val());

            if (value === "") {
                $("#" + field.error).text(field.label + " is required.");
                $("#" + field.id).focus();
                return false;
            }

            if (!/^[2-9][0-9]{11}$/.test(value)) {
                $("#" + field.error).text("Enter valid 12 digit Aadhaar Number.");
                $("#" + field.id).focus();
                return false;
            }
        }
    }

    // ==========================
    // Semen Details
    // ==========================
    if ($.trim($("#aadhar_no_sw").val()) !== "") {

        const semenFields = [
            { id: "husband_semen", error: "husband_semen_error", label: "Husband" },
            { id: "donor_semen", error: "donor_semen_error", label: "Donor" },
            { id: "no_of_semen_vials_used", error: "no_of_semen_vials_used_error", label: "No. of Semen Vials Used" },
            { id: "no_of_semen_vials_discarded", error: "no_of_semen_vials_discarded_error", label: "No. of Semen Vials Discarded" },
            { id: "no_of_semen_vials_frozen", error: "no_of_semen_vials_frozen_error", label: "No. of Semen Vials Frozen" }
        ];

        for (let field of semenFields) {

            let value = $.trim($("#" + field.id).val());

            if (value === "") {
                $("#" + field.error).text(field.label + " is required.");
                $("#" + field.id).focus();
                return false;
            }
        }
    }

    // ==========================
    // Oocyte Details
    // ==========================
    if (
        $.trim($("#aadhar_no_hus").val()) !== "" ||
        $.trim($("#aadhar_no_wife").val()) !== "" ||
        $.trim($("#aadhar_no_oocyte").val()) !== ""
    ) {

        const oocyteFields = [
            { id: "self_oocyte", error: "self_oocyte_error", label: "Self" },
            { id: "donor_oocyte", error: "donor_oocyte_error", label: "Donor" },
            { id: "no_of_oocytes_used_retrived", error: "no_of_oocytes_used_retrived_error", label: "No. of Oocytes Retrieved" },
            { id: "no_of_oocyted_used_for_embryo_creation", error: "no_of_oocyted_used_for_embryo_creation_error", label: "No. of Oocytes Used for Embryo Creation" },
            { id: "no_of_oocyte_discarded", error: "no_of_oocyte_discarded_error", label: "No. of Oocytes Discarded" },
            { id: "no_of_frozen_oocyte", error: "no_of_frozen_oocyte_error", label: "No. of Frozen Oocytes" }
        ];

        for (let field of oocyteFields) {

            let value = $.trim($("#" + field.id).val());

            if (value === "") {
                $("#" + field.error).text(field.label + " is required.");
                $("#" + field.id).focus();
                return false;
            }
        }
    }

    

    return true;
}
    </script>
@endsection
