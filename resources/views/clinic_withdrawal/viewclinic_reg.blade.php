@extends('layouts.admin.ssa_master')

@section('content')

<style nonce="{{ $cspNonce }}">

    body {
        background: #f4f6f9;
    }

    /* OUTER WRAPPER */
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
        text-align: left;
    }

    /* SECTION BOX */
    .form-section {
        border: 1px solid #cfd6dd;
        border-radius: 8px;
        margin-bottom: 18px;
        background: #fff;
    }

    .form-section-header {
        background: #cdd0d5;
        color: #fff;
        padding: 10px 15px;
        font-weight: 600;
        border-radius: 8px 8px 0 0;
    }

    .form-section-body {
        padding: 18px;
    }

    label {
        font-weight: 600;
        font-size: 14px;
    }

    .form-control {
        border-radius: 5px;
    }

    .readonly-bg {
        background: #eef1f4 !important;
        font-weight: 600;
    }

    .required {
        color: red;
    }

    table th {
        background: #f1f3f6;
    }

    .btn {
        border-radius: 5px;
        padding: 8px 20px;
    }

</style>

<div class="container-fluid">

    <div class="form-wrapper">

        <h3 class="page-title">
            Application for Withdrawal of Registration of a Registered Clinic
        </h3>
       @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif        

        @if(session('success'))
            <div class="alert alert-{{ session('type') === 'submit' ? 'success' : 'success' }}">
                {{ session('success') }}
            </div>
        @endif
          <form id="withdrawalForm"
              method="POST"
              action="{{ route('withdrawal.sa.register.submit') }}"
              enctype="multipart/form-data">

            @csrf
            {{-- Hidden identifiers required by the controller --}}
            <input type="hidden" name="id" value="{{ $application->id }}">
            <input type="hidden" name="clinic_type" value="{{ $application->clinic_type }}">
            @php
                $fileField = strtolower($application->clinic_type) === 'artsurrogacy' ? 'reg_surrogacyclinic_certificate' : (strtolower($application->clinic_type) === 'artclinic' ? 'reg_artclinic_certificate' : 'reg_artbank_certificate');
            @endphp
            <input type="hidden" name="submit_type" id="submit_type" value="">

            <div class="form-section">

                <div class="form-section-header">
                    1. Clinic Details (As Registered)
                </div>

                <div class="form-section-body">

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label>Application No.</label>
                           
                            <input type="text" class="form-control readonly"
                                    name="applicationno" 
                                    value="{{ $application->applicationno ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Registration Number</label>
                           
                            <input type="text" class="form-control readonly"
                                    name="registration_no" 
                                    value="{{ $application->registration_no ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Name of the Clinic</label>
                            <input type="text" class="form-control readonly"
                                name="clinic_name" 
                                value="{{ $application->clinic_name ?? '-' }}" readonly>
                        </div> 

                        <div class="col-md-3 mb-3">
                            <label>Type of Clinic</label>
                            <input type="text" class="form-control readonly"
                                name="clinic_type" 
                                value="{{ $application->clinic_type ?? '-' }}" readonly>
                        </div> 

                        <div class="col-md-3 mb-3">
                            <label>Date of Registration</label>
                            <input type="text" class="form-control readonly"
                                   name="rgistration_date" 
                                   value="{{ $application->application_date ?? '-' }}" readonly>
                        </div> 

                        <div class="col-md-6 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control readonly"
                                name="address" 
                                value="{{ $application->address ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Picode</label>
                            <input type="text" class="form-control readonly"
                                name="pincode" 
                                value="{{ $application->pincode ?? '-'}}" readonly>
                        </div>

                         <div class="col-md-3 mb-3">
                            <label>State</label>
                            <input type="text" class="form-control readonly"
                                name="state" 
                                value="{{ $application->state ?? '-' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>District</label>
                            <input type="text" class="form-control readonly"
                                    name="district" 
                                   value="{{ $application->district ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">

                    <div class="form-section-header">
                        2. Withdrawal Request Details
                    </div>

                <div class="form-section-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>
                                Date of Application <span class="required">*</span>
                            </label>
                            <input type="date"
                                   name="application_date"
                                   class="form-control"
                                   value="{{ $application->application_date ?? '-' }}" readonly 
                                   >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>
                                Date of Withdrawal <span class="required">*</span>
                            </label>
                            <input type="date"
                               name="withdrawal_date"
                               class="form-control"
                               value="{{ $application->withdrawal_date ?? '' }}" 
                               readonly >
                        </div>

                        @php
                            $selectedReason = old(
                                'withdrawal_reason',
                                $clinic->withdrawal_reason ?? 'Voluntary Surrender'
                            );
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label class="fw-bold">
                                Reason of Withdrawal
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $selectedReason }}"
                                   readonly>

                            <input type="hidden"
                                   name="withdrawal_reason"
                                   value="{{ $selectedReason }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>
                                Please Specify <span class="required">*</span>
                            </label>

                            <textarea name="withdrawal_description"
                              id="withdrawal_description"
                              class="form-control" readonly
                              rows="3">{{ $application->withdrawal_description ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">

                <div class="form-section-header">
                    <i class="fa fa-file-text-o"></i> 3. Supporting Documents
                </div>

                <div class="form-section-body">

                    @forelse($uploadDocs as $doc)

                        <div class="card mb-3">
                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-md-8">
                                        <h6 class="mb-1">
                                                <label class="fw-bold mb-2">
                                               {{ $doc->doc_name ?? 'Supporting Document' }}
                                            </label>
                                        </h6>

                                        <small class="text-muted">
                                            Uploaded document available for review
                                        </small>
                                    </div>

                                    <div class="col-md-4 text-end">

                                        <a href="{{ asset('webprodfiles/clinic_application/' . str_replace('/', '_',$application->applicationno) . '/' . $doc->file_name) }}"
                                           target="_blank"
                                           class="btn btn-primary btn-sm">

                                            <i class="fa fa-eye"></i> View
                                        </a>

                                        <a href="{{ asset('webprodfiles/clinic_application/' . str_replace('/', '_',$application->applicationno) . '/' . $doc->file_name) }}"
                                           download
                                           class="btn btn-outline-secondary btn-sm">

                                            <i class="fa fa-download"></i>
                                        </a>

                                    </div>

                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="alert alert-warning mb-0">
                            <i class="fa fa-info-circle"></i>
                            No supporting documents uploaded.
                        </div>

                    @endforelse

                </div>

            </div>

            <div class="form-section">
                <div class="form-section-header">
                    4. Action by State Authority
                </div>

                <div class="form-section-body">

                    <!-- Decision -->
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row">

                                <!-- Decision -->
                                <div class="col-md-6">
                                    <label class="fw-bold mb-2">
                                        Decision <span class="text-danger">*</span>
                                    </label>

                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select</option>

                                        <option value="Approve"
                                            {{ old('status', $data->status ?? '') == 'Approve' ? 'selected' : '' }}>
                                            Approve
                                        </option>

                                        <option value="Reject"
                                            {{ old('status', $data->status ?? '') == 'Reject' ? 'selected' : '' }}>
                                            Reject
                                        </option>
                                    </select>
                                    @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Received Date -->
                                <div class="col-md-6">
                                    <label class="fw-bold mb-2">
                                       Date on which application recived by authority
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                           name="app_received_date"
                                           id="app_received_date"
                                           class="form-control"
                                           value="{{ old('app_received_date') }}">

                                    @error('app_received_date')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Registration Date -->
                              <!--   <div class="col-md-4">
                                    <label class="fw-bold mb-2">
                                        Date of online form submission (By the user Clinic)
                                    </label>

                                    <input type="date"
                                       name="registration_date"
                                       id="registration_date"
                                       class="form-control"
                                       value="{{ $application->registration_date ?? '' }}"
                                       >
                                    @error('registration_date')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Approval Section -->
                    <div class="card border-0 shadow-sm mb-3 d-none"
                         id="reg_number">

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="fw-bold mb-2">
                                        Registration Number
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="registration_no"
                                           id="registration_no"
                                           class="form-control"
                                           placeholder="Enter Registration Number"
                                           value="{{ old('registration_no') }}">
                                    @error('registration_no')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold">
                                        Received file
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input class="form-control"
                                           type="file"
                                           id="approve_order_file"
                                           name="approve_order_file"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           value="{{ old('approve_order_file') }}">
                                    @error('approve_order_file')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-block">
                                        PDF/JPG/JPEG/PNG • File Size: 50 KB to 200 KB
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Rejection Section -->
                    <div class="card border-0 shadow-sm mb-3 d-none"
                         id="rejection_section">

                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="fw-bold mb-2">
                                        Rejection Order Date
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                           name="date_rej"
                                           id="date_rej"
                                           class="form-control"
                                           value="{{ old('date_rej') }}">
                                    @error('date_rej')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-bold">
                                        Order of Rejection
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input class="form-control"
                                           type="file"
                                           id="rejection_order_file"
                                           name="rejection_order_file"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    @error('rejection_order_file')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-block">
                                        PDF/JPG/JPEG/PNG • File Size: 50 KB to 200 KB
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="text-center mt-3">

                <button type="submit"
                        id="submitButton"
                        value="submit"
                        class="btn btn-primary">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<script nonce="{{ $cspNonce }}">
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('withdrawalForm');

    const decision = document.getElementById('status');

    const regSection = document.getElementById('reg_number');
    const rejectSection = document.getElementById('rejection_section');

    const registrationNo = document.getElementById('registration_no');
    const dateRej = document.getElementById('date_rej');
    const appDate = document.getElementById('app_received_date');
    // const regDate = document.getElementById('date_reg');


    const approveFile = document.getElementById('approve_order_file');
    const rejectFile = document.getElementById('rejection_order_file');

    const RULES = {
        MIN_KB: 50,
        MAX_KB: 1024,
        EXT: ['pdf', 'jpg', 'jpeg', 'png']
    };

    function isBlank(field) {
        if (!field) return true;
        if (field.type === 'file') return !field.files || field.files.length === 0;
        return !field.value.trim();
    }

    function showError(message, field, event) {
        alert(message);
        if (field) field.focus();
        if (event) event.preventDefault();
        return false;
    }

    function setRequired(fields, status) {
        fields.forEach(function (field) {
            if (field) field.required = status;
        });
    }

    function validateFile(input) {
        if (!input || !input.files || !input.files.length) {
            return { isValid: false, message: 'Please select a file.' };
        }

        const file = input.files[0];
        const extension = file.name.split('.').pop().toLowerCase();
        const sizeKB = file.size / 1024;

        if (!RULES.EXT.includes(extension)) {
            return { isValid: false, message: 'Only PDF, JPG, JPEG, PNG allowed.' };
        }

        if (sizeKB < RULES.MIN_KB || sizeKB > RULES.MAX_KB) {
            return { isValid: false, message: 'File must be between 50 KB and 200 KB.' };
        }

        return { isValid: true };
    }

    function toggleSections() {
        const value = decision.value;

        const isApprove = value === 'Approve';
        const isReject = value === 'Reject';

        regSection.classList.toggle('d-none', !isApprove);
        rejectSection.classList.toggle('d-none', !isReject);
    }

    function init() {
        const today = new Date().toISOString().split('T')[0];
        if (dateRej) dateRej.max = today;

        toggleSections();
        decision?.addEventListener('change', toggleSections);

        [approveFile, rejectFile].forEach(function (input) {
            input?.addEventListener('change', function () {
                const result = validateFile(this);
                if (!result.isValid) {
                    alert(result.message);
                    this.value = '';
                }
            });
        });
    }

    function handleSubmit(event) {

        const value = decision.value;

        if (isBlank(decision)) {
            return showError('Please select a decision.', decision, event);
        }

        if (isBlank(appDate)) {
            return showError('Received Date is required.', appDate, event);
        }

        if (value === 'Approve') {

            if (isBlank(registrationNo)) {
                return showError('Registration Number is required.', registrationNo, event);
            }

            const result = validateFile(approveFile);
            if (!result.isValid) {
                return showError(result.message, approveFile, event);
            }
        }

        if (value === 'Reject') {

            if (isBlank(dateRej)) {
                return showError('Rejection Date is required.', dateRej, event);
            }

            if (appDate.value && new Date(dateRej.value) < new Date(appDate.value)) {
                return showError(
                    'Rejection date cannot be earlier than received date.',
                    dateRej,
                    event
                );
            }

            const result = validateFile(rejectFile);
            if (!result.isValid) {
                return showError(result.message, rejectFile, event);
            }
        }

        return true;
    }

    form?.addEventListener('submit', handleSubmit);

    init();

});
</script>
@endsection
