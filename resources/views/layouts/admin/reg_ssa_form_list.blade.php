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
        .csp-admin-inline-block{
            display: inline-block;
        }
        .csp-admin-red-color{
            color:red;
        }
        .csp-admin-form-button{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white; display: inline-block;
        }
        .csp-admin-div-none{
            display: none;
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
                        <h4 class="card-title">Applications for the ART Clinic</h4>
                    </div>
                    <div class="card-body">
                        <form id="searchForm" method="GET" action="{{ route('admin.regsearchApplication') }}" class="csp-admin-form" autocomplete="off">
                            <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No."
                                class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button">Search</button>
                        </form>
                        
                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>
                        
                        <!-- Search result container -->
                        <div id="result">
                            <table class="table table-bordered table-striped table-hover nowrap w-100" id="example8">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Application No.</th>
                                        <th>Application status</th>
                                        <th>Clinic Name</th>
                                        <th>Nature</th>
                                        <th>Clinic Level</th>
                                        <th>Email ID</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Date of online<br> form submission<br>(By the user Clinic)</th>
                                        <th>Date of payment fee</th>
                                        <th>Date on which<br> application recived<br> by authority</th>
                                        <th>Certificate Issue</th>
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
        
        //   console.log('check 1');
            $('#searchForm').submit(function(e) {
          //     console.log('check 1');
                e.preventDefault(); // Prevent form from refreshing page
        
                let uhid = $('#searchApplicationNo').val();
        
        
                $.ajax({
                    url: "{{ route('admin.regsearchApplication') }}",
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
                                let applicationNo = form.artclinics?.app_no?.applicationno ? form.artclinics.app_no.applicationno : 'N/A';
                                var encrypted_id2 = form.artclinics?.app_no?.artclinic_id?.id ? form.artclinics.app_no?.artclinic_id?.id : 0;
                                var encrypted_id3 = form.artclinics?.id 
                                                    ? form.artclinics.status 
                                                    : 0;
                                // console.log(encrypted_id2);
                                let formattedDate = form.created_at 
                                ? new Date(form.created_at).toLocaleDateString('en-GB') // Converts to DD/MM/YYYY
                                : 'N/A';
                                // console.log(encrypted_id2);
                                let actionColumn = encrypted_id2 != 0
                                ? '<span>-</span>'
                                : `<a href="{{ route("admin.reg_receivedssaForm_list", ['id' => '__ID__']) }}" 
                                    class="link">
                                    Action
                                </a>`.replace('__ID__', form.encrypted_id1);
                                let cert_issue = encrypted_id2 != 0
                                ? 'Yes'
                                : 'No';
                                let viewcolumn = encrypted_id3 == 0
                                ? '<span>-</span>'
                                : `<a href="{{ route("clinic.clinicForm_view", ['id' => '__ID__']) }}" 
                                    class="class="btn btn csp-clinic-btn" target='_blank'>
                                    <i class="fas fa-eye"></i>
                                </a>`.replace('__ID__', form.encrypted_id3);
                                let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${form.artclinics?.app_no?.applicationno || 'N/A'}</td>
                                    <td>${form.artclinics.appstatus ?? 'N/A'}</td>
                                    <td>${form.clinicname ?? 'N/A'}</td>
                                    <td>${form.nature ?? 'N/A'}</td>
                                    <td>${form.artclinics?.cliniclevel ?? 'N/A'}</td>
                                    <td>${form.email ?? 'N/A'}</td>
                                    <td>${form.contactno ?? 'N/A'}</td>
                                    <td>${form.address ?? 'N/A'}</td>
                                    <td>${form.state ?? 'N/A'}</td>
                                    <td>${form.district ?? 'N/A'}</td>
                                    <td>${form.artclinics.applicationno_datetime_submission ?? 'N/A'}</td>
                                    <td>${form.artclinics.app_date_payment ?? 'N/A'}</td>
                                    <td>${form.artclinics.app_date_recieve ?? 'N/A'}</td>
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
