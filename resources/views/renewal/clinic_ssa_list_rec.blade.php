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
                        <h4 class="card-title">Applications for the ART Clinics  test (Renewal)</h4>
                    </div>
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('renewal.ssa_search_application', ['clinicType' => $clinicTypeValue]) }}" class="csp-admin-form">
                            <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."  class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button" >Search</button>
                        </form>
                        
                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>
                        
                        <!-- Search result container -->
                        <div id="result" class="csp-admin-div-none">
                            <table class="table display" id="" >
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
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
  <script nonce="{{ $cspNonce }}">
    let clinicType = @json($clinicTypeValue);
    clinicType = clinicType.toLowerCase();

    // Build AJAX URL dynamically
    let ajaxUrlTemplate = "{{ route('renewal.ssa_search_application', ['clinicType' => '__CLINIC__']) }}";
    let ajaxUrl = ajaxUrlTemplate.replace('__CLINIC__', clinicType);

    let viewUrlTemplate = "{{ route('renewal.ssa_application_rec', ['clinicType' => '__CLINIC__', 'id' => '__ID__']) }}";

    $(document).on('submit', '#searchForm', function(e) {
        e.preventDefault();

        let query = $('#searchApplicationNo').val().trim();
        if (!query) {
            $('#errorMessage').text('Please enter an application number.');
            return;
        }

        // console.log('Sending AJAX to:', ajaxUrl, 'with query:', query);

        $.ajax({
            url: ajaxUrl,
            type: "GET",
            data: { application_no: query },
            success: function(response) {
                // console.log('AJAX Response:', response);
                let rows = '';
                if (response && response.length > 0) {
                    $.each(response, function(index, item) {
                        let viewUrl = viewUrlTemplate
                                        .replace('__CLINIC__', clinicType)
                                        .replace('__ID__', item.encrypted_id);

                        let actionColumn = item.app_received === 'received'
                            ? 'Fee Received'
                            : `<a href="${viewUrl}" class="btn btn-sm btn-primary">Action</a>`;

                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.applicationno ?? ''}</td>
                                <td>${item.clinicname ?? ''}</td>
                                <td>${item.email ?? ''}</td>
                                <td>${item.address ?? ''}</td>
                                <td>${item.state ?? ''}</td>
                                <td>${item.district ?? ''}</td>
                                <td>${actionColumn}</td>
                            </tr>`;
                    });

                    $('#patientList').html(rows);
                    $('#result').show();
                    $('#errorMessage').text('');
                } else {
                    $('#patientList').html('');
                    $('#result').hide();
                    $('#errorMessage').text('No records found.');
                }
            },
            error: function(xhr, status, error) {
                // console.error('AJAX error:', xhr.responseText);
                $('#errorMessage').text('Something went wrong. Please try again.');
            }
        });
    });
</script>




{{-- 
<script nonce="{{ $cspNonce }}">
$(document).on('submit', '#searchForm', function(e) {
    e.preventDefault();

    let query = $('#searchApplicationNo').val();

    $.ajax({
        url: "{{ route('renewal.clinicsearchapplication') }}",
        type: "GET",
        data: { application_no: query },
        success: function(response) {
            let rows = '';
            if (response.length > 0) {
               let baseUrl = "{{ route('renewal.bankapplication_rec', ['id' => '__ID__']) }}";
                $.each(response, function(index, item) {
         let viewUrl = baseUrl.replace('__ID__', item.encrypted_id);
        let actionColumn = '';

        if (item.app_received === 'received') {
            actionColumn = 'Fee Received';
        } else {
            actionColumn = `<a href="${viewUrl}" class="btn btn-sm btn-primary">action</a>`;
        }

            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.applicationno ?? ''}</td>
                    <td>${item.clinicname ?? ''}</td>
                    <td>${item.email ?? ''}</td>
                    <td>${item.address ?? ''}</td>
                    <td>${item.state ?? ''}</td>
                    <td>${item.district ?? ''}</td>
                    <td>${actionColumn}</td>
                </tr>`;
                });
                $('#patientList').html(rows);
                $('#result').removeClass('csp-admin-div-none');
                $('#errorMessage').text('');
            } else {
                $('#patientList').html('');
                $('#result').addClass('csp-admin-div-none');
                $('#errorMessage').text('No records found.');
            }
        },
        error: function() {
            $('#errorMessage').text('Something went wrong. Please try again.');
        }
    });
});

</script> --}}

       

@endsection
