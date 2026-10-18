@extends('layouts.admin.admin_master')  
   <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content')
@php
$annexure='';
    if($type==1) {
    $annexure='Annexure I ';
     $annexureHeading='Annexure I (Compilation of all States)';
    }elseif($type==2){
    $annexure='Annexure II ';
     $annexureHeading='Annexure-II (Compilation of all States)';
    }elseif($type==3){
    $annexure='Annexure III ';
     $annexureHeading='Annexure-III (Compilation of all States)';
    }

@endphp

<div class="content-bodys">
    <div class="container-fluid" id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center border main-tital rounded-top-4">
                    <h3 class=" bc-color-csp-clinic-four">Consolidated Comprehensive Quarterly {{$annexure}} Report of the State/UT Appropriate Authority</h3>
                </div>     
            </div>                                    
            <form id="multi-step-form" name="quarterlyreportfrm"> 
                <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                    <div class="row">  
                       <div class="col-md-4">
                            <h5><span class="fw-bold">{{ $annexureHeading}}</h5>                                              
                        </div> 
                        <div class="col-md-2">
                            <h5><span class="fw-bold">Quarter: </span> {{ $quarter }}</h5>                                              
                        </div>
                        <div class="col-md-2">                          
                            <h5><span class="fw-bold">Year: </span> {{ $year }} </h5>                 
                        </div>  
                    </div>               
                  @if($type==1) 
                    <div class="col-md-12 text-end"> 
                        <span id="exportExcelBtnAnnexure1" class="btn btn-primary">Export to Excel</span>
                    </div> 
                    <table class="table table-bordered main-tables" id="annex1">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                  <th>State</th>
                                <th>Name of the Clinic/Bank</th>
                                <th>Operating since</th>
                                <th colspan="2">Action taken</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php $i=1;                             
                             @endphp
                         @if(count($queryAnnexure)>0) 
                            @if(isset($queryAnnexure)) 
                                @foreach ($queryAnnexure as $row )     
                                <tr class="row-template @if($i==1) q9-row @endif">
                                    <td>{{$i}}</td>
                                      <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                                    <td>{{isset($row->clinic_name)? $row->clinic_name:'Nill' }}</td>
                                    <td>{{isset($row->operating_since)? date("d-m-Y",strtotime($row->operating_since)):'Nill' }}</td>
                                    <td>{{isset($row->action_taken)? $row->action_taken:'Nill' }}</td>
                                </tr>      
                                @php $i++; @endphp 
                                @endforeach
                            @endif  
                           @else
                            <tr class="row-template @if($i==1) q9-row @endif">
                                <td>{{$i}}</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                            </tr> 
                            @endif  
                        </tbody>
                    </table>  
                  @endif 
                  @if($type==2) 
               
                    <div class="col-md-12 text-end"> 
                        <span id="exportExcelAnnexure2" class="btn btn-primary">Export to Excel</span>
                    </div>  
                    <table class="table table-bordered main-tables" id="annex2">
                        <thead class="table-light">
                            <tr>
                            <th>S.No</th>
                             <th>State</th>
                            <th>Complaint forwarded by DHR/ other stakeholders/ suomoto cognizance</th>
                            <th>Complaint filed by</th>
                            <th>Complaint filed against (Name of the Clinic/bank/Person)</th>
                            <th>Details of issues involved</th>
                            <th>Details of Action taken (viz. inspection, search/seizure etc.)</th>
                            <th>Final outcome of the complaint viz. suspension/ cancellation of registration/ Others</th>
                            </tr>
                        </thead>
                       
                        <tbody>
                             @php $i=1;                             
                             @endphp
                         @if(count($queryAnnexure)>0) 
                            @if(isset($queryAnnexure)) 
                                @foreach ($queryAnnexure as $row )     
                                <tr class="row-template @if($i==1) q9-row @endif">
                                    <td>{{$i}}</td>
                                    <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                                    <td>{{isset($row->complaint_source)? $row->complaint_source:'Nill' }}</td>
                                    <td>{{isset($row->filed_by)? $row->filed_by:'Nill' }}</td>
                                    <td>{{isset($row->filed_against)? $row->filed_against:'Nill' }}</td>
                                    <td>{{isset($row->issue_details)? $row->issue_details:'Nill' }}</td>                                    
                                    <td>{{isset($row->outcome)? $row->outcome:'Nill' }}</td>
                                    <td>{{isset($row->action_taken)? $row->action_taken:'Nill' }}</td>
                                </tr>      
                                @php $i++; @endphp 
                                @endforeach
                            @endif  
                           @else
                            <tr class="row-template @if($i==1) q9-row @endif">
                                <td>{{$i}}</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                            </tr> 
                            @endif  
                        </tbody>
                    </table>
                  @endif  
                  @if($type==3)
                    <div class="col-md-12 text-end"> 
                        <span id="exportExcelBtnAnnexure3" class="btn btn-primary">Export to Excel</span>
                    </div>  
                    <table class="table table-bordered main-tables" id="annex3">
                        <thead class="table-light">
                        <tr>
                        <th>S.No</th>
                         <th>State</th>
                        <th>Case filed by</th>
                        <th>Case filed against (Name of the Clinic/bank/Persons)</th>
                        <th>Section and Act, for violation of which cases were filed</th>
                        <th>Details of issues involved</th>
                        <th>No. of persons arrested</th>
                        <th>Final outcome of the cases</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                             @php $i=1;  @endphp
                        @if(count($queryAnnexure)>0) 
                            @if(isset($queryAnnexure)) 
                                @foreach ($queryAnnexure as $row )     
                                <tr class="row-template @if($i==1) q9-row @endif">
                                    <td>{{$i}}</td>
                                    <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                                    <td>{{isset($row->case_filed_by)? $row->case_filed_by:'Nill' }}</td>
                                    <td>{{isset($row->case_filed_against)? $row->case_filed_against:'Nill' }}</td>
                                    <td>{{isset($row->section_act_for_violation)? $row->section_act_for_violation:'Nill' }}</td>
                                    <td>{{isset($row->issue_details)? $row->issue_details:'Nill' }}</td>                                    
                                    <td>{{isset($row->persons_arrested)? $row->persons_arrested:'Nill' }}</td>
                                    <td>{{isset($row->case_outcome)? $row->case_outcome:'Nill' }}</td>
                                </tr>      
                                @php $i++; @endphp 
                                @endforeach
                            @endif  
                           @else
                            <tr class="row-template @if($i==1) q9-row @endif">
                                <td>{{$i}}</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                                <td>Nill</td>
                            </tr> 
                            @endif
                    </table>
                   @endif 
                </div> 
            </form>     
        </div>
    </div>
</div> 
 
<script nonce="{{ $cspNonce }}" src="{{url('public/js/xlsx.full.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">    

    $(document).ready(function () {
    // Annexure I
    $('#exportExcelBtnAnnexure1').on('click', function () {   
        var table = document.getElementById('annex1');
        if (!table) {
            console.error('Table annex1 not found');
            return;
        }
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Quarterly Report Annexure I"
        });

        XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_I.xlsx');
    });

    // Annexure II
    $('#exportExcelAnnexure2').on('click', function () {
        var table = document.getElementById('annex2');
        if (!table) {
            console.error('Table annex2 not found');
            return;
        }
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Quarterly Report Annexure II"
        });
        XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_II.xlsx');
    });

    // Annexure III
    $('#exportExcelBtnAnnexure3').on('click', function () {
        var table = document.getElementById('annex3');
        if (!table) {
            console.error('Table annex3 not found');
            return;
        }
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Quarterly Report Annexure III"
        });
        XLSX.writeFile(wb, 'Quarterly_Reports_Annexure_III.xlsx');
    });

});
</script> 
 
@endsection
