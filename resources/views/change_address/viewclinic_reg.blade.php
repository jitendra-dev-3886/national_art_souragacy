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
                        <form class="form-horizontal" name="myForm"  action="{{ route('change_address.register.submit') }}"  id="application-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $application->id ?? '' }}">
                            <h6 class="card-title text-primary">Clinic Details</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        
                                        <input type="hidden"  id=""
                                                value="{{ $clinic_data->certificate_valid_date }}"
                                                class="form-control" readonly>

                                                <input type="hidden"  id=""
                                                value="{{ $clinic_data->clinic_type }}"
                                                class="form-control clinic_type" readonly>

                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Application
                                                Number</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="application_no" id="application_no"
                                                value="{{ $application->applicationno }}"
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
                                            for="validationCustomUsername">
                                            <strong>{{ $application->clinic_type === 'ARTBANK' ? 'Bank Name' : 'Clinic Name' }}
                                            </strong></label>
                                        <div class="input-group">

                                            <input type="text" name="clinicname" id="clinicname"
                                                value="{{ $application->clinicname}}" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Nature</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="nature" id="nature"
                                                value="{{ $application->nature }}" class="form-control"
                                                readonly>
                                            <!-- <div class="invalid-feedback">
                                            Please Enter a Transaction ID.
                                        </div> -->
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
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


                            <div class="row g-3">

                                {{-- Current Address --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Old Address
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-address-card"></i>
                                            </span>
                                            @php
                                                $fullAddress = implode(', ', array_filter([
                                                    $clinic_data->address ?? null,
                                                    $clinic_data->district ?? null,
                                                    $clinic_data->state ?? null,
                                                    $clinic_data->pincode ?? null,
                                                ]));
                                            @endphp
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ $fullAddress }}" title="{{ $fullAddress }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            New Address
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-address-card"></i>
                                            </span>

                                            <input
                                                name="address"
                                                id="address"
                                                type="text"
                                                class="form-control"
                                                value="{{ $application->address }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- New District --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            New District
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-map-marker"></i>
                                            </span>

                                            <input
                                                type="text"
                                                id="district"
                                                name="district"
                                                class="form-control"
                                                value="{{ $application->district }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- New State --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            New State
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-map"></i>
                                            </span>

                                            <input
                                                type="text"
                                                id="state"
                                                name="state"
                                                class="form-control"
                                                value="{{ $application->state }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- New Pincode --}}
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            New Pincode
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-map-pin"></i>
                                            </span>

                                            <input
                                                type="text"
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
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Name
                                                of the Contact Person</strong></label>
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
                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Email ID</strong></label>
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
                                        <label class="text-label form-label"
                                            for="validationCustomUsername"><strong>Mobile Number</strong></label>
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

                            <hr class=" text-success ">
                            @if ( $application->nature == 'Private')
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>
                                            Fee amount</strong></label>
                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                                                                  
                                            <input type="text" name="fee_amount" id="fee_amount"
                                                placeholder="Enter fee amount" class="form-control" value="{{ $feeAmount ?? 0 }}"
                                                readonly>
                                            <div class="invalid-feedback">
                                                Please Enter a Fee Amount.
                                            </div>
                                        </div>
                                       <!--  @if(($application->appstatus ?? null) === 'Rejected')
                                            <span>✓✓ <b>Fees already paid </b> </span>
                                        @endif -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="validationCustomUsername"><strong>Mode
                                                of Payment</strong><span class="csp-admin-label-color">*</span></label>
                                        @if (!empty($application->mode_payment))


                                        <div class="input-group">
                                            <span class="input-group-text"> <i
                                                    class="fas fa-money-bill-wave payment-icons"></i> </span>
                                            <input type="text" name="mode_payment" id="mode_payment"
                                                value="{{ $application->mode_payment }}"
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
                                                No.</strong><span class="csp-admin-label-color">*</span></label>
                                        @if (!empty($application->transaction_id))
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fas fa-receipt"></i> </span>
                                            <input type="text" name="transaction_id" id="transaction_id"
                                                value="{{ $application->transaction_id }}"
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
                                            for="validationCustomUsername"><strong>Date of Payment of fee
                                            </strong><span class="csp-admin-label-color">*</span></label>
                                        @if (!empty($application->app_date_payment))
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_payment" id="app_date_payment"
                                                value="{{ $application->app_date_payment->format('Y-m-d') }}"
                                                class="form-control" type="date" readonly>
                                        </div>
                                        @else
                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_payment" id="app_date_payment" class="form-control"
                                                type="date">
                                        </div>
                                        @endif

                                        @error('app_date_payment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            <?php //}?>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label"><strong>Date on which application recieved by State
                                                Appropriate Authority </strong><span
                                                class="csp-admin-label-color">*</span></label>

                                        @if ($application->app_date_recieve != null)

                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            <input name="app_date_recieve" id="app_date_recieve"
                                                value="{{ $application->app_date_recieve }}"
                                                placeholder="" class="form-control" type="date" disabled>
                                        </div>
                                        @else

                                        <div class="input-group">
                                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                            {{-- <input name="app_date_recieve" id="app_date_recieve" value=""
                                                class="form-control" type="date"> --}}
                                                <input name="app_date_recieve"
                                                id="app_date_recieve"
                                                class="form-control app_date_amount"
                                                type="date"
                                                value=""
                                                data-app-id="{{ Crypt::encryptString($application->id) }}">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Old Registration Certificate
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fa fa-file-pdf-o text-danger"></i>
                                            </span>

                                            @if(!empty($clinic_data->certificate_path))
                                                <input type="text"
                                                       class="form-control"
                                                       value="Certificate Available"
                                                       readonly>

                                                <a href="{{ asset('webprodfiles/clinic_registration_certificate/' . str_replace('/', '_', $clinic_data->clinic_id) . '/' . $clinic_data->certificate_path) }}"
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
                                    <div class="mb-3" id="state">
                                       
                                        @php
                                        
                                            $docTypeMapping = [
                                                'ARTSURROGACY' => ['doc_type' => 'target_file_receiving_surrogacyclinic_docs', 'label' => 'Receipt of Fee'],
                                                'ARTCLINIC'    => ['doc_type' => 'target_file_receiving_artclinic_docs', 'label' => 'Receipt of Fee'],
                                                'ARTBANK'      => ['doc_type' => 'target_file_receiving_artbank_docs', 'label' => 'Receipt of Fee'],
                                            ];

                                            $clinicDoc = $docTypeMapping[$application->clinic_type] ?? NULL;
                                            $documentExists = false;
                                        @endphp

                                        @if ($clinicDoc)
                                            {{-- Check if document already uploaded --}}
                                            @if ($get_docfileData->isNotEmpty())
                                                @foreach ($get_docfileData as $docfile)
                                                    @if ($docfile->doc_type === $clinicDoc['doc_type'])
                                                        @php
                                                            $documentExists = true;
                                                        @endphp
                                                        <label class="text-label form-label mb-10 mt-4" for="validationCustomUsername">
                                                            <strong>{{ $clinicDoc['label'] }}:</strong>

                                                        </label>
                                                        <div class="input-group">
                                                            <a href="{{ asset('webprodfiles/application_sa/' . $application_no_folder . '/' . basename($docfile->doc_upload_ref)) }}" class="link" target="_blank">
                                                                <i class="fa fa-download"></i> View {{ $clinicDoc['label'] }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                            {{-- If no document exists, show upload input --}}
                                            @if (!$documentExists)
                                            <label class="text-label form-label" for="validationCustomUsername">
                                                <strong>Upload {{ $clinicDoc['label'] }}</strong> <span class="csp-admin-label-color">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control" type="file" id="formFile1" name="{{ str_replace('target_file_', '', $clinicDoc['doc_type']) }}">
                                            </div>
                                            @endif
                                        @endif
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
                        @error('approved_rejected')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="control-label"><strong>Original Date of Registration</strong></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                            <input type="text" class="datepicker-default form-control" value="{{ date('d-m-Y',strtotime($application->current_registration_date )) }}" disabled>
                        </div>
                    </div>
                    <div class="mb-3" id="date_id" class="csp-admin-div-none">
                        <div class="mb-3">
                            <label class="control-label"><strong>Date of Registration</strong><span
                                    class="csp-admin-label-color">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                {{-- <input name="date_reg" id="date_reg" placeholder="" class="form-control" type="date" /> --}}
                                <input name="date_reg" id="date_reg"  class="form-control"  type="date" value="{{ $registrationDate }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="control-label"><strong>Validity Upto</strong><span
                                    class="csp-admin-label-color">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input name="validity_upto" id="validity_upto" placeholder="" class="form-control"
                                 type="date" value="{{ $newValidDate  ?? ''}}">
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
                        @error('registration_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3" id="d_rejection" class="csp-admin-div-none">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Date of
                                Rejection Order</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                            <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];?></span-->
                            <input name="date_rej" id="date_rej" placeholder="" class="form-control" type="date" />
                        </div>
                        @error('date_rej')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3" id="order_no" class="csp-admin-div-none">
                        <label class="text-label form-label" for="validationCustomUsername"><strong>Rejection Order
                                Number</strong><span class="csp-admin-label-color">*</span></label></label>
                        <div class="input-group">
                            <span class="input-group-text"> <i class="fa fa-pencil"></i> </span>
                            <!--span class="input-group-text"><?php //echo $app_status1['applicationno'];?></span-->
                            <input type="text" name="rejection_no" id="rejection_no" class="form-control">
                        </div>
                        @error('rejection_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @php
                        // Map clinic types to document names and labels
                        $fileFieldMap = [
                            'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                            'artclinic' => 'reg_artclinic_certificate',
                            'artbank'   => 'reg_artbank_certificate',
                        ];

                        $fileField = $fileFieldMap[strtolower($application->clinic_type)];
                    @endphp

                    <div class="mb-3" id="state">
                        <label class="text-label form-label" id="lableNameN"
                            for="validationCustomUsername"><strong>Registration
                                Certificate</strong><span class="csp-admin-label-color">*</span></label>
                        <div class="input-group">
                            <input class="form-control" type="file" id="formFile2" name="{{ $fileField }}" 
                            >
                        </div>
                       @error($fileField)
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="hidden" name="clinic_type" value="{{ $application->clinic_type }}">
                    <ul><strong>Note:- </strong>
                        <li>Date of Receipt of Application can't earlier than the date of payment of fee.</li>
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

<script nonce="{{ $cspNonce }}">
    $(document).ready(function () {

        const registrationDate = "{{ $registrationDate }}";

        function calculateValidityFromDate(dateStr) {
            if (dateStr) {
                const date = new Date(dateStr);
                const validityDate = date.toISOString().split('T')[0];

                $('#validity_upto').val(validityDate);
            } else {
                $('#validity_upto').val('');
            }
        }

        function showGranted() {
            $('#centralg').show();
            $('#order_no').hide();
            $('#date_id').show();
            $('#d_rejection').hide();

            $('#lableNameN').html(
                'Upload Registration Certificate <span class="csp-admin-label-color">*</span>'
            );

            $('#date_reg').val(registrationDate);
            calculateValidityFromDate(registrationDate);
        }

        function showRejected() {
            $('#order_no').show();
            $('#d_rejection').show();
            $('#centralg').hide();
            $('#date_id').hide();

            $('#lableNameN').html(
                'Upload Rejection Order <span class="csp-admin-label-color">*</span>'
            );

            $('#date_reg').val('');
            $('#validity_upto').val('');
        }

        function resetDecisionFields() {
            $('#order_no').hide();
            $('#centralg').hide();
            $('#date_id').hide();
            $('#d_rejection').hide();

            $('#date_reg').val('');
            $('#validity_upto').val('');

            $('#lableNameN').text('');
        }

        // Decision change
        $('#approved_rejected').on('change', function () {

            const decision = this.value;

            // Clear decision-related fields
            $('#registration_no').val('');
            $('#rejection_no').val('');
            $('#date_rej').val('');
            $('#formFile2').val('');

            if (decision === 'Registration Granted') {

                showGranted();

            } else if (decision === 'Registration Rejected') {

                showRejected();

            } else {

                resetDecisionFields();
            }
        });


        // Page load
        let initialValue = $('#approved_rejected').val();

        // If nothing is selected, default to Registration Granted
        if (!initialValue) {
            $('#approved_rejected').val('Registration Granted');
            initialValue = 'Registration Granted';
        }

        // Show correct section on page load
        if (initialValue === 'Registration Granted') {

            showGranted();

        } else if (initialValue === 'Registration Rejected') {

            showRejected();

        } else {

            resetDecisionFields();
        }

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
                e.preventDefault(); // Form submit prevention
            }
        });
    });

    function validatesubmit() {
            let isValid = true;
            var nature = document.getElementById("nature").value;
            var app_data = document.getElementById("app_date_recieve").value; 
                        
            // Additional validations only if nature is "Private"
            if (nature  === "Private") {
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

                if (app_data === '') { 
                    alert("Date of Receipt cannot be blank");
                    document.getElementById("app_date_recieve").focus(); 
                    return false;
                }

               const formFile1 = document.getElementById("formFile1");

                if (formFile1 && formFile1.value === "") {
                    alert("Upload Fee Receipt cannot be blank");
                    formFile1.focus();
                    return false;
                }
            }
            
            if (document.getElementById("approved_rejected").value == "") {
                alert("Decision cannot be blank");
                document.getElementById("approved_rejected").focus();
                return false;
            }

            if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById("date_reg").value == "")) {
                alert("Date of Registration cannot be blank");
                document.getElementById("date_reg").focus();
                return false;
            }
            
            // FIX: Only create Date objects and compare if the Rejection Date is actually filled out
            if (document.getElementById('date_rej') && document.getElementById('date_rej').value !== "") {
                const appDateReceive = new Date(document.getElementById('app_date_recieve').value);
                const dateRej = new Date(document.getElementById('date_rej').value);
                
                if (dateRej < appDateReceive) {
                    alert("Date of Rejection cannot be earlier than Date of Receive.");
                    document.getElementById('date_rej').value = ''; // Clear the Date of Rejection field
                    document.getElementById("date_rej").focus();
                    return false;
                }
            }
            
            if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById("validity_upto").value == "")) {
                alert("Date of Validity Upto cannot be blank");
                document.getElementById("validity_upto").focus();
                return false;
            }
            
            if ((document.getElementById("approved_rejected").value == "Registration Granted") && (document.getElementById("registration_no").value == "")) {
                alert("Registration No. cannot be blank");
                document.getElementById("registration_no").focus();
                return false;
            }
            
            // FIX: Check if formFile exists before checking its value to prevent crashes
            const formFile2 = document.getElementById("formFile2");
            if ((document.getElementById("approved_rejected").value == "Registration Granted") && formFile2 && (formFile2.value == "")) {
                alert("Upload Registration Certificate cannot be blank");
                formFile2.focus();
                return false;
            }

            if ((document.getElementById("approved_rejected").value === "Registration Rejected" && formFile2 && formFile2.value === "")) 
            {
                alert("Upload Rejection Order cannot be blank");
                formFile2.focus();
                return false;
            }
            
            if ((document.getElementById("approved_rejected").value == "Registration Rejected") && (document.getElementById("date_rej").value == "")) {
                alert("Date of Rejection cannot be blank");
                document.getElementById("date_rej").focus();
                return false;
            }
            
            if ((document.getElementById("approved_rejected").value == "Registration Rejected") && (document.getElementById("rejection_no").value == "")) {
                alert("Rejection Order No. cannot be blank");
                document.getElementById("rejection_no").focus();
                return false;
            }
            
            // FIX: Check if formFile exists before checking its value to prevent crashes
            if (
                document.getElementById("approved_rejected").value === "Registration Rejected" &&
                formFile2 &&
                formFile2.value === ""
            ) {
                alert("Upload Rejection Order cannot be blank");
                formFile2.focus();
                return false;
            }
            
            var agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
            
            if (agree) {
                return true;
            } else {
                return false;
            }
        };
</script>

<script nonce="{{ $cspNonce }}">
    var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif"];
    
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

        // jQuery event bindings (no inline js needed)
        $(document).ready(function () {
            $('#app_date_payment, #app_date_recieve').on('change', function () {
                validateDates();
            });
        });
    
        function fileSizeValidatejpeg(fdata, minSize, maxSizejpeg) {
            if (fdata.files && fdata.files[0]) {
                var fsize = fdata.files[0].size /
                    1024; 
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

   // Attach listeners using IDs
   document.addEventListener("DOMContentLoaded", function() {
       const formFile1 = document.getElementById("formFile1");
       const formFile2 = document.getElementById("formFile2");
   
       if (formFile1) {
           formFile1.addEventListener("change", function() {
               validateForSize(this, 50, 2048);
           });
       }
   
       if (formFile2) {
           formFile2.addEventListener("change", function() {
               validateForSize(this, 50, 2048);
           });
       }
   });

   // For the old documents
    document.getElementById('viewCertificateBtn').addEventListener('click', function (e) {
        e.preventDefault();
        alert('Certificate is not available. Please contact the clinic.');
    });
</script>
@endsection
