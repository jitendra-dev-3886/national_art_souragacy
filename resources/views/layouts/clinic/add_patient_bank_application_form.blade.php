@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .color-red-fourty-three {
            color: #ff0000;
        }

        .displyay-none-fifty {
            display: none;
        }

        .bc-br-color-fourtyeight {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-readonlycolor {
            background-color: #e8eaec !important;
            /* light blue, change as needed */
            font-weight: bold;
            /* optional */
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
            background-color: #0d6efd;
            ;
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
                    <h3 class="card-title mb-5 text-primary">Donor information form for ART Bank</h3>

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

                    <form name="art_clin1" method="POST" action="{{ route('clinic.patient_save_bank_application_form') }}"
                        enctype="multipart/form-data" autocomplete="off">
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
                                            <input type="text" name="year" id="year_s"
                                                value="{{ $available_years->first()->year }}"
                                                class="form-control csp-readonlycolor" readonly>
                                            {{-- <input type="hidden" name="year" value="{{ $available_years->first()->year }}"> --}}
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
                                            <input type="hidden" name="quarter" id="quater_s"
                                                value="{{ $available_quarters->first()['id'] }}" class="form-control"
                                                readonly>
                                            <input type="text" value="{{ $available_quarters->first()['description'] }}"
                                                class="form-control csp-readonlycolor" readonly>
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

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label d-block">
                                    <strong>Already enrolled Donor</strong>
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="previous_treatment"
                                            id="previous_treatment_yes" value="Yes">
                                        <label class="form-check-label" for="treatment_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="previous_treatment"
                                            id="previous_treatment_no" value="No" checked>
                                        <label class="form-check-label" for="treatment_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <span id="bank_reg_numID" class="color-red-fourty-three">
                                    <?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;}
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Bank
                                            Registration
                                            Number</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->registration_no }}"
                                            class="form-control csp-readonlycolor" name="bank_reg_num" id="bank_reg_num"
                                            aria-describedby="bank_reg_num" placeholder="" readonly>
                                    </div>
                                    <span id="bank_reg_numID" class="color-red-fourty-three"><?php // if(isset($notice_bank_reg_num)){ echo $notice_bank_reg_num;}
                                    ?></span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Name of the
                                            Bank</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->name }}"
                                            class="form-control csp-readonlycolor" name="name_of_bank" id="name_of_bank"
                                            aria-describedby="name_of_bank" placeholder="" readonly>
                                    </div>
                                    <span id="name_of_bankID" class="color-red-fourty-three"><?php //if(isset($notice_name_of_bank)){ echo $notice_name_of_bank;}
                                    ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Donor
                                            UHID</strong><span class="color-red-fourty-three">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="donor_id" id="donor_id"
                                            aria-describedby="donor_id" placeholder="" maxlength="10">
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
                                            class="color-red-fourty-three">*</span></label>
                                    <div class="input-group">
                                        <select name="gender_donor" id="gender_donor" class="form-control"
                                            aria-label=".form-select-lg example">
                                            <option value="" class="text-muted"><strong><b>Select</b></strong>
                                            </option>
                                            <option value="Male" class="p-1">Male</option>
                                            <option value="Female" class="p-1">Female</option>

                                        </select>
                                    </div>
                                    @error('gender_donor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 displyay-none-fifty" id="d_age">
                                <div class="mb-3">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong>Age</strong><span
                                            class="color-red-fourty-three">*</span></label>
                                    <div class="input-group">
                                        {{-- <div class="mb-3">
                                    <input type="number" name="donor_age" id="donor_age" class="form-control" placeholder="Enter Age" min="21" max="55" style="
                                             width: 180px;">
                                    
                                    <!-- Error message below input -->
                                    <small id="ageError" class="text-danger" style="display: none;"></small>
                                </div> --}}
                                        <select name="donor_age" id="donor_age" class="form-control"
                                            aria-label=".form-select-lg example">
                                            <option value="" class="text-muted"><strong><b>Select
                                                        Age</b></strong>
                                            </option>
                                            <?php for ($i = 21; $i <= 55; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>


                                        </select>
                                    </div>
                                    @error('donor_age')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>





                            <div class="col-md-2 displyay-none-fifty" id="o_age">
                                <div class="mb-3">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong>Age</strong><span
                                            class="color-red-fourty-three">*</span></label>
                                    <div class="input-group">
                                        {{-- <div class="mb-3">
                                    <input type="number" name="oocyte_age" id="oocyte_age" class="form-control" placeholder="Enter Age" min="23" max="35" style="
                                             width: 180px;">
                                    
                                    <!-- Error message below input -->
                                    <small id="ageErroroocyte" class="text-danger" style="display: none;"></small>
                                </div> --}}
                                        <select name="oocyte_age" id="oocyte_age" class="form-control"
                                            aria-label=".form-select-lg example">
                                            <option value="" class="text-muted"><strong><b>Select
                                                        Age</b></strong>
                                            </option>
                                            <?php for ($i = 23; $i <= 35; $i++) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>


                                        </select>

                                    </div>
                                    @error('oocyte_age')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Marital
                                            status</strong><span class="color-red-fourty-three">*</span></label>
                                    <div class="input-group">
                                        <select name="marital_status" id="marital_status" class="form-control"
                                            aria-label=".form-select-lg example">
                                            <option value="" class="text-muted"><strong><b>Select</b></strong>
                                            </option>
                                            <option value="Married" class="p-1">Married</option>
                                            <option value="Single" class="p-1">Single</option>

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
                            {{-- <div class="col-md-4" id="other_nationality1" style="display:none;">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>Other Nationality
                                </strong><span style="color:red;">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="other_nationality"
                                    id="other_nationality">

                            </div>

                        </div>
                    </div> --}}

                            {{-- <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong
                                    id="heading_gamete">Oocyte details ( No of Oocyte(s) stored )
                                </strong><span class="color-red-fourty-three">*</span></label>
                            <div class="input-group">
                            <select name="gamete_details" id="gamete_details" class="form-control"
                                    aria-label=".form-select-lg example">
                                    <option value="" class="text-muted"><strong><b>Select</b></strong>
                                    </option>
                                    <?php for ($i = 1; $i <= 99; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>





                                <!--input type="number" class="form-control" name="gamete_details"
                                    id="gamete_details" min="0"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"-->

                            </div>
                            @error('gamete_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div> --}}





                            <div class="col-md-4">
                                <div class="border rounded p-3 mt-3 shadow-sm">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="no_gamete_checkbox"
                                            name="no_oocyte_semen_stored" value="1">

                                        <label class="form-check-label fw-bold" id="no_gamete_label"
                                            for="no_gamete_checkbox">
                                            No Oocyte (Stored)
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label">
                                        <strong id="heading_gamete">
                                            Oocyte details ( No of Oocyte(s) stored )
                                        </strong>
                                        <span class="color-red-fourty-three">*</span>
                                    </label>

                                    <div class="input-group">
                                        <select name="gamete_details" id="gamete_details" class="form-control">
                                            <option value="">Select</option>

                                            @for ($i = 1; $i <= 99; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
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
                                        <textarea class="form-control" col="5" rows="3" name="complicatoins_if_any" id="complicatoins_if_any" data-label="Complications"></textarea>
                                    </div>
                                    <span id="complicatoins_if_anyID"
                                        class="color-red-fourty-three"><?php // if(isset($comp_if_any)){ echo $comp_if_any;}
                                        ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Remarks/
                                            Any other relevant
                                            information</strong></label>
                                    <div class="input-group">
                                        <textarea class="form-control" col="5" rows="3" id="remark" name="remark" data-label="Remark"></textarea>
                                    </div>
                                    <span id="" class="color-red-fourty-three"><?php // if(isset($remark)){ echo $remark;}
                                    ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Required
                                            Affidavit/Undertaking** regarding
                                            following to be taken on record for the Donor:</strong></label>
                                    <div class="col-12" id="declaration_hide">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration"
                                                name="declaration">
                                            <label class="form-check-label" for="gridCheck">
                                                Please click that affidavit/undertaking** has been taken on record from
                                                oocyte donor that she has not donated oocytes more than once in her
                                                lifetime.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="declaration1"
                                                name="declaration1">
                                            <label class="form-check-label" for="gridCheck">
                                                Please click on the undertaking that the bank has not supplied sperm/oocyte
                                                of the same donor to more than one commissioning couple/single woman or
                                                clinic.
                                            </label>
                                        </div>
                                    </div>
                                    <label class="form-check-label" for="gridCheck">
                                        **Note: Undertaking will be taken in retrospective cases where affidavit is not
                                        available and the case is prior to the operationalization of the portal.
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="submit" name="submit" value="complete" id="btnSubmit" onclick="return validatesubmit()"
                    class="btn me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">This reporting period has been completed</button> --}}
                        <button type="submit" name="submit" value="continue" id="btnSubmit"
                            class="btn me-2 bc-br-color-fourtyeight">Continue Next Donor details</button>
                        <button type="button" id="closeButton" class="btn me-2 btn btn-danger">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function() {
            const submitButton = document.getElementById('btnSubmit');
            const closeButton = document.getElementById('closeButton');
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
        });
        $('#remark,#complicatoins_if_any').on('input', function() {
        var value = $(this).val();
        if (value.length > 500) {
            $(this).val(value.substring(0, 500));
            alert('Maximum 500 characters allowed for the ' + $(this).data('label') + '.');
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
        document.addEventListener('DOMContentLoaded', function() {
            // const yearSelect = document.getElementById('yearSelect');
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

            // function filterQuarters() {
            //     const selectedYear = parseInt(yearSelect.value);

            //     Array.from(quarterSelect.options).forEach(option => {
            //         const qNum = parseInt(option.getAttribute('data-quarter'));

            //         if (!qNum || isNaN(selectedYear)) {
            //             option.hidden = false;
            //             return;
            //         }

            //         if (selectedYear === currentYear) {
            //             // Show only current financial quarter
            //             option.hidden = qNum !== currentFinQuarter;
            //         } else {
            //             option.hidden = false;
            //         }
            //     });

            //     const selectedOption = quarterSelect.selectedOptions[0];
            //     if (selectedOption && selectedOption.hidden) {
            //         quarterSelect.selectedIndex = 0;
            //     }
            // }

            // yearSelect.addEventListener('change', filterQuarters);
            // filterQuarters();
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
                $('#other_nationality option[value="248"]').remove();
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
                document.getElementById("declaration").checked = false;
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
            if (document.getElementById("gamete_details").value == "" && (document.getElementById("gender_donor").value ==
                    "Male")) {
                alert("Semen Details cannot be blank");
                document.getElementById("gamete_details").focus();
                return false;
            }
            if (document.getElementById("gamete_details").value == "" && (document.getElementById("gender_donor").value ==
                    "Female")) {
                alert("Oocyte Details cannot be blank");
                document.getElementById("gamete_details").focus();
                return false;
            }
            if ((document.getElementById("gender_donor").value == "Female") && (!document.getElementById("declaration")
                    .checked)) {
                alert(
                    "Please click that affidavit/undertaking** has been taken on record from oocyte donor that she has not donated oocytes more than once in her lifetime.");
                document.getElementById("declaration").focus();
                return false;
            }
            if ((document.getElementById("gender_donor").value == "Female") && (!document.getElementById("declaration1")
                    .checked)) {
                alert(
                    "Please click on the undertaking that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic.");
                document.getElementById("declaration1").focus();
                return false;
            }
            if ((document.getElementById("gender_donor").value == "Male") && (!document.getElementById("declaration1")
                    .checked)) {
                alert(
                    "Please click on the undertaking that the bank has not supplied sperm/oocyte of the same donor to more than one commissioning couple/single woman or clinic.");
                document.getElementById("declaration1").focus();
                return false;
            }
            const patient_uhid = document.getElementById("donor_id").value;

            var agree = confirm(
                "Kindly check & confirm all details for UHID-" + patient_uhid +
                " before continuing next donor details.After submission Donor details can be modified using view / edit options."
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
            var yy = $('#year_s').val();
            var qq = $('#quater_s').val();

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
                    year_: yy,
                    quarter_: qq,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
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
                            if (response.matched === 'q_not_matched') {
                                $('#availability').html(
                                    '<span class="text-success">UHID Found for this ART Bank.</span>');
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
                                '<span class="text-danger">UHID does not exist for this ART Bank. Kindly enter correct UHID.</span>'
                                );
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
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Run when donor_id input loses focus
        $(document).on('blur', '#donor_id', function() {
            checkUHID();
        });

        // Run when previous treatment radio is changed
        $(document).on('change', 'input[name="previous_treatment"]', function() {
            checkUHID();
        });
        // Run when donor_id input loses focus
        $(document).on('blur', '#donor_id', function() {
            checkUHID();
        });

        // Run when previous treatment radio is changed
        $(document).on('change', 'input[name="previous_treatment"]', function() {
            checkUHID();
        });

        $(document).ready(function() {

            $('#no_gamete_checkbox').on('change', function() {

                let select = $('#gamete_details');

                if ($(this).is(':checked')) {

                    select.html('<option value="0" selected>0</option>');

                } else {

                    let options = '<option value="">Select</option>';

                    for (let i = 1; i <= 99; i++) {
                        options += `<option value="${i}">${i}</option>`;
                    }

                    select.html(options);
                }
            });

        });


        $('#gender_donor').change(function() {

            let gender = $(this).val();

            if (gender === 'Male') {

                $('#no_gamete_label').text('No Semen (in vials) Stored');
                $('#heading_gamete').text('Semen Detail (in vials)');

            } else if (gender === 'Female') {

                $('#no_gamete_label').text('No Oocyte(Stored)');
                $('#heading_gamete').text('Oocyte details ( No. of Oocyte(s) stored )');

            }

        });
    </script>


@endsection
