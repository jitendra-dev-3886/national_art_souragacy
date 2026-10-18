@extends('layouts.admin.admin_master')  
@section('content') 
<div class="container-fluid">     			
    <div class="row card p-3 " >
        <div class="col-lg-12">
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
            <form action="{{ route('report.ConsolidatedQuarterlyReportFilter') }}" method="post" name="frmfilter" id="frmfilter">
                     @csrf
                     <input type="hidden" name="flagid" value="1">
                       <h3 class=" bc-color-csp-clinic-four">Consolidated Comprehensive Quarterly report of the State / UT Appropriate Authority
                        </h3>
                    <div class="row pt-4">                      
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select State</strong></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                          <select name="state" id="state" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select State</option>
                                             <option value="All">All State</option>
                                                @foreach($state as $stateRow)  
                                                    <option value="{{ $stateRow->state_id }}">{{ $stateRow->state_name}}</option>
                                                @endforeach                                                                                
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Year</strong><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                           @php  
                                        $currentYear=(date('m')<=3 )? date('Y')-1 : date('Y');                             
                                        @endphp
                                        <select name="year" id="year" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select year</option>
                                             @for ($i = 2022; $i <= $currentYear; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor                                             
                                        </select>
                                        <!-- Error Message Container -->
                                        <span id="msgyear" class="text-danger"></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                            <label class="text-label form-label" for="cliniclevel"><strong>Select Period</strong><span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="dropdown bootstrap-select nice-select default-select wide form-control solid">
                                        <select name="quarter" id="quarter" class="nice-select default-select wide form-control solid" tabindex="null">
                                            <option value="">Select Quarter</option>
                                                @foreach($quarters as $qtrRow)  
                                                    <option value="{{ $qtrRow->quarter }}">{{ $qtrRow->description}}</option>
                                                @endforeach                                                                                
                                            </select>
                                            <!-- Error Message Container -->
                                            <span id="msgqtr" class="text-danger"></span> 
                                    </div> 
                                </div>
                            </div>
                        </div>            						
                        <div class="col-md-1">
                            <div class="mb-2 pt-2">
                            <span>&nbsp; &nbsp;<a class="link btn btn-primary csp-clinic-btn-blue" id="submitfilter">Submit</a></span>							 
                            </div>
                        </div>                  
                    </div><br />
                </form>
        </div>    
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery.min.js') }}"></script>
<script nonce="{{ $cspNonce }}">
$(document).ready(function () {
     $("#submitfilter").click(function (e) {        
       // e.preventDefault(); 
       let flag=0;
        $('#msgqtr').html("");
        $('#msgyear').html("");
        let  selectedYear=$('#year').val();
        let  selectedQuarter=$('#quarter').val();
        
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1; // 1–12
    const currentQuarter = Math.ceil(currentMonth / 3); // 1–4

       if(selectedQuarter==""){
           $('#msgqtr').html("Please enter quarter");
           flag=1;

         }             
         if(selectedYear==""){
             $('#msgyear').html("Please enter year");
             flag=1;
         }  
 
         if (selectedYear === currentYear && selectedQuarter > currentQuarter) {
             $('#msgqtr').html("Future quarter is not allowed.");
             flag=1;
         }
        if(flag==0){             
                $("#frmfilter").submit();
             
        }else{
            return false;
        }

    })
});
</script> 
@endsection
