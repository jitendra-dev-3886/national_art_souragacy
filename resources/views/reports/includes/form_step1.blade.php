<table class="table table-bordered main-tables">
    <thead class="table-light">
        <tr>
            <th colspan="2">Items</th>
            <th colspan="2">During the Quarter</th>
            <th colspan="2">Upto this Quarter end (since inception of the Act <span class="no-capitalize">i.e</span> 25.01.2022)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b> 1.</b> Number of applications received in the National Registry Portal in the State / UT :
            </td>
            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q1" id="art_clinic_q1" value="{{isset($prefillData['artclinic'])? $prefillData['artclinic']:'' }}" class="form-control art_clinic_q1 number-only" placeholder="Number" readonly ></td>
             <td rowspan="3"><input type="text" id="tno_q1" value="" class="form-control h-s" placeholder="Total Number" readonly></td>     
            <td><input type="text" name="art_clinic_qtr_end_q1"  id="art_clinic_qtr_end_q1" value="{{isset($prefillData['qtrartclinic'])? $prefillData['qtrartclinic']:'' }}" class="form-control number-only" placeholder="Number" readonly> <span class="text-danger small fs-6 error-msgw" id="art_clinic_qtr_1_error_msg">@error('art_clinic_qtr_1_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q1" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>
        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q1"  id="art_banks_q1" value="{{isset($prefillData['artbank'])? $prefillData['artbank']:'' }}" class="form-control number-only art_banks_q1" placeholder="Number" readonly ></td>
            <td><input type="text" name="art_banks_qtr_end_q1"  id="art_banks_qtr_end_q1" value="{{isset($prefillData['qtrartbank'])? $prefillData['qtrartbank']:'' }}" class="form-control number-only" placeholder="Number"  readonly><span class="text-danger small fs-6 error-msgw" id="art_banks_qtr_1_error_msg">@error('art_banks_qtr_1_error_msg') {{ $message }} @enderror</span></td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q1"  id="surrogacy_clinic_q1" value="{{isset($prefillData['surrogacy_clinic'])? $prefillData['surrogacy_clinic']:'' }}" class="form-control number-only surrogacy_clinic_q1" placeholder="Number" readonly></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q1"  id="surrogacy_clinic_qtr_end_q1" value="{{isset($prefillData['qtrsurrogacy_clinic'])? $prefillData['qtrsurrogacy_clinic']:'' }}" class="form-control number-only" placeholder="Number" readonly><span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_qtr_1_error_msg"></span></td>
        </tr>
    </tbody>  
    <tbody>
        <tr data-id="2">
            <td rowspan="3" class="text-start">
                <b>2.</b> Number of applications received (Complete in all respects along with Registration fees) by the State / UT :
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q2"  id="art_clinic_q2" value="{{isset($reportResult->art_clinic_q2)? $reportResult->art_clinic_q2:'' }}" class="form-control number-only firstval" placeholder="Number" data-name="art_clinic_q2" data-number="1">
             <span class="text-danger small fs-6 error-msgw" id="art_clinic_left_2_error_msg">@error('art_clinic_left_2_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_q2" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q2"  id="art_clinic_qtr_end_q2" value="{{isset($reportResult->art_clinic_qtr_end_q2)? $reportResult->art_clinic_qtr_end_q2:'' }}" class="form-control number-only secondval" placeholder="Number" >
              {{-- <span class="text-danger small fs-6 error-msg"></span> --}}
                 <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_2_error_msg">@error('art_clinic_qtr_2_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q2" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q2"  id="art_banks_q2" value="{{isset($reportResult->art_banks_q2)? $reportResult->art_banks_q2:'' }}" class="form-control number-only firstval" placeholder="Number" data-name="art_banks_q2">
                <span class="text-danger small fs-6 error-msgw" id="art_bank_left_2_error_msg">@error('art_bank_left_2_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="art_banks_qtr_end_q2"  id="art_banks_qtr_end_q2" value="{{isset($reportResult->art_banks_qtr_end_q2)? $reportResult->art_banks_qtr_end_q2:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg" id="art_banks_qtr_2_error_msg">@error('art_banks_qtr_2_error_msg') {{ $message }} @enderror</span>
             {{-- <span class="text-danger small fs-6 error-msg error-msg-q4"></span> --}}
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q2"  id="surrogacy_clinic_q2" value="{{isset($reportResult->surrogacy_clinic_q2)? $reportResult->surrogacy_clinic_q2:'' }}" class="form-control number-only firstval" placeholder="Number" data-name="surrogacy_clinic_q2">
            <span class="text-danger small fs-6 error-msgw" id="surrogacy_clinic_left_2_error_msg">@error('surrogacy_clinic_left_2_error_msg') {{ $message }} @enderror</span>
        </td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q2"  id="surrogacy_clinic_qtr_end_q2" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q2)? $reportResult->surrogacy_clinic_qtr_end_q2:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msg error-msg-q4q" id="surrogacy_clinic_qtr_2_error_msg">@error('surrogacy_clinic_qtr_2_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr data-id="3">
            <td rowspan="3" class="text-start">
                <b>3.</b> Number of Clinic or Banks Registered in the State / UT
            </td>
            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q3"  id="art_clinic_q3" value="{{isset($reportResult->art_clinic_q3)? $reportResult->art_clinic_q3:'' }}" class="form-control number-only firstval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_3_error_msg">@error('art_clinic_left_3_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_q3" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q3"  id="art_clinic_qtr_end_q3" value="{{isset($reportResult->art_clinic_qtr_end_q3)? $reportResult->art_clinic_qtr_end_q3:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_3_error_msg">@error('art_clinic_qtr_3_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text"  id="tno_qtr_end_q3" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q3"  id="art_banks_q3" value="{{isset($reportResult->art_banks_q3)? $reportResult->art_banks_q3:'' }}" class="form-control firstval" placeholder="Number number-only firstval" >
             <span class="text-danger small fs-6 error-msg-q41" id="art_banks_left_3_error_msg">@error('art_banks_left_3_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="art_banks_qtr_end_q3"  id="art_banks_qtr_end_q3" value="{{isset($reportResult->art_banks_qtr_end_q3)? $reportResult->art_banks_qtr_end_q3:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_3_error_msg">@error('art_banks_qtr_3_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q3"  id="surrogacy_clinic_q3" value="{{isset($reportResult->surrogacy_clinic_q3)? $reportResult->surrogacy_clinic_q3:'' }}" class="form-control number-only firstval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_left_3_error_msg">@error('surrogacy_clinic_left_3_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q3"  id="surrogacy_clinic_qtr_end_q3" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q3)? $reportResult->surrogacy_clinic_qtr_end_q3:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_3_error_msg">@error('surrogacy_clinic_qtr_3_error_msg') {{ $message }} @enderror</span>
              
            </td>
        </tr>
    </tbody> 
    <tbody>
        <tr data-id="4">
            <td rowspan="3" class="text-start">
            <b>4.</b> Of the Number shown in item (3) above, number of establishments in the Government run institutes in the State / UT:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q4"  id="art_clinic_q4" value="{{isset($reportResult->art_clinic_q4)? $reportResult->art_clinic_q4:'' }}" class="form-control number-only firstval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_4_error_msg">@error('art_clinic_left_4_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" name="tno_q4"  id="tno_q4" value="" class="form-control h-s" placeholder="Total Number" readonly>
            
            </td>
            <td><input type="text" name="art_clinic_qtr_end_q4"  id="art_clinic_qtr_end_q4" value="{{isset($reportResult->art_clinic_qtr_end_q4)? $reportResult->art_clinic_qtr_end_q4:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_4_error_msg">@error('art_clinic_qtr_4_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q4" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q4"  id="art_banks_q4" value="{{isset($reportResult->art_banks_q4)? $reportResult->art_banks_q4:'' }}" class="form-control number-only firstval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg-q41" id="art_banks_left_4_error_msg">@error('art_banks_left_4_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="art_banks_qtr_end_q4"  id="art_banks_qtr_end_q4" value="{{isset($reportResult->art_banks_qtr_end_q4)? $reportResult->art_banks_qtr_end_q4:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_4_error_msg">@error('art_banks_qtr_4_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q4"  id="surrogacy_clinic_q4" value="{{isset($reportResult->surrogacy_clinic_q4)? $reportResult->surrogacy_clinic_q4:'' }}" class="form-control number-only firstval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_left_4_error_msg">@error('surrogacy_clinic_left_4_error_msg') {{ $message }} @enderror</span>
            </td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q4"  id="surrogacy_clinic_qtr_end_q4" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q4)? $reportResult->surrogacy_clinic_qtr_end_q4:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_4_error_msg">@error('surrogacy_clinic_qtr_4_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr data-id="3">
            <td rowspan="3" class="text-start">
                <b>5.</b> Of the number shown in item (3) above, number of Private clinics or banks in the State/UT:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q5"  id="art_clinic_q5" value="{{isset($reportResult->art_clinic_q5)? $reportResult->art_clinic_q5:'' }}" class="form-control number-only firstval" placeholder="Number" readonly></td>
            <td rowspan="3"><input type="text" id="tno_q5" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q5"  id="art_clinic_qtr_end_q5" value="{{isset($reportResult->art_clinic_qtr_end_q5)? $reportResult->art_clinic_qtr_end_q5:'' }}" class="form-control number-only secondval" placeholder="Number" readonly>
            <span class="text-danger small fs-6 error-msg"></span>
            </td>
            <td rowspan="3"><input type="text"  id="tno_qtr_end_q5" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q5"  id="art_banks_q5" value="{{isset($reportResult->art_banks_q5)? $reportResult->art_banks_q5:'' }}" class="form-control number-only firstval" placeholder="Number" readonly></td>
            <td><input type="text" name="art_banks_qtr_end_q5"  id="art_banks_qtr_end_q5" value="{{isset($reportResult->art_banks_qtr_end_q5)? $reportResult->art_banks_qtr_end_q5:'' }}" class="form-control number-only secondval" placeholder="Number" readonly>
                   <span class="text-danger small fs-6 error-msg"></span>
           </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q5"  id="surrogacy_clinic_q5" value="{{isset($reportResult->surrogacy_clinic_q5)? $reportResult->surrogacy_clinic_q5:'' }}" class="form-control number-only firstval" placeholder="Number" readonly></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q5"  id="surrogacy_clinic_qtr_end_q5" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q5)? $reportResult->surrogacy_clinic_qtr_end_q5:'' }}" class="form-control number-only secondval" placeholder="Number" readonly>
               <span class="text-danger small fs-6 error-msg"></span>
            </td>
        </tr>
    </tbody>     
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b> 6.</b> Number of Applications rejected for registration of clinics or banks:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q6"  id="art_clinic_q6" value="{{isset($reportResult->art_clinic_q6)? $reportResult->art_clinic_q6:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_clinic_left_6_error_msg">@error('art_clinic_left_6_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q6" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q6"  id="art_clinic_qtr_end_q6" value="{{isset($reportResult->art_clinic_qtr_end_q6)? $reportResult->art_clinic_qtr_end_q6:'' }}" class="form-control number-only secondval" placeholder="Number" >
              <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_6_error_msg">@error('art_clinic_qtr_6_error_msg') {{ $message }} @enderror</span>
              <span class="text-danger small fs-6 error-msg-q41" id="art_clinic_qtr_6_error_msg1">@error('art_clinic_qtr_6_error_msg1') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text"  id="tno_qtr_end_q6" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q6"  id="art_banks_q6" value="{{isset($reportResult->art_banks_q6)? $reportResult->art_banks_q6:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="art_banks_left_6_error_msg">@error('art_banks_left_6_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q6"  id="art_banks_qtr_end_q6" value="{{isset($reportResult->art_banks_qtr_end_q6)? $reportResult->art_banks_qtr_end_q6:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_6_error_msg">@error('art_banks_qtr_6_error_msg') {{ $message }} @enderror</span>
             <span class="text-danger small fs-6 error-msg-q41" id="art_banks_qtr_6_error_msg1">@error('art_banks_qtr_6_error_msg1') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q6"  id="surrogacy_clinic_q6" value="{{isset($reportResult->surrogacy_clinic_q6)? $reportResult->surrogacy_clinic_q6:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_left_6_error_msg">@error('surrogacy_clinic_left_6_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q6"  id="surrogacy_clinic_qtr_end_q6" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q6)? $reportResult->surrogacy_clinic_qtr_end_q6:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_6_error_msg">@error('surrogacy_clinic_qtr_6_error_msg') {{ $message }} @enderror</span>
                <span class="text-danger small fs-6 error-msg-q41" id="surrogacy_clinic_qtr_6_error_msg1">@error('surrogacy_clinic_qtr_6_error_msg1') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b>7.</b> Number of Applications received on the portal but later cancelled or withdrawn in respect of:
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q7"  id="art_clinic_q7" value="{{isset($reportResult->art_clinic_q7)? $reportResult->art_clinic_q7:'' }}" class="form-control number-only firstval" placeholder="Number" > <span class="text-danger small fs-6 error-msg" id="art_clinic_left_7_error_msg">@error('art_clinic_left_7_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" id="tno_q7" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q7"  id="art_clinic_qtr_end_q7" value="{{isset($reportResult->art_clinic_qtr_end_q7)? $reportResult->art_clinic_qtr_end_q7:'' }}" class="form-control number-only secondval" placeholder="Number" >
           <span class="text-danger small fs-6 error-msg" id="art_clinic_qtr_7_error_msg">@error('art_clinic_qtr_7_error_msg') {{ $message }} @enderror</span>
           <span class="text-danger small fs-6 error-msg" id="art_clinic_qtr_7_error_msg1">@error('art_clinic_qtr_7_error_msg1') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q7" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q7"  id="art_banks_q7" value="{{isset($reportResult->art_banks_q7)? $reportResult->art_banks_q7:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="art_banks_left_7_error_msg">@error('art_banks_left_7_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q7"  id="art_banks_qtr_end_q7" value="{{isset($reportResult->art_banks_qtr_end_q7)? $reportResult->art_banks_qtr_end_q7:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg" id="art_banks_qtr_7_error_msg">@error('art_banks_qtr_7_error_msg') {{ $message }} @enderror</span>
            <span class="text-danger small fs-6 error-msg" id="art_banks_qtr_7_error_msg1">@error('art_banks_qtr_7_error_msg1') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q7"  id="surrogacy_clinic_q7" value="{{isset($reportResult->surrogacy_clinic_q7)? $reportResult->surrogacy_clinic_q7:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_left_7_error_msg">@error('surrogacy_clinic_left_7_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q7"  id="surrogacy_clinic_qtr_end_q7" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q7)? $reportResult->surrogacy_clinic_qtr_end_q7:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_qtr_7_error_msg">@error('surrogacy_clinic_qtr_7_error_msg') {{ $message }} @enderror</span>
                <span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_qtr_7_error_msg1">@error('surrogacy_clinic_qtr_7_error_msg1') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b> 8.</b> Number of applications pending beyond the prescribed period: [2-(3+6+7)]
            </td>

            <td class="text-start">ART Clinic | Pending beyond 30 days</td>
            <td><input type="text" name="art_clinic_q8"  id="art_clinic_q8" value="{{isset($reportResult->art_clinic_q8)? $reportResult->art_clinic_q8:'' }}" class="form-control number-only firstval" placeholder="Number" > <span class="text-danger small fs-6 error-msg" id="art_clinic_left_8_error_msg">@error('art_clinic_left_8_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text"  id="tno_q8" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q8"  id="art_clinic_qtr_end_q8" value="{{isset($reportResult->art_clinic_qtr_end_q8)? $reportResult->art_clinic_qtr_end_q8:'' }}" class="form-control number-only secondval" placeholder="Number" >
           <span class="text-danger small fs-6 error-msg" id="art_clinic_qtr_8_error_msg">@error('art_clinic_qtr_8_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" id="tno_qtr_end_q8" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks | Pending beyond 30 days</td>
            <td><input type="text" name="art_banks_q8"  id="art_banks_q8" value="{{isset($reportResult->art_banks_q8)? $reportResult->art_banks_q8:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="art_banks_left_8_error_msg">@error('art_banks_left_8_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q8"  id="art_banks_qtr_end_q8" value="{{isset($reportResult->art_banks_qtr_end_q8)? $reportResult->art_banks_qtr_end_q8:'' }}" class="form-control number-only secondval" placeholder="Number" >
               <span class="text-danger small fs-6 error-msg" id="art_banks_qtr_8_error_msg">@error('art_banks_qtr_8_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic | Pending beyond 90 days</td>
            <td><input type="text" name="surrogacy_clinic_q8"  id="surrogacy_clinic_q8" value="{{isset($reportResult->surrogacy_clinic_q8)? $reportResult->surrogacy_clinic_q8:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_left_8_error_msg">@error('surrogacy_clinic_left_8_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q8"  id="surrogacy_clinic_qtr_end_q8" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q8)? $reportResult->surrogacy_clinic_qtr_end_q8:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_qtr_8_error_msg">@error('surrogacy_clinic_qtr_8_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td rowspan="3" class="text-start">
            <b> 9.</b> A Number of clinics which are not Registered:
            <p class="pt-2"> B. Action taken in respect of A:</p>
              <p class="fst-italic small">(Please provide the details on a separate sheet, as per Annexure-I.)<p>
            
            </td>

            <td class="text-start">ART Clinic</td>
            <td><input type="text" name="art_clinic_q9"  id="art_clinic_q9" value="{{isset($reportResult->art_clinic_q9)? $reportResult->art_clinic_q9:'' }}" class="form-control number-only firstval" placeholder="Number" > <span class="text-danger small fs-6 error-msg" id="art_clinic_left_9_error_msg">@error('art_clinic_left_9_error_msg') {{ $message }} @enderror</span></td>
            <td rowspan="3"><input type="text" name="tno_q9"  id="tno_q9" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
            <td><input type="text" name="art_clinic_qtr_end_q9"  id="art_clinic_qtr_end_q9" value="{{isset($reportResult->art_clinic_qtr_end_q9)? $reportResult->art_clinic_qtr_end_q9:'' }}" class="form-control number-only secondval" placeholder="Number" >
            <span class="text-danger small fs-6 error-msg" id="art_clinic_qtr_9_error_msg">@error('art_clinic_qtr_9_error_msg') {{ $message }} @enderror</span>
            </td>
            <td rowspan="3"><input type="text" name="tno_qtr_end_q9"  id="tno_qtr_end_q9" value="" class="form-control h-s" placeholder="Total Number" readonly></td>
        </tr>

        <tr>
            <td class="text-start">ART Banks</td>
            <td><input type="text" name="art_banks_q9"  id="art_banks_q9" value="{{isset($reportResult->art_banks_q9)? $reportResult->art_banks_q9:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="art_banks_left_9_error_msg">@error('art_banks_left_9_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="art_banks_qtr_end_q9"  id="art_banks_qtr_end_q9" value="{{isset($reportResult->art_banks_qtr_end_q9)? $reportResult->art_banks_qtr_end_q9:'' }}" class="form-control number-only secondval" placeholder="Number" >
                <span class="text-danger small fs-6 error-msg" id="art_banks_qtr_9_error_msg">@error('art_banks_qtr_9_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>

        <tr>
            <td class="text-start">Surrogacy Clinic</td>
            <td><input type="text" name="surrogacy_clinic_q9"  id="surrogacy_clinic_q9" value="{{isset($reportResult->surrogacy_clinic_q9)? $reportResult->surrogacy_clinic_q9:'' }}" class="form-control number-only firstval" placeholder="Number" ><span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_left_9_error_msg">@error('surrogacy_clinic_left_9_error_msg') {{ $message }} @enderror</span></td>
            <td><input type="text" name="surrogacy_clinic_qtr_end_q9"  id="surrogacy_clinic_qtr_end_q9" value="{{isset($reportResult->surrogacy_clinic_qtr_end_q9)? $reportResult->surrogacy_clinic_qtr_end_q9:'' }}" class="form-control number-only secondval" placeholder="Number" >
             <span class="text-danger small fs-6 error-msg" id="surrogacy_clinic_qtr_9_error_msg">@error('surrogacy_clinic_qtr_9_error_msg') {{ $message }} @enderror</span>
            </td>
        </tr>
    </tbody>
</table>
