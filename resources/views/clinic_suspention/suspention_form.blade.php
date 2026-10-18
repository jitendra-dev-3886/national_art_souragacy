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
    color: #133c37f5;
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

<h3 class="page-title"> Suspension Application Form </h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST"
      action="{{ route('suspention.sa.submit_application', $encryptedClinicId) }}">
    @csrf

    <input type="hidden" name="submit_type" id="submit_type">

    {{-- ================= SECTION 1 ================= --}}
    <div class="form-section">
        <div class="form-section-header">1. DETAILS OF application</div>

        <div class="form-section-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Name of application</label>
                    <input type="text" class="form-control readonly-bg"
                        value="{{ $application->name ?? '' }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Registration No.</label>
                    <input type="text" class="form-control readonly-bg"
                        value="{{ $application->registration_no ?? '' }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Clinic Type</label>

                    <select name="clinic_type" id="clinic_type" class="form-control">
                        <option value="">-- Select Clinic Type --</option>
                        <option value="ARTCLINIC" {{ ($application->clinic_type ?? '') == 'ARTCLINIC' ? 'selected' : '' }}>
                            ARTCLINIC
                        </option>
                        <option value="NON_ARTCLINIC" {{ ($application->clinic_type ?? '') == 'NON_ARTCLINIC' ? 'selected' : '' }}>
                            NON ARTCLINIC
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control readonly-bg"
                        value="{{ $application->address ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>District</label>
                    <input type="text" class="form-control readonly-bg"
                        value="{{ $application->district ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>State</label>
                    <input type="text" class="form-control readonly-bg"
                        value="{{ $application->state ?? '' }}" readonly>
                </div>

               <div class="col-md-4 mb-3" id="clinic_level_group" style="display:none;">
                    <label>Clinic Level</label>

                    <input type="text"
                        name="clinic_level"
                        id="clinic_level"
                        class="form-control"
                        value="{{ old('clinic_level', $application->clinic_level ?? '') }}"
                        placeholder="Enter clinic level">

                    <div class="text-danger small" id="clinic_level_error"></div>
            </div>                                          

            </div>
        </div>
    </div>

    {{-- ================= SECTION 2 ================= --}}
    <div class="form-section">
    <div class="form-section-header">
        2. REASON FOR SUSPENSION
    </div>

    <div class="form-section-body">

        <label class="fw-bold mb-3">
            Select the Primary Reason <span class="required">*</span>
        </label>

        <div class="row">

            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="reason"
                           id="reason1"
                           value="Violation of Rules"
                           >

                    <label class="form-check-label" for="reason1">
                        Violation of Rules
                    </label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="reason"
                           id="reason2"
                           value="Non-Compliance">

                    <label class="form-check-label" for="reason2">
                        Non-Compliance
                    </label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="reason"
                           id="reason3"
                           value="Patient Safety Issues">

                    <label class="form-check-label" for="reason3">
                        Patient Safety Issues
                    </label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="reason"
                           id="reason4"
                           value="Inspection Failure">

                    <label class="form-check-label" for="reason4">
                        Inspection Failure
                    </label>
                </div>
            </div>

            <div class="col-md-4 mb-2">
                <div class="form-check">
                    <input class="form-check-input"
                           type="radio"
                           name="reason"
                           id="reason5"
                           value="Others">

                    <label class="form-check-label" for="reason5">
                        Others
                    </label>
                </div>
            </div>

        </div>

        <div class="mb-3">
            <label class="fw-bold">Action Type <span class="required">*</span></label>
            <div class="d-flex gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="action_type" id="action_type_suspension" value="suspension">
                    <label class="form-check-label" for="action_type_suspension">Suspension</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="action_type" id="action_type_cancellation" value="cancellation">
                    <label class="form-check-label" for="action_type_cancellation">Cancellation</label>
                </div>
            </div>
            <div class="text-danger small" id="action_type_error"></div>
        </div>

        <div class="text-danger small mb-2" id="reason_error"></div>

        <div class="mt-3">
            <label>Remarks <span class="required">*</span></label>
            <textarea class="form-control"
                      name="reason_details"
                      rows="4"
                      placeholder="Enter detailed reason for suspension..."
                      ></textarea>
            <div class="text-danger small" id="reason_details_error"></div>
        </div>

    </div>
