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

.readonly {
    background: #eef1f4 !important;
    font-weight: 600;
}

.form-control.is-invalid {
    border-color: #2d28c8 !important;
    border-right: 0rem !important;
}

</style>

<div class="container-fluid">

<div class="form-wrapper">

<h3 class="page-title"> Clinic/Bank Suspension/Cancellation of Registration</h3>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please correct the following error(s):</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="POST" id="suspensionForm"
      action="{{ route('suspension.sa.submit_application', $encryptedClinicId) }}"
      enctype="multipart/form-data"
      >
    @csrf

    <input type="hidden" name="submit_type" id="submit_type">

    {{-- ================= SECTION 1 ================= --}}
    <div class="form-section vailation-red">
        <div class="form-section-header">1. DETAILS OF CLINIC</div>

        <div class="form-section-body">
            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Name of Clinic/Bank</label>
                    <input type="text" class="form-control"
                        value="{{ $application->name ?? '' }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Registration No.</label>
                    <input type="text" class="form-control"
                        value="{{ $application->registration_no ?? '' }}" readonly>
                </div>

               <div class="col-md-4 mb-3">
                    <label>Clinic Type</label>

                    <!-- <select name="clinic_type" id="clinic_type" class="form-control"> -->
                        <!-- <option value="">-- Select Clinic Type --</option>
                        <option value="ARTCLINIC" {{ ($application->clinic_type ?? '') == 'ARTCLINIC' ? 'selected' : '' }}>
                            ARTCLINIC
                        </option>

                        <option value="ARTBANK" {{ ($application->clinic_type ?? '') == 'ARTBANK' ? 'selected' : '' }}>
                            ARTBANK
                        </option>

                        <option value="ARTSURROGACY" {{ ($application->clinic_type ?? '') == 'ARTSURROGACY' ? 'selected' : '' }}>
                            ARTSURROGACY
                        </option> 
                        </select>-->
                        <input
                            type="text"
                            name="clinic_type"
                            id="clinic_type"
                            class="form-control"
                            value="{{ old('clinic_type', $application->clinic_type ?? '') }}"
                            readonly
                        >
                   

                    <div class="text-danger small" id="clinic_type_error"></div>
                </div>
                
                <div class="col-md-4 mb-3" id="clinic_level_group" style="display:none;">
                    <label>Clinic Level <span class="text-danger">*</span></label>

                    <!-- <select name="clinic_level" id="clinic_level" class="form-control">
                        <option value="">-- Select Clinic Level --</option>

                        <option value="{{$application->level}}"
                            {{ ($application->level ?? '') == 'Level-1' ? 'selected' : '' }}>
                            LEVEL 1
                        </option>

                        <option value="{{$application->level}}"
                            {{ ($application->level ?? '') == 'Level-2' ? 'selected' : '' }}>
                            LEVEL 2
                        </option>
                        
                    </select> -->

                    <input
                        type="text"
                        name="clinic_level"
                        id="clinic_level"
                        class="form-control"
                        value="{{ old('clinic_level', $application->level ?? '') }}"
                        readonly
                    >

                    <div class="text-danger small" id="clinic_level_error"></div>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control"
                        value="{{ $application->address ?? '' }}" readonly>
                </div>

                <div class="col-md-3 mb-3">
                    <label>District</label>
                    <input type="text" class="form-control"
                        value="{{ $application->district ?? '' }}" readonly>
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

            </div>
        </div>
    </div>

    {{-- ================= SECTION 2 ================= --}}
    <div class="form-section">

        <div class="form-section-header">
            2. REQUET OF SUSPENSION / CANCELLATION
        </div>

        <div class="form-section-body">

            <!-- Action Type -->
            <div class="card border-0 mb-4">
                <div class="card-body py-3">

                    <label class="fw-bold mb-3">
                        Suspension/Cancellation <span class="text-danger">*</span>
                    </label>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="action_type"
                                       id="suspension"
                                       value="Suspension"
                                       checked 
                                       {{ old('action_type') == 'Suspension' ? 'checked' : '' }}>

                                <label class="form-check-label fw-semibold" for="suspension">
                                    Suspension
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="action_type"
                                       id="cancellation"
                                       value="Cancellation"
                                       {{ old('action_type') == 'Cancellation' ? 'checked' : '' }}>

                                <label class="form-check-label fw-semibold" for="cancellation">
                                    Cancellation
                                </label>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            <!-- Primary Reason -->
            <div class="card border-0 mb-4">
                <div class="card-body py-3">

                    <label class="fw-bold mb-3">
                        Primary Reason <span class="text-danger">*</span>
                    </label>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="reason"
                                       id="reason_violation"
                                       value="Violation of Rules"
                                       {{ old('reason') == 'Violation of Rules' ? 'checked' : '' }}>

                                <label class="form-check-label" for="reason_violation">
                                    Violation of Rules
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="reason"
                                       id="reason_non_compliance"
                                       value="Non-Compliance"
                                       {{ old('reason') == 'Non-Compliance' ? 'checked' : '' }}>

                                <label class="form-check-label" for="reason_non_compliance">
                                    Non-Compliance
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="reason"
                                       id="reason_patient_safety"
                                       value="Patient Safety Issues"
                                       {{ old('reason') == 'Patient Safety Issues' ? 'checked' : '' }}>

                                <label class="form-check-label" for="reason_patient_safety">
                                    Patient Safety Issues
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="reason"
                                       id="reason_inspection"
                                       value="Inspection Failure"
                                       {{ old('reason') == 'Inspection Failure' ? 'checked' : '' }}>

                                <label class="form-check-label" for="reason_inspection">
                                    Inspection Failure
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="reason"
                                       id="reason_other"
                                       value="Others"
                                       {{ old('reason') == 'Others' ? 'checked' : '' }}>

                                <label class="form-check-label" for="reason_other">
                                    Others
                                </label>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">
                    Please Specify <span class="text-danger">*</span>
                </label>

                <textarea class="form-control"
                          name="reason_details"
                          rows="4"
                          placeholder="Please Specify...">{{ old('reason_details', $application->reason_details ?? '') }}</textarea>
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

                <div class="col-md-4 mb-3">
                    <label>Suspension From Date <span class="required">*</span></label>
                    <input type="date"
                           name="suspension_from_date"
                           class="form-control"
                           value="{{ old('suspension_from_date') }}">
                </div>

                <div class="col-md-4 mb-3" id="toDateSection">
                    <label>Suspension To Date <span class="required">*</span></label>
                    <input type="date"
                           name="suspension_to_date"
                           class="form-control"
                           value="{{ old('suspension_to_date') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>
                        Suspension Order Document <span class="required">*</span>
                    </label>

                    <input type="file"
                           name="suspension_order_document"
                           class="form-control"
                           accept=".pdf,.jpg,.jpeg,.png">

                    <small class="text-muted">
                        Allowed file types: PDF, JPG, JPEG, PNG (Max: 2 MB)
                    </small>
                </div>

            </div>

            <div class="alert alert-warning mb-0">
                <strong>Order Summary</strong>
                <br> Upon approval, the registration of this Clinical Establishment shall remain
                <strong>Suspended</strong> from the effective date until revoked or the suspension period expires, in accordance with the applicable provisions of the Act and Rules.
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
                    <input type="text" name="authorized_name" class="form-control" value="{{ old('authorized_name') }}" placeholder="Enter authorized person name">
                </div>

                <div class="col-md-6">
                    <label>Designation</label>
                    <input 
                        type="text" 
                        name="authorized_designation" 
                        class="form-control" 
                        value="{{ old('authorized_designation') }}" placeholder="Enter authorized designation">
                </div>

                <div class="col-md-6">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address">
                </div>

                <div class="col-md-6">
                    <label>Date</label>
                    <input type="date" name="auth_date" class="form-control" value="{{ $todayDate }}">
                </div>

            </div>
        </div>
    </div>

    {{-- ================= BUTTONS ================= --}}
    <div class="text-center mt-4">

        <button type="submit"
                class="btn btn-danger px-4"
                onclick="document.getElementById('submit_type').value='submit'">
            Issue suspension
        </button>

    </div>

