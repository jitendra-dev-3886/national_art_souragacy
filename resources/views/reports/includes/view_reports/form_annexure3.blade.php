<h5 class="mb-4 text-primary">Q18. (please give details on separate sheet as per Annexure-III)</h5>
<table class="table table-bordered main-tables" id="datafiels4">
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
         @php $l=1;  @endphp
    @if(isset($annexureResult['thirdAnnexureResultQ18'])) 
        @foreach ($annexureResult['thirdAnnexureResultQ18'] as $rowQ18 ) 
            <tr class="row-template @if($l==1) q18-row @endif">
                <td>{{$l}}</td>
                <td>{{isset($rowQ18['case_filed_by'])? $rowQ18['case_filed_by']:'' }}</td>
                <td>{{isset($rowQ18['case_filed_against'])? $rowQ18['case_filed_against']:'' }}</td>
                <td>{{isset($rowQ18['section_act_for_violation'])? $rowQ18['section_act_for_violation']:'' }}</td>
                <td>{{isset($rowQ18['issue_details'])? $rowQ18['issue_details']:'' }}</td>
                <td>{{isset($rowQ18['persons_arrested'])? $rowQ18['persons_arrested']:''   }}</td>
                <td>{{isset($rowQ18['case_outcome'])? $rowQ18['case_outcome']:''   }}</td>
            </tr>
          @php $l++; @endphp 
        @endforeach
    @endif  
    </tbody>
</table>