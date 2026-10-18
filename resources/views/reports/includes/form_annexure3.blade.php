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
         @php $l=1; 
        // print_r($thirdAnnexureResultQ18);
         @endphp
    @if(isset($thirdAnnexureResultQ18)) 
        @foreach ($thirdAnnexureResultQ18 as $rowQ18 ) 
         <tr class="row-template @if($l==1) q18-row @endif"">
            <td><input type="text" class="form-control sno" value="{{$l}}" readonly></td>
            <td><input type="text" name="case_filed_by_q18[]"  value="{{isset($rowQ18['case_filed_by'])? $rowQ18['case_filed_by']:'' }}" class="form-control case-filed-by" ></td>
            <td><input type="text" name="case_filed_against_q18[]" value="{{isset($rowQ18['case_filed_against'])? $rowQ18['case_filed_against']:'' }}" class="form-control case-filed-against" ></td>
            <td><input type="text" name="section_act_for_violation_q18[]" value="{{isset($rowQ18['section_act_for_violation'])? $rowQ18['section_act_for_violation']:'' }}" class="form-control section-act-for-violation" ></td>
            <td><input type="text" name="issue_details_q18[]" value="{{isset($rowQ18['issue_details'])? $rowQ18['issue_details']:'' }}" class="form-control issue-details" ></td>
            <td><input type="text" name="persons_arrested_q18[]" value="{{isset($rowQ18['persons_arrested'])? $rowQ18['persons_arrested']:''   }}" class="form-control persons-arrested" ></td>
            <td><input type="text" name="case_outcome_q18[]" value="{{isset($rowQ18['case_outcome'])? $rowQ18['case_outcome']:''   }}" class="form-control case-outcome" ></td>
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>
          @php $l++; @endphp 
        @endforeach
    @endif  

        <tr class="row-template  @if($l==1) q18-row @endif">
            <td><input type="text" class="form-control sno" value="{{$l}}" readonly></td>
            <td><input type="text" name="case_filed_by_q18[]"  value="" class="form-control case-filed-by" ></td>
            <td><input type="text" name="case_filed_against_q18[]" value="" class="form-control case-filed-against" ></td>
            <td><input type="text" name="section_act_for_violation_q18[]" value="" class="form-control section-act-for-violation" ></td>
            <td><input type="text" name="issue_details_q18[]" value="" class="form-control issue-details" ></td>
            <td><input type="text" name="persons_arrested_q18[]" value="" class="form-control persons-arrested" ></td>
            <td><input type="text" name="case_outcome_q18[]" value="" class="form-control case-outcome" ></td>
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>
    </tbody>
</table>