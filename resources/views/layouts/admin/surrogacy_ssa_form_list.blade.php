@extends('layouts.admin.ssa_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-form{
            display: flex; align-items: center;
        }
        .csp-admin-form-input{
            width: 300px; margin-bottom: 10px; margin-right: 10px; display: inline-block;
        }
        .csp-admin-form-button{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white; display: inline-block;
        }
        .csp-admin-red-color{
            color:red;
        }
        .csp-admin-div-none{
            display: none;
        }

    </style>
<script src="{{ asset('datatable/jquery3.0.js') }}" nonce="{{ $cspNonce }}"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('datatable/datatable.css') }}" nonce="{{ $cspNonce }}">

<!--  DataTables JS -->
<script src="{{ asset('datatable/datatablemin.js') }}" nonce="{{ $cspNonce }}"></script>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('upd_success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong> {{ session('upd_success') }}</strong>
                    </div>
                </div>
            @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Applications for the Surrogacy Clinic</h4>
                    </div>
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('admin.regsurrogacysearchApplication') }}" class="csp-admin-form">
                            <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."  class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button" >Search</button>
                        </form>
                        
                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>
                        
                        <!-- Search result container -->
                        <div id="result" class="csp-admin-div-none">
                            <table class="table display" id="example3" >
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Clinic Name</th>
                                        <th>Email ID</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>                                      
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody id="patientList">
                                    <!-- Results will be injected here -->
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                @if(session('error'))
                                <p style="color:red;">{{ session('error') }}</p>
                            @endif --}}
                              

                                   
                            {{-- <form method="GET" action="{{ route('admin.surrogacysearchApplication') }}" style="display: flex; align-items: center;">
                                <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."
                                    class="form-control" style="width: 300px; margin-bottom: 10px; margin-right: 10px; display: inline-block;" value="{{ request('application_no') }}">
                                <button type="submit" class="btn btn-primary" style="display: inline-block;">Search</button>
                            </form> --}}
                                {{-- <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Clinic Name</th>
                                        <th>Email ID</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                      
                                        <th>Action</th> 

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($ssasurogacyformList as $formList)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $formList->surrogacyclinics->sapp_no->applicationno }}</td>
                                            <td>{{ $formList->clinicname }}</td>
                                            <td>{{ $formList->email }}</td>
                                            <td>{{ $formList->address }}</td>
                                            <td>{{ $formList->state }}</td>
                                            <td>{{ $formList->district }}</td>
                                            <td>
                                                @if ($formList->surrogacyclinics->app_received == 'received')
                                                    <span>-</span>
                                                @else
                                                    <a href="{{ route('admin.receivedsurrogacy_ssaForm_list', ['id' => Crypt::encrypt($formList->surrogacyclinics->id)]) }}" class="link">
                                                        Action
                                                    </a>
                                                @endif
                                            </td>                                           
                                           

                                        </tr>
                                    @endforeach
                                </tbody> --}}
                            {{-- </table>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
        
        //   console.log('check 1');
            $('#searchForm').submit(function(e) {
          //     console.log('check 1');
                e.preventDefault(); // Prevent form from refreshing page
        
                let uhid = $('#searchApplicationNo').val();
        
        
                $.ajax({
                    url: "{{ route('admin.regsurrogacysearchApplication') }}",
                    type: "GET",
                    data: { application_no: uhid },
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
                                let applicationNo = form.surrogacyclinics?.sapp_no?.applicationno ? form.surrogacyclinics.sapp_no.applicationno : 'N/A';

                                console.log(applicationNo);
                                let formattedDate = form.created_at 
                                ? new Date(form.created_at).toLocaleDateString('en-GB') // Converts to DD/MM/YYYY
                                : 'N/A';
                                let actionColumn = form.surrogacyclinics?.app_received === 'received'
                                ? '<span>-</span>'
                                : `<a href="{{ route("admin.receivedsurrogacyssaForm_list", ['id' => '__ID__']) }}" 
                                    class="link">
                                    Action
                                </a>`.replace('__ID__', form.encrypted_id1);
                                let row = `<tr>
                                    <td>${index + 1}</td>
                                     <td>${form.surrogacyclinics?.sapp_no?.applicationno || 'N/A'}</td>
                                   
                                    <td>${form.clinicname ?? 'N/A'}</td>
                                    <td>${form.email ?? 'N/A'}</td>
                                    <td>${form.address ?? 'N/A'}</td>
                                    <td>${form.state ?? 'N/A'}</td>
                                    <td>${form.district ?? 'N/A'}</td>
                                    <td>${actionColumn}</td>
                                    
                                </tr>`.replace('__ID__', form.encrypted_id1); // Encrypt in controller
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
{{-- <script nonce="{{ $cspNonce }}">
document.addEventListener("DOMContentLoaded", function () {
    alert('hii');
    $('#clinicTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        pageLength: 10
    });
});
</script> --}}

       

@endsection
