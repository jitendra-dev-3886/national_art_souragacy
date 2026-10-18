<h5 class="mb-4 text-primary">Annexure-III (For  Point 18 & 22 of the Format)</h5>
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
    @if(isset($thirdAnnexureResultQ22)) 
        @foreach ($thirdAnnexureResultQ22 as $rowQ22 ) 
        <tr class="row-template @if($m==1) q22-row @endif">
            <td><input type="text" class="form-control sno" value="{{$m}}" readonly></td>
            <td><input type="text" name="case_filed_by_q22[]"  value="{{isset($rowQ22['case_filed_by'])? $rowQ22['case_filed_by']:'' }}" class="form-control case-filed-by" ></td>
            <td><input type="text" name="case_filed_against_q22[]" value="{{isset($rowQ22['case_filed_against'])? $rowQ22['case_filed_against']:'' }}" class="form-control case-filed-against" ></td>
            <td><input type="text" name="section_act_for_violation_q22[]" value="{{isset($rowQ22['section_act_for_violation'])? $rowQ22['section_act_for_violation']:'' }}" class="form-control section-act-for-violation" ></td>
            <td><input type="text" name="issue_details_q22[]" value="{{isset($rowQ22['issue_details'])? $rowQ22['issue_details']:'' }}" class="form-control issue-details" ></td>
            <td><input type="number" name="persons_arrested_q22[]" value="{{isset($rowQ22['persons_arrested'])? $rowQ22['persons_arrested']:'' }}" class="form-control persons-arrested" ></td>
            <td><input type="text" name="case_outcome_q22[]" value="{{isset($rowQ22['case_outcome'])? $rowQ22['case_outcome']:'' }}" class="form-control case-outcome" ></td>
            <td class="aligns">
            <button class="btn btn-danger btn-sm removeRow">X</button>
            </td>
        </tr>
         @php $m++; @endphp 
        @endforeach
    @endif  

 
        <tr class="row-template @if($m==1) q22-row @endif">
            <td><input type="text" class="form-control sno" value="{{$m}}" readonly></td>
            <td><input type="text" name="case_filed_by_q22[]"  value="" class="form-control case-filed-by" ></td>
            <td><input type="text" name="case_filed_against_q22[]" value="" class="form-control case-filed-against" ></td>
            <td><input type="text" name="section_act_for_violation_q22[]" value="" class="form-control section-act-for-violation" ></td>
            <td><input type="text" name="issue_details_q22[]" value="" class="form-control issue-details" ></td>
            <td><input type="text" name="persons_arrested_q22[]" value="" class="form-control persons-arrested" ></td>
            <td><input type="text" name="case_outcome_q22[]" value="" class="form-control case-outcome" ></td>
            <td class="aligns">
            <span class="btn btn-danger btn-sm removeRow">X</span>
            </td>
        </tr>
    </tbody>
   
</table>

<div class="text-end row align-items-center pe-4">
    <div class="col-md-6 text-start">
        <p class="text-danger small q22_annx mb-0"> Please fill all fields in the first row of Annexure-III Question 18 and 22. If you have no data, enter “NIL” .</p>
    </div>
    <div class="col-md-6">
       <span class="btn btn-success btn-sm mt-2 addRowBtn"  data-table="datafiels5">+</span>
    </div>
</div>
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
        <td>   <input type="text" name="applicant_name" id="applicant_name" class="form-control" value="{{isset($reportResult->applicant_name)? $reportResult->applicant_name:'' }}">
            <span id="msgapplicant_name" class="text-danger"></span> </td>
        <td> <input type="text" name="designation" id="designation" class="form-control" value="{{isset($reportResult->designation)? $reportResult->designation:'' }}">
                                    
            <span id="msgdesignation" class="text-danger"></span> </td>
        <td><input type="text" name="place" id="place" class="form-control" value="{{isset($reportResult->place)? $reportResult->place:'' }}">
            <span id="msgplace" class="text-danger"></span> </td>
        <td>

            <input type="text" class="form-control" value="{{ date('Y-m-d') }}"  disabled>
             <input type="hidden" class="form-control" value="{{isset($reportResult->ip_address)? $reportResult->ip_address: request()->ip() }}" readonly="">

        </td>
    </tr>
</table>
<div class="col-md-12 align-items-left">                
    {{-- <b> <input type="checkbox" id="declaration" name="declaration">I hereby declare that the entries in this form and the additional
    particulars , if any,furnished herewith are true to the best of my
    knowledge and belief.<span
    class="color-red-fourtyseven">*</span> </b> --}}
     <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="declaration" name="declaration">
        <label class="form-check-label" for="declaration">I hereby declare that the entries in this form and the additional
    particulars , if any,furnished herewith are true to the best of my
    knowledge and belief.<span
    class="text-danger">*</span></label>
    </div>
    @if ($errors->has('declaration'))
    <div class="color-red-fourtyseven">
    <strong>{{ $errors->first('declaration') }}</strong>
        
    </div>
    @endif
        <div id="msgdeclarationr" class="text-danger"></div>
        <div class="d-flex justify-content-between align-items-center pt-3">
            <button type="button" class="btn btn-primary prev-step">Previous</button>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success" id="draftBtn">Save as Draft</button>
                <button type="submit" class="btn btn-success" id="submitBtn">Final Submit</button>
            </div>
        </div>
</div>
