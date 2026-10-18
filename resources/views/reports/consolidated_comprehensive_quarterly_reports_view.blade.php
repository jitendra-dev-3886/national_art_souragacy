@extends('layouts.admin.admin_master')  
 <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content') 
  @php   
            $states = $statesInfo->groupBy('stateid')->map(function ($items) {
                return [
                    'state_name' => $items->first()->state_name,
                    'data' => $items->values()
                ];
            });
            
        @endphp 
<div class="content-bodys">
    <div class="container-fluid" id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center border main-tital rounded-top-4">
                    <h2 class="text-dark">Consolidated Comprehensive Quarterly report of the State / UT Appropriate Authority
                    </h2>
                </div>     
            </div>   
            <?php // echo "<pre>";print_r($reportInfo);echo "</pre>";?>                       
            <form id="multi-step-form" name="quarterlyreportfrm">
                <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-5 shadow-sm">
                    <div class="row">
                                           
                          <div class="col-md-6">
                           <h5><span class="fw-bold">Name Of State / Union Territory: </span> {{ $reportInfo['stateName']}}</h5>                      
                        </div>
                        <div class="col-md-2">
                            <h5><span class="fw-bold">Quarter: </span> {{ $reportInfo['quarterName'] }}</h5>                                              
                        </div>
                        <div class="col-md-2">                          
                            <h5><span class="fw-bold">Year: </span> {{ $reportInfo['yearPost'] }} </h5>                 
                        </div>                     
                        <div class="col-md-2 text-end"> 
                          <a class="btn btn-secondary" href="{{route('report.ConsolidatedQuarterlyReport') }}" ><< Back </a>
                       </div> 
                        <div class="col-md-4 text-start"> 
                             <h5><span class="fw-bold">Quarterly Report submitted by States/UTs: </span> <a href="#" data-bs-toggle="modal" data-bs-target="#uptoQuarterMeeting" class="text-decoration-underline btn-red">No. of State: <span class="fw-bold"> {{ $reportResult->total_state }}</span> </a></h5>  
                       </div> 
                
                        <div class="col-md-4"> 
                          <h5><span class="fw-bold">Quarterly Report not submitted:  </span> <a href="#" data-bs-toggle="modal" data-bs-target="#reportNotSubmitted" class="text-decoration-underline btn-red">No. of State: <span class="fw-bold"> {{ count( $states) }}</span> </a></h5>  
                       </div>                       
                    </div>                             
                </div> 
                <div class="rounded-4">                     
                    <div class="step step-1">   
                                                     
                        <div class="border p-2 p-lg-4 rounded-3 bg-white mb-4 shadow-sm table-responsive">
                            
                            @if($reportInfo['reportData']==1)
                             @include('reports.includes.view_reports.consolidated_quarterly_report')
                             @else
                            <h5> No Record found!   </h5> 
                             @endif
                        </div>
                    </div>                  
                </div> 
            </form>     
        </div>
    </div>
</div>
<!--Quarterly Report submitted by States/UTs -->
<div class="modal fade" id="uptoQuarterMeeting" tabindex="-1" aria-labelledby="uptoQuarterMeetingLabel" aria-hidden="true">
  <div class="modal-dialog  modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="uptoQuarterMeetingLabel">Quarterly Report submitted by States/UTs:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       {!! $reportResult->meeting_state_list !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>       
      </div>
    </div>
  </div>
</div>

<!--Quarterly Report not submitted: -->
<div class="modal fade" id="reportNotSubmitted" tabindex="-1" aria-labelledby="reportNotSubmittedLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="reportNotSubmittedLabel">Quarterly Report not submitted:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      
        <table class="table table-bordered">
            <thead class="table-secondary">
                <tr>
                    <th>State</th>
                    <th class="text-start">Email  </th>
                </tr>
            </thead>
            <tbody>
                @foreach($states as $stateId => $state)
                    <tr>
                        <td>{{$state['state_name']}}</td>
                        <td><table>
                                @foreach($state['data'] as $user)
                                <tr>
                                    <td class="text-start">{{ $user->email }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>       
      </div>
    </div>
  </div>
</div> 
<script nonce="{{ $cspNonce }}" src="{{url('public/js/xlsx.full.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
     $(document).ready(function(){
        // Excel Export Quarterly Reports
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('usersTable'), {sheet: "Quarterly Report"});
            XLSX.writeFile(wb, 'Quarterly_Reports.xlsx');
        });  
         // Excel Export Quarterly Reports Annexure I    
       document.getElementById('exportExcelBtnAnnexureI').addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('usersTableAnnex1'), {sheet: "Quarterly Report Annexure I"});
            XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_I.xlsx');
        });
         // Excel Export Quarterly Reports Annexure II   
        document.getElementById('exportExcelBtnAnnexureII').addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('usersTableAnnex2'), {sheet: "Quarterly Report Annexure II"});
            XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_II.xlsx');
        });
        // Excel Export Quarterly Reports Annexure III
        document.getElementById('exportExcelBtnAnnexureIII').addEventListener('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('usersTableAnnex3'), {sheet: "Quarterly Report Annexure III"});
            XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_III.xlsx');
        })         
    })
</script> 
 
@endsection
