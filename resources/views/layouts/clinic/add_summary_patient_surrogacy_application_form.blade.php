@extends('layouts.clinic.clinic_master')
@section('content')
 <style nonce="{{$cspNonce}}">
        .color-csp-clinic-one {
            color: red;
        }

        .width-csp-clinic-two {
            width: 550px;
        }

        .width-csp-clinic-three {
            width: 20%;
        }
        .width-csp-clinic-six {
            width: 48%;
        }
        .bgclr-bd-clr-csp-clinic{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white;"
        }
       
/*  */
        
/*  */

.width-csp-clinic-four{width: 48%;}
.width-bgclr-clr-five{
width: 20%; background-color: #e9ecef; color: #495057;}


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
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('exists'))
                        <script nonce="{{ $cspNonce }}">
                            alert("{{ session('exists') }}");
                        </script>
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
                    <h3 class="card-title mb-5 text-primary">Reporting Format for Surrogacy Clinics</h3>
                    <form name="art_clin1" method="POST"
                        action="{{ route('clinic.summary_patient_save_surrogacy_application_form') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- @php
                            $quarters = [
                                'Q1' => 'Q1 (Apr - Jun)',
                                'Q2' => 'Q2 (Jul - Sep)',
                                'Q3' => 'Q3 (Oct - Dec)',
                                'Q4' => 'Q4 (Jan - Mar)'
                            ];
                        @endphp

                    <div class="d-flex gap-3">
                        <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                            <option value="">Select Quarter</option>
                            @foreach ($quarters as $key => $value)
                                @php
                                    // Check if this quarter should be disabled
                                    $disableQuarter = false;
                                    if (request()->get('year') == $currentYear) {
                                        // If current year, disable quarters after currentQuarter
                                        $order = ['Q1' => 1, 'Q2' => 2, 'Q3' => 3, 'Q4' => 4];
                                        if ($order[$key] > $order[$currentQuarter]) {
                                            $disableQuarter = true;
                                        }
                                    }

                                    // Also, check if quarter-year already submitted
                                    foreach ($existingSubmissions as $submission) {
                                        if ($submission->quarter == $key && $submission->year == request()->get('year')) {
                                            $disableQuarter = true;
                                            break;
                                        }
                                    }
                                @endphp
                                <option value="{{ $key }}" @if ($disableQuarter) disabled @endif>{{ $value }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                            <option value="">Select Year</option>
                            @for ($y = $currentYear; $y >= 2022; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div> --}}
                            {{-- @php
                        $currentYear = date('Y');
                    @endphp

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>a. Quarter and Year </strong>
                            </label>
                            <div class="d-flex gap-3">
                                <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                    <option value="">Select Quarter</option>
                                    <option value="Q1">Q1 (Apr - Jun)</option>
                                    <option value="Q2">Q2 (Jul - Sep)</option>
                                    <option value="Q3">Q3 (Oct - Dec)</option>
                                    <option value="Q4">Q4 (Jan - Mar)</option>
                                </select>
                                <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                    <option value="">Select Year</option>
                                    @for ($y = $currentYear; $y >= 2022; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            

                                
                            </div>
                        </div>
                    </div> --}}
                            @php
                                $currentYear = date('Y');
                                $currentQuarter = ceil(date('n') / 3);
                            @endphp


           <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label d-block">
                                        <strong>a. Year and quarter</strong>
                                    </label>
                                    <div class="d-flex gap-3">
                                        <select class="form-select width-csp-clinic-four" name="year" id="yearSelect" >
                                            <option value="">Select Year</option>
                                            @for ($y = 2022; $y <= $currentYear; $y++)
                                                <option value="{{ $y }}"
                                                    @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y) selected @endif>{{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                      
                                         <select class="form-select csp-clinic-select-half" name="quarter" id="quarterSelect">
                                <option value="">Select quarter</option>
                                @foreach ($quarter as $quarters)
                                   
                                    <option value="{{ $quarters->id }}">{{ $quarters->description }}</option>
                                @endforeach
                            </select>
                                        
                                    </div>
                                </div>
                            </div>

                    <!-- Treatment Month and Year -->
                    {{-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>a. Quarter and Year</strong>
                            </label>
                            <div class="d-flex gap-3">
                                <select class="form-select" name="quarter" style="width: 48%;">
                                    <option value="">Select Quarter</option>
                                    @for ($q = 1; $q <= 4; $q++)
                                        @if ($selectedYear ?? $currentYear < $currentYear || $q <= $currentQuarter)
                                            <option value="Q{{ $q }}">Q{{ $q }} 
                                                @if($q == 1)(Jan - Mar)
                                                @elseif($q == 2)(Apr - Jun)
                                                @elseif($q == 3)(Jul - Sep)
                                                @elseif($q == 4)(Oct - Dec)
                                                @endif
                                            </option>
                                        @endif
                                    @endfor
                                </select>
                                <select class="form-select" name="year" id="quarterYear" style="width: 48%;">
                                    <option value="">Select Year</option>
                                    @for ($y = $currentYear; $y >= 2022; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select> --}}
                                {{-- <select class="form-select" name="month" style="width: 48%;">
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select> --}}
                
                                {{-- <select class="form-select" name="year" style="width: 48%;">
                                    <option value="">Select Year</option>
                                    <?php
                                      //  $currentYear = date('Y');
                                       // for ($i = $currentYear; $i >= 2022; $i--) {
                                       //     echo "<option value='$i'>$i</option>";
                                      //  }
                                    ?>
                                </select> --}}
                            {{-- </div>
                        </div>
                    </div> --}}
                     <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>b. Name of
                                            the
                                            Clinic</strong>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->name }}"
                                            onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                            class="form-control" name="name_of_clinic" id="name_of_clinic"
                                            aria-describedby="name_of_clinic" placeholder="" readonly>
                                    </div>
                                    <span id="name_of_clinicID" class="color-csp-clinic-one"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}
                                    ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>c. Clinic
                                            Registration
                                            Number</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $patient_list->registration_no }}"
                                            class="form-control" name="cli_reg_name" id="cli_reg_name"
                                            aria-describedby="cli_reg_name" placeholder="" data-validation="alphanumeric"
                                            data-validation-allowing="_" readonly>

                                    </div>
                                    <span id="clinic_level1_reg_numID"
                                        class="color-csp-clinic-one"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;}
                                        ?></span>
                                </div>
                            </div>





                 
                </div>
                

               
                        <div class="row">

                            <div class=" mb-4 d-flex align-items-center">
                                <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two"><strong>d. Total
                                        number patients undergoing/undergone surrogacy procedure</strong></label>
                                {{-- <input type="number" class="form-control" style="width: 20%;" id="no_patient_undergoing_procedure" name="no_patient_undergoing_procedure" readonly> --}}
                            </div>




                    {{-- <label class="text-label form-label mb-4"
                    for="validationCustomUsername"><strong>d. Total number patients undergoing/undergone surrogacy procedure:</strong>
                    </label> --}}


                  <div class="row">
                                <!-- Indian Nationals -->
                                {{-- <div class="col-md-6"> --}}
                                <div class=" mb-3 d-flex align-items-center">
                                    <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two">(i) Number of
                                        Indian Nationals:</label>
                                    <input type="number" class="form-control calc-input width-csp-clinic-three"
                                        id="no_indian_nationals" name="no_indian_nationals" required>
                                </div>

                    {{-- </div> --}}
                    {{-- <div class="col-md-6"> --}}
                        <!-- Foreign Nationals -->
                        <div class=" mb-3 d-flex align-items-center">
                                    <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">(ii) Number
                                        of Foreign Nationals (OCI cardholders):</label>
                                    <input type="number" class="form-control calc-input width-csp-clinic-three " 
                                        id="no_foreign_nationals" name="no_foreign_nationals" required>
                                </div>
                                <div class=" mb-4 d-flex align-items-center justify-content-between">
                                    <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two"><strong>Total
                                            number patients undergoing/undergone surrogacy procedure (i+ii)</strong></label>
                                    <input type="number" class="form-control width-bgclr-clr-five "
                                        
                                        id="no_patient_undergoing_procedure" name="no_patient_undergoing_procedure"
                                        readonly>
                                </div>

                    {{-- </div> --}}


                    </div>




        <div class="row">
                                <!-- Ongoing Surrogacy Column -->
                                {{-- <div class="col-md-6"> --}}

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>e. Number of Patients where
                                            Surrogacy procedure is ongoing</strong></label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_patient_surrogacy_ongoing" name="no_patient_surrogacy_ongoing" placeholder="Auto-calculated" readonly> --}}
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two">e.1
                                        Number of Married couples</label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_married_couples" name="no_married_couples" readonly> --}}
                                </div>
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two">e.1.a
                                        Using self-gametes</label>
                                    <input type="number" class="form-control calcs-input width-csp-clinic-three"
                                        id="no_ongoing_self_gametes" name="no_ongoing_self_gametes" required>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_oocytes_donor_semen"
                                        class="form-label me-3 width-csp-clinic-two">e.1.b Using self-oocytes and donor
                                        semen</label>
                                    <input type="number" class="form-control calcs-input width-csp-clinic-three" 
                                        id="no_ongoing_oocytes_donor_semen" name="no_ongoing_oocytes_donor_semen"
                                        required>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_semen_donor_oocytes"
                                        class="form-label me-3 width-csp-clinic-two">e.1.c Using self-semen and donor
                                        oocytes</label>
                                    <input type="number" class="form-control  width-csp-clinic-three calcs-input"
                                        id="no_ongoing_semen_donor_oocytes" name="no_ongoing_semen_donor_oocytes"
                                        required>
                                </div>
                                <div class="mb-2 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>e.1 (a+b+c) Total Married
                                            Couples</strong></label>
                                    <input type="number" class="form-control width-bgclr-clr-five"
                                        
                                        id="no_married_couples" name="no_married_couples" readonly>
                                </div>
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_single_woman" class="form-label me-3 width-csp-clinic-two">e.2
                                        Number of Single women (widow/divorcee)</label>
                                    <input type="number" class="form-control calcs-input width-csp-clinic-three" 
                                        id="no_ongoing_single_woman" name="no_ongoing_single_woman" required>
                                </div>
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>Total number of Patients where
                                            Surrogacy procedure is ongoing (e.1+e.2)</strong></label>
                                    <input type="number" class="form-control width-bgclr-clr-five"
                                      
                                        id="no_patient_surrogacy_ongoing" name="no_patient_surrogacy_ongoing" readonly>
                                </div>
                                {{-- </div> --}}

                                <!-- Completed Surrogacy Column -->
                                {{-- <div class="col-md-6"> --}}

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>f. Number of Patients where
                                            Surrogacy procedure has been completed</strong></label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_patient_surrogacy_completed" name="no_patient_surrogacy_completed" readonly> --}}
                                </div>

                                <div class="mb-2 d-flex align-items-center">
                                    <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two">f.1
                                        Number of Married couples</label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_married_couple" name="no_married_couple" readonly> --}}
                                </div>





                                {{-- <label class="text-label form-label mb-3">
                                <strong>f. Number of Patients where Surrogacy procedure has been completed:</strong>
                            </label> --}}

                                {{-- <label class="text-label form-label mb-2"><strong>(i) Number of Married couples:</strong></label> --}}

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="completed_self_gametes" class="form-label me-3 width-csp-clinic-two">f.1.a
                                        Using self-gametes</label>
                                    <input type="number" class="form-control calcss-input width-csp-clinic-three"
                                        id="no_completed_self_gametes" name="no_completed_self_gametes" required>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="completed_oocytes_donor_semen"
                                        class="form-label me-3 width-csp-clinic-two">f.1.b Using self-oocytes and donor
                                        semen</label>
                                    <input type="number" class="form-control calcss-input width-csp-clinic-three" 
                                        id="no_completed_oocytes_donor_semen" name="no_completed_oocytes_donor_semen"
                                        required>
                                </div>

                                <div class="mb-3 d-flex align-items-center">
                                    <label for="completed_semen_donor_oocytes"
                                        class="form-label me-3 width-csp-clinic-two">f.1.c Using self-semen and donor
                                        oocytes</label>
                                    <input type="number" class="form-control calcss-input width-csp-clinic-three" 
                                        id="no_completed_semen_donor_oocytes" name="no_completed_semen_donor_oocytes"
                                        required>
                                </div>
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>f.1 (a+b+c) Number of Married
                                            couples</strong></label>
                                    <input type="number" class="form-control width-bgclr-clr-five"
                                     
                                        id="no_married_couple" name="no_married_couple" readonly>
                                </div>
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="completed_single_woman" class="form-label me-3 width-csp-clinic-two">f.2
                                        Number of Single women (widow/divorcee):</label>
                                    <input type="number" class="form-control calcss-input width-csp-clinic-three" 
                                        id="no_completed_single_woman" name="no_completed_single_woman" required>
                                </div>
                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>Total number of Patients where
                                            Surrogacy procedure has been completed (f.1+f2)</strong></label>
                                    <input type="number" class="form-control width-bgclr-clr-five"
                                 
                                        id="no_patient_surrogacy_completed" name="no_patient_surrogacy_completed"
                                        readonly>
                                </div>
                                {{-- </div> --}}
                            </div>



                    <div class="row">
                {{-- <div class="col-md-6"> --}}












                                <div class="mb-4 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>g. Total number of surrogate
                                            Mothers</strong></label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_surrogate_mothers" name="no_surrogate_mothers" placeholder="Auto-calculated" readonly> --}}
                                </div>


                    {{-- <label class="text-label form-label mb-4"
                    for="validationCustomUsername"><strong>g. Total number of surrogate Mothers:</strong>
                    </label> --}}


                 {{-- <label class="text-label form-label mb-4"
                    for="validationCustomUsername"><strong>g. Total number of surrogate Mothers:</strong>
                    </label> --}}


                                <div class="row">
                                    <!-- Indian Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two">(i)
                                            Number of surrogate mothers (ongoing cases):</label>
                                        <input type="number" class="form-control calcc-input width-csp-clinic-three"
                                            id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing"
                                            required>
                                    </div>

                                    <!-- Foreign Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">(ii)
                                            Number of surrogate mothers (completed cases):</label>
                                        <input type="number" class="form-control calcc-input width-csp-clinic-three"
                                            id="no_surrogate_mother_completed" name="no_surrogate_mother_completed"
                                             required>
                                    </div>



                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <label for="ongoing_self_gametes"
                                            class="form-label me-3 width-csp-clinic-two"><strong>Total number of surrogate
                                                Mothers (i+ii)</strong></label>
                                        <input type="number" class="form-control width-bgclr-clr-five"
                                           
                                            id="no_surrogate_mothers" name="no_surrogate_mothers" readonly>
                                    </div>
                                </div>




                  <div class="row">
                                    <!-- Indian Nationals -->
                                    {{-- <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;">(i) Number of surrogate mothers (ongoing cases):</label>
                            <input type="number" class="form-control" id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing" style="width: 10%;">
                        </div> --}}

                                    <!-- Foreign Nationals -->
                                    <div class=" mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>h. Number of surgical
                                                retrivals of semen done:</strong></label>
                                        <input type="number" class="form-control width-csp-clinic-three" id="no_surgical_retrival_done"
                                            name="no_surgical_retrival_done" required>
                                    </div>
                                </div>


                                <div class="mb-4 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>i. Number of oocyte retrievals
                                            done</strong></label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_oocyte_retrievals" name="no_oocyte_retrievals" placeholder="Auto-calculated" readonly> --}}
                                </div>
                                {{-- <label class="text-label form-label mb-4"
                    for="validationCustomUsername"><strong>i. Number of oocyte retrievals done:</strong>
                    </label> --}}



                     <div class="row">
                                    <!-- Indian Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two">(i)
                                            oocyte donor</label>
                                        <input type="number" class="form-control calci-input width-csp-clinic-three" id="no_oocyte_donor"
                                            name="no_oocyte_donor"  required>
                                    </div>

                                    <!-- Foreign Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">(ii)
                                            Self oocytes of patient</label>
                                        <input type="number" class="form-control calci-input  width-csp-clinic-three"
                                            id="no_self_oocyte_patient" name="no_self_oocyte_patient" 
                                            required>
                                    </div>
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <label for="ongoing_self_gametes"
                                            class="form-label me-3 width-csp-clinic-two"><strong>Number of oocyte
                                                retrievals (i+ii)</strong></label>
                                        <input type="number" class="form-control width-bgclr-clr-five"
                                            
                                            id="no_oocyte_retrievals" name="no_oocyte_retrievals" readonly>
                                    </div>
                                </div>


                   

               <div class="row">
                                    <!-- Indian Nationals -->
                                    {{-- <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;">(i) Number of surrogate mothers (ongoing cases):</label>
                            <input type="number" class="form-control" id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing" style="width: 10%;">
                        </div> --}}

                                    <!-- Foreign Nationals -->
                                    <div class=" mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>j. Number of patient semen
                                                cryopreserved (in vials):</strong></label>
                                        <input type="number" class="form-control width-csp-clinic-three" id="no_patient_semen_cryopreserved"
                                            name="no_patient_semen_cryopreserved"  required>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Indian Nationals -->
                                    {{-- <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;">(i) Number of surrogate mothers (ongoing cases):</label>
                            <input type="number" class="form-control" id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing" style="width: 10%;">
                        </div> --}}

                                    <!-- Foreign Nationals -->
                                    <div class=" mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>k. Number of patient
                                                oocytes cryopreserved:</strong></label>
                                        <input type="number" class="form-control width-csp-clinic-three" id="no_patient_oocyte_cryopreserved"
                                            name="no_patient_oocyte_cryopreserved"  required>
                                    </div>
                                </div>




                   <div class="row">
                                    <!-- Indian Nationals -->
                                    {{-- <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;">(i) Number of surrogate mothers (ongoing cases):</label>
                            <input type="number" class="form-control" id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing" style="width: 10%;">
                        </div> --}}

                                    <!-- Foreign Nationals -->
                                    <div class=" mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>l. Number of donor sperm
                                                cryopreserved (in vials):</strong></label>
                                        <input type="number" class="form-control width-csp-clinic-three" id="no_donor_sperm_cryopreserved"
                                            name="no_donor_sperm_cryopreserved"  required>
                                    </div>
                                </div>

                                {{-- </div> --}}

                                {{-- <div class="col-md-6"> --}}









                    <div class="row">
                                    <!-- Indian Nationals -->
                                    {{-- <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;">(i) Number of surrogate mothers (ongoing cases):</label>
                            <input type="number" class="form-control" id="no_surrogate_mother_ongoing" name="no_surrogate_mother_ongoing" style="width: 10%;">
                        </div> --}}

                                    <!-- Foreign Nationals -->
                                    <div class=" mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>m. Number of donor oocyte
                                                cryopreserved:</strong></label>
                                        <input type="number" class="form-control width-csp-clinic-three" id="no_donor_oocyte_cryopreserved"
                                            name="no_donor_oocyte_cryopreserved"  required>
                                    </div>
                                </div>
                                <div class="mb-4 d-flex align-items-center">
                                    <label for="ongoing_self_gametes"
                                        class="form-label me-3 width-csp-clinic-two"><strong>n. Number of embryos
                                            cryopreserved</strong></label>
                                    {{-- <input type="number" class="form-control" style="width: 20%;" id="no_embryos_cryopreserved" name="no_embryos_cryopreserved" placeholder="Auto-calculated" readonly> --}}
                                </div>
                                <div class="row">
                                    <!-- Indian Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two">n.1
                                            created using self-gametes</label>
                                        <input type="number" class="form-control embryo-input width-csp-clinic-three"
                                            id="no_created_using_self_gametes" name="no_created_using_self_gametes"
                                            required>
                                    </div>

                                    <!-- Foreign Nationals -->
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">n.2
                                            created using one donor gamete</label>
                                        {{-- <input type="number" class="form-control" id="no_created_using_one_donor_gamete" name="no_created_using_one_donor_gamete" style="width: 20%;"  placeholder="Auto-calculated" readonly> --}}
                                    </div>

                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">n.2.a
                                            Donor Sperm</label>
                                        <input type="number" class="form-control embryo-input width-csp-clinic-three" id="no_donor_sperm"
                                            name="no_donor_sperm"  required>
                                    </div>
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">n.2.b
                                            Donor oocyte</label>
                                        <input type="number" class="form-control embryo-input width-csp-clinic-three" id="no_donor_oocyte"
                                            name="no_donor_oocyte"  required>
                                    </div>
                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals"
                                            class="form-label me-3 width-csp-clinic-two"><strong>n.2 (a+b)Total created
                                                using one donor gamete</strong></label>
                                        <input type="number" class="form-control width-bgclr-clr-five" id="no_created_using_one_donor_gamete"
                                            name="no_created_using_one_donor_gamete"
                                             readonly>
                                    </div>


                                    <div class="col-md-12 mb-3 d-flex align-items-center">
                                        <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two">n.3
                                            created using both donor gametes</label>
                                        <input type="number" class="form-control embryo-input width-csp-clinic-three"
                                            id="no_created_using_both_donor_gamete"
                                            name="no_created_using_both_donor_gamete" required>
                                    </div>
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <label for="ongoing_self_gametes"
                                            class="form-label me-3 width-csp-clinic-two"><strong>Total Number of embryos
                                                cryopreserved. n (1+2+3)</strong></label>
                                        <input type="number" class="form-control width-bgclr-clr-five"
                                            
                                            id="no_embryos_cryopreserved" name="no_embryos_cryopreserved" readonly>
                                    </div>
                                </div>



                                {{-- </div> --}}














                                     
                 <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" name="submit" id="btnSubmit" class="btn me-2 bgclr-bd-clr-csp-clinic">Submit</button>

                                    </div>
                                </div>

                    </form>




