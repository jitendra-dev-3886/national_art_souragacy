<div class="col-md-12 text-end">
    <span id="exportExcelBtn" class="btn btn-primary">Export to Excel</span>                          
</div>    
<table class="table table-bordered" id="usersTable">
    <thead class="table-secondary">
        <tr>
            <th rowspan="2" class="item-cell">Items</th>
            <th class="text-center" colspan="4">Selected Quarter</th>
            <th class="text-center" colspan="4">Upto Quarter's end</th>
        </tr>
        <tr>
            <th>ART Clinic</th>
            <th>ART Banks</th>
            <th>Surrogacy Clinic</th>
            <th>Total</th>
            
            <th>ART Clinic</th>
            <th>ART Banks</th>
            <th>Surrogacy Clinic</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>1.</strong> Number of applications received in the National Registry Portal in the State / UT:
            </td>
            <td>{{isset($reportResult->art_clinic_q1)? $reportResult->art_clinic_q1:'' }}</td>
            <td>{{isset($reportResult->art_banks_q1)? $reportResult->art_banks_q1:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q1)? $reportResult->surrogacy_clinic_q1:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q1 ?? 0)+ ($reportResult->art_banks_q1 ?? 0) + ($reportResult->surrogacy_clinic_q1 ?? 0) }}</td>
            <td>{{isset($reportResult->art_clinic_qtr_end_q1)? $reportResult->art_clinic_qtr_end_q1:'' }} </td>                  
            <td>{{isset($reportResult->art_banks_qtr_end_q1)? $reportResult->art_banks_qtr_end_q1:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q1)? $reportResult->surrogacy_clinic_qtr_end_q1:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q1 ?? 0)+ ($reportResult->art_banks_qtr_end_q1 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q1 ?? 0) }}
        </td></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>2.</strong> Number of applications received (Complete in all respects along with Registration fees) by the State / UT:
            </td>
            <td>{{isset($reportResult->art_clinic_q2)? $reportResult->art_clinic_q2:'' }}</td>
            <td>{{isset($reportResult->art_banks_q2)? $reportResult->art_banks_q2:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q2)? $reportResult->surrogacy_clinic_q2:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q2 ?? 0)+ ($reportResult->art_banks_q2 ?? 0) + ($reportResult->surrogacy_clinic_q2 ?? 0) }}</td>
            <td>{{isset($reportResult->art_clinic_qtr_end_q2)? $reportResult->art_clinic_qtr_end_q2:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q2)? $reportResult->art_banks_qtr_end_q2:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q2)? $reportResult->surrogacy_clinic_qtr_end_q2:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q2 ?? 0)+ ($reportResult->art_banks_qtr_end_q2 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q2 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>3.</strong> Number of Clinic or Banks Registered in the State / UT:
            </td>
            <td>{{isset($reportResult->art_clinic_q3)? $reportResult->art_clinic_q3:'' }}</td>
            <td>{{isset($reportResult->art_banks_q3)? $reportResult->art_banks_q3:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q3)? $reportResult->surrogacy_clinic_q3:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q3 ?? 0)+ ($reportResult->art_banks_q3 ?? 0) + ($reportResult->surrogacy_clinic_q3 ?? 0) }}</td>
            <td>{{isset($reportResult->art_clinic_qtr_end_q3)? $reportResult->art_clinic_qtr_end_q3:'' }}</td>        
            <td>{{isset($reportResult->art_banks_qtr_end_q3)? $reportResult->art_banks_qtr_end_q3:'' }}</td>   
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q3)? $reportResult->surrogacy_clinic_qtr_end_q3:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q3 ?? 0)+ ($reportResult->art_banks_qtr_end_q3 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q3 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>4.</strong> Of the Number shown in item (3) above, number of establishments in the Government run institutes in the State / UT:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q4)? $reportResult->art_clinic_q4:'' }}</td>
            <td>{{isset($reportResult->art_banks_q4)? $reportResult->art_banks_q4:'' }}</td>
            <td id="surrogacy_clinic_q4">{{isset($reportResult->surrogacy_clinic_q4)? $reportResult->surrogacy_clinic_q4:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q4 ?? 0)+ ($reportResult->art_banks_q4 ?? 0) + ($reportResult->surrogacy_clinic_q4 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q4)? $reportResult->art_clinic_qtr_end_q4:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q4)? $reportResult->art_banks_qtr_end_q4:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q4)? $reportResult->surrogacy_clinic_qtr_end_q4:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q4 ?? 0)+ ($reportResult->art_banks_qtr_end_q4 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q4 ?? 0) }}</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td class="item-cell">
                <strong>5.</strong> Of the number shown in item (3) above, number of Private clinics or banks in the State/UT:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q5)? $reportResult->art_clinic_q5:'' }}</td>
            <td>{{isset($reportResult->art_banks_q5)? $reportResult->art_banks_q5:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q5)? $reportResult->surrogacy_clinic_q5:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q5 ?? 0)+ ($reportResult->art_banks_q5 ?? 0) + ($reportResult->surrogacy_clinic_q5 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q5)? $reportResult->art_clinic_qtr_end_q5:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q5)? $reportResult->art_banks_qtr_end_q5:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q5)? $reportResult->surrogacy_clinic_qtr_end_q5:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q5 ?? 0)+ ($reportResult->art_banks_qtr_end_q5 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q5 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>6.</strong> Number of Applications rejected for registration of clinics or banks:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q6)? $reportResult->art_clinic_q6:'' }}</td>
            <td>{{isset($reportResult->art_banks_q6)? $reportResult->art_banks_q6:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q6)? $reportResult->surrogacy_clinic_q6:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q6 ?? 0)+ ($reportResult->art_banks_q6 ?? 0) + ($reportResult->surrogacy_clinic_q6 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q6)? $reportResult->art_clinic_qtr_end_q6:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q6)? $reportResult->art_banks_qtr_end_q6:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q6)? $reportResult->surrogacy_clinic_qtr_end_q6:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q6 ?? 0)+ ($reportResult->art_banks_qtr_end_q6 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q6 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>7.</strong> Number of Applications received on the portal but later cancelled or withdrawn in respect of:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q7)? $reportResult->art_clinic_q7:'' }}</td>
            <td>{{isset($reportResult->art_banks_q7)? $reportResult->art_banks_q7:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q7)? $reportResult->surrogacy_clinic_q7:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q7 ?? 0)+ ($reportResult->art_banks_q7 ?? 0) + ($reportResult->surrogacy_clinic_q7 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q7)? $reportResult->art_clinic_qtr_end_q7:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q7)? $reportResult->art_banks_qtr_end_q7:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q7)? $reportResult->surrogacy_clinic_qtr_end_q7:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q7 ?? 0)+ ($reportResult->art_banks_qtr_end_q7 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q7 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>8.</strong> Number of applications pending beyond the prescribed period: 
            </td>                   
            <td>{{isset($reportResult->art_clinic_q8)? $reportResult->art_clinic_q8:'' }}</td>
            <td>{{isset($reportResult->art_banks_q8)? $reportResult->art_banks_q8:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q8)? $reportResult->surrogacy_clinic_q8:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q8 ?? 0)+ ($reportResult->art_banks_q8 ?? 0) + ($reportResult->surrogacy_clinic_q8 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q8)? $reportResult->art_clinic_qtr_end_q8:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q8)? $reportResult->art_banks_qtr_end_q8:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q8)? $reportResult->surrogacy_clinic_qtr_end_q8:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q8 ?? 0)+ ($reportResult->art_banks_qtr_end_q8 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q8 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>9.</strong> A Number of clinics which are not Registered:                     
                <p class="fst-italic small">(<a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=> 1])}}" target="_blank" >View Annexure-I </a>)<p>
            </td>                   
            <td>{{isset($reportResult->art_clinic_q9)? $reportResult->art_clinic_q9:'' }}</td>
            <td>{{isset($reportResult->art_banks_q9)? $reportResult->art_banks_q9:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q9)? $reportResult->surrogacy_clinic_q9:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q9 ?? 0)+ ($reportResult->art_banks_q9 ?? 0) + ($reportResult->surrogacy_clinic_q9 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q9)? $reportResult->art_clinic_qtr_end_q9:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q9)? $reportResult->art_banks_qtr_end_q9:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q9)? $reportResult->surrogacy_clinic_qtr_end_q9:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q9 ?? 0)+ ($reportResult->art_banks_qtr_end_q9 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q9 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>10.</strong> Number Of applications received for renewals of registration certificate:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q10)? $reportResult->art_clinic_q10:'' }}</td>
            <td>{{isset($reportResult->art_banks_q10)? $reportResult->art_banks_q10:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q10)? $reportResult->surrogacy_clinic_q10:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q10 ?? 0)+ ($reportResult->art_banks_q10 ?? 0) + ($reportResult->surrogacy_clinic_q10 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q10)? $reportResult->art_clinic_qtr_end_q10:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q10)? $reportResult->art_banks_qtr_end_q10:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q10)? $reportResult->surrogacy_clinic_qtr_end_q10:'' }}</td>
            <td >{{ ($reportResult->art_clinic_qtr_end_q10 ?? 0)+ ($reportResult->art_banks_qtr_end_q10 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q10 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>11.</strong> Out of (10) above, applications of delayed renewal received:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q11)? $reportResult->art_clinic_q11:'' }}</td>
            <td>{{isset($reportResult->art_banks_q11)? $reportResult->art_banks_q11:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q11)? $reportResult->surrogacy_clinic_q11:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q11 ?? 0)+ ($reportResult->art_banks_q11 ?? 0) + ($reportResult->surrogacy_clinic_q11 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q11)? $reportResult->art_clinic_qtr_end_q11:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q11)? $reportResult->art_banks_qtr_end_q11:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q11)? $reportResult->surrogacy_clinic_qtr_end_q11:'' }}</td>
            <td >{{ ($reportResult->art_clinic_qtr_end_q11 ?? 0)+ ($reportResult->art_banks_qtr_end_q11 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q11 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>12.</strong> Number of renewals granted:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q12)? $reportResult->art_clinic_q12:'' }}</td>
            <td>{{isset($reportResult->art_banks_q12)? $reportResult->art_banks_q12:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q12)? $reportResult->surrogacy_clinic_q12:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q12 ?? 0)+ ($reportResult->art_banks_q12 ?? 0) + ($reportResult->surrogacy_clinic_q12 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q12)? $reportResult->art_clinic_qtr_end_q12:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q12)? $reportResult->art_banks_qtr_end_q12:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q12)? $reportResult->surrogacy_clinic_qtr_end_q12:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q12 ?? 0)+ ($reportResult->art_banks_qtr_end_q12 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q12 ?? 0) }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>13.</strong> Number of renewal applications rejected:
            </td>                   
            <td>{{isset($reportResult->art_clinic_q13)? $reportResult->art_clinic_q13:'' }}</td>
            <td>{{isset($reportResult->art_banks_q13)? $reportResult->art_banks_q13:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_q13)? $reportResult->surrogacy_clinic_q13:'' }}</td>
            <td>{{ ($reportResult->art_clinic_q13 ?? 0)+ ($reportResult->art_banks_q13 ?? 0) + ($reportResult->surrogacy_clinic_q13 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinic_qtr_end_q13)? $reportResult->art_clinic_qtr_end_q13:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_q13)? $reportResult->art_banks_qtr_end_q13:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinic_qtr_end_q13)? $reportResult->surrogacy_clinic_qtr_end_q13:'' }}</td>
            <td>{{ ($reportResult->art_clinic_qtr_end_q13 ?? 0)+ ($reportResult->art_banks_qtr_end_q13 ?? 0) + ($reportResult->surrogacy_clinic_qtr_end_q13 ?? 0) }}</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td class="item-cell">
                <strong>14 A.</strong>  Number of appeals received against the rejection of applications (Fresh registration/Renewal)
            </td>                   
            <td colspan="3">{{isset($reportResult->appeal_rej_app_a_q14)? $reportResult->appeal_rej_app_a_q14:'' }}</td>            
            <td>{{isset($reportResult->appeal_rej_app_a_q14)? $reportResult->appeal_rej_app_a_q14:'' }}</td>          
            <td colspan="3">{{isset($reportResult->appeal_rej_app_qtr_end_a_q14)? $reportResult->appeal_rej_app_qtr_end_a_q14:'' }}</td>             
            <td>{{isset($reportResult->appeal_rej_app_qtr_end_a_q14)? $reportResult->appeal_rej_app_qtr_end_a_q14:'' }}</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>14 B. </strong>Out of the above, number of appeals disposed off.
            </td>                   
            <td colspan="3">{{isset($reportResult->appeals_disposed_b_q14)? $reportResult->appeals_disposed_b_q14:'' }}</td>
            
            <td >{{isset($reportResult->appeals_disposed_b_q14)? $reportResult->appeals_disposed_b_q14:'' }}</td>          
            <td colspan="3">{{isset($reportResult->appeals_disposed_qtr_end_b_q14)? $reportResult->appeals_disposed_qtr_end_b_q14:'' }}</td>
            
            <td >{{isset($reportResult->appeals_disposed_qtr_end_b_q14)? $reportResult->appeals_disposed_qtr_end_b_q14:'' }}</td>                   
        </tr>
    </tbody>
    
    <tbody>
        <tr>
            <td colspan="9" class="text-start bg-light">
                <strong>Complaints, Action taken, Cases filed in court and penal provisions details  </strong>
            </td>
        </tr>
   
        <tr>
            <td class="item-cell">
                <strong>15.</strong> Number of complaints received by the Appropriate Authorities under the Act:
                    <p class="fst-italic small">(<a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>2])}}" target="_blank" > View Annexure-II</a>)<p>
                    <p>i: Forwarded by Department of Health Research</p>
            </td>                   
            <td colspan="3"> {{isset($reportResult->forwarded_dhr_i_q15)? $reportResult->forwarded_dhr_i_q15:'' }} </td>
      
            <td  rowspan="3"> 
                {{ ($reportResult->forwarded_dhr_i_q15 ?? 0) + ($reportResult->received_stakeholders_ii_q15 ?? 0) + ($reportResult->suo_moto_cognizancеr_iii_q15 ?? 0)}}
                
                </td>          
            <td colspan="3">{{isset($reportResult->forwarded_dhr_qtr_end_i_q15)? $reportResult->forwarded_dhr_qtr_end_i_q15:'' }} </td>
           
            <td rowspan="3">
                {{ ($reportResult->forwarded_dhr_qtr_end_i_q15 ?? 0) + ($reportResult->received_stakeholders_qtr_end_ii_q15 ?? 0) + ($reportResult->suo_moto_cognizancеr_qtr_end_iii_q15 ?? 0)}}
            </td>                   
        </tr>
            <tr>
            <td class="item-cell">                        
                    <p>ii. Received from other Stakeholders</p>
            </td>                   
            <td colspan="3" class="text-start">{{isset($reportResult->received_stakeholders_ii_q15)? $reportResult->received_stakeholders_ii_q15:'' }}</td>
           
                      
            <td colspan="3" class="text-start">{{isset($reportResult->received_stakeholders_qtr_end_ii_q15)? $reportResult->received_stakeholders_qtr_end_ii_q15:'' }}</td>
                         
        </tr>
            <tr>
            <td class="item-cell">
                
                    <p>iii. Suo-moto Cognizancе</p>
            </td>                   
            <td colspan="3" class="text-start">{{isset($reportResult->suo_moto_cognizancеr_iii_q15)? $reportResult->suo_moto_cognizancеr_iii_q15:'' }}</td>
          
            <td colspan="3" class="text-start">{{isset($reportResult->suo_moto_cognizancеr_qtr_end_iii_q15)? $reportResult->suo_moto_cognizancеr_qtr_end_iii_q15:'' }}</td>
                         
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>16 A. </strong>Action taken w.r.t. complaints at point (15) above:
                <p>Inspection of premises, search and seizure of documents or records, summoning of associated persons etc.</p>
                <p>  [Powers drawn from Sec. 14(1) & 40(1) of ART (Regulation) Act, 2021<br>
        and Sec. 37(1) & 47(1) of Surrogacy (Regulation) Act, 2021]</p>
            </td>                   
            <td colspan="3">{{isset($reportResult->action_taken_a_q16)? $reportResult->action_taken_a_q16:'' }}</td>             
            <td>{{isset($reportResult->action_taken_a_q16)? $reportResult->action_taken_a_q16:'' }}</td>     
            <td colspan="3">{{isset($reportResult->action_taken_qtr_end_a_q16)? $reportResult->action_taken_qtr_end_a_q16:'' }}</td>
            
            <td>{{isset($reportResult->action_taken_qtr_end_a_q16)? $reportResult->action_taken_qtr_end_a_q16:'' }}</td>               
        </tr>
        <tr>
            <td class="item-cell">                        
                <p><strong>16 B.</strong> Number of suspensions or cancellations of registration in the State/UT under Section 18 of ART (Regulation) Act and Section 13 of Surrogacy (Regulation) Act, 2021 in respect of:
                (<a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>2])}}" target="_blank" >View Annexure-II</a>)
                </p>
                                
            </td>                   
            <td>{{isset($reportResult->art_clinics_b_q16)? $reportResult->art_clinics_b_q16:'' }}</td>
            <td>{{isset($reportResult->art_banks_b_q16)? $reportResult->art_banks_b_q16:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinics_b_q16)? $reportResult->surrogacy_clinics_b_q16:'' }}</td>

            <td> {{ ($reportResult->art_clinics_b_q16 ?? 0) + ($reportResult->art_banks_b_q16 ?? 0) + ($reportResult->surrogacy_clinics_b_q16 ?? 0) }}</td>          
            <td>{{isset($reportResult->art_clinics_qtr_end_b_q16)? $reportResult->art_clinics_qtr_end_b_q16:'' }}</td>
            <td>{{isset($reportResult->art_banks_qtr_end_b_q16)? $reportResult->art_banks_qtr_end_b_q16:'' }}</td>
            <td>{{isset($reportResult->surrogacy_clinics_qtr_end_b_q16)? $reportResult->surrogacy_clinics_qtr_end_b_q16:'' }}</td>
            <td>{{ ($reportResult->art_clinics_qtr_end_b_q16 ?? 0) + ($reportResult->art_banks_qtr_end_b_q16 ?? 0) + ($reportResult->surrogacy_clinics_qtr_end_b_q16 ?? 0) }}</td>                   
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>17 A.</strong> Number of appeals received against
        suspension or cancellation of registration of clinics or banks
            </td>                   
            <td colspan="3">{{isset($reportResult->appeal_received_a_q17)? $reportResult->appeal_received_a_q17:'' }}</td>            
            <td rowspan="2">
                  {{ ($reportResult->appeal_received_a_q17 ?? 0)+ ($reportResult->appeals_disposed_b_q17 ?? 0)}}
              </td>          
            <td colspan="3">{{isset($reportResult->appeal_received_qtr_end_a_q17)? $reportResult->appeal_received_qtr_end_a_q17:'' }}</td>            
            <td rowspan="2">
                 {{ ($reportResult->appeal_received_qtr_end_a_q17 ?? 0)+ ($reportResult->appeals_disposed_qtr_end_b_q17 ?? 0)}}
            </td>
        </tr>     
        <tr>
            <td class="item-cell">
                <strong>17 B.</strong> Out of the above, number of appeals disposed off.
            </td>                   
            <td colspan="3">{{isset($reportResult->appeals_disposed_b_q17)? $reportResult->appeals_disposed_b_q17:'' }}</td>
                          
            <td colspan="3" class="text-start">{{isset($reportResult->appeals_disposed_qtr_end_b_q17)? $reportResult->appeals_disposed_qtr_end_b_q17:'' }}</td>
            
                         
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>18.</strong>Number of complaints filed in courts in the State/UT:
                as per Sec. 35 of ART(Regulation) Act and Sec. 44 of the Surrogacy(Regulation) Act 2021:
                <p>(<a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>3])}}" target="_blank">View Annexure-III</a>)</p>
            </td>                   
            <td colspan="3">{{isset($reportResult->complaints_filed_q18)? $reportResult->complaints_filed_q18:'' }}</td>
            
            <td>{{isset($reportResult->complaints_filed_q18)? $reportResult->complaints_filed_q18:'' }}</td>          
            <td colspan="3">{{isset($reportResult->complaints_filed_qtr_end_q18)? $reportResult->complaints_filed_qtr_end_q18:'' }}</td>          
            <td>{{isset($reportResult->complaints_filed_qtr_end_q18)? $reportResult->complaints_filed_qtr_end_q18:'' }}</td>                   
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>22. </strong> Action taken in respect of Penal provisions under:
                <p class="fst-italic small"> <strong>1. </strong> Chapter V of ART<p>   
                <p class="fst-italic small">(<a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>3])}}" target="_blank">View Annexure-III</a>)<p>   
            </td>                   
            <td colspan="3">{{isset($reportResult->chapter_v_art_q22)? $reportResult->chapter_v_art_q22:'' }}</td>
           
            <td rowspan="2">{{ ($reportResult->chapter_v_art_q22 ?? 0)+ ($reportResult->surrogacy_chapter_vii_q22 ?? 0) }} </td>          
            <td colspan="3">{{isset($reportResult->chapter_v_art_qtr_end_q22)? $reportResult->chapter_v_art_qtr_end_q22:'' }}</td>
           
            <td rowspan="2"> {{ ($reportResult->chapter_v_art_qtr_end_q22 ?? 0)+ ($reportResult->surrogacy_chapter_qtr_end_vii_q22 ?? 0) }}  </td>    
                           
        </tr>      
        <tr>
            <td class="item-cell">
                    
                <p class="fst-italic small"> <strong>2. </strong> Chapter VII of surrogacy<p>   
                
            </td>                   
             
            <td colspan="3">{{isset($reportResult->surrogacy_chapter_vii_q22)? $reportResult->surrogacy_chapter_vii_q22:'' }}</td>                
            <td colspan="3">{{isset($reportResult->surrogacy_chapter_qtr_end_vii_q22)? $reportResult->surrogacy_chapter_qtr_end_vii_q22:'' }}</td>
                                         
        </tr>                   
    </tbody>
    <tbody>
         <tr>
            <td colspan="9" class="text-start bg-light">
                <strong>Details of certificates issued in connection with Surrogacy (Regulation) Act, 2021 [Sec.4]  </strong>
            </td>
        </tr>  
        <tr> 
            <td>
                <strong>19 A. </strong> Number of applications received for:-
                <p>    <strong>i.</strong> Certificate of Essentiality to Intending Couple/Intending woman</p>
            </td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_i_a_q19)? $reportResult->applications_received_i_a_q19:'' }}</td>
            <td  rowspan="4">
                  {{ ($reportResult->applications_received_i_a_q19 ?? 0)+ ($reportResult->applications_received_ii_a_q19 ?? 0)+ ($reportResult->applications_received_iii_a_q19 ?? 0)+ ($reportResult->applications_received_iv_a_q19 ?? 0)}}
            </td>          
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_qtr_end_i_a_q19)? $reportResult->applications_received_qtr_end_i_a_q19:'' }}</td>
            <td  rowspan="4">{{ ($reportResult->applications_received_qtr_end_i_a_q19 ?? 0)+ ($reportResult->applications_received_qtr_end_ii_a_q19 ?? 0)+ ($reportResult->applications_received_qtr_end_iii_a_q19 ?? 0)+ ($reportResult->applications_received_qtr_end_iv_a_q19 ?? 0)}}</td>                   
        </tr>
            <tr> 
            <td><strong>ii. </strong> Eligibility Certificate to Surrogate Mother</td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_ii_a_q19)? $reportResult->applications_received_ii_a_q19:'' }}</td>            
             
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_qtr_end_ii_a_q19)? $reportResult->applications_received_qtr_end_ii_a_q19:'' }}</td>                              
        </tr>
        <tr> 
            <td>                    
                <strong>iii. </strong> Eligibility Certificate to Intending Couple/Intending woman</td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_iii_a_q19)? $reportResult->applications_received_iii_a_q19:'' }}</td>                    
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_qtr_end_iii_a_q19)? $reportResult->applications_received_qtr_end_iii_a_q19:'' }}</td>                               
        </tr>
        <tr> 
            <td>                    
                <strong>iv. </strong> Authorisation of Medical Termination of Pregnancy having written consent of the Surrogate Mother
            </td> 
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_iv_a_q19)? $reportResult->applications_received_iv_a_q19:'' }}</td>                 
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_received_qtr_end_iv_a_q19)? $reportResult->applications_received_qtr_end_iv_a_q19:'' }}</td>                            
        </tr>

            <tr> 
            <td>
            <strong>19 B. </strong> Out of the applications received as per A above, number of certificates granted:-
                <p><strong>i.</strong> Certificate of Essentiality to Intending Couple/Intending woman </p>
            </td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_i_b_q19)? $reportResult->applications_granted_i_b_q19:'' }}</td>
            <td rowspan="4">
                 {{ ($reportResult->applications_granted_i_b_q19 ?? 0)+ ($reportResult->applications_granted_ii_b_q19 ?? 0)+ ($reportResult->applications_granted_iii_b_q19 ?? 0)+ ($reportResult->applications_granted_iv_b_q19 ?? 0)}}
               </td>          
             
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_qtr_end_i_b_q19)? $reportResult->applications_granted_qtr_end_i_b_q19:'' }}</td>
            <td rowspan="4">
                  {{ ($reportResult->applications_granted_qtr_end_i_b_q19 ?? 0)+ ($reportResult->applications_granted_qtr_end_ii_b_q19 ?? 0)+ ($reportResult->applications_granted_qtr_end_iii_b_q19 ?? 0)+ ($reportResult->applications_granted_qtr_end_iv_b_q19 ?? 0) }}
            </td>                   
        </tr>
            <tr> 
            <td>   
                    <strong>ii. </strong> Eligibility Certificate to Surrogate Mother 
            </td>                   
          
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_ii_b_q19)? $reportResult->applications_granted_ii_b_q19:'' }}</td>
        
          
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_qtr_end_ii_b_q19)? $reportResult->applications_granted_qtr_end_ii_b_q19:'' }}</td>
                             
        </tr>
        <tr> 
            <td>   
                    <strong>iii. </strong>Eligibility Certificate to Intending Couple/Intending woman
            </td>                   
             
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_iii_b_q19)? $reportResult->applications_granted_iii_b_q19:'' }}</td>
             
             
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_qtr_end_iii_b_q19)? $reportResult->applications_granted_qtr_end_iii_b_q19:'' }}</td>
         </tr>
        <tr><td><strong>iv. </strong> Authorisation of Medical Termination of Pregnancy having written consent of the Surrogate Mother</td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_iv_b_q19)? $reportResult->applications_granted_iv_b_q19:'' }}</td>
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_granted_qtr_end_iv_b_q19)? $reportResult->applications_granted_qtr_end_iv_b_q19:'' }}</td>
                          
        </tr>
        <tr> 
            <td>   
                    <strong>19 C. </strong> Out of the applications received as per A above, number of applications rejected:-
                <p><strong>i. </strong> Certificate of Essentiality to Intending Couple/Intending woman </p>
            </td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_i_c_q19)? $reportResult->applications_rejected_i_c_q19:'' }}</td>
            <td rowspan="4">
                {{ ($reportResult->applications_rejected_i_c_q19 ?? 0)+ ($reportResult->applications_rejected_ii_c_q19 ?? 0)+ ($reportResult->applications_rejected_iii_c_q19 ?? 0)+ ($reportResult->applications_rejected_iv_c_q19 ?? 0) }}
            </td>          
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_qtr_end_i_c_q19)? $reportResult->applications_rejected_qtr_end_i_c_q19:'' }}</td>
            <td rowspan="4">{{ ($reportResult->applications_rejected_qtr_end_i_c_q19 ?? 0)+ ($reportResult->applications_rejected_qtr_end_ii_c_q19 ?? 0)+ ($reportResult->applications_rejected_qtr_end_iii_c_q19 ?? 0)+ ($reportResult->applications_rejected_qtr_end_iv_c_q19 ?? 0) }}
            </td>                   
        </tr>
        <tr> 
            <td><strong>ii. </strong> Eligibility Certificate to Surrogate Mother </td>                   
           
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_ii_c_q19)? $reportResult->applications_rejected_ii_c_q19:'' }}</td>
                
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_qtr_end_ii_c_q19)? $reportResult->applications_rejected_qtr_end_ii_c_q19:'' }}</td>
           
        </tr>
        <tr> 
            <td><strong>iii. </strong> Eligibility Certificate to Intending Couple/Intending woman</td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_iii_c_q19)? $reportResult->applications_rejected_iii_c_q19:'' }}</td>
             
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_qtr_end_iii_c_q19)? $reportResult->applications_rejected_qtr_end_iii_c_q19:'' }}</td>
                           
        </tr>
                <tr> 
            <td> 
                <p><strong>iv. </strong>Authorisation of Medical Termination of
        Pregnancy having written consent of the Surrogate Mother</p>
            </td>                   
           
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_iv_c_q19)? $reportResult->applications_rejected_iv_c_q19:'' }}</td>
           
            <td class="text-start" colspan="3">{{isset($reportResult->applications_rejected_qtr_end_iv_c_q19)? $reportResult->applications_rejected_qtr_end_iv_c_q19:'' }}</td>
                             
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td class="item-cell">
                <strong>20 A.</strong> Number of Appeals received against rejection of certificate at point 19(C) above.
            </td>                   
           
            <td class="text-start" colspan="3">{{isset($reportResult->appeals_against_rejection_a_q20)? $reportResult->appeals_against_rejection_a_q20:'' }}</td>
            <td rowspan="2">{{ ($reportResult->appeals_against_rejection_a_q20 ?? 0)+ ($reportResult->appeals_disposed_b_q20 ?? 0) }}</td>          
             
            <td colspan="3">{{isset($reportResult->appeals_against_rejection_qtr_end_a_q20)? $reportResult->appeals_against_rejection_qtr_end_a_q20:'' }}</td>
            <td rowspan="2">{{ ($reportResult->appeals_against_rejection_qtr_end_a_q20 ?? 0)+ ($reportResult->appeals_disposed_qtr_end_b_q20 ?? 0) }}</td>                   
        </tr>
            <tr>
            <td class="item-cell">
                <strong>20 B.</strong> Number of Such Appeals disposed off. 
            </td>                   
             
            <td class="text-start" colspan="3">{{isset($reportResult->appeals_disposed_b_q20)? $reportResult->appeals_disposed_b_q20:'' }}</td>                   
            
            <td class="text-start" colspan="3">{{isset($reportResult->appeals_disposed_qtr_end_b_q20)? $reportResult->appeals_disposed_qtr_end_b_q20:'' }}</td>
                              
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td colspan="9" class="text-start bg-light">
                <strong>Meeting details</strong>
            </td>
        </tr>  
        <tr>
            <td class="item-cell">
                <strong>21.</strong> Date(s) of the meetings of the State Board constituted under section 27 of the Act [Sec 29(1) - meeting at least once in 4 months].
            </td>                   
            <td  colspan="4" class="text-start">{!! $reportResult->meeting_state_date_list !!}
            </td> 
            <td  colspan="4" class="text-start">{!! $reportResult->meeting_state_date_qtr_end_q21_list !!}
                </button>
            </td>
                                
        </tr>                   
    </tbody>    
