@extends('layouts.clinic.clinic_master')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-danger shadow">
                <div class="card-header bg-danger text-white">
                    Patient Reporting Period error
                </div>
                @if($exists_live)
                <div class="card-body text-center">
                    <p class="fs-5 text-danger">
                        Patient Reporting Period <strong>{{ $alreadysetquarter->description ?? 'N/A' }}, <strong>{{ $alreadysetYear ?? 'N/A' }}</strong> </strong> is already set.
                        <a href="mailto:support-team@gmail.com" class="fw-semibold text-danger">
                            Kindly start the patient reporting.
                        </a>
                    </p>
                </div>
                @elseif ($exists)
                <div class="card-body text-center">
                    <p class="fs-5 text-danger">
                        This quarter has already been submitted; therefore, no further quarter is presently available for submission.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection