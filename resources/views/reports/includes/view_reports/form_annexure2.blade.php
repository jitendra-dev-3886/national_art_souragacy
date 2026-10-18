 <h5 class="mb-4 text-primary">Q15. (Please give details on separate sheet as per Annexure -II)</h5>
 <table class="table table-bordered main-tables" id="datafiels2">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
            <th>Complaint forwarded by DHR/ other stakeholders/ suomoto cognizance</th>
            <th>Complaint filed by</th>
            <th>Complaint filed against (Name of the Clinic/bank/Person)</th>
            <th>Details of issues involved</th>
            <th>Details of Action taken (viz. inspection, search/seizure etc.)</th>
            <th colspan="2">Final outcome of the complaint viz. suspension/ cancellation of registration/ Others</th>
        </tr>
    </thead>
    <tbody>
     @php $j=1;  @endphp
    @if(isset($annexureResult['secondAnnexureResultQ15'])) 
        @foreach ($annexureResult['secondAnnexureResultQ15'] as $rowQ15 ) 
     <tr class="row-template @if($j==1) q15-row @endif">
        <td>{{$j}}</td>
        <td>{{isset($rowQ15['complaint_source'])? $rowQ15['complaint_source']:'' }}</td>
        <td>{{isset($rowQ15['filed_by'])? $rowQ15['filed_by']:'' }}</td>
        <td>{{isset($rowQ15['filed_against'])? $rowQ15['filed_against']:'' }}</td>
        <td>{{isset($rowQ15['issue_details'])? $rowQ15['issue_details']:'' }}</td>
        <td>{{isset($rowQ15['action_taken'])? $rowQ15['action_taken']:'' }}</td>
        <td>{{isset($rowQ15['outcome'])? $rowQ15['outcome']:'' }}</td>         
    </tr>
  @php $j++; @endphp 
        @endforeach
    @endif        
    </tbody>
</table>


