<table class="table table-bordered main-tables">
    <thead class="table-light">
        <tr>
            <th colspan="2">Items</th>
            <th colspan="2">During the Quarter</th>
            <th colspan="2">Upto this Quarter end</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" class="text-start"><b>19.</b> Details of certificates issued in connection with Surrogacy (Regulation) Act, 2021 [Sec.4]:-</td>
        </tr>
        <tr>
            <td rowspan="4">
                <b>A.</b> Number of applications received for:-
            </td>

            <td>
            <b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman
            </td>

            <td><input type="text" name="applications_received_i_a_q19"  id="applications_received_i_a_q19" value="{{isset($reportResult->applications_received_i_a_q19)? $reportResult->applications_received_i_a_q19:'' }}" class="form-control number-only firstval q19a_i" placeholder="Number" data-number="i"> <span class="text-danger small fs-6 error-msg"id="appeal_received_left_19ai_error_msg">@error('appeal_received_left_19ai_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="4"><input type="text" name="tno_i_a_q19"  id="tno_i_a_q19" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="applications_received_qtr_end_i_a_q19"  id="applications_received_qtr_end_i_a_q19" value="{{isset($reportResult->applications_received_qtr_end_i_a_q19)? $reportResult->applications_received_qtr_end_i_a_q19:'' }}" class="form-control number-only secondval 19b_val_qtr_i " placeholder="Number" >
            <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_19ai_error_msg">@error('appeal_received_qtr_19ai_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="4"><input type="text" id="tno_qtr_end_i_a_q19" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td><input type="text" name="applications_received_ii_a_q19"  id="applications_received_ii_a_q19" value="{{isset($reportResult->applications_received_ii_a_q19)? $reportResult->applications_received_ii_a_q19:'' }}" class="form-control number-only firstval q19a_ii" placeholder="Number" data-number="ii"><span class="text-danger small fs-6 error-msg"id="appeal_received_left_19aii_error_msg">@error('appeal_received_left_19aii_error_msg') {{ $message }} @enderror</span></td> 
            <td><input type="text" name="applications_received_qtr_end_ii_a_q19"  id="applications_received_qtr_end_ii_a_q19" value="{{isset($reportResult->applications_received_qtr_end_ii_a_q19)? $reportResult->applications_received_qtr_end_ii_a_q19:'' }}" class="form-control number-only secondval 19b_val_qtr_ii" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_19aii_error_msg">@error('appeal_received_qtr_19aii_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td><input type="text" name="applications_received_iii_a_q19"  id="applications_received_iii_a_q19" value="{{isset($reportResult->applications_received_iii_a_q19)? $reportResult->applications_received_iii_a_q19:'' }}" class="form-control number-only firstval q19a_iii" placeholder="Number" data-number="iii"><span class="text-danger small fs-6 error-msg"id="appeal_received_left_19aiii_error_msg">@error('appeal_received_left_19aiii_error_msg') {{ $message }} @enderror</span></td>         
            <td><input type="text" name="applications_received_qtr_end_iii_a_q19"  id="applications_received_qtr_end_iii_a_q19" value="{{isset($reportResult->applications_received_qtr_end_iii_a_q19)? $reportResult->applications_received_qtr_end_iii_a_q19:'' }}" class="form-control number-only secondval 19b_val_qtr_iii" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_19aiii_error_msg">@error('appeal_received_qtr_19aiii_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
            Pregnancy having written consent of the Surrogate Mother</td>
            <td><input type="text" name="applications_received_iv_a_q19"  id="applications_received_iv_a_q19" value="{{isset($reportResult->applications_received_iv_a_q19)? $reportResult->applications_received_iv_a_q19:'' }}" class="form-control number-only firstval q19a_iv" placeholder="Number" data-number="iv"><span class="text-danger small fs-6 error-msg"id="appeal_received_left_19aiv_error_msg">@error('appeal_received_left_19aiv_error_msg') {{ $message }} @enderror</span></td>     
            <td><input type="text" name="applications_received_qtr_end_iv_a_q19"  id="applications_received_qtr_end_iv_a_q19" value="{{isset($reportResult->applications_received_qtr_end_iv_a_q19)? $reportResult->applications_received_qtr_end_iv_a_q19:'' }}" class="form-control number-only secondval 19b_val_qtr_iv" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_19aiv_error_msg">@error('appeal_received_qtr_19aiv_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>        
        <tr>
            <td rowspan="4">
            <b> B.</b> Out of the applications received as per A above, number of certificates granted:-
            </td>

            <td><b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman</td>
            <td><input type="text" name="applications_granted_i_b_q19"  id="applications_granted_i_b_q19" value="{{isset($reportResult->applications_granted_i_b_q19)? $reportResult->applications_granted_i_b_q19:'' }}" class="form-control number-only firstval 19b_val_i 19b_val" placeholder="Number" data-number="i">
            <span class="text-danger small fs-6 error-msg"id="applications_granted_left_19bi_error_msg">@error('applications_granted_left_19bi_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="4"><input type="text" id="tno_i_b_q19" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="applications_granted_qtr_end_i_b_q19"  id="applications_granted_qtr_end_i_b_q19" value="{{isset($reportResult->applications_granted_qtr_end_i_b_q19)? $reportResult->applications_granted_qtr_end_i_b_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="i" >
            <span class="text-danger small fs-6 error-msg"id="applications_granted_qtr_19bi_error_msg">@error('applications_granted_qtr_19bi_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="4"><input type="text" id="tno_qtr_end_i_b_q19" value="" class="form-control h-s" placeholder="Total Number" readonly>
            </td>
        </tr>
        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td><input type="text" name="applications_granted_ii_b_q19"  id="applications_granted_ii_b_q19" value="{{isset($reportResult->applications_granted_ii_b_q19)? $reportResult->applications_granted_ii_b_q19:'' }}" class="form-control number-only firstval 19b_val 19b_val_ii" placeholder="Number" data-number="ii">
             <span class="text-danger small fs-6 error-msg"id="applications_granted_left_19bii_error_msg">@error('applications_granted_left_19bii_error_msg') {{ $message }} @enderror</span>
            </td>           
            <td><input type="text" name="applications_granted_qtr_end_ii_b_q19"  id="applications_granted_qtr_end_ii_b_q19" value="{{isset($reportResult->applications_granted_qtr_end_ii_b_q19)? $reportResult->applications_granted_qtr_end_ii_b_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="ii" >
            <span class="text-danger small fs-6 error-msg"id="applications_granted_qtr_19bii_error_msg">@error('applications_granted_qtr_19bii_error_msg') {{ $message }} @enderror</span>
            </td>
       </tr>

        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td><input type="text" name="applications_granted_iii_b_q19"  id="applications_granted_iii_b_q19" value="{{isset($reportResult->applications_granted_iii_b_q19)? $reportResult->applications_granted_iii_b_q19:'' }}" class="form-control number-only firstval 19b_val 19b_val_iii" placeholder="Number" data-number="iii">
            <span class="text-danger small fs-6 error-msg"id="applications_granted_left_19biii_error_msg">@error('applications_granted_left_19biii_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="applications_granted_qtr_end_iii_b_q19"  id="applications_granted_qtr_end_iii_b_q19" value="{{isset($reportResult->applications_granted_qtr_end_iii_b_q19)? $reportResult->applications_granted_qtr_end_iii_b_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="iii" >
            <span class="text-danger small fs-6 error-msg"id="applications_granted_qtr_19biii_error_msg">@error('applications_granted_qtr_19biii_error_msg') {{ $message }} @enderror</span>
            
            </td>
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
                Pregnancy having written consent of the Surrogate Mother</td>
            <td><input type="text" name="applications_granted_iv_b_q19"  id="applications_granted_iv_b_q19" value="{{isset($reportResult->applications_granted_iv_b_q19)? $reportResult->applications_granted_iv_b_q19:'' }}" class="form-control number-only firstval 19b_val 19b_val_iv" placeholder="Number" data-number="iv">
            <span class="text-danger small fs-6 error-msg"id="applications_granted_left_19biv_error_msg">@error('applications_granted_left_19biv_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="applications_granted_qtr_end_iv_b_q19"  id="applications_granted_qtr_end_iv_b_q19" value="{{isset($reportResult->applications_granted_qtr_end_iv_b_q19)? $reportResult->applications_granted_qtr_end_iv_b_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="iv">
           <span class="text-danger small fs-6 error-msg"id="applications_granted_qtr_19biv_error_msg">@error('applications_granted_qtr_19biv_error_msg') {{ $message }} @enderror</span>
            </td>
          
        </tr>

        <tr>
            <td rowspan="4">
            <b> C.</b> Out of the applications received as per A above, number of applications rejected:-
            </td>
            <td><b>i.</b> Certificate of Essentiality to Intending Couple/Intending woman</td>
            <td><input type="text" name="applications_rejected_i_c_q19"  id="applications_rejected_i_c_q19" value="{{isset($reportResult->applications_rejected_i_c_q19)? $reportResult->applications_rejected_i_c_q19:'' }}" class="form-control number-only firstval 19b_val" placeholder="Number" data-number="i"><span class="text-danger small fs-6 error-msg"id="applications_rejected_left_19ci_error_msg">@error('applications_rejected_left_19ci_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="4"><input type="text" id="tnc_i_c_q19" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="applications_rejected_qtr_end_i_c_q19"  id="applications_rejected_qtr_end_i_c_q19" value="{{isset($reportResult->applications_rejected_qtr_end_i_c_q19)? $reportResult->applications_rejected_qtr_end_i_c_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="i">
              <span class="text-danger small fs-6 error-msg"id="applications_rejected_qtr_19ci_error_msg">@error('applications_rejected_qtr_19ci_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="4"><input type="text" id="tno_qtr_end_i_c_q19" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td><b>ii.</b> Eligibility Certificate to Surrogate Mother</td>
            <td><input type="text" name="applications_rejected_ii_c_q19"  id="applications_rejected_ii_c_q19" value="{{isset($reportResult->applications_rejected_ii_c_q19)? $reportResult->applications_rejected_ii_c_q19:'' }}" class="form-control number-only firstval 19b_val" placeholder="Number" data-number="ii"><span class="text-danger small fs-6 error-msg"id="applications_rejected_left_19cii_error_msg">@error('applications_rejected_left_19cii_error_msg') {{ $message }} @enderror</span></td> 
            <td><input type="text" name="applications_rejected_qtr_end_ii_c_q19"  id="applications_rejected_qtr_end_ii_c_q19" value="{{isset($reportResult->applications_rejected_qtr_end_ii_c_q19)? $reportResult->applications_rejected_qtr_end_ii_c_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number"  data-number="ii">
              <span class="text-danger small fs-6 error-msg"id="applications_rejected_qtr_19cii_error_msg">@error('applications_rejected_qtr_19cii_error_msg') {{ $message }} @enderror</span>
            </td>
 
        </tr>

        <tr>
            <td><b>iii.</b> Eligibility Certificate to Intending Couple/Intending woman</td>
            <td><input type="text" name="applications_rejected_iii_c_q19"  id="applications_rejected_iii_c_q19" value="{{isset($reportResult->applications_rejected_iii_c_q19)? $reportResult->applications_rejected_iii_c_q19:'' }}" class="form-control number-only firstval 19b_val" placeholder="Number" data-number="iii"><span class="text-danger small fs-6 error-msg"id="applications_rejected_left_19ciii_error_msg">@error('applications_rejected_left_19ciii_error_msg') {{ $message }} @enderror</span></td>           
            <td><input type="text" name="applications_rejected_qtr_end_iii_c_q19"  id="applications_rejected_qtr_end_iii_c_q19" value="{{isset($reportResult->applications_rejected_qtr_end_iii_c_q19)? $reportResult->applications_rejected_qtr_end_iii_c_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="iii" ><span class="text-danger small fs-6 error-msg"id="applications_rejected_qtr_19ciii_error_msg">@error('applications_rejected_qtr_19ciii_error_msg') {{ $message }} @enderror</span>
            </td>
 
        </tr>
        <tr>
            <td><b>iv.</b> Authorisation of Medical Termination of
                Pregnancy having written consent of the Surrogate Mother</td>
            <td><input type="text" name="applications_rejected_iv_c_q19"  id="applications_rejected_iv_c_q19" value="{{isset($reportResult->applications_rejected_iv_c_q19)? $reportResult->applications_rejected_iv_c_q19:'' }}" class="form-control number-only firstval 19b_val" placeholder="Number" data-number="iv"><span class="text-danger small fs-6 error-msg"id="applications_rejected_left_19civ_error_msg">@error('applications_rejected_left_19civ_error_msg') {{ $message }} @enderror</span></td>      
            <td><input type="text" name="applications_rejected_qtr_end_iv_c_q19"  id="applications_rejected_qtr_end_iv_c_q19" value="{{isset($reportResult->applications_rejected_qtr_end_iv_c_q19)? $reportResult->applications_rejected_qtr_end_iv_c_q19:'' }}" class="form-control number-only secondval 19b_val_qtr" placeholder="Number" data-number="iv"><span class="text-danger small fs-6 error-msg"id="applications_rejected_qtr_19civ_error_msg">@error('applications_rejected_qtr_19civ_error_msg') {{ $message }} @enderror</span>
            </td>
       
        </tr> 
    </tbody>    
    <tbody>    
        <tr>
            <td rowspan="1">
                <b>20. A.</b>  Number of Appeals received against rejection of certificate at point 19(C) above.
            </td>

            <td></td>
            <td><input type="text" name="appeals_against_rejection_a_q20"  id="appeals_against_rejection_a_q20" value="{{isset($reportResult->appeals_against_rejection_a_q20)? $reportResult->appeals_against_rejection_a_q20:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg"id="appeals_against_rejection_left_20a_error_msg">@error('appeals_against_rejection_left_20a_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_a_q20" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeals_against_rejection_qtr_end_a_q20"  id="appeals_against_rejection_qtr_end_a_q20" value="{{isset($reportResult->appeals_against_rejection_qtr_end_a_q20)? $reportResult->appeals_against_rejection_qtr_end_a_q20:'' }}" class="form-control number-only secondval" placeholder="Number" > <span class="text-danger small fs-6 error-msg"id="appeals_against_rejection_qtr_20a_error_msg">@error('appeals_against_rejection_qtr_20a_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_qtr_end_a_q20" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td rowspan="4">
            <b>20. B.</b> Number of Such Appeals disposed off.            
            </td>
            <td></td>
            <td><input type="text" name="appeals_disposed_b_q20"  id="appeals_disposed_b_q20" value="{{isset($reportResult->appeals_disposed_b_q20)? $reportResult->appeals_disposed_b_q20:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg"id="appeals_disposed_left_20b_error_msg">@error('appeals_disposed_left_20b_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_b_q20" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeals_disposed_qtr_end_b_q20"  id="appeals_disposed_qtr_end_b_q20" value="{{isset($reportResult->appeals_disposed_qtr_end_b_q20)? $reportResult->appeals_disposed_qtr_end_b_q20:'' }}" class="form-control number-only secondval" placeholder="Number" ><span class="text-danger small fs-6 error-msg"id="appeals_disposed_qtr_20b_error_msg">@error('appeals_disposed_qtr_20b_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_qtr_end_b_q20" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
                <b>21.</b> Date(s) of the meetings of the State Board constituted under section 27 of the Act [Sec 29(1) - meeting at least once in 4 months].
            

            <td class="text-start"></td>
            <td colspan="2"><textarea name="meeting_date_q21" pattern="[0-9/,]+"  id="meeting_date_q21"  class="form-control alowedchar" placeholder="Meeting Dates- Format: mm/dd/yyyy (only , / and numbers are allowed)" >{{isset($reportResult->meeting_date_q21)? $reportResult->meeting_date_q21:'' }}</textarea>
            {{-- <span class="text-danger small fs-6"></span> --}}
            </td>
           
            <td colspan="2">
                <textarea name="meeting_date_qtr_end_q21" pattern="[0-9/,]+"  id="meeting_date_qtr_end_q21" class="form-control alowedchar" placeholder="Meeting Dates Upto this Quarter end- Format: mm/dd/yyyy (only , / and numbers are allowed)" >{{isset($reportResult->meeting_date_qtr_end_q21)? $reportResult->meeting_date_qtr_end_q21:'' }}</textarea>
            {{-- <span class="text-danger small fs-6">Allow only /, numbers, and commas.Format: mm/dd/yyyy,mm/dd/yyyy,</span> --}}
            </td>
             
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
                <b>22.</b> Action taken in respect of Penal provisions under:
                
                <p class="fst-italic small">(Please provide the details on a separate sheet as per Annexure-III.)<p>   
            </td>

            <td class="text-start"><b>1.</b> Chapter V of ART</td>
            <td><input type="text" name="chapter_v_art_q22"  id="chapter_v_art_q22" value="{{isset($reportResult->chapter_v_art_q22)? $reportResult->chapter_v_art_q22:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="chapter_v_art_left_22_error_msg">@error('chapter_v_art_left_22_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q22" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="chapter_v_art_qtr_end_q22"  id="chapter_v_art_qtr_end_q22" value="{{isset($reportResult->chapter_v_art_qtr_end_q22)? $reportResult->chapter_v_art_qtr_end_q22:'' }}" class="form-control number-only secondval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="chapter_v_art_qtr_22_error_msg">@error('chapter_v_art_qtr_22_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" name="tno_qtr_end_q22"  id="tno_qtr_end_q22" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start"><b>2.</b>Chapter VII of surrogacy</td>
            <td><input type="text" name="surrogacy_chapter_vii_q22"  id="surrogacy_chapter_vii_q22" value="{{isset($reportResult->surrogacy_chapter_vii_q22)? $reportResult->surrogacy_chapter_vii_q22:'' }}" class="form-control number-only number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="surrogacy_chapter_vii_left_22_error_msg">@error('surrogacy_chapter_vii_left_22_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_chapter_qtr_end_vii_q22" id="surrogacy_chapter_qtr_end_vii_q22" value="{{isset($reportResult->surrogacy_chapter_qtr_end_vii_q22)? $reportResult->surrogacy_chapter_qtr_end_vii_q22:'' }}" class="form-control number-only secondval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="surrogacy_chapter_vii_qtr_22_error_msg">@error('surrogacy_chapter_vii_qtr_22_error_msg') {{ $message }} @enderror</span></td>
        </tr>

    </tbody>
  
</table>


