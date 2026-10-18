@extends(session('user_type') == '5' ? 'layouts.admin.ssa_master' : 'layouts.admin.admin_master')
@section('content')

@section('content')
{{-- <div class="container-fluid py-4">
    <div class="card shadow rounded-2xl">
        <div class="card-header">
            <h4 class="mb-0">Search Application</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.view_application.show') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Clinic Type</label>
                        <select class="form-control" name="clinic_type">
                            <option value="">Select Clinic Type</option>
                        
                            <option value="art_bank">ART Bank</option>
                            <option value="art_clinic">ART Clinic</option>
                            <option value="art_surrogacy">ART Surrogacy</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Application Number</label>
                       <input type="text" id="searchApplicationNo" name="application_no" placeholder="Enter Application No." class="form-control csp-admin-form-input">
                    </div>

                    <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary btn csp-admin-search-form">View</button>
                    </div>
                </div>
            </form>
           {{-- VIEW TABLE --}}
{{-- VIEW TABLE --}}
{{-- @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif


        </div>
    </div> --}}



{{-- SCRIPT --}}

<div class="container-fluid py-4">
    <div class="card shadow rounded-2xl">
        <div class="card-header">
            <h4 class="mb-0">Search Application</h4>
              {{-- ERROR MESSAGE --}}
   
        </div>
        <div class="card-body">
 @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- SEARCH FORM --}}
    <form action="{{ route('admin.view_archive_application.show') }}" method="POST">
        @csrf
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Clinic Type</label>
                <select class="form-control" name="clinic_type">
                    <option value="">Select Clinic Type</option>
                    <option value="art_bank" {{ (old('clinic_type') ?? $clinicType ?? '') == 'art_bank' ? 'selected' : '' }}>ART Bank</option>
                    <option value="art_clinic" {{ (old('clinic_type') ?? $clinicType ?? '') == 'art_clinic' ? 'selected' : '' }}>ART Clinic</option>
                    <option value="art_surrogacy" {{ (old('clinic_type') ?? $clinicType ?? '') == 'art_surrogacy' ? 'selected' : '' }}>ART Surrogacy</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Application Number</label>
                <input type="text" id="searchApplicationNo" name="application_no" 
                       placeholder="Enter Application No." 
                       class="form-control csp-admin-form-input"
                       value="{{ old('application_no') ?? $applicationNo ?? '' }}">
            </div>

            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary btn csp-admin-search-form">View</button>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
</div>







 <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
    





@endsection
