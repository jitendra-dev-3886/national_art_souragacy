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
            <td rowspan="3" class="text-start">
                <b>10.</b> Number Of applications received for renewals of registration certificate:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q10"  id="art_clinic_q10" value="{{isset($reportResult->art_clinic_q10)? $reportResult->art_clinic_q10:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_10_error_msg">@error('art_clinic_left_10_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text"  id="tno_q10" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q10"  id="art_clinic_qtr_end_q10" value="{{isset($reportResult->art_clinic_qtr_end_q10)? $reportResult->art_clinic_qtr_end_q10:'' }}" class="form-control number-only secondvalx" placeholder="Number" >
           <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_10_error_msg">@error('art_clinic_qtr_10_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" name="tno_qtr_end_q10"  id="tno_qtr_end_q10" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q10"  id="art_banks_q10" value="{{isset($reportResult->art_banks_q10)? $reportResult->art_banks_q10:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_banks_left_10_error_msg">@error('art_banks_left_10_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q10"  id="art_banks_qtr_end_q10" value="{{isset($reportResult->art_banks_qtr_end_q10)? $reportResult->art_banks_qtr_end_q10:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msgw" id="art_banks_qtr_10_error_msg">@error('art_banks_qtr_10_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q10"  id="surrogacy_clinic_q10" value="{{isset($reportResult->surrogacy_clinic_q10)? $reportResult->surrogacy_clinic_q10:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_left_10_error_msg">@error('surrogacy_clinic_left_10_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q10"  id="surrogacy_clinic_qtr_end_q10" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q10)? $reportResult->surrogacy_clinic_qtr_end_q10:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_qtr_10_error_msg">@error('surrogacy_clinic_qtr_10_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b> 11.</b> Out of (10) above, applications of delayed renewal received:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q11"  id="art_clinic_q11" value="{{isset($reportResult->art_clinic_q11)? $reportResult->art_clinic_q11:'' }}" class="form-control number-only firstval" placeholder="Number"><span class="text-danger small fs-6 error-msgw" id="art_clinic_left_11_error_msg">@error('art_clinic_left_11_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q11" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q11" id="art_clinic_qtr_end_q11" value="{{isset($reportResult->art_clinic_qtr_end_q11)? $reportResult->art_clinic_qtr_end_q11:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msgw" id="art_clinic_qtr_11_error_msg">@error('art_clinic_qtr_11_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q11" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q11"  id="art_banks_q11" value="{{isset($reportResult->art_banks_q11)? $reportResult->art_banks_q11:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_banks_left_11_error_msg">@error('art_banks_left_11_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q11"  id="art_banks_qtr_end_q11" value="{{isset($reportResult->art_banks_qtr_end_q11)? $reportResult->art_banks_qtr_end_q11:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msgw" id="art_banks_qtr_11_error_msg">@error('art_banks_qtr_11_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q11"  id="surrogacy_clinic_q11" value="{{isset($reportResult->surrogacy_clinic_q11)? $reportResult->surrogacy_clinic_q11:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_left_11_error_msg">@error('surrogacy_clinic_left_11_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q11"  id="surrogacy_clinic_qtr_end_q11" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q11)? $reportResult->surrogacy_clinic_qtr_end_q11:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_qtr_11_error_msg">@error('surrogacy_clinic_qtr_11_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b>12.</b> Number of renewals granted:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q12"  id="art_clinic_q12" value="{{isset($reportResult->art_clinic_q12)? $reportResult->art_clinic_q12:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_clinic_left_12_error_msg">@error('art_clinic_left_12_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q12" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q12"  id="art_clinic_qtr_end_q12" value="{{isset($reportResult->art_clinic_qtr_end_q12)? $reportResult->art_clinic_qtr_end_q12:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msgw" id="art_clinic_qtr_12_error_msg">@error('art_clinic_qtr_12_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text"  id="tno_qtr_end_q12" value="" class="form-control number-only h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q12"  id="art_banks_q12" value="{{isset($reportResult->art_banks_q12)? $reportResult->art_banks_q12:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_banks_left_12_error_msg">@error('art_banks_left_12_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q12"  id="art_banks_qtr_end_q12" value="{{isset($reportResult->art_banks_qtr_end_q12)? $reportResult->art_banks_qtr_end_q12:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msgw" id="art_banks_qtr_12_error_msg">@error('art_banks_qtr_12_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q12"  id="surrogacy_clinic_q12" value="{{isset($reportResult->surrogacy_clinic_q12)? $reportResult->surrogacy_clinic_q12:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_left_12_error_msg">@error('surrogacy_clinic_left_12_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q12"  id="surrogacy_clinic_qtr_end_q12" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q12)? $reportResult->surrogacy_clinic_qtr_end_q12:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_qtr_12_error_msg">@error('surrogacy_clinic_qtr_12_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>  
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
                <b>13.</b> Number of renewal applications rejected:
            </td>
            
            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q13"  id="art_clinic_q13" value="{{isset($reportResult->art_clinic_q13)? $reportResult->art_clinic_q13:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_clinic_left_13_error_msg">@error('art_clinic_left_13_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q13" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q13"  id="art_clinic_qtr_end_q13" value="{{isset($reportResult->art_clinic_qtr_end_q13)? $reportResult->art_clinic_qtr_end_q13:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msgw" id="art_clinic_qtr_13_error_msg">@error('art_clinic_qtr_13_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q13" value="" class="form-control number-only h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q13"  id="art_banks_q13" value="{{isset($reportResult->art_banks_q13)? $reportResult->art_banks_q13:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="art_banks_left_13_error_msg">@error('art_banks_left_13_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q13"  id="art_banks_qtr_end_q13" value="{{isset($reportResult->art_banks_qtr_end_q13)? $reportResult->art_banks_qtr_end_q13:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msgw" id="art_banks_qtr_13_error_msg">@error('art_banks_qtr_13_error_msg') {{ $message }} @enderror</span>
            </td>

        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q13"  id="surrogacy_clinic_q13" value="{{isset($reportResult->surrogacy_clinic_q13)? $reportResult->surrogacy_clinic_q13:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_left_13_error_msg">@error('surrogacy_clinic_left_13_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q13"  id="surrogacy_clinic_qtr_end_q13" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q13)? $reportResult->surrogacy_clinic_qtr_end_q13:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_qtr_13_error_msg">@error('surrogacy_clinic_qtr_13_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
    
        <tr>
            <td rowspan="1">
                <b>14. A.</b>  Number of appeals received against the rejection of applications (Fresh registration/Renewal)
            </td>

            <td>-------</td>
            <td><input type="text" name="appeal_rej_app_a_q14"  id="appeal_rej_app_a_q14" value="{{isset($reportResult->appeal_rej_app_a_q14)? $reportResult->appeal_rej_app_a_q14:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="renewal_left_14a_error_msg">@error('renewal_left_14a_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_a_q14" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeal_rej_app_qtr_end_a_q14"  id="appeal_rej_app_qtr_end_a_q14" value="{{isset($reportResult->appeal_rej_app_qtr_end_a_q14)? $reportResult->appeal_rej_app_qtr_end_a_q14:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msgw" id="renewal_qtr_14a_error_msg">@error('renewal_qtr_14a_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text"  id="tno_qtr_end_a_q14" value="" class="form-control number-only h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td rowspan="4">
            <b>14. B.</b> Out of the above, number of appeals disposed off.
            
            </td>

            <td>---------</td>
            <td><input type="text" name="appeals_disposed_b_q14"  id="appeals_disposed_b_q14" value="{{isset($reportResult->appeals_disposed_b_q14)? $reportResult->appeals_disposed_b_q14:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw" id="renewal_left_14b_error_msg">@error('renewal_left_14b_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_b_q14" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeals_disposed_qtr_end_b_q14"  id="appeals_disposed_qtr_end_b_q14" value="{{isset($reportResult->appeals_disposed_qtr_end_b_q14)? $reportResult->appeals_disposed_qtr_end_b_q14:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msgw" id="renewal_qtr_14b_error_msg">@error('renewal_qtr_14b_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" id="tno_qtr_end_b_q14" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
                <b>15.</b> Number of complaints received by the Appropriate Authorities under the Act:
            <p class="fst-italic small">(Please provide the details on a separate sheet, as per Annexure-II.)<p>
            </td>

            <td class="text-start"><b>i:</b> Forwarded by Department of Health Research</td>
            <td><input type="text" name="forwarded_dhr_i_q15"  id="forwarded_dhr_i_q15" value="{{isset($reportResult->forwarded_dhr_i_q15)? $reportResult->forwarded_dhr_i_q15:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_15_error_msg">@error('art_clinic_left_15_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_i_q15" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="forwarded_dhr_qtr_end_i_q15"  id="forwarded_dhr_qtr_end_i_q15" value="{{isset($reportResult->forwarded_dhr_qtr_end_i_q15)? $reportResult->forwarded_dhr_qtr_end_i_q15:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_15_error_msg">@error('art_clinic_qtr_15_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" name="tno_qtr_end_i_q15"  id="tno_qtr_end_i_q15" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start"><b>ii.</b> Received from other Stakeholders</td>
            <td><input type="text" name="received_stakeholders_ii_q15"  id="received_stakeholders_ii_q15" value="{{isset($reportResult->received_stakeholders_ii_q15)? $reportResult->received_stakeholders_ii_q15:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_banks_left_15_error_msg">@error('art_banks_left_15_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="received_stakeholders_qtr_end_ii_q15"  id="received_stakeholders_qtr_end_ii_q15" value="{{isset($reportResult->received_stakeholders_qtr_end_ii_q15)? $reportResult->received_stakeholders_qtr_end_ii_q15:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_15_error_msg">@error('art_banks_qtr_15_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start"><b>iii.</b> Suo-moto Cognizancе</td>
            <td><input type="text" name="suo_moto_cognizancеr_iii_q15"  id="suo_moto_cognizancеr_iii_q15" value="{{isset($reportResult->suo_moto_cognizancеr_iii_q15)? $reportResult->suo_moto_cognizancеr_iii_q15:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_left_15_error_msg">@error('surrogacy_clinic_left_15_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="suo_moto_cognizancеr_qtr_end_iii_q15"  id="suo_moto_cognizancеr_qtr_end_iii_q15" value="{{isset($reportResult->suo_moto_cognizancеr_qtr_end_iii_q15)? $reportResult->suo_moto_cognizancеr_qtr_end_iii_q15:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_15_error_msg">@error('surrogacy_clinic_qtr_15_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>  
    <tbody>
        <tr> 
            <td colspan="6" class="text-start"><b>16.</b> Action taken w.r.t. complaints at point (15) above:</td>
        </tr>
        <tr>
            <td rowspan="1">
                <b>A.</b> Inspection of premises, search and seizure of documents or records, summoning of associated persons etc.
            </td>

            <td>
                [Powers drawn from Sec. 14(1) & 40(1) of ART (Regulation) Act, 2021<br>
                and Sec. 37(1) & 47(1) of Surrogacy (Regulation) Act, 2021]
            </td>
            
            <td><input type="text" name="action_taken_a_q16"  id="action_taken_a_q16" value="{{isset($reportResult->action_taken_a_q16)? $reportResult->action_taken_a_q16:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_left_16a_error_msg">@error('surrogacy_clinic_left_16a_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_a_q16" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="action_taken_qtr_end_a_q16"  id="action_taken_qtr_end_a_q16" value="{{isset($reportResult->action_taken_qtr_end_a_q16)? $reportResult->action_taken_qtr_end_a_q16:'' }}" class="form-control number-only secondval" placeholder="Number" >
            
               <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_16a_error_msg">@error('surrogacy_clinic_qtr_16a_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" id="tnb_qtr_end_a_q16" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td rowspan="3">
            <b> B.</b> Number of suspensions or cancellations of registration in the State/UT under Section 18 of ART (Regulation) Act and Section 13 of Surrogacy (Regulation) Act, 2021 in respect of:
               <p class="fst-italic small">(Please provide the details on a separate sheet against each complaint or suo-moto cognizance, as per Annexure-II.)<p>   
            </td>            
            <td>ART Clinics</td>
            <td><input type="text" name="art_clinics_b_q16"  id="art_clinics_b_q16" value="{{isset($reportResult->art_clinics_b_q16)? $reportResult->art_clinics_b_q16:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_b_16_error_msg">@error('art_clinic_left_b_16_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" name="tno_b_q16"  id="tno_b_q16" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinics_qtr_end_b_q16"  id="art_clinics_qtr_end_b_q16" value="{{isset($reportResult->art_clinics_qtr_end_b_q16)? $reportResult->art_clinics_qtr_end_b_q16:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_b_16_error_msg">@error('art_clinic_qtr_b_16_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" name="tno_art_clinics_qtr_end_b_q16"  id="tno_art_clinics_qtr_end_b_q16" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td>ART Banks</td>
            <td><input type="text" name="art_banks_b_q16"  id="art_banks_b_q16" value="{{isset($reportResult->art_banks_b_q16)? $reportResult->art_banks_b_q16:'' }}" class="form-control number-only firstval" placeholder="Number" >
           <span class="text-danger small fs-6 error-msg-q41" id="art_banks_left_b_16_error_msg">@error('art_banks_left_b_16_error_msg') {{ $message }} @enderror</span>
            </td>
         
            <td><input type="text" name="art_banks_qtr_end_b_q16"  id="art_banks_qtr_end_b_q16" value="{{isset($reportResult->art_banks_qtr_end_b_q16)? $reportResult->art_banks_qtr_end_b_q16:'' }}" class="form-control number-only secondval" placeholder="Number" >
                            <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_b_16_error_msg">@error('art_banks_qtr_b_16_error_msg') {{ $message }} @enderror</span>

            </td>
            
        </tr>

        <tr>
            <td>Surrogacy Clinics</td>
            <td><input type="text" name="surrogacy_clinics_b_q16"  id="surrogacy_clinics_b_q16" value="{{isset($reportResult->surrogacy_clinics_b_q16)? $reportResult->surrogacy_clinics_b_q16:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinics_left_b_16_error_msg">@error('surrogacy_clinics_left_b_16_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinics_qtr_end_b_q16"  id="surrogacy_clinics_qtr_end_b_q16" value="{{isset($reportResult->surrogacy_clinics_qtr_end_b_q16)? $reportResult->surrogacy_clinics_qtr_end_b_q16:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinics_qtr_b_16_error_msg">@error('surrogacy_clinics_qtr_b_16_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

    </tbody>  
    <tbody>
    
        <tr>
            <td rowspan="1">
                <b>17. A.</b>  Number of appeals received against
                suspension or cancellation of registration of clinics or banks
            </td>

            <td></td>
            <td><input type="text" name="appeal_received_a_q17"  id="appeal_received_a_q17" value="{{isset($reportResult->appeal_received_a_q17)? $reportResult->appeal_received_a_q17:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg"id="appeal_received_left_17a_error_msg">@error('appeal_received_left_17a_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text"   id="tno_a_q17" value="{{isset($reportResult->appeal_received_a_q17)? $reportResult->appeal_received_a_q17:'' }}" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeal_received_qtr_end_a_q17"  id="appeal_received_qtr_end_a_q17" value="{{isset($reportResult->appeal_received_qtr_end_a_q17)? $reportResult->appeal_received_qtr_end_a_q17:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_17a_error_msg">@error('appeal_received_qtr_17a_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" id="tno_qtr_end_a_q17" value="{{isset($reportResult->appeal_received_qtr_end_a_q17)? $reportResult->appeal_received_qtr_end_a_q17:'' }}" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td rowspan="4">
            <b>17. B.</b> Out of the above, number of appeals disposed off
            
            </td>

            <td></td>
            <td><input type="text" name="appeals_disposed_b_q17"  id="appeals_disposed_b_q17" value="{{isset($reportResult->appeals_disposed_b_q17)? $reportResult->appeals_disposed_b_q17:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg"id="appeal_received_left_17b_error_msg">@error('appeal_received_left_17b_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" id="tno_b_q17" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="appeals_disposed_qtr_end_b_q17"  id="appeals_disposed_qtr_end_b_q17" value="{{isset($reportResult->appeals_disposed_qtr_end_b_q17)? $reportResult->appeals_disposed_qtr_end_b_q17:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg"id="appeal_received_qtr_17b_error_msg">@error('appeal_received_qtr_17b_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" id="tno_qtr_end_b_q17" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
                <b>18.</b> Number of complaints filed in courts in the
                State/UT:
                 <p class="fst-italic small">(Please provide the details on a separate sheet as per Annexure-III.)<p>   
            </td>
            
            <td class="text-start"> as per Sec. 35 of ART(Regulation) Act
                and Sec. 44 of the Surrogacy(Regulation) Act 2021:
            </td>
            <td><input type="text" name="complaints_filed_q18"  id="complaints_filed_q18" value="{{isset($reportResult->complaints_filed_q18)? $reportResult->complaints_filed_q18:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msgw"id="complaints_filed_left_18_error_msg">@error('complaints_filed_left_18_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q18" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="complaints_filed_qtr_end_q18"  id="complaints_filed_qtr_end_q18" value="{{isset($reportResult->complaints_filed_qtr_end_q18)? $reportResult->complaints_filed_qtr_end_q18:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg2"id="complaints_filed_qtr_18_error_msg">@error('complaints_filed_qtr_18_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q18" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>    
    </tbody>
</table>
