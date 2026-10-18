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

    .csp-clinic-select-half {
        width: 48%;
    }

    .csp-clinic-btn-primary {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
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
            @if(isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endif
            @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <h3 class="card-title mb-5 text-primary">Patient detail reporting</h3>
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
        <form id="art_clin1" action="{{ url('clinic/patient-reporting-surrogacy-application-form-submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @php
                    $currentYear = date('Y');
                    $currentQuarter = ceil(date('n') / 3);
                @endphp
        
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <strong>Report Filing for Patient details</strong>
                        </label>
                        <div class="d-flex gap-3">
                            <select class="form-select csp-clinic-select-half" disabled>
                                <option>{{ $defaultYear }}</option>
                            </select>

                            <select class="form-select csp-clinic-select-half" disabled>
                                <option>
                                    {{ $quarter->where('quarter', $defaultQuarter)->first()->description ?? $defaultQuarter }}
                                </option>
                            </select>

                            {{-- Hidden fields to submit actual values --}}
                            <input type="hidden" name="year" value="{{ $defaultYear }}">
                            <input type="hidden" name="quarter" value="{{ $defaultQuarter }}">
                           
                           
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="mt-4">
              
                <button type="submit" class="btn me-2 csp-clinic-btn-primary">Set Reporting Period</button>
            </div>
        </form>
        
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
                                        <option value="{{ $quarters->id }}" data-quarter="{{ $qnum }}">{{ $quarters->description }}</option>
                                    @endforeach
                                </select>
                                <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                    <option value="">Select Year</option>
                                    @for ($y = $currentYear; $y >= 2022; $y--)
                                        <option value="{{ $y }}" @if ((old('year') ?? ($previous_data->year ?? $currentYear)) == $y) selected @endif>{{ $y }}</option>
                                    @endfor
                                </select>
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




{{-- <script nonce="{{ $cspNonce }}">
    $('#art_clin1').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ route('clinic.reporting_period_patient_save_bank_application_form') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#reporting-table-wrapper').html(response.reportData); // Render table HTML
               // alert(response.message);
            },
            error: function(xhr) {
                alert('Something went wrong');
            }
        });
    });
</script> --}}

{{-- <script nonce="{{ $cspNonce }}">
    $('#art_clin1').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ route('clinic.reporting_period_patient_save_bank_application_form') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = response.reportData;
                let html = '';

                if (data.length > 0) {
                    html += '<table class="table table-bordered">';
                    html += '<thead><tr><th>#</th><th>Quarter</th><th>Year</th><th>Status</th></tr></thead><tbody>';

                    data.forEach(function(item, index) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>Q' + item.quarter + '</td>';
                        html += '<td>' + item.year + '</td>';
                        html += '<td>' + item.status + '</td>';
                        html += '</tr>';
                    });

                    html += '</tbody></table>';
                } else {
                    html = '<div class="alert alert-info">No reporting data found for selected period.</div>';
                }

                $('#reporting-table-wrapper').html(html);
                alert(response.message);
            },
            error: function(xhr) {
                alert('Something went wrong. Please try again.');
            }
        });
    });
</script> --}}

{{-- <script nonce="{{ $cspNonce }}">
    $('#art_clin1').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ route('clinic.reporting_period_patient_save_bank_application_form') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = response.reportData;
                let html = '';

                if (data.length > 0) {
                    //  html += '<table id="reportTable" class="table table-bordered dataTable">';
                    //  html += '<thead><tr><th>#</th><th>Quarter</th><th>Year</th><th>Status</th><th>Action</th></tr></thead><tbody>';

                    data.forEach(function(item, index) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>Q' + item.quarter + '</td>';
                        html += '<td>' + item.year + '</td>';
                        html += '<td>' + item.status + '</td>';
                        html += '<td>' + item.status + '</td>';
                        html += '<td>';
                        html += '<button class="btn btn-sm btn-primary me-2 complete-btn" data-id="' + item.id + '">This reporting period has been completed</button>';
                        html += '<a href="/clinic/continue-form/' + item.id + '" class="btn btn-sm btn-success">Continue patient details</a>';
                        html += '</td>';
                        html += '</tr>';
                    });

                     //html += '</tbody></table>';
                } 
                // else {
                //     html = '<div class="alert alert-info">No reporting data found for selected period.</div>';
                // }

                $('#reporting-table-wrapper').html(html);

                // Reinitialize DataTables
                $('#reportTable').DataTable();

                alert(response.message);
            },
            error: function(xhr) {
                alert('Something went wrong. Please try again.');
            }
        });
    });
</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
$('#art_clin1').on('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: "{{ route('clinic.reporting_period_patient_save_bank_application_form') }}",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.exists) {
                alert('This quarter and year have already been added!');
                return;
            }

            let data = response.reportData;
            let html = '';

            if (data.length > 0) {
                data.forEach(function(item, index) {
                    let rowCount = $('#reportTable tbody tr').length;
                    let quarterLabel = {
                        1: 'Q1 (April–June)',
                        2: 'Q2 (July–Sept)',
                        3: 'Q3 (Oct–Dec)',
                        4: 'Q4 (Jan–March)'
                    };
                    html += '<tr>';
                    html += '<td>' + (rowCount + 1) + '</td>';
                    html += '<td>' + (quarterLabel[item.quarter] || 'Unknown') + '</td>';
                    // html += '<td>Q' + item.quarter + '</td>';
                    html += '<td>' + item.year + '</td>';
                    // html += '<td>' + item.status + '</td>';
                    html += '<td>';
                    html += '<button class="btn btn-sm btn-primary me-2 complete-btn" data-id="' + item.id + '">This reporting period has been completed</button>';
                    
                    html += '</td>';
                    html += '<td>';
                    html += '<a href="/clinic/continue-form/' + item.id + '" class="btn btn-sm btn-success">Continue patient details</a>';
                    html += '</td>';
                    html += '</tr>';
                });

                $('#reportTable tbody').append(html); // Only append to tbody
            }

            if (!$.fn.DataTable.isDataTable('#reportTable')) {
                $('#reportTable').DataTable(); // initialize only once
            }

            alert(response.message);
        },
        error: function(xhr) {
            alert('Something went wrong. Please try again.');
        }
    });
});

</script> --}}
{{-- <script nonce="{{ $cspNonce }}">
    $('#art_clin1').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ route('clinic.reporting_period_patient_save_bank_application_form') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.redirect) {
                        alert(response.message); // show the message
                        window.location.href = response.redirect; // redirect
                        return;
                    }

                    alert(response.message); // show success message
                },
                error: function(xhr) {
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    </script> --}}
@endsection