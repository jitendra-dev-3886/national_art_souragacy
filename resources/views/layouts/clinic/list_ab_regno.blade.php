@extends('layouts.main')

@section('content')
<div class="hold-transition skin-blue sidebar-mini">
    @include('header')

    <!-- Content Wrapper -->
    <div class="">
        <section class="content-header">
            <h3>
                @php $test = request()->get('category'); @endphp

                @if($test == 'ac') List of total received application for ART Clinic @endif
                @if($test == 'sc') List of total received application for Surrogacy Clinic @endif
                @if($test == 'ab') List of total received application for ART Bank @endif
                @if($test == 'ac_accept') List of issued registration number for ART Clinic @endif
                @if($test == 'sc_accept') List of issued registration number for Surrogacy Clinic @endif
                @if($test == 'ab_accept') List of issued registration number for ART Bank @endif
                @if($test == 'ac_reject') List of total Rejected application for ART Clinic @endif
                @if($test == 'sc_reject') List of total Rejected application for Surrogacy Clinic @endif
                @if($test == 'ab_reject') List of total Rejected application for ART Bank @endif
            </h3>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 container-fluid">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        @if(in_array($test, ['sc_accept','ac_accept'])) <th>Name of the Clinics</th> @endif
                                        @if($test == 'ab_accept') <th>Name of the Banks</th> @endif
                                        @if(in_array($test, ['sc_reject','ac_reject'])) <th>Name of the Clinics</th> @endif
                                        @if($test == 'ab_reject') <th>Name of the Banks</th> @endif
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>Email ID</th>
                                        @if(in_array($test, ['sc_accept','ac_accept','ab_accept']))
                                            <th>Registration No.</th>
                                        @elseif(in_array($test, ['sc_reject','ac_reject','ab_reject']))
                                            <th>Rejection Order No.</th>
                                        @endif
                                        @if(in_array($test, ['sc_accept','ac_accept','ab_accept']))
                                            <th>Download Certificate</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($results as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $row->clinicname }}</td>
                                            <td>{{ $row->address }}</td>
                                            <td>{{ $row->state }}</td>
                                            <td>{{ str_replace(['.','@'], ['[dot]','[at]'], $row->email) }}</td>

                                            @if(in_array($test, ['ac_reject','sc_reject','ab_reject']))
                                                <td>{{ $row->rejection_no ?? '' }}</td>
                                            @endif

                                            @if(in_array($test, ['ac_accept','sc_accept','ab_accept']))
                                                <td>{{ $row->registration_no }}</td>
                                                <td>
                                                    @if($test == 'ac_accept')
                                                        <a href="{{ url('/art_clinic_certificate/'.$row->reg_no_file) }}" target="_blank"><i class="fa fa-download"></i></a>
                                                    @elseif($test == 'sc_accept')
                                                        <a href="{{ url('/surrogacy_certificate/'.$row->reg_no_file) }}" target="_blank"><i class="fa fa-download"></i></a>
                                                    @elseif($test == 'ab_accept')
                                                        <a href="{{ url('/art_bank_certificate/'.$row->reg_no_file) }}" target="_blank"><i class="fa fa-download"></i></a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr><td colspan="14">No data Found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('footer')
</div>

{{-- DataTables --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        lengthChange: false
    });
});
</script>
@endpush
@endsection
