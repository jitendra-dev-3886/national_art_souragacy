@extends('layouts.admin.admin_master')

@section('content')
<style nonce="{{ $cspNonce }}">
    .csp-admin-message-div {
        background-color: #141481; border-color: #0b5ed7; color: white;
    }
    .csp-admin-submit-button {
        margin-top: 32px;
    }
    .csp-admin-table {
        min-width: 845px;
    }
    .csp-admin-clinic-type {
        color: #ff0000;
    }
    #dataTableContainer {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="col-lg-6 offset-lg-3">
                    <div class="alert alert-danger alert-dismissible alert-alt fade show">
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">List of Date of Correction Clinic Registration</h4>
                    
                </div>

                <div class="card-body">
                    <div>
                        <table id="myDataTable" class="display table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Clinic Id</th>
                                    <th>Registration No.</th>
                                    <th>Clinic Name</th>
                                    <th>Level</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>View certificate</th>
                                    <th>Registration Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data)
                                    @php $n = 1; @endphp
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $n++ }}</td>
                                            <td class="clinic_id">{{ $d->clinic_id }}</td>
                                            <td>{{ $d->registration_no }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->level }}</td>
                                            <td>{{ $d->state }}</td>
                                            <td>{{ $d->district }}</td>
                                            <td>
                                                @php $file = folderpath('clinic_registration_certificate_blade') . $d->clinic_id . '/' . $d->certificate_path; @endphp
                                                <a href="{{ asset($file) }}" target="_blank">
                                                    View PDF
                                                </a>
                                            </td>
                                            @if($d->rgistration_date)
                                                <td>{{ $d->rgistration_date }}
                                                    <input type="hidden" value='' class="form-control reg_date">
                                                </td>
                                                
                                            @else
                                                <td>
                                                    <input type="date" name="registration_date" class="form-control reg_date">
                                                </td>
                                            @endif
                                            
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">No record found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <button type="button" id="saveDates" class="btn btn-primary btn-sm csp-admin-submit-button float-end">
                        Save Dates
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<link nonce="{{ $cspNonce }}" rel="stylesheet" href="{{ url('public/css/sweetalert2.min.css') }}">
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/sweetalert2.all.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#myDataTable').DataTable();

        $('#saveDates').click(function() {
            let formData = [];

            $('#myDataTable tbody tr').each(function() {
                let clinicId = $(this).find('.clinic_id').text().trim();
                let date = $(this).find('.reg_date').val();

                if (date && date.trim() !== '') {
                    formData.push({
                        clinic_id: clinicId,
                        registration_date: date
                    });
                }
            });

            if (formData.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data',
                    text: 'Please fill at least one date before submitting.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }
            $.ajax({
                url: "{{ route('admin.updateDates') }}", 
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    data: formData
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#3085d6',
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Not save registeration date.Please try again',
                        confirmButtonColor: '#d33',
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
