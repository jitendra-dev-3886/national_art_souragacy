@extends('layouts.clinic.clinic_master')
@section('content')


<style nonce="{{$cspNonce}}">
    .step-indicator {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .indicator {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: #e9ecef;
    }
    .indicator.active {
      background-color: #0d6efd;
    }
    .progress-bar {
    background-color: #0d6efd;;
}


.widthfe-csp-clinic-one{
width: 48%;
}
.widthff-csp-clinic-two{
    width: 550%;
}
.clr-csp-clinic-three{
color: red;
}
.wdbdclr-csp-clinic-four{
width: 20%; background-color: #e9ecef; color: #495057;
}
.btn-bgclr-csp-clinic-five{
background-color: #0b5ed7; border-color: #0b5ed7; color: white;
}
.wdtp-csp-clinic-six{
    width: 20%;
}
 .width-csp-clinic-four{
    width: 20%;  
    }

  </style>


        <div class="container-fluid">
            <div class="col-lg-12">
                <div class="card">       
                    <div class="card-body">  
                        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('exists'))
            <script nonce="{{ $cspNonce }}">
                alert("{{ session('exists') }}");
            </script>
        @endif


        {{-- <div class="container mt-5"> --}}
            <h3 class="card-title mb-5 text-primary">Reporting Format for ART Clinic (Level-II)</h3>
            
          
            
            <!-- Form -->
            {{-- <form id="form-wizard" method="POST" action="{{ route('clinic.save_clinic_application_form') }}" enctype="multipart/form-data"> --}}
              <!-- Step 1 -->
            
              {{-- <form name="art_clin1" method="POST" action="{{ url('clinic/summary-patient-application-form-new') }}" enctype="multipart/form-data">                              --}}
        
              <form name="art_clin1" method="POST" action="{{ route ('clinic.summary_patient_save_art_two_application_form_edit') }}" enctype="multipart/form-data">                             
                @csrf
                <input type="hidden" name="id" value="{{ $report->id }}">

              <div class="row">
                    @php
                    $currentYear = date('Y');
                    $currentQuarter = ceil(date('n') / 3);
                @endphp
        
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <strong>a. Year and quarter</strong>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="d-flex gap-3">
                                
                            
                                <input type="text" class="form-control widthfe-csp-clinic-one"  name="year" value="{{ $report->year }}" readonly>
                                <input type="hidden" class="form-control widthfe-csp-clinic-one" name="quarter" value="{{ $report->quarter }}" readonly>
                                <input type="text" class="form-control widthfe-csp-clinic-one" value="{{ $report->quarterdesc->description }}" readonly>
                            </div>
                            {{-- <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                <option value="">Select quarter</option>
                                <option value="1" {{ $report->quarter == 1 ? 'selected' : '' }}>Q1</option>
                                <option value="2" {{ $report->quarter == 2 ? 'selected' : '' }}>Q2</option>
                                <option value="3" {{ $report->quarter == 3 ? 'selected' : '' }}>Q3</option>
                                <option value="4" {{ $report->quarter == 4 ? 'selected' : '' }}>Q4</option>
                            </select>
                            
                            <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                <option value="">Select Year</option>
                                @for ($y = now()->year; $y >= 2000; $y--)
                                    <option value="{{ $y }}" {{ $report->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select> --}}
                        </div>
                    </div>
                </div>
                    {{-- @php
                    $currentYear = date('Y');
                @endphp

                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <strong>a. Quarter and Year </strong>
                        </label>
                        <div class="d-flex gap-3">
                            <select class="form-select" name="quarter" id="quarterSelect" style="width: 48%;">
                                <option value="">Select Quarter</option>
                                <option value="Q1">Q1 (Apr - Jun)</option>
                                <option value="Q2">Q2 (Jul - Sep)</option>
                                <option value="Q3">Q3 (Oct - Dec)</option>
                                <option value="Q4">Q4 (Jan - Mar)</option>
                            </select>
                            <select class="form-select" name="year" id="yearSelect" style="width: 48%;">
                                <option value="">Select Year</option>
                                @for ($y = $currentYear; $y >= 2022; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        

                            
                        </div>
                    </div>
                </div> --}}
                   
                 <div class="col-md-5">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>b. Name of the
                                    Clinic</strong>
                                </label>
                            <div class="input-group">
                                <input type="text" value="{{ $report->name_of_clinic }}" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                    class="form-control" name="name_of_clinic" id="name_of_clinic" aria-describedby="name_of_clinic" placeholder="" readonly>
                            </div>
                            <span id="name_of_clinicID"
                               class="clr-csp-clinic-three"><?php // if (isset($notice_name_of_clinic)) { echo $notice_name_of_clinic;}?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="text-label form-label"
                                for="validationCustomUsername"><strong>c. Clinic Registration
                                    Number</strong></label>
                            <div class="input-group">
                                <input type="text"
                                    value="{{ $report->clinic_level1_reg_num}}"
                                    class="form-control" name="clinic_level1_reg_num"
                                    id="clinic_level1_reg_num" aria-describedby="clinic_level1_reg_num"
                                    placeholder="" data-validation="alphanumeric"
                                    data-validation-allowing="_" readonly>
                                  
                            </div>
                            <span id="clinic_level1_reg_numID"
                                class="clr-csp-clinic-three"><?php //if(isset($notice_clinic_level1_reg_num)){ echo $notice_clinic_level1_reg_num;} ?></span>
                        </div>
                    </div>
                    




                 
                </div>
                

                <div class="row">
                   




                    <div class="row">
                        

                          <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>d. Total Number of Patients undergoing IVF/ICSI procedure (ongoing cases)</strong></label>
                        
                    </div>

                    {{-- <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>(i) Number of Married couples</strong></label>
                       
                    </div>

                    <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-gametes</label>
                         <input type="number" class="form-control width-csp-clinic-four" id="no_ongoing_self_gametes" name="no_ongoing_self_gametes" value="{{ $report->no_ongoing_self_gametes ?? '' }}" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using donor gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_donor_gametes" name="no_donor_gametes"  value="{{ $report->no_donor_gametes ?? '' }}" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i (a+b) Number of Married couples</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_married_couples" name="no_married_couples"  value="{{ $report->no_married_couples ?? '' }}" readonly>
                    </div>
                     <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>(b) Using donor gametes</strong></label>
                       
                    </div>
                     <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b.i) One donor gamete</label>
                         <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_sperm" name="no_one_donor_sperm"   value="{{ $report->no_one_donor_sperm ?? '' }}" required>
                    </div>
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b.ii) Both donor gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_gamete" name="no_one_donor_gamete"  value="{{ $report->no_one_donor_gamete ?? '' }}" required>
                    </div>

                      <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i (i+ii) Using donor gametes</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_ongoing_donor_gamete" name="no_ongoing_donor_gamete"  value="{{ $report->no_ongoing_donor_gamete ?? '' }}" readonly readonly>
                    </div>

                     <div class="mb-3 d-flex align-items-center justify-content-between">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>(ii) Single woman (unmarried/widow/divorcee)</strong></label>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using Donor Sperm and self-oocytes</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_using_donor_sperm" name="no_using_donor_sperm" value="{{ $report->no_using_donor_sperm ?? '' }}" required>
                    </div>
                           
                     <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using both donor gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_using_donor_gamete" name="no_using_donor_gamete" value="{{ $report->no_using_donor_gamete ?? '' }}" required>
                    </div>
                          

                     <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>ii (a+b) Single woman (unmarried/widow/divorcee)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_ongoing_single_woman" name="no_ongoing_single_woman" value="{{ $report->no_ongoing_single_woman ?? '' }}" readonly>
                    </div>

                     <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total Number of Patients undergoing IVF/ICSI procedure (ongoing cases) (i+ii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_undergoing_IVF_procedure" name="no_patient_undergoing_IVF_procedure" value="{{ $report->no_patient_undergoing_IVF_procedure ?? '' }}" readonly>
                    </div> --}}

                    <div class="container mt-4">
                          
                        
                           <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>(i) Number of Married couples</strong></label>
                       
                    </div>
                        

                      <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-gametes</label>
                         <input type="number" class="form-control width-csp-clinic-four" id="no_ongoing_self_gametes" name="no_ongoing_self_gametes" value="{{ $report->no_ongoing_self_gametes ?? '' }}" required>
                    </div>

                      <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using donor gametes</label>
                         <input type="number" class="form-control width-csp-clinic-four"  id="no_donor_gametes" name="no_donor_gametes" value="{{ $report->no_ongoing_self_gametes ?? '' }}" required>
                    </div>
                           
                          <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i (a+b) Number of Married couples</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_married_couples" name="no_married_couples"  value="{{ $report->no_married_couples ?? '' }}" readonly>
                    </div>
                         
                        
                           <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>(b) Using donor gametes</strong></label>
                       
                    </div>
                             <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b.i) One donor gamete</label>
                         <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_sperm" name="no_one_donor_sperm" value="{{ $report->no_one_donor_sperm ?? '' }}" required>
                    </div>

                     <div class="mb-2 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b.ii) Both donor gametes</label>
                         <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_gamete" name="no_one_donor_gamete" value="{{ $report->no_one_donor_gamete ?? '' }}" required>
                    </div>
                         
                           <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>b (i+ii)Using donor gametes</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_ongoing_donor_gamete" name="no_ongoing_donor_gamete"  value="{{ $report->no_ongoing_donor_gamete ?? '' }}" readonly>
                    </div>
                           
                            <div class="mb-3 d-flex align-items-center">
                              
                                <input type="hidden" class="form-control wdtp-csp-clinic-six"  id="no_ongoing_donor_bothgamete"  required>
                            </div>
                        
                            <div class="mb-3 d-flex align-items-center justify-content-between">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>(ii) Single woman (unmarried/widow/divorcee)</strong></label>
                            </div>

                            <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using Donor Sperm and self-oocytes</label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_using_donor_sperm" name="no_using_donor_sperm" value="{{ $report->no_using_donor_sperm ?? '' }}" required>
                    </div>
                           
                     <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using both donor gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_using_donor_gamete" name="no_using_donor_gamete" value="{{ $report->no_using_donor_gamete ?? '' }}" required>
                    </div>
                          
                             <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>ii (a+b) Single woman (unmarried/widow/divorcee)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_ongoing_single_woman" name="no_ongoing_single_woman" value="{{ $report->no_ongoing_single_woman ?? '' }}" readonly>
                    </div>
                             <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total Number of Patients undergoing IVF/ICSI procedure (ongoing cases) (i+ii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_undergoing_IVF_procedure" name="no_patient_undergoing_IVF_procedure" value="{{ $report->no_patient_undergoing_IVF_procedure ?? '' }}" readonly>
                    </div>
                        
                           
                        </div>
                       

                        <!-- Ongoing Surrogacy Column -->
                        <div class="container mt-4">
                          
                        
                       
                           
                        </div>
                       

                      <div class="mb-3 d-flex align-items-center">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>e. Total Number of Patients where IVF/ICSI procedure has been completed</strong></label>
                            </div>

                            <!-- Married Couples -->
                           <div class="mb-2 d-flex align-items-center">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>(i) Married couples</strong></label>
                            </div>
                         <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-gametess</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_self_gametes" name="no_completed_self_gametes" value="{{ $report->no_completed_self_gametes ?? '' }}" required>
                    </div>
                           
                    <div class="mb-3 d-flex align-items-center">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using donor gametes</label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_donor_gamete" name="no_donor_gamete"  value="{{ $report->no_donor_gamete ?? '' }}" required>
                    </div>

                              <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i (a+b) Married couples</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_married_couple" name="no_married_couple"  value="{{ $report->no_married_couple ?? '' }}" readonly>
                    </div>

                          

                            <!-- One Donor Gamete -->
                            <div class="mb-3 d-flex align-items-center">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>(b.i) One donor gamete</strong></label>
                            </div>
 <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-sperm and  donor oocytes</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_sperms" name="no_one_donor_sperms" value="{{ $report->no_one_donor_sperms ?? '' }}" required>
                            </div>
                           <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using self-oocytes and donor sperm</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_one_donor_gametes" name="no_one_donor_gametes" value="{{ $report->no_one_donor_gametes ?? '' }}" required>
                            </div>

                             <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>b.i (a+b) One donor gamete</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_donor_gamete" name="no_completed_donor_gamete"  value="{{ $report->no_completed_donor_gamete ?? '' }}" readonly>
                    </div>
    <!-- Both Donor Gametes -->
 <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b.ii) Both donor gametes</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_completed_donor_bothgamete" name="no_completed_donor_bothgamete" value="{{ $report->no_completed_donor_bothgamete ?? '' }}" required>
                            </div>
                        
                            

                            <!-- Single Woman -->
                            <div class="mb-3 d-flex align-items-center">
                                <label class="form-label me-3 widthff-csp-clinic-two" ><strong>(ii) Single woman (unmarried/widow/divorcee)</strong></label>
                            </div>
<div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-sperm and  donor oocytes</label>
                            <input type="number" class="form-control width-csp-clinic-four"id="no_using_donor_sperms" name="no_using_donor_sperms" value="{{ $report->no_using_donor_sperms ?? '' }}" required>
                            </div>
                            
                         <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using both donor gametes</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_using_donor_gametes" name="no_using_donor_gametes"  value="{{ $report->no_using_donor_gametes ?? '' }}" required>
                            </div>
                            
                             <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>ii (a+b) Single woman (unmarried/widow/divorcee):</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_completed_single_woman" name="no_completed_single_woman"  value="{{ $report->no_completed_single_woman ?? '' }}" readonly>
                    </div>

                           
                            <!-- Final Total -->

                            <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total Number of Patients where IVF/ICSI procedure has been completed (i+ii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_patient_undergoing_IVF_procedure_completed" name="no_patient_undergoing_IVF_procedure_completed"  value="{{ $report->no_patient_undergoing_IVF_procedure_completed ?? '' }}" readonly>
                    </div>
                          
                    </div>
                           
                        
                          
 <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>f. Number of surgical retrievals of semen done:</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four" id="no_surgical_semen_completed" name="no_surgical_semen_completed"  value="{{ $report->no_surgical_semen_completed ?? '' }}"  required>
                    </div>
                           
                           
                    </div>
                    
            <div class="row">
                       
                            <div class=" mb-4 d-flex align-items-center">
                                <label for="foreign_nationals" class="form-label me-3 widthff-csp-clinic-two" ><strong>g. Number of oocyte retrievals done:</strong></label>                               
                            </div>

                             <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(i) oocyte donor:</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_oocyte_donor" name="no_oocyte_donor" value="{{ $report->no_oocyte_donor ?? '' }}" required>
                            </div>
                                   
                          <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(ii) Self oocytes of patient:</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_self_oocyte_patient" name="no_self_oocyte_patient" value="{{ $report->no_self_oocyte_patient ?? '' }}" required>
                            </div>
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total number of oocyte retrievals done. g(i+ii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_oocyte_retrievals_done" name="no_oocyte_retrievals_done" value="{{ $report->no_oocyte_retrievals_done ?? '' }}" readonly>
                    </div>
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>h. Number of Patient sperm cryopreserved (in vials):</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_patient_sperm_cryo" name="no_patient_sperm_cryo"  value="{{ $report->no_patient_sperm_cryo ?? '' }}" required>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>i. Number of patient oocytes cryopreserved:</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"    id="no_patient_oocyte_cryo" name="no_patient_oocyte_cryo"  value="{{ $report->no_patient_oocyte_cryo ?? '' }}" required>
                    </div>
                 
            </div>

                       

   <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>j. Number of donor sperm cryopreserved (in vials):</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"    id="no_donor_sperm_cryo" name="no_donor_sperm_cryo" value="{{ $report->no_donor_sperm_cryo ?? '' }}" required>
                    </div>

                                       
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>k. Number of donor oocytes cryopreserved:</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"   id="no_donor_oocyte_cryo" name="no_donor_oocyte_cryo" value="{{ $report->no_donor_oocyte_cryo ?? '' }}" required>
                    </div>     
                                  
                      
                         <div class=" mb-4 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 widthff-csp-clinic-two"><strong>l. Number of embryos cryopreserved</strong></label>
                            {{-- <input type="number" class="form-control" id="no_embryos_cryopreserved" name="no_embryos_cryopreserved" style="width: 20%;" readonly placeholder="Auto-calculated"> --}}
                        </div>

                             <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" ><strong>(i) created using self-gametes</strong></label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_created_self_gametes" name="no_created_self_gametes"  value="{{ $report->no_created_self_gametes ?? '' }}" required>
                            </div>
                       
                    
                       
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            <label for="foreign_nationals" class="form-label me-3 widthff-csp-clinic-two" ><strong>(ii) created using one donor gamete:</strong></label>
                            {{-- <input type="number" class="form-control" id="no_created_one_donor_gamete" name="no_created_one_donor_gamete" style="width: 20%;" readonly placeholder="Auto-calculated"> --}}
                        </div>
                              <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(a) Using self-sperm and donor oocytes</label>
                            <input type="number" class="form-control width-csp-clinic-four"id="no_donor_sperm" name="no_donor_sperm" value="{{ $report->no_donor_sperm ?? '' }}" required>
                            </div>
                       
                       <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(b) Using self-oocytes and donor sperm</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_donor_oocyte" name="no_donor_oocyte"  value="{{ $report->no_donor_oocyte ?? '' }}" required>
                            </div>
                      
                     <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>ii (a+b) created using one donor gamete:</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_created_one_donor_gamete" name="no_created_one_donor_gamete" value="{{ $report->no_created_one_donor_gamete ?? '' }}" readonly>
                    </div>
                      
                      <div class="mb-3 d-flex align-items-center">
                            <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two" >(iii) created using both donor gametes:</label>
                            <input type="number" class="form-control width-csp-clinic-four" id="no_created_both_donor_gamete" name="no_created_both_donor_gamete" value="{{ $report->no_created_both_donor_gamete ?? '' }}" required>
                            </div>
                       
                               <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>Total number of embryos cryopreserved. (i+ii+iii)</strong></label>
                        <input type="number" class="form-control width-csp-clinic-four"  id="no_embryos_cryopreserved" name="no_embryos_cryopreserved" value="{{ $report->no_embryos_cryopreserved ?? '' }}" readonly>
                    </div>

                     <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label for="ongoing_self_gametes" class="form-label me-3 width-csp-clinic-two"><strong>m. Date of submission of the form(DD/MM/YY):</strong></label>
                        <input type="date" class="form-control width-csp-clinic-four"  id="date_of_submission" name="date_of_submission" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
                    </div>
                       
                          
                        
                    
                    </div>
                    
                <div class="row">
                    <div class="col-md-4">                    
                        <button type="submit" name="submit" id="btnSubmit"
                        class="btn me-2 btn-bgclr-csp-clinic-five">Submit</button>
                    </div>
                </div>
                
            </form>


</div>

    </div>
</div>
    </div>
</div>
</div>
   <script nonce="{{ $cspNonce }}">
    function getNumber(id) {
        return parseInt(document.getElementById(id).value) || 0;
    }

    // function calculateTotals() {
    //     const selfGametes = getNumber('no_ongoing_self_gametes');
    //     const donorGametes = getNumber('no_donor_gametes');
    //     const marriedCouples = selfGametes + donorGametes;
    //     document.getElementById('no_married_couples').value = marriedCouples;

    //     const oneDonorSperm = getNumber('no_one_donor_sperm');
    //     const oneDonorOocyte = getNumber('no_one_donor_gamete');
    //     const oneDonorTotal = oneDonorSperm + oneDonorOocyte;
    //     document.getElementById('no_ongoing_donor_gamete').value = oneDonorTotal;

    //     const singleDonorSperm = getNumber('no_using_donor_sperm');
    //     const singleBothDonor = getNumber('no_using_donor_gamete');
    //     const singleWomanTotal = singleDonorSperm + singleBothDonor;
    //     document.getElementById('no_ongoing_single_woman').value = singleWomanTotal;

    //     const totalPatients = marriedCouples + singleWomanTotal;
    //     document.getElementById('no_patient_undergoing_IVF_procedure').value = totalPatients;
    // }

     function calculateTotals() {
        const selfGametes = getNumber('no_ongoing_self_gametes');
        const donorGametes = getNumber('no_donor_gametes');
        const marriedCouples = selfGametes + donorGametes;
        document.getElementById('no_married_couples').value = marriedCouples;

        const oneDonorSperm = getNumber('no_one_donor_sperm');
        const oneDonorOocyte = getNumber('no_one_donor_gamete');
        const oneDonorTotal = oneDonorSperm + oneDonorOocyte;
        document.getElementById('no_ongoing_donor_gamete').value = oneDonorTotal;

        const singleDonorSperm = getNumber('no_using_donor_sperm');
        const singleBothDonor = getNumber('no_using_donor_gamete');
        const singleWomanTotal = singleDonorSperm + singleBothDonor;
        document.getElementById('no_ongoing_single_woman').value = singleWomanTotal;

        const totalPatients = marriedCouples + singleWomanTotal;
        document.getElementById('no_patient_undergoing_IVF_procedure').value = totalPatients;
    }


    const inputIds = [
        'no_ongoing_self_gametes',
        'no_donor_gametes',
        'no_one_donor_sperm',
        'no_one_donor_gamete',
        'no_using_donor_sperm',
        'no_using_donor_gamete'
    ];

    inputIds.forEach(id => {
        document.getElementById(id).addEventListener('input', calculateTotals);
    });
</script>
  <script nonce="{{ $cspNonce }}">
    function getVal(id) {
        return parseInt(document.getElementById(id).value) || 0;
    }

    function calculateCompletedTotals() {
        const completedSelfGametes = getVal('no_completed_self_gametes');
        const completedDonorGamete = getVal('no_donor_gamete');
        const marriedCoupleTotal = completedSelfGametes + completedDonorGamete;
        document.getElementById('no_married_couple').value = marriedCoupleTotal;

        const oneDonorSperm = getVal('no_one_donor_sperms');
        const oneDonorOocyte = getVal('no_one_donor_gametes');
        const oneDonorTotal = oneDonorSperm + oneDonorOocyte;
        document.getElementById('no_completed_donor_gamete').value = oneDonorTotal;

        const singleDonorSperm = getVal('no_using_donor_sperms');
        const singleDonorBoth = getVal('no_using_donor_gametes');
        const singleWomanTotal = singleDonorSperm + singleDonorBoth;
        document.getElementById('no_completed_single_woman').value = singleWomanTotal;

        const totalCompletedPatients = marriedCoupleTotal + singleWomanTotal;
        document.getElementById('no_patient_undergoing_IVF_procedure_completed').value = totalCompletedPatients;
    }

    const completedInputIds = [
        'no_completed_self_gametes',
        'no_donor_gamete',
        'no_one_donor_sperms',
        'no_one_donor_gametes',
        'no_using_donor_sperms',
        'no_using_donor_gametes'
    ];

    completedInputIds.forEach(id => {
        document.getElementById(id).addEventListener('input', calculateCompletedTotals);
    });
</script>
  <script nonce="{{ $cspNonce }}">
    function updateIVFCounts() {
        const selfGametes = parseInt(document.getElementById('no_ongoing_self_gametes').value) || 0;
        const donorBothGamete = parseInt(document.getElementById('no_ongoing_donor_bothgamete').value) || 0;
        const oneDonorSperm = parseInt(document.getElementById('no_one_donor_sperm').value) || 0;
        const oneDonorOocyte = parseInt(document.getElementById('no_one_donor_gamete').value) || 0;
        const usingDonorSperm = parseInt(document.getElementById('no_using_donor_sperm').value) || 0;
        const usingDonorGamete = parseInt(document.getElementById('no_using_donor_gamete').value) || 0;

        const oneDonorGamete = oneDonorSperm + oneDonorOocyte;
        const totalDonorGametes = donorBothGamete + oneDonorGamete;
        const marriedCouples = selfGametes + totalDonorGametes;
        const singleWomen = usingDonorSperm + usingDonorGamete;
        const totalIVFPatients = oneDonorGamete + singleWomen;

        // Set calculated values
        document.getElementById('no_ongoing_donor_gamete').value = oneDonorGamete;
        document.getElementById('no_donor_gametes').value = totalDonorGametes;
        document.getElementById('no_married_couples').value = marriedCouples;
        document.getElementById('no_ongoing_single_woman').value = singleWomen;
        document.getElementById('no_patient_undergoing_IVF_procedure').value = totalIVFPatients;
    }

    // Attach listeners to user-input fields
    document.querySelectorAll('#no_ongoing_self_gametes, #no_ongoing_donor_bothgamete, #no_one_donor_sperm, #no_one_donor_gamete, #no_using_donor_sperm, #no_using_donor_gamete')
        .forEach(input => {
            input.addEventListener('input', updateIVFCounts);
        });
        function updateIVFCountss() {
        const selfGametess = parseInt(document.getElementById('no_completed_self_gametes').value) || 0;
        const donorBothGametes = parseInt(document.getElementById('no_completed_donor_bothgamete').value) || 0;
        const oneDonorSperms = parseInt(document.getElementById('no_one_donor_sperms').value) || 0;
        const oneDonorOocytes = parseInt(document.getElementById('no_one_donor_gametes').value) || 0;
        const usingDonorSperms = parseInt(document.getElementById('no_using_donor_sperms').value) || 0;
        const usingDonorGametes = parseInt(document.getElementById('no_using_donor_gametes').value) || 0;

        const oneDonorGametes = oneDonorSperms + oneDonorOocytes;
        const totalDonorGametess = donorBothGametes + oneDonorGametes;
        const marriedCoupless = selfGametess + totalDonorGametess;
        const singleWomens = usingDonorSperms + usingDonorGametes;
        const totalIVFPatientss = marriedCoupless + singleWomens;

        // Set calculated values
        document.getElementById('no_completed_donor_gamete').value = oneDonorGametes;
        document.getElementById('no_donor_gamete').value = totalDonorGametess;
        document.getElementById('no_married_couple').value = marriedCoupless;
        document.getElementById('no_completed_single_woman').value = singleWomens;
        document.getElementById('no_patient_undergoing_IVF_procedure_completed').value = totalIVFPatientss;
    }

    // Attach listeners to user-input fields
    document.querySelectorAll('#no_completed_self_gametes, #no_completed_donor_bothgamete, #no_one_donor_sperms, #no_one_donor_gametes, #no_using_donor_sperms, #no_using_donor_gametes')
        .forEach(input => {
            input.addEventListener('input', updateIVFCountss);
        });
        function updateOocyteRetrievals() {
        const donor = parseInt(document.getElementById('no_oocyte_donor').value) || 0;
        const self = parseInt(document.getElementById('no_self_oocyte_patient').value) || 0;
        const total = donor + self;
        document.getElementById('no_oocyte_retrievals_done').value = total;
    }

    document.getElementById('no_oocyte_donor').addEventListener('input', updateOocyteRetrievals);
    document.getElementById('no_self_oocyte_patient').addEventListener('input', updateOocyteRetrievals);
    function updateCryopreservedEmbryos() {
        const self = parseInt(document.getElementById('no_created_self_gametes').value) || 0;
        const donorSperm = parseInt(document.getElementById('no_donor_sperm').value) || 0;
        const donorOocyte = parseInt(document.getElementById('no_donor_oocyte').value) || 0;
        const bothDonor = parseInt(document.getElementById('no_created_both_donor_gamete').value) || 0;

        const oneDonor = donorSperm + donorOocyte;
        const total = self + oneDonor + bothDonor;

        document.getElementById('no_created_one_donor_gamete').value = oneDonor;
        document.getElementById('no_embryos_cryopreserved').value = total;
    }

    document.getElementById('no_created_self_gametes').addEventListener('input', updateCryopreservedEmbryos);
    document.getElementById('no_donor_sperm').addEventListener('input', updateCryopreservedEmbryos);
    document.getElementById('no_donor_oocyte').addEventListener('input', updateCryopreservedEmbryos);
    document.getElementById('no_created_both_donor_gamete').addEventListener('input', updateCryopreservedEmbryos);
</script>

<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {
    const yearSelect = document.getElementById('yearSelect');
    const quarterSelect = document.getElementById('quarterSelect');

    const today = new Date();
    const currentYear = today.getFullYear();
    const currentMonth = today.getMonth() + 1; // 1-based

    // Determine current financial quarter
    let currentFinQuarter;
    if (currentMonth >= 4 && currentMonth <= 6) {
        currentFinQuarter = 1; // Q1 (Apr-Jun)
    } else if (currentMonth >= 7 && currentMonth <= 9) {
        currentFinQuarter = 2; // Q2 (Jul-Sep)
    } else if (currentMonth >= 10 && currentMonth <= 12) {
        currentFinQuarter = 3; // Q3 (Oct-Dec)
    } else {
        currentFinQuarter = 4; // Q4 (Jan-Mar)
    }

    function filterQuarters() {
        const selectedYear = parseInt(yearSelect.value);

        Array.from(quarterSelect.options).forEach(option => {
            if (!option.value) return; // skip "Select quarter" option
            const qNum = parseInt(option.value);

            if (isNaN(selectedYear)) {
                option.hidden = false;
                return;
            }

            if (selectedYear < currentYear) {
                // Past years → show all quarters
                option.hidden = false;
            } else if (selectedYear === currentYear) {
                // Current year → show up to current quarter
                option.hidden = qNum > currentFinQuarter;
            } else {
                // Future years → hide all
                option.hidden = true;
            }
        });

        // Reset if hidden option was selected
        const selectedOption = quarterSelect.selectedOptions[0];
        if (selectedOption && selectedOption.hidden) {
            quarterSelect.selectedIndex = 0;
        }
    }

    yearSelect.addEventListener('change', filterQuarters);
    filterQuarters(); // initial run
});
</script>




<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {
        const numberInputs = document.querySelectorAll('input[type="number"]');

        numberInputs.forEach(input => {
            input.setAttribute('min', '0');

            input.addEventListener('input', function () {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });
    });
</script>
<script nonce="{{ $cspNonce }}">
    function validatesubmit() {
        if (document.getElementById("yearSelect").value == "") {
            alert("Select Year");
            document.getElementById("yearSelect").focus();
            return false;
        } 
        if (document.getElementById("quarterSelect").value == "") {
            alert("Select Quarter");
            document.getElementById("quarterSelect").focus();
            return false;
        }
        if (document.getElementById("no_patient_undergoing_IVF_procedure").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_undergoing_IVF_procedure").focus();
            return false;
        } 
        if (document.getElementById("no_married_couples").value == "") {
            alert("Enter the number");
            document.getElementById("no_married_couples").focus();
            return false;
        }          
        if (document.getElementById("no_ongoing_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_self_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_donor_gamete").focus();
            return false;
        } 
        if (document.getElementById("no_one_donor_sperm").value == "") {
            alert("Enter the number");
            document.getElementById("no_one_donor_sperm").focus();
            return false;
        } 
        if (document.getElementById("no_one_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_one_donor_gamete").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_donor_bothgamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_donor_bothgamete").focus();
            return false;
        } 
        if (document.getElementById("no_ongoing_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_ongoing_single_woman").focus();
            return false;
        }  
        if (document.getElementById("no_using_donor_sperm").value == "") {
            alert("Enter the number");
            document.getElementById("no_using_donor_sperm").focus();
            return false;
        }  
        if (document.getElementById("no_using_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_using_donor_gamete").focus();
            return false;
        }   
        
        


        if (document.getElementById("no_patient_undergoing_IVF_procedure_completed").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_undergoing_IVF_procedure_completed").focus();
            return false;
        } 
        if (document.getElementById("no_married_couple").value == "") {
            alert("Enter the number");
            document.getElementById("no_married_couple").focus();
            return false;
        } 
        if (document.getElementById("no_completed_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_self_gametes").focus();
            return false;
        }        
        if (document.getElementById("no_completed_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_donor_gamete").focus();
            return false;
        } 
        if (document.getElementById("no_one_donor_sperms").value == "") {
            alert("Enter the number");
            document.getElementById("no_one_donor_sperms").focus();
            return false;
        } 
        if (document.getElementById("no_one_donor_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_one_donor_gametes").focus();
            return false;
        } 
        if (document.getElementById("no_completed_donor_bothgamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_donor_bothgamete").focus();
            return false;
        } 
        if (document.getElementById("no_completed_single_woman").value == "") {
            alert("Enter the number");
            document.getElementById("no_completed_single_woman").focus();
            return false;
        }
        if (document.getElementById("no_using_donor_sperms").value == "") {
            alert("Enter the number");
            document.getElementById("no_using_donor_sperms").focus();
            return false;
        }  
        if (document.getElementById("no_using_donor_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_using_donor_gametes").focus();
            return false;
        } 
        
        if (document.getElementById("no_surgical_semen_completed").value == "") {
            alert("Enter the number");
            document.getElementById("no_surgical_semen_completed").focus();
            return false;
        }
        if (document.getElementById("no_oocyte_retrievals_done").value == "") {
            alert("Enter the number");
            document.getElementById("no_oocyte_retrievals_done").focus();
            return false;
        }
        if (document.getElementById("no_oocyte_donor").value == "") {
            alert("Enter the number");
            document.getElementById("no_oocyte_donor").focus();
            return false;
        }
        if (document.getElementById("no_self_oocyte_patient").value == "") {
            alert("Enter the number");
            document.getElementById("no_self_oocyte_patient").focus();
            return false;
        }
        if (document.getElementById("no_created_self_gametes").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_self_gametes").focus();
            return false;
        }
        if (document.getElementById("no_created_one_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_one_donor_gamete").focus();
            return false;
        }
        if (document.getElementById("no_donor_sperm").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_sperm").focus();
            return false;
        }
        if (document.getElementById("no_donor_oocyte").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocyte").focus();
            return false;
        }
        if (document.getElementById("no_created_both_donor_gamete").value == "") {
            alert("Enter the number");
            document.getElementById("no_created_both_donor_gamete").focus();
            return false;
        }
        if (document.getElementById("no_patient_sperm_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_sperm_cryo").focus();
            return false;
        }
        if (document.getElementById("no_patient_oocyte_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_patient_oocyte_cryo").focus();
            return false;
        }
        if (document.getElementById("no_donor_sperm_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_sperm_cryo").focus();
            return false;
        }
        if (document.getElementById("no_donor_oocyte_cryo").value == "") {
            alert("Enter the number");
            document.getElementById("no_donor_oocyte_cryo").focus();
            return false;
        }
            
        var agree = confirm(
            "Kindly check and confirm all details before final submission. There is no provision for editing/correction once the form is submitted."
        );
        if (agree) {
    
            return true;
        } else {
            return false;
        }
        return true;
    }

    $(document).ready(function () {
        $('#btnSubmit').on('click', function (e) {
            if (!validatesubmit()) {
                e.preventDefault(); // prevent form submit if validation fails
            }
            // else form will submit naturally
        });
    });
    </script> 
    



@endsection
