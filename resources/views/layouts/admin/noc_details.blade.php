@extends('layouts.admin.admin_master')
{{-- @extends('layouts.admin.admin_siderbar_nav') --}}
@section('content')


<style nonce="{{ $cspNonce }}">
        .btn-secondary {
        --bs-btn-color: #fff;
        --bs-btn-bg: #210f77;
        --bs-btn-border-color: #210f77;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #210f77;
        --bs-btn-hover-border-color: #210f77;
        --bs-btn-focus-shadow-rgb: 55, 111, 106;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #210f77;
        --bs-btn-active-border-color: #210f77;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #210f77;
        --bs-btn-disabled-border-color: #210f77;
        }

        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-opecity-div{
            opacity:0.8;
        }
        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-ancor-margin{
            margin-right: 5px;
        }
        .csp-admin-submit-button{
            width: 108px; height: 43px; margin-left: -10px; background-color:0b47a0;border-color: 0b47a0;
        }
        .csp-admin-table-100{
            min-width:100px
        }
        .csp-admin-anchor{
            background-color: #210f77; border-block-color: #210f77;border-color: #210f77;
        }
        .csp-admin-table-cloumn{
            text-transform: lowercase;
        }


    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid">
        @if (session('success_add'))
        <div class="col-lg-6 offset-lg-3">
            <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                <strong> {{ session('success_add') }}</strong> 
            </div>
        </div>
    @endif

        @if ($role == 4)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header position-relative d-flex justify-content-between align-items-center">
                            <div></div>
                            <h4 class="card-title position-absolute top-50 start-50 translate-middle text-primary csp-admin-opecity-div">
                                NOC Application List
                            </h4>
                            <div></div>
                        </div>
                        <div class="card-header">
                            <h4 class="card-title">Applications to be Assigned</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example44" class="display csp-admin-table-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>S.No</th>
                                            <th>Assign To</th>
                                            <th>View Form</th>
                                            <th>Application No</th>
                                            <th>Date of Submission</th>
                                            <th>Applicant Details</th>
                                            <th>Embryo/Gamete</th>
                                            <th>Transfer</th>
                                            <th>purpose</th>
                                            <th>Country/State(From - To)</th>
                                            <th>Current Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($getdata_noc_data))
                                            
                                       
                                        @foreach ($getdata_noc_data as $data)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="select_check_box" value="{{ $data->id }}" class="select-check-box">
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <select id="drop{{ $data->id }}" name="username[]"
                                                        class="form-control roleDropdown mySelect">
                                                        <option value="">Select</option>
                                                        {!! getActor($data->id) !!}
                                                    </select>
                                                </td>
                                                <td>
                                                <a href="{{ route('admin.nocgeneratePdf', ['id' => Crypt::encrypt($data->id)]) }}" target="_blank">
                                                    <i class="fas fa-eye csp-admin-ancor-margin"></i>
                                                </a>
                                                </td>
                                                <td>{{ $data->application_no }}</td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($data->submission_date)->format('d-m-Y') }}</td> --}}
                                                <td>{{ \Carbon\Carbon::parse($data->submission_date)->format('d-m-Y H:i:s') }}</td>
                                                <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                <td>{{ $data->transfer_of }}</td>   
                                                <td>{{ $data->transfer }}</td>
                                                <td>{{ $data->purpose_of_transfer }}</td>
                                                @if(is_null($data->t_state))
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                @else
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                @endif
                                                <td>{!! status_name($data->level_id) !!}</td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tr>
                                        <td colspan="11">
                                            <form id="myForm">
                                                <button type="submit" name="submit" class="btn btn-secondary csp-admin-submit-button">Submit</button>
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($role == 4 || $role == 5)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>List of Examined Application</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display csp-admin-table-100">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>Applicant Details</th>
                                            <th>Embryo/Gamete</th>
                                            <th>Transfer</th>
                                            <th>purpose</th>    
                                            <th>Country/State(From - To)</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_action_list as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                        class="btn btn-info csp-admin-anchor">
                                                        {{ $data->application_no }}
                                                    </a>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($data->submission_date)->format('d-m-Y H:i:s') }}</td>
                                                <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                <td>{{ $data->transfer_of }}</td>   
                                                <td>{{ $data->transfer }}</td>
                                                <td>{{ $data->purpose_of_transfer }}</td>
                                                @if(is_null($data->t_state))
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                @else
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                @endif
                                                <td>{!! status_name($data->level_id) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
        @if ($role == 4)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Marked for Approval Process</h4>
                            <span class="name"></span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example8" class="display csp-admin-table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>Applicant Details</th>
                                            <th>Embryo/Gamete</th>
                                            <th>Transfer</th>
                                            <th>purpose</th>    
                                            <th>Country/State(From - To)</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($get_list_marked_for_approval as $data)
                                            <tr>


                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                       class="btn btn-info csp-admin-anchor">
                                                        {{ $data->application_no }}
                                                    </a>
                                                </td>
                                                <td>{{ $data->submission_date }}</td>
                                                <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                <td>{{ $data->transfer_of }}</td>   
                                                <td>{{ $data->transfer }}</td>
                                                <td>{{ $data->purpose_of_transfer }}</td>
                                                @if(is_null($data->t_state))
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                @else
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                @endif
                                                <td>{!! status_name($data->level_id) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Park for Internal</h4>
                            <span class="name"></span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display csp-admin-table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>Applicant Details</th>
                                            <th>Embryo/Gamete</th>
                                            <th>Transfer</th>
                                            <th>purpose</th>    
                                            <th>Country/State(From - To)</th>
                                            <th>Current Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($get_list_park_for_internal as $data)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                         class="btn btn-info csp-admin-anchor">
                                                        {{ $data->application_no }}
                                                    </a>
                                                </td>
                                                <td>{{ $data->submission_date }}</td>
                                                <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                <td>{{ $data->transfer_of }}</td>   
                                                <td>{{ $data->transfer }}</td>
                                                <td>{{ $data->purpose_of_transfer }}</td>
                                                @if(is_null($data->t_state))
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                @else
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                @endif
                                                <td>{!! status_name($data->level_id) !!}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Park for External committee</h4>
                            <span class="name"></span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example4" class="display csp-admin-table">
                                    <thead>
                                        <tr>

                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>Applicant Details</th>
                                            <th>Embryo/Gamete</th>
                                            <th>Transfer</th>
                                            <th>purpose</th>    
                                            <th>Country/State(From - To)</th>
                                            <th>Current Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($get_Park_for_external_committeit as $data)
                                            <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                        class="btn btn-info csp-admin-anchor">
                                                        {{ $data->application_no }}
                                                    </a>
                                                </td>
                                                <td>{{ $data->submission_date }}</td>
                                                <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                <td>{{ $data->transfer_of }}</td>   
                                                <td>{{ $data->transfer }}</td>
                                                <td>{{ $data->purpose_of_transfer }}</td>
                                                @if(is_null($data->t_state))
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                @else
                                                <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                @endif
                                                <td>{!! status_name($data->level_id) !!}</td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Park for Apex Committee</h4>
                            <span class="name"></span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="example5_wrapper" class="dataTables_wrapper no-footer">
                                    <table id="example5" class="display dataTable no-footer csp-admin-table"
                                        role="grid" aria-describedby="example5_info">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Application No.</th>
                                                <th>Action date</th>
                                                <th>Applicant Details</th>
                                                <th>Embryo/Gamete</th>
                                                <th>Transfer</th>
                                                <th>purpose</th>    
                                                <th>Country/State(From - To)</th>
                                                <th>Current Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($get_Park_for_Appex_Commity as $data)
                                                <tr>

                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                            class="btn btn-info csp-admin-anchor">
                                                            {{ $data->application_no }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $data->submission_date }}</td>
                                                    <td>{{ $data->name_applicant ?? 'N/A' }} - {{ $data->email  ?? 'N/A' }} - {{ $data->mobileno ?? 'N/A' }}</td>
                                                    <td>{{ $data->transfer_of }}</td>   
                                                    <td>{{ $data->transfer }}</td>
                                                    <td>{{ $data->purpose_of_transfer }}</td>
                                                    @if(is_null($data->t_state))
                                                    <td>{{ $data->f_state ?? 'N/A' }} - {{ country($data->country) }}</td>
                                                    @else
                                                    <td>{{ $data->f_state ?? 'N/A' }} - {{ $data->t_state }}</td>
                                                    @endif
                                                    <td>{!! status_name($data->level_id) !!}</td>
                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($role == 7)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List of Noc Approved</h4>
                        <span class="name"></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="" class="dataTables_wrapper no-footer">
                                <table id="example8" class="display dataTable no-footer csp-admin-table"
                                    role="grid" aria-describedby="example5_info">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>Name <span class="csp-admin-table-cloumn">of</span> Applicant</th>
                                            <th>Email ID</th>
                                            <th>Address</th>
                                            <th>State</th>
                                            <th>District</th>
                                            <th>Current Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($get_list_final_approval))
                                            @foreach ($get_list_final_approval as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->application_no ?? 'N/A' }}</td>
                                                    <td>{{ $data->submission_date }}</td>
                                                    <td>{{ $data->name_applicant ?? 'N/A' }}</td>
                                                    <td>{{ $data->email ?? 'N/A' }}</td>
                                                    <td>{{ $data->address ?? 'N/A' }}</td>
                                                    <td>{{ $data->state ?? 'N/A' }}</td>
                                                    <td>{{ $data->district ?? 'N/A' }}</td>
                                                    <td>{!! status_name($data->level_id) !!}</td>
                                                    <td>
                                                        <a href="{{ url('admin/view_noc_page/' . Crypt::encrypt($data->application_id) . '/' . Crypt::encrypt($data->level_id)) }}"
                                                             class="btn btn-info csp-admin-anchor">
                                                            Approved
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Second Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Noc Genrated List</h4>
                        <span class="name"></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="" class="dataTables_wrapper no-footer">
                                <table id="example9" class="display dataTable no-footer"
                                csp-admin-table  role="grid" aria-describedby="example5_info">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Application No.</th>
                                            <th>Action date</th>
                                            <th>internal_recommendation</th>
                                            <th>external_committee</th>
                                            <th>apex_committee</th>
                                            <th>approval_checked</th>
                                            <th>doc_type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($get_view_noc_pagelist_noc))
                                            @foreach ($get_view_noc_pagelist_noc as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->app_id ?? 'N/A' }}</td>
                                                    <td>{{ $data->created_at ?? 'N/A' }}</td>
                                                    <td>{{ $data->internal_recommanation ?? 'N/A' }}</td>
                                                    <td>{{ $data->external_commitee ?? 'N/A' }}</td>
                                                    <td>{{ $data->appex_commitee ?? 'N/A' }}</td>
                                                    <td>{{ $data->approval_checked ?? 'N/A' }}</td>
                                                    <td>{{ $data->doc_type ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

<script nonce="{{ $cspNonce }}">

    $(document).ready(function() {
        $('select').on('change', function() {
            var id = this.id;
            var value = this.value;
            var name = this.name;
            var $this = $(this);
            if (value == 'Approve') {
                $.ajax({
                    type: "POST",
                    url: "update_status.php",
                    data: {
                        id: id,
                        value: value,
                        name: name
                    },
                    success: function(data) {
                        $this.closest('td').html(data);
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        function initializeTable(tableId) {
            // Check if the table is already initialized
            if (!$.fn.dataTable.isDataTable(tableId)) {
                // Initialize DataTable
                var table = $(tableId).DataTable({
                    'paging': true,
                    'lengthChange': true,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': true
                });
            }
        }

        $.extend(true, $.fn.dataTable.defaults.oLanguage.oPaginate, {
                        sNext: '<i class="fa fa-chevron-right" ></i>',
                        sPrevious: '<i class="fa fa-chevron-left" ></i>'
});

        initializeTable('#example1');
        initializeTable('#example2');
        initializeTable('#example8');
        initializeTable('#example3');
        initializeTable('#example4');
        initializeTable('#example5');
        initializeTable('#example6');
        initializeTable('#example7');
        initializeTable('#example8');
        initializeTable('#example9');
        initializeTable('#example44');
   
    });




    $(document).ready(function() {
        $('.select-check-box').on('click', function() {
            let checkbox = this;
            let drpt = $(this).val();
            let drval = 'drop' + drpt;
            let dropdown = $('#' + drval);
            let dropdownValue = dropdown.val();

            if (!dropdownValue) {
                alert("Please select Examiner!");
                checkbox.checked = false;
                dropdown.focus();
            }
        });
    });



    $(document).ready(function() {
        var baseUrl = "{{ url('/') }}";
        document.getElementById('myForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const checkboxes = document.querySelectorAll('input[name="select_check_box"]:checked');
            const selectedValues = Array.from(checkboxes).map(checkbox => checkbox.value);
            //alert(selectedValues.length);
            if (selectedValues.length == 0) {
                swal("Warning", "Please select at least one examiner.", "warning");
                return; // Exit if no checkboxes are selected
            }
           // alert(selectedValues.length);
            if (selectedValues.length > 0) {
                swal({
                    title: "Confirm Action",
                    text: "Are you sure you want to assign this application !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {

                    if (isConfirm) {

                        selectedValues.forEach(value => {
                            let drval = 'drop' + value;
                            let dropdown = $('#' + drval).val();
                            //alert(dropdown);
                            const data = dropdown.split("-");
                           
                            let nocid = data[0];
                            let level_id = data[1];
                            let userid = data[2];
                            let serviceid = data[3];

                            $csr = $('meta[name="csrf-token"]').attr('content');
                            //  alert($csr);
                            $.ajax({
                                url: baseUrl + '/ajax-request',
                                type: 'POST',
                                data: {
                                    app_id: nocid,
                                    level_id: level_id,
                                    user_id: userid,
                                    serviceid: serviceid
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr(
                                        'content') // Get CSRF token from the meta tag
                                },
                                success: function(response) {

                                   // alert('sdfsdfsdf');

                                }
                            });
                            swal("Success!",
                                "This application has been assigned to Examiner",
                                "success");
                            setTimeout(function() {
                                location.reload('admin/noc_page');
                            }, 1000);
                        });

                    } else {
                        swal("Cancelled", "This application is not assigned.", "info");
                    }
                });
            } else {
                swal("Warning", "Please select at least one examiner.", "warning");
            }
        });
    });
</script>

<script nonce="{{ $cspNonce }}">
    // document.addEventListener("DOMContentLoaded", function () {
    //     alert($.fn.dataTable.version);
    //     if ($.fn.dataTable) {
    //         console.log("DataTables version:", $.fn.dataTable.version);
    //     } else {
    //         console.log("DataTables not loaded.");
    //     }
    // });
</script>
@endsection