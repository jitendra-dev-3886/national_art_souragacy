 <h5 class="mb-4 text-primary">Annexure-II (For  Point 15 & 16 of the Format)</h5>
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
       @php $k=1; 
 
       @endphp
    @if(isset($secondAnnexureResultQ16)) 
        @foreach ($secondAnnexureResultQ16 as $rowQ16 )   
     <tr class="row-template  @if($k==1) q16-row @endif">
        <td><input type="text" class="form-control sno" value="{{$k}}" readonly></td>
        <td><input type="text" name="complaint_source_q16[]" value="{{isset($rowQ16['complaint_source'])? $rowQ16['complaint_source']:'' }}" class="form-control complaint-source" ></td>
        <td><input type="text" name="filed_by_q16[]"  value="{{isset($rowQ16['filed_by'])? $rowQ16['filed_by']:'' }}" class="form-control filed-by" ></td>
        <td><input type="text" name="filed_against_q16[]"  id="" value="{{isset($rowQ16['filed_against'])? $rowQ16['filed_against']:'' }}" class="form-control filed-against" ></td>
        <td><input type="text" name="issue_details_q16[]"  id="" value="{{isset($rowQ16['issue_details'])? $rowQ16['issue_details']:'' }}" class="form-control issue-details" ></td>
        <td><input type="text" name="action_taken_q16[]"  id="" value="{{isset($rowQ16['action_taken'])? $rowQ16['action_taken']:'' }}" class="form-control action-taken" ></td>
        <td><input type="text" name="outcome_q16[]"  id="" value="{{isset($rowQ16['outcome'])? $rowQ16['outcome']:'' }}" class="form-control outcome" ></td>
        <td class="aligns">
        <span class="btn btn-danger btn-sm removeRow">X</span>
        </td>
    </tr>
  @php $k++; @endphp 
        @endforeach
    @endif
    <tr class="row-template @if($k==1) q16-row @endif">
        <td><input type="text" class="form-control sno" value="{{$k}}" readonly></td>
        <td><input type="text" name="complaint_source_q16[]" value="" class="form-control complaint-source" ></td>
        <td><input type="text" name="filed_by_q16[]"  value="" class="form-control filed-by" ></td>
        <td><input type="text" name="filed_against_q16[]"  id="" value="" class="form-control filed-against" ></td>
        <td><input type="text" name="issue_details_q16[]"  id="" value="" class="form-control issue-details" ></td>
        <td><input type="text" name="action_taken_q16[]"  id="" value="" class="form-control action-taken" ></td>
        <td><input type="text" name="outcome_q16[]"  id="" value="" class="form-control outcome" ></td>
        <td class="aligns">
        <span class="btn btn-danger btn-sm removeRow">X</span>
        </td>
    </tr>
    </tbody>
</table>