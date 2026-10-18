@extends('layouts.noc.noc_master')

@section('content')

<style nonce="{{$cspNonce}}">
    .csp-clinic-alert-blue {
        background-color: #141481;
        color: white;
        padding: 10px;
    }

    .csp-clinic-alert-blue h4 {
        margin: 0;
        color: white;
    }

    .csp-clinic-table {
        min-width: 845px;
    }

    .csp-clinic-table thead tr {
        border-top: 2px solid #000;
    }
   .flex-between-center-csp-clinic {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


</style>

<div class="container-fluid">
    <div class="row">
        <!-- Display Back Attachment Documents -->
        <div class="col-12">
            <div class="col-xs-12">
                <div class="alert alert-success col-xs-12 csp-clinic-alert-blue">
                    <div class="flex-between-center-csp-clinic">
                        <h4>Application Number: {{ $view_back_attachment->application_no }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>User Remarks List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="display csp-clinic-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Application No</th>
                                        <th>User Remarks Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($view_user_remarks as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name_applicant }}</td>
                                            <td>{{ $data->application_no }}</td>
                                            <td>{{ $data->remarks }}</td>
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
            $(tableId).DataTable({
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
