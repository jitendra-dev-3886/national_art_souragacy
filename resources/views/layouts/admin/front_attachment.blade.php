@extends('layouts.admin.admin_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-applicant-number{
            display: flex; justify-content: space-between; align-items: center;
        }
        .csp-admin-message-heading{
            margin: 0;color: white;
        }
        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-table-cloumn{
            text-transform: lowercase;
        }
        .csp-admin-file-margin{
            margin-right: 5px;
        }
        .csp-admin-form-input{
            width: 300px; margin-bottom: 10px; margin-right: 10px; display: inline-block;
        }
        .csp-admin-form-button{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white; display: inline-block;
        }
    </style>


    <div class="container-fluid">
        <div class="row">
            <!-- Display Back Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12 csp-admin-message-div">
                        <div class="csp-admin-applicant-number">
                            <h4 class="csp-admin-message-heading">Application Number: {{ $view_attachment->application_no }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>List of Documents Uploaded by the Applicant</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display csp-admin-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            {{-- <th>Name <span style="text-transform: lowercase;">of</span> Applicant</th> --}}
                                            <th>Uploaded Documents</th>
                                            <th>View Documents<t>
                                            {{-- <th>Uploaded attachment </th> --}}
                                            {{-- <th>Create Date</th> --}}
                                            <th>Date of uploading</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                            $foldername = sanitizeFolderName($view_attachment->application_no);
                                            $applicant = 'applicant/';
                                            $fullPath = folderpath('noc_application_blade') . $foldername . '/' . $applicant;
                                        @endphp
                                        @foreach ($getbackdata as $user_get_ref)
                                        @php
                                            $filePath = $fullPath . $user_get_ref->doc_upload_ref;
                                            $encryptedPath = encrypt($filePath);
                                        @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user_get_ref->upload_desc  }}</td>
                                                <td>
                                                    <a href="{{ route('view.file', ['path' => $encryptedPath]) }}"
                                                        target="_blank">
                                                        <i class="fas fa-eye csp-admin-file-margin" ></i>
                                                    </a>
                                                </td>
                                                <td>{{ $user_get_ref->created_at }}</td>
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
