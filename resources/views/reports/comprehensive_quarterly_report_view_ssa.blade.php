@extends('layouts.admin.ssa_master')
   <link href="{{ url('public/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ url('public/css/app.css') }}" rel="stylesheet">
@section('content')
<style nonce="{{ $cspNonce }}">
.no-capitalize {
  text-transform: none !important;
}
</style>
<div class="content-bodys">
    <div class="container-fluid" id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center border main-tital rounded-top-4 py-5">
                    <h2 class="text-dark">View Quarterly report to be submitted by the <br>State / UT Appropriate Authority</h2>
                </div>     
            </div>
                          
            <form id="multi-step-form" name="quarterlyreportfrm">  
               
                <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-5 shadow-sm">
                    <div class="row">
                        <div class="col-md-6">
                           <p  class="form-label">Report For Quarter ended on: <span class="fw-bold">{{ $reportResult->description; }} {{ $reportResult->year; }}</span></p>
                           <p for="quarter" class="form-label">Name Of State / Union Territory:<span class="fw-bold"> {{$reportResult->state_name; }}</span></p>
                        </div>
                        <div class="col-md-6 text-end">                          
                           <a class="btn btn-secondary" href="{{route('report.QuarterlyreportPdf',  ['report_id'=> Crypt::encryptString($reportResult->report_id ?? 0)])}}" target="_blank">Export in PDF</a>
                        </div>
                    </div>                             
                </div>            
                <div class="rounded-4 pt-4">
                    <div class="progress px-1" style="height: 3px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: 0%;"
                            aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>
                        <div class="step-container d-flex justify-content-between">
                        <div class="step-circle active" data-step="1">1</div>
                        <div class="step-circle" data-step="2">2</div>
                        <div class="step-circle" data-step="3">3</div>
                        <div class="step-circle" data-step="4">4</div>
                    </div>

                     
                    <div class="step step-1">                                            
                        <div class="border p-2 p-lg-4 rounded-3 bg-white mb-4 shadow-sm table-responsive">
                                @include('reports.includes.view_reports.form_step1')
                               <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>
                    </div>

                    <div class="step step-2">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm ">
                            @include('reports.includes.view_reports.form_step2')       
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary prev-step">Previous</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>                                         
                        </div>
                    </div>

                    <div class="step step-3">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.view_reports.form_step3')
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary prev-step">Previous</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="step step-4">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.view_reports.form_annexure1')
                                                    
                        </div>
                        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.view_reports.form_annexure2')  
                        </div> --}}
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.view_reports.form_annexure2_q16')                                                                                           
                                                      
                        </div>
                        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">                          
                                    @include('reports.includes.view_reports.form_annexure3')                             
                           
                        </div> --}}
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">
                                        @include('reports.includes.view_reports.form_annexure3_q22') 
                        </div>              
                    </div>  
                </div> 
            </form>     
        </div>
    </div>
