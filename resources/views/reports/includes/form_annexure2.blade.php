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
    @if(isset($secondAnnexureResultQ15)) 
        @foreach ($secondAnnexureResultQ15 as $rowQ15 )   

     <tr class="row-template @if($j==1) q15-row @endif">
        <td><input type="text" class="form-control sno" value="{{$j}}" readonly></td>
        <td><input type="text" name="complaint_source_q15[]" value="{{isset($rowQ15['complaint_source'])? $rowQ15['complaint_source']:'' }}" class="form-control complaint-source" ></td>
        <td><input type="text" name="filed_by_q15[]"  value="{{isset($rowQ15['filed_by'])? $rowQ15['filed_by']:'' }}" class="form-control filed-by" ></td>
        <td><input type="text" name="filed_against_q15[]"   value="{{isset($rowQ15['filed_against'])? $rowQ15['filed_against']:'' }}" class="form-control filed-against"></td>
        <td><input type="text" name="issue_details_q15[]"  value="{{isset($rowQ15['issue_details'])? $rowQ15['issue_details']:'' }}" class="form-control issue-details"> </td>
        <td><input type="text" name="action_taken_q15[]"  value="{{isset($rowQ15['action_taken'])? $rowQ15['action_taken']:'' }}" class="form-control action-taken" ></td>
        <td><input type="text" name="outcome_q15[]" value="{{isset($rowQ15['outcome'])? $rowQ15['outcome']:'' }}" class="form-control outcome" ></td>
        <td class="aligns">
        <span class="btn btn-danger btn-sm removeRow">X</span>
        </td>
    </tr>
  @php $j++; @endphp 
        @endforeach
    @endif
        <tr class="row-template  @if($j==1) q15-row @endif">
            <td><input type="text" class="form-control sno" value="{{$j}}" readonly></td>           
            <td><input type="text" name="complaint_source_q15[]" value="" class="form-control complaint-source" ></td>
            <td><input type="text" name="filed_by_q15[]"  value="" class="form-control filed-by" ></td>
            <td><input type="text" name="filed_against_q15[]" value="" class="form-control filed-against" ></td>
            <td><input type="text" name="issue_details_q15[]" value="" class="form-control issue-details" ></td>
            <td><input type="text" name="action_taken_q15[]"  value="" class="form-control action-taken" ></td>
            <td><input type="text" name="outcome_q15[]"   value="" class="form-control outcome" ></td>
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>
    </tbody>
</table>


