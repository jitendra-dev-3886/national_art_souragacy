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

                @if(session('exists'))
                <div class="alert alert-warning">
                    {{ $messagea ?? 'This quarter and year have already been added!' }}
                </div>
            @endif
            <h3 class="card-title mb-5 text-primary">Reporting period</h3>
              <!-- {{-- <form name="art_clin1" method="POST" action="{{ route('clinic.reporting_period_patient_save_bank_application_form') }}" enctype="multipart/form-data">                             
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
            </form> --}} -->
            <!-- {{-- @if ($messagea)
            <script nonce="{{ $cspNonce }}">
                alert("{{ $messagea }}");
            </script>
        @endif --}} -->

            <!-- {{-- <form id="art_clin1" enctype="multipart/form-data">
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
            </form> --}} -->
            
            {{-- <div class="mt-4" id="reporting-table-wrapper">
                <!-- Data will be loaded here -->
            </div> --}}
            
            <!-- {{-- <div class="mt-5" id="reporting-table-wrapper">
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
            </div> --}} -->


            <form id="art_clin1" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="quarter_id" value="{{ $reporting_data->id }}">

                <div class="row">
                    @php
                        $currentYear = date('Y');
                        $currentQuarter = ceil(date('n') / 3);
                    @endphp 
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label d-block"><strong>Year and Quarter</strong></label>
                            <div class="d-flex gap-3">
                                @if ($available_years->count() === 1)
                                    <input type="text" name="year" class="form-control csp-readonlycolor" value="{{ $available_years->first()->year }}" readonly>
                                    {{-- <input type="hidden" name="year" value="{{ $available_years->first()->year }}"> --}}
                                {{-- @else
                                    <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                        <option value="">Select Year</option>
                                        @foreach ($available_years as $y)
                                            <option value="{{ $y->year }}" @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y->year) selected @endif>
                                                {{ $y->year }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                @endif
                                @if ($available_quarters->count() === 1)
                                    <input type="text" class="form-control csp-readonlycolor" value="{{ $available_quarters->first()['description'] }}" readonly>
                                     <input type="hidden" name="quarter" value="{{ $available_quarters->first()['id'] }}"> 
                                   
                                {{-- @else
                                    <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                        <option value="">Select Quarter</option>
                                        @foreach ($available_quarters as $q)
                                            <option value="{{ $q['id'] }}" @if ((old('quarter') ?? ($previous_data->quarter ?? '')) == $q['id']) selected @endif>
                                                {{ $q['description'] }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                @endif            
                           
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" id="continueBtn" class="btn csp-clinic-btn-primary">
                        Continue patient details
                    </button>
                </div>

                <!-- Completed Checkbox -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="completedCheck">
                    <label class="form-check-label" for="completedCheck">
                        All patient details for above reporting period completed
                    </label>
                </div>

                <!-- Submit Completed Button -->
                <div>
                    <button type="submit" id="completedBtn" class="btn csp-clinic-btn-primary" disabled>
                        Final Submit
                    </button>
                </div>
                <!-- {{-- <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status" value="Live" id="continueCheck">
                    <label class="form-check-label" for="continueCheck">Continue patient details</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="status" value="Finished" id="completedCheck">
                    <label class="form-check-label" for="completedCheck">All patient details reporting completed</label>
                </div>
            
                
            
                <div class="mt-4">
                    <button type="submit" id="submitBtn" class="btn me-2" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">Submit</button>
                </div> --}} -->
            </form>
            




        </div>


       




    </div>




    
</div>
    </div>
</div>
</div>


<script nonce="{{ $cspNonce }}">

    document.getElementById("continueBtn").addEventListener("click", function (e) {

        let declaration = document.getElementById("clinic_confirm_declaration");

        if (!declaration.checked) {
            e.preventDefault();
            alert("Please confirm that you are submitting this form on behalf of the clinic.");
            declaration.focus();
            return false;
        }

    });
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
                } else {
                    $('#continueBtn').prop('disabled', false);
                    $('#completedBtn').prop('disabled', true);
                }
            });
$('#art_clin1').on('submit', function(e) {
    e.preventDefault();

    const completed = $('#completedCheck').is(':checked');
    let formData = new FormData(this);

    formData.set('status', completed ? 'Finished' : 'Live');

    $.ajax({
        type: 'POST',
        url: "{{ route('clinic.reporting_already_live_period_patient_save_clinic_application_form') }}",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // alert(response.message);

            if (completed) {
                window.location.href = "{{ route('clinic.clinicForm_list') }}";
            } else {
                window.location.href = "{{ route('clinic.add_patient_clinic_application_form') }}";
            }
        },
        error: function(xhr) {
            let errorMsg = 'Something went wrong. Please try again.';
            if(xhr.responseJSON && xhr.responseJSON.errors){
                // Show Laravel validation errors if any
                errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
            } else if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            alert(errorMsg);
            console.error(xhr);
        }
    });
});

});
        </script>
@endsection