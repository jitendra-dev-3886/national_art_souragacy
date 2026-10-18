@extends('layouts.clinic.clinic_master')
@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-alert-primary {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-btn-primary {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-btn-secondary {
        background-color: #0b49f9;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-clinic-search-form {
        display: flex;
        align-items: center;
    }

    .csp-clinic-search-input {
        width: 300px;
        margin-bottom: 10px;
        margin-right: 10px;
        display: inline-block;
    }

    .csp-clinic-btn-inline {
        display: inline-block;
    }

    .csp-clinic-error-text {
        color: red;
    }

    .csp-clinic-result-hidden {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif --}}
        @if (session('success'))
        <div class="col-lg-6 offset-lg-3">
         
            <div class="alert alert-success alert-dismissible alert-alt fade show csp-clinic-alert-primary">

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                </button>
                {{-- <strong>Success!</strong> Application has been created successfully. --}}
                {{-- <p class="text-success">Application No: {{ session('success') }}</p> <!-- Display application number --> --}}
                <p class="">{{ session('success') }}</p>
            </div>
        </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">List of Donors (ART Bank)</h4>
                    {{-- @if (!$exists) --}}
                 
                     <a href="{{ route('clinic.add_reporting_period_patient_bank_application_form') }}" class="btn btn csp-clinic-btn-primary">Donor Information Form</a>
 

                    {{-- @else
                    <a href="{{ route('clinic.add_reporting_already_live_period_patient_bank_application_form') }}" class="btn btn" style="background-color: #0b5ed7; border-color: #0b5ed7; color: white;">Donor Information Form</a>
                    {{-- <span class="badge bg-warning text-dark">Live record already exists for this quarter and year</span>
                    @endif --}}
                
                
                
                </div>
                <div class="card-body">
                   

                    <form id="searchForm" method="GET" action="{{ route('admin.list_artbank_patientsearchApplication') }}" class="csp-clinic-search-form">

                        <input type="text" id="searchdonor_id" name="donor_id" placeholder="Enter Donor ID."
                            class="form-control csp-clinic-search-input">

                          <input type="text" name="search" class="form-control csp-clinic-search-input">

                     
                        <button type="submit" class="btn btn csp-clinic-btn-primary csp-clinic-btn-inline">Search</button>
                        

                    </form>
                    
                    <!-- Error message container -->
                 
                      <p id="errorMessage" class="csp-clinic-error-text"></p>
                    
                    <!-- Search result container -->
                 
                    <div id="result" class="csp-clinic-result-hidden">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Patient UHID</th>
                                    <th>Clinic Registration Number</th>
                                    <th>Date of Form Submission</th>                                   
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody id="patientList">
                                <!-- Results will be injected here -->
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                     <th>Donor UHID</th>
                                    <th>Bank Registration number</th>
                                    <th>Date of Form Submission</th>
                                  
                                    <th>view</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1
                                @endphp
                                @foreach ($patient_list as $patient_lists)
                             
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $patient_lists->donor_id }}</td>
                                        <td>{{ $patient_lists->bank_reg_num }}</td>                                        
                                        <td>{{ $patient_lists->created_at }}</td>                                     
                                        <td><a href="{{ route("clinic.patientbankForm_view", ['id' => encrypt($patient_lists->id)]) }}" class="btn btn" style="background-color: #0b49f9; border-color: #0b5ed7; color: white;" >
                                            <i class="fas fa-eye"></i> 
                                        </a> </td>                                      
                                    </tr>                                  
                                @endforeach
                            </tbody>
                        </table>
                    </div>                     --}}
                </div>
            </div>
        </div>




    </div>
   
</div>
{{-- <script nonce="{{ $cspNonce }}" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
$(document).ready(function() {

  //  console.log('check 1');
    $('#searchForm').submit(function(e) {
     //   console.log('check 1');
        e.preventDefault(); // Prevent form from refreshing page

        let uhid = $('#searchdonor_id').val();
        $.ajax({
            url: "{{ route('admin.list_artbank_patientsearchApplication') }}",
            type: "GET",
            data: { donor_id: uhid },
            beforeSend: function() {
                $('#errorMessage').text('');
                $('#patientList').html('<tr><td colspan="5">Searching...</td></tr>');
            },
            success: function(response) {
                
                $('#patientList').empty(); // Clear previous results
                
                if (response.errorMessage) {
                    $('#errorMessage').text(response.errorMessage);
                    $('#result').hide(); // Keep it hidden if there's an error
                } else {
                    $('#result').show(); // Show only if data exists
                    $.each(response.patient_list, function(index, form) {
                        let formattedDate = form.created_at 
                        ? new Date(form.created_at).toLocaleDateString('en-GB') // Converts to DD/MM/YYYY
                        : 'N/A';
                        let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${form.donor_id ?? 'N/A'}</td>
                            <td>${form.bank_reg_num ?? 'N/A'}</td>
                             <td>${formattedDate}</td>
                            <td>  <a href="{{ route('clinic.patientbankForm_view', ['id' => '__ID__']) }}" class="btn btn csp-clinic-btn-secondary">">
                             

                                <i class="fas fa-eye"></i></a></td>
                        </tr>`.replace('__ID__', form.encrypted_id); // Encrypt in controller
                        $('#patientList').append(row);
                    });
                }
            },
            error: function() {
                $('#errorMessage').text('Something went wrong. Please try again.');
                $('#result').hide(); // Hide table on error
            }
        });
    });
});
</script>
@endsection