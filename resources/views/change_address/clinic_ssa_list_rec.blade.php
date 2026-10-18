@extends('layouts.admin.ssa_master')

@section('content')

<style nonce="{{ $cspNonce }}">
    .csp-admin-message-div{
        background-color: #141481;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-admin-form{
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .csp-admin-form-input{
        width: 300px;
    }

    .csp-admin-form-button{
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }

    .csp-admin-red-color{
        color:red;
    }

    .csp-admin-div-none{
        display:none;
    }
</style>

<!-- jQuery FIRST -->
<script src="{{ asset('datatable/jquery3.0.js') }}" nonce="{{ $cspNonce }}"></script>

<!-- DataTable CSS -->
<link rel="stylesheet" href="{{ asset('datatable/datatable.css') }}">

<!-- DataTable JS -->
<script src="{{ asset('datatable/datatablemin.js') }}" nonce="{{ $cspNonce }}"></script>

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            @if(session('upd_success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible fade show csp-admin-message-div">
                        <strong>{{ session('upd_success') }}</strong>
                    </div>
                </div>
            @endif

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">
                        Applications for the ART Clinics Receiving
                    </h4>
                </div>

                <div class="card-body">

                    <!-- Search Form -->
                    <form id="searchForm" class="csp-admin-form">

                        <input
                            type="text"
                            id="searchApplicationNo"
                            name="application_no"
                            placeholder="Enter Application No."
                            class="form-control csp-admin-form-input"
                        >

                        <button type="submit" class="btn csp-admin-form-button">
                            Search
                        </button>

                    </form>

                    <!-- Error -->
                    <p id="errorMessage" class="csp-admin-red-color"></p>

                    <!-- Result -->
                    <div id="result" class="csp-admin-div-none">

                        <table class="table table-bordered display nowrap w-100"
                               id="recClinicList">

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

                            <tbody id="ajaxData"></tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script nonce="{{ $cspNonce }}">

    $(document).ready(function () {

        let clinicType = @json(strtolower($clinicTypeValue));

        const ajaxUrl =
            "{{ route('change_address.ssa.search_application', ['clinicType' => '__CLINIC__']) }}"
            .replace('__CLINIC__', clinicType);

          /*if (!query) {
                $errorMessage.text('Please enter an application number.');
                    return;
               }
            let viewColumn = `<a href="${viewUrl}" class="btn btn-sm btn-secondary">View</a>`;
            $errorMessage.text('');
           */

       // View URL
        const viewUrlTemplate =
            "{{ route('change_address.ssa_application_rec', ['clinicType' => '__CLINIC__', 'encryptedId' => '__ID__']) }}";

        const $table = $('#recClinicList');
        const $ajaxData = $('#ajaxData');
        const $errorMessage = $('#errorMessage');
        const $result = $('#result');

        // Search Submit
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            const query = $('#searchApplicationNo').val().trim();
            // Validation
            if (!query) {
                $errorMessage.text('Please enter an application number.');
                return;
            }
            $errorMessage.text('');
            $.ajax({
                url: ajaxUrl,
                type: 'GET',

                data: {
                    application_no: query
                },
                success: function (response) {
                    console.log(response);
                    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#recClinicList')) {
                        $table.DataTable().clear().destroy();
                    }
                    $ajaxData.empty();
                    if (response.errorMessage) {
                        $result.addClass('csp-admin-div-none');
                        $errorMessage.text(response.errorMessage);
                        return;
                    }
                    // No records
                    if (!Array.isArray(response) || response.length === 0) {
                        $result.addClass('csp-admin-div-none');
                        $errorMessage.text('No records found.');
                        return;
                    }

                        const rows = response.map((item, index) => {
                        const viewUrl = viewUrlTemplate
                            .replace('__CLINIC__', clinicType)
                            .replace('__ID__', item.encrypted_id);

                        const statusMap = {
                            Rejected: '<span class="">Rejected</span>',
                            Approved: '<span class="">Approved</span>',
                            Received: '<span class="">Fee Received</span>',
                            Pending: `<a href="${viewUrl}" class="btn btn-sm btn-primary">Action</a>`
                        };

                        return `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.applicationno ?? ''}</td>
                                <td>${item.clinicname ?? ''}</td>
                                <td>${item.email ?? ''}</td>
                                <td>${item.address ?? ''}</td>
                                <td>${item.state ?? ''}</td>
                                <td>${item.district ?? ''}</td>
                                <td>
                                    ${statusMap[item.appstatus] || `<span class="badge bg-secondary">${item.appstatus || 'N/A'}</span>`}
                                </td>
                            </tr>
                        `;
                    }).join('');

                    $ajaxData.html(rows);
                    $result.removeClass('csp-admin-div-none');
                    if ($.fn.DataTable) {
                        $table.DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            responsive: true,
                            scrollX: true
                        });
                    } else {

                        console.error('DataTable library not loaded.');

                    }
                },
                error: function (xhr) {
                    console.log(xhr);
                    $errorMessage.text(
                        'Something went wrong. Please try again.'
                    );
                }
            });
        });
    });
</script>

@endsection