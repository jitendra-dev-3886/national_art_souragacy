@extends('layouts.noc.noc_master')
<style nonce="{{ $cspNonce }}">
    .bg-color-csp-noc_twentyone{
        background-color: #141481;
    }

    .margin-color-csp-noc_twentytwo{
        margin:13px;color: white;
    }
    .font-size-csp-noc-twentythree{
        font-size: 50px; color:#af0f0f;
    }
    .disply-justify-align-cspno-twentyfour{
        display: flex; justify-content: space-between; align-items: center;
    }
</style>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Display Front Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="bg-color-csp-noc_twentyone">
                        <div class="disply-justify-align-cspno-twentyfour">
                            <h4 class="margin-color-csp-noc_twentytwo">Application Number: {{ $view_attachment->application_no }}</h4>
                            <a href="{{url('noc/view_user_form/' .$cry_id. '/'.$cry_level_id)}}" class="button margin-color-csp-noc_twentytwo">Back</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <!-- Card Body Start for Front Attachments -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Front Attachment Document List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display">
                                      <thead>
                                        <tr>
                                            <th>ID</th>
                                            <!-- <th>Name</th> -->
                                            <th>File Description</th>
                                            <th>File Attachment</th>
                                            {{-- <th>Create Date</th> --}}
                                            <th>Uploaded Date</th>
                                        </tr>
                                    </thead>

                                       <tbody>
                                        @php
                                        $applicant = 'applicant/';
                                            $count = 1;
                                            $foldername = sanitizeFolderName($view_attachment->application_no);
                                            $registryPath = 'applicant/';
                                            $fullPath = folderpath('noc_application_blade') . $foldername . '/' . $applicant;
                                        @endphp
                                        @foreach ($getdata_front_attach as $user_get_ref)

                                        @php
                                        $filePath = $fullPath . $user_get_ref->doc_upload_ref;
                                        $encryptedPath = encrypt($filePath);
                                        @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <!-- <td>{{ $user_get_ref->name_applicant }}</td> -->
                                                    @if($user_get_ref->doc_id == 24 )
                                                    <td>{{ $user_get_ref->upload_desc }}</td>
                                                    @else
                                                    <td>{!! get_doc_file_name($user_get_ref->doc_id) !!}</td>
                                                    @endif
                                                    <td>
                                                        <a href="{{ route('view.file', ['path' => $encryptedPath]) }}"
                                                            target="_blank">
                                                            <i class="fa-solid fa-file-pdf fa-3x font-size-csp-noc-twentythree"></i>
                                                        </a>
                                                    </td>
                                                    {{-- <td>{{ \Carbon\Carbon::parse($user_get_ref->created_at)->format('d-m-Y') }}</td> --}}
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
