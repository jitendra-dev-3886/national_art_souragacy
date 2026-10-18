@extends('layouts.admin.ssa_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
        }
        .csp-admin-opecity-div{
            opacity:0.8;
        }
        .G293{
            min-width: 845px;
        }
        .csp-admin-ancor-margin{
            margin-right: 5px;
        }
        .csp-admin-submit-button{
            width: 108px; height: 43px; margin-left: -10px; background-color:0b47a0;border-color: 0b47a0;
        }
        .csp-admin-table-100{
            min-width:100px
        }
        .csp-admin-anchor{
            background-color: #210f77; border-block-color: #210f77;border-color: #210f77;
        }
        .csp-admin-table-cloumn{
            text-transform: lowercase;
        }
        hr {
            height: 4px; /* Thickness of the line */
            background-color: #68e365; /* Color of the line */
            border: none; /* Removes default border */
            margin: 20px 0; /* Space above and below the line */
        }
        .csp-admin-label-color{
            color:#ff0000;
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
                <div class="card">
                 @php
                      $encryptedClinic = Crypt::encryptString($application->clinic_type);
                 @endphp
                    <div class="card-body">
                        <div class="basic-form">
                       <form id="application-form" action="{{ route('change_address.receive_clinic_submit', ['encryptedClinicType' => $encryptedClinic]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                                <input type="hidden" name="id" value="{{ $application->id ?? '' }}">
                                <h6 class="card-title text-primary"> Clinic Details</h6>
                                <hr>
                                <div class="row">
                                <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="text-label form-label" for="validationCustomUsername"><strong>Application Number</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fas fa-money-bill-wave payment-icons"></i> </span>
                                                <input type="text" name="application_no" id="application_no"
                                                    value="{{ $application->applicationno }}" class="form-control"
                                                    readonly>
                                                <!-- <div class="invalid-feedback">
                                                    Please Enter a Transaction ID.
                                                </div> -->
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-4">
                                <div class="mb-3" id="state" >
                                    <label class="text-label form-label" id="lableName"
                                        for="validationCustomUsername"><strong>Clinic Name</strong></label>
                                    <div class="input-group">

                                    <input type="text" name="clinicname" id="clinicname"
                                            value="{{ $application->clinicname}}" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Nature</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fas fa-money-bill-wave payment-icons"></i> </span>
                                        <input type="text" name="nature" id="nature"
                                            value="{{ $application->nature }}" class="form-control"
                                            readonly>
                                        <!-- <div class="invalid-feedback">
                                            Please Enter a Transaction ID.
                                        </div> -->
                                    </div>
                                </div>
                                </div>
                                {{-- <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Clinic Level</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="cliniclevel" id="cliniclevel"
                                                value="{{ $receivedssaartformList->artclinics->cliniclevel }}" class="form-control"
                                                readonly>
                                            <!-- <div class="invalid-feedback">
                                                Please Enter a Transaction ID.
                                            </div> -->
                                        </div>
                                    </div>
                                </div> --}}
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Old Address
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-address-card"></i>
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ implode(', ', array_filter([
                                                        $application->clinic->address ?? null,
                                                        $application->clinic->district ?? null,
                                                        $application->clinic->state ?? null,
                                                        $application->clinic->pincode ?? null,
                                                    ])) }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">New Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-address-card"></i>
                                                </span>
                                                <input type="text"
                                                       id="address"
                                                       name="address"
                                                       class="form-control"
                                                       value="{{ $application->address }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- District --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">District</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-marker"></i>
                                                </span>
                                                <input type="text"
                                                       id="district"
                                                       name="district"
                                                       class="form-control"
                                                       value="{{ $application->district }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- State --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">State</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map"></i>
                                                </span>
                                                <input type="text"
                                                       id="state"
                                                       name="state"
                                                       class="form-control"
                                                       value="{{ $application->state }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                
                                    {{-- Pincode --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pincode</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa fa-map-pin"></i>
                                                </span>
                                                <input type="text"
                                                       id="pincode"
                                                       name="pincode"
                                                       class="form-control"
                                                       value="{{ $application->pincode }}"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="card-title text-primary">Contact person details</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">                                      
                                    <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Name of the Contact Person</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                        <input type="text" name="address" id="address"
                                            value="{{ $application->contact_person_name }}" class="form-control"
                                            readonly>
                                        <!-- <div class="invalid-feedback">
                                            Please Enter a username.
                                        </div> -->
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Email ID</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                        <input type="text" name="address" id="address"
                                            value="{{ $application->contact_person_email }}" class="form-control"
                                            readonly>
                                        <!-- <div class="invalid-feedback">
                                            Please Enter a username.
                                        </div> -->
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Mobile Number</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                        <input type="text" name="address" id="address"
                                            value="{{ $application->contact_person_mobile }}" class="form-control"
                                            readonly>
                                        <!-- <div class="invalid-feedback">
                                            Please Enter a username.
                                        </div> -->
                                    </div>
                                </div>

                                </div>
                                </div>
                                
                                 <h4 class="card-title text-primary">Enter receipt/fee details</h4>

                                <hr class=" text-success " > 
                                @if ( $application->nature == 'Private') 
                                <?php //if( $row2['nature'] == "Private") {?>
                                <div class="row">
                                <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Fee amount</strong><span class="csp-admin-label-color">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fas fa-money-bill-wave payment-icons"></i> </span> 
                                        <input type="text" name="fee_amount" id="fee_amount" placeholder="Enter fee amount"
                                            class="form-control" value="{{ $feeAmount }}" readonly>
                                        <div class="invalid-feedback">
                                            Please Enter a Fee Amount.
                                        </div>
                                    </div>
                                </div>
                                </div>
                                {{-- @endif   --}}
                                <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Mode of Payment</strong><span
                                    class="csp-admin-label-color">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fas fa-money-bill-wave payment-icons"></i> </span>
                                        <select name="mode_payment" id="mode_payment"
                                            class="form-control">
                                            <option value="">Select</option>
                                            <option value="Cash" {{ old('mode_payment', $application->mode_payment) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Cheque" {{ old('mode_payment', $application->mode_payment) == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                            <option value="Demand Draft" {{ old('mode_payment', $application->mode_payment) == 'Demand Draft' ? 'selected' : '' }}>Demand Draft</option>
                                            <option value="Online" {{ old('mode_payment', $application->mode_payment) == 'Online' ? 'selected' : '' }}>Online</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please Enter a Mode of Payment.
                                        </div>
                                    </div>
                                    @error('mode_payment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Transaction ID/DD No./Ref.no/Receipt No.</strong><span
                                        class="csp-admin-label-color">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fas fa-receipt"></i> </span>
                                            <input type="text" name="transaction_id" id="transaction_id" placeholder="Transaction ID/DD No./Ref.no/Receipt No."
                                                class="form-control" value="{{ $application->transaction_id ?? '' }}" {{ !empty($application->transaction_id) ? 'readonly' : '' }}>
                                            <div class="invalid-feedback">
                                                Please Enter a Transaction ID.
                                            </div>
                                        </div>
                                        @error('transaction_id')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                <div class="mb-3" id="state" >
                                    <label class="text-label form-label" id="lableName"
                                        for="validationCustomUsername"><strong>Date of Payment of Fees
                                        </strong><span
                                        class="csp-admin-label-color">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                        <input name="app_date_payment" id="app_date_payment" value="{{ !empty($application->app_date_payment) ? \Carbon\Carbon::parse($application->app_date_payment)->format('Y-m-d') : '' }}" placeholder="" class="form-control" type="date" {{ !empty($application->app_date_payment) ? 'readonly' : '' }}>
                                    </div>
                                     @error('app_date_payment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                </div>
                                </div>
                                @endif
                                <?php //}?>
                             
                                <div class="row">
                                <div class="col-md-3">    
                                <div class="mb-3">
                                    <label class="control-label"><strong>Date on which application recieved by State Appropriate Authority </strong><span
                                            class="csp-admin-label-color">*</span></label>	

                                    @if (isset($application->surrogacyclinics) && $application->surrogacyclinics->app_date_recieve != null)
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_recieve" id="app_date_recieve" value="{{ $application->surrogacyclinics->app_date_recieve }}" placeholder=""
                                                class="form-control" type="date" disabled>
                                                <input name="app_date_recieve" value="{{ $application->surrogacyclinics->app_date_recieve }}" type="hidden">
                                        </div>
                                    @else
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            {{-- <input name="app_date_recieve" id="app_date_recieve" value="" placeholder="" class="form-control app_date_amount" onchange="getAmountDate({{ Crypt::encriptString($application->id) }});" type="date"> --}}
                                            <input name="app_date_recieve"
                                                id="app_date_recieve"
                                                class="form-control app_date_amount"
                                                type="date"
                                                data-app-id="{{ Crypt::encryptString($application->id) }}"
                                                onchange="getAmountDate(this)">
                                        </div>
                                    @endif	

                                    @error('app_date_recieve')
                                            <span class="text-danger">{{ $message }}</span>
                                    @enderror  						
                                </div>
                                {{-- {{ $application->clinic_type }} --}}
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Old Registration Certificate
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-file"></i> </span>

                                            @if(!empty($clinic_data->certificate_path))
                                                <input type="text"
                                                       class="form-control"
                                                       value="Certificate Available"
                                                       readonly>

                                                <a href="{{ asset('webprodfiles/clinic_registration_certificate/' . str_replace('/', '_', $application->clinic_id) . '/' . $application->certificate_path) }}"
                                                   target="_blank"
                                                   class="btn btn-primary">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            @else
                                                <input type="text"
                                                       class="form-control"
                                                       value="Certificate Not Available"
                                                       readonly>

                                                <a href="javascript:void(0)"
                                                   class="btn btn-primary"
                                                   id="viewCertificateBtn">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                @if ($application->nature == 'Private')
                                    <div class="col-md-4">
                                        @php
                                            $inputNameMap = [
                                                'ARTSURROGACY' => 'receiving_surrogacyclinic_docs',
                                                'ARTCLINIC'    => 'receiving_artclinic_docs',
                                                'ARTBANK'      => 'receiving_artbank_docs',
                                            ];

                                            $docTypeMapping = [
                                                'ARTSURROGACY' => 'target_file_receiving_surrogacyclinic_docs',
                                                'ARTCLINIC'    => 'target_file_receiving_artclinic_docs',
                                                'ARTBANK'      => 'target_file_receiving_artbank_docs',
                                            ];

                                            $fileInputName = $inputNameMap[$application->clinic_type] ?? 'receiving_docs';
                                            $docType = $docTypeMapping[$application->clinic_type] ?? null;

                                            $uploadedDoc = $get_docfileData->firstWhere('doc_type', $docType);
                                        @endphp
                                        @if ($isRejectedBefore && $uploadedDoc)
                                            <!--  <label class="text-label form-label">
                                                <strong>View receipt of fee</strong>
                                            </label>
                                            <div class="input-group mt-4">
                                                <a href="{{ asset('webprodfiles/application_sa/' . $application_no_folder . '/' . basename($uploadedDoc->doc_upload_ref)) }}"
                                                   class="link"
                                                   target="_blank">
                                                    <i class="fa fa-download"></i> View Receipt of Fee
                                                </a>
                                            </div> -->
                                             <label class="text-label form-label">
                                                <strong>Upload receipt of fee</strong>
                                                <span class="csp-admin-label-color">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control"
                                                       type="file"
                                                       id="formFile"
                                                       name="{{ $fileInputName }}">
                                                <input type="hidden"
                                                       name="clinic_type"
                                                       value="{{ $application->clinic_type }}">
                                            </div>
                                            @error($fileInputName)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <label class="text-label form-label">
                                                <strong>Upload receipt of fee</strong>
                                                <span class="csp-admin-label-color">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control"
                                                       type="file"
                                                       id="formFile"
                                                       name="{{ $fileInputName }}">
                                                <input type="hidden"
                                                       name="clinic_type"
                                                       value="{{ $application->clinic_type }}">
                                            </div>
                                            @error($fileInputName)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        @endif
                                    </div>
                                @endif

                                <?php //}?>
                                </div>                                 
                                <?php //if( $row2['nature'] == "Private") {?>
                                <ul><strong>Note:- </strong>
                                <li>Date of Receipt of Application can't earlier than the date of payment of fees.</li>
                                    <li>File Type: PDF or JPG Format only.</li>
                                    <li>File Size: 50 to 200 kb.</li>
                                </ul>
                                <?php //}?>
                                <br>

                                {{-- <button type="submit" name="submit" class="btn me-2 btn-primary csp-admin-message-div" onclick="return validatesubmit()">Submit</button> --}}
                                <button type="submit" name="submit" class="btn me-2 btn-primary csp-admin-message-div">Submit</button>
                                <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script nonce="{{ $cspNonce }}">
        // Set the max attribute for date fields to today's date
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('app_date_payment').setAttribute('max', today);
            document.getElementById('app_date_recieve').setAttribute('max', today);
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

            if (receiptDate < paymentDate) {
                alert("Date of Receipt cannot be earlier than the Date of Payment.");
                dateOfReceiptField.value = "";
                dateOfReceiptField.focus();
                return false;
            }
        }

        return true;
    }

    // jQuery event bindings (no inline js needed)
    $(document).ready(function () {
        $('#app_date_payment, #app_date_recieve').on('change', function () {
            validateDates();
        });
    });
    
    
    </script>
     <script nonce="{{ $cspNonce }}" >
        
        $(document).ready(function () {
            $('#application-form').on('submit', function (e) {
                if (!validatesubmit()) {
                    e.preventDefault(); // Form submit को रोकें
                }
            });
        });

        function validatesubmit() {

            let isValid = true;

            const nature = $('#nature').val();
            const dateOfReceipt = $('#app_date_recieve').val();
            const appDatePayment = $('#app_date_payment').val();

            // Additional validations only if nature is "Private"
            if (nature === "Private") {
                if (!$('#fee_amount').val()) {
                    alert("Fee amount cannot be blank");
                    $('#fee_amount').focus();
                    return false;
                }

                if (!$('#mode_payment').val()) {
                    alert("Mode of payment cannot be blank");
                    $('#mode_payment').focus();
                    return false;
                } 

                if (!$('#transaction_id').val()) {
                    alert("Transaction ID cannot be blank");
                    $('#transaction_id').focus();
                    return false;
                }

                if (!appDatePayment) {
                    alert("Date of Payment of Fee cannot be blank");
                    $('#app_date_payment').focus();
                    return false;
                }

                 if (!dateOfReceipt) {
                    alert("Date of Receipt cannot be blank");
                    $('#app_date_recieve').focus();
                    return false;
                }

                if (!$('#formFile').val()) {
                    alert("Upload the receipt of Fee");
                    $('#formFile').focus();
                    return false;
                }

                // Check date logic
                if (new Date(dateOfReceipt) < new Date(appDatePayment)) {
                    alert("Date of Receipt can't be earlier than the Date of Payment.");
                    $('#app_date_recieve').focus();
                    return false;
                }
            }

            // Final confirmation
            const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
            if (agree) {
                // Submit the form manually
                this.submit();
            }

            // else do nothing (stay on page)
        }
        
        
        var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif"];
    
        function validateForSize(input, minSize, maxSize) {
            if (input.type === "file") {
                var fileName = input.value;
                if (fileName.length > 0) {
                    var isValidExtension = _validFilejpeg.some(function (ext) {
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

        // jQuery binding (No inline JS)
        $(document).ready(function () {
            $('#formFile').on('change', function () {
                validateForSize(this, 50, 2048); // min 50KB, max 200KB
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
                    // console.log("");
                }
            }
        }
        document.getElementById('viewCertificateBtn').addEventListener('click', function (e) {
            e.preventDefault();
            alert('Certificate is not available. Please contact the clinic.');
        });
</script>
@endsection