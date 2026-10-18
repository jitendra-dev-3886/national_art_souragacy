@extends('layouts.admin.ssa_master')
@section('content')

    <style nonce="{{ $cspNonce }}">
        .csp-admin-message-div{
            background-color: #141481; border-color: #0b5ed7; color: white;
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
        .csp-admin-div-none{
            display: none;
        }
        .csp-admin-submit-button{
            background-color: #0b5ed7; border-color: #0b5ed7; color: white;
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
            @if(session('error'))
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
                        <form class="form-horizontal" name="myForm" action="{{ route('admin.reg_receive_surrogacy_submit') }}" id="application-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $receivedssasurrogacyformList->surrogacyclinics->id ?? '' }}">
                            <input type="hidden" name="userid" value="{{ $receivedssasurrogacyformList->id ?? '' }}">
                            <h6 class="card-title text-primary">Surrogacy Clinic Details</h6>
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
                                                value="{{ $receivedssasurrogacyformList->surrogacyclinics->sapp_no->applicationno }}"
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
                                            for="validationCustomUsername"><strong>Clinic Name
                                            </strong></label>
                                        <div class="input-group">

                                            <input type="text" name="clinicname" id="clinicname"
                                                value="{{ $receivedssasurrogacyformList->clinicname}}" class="form-control"
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
                                                value="{{ $receivedssasurrogacyformList->nature }}" class="form-control"
                                                readonly>
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
                                                value="{{ $receivedssabankformList->artclinics->cliniclevel }}"
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
                                        value="{{ $receivedssasurrogacyformList->address }}" class="form-control" readonly>
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
                                                value="{{ $receivedssasurrogacyformList->pincode }}" class="form-control"
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
                                                value="{{ $receivedssasurrogacyformList->state }}" class="form-control"
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
                                                value="{{ $receivedssasurrogacyformList->district }}" class="form-control"
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
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Name
                                                of the Contact Person</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                                            <input type="text" name="address" id="address"
                                                value="{{ $receivedssasurrogacyformList->personname }}" class="form-control"
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
                                                value="{{ $receivedssasurrogacyformList->email }}" class="form-control"
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
                                            <input type="text" name="address" id="address"
                                                value="{{ $receivedssasurrogacyformList->mobile }}" class="form-control"
                                                readonly>
                                            <!-- <div class="invalid-feedback">
                                            Please Enter a username.
                                        </div> -->
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <h4 class="card-title text-primary">Enter receipt/fee details</h4>

                            <hr class=" text-success ">
                            <div class="row">
                                <div class="col-md-3"> 
                                    <div class="form-check">
                                        <input type="checkbox" name="incomplete_withdrawal_cancelled" id="incomplete_withdrawal_cancelled" placeholder="Enter receipt number" class="form-check-input me-2">
                                            <label class="mt-2">Incomplete / Withdrawal / Cancelled</label>
                                    </div>
                                </div>
                                <div class="col-md-8" id="physical_application_div" style="display:none !important;"> 
                                    <div class="form-check">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label class="mt-3">Physical Application</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <select name="physical_application" id="physical_application" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1">Physical Application Not Received by SAA</option>
                                                        <option value="2">Physical Application Submitted without fees</option>
                                                        <option value="3">Physical Application Submitted but incomplete (without relevant document)</option>
                                                        <option value="4">Application withdrawn/cancelled by the applicant</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                                <hr class=" text-success ">
                            @if ( $receivedssasurrogacyformList->nature == 'Private')
                            <?php //if( $row2['nature'] == "Private") {?>
                            
                            <div class="row">


                                {{-- @if ($receivedssaartformList->artclinics->cliniclevel == 'Level-1') --}}
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Fee
                                                amount</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <!-- <select name="fee_amount" id="fee_amount"
                                            class="form-control">
                                            <option value="">Select</option>
                                            <option value="50000">50000</option>
                                            <option value="200000">200000</option>                                               
                                        </select>                                            -->
                                            <input type="text" name="fee_amount" id="fee_amount"
                                                placeholder="Enter fee amount" class="form-control" value="200000"
                                                readonly>
                                            <div class="invalid-feedback">
                                                Please Enter a Fee Amount.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- @elseif ($receivedssaartformList->artclinics->cliniclevel == 'Level-2')
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Fee
                                                amount</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <!-- <select name="fee_amount" id="fee_amount"
                                            class="form-control">
                                            <option value="">Select</option>
                                            <option value="50000">50000</option>
                                            <option value="200000">200000</option>                                               
                                        </select>                                            -->
                                            <input type="text" name="fee_amount" id="fee_amount"
                                                placeholder="Enter fee amount" class="form-control" value="200000"
                                                readonly>
                                            <div class="invalid-feedback">
                                                Please Enter a Fee Amount.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif --}}
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Mode
                                                of Payment</strong><span class="csp-admin-label-color incomplete_application_not_required">*</span></label>
                                        @if (!empty($receivedssasurrogacyformList->surrogacyclinics->mode_payment))


                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="mode_payment" id="mode_payment"
                                                value="{{ $receivedssasurrogacyformList->surrogacyclinics->mode_payment }}"
                                                class="form-control" readonly>
                                            <div class="invalid-feedback">
                                                Please Enter a Mode of Payment.
                                            </div>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <select name="mode_payment" id="mode_payment" class="form-control">
                                                <option value="">Select</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Demand Draft">Demand Draft</option>
                                                <option value="Online">Online</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please Enter a Mode of Payment.
                                            </div>
                                        </div>

                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Transaction ID/DD No./Ref.no/Receipt
                                                No.</strong><span class="csp-admin-label-color incomplete_application_not_required">*</span></label>
                                        @if (!empty($receivedssasurrogacyformList->surrogacyclinics->transaction_id))
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fas fa-receipt"></i> </span>
                                            <input type="text" name="transaction_id" id="transaction_id"
                                                value="{{ $receivedssasurrogacyformList->surrogacyclinics->transaction_id }}"
                                                class="form-control" readonly>
                                            <div class="invalid-feedback">
                                                Please Enter a Transaction ID.
                                            </div>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fas fa-receipt"></i> </span>
                                            <input type="text" name="transaction_id" id="transaction_id"
                                                placeholder="Transaction ID/DD No./Ref.no/Receipt No."
                                                class="form-control">
                                            <div class="invalid-feedback">
                                                Please Enter a Transaction ID.
                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3" id="state">
                                        <label class="text-label form-label" id="lableName"
                                            for="validationCustomUsername"><strong>Date of Payment of Fees
                                            </strong><span class="csp-admin-label-color incomplete_application_not_required">*</span></label>
                                        @if (!empty($receivedssasurrogacyformList->surrogacyclinics->app_date_payment))
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_payment" id="app_date_payment"
                                                value="{{ $receivedssasurrogacyformList->surrogacyclinics->app_date_payment }}"
                                                class="form-control" type="date" readonly>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_payment" id="app_date_payment" class="form-control"
                                                type="date" max="{{ date('Y-m-d') }}">
                                        </div>

                                        @endif

                                    </div>
                                </div>
                            </div>
                            @endif
                            <?php //}?>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Date on which application recieved by State
                                                Appropriate Authority </strong><span
                                                class="csp-admin-label-color incomplete_application_not_required">*</span></label>

                                        @if ($receivedssasurrogacyformList->surrogacyclinics->app_date_recieve != null)

                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_recieve" id="app_date_recieve"
                                                value="{{ $receivedssasurrogacyformList->surrogacyclinics->app_date_recieve }}"
                                                placeholder="" class="form-control" type="date" disabled>
                                        </div>
                                        @else

                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_recieve" id="app_date_recieve" value=""
                                                class="form-control" type="date" max="{{ date('Y-m-d') }}">
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                @if ( $receivedssasurrogacyformList->nature == 'Private')

                                <div class="col-md-6">
                                    <div class="mb-3" id="state">
                                        @php
                                        $docTypeMapping = [
                                        'target_file_receiving_surrogacyclinic_docs' => 'Reciept of Fee',
                                        ];
                                        //dd($get_docfileData);
                                        @endphp
                                        @php $documentExists = false; @endphp

                                        @if($get_docfileData->isNotEmpty())
                                            @foreach ($get_docfileData as $docfile)
                                                @if ($docfile->doc_type === 'target_file_receiving_surrogacyclinic_docs')
                                                    @php $documentExists = true; 
                                                    $baseUrl = getApplicationBaseUrl();
                                                    $inputappno = $receivedssasurrogacyformList->surrogacyclinics->sapp_no->applicationno;
                                                    $applicationno = str_replace('/', '_', $inputappno).'/';
                                                    
                                                    @endphp

                                                    <label class="text-label form-label mb-10" id="lableName" for="validationCustomUsername">
                                                        <strong>Receipt of Fee: </strong>
                                                    </label>
                                                    <div class="input-group">
                                                        {{-- <a href="{{ asset('artprojfiles/application_sa/' . $application_no_folder . '/' . basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                            <i class="fa fa-download"></i> View Receipt
                                                        </a> --}}
                                                        @php $file = folderpath('application_sa_blade') . $application_no_folder . '/' . $docfile->doc_upload_ref; @endphp
                                                        <a href="{{ asset($file) }}" target="_blank"> <i class="fa fa-download"></i> View Receipt</a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if (!$documentExists)
                                            <div class="input-group">
                                                <label class="text-label form-label" id="lableName" for="validationCustomUsername">
                                                    <strong>Upload Receipt of Fee</strong> <span class="csp-admin-label-color incomplete_application_not_required">*</span>
                                                </label>
                                                <input class="form-control" type="file" id="formFile1" name="receiving_surrogacyclinic_docs" accept="application/pdf">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

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
                    <div class="mb-3" id="rejection_reason_div" style="display:none;">
                        <label class="control-label"><strong>Reason for Rejection</strong><span class="csp-admin-label-color">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-chevron-down"></i></span>
                            <textarea name="reason_for_rejection" id="reason_for_rejection" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mb-3" id="date_id" class="csp-admin-div-none">
                        <div class="mb-3">
                            <label class="control-label"><strong>Date of Registration</strong><span
                                    class="csp-admin-label-color">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input name="date_reg" id="date_reg" placeholder="" class="form-control" type="date" max="{{ date('Y-m-d') }}"/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="control-label"><strong>Validity Upto</strong><span
                                    class="csp-admin-label-color">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input name="validity_upto" id="validity_upto" placeholder="" class="form-control"
                                    type="date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3" id="centralg" class="csp-admin-div-none">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Registration
                                Number</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                            <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];?></span-->
                            <input type="text" name="registration_no" id="registration_no" class="form-control">

                        </div>
                    </div>
                    <div class="mb-3" id="d_rejection" class="csp-admin-div-none">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Date of
                                Rejection Order</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                            <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];?></span-->
                            <input name="date_rej" id="date_rej" placeholder="" class="form-control" type="date" max="{{ date('Y-m-d') }}"/>

                        </div>
                    </div>
                    <div class="mb-3" id="order_no" class="csp-admin-div-none">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Rejection Order
                                Number</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                            <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];?></span-->
                            <input type="text" name="rejection_no" id="rejection_no" class="form-control">

                        </div>
                    </div>
                    <div class="mb-3" id="state">
                        <label class="text-label form-label" id="lableNameR"
                            for="validationCustomUsername"><strong>Registration
                                Certificate</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">

                            <input class="form-control" type="file" id="formFile" name="reg_surrogacyclinic_certificate">
                        </div>
                    </div>








                    <ul><strong>Note:- </strong>
                        <li>Date of Receipt of Application can't earlier than the date of payment of fees.</li>
                        <li>File Type: PDF or JPG Format only.</li>
                        <li>File Size: 50 to 200 kb.</li>
                    </ul>

                    <br>
                    <button type="submit" name="submit"  class="btn me-2 btn-primary csp-admin-submit-button">Submit</button>
                    <!--button type="submit" class="btn btn-danger light">Cancel</button-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script nonce="{{ $cspNonce }}" src="{{ url('public/js/jquery-3.6.0.min.js')}}"></script>
