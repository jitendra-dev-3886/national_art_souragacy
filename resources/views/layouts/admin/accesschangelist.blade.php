@extends('layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .csp-admin-message-alert{
        background-color: #0B5ED7;
        border-color: #0B5ED7;
        color: white;
    }
    .csp-admin-table{
        min-width: 845px;
    }
</style>
<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <!-- CARD HEADER -->
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-center align-items-center"
             style="height:60px; font-size:18px;">
            ACCESS CHANGE REQUEST
        </div>
        <!-- CARD BODY -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover m-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>S. No.</th>
                            <th>Request No</th>
                            <th>Application No</th>
                            <th>Registration No</th>
                            <th>Clinic Name</th>
                            <th>Clinic Old EmailID</th>
                            <th>Clinic New EmailID</th>
                            <th>Clinic Old MobileNo</th>
                            <th>Clinic New MobileNo</th>
                            <th>Reason for Change</th>
                            <th>Attached PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $row->request_id }}</td>
                            <td>{{ $row->request_id }}</td>
                            <td>{{ $row->application_no }}</td>
                            <td>{{ $row->registration_no }}</td>
                            <td>{{ $row->clinic_name }}</td>
                            <td>{{ $row->old_clinic_email }}</td>
                            <td>{{ $row->new_clinic_email }}</td>
                            <td>{{ $row->clinic_phone }}</td>
                            <td>{{ $row->new_clinic_mobile }}</td>
                            <td>{{ $row->change_reason }}</td>
                            <td>{{ $row->request_letter_path }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-danger fw-bold">
                                No Records Found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection