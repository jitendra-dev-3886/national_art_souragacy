
@extends('layouts.admin.admin_master')
@section('content')
<style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481;
        }
        .csp-admin-table{
            min-width: 845px;
        }
        .csp-admin-div-tt{
            display: flex; justify-content: space-between; align-items: center;
        }
        .csp-admin-app-h4{
            margin: 0;color: white;
        }

    </style>
    <div class="container-fluid">
        <div class="row">
            <!-- Display Back Attachment Documents -->
            <div class="col-12">
                <div class="col-xs-12">
                    <div class="alert alert-success col-xs-12 csp-admin-message-div">
                        <div class="csp-admin-div-tt">
                            <h4 class="csp-admin-app-h4">Application Number:
                                {{ $view_back_attachment->application_no }}</h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Remarks List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="display csp-admin-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Officer Name</th> 
                                            <th>Remarks</th>
                                            <th>Notings</th>
                                            <th>Action Date</th>
                                            {{-- <th>Action date</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($view_remarks as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                             
                                                  @if($data->noc_user == 1)
                                                  <td><Strong>{{ $data->name_applicant }}</strong></td>
                                                  @else
                                                  <td>{{ $data->First_name }} {{ $data->Last_name }}</td>
                                                  @endif
                                                <td>{{ $data->remarks }}</td>
                                                <td>{{ $data->notesheet }}</td>
                                                {{-- <td>{{ $data->submission_date }}</td> --}}
                                                <td>{{ $data->action_date }}
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
