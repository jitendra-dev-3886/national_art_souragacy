@extends('layouts.noc.noc_master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Display Front Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12" style="background-color: #141481;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4 style="margin: 0;color: white;">Application Number: {{ $view_attachment->application_no }}</h4>
                            <a href="{{url('noc/view_user_form/' .$cry_id. '/'.$cry_level_id)}}" class="button" style="margin: 0;color: white;">Back</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Front Attachment Document List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display" style="min-width:845px">
                                      <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>File Description</th>
                                            <th>File Attachment</th>
                                            <th>Uploaded Date</th>
                                        </tr>
                                    </thead>

                                       <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($getdata_front_attach as $user_get_ref)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <!-- <td>{{ $user_get_ref->name_applicant }}</td> -->
                                                @if($user_get_ref->doc_id == 24 )
                                                <td>{{ $user_get_ref->upload_desc }}</td>
                                                @else
                                                <td>{!! get_doc_file_name($user_get_ref->doc_id) !!}</td>
                                                @endif
                                                <td>
                                                    <a href="{{ url($baseUrl.$user_get_ref->doc_upload_ref) }}"
                                                        target="_blank">
                                                        <i class="fa-solid fa-file-pdf fa-3x" style="font-size: 50px; color:#af0f0f;"></i>
                                                    </a>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($user_get_ref->updated_at)->format('d-m-Y H:i:s') }}</td>
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
