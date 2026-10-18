@extends('layouts.admin.ssa_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-table {
            min-width: 845px;
        }

        .csp-admin-form {
            display: flex;
            align-items: center;
        }

        .csp-admin-form-input {
            width: 300px;
            margin-bottom: 10px;
            margin-right: 10px;
            display: inline-block;
        }

        .csp-admin-form-button {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
            display: inline-block;
        }

        .csp-admin-red-color {
            color: red;
        }

        .csp-admin-div-none {
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
                        <h4 class="card-title">{{ $clinicTypeValueaname[$clinicTypeValue] }}</h4>
                    </div>
                    {{-- {{ $clinicTypeValue }} --}}
                    <div class="card-body">
                        <form id="searchForm" method="GET"
                            action="{{ route('changemanpower.ssa_search_application', ['clinicType' => $clinicTypeValue]) }}"
                            class="csp-admin-form">
                            <input type="text" id="searchApplicationNo" name="application_no"
                                placeholder="Enter Application No." class="form-control csp-admin-form-input">
                            <button type="submit" class="btn btn csp-admin-form-button">Search</button>
                        </form>

                        <!-- Error message container -->
                        <p id="errorMessage" class="csp-admin-red-color"></p>

                        <!-- Search result container -->
                        <div id="result" class="csp-admin-div-none">
                            <table class="table table-bordered table-striped table-hover nowrap w-100" id="surrogacy_list">
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
        // Get clinic type from Blade (plain for search)
        let clinicType = @json($clinicTypeValue);

        // AJAX URL for searching applications dynamically (plain)
        let ajaxUrlTemplate = "{{ route('changemanpower.ssa_search_application', ['clinicType' => '__CLINIC__']) }}";
        let ajaxUrl = ajaxUrlTemplate.replace('__CLINIC__', clinicType);

        // Encrypted clinic type for Action URLs
        let encryptedClinicType = @json(Crypt::encryptString($clinicTypeValue));

        // Base URL for Action (registration) and View (details)
        let actionUrlBase = "{{ url('manpower/CLINIC_PLACEHOLDER-ssa-application-reg/ID_PLACEHOLDER') }}";
        let viewUrlBase = "{{ url('manpower/art-change-manpower-form-view/ID_PLACEHOLDER') }}";


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
                data: {
                    application_no: query
                },
                success: function(response) {
                    // console.log('AJAX Response:', response);
                    let rows = '';


                    if ($.fn.DataTable.isDataTable('#surrogacy_list')) {
                        $('#surrogacy_list').DataTable().clear().destroy();
                    }
                    $.each(response, function(index, item) {

                        // Build Action URL using encrypted clinic type
                        let actionUrl = actionUrlBase
                            .replace('CLINIC_PLACEHOLDER', encryptedClinicType)
                            .replace('ID_PLACEHOLDER', item.encrypted_id);

                        // Build View URL (can remain encrypted ID only)

                        let viewUrl = viewUrlBase.replace('ID_PLACEHOLDER', item.encrypted_id);
                        // Determine last columns
                        let actionColumn = '';
                        let viewColumn = '';

                        if (item.app_status === 'Pending' || item.app_status === 'Received') {
                            actionColumn =
                                `<a href="${actionUrl}" class="btn btn-sm btn-primary">Action</a>`;
                        } else if (item.app_status === 'Approved' || item.app_status ===
                            'Rejected') {
                            actionColumn = item.app_status;
                        }
                        viewColumn =
                            `<a href="${viewUrl}" class="btn btn-sm btn-secondary">View</a>`;

                        rows += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.application_no ?? ''}</td>
                                <td>${item.app_status ?? ''}</td>
                                <td>${item.clinicname ?? ''}</td>
                                <td>${item.nature ?? ''}</td>
                                <td>${item.email ?? ''}</td>
                                <td>${item.contactno ?? ''}</td>
                                <td>${item.address ?? ''}</td>
                                <td>${item.state ?? ''}</td>
                                <td>${item.district ?? ''}</td>
                                <td>${item.date_of_submisstion  ? item.date_of_submisstion.split('-').reverse().join('-') : ''}</td>
                                <td>${viewColumn ?? '-'}</td>
                                <td>${actionColumn}</td>

                            </tr>`.replace('__ID__', item.encrypted_clinic_id); // Encrypt in controller

                    });
                    $('#patientList').append(rows);
                    $('#surrogacy_list').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true,
                        responsive: true,
                        scrollX: true,

                        dom: '<"row"<"col-md-2"l><"col-md-7"B><"col-md-3"f>>' +
                            'rt' +
                            '<"row"<"col-md-6"p>>',
                        buttons: [{
                            extend: 'excel',
                            text: 'Export Excel'
                        }],
                        columnDefs: [{
                                targets: 0,
                                width: '5%'
                            }, // S.No
                            {
                                targets: 1,
                                width: '7%'
                            }, // Application No
                            {
                                targets: 2,
                                width: '8%'
                            }, // Clinic Name
                            {
                                targets: 3,
                                width: '6%'
                            }, // Nature
                            {
                                targets: 4,
                                width: '7%'
                            }, // Email
                            {
                                targets: 5,
                                width: '6%'
                            }, // Mobile
                            {
                                targets: 6,
                                width: '10%'
                            }, // Address
                            {
                                targets: 7,
                                width: '6%'
                            }, // State
                            {
                                targets: 8,
                                width: '6%'
                            }, // District
                            {
                                targets: 9,
                                width: '7%'
                            }, // Online Submission
                            {
                                targets: 10,
                                width: '7%'
                            }, // Payment Date
                            {
                                targets: 11,
                                width: '7%'
                            }, // Received Date
                            {
                                targets: 12,
                                width: '6%'
                            } // Action
                        ],
                        createdRow: function(row, data, dataIndex) {
                            $('td', row).addClass('align-middle text-wrap');
                        }
                    });
                    // $('#patientList').html(rows);
                    $('#result').removeClass('csp-admin-div-none');
                    $('#errorMessage').text('');
                    // } else {
                    //     $('#patientList').html('');
                    //     $('#result').addClass('csp-admin-div-none');
                    //     $('#errorMessage').text('No records found.');
                    // }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr.responseText);
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
