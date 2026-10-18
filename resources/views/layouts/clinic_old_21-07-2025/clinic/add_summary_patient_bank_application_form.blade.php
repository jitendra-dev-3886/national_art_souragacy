@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
.color-csp-clinic-one{
color: red;
}
.width-csp-clinic-two{
    width: 550px;
}
.width-bc-color-csp-clinic-three{
    width: 20%; background-color: #e9ecef; color: #495057;
}
.width-csp-clinic-four{
width: 20%;
}
.width-csp-clinic-five{
width: 48%;
}
.bc-bc-color-csp-clinic-six{
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
@if (session('exists'))
    <script nonce="{{ $cspNonce }}">
        alert("{{ session('exists') }}");
    </script>
@endif

       
            <h3 class="card-title mb-5 text-primary">Reporting Format for ART Bank</h3>
            

              <form name="art_clin1" method="POST" action="{{ route('clinic.summary_patient_save_bank_application_form') }}" enctype="multipart/form-data">                             
                @csrf

                <div class="row">
                    @php
                    $currentYear = date('Y');
                    $currentQuarter = ceil(date('n') / 3);
                @endphp
        
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <strong>a. Quarter and Year</strong>
                        </label>
                        <div class="d-flex gap-3">
                            <select class="form-select width-csp-clinic-five" name="quarter" id="quarterSelect" >
                                <option value="">Select quarter</option>
                                @foreach ($quarter as $quarters)
                                    @php
                                        preg_match('/Q(\d)/', $quarters->description, $matches);
                                        $qnum = $matches[1] ?? 1;
                                    @endphp
                                    <option value="{{ $quarters->id }}" data-quarter="{{ $qnum }}">{{ $quarters->description }}</option>
                                @endforeach
                            </select>
                            <select class="form-select width-csp-clinic-five" name="year" id="yearSelect" >
                                <option value="">Select Year</option>
                                @for ($y = $currentYear; $y >= 2022; $y--)
                                    <option value="{{ $y }}" @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y) selected @endif>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
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
                    <!-- Treatment Month and Year -->
                    {{-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>a. Month and Year</strong>
                            </label>
                            <div class="d-flex gap-3">
                                <select class="form-select" name="month" style="width: 48%;">
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
                                </select>
                
                                <select class="form-select" name="year" style="width: 48%;">
                                    <option value="">Select Year</option>
                                    <?php
                                   //     $currentYear = date('Y');
                                    //    for ($i = $currentYear; $i >= 2022; $i--) {
                                    //        echo "<option value='$i'>$i</option>";
                                     //   }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>b. Name of the
                                    Bank</strong>
                                </label>
                            <div class="input-group">
                                <input type="text" 
                                value="{{ $patient_list->clinicname }}"
                                    {{-- onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" --}}
                                    class="form-control" name="name_of_bank" id="name_of_bank"
                                    aria-describedby="name_of_bank" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                                class="color-csp-clinic-one"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>c. Bank Registration
                                    Number</strong></label>
                            <div class="input-group">
                                <input type="text"
                                    value="{{ $patient_list->bank_reg_no->registration_no }}"
                                    class="form-control" name="bank_reg_num"
                                    id="bank_reg_num" aria-describedby="bank_reg_num"
                                    placeholder="" data-validation="alphanumeric"
                                    data-validation-allowing="_" readonly>
                                  
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="color-csp-clinic-one"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                   
                 
                </div>
                
                <div class="row">

                    <div class=" mb-4 d-flex align-items-center">
                        <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two" ><strong>d. Total number of oocyte donors screened and registered</strong></label>
                         <input type="number" class="form-control width-bc-color-csp-clinic-three"  id="no_oocyte_donors_screened" name="no_oocyte_donors_screened" required>
                    </div>


                    <div class="row">
                      
                        <div class=" mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two" >(i) Number of oocytes cryopreserved/stored in your bank:</label>
                            <input type="number" class="form-control calc-input width-csp-clinic-four"  id="no_oocyte_cryo" name="no_oocyte_cryo" required>
                        </div>
                    
                     
                        <div class=" mb-3 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two" >(ii) Number of Donor oocytes supplied to ART clinic:</label>
                            <input type="number" class="form-control calc-input width-csp-clinic-four" id="no_donor_oocyte" name="no_donor_oocyte" required>
                        </div>

                        <div class=" mb-3 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 width-csp-clinic-two" >(iii) Number of Donor oocytes supplied to surrogacy clinic:</label>
                            <input type="number" class="form-control calc-input width-csp-clinic-four" id="no_donor_surro" name="no_donor_surro" required>
                        </div>
                        <!-- <div class=" mb-4 d-flex align-items-center justify-content-between">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;"><strong>Total number of oocyte donors screened and registered. d (i+ii+iii)</strong></label>
                            <input type="number" class="form-control" style="width: 20%; background-color: #e9ecef; color: #495057;" id="no_oocyte_donors_screened" name="no_oocyte_donors_screened" readonly>
                        </div> -->
                    </div>

                    <div class="row">

                        <div class=" mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3 width-csp-clinic-two"><strong>e. Total Number of semen donors screened & registered</strong></label>
                            <input type="number" class="form-control width-bc-color-csp-clinic-three"  id="no_semen_donors_screened" name="no_semen_donors_screened" required>
                        </div>

                       
                        {{-- <div class="col-md-6"> --}}
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ">(i) Number of donor semen samples cryopreserved/stored in your bank (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four" id="no_donor_semen_cryo" name="no_donor_semen_cryo" required>
                            </div>
                    
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_oocytes_donor_semen" class="form-label me-3 width-csp-clinic-two" ">(ii) Number of patient own semen samples cryopreserved/stored in your bank (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four"  id="no_patient_semen_cryo" name="no_patient_semen_cryo" required>
                            </div>
                    
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_semen_donor_oocytes" class="form-label me-3 width-csp-clinic-two" ">(iii) Number of Donor semen samples supplied to ART clinic (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four" id="no_donor_semen_art" name="no_donor_semen_art" required>
                            </div>                    
                          
                        {{-- </div> --}}
                    
                        {{-- <div class="col-md-6">                           --}}
                    
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 width-csp-clinic-two" >(iv) Number of Donor semen samples supplied to Surrogacy clinic (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four" id="no_donor_semen_surrogacy" name="no_donor_semen_surrogacy" required>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 width-csp-clinic-two">(v) Number of patients own semen samples supplied to ART clinic (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four" id="no_patient_semen_artclinic" name="no_patient_semen_artclinic" required>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 width-csp-clinic-two" >(vi) Number of patients own semen samples supplied to Surrogacy clinic (in vials)</label>
                                <input type="number" class="form-control semen-input width-csp-clinic-four"  id="no_patient_own_semen_sclinic" name="no_patient_own_semen_sclinic" required>
                            </div>                   
                            <!-- <div class=" mb-3 d-flex align-items-center justify-content-between">
                                <label for="indian_nationals" class="form-label me-3" style="width: 550px;"><strong>Total Number of semen donors screened & registered. e (i+ii+ii+iv+v+vi)</strong></label>
                                <input type="number" class="form-control" style="width: 20%; background-color: #e9ecef; color: #495057;" id="no_semen_donors_screened" name="no_semen_donors_screened"  readonly>
                            </div> -->
                        {{-- </div> --}}
                    </div>
                    

                 
                   
                <div class="row">
                    <div class="col-md-4">                    
                        {{-- <button type="submit" name="submit" id="btnSubmit" onclick="return validatesubmit()"
                        class="btn me-2 bc-bc-color-csp-clinic-six">Submit</button> --}}

                <button type="submit" name="submit" id="btnSubmit" class="btn me-2 bc-bc-color-csp-clinic-six">Submit</button>



                </div>
                </div>

                </form>

                </div>
                </div>
                </div>
                </div>
                </div>
                </div>









    
<script nonce="{{ $cspNonce }}">
    // function calculateTotal() {
    //     const cryo = parseInt(document.getElementById('no_oocyte_cryo').value) || 0;
    //     const art = parseInt(document.getElementById('no_donor_oocyte').value) || 0;
    //     const surro = parseInt(document.getElementById('no_donor_surro').value) || 0;

    //     const total = cryo + art + surro;
    //     document.getElementById('no_oocyte_donors_screened').value = total;
    // }

    // document.querySelectorAll('.calc-input').forEach(input => {
    //     input.addEventListener('input', calculateTotal);
    // });



    // function calculateSemenTotal() {
    //     let total = 0;
    //     document.querySelectorAll('.semen-input').forEach(input => {
    //         total += parseInt(input.value) || 0;
    //     });
    //     document.getElementById('no_semen_donors_screened').value = total;
    // }

    // document.querySelectorAll('.semen-input').forEach(input => {
    //     input.addEventListener('input', calculateSemenTotal);
    // });
</script>
    
    
    
    
 {{-- <script nonce="{{ $cspNonce }}">
    document.addEventListener("DOMContentLoaded", function () {
        // Section d: Oocyte donors
        const oocyteMain = document.getElementById("no_oocyte_donors_screened");
        const oocyteFields = [
            document.getElementById("no_oocyte_cryo"),
            document.getElementById("no_donor_oocyte"),
            document.getElementById("no_donor_surro")
        ];

        // Section e: Semen donors
        const semenMain = document.getElementById("no_semen_donors_screened");
        const semenFields = [
            document.getElementById("no_donor_semen_cryo"),
            document.getElementById("no_patient_semen_cryo"),
            document.getElementById("no_donor_semen_art"),
            document.getElementById("no_donor_semen_surrogacy"),
            document.getElementById("no_patient_semen_artclinic"),
            document.getElementById("no_patient_own_semen_sclinic")
        ];

        function validateTotal(mainField, relatedFields, sectionName) {
            const mainVal = parseInt(mainField.value) || 0;
            const total = relatedFields.reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

            if (total > mainVal) {
                alert(`In section ${sectionName}, the total of sub-items cannot exceed the main total.`);

                // Optionally clear the last changed field, or all subfields
                relatedFields.forEach(input => input.value = '');
            }
        }

        function setupValidation(mainField, relatedFields, sectionName) {
            relatedFields.forEach(field => {
                field.addEventListener("input", function () {
                    validateTotal(mainField, relatedFields, sectionName);
                });
            });

            mainField.addEventListener("input", function () {
                validateTotal(mainField, relatedFields, sectionName);
            });
        }

        // Setup validation
        setupValidation(oocyteMain, oocyteFields, "d. The total of (i) to (iii) does not exceed the total number of oocyte donors screened and registered.");
        setupValidation(semenMain, semenFields, "e. The total of (i) to (vi) does not exceed the total Number of semen donors screened & registered");
    });
</script> --}}

    
    
    
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
                const qNum = parseInt(option.getAttribute('data-quarter'));

                if (!qNum || isNaN(selectedYear)) {
                    option.hidden = false;
                    return;
                }

                if (selectedYear === currentYear) {
                    // Show only current financial quarter
                    option.hidden = qNum !== currentFinQuarter;
                } else {
                    option.hidden = false;
                }
            });

            const selectedOption = quarterSelect.selectedOptions[0];
            if (selectedOption && selectedOption.hidden) {
                quarterSelect.selectedIndex = 0;
            }
        }

        yearSelect.addEventListener('change', filterQuarters);
        filterQuarters();
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
        if (document.getElementById("no_oocyte_donors_screened").value == "") {
            alert("Select Quarter");
            document.getElementById("no_oocyte_donors_screened").focus();
            return false;
        }          
        if (document.getElementById("no_oocyte_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_oocyte_cryo").focus();
            return false;
        } 
        if (document.getElementById("no_donor_surro").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_surro").focus();
            return false;
        } 
        if (document.getElementById("no_semen_donors_screened").value == "") {
            alert("Enter the number");
            document.getElementById("no_semen_donors_screened").focus();
            return false;
        } 
        if (document.getElementById("no_donor_semen_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_semen_cryo").focus();
            return false;
        } 
        
        if (document.getElementById("no_donor_oocyte").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocyte").focus();
            return false;
        } 
        if (document.getElementById("no_patient_semen_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_semen_cryo").focus();
            return false;
        }        
        if (document.getElementById("no_donor_semen_art").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_semen_art").focus();
            return false;
        } 
        if (document.getElementById("no_donor_semen_surrogacy").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_semen_surrogacy").focus();
            return false;
        } 
        if (document.getElementById("no_patient_semen_artclinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_semen_artclinic").focus();
            return false;
        }
        if (document.getElementById("no_patient_own_semen_sclinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_own_semen_sclinic").focus();
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

  $(document).ready(function () {
        $('#btnSubmit').on('click', function (e) {
            if (!validatesubmit()) {
                e.preventDefault(); // prevent form submission
            }
        });
    });

    </script> 
    



@endsection