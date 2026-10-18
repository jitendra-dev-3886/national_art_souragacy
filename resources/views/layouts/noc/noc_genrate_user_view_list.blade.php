@extends('layouts.noc.noc_master')
@section('content')
<style nonce="{{ $cspNonce }}">
.btn-info {
  --bs-btn-color: #000;
  --bs-btn-bg: #020471;
  --bs-btn-border-color: #535BD6;
  --bs-btn-hover-color: #000;
  --bs-btn-hover-bg: #020471;
  --bs-btn-hover-border-color: #020471;
  --bs-btn-focus-shadow-rgb: 182, 71, 164;
  --bs-btn-active-color: #000;
  --bs-btn-active-bg: #020471;
  --bs-btn-active-border-color: #020471;
  --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
  --bs-btn-disabled-color: #000;
  --bs-btn-disabled-bg: #020471;
  --bs-btn-disabled-border-color: #020471;
}
.bc-border-csp-noc-thirtytwo{
    background-color:141481;border-color: 141481;
}
.min-width-thirtythree{
    min-width: 845px;
}
.text-transform-thirtythree{
    text-transform: lowercase;
}
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List <span class="text-transform-thirtythree">of</span> Noc</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="display min-width-thirtythree">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>S.No</th>
                                        <th>Application No</th>
                                        <th>Receiving Date</th>
                                        <th>Name <span class="text-transform-thirtythree">of</span> Applicant</th>
                                        <th>Email ID</th>
                                        <th>Address</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($userdata as $data)
                               
                                    @php
                                    //   dd($data);
                                        $foldername = sanitizeFolderName($data->application_no);
                                        $registry = 'registry/';
                                        $filePath = $foldername . '/' . $registry . $data->path;
                                        $encryptedPath = encrypt($filePath);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->application_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $data->name_applicant }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->address }}</td>
                                        <td>{{ $data->state }}</td>
                                        <td>{{ $data->district }}</td>
                                        <td>
                                            <a href="{{ route('view.file', ['path' => $encryptedPath]) }}"  
                                            class="btn btn-info bc-border-csp-noc-thirtytwo">
                                                Download NOC
                                            </a>
                                        </td>
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

<script nonce="{{ $cspNonce }}">
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
   
    });

</script>
@endsection
