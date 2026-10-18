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
                        <table id="myDataTable" class="display table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Clinic Id</th>
                                    <th>Registration No.</th>
                                    <th>Clinic Name</th>
                                    <th>Level</th>
                                    <th>Clinic Type</th>
                                    <th>Clinic Email</th>
                                    <th>Clinic Contact No.</th>
                                    <th>State</th>
                                    <th>Date of Estb. by clinic</th>
                                    <th>Date of establishment status</th>
                                    <th>Date of Estb. by interpretation <br> (YYYY-MM-DD)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data)
                                    @php $n = 1;@endphp
                                    @foreach ($data as $d)
                                        <tr>
                                            @if ($n==2)
                                            {{-- @php dd($data->count());@endphp --}}
                                            @endif
                                            <td>{{ $n++ }}</td>
                                            <td class="clinic_id">{{ $d->clinic_id }}</td>
                                            <td>{{ $d->registration_no }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ $d->level }}</td>
                                            @if ($d->clinic_type=="ARTSURROGACY")
                                                <td>Surrogacy Clinic</td>
                                            @elseif ($d->clinic_type=="ARTBANK")
                                                <td>ART Bank</td>
                                            @elseif($d->clinic_type=="ARTCLINIC")
                                                <td>ART Clinic</td>
                                            @endif
                                            
                                            <td>{{ $d->email }}</td>
                                            <td>{{ $d->contact_number_clinic }}</td>
                                            <td>{{ $d->state }}</td>
                                            <td>{{ $d->old_establishment_date }}</td>
                                            {{-- <td><input type="text" placeholder="YYYY-MM-DD" value="{{ $d->new_establishment_date  ? $d->new_establishment_date  : '' }}" name="estblishment_date" class="form-control estb_date"></td> --}}
                                            <td>
                                                @if($d->is_same_establishment_date)
                                                    <span class="text-success fw-bold">Corrected by user</span>
                                                @elseif(\Carbon\Carbon::hasFormat($d->old_establishment_date, 'Y-m-d'))
                                                    <span class="text-success fw-bold">Fetched by System</span>
                                                @elseif(\Carbon\Carbon::hasFormat($d->new_establishment_date, 'Y-m-d'))
                                                    <span class="text-success fw-bold">Corrected by registry</span>
                                                @else
                                                    <span class="text-danger fw-bold">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($d->is_same_establishment_date)
                                                    <span class="fw-bold">{{ $d->old_establishment_date }}</span>
                                                @elseif(\Carbon\Carbon::hasFormat($d->old_establishment_date, 'Y-m-d'))
                                                    <span class="fw-bold">{{ $d->old_establishment_date }}</span>
                                                @else
                                                    <input
                                                        type="date"
                                                        value="{{ $d->new_establishment_date }}"
                                                        name="estblishment_date"
                                                        class="form-control estb_date"
                                                    >
                                                @endif
                                            </td>
                                            
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

{{-- <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script> --}}
<link nonce="{{ $cspNonce }}" rel="stylesheet" href="{{ url('public/css/sweetalert2.min.css') }}">
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/sweetalert2.all.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#myDataTable').DataTable({
            responsive: true, // :white_tick: Responsive Design Enable
            scrollX: true,    // :white_tick: Horizontal Scroll Enable
            scrollY: '500px', // :white_tick: Vertical Scroll Height (optional)
            scrollCollapse: true, // Scroll collapse when fewer rows
            paging: true,     // Enable pagination
            autoWidth: false, // Prevent automatic column width adjustment
        });

        $('#saveDates').click(function() {
            let formData = [];
            var table = $('#myDataTable').DataTable();
            table.rows({ search: 'applied' }).every(function() {
                let row = $(this.node());
                let clinicId = row.find('.clinic_id').text().trim();
                let input = row.find('.estb_date');
                if (input.length) {
                    let date = input.val();

                    if (date) {
                        formData.push({
                            clinic_id: clinicId,
                            new_date_of_establishment: date
                        });
                    }
                }
            });
            if (formData.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Data',
                    text: 'No dates to update',
                });
                return;
            }

            $.ajax({
                url: "{{ route('admin.updateEstbDates') }}", 
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
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Not save Establishment date.Please try again',
                        confirmButtonColor: '#d33',
                    });
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