</div> 
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/app.js') }}"></script>
<script nonce="{{ $cspNonce }}">
//Code calculation for question 1 to 14   
 
    $(function () {
        for (let i = 1; i <= 14; i++) {
            if(i<=13){                 
                let art_clinic_q = Number($("#art_clinic_q" + i).html()) || 0;
                let art_banks_q = Number($("#art_banks_q" + i).html()) || 0;
                let surrogacy_clinic_q = Number($("#surrogacy_clinic_q" + i).html()) || 0;
                let totalRec = art_clinic_q + art_banks_q + surrogacy_clinic_q;
                $("#tno_q" + i).html(totalRec);                  
                let art = Number($("#art_clinic_qtr_end_q" + i).html()) || 0;
                let bank = Number($("#art_banks_qtr_end_q" + i).html()) || 0;
                let sur = Number($("#surrogacy_clinic_qtr_end_q" + i).html()) || 0;
                $("#tno_qtr_end_q" + i).html(art + bank + sur);
            } 
            if(i==14){                   
                let totalAppeal_rej = Number($("#appeal_rej_app_a_q" + i).html()) || 0;                    
                $("#tno_a_q" + i).html(totalAppeal_rej);

                    let totalAppeal_rej_qtr_end = Number($("#appeal_rej_app_qtr_end_a_q" + i).html()) || 0;  
                    $("#tno_qtr_end_a_q" + i).html(totalAppeal_rej_qtr_end);

                    let totalAppeals_disposed = Number($("#appeals_disposed_b_q" + i).html()) || 0;                    
                $("#tno_b_q" + i).html(totalAppeals_disposed);
                    let totalAppeal_rej_qtr_end_b_q = Number($("#appeals_disposed_qtr_end_b_q" + i).html()) || 0;  
                    $("#tno_qtr_end_b_q" + i).html(totalAppeal_rej_qtr_end_b_q);
            }
        } 
    });
     
    $(function () {
        //Code calculation for question 15 
        let forwarded_dhr_i_q15 = Number($("#forwarded_dhr_i_q15").html()) || 0;
        let received_stakeholders_ii_q15 = Number($("#received_stakeholders_ii_q15").html()) || 0;
        let suo_moto_cognizancеr_iii_q15 = Number($("#suo_moto_cognizancеr_iii_q15").html()) || 0;
        let totalq15 = forwarded_dhr_i_q15 + received_stakeholders_ii_q15 + suo_moto_cognizancеr_iii_q15;
        $("#tno_i_q15").html(totalq15);
        let forwarded_dhr_qtr_end_i_q15= Number($("#forwarded_dhr_qtr_end_i_q15").html()) || 0;  
        let received_stakeholders_qtr_end_ii_q15= Number($("#received_stakeholders_qtr_end_ii_q15").html()) || 0;  
        let suo_moto_cognizancеr_qtr_end_iii_q15 = Number($("#suo_moto_cognizancеr_qtr_end_iii_q15").html()) || 0; 
        let totalqtrend15 =forwarded_dhr_qtr_end_i_q15 + received_stakeholders_qtr_end_ii_q15 +  suo_moto_cognizancеr_qtr_end_iii_q15;          
        $("#tno_qtr_end_i_q15").html(totalqtrend15);
        //Code calculation for question 16 A
        let action_taken_a_q16= Number($("#action_taken_a_q16").html()) || 0;  
        $("#tno_a_q16").html(action_taken_a_q16);
        let action_taken_qtr_end_a_q16= Number($("#action_taken_qtr_end_a_q16").html()) || 0;  
        $("#tnb_qtr_end_a_q16").html(action_taken_qtr_end_a_q16);
        //Code calculation for question 16 B
        let art_clinics_b_q16 = Number($("#art_clinics_b_q16").html()) || 0;
        let art_banks_b_q16 = Number($("#art_banks_b_q16").html()) || 0;
        let surrogacy_clinics_b_q16 = Number($("#surrogacy_clinics_b_q16").html()) || 0;
        let totalRecQ16 = art_clinics_b_q16 + art_banks_b_q16 + surrogacy_clinics_b_q16;            
        $("#tno_b_q16").html(totalRecQ16);    
        let art_clinics_qtr_end_b_q16 = Number($("#art_clinics_qtr_end_b_q16").html()) || 0;
        let art_banks_qtr_end_b_q16 = Number($("#art_banks_qtr_end_b_q16").html()) || 0;
        let surrogacy_clinics_qtr_end_b_q16 = Number($("#surrogacy_clinics_qtr_end_b_q16").html()) || 0;
        let totalRecQtrQ16 = art_clinics_qtr_end_b_q16 + art_banks_qtr_end_b_q16 + surrogacy_clinics_qtr_end_b_q16;
        $("#tno_art_clinics_qtr_end_b_q16").html(totalRecQtrQ16);  
        //Code calculation for question 17 A
        let appeal_received_a_q17= Number($("#appeal_received_a_q17").html()) || 0;  
        $("#tno_a_q17").html(appeal_received_a_q17);
        let appeal_received_qtr_end_a_q17= Number($("#appeal_received_qtr_end_a_q17").html()) || 0;  
        $("#tno_qtr_end_a_q17").html(appeal_received_qtr_end_a_q17);
        let appeals_disposed_b_q17= Number($("#appeals_disposed_b_q17").html()) || 0;  
        $("#tno_b_q17").html(appeals_disposed_b_q17);
        //Code calculation for question 17 B
        let appeals_disposed_qtr_end_b_q17= Number($("#appeals_disposed_qtr_end_b_q17").html()) || 0;  
        $("#tno_qtr_end_b_q17").html(appeals_disposed_qtr_end_b_q17);
            //Code calculation for question 18
            let complaints_filed_q18= Number($("#complaints_filed_q18").html()) || 0;  
            $("#tno_q18").html(complaints_filed_q18);
        let complaints_filed_qtr_end_q18= Number($("#complaints_filed_qtr_end_q18").html()) || 0;  
        $("#tno_qtr_end_q18").html(complaints_filed_qtr_end_q18);
            //Code calculation for question 19 a
        let total_a_q19  = 0;
        total_a_q19 += Number($("#applications_received_i_a_q19").html()) || 0;
        total_a_q19 += Number($("#applications_received_ii_a_q19").html()) || 0;
        total_a_q19 += Number($("#applications_received_iii_a_q19").html()) || 0;
        total_a_q19 += Number($("#applications_received_iv_a_q19").html()) || 0;   
        $("#tno_i_a_q19").html(total_a_q19);
        let total_qtr_a_q19  = 0;
        total_qtr_a_q19 += Number($("#applications_received_qtr_end_i_a_q19").html()) || 0;
        total_qtr_a_q19 += Number($("#applications_received_qtr_end_ii_a_q19").html()) || 0;
        total_qtr_a_q19 += Number($("#applications_received_qtr_end_iii_a_q19").html()) || 0;
        total_qtr_a_q19 += Number($("#applications_received_qtr_end_iv_a_q19").html()) || 0;   
        $("#tno_qtr_end_i_a_q19").html(total_qtr_a_q19);
        //Code calculation for question 19 b
        let total_b_q19  = 0;
        total_b_q19 += Number($("#applications_granted_i_b_q19").html()) || 0;
        total_b_q19 += Number($("#applications_granted_ii_b_q19").html()) || 0;
        total_b_q19 += Number($("#applications_granted_iii_b_q19").html()) || 0;
        total_b_q19 += Number($("#applications_granted_iv_b_q19").html()) || 0;   
        $("#tno_i_b_q19").html(total_b_q19);                
        let total_qtr_b_q19  = 0;
        total_qtr_b_q19 += Number($("#applications_granted_qtr_end_i_b_q19").html()) || 0;
        total_qtr_b_q19 += Number($("#applications_granted_qtr_end_ii_b_q19").html()) || 0;
        total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iii_b_q19").html()) || 0;
        total_qtr_b_q19 += Number($("#applications_granted_qtr_end_iv_b_q19").html()) || 0;   
        $("#tno_qtr_end_i_b_q19").html(total_qtr_b_q19);
            //Code calculation for question 19 c
        let total_c_q19  = 0;
        total_c_q19 += Number($("#applications_rejected_i_c_q19").html()) || 0;
        total_c_q19 += Number($("#applications_rejected_ii_c_q19").html()) || 0;
        total_c_q19 += Number($("#applications_rejected_iii_c_q19").html()) || 0;
        total_c_q19 += Number($("#applications_rejected_iv_c_q19").html()) || 0;   
        $("#tnc_i_c_q19").html(total_c_q19);
        let total_qtr_c_q19  = 0;
        total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_i_c_q19").html()) || 0;
        total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_ii_c_q19").html()) || 0;
        total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iii_c_q19").html()) || 0;
        total_qtr_c_q19 += Number($("#applications_rejected_qtr_end_iv_c_q19").html()) || 0;   
        $("#tno_qtr_end_i_c_q19").html(total_qtr_c_q19);

        let appeals_against_rejection_a_q20= Number($("#appeals_against_rejection_a_q20").html()) || 0;  
        $("#tno_a_q20").html(appeals_against_rejection_a_q20);
        let appeals_against_rejection_qtr_end_a_q20= Number($("#appeals_against_rejection_qtr_end_a_q20").html()) || 0;  
        $("#tno_qtr_end_a_q20").html(appeals_against_rejection_qtr_end_a_q20);
        let appeals_disposed_b_q20= Number($("#appeals_disposed_b_q20").html()) || 0;  
        $("#tno_b_q20").html(appeals_disposed_b_q20);
        let appeals_disposed_qtr_end_b_q20= Number($("#appeals_disposed_qtr_end_b_q20").html()) || 0;  
        $("#tno_qtr_end_b_q20").html(appeals_disposed_qtr_end_b_q20);

        let chapter_v_art_q22= Number($("#chapter_v_art_q22").html()) || 0;  
        let surrogacy_chapter_vii_q22= Number($("#surrogacy_chapter_vii_q22").html()) || 0;  
        $("#tno_q22").html(chapter_v_art_q22+surrogacy_chapter_vii_q22);
        let chapter_v_art_qtr_end_q22= Number($("#chapter_v_art_qtr_end_q22").html()) || 0;  
        let surrogacy_chapter_qtr_end_vii_q22= Number($("#surrogacy_chapter_qtr_end_vii_q22").html()) || 0;  
        $("#tno_qtr_end_q22").html(chapter_v_art_qtr_end_q22+surrogacy_chapter_qtr_end_vii_q22);
    });
</script> 
@endsection
