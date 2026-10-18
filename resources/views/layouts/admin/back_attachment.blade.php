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
    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Display Back Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12 csp-admin-message-div">
                        <div class="csp-admin-applicant-number">
                            <h4 class="csp-admin-message-heading">Application Number: {{ $view_back_attachment->application_no }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <!-- Card Body Start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>List of Uploaded Documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display csp-admin-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Officer Name</th>
                                            <th>Uploaded Documents</th>
                                            <th>View Documents</th>
                                            <th>Date <span class="csp-admin-table-cloumn">of</span> uploading</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                            $foldername = sanitizeFolderName($view_back_attachment->application_no);
                                            $registryPath = 'registry/';
                                            $fullPath = folderpath('noc_application_blade') . $foldername . '/' . $registryPath;
                                            
                                        @endphp
                                        @foreach ($getbackdata as $user_get_ref)
                                        @php
                                            $filePath = $fullPath . $user_get_ref->doc_upload_ref;
                                            $encryptedPath = encrypt($filePath);
                                        @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user_get_ref->First_name .' ' .$user_get_ref->Last_name }}</td>
                                                <td>{{ $user_get_ref->upload_desc }}</td>
                                                <td><a href="{{ route('view.file', ['path' => $encryptedPath]) }}" target="_blank"><i class="fas fa-eye csp-admin-file-margin"></i>
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
                    <!-- Card Body End -->
                </div>
            </div>
        </div>

        <!-- Back Attachment Upload Form -->
        <!-- <div class="col-md-12"> -->
        <!-- Card Component Start -->
        <!-- <div class="card">
                <div class="card-header">
                    <h5>Upload Back Attachment File</h5>
                </div>
                <div class="card-body">
                @if (session('success'))
    <div class="alert alert-success">
                          <P style="color:black;">  {{ session('success') }}</P>
                        </div>
    @endif
                    @if (session('error'))
    <div class="alert alert-danger">
                          <P style="color:black;">  {{ session('error') }}</P>
                        </div>
    @endif
                <form action="{{ route('back_attach') }}" method="POST" enctype="multipart/form-data">
                   @csrf
               

                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Title & description</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" id="inputEmail" name="description" placeholder="Enter your email" required rows="4"
                            cols="50"></textarea>

                        </div>
                    </div>
                     <br>
                    <div class="form-group row">
                        <label for="inputFile" class="col-sm-2 col-form-label">Back Attachement Upload File</label>
                        <div class="col-sm-4">
                        <input type="file" class="form-control" id="inputFile" name="file" accept=".pdf" required>
                        </div>
                    </div>

                    <button type="submit" style="margin-left: 625px;margin-top: 19px;background-color: #141481; border-color:#141481;" name="submit" value="submit" class="btn btn-success">Upload</button>
                    </form>

                </div>
            </div> -->
        <!-- Card Component End -->
        <!-- </div> -->
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
