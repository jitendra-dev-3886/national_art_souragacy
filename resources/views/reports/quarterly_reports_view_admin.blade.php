@extends('layouts.admin.admin_master')
   <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content') 
<div class="container-fluid">     			
    <div class="row card"  >
        <div class="col-lg-12">
            <form action="" method="post" name="frmfilter" id="frmfilter">
                     @csrf
                     <input type="hidden" name="flagid" value="1">
                    <div class="row">
                        <h3 class=" bc-color-csp-clinic-four">Quarterly report of the State / UT Appropriate Authority
                        </h3>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select State</strong><span class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                          <select name="state" id="state" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select State</option>
                                                @foreach($state as $stateRow)  
                                                    <option value="{{ $stateRow->state_id }}">{{ $stateRow->state_name}}</option>
                                                @endforeach                                                                                
                                            </select>
                                        <!-- Error Message Container -->
                                        <span id="msgyear" class="text-danger"></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Year</strong><span class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                        <select name="year" id="year" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select year</option>
                                            @for ($i = 2022; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor                                                                                
                                        </select>
                                        <!-- Error Message Container -->
                                        <span id="msgyear" class="text-danger"></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Period</strong><span class="color-red-fourtyseven">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                        <select name="quarter" id="quarter" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select Quarter</option>
                                                @foreach($quarters as $qtrRow)  
                                                    <option value="{{ $qtrRow->quarter }}">{{ $qtrRow->description}}</option>
                                                @endforeach                                                                                
                                            </select>
                                            <!-- Error Message Container -->
                                            <span id="msgqtr" class="text-danger"></span> 
                                    </div> 
                                </div>
                            </div>
                        </div>            						
                        <div class="col-md-1">
                            <div class="mb-2 pt-2">
                            <span>&nbsp; &nbsp;<a class="link btn btn-primary csp-clinic-btn-blue" id="submitfilter">Submit</a></span>							 
                            </div>
                        </div>                  
                    </div>
                </form>
        </div>
    
       
        <div class="table-responsive">
            <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                    <tr> 
                        <th class="text-center">S.No.</th>  
                        <th class="text-center">Quarter</th> 
                        <th class="text-center">Year</th>     
                         <th class="text-center">State</th>                                                  
                        <th  class="text-center">Report status </th>                                                    
                        <th class="text-center">Final Submission Date</th>
                        <th class="text-center">Action</th>
                    </tr>  
                
                </thead>
                <tbody id="report-result">                    
                    @php $sn = 1;  @endphp
                    @if($reportResult)
                        @foreach($reportResult As $reportRow)
                            <tr  class="text-center">
                                <td class="text-center">{{$sn++}} <span class='btn-outline-success'></span></td>   
                                <td>{{$reportRow['quarter_name'] ?? ''}}</td>  
                                <td class="text-center">{{$reportRow['year'] ?? ''}}</td>
                                <td class="text-center">{{$reportRow['state_name'] ?? ''}}</td>
                                <td> @if($reportRow['status'] == 1)  <span class="text-success">Final Submit</span>
                                    @else
                                    <span class="text-danger">Save As Draft</span>
                                    @endif                                       
                                <td>{{ !empty($reportRow['final_date']) ? date('d/m/Y', strtotime($reportRow['final_date'])) : '-' }}</td>
                                    <td> @if($reportRow['status'] == 1)                                         
                                     <a href="{{route('report.QuarterlyreportviewAdmin', ['report_id'=> Crypt::encryptString($reportRow['report_id'])])}}" class="btn btn-sm btn-primary text-white" aria-disabled="true"><i class="bi bi-file-text me-1"></i> View Report</a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-secondary" href="{{route('report.QuarterlyreportPdf',['report_id'=>Crypt::encryptString($reportRow['report_id'])])}}" target="_blank"><i class="bi bi-file-arrow-down"></i> Export in PDF</a>
                                    @else
                                    <span>N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">Data not found.</td>
                        </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.umd.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/jspdf.plugin.autotable.min.js')}}"></script>
<script nonce="{{ $cspNonce }}" src="{{url('public/js/xlsx.full.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
    
    //Code For pageing, searching and shorting code
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
        initializeTable('#usersTable');
    });
     //Code for filter
    $(document).ready(function(){
      
        $("#submitfilter").click(function() {                   
            $.ajax({
                    url: "{{ route('report.quarterlyreportFilter') }}",
                    method: "POST",                 
                    data: $("#frmfilter").serialize(),
                    beforeSend: function(){
                        $('#report-result').html('<div class="text-center p-3"><b>Loading Report...</b></div>');
                    },
                    success: function(response) {   
                        $('#report-result').empty();
                        if ($.fn.DataTable.isDataTable('#usersTable')) {
                            $('#usersTable').DataTable().clear().destroy();
                        }
                            $.each(response.reportResult, function(index, form) {
                            let viewUrl = "{{ route('report.QuarterlyreportviewAdmin', ['report_id' => ':id']) }}";
                            let pdfUrl  = "{{ route('report.QuarterlyreportPdf', ['report_id' => ':id']) }}";

                            let actionColumn = form.status == 1
                                ? `
                                    <a href="${viewUrl.replace(':id', form.report_id)}" 
                                    class="btn btn-sm btn-primary text-white">
                                     <i class="bi bi-file-text me-1"></i>   View Report
                                    </a> &nbsp;&nbsp;&nbsp;
                                    <a href="${pdfUrl.replace(':id', form.report_id)}" 
                                    class="btn btn-sm btn-secondary" 
                                    target="_blank">
                                      <i class="bi bi-file-arrow-down"></i> Export in PDF
                                    </a>
                                `
                                : '<span>N/A</span>';                               

                            let reportstatus = form.status == 1
                            ? `<span class="text-success">Final Submit</span>` 
                            : `<span class="text-danger">Save As Draft</span>`;
                                let formattedDate = form.final_date ? new Date(form.final_date).toLocaleDateString('en-GB') // Converts to DD/MM/YYYY
                                    : 'N/A';
                                let row = `<tr class="text-center">
                                <td class="text-center">${index + 1}</td>  
                                 <td class="text-center">${form.quarter_name ?? 'N/A'}</td> 
                                   <td class="text-center">${form.year ?? 'N/A'}</td>     
                                 <td class="text-center">${form.state_name ?? 'N/A'}</td>
                                <td>${reportstatus}</td>
                                <td>${formattedDate}</td> 
                                <td class="text-center">${actionColumn}</td>                                    
                            </tr>`; // Encrypt in controller
                            $('#report-result').append(row);
                            })
                        
                        $('#usersTable').DataTable({
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            responsive: true,
                            scrollX: true,
                            destroy: true 
                        });
                    }
            });            
        });
    });
</script>
@endsection