</table> 
<div>  
    <h5><span class="fw-bold"><br />	Annexure Details:- <hr />Annexure I (Compilation of all States)</span></h5>
</div>
<div class="col-md-12 text-end"> 
    <span id="exportExcelBtnAnnexureI" class="btn btn-primary">Export to Excel</span>
</div>    
<table class="table table-bordered main-tables" id="usersTableAnnex1">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
                <th>State</th>
            <th>Name of the Clinic/Bank</th>
            <th>Operating since</th>
            <th colspan="2">Action taken</th>
        </tr>
    </thead>
    <tbody>
            @php $i=1;                             
            @endphp
        @if(count($reportInfo['annexure_i'])>0) 
        @if(isset($reportInfo['annexure_i'])) 
            @foreach ($reportInfo['annexure_i'] as $row )     
            <tr class="row-template @if($i==1) q9-row @endif">
                <td>{{$i}}</td>
                    <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                <td>{{isset($row->clinic_name)? $row->clinic_name:'Nill' }}</td>
                <td>{{isset($row->operating_since)? date("d-m-Y",strtotime($row->operating_since)):'Nill' }}</td>
                <td>{{isset($row->action_taken)? $row->action_taken:'Nill' }}</td>
            </tr>      
            @php $i++; @endphp 
            @endforeach
        @endif  
        @else
        <tr class="row-template @if($i==1) q9-row @endif">
            <td>{{$i}}</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
        </tr> 
        @endif  
    </tbody>
