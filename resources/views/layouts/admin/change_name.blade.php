@extends('layouts.admin.ssa_master')

@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-table {
            min-width: 1800px;
        }

        .csp-admin-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .csp-admin-form-input {
            width: 300px;
        }

        .csp-admin-red-color {
            color: red;
            font-weight: 600;
        }
    </style>
    <style>
        #example8 th,
        #example8 td {

            white-space: nowrap;
            vertical-align: middle;

        }

        .dataTables_wrapper {

            width: 100%;

        }
    </style>

    <div class="container-fluid">

        <div class="row">

            <div class="col-12">

                @if (session('upd_success'))
                    <div class="col-lg-6 offset-lg-3">

                        <div class="alert alert-success alert-dismissible fade show csp-admin-message-div">

                            <strong>{{ session('upd_success') }}</strong>

                        </div>

                    </div>
                @endif

                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title">

                            Applications for Change Name

                        </h4>

                    </div>

                    <div class="card-body">

                        <!-- Search Form -->

                        <form id="searchForm" class="csp-admin-form">

                            {{-- <input type="hidden" id="clinicType" value="{{ $type }}"> --}}

                            <input type="text" name="application_no" id="searchApplicationNo"
                                class="form-control csp-admin-form-input" placeholder="Enter Application No">

                            <button type="submit" class="btn btn-primary">

                                Search

                            </button>

                        </form>

                        <p id="errorMessage" class="csp-admin-red-color">
                        </p>

                        <!-- Table -->

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover nowrap csp-admin-table"
                                id="example8">

                                <thead>

                                    <tr>

                                        <th>S.No.</th>

                                        <th>Application No.</th>

                                        <th>Application Status</th>

                                        <th>Current Clinic Name</th>

                                        <th>New Clinic Name</th>

                                        <th>Nature</th>

                                        @if ($type == 'ARTCLINIC')
                                            <th>Clinic Level</th>
                                        @endif

                                        <th class="text-center">Email ID</th>

                                        <th>Contact No.</th>

                                        <th>Address</th>

                                        <th>State</th>

                                        <th>District</th>

                                        <th>
                                            Date of Online
                                            <br>
                                            Form Submission
                                        </th>

                                        <th>
                                            Date on which
                                            <br>
                                            Application Received
                                        </th>

                                        <th>Certificate Issue</th>

                                        <th>View</th>


                                        <th class="text-center">Action</th>

                                    </tr>

                                </thead>

                                <tbody id="patientList">

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

            // Initialize DataTable First Time

            let table = $('#example8').DataTable({

                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                scrollX: true,
                autoWidth: false

            });

            // Search Form Submit

            $('#searchForm').submit(function(e) {

                e.preventDefault();

                let application_no = $('#searchApplicationNo').val();

                let clinic_type = $('#clinicType').val();

                if (application_no == '') {

                    $('#errorMessage').text(
                        'Please enter application number'
                    );

                    return;
                }

                $.ajax({

                    url: "{{ url('search-change-name') }}/" + clinic_type,

                    type: "GET",

                    data: {
                        application_no: application_no
                    },

                    beforeSend: function() {

                        $('#errorMessage').text('');

                        // destroy old datatable
                        table.destroy();

                        $('#patientList').html(

                            '<tr>' +

                            '<td colspan="17" class="text-center">' +

                            'Searching...' +

                            '</td>' +

                            '</tr>'
                        );

                    },

                    success: function(response) {

                        $('#patientList').empty();

                        if (response.errorMessage) {

                            $('#errorMessage').text(
                                response.errorMessage
                            );

                            return;
                        }

                        if (response.applications.length == 0) {

                            $('#errorMessage').text(
                                'No Record Found'
                            );

                            return;
                        }

                        $.each(response.applications, function(index, form) {
                            let viewUrl =
                                "{{ route('cn.application.view', ['encryptedId' => '__ID__']) }}"
                                .replace('__ID__', encodeURIComponent(form
                                    .encrypted_id));

                            let row = `

                    <tr>

                        <td>${index + 1}</td>

                        <td>${form.application_no ?? 'N/A'}</td>

                            <td>
                ${form.appstatus ?? 'N/A'}

                            </td>

                        <td>${form.name ?? 'N/A'}</td>

                        <td>${form.proposed_clinic_name ?? 'N/A'}</td>

                        <td>${form.nature ?? 'N/A'}</td>

                        ${
                        "{{ $type }}" == "ARTCLINIC"
                        ? `<td>${form.level ?? 'N/A'}</td>`
                        : ''
                        }

                        <td>${form.email ?? 'N/A'}</td>

                        <td>${form.contact_number ?? 'N/A'}</td>

                        <td>${form.address ?? 'N/A'}</td>

                        <td>${form.state ?? 'N/A'}</td>

                        <td>${form.district ?? 'N/A'}</td>

                            <td>
                ${form.created_at
                ? new Date(form.created_at).toLocaleDateString('en-GB').replace(/\//g, '-')
                : 'N/A'}
                </td>

                <td>
                ${form.updated_at
                ? new Date(form.updated_at).toLocaleDateString('en-GB').replace(/\//g, '-')
                : 'N/A'}
                </td>

                 
                        

                        <td>${form.appstatus ?? 'N/A'}</td>
                        <td>
                        ${
                            form.appstatus === 'Approved'
                                ? `<a href="${viewUrl}"
                                                    class="btn btn-sm btn-secondary"
                                                    target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>`
                                : '-'
                        }
                        </td>
                            <td>
                            ${
                            form.appstatus === 'Pending'
                            ? (
                            form.encrypted_id
                            ? `<a href="{{ route('admin.reg_artclinicchange_list', ['id' => '__ID__']) }}"
                                       class="btn btn-sm btn-primary">
                                        Action
                                        </a>`.replace('__ID__', encodeURIComponent(form.encrypted_id))
                            : '-'
                            )
                            : form.appstatus === 'Approved'
                            ? '-'
                            : form.appstatus === 'Rejected'
                            ? '-'
                            : '-'
                            }
                            </td>

                                    </tr>

                    `;

                            $('#patientList').append(row);

                        });


                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        $('#errorMessage').text(
                            'Something went wrong'
                        );

                    }

                });

            });

        });
    </script>
@endsection
