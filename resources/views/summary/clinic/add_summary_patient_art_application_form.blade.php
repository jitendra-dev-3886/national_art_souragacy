@extends('layouts.clinic.clinic_master')

@section('content')

<style nonce="{{$cspNonce}}">
    .color-csp-clinic-one{
    color: red;
    }
    .width-csp-clinic-two{
    width: 550px;
    }
    .width-csp-clinic-three{
        width: 48%;
    }
    .width-csp-clinic-four{
    width: 20%;  
    }
    .bc-bc-color-csp-clinic-five{
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
    .csp-readonlycolor {
        background-color: #e8eaec !important;
        font-weight: bold;
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

        <h3 class="card-title mb-5 text-primary">Patient Summary Reporting Format for ART Clinic (Level-I)</h3>            
            <form  method="POST" action="{{ url('clinic/summary-patient-application-form-new') }}" enctype="multipart/form-data">                             
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>a. Year and Quarter</strong>
                            </label>
                            <input type="hidden" value="{{ $clinic_type }}" class="form-control" name="clinic_type"> 

                            <div class="d-flex gap-3">

                                @if (!empty($data['year']))
                                    <input type="text" name="year" class="form-control csp-readonlycolor"
                                    value="{{ $data['year'] }}" readonly>
                                    <input type="hidden" name="year" value="{{ $data['year'] }}">
                                @endif

                                @if (!empty($data['quarter']))
                                    <input type="hidden" name="quarter" class="form-control" value="{{ $data['quarter'] }}" readonly>
                                    <input type="text"  class="form-control csp-readonlycolor" value="{{ $quarter_desc }}" readonly>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>c. Name of the Clinic</strong> </label>
                            <div class="input-group">
                                <input type="text" class="form-control csp-readonlycolor" name="name_of_clinic" id="name_of_clinic" value="{{ $clinic->name }}" aria-describedby="name_of_clinic" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID" class="color-csp-clinic-one"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>b. Clinic Registration Number</strong></label>
                            <div class="input-group">
                                <input type="text" value="{{ $clinic->registration_no }}" class="form-control csp-readonlycolor" name="clinic_level1_reg_num" id="clinic_level1_reg_num" aria-describedby="clinic_level1_reg_num"
                                    placeholder="" data-validation="alphanumeric"
                                    data-validation-allowing="_" readonly> 
                            </div>
                            <span id="clinic_level1_reg_numID" class="color-csp-clinic-one"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Ongoing Surrogacy Column -->
                    <input type="hidden" class="form-control" name="summary_id"  value="{{ $summary_exists->id ?? '' }}" required>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>d. Total Number of Patients undergoing IUI procedure (ongoing cases)</strong></label>
                        {{-- <input type="number" class="form-control" style="width: 40%;" id="no_patient_IUI_onoing" name="no_patient_IUI_onoing"  placeholder="Auto-calculated" readonly> --}}
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >d.1 Number of Married couples</label>
                        {{-- <input type="number" class="form-control" style="width: 40%;" id="no_married_couples" name="no_married_couples"  placeholder="Auto-calculated" readonly> --}}
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >d.1.a Using self-gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_ongoing_self_gametes" name="no_ongoing_self_gametes" value="{{ $summary_exists->no_ongoing_self_gametes ?? '' }}" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_donor_semen" class="form-label me-3 width-csp-clinic-two">d.1.b Using donor semen</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_ongoing_donor_semen" value="{{ $summary_exists->no_ongoing_donor_semen ?? '' }}" name="no_ongoing_donor_semen" required>
                    </div>


                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>(d.1.a+d.1.b) Total Married Couples </strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_married_couples" value="{{ $summary_exists->no_married_couples ?? '' }}" name="no_married_couples"  placeholder="" readonly>
                    </div>
                    
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_single_woman" class="form-label me-3 width-csp-clinic-two" >d.2 Single women (unmarried/widow/divorcee)</label>
                        <input type="number" class="form-control width-csp-clinic-four"id="no_ongoing_single_woman" value="{{ $summary_exists->no_ongoing_single_woman ?? '' }}" name="no_ongoing_single_woman" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total Patients Undergoing IUI d (d.1+d.2)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_patient_IUI_onoing" value="{{ $summary_exists->no_patient_IUI_onoing ?? '' }}" name="no_patient_IUI_onoing"  placeholder="" readonly>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>e. Total Number of Patients where IUI procedure has been completed</strong></label>
                        {{-- <input type="number" class="form-control" style="width: 20%;" id="no_patient_IUI_completed" name="no_patient_IUI_completed" placeholder="Auto-calculated" readonly> --}}
                    </div>


                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two">e.1 Married couples</label>
                        {{-- <input type="number" class="form-control" style="width: 40%;" id="no_married_couple" name="no_married_couple" placeholder="Auto-calculated" readonly> --}}
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_self_gametes" class="form-label me-3 width-csp-clinic-two" >e.1.a Using self-gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_self_gametes" value="{{ $summary_exists->no_completed_self_gametes ?? '' }}" name="no_completed_self_gametes" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_oocytes_donor_semen" class="form-label me-3 width-csp-clinic-two" >e.1.b Using donor semen</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_donor_semen" value="{{ $summary_exists->no_completed_donor_semen ?? '' }}" name="no_completed_donor_semen" required>
                    </div>
            
                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>(e.1.a+e.1.b) Total Married Couples</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_married_couple" value="{{ $summary_exists->no_married_couple ?? '' }}" name="no_married_couple"  readonly>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_single_woman" class="form-label me-3 width-csp-clinic-two">e.2 Single women (unmarried/widow/divorcee):</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_single_woman" value="{{ $summary_exists->no_completed_single_woman ?? '' }}" name="no_completed_single_woman" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>Total Patients completed IUI e (e.1+e.2)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_patient_IUI_completed" value="{{ $summary_exists->no_patient_IUI_completed ?? '' }}" name="no_patient_IUI_completed"  readonly>
                    </div>

                    
                   <div class="mb-3 d-flex align-items-center">
    <label class="form-label me-3 width-csp-clinic-two">
        <strong>f. Date of submission of the form (DD/MM/YY)</strong>
    </label>

  <input type="date" class="form-control width-csp-clinic-four"  id="date_of_submission"  name="date_of_submission"  value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" readonly  >
</div>
                {{-- </div> --}}
                </div>
                <div class="row">
                    <div class="col-md-4">                    
                        <button type="submit" name="submit" id="btnSubmit"
                        class="btn me-2 bc-bc-color-csp-clinic-five" >Submit</button>
                    </div>
                </div>


            </form>

    <script nonce="{{ $cspNonce }}">
        function updateIUICounts() {
            const selfGametes = parseInt(document.getElementById('no_ongoing_self_gametes').value) || 0;
            const donorSemen = parseInt(document.getElementById('no_ongoing_donor_semen').value) || 0;
            const singleWomen = parseInt(document.getElementById('no_ongoing_single_woman').value) || 0;
        
            const marriedCouples = selfGametes + donorSemen;
            const totalPatients = marriedCouples + singleWomen;
        
            document.getElementById('no_married_couples').value = marriedCouples;
            document.getElementById('no_patient_IUI_onoing').value = totalPatients;
        }
        
        // Attach listener
        document.querySelectorAll('#no_ongoing_self_gametes, #no_ongoing_donor_semen, #no_ongoing_single_woman')
            .forEach(input => input.addEventListener('input', updateIUICounts));

            function updateIUICountss() {
            const selfGametess = parseInt(document.getElementById('no_completed_self_gametes').value) || 0;
            const donorSemens = parseInt(document.getElementById('no_completed_donor_semen').value) || 0;
            const singleWomens = parseInt(document.getElementById('no_completed_single_woman').value) || 0;
        
            const marriedCoupless = selfGametess + donorSemens;
            const totalPatientss = marriedCoupless + singleWomens;
        
            document.getElementById('no_married_couple').value = marriedCoupless;
            document.getElementById('no_patient_IUI_completed').value = totalPatientss;
        }
        
        // Attach listener
        document.querySelectorAll('#no_completed_self_gametes, #no_completed_donor_semen, #no_completed_single_woman')
            .forEach(input => input.addEventListener('input', updateIUICountss));
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
        if (document.getElementById("no_ongoing_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_donor_semen").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_single_woman").focus();
            return false;
        } 
        if (document.getElementById("no_completed_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_completed_donor_semen").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_donor_semen").focus();
            return false;
        }        
        if (document.getElementById("no_completed_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_single_woman").focus();
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
                e.preventDefault(); // prevent form submit if validation fails
            }
            // else form will submit naturally
        });
    });
    

    </script>
@endsection