</table> 
<div><h5><span class="fw-bold">Annexure II (Compilation of all States)</span></h5></div>
<div class="col-md-12 text-end"> 
    <span id="exportExcelBtnAnnexureII" class="btn btn-primary">Export to Excel</span>
</div> 
<table class="table table-bordered main-tables" id="usersTableAnnex2">
    <thead class="table-light">
        <tr>
        <th>S.No</th>
            <th>State</th>
        <th>Complaint forwarded by DHR/ other stakeholders/ suomoto cognizance</th>
        <th>Complaint filed by</th>
        <th>Complaint filed against (Name of the Clinic/bank/Person)</th>
        <th>Details of issues involved</th>
        <th>Details of Action taken (viz. inspection, search/seizure etc.)</th>
        <th>Final outcome of the complaint viz. suspension/ cancellation of registration/ Others</th>
        </tr>
    </thead>
    
    <tbody>
            @php $i=1;                             
            @endphp
        @if(count($reportInfo['annexure_ii'])>0) 
        @if(isset($reportInfo['annexure_ii'])) 
            @foreach ($reportInfo['annexure_ii'] as $row )     
            <tr class="row-template @if($i==1) q9-row @endif">
                <td>{{$i}}</td>
                <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                <td>{{isset($row->complaint_source)? $row->complaint_source:'Nill' }}</td>
                <td>{{isset($row->filed_by)? $row->filed_by:'Nill' }}</td>
                <td>{{isset($row->filed_against)? $row->filed_against:'Nill' }}</td>
                <td>{{isset($row->issue_details)? $row->issue_details:'Nill' }}</td>                                    
                <td>{{isset($row->outcome)? $row->outcome:'Nill' }}</td>
                <td>{{isset($row->action_taken)? $row->action_taken:'Nill' }}</td>
            </tr>      
            @php $i++; @endphp 
            @endforeach
        @endif  
        @else
        <tr class="row-template @if($i==1) q9-row @endif">
            <td>{{$i}}</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
        </tr> 
        @endif  
    </tbody>