</div>

    {{-- ================= SECTION 3 ================= --}}
   <div class="form-section">
    <div class="form-section-header">
        3. SUSPENSION ORDER DETAILS
    </div>

    <div class="form-section-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>From date <span class="required">*</span></label>
                <input type="date"
                       name="suspension_from_date"
                       class="form-control"
                       >
                <div class="text-danger small" id="suspension_from_date_error"></div>
            </div>

            <div class="col-md-6 mb-3">
                <label>To date</label>
                <input type="date"
                       name="suspension_to_date"
                       class="form-control">
                <div class="text-danger small" id="suspension_to_date_error"></div>
            </div>

        </div>

        <div class="alert alert-warning mb-0">
            <strong>Order Summary</strong><br>
            Upon approval, the registration of this Clinical Establishment shall remain
            <strong>Suspended</strong> from the effective date until revoked or the suspension
            period expires, in accordance with the applicable provisions of the Act and Rules.
        </div>

    </div>
</div>

    {{-- ================= SECTION 5 ================= --}}
    <div class="form-section">
        <div class="form-section-header">5. AUTHORIZED BY</div>

        <div class="form-section-body">
            <div class="row">

                <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="authorized_name" class="form-control">
                    <div class="text-danger small" id="authorized_name_error"></div>
                </div>

                <div class="col-md-6">
                    <label>Designation</label>
                    <input type="text" name="authorized_designation" class="form-control">
                    <div class="text-danger small" id="authorized_designation_error"></div>
                </div>

                <div class="col-md-6">
                    <label>Signature</label>
                    <input type="text" name="signature" class="form-control">
                    <div class="text-danger small" id="signature_error"></div>
                </div>

                <div class="col-md-6">
                    <label>Date</label>
                    <input type="date" name="auth_date" class="form-control">
                    <div class="text-danger small" id="auth_date_error"></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= BUTTONS ================= --}}
    <div class="text-center mt-4">

        <button type="submit"
                class="btn btn-danger px-4"
                onclick="document.getElementById('submit_type').value='submit'">
            Issue Suspension
        </button>

    </div>

</form>

</div>
</div>

