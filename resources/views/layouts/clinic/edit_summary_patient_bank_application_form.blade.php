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

                    <h3 class="card-title mb-5 text-primary">Patient Summary Reporting Format for ART Bank</h3>            
         
                 <form name="art_clin1" method="POST" action="{{ route('clinic.summary_patient_save_bank_application_form_edit') }}" enctype="multipart/form-data">                             
                @csrf
                <input type="hidden" name="id" value="{{ $report->id }}">
                <div class="row">
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
                    <div class="d-flex gap-3">
                    
                        <input type="text" class="form-control widthfe-csp-clinic-one"  name="year" value="{{ $report->year }}" readonly>
                        <input type="hidden" class="form-control widthfe-csp-clinic-one"  name="quarter" value="{{ $report->quarter }}" readonly>
                        <input type="text" class="form-control widthfe-csp-clinic-one"  value="{{ $report->quarterdesc->description }}" readonly>
                    </div>
                  
                </div>
            </div>
        </div>                   
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>b. Name of the
                                    Bank</strong>
                                </label>
                            <div class="input-group">
                                <input type="text" 
                                value="{{ $report->name_of_bank }}"
                                    {{-- onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)" --}}
                                    class="form-control" name="name_of_bank" id="name_of_bank"
                                    aria-describedby="name_of_bank" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                                class="clr-csp-clinic-three">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>c. Bank Registration
                                    Number</strong></label>
                            <div class="input-group">
                                <input type="text"
                                    value="{{ $report->bank_reg_num }}"
                                    class="form-control" name="bank_reg_num"
                                    id="bank_reg_num" aria-describedby="bank_reg_num"
                                    placeholder="" data-validation="alphanumeric"
                                    data-validation-allowing="_" readonly>
                                  
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="clr-csp-clinic-three">
                    </div>
                   
                 
                </div>

                <div class="row">
                    <!-- Ongoing Surrogacy Column -->
                    <input type="hidden" class="form-control" name="summary_id"  value="{{ $report->id ?? '' }}" required>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>d. Total Number of oocyte donors screened and registered</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_oocyte_donor" name="no_oocyte_donors_screened" value="{{ $report->no_oocyte_donors_screened ?? '' }}" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>e. Total Number of oocyte cryopreserved/stored in your bank(e.i+e.ii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" id="total_oocyte_stored" value="{{ $report->total_oocyte_stored ?? '' }}" name="total_oocyte_stored"  placeholder="(e.i+e.ii)" readonly>
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >i. Number of donor oocytes cryopreserved/stored in your bank</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_donor_oocyte_store" name="no_oocyte_cryo" value="{{ $report->no_oocyte_cryo ?? '' }}" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >ii. Number of patient own oocytes cryopreserved/stored in your bank</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_patient_oocyte_store" name="no_donor_oocyte" value="{{ $report->no_donor_oocyte ?? '' }}" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>f. Total Number of oocyte supplied(f.i+f.ii+f.iii+f.iv)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" name="no_semen_donors_screened"  id="total_oocyte_supplied" value="{{ $report->no_semen_donors_screened ?? '' }}" placeholder="(f.i+f.ii+f.iii+f.iv)" readonly>
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >i. Number of donor oocytes supplied to ART clinic</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_donor_oocytes_supplied_clinic" name="no_donor_semen_cryo" value="{{ $report->no_donor_semen_cryo ?? '' }}" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >ii. Number of donor oocytes supplied to surrogacy clinic</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_donor_oocytes_supplied_surrogacy" name="no_donor_surro" value="{{ $report->no_donor_surro ?? '' }}" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_donor_semen" class="form-label me-3 width-csp-clinic-two">iii. Number of patient own oocytes supplied to ART clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_oocytes_supplied_clinic" value="{{ $report->no_patient_semen_cryo ?? '' }}" name="no_patient_semen_cryo" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_donor_semen" class="form-label me-3 width-csp-clinic-two">iv. Number of patient own oocytes supplied to surrogacy clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_oocytes_supplied_surrogacy" value="{{ $report->no_patient_oocytes_supplied_surrogacy ?? '' }}" name="no_patient_oocytes_supplied_surrogacy" required>
                    </div>


                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>g. Total Number of semen donors screened & registered</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="total_semen_donor" value="{{ $report->total_semen_donor ?? '' }}" name="total_semen_donor"  placeholder="">
                    </div>
                    

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>h. Total Number of semen samples cryopreserved/stored in your bank(in vials)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" name="total_semen_sample_store"  id="total_semen_sample_store" value="{{ $report->total_semen_sample_store ?? '' }}" placeholder="(h.i+h.ii)" readonly>
                    </div>

            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_self_gametes" class="form-label me-3 width-csp-clinic-two" >i.Number of donor semen samples cryopreserved/stored (in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="donor_semen_sample_store" value="{{ $report->donor_semen_sample_store ?? '' }}" name="donor_semen_sample_store" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_oocytes_donor_semen" class="form-label me-3 width-csp-clinic-two" >ii.Number of patient own semen samples cryopreserved/stored (in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="patient_semen_sample_store" value="{{ $report->patient_semen_sample_store ?? '' }}" name="patient_semen_sample_store" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i. Total Number of semen samples supplied(in vials)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" name="total_semen_sample_supplied"  id="total_semen_sample_supplied" value="{{ $report->total_semen_sample_supplied ?? '' }}" placeholder="(i.i+i.ii+i.iii+i.iv)" readonly>
                    </div>

            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_self_gametes" class="form-label me-3 width-csp-clinic-two" >i.Number of donor semen samples supplied to ART clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_donor_semen_supplied_clinic" value="{{ $report->no_donor_semen_art ?? '' }}" name="no_donor_semen_art" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_oocytes_donor_semen" class="form-label me-3 width-csp-clinic-two" >ii.Number of donor semen samples supplied to surrogacy clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_donor_semen_supplied_surrogacy" value="{{ $report->no_donor_semen_surrogacy ?? '' }}" name="no_donor_semen_surrogacy" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_self_gametes" class="form-label me-3 width-csp-clinic-two" >iii.Number of patient own semen samples supplied to ART clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_semen_supplied_clinic" value="{{ $report->no_patient_semen_artclinic ?? '' }}" name="no_patient_semen_artclinic" required>
                    </div>
            
                    <div class="mb-3 d-flex align-items-center">
                        <label for="completed_oocytes_donor_semen" class="form-label me-3 width-csp-clinic-two" >iv.Number of patient own samples supplied to surrogacy clinic(in vials)</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_semen_supplied_surrogacy" value="{{ $report->no_patient_semen_supplied_surrogacy ?? '' }}" name="no_patient_semen_supplied_surrogacy" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>j. Date of submission of the form(DD/MM/YY)</strong></label>
                        <input type="date" class="form-control width-csp-clinic-four" id="date_of_submission"   name="date_of_submission"    value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"  readonly>
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
        function toInt(id) {
            return parseInt(document.getElementById(id).value) || 0;
        }

        // e = e.i + e.ii
        function calcE() {
            document.getElementById('total_oocyte_stored').value =
                toInt('no_donor_oocyte_store') + toInt('no_patient_oocyte_store');
        }

        // f = f.i + f.ii + f.iii + f.iv
        function calcF() {
            document.getElementById('total_oocyte_supplied').value =
                toInt('no_donor_oocytes_supplied_clinic') +
                toInt('no_donor_oocytes_supplied_surrogacy') +
                toInt('no_patient_oocytes_supplied_clinic') +
                toInt('no_patient_oocytes_supplied_surrogacy');
        }

        // h = h.i + h.ii
        function calcH() {
            document.getElementById('total_semen_sample_store').value =
                toInt('donor_semen_sample_store') +
                toInt('patient_semen_sample_store');
        }

        // i = i.i + i.ii + i.iii + i.iv
        function calcI() {
            document.getElementById('total_semen_sample_supplied').value =
                toInt('no_donor_semen_supplied_clinic') +
                toInt('no_donor_semen_supplied_surrogacy') +
                toInt('no_patient_semen_supplied_clinic') +
                toInt('no_patient_semen_supplied_surrogacy');
        }

        // Attach listeners
        [
        'no_donor_oocyte_store','no_patient_oocyte_store',
        'no_donor_oocytes_supplied_clinic','no_donor_oocytes_supplied_surrogacy',
        'no_patient_oocytes_supplied_clinic','no_patient_oocytes_supplied_surrogacy',
        'donor_semen_sample_store','patient_semen_sample_store',
        'no_donor_semen_supplied_clinic','no_donor_semen_supplied_surrogacy',
        'no_patient_semen_supplied_clinic','no_patient_semen_supplied_surrogacy'
        ].forEach(id => {
            document.getElementById(id).addEventListener('input', function () {
                if (this.value < 0) this.value = 0;
                calcE(); calcF(); calcH(); calcI();
            });
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
        if (document.getElementById("no_oocyte_donor").value == "") {
            alert("Oocyte Donor filed is required");
            document.getElementById("no_oocyte_donor").focus();
            return false;
        }
        
        if (document.getElementById("no_donor_oocyte_store").value == "") {
            alert("Oocyte donor store filed is required");
            document.getElementById("no_donor_oocyte_store").focus();
            return false;
        }     
              
        if (document.getElementById("no_patient_oocyte_store").value == "") {
            alert("Oocyte patient store filed is required");
            document.getElementById("no_patient_oocyte_store").focus();
            return false;
        } 
        
        if (document.getElementById("no_donor_oocytes_supplied_clinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocytes_supplied_clinic").focus();
            return false;
        } 
        if (document.getElementById("no_donor_oocytes_supplied_surrogacy").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocytes_supplied_surrogacy").focus();
            return false;
        } 
        if (document.getElementById("no_patient_oocytes_supplied_clinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_oocytes_supplied_clinic").focus();
            return false;
        }        
        if (document.getElementById("no_patient_oocytes_supplied_surrogacy").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_oocytes_supplied_surrogacy").focus();
            return false;
        } 
        if (document.getElementById("total_semen_donor").value == "") {
            alert("Enter the number");
            document.getElementById("total_semen_donor").focus();
            return false;
        }  
        
        if (document.getElementById("donor_semen_sample_store").value == "") {
            alert("Enter the number");
            document.getElementById("donor_semen_sample_store").focus();
            return false;
        }  
        if (document.getElementById("patient_semen_sample_store").value == "") {
            alert("Enter the number");
            document.getElementById("patient_semen_sample_store").focus();
            return false;
        } 

        if (document.getElementById("no_donor_semen_supplied_clinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_semen_supplied_clinic").focus();
            return false;
        } 
        if (document.getElementById("no_donor_semen_supplied_surrogacy").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_semen_supplied_surrogacy").focus();
            return false;
        } 
        if (document.getElementById("no_patient_semen_supplied_clinic").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_semen_supplied_clinic").focus();
            return false;
        } 
        if (document.getElementById("no_patient_semen_supplied_surrogacy").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_semen_supplied_surrogacy").focus();
            return false;
        }   

        // if (document.getElementById("date_of_submission").value == "") {
        //     alert("Oocyte Donor filed is required");
        //     document.getElementById("date_of_submission").focus();
        //     return false;
        // }
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