<script nonce="{{ $cspNonce }}">
    // Add an event listener for the date input
        document.getElementById('date_reg').addEventListener('input', function () {
            const dateReg = this.value; // Get the selected date
            if (dateReg) {
                const date = new Date(dateReg); // Create a Date object
                date.setFullYear(date.getFullYear() + 3); // Add 5 years
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
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('app_date_payment').setAttribute('max', today);
            document.getElementById('app_date_recieve').setAttribute('max', today);
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
    $(document).ready(function () {
        $('#app_date_payment, #app_date_recieve').on('change', function () {
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

{{-- <script nonce="{{ $cspNonce }}">
    $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                'w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
</script> --}}

<script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        $('#approved_rejected').on('change', function() {
           // alert('check 1');
            $("#date_reg").val('');
            $("#validity_upto").val('');
            $("#registration_no").val('');
            $("#rejection_no").val('');
            $("#date_rej").val('');
    
            $("#formFile").val('');
    
            if (this.value == 'Registration Granted') {
                $("#centralg").show();
                $("#order_no").hide();
                $("#date_id").show();
                $("#d_rejection").hide();
                $('#lableNameR').html("<strong>Upload Registration Certificate <span class='csp-admin-label-color'>*</span></strong>");
            } else if (this.value == 'Registration Rejected') {
                //$("lableName").html.replace("text value");
                $("#order_no").show();
                $("#d_rejection").show();
                $("#centralg").hide();
                $("#date_id").hide();
                $('#lableNameR').html("<strong>Upload Rejection Order <span class='csp-admin-label-color'>*</span></strong>");
    
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
            var nature = document.getElementById("nature").value;

            //     var app_data = $("#app_date_recieve").val();
            //     alert(app_data);
        
            //    if (test.app_data == '') {
            //             alert("Date of Receipt cannot be blank");
            //             document.getElementById("app_date_recieve").focus();
            //             return false;
            //         } 
            //         alert(nature+"Hii");
            var app_data = document.getElementById("app_date_recieve").value; // Correct way to get value using jQuery
            // alert(app_data);
           
            // Additional validations only if nature is "Private"
            if (nature  === "Private") {
                // alert(nature);
                if (document.getElementById("incomplete_withdrawal_cancelled").checked) {
                    if(document.getElementById("physical_application").value == "") {
                        alert("Physical Application cannot be blank");
                        document.getElementById("physical_application").focus();
                        return false;
                    }
                    if(document.getElementById("reason_for_rejection").value == "") {
                        alert("Reason for Rejection cannot be blank");
                        document.getElementById("reason_for_rejection").focus();
                        return false;
                    }
                }else{
                    if (app_data === '') { 
                        alert("Date of Receipt cannot be blank");
                        document.getElementById("app_date_recieve").focus(); // Using jQuery for better cross-browser support
                        return false;
                    }
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
                    if (document.getElementById("formFile1").value == "") {
                        alert("upload the receipt of Fee");
                        document.getElementById("formFile1").focus();
                        return false;
                    }	
                }           
            } else {
                if (document.getElementById("incomplete_withdrawal_cancelled").checked) {
                    if(document.getElementById("physical_application").value == "") {
                        alert("Physical Application cannot be blank");
                        document.getElementById("physical_application").focus();
                        return false;
                    }
                    if(document.getElementById("reason_for_rejection").value == "") {
                        alert("Reason for Rejection cannot be blank");
                        document.getElementById("reason_for_rejection").focus();
                        return false;
                    }
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
            // Check if Date of Registration is not earlier than Date of Receive
            if (dateReg < appDateReceive) {
                alert("Date of Registration cannot be earlier than Date of Receive.");
                document.getElementById('date_reg').value = ''; // Clear the Date of Registration field
                document.getElementById("date_reg").focus();
                return false;
            }
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
            // Check if delay_reason is required and empty
            // var delayReasonDiv = document.getElementById('delay_reason_div');
            // var delayReason = document.getElementById('delay_reason').value;

            // if (delayReasonDiv.style.display === 'block' && delayReason.trim() === '') {
            //     alert("Please provide a reason for the delay.");
            //     document.getElementById("delay_reason").focus();
            //     return false; // Prevent form submission
            // }
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
    var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".gif"];
    
        function validateForSize(oInput, minSize, maxSizejpeg) {
        // alert('jjj');
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
        $(document).ready(function () {
            $('#app_date_payment, #app_date_recieve').on('change', function () {
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
</script>


{{-- <script nonce="{{ $cspNonce }}" type="text/javascript">
    window.history.forward();
    
        function noBack() {
            window.history.forward();
        }
</script> --}}
<script nonce="{{ $cspNonce }}" >
    $(document).ready(function () {
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

                $('#lableNameR').html("<strong>Upload Rejection Order <span class='csp-admin-label-color'>*</span></strong>");
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
                $('#lableNameR').html("<strong>Upload Registration Certificate <span class='csp-admin-label-color'>*</span></strong>");
            }
        });
    });
    </script>
@endsection