<script nonce="{{ $cspNonce }}">
(function () {

    const form = document.querySelector('form');
    if (!form) return;

    const errors = {
        reason: document.getElementById('reason_error'),
        reason_details: document.getElementById('reason_details_error'),
        action_type: document.getElementById('action_type_error'),
        clinic_level: document.getElementById('clinic_level_error'),
        suspension_from_date: document.getElementById('suspension_from_date_error'),
        suspension_to_date: document.getElementById('suspension_to_date_error'),
        authorized_name: document.getElementById('authorized_name_error'),
        authorized_designation: document.getElementById('authorized_designation_error'),
        signature: document.getElementById('signature_error'),
        auth_date: document.getElementById('auth_date_error'),
    };

    const fields = {
        reason: () => document.querySelector('input[name="reason"]:checked'),
        action_type: () => document.querySelector('input[name="action_type"]:checked'),
        clinic_level: () => document.getElementById('clinic_level'),
        reason_details: () => document.querySelector('[name="reason_details"]'),
        from: () => document.querySelector('[name="suspension_from_date"]'),
        to: () => document.querySelector('[name="suspension_to_date"]'),
        authorized_name: () => document.querySelector('[name="authorized_name"]'),
        authorized_designation: () => document.querySelector('[name="authorized_designation"]'),
        signature: () => document.querySelector('[name="signature"]'),
        auth_date: () => document.querySelector('[name="auth_date"]'),
    };

    function clearErrors() {
        Object.values(errors).forEach(el => {
            if (el) el.textContent = '';
        });
    }

    function setError(el, errEl, msg) {
        if (errEl) errEl.textContent = msg;
        if (el) el.focus();
        return false;
    }

    function validateDates(fromEl, toEl) {
        if (!fromEl || !toEl) return true;

        if (fromEl.value && toEl.value) {
            return new Date(toEl.value) >= new Date(fromEl.value);
        }
        return true;
    }

    /* ----------------------------
       CLINIC LEVEL TOGGLE (UI ONLY)
    ---------------------------- */
    const clinicType = document.querySelector('[name="clinic_type"]');
    const clinicLevelGroup = document.getElementById('clinic_level_group');
    const clinicLevel = document.getElementById('clinic_level');

    function toggleClinicLevel() {
        if (!clinicType || !clinicLevelGroup) return;

        const value = clinicType.value.trim().toUpperCase();

        if (value === 'ARTCLINIC') {
            clinicLevelGroup.style.display = 'block';
        } else {
            clinicLevelGroup.style.display = 'none';
            if (clinicLevel) clinicLevel.value = '';
        }
    }

    // run once on load
    toggleClinicLevel();

    // run on change
    if (clinicType) {
        clinicType.addEventListener('change', toggleClinicLevel);
    }

    /* ----------------------------
       VALIDATION
    ---------------------------- */
    function validateForm() {

        clearErrors();
        let valid = true;

        const reason = fields.reason();
        if (!reason) {
            valid = setError(null, errors.reason, 'Please select a suspension reason.') && valid;
        }

        const action = fields.action_type();
        if (!action) {
            valid = setError(null, errors.action_type, 'Please select an action type.') && valid;
        }

        const remarks = fields.reason_details();
        if (!remarks?.value.trim()) {
            valid = setError(remarks, errors.reason_details, 'Please enter remarks.') && valid;
        }

        const from = fields.from();
        const to = fields.to();

        if (action?.value === 'suspension') {

            if (!from?.value) {
                valid = setError(from, errors.suspension_from_date, 'Please select From Date for suspension.') && valid;
            }

            if (!to?.value) {
                valid = setError(to, errors.suspension_to_date, 'Please select To Date for suspension.') && valid;
            }

            if (!validateDates(from, to)) {
                valid = setError(to, errors.suspension_to_date, 'To Date must be >= From Date.') && valid;
            }

        } else if (action?.value === 'cancellation') {

            if (!from?.value) {
                valid = setError(from, errors.suspension_from_date, 'Please select From Date for cancellation.') && valid;
            }

            if (!validateDates(from, to)) {
                valid = setError(to, errors.suspension_to_date, 'To Date must be >= From Date.') && valid;
            }
        }

        const authName = fields.authorized_name();
        if (!authName?.value.trim()) {
            valid = setError(authName, errors.authorized_name, 'Enter Authorized Name.') && valid;
        }

        const authDesignation = fields.authorized_designation();
        if (!authDesignation?.value.trim()) {
            valid = setError(authDesignation, errors.authorized_designation, 'Enter Designation.') && valid;
        }

        const signature = fields.signature();
        if (!signature?.value.trim()) {
            valid = setError(signature, errors.signature, 'Enter Signature.') && valid;
        }

        const authDate = fields.auth_date();
        if (!authDate?.value) {
            valid = setError(authDate, errors.auth_date, 'Select Authorization Date.') && valid;
        }

        return valid;
    }

    /* ----------------------------
       SUBMIT HANDLER
    ---------------------------- */
    form.addEventListener('submit', function (e) {

        if (!validateForm()) {
            e.preventDefault();

            const firstError = document.querySelector('[id$="_error"]:not(:empty)');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });

    /* ----------------------------
       AUTO CLEAR ERRORS
    ---------------------------- */
    document.querySelectorAll('input, textarea, select').forEach(el => {
        el.addEventListener('input', function () {
            const err = document.getElementById(this.name + '_error');
            if (err) err.textContent = '';
        });
    });

})();
</script>

@endsection