</form>

</div>
</div>

<script nonce="{{ $cspNonce }}">
    (function () {

        const form = document.getElementById('suspensionForm');
        if (!form) return;

        /* ===========================
           ELEMENTS
        =========================== */

        const clinicType = document.getElementById('clinic_type');
        const clinicLevel = document.getElementById('clinic_level');
        const clinicLevelGroup = document.getElementById('clinic_level_group');

        const toDateSection = document.getElementById('toDateSection');

        const remarks = document.querySelector('[name="reason_details"]');

        const fromDate = document.querySelector('[name="suspension_from_date"]');
        const toDate = document.querySelector('[name="suspension_to_date"]');

        const orderDoc = document.querySelector('[name="suspension_order_document"]');

        const authName = document.querySelector('[name="authorized_name"]');
        const authDesignation = document.querySelector('[name="authorized_designation"]');
        const email = document.querySelector('[name="email"]');
        const authDate = document.querySelector('[name="auth_date"]');


        /* ===========================
           COMMON FUNCTIONS
        =========================== */

        function showError(message, element = null) {
            alert(message);

            if (element) {
                element.focus();
            }

            return false;
        }

        function isEmpty(value) {
            return !value || value.toString().trim() === '';
        }

        function required(element, message) {

            if (!element || isEmpty(element.value)) {
                return showError(message, element);
            }

            return true;
        }

        function radioRequired(name, message) {

            const selected = document.querySelector(`input[name="${name}"]:checked`);

            if (!selected) {
                showError(message);
                return null;
            }

            return selected;
        }


        /* ===========================
           UI FUNCTIONS
        =========================== */

        let clinicLevelValue = '';

        function toggleClinicLevel() {
            if (clinicType.value === 'ARTCLINIC') {
                clinicLevelGroup.style.display = '';

                if (clinicLevelValue !== '') {
                    clinicLevel.value = clinicLevelValue;
                }
            } else {
                if (clinicLevel.value !== '') {
                    clinicLevelValue = clinicLevel.value;
                }

                clinicLevelGroup.style.display = 'none';
                clinicLevel.value = '';
            }
        }

        clinicType.addEventListener('change', toggleClinicLevel);
        toggleClinicLevel();

        function toggleToDate() {

            const action = radioRequired('action_type', '');

            if (!action) return;

            if (action.value === 'Cancellation') {

                toDateSection.style.display = 'none';
                toDate.value = '';

            } else {

                toDateSection.style.display = '';
            }
        }

        toggleClinicLevel();
        toggleToDate();

        clinicType.addEventListener('change', toggleClinicLevel);

        document.querySelectorAll('input[name="action_type"]').forEach(function (radio) {

            radio.addEventListener('change', toggleToDate);

        });


        /* ===========================
           FILE VALIDATION
        =========================== */

        function validateFile() {

            if (!orderDoc.files.length) {

                return showError(
                    'Please upload Order Document.',
                    orderDoc
                );
            }

            const file = orderDoc.files[0];

            const allowed = [
                'application/pdf',
                'image/jpeg',
                'image/png'
            ];

            if (!allowed.includes(file.type)) {

                return showError(
                    'Only PDF, JPG, JPEG and PNG files are allowed.',
                    orderDoc
                );
            }

            if (file.size > (2 * 1024 * 1024)) {

                return showError(
                    'Maximum file size is 2 MB.',
                    orderDoc
                );
            }

            return true;
        }


        /* ===========================
           DATE VALIDATION
        =========================== */

        function validateDates(action) {

            if (!required(fromDate, 'Please select Effective From Date.')) {

                return false;
            }

            if (action.value === 'Suspension') {

                if (!required(toDate, 'Please select Suspension To Date.')) {

                    return false;
                }

                if (new Date(toDate.value) < new Date(fromDate.value)) {

                    return showError(
                        'Suspension To Date should be greater than or equal to Effective From Date.',
                        toDate
                    );
                }
            }

            return true;
        }

        function validateEmail(element) {

            if (!required(element, 'Email is required.')) {
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(element.value.trim())) {
                return showError(
                    'Please enter a valid email address.',
                    element
                );
            }

            return true;
        }

        /* ===========================
           MAIN VALIDATION
        =========================== */

        function validateForm() {

            const action = radioRequired(
                'action_type',
                'Please select Suspension/Cancellation.'
            );

            if (!action) return false;

            if (!radioRequired(
                'reason',
                'Please select Primary Reason.'
            )) return false;

            if (!required(
                remarks,
                'Please enter Reason Details.'
            )) return false;

            if (!validateDates(action)) return false;

            if (!validateFile()) return false;

            const validations = [
                [authName, 'Authorized Name is required.'],
                [authDesignation, 'Designation is required.'],
                [authDate, 'Authorization Date is required.']
            ];

            for (const [element, message] of validations) {
                if (!required(element, message)) {
                    return false;
                }
            }

            if (!validateEmail(email)) return false;

            return true;
        }

        /* ===========================
           SUBMIT
        =========================== */
        let isSubmitting = false;

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            if (isSubmitting) {
                return;
            }

            if (!validateForm()) {
                return;
            }

            const action = document.querySelector('input[name="action_type"]:checked').value;

            const message = action === 'Cancellation'
                ? 'Please verify all details before proceeding. Are you sure you want to issue the Cancellation Order for this clinic/bank?'
                : 'Please verify all details before proceeding. Are you sure you want to issue the Suspension Order for this clinic/bank?';

            if (confirm(message)) {
                isSubmitting = true;
                form.submit();
            }
        });
    })();
</script>
@endsection