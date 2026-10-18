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
                    <h2 class="text-dark">Format for Quarterly report to be submitted by the <br>State / UT Appropriate Authority</h2>
                </div>     
            </div>
             <!-- Display success message -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                    @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger col-sm-12">
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif                  
            <form id="multi-step-form" name="quarterlyreportfrm" action="{{ route('report.quarterlyreportformCreate') }}" method="POST">
                 @csrf  
                <span id="submitType"></span>
                <div class="border p-2 p-lg-4 rounded-bottom-3 bg-white mb-5 shadow-sm">
                    <div class="row">
                        
                        <div class="col-md-3 mts">
                            <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                                <input type="text" name="year" id="year"class="form-control" value="{{ $filterData['Year']}}" readonly>
                                <span id="msgyear" class="text-danger"></span> 
                            </div>
                        </div>
                        <div class="col-md-3 mts">
                            <div class="mb-3">
                            <label for="quarter" class="form-label">Period</label>
                                <input type="text" class="form-control" value="{{ $filterData['Quartername'] }}" readonly>
                                <input type="hidden" name="quarter" id="quarter"class="form-control" value="{{ $filterData['Quarter'] }}" readonly>                               
                                <span id="msgqtr" class="text-danger"></span> 
                            </div>
                        </div>
                    </div>
                    <div class="row" id="report-result"></div>   
                     
                    <div class="row">                  
                        <div class="col-md-6 mts fw-bold">Name of the State / UT : {{$filterData['state_name']}}</div>
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
                                @include('reports.includes.form_step1')
                               <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>
                    </div>

                    <div class="step step-2">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.form_step2')       
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary prev-step">Previous</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>                                         
                        </div>
                    </div>

                    <div class="step step-3">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_step3')
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary prev-step">Previous</button>
                                <button type="button" class="btn btn-primary next-step">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="step step-4">
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.form_annexure1')
                            <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                    <p class="text-danger small q9_annx mb-0">Please fill all fields in the first row of  Annexure-I Question 9. If you have no data, enter “NIL”. The date field may be left blank.</p>
                                </div>
                                <div class="col-md-6">
                                     <button class="btn btn-success btn-sm mt-2 addRowBtn" data-table="datafiels1">+</button>
                                </div>
                            </div>                            
                        </div>
                        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                            @include('reports.includes.form_annexure2')                                                
                              <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                   <p class="text-danger small q15_annx mb-0">  Please fill all fields in the first row of  Annexure-II Question 15. If you have no data, enter “NIL”. </p>
                                </div>
                                <div class="col-md-6">
                                   <button class="btn btn-success btn-sm mt-2 addRowBtn" data-table="datafiels2">+</button>
                                </div>
                            </div>                           
                        </div> --}}
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm">
                                @include('reports.includes.form_annexure2_q16')                                                                                            
                            <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                   <p class="text-danger small q16_annx mb-0">  Please fill all fields in the first row of  Annexure-II Question 16. If you have no data, enter “NIL”. </p>
                               </div>
                                <div class="col-md-6">
                                   <button class="btn btn-success btn-sm mt-2 addRowBtn" data-table="datafiels3">+</button>
                                </div>
                            </div>                           
                        </div>
                        {{-- <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">                          
                                    @include('reports.includes.form_annexure3') 
                            <div class="text-end row align-items-center pe-4">
                                <div class="col-md-6 text-start">
                                     <p class="text-danger small q18_annx mb-0">  Please fill all fields in the first row of  Annexure-III Question 18. If you have no data, enter “NIL”. </p>
                                </div>
                                <div class="col-md-6">
                                     <button class="btn btn-success btn-sm mt-2 addRowBtn"  data-table="datafiels4">+</button>
                                </div>
                            </div>
                           
                        </div> --}}
                        <div class="border p-4 rounded-3 bg-white mb-4 shadow-sm mt-4">
                                        @include('reports.includes.form_annexure3_q22') 
                        </div>              
                    </div>  
                </div> 
            </form>     
        </div>
    </div>