{{-- <div> --}}







</div>







    </div>
</div>
    </div>
</div>
</div>


 
 <script nonce="{{ $cspNonce }}">
    function calculateTotal() {
        const cryo = parseInt(document.getElementById('no_indian_nationals').value) || 0;
        const art = parseInt(document.getElementById('no_foreign_nationals').value) || 0;
        

        const total = cryo + art;
        document.getElementById('no_patient_undergoing_procedure').value = total;
    }

    document.querySelectorAll('.calc-input').forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    function updateSurrogacyCounts() {
        const selfGametes = parseInt(document.getElementById('no_ongoing_self_gametes').value) || 0;
        const selfOocytesDonorSemen = parseInt(document.getElementById('no_ongoing_oocytes_donor_semen').value) || 0;
        const selfSemenDonorOocytes = parseInt(document.getElementById('no_ongoing_semen_donor_oocytes').value) || 0;
        const singleWomen = parseInt(document.getElementById('no_ongoing_single_woman').value) || 0;

        const marriedCouples = selfGametes + selfOocytesDonorSemen + selfSemenDonorOocytes;
        const totalPatients = marriedCouples + singleWomen;

        document.getElementById('no_married_couples').value = marriedCouples;
        document.getElementById('no_patient_surrogacy_ongoing').value = totalPatients;
    }

    document.querySelectorAll('.calcs-input').forEach(input => {
        input.addEventListener('input', updateSurrogacyCounts);
    });
    function updateSurrogacyCountss() {
        const selfGametess = parseInt(document.getElementById('no_completed_self_gametes').value) || 0;
        const selfOocytesDonorSemens = parseInt(document.getElementById('no_completed_oocytes_donor_semen').value) || 0;
        const selfSemenDonorOocytess = parseInt(document.getElementById('no_completed_semen_donor_oocytes').value) || 0;
        const singleWomens = parseInt(document.getElementById('no_completed_single_woman').value) || 0;

        const marriedCoupless = selfGametess + selfOocytesDonorSemens + selfSemenDonorOocytess;
        const totalPatientss = marriedCoupless + singleWomens;

        document.getElementById('no_married_couple').value = marriedCoupless;
        document.getElementById('no_patient_surrogacy_completed').value = totalPatientss;
    }

    document.querySelectorAll('.calcss-input').forEach(input => {
        input.addEventListener('input', updateSurrogacyCountss);
    });
    function calculateTotalg() {
        const cryog = parseInt(document.getElementById('no_surrogate_mother_ongoing').value) || 0;
        const artg = parseInt(document.getElementById('no_surrogate_mother_completed').value) || 0;
        

        const total = cryog + artg;
        document.getElementById('no_surrogate_mothers').value = total;
    }

    document.querySelectorAll('.calcc-input').forEach(input => {
        input.addEventListener('input', calculateTotalg);
    });
    function calculateTotali() {
        const cryoi = parseInt(document.getElementById('no_oocyte_donor').value) || 0;
        const arti = parseInt(document.getElementById('no_self_oocyte_patient').value) || 0;
        

        const totali = cryoi + arti;
        document.getElementById('no_oocyte_retrievals').value = totali;
    }

    document.querySelectorAll('.calci-input').forEach(input => {
        input.addEventListener('input', calculateTotali);
    });
    function updateEmbryoCounts() {
        const selfGametes = parseInt(document.getElementById('no_created_using_self_gametes').value) || 0;
        const donorSperm = parseInt(document.getElementById('no_donor_sperm').value) || 0;
        const donorOocyte = parseInt(document.getElementById('no_donor_oocyte').value) || 0;
        const bothDonors = parseInt(document.getElementById('no_created_using_both_donor_gamete').value) || 0;

        const oneDonor = donorSperm + donorOocyte;
        const totalCryopreserved = selfGametes + oneDonor + bothDonors;

        document.getElementById('no_created_using_one_donor_gamete').value = oneDonor;
        document.getElementById('no_embryos_cryopreserved').value = totalCryopreserved;
    }

    document.querySelectorAll('.embryo-input').forEach(input => {
        input.addEventListener('input', updateEmbryoCounts);
    });
   
