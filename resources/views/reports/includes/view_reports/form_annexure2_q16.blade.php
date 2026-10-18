 <h5 class="mb-4 text-primary">Annexure-II (For Point 15 & 16 of the Format)</h5>
 <table class="table table-bordered main-tables" id="datafiels3">
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
       @php $k=1;  @endphp
    @if(isset($annexureResult['secondAnnexureResultQ16'])) 
        @foreach ($annexureResult['secondAnnexureResultQ16'] as $rowQ16 )   
     <tr class="row-template  @if($k==1) q16-row @endif">
        <td>{{$k}}</td>
        <td>{{isset($rowQ16['complaint_source'])? $rowQ16['complaint_source']:'' }}</td>
        <td>{{isset($rowQ16['filed_by'])? $rowQ16['filed_by']:'' }}</td>
        <td>{{isset($rowQ16['filed_against'])? $rowQ16['filed_against']:'' }}</td>
        <td>{{isset($rowQ16['issue_details'])? $rowQ16['issue_details']:'' }}</td>
        <td>{{isset($rowQ16['action_taken'])? $rowQ16['action_taken']:'' }}</td>
        <td>{{isset($rowQ16['outcome'])? $rowQ16['outcome']:'' }}</td>
    </tr>
  @php $k++; @endphp 
        @endforeach
    @endif
    
    </tbody>
</table>