</table>
<div><h5><span class="fw-bold">Annexure III (Compilation of all States)</span></h5></div>
<div class="col-md-12 text-end"> 
    <span id="exportExcelBtnAnnexureIII" class="btn btn-primary">Export to Excel</span>
</div>
<table class="table table-bordered main-tables" id="usersTableAnnex3">
    <thead class="table-light">
    <tr>
    <th>S.No</th>
        <th>State</th>
    <th>Case filed by</th>
    <th>Case filed against (Name of the Clinic/bank/Persons)</th>
    <th>Section and Act, for violation of which cases were filed</th>
    <th>Details of issues involved</th>
    <th>No. of persons arrested</th>
    <th>Final outcome of the cases</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
            @php $i=1;  @endphp
    @if(count($reportInfo['annexure_iii'])>0) 
        @if(isset($reportInfo['annexure_iii'])) 
            @foreach ($reportInfo['annexure_iii'] as $row )     
            <tr class="row-template @if($i==1) q9-row @endif">
                <td>{{$i}}</td>
                <td>{{isset($row->state_name)? $row->state_name:'Nill' }}</td>
                <td>{{isset($row->case_filed_by)? $row->case_filed_by:'Nill' }}</td>
                <td>{{isset($row->case_filed_against)? $row->case_filed_against:'Nill' }}</td>
                <td>{{isset($row->section_act_for_violation)? $row->section_act_for_violation:'Nill' }}</td>
                <td>{{isset($row->issue_details)? $row->issue_details:'Nill' }}</td>                                    
                <td>{{isset($row->persons_arrested)? $row->persons_arrested:'Nill' }}</td>
                <td>{{isset($row->case_outcome)? $row->case_outcome:'Nill' }}</td>
            </tr>      
            @php $i++; @endphp 
            @endforeach
        @endif  
        @else
        <tr class="row-template @if($i==1) q9-row @endif">
            <td>{{$i}}</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
            <td>Nill</td>
        </tr> 
        @endif
</table>
<div class="row">  
    
    <?php // print_r($reportInfo['annexure_i']); ?>
    <div class="col-md-4">
    <a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=> 1])}}" class="btn btn-primary" target="_blank" >
    Annexure-I (For Point 9 of the Format) 
    </a>
    </div>
    <div class="col-md-4">
     <a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>2])}}" class="btn btn-primary" target="_blank" >
    Annexure-II (For Point 15 & 16 of the Format)
   </a>
    </div>
    <div class="col-md-4 text-right">
      <a href="{{route('report.ConsolidatedQuarterlyAnnexureReport', ['report' => $reportInfo['report'],'type'=>3])}}" class="btn btn-primary" target="_blank" >
    Annexure-III (For Point 18 & 22 of the Format)
    </a>
    </div>
</div>
 