</script>
    

<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('yearSelect');
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

    function filterQuarters() {
        const selectedYear = parseInt(yearSelect.value);

        Array.from(quarterSelect.options).forEach(option => {
            if (!option.value) return; // skip "Select quarter" option
            const qNum = parseInt(option.value);

            if (isNaN(selectedYear)) {
                option.hidden = false;
                return;
            }

            if (selectedYear < currentYear) {
                // Past years → show all quarters
                option.hidden = false;
            } else if (selectedYear === currentYear) {
                // Current year → show up to current quarter
                option.hidden = qNum > currentFinQuarter;
            } else {
                // Future years → hide all
                option.hidden = true;
            }
        });

        // Reset if hidden option was selected
        const selectedOption = quarterSelect.selectedOptions[0];
        if (selectedOption && selectedOption.hidden) {
            quarterSelect.selectedIndex = 0;
        }
    }

    yearSelect.addEventListener('change', filterQuarters);
    filterQuarters(); // initial run
});
</script>

  <script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1;
        const currentQuarter = Math.ceil(currentMonth / 3);

        const yearSelect = document.getElementById('yearSelect');
        const quarterSelect = document.getElementById('quarterSelect');

        yearSelect.addEventListener('change', function () {
            const selectedYear = parseInt(this.value);

            // Reset quarter selection
            quarterSelect.value = '';

            Array.from(quarterSelect.options).forEach(option => {
                if (!option.value) return; // Skip default

                const quarterNum = parseInt(option.value.replace('Q', ''));

                if (selectedYear < currentYear) {
                    // Show all quarters
                    option.style.display = 'block';
                } else if (selectedYear === currentYear) {
                    // Show only up to the current quarter
                    option.style.display = quarterNum <= currentQuarter ? 'block' : 'none';
                } else {
                    // Future year selected — hide all
                    option.style.display = 'none';
                }
            });
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const numberInputs = document.querySelectorAll('input[type="number"]');

        numberInputs.forEach(input => {
            input.setAttribute('min', '0');

            input.addEventListener('input', function () {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });
    });
</script>
   
    
      
    <script nonce="{{ $cspNonce }}">
    function validatesubmit() {
        if (document.getElementById("yearSelect").value == "") {
            alert("Select Year");
            document.getElementById("yearSelect").focus();
            return false;
        } 
        if (document.getElementById("quarterSelect").value == "") {
            alert("Select Quarter");
            document.getElementById("quarterSelect").focus();
            return false;
        }
        if (document.getElementById("no_patient_undergoing_procedure").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_undergoing_procedure").focus();
            return false;
        }         
        if (document.getElementById("no_indian_nationals").value == "") {
            alert("Enter the number of Indian Nationals");
            document.getElementById("no_indian_nationals").focus();
            return false;
        } 
        if (document.getElementById("no_foreign_nationals").value == "") {
            alert("Enter the number of Foreign Nationals (OCI cardholders)");
            document.getElementById("no_foreign_nationals").focus();
            return false;
        }
        if (document.getElementById("no_patient_surrogacy_ongoing").value == "") {
            alert("Enter the number ");
            document.getElementById("no_patient_surrogacy_ongoing").focus();
            return false;
        }
        if (document.getElementById("no_married_couples").value == "") {
            alert("Enter the number ");
            document.getElementById("no_married_couples").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_oocytes_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_oocytes_donor_semen").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_semen_donor_oocytes").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_semen_donor_oocytes").focus();
            return false;
        }        
        if (document.getElementById("no_ongoing_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_single_woman").focus();
            return false;
        }
        if (document.getElementById("no_patient_surrogacy_completed").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_surrogacy_completed").focus();
            return false;
        } 
        if (document.getElementById("no_married_couple").value == "") {
            alert("Enter the number");
            document.getElementById("no_married_couple").focus();
            return false;
        } 
        if (document.getElementById("no_completed_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_completed_oocytes_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_oocytes_donor_semen").focus();
            return false;
        }
        if (document.getElementById("no_completed_semen_donor_oocytes").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_semen_donor_oocytes").focus();
            return false;
        }
        if (document.getElementById("no_completed_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_single_woman").focus();
            return false;
        }
        if (document.getElementById("no_surrogate_mothers").value == "") {
            alert("Enter the number");
            document.getElementById("no_surrogate_mothers").focus();
            return false;
        }
        if (document.getElementById("no_surrogate_mother_ongoing").value == "") {
            alert("Enter the number");
            document.getElementById("no_surrogate_mother_ongoing").focus();
            return false;
        }
        if (document.getElementById("no_surrogate_mother_completed").value == "") {
            alert("Enter the number");
            document.getElementById("no_surrogate_mother_completed").focus();
            return false;
        }
        if (document.getElementById("no_surgical_retrival_done").value == "") {
            alert("Enter the number");
            document.getElementById("no_surgical_retrival_done").focus();
            return false;
        }
        if (document.getElementById("no_oocyte_retrievals").value == "") {
            alert("Enter the number");
            document.getElementById("no_oocyte_retrievals").focus();
            return false;
        }
        if (document.getElementById("no_oocyte_donor").value == "") {
            alert("Enter the number");
            document.getElementById("no_oocyte_donor").focus();
            return false;
        }
        if (document.getElementById("no_self_oocyte_patient").value == "") {
            alert("Enter the number");
            document.getElementById("no_self_oocyte_patient").focus();
            return false;
        }
        if (document.getElementById("no_patient_semen_cryopreserved").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_semen_cryopreserved").focus();
            return false;
        }
        if (document.getElementById("no_patient_oocyte_cryopreserved").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_oocyte_cryopreserved").focus();
            return false;
        }
        if (document.getElementById("no_created_using_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_using_self_gametes").focus();
            return false;
        }
        if (document.getElementById("no_donor_sperm").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_sperm").focus();
            return false;
        }
        if (document.getElementById("no_donor_oocyte").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocyte").focus();
            return false;
        }
        if (document.getElementById("no_created_using_one_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_using_one_donor_gamete").focus();
            return false;
        }
        if (document.getElementById("no_created_using_both_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_using_both_donor_gamete").focus();
            return false;
        }
        if (document.getElementById("no_donor_sperm_cryopreserved").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_sperm_cryopreserved").focus();
            return false;
        }
        if (document.getElementById("no_donor_oocyte_cryopreserved").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocyte_cryopreserved").focus();
            return false;
        }
        if (document.getElementById("no_embryos_cryopreserved").value == "") {
            alert("Enter the number");
            document.getElementById("no_embryos_cryopreserved").focus();
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

    $(document).ready(function() {
        $('#btnSubmit').on('click', function(e) {
            if (!validatesubmit()) {
                e.preventDefault(); // Stop form submission if validation fails
            }
        });
    });
    </script> 
    
    
@endsection
