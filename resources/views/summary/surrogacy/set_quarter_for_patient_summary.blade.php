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
   background-color: #efebe9;
   }
   .indicator.active {
   background-color: #0d6efd;
   }
   .progress-bar {
   background-color: #0d6efd;;
   }
   .csp-clinic-select-half {
   width: 48%;
   }
   .csp-clinic-btn-primary {
   background-color: #0b5ed7;
   border-color: #0b5ed7;
   color: white;
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
            @if(session('exists'))
            <div class="alert alert-warning">
               {{ $messagea ?? 'This quarter and year have already been added!' }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            <h3 class="card-title mb-5 text-primary">Patient Summary</h3>
            <form id="art_clin1" action="{{ url('clinic/set-quarter-for-patient-summary-submit') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="row">
                  @php
                  $currentYear = date('Y');
                  $currentQuarter = ceil(date('n') / 3);
                  @endphp
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label d-block">
                        <strong>Report Filing for ART Surrogacy Patient Summary</strong>
                        </label>
                        <div class="d-flex gap-3">
                           <select class="form-select csp-clinic-select-half" disabled>
                              <option>{{ $defaultYear }}</option>
                           </select>
                           <select class="form-select csp-clinic-select-half" disabled>
                              <option>{{ $selected_quarter->description }}</option>
                           </select>
                           {{-- Hidden fields to submit actual values --}}
                           <input type="hidden" name="year" value="{{ $defaultYear }}">
                           <input type="hidden" name="quarter" value="{{ $defaultQuarter }}">
                           <input type="hidden" name="clinic_type" value="{{ $clinic_type }}">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="mt-4">
                  <button type="submit" class="btn me-2 csp-clinic-btn-primary">Set Summary Period</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
</div>
@endsection