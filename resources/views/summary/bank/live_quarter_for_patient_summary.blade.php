@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
   .csp-clinic-btn-primary {
   background-color: #0b5ed7;
   border-color: #0b5ed7;
   color: white;
   }
   .step-indicator {
   display: flex;
   justify-content: center;
   gap: 10px;
   margin-bottom: 20px;
   }
   .csp-readonlycolor {
   background-color: #e8eaec !important;  /* light blue, change as needed */
   font-weight: bold;          /* optional */
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
   .total-patient{
   font-weight: 600;
   }
   .progress-bar {
   background-color: #0d6efd;
   }
   .patient-round {
   width:30px;height:30px;font-weight:bold;
   }
   .display-none {
   display: none;
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
            <h3 class="card-title mb-5 text-primary">Summary period </h3>
            <form id="art_clinic_summary1" method="POST" action="{{ route('clinic.patient_summary_detail_form',['artbank']) }}" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="card border mb-3">
                        <div class="card-header">
                           <strong>Summary Period</strong>
                        </div>
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-12">
                                 <label><strong>Year and Quarter</strong></label>
                                 <div class="d-flex gap-3">

                                    @php
                                 //   dd($available_years);
                                       
                                       @endphp
                                    @if (!empty($available_years))
                                       <input type="text" name="year" class="form-control csp-readonlycolor"
                                       value="{{ $available_years }}" readonly>
                                       <input type="hidden" name="year" value="{{ $available_years }}">
                                    @endif
                                    @if (!empty($available_quarters))
                                       <input type="text" class="form-control csp-readonlycolor" value="{{ $available_quarters->description}}" readonly>
                                       <input type="hidden" name="quarter" value="{{ $available_quarters->quarter }}">
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <input type="submit" id="continueBtn" name="action" value="Continue Patient Summary" class="btn btn-primary mt-3">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="card border mb-3">
                        <div class="card-header ">
                           <strong>Current Summary Period({{ $available_quarters->description }},{{ $available_years }})</strong>
                        </div>
                        <div class="card-body">
                           <p class="mb-2 total-patient">
                              {{-- No. of patient summary submitted : --}}
                              {{-- <span class="patient-round rounded-circle bg-danger text-white d-inline-flex justify-content-center align-items-center">
                              {{-- {{ $totalPatients }} --}} 
                              {{-- 20 --}}
                              {{-- </span>  --}}
                             
                           </p>
                           <div class="form-check mb-3">
                              <input class="form-check-input" type="checkbox" id="completedCheck">
                              <label class="form-check-label" for="completedCheck">
                              {{-- All  --}}
                              patient summary for above reporting period completed
                              </label>
                           </div>
                           {{-- <p class="text-danger mb-3 display-none" id="finalSubmitWarning">
                              Kindly check and confirm all patient summary before final submission.
                              Summary can not be modified through View/Edit after final submission.
                           </p> --}}
                           <input type="submit" id="completedBtn" value=" Final Submit" name="action" class="btn btn-primary  display-none">
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script nonce="{{ $cspNonce }}">
   
    $(document).ready(function () {
      $('#completedBtn').on('click', function (e) {
         if (!confirm("Kindly check & confirm all details. After submission Summary details can not be modified.")) {
            e.preventDefault();
         }
      });

       $('#completedCheck').on('change', function () {
           if ($(this).is(':checked')) {
               $('#continueBtn').prop('disabled', true);
               $('#completedBtn').prop('disabled', false);
               $('#continueBtn').hide();
               $('#completedBtn').show();
               $('#finalSubmitWarning').show();
               completedBtn
           } else {
               $('#continueBtn').prop('disabled', false);
               $('#completedBtn').prop('disabled', true);
               $('#continueBtn').show();
               $('#completedBtn').hide();
               $('#finalSubmitWarning').hide();
           }
       });
   
       
      });
</script>
@endsection