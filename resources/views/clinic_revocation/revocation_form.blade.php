@extends('layouts.admin.ssa_master')

@section('content')

<style nonce="{{ $cspNonce }}">
body {
    background: #f4f6f9;
}

.form-wrapper {
    border: 2px solid #cdd0d5;
    border-radius: 10px;
    background: #fff;
    padding: 20px;
}

.page-title {
    font-weight: 700;
    color: #1d4ed8;
    margin-bottom: 20px;
}

.form-section {
    border: 1px solid #cfd6dd;
    border-radius: 8px;
    margin-bottom: 18px;
}

.form-section-header {
    background: #aeb1b7;
    color: #fff;
    padding: 10px 15px;
    font-weight: 600;
}

.form-section-body {
    padding: 18px;
}

.required { color: red; }

.readonly-bg {
    background: #eef1f4 !important;
    font-weight: 600;
}
</style>

<div class="container-fluid">

<div class="form-wrapper">

<h3 class="page-title">Clinic Revocation of Suspension Application</h3>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST"
      id="revocationForm"
      enctype="multipart/form-data"
      action="{{ route('revocation.sa.submit_application', $encryptedClinicId) }}">
    @csrf
    <input type="hidden" name="sus_application_id" value="{{ $application->suspension_application->id }}">
    {{-- ================= SECTION 1 ================= --}}
    <div class="form-section">
        <div class="form-section-header">1. Application DETAILS</div>

        <div class="form-section-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Name of application</label>
                    <input type="text" class="form-control"
                        value="{{ $application->name ?? '' }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Registration No.</label>
                    <input type="text" class="form-control"
                        value="{{ $application->registration_no ?? '' }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Application No.</label>
                    <input type="text" class="form-control" name="application_no" 
                        value="{{ $application->application_no ?? '' }}" readonly>
                </div> 

                <div class="col-md-4 mb-3">
                    <label>Clinic Type</label>
                    <input type="text" class="form-control" name="clinic_type" 
                        value="{{ $application->clinic_type ?? '' }}" readonly>
                </div>

                @if(($application->clinic_type ?? '') === 'ARTCLINIC')
                    <div class="col-md-4 mb-3">
                        <label>Clinic Level</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $application->level ?? '' }}"
                               readonly>
                    </div>
                @endif

                <div class="col-md-4 mb-3">
                    <label>District</label>
                    <input type="text" class="form-control"
                        value="{{ $application->district ?? '' }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control"
                        value="{{ $application->address ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>State</label>
                    <input type="text" class="form-control"
                        value="{{ $application->state ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Pincode</label>
                    <input type="text" class="form-control"
                        value="{{ $application->pincode ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <input type="text" class="form-control"
                        value="{{ $application->suspension_application->appstatus ?? '' }} " readonly>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= SECTION 2 ================= --}}
    <div class="form-section">
        <div class="form-section-header">
            2. REVOCATION REASON
        </div>

        <div class="form-section-body">

            <label class="fw-bold mb-3">
                Select Revocation Reason <span class="required">*</span>
            </label>

            <div class="row">

                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="reason"
                               id="compliance_achieved"
                               value="Compliance Achieved"
                               >

                        <label class="form-check-label" for="compliance_achieved">
                            Compliance Achieved
                        </label>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="reason"
                               id="inspection_cleared"
                               value="Inspection Cleared">

                        <label class="form-check-label" for="inspection_cleared">
                            Inspection Cleared
                        </label>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="reason"
                               id="corrective_actions"
                               value="Corrective Actions Completed">

                        <label class="form-check-label" for="corrective_actions">
                            Corrective Actions Completed
                        </label>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="reason"
                               id="legal_clearance"
                               value="Legal Clearance">

                        <label class="form-check-label" for="legal_clearance">
                            Legal Clearance
                        </label>
                    </div>
                </div>

                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="radio"
                               name="reason"
                               id="other_reason"
                               value="Other">

                        <label class="form-check-label" for="other_reason">
                            Other
                        </label>
                    </div>
                </div>

            </div>

            <div class="mt-3">
                <label>
                    Detailed Explanation <span class="required">*</span>
                </label>

                <textarea name="reason_details"
                          class="form-control"
                          rows="4"
                          placeholder="Provide details for revocation..."
                          >{{ old('reason_details') }}</textarea>
            </div>

        </div>
    </div>

    {{-- ================= SECTION 3 ================= --}}

    <div class="form-section">
        <div class="form-section-header">
            3. REVOCATION ORDER DETAILS
        </div>

        <div class="form-section-body">

            <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Suspension From Date <span class="required">*</span></label>
                        <input type="date"
                               name="suspension_from_date"
                               class="form-control"
                               value="{{ $application->suspension_application->suspension_from_date ?? '' }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3" id="toDateSection">
                        <label>Suspension To Date <span class="required">*</span></label>
                        <input type="date"
                               name="suspension_to_date"
                               class="form-control"
                               value="{{ $application->suspension_application->suspension_to_date ?? '' }}" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>
                            Revocation Order Document <span class="required">*</span>
                        </label>

                        <input type="file"
                               name="revocation_order_document"
                               class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png">

                        <small class="text-muted">
                            Allowed file types: PDF, JPG, JPEG, PNG (Max: 2 MB)
                        </small>
                    </div>

                </div>

                <div class="alert alert-warning mb-0">
                    <strong>Order Summary</strong>
                    <br> 

                        Upon approval, the suspension of this Clinical Establishment shall be <strong>revoked</strong> from the effective date, and the registration shall remain <strong>valid and active,</strong> in accordance with the applicable provisions of the Act and Rules.
                </div>
        </div>
    </div>

    {{-- ================= SECTION 4 ================= --}}
    <div class="form-section">
        <div class="form-section-header">
            4. AUTHORIZED BY
        </div>

        <div class="form-section-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="authorized_name" class="form-label">
                        Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="authorized_name"
                        name="authorized_name"
                        class="form-control @error('authorized_name') is-invalid @enderror"
                        value="{{ old('authorized_name') }}"
                        placeholder="Enter authorized person's name">

                    @error('authorized_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="authorized_designation" class="form-label">
                        Designation <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="authorized_designation"
                        name="authorized_designation"
                        class="form-control @error('authorized_designation') is-invalid @enderror"
                        value="{{ old('authorized_designation') }}"
                        placeholder="Enter designation">

                    @error('authorized_designation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">
                        Email <span class="text-danger">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}"
                        placeholder="Enter email address">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="auth_date" class="form-label">
                        Date
                    </label>
                    <input
                        type="date"
                        id="auth_date"
                        name="auth_date"
                        class="form-control"
                        value="{{ old('auth_date', $todayDate) }}" readonly>

                    @error('auth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
    </div>  

    {{-- ================= BUTTONS ================= --}}
    <div class="text-center mt-4">

        <button type="submit"
                class="btn btn-primary px-4"
                onclick="document.getElementById('submit_type').value='submit'">
            Revoke Suspension
        </button>

    </div>

</form>

</div>
</div>

<script nonce="{{ $cspNonce }}">
(function () {

    const form = document.getElementById('revocationForm');
    if (!form) return;

    function error(msg, el = null) {
        alert(msg);

        if (el) {
            setTimeout(() => {
                el.focus();
            }, 10);
        }

        return false;
    }

    function isEmpty(v) {
        return !v || v.toString().trim() === '';
    }

    form.addEventListener('submit', function (e) {

        const reason = document.querySelector('input[name="reason"]:checked');
        if (!reason) {
            e.preventDefault();
            return error('Please select Revocation Reason');
        }

        const details = document.querySelector('[name="reason_details"]');
        if (!details || isEmpty(details.value)) {
            e.preventDefault();
            return error('Please enter Detailed Explanation', details);
        }

        const fileInput = document.querySelector('[name="revocation_order_document"]');

        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            return error('Please upload Order Document', fileInput);
        }

        const file = fileInput.files[0];

        const allowed = ['application/pdf','image/jpeg','image/jpg','image/png'];

        if (!allowed.includes(file.type)) {
            e.preventDefault();
            return error('Invalid file type', fileInput);
        }

        if (file.size > 2 * 1024 * 1024) {
            e.preventDefault();
            return error('File must be less than 2MB', fileInput);
        }

        const name = document.querySelector('[name="authorized_name"]');
        if (!name || isEmpty(name.value)) {
            e.preventDefault();
            return error('Authorized Name required', name);
        }

        const des = document.querySelector('[name="authorized_designation"]');
        if (!des || isEmpty(des.value)) {
            e.preventDefault();
            return error('Designation required', des);
        }

        const email = document.querySelector('[name="email"]');

        if (!email || isEmpty(email.value)) {
            e.preventDefault();
            return error('Email is required.', email);
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email.value.trim())) {
            e.preventDefault();
            return error('Please enter a valid email address.', email);
        }

        const date = document.querySelector('[name="auth_date"]');
        if (!date || isEmpty(date.value)) {
            e.preventDefault();
            return error('Authorization date required', date);
        }

        const confirmed = confirm(
            "Are you sure you want to submit the revocation application? Once submitted, the information cannot be modified."
        );

        if (!confirmed) {
            e.preventDefault();
            return;
        }
    });

})();
</script>
@endsection