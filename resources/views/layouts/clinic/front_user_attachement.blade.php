@extends('layouts.noc.noc_master')

@section('content')
<style nonce="{{$cspNonce}}">
    .csp-clinic-bg-blue {
        background-color: #141481;
    }

    .csp-clinic-flex-space-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .csp-clinic-header-text {
        margin: 0;
        color: white;
    }

    .csp-clinic-table {
        min-width: 845px;
    }

    .csp-clinic-pdf-icon {
        font-size: 50px;
        color: #af0f0f;
    }
</style>


    <div class="container-fluid">
        <div class="row">
            <!-- Display Front Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                  
                    <div class="alert alert-success col-xs-12 csp-clinic-bg-blue">
                                                <div class="csp-clinic-flex-space-between">
                                                    <h4 class="csp-clinic-header-text">
                                                        Application Number: {{ $view_attachment->application_no }}
                                                    </h4>
                                                    


                                         

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
                               
                                <table id="example1" class="display csp-clinic-table">  
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Mobile No</th>
                                            <th>Email</th>
                                            <th>Front Attachment Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getdata_front_attach as $user_get_ref)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user_get_ref->user_name }}</td>
                                                <td>{{ $user_get_ref->mobileno }}</td>
                                                <td>{{ $user_get_ref->email }}</td>
                                                <td>
                                                    <a href="http://localhost/noc_documents/{{ $user_get_ref->doc_upload_ref }}"
                                                        target="_blank">
                                                    
                                                            <i class="fa-solid fa-file-pdf fa-3x csp-clinic-pdf-icon"></i>
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
