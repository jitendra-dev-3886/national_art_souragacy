@extends('layouts.noc.noc_master') 
@section('content')
<style nonce="{{ $cspNonce }}">
  .bg-color-csp-noc_twentyone{
        background-color: #141481;
    }

    .margin-color-csp-noc_twentytwo{
        margin:10px;color: white;
    }
    
    .disply-justify-align-cspno-twentyfour{
        display: flex; justify-content: space-between; align-items: center;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="col-xs-12">
                <div class="alert alert-success col-xs-12 bg-color-csp-noc_twentyone">
                    <div class="disply-justify-align-cspno-twentyfour">
                        <h4 class="margin-color-csp-noc_twentytwo">Application Number: {{ $view_back_attachment->application_no }}</h4>
                        <a href="{{url('noc/view_user_form/' .$cry_id. '/'.$cry_level_id)}}" class="button margin-color-csp-noc_twentytwo">Back</a>
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
                        <table id="example1" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name </th>
                                        <th>Application No</th>
                                        <th>Remarks </th>
                                        <th>Action Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $count = 1;
                                    @endphp
                                    @foreach ($view_user_remarks as $data)
                                    @php
                                        $app_no = $data->application_no;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        @if($data->noc_user == 1)
                                        <td>{{ $data->name_applicant }}</td>
                                        @else
                                        <td>{{ $data->First_name . ' ' . $data->Last_name }}</td>
                                        @endif
                                        <td>{{ app_no($id) }}</td>
                                        <td>{{ $data->remarks }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->action_date)->format('d-m-Y H:i:s') }}</td>
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
$(document).ready(function(){
        function initializeTable(tableId){
            if (!$.fn.dataTable.isDataTable(tableId)){
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