</div> 
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/app.js') }}"></script>
<script nonce="{{ $cspNonce }}">
$(document).ready(function () { 
    for (let s = 1; s <= 13; s++) {

        const index = s; // capture current value

       $("#art_clinic_qtr_end_q" + index).on("keyup", function () {

            let dur_qtr_art = Number($("#art_clinic_q" + index).val()) ;
            let qtr_end_art = Number($(this).val()) ;

            if (qtr_end_art < dur_qtr_art) {
                $("#msg_art_qtr_end_q" + index).html('Invalid ART quarter end');
            } else {
                $("#msg_art_qtr_end_q" + index).html('');
            }
        });
    }


      
      $('.q9_annx, .q15_annx, .q16_annx, .q18_annx, .q22_annx').hide();
     $("#submitBtn").click(function (e) {
          e.preventDefault();
        let common='<input type="hidden" name="common" value="submit">';
        $("#submitType").html(common);
        const byId = (id) => document.getElementById(id);
       let flag=0;
        $('#msgqtr').html("");
        $('#msgyear').html("");
        let  year=$('#year').val();
        let  qtr=$('#quarter').val();
        
        let  applicant_name=$('#applicant_name').val();
        let  designation=$('#designation').val();
        let  place=$('#place').val();
        if(qtr==""){
          $('#msgqtr').html("Please enter quarter");
          flag=1;
        }             
        if(year==""){
            $('#msgyear').html("Please enter years");
            flag=1;
        }
          if(applicant_name==""){
            $('#msgapplicant_name').html("Please enter name");
            flag=1;
        }
        if(designation==""){
            $('#msgdesignation').html("Please enter designation");
            flag=1;
        }
          if(place==""){
            $('#msgplace').html("Please enter place");
            flag=1;
        }
         

        //Question 9 validation
        let firstRow = $('.q9-row:first');
        let clinicName = firstRow.find('.clinic-name').val().trim(); 
        let actionTaken = firstRow.find('.action-taken').val().trim();
        if (clinicName === '' ||  actionTaken === '') {
         $('.q9_annx').show();
        flag=1;
        }else{
            $('.q9_annx').hide();   
        } 
        
         //Question 15 validation
        let firstRowQ15 = $('.q15-row:first');
        let clinicNameQ15 = firstRowQ15.find('.complaint-source').val().trim(); 
        let filedbyQ15 = firstRowQ15.find('.filed-by').val().trim();
        let filedagainstQ15 = firstRowQ15.find('.filed-against').val().trim();
        let issuedetailsQ15 = firstRowQ15.find('.issue-details').val().trim();

        if (clinicNameQ15 === '' ||  filedbyQ15 === ''  ||  filedagainstQ15 === '' ||  issuedetailsQ15 === '') {        
             $('.q15_annx').show();
            flag=1;
        }else{
            $('.q15_annx').hide();   
        } 
        //Question 16 validation
        let firstRowQ16 = $('.q16-row:first');
        let clinicNameQ16 = firstRowQ16.find('.complaint-source').val().trim(); 
        let filedbyQ16 = firstRowQ16.find('.filed-by').val().trim();
        let filedagainstQ16 = firstRowQ16.find('.filed-against').val().trim();
        let issuedetailsQ16 = firstRowQ16.find('.issue-details').val().trim();
        if (firstRowQ16 === '' ||  clinicNameQ16 === ''  ||  filedbyQ16 === '' ||  filedagainstQ16 === '' || issuedetailsQ16==="") {
              $('.q16_annx').hide();
            flag=1;
        }else{
            $('.q16_annx').hide();   
        } 
 
        //Question 18 validation q22-row
        let firstRowQ18 = $('.q18-row:first');
        let caseFiledByQ18 = firstRowQ18.find('.case-filed-by').val().trim(); 
        let caseFiledAgainstQ18 = firstRowQ18.find('.case-filed-against').val().trim();
        let sectionActForViolationQ18 = firstRowQ18.find('.section-act-for-violation').val().trim();        
        let issuedetailsQ18 = firstRowQ18.find('.issue-details').val().trim();
        let personsArrestedQ18 = firstRowQ18.find('.persons-arrested').val().trim();
        let caseOutcomeQ18 = firstRowQ18.find('.case-outcome').val().trim();


        if (caseFiledByQ18 === '' ||  caseFiledAgainstQ18 === ''  ||  sectionActForViolationQ18 === '' ||  issuedetailsQ18 === '' || personsArrestedQ18==="" || caseOutcomeQ18==="") {        
              $('.q18_annx').show();
            flag=1;
        }else{
            $('.q18_annx').hide();   
        } 
        let firstRowQ22 = $('.q22-row:first');
        let caseFiledByQ22 = firstRowQ22.find('.case-filed-by').val().trim(); 
        let caseFiledAgainstQ22 = firstRowQ22.find('.case-filed-against').val().trim();
        let sectionActForViolationQ22 = firstRowQ22.find('.section-act-for-violation').val().trim();        
        let issuedetailsQ22 = firstRowQ22.find('.issue-details').val().trim();
        let personsArrestedQ22 = firstRowQ22.find('.persons-arrested').val().trim();
        let caseOutcomeQ22 = firstRowQ22.find('.case-outcome').val().trim();


        if (caseFiledByQ22 === '' ||  caseFiledAgainstQ22 === ''  ||  sectionActForViolationQ22 === '' ||  issuedetailsQ22 === '' || personsArrestedQ22==="" || caseOutcomeQ22==="") {        
             $('.q22_annx').show();           
            flag=1;
        }else{
            $('.q22_annx').hide();   
        } 

        const decl = byId("declaration");
        if (decl && !decl.checked) {
            // alert("Declaration cannot be blank");  
             $('#msgdeclarationr').html("Declaration cannot be blank");         
            flag=1;
        } 
        if(flag==0){              
         // Final confirm
           const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
          if(agree)  
           $('#multi-step-form').submit();
        }
     })

     //Save as draft
     $("#draftBtn").click(function (e) {
        e.preventDefault();
        let common='<input type="hidden" name="common" value="draft">';
        $("#submitType").html(common);
        const byId = (id) => document.getElementById(id);
        let flag=0;
        $('#msgqtr').html("");
        $('#msgyear').html("");
        let  year=$('#year').val();
        let  qtr=$('#quarter').val();
        let  applicant_name=$('#applicant_name').val();
        let  designation=$('#designation').val();
        let  place=$('#place').val();
        if(qtr==""){
        $('#msgqtr').html("Please enter quarter");
        flag=1;
        }             
        if(year==""){
        $('#msgyear').html("Please enter years");
        flag=1;
        }
        if(applicant_name==""){
            $('#msgapplicant_name').html("Please enter name");
            flag=1;
        }
        if(designation==""){
            $('#msgdesignation').html("Please enter designation");
            flag=1;
        }
          if(place==""){
            $('#msgplace').html("Please enter place");
            flag=1;
        }
        //Question 9 validation
        let firstRow = $('.q9-row:first');
        let clinicName = firstRow.find('.clinic-name').val().trim(); 
        let actionTaken = firstRow.find('.action-taken').val().trim();
        if (clinicName === '' ||  actionTaken === '') {
         $('.q9_annx').show();
        flag=1;       
        }else{
            $('.q9_annx').hide();   
        }  

         //Question 15 validation
        let firstRowQ15 = $('.q15-row:first');
        let clinicNameQ15 = firstRowQ15.find('.complaint-source').val().trim(); 
        let filedbyQ15 = firstRowQ15.find('.filed-by').val().trim();
        let filedagainstQ15 = firstRowQ15.find('.filed-against').val().trim();
        let issuedetailsQ15 = firstRowQ15.find('.issue-details').val().trim();

        if (clinicNameQ15 === '' ||  filedbyQ15 === ''  ||  filedagainstQ15 === '' ||  issuedetailsQ15 === '') {        
             $('.q15_annx').show();
            flag=1;               
        }else{
            $('.q15_annx').hide();   
        }  
        //Question 16 validation
        let firstRowQ16 = $('.q16-row:first');
        let clinicNameQ16 = firstRowQ16.find('.complaint-source').val().trim(); 
        let filedbyQ16 = firstRowQ16.find('.filed-by').val().trim();
        let filedagainstQ16 = firstRowQ16.find('.filed-against').val().trim();
        let issuedetailsQ16 = firstRowQ16.find('.issue-details').val().trim();
        if (firstRowQ16 === '' ||  clinicNameQ16 === ''  ||  filedbyQ16 === '' ||  filedagainstQ16 === '' || issuedetailsQ16==="") {
              $('.q16_annx').show();
            flag=1;           
        }else{
            $('.q16_annx').hide();   
        }  
//case-filed-by case-filed-against section-act-for-violation issue-details persons-arrested case-outcome
        //Question 18 validation q22-row
        let firstRowQ18 = $('.q18-row:first');
        let caseFiledByQ18 = firstRowQ18.find('.case-filed-by').val().trim(); 
        let caseFiledAgainstQ18 = firstRowQ18.find('.case-filed-against').val().trim();
        let sectionActForViolationQ18 = firstRowQ18.find('.section-act-for-violation').val().trim();        
        let issuedetailsQ18 = firstRowQ18.find('.issue-details').val().trim();
        let personsArrestedQ18 = firstRowQ18.find('.persons-arrested').val().trim();
        let caseOutcomeQ18 = firstRowQ18.find('.case-outcome').val().trim();


        if (caseFiledByQ18 === '' ||  caseFiledAgainstQ18 === ''  ||  sectionActForViolationQ18 === '' ||  issuedetailsQ18 === '' || personsArrestedQ18==="" || caseOutcomeQ18==="") {        
              $('.q18_annx').show();
            flag=1;            
        }else{
            $('.q18_annx').hide();   
        }  
        let firstRowQ22 = $('.q22-row:first');
        let caseFiledByQ22 = firstRowQ22.find('.case-filed-by').val().trim(); 
        let caseFiledAgainstQ22 = firstRowQ22.find('.case-filed-against').val().trim();
        let sectionActForViolationQ22 = firstRowQ22.find('.section-act-for-violation').val().trim();        
        let issuedetailsQ22 = firstRowQ22.find('.issue-details').val().trim();
        let personsArrestedQ22 = firstRowQ22.find('.persons-arrested').val().trim();
        let caseOutcomeQ22 = firstRowQ22.find('.case-outcome').val().trim();


        if (caseFiledByQ22 === '' ||  caseFiledAgainstQ22 === ''  ||  sectionActForViolationQ22 === '' ||  issuedetailsQ22 === '' || personsArrestedQ22==="" || caseOutcomeQ22==="") {        
             $('.q22_annx').show();           
            flag=1;             
        }else{
            $('.q22_annx').hide();   
        } 

         //Question 9 validation
        //outcome     action-taken
  
        const decl = byId("declaration");
    
        if (decl && !decl.checked) {        
            $('#msgdeclarationr').html("Declaration cannot be blank");         
        flag=1;
        } 
        if(flag==0){              
        // Final confirm
        // const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
        // if(agree) 
        // 
         $('#multi-step-form').submit();
         }


       })
});


</script> 
@endsection
