@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-danger shadow">
                <div class="card-header bg-danger text-white">
                    Invalid Clinic Information
                </div>
                <div class="card-body text-center">
                    <p class="fs-5 text-danger">
                        Date of establishment of your <strong>{{ $clinictype ?? 'N/A' }}</strong>  is not valid please contact to customer support at 
                        <a href="mailto:support-team@gmail.com" class="fw-semibold text-danger">
                            support-artsurrogacy@gov.in
                        </a>.
                    </p>
                    <hr>
                    <p class="mb-3">
                        You cannot proceed with patient reporting until this issue is resolved.
                    </p>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection