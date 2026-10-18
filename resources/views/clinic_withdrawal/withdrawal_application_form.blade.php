@extends('layouts.clinic.clinic_master')

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
            Application Form for Withdrawal of Registration of Registered Clinic
        </h3>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-{{ session('type') === 'submit' ? 'success' : 'success' }}">
                {{ session('success') }}
            </div>
        @endif
          <form id="withdrawalForm"
              method="POST"
              action="{{ route('submit_withdrawal.application_form', ['encryptedClinicId' => $encryptedClinicId]) }}"
              enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="submit_type" id="submit_type" value="">

            <div class="form-section">

                <div class="form-section-header">
                    1. Clinic Details (As Registered)
                </div>

                <div class="form-section-body">

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label>Registration Number</label>
                           
                            <input type="text" class="form-control"
                                    name="registration_no" 
                                    value="{{ old(
                                    'registration_no',
                                    $draftData->registration_no ?? $clinic->registration_no ?? ''
                                ) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Name of the Clinic</label>
                            <input type="text" class="form-control"
                                name="clinic_name" 
                                value="{{ old(
                                'clinic_name',
                                $draftData->clinic_name ?? $clinic->name ?? ''
                            ) }}" readonly>
                        </div> 

                        <div class="col-md-3 mb-3">
                            <label>Type of Clinic</label>
                            <input type="text" class="form-control"
                                name="clinic_type" 
                                value="{{ old(
                                'clinic_type',
                                $draftData->clinic_type ?? $clinic->clinic_type ?? ''
                            ) }}" readonly>
                        </div> 

                        <div class="col-md-3 mb-3">
                            <label>Date of Registration</label>
                            <input type="text" class="form-control"
                                   name="rgistration_date" 
                                   value="{{ old(
                                    'rgistration_date',
                                    $draftData->rgistration_date ?? $clinic->rgistration_date ?? ''
                                ) }}" readonly>
                        </div> 

                        <div class="col-md-6 mb-3">
                            <label>Address</label>
                            <input type="text" class="form-control"
                                name="address" 
                                value="{{ old(
                                'address',
                                $draftData->address ?? $clinic->address ?? ''
                            ) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>District</label>
                            <input type="text" class="form-control"
                                    name="district" 
                                   value="{{ old(
                                'rgistration_date',
                                $draftData->district ?? $clinic->district ?? ''
                            ) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>State</label>
                            <input type="text" class="form-control"
                                name="state" 
                                value="{{ old(
                                'state',
                                $draftData->state ?? $clinic->state ?? ''
                            ) }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Pnicode</label>
                            <input type="text" class="form-control"
                                name="pincode" 
                                value="{{ old(
                                'pincode',
                                $draftData->pincode ?? $clinic->pincode ?? ''
                            ) }}" readonly>
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

                        <div class="col-md-4 mb-3">
                            <label>
                                Date of Application <span class="required">*</span>
                            </label>
                            <input type="date"
                                   name="application_date"
                                   id="application_date"
                                   class="form-control"
                                   value="{{ $todayDate }}" readonly 
                                   >
                            @error('application_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>
                                Date of Withdrawal <span class="required">*</span>
                            </label>
                            <input type="date"
                               name="withdrawal_date"
                               id="withdrawal_date"
                               class="form-control"
                               value="{{ old(
                                'withdrawal_date',
                                $draftData->withdrawal_date ?? $clinic->withdrawal_date ?? ''
                            ) }}" 
                               >
                            @error('withdrawal_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @php
                            $selectedReason = old(
                                'withdrawal_reason',
                                $draftData->withdrawal_reason ?? 'Voluntary Surrender'
                            );
                        @endphp

                        <div class="col-md-12 mb-3">
                            <label>
                                Reason of Withdrawal <span class="required">*</span>
                            </label>

                            <div class="row mt-2">

                                <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="withdrawal_reason"
                                               value="Voluntary Surrender"
                                               {{ $selectedReason == 'Voluntary Surrender' ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            Voluntary Withdrawal by Clinic
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="withdrawal_reason"
                                               value="Closure of Clinic"
                                               {{ $selectedReason == 'Closure of Clinic' ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            Closure of Clinic
                                        </label>
                                    </div>
                                </div>

                                <!-- <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="withdrawal_reason"
                                               value="Ownership Transfer"
                                               {{ $selectedReason == 'Ownership Transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            Transfer Ownership
                                        </label>
                                    </div>
                                </div> -->

                                <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="withdrawal_reason"
                                               value="Other"
                                               {{ $selectedReason == 'Other' ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            Others
                                        </label>
                                    </div>
                                </div>

                            </div>

                            @error('withdrawal_reason')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>
                                Please Specify <span class="required">*</span>
                            </label>

                            <textarea name="withdrawal_description"
                              id="withdrawal_description"
                              class="form-control"
                              rows="3">{{ old(
                                        'withdrawal_description',
                                        $draftData->withdrawal_description ?? $clinic->withdrawal_description ?? ''
                                    ) }}</textarea>
                            @error('withdrawal_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">

                <div class="form-section-header">
                    3. Supporting Documents
                </div>

                <div class="form-section-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th width="35%">Document</th>
                                <th width="60%">Upload</th>
                            </tr>
                        </thead>

                       <tbody>
                       <tr>
                          <td>1</td>
                          <td>Withdrawal Request Letter <span class="required">*</span></td>
                          <td>
                            @php
                                $withDoc = collect($draftData->withdrawalDocuments ?? [])
                                    ->firstWhere('document_type', 'Withdrawal letter');
                            @endphp
                                <div class="position-relative">
                                    <input type="file"
                                           id="withdrawal_letter"
                                           name="withdrawal_letter"
                                           class="form-control pe-5"
                                           accept=".pdf,.jpg,.jpeg,.png">
                                         @if($withDoc)
                                               
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-2 d-flex gap-1">
                                            <a href="{{ asset('webprodfiles/clinic_application/' . str_replace('/', '_', $draftData->applicationno) . '/' . $draftData->withdrawalDocuments[0]->file_name) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-primary"
                                               title="Preview Existing File">
                                                👁
                                            </a>
                                    </div>
                                    <input type="hidden"
                                       name="withdrawal_letter_id"
                                       value="{{ $withDoc->id }}">
                                    @endif

                                </div>
                                @error('withdrawal_letter')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <small class="text-muted d-block mt-1">
                                    PDF, JPG, JPEG, PNG | Max Size: 2 MB
                                </small>
                            </td>
                       <!-- Records Transfer --> 
                       <tr>
                          <td>2</td>
                          <td>Records / Sample Undertaking <span class="required">*</span></td>
                          <td> 
                            @php
                                $recordDoc = collect($draftData->withdrawalDocuments ?? [])
                                    ->firstWhere('document_type', 'Records transfer document');
                            @endphp

                            <div class="position-relative">

                                <input type="file"
                                       name="records_transfer_document"
                                       id="records_transfer_document"
                                       class="form-control"
                                       style="padding-right:90px"
                                       accept=".pdf,.jpg,.jpeg,.png">
                                @if($recordDoc)
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-2 d-flex gap-1">

                                        <a href="{{ asset('webprodfiles/clinic_application/' . str_replace('/', '_', $draftData->applicationno) . '/' . $recordDoc->file_name) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-primary">
                                            👁
                                        </a>
                                    </div>

                                    <input type="hidden"
                                       name="records_transfer_document_id"
                                       value="{{ $recordDoc->id }}">
                                @endif
                            </div>
                            @error('records_transfer_document')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                           <small class="text-muted d-block mt-1"> PDF, JPG, JPEG, PNG | Max Size: 2 MB </small> 

                          </td>
                       </tr>
                       <!-- Additional Documents --> 
                       <tr>
                        <td>3</td>
                        <td>Additional Documents</td>
                        <td>

                            <div id="uploadContainer">

                                @if(isset($draftData) && collect($draftData->withdrawalDocuments)
                                        ->filter(fn($doc) => str_starts_with($doc->document_type ?? '', 'Other document'))
                                        ->count())

                                    @foreach(collect($draftData->withdrawalDocuments)
                                        ->filter(fn($doc) => str_starts_with($doc->document_type ?? '', 'Other document')) as $doc)

                                        <div class="row upload-row mb-2">

                                            <div class="col-md-5">
                                                <textarea name="uploadremarks[]" class="form-control" rows="3">{{ $doc->remarks }}</textarea>

                                                <input type="hidden"
                                                       name="document_id[]"
                                                       value="{{ $doc->id }}">
                                            </div>

                                            <div class="col-md-5">

                                                <div class="position-relative">

                                                    <input type="file"
                                                           name="other_document[]"
                                                           class="form-control inputFile_id"
                                                           accept=".pdf,.jpg,.jpeg,.png"
                                                           style="padding-right:80px;">

                                                    <div class="position-absolute top-50 end-0 translate-middle-y me-2">

                                                        <a href="{{ asset($doc->file_path.$doc->file_name) }}"
                                                           target="_blank"
                                                           class="btn btn-sm btn-primary">
                                                            👁
                                                        </a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger removeField">-</button>
                                                <button type="button" class="btn btn-primary addmore">+</button>
                                            </div>

                                        </div>

                                    @endforeach

                                @else

                                    <div class="row upload-row mb-2">

                                        <div class="col-md-5">

                                            <textarea name="uploadremarks[]" class="form-control" rows="3"></textarea>

                                            <input type="hidden"
                                                   name="document_id[]"
                                                   value="">

                                        </div>

                                        <div class="col-md-5">

                                            <input type="file"
                                                   name="other_document[]"
                                                   class="form-control inputFile_id"
                                                   accept=".pdf,.jpg,.jpeg,.png">

                                        </div>

                                        <div class="col-md-2">

                                            <button type="button" class="btn btn-danger removeField">-</button>
                                            <button type="button" class="btn btn-primary addmore">+</button>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </td>
                    </tr>
                    </tbody>
                    </table>
                </div>
            </div>

            <div class="form-section">

                <div class="form-section-header">
                    4. Declaration
                </div>

                <div class="form-section-body">

                    <div class="form-check mb-3">
                        <input type="checkbox"
                           id="declaration"
                           name="declaration"
                           class="form-check-input"
                           >

                        <label for="declaration" class="form-check-label">
                        I hereby declare that the information provided is true and correct and I request withdrawal of the registration of the clinic.
                        </label>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <label>Authorized Signatory<span class="required">*</span></label>
                            <input type="text" name="authorized_signatory" 
                            value="{{ old(
                                'authorized_signatory',
                                $draftData->authorized_signatory ?? $clinic->authorized_signatory ?? ''
                            ) }}" class="form-control">
                            @error('authorized_signatory')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label>Designation<span class="required">*</span></label>
                            <input type="text" name="designation" 
                            value="{{ old(
                                'designation',
                                $draftData->designation ?? $clinic->designation ?? ''
                            ) }}"
                            class="form-control">
                            @error('designation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label>Contact Number<span class="required">*</span></label>
                            <input type="text" name="contact_no"  id="contact_no"
                            maxlength="10"
                            value="{{ old(
                                'contact_no',
                                $draftData->contact_no ?? $clinic->contact_no ?? ''
                            ) }}"
                            class="form-control">
                            @error('contact_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label>Date</label>
                            <input type="date" name="declaration_date" 
                            value="{{ $todayDate }}"
                            class="form-control" readonly>
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

               <button type="submit"
                        id="draftButton"
                        value="draft"
                        class="btn btn-secondary">
                    Save as Draft
                </button>
            </div>

        </form>

    </div>
</div>

<script nonce="{{ $cspNonce }}">
    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('withdrawalForm');
        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB
        const MAX_ROWS = 4;

        // Allowed: A-Z, a-z, 0-9, whitespace, comma (,), period (.), underscore (_), square brackets ([ ]), parentheses (( )), apostrophe (').
        const descRegex = /^[A-Za-z0-9\s,._\[\]\(\)']+$/;        
        const allowedFiles = ['pdf', 'jpg', 'jpeg', 'png'];

        // Hide first remove button
        $('.upload-row:first .removeField').hide();

        // Common Functions
        function required(name, label) {
            const els = document.getElementsByName(name);

            if (!els || els.length === 0) {
                // no field present in form — treat as valid
                return true;
            }

            if (els.length > 1) {
                // likely a radio/checkbox group
                for (const e of els) {
                    if ((e.type === 'radio' || e.type === 'checkbox') && e.checked) {
                        return true;
                    }
                }
                alert(label + ' cannot be blank');
                els[0].focus();
                return false;
            }

            const el = els[0];

            if (el.type === 'checkbox') {
                if (!el.checked) {
                    alert(label + ' cannot be blank');
                    el.focus();
                    return false;
                }
                return true;
            }

            if (!el.value || !String(el.value).trim()) {
                alert(label + ' cannot be blank');
                el.focus();
                return false;
            }

            return true;
        }

        function validateAplicationDateWithdrawalDate() {
            const applicationDate = $('#application_date').val();
            const withdrawalDate = $('#withdrawal_date').val();

            if (withdrawalDate < applicationDate) {
                alert('Withdrawal date cannot be later than the application date.');
                $('#withdrawal_date').focus();
                return false;
            }

            return true;
        }

        function validateDescription() {

            const el = document.querySelector('[name="withdrawal_description"]');
            const val = el?.value.trim() || '';

            if (!val) {
                alert('Description cannot be blank');
                el.focus();
                return false;
            }

            if (!descRegex.test(val)) {
                alert('Invalid characters in description');
                el.focus();
                return false;
            }

            const wordCount = val.split(/\s+/).filter(Boolean).length;
            if (wordCount > 100) {
                alert('Description cannot exceed 100 words.');
                el.focus();
                return false;
            }

            return true;
        }

        function validateMobileNumber() {
            let mobile = document.getElementById('contact_no').value.trim();

            // Only 10 digits allowed
            let mobileRegex = /^[6-9]\d{9}$/;

            if (mobile === '') {
                alert('Contact Number is required.');
                document.getElementById('contact_no').focus();
                return false;
            }

            if (!mobileRegex.test(mobile)) {
                alert('Please enter a valid 10-digit mobile number.');
                document.getElementById('contact_no').focus();
                return false;
            }

            return true;
        }

        function validateDeclaration() {

            const el = document.querySelector('[name="declaration"]');

            if (!el || !el.checked) {
                alert('Please accept declaration');
                el?.focus();
                return false;
            }

            return true;
        }

        function validateFile(file, label) {

            if (!file) {
                alert('Please upload ' + label);
                return false;
            }

            const allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
            const ext = file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(ext)) {
                alert(label + ' must be PDF, JPG, JPEG or PNG.');
                return false;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert(label + ' size must not exceed 2 MB.');
                return false;
            }

            return true;
        }

      function validateUploadRows() {

    let valid = true;

    $('.upload-row').each(function () {

        const desc = $(this).find('textarea').val().trim();
        const file = $(this).find('input[type=file]')[0]?.files[0];
        const hasExistingFile = $(this).find('a.btn-primary').length > 0;

        // Description entered but no file and no existing document
        if (desc && !file && !hasExistingFile) {
            alert('Please upload file for entered description.');
            valid = false;
            return false;
        }

        // New file selected but no description
        if (file && !desc) {
            alert('Please enter file description.');
            valid = false;
            return false;
        }

        if (file && !validateFile(file, 'Upload File')) {
            valid = false;
            return false;
        }
    });

    return valid;
}

        const hasWithdrawalDoc = {{ !empty($withDoc) ? 'true' : 'false' }};
        const hasRecordDoc = {{ !empty($recordDoc) ? 'true' : 'false' }};

        function validateFiles() {

            const withdrawal = document.querySelector('[name="withdrawal_letter"]');
            const records = document.querySelector('[name="records_transfer_document"]');

            // Only check if document does not already exist
            if (!hasWithdrawalDoc && !withdrawal.files.length) {
                alert('Please upload Withdrawal Request Letter');
                withdrawal.focus();
                return false;
            }

            if (!hasRecordDoc && !records.files.length) {
                alert('Please upload Records / Sample Undertaking');
                records.focus();
                return false;
            }

            // Validate newly selected files only
            if (withdrawal.files.length &&
                !validateFile(withdrawal.files[0], 'Withdrawal Request Letter')) {
                withdrawal.focus();
                return false;
            }

            if (records.files.length &&
                !validateFile(records.files[0], 'Records / Sample Undertaking')) {
                records.focus();
                return false;
            }

            return true;
        }

        function validateForm() {

            if (!required('application_date', 'Application Date')) return false;
            if (!required('withdrawal_date', 'Withdrawal Date')) return false;
            if (!required('withdrawal_reason', 'Withdrawal Reason')) return false;
            if (!validateAplicationDateWithdrawalDate()) return false;
            if (!validateDescription()) return false;
            if (!validateFiles()) return false;
            if (!validateDeclaration()) return false;
            if (!required('authorized_signatory', 'Authorized Signatory')) return false;
            if (!required('designation', 'Designation')) return false;

            if (!required('contact_no', 'Contact Number')) return false;
            if (!validateMobileNumber()) return false;

            if (!required('declaration_date', 'Declaration Date')) return false;

            if (!validateUploadRows()) return false;

            return true;
        }

        // Dynamic Upload Row
       $(document).on('click', '.addmore', function () {

        if ($('.upload-row').length >= MAX_ROWS) {
            alert(`Maximum ${MAX_ROWS} upload sections allowed.`);
            return;
        }

        const clone = $('.upload-row:first').clone();

        clone.find('textarea').val('');
        clone.find('input[type=file]').val('');

        // IMPORTANT
        clone.find('input[name="document_id[]"]').val('');

        // Remove preview button for new row
        clone.find('a').remove();

        clone.find('.removeField').show();

        $('#uploadContainer').append(clone);

        $('.addmore').hide();
        $('.upload-row:last .addmore').show();
    });

       $(document).on('click', '.removeField', function () {

        $(this).closest('.upload-row').remove();

        $('.upload-row:first .removeField').hide();
        $('.addmore').hide();
        $('.upload-row:last .addmore').show();
    });

        // Dynamic Upload Validation
        $(document).on('change', '.inputFile_id', function () {

            const file = this.files[0];
            if (!file) return;

            const row = $(this).closest('.upload-row');

            if (!row.length) return;

            const desc = row.find('textarea');

            if (!desc.val().trim()) {

                alert('Please enter file description first.');

                this.value = '';
                desc.focus();

                return false;
            }

            if (!validateFile(file, 'Additional Document')) {
                this.value = '';
            }
        });

        // Normal File Inputs Validation
        $(document).on('change', '.fileValidate', function () {

            const file = this.files[0];

            if (!file) return;

            if (!validateFile(file, 'Document')) {
                this.value = '';
            }
        });

        // Form Submit
        document.getElementById('submitButton').addEventListener('click', function () {
            document.getElementById('submit_type').value = 'submit';
        });

        document.getElementById('draftButton').addEventListener('click', function () {
            document.getElementById('submit_type').value = 'draft';
        });

        form.addEventListener('submit', function (e) {

            // Always prevent default and control submission explicitly
            e.preventDefault();

            const submitter = e.submitter;
            let type = submitter ? submitter.value : '';

            if (type === 'draft') {
                document.getElementById('submit_type').value = 'draft';
                form.submit();
                return;
            }

            if (type === 'submit') {
                if (validateForm()) {
                    document.getElementById('submit_type').value = 'submit';
                    form.submit();
                }
                return;
            }

            // Run validation; if valid, set submit_type and submit programmatically
            if (validateForm()) {
                document.getElementById('submit_type').value = 'submit';
                form.submit();
            } else {
                // validation failed; focus is handled inside validators
                return false;
            }
        });
    });

    $('#contact_no').on('blur', function () {

        let input = $(this);
        let value = input.val().trim();

        if (value === '') {
            return;
        }

        if (!/^[6-9]\d{9}$/.test(value)) {
            alert('Please enter a valid 10-digit mobile number.');

            input.val('');

            setTimeout(function () {
                input.focus();
            }, 100);
        }
    });
</script>


@endsection