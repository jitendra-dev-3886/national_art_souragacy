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



        .csp-admin-inline-block{
            display: inline-block;
        }
        .csp-admin-applicant-number{
            display: flex; justify-content: space-between; align-items: center;
        }
        .csp-admin-message-heading{
            margin: 0;color: white;
        }
        .csp-admin-table-cloumn{
            text-transform: lowercase;
        }
        .csp-admin-file-margin{
            margin-right: 5px;
        }
    </style>

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
                            <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."
                                class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button">Search</button>
                        </form>
                        
                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>
                        
                        <!-- Search result container -->
                        <div id="result" class="csp-admin-div-none">
                            <table class="table table-bordered table-striped table-hover nowrap w-100" id="example8">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Application Status</th>
                                        <th>Clinic Name</th>
                                        <th>Nature</th>
                                        <th>Email ID</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date of online<br> form submission<br>(By the user Clinic)</th>
                                        <th>Date of payment fee</th>
                                        <th>Date on which<br> application recived<br> by authority</th>
                                        <th>Certificate Issued</th>     
                                        <th>View</th>                                    
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
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
        
            $('#searchForm').submit(function(e) {
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
                            if ($.fn.DataTable.isDataTable('#example8')) {
                                $('#example8').DataTable().clear().destroy();
                            }
                            $.each(response.patient_list, function(index, form) {
                                let applicationNo = form.surrogacyclinics?.sapp_no?.applicationno ? form.surrogacyclinics.sapp_no.applicationno : 'N/A';
                                var encrypted_id2 = form.surrogacyclinics?.sapp_no?.surrogacyclinic_id?.id ? form.surrogacyclinics.sapp_no?.surrogacyclinic_id?.id : 0;
                                var encrypted_id3 = form.surrogacyclinics?.id 
                                                    ? form.surrogacyclinics.status 
                                                    : 0;
                             
                                let formattedDate = form.created_at 
                                ? new Date(form.created_at).toLocaleDateString('en-GB') // Converts to DD/MM/YYYY
                                : 'N/A';
                             
                                let actionColumn = encrypted_id2 != 0
                                ? '<span>-</span>'
                                : `<a href="{{ route("admin.reg_receivedsurrogacyssaForm_list", ['id' => '__ID__']) }}" 
                                    class="link">
                                    Action
                                </a>`.replace('__ID__', form.encrypted_id1);
                                let viewcolumn = encrypted_id3 == 0
                                ? '<span>-</span>'
                                : `<a href="{{ route("clinic.sclinicForm_view", ['id' => '__ID__']) }}" 
                                    class="class="btn btn csp-clinic-btn">
                                    <i class="fas fa-eye"></i>
                                </a>`.replace('__ID__', form.encrypted_id3);
                                let cert_issue = encrypted_id2 != 0
                                ? 'Yes'
                                : 'No';
                                let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${form.surrogacyclinics?.sapp_no?.applicationno || 'N/A'}</td>
                                    <td>${form.surrogacyclinics.appstatus ?? 'N/A'}</td>
                                    <td>${form.clinicname ?? 'N/A'}</td>
                                    <td>${form.nature ?? 'N/A'}</td>
                                    <td>${form.email ?? 'N/A'}</td>
                                    <td>${form.contactno ?? 'N/A'}</td>
                                    <td>${form.address ?? 'N/A'}</td>
                                    <td>${form.state ?? 'N/A'}</td>
                                    <td>${form.district ?? 'N/A'}</td>
                                    <td>${form.surrogacyclinics.applicationno_datetime_submission ?? 'N/A'}</td>
                                    <td>${form.surrogacyclinics.app_date_payment ?? 'N/A'}</td>
                                    <td>${form.surrogacyclinics.app_date_recieve ?? 'N/A'}</td>
                                    <td>${cert_issue}</td>
                                    <td>${viewcolumn}</td>
                                    <td>${actionColumn}</td>
                                    
                                </tr>`.replace('__ID__', form.encrypted_id1); // Encrypt in controller
                                $('#patientList').append(row);
                            });
                            $('#example8').DataTable({
                                paging: true,
                                searching: true,
                                ordering: true,
                                info: true,
                                responsive: true,
                                scrollX: true,
                                dom:
                                    '<"row"<"col-md-2"l><"col-md-7"B><"col-md-3"f>>' + 
                                    'rt' +                               
                                    '<"row"<"col-md-6"p>>',  
                                buttons: [
                                    {
                                        extend: 'excel',
                                        text: 'Export Excel'
                                    }
                                ],
                                columnDefs: [
                                    { targets: 0, width: '5%' },   // S.No
                                    { targets: 1, width: '10%' },  // Application No
                                    { targets: 2, width: '12%' },  // Clinic Name
                                    { targets: 3, width: '8%' },   // Nature
                                    { targets: 4, width: '10%' },  // Email
                                    { targets: 5, width: '8%' },   // Mobile
                                    { targets: 6, width: '15%' },  // Address
                                    { targets: 7, width: '8%' },   // Statei
                                    { targets: 8, width: '8%' },   // Distrct
                                    { targets: 9, width: '10%' },  // Online Submission
                                    { targets: 10, width: '10%' }, // Payment Date
                                    { targets: 11, width: '10%' }, // Received Date
                                    { targets: 12, width: '10%' }, // Certificate
                                    { targets: 13, width: '6%' }   // Action
                                ],
                                createdRow: function(row, data, dataIndex) {
                                    $('td', row).addClass('align-middle text-wrap');
                                }
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
