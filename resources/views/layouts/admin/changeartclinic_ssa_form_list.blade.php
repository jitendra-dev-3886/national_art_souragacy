@extends('layouts.admin.ssa_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-div-none {
            display: none;
        }

        .csp-admin-submit-button {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        .csp-admin-required-tick {
            color: #ff0000;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (session('upd_success'))
                    <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-success alert-dismissible alert-alt fade show csp-admin-message-div">
                            <strong> {{ session('upd_success') }}</strong>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card">
                    {{-- <div class="card-header">
                    <h4 class="card-title">ART form Application List</h4>
                </div> --}}


                    <div class="card-body">
                        <div class="basic-form">
                            <form class="form-horizontal" name="myForm"
                                action="{{ route('admin.changename_artclinic_submit') }}" id="application-form"
                                method="POST" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="id" value="{{ $receivedssaartformList->id ?? '' }}">
                                <input type="hidden" name="clinic_id"
                                    value="{{ $receivedssaartformList->clinic_id ?? '' }}">
                                @php
                                    $titles = [
                                        'ARTCLINIC' => 'ART Clinic Details',
                                        'ARTBANK' => 'ART Bank Details',
                                        'ARTSURROGACY' => 'ART Surrogacy Details',
                                    ];
                                @endphp

                                <h6 class="card-title text-primary">
                                    {{ $titles[$receivedssaartformList->clinic_type] ?? 'Details' }}
                                </h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Application
                                                    Number</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i
                                                        class="fas fa-money-bill-wave payment-icons"></i> </span>
                                                <input type="text" name="application_no" id="application_no"
                                                    value="{{ $receivedssaartformList->application_no ?? '' }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                            Please Enter a Transaction ID.
                                                        </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3" id="state">
                                            <label class="text-label form-label" id="lableName"
                                                for="validationCustomUsername"><strong> Current Clinic Name
                                                </strong></label>
                                            <div class="input-group">

                                                <input type="text" name="name" id="clinicname"
                                                    value="{{ $receivedssaartformList->name }}" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Nature</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i
                                                        class="fas fa-money-bill-wave payment-icons"></i> </span>
                                                <input type="text" name="nature" id="nature"
                                                    value="{{ $receivedssaartformList->nature }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a Transaction ID.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    @if ($receivedssaartformList->clinic_type == 'ARTCLINIC')
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="text-label form-label">
                                                    <strong>Clinic Level</strong>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-money-bill-wave payment-icons"></i>
                                                    </span>

                                                    <input type="text" name="level" id="cliniclevel"
                                                        value="{{ $receivedssaartformList->level }}" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong>Address</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                        <input type="text" name="address" id="address"
                                            value="{{ $receivedssaartformList->address }}" class="form-control" readonly>
                                        <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Pincode</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-marker"></i> </span>
                                                <input type="text" name="address" id="address"
                                                    value="{{ $receivedssaartformList->pincode }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>State</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-map"></i> </span>
                                                <input type="text" name="address" id="address"
                                                    value="{{ $receivedssaartformList->state }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>District</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-map"></i> </span>
                                                <input type="text" name="address" id="address"
                                                    value="{{ $receivedssaartformList->district }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a District.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <h6 class="card-title text-primary">Contact person details</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Name
                                                    of the Contact Person</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="name" id="address"
                                                    value="{{ $receivedssaartformList->name }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Email ID</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                <input type="text" name="address" id="address"
                                                    value="{{ $receivedssaartformList->email }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Mobile Number</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                                <input type="text" name="contact_number_clinic" id="address"
                                                    value="{{ $receivedssaartformList->contact_number_clinic }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <h4 class="card-title text-primary">Enter receipt/fee details</h4>
                                <hr class="text-success">
                                <div class="row">
                                    {{-- <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="incomplete_withdrawal_cancelled"
                                                id="incomplete_withdrawal_cancelled" placeholder="Enter receipt number"
                                                class="form-check-input me-2">
                                            <label class="mt-2">Incomplete / Withdrawal / Cancelled</label>
                                        </div>
                                    </div> --}}


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Proposed New Name Of the
                                                    Clinic(Current)</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="proposed_clinic_name" id="address"
                                                    value="{{ $receivedssaartformList->proposed_clinic_name }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Effective Date of Name
                                                    change</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                <input type="text" name="name_change_effective_date" id="address"
                                               
                                                    value=" {{$receivedssaartformList->name_change_effective_date ? \Carbon\Carbon::parse($receivedssaartformList->name_change_effective_date)->format('d-m-Y') : '' }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Reason for Change of
                                                    Name</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="reason_for_name_change" id="address"
                                                    value="{{ $receivedssaartformList->reason_for_name_change }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="mb-3">

                                            <label class="form-label fw-bold">
                                                Uploaded Documents
                                            </label>

                                            @php
                                                $applicationno = str_replace(
                                                    '/',
                                                    '_',
                                                    $receivedssaartformList->application_no,
                                                );
                                            @endphp

                                            @if ($documents->count() > 0)
                                                <div class="row">

                                                    @foreach ($documents as $doc)
                                                        <div class="col-md-4">

                                                            <div
                                                                class="border rounded p-3 mb-3 bg-light text-center h-100">

                                                                <strong class="d-block mb-2">
                                                                    {{ $doc->document_type }}
                                                                </strong>

                                                                <a href="{{ asset('webprodfiles/clinic_application/' . $applicationno . '/' . $doc->file_path) }}"
                                                                    target="_blank" class="btn btn-sm btn-primary">

                                                                    <i class="fa fa-eye"></i> View File

                                                                </a>

                                                            </div>

                                                        </div>
                                                    @endforeach

                                                </div>
                                            @else
                                                <span class="text-danger">
                                                    No documents uploaded
                                                </span>
                                            @endif

                                        </div>

                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Name of Authorized
                                                    Signatory</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="authorized_signatory_name" id="address"
                                                    value="{{ $receivedssaartformList->authorized_signatory_name }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Designation</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                                <input type="text" name="designation" id="address"
                                                    value="{{ $receivedssaartformList->designation }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Contact Number</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                                <input type="text" name="contact_number" id="address"
                                                    value="{{ $receivedssaartformList->contact_number }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Date</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                <input type="text" name="declaration_date" id="address"
                                                   value="{{$receivedssaartformList->declaration_date ? \Carbon\Carbon::parse($receivedssaartformList->declaration_date)->format('d-m-Y') : '' }}"
                                                    class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a username.
                                                </div> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <hr class="text-success">

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Date on which application recieved by
                                                    State
                                                    Appropriate Authority </strong><span
                                                    class="csp-admin-required-tick incomplete_application_not_required">*</span></label>



                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                <input name="app_date_recieve" id="app_date_recieve" value=""
                                                    class="form-control" type="date" max="{{ date('Y-m-d') }}">
                                            </div>


                                        </div>
                                    </div>

                                </div>


                        </div>

                        <div class="mb-3">
                            <label class="control-label"><strong>Decision</strong><span
                                    class="csp-admin-required-tick">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-chevron-down"></i> </span>
                                <select name="approved_rejected" id="approved_rejected" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Request Accepted">Request Accepted</option>
                                    <option value="Request Rejected">Request Rejected</option>
                                </select>
                            </div>
                            @error('approved_rejected')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3" id="rejection_reason_div">
                            <label class="control-label"><strong>Reason for Rejection</strong><span
                                    class="csp-admin-required-tick">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-chevron-down"></i></span>
                                <textarea name="reason_for_rejection" id="reason_for_rejection" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3" id="date_id">
                            <div class="mb-3">
                                <label class="control-label"><strong>Date of Registration</strong><span
                                        class="csp-admin-required-tick">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                    <input name="date_reg" placeholder="" class="form-control" type="date"
                                        max="{{ date('Y-m-d') }}" value="{{ $clinic_data->rgistration_date ?? '' }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="control-label"><strong>Certificate Validity Upto</strong></label>
                                <div class="input-group">
                                    <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                    <input name="validity_upto" id="validity_upto3" placeholder="" class="form-control"
                                        type="date" value="{{ $clinic_data->certificate_valid_date ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3" id="centralg">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Registration
                                    Number</strong><span class="csp-admin-required-tick">*</span></label></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                                <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];
                                ?></span-->
                                <input type="text" name="registration_no"
                                    value="{{ $clinic_data->registration_no ?? '' }}" class="form-control" disabled>

                            </div>
                        </div>
                        <div class="mb-3" id="d_rejection" class="csp-admin-div-none">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Date of
                                    Rejection Order</strong><span class="csp-admin-required-tick">*</span></label></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];
                                ?></span-->
                                <input name="date_rej" id="date_rej" placeholder="" class="form-control"
                                    type="date" max="{{ date('Y-m-d') }}">

                            </div>
                        </div>
                        <div class="mb-3" id="order_no" class="csp-admin-div-none">
                            <label class="text-label form-label" for="validationCustomUsername"><strong>Rejection Order
                                    Number</strong><span class="csp-admin-required-tick">*</span></label></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                                <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];
                                ?></span-->
                                <input type="text" name="rejection_no" id="rejection_no" class="form-control">

                            </div>
                        </div>
                        @php
                            // Map clinic types to document names and labels
                            $fileFieldMap = [
                                'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                                'artclinic' => 'reg_artclinic_certificate',
                                'artbank' => 'reg_artbank_certificate',
                            ];

                            $fileField = $fileFieldMap[strtolower($application->clinic_type)];
                        @endphp
                        <div class="mb-3" id="state">
                            <label class="text-label form-label" id="lableNameR" for="formFile"><strong>Registration
                                    Certificate (After Changed Name)</strong><span class="csp-admin-required-tick">*</span></label></label>
                            <div class="input-group">
                                <input class="form-control" type="file" id="formFile"
                                    name="{{ $fileField }}">
                            </div>
                        </div>
                        @error('reg_artclinic_certificate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <ul><strong>Note:- </strong>
                            <li>Date of Receipt of Application can't earlier than the date of payment of fees.</li>
                            <li>File Type: PDF or JPG Format only.</li>
                            <li>File Size: 50 to 200 kb.</li>
                        </ul>

                        <br>

                        <button type="submit" name="submit"
                            class="btn me-2 btn-primary csp-admin-submit-button">Submit</button>
                        <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js') }}"></script>
    <script nonce="{{ $cspNonce }}">
        // Add an event listener for the date input
        document.getElementById('date_reg').addEventListener('input', function() {
            const dateReg = this.value; // Get the selected date
            if (dateReg) {
                const date = new Date(dateReg); // Create a Date object
                date.setFullYear(date.getFullYear() + 5); // Add 5 years
                date.setDate(date.getDate() - 1); // Subtract 1 day for validity end date
                const validityDate = date.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                document.getElementById('validity_upto').value = validityDate; // Set the calculated date
            } else {
                document.getElementById('validity_upto').value = ''; // Clear the validity field if date is removed
            }
        });
    </script>
    <script nonce="{{ $cspNonce }}">
        // Set the max attribute for date fields to today's date
        document.addEventListener("DOMContentLoaded", function() {
            const today = new Date().toISOString().split('T')[0];

            document.getElementById('date_reg').setAttribute('max', today);
            document.getElementById('date_rej').setAttribute('max', today);
        });

        document.addEventListener("DOMContentLoaded", () => {
            const dateOfPaymentField = document.getElementById("app_date_payment");
            const dateOfReceiptField = document.getElementById("app_date_recieve");

            // Validate dates when the 'Date of Payment' is changed
            dateOfPaymentField.addEventListener("change", () => {
                validateDateFields("payment");
            });

            // Validate dates when the 'Date of Receipt' is changed
            dateOfReceiptField.addEventListener("change", () => {
                validateDateFields("receipt");
            });
        });

        function validateDateFields(triggeredBy) {
            const dateOfPaymentField = document.getElementById("app_date_payment");
            const dateOfReceiptField = document.getElementById("app_date_recieve");

            const dateOfPayment = dateOfPaymentField.value;
            const dateOfReceipt = dateOfReceiptField.value;

            if (dateOfPayment && dateOfReceipt) {
                const paymentDate = new Date(dateOfPayment);
                const receiptDate = new Date(dateOfReceipt);

                // Check if the 'Date of Receipt' is earlier than the 'Date of Payment'
                if (receiptDate < paymentDate) {
                    alert("Date of Receipt cannot be earlier than the Date of Payment.");
                    if (triggeredBy === "receipt") {
                        dateOfReceiptField.value = "";
                        dateOfReceiptField.focus();
                    } else if (triggeredBy === "payment") {
                        dateOfPaymentField.value = "";
                        dateOfPaymentField.focus();
                    }
                }
            }
        }

        function validateDates() {
            const dateOfPaymentField = document.getElementById("app_date_payment");
            const dateOfReceiptField = document.getElementById("app_date_recieve");

            const dateOfPayment = dateOfPaymentField.value;
            const dateOfReceipt = dateOfReceiptField.value;

            if (dateOfPayment && dateOfReceipt) {
                const paymentDate = new Date(dateOfPayment);
                const receiptDate = new Date(dateOfReceipt);

                // Final validation on form submission
                if (receiptDate < paymentDate) {
                    alert("Date of Receipt cannot be earlier than the Date of Payment.");
                    dateOfReceiptField.value = "";
                    dateOfReceiptField.focus();
                    return false;
                }
            }

            return true; // Allow form submission if all validations pass
        }

        // ✅ jQuery event bindings (no inline js needed)
        $(document).ready(function() {
            $('#app_date_payment, #app_date_recieve').on('change', function() {
                validateDates();
            });
        });
    </script>
    <script nonce="{{ $cspNonce }}">
        document.getElementById('date_reg').addEventListener('change', function() {
            var dateReceived = document.getElementById('app_date_recieve').value;
            var dateRegistered = document.getElementById('date_reg').value;

            if (dateReceived && dateRegistered) {
                var date1 = new Date(dateReceived);
                var date2 = new Date(dateRegistered);
                var timeDifference = Math.abs(date2 - date1);
                var dayDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)); // Convert to days

                // Show delay reason div if difference is greater than 36 days
                if (dayDifference > 96) {
                    document.getElementById('delay_reason_div').style.display = 'block';
                    document.getElementById('delay_reason').setAttribute('required', 'required');
                } else {
                    document.getElementById('delay_reason_div').style.display = 'none';
                    document.getElementById('delay_reason').removeAttribute('required');
                }
            }
        });
    </script>


    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#approved_rejected').on('change', function() {
                // alert('check 1');
                $("#date_reg").val('');
                $("#validity_upto").val('');
                $("#registration_no").val('');
                $("#rejection_no").val('');
                $("#date_rej").val('');
                $("#formFile").val('');
                 $('#rejection_reason_div').hide();

                if (this.value == 'Request Accepted') {
                    $("#centralg").show();
                    $("#order_no").hide();
                    $("#date_id").show();
                    $("#d_rejection").hide();
                    $('#lableNameR').html(
                        "<strong>Upload Registration Certificate (After Changed Name)<span class='csp-admin-required-tick'>*</span></strong>"
                    );
                    $('#rejection_reason_div').hide();
                } else if (this.value == 'Request Rejected') {
                    //$("lableName").html.replace("text value");
                    $('#rejection_reason_div').show();
                    $('#lableNameR').html(
                        "<strong>Upload Rejection Order (After Changed Name)<span class='csp-admin-required-tick'>*</span></strong>"
                    );
                    $("#order_no").show();
                    $("#d_rejection").show();
                    $("#centralg").hide();
                    $("#date_id").hide();
                    $('#rejection_reason_div').show();

                } else {
                   
                    $("#order_no").hide();
                    $("#centralg").hide();
                    $("#date_id").hide();
                    $("#d_rejection").hide();
                    $('#lableNameR').RemoveAttr("Rejection Order");
                }

            });
        });
    </script>


    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#application-form').on('submit', function(e) {
                if (!validatesubmit()) {
                    e.preventDefault();
                }
            });
        });

        function validatesubmit() {

            let isValid = true;

            if (document.getElementById("approved_rejected").value == "") {
                alert("Decision cannot be blank");
                document.getElementById("approved_rejected").focus();
                return false;
            }

            if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById(
                        "formFile")
                    .value == "")) {
                alert("Upload Registration Certificate cannot be blank");
                document.getElementById("formFile").focus();
                return false;
            }
            const dateRej = new Date(document.getElementById('date_rej').value);

            if ((document.getElementById("approved_rejected").value == "Registration Rejected") && (document.getElementById(
                    "date_rej").value == "")) {
                alert("Date of Rejection cannot be blank");
                document.getElementById("date_rej").focus();
                return false;
            }
            if ((document.getElementById("approved_rejected").value == "Registration Rejected") && (document.getElementById(
                        "rejection_no")
                    .value == "")) {
                alert("Rejection Order No. cannot be blank");
                document.getElementById("rejection_no").focus();
                return false;
            }
 
            if ((document.getElementById("approved_rejected").value == "Registration Rejected") && (document.getElementById(
                        "formFile")
                    .value == "")) {
                alert("Upload Rejection Order cannot be blank");
                document.getElementById("formFile").focus();
                return false;
            }
            var agree = confirm(
                "Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted."
            );
            if (agree) {

                return true;
            } else {
                return false;
            }

            return isValid;
        }
    </script>


    <script nonce="{{ $cspNonce }}">
        var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".gif"];

        function validateForSize(input, minSize, maxSize) {
            if (input.type === "file") {
                var fileName = input.value;
                if (fileName.length > 0) {
                    var isValidExtension = _validFilejpeg.some(function(ext) {
                        return fileName.toLowerCase().endsWith(ext.toLowerCase());
                    });

                    if (!isValidExtension) {
                        alert("Sorry, this file is invalid. Allowed extensions are: " + _validFilejpeg.join(", "));
                        input.value = "";
                        return false;
                    }
                }
            }

            return fileSizeValidatejpeg(input, minSize, maxSize);
        }


        $(document).ready(function() {
            $('#formFile').on('change', function() {
                validateForSize(this, 50, 200);
            });
        });

        function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
            if (fdata.files && fdata.files[0]) {
                var fsize = fdata.files[0].size /
                    1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
                //alert(fsize)
                if (fsize > maxSizejpeg || fsize < minSize) {
                    alert('This file size is: ' + fsize.toFixed(2) +
                        "KB. Files should be in " + (minSize) + " to " + (maxSizejpeg) + " KB ");
                    fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
                    return false;
                } else {
                    console.log("");
                }
            }
        }
    </script>

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#physical_application_div').hide();
            $('#rejection_reason_div').hide();
            $('#incomplete_withdrawal_cancelled').on('change', function() {
                if ($(this).is(':checked')) {
                    $('.incomplete_application_not_required').hide();
                    $('#approved_rejected option').prop('disabled', true);
                    $('#approved_rejected option[value="Registration Rejected"]').prop('disabled', false);
                    $('#approved_rejected').val('Registration Rejected');

                    $('#physical_application_div').show();
                    $('#rejection_reason_div').show();

                    $('#lableNameR').html(
                        "<strong>Upload Rejection Order <span class='csp-admin-required-tick'>*</span></strong>"
                    );
                    $("#order_no").show();
                    $("#d_rejection").show();
                    $("#centralg").hide();
                    $("#date_id").hide();

                } else {
                    $('.incomplete_application_not_required').show();
                    $('#approved_rejected option').prop('disabled', false);
                    $('#approved_rejected').val('');

                    $('#physical_application_div').hide();
                    $('#rejection_reason_div').hide();


                    $("#centralg").show();
                    $("#order_no").hide();
                    $("#date_id").show();
                    $("#d_rejection").hide();
                    $('#lableNameR').html(
                        "<strong>Upload Registration Certificate <span class='csp-admin-required-tick'>*</span></strong>"
                    );
                }
            });
        });
    </script>
@endsection
