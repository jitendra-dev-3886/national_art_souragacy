@extends('layouts.clinic.clinic_master')
@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-btn-primary {
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
    .csp-readonlycolor {
    background-color: #e8eaec !important;  /* light blue, change as needed */
    font-weight: bold;          /* optional */
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
    .total-patient{
       font-weight: 600;
    }
    .progress-bar {
    background-color: #0d6efd;
    }
    .patient-round {
        width:30px;height:30px;font-weight:bold;
    }
    .display-none {
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

                @if(session('exists'))
                <div class="alert alert-warning">
                    {{ $messagea ?? 'This quarter and year have already been added!' }}
                </div>
            @endif
            <h3 class="card-title mb-5 text-primary">Reporting period</h3>

            <form id="art_clin1" action="{{ route('clinic.reporting_already_live_period_patient_save_clinic_application_form') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="quarter_id" value="{{ $reporting_data->id }}">

                <div class="row">
                    <div class="col-md-6">
                        <div class="card border mb-3">
                            <div class="card-header">
                                <strong>Reporting Period</strong>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><strong>Year and Quarter</strong></label>
                                        <div class="d-flex gap-3">
                                            @if ($available_years->count() === 1)
                                                <input type="text" name="year" class="form-control csp-readonlycolor"
                                                    value="{{ $available_years->first()->year }}" readonly>
                                                <input type="hidden" name="year" value="{{ $available_years->first()->year }}">
                                            @endif

                                            @if ($available_quarters->count() === 1)
                                                <input type="text" class="form-control csp-readonlycolor" value="{{ $available_quarters->first()['description'] }}" readonly>
                                                <input type="hidden" name="quarter" value="{{ $available_quarters->first()['id'] }}">
                                            @endif

                                            

                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="continueBtn"
                                        class="btn btn-primary mt-3">
                                    Continue Patient Details
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border mb-3">
                            <div class="card-header ">
                                <strong>Current Reporting Period({{ $available_quarters->first()['description'] }},{{ $available_years->first()->year }})</strong>
                            </div>

                            <div class="card-body">
                                @php
                                    use App\Models\patient\PatientArtclinic;

                                    $totalPatients = PatientArtclinic::where('clinic_id', $reporting_data->clinic_id)
                                        ->where('year', $available_years->first()->year)
                                        ->where('quarter', $available_quarters->first()['id'])
                                        ->count();
                                @endphp

                                <p class="mb-2 total-patient">
                                    No. of patient details submitted :
                                    <span class="patient-round rounded-circle bg-danger text-white d-inline-flex justify-content-center align-items-center">
                                        {{ $totalPatients }}
                                    </span>
                                </p>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="completedCheck" name="status" value="Finished">
                                    <label class="form-check-label" for="completedCheck">
                                        All patient details for above reporting period completed
                                    </label>
                                   
                                    

                                    @if($totalPatients == 0)
                                     <br>
                                        <input class="form-check-input" type="checkbox" id="nillcheck" name="is_nilldata" value="1" disabled>
                                        <label class="form-check-label" for="nillcheck">
                                            No cases to report for this period.
                                        </label>
                                    @endif
                                   
                                </div>


                                <button type="submit" id="completedBtn" class="btn btn-primary  display-none">Final Submit</button>

                            </div>
                        </div>
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
        // $(document).ready(function () {
        //     // Only one checkbox can be selected at a time
        //     $('#completedCheck, #continueCheck').on('change', function () {
        //         $('#completedCheck, #continueCheck').not(this).prop('checked', false);
        //         $('#submitBtn').text($('#completedCheck').is(':checked') ? 'Submit' : 'Continue');
        //     });
        
        //     $('#art_clin1').on('submit', function(e) {
        //         e.preventDefault();
        
        //         const completed = $('#completedCheck').is(':checked');
        //         const continueStatus = $('#continueCheck').is(':checked');
        
        //         if (!completed && !continueStatus) {
        //             alert('Please select either "Completed" or "Continue".');
        //             return;
        //         }
        
        //         let formData = new FormData(this);
        //         formData.set('status', completed ? 'Finished' : 'Live'); // Ensure correct value is sent
        
        //         $.ajax({
        //             type: 'POST',
        //             url: "{{ route('clinic.reporting_already_live_period_patient_save_clinic_application_form') }}",
        //             data: formData,
        //             contentType: false,
        //             processData: false,
        //             success: function(response) {
        //                 if (response.exists) {
        //                     alert(response.message);
        //                     return;
        //                 }
        
        //                alert(response.message);
        
        //                 // Redirect to patient form if "Continue" was selected
        //                 if (continueStatus) {
        //                     window.location.href = "{{ route('clinic.add_patient_clinic_application_form') }}";
        //                 } else if (completed) {
        //                 window.location.href = "{{ route('clinic.clinicForm_list') }}";
        //             }
        //             },
        //             error: function(xhr) {
        //                 alert('Something went wrong. Please try again.');
        //             }
        //         });
        //     });
        // });
        $(document).ready(function () {
            $('#completedCheck').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#continueBtn').prop('disabled', true);
                    $('#completedBtn').prop('disabled', false);
                    $('#nillcheck').prop('disabled', false);
                    
                    $('#continueBtn').hide();
                    $('#completedBtn').show();
                } else {
                    $('#continueBtn').prop('disabled', false);
                    $('#completedBtn').prop('disabled', true);
                    $('#nillcheck').prop('disabled', true).prop('checked', false);
                    $('#continueBtn').show();
                    $('#completedBtn').hide();
                }
            });
            $('#completedBtn').on('click', function(e) {
            const nill_submit = $('#nillcheck').is(':checked');
            const completed = $('#completedCheck').is(':checked');
                if({{$totalPatients }}===0)
                {
                    if(!nill_submit)
                    {
                        alert("Please click on the undertaking that No cases to report for this period.");
                        return false;
                    }
                    if(completed && nill_submit)
                    {
                        const confirmed = confirm(
                            "Kindly check and confirm details before final submission.There will be no option for Editing/Updating details after final submission of this quarter."
                        );
                    }

                }
            })
            $('#art_clin1').on('submit', function(e) {
                const completed = $('#completedCheck').is(':checked');

                if ({{$totalPatients }} > 0 && completed) {
                    const confirmed = confirm(
                        "Kindly check and confirm details before final submission.There will be no option for Editing/Updating details after final submission of this quarter."
                    );
                    if (!confirmed) {
                        e.preventDefault(); // only stop if user cancels
                    }
                }
            });
        });
        </script>
@endsection