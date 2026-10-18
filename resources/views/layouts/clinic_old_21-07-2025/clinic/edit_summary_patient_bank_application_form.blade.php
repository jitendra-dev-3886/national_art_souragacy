@extends('layouts.clinic.clinic_master')
@section('content')



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



.widthfe-csp-clinic-one{
width: 48%;
}
.widthff-csp-clinic-two{
    width: 550%;
}
.clr-csp-clinic-three{
color: red;
}
.wdbdclr-csp-clinic-four{
width: 20%; background-color: #e9ecef; color: #495057;
}
.btn-bgclr-csp-clinic-five{
background-color: #0b5ed7; border-color: #0b5ed7; color: white;
}
.wdtp-csp-clinic-six{
    width: 20%;
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
                    <strong>a. Quarter and Year</strong>
                </label>
                <div class="d-flex gap-3">
                    <div class="d-flex gap-3">
                        <input type="text" class="form-control widthfe-csp-clinic-one"  name="quarter" value="{{ $report->quarter }}" readonly>
                    
                        <input type="text" class="form-control widthfe-csp-clinic-one"  name="year" value="{{ $report->year }}" readonly>
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

                    <div class=" mb-4 d-flex align-items-center">
                        <label for="indian_nationals" class="form-label me-3 widthff-csp-clinic-two" ><strong>d. Total number of oocyte donors screened and registered</strong></label>
                        <input type="number" class="form-control wdbdclr-csp-clinic-four"  value="{{ $report->no_oocyte_donors_screened }}" id="no_oocyte_donors_screened" name="no_oocyte_donors_screened" required>
                    </div>


                    <div class="row">
                      
                        <div class=" mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3 widthff-csp-clinic-two" >(i) Number of oocytes cryopreserved/stored in your bank:</label>
                            <input type="number" class="form-control calc-input wdtp-csp-clinic-six"  id="no_oocyte_cryo" name="no_oocyte_cryo" value="{{ $report->no_oocyte_cryo }}" required>
                        </div>
                    
                     
                        <div class=" mb-3 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 widthff-csp-clinic-two">(ii) Number of Donor oocytes supplied to ART clinic:</label>
                            <input type="number" class="form-control calc-input wdtp-csp-clinic-six"  id="no_donor_oocyte" name="no_donor_oocyte" value="{{ $report->no_donor_oocyte }}" required>
                        </div>

                        <div class=" mb-3 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 widthff-csp-clinic-two" >(iii) Number of Donor oocytes supplied to surrogacy clinic:</label>
                            <input type="number" class="form-control calc-input wdtp-csp-clinic-six"  id="no_donor_surro" name="no_donor_surro" value="{{ $report->no_donor_surro }}" required>
                        </div>
                        <!-- <div class=" mb-4 d-flex align-items-center justify-content-between">
                            <label for="indian_nationals" class="form-label me-3" style="width: 550px;"><strong>Total number of oocyte donors screened and registered. d (i+ii+iii)</strong></label>
                            <input type="number" class="form-control" style="width: 20%; background-color: #e9ecef; color: #495057;" value="{{ $report->no_oocyte_donors_screened }}" id="no_oocyte_donors_screened" name="no_oocyte_donors_screened" readonly>
                        </div> -->
                    </div>

                    <div class="row">

                        <div class=" mb-3 d-flex align-items-center">
                            <label for="indian_nationals" class="form-label me-3 widthff-csp-clinic-two" ><strong>e. Total Number of semen donors screened & registered</strong></label>
                            <input type="number" class="form-control wdbdclr-csp-clinic-four" id="no_semen_donors_screened" name="no_semen_donors_screened"  value="{{ $report->no_semen_donors_screened }}">
                        </div>

                       
                        
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_self_gametes" class="form-label me-3 widthff-csp-clinic-two">(i) Number of donor semen samples cryopreserved/stored in your bank (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six" id="no_donor_semen_cryo" name="no_donor_semen_cryo" value="{{ $report->no_donor_semen_cryo }}" required>
                            </div>
                    
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_oocytes_donor_semen" class="form-label me-3 widthff-csp-clinic-two" >(ii) Number of patient own semen samples cryopreserved/stored in your bank (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six"  id="no_patient_semen_cryo" name="no_patient_semen_cryo" value="{{ $report->no_patient_semen_cryo }}" required>
                            </div>
                    
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_semen_donor_oocytes" class="form-label me-3 widthff-csp-clinic-two" >(iii) Number of Donor semen samples supplied to ART clinic (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six"  id="no_donor_semen_art" name="no_donor_semen_art" value="{{ $report->no_donor_semen_art }}" required>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 widthff-csp-clinic-two" >(iv) Number of Donor semen samples supplied to Surrogacy clinic (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six"  id="no_donor_semen_surrogacy" name="no_donor_semen_surrogacy" value="{{ $report->no_donor_semen_surrogacy }}" required>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 widthff-csp-clinic-two" >(v) Number of patients own semen samples supplied to ART clinic (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six"  id="no_patient_semen_artclinic" name="no_patient_semen_artclinic" value="{{ $report->no_patient_semen_artclinic }}" required>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                                <label for="ongoing_single_woman" class="form-label me-3 widthff-csp-clinic-two" >(vi) Number of patients own semen samples supplied to Surrogacy clinic (in vials)</label>
                                <input type="number" class="form-control semen-input wdtp-csp-clinic-six"  id="no_patient_own_semen_sclinic" name="no_patient_own_semen_sclinic" value="{{ $report->no_patient_own_semen_sclinic }}" required>
                            </div>                   
                            <!-- <div class=" mb-3 d-flex align-items-center justify-content-between">
                                <label for="indian_nationals" class="form-label me-3" style="width: 550px;"><strong>Total Number of semen donors screened & registered. e (i+ii+ii+iv+v+vi)</strong></label>
                                <input type="number" class="form-control" style="width: 20%; background-color: #e9ecef; color: #495057;" id="no_semen_donors_screened" name="no_semen_donors_screened"  value="{{ $report->no_semen_donors_screened }}" readonly>
                            </div>    -->
                    </div>
                    

                 
                   
                <div class="row">
                    <div class="col-md-4">                    
                        <button type="button" onclick="window.location.href='{{ route('clinic.clinicForm_list') }}'" class="btn me-2 btn btn-danger">Close</button>                            
                        <button type="submit" name="submit" id="btnSubmit"
                        class="btn me-2 btn-bgclr-csp-clinic-five" >update</button>
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

document.addEventListener('DOMContentLoaded', function () {
    const form = document.forms['art_clin1'];
    const alertedFields = new Set();

    if (form) {
        const inputs = form.querySelectorAll('input');

        inputs.forEach(function (input) {
            input.addEventListener('focus', function () {
                if (!alertedFields.has(input.name) && input.value.trim() === '') {
                    // Try 1: label with for= matching input id
                    let label = document.querySelector(`label[for="${input.id}"]`);

                    // Try 2: if no label found, check if input is inside a label (ancestor)
                    if (!label) {
                        let parent = input.parentElement;
                        while (parent) {
                            if (parent.tagName.toLowerCase() === 'label') {
                                label = parent;
                                break;
                            }
                            parent = parent.parentElement;
                        }
                    }

                    // Try 3: if still no label, try previous sibling label (common pattern)
                    if (!label) {
                        let prev = input.previousElementSibling;
                        while (prev) {
                            if (prev.tagName.toLowerCase() === 'label') {
                                label = prev;
                                break;
                            }
                            prev = prev.previousElementSibling;
                        }
                    }

                    // Get label text or fallback to input name
                    let fieldName = label ? label.innerText.trim() : input.name || 'This field';

                    // Remove trailing colon or asterisk if any (clean up)
                    fieldName = fieldName.replace(/[:*]$/, '').trim();

                    alert(`Please fill out: ${fieldName}`);
                    alertedFields.add(input.name);
                }
            });
        });
    }
});

    // document.addEventListener('DOMContentLoaded', function () {
    //     const form = document.forms['art_clin1'];
    //     const alertedFields = new Set();

    //     if (form) {
    //         const inputs = form.querySelectorAll('input');

    //         inputs.forEach(function (input) {
    //             input.addEventListener('focus', function () {
    //                 if (!alertedFields.has(input.name) && input.value.trim() === '') {
    //                     let label = document.querySelector(`label[for="${input.id}"]`);
    //                     let fieldName = label ? label.innerText.trim() : input.name || 'This field';
    //                     alert(`Please fill out: ${fieldName}`);
    //                     alertedFields.add(input.name);
    //                 }
    //             });
    //         });
    //     }
    // });
</script>







    
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
    
    
    
    
    
    <script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('name_of_bank');

    if (input) {
        input.addEventListener('keypress', function (event) {
            const charCode = event.charCode;
            const isAlphabet = (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122);

            if (!isAlphabet) {
                event.preventDefault();
            }
        });
    }
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
    // function validatesubmit() {
    //     if (document.getElementById("yearSelect").value == "") {
    //         alert("Select Year");
    //         document.getElementById("yearSelect").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("quarterSelect").value == "") {
    //         alert("Select Quarter");
    //         document.getElementById("quarterSelect").focus();
    //         return false;
    //     }
    //     if (document.getElementById("no_oocyte_donors_screened").value == "") {
    //         alert("Select Quarter");
    //         document.getElementById("no_oocyte_donors_screened").focus();
    //         return false;
    //     }          
    //     if (document.getElementById("no_oocyte_cryo").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_oocyte_cryo").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_donor_surro").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_donor_surro").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_semen_donors_screened").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_semen_donors_screened").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_donor_semen_cryo").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_donor_semen_cryo").focus();
    //         return false;
    //     } 
        
    //     if (document.getElementById("no_donor_oocyte").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_donor_oocyte").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_patient_semen_cryo").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_patient_semen_cryo").focus();
    //         return false;
    //     }        
    //     if (document.getElementById("no_donor_semen_art").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_donor_semen_art").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_donor_semen_surrogacy").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_donor_semen_surrogacy").focus();
    //         return false;
    //     } 
    //     if (document.getElementById("no_patient_semen_artclinic").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_patient_semen_artclinic").focus();
    //         return false;
    //     }
    //     if (document.getElementById("no_patient_own_semen_sclinic").value == "") {
    //         alert("Enter the number");
    //         document.getElementById("no_patient_own_semen_sclinic").focus();
    //         return false;
    //     }            
    //     var agree = confirm(
    //         "Kindly check and confirm all details before final submission. There is no provision for editing/correction once the form is submitted."
    //     );
    //     if (agree) {
    
    //         return true;
    //     } else {
    //         return false;
    //     }
    //     return true;
    // }
    </script> 
    



@endsection