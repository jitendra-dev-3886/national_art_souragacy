@extends('layouts.admin.ssa_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div {
            background-color: #141481;
            border-color: #0b5ed7;
            color: white;
        }

        hr {
            height: 4px;
            /* Thickness of the line */
            background-color: #68e365;
            /* Color of the line */
            border: none;
            /* Removes default border */
            margin: 20px 0;
            /* Space above and below the line */
        }

        .csp-admin-label-color {
            color: #ff0000;
        }

        .csp-admin-div-none {
            display: none;
        }

        .csp-admin-submit-button {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: white;
        }

        input.form-control[readonly] {
            background-color: #f8f8f8;
            border: 1px solid #f3f1f1;
            cursor: not-allowed;
        }

        input.form-control[disabled] {
            background-color: #f8f8f8;
            border: 1px solid #f3f1f1;
            cursor: not-allowed;
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
                                action="{{ route('changemanpower.applicationChangeManpowerSubmit') }}" id="application-form"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $application->id ?? '' }}">
                                <h6 class="card-title text-primary">{{ match ($clinic_data->clinic_type) {
                                    'ARTCLINIC' => 'ART Clinic',
                                    'ARTBANK' => 'ART Bank',
                                    'ARTSURROGACY' => 'ART Surrogacy',
                                    default => "Clinic",} }} Details</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">

                                            <input type="hidden" id=""
                                                value="{{ $clinic_data->certificate_valid_date }}" class="form-control"
                                                readonly>

                                            <input type="hidden" id="" name="clinic_id"
                                                value="{{ $clinic_data->clinic_id }}" class="form-control" readonly>

                                            <input type="hidden" id="" value="{{ $clinic_data->clinic_type }}"
                                                class="form-control clinic_type" readonly>

                                            <label class="text-label form-label"
                                                for="validationCustomUsername"><strong>Application
                                                    Number</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i
                                                        class="fas fa-money-bill-wave payment-icons"></i> </span>
                                                <input type="text" name="application_no" id="application_no"
                                                    value="{{ $application->application_no }}" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3" id="state">
                                            <label class="text-label form-label" id="clinicNameLabel"
                                                for="validationCustomUsername"><strong>Clinic Name
                                                </strong></label>
                                            <div class="input-group">

                                                <input type="text" name="clinicname" id="clinicname"
                                                    value="{{ $application->clinicname }}" class="form-control" readonly>
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
                                                    value="{{ $application->nature }}" class="form-control" readonly>
                                                <!-- <div class="invalid-feedback">
                                                                                    Please Enter a Transaction ID.
                                                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Clinic Level</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="cliniclevel" id="cliniclevel"
                                                value="{{ $application->artclinics->cliniclevel }}"
                                                class="form-control" readonly>
                                            <!-- <div class="invalid-feedback">
                                            Please Enter a Transaction ID.
                                        </div> -->
                                        </div>
                                    </div>
                                </div> --}}
                                </div>
                                <div class="mb-3">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong>Address</strong></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                        <input type="text" name="address" id="address"
                                            value="{{ $application->address }}" class="form-control" readonly>
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
                                                    value="{{ $application->pincode }}" class="form-control" readonly>
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
                                                    value="{{ $application->state }}" class="form-control" readonly>
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
                                                    value="{{ $application->district }}" class="form-control" readonly>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- <h6 class="card-title text-primary">Change Manpower Director List</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-primary"><span class="d-inline p-2 bg-primary text-white">Existing
                                                Director</span></h6>
                                        <table class="table table-bordered border">
                                            <thead class="">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Qualification</th>
                                                    <th>Registration No.</th>
                                                    <th>Relieving Date </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ChangeManpowerDirector as $i => $cm)
                                                    @if ($cm->type == 'existing')
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $cm->name_director }}</td>
                                                            <td>{{ $cm->quali_director }}</td>
                                                            <td>{{ $cm->reg_director }}</td>
                                                            <td>{{ $cm->expiry_date }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <h6 class="text-primary"><span class="d-inline p-2 bg-primary text-white">New
                                                Director</span></h6>
                                        <table class="table table-bordered border">
                                            <thead class="">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Qualification</th>
                                                    <th>Registration No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ChangeManpowerDirector as $i => $cm)
                                                    @if ($cm->type == 'new')
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $cm->name_director }}</td>
                                                            <td>{{ $cm->quali_director }}</td>
                                                            <td>{{ $cm->reg_director }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <h6 class="card-title text-primary">Change Manpower Staff List</h6>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-primary"><span class="d-inline p-2 bg-primary text-white">Existing
                                                Staff</span></h6>
                                        <table class="table table-bordered border">
                                            <thead class="">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Post</th>
                                                    <th>name</th>
                                                    <th>Qualification</th>
                                                    <th>Registration No.</th>
                                                    <th>Relieving Date </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ChangeManpowerStaff as $i => $cms)
                                                    @if ($cms->type == 'existing')
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $cms->post ?? $cms->anyotherpost }}</td>
                                                            <td>{{ $cms->name }}</td>
                                                            <td>{{ $cms->qualification ?? $cms->anyotherdegree }}</td>
                                                            <td>{{ $cms->regno }}</td>
                                                            <td>{{ $cms->expiry_date }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <h6 class="text-primary"><span class="d-inline p-2 bg-primary text-white">New
                                                Staff</span></h6>
                                        <table class="table table-bordered border">
                                            <thead class="">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Post</th>
                                                    <th>name</th>
                                                    <th>Qualification</th>
                                                    <th>Registration No.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ChangeManpowerStaff as $i => $cms)
                                                    @if ($cms->type == 'new')
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $cms->post ?? $cms->anyotherpost }}</td>
                                                            <td>{{ $cms->name }}</td>
                                                            <td>{{ $cms->qualification ?? $cms->anyotherdegree }}</td>
                                                            <td>{{ $cms->regno }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div> --}}
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Date on which application recieved by
                                                    State
                                                    Appropriate Authority </strong><span
                                                    class="csp-admin-label-color">*</span></label>

                                            @if ($application->app_date_recieve != null)
                                                <div class="input-group">
                                                    <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                    <input name="app_date_recieve" id="app_date_recieve"
                                                        value="{{ $application->app_date_recieve }}" placeholder=""
                                                        class="form-control" type="date" disabled>
                                                </div>
                                            @else
                                                <div class="input-group">
                                                    <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                    {{-- <input name="app_date_recieve" id="app_date_recieve" value=""
                                                class="form-control" type="date"> --}}
                                                    <input name="app_date_recieve" id="app_date_recieve"
                                                        class="form-control {{ $application->is_resubmission === 1 ? '' : 'app_date_amount' }}"
                                                        type="date" value=""
                                                        data-app-id="{{ Crypt::encryptString($application->id) }}">
                                                </div>
                                            @endif

                                        </div>
                                    </div>



                                </div>

                                <div class="mb-3">
                                    <label class="control-label"><strong>Decision</strong><span
                                            class="csp-admin-label-color">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-chevron-down"></i> </span>
                                        <select name="approved_rejected" id="approved_rejected" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Registration Granted">Registration Granted</option>

                                            <option value="Registration Rejected">Registration Rejected</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Original Date of
                                                    Registration</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                <input type="text" class="datepicker-default form-control"
                                                    value="{{ date('d-m-Y', strtotime($application->current_registration_date)) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="control-label"><strong>Certificate Valid Date</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                                <input type="text" class="datepicker-default form-control"
                                                    value="{{ date('d-m-Y', strtotime($clinic_data->certificate_valid_date)) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="mb-3" id="date_id" class="csp-admin-div-none">
                                    <div class="mb-3">
                                         <label class="control-label"><strong>Date of Registration</strong><span
                                    class="csp-admin-label-color">*</span></label>
                                         <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input name="date_reg" id="date_reg"  class="form-control"  type="date" value="{{ $registrationDate ?? '' }}" readonly/>
                            </div> 
                                    </div>

                                </div> --}}
                                <div class="mb-3" id="centralg" class="csp-admin-div-none">
                                    <label class="text-label form-label"
                                        for="validationCustomUsername"><strong>Registration
                                            Number</strong><span class="csp-admin-label-color">*</span></label></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                                        <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];
                                        ?></span-->
                                        <input type="text" name="registration_no" id="registration_no"
                                            class="form-control" value="{{ $clinic_data->registration_no ?? '' }}"
                                            readonly>

                                    </div>
                                </div>
                                {{-- <div class="mb-3" id="d_rejection" class="csp-admin-div-none">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Date of
                                            Rejection Order</strong><span
                                            class="csp-admin-label-color">*</span></label></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                       
                                        <input name="date_rej" id="date_rej" placeholder="" class="form-control"
                                            type="date" />

                                    </div>
                                </div> --}}
                                <div class="mb-3" id="order_no" class="csp-admin-div-none">
                                    <label class="text-label form-label" for="validationCustomUsername"><strong>Rejection
                                            Order
                                            Number</strong><span class="csp-admin-label-color">*</span></label></label>
                                    <div class="input-group">
                                        <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                                        <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];
                                        ?></span-->
                                        <input type="text" name="rejection_no" id="rejection_no"
                                            class="form-control">

                                    </div>
                                </div>
                                @php
                                    // Map clinic types to document names and labels
                                    $fileFieldMap = [
                                        'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                                        'artclinic' => 'reg_artclinic_certificate',
                                        'artbank' => 'reg_artbank_certificate',
                                    ];
                                    $ct = strtolower($application->clinic_type);

                                @endphp

                                <div class="mb-3" id="state">
                                    <label class="text-label form-label" id="lableName"
                                        for="validationCustomUsername"><strong>Registration
                                            Certificate</strong><span
                                            class="csp-admin-label-color">*</span></label></label>
                                    <div class="input-group">
                                        {{-- <input class="form-control" type="file" id="formFile" name="reg_artbank_certificate"> --}}
                                        <input class="form-control" type="file" id="formFile1"
                                            name="{{ $fileFieldMap[$ct] }}" required>
                                    </div>
                                </div>

                                <ul><strong>Note:- </strong>
                                    <li>Date of Receipt of Application can't earlier than the date of payment of fee.</li>
                                    <li>File Type: PDF or JPG Format only.</li>
                                    <li>File Size: 50 to 200 kb.</li>
                                </ul>

                                <br>
                                <div class="mb-3" id="state">
                                    <label class="text-label form-label" id="lableName"
                                        for="validationCustomUsername"><strong>Remark</strong></label></label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="remark" name="remark">
                                    </div>
                                </div>

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
            // Set the max attribute for date fields to today's date
            document.addEventListener("DOMContentLoaded", function() {
                const today = new Date().toISOString().split('T')[0];
                // document.getElementById('app_date_payment').setAttribute('max', today);
                document.getElementById('app_date_recieve').setAttribute('max', today);
                document.getElementById('date_reg').setAttribute('max', today);
                document.getElementById('date_rej').setAttribute('max', today);
            });

            document.addEventListener("DOMContentLoaded", () => {
                // const dateOfPaymentField = document.getElementById("app_date_payment");
                const dateOfReceiptField = document.getElementById("app_date_recieve");

                // Validate dates when the 'Date of Payment' is changed
                // dateOfPaymentField.addEventListener("change", () => {
                //     validateDateFields("payment");
                // });

                // Validate dates when the 'Date of Receipt' is changed
                dateOfReceiptField.addEventListener("change", () => {
                    validateDateFields("receipt");
                });
            });

            // function validateDateFields(triggeredBy) {
            //     // const dateOfPaymentField = document.getElementById("app_date_payment");
            //     const dateOfReceiptField = document.getElementById("app_date_recieve");

            //     // const dateOfPayment = dateOfPaymentField.value;
            //     const dateOfReceipt = dateOfReceiptField.value;

            //     if (dateOfPayment && dateOfReceipt) {
            //         // const paymentDate = new Date(dateOfPayment);
            //         const receiptDate = new Date(dateOfReceipt);

            //         // Check if the 'Date of Receipt' is earlier than the 'Date of Payment'
            //         if (receiptDate < paymentDate) {
            //             alert("Date of Receipt cannot be earlier than the Date of Payment.");
            //             if (triggeredBy === "receipt") {
            //                 dateOfReceiptField.value = "";
            //                 dateOfReceiptField.focus();
            //             } else if (triggeredBy === "payment") {
            //                 dateOfPaymentField.value = "";
            //                 dateOfPaymentField.focus();
            //             }
            //         }
            //     }
            // }

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
                    const decision = this.value;
                    $("#rejection_no").val('');
                    $("#date_rej").val('');
                    $("#formFile").val('');

                    if (decision === 'Registration Granted') {
                        // Show relevant sections
                        $("#centralg").show();
                        $("#order_no").hide();
                        $("#date_id").show();
                        $("#d_rejection").hide();

                        // Label for upload
                        $('#lableName').html("<strong> Registration Certificate <strong>*</strong>");


                    } else if (decision === 'Registration Rejected') {
                        $('#lableName').html("<strong>Upload Rejection Order <strong>*</strong>");
                        $("#order_no").show();
                        $("#d_rejection").show();
                        $("#centralg").hide();
                        $("#date_id").hide();

                        // Clear registration fields
                        $('#date_reg').val('');
                        $('#validity_upto').val('');

                    } else {
                        // Reset all conditionally shown blocks
                        $("#order_no").hide();
                        $("#centralg").hide();
                        $("#date_id").hide();
                        $("#d_rejection").hide();
                        $('#lableName').removeAttr("Rejection Order");

                        $('#date_reg').val('');
                        $('#validity_upto').val('');
                        // $('#lableName').text(''); // Clear label
                    }
                });

                // On page load, if already selected (e.g., on edit)
                const initialValue = $('#approved_rejected').val();
                // }
            });
        </script>


        <script nonce="{{ $cspNonce }}">
            // Set the max attribute for date fields to today's date
            document.addEventListener("DOMContentLoaded", function() {
                const today = new Date().toISOString().split('T')[0];
                // document.getElementById('app_date_payment').setAttribute('max', today);
                document.getElementById('app_date_recieve').setAttribute('max', today);
            });

            document.addEventListener("DOMContentLoaded", () => {
                // const dateOfPaymentField = document.getElementById("app_date_payment");
                const dateOfReceiptField = document.getElementById("app_date_recieve");

                // Validate dates when the 'Date of Payment' is changed
                // dateOfPaymentField.addEventListener("change", () => {
                //     validateDateFields("payment");
                // });

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
        </script>
        <script nonce="{{ $cspNonce }}">
            $(document).ready(function() {
                $('#application-form').on('submit', function(e) {
                    if (!validatesubmit()) {
                        e.preventDefault(); // Form submit को रोकें
                    }
                });
            });

            function validatesubmit() {
                let isValid = true;
                var nature = document.getElementById("nature").value;

                var app_data = document.getElementById("app_date_recieve").value; // Correct way to get value using jQuery
                // alert(app_data);
                if (app_data === '') {
                    alert("Date of Receipt cannot be blank");
                    document.getElementById("app_date_recieve").focus(); // Using jQuery for better cross-browser support
                    return false;
                }
                // Additional validations only if nature is "Private"
                if (nature === "Private") {
                    //alert(nature);
                    if (document.getElementById("fee_amount").value == "") {
                        alert("Fee amount cannot be blank");
                        document.getElementById("fee_amount").focus();
                        return false;
                    }

                    if (document.getElementById("mode_payment").value == "") {
                        alert("Mode of payment cannot be blank");
                        document.getElementById("mode_payment").focus();
                        return false;
                    }
                    if (document.getElementById("transaction_id").value == "") {
                        alert("Transaction ID cannot be blank");
                        document.getElementById("transaction_id").focus();
                        return false;
                    }
                    if (document.getElementById("app_date_payment").value == "") {
                        alert("Date of Payment of Fee cannot be blank");
                        document.getElementById("app_date_payment").focus();
                        return false;
                    }
                }
                if (document.getElementById("approved_rejected").value == "") {
                    alert("Decision cannot be blank");
                    document.getElementById("approved_rejected").focus();
                    return false;
                }

                if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById(
                            "date_reg")
                        .value == "")) {
                    alert("Date of Registration cannot be blank");
                    document.getElementById("date_reg").focus();
                    return false;
                }
                const appDateReceive = new Date(document.getElementById('app_date_recieve').value);
                const dateReg = new Date(document.getElementById('date_reg').value);
                const dateValid = new Date(document.getElementById('validity_upto').value);
                const dateRej = new Date(document.getElementById('date_rej').value);

                if (dateRej < appDateReceive) {
                    alert("Date of Rejection cannot be earlier than Date of Receive.");
                    document.getElementById('date_rej').value = ''; // Clear the Date of Rejection field
                    document.getElementById("date_rej").focus();
                    return false;
                }
                if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById(
                            "validity_upto")
                        .value == "")) {
                    alert("Date of Validity Upto cannot be blank");
                    document.getElementById("validity_upto").focus();
                    return false;
                }
                if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById(
                            "registration_no")
                        .value == "")) {
                    alert("Registration No. cannot be blank");
                    document.getElementById("registration_no").focus();
                    return false;
                }
                if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById(
                            "formFile")
                        .value == "")) {
                    alert("Upload Registration Certificate cannot be blank");
                    document.getElementById("formFile").focus();
                    return false;
                }
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
            };
            // });
        </script>
        <script nonce="{{ $cspNonce }}">
            var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif"];

            function validateForSize(oInput, minSize, maxSizejpeg) {
                //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
                if (oInput.type == "file") {
                    var sFileName = oInput.value;
                    if (sFileName.length > 0) {
                        var blnValid = false;
                        for (var j = 0; j < _validFilejpeg.length; j++) {
                            var sCurExtension = _validFilejpeg[j];
                            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                                .toLowerCase() == sCurExtension.toLowerCase()) {
                                blnValid = true;
                                break;
                            }
                        }

                        if (!blnValid) {
                            alert("Sorry, this file is invalid, allowed extension is: " + _validFilejpeg.join(", "));
                            oInput.value = "";
                            return false;
                        }
                    }
                }

                fileSizeValidatejpeg(oInput, minSize, maxSizejpeg);
            }

            // ✅ jQuery event bindings (no inline js needed)
            $(document).ready(function() {
                $('#app_date_payment, #app_date_recieve').on('change', function() {
                    validateDates();
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


            // ✅ Attach listeners using IDs
            document.addEventListener("DOMContentLoaded", function() {
                const formFile1 = document.getElementById("formFile1");
                const formFile = document.getElementById("formFile");

                if (formFile1) {
                    formFile1.addEventListener("change", function() {
                        validateForSize(this, 50, 200);
                    });
                }

                if (formFile) {
                    formFile.addEventListener("change", function() {
                        validateForSize(this, 50, 200);
                    });
                }
            });
            $(document).ready(function() {
                $('.app_date_amount').on('change', function() {
                    let recived_date = $(this).val();
                    let get_id = $(this).data('app-id');
                    $.ajax({
                        url: "{{ route('renewal.ssa_application.get.cashamount') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            recived_date: recived_date,
                            get_id: get_id,
                        },
                        success: function(response) {
                            // console.log(response);
                            let check = $('#fee_amount').val();
                            if (check != response) {
                                alert('Applicable fee is initial registration fee i.e. Rs ' +
                                    response + ' for late submission of application.');
                                $('#fee_amount').val('');
                                $('#fee_amount').val(response);
                            } else {
                                $('#fee_amount').val(check);
                            }
                            $('#fee_amount').val(response)

                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Something went wrong');
                        }
                    });
                });
            });
        </script>
    @endsection
