@extends('layouts.main')
@section('content')       
<section class="py-5">
    <div class="container-fluid m-2">
        <div class="row">
            <h3 class="text-center">
                List of 
                    {{ str_contains($clinic_type, 'reject') ? 'Rejected' : 'Registered' }} {{ str_contains($clinic_type, 'surrogacy') ? 'Surrogacy Clinic' : (str_contains($clinic_type, 'bank') ? 'ART Bank' : 'ART Clinic') }} Application
            </h3>
        </div>
        <div class="row">
            <table id="clinicRejection" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name of the Clinics</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>Email ID</th>
                        <th>Application No.</th>
                        {{-- <th>Download Certificate</th> --}}
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</section>
<script nonce="{{ $cspNonce }}"> 
    $(document).ready(function () {

        $('#clinicRejection').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 20,
            ordering: true,
            searching: true,
            dom:
                "<'row mb-2'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-2'<'col-sm-5'i><'col-sm-7 d-flex justify-content-end'p>>",
            ajax: {
                url: "{{ route('clinic.list') }}",
                type: "GET",
                data: function (d) {
                    d.type = "{{ request('type') }}";
                }
            },

            columns: [
                { data: 'null',
                    render: (data, type, row, meta) => meta.row + 1 + meta.settings._iDisplayStart
                 },
                { data: 'clinicname' },
                { data: 'address' },
                { data: 'state' },
                { data: 'email',
                    render: function (data) {
                        return data
                            ? data.replace(/\./g, '[dot]').replace(/@/g, '[at]')
                            : '';
                    }
            },
                { data: 'applicationno' }
            ]
        });

    });
    </script>
@endsection
        


   
