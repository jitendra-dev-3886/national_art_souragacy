<h5 class="mb-4 text-primary">Annexure-III (For Point 18 & 22 of the Format)</h5>
<table class="table table-bordered main-tables" id="datafiels5">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
            <th>Case filed by</th>
            <th>Case filed against (Name of the Clinic/bank/Persons)</th>
            <th>Section and Act, for violation of which cases were filed</th>
            <th>Details of issues involved</th>
            <th>No. of persons arrested</th>
            <th colspan="2">Final outcome of the cases</th>
        </tr>
    </thead>
    <tbody>
          @php $m=1; 
        // print_r($thirdAnnexureResultQ18);
         @endphp
        @if(isset($annexureResult['thirdAnnexureResultQ22'])) 
            @foreach ($annexureResult['thirdAnnexureResultQ22'] as $rowQ22 ) 
            <tr class="row-template @if($m==1) q22-row @endif">
                <td>{{$m}}</td>
                <td>{{isset($rowQ22['case_filed_by'])? $rowQ22['case_filed_by']:'' }}</td>
                <td>{{isset($rowQ22['case_filed_against'])? $rowQ22['case_filed_against']:'' }}</td>
                <td>{{isset($rowQ22['section_act_for_violation'])? $rowQ22['section_act_for_violation']:'' }}</td>
                <td>{{isset($rowQ22['issue_details'])? $rowQ22['issue_details']:'' }}</td>
                <td>{{isset($rowQ22['persons_arrested'])? $rowQ22['persons_arrested']:'' }}</td>
                <td>{{isset($rowQ22['case_outcome'])? $rowQ22['case_outcome']:'' }}</td>
            </tr>
            @php $m++; @endphp 
            @endforeach
        @endif          
    </tbody>
   
</table>
</div>
<div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">
    <h5 class="mb-4 text-primary">For and on behalf of State Government/ U.T. Administration</h5>
<table class="table table-bordered main-tables">
    <tr>
        <th>Name</th>
        <th>Designation</th>
        <th>Place</th>
        <th>Date</th>
    </tr>
    <tr>
        <td>{{isset($reportResult->applicant_name)? $reportResult->applicant_name:'' }} </td>
        <td>{{isset($reportResult->designation)? $reportResult->designation:'' }}</td>
        <td>{{isset($reportResult->place)? $reportResult->place:'' }}</td>
        <td>{{isset($reportResult->final_date)? date('Y-m-d',strtotime($reportResult->final_date)):'' }}</td>
    </tr>
</table>

<div class="col-md-12 align-items-left"> 
        <div class="d-flex justify-content-between align-items-center pt-3">
            <button type="button" class="btn btn-primary prev-step">Previous</button>             
        </div>
</div>