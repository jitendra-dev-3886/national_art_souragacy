@extends('layouts.clinic.clinic_master')
@section('content')
    <div class="container mt-4">
        <div class="card shadow">

            <div class="card-header bg-white text-white text-center">

                <h4 class="mb-2">Application Form for Change of </h4>

                <hr class="bg-white">

                <small class="mb-2" bg-black text-white text-center>
                    Note: Fields marked with * are mandatory.
                </small>

            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif


                {{-- @php
                    $readonly = $isSubmitted ? 'readonly' : '';
                    $disabled = $isSubmitted ? 'disabled' : '';
                @endphp --}}

                <form id="form-wizard" action="{{ route('clinic.change.name.submit') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="application_id" value="{{ $application->id ?? '' }}">
                    <input type="hidden" name="clinic_id" value="{{ $application->clinic_id ?? '' }}">
                    <input type="hidden" name="submit_type" id="submit_type">
                    <h4>1. Clinic Details (As Registered) </h4>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Registration Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="registration_no" class="form-control"
                                value="{{ $application->registration_no ?? '' }}" readonly>
                        </div>



                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Name of the Clinic <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" value="{{ $application->name ?? '' }}"
                                readonly>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Type of Clinic <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="clinic_type" class="form-control"
                                value="{{ $application->clinic_type ?? '' }}" readonly>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Nature of the Organization <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nature" class="form-control"
                                value="{{ $application->nature ?? '' }}" readonly>

                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                E-mail Address of the clinic <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="email" class="form-control"
                                value="{{ $application->email ?? '' }}" readonly>

                        </div>


                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="contact_number_clinic" class="form-control"
                                value="{{ $application->contact_number_clinic ?? '' }}" readonly>

                        </div>





                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">
                                Date of Registration <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="rgistration_date" class="form-control"
                                value="{{ $application->rgistration_date ?? '' }}" readonly>
                        </div>


                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">
                                Address <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="address" class="form-control"
                                value="{{ $application->address ?? '' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                Pincode <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="pincode" class="form-control"
                                value="{{ $application->pincode ?? '' }}" readonly>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                State <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="state" class="form-control"
                                value="{{ $application->state ?? '' }}" readonly>

                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">
                                District <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="district" class="form-control"
                                value="{{ $application->district ?? '' }}" readonly>
                        </div>

                    </div>

                    <h4>2. Proposed New Name Details</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold">
                                Proposed New Name Of the Clinic(Current) <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="proposed_name" class="form-control"
                                value="{{ old('proposed_name', $application->proposed_clinic_name ?? '') }}">
                            @error('proposed_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold">
                                Effective Date of Name change <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="effective_date" class="form-control"
                                value="{{ old('effective_date', $application->name_change_effective_date ?? '') }}">
                            @error('effective_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label fw-bold">
                                Reason for Change of Name<span class="text-danger">*</span>
                            </label>
                            <textarea name="reason" class="form-control" maxlength="500">{{ old('reason', $application->reason_for_name_change ?? '') }}</textarea>
                            @error('reason')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                    </div>

                    <h4>3. Supporting Documents(Upload Self-Attested Copies)</h4>
                    <table class="table table-bordered">

                        <thead class="table-light">
                            <tr>
                                <th style="width: 8%;">S.No</th>
                                <th style="width: 30%;">Document Name</th>
                                <th style="width: 40%;">Upload Document</th>
                                <th style="width: 22%;">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @for ($i = 0; $i < 3; $i++)
                                @php
                                    $fileName = $applicationDocuments[$i]->file_path ?? null;

                                    $fileUrl = $fileName
                                        ? folderpath(
                                            'application_sa/' . $application->registration_no . '/' . $fileName,
                                        )
                                        : null;
                                @endphp

                                <tr>


                                    <td class="text-center fw-bold">
                                        {{ $i + 1 }}
                                    </td>


                                    <td>
                                        <input type="text" name="document_name[]"
                                            class="form-control @error('document_name.' . $i) is-invalid @enderror"
                                            value="{{ old('document_name.' . $i) }}">

                                        @error('document_name.' . $i)
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>

                                    <td>
                                        <input type="file" name="documents[]"
                                            class="form-control @error('documents.' . $i) is-invalid @enderror"
                                            accept=".pdf,.jpg,.jpeg,.png">

                                        <small class="text-muted d-block mt-1">
                                            Allowed: PDF | Max: 250 KB
                                        </small>

                                        @error('documents.' . $i)
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>


                                    <td class="text-center">

                                        {{-- @php
                                            $fileName = $applicationDocuments[$i]->file_path ?? null;

                                            $fileUrl = $fileName
                                                ? asset('application_sa/' . $clinic->registration_no . '/' . $fileName)
                                                : null;
                                        @endphp

                                        @if (!empty($fileName))
                                            <a href="{{ $fileUrl }}" target="_blank"
                                                class="btn btn-sm btn-primary">

                                                View File
                                            </a>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif --}}

                                    </td>

                                </tr>
                            @endfor

                        </tbody>

                    </table>



                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Name of Authorized Signatory<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="authorized_signatory_name" class="form-control"
                                value="{{ old('authorized_signatory_name', $application->authorized_signatory_name ?? '') }}">
                            @error('authorized_signatory_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Designation<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="designation" class="form-control"
                                value="{{ old('designation', $application->designation ?? '') }}">
                            @error('designation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Contact Number <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="contact_number" class="form-control" min="0"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10)"
                                value="{{ old('contact_number', $application->contact_number ?? '') }}">
                            @error('contact_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="declaration_date" class="form-control"
                                value="{{ old('declaration_date', $application->declaration_date ?? '') }}">
                            @error('declaration_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <h4>4. Declaration</h4>

                    <div class="col-md-12">
                        <div class="mb-3" id="declaration_both">



                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="declaration" id="declaration">
                                    <label class="form-check-label" for="gridCheck">
                                        I/We hereby declare that the information provide above is true and correct to the
                                        best of
                                        my/our knowledge and belief.I/We undertake that all the attached documents are
                                        genuine and self
                                        attested.I/We also understand that if any information is found to be false,the
                                        application may be rejected and
                                        action may be taken as per law. *
                                </div>
                                @error('declaration')
                                    <br><small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>



                    <div class="text-center mt-3">

                        <button type="submit" id="draftButton" class="btn btn-success bc-bc-color-csp-clinic-three">
                            Save As Draft
                        </button>

                        <button type="submit" id="submitButton" class="btn btn-primary">
                            Submit Application
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}">
        document.querySelectorAll('.fileInput').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > 250 * 1024) {
                    alert('File must be less than 250 KB');
                    this.value = '';
                }
            });
        });
    </script>

    <script nonce="{{ $cspNonce }}">
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('form-wizard');
            const submitButton = document.getElementById('submitButton');
            const draftButton = document.getElementById('draftButton');


            function setError(id, message, element = null) {

                alert(message);

                const el = document.getElementById(id);
                if (el) {
                    el.innerText = message;
                    el.style.color = "red";
                    el.style.fontSize = "13px";
                }

                if (element) {
                    element.focus();
                }

                return false;
            }

            function clearError(id) {
                const el = document.getElementById(id);
                if (el) {
                    el.innerText = "";
                }
            }

            function hasInvalidCharacters(value) {
                const forbiddenPattern = /[<>$%#{}[\];'"`]/;
            return forbiddenPattern.test(value);
        }

        function validateFile(fileInput) {

            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                return false;
            }

            const file = fileInput.files[0];


            if (file.size > 250 * 1024) {
                fileInput.value = '';
                return false;
            }


            const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            const extension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(extension)) {
                fileInput.value = '';
                return false;
            }

            return true;
        }


        function validateDraft() {

            const textInputs = document.querySelectorAll("input[type='text'], textarea");

            for (let input of textInputs) {
                if (input.value.trim() !== '' && hasInvalidCharacters(input.value)) {
                    return setError("errorreason", "Invalid characters detected", input);
                }
            }

            const fileInputs = document.querySelectorAll('.fileInput');

            for (let fileInput of fileInputs) {
                if (fileInput.files.length > 0 && !validateFile(fileInput)) {
                    return setError("errorfile", "Invalid file selected", fileInput);
                }
            }

            return true;
        }


        function validateSubmit() {

            clearError("errorreason");
            clearError("errorfile");
            clearError("errorcontact");
            clearError("errordeclaration");

            const requiredFields = [
                'proposed_name',
                'effective_date',
                'reason',
                'authorized_signatory_name',
                'designation',
                'contact_number',
                'declaration_date'
            ];

            for (let name of requiredFields) {

                const field = document.querySelector(`[name="${name}"]`);

                if (!field || !field.value.trim()) {
                    return setError("errorreason", `${name.replaceAll('_', ' ')} is required`, field);
                    }
                }


                const contact = document.querySelector('[name="contact_number"]');

                if (!/^[0-9]{10}$/.test(contact.value)) {
                    return setError("errorcontact", "Enter valid 10 digit mobile number", contact);
                }


                const declaration = document.getElementById('declaration');

                if (!declaration.checked) {
                    return setError("errordeclaration", "Please accept declaration", declaration);
                }


                const textInputs = document.querySelectorAll("input[type='text'], textarea");

                for (let input of textInputs) {
                    if (input.value.trim() !== '' && hasInvalidCharacters(input.value)) {
                        return setError("errorreason", "Invalid characters detected", input);
                    }
                }

                const reason = document.querySelector('[name="reason"]');

                if (!reason.value.trim()) {
                    return setError(
                        "errorreason",
                        "Please enter reason for change of name",
                        reason
                    );
                }


                const fileInputs = document.querySelectorAll('.fileInput');

                for (let fileInput of fileInputs) {

                    if (fileInput.files.length === 0) {
                        return setError(
                            "errorfile",
                            "Please upload file after Reason for Change of Name",
                            fileInput
                        );
                    }

                    if (!validateFile(fileInput)) {
                        return setError(
                            "errorfile",
                            "Invalid file type or size (max 250KB, pdf/jpg/jpeg/png only)",
                            fileInput
                        );
                    }
                }


                const documentNames = document.querySelectorAll('[name="document_name[]"]');

                for (let i = 0; i < documentNames.length; i++) {

                    if (documentNames[i].value.trim() === '') {
                        return setError(
                            "errorreason",
                            "Please enter document name in all rows",
                            documentNames[i]
                        );
                    }
                }

                return confirm('Kindly check and confirm all details before final submission.');
            }


            if (submitButton) {
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateSubmit()) {
                        form.submit();
                    }
                });
            }

            if (draftButton) {
                draftButton.addEventListener('click', function(e) {
                    e.preventDefault();

                    if (validateDraft()) {
                        form.submit();
                    }
                });
            }

        });


      

$('#draftButton').on('click', function () {
$('#submit_type').val('draft');
});

$('#submitButton').on('click', function () {
$('#submit_type').val('submit');
});
    </script>
@endsection
