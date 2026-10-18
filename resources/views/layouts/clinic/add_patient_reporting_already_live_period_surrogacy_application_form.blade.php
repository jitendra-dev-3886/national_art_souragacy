@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
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
    .progress-bar {
    background-color: #0d6efd;;
}
.csp-clinic-btn-continue {
    background-color: #0b5ed7;
    border-color: #0b5ed7;
    color: white;
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
              {{-- <form name="art_clin1" method="POST" action="{{ route('clinic.reporting_period_patient_save_bank_application_form') }}" enctype="multipart/form-data">                             
                @csrf			

            <div class="row">                               
                            @php
                            $currentYear = date('Y');
                            $currentQuarter = ceil(date('n') / 3);
                            @endphp

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <strong>Select Period for filling Patient details</strong>
                        </label>
                        <div class="d-flex gap-3">
                            <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                <option value="">Select quarter</option>
                                @foreach ($quarter as $quarters)
                                    @php
                                        preg_match('/Q(\d)/', $quarters->description, $matches);
                                        $qnum = $matches[1] ?? 1;
                                    @endphp
                                    
                                    <option value="{{ $quarters->id }}" data-quarter="{{ $qnum }}" >
                                       
                                        {{ $quarters->description }}
                                    </option>
                                @endforeach                                
                            </select>                           
                            <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                <option value="">Select Year</option>
                                @for ($y = $currentYear; $y >= 2022; $y--)
                                    <option value="{{ $y }}"
                                        @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y) selected @endif>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>                           
                         </div>
                        </div>
                    </div>


                </div>
				
                <div class="mt-4">
                <button type="submit" name="submit" id="btnSubmit" onclick="return validatesubmit()"
                    class="btn me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">Submit</button>
                </div>
            </form> --}}
            {{-- @if ($messagea)
            <script nonce="{{ $cspNonce }}">
                alert("{{ $messagea }}");
            </script>
        @endif --}}

            {{-- <form id="art_clin1" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    @php
                        $currentYear = date('Y');
                        $currentQuarter = ceil(date('n') / 3);
                    @endphp 
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block">
                                <strong>Quarter and Year</strong>
                            </label>
                            <div class="d-flex gap-3">
                               
                                @if ($available_quarters->count() === 1)
                                <input type="text" class="form-control" name="quarter"
                                       value="{{ $available_quarters->first()['description'] }}" readonly>
                                <input type="hidden" name="quarter" value="{{ $available_quarters->first()['id'] }}">
                                @else
                                <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                    <option value="">Select Quarter</option>
                                    @foreach ($available_quarters as $q)
                                        <option value="{{ $q['id'] }}"
                                            @if ((old('quarter') ?? ($previous_data->quarter ?? '')) == $q['id']) selected @endif>
                                            {{ $q['description'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @endif
                            
                               
                                @if ($available_years->count() === 1)
                                    <input type="text" class="form-control" name="year"
                                           value="{{ $available_years->first()->year }}"
                                           readonly>
                                    <input type="hidden" name="year" value="{{ $available_years->first()->year }}">
                                @else
                                    <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                        <option value="">Select Year</option>
                                        @foreach ($available_years as $y)
                                            <option value="{{ $y->year }}"
                                                @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y->year) selected @endif>
                                                {{ $y->year }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>                        
                        </div>
                    </div>
                </div>
            
                <div class="mt-4">
                    <button type="submit" class="btn me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">Submit</button>
                </div>
            </form> --}}
            
            {{-- <div class="mt-4" id="reporting-table-wrapper">
                <!-- Data will be loaded here -->
            </div> --}}
            
            {{-- <div class="mt-5" id="reporting-table-wrapper">
                @if ($reportData->isNotEmpty())
                    <table class="table table-bordered" id="reportTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Quarter</th>
                                <th>Year</th>
                               
                                <th>Action (Completed)</th>
                                <th>Action (Continue)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reportData as $index => $report)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @php
                                            $quarterLabels = [
                                                1 => 'Q1 (April–June)',
                                                2 => 'Q2 (July–Sept)',
                                                3 => 'Q3 (Oct–Dec)',
                                                4 => 'Q4 (Jan–March)',
                                            ];
                                        @endphp
                                        {{ $quarterLabels[$report->quarter] ?? 'Unknown' }}
                                    </td>
                                  
                                    <td>{{ $report->year }}</td>
                                 
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2 complete-btn" data-id="{{ $report->id }}">
                                            This reporting period has been completed
                                        </button>
                                        
                                    </td>
                                    <td>
                                    <a href="/clinic/continue-form/{{ $report->id }}" class="btn btn-sm btn-success">
                                        Continue patient details
                                    </a>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-info">No live records available.</div>
                @endif
            </div> --}}

            <form id="art_clin1" enctype="multipart/form-data">
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
                                    use App\Models\patient\PatientSurrogacyClinic;

                                    $totalPatients = PatientSurrogacyClinic::where('clinic_id', $reporting_data->clinic_id)
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
                                    <input class="form-check-input" type="checkbox" id="completedCheck">
                                    <label class="form-check-label" for="completedCheck">
                                        All patient details for above reporting period completed
                                    </label>
                                    @if ($totalPatients == 0)
                                        <br>
                                        <input class="form-check-input" type="checkbox" id="nillcheck" name="is_nilldata" value="1">
                                        <label class="form-check-label" for="nillcheck"> No cases to report for this
                                            period.
                                        </label>
                                    @endif
                                </div>
                                
                                    
                                <button type="submit" id="completedBtn" class="btn btn-primary display-none">Final Submit</button>

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
        let doc_uploaded = "{{ $doc_uploaded ?? ''}}";
        let fileExists = "{{ $fileExists ?? ''}}";
        $(document).ready(function () {
            $('#completedCheck').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#continueBtn').prop('disabled', true);
                    $('#completedBtn').prop('disabled', false);
                    $('#continueBtn').hide();
                    $('#completedBtn').show();
                    $('#finalSubmitWarning').show();
                } else {
                    $('#continueBtn').prop('disabled', false);
                    $('#completedBtn').prop('disabled', true);
                    $('#continueBtn').show();
                    $('#completedBtn').hide();
                    $('#finalSubmitWarning').hide();
                }
            });
        $('#completedBtn').on('click', function(e) {
        const nill_submit = $('#nillcheck').is(':checked');
            if({{$totalPatients }}===0)
            {
                if(!nill_submit)
                {
                    alert("Please click on the undertaking that No cases to report for this period.");
                    return false;
                }
                elseif(!doc_uploaded || !fileExists)
                {
                    alert("Document not uploaded while patient data submission, kindly first upload the documents via view/update option.");
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
        e.preventDefault();

        const completed = $('#completedCheck').is(':checked');
        if(!doc_uploaded || !fileExists)
        {
            alert("Document not uploaded while patient data submission, kindly first upload the documents via view/update option.");
            return false;
        }
        if ({{$totalPatients }} > 0 && completed) {
            const confirmed = confirm(
                "Kindly check and confirm details before final submission.There will be no option for Editing/Updating details after final submission of this quarter."
            );
            if (!confirmed) {
                return false;
            }
        }
        let formData = new FormData(this);

        formData.set('status', completed ? 'Finished' : 'Live');

        $.ajax({
            type: 'POST',
            url: "{{ route('clinic.reporting_already_live_period_patient_save_surrogacy_application_form') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // alert(response.message);

                if (completed) {
                    window.location.href = "{{ route('clinic.clinicForm_list') }}";
                } else {
                    window.location.href = "{{ route('clinic.add_patient_surrogacy_application_form') }}";
                }
            },
            error: function(xhr) {
                alert('Something went wrong. Please try again.');
            }
        });
    });
});
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
        //             url: "{{ route('clinic.reporting_already_live_period_patient_save_surrogacy_application_form') }}",
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
        //                     window.location.href = "{{ route('clinic.add_patient_surrogacy_application_form') }}";
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
        </script>
@endsection