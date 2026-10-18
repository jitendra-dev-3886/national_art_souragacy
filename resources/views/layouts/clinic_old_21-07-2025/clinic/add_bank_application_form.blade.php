@extends('layouts.clinic.clinic_master')
@section('content')


<style nonce="{{ $cspNonce }}">
    .border-color-csp-noc-fortytwo{
    border-color: #0b5ed7; color: #0b5ed7;
    }
    .color-red-fourty-three{
        color: #ff0000;
    }
    .btn-color-border-color-csp-noc-fourty-five{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .csp-clinic-height{
        height: 20px;
    }
    .csp-clinic-width{
        width:50%;
    }
    .csp-clinic-display-none{
        display:none;
    }
</style>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if (session('success'))
                        <div class="alert alert-success">
                        {{ session('success') }}
                        </div>
                @endif
       
            <h3>Application Form for ART Bank</h3>

            <!-- Progress Bar -->
  <div class="progress mb-4 csp-clinic-height" >
    <div
      id="progress-bar"
      class="progress-bar progress-bar-striped progress-bar-animated csp-clinic-width"
      role="progressbar"
     
      aria-valuenow="50"
      aria-valuemin="0"
      aria-valuemax="100">
      Step 1 of 2
    </div>
  </div>

            <!-- Form -->
            <form id="form-wizard" method="POST" action="{{ route('clinic.save_bank_application_form') }}" enctype="multipart/form-data" autocomplete="off">
              <!-- Step 1 -->
              @csrf
              <div id="step-1" class="step">
                <div class="row">
                    <h3 class="border-color-csp-noc-fortytwo">General Information and Staff Details</h3>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="control-label" for="clinicname"><strong>Name of the Bank</strong><span
                                class="color-red-fourty-three">*</span></label>
                        <div class="input-group">
                            <input id="clinicname" name="clinicname" class="form-control" value="{{ $signup->clinicname ?? '' }}"
                                type="text" readonly/>
                        </div>
                        <div id="errorclinicname" class="color-red-fourty-three"></div>
                        @if ($errors->has('clinicname'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('clinicname') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="address"><strong>Address</strong></label>
                        <div class="input-group">
                            <input type="text" name="address" id="address"
                               value="{{ $signup->address ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                        <div id="erroraddress" class="color-red-fourty-three"></div>
                        @if ($errors->has('address'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pincode"><strong>Pincode</strong></label>
                        <div class="input-group">
                            <input type="text" name="pincode" placeholder="" id="pincode"
                                value="{{ $signup->pincode ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                        <span id="pincodeavailability"></span>
                        <div id="errorpincode" class="color-red-fourty-three"></div>
                        @if ($errors->has('pincode'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('pincode') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="state"><strong>State</strong></label>
                        <div class="input-group">
                            <input type="text" name="state" placeholder="state" id="state"
                                value="{{ $signup->state ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="district"><strong>District</strong></label>
                        <div class="input-group" id="district-container">
                            <input type="text" name="district" placeholder="district" id="district"
                                value="{{ $signup->district ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="nature2"><strong>Nature
                                of the
                                Organization</strong></label>
                        <div class="input-group">
                            <select name="nature2" id="nature2" class="form-control" disabled>
                                <option value="">Select</option>
                                <option value="Government" {{ ($signup->nature ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                                <option value="Private" {{ ($signup->nature ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                            </select>
                            <input type="hidden" name="nature" id="nature" value="{{$signup->nature}}">
                        </div>
                        <div id="errornature" class="color-red-fourty-three"></div>
                        @if ($errors->has('nature'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('nature') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="email_bank"><strong>E-mail
                                Address of the Organization</strong></label>
                        <div class="input-group">
                            <input type="text" name="email_bank" placeholder="" id = "email_bank"
                            value="{{ $signup->email ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="erroremail_bank" class="color-red-fourty-three"></div>
                        @if ($errors->has('email_bank'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('email_bank') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="contactno"><strong>Contact
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="contactno" placeholder="" id="contactno"
                                value="{{ $signup->contactno ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="errorcontactno" class="color-red-fourty-three"></div>
                        @if ($errors->has('contactno'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('contactno') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="personname"><strong>Name
                                of the Contact Person</strong></label>
                        <div class="input-group">
                            <input type="text" name="personname" placeholder="" id="personname"
                            value="{{ $signup->personname ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="errorpersonname" class="color-red-fourty-three"></div>
                        @if ($errors->has('personname'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('personname') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mobilecontact"><strong>Mobile
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="mobilecontact" placeholder="" id="mobilecontact"
                            value="{{ $signup->mobile ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="errormobilecontact" class="color-red-fourty-three"></div>
                        @if ($errors->has('mobilecontact'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('mobilecontact') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="emailcontact"><strong>E-mail
                                Address</strong></label>
                        <div class="input-group">
                            <input type="text" name="emailcontact" placeholder="" id ="emailcontact"
                            value="{{ $signup->email_contact_person ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="erroremailcontact" class="color-red-fourty-three"></div>
                        @if ($errors->has('emailcontact'))
                            <div class="color-red-fourty-three">
                                <strong>{{ $errors->first('emailcontact') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="fax"><strong>Fax
                                Number</strong></label>
                        <div class="input-group">
                            <input type="text" name="fax" placeholder="" id ="fax"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="website"><strong>Website</strong></label>
                        <div class="input-group">
                            <input type="text" name="website" placeholder="" id="website"
                                 class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>1.
                                Date of establishment of your ART Bank</strong><span
                                class="color-red-fourty-three"></span></label>
                        <div class="input-group">
                            <input type="date" name="dateestab"
                                class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab') }}">
                        </div>
                        <div id="errordatepicker" class="color-red-fourty-three"></div>
                        @if ($errors->has('dateestab'))
                                <div class="color-red-fourty-three">
                                    <strong>{{ $errors->first('dateestab') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div id="otherstaff" class="col-xs-12 form-group" >
                    <label class="control-label" for=""><strong>5. Provide details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <tr>
                                <th width="">Name<span class="color-red-fourty-three">*</span></th>
                                <th width="">Designation<span class="color-red-fourty-three">*</span>
                                </th>
                                <th width="">Qualification<span class="color-red-fourty-three">*</span>
                                </th>
                            </tr>

                            <tr class="staff-row">
                                <td>
                                    <input type="text" id="nameotherstaff"
                                        name="name_otherstaff[]" placeholder=""
                                        class="form-control">
                                        <div id="errornameotherstaff" class="color-red-fourty-three"></div>
                                        @error('name_otherstaff.0')
                                            <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                        @enderror
                                </td>
                                <td>
                                    <select id="designationotherstaff"
                                        name="designation_otherstaff[]" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Registered Medical Practioner">Registered
                                            Medical Practioner</option>
                                        <option value="Any Other">Any Other</option>
                                    </select>
                                    <div id="errordesignation_otherstaff" class="color-red-fourty-three"></div>
                                    @error('designation_otherstaff.0')
                                        <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherpost" name="anyotherpost[]"
                                       value="" placeholder=""
                                        class="form-control csp-clinic-display-none" >
                                        <div id="erroranyotherpost" class="color-red-fourty-three"></div>
                                        @error('anyotherpost.0')
                                            <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                        @enderror
                                </td>

                                <td>
                                    <select id="qualiotherstaff" name="quali_otherstaff[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="Doctorate">Doctorate</option>
                                        <option value="Post Graduate">Post Graduate</option>
                                        <option value="Graduate">Graduate</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Under Graduate">Under Graduate</option>
                                        <option value="Any Other">Any Other</option>
                                    </select>
                                    <div id="errorqualiotherstaff" class="color-red-fourty-three"></div>
                                    @error('quali_otherstaff.0')
                                        <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                    @enderror

                                    <input type="text" id="anyotherdegree"
                                        name="anyotherdegree[]"  value=""
                                        placeholder="" class="form-control csp-clinic-display-none">
                                        <div id="erroranyotherdegree" class="color-red-fourty-three"></div>
                                        @error('anyotherdegree.0')
                                            <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                        @enderror
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                                </td>
                            </tr>
                        </table>
                        <div align="right">
                            <button type="button" name="addotherstaff" id="addotherstaff"
                                class="btn-xs btn-color-border-color-csp-noc-fourty-five">+</button>
                        </div>
                    </div>
                </div>
            </div>











                    <button type="button" class="btn btn-primary btn-color-border-color-csp-noc-fourty-five" id="next-step">Next</button>






                </div>

                            <!-- Step 2 -->
                            <div id="step-2" class="step d-none">
                                        <div class="row">
                                            <h3 class="border-color-csp-noc-fortytwo">Procedures</h3>
                                            <div id="equipment" class="col-xs-12 form-group">
                                                <label class="control-label" for="">6. Provide list of Equipment's</label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="crud_table_equipments">
                                                        <tr>
                                                            <th width="">Name of Equipments<span class="color-red-fourty-three">*</span>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="equipmentname" name="equipmentname[]"
                                                                    placeholder="" class="form-control">
                                                                    <div id="errorequipmentname" class="color-red-fourty-three"></div>
                                                                    @error('equipmentname.0')
                                                                        <div class="color-red-fourty-three"><strong>{{ $message }}</strong></div>
                                                                    @enderror
                                                                    <!-- @if ($errors->has('equipmentname.*'))
                                                                <div class="color-red-fourty-three">
                                                                    <strong>{{ $errors->first('equipmentname.*') }}</strong>
                                                                </div>
                                                            @endif -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div align="right">
                                                        <button type="button" name="addequipment" id="addequipment"
                                                            class="btn-xs btn-color-border-color-csp-noc-fourty-five" >+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>7. Indicate which of the
                                                            following ART
                                                            procedures are being routinely carried out at
                                                            your ART Bank
                                                        </strong></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>i). Collection of Semen
                                                        </strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>a).
                                                        Ejaculation<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="ejaculation" id="ejaculation"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorejaculation" class="color-red-fourty-three"></div>
                                                @if ($errors->has('ejaculation'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('ejaculation') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>
                                                        b). Electroejaculation (in
                                                        case of retrograde ejaculation)<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="electroejaculation" id="electroejaculation"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorelectroejaculation" class="color-red-fourty-three"></div>
                                                @if ($errors->has('electroejaculation'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('electroejaculation') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>ii). Processing of Sperm<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">

                                                    <select name="processingsperm" id="processingsperm"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorprocessingsperm" class="color-red-fourty-three"></div>
                                                @if ($errors->has('processingsperm'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('processingsperm') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>iii). Storage of Sperm<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="storagesperm" id="storagesperm"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorstoragesperm" class="color-red-fourty-three"></div>
                                                @if ($errors->has('storagesperm'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('storagesperm') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>iv). Provision/sourcing of
                                                        Oocyte Donor<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="oocytedonor" id="oocytedonor"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="erroroocytedonor" class="color-red-fourty-three"></div>
                                                @if ($errors->has('oocytedonor'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('oocytedonor') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>5. Cryopreservation of
                                                        Sperm<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="cryopreservation" id="cryopreservation"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorcryopreservation" class="color-red-fourty-three"></div>
                                                @if ($errors->has('cryopreservation'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('cryopreservation') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="control-label" for=""><strong>6. Method of Freezing of
                                                        Sperm
                                                    </strong></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>i). Sperm Slow Freezing<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermslow" id="spermslow"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorspermslow" class="color-red-fourty-three"></div>
                                                @if ($errors->has('spermslow'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('spermslow') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>ii). Sperm Vitrification<span
                                                            class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermvitrification" id="spermvitrification"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorspermvitrification" class="color-red-fourty-three"></div>
                                                @if ($errors->has('spermvitrification'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('spermvitrification') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="validationCustomUsername"><strong>7. Whether Freezing of
                                                        Testicular Tissue<span class="color-red-fourty-three">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="tisticulartissue" id='tisticulartissue'
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errortisticulartissue" class="color-red-fourty-three"></div>
                                                @if ($errors->has('tisticulartissue'))
                                                    <div class="color-red-fourty-three">
                                                        <strong>{{ $errors->first('tisticulartissue') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="field2" class="form-label"><strong>8. Any other
                                                        details</strong></label>
                                                <textarea class="form-control" id="otherdetails" name="otherdetails"
                                                    rows="4" cols="163"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-9 mb-4">
                                                <input type="checkbox" id="declaration" name="declaration">
                                                <b> I hereby declare that the entries in this form and the additional
                                                    particulars , if any,furnished herewith are true to the best of my
                                                    knowledge and belief.<span
                                                        class="color-red-fourty-three">*</span> </b>
                                            </div>
                                        </div>

                                    </div>
                    <button type="button" class="btn btn-secondary btn-color-border-color-csp-noc-fourty-five" id="prev-step">Back</button>
                    <button type="submit" id="submitButton" class="btn btn-success btn-color-border-color-csp-noc-fourty-five">Submit</button>
              </div>
            </form>
</div>
    </div>
</div>
    </div>
</div>
</div>

<script nonce="{{$cspNonce}}">
document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('submitButton');
    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            if (!validatesubmit()) {
                event.preventDefault();
            }
        });
    }
});
</script>
<style nonce="{{$cspNonce}}">
    .step-indicator {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }
    .indicator {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: #e9ecef;
    }
    .indicator.active {
      background-color: #0d6efd;
    }
    .progress-bar {
    background-color: #0d6efd;;
}
  </style>
    <script nonce="{{ $cspNonce }}">
    $('#pincode').blur(function () {
        var pincode = $(this).val();
        if (pincode === "") {
            $('#state').val('');
            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
        } else {
            $.ajax({
                url: "{{ route('pincode.signup') }}",
                method: "POST",
                data: {
                    pincode: pincode,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.success) {
                        $('#state').val(data.state);
                        $('#pincodeavailability').html('');

                        if (data.districts.length > 1) {

                            // If multiple districts, show dropdown
                            let districtDropdown = '<select name="district" id="district" class="form-control">';
                            //    console.log(districtDropdown);
                            districtDropdown += '<option value="">Select District</option>';
                            data.districts.forEach(district => {
                                districtDropdown += `<option value="${district}">${district}</option>`;
                            });
                            districtDropdown += '</select>';
                            $('#district-container').html(districtDropdown);
                        } else if (data.districts.length === 1) {
                            // If only one district, show input field
                            $('#district-container').html(`<input type="text" name="district" id="district" value="${data.districts[0]}" class="form-control" readonly />`);
                        } else {
                            $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                            $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                        }
                    } else {
                        $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                        $('#state').val('');
                        $('#district-container').html('<input type="text" name="district" id="district" placeholder="District" class="form-control" readonly />');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                }
            });
        }
    });
</script>
    <script nonce="{{ $cspNonce }}">
        $('#crud_table_otherstaff').on('change', 'select', function() {
            if ($(this).val() == 'Any Other') {
                //alert("called");
                $(this).parent().find('input').show();
                $(this).parent().find('input').attr('required', '');

            } else {
                $(this).parent().find('input').hide();
                $(this).parent().find('input').removeAttr('required');
            }
        });
        </script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        // Add new row
        $('#addotherstaff').click(function () {
            let newRow = $('#crud_table_otherstaff .staff-row:first').clone();
            newRow.find('input, select').val(''); // Clear input values
            $('#crud_table_otherstaff').append(newRow);
        });

        // Remove a row
        $(document).on('click', '.remove-row', function () {
            if ($('#crud_table_otherstaff .staff-row').length > 1) {
                $(this).closest('tr').remove();
            } else {
                alert("At least one row must be present.");
            }
        });
    });
</script>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            var i = 1;
            $('#addequipment').click(function() {
                i++;
                $('#crud_table_equipments').append('<tr id="row1' + i +
                    '"><td><input type="text" id="equipmentname" name="equipmentname[]"placeholder="" class="form-control"></td><td><button type="button" name="btn_remove_addEQ" id="' +
                    i +
                    '" class="btn btn-danger btn_remove_addEQ"><i class="fa fa fa-trash"></i></button></td></tr>'
                );
            });
            $(document).on('click', '.btn_remove_addEQ', function() {
                var button_id = $(this).attr("id");
                $('#row1' + button_id + '').remove();
            });
        });
        </script>



<script nonce="{{ $cspNonce }}">
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next-step').addEventListener('click', () => {
      step1.classList.add('d-none');
      step2.classList.remove('d-none');
      progressBar.style.width = '100%';
      progressBar.setAttribute('aria-valuenow', '100');
      progressBar.innerText = 'Step 2 of 2';
    });

    document.getElementById('prev-step').addEventListener('click', () => {
      step2.classList.add('d-none');
      step1.classList.remove('d-none');
      progressBar.style.width = '50%';
      progressBar.setAttribute('aria-valuenow', '50');
      progressBar.innerText = 'Step 1 of 2';
    });

    // document.getElementById('form-wizard').addEventListener('submit', (e) => {
    //   e.preventDefault();
    //   alert('Form submitted successfully!');
    // });
  </script>
  <script nonce="{{ $cspNonce }}" type="text/javascript">
    function validateAadhar(input) {
        // Allow only numeric input
        input.value = input.value.replace(/\D/g, '');

        // Ensure the input is not more than 4 digits
        if (input.value.length > 4) {
            input.value = input.value.slice(0, 4);
        }
    }
    </script>







                            {{-- <script nonce="{{ $cspNonce }}">
                            $('#transfer').on('change', function() {
                                if (this.value == 'outside_india') {
                                    $("#copy_passport_spouse1").show();
                                } else {
                                    $("#copy_passport_spouse1").hide();
                                }
                            });

                            var refreshButton = document.querySelector(".refresh-captcha");
                            refreshButton.onclick = function() {
                                document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
                            }
                            </script> --}}

                                {{-- <script nonce="{{ $cspNonce }}">
                                //var _validFilepdf = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];
                                var _validFilepdf = [".pdf"];
                                function validateForSizepdf(oInput, minSize, maxSizepdf) {
                                    //if there is a need of specifying any other type, just add that particular type in var  _validFilejpeg
                                    if (oInput.type == "file") {
                                        var sFileName = oInput.value;
                                        if (sFileName.length > 0) {
                                            var blnValid = false;
                                            for (var j = 0; j < _validFilepdf.length; j++) {
                                                var sCurExtension = _validFilepdf[j];
                                                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length)
                                                    .toLowerCase() == sCurExtension.toLowerCase()) {
                                                    blnValid = true;
                                                    break;
                                                }
                                            }

                                            if (!blnValid) {
                                                alert("Sorry, this file is invalid, allowed extension is: " + _validFilepdf.join(", "));
                                                oInput.value = "";
                                                return false;
                                            }
                                        }
                                    }

                                    fileSizeValidatepdf(oInput, minSize, maxSizepdf);
                                }

                                function fileSizeValidatepdf(fdata, minSize, maxSizepdf) {
                                    if (fdata.files && fdata.files[0]) {
                                        var fsize = fdata.files[0].size /
                                            1024; //The files property of an input element returns a FileList. fdata is an input element,fdata.files[0] returns a File object at the index 0.
                                        //alert(fsize)
                                        if (fsize > maxSizepdf || fsize < minSize) {
                                            alert('This file size is: ' + fsize.toFixed(2) +
                                                "KB. Files should be in " + (minSize) + " to " + (maxSizepdf) + " KB ");
                                            fdata.value = ""; //so that the file name is not displayed on the side of the choose file button
                                            return false;
                                        } else {
                                            console.log("");
                                        }
                                    }
                                }
                                </script>
                                <script nonce="{{ $cspNonce }}">
                                var _validFilejpeg = [".pdf", ".jpeg", ".jpg", ".bmp", ".gif", ".png"];

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
                                </script> --}}
                                <script nonce="{{ $cspNonce }}">
                                    function validatesubmit() {
                                        //alert('test1');
                                        const art_form_elements = ['clinicname','address','pincode','nature','email_bank','contactno','personname','mobilecontact','emailcontact'];
                                        for (let elements of art_form_elements) {
                                            //alert(elements);
                                            let el = document.getElementById(elements);
                                            //alert(el);
                                            const name = el.name || el.id || 'Unnamed field';
                                            let errorDiv1 = document.getElementById("error".concat(el.id));
                                            // Skip button
                                            if (el.type === 'submit' || el.type === 'button' || el.type === 'checkbox' || el.type === 'radio') continue;

                                            if (el.tagName === 'SELECT') {
                                                //alert("test select" + elements);
                                                if (!el.value) {

                                                    errorDiv1.innerHTML = "please select the above";
                                                    //el.focus()
                                                    if (el.id === 'nature'){
                                                        alert(`nature of the organization is not selected.`);
                                                        return false;
                                                     } else {
                                                    alert(`${name} is not selected.`);
                                                    return false;
                                                     }
                                                }
                                                else{
                                                    errorDiv1.innerHTML='';
                                                }
                                            } else if (el.tagName === 'TEXTAREA' ||
                                                        el.type === 'text' ||
                                                        el.type === 'date' ||
                                                        el.type === 'email' ||
                                                        el.type === 'number') {
                                                            //alert("test others" + elements);
                                                            if (el.value.trim() === '') {
                                                                let errorId1 = "error".concat(el.id);
                                                                let errorDiv1 = document.getElementById(errorId1);
                                                                if(el.name === 'email_clinic'){
                                                                    alert(`email of the clinic is empty.`);
                                                                    errorDiv1.innerHTML = "please fill the above";
                                                                    return false;
                                                                }
                                                                errorDiv1.innerHTML = "please fill the above";
                                                                alert(`${name} is empty.`);
                                                                return false;
                                                            }
                                                            else{
                                                                errorDiv1.innerHTML='';
                                                            }
                                            }
                                        }
                                       // Check if Clinic Level is selected


                                        let datepicker = document.getElementById("datepicker").value;
                                        let errorDiv1 = document.getElementById("errordatepicker");

                                        if (datepicker === "") {
                                            errorDiv1.innerHTML = "Date of establishment of your ART Clinic cannot be blank";
                                            alert("Date of establishment of your ART Clinic cannot be blank");
                                            document.getElementById("datepicker").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }
                                        else {
                                            errorDiv1.innerHTML = ""; // Clear error message if valid
                                        }
                                        let nameotherstaff = document.getElementById("nameotherstaff").value;
                                        let errorDiv2 = document.getElementById("errornameotherstaff");

                                        if (nameotherstaff === "") {
                                            errorDiv2.innerHTML = "Name of staff cannot be blank";
                                            alert("Name of staff cannot be blank");
                                            document.getElementById("nameotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv2.innerHTML = ""; // Clear error message if valid
                                        }
                                        let designationotherstaff = document.getElementById("designationotherstaff").value;
                                        let errorDiv3 = document.getElementById("errordesignation_otherstaff");

                                        if (designationotherstaff === "") {
                                            errorDiv3.innerHTML = "Designation of staff cannot be blank";
                                            alert("Designation of staff cannot be blank");
                                            document.getElementById("designationotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv3.innerHTML = ""; // Clear error message if valid
                                        }
                                        let qualiotherstaff = document.getElementById("qualiotherstaff").value;
                                        let errorDiv4 = document.getElementById("errorqualiotherstaff");

                                        if (qualiotherstaff === "") {
                                            errorDiv4.innerHTML = "Qualification of staff cannot be blank";
                                            alert("Qualification of staff cannot be blank");
                                            document.getElementById("qualiotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv4.innerHTML = ""; // Clear error message if valid
                                        }
                                        let anyotherpost = document.getElementById("anyotherpost").value;
                                        let errorDiv5 = document.getElementById("erroranyotherpost");
                                        if ((designationotherstaff === "Any Other") && (anyotherpost ==="")) {
                                            errorDiv5.innerHTML = "Designation of the other Post cannot be blank";
                                            alert("Designation of the other Post cannot be blank");
                                            document.getElementById("anyotherpost").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv5.innerHTML = ""; // Clear error message if valid
                                        }
                                        let anyotherdegree = document.getElementById("anyotherdegree").value;
                                        let errorDiv6 = document.getElementById("erroranyotherdegree");
                                        if ((qualiotherstaff === "Any Other") && (anyotherdegree ==="")) {
                                            errorDiv6.innerHTML = "Qualification of the other Post cannot be blank";
                                            alert("Qualification of the other Post cannot be blank");
                                            document.getElementById("anyotherdegree").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv6.innerHTML = ""; // Clear error message if valid
                                        }

                                        let equipmentname = document.getElementById("equipmentname").value;
                                        let errorDiv7 = document.getElementById("errorequipmentname");
                                        if (equipmentname === "") {
                                            errorDiv7.innerHTML = "Name of equipment cannot be blank";
                                            alert("Name of equipment cannot be blank");
                                            document.getElementById("equipmentname").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv7.innerHTML = ""; // Clear error message if valid
                                        }
                                        let ejaculation = document.getElementById("ejaculation").value;
                                        let errorDiv8 = document.getElementById("errorejaculation");
                                        if (ejaculation === "") {
                                            errorDiv8.innerHTML = "Ejaculation cannot be blank";
                                            alert("Ejaculation cannot be blank");
                                            document.getElementById("ejaculation").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv8.innerHTML = ""; // Clear error message if valid
                                        }
                                        let electroejaculation = document.getElementById("electroejaculation").value;
                                        let errorDiv9 = document.getElementById("errorelectroejaculation");
                                        if (electroejaculation === "") {
                                            errorDiv9.innerHTML = "Electroejaculation (in case of retrograde ejaculation) cannot be blank";
                                            alert("Electroejaculation (in case of retrograde ejaculation) cannot be blank");
                                            document.getElementById("electroejaculation").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv9.innerHTML = ""; // Clear error message if valid
                                        }
                                        let processingsperm = document.getElementById("processingsperm").value;
                                        let errorDiv10 = document.getElementById("errorprocessingsperm");
                                        if (processingsperm === "") {
                                            errorDiv10.innerHTML = "Processing of Sperm cannot be blank";
                                            alert("Processing of Sperm cannot be blank");
                                            document.getElementById("processingsperm").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv10.innerHTML = ""; // Clear error message if valid
                                        }
                                        let storagesperm = document.getElementById("storagesperm").value;
                                        let errorDiv11 = document.getElementById("errorstoragesperm");
                                        if (storagesperm === "") {
                                            errorDiv11.innerHTML = "Storage of Sperm cannot be blank";
                                            alert("Storage of Sperm cannot be blank");
                                            document.getElementById("storagesperm").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv11.innerHTML = ""; // Clear error message if valid
                                        }
                                        let oocytedonor = document.getElementById("oocytedonor").value;
                                        let errorDiv12 = document.getElementById("erroroocytedonor");
                                        if (oocytedonor === "") {
                                            errorDiv12.innerHTML = "Provision/sourcing of Oocyte Donor cannot be blank";
                                            alert("Provision/sourcing of Oocyte Donor cannot be blank");
                                            document.getElementById("oocytedonor").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv12.innerHTML = ""; // Clear error message if valid
                                        }
                                        let cryopreservation = document.getElementById("cryopreservation").value;
                                        let errorDiv13 = document.getElementById("errorcryopreservation");
                                        if (cryopreservation === "") {
                                            errorDiv13.innerHTML = "Cryopreservation of Sperm cannot be blank";
                                            alert("Cryopreservation of Sperm cannot be blank");
                                            document.getElementById("cryopreservation").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv13.innerHTML = ""; // Clear error message if valid
                                        }
                                        let spermslow = document.getElementById("spermslow").value;
                                        let errorDiv14 = document.getElementById("errorspermslow");
                                        if (spermslow === "") {
                                            errorDiv14.innerHTML = "Sperm Slow Freezing cannot be blank";
                                            alert("Sperm Slow Freezing cannot be blank");
                                            document.getElementById("spermslow").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv14.innerHTML = ""; // Clear error message if valid
                                        }
                                        let spermvitrification = document.getElementById("spermvitrification").value;
                                        let errorDiv15 = document.getElementById("errorspermvitrification");
                                        if (spermvitrification === "") {
                                            errorDiv15.innerHTML = "Sperm Vitrification cannot be blank";
                                            alert("Sperm Vitrification cannot be blank");
                                            document.getElementById("spermvitrification").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv15.innerHTML = ""; // Clear error message if valid
                                        }
                                        let tisticulartissue = document.getElementById("tisticulartissue").value;
                                        let errorDiv16 = document.getElementById("errortisticulartissue");
                                        if (tisticulartissue === "") {
                                            errorDiv16.innerHTML = "Whether Freezing of Testicular Tissue cannot be blank";
                                            alert("Whether Freezing of Testicular Tissue cannot be blank");
                                            document.getElementById("tisticulartissue").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv16.innerHTML = ""; // Clear error message if valid
                                        }



                                        // if (document.getElementById("datepicker").value == "") {
                                        //     alert("1. Date of establishment of your ART Bank cannot be blank");
                                        //     document.getElementById("datepicker").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("nameotherstaff").value == "") {
                                        //     alert("2. Name of staff cannot be blank");
                                        //     document.getElementById("nameotherstaff").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("designationotherstaff").value == "") {
                                        //     alert("2. Designation of staff cannot be blank");
                                        //     document.getElementById("designationotherstaff").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("qualiotherstaff").value == "") {
                                        //     alert("2. Qualification of staff cannot be blank");
                                        //     document.getElementById("qualiotherstaff").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("equipmentname").value == "") {
                                        //     alert("3. Name of equipment cannot be blank");
                                        //     document.getElementById("equipmentname").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("ejaculation").value == "") {
                                        //     alert("4.1 (i) Ejaculation cannot be blank");
                                        //     document.getElementById("ejaculation").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("electroejaculation").value == "") {
                                        //     alert("4.1 (ii) Electroejaculation (in case of retrograde ejaculation)  cannot be blank");
                                        //     document.getElementById("electroejaculation").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("processingsperm").value == "") {
                                        //     alert("4.2 Processing of Sperm cannot be blank");
                                        //     document.getElementById("processingsperm").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("storagesperm").value == "") {
                                        //     alert("4.3 Storage of Sperm not be blank");
                                        //     document.getElementById("icsi").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("oocytedonor").value == "") {
                                        //     alert("4.4 Provision/sourcing of Oocyte Donor cannot be blank");
                                        //     document.getElementById("oocytedonor").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("cryopreservation").value == "") {
                                        //     alert("5. Cryopreservation of Sperm cannot be blank");
                                        //     document.getElementById("cryopreservation").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("spermslow").value == "") {
                                        //     alert("6.1 Sperm Slow Freezing not be blank");
                                        //     document.getElementById("spermslow").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("spermvitrification").value == "") {
                                        //     alert("6.2 Sperm Vitrification cannot be blank");
                                        //     document.getElementById("spermvitrification").focus();
                                        //     return false;
                                        // }
                                        // if (document.getElementById("tisticulartissue").value == "") {
                                        //     alert("7. Whether Freezing of Testicular Tissue cannot be blank");
                                        //     document.getElementById("tisticulartissue").focus();
                                        //     return false;
                                        // }
                                        if (!document.getElementById("declaration").checked) {
                                            alert("Declaration cannot be blank");
                                            document.getElementById("declaration").focus();
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
                                        return true;
                                    }
                                    </script>
                                {{-- <script nonce="{{ $cspNonce }}">
                                    $('#pincode').blur(function() {
                                        var pincode = $(this).val();
                                        if (pincode === "") {
                                            $('#state').val('');
                                            $('#district').val('');
                                            $('#pincodeavailability').html('<span class="text-danger">Please enter a valid Pincode.</span>');
                                        } else {
                                            $.ajax({
                                                url: "{{ route('pincode.check') }}", // Laravel route
                                                method: "POST",
                                                data: {
                                                    pincode: pincode,
                                                    _token: "{{ csrf_token() }}" // CSRF token for security
                                                },
                                                success: function(data) {
                                                    if (data.success) {
                                                        $('#state').val(data.state);
                                                        $('#district').val(data.district);
                                                        $('#pincodeavailability').html('');
                                                    } else {
                                                        $('#pincodeavailability').html('<span class="text-danger">Invalid Pincode.</span>');
                                                        $('#state').val('');
                                                        $('#district').val('');
                                                    }
                                                }
                                            });
                                        }
                                    });
                                </script> --}}




    {{-- <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            $('#to_status_clinic, #to_status_from_clinic').on('change', function() {
                var clinicType = $('#to_status_clinic').val();
                var statusType = $('#to_status_from_clinic').val();

                if (clinicType && statusType) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('noc.fetchClinicData') }}',
                        data: {
                            clinic_type: clinicType,
                            status_type: statusType,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('.abc').empty().append(data);
                            $('.xyz').empty().append(data);
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: ", error);
                        }
                    });
                } else {
                    $('.abc, .xyz').html('<option value="">Select</option>');
                }
            });

            $('#status_clinic, #status_from_clinic').on('change', function() {
                var clinicType = $('#status_clinic').val();
                var statusType = $('#status_from_clinic').val();

                if (clinicType && statusType) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('noc.fetchClinicDataFrom') }}',
                        data: {
                            clinic_type: clinicType,
                            status_type: statusType,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('.def').empty().append(data);
                            $('.ghi').empty().append(data);
                        },
                        error: function(xhr, status, error) {
                            console.log("AJAX Error: ", error);
                        }
                    });
                } else {
                    $('.def, .ghi').html('<option value="">Select</option>');
                }
            });
        });
    </script>
<script nonce="{{ $cspNonce }}">
$(document).ready(function () {
    $('#to_name_clinic').change(function () {
        //console.log('hello');
        //alert('check 1');
        var clinicType = $('#to_status_clinic').val();
        var statusType = $('#to_status_from_clinic').val();
        var to_name_clinic_fetch_reg = $('#to_name_clinic').val();

        console.log(to_name_clinic_fetch_reg);
        if (to_name_clinic_fetch_reg === '') {
            $('#to_clinic_hide_show').hide();
            $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno').val('');
        } else {
            $('#to_clinic_hide_show').show();

            $.ajax({
                url: '{{ route('noc.fetchClinicDetails') }}',
                method: 'POST',
                data: {
                    to_name_clinic_fetch_reg: to_name_clinic_fetch_reg,
                    clinicType: clinicType,
                    statusType: statusType,
                     _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    $('#to_address').val(data.address || '');
                    $('#t_pincode').val(data.pincode || '');
                    $('#t_state').val(data.state || '');
                    $('#t_district').val(data.district || '');
                    $('#t_email').val(data.email || '');
                    $('#t_contact').val(data.contactno || '');
                    $('#to_regno').val(data.registration_no || '');
                    $('#to_applicationno').val(data.application_no || '');
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    });

    $('#to_name_clinic1').change(function () {
        var clinicType = $('#to_status_clinic').val();
        var statusType = $('#to_status_from_clinic').val();
        var to_name_clinic_fetch_app = $('#to_name_clinic1').val();

        if (to_name_clinic_fetch_app === '') {
            $('#to_clinic_hide_show').hide();
            $('#to_address, #t_pincode, #t_state, #t_district, #t_email, #t_contact, #to_regno, #to_applicationno').val('');
        } else {
            $('#to_clinic_hide_show').show();

            $.ajax({
                url: '{{ route('noc.fetchClinicApplicationDetails') }}',
                method: 'POST',
                data: {
                    to_name_clinic_fetch_app: to_name_clinic_fetch_app,
                    clinicType: clinicType,
                    statusType: statusType,
                     _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    $('#to_address').val(data.address || '');
                    $('#t_pincode').val(data.pincode || '');
                    $('#t_state').val(data.state || '');
                    $('#t_district').val(data.district || '');
                    $('#t_email').val(data.email || '');
                    $('#t_contact').val(data.contactno || '');
                    $('#to_regno').val(data.registration_no || '');
                    $('#to_applicationno').val(data.applicationno || '');
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    });
});
</script>
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        $('#from_name_clinic').change(function() {

            var clinicType = $('#status_clinic').val();
            var statusType = $('#status_from_clinic').val();
            var from_name_clinic_fetch_reg = $('#from_name_clinic').val();

            console.log(statusType);
            console.log(from_name_clinic_fetch_reg);
            if (from_name_clinic_fetch_reg === '') {
                $('#from_address').val('');
                $('#f_pincode').val('');
                $('#f_state').val('');
                $('#f_district').val('');
                $('#f_email').val('');
                $('#f_contact').val('');
                $('#from_regno').val('');
                $('#from_applicationno').val('');
            } else {
                $.ajax({
                    url: '{{ route('noc.fetchClinicDataFromm') }}',
                    method: 'POST',
                    data: {
                        from_name_clinic_fetch_reg: from_name_clinic_fetch_reg,
                        clinicType: clinicType,
                        statusType: statusType,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#from_address').val(data.address || '');
                        $('#f_pincode').val(data.pincode || '');
                        $('#f_state').val(data.state || '');
                        $('#f_district').val(data.district || '');
                        $('#f_email').val(data.email || '');
                        $('#f_contact').val(data.contactno || '');
                        $('#from_regno').val(data.registration_no || '');
                        $('#from_applicationno').val(data.application_no || '');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });

        $('#from_name_clinic1').change(function() {
            var clinicType = $('#status_clinic').val();
            var statusType = $('#status_from_clinic').val();
            var from_name_clinic_fetch_app = $('#from_name_clinic1').val();


            if (from_name_clinic_fetch_app === '') {
                $('#from_address').val('');
                $('#f_pincode').val('');
                $('#f_state').val('');
                $('#f_district').val('');
                $('#f_email').val('');
                $('#f_contact').val('');
                $('#from_regno').val('');
                $('#from_applicationno').val('');
            } else {
                $.ajax({
                    url: '{{ route('noc.nocClinicFetchAppFrom') }}',
                    method: 'POST',
                    data: {
                        from_name_clinic_fetch_app: from_name_clinic_fetch_app,
                        clinicType: clinicType,
                        statusType: statusType,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#from_address').val(data.address || '');
                        $('#f_pincode').val(data.pincode || '');
                        $('#f_state').val(data.state || '');
                        $('#f_district').val(data.district || '');
                        $('#f_email').val(data.email || '');
                        $('#f_contact').val(data.contactno || '');
                        $('#from_regno').val(data.registration_no || '');
                        $('#from_applicationno').val(data.applicationno || '');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }
        });
    });
    </script> --}}




@endsection