@extends('layouts.admin.ssa_master')
@section('content')

<style nonce="{{ $cspNonce }}">
    .csp-admin-message-alert{
        background-color: #0b5ed7;
        border-color: #0b5ed7;
        color: white;
    }
    .csp-admin-table{
        min-width: 845px;
    }
    /* Dark text that stays readable on success & danger */
    .text-dark-contrast {
        color: #1a1a1a !important;
    }

    .text-dark-contrast i {
        color: #1a1a1a !important;
    }
    .accept-btn,
    .accept-btn i {
        color: #0f2f1c !important; /* very dark green */
    }

    .reject-btn,
    .reject-btn i {
        color: #3b0d0d !important; /* very dark red */
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
                            <th>Request No</th>
                            <th>Application No</th>
                            <th>Registration No</th>
                            <th>Clinic Name</th>
                            <th>Clinic Old EmailID</th>
                            <th>Clinic New EmailID</th>
                            <th>Clinic Old MobileNo</th>
                            <th>Clinic New MobileNo</th>
                             <th>Reason for Change</th>
                              <th>Attached pdf</th>
                            {{-- <th>Old Phone</th>
                            <th>New Phone</th>
                            <th>Cancel</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                             {{-- <th style="width:120px;">Cancel</th> --}}
                            <th style="width:120px;">Resend Email</th>
                        </tr>
                    </thead>

                    <tbody>
                @forelse($data as $row)
<tr>
    <td>{{ $row->request_id }}</td>
    <td>{{ $row->application_no }}</td>
    <td>{{ $row->registration_no }}</td>
    <td>{{ $row->clinic_name }}</td>
    <td>{{ $row->old_clinic_email }}</td>
    <td>{{ $row->new_clinic_email }}</td>
    <td>{{ $row->clinic_phone }}</td>
    <td>{{ $row->new_clinic_mobile }}</td>
    <td>{{ $row->change_reason }}</td>
    {{-- <td>{{ $row->request_letter_path }}</td> --}}
    <td>
        @php $file = folderpath('clinicaccesschange_blade') . $row->state. '/' . $row->request_letter_path; @endphp
        <a href="{{ asset($file) }}" target="_blank">
            View Request Letter
        </a>
        {{-- <a href="{{ asset('artprojfiles/clinic_registration_certificate/' .$row->clinic_id. '/' . basename($row->certificate_path)) }}" target="_blank">
        View PDF
        </a> --}}
    </td>
    {{-- <td>{{ $row->old_phone }}</td>
    <td>{{ $row->verify_new_phone }}</td> 
    <td>{{ $row->cancel }}</td> --}}
    <td>{{ $row->status_label}}</td>
    </td>
    @if ($row->status=='pending')
    <td class="text-center">
        <button
            type="button"
            class="btn btn-sm btn-outline-danger revoke-btn"
            data-id="{{ $row->id }}">
            <i class="bi bi-x-circle"></i> Revoke
        </button>
    </td>
    @elseif ($row->status === 'requested')
    <td class="text-center">
        <div class="btn-group" role="group">
            <button
                type="button"
                class="btn btn-sm btn-success accept-btn text-dark-contrast"
                data-id="{{ $row->id }}">
                <i class="bi bi-check-circle"></i> Accept
            </button>

            <button
                type="button"
                class="btn btn-sm btn-danger reject-btn text-dark-contrast"
                data-id="{{ $row->id }}">
                <i class="bi bi-x-circle"></i> Reject
            </button>
        </div>
    </td>
    @else
    <td class="text-center text-muted">
    <span class="badge bg-secondary">No Action Needed</span>
    </td>
    @endif
     {{-- <td>
    <button
        type="button"
        class="btn btn-sm btn-danger cancel-request-btn"
        data-id="{{ $row->request_id }}">
        Cancel
    </button>
    </td> --}}
    @if($row->status=='pending' && !is_null($row->email_sent))
    <td class="text-center">
        <button
            type="button"
            class="btn btn-sm btn-outline-primary resend-mail-btn"
            data-id="{{ $row->id }}"
            title="Resend application email">
            <i class="bi bi-envelope-arrow-up"></i> Resend Email
        </button>
    </td>
    @else
        <td class="text-center">
            Not Allowed
        </td>
    @endif
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

<script nonce="{{ $cspNonce }}">


$(document).ready(function(){

    function updateStatus(id, action){
        $.ajax({
            url: "{{ route('access_change.update_status') }}",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                action: action
            },
            success: function(response){
                if(response.status){
                    alert(response.message);
                    location.reload(); 
                } else {
                    alert(response.message);
                }
            },
            error: function(){
                alert('Server Error please contact support team.');
            }
        });
    }

    $('.revoke-btn').on('click', function(){
        let id = $(this).data('id');
        if(confirm('Are you sure you want to revoke this request?')){
            updateStatus(id, 'revoke');
        }
    });

    $('.accept-btn').on('click', function(){
        let id = $(this).data('id');
        if(confirm('Are you sure you want to accept this request?')){
            updateStatus(id, 'accept');
        }
    });

   $('.reject-btn').on('click', function(){
        let id = $(this).data('id');
        if(confirm('Are you sure you want to reject this request?')){
            updateStatus(id, 'reject');
        }
    });

});


// resend mail

$(document).on('click', '.resend-mail-btn', function () {

    let id = $(this).data('id');

    $.ajax({
        url: "{{ route('access_change.resend_mail') }}",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        },
        success: function (response) {
            alert(response.message);
        },
        error: function () {
            alert('Something went wrong!');
        }
    });
});


</script>


@endsection