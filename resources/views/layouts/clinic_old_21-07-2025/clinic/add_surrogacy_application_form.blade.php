@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{$cspNonce}}">
    .display-none-csp-clinic-one{
    display:none;
    }
    .color-csp-clinic-two{
        color: red;
    }
    .bc-bc-color-csp-clinic-three{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .bc-color-csp-clinic-four{
        border-color: #0b5ed7; color: #0b5ed7;
    }

.height-csp-clinic-five{
    height: 20px;
    
}
.width-csp-clinic-six{
    width: 70%;
}

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




<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">       
            <div class="card-body">  
                @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

            <h3>Application Form for Surrogacy Clinic</h3>
            <!-- Progress Bar -->
  <div class="progress mb-4 height-csp-clinic-five" >
    <div 
      id="progress-bar" 
      class="progress-bar progress-bar-striped progress-bar-animated" 
      role="progressbar" 
     class="width-csp-clinic-six"
      aria-valuenow="50" 
      aria-valuemin="0" 
      aria-valuemax="100">
      Step 1 of 2
    </div>
  </div>
            
            <!-- Form -->
            <form id="surrogacy_clinicform" method="POST" action="{{ route('clinic.save_sclinic_application_form') }}" enctype="multipart/form-data">
              <!-- Step 1 -->
              @csrf
              <div id="step-1" class="step">
                <div class="row">
                    <h3 class=" bc-color-csp-clinic-four" >General Information and Staff Details</h3>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="control-label" for="clinicname"><strong>Name of the Clinic</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input id="clinicname" name="clinicname" placeholder="Name of Clinic" class="form-control" value="{{ $signup->clinicname ?? '' }}"
                                type="text" readonly> 
                        </div>
                        <div id="errorclinicname" class="color-csp-clinic-two"></div>
                        @if ($errors->has('clinicname'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('clinicname') }}</strong>
                            </div>
                        @endif
                    </div>

                     
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="address"><strong>Address</strong><span
                            class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="address" id="address" placeholder="Address" value="{{ $signup->address ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                        <div id="erroraddress" class="color-csp-clinic-two"></div>
                        @if ($errors->has('address'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pincode"><strong>Pincode</strong><span
                            class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="pincode" placeholder="pincode" id="pincode" pattern="^[0-9]{6}$"
                                value="{{ $signup->pincode ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                        <span id="pincodeavailability"></span>
                        <div id="errorpincode" class="color-csp-clinic-two"></div>
                        @if ($errors->has('pincode'))
                            <div class="color-csp-clinic-two">
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
                            <input type="text" name="state" placeholder="State" id="state"
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
                            <input type="text" name="district" placeholder="District" id="district" 
                                value="{{ $signup->district ?? '' }}"
                                class="form-control border-left-end" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="nature"><strong>Nature
                                of the
                                Organization</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <select name="nature2" id="nature2" class="form-control" disabled>
                                <option value="">Select</option>
                                <option value="Government" {{ ($signup->nature ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                                <option value="Private" {{ ($signup->nature ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                            </select>
                            <input type="hidden" name="nature" id="nature" value="{{$signup->nature}}">
                        </div>
                        <div id="errornature" class="color-csp-clinic-two"></div>
                        @if ($errors->has('nature'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('nature') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="email_clinic"><strong>E-mail
                                Address the clinic</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="email" name="email_clinic" placeholder="Email" id="email_clinic"
                            value="{{ $signup->email ?? '' }}" class="form-control"
                                readonly>
                        </div>
                        <div id="erroremail_clinic" class="color-csp-clinic-two"></div>
                        @if ($errors->has('email_clinic'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('email_clinic') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="contactno"><strong>Contact
                                Number</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="contactno" placeholder="contact number should be 11 numbers" id="contactno"
                                value="{{ old('contactno', $signup->contactno ?? '') }}" class="form-control" pattern="^[0-9]{11}$" maxlength="11" readonly>
                        </div>
                        <div id="errorcontactno" class="color-csp-clinic-two"></div>
                        @if ($errors->has('contactno'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('contactno') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="personname"><strong>Name
                                of the Contact Person</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="personname" placeholder="Name of contact Person" id="personname"
                            value="{{ $signup->personname ?? '' }}" class="form-control" pattern="[A-Za-z]*" title="Only alphabetic characters are allowed" readonly>
                        </div>
                        <div id="errorpersonname" class="color-csp-clinic-two"></div>
                        @if ($errors->has('personname'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('personname') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mobilecontact"><strong>Mobile
                                Number</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="mobilecontact" placeholder="contact mobile number" id="mobilecontact"
                            value="{{ $signup->mobile ?? '' }}" class="form-control" pattern="^[0-9]{10}$" maxlength="10" readonly>
                        </div>
                        <div id="errormobilecontact" class="color-csp-clinic-two"></div>
                        @if ($errors->has('mobilecontact'))
                            <div class="color-csp-clinic-two">
                                <strong>{{ $errors->first('mobilecontact') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="emailcontact"><strong>E-mail
                            Address</strong><span
                            class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="text" name="emailcontact" placeholder="Enter a email address.." id = "emailcontact"
                            value="{{ $signup->email ?? '' }}" class="form-control" readonly>
                        </div>
                        <div id="erroremailcontact" class="color-csp-clinic-two"></div>
                        @if ($errors->has('emailcontact'))
                            <div class="color-csp-clinic-two">
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
                            <input type="text" name="fax" placeholder="enter the fax number" id="fax"
                                class="form-control" value="{{ old('fax') }}">
                              
                        </div> 
                         <!-- @if ($errors->has('fax'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('fax') }}</strong>
                                </div>
                            @endif -->
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="website"><strong>Website</strong></label>
                        <div class="input-group">
                            <input type="text" name="website" placeholder="enter the website" id="website"
                                 class="form-control" value="{{ old('website') }}">
                               
                        </div>
                          <!-- @if ($errors->has('website'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('website') }}</strong>
                                </div>
                            @endif -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>1.
                                Date of establishment of your Surrogacy Clinic</strong><span
                                class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <input type="date" name="dateestab" 
                                class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab') }}">
                        </div>
                        <div id="errordatepicker" class="color-csp-clinic-two"></div>
                        @if ($errors->has('dateestab'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('dateestab') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mtpact"><strong>2.
                                Whether your Surrogacy Clinic is registered under MTP
                                Act</strong><span class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <select name="mtpact" id="mtpact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('mtpact') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('mtpact') == 'No' ? 'selected' : '' }}>No</option>
                            </select>

                        </div>
                        <div id="errormtpact" class="color-csp-clinic-two"></div>
                        @if ($errors->has('mtpact'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('mtpact') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pcpndtact"><strong>3.
                                Whether your Surrogacy Clinic is registered under PCPNDT
                                Act</strong><span class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <select name="pcpndtact" id="pcpndtact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('pcpndtact') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('pcpndtact') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                         
                        </div>
                        <div id="errorpcpndtact" class="color-csp-clinic-two"></div>
                        @if ($errors->has('pcpndtact'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('pcpndtact') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="director"><strong>4.Whether your Surrogacy Clinic has
                                Director</strong><span class="color-csp-clinic-two">*</span></label>
                        <div class="input-group">
                            <select id="director" name="director"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div id="errordirector" class="color-csp-clinic-two"></div>
                        @if ($errors->has('director'))
                                <div class="color-csp-clinic-two">
                                    <strong>{{ $errors->first('director') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>







                
                <div id="directory" class="col-xs-12 form-group display-none-csp-clinic-one" >
                    <div class="table-responsive">

                        <table class="table table-bordered" id="crud_table_director">
                            <tr>
                                <th width="">Name<span class="color-csp-clinic-two">*</span></th>
                                <th width="">Qualification<span class="color-csp-clinic-two">*</span>
                                </th>
                                <th width="">Registration No. (if applicable)</th>
                                <th></th>
                            </tr>                           
                            <tr class="staff-row">
                                <td>
                                    <input type="text" id="namedirector" name="name_director[]"
                                        placeholder="" class="form-control">
                                        <div id="errornamedirector" class="color-csp-clinic-two"></div>
                                        @if ($errors->has('name_director.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('name_director.*') }}</strong>
                                    </div>
                                @endif
                                </td>
                                <td>
                                    <select id="quali_director" name="quali_director[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="PhD">Ph.D</option>
                                        <option value="DM">DM</option>
                                        <option Value="MCh">M.Ch</option>
                                        <option Value="PG">PG</option>
                                        <option Value="MD">MD</option>
                                        <option Value="MS">MS</option>
                                        <option Value="DNB">DNB</option>
                                    </select>
                                    <div id="errorquali_director" class="color-csp-clinic-two"></div>
                                    @if ($errors->has('quali_director.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('quali_director.*') }}</strong>
                                    </div>
                                @endif
                                </td>
                                <td>
                                    <input type="text" id="regdirector" name="reg_director[]"
                                        placeholder="" class="form-control">
                                </td>
                                <td>
                                    {{-- <button type="button" class="btn btn-danger btn-sm remove-row">-</button> --}}
                                </td>

                            </tr>                           
                        </table>
                        <div align="right">
                            <button type="button" name="adddirector" id="adddirector" 
                                class="btn-xs bc-bc-color-csp-clinic-three"><i class="fa fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div id="otherstaff" class="col-xs-12 form-group">
                    <label class="control-label" for=""><strong>5. Provide details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <tr>
                                <th width="">Name of the Post<span class="color-csp-clinic-two">*</span></th>
                                <th width="">Name of the Staff<span class="color-csp-clinic-two">*</span></th>
                                <th width="">Qualification<span class="color-csp-clinic-two">*</span></th>
                                <th width="">Registration No (if applicable)</th>
                            </tr>                           
                            <tr class="staff-row">
                                <td>
                                    <select id="postotherstaff" name="post_otherstaff[]"
                                        class="form-control">
                                        <option value="">Select</option>
                                        <option value="Gynecologist">Gynecologist</option>
                                        <option value="Andrologist">Andrologist</option>
                                        <option value="Clinical Embryologist">Clinical
                                            Embryologist</option>
                                        <option value="Counselor">Counselor</option>
                                        <option value="Anesthetist">Anesthetist</option>
                                        <option value="Any Other">Any Other</option>

                                    </select>
                                    <div id="errorpostotherstaff" class="color-csp-clinic-two"></div>
                                    @error('post_otherstaff.0')
                                        <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherpost" name="anyotherpost[]"
                                                                 value="" placeholder=""
                                                                class="form-control display-none-csp-clinic-one">
                                    <div id="erroranyotherpost" class="color-csp-clinic-two"></div>
                                    @error('anyotherpost.0')
                                            <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    <!-- @if ($errors->has('post_otherstaff.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('post_otherstaff.*') }}</strong>
                                    </div>
                                @endif -->
                                    <!-- <input type="text" id="anyotherpost" name="anyotherpost[]"
                                        style="display:none" placeholder=""
                                        class="form-control">
                                      -->
                                </td>

                                <td>
                                    <input type="text" id="nameotherstaff" name="name_otherstaff[]" placeholder=""  class="form-control">
                                    <div id="errornameotherstaff" class="color-csp-clinic-two"></div>
                                    <!-- @if ($errors->has('name_otherstaff.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('name_otherstaff.*') }}</strong>
                                    </div>
                                @endif -->
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
                                    <div id="errorqualiotherstaff" class="color-csp-clinic-two"></div>
                                    @error('quali_otherstaff.0')
                                        <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                    @enderror
                                    <input type="text" id="anyotherdegree"
                                    name="anyotherdegree[]"  value=""
                                    placeholder="" class="form-control display-none-csp-clinic-one">
                                    <div id="erroranyotherdegree" class="color-csp-clinic-two"></div>
                                    @error('anyotherdegree.0')
                                            <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                        @enderror
                                    <!-- @if ($errors->has('quali_otherstaff.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('quali_otherstaff.*') }}</strong>
                                    </div>
                                @endif -->
                                    <!-- <input type="text" id="anyotherdegree"
                                        name="anyotherdegree[]" style="display:none" value=""
                                        placeholder="" class="form-control"> -->
                                </td>
                                <td>
                                    <input type="text" id="regno" name="regno[]" placeholder=""
                                        class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </table>
                        <div align="right">
                            <button type="button" name="addotherstaff" id="addotherstaff"
                                class="btn-xs bc-bc-color-csp-clinic-three" >+</button>
                        </div>
                    </div>
                </div>
            </div>
                    <button type="button" class="btn btn-primary bc-bc-color-csp-clinic-three"  id="next-step">Next</button>
                  </div>
              
                            <!-- Step 2 -->
                            <div id="step-2" class="step d-none">
                                        <div class="row">
                                            <h3 class=" bc-color-csp-clinic-four" >Procedures</h3>
                                            <div id="equipment" class="col-xs-12 form-group">
                                                <label class="control-label" for="">6. Provide list of Equipment's</label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="crud_table_equipments">
                                                        <tr>
                                                            <th width="">Name of Equipments<span class="color-csp-clinic-two">*</span>
                                                            </th>
                                                        </tr>                                                       
                                                        <tr>
                                                            <td>
                                                                <input type="text" id="equipmentname" name="equipmentname[]"
                                                                    placeholder="" class="form-control">
                                                                    <div id="errorequipmentname" class="color-csp-clinic-two"></div>
                                                                    @error('equipmentname.0')
                                                                        <div class="color-csp-clinic-two"><strong>{{ $message }}</strong></div>
                                                                    @enderror
                                                                    <!-- @if ($errors->has('equipmentname.*'))
                                                                <div class="color-csp-clinic-two">
                                                                    <strong>{{ $errors->first('equipmentname.*') }}</strong>
                                                                </div>
                                                            @endif -->
                                                            </td>
                                                        </tr>                                                       
                                                    </table>
                                                    <div align="right">
                                                        <button type="button" name="addequipment" id="addequipment"
                                                            class="btn-xs bc-bc-color-csp-clinic-three">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>7. Indicate which of the
                                                            following ART
                                                            procedures are being routinely carried out at
                                                            your Surrogacy Clinic
                                                        </strong></label>
                                                </div>
                                            </div>
                                            <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="iuih"><strong>i).
                                                        Intra-uterine Insemination using Husband Semen (IUI-H)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuih" id="iuih"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                   
                                                </div>
                                                <div id="erroriuih" class="color-csp-clinic-two"></div>
                                                @if ($errors->has('iuih'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('iuih') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="iuid"><strong>ii).
                                                        Intra-uterine Insemination using
                                                        Donor Semen (IUI-D)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuid" id="iuid"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                   
                                                </div>
                                                <div id="erroriuid" class="color-csp-clinic-two"></div>
                                                @if ($errors->has('iuid'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('iuid') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="ivfet"><strong>iii). In vitro
                                                        Fertilization-Embryo
                                                        Transfer (IVF-ET)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">

                                                    <select name="ivfet" id="ivfet"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                   
                                                </div>
                                                <div id="errorivfet" class="color-csp-clinic-two"></div>
                                                 @if ($errors->has('ivfet'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('ivfet') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="icsi"><strong>iv).
                                                        Intra-cytoplasmic Sperm Injection (ICSI)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="icsi" id="icsi"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                  
                                                </div>
                                                <div id="erroricsi" class="color-csp-clinic-two"></div>
                                                 @if ($errors->has('icsi'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('icsi') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="pgt"><strong>v).
                                                        Pre-implantation Genetic Testing (PGT)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="pgt" id="pgt"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorpgt" class="color-csp-clinic-two"></div>
                                                @if ($errors->has('pgt'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('pgt') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="spermandoocyte"><strong>vi).
                                                        Processing or Storage of Gametes (sperm & oocyte)of the Patient
                                                        and
                                                        or embryos of patient<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermandoocyte" id="spermandoocyte"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="errorspermandoocyte" class="color-csp-clinic-two"></div>
                                                @if ($errors->has('spermandoocyte'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('spermandoocyte') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="anyotherprocedure"><strong>vii). Any Other Procedure<span class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="anyotherprocedure" id='anyotherprocedure'
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                                <div id="erroranyotherprocedure" class="color-csp-clinic-two"></div>
                                                @if ($errors->has('anyotherprocedure'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('anyotherprocedure') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 display-none-csp-clinic-one" id='anyotherprocedurey' >
                                                <label class="text-label form-label"
                                                    for="otherprocedure"><strong>If yes, please specify<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <input type="text" id="otherprocedure" name="otherprocedure"
                                                        placeholder="" class="form-control">
                                                </div>
                                                <div id="errorotherprocedure" class="color-csp-clinic-two"></div>                                      
                                                @if ($errors->has('otherprocedure.*'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('otherprocedure.*') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="otherdetails" class="form-label"><strong>8. Any other details</strong></label>
                                                <textarea class="form-control" id="otherdetails" name="otherdetails"
                                                    rows="4" cols="163"></textarea>
                                                    @if ($errors->has('otherdetails'))
                                    <div class="color-csp-clinic-two">
                                        <strong>{{ $errors->first('otherdetails') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>
                               </div>
                                        
                       
                                        <div class="row">
                                            <div class="col-md-9 mb-4">
                                                <input type="checkbox" id="declaration" name="declaration">
                                                <b> I hereby declare that the entries in this form and the additional
                                                    particulars , if any,furnished herewith are true to the best of my
                                                    knowledge and belief.<span
                                                        class="color-csp-clinic-two">*</span> </b>
                                                        <div id="errordeclaration" class="color-csp-clinic-two"></div>                                      
                                                @if ($errors->has('declaration'))
                                                <div class="color-csp-clinic-two">
                                                    <strong>{{ $errors->first('declaration') }}</strong>
                                                </div>
                                                @endif
                                            </div>
                                           
                                        </div>

                                    </div>
                    <button type="button" class="btn btn-secondary bc-bc-color-csp-clinic-three"  id="prev-step">Back</button>
                    <button type="submit" id="submitButton" class="btn btn-success bc-bc-color-csp-clinic-three">Submit</button>
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
    $('#director').on('change', function() {
        $("#namedirector").val('');
        $("#quali_director").val('');
        $("#regdirector").val('');
        if (this.value == 'Yes') {
            $("#directory").show();
            $("#namedirector").prop("disabled", false);
            $("#quali_director").prop("disabled", false);
            $("#regdirector").prop("disabled", false);
        } else {
            $("#directory").hide();
            $("#namedirector").prop("disabled", true);
            $("#quali_director").prop("disabled", true);
            $("#regdirector").prop("disabled", true);
        }
    });
    </script>
    <script nonce="{{ $cspNonce }}">
    $('#anyotherprocedure').on('change', function() {
    
        $("#otherprocedure").val('');        
        if (this.value == 'Yes') {
           
            $("#anyotherprocedurey").show();
            $("#otherprocedure").prop("disabled", false);

        } else {
            $("#anyotherprocedurey").hide();
            $("#otherprocedure").prop("disabled", true);
        }
    });
    </script>
    <script nonce="{{ $cspNonce }}">
        $('#crud_table_otherstaff').on('change', 'select', function() {
            if ($(this).val() == 'Any Other') {
                //alert("called");
                $(this).parent().find('input').show();
                $(this).parent().find('input').attr('required', '');
                // $(this).parent().find('input').prop("disabled", false);
        
            } else {
                $(this).parent().find('input').hide();
                $(this).parent().find('input').removeAttr('required');
                // $(this).parent().find('input').prop("disabled", true);
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
        $('#adddirector').click(function() {
            i++;
            $('#crud_table_director').append('<tr id="row1' + i +
                '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control" required></td><td><select id= "quali_director" name="quali_director[]" class="form-control" required><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
                i +
                '" class="btn btn-danger btn_remove1"><i class="fa fa fa-trash"></i></button></td></tr>'
            );
        });
        $(document).on('click', '.btn_remove1', function() {
            var button_id = $(this).attr("id");
            //  alert(button_id);
            $('#row1' + button_id + '').remove();
        });
    });
    </script>

<!-- add addequipment start here date(06-01-2025)-->
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
<!-- add addequipment end here date(06-01-2025)-->

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
 
                           
                                <script nonce="{{ $cspNonce }}">
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
                                </script>
                                <script nonce="{{ $cspNonce }}">
                                    function validatesubmit() { 
                                        //return true; 
                                        

                                        const surrogacy_form_elements = ['clinicname','address','pincode','nature','email_clinic','contactno','personname','mobilecontact','emailcontact'];
                                        for (let elements of surrogacy_form_elements) {
                                            //alert(elements);
                                            let el = document.getElementById(elements);
                                            //alert(el);
                                            const name = el.name || el.id || 'Unnamed field';
                                            let errorDiv1 = document.getElementById("error".concat(el.id));
                                            // Skip button
                                            if (el.type === 'submit' || el.type === 'button' || el.type === 'checkbox' || el.type === 'radio') continue;

                                            if (el.tagName === 'SELECT') {
                                                //alert("test select");
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
                                                            //alert("test others");
                                                            // alert("test others" + elements);
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
                                        let datepicker = document.getElementById("datepicker").value;
                                        let errorDiv1 = document.getElementById("errordatepicker");


                                        if (datepicker === "") {
                                            errorDiv1.innerHTML = "Date of establishment of your Surrogacy Clinic cannot be blank";
                                            alert("Date of establishment of your Surrogacy Clinic cannot be blank");
                                            document.getElementById("datepicker").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }
                                        else {
                                            errorDiv1.innerHTML = ""; // Clear error message if valid
                                        }
                                        let mtpact = document.getElementById("mtpact").value;
                                        let errorDiv2 = document.getElementById("errormtpact");

                                        if (mtpact === "") {
                                            errorDiv2.innerHTML = "Whether your Surrogacy Clinic is registered under MTP Act cannot be blank";
                                            alert("Whether your Surrogacy Clinic is registered under MTP Act cannot be blank");
                                            document.getElementById("mtpact").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv2.innerHTML = ""; // Clear error message if valid
                                        }

                                        let pcpndtact = document.getElementById("pcpndtact").value;
                                        let errorDiv3 = document.getElementById("errorpcpndtact");

                                        if (pcpndtact === "") {
                                            errorDiv3.innerHTML = "Whether your Surrogacy Clinic is registered under PCPNDT Act cannot be blank";
                                            alert("Whether your Surrogacy Clinic is registered under PCPNDT Act cannot be blank");
                                            document.getElementById("pcpndtact").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv3.innerHTML = ""; // Clear error message if valid
                                        }
                                        let director = document.getElementById("director").value;
                                        let directorname = document.getElementById("namedirector").value;
                                        let directorquali = document.getElementById("quali_director").value;                                        
                                        let errorDiv4 = document.getElementById("errordirector");
                                        let errorDiv5 = document.getElementById("errornamedirector");
                                        let errorDiv6 = document.getElementById("errorquali_director");

                                        if (director === "") {
                                            errorDiv4.innerHTML = "Whether your Surrogacy Clinic has Director cannot be blank";
                                            alert("Whether your Surrogacy Clinic has Director cannot be blank");
                                            document.getElementById("director").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv4.innerHTML = ""; // Clear error message if valid
                                        }

                                        if ((director === "Yes") && (directorname === null)) {
                                            errorDiv5.innerHTML = "Name of the Director cannot be blank";
                                            alert("Name of the Director cannot be blank");
                                            document.getElementById("namedirector").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv5.innerHTML = ""; // Clear error message if valid
                                        }
                                        if ((director === "Yes") && (directorquali === null)) {
                                            errorDiv6.innerHTML = "Qualification of the Director cannot be blank";
                                            alert("Qualification of the Director cannot be blank");
                                            document.getElementById("quali_director").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv6.innerHTML = ""; // Clear error message if valid
                                        }


                                        if ((director === "Yes") && (directorname === "")) {
                                            errorDiv5.innerHTML = "Name of the Director cannot be blank";
                                            alert("Name of the Director cannot be blank");
                                            document.getElementById("namedirector").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv5.innerHTML = ""; // Clear error message if valid
                                        }
                                        if ((director === "Yes") && (directorquali === "")) {
                                            errorDiv6.innerHTML = "Qualification of the Director cannot be blank";
                                            alert("Qualification of the Director cannot be blank");
                                            document.getElementById("quali_director").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv6.innerHTML = ""; // Clear error message if valid
                                        }
                                        let postotherstaff = document.getElementById("postotherstaff").value;
                                        let errorDiv7 = document.getElementById("errorpostotherstaff");

                                        if (postotherstaff === "") {
                                            errorDiv7.innerHTML = "Post of staff cannot be blank";
                                            alert("Post of staff cannot be blank");
                                            document.getElementById("postotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv7.innerHTML = ""; // Clear error message if valid
                                        }
                                        let anyotherpost = document.getElementById("anyotherpost").value;
                                        let errorDiv10 = document.getElementById("erroranyotherpost");
                                        if ((postotherstaff === "Any Other") && (anyotherpost ==="")) {
                                            errorDiv10.innerHTML = "Name of the other Post cannot be blank";
                                            alert("Name of the other Post cannot be blank");
                                            document.getElementById("anyotherpost").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv10.innerHTML = ""; // Clear error message if valid
                                        }
                                        let nameotherstaff = document.getElementById("nameotherstaff").value;
                                        let errorDiv8 = document.getElementById("errornameotherstaff");

                                        if (nameotherstaff === "") {
                                            errorDiv8.innerHTML = "Name of staff cannot be blank";
                                            alert("Name of staff cannot be blank");
                                            document.getElementById("nameotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv8.innerHTML = ""; // Clear error message if valid
                                        }
                                        let qualiotherstaff = document.getElementById("qualiotherstaff").value;
                                        let errorDiv9 = document.getElementById("errorqualiotherstaff");
                                        if (qualiotherstaff === "") {
                                            errorDiv9.innerHTML = "Qualification of staff cannot be blank";
                                            alert("Qualification of staff cannot be blank");
                                            document.getElementById("qualiotherstaff").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv9.innerHTML = ""; // Clear error message if valid
                                        }


                                        
                                        let anyotherdegree = document.getElementById("anyotherdegree").value;
                                        let errorDiv11 = document.getElementById("erroranyotherdegree");
                                        if ((qualiotherstaff === "Any Other") && (anyotherdegree ==="")) {
                                            errorDiv11.innerHTML = "Other Qualification of staff cannot be blank";
                                            alert("Other Qualification of staff cannot be blank");
                                            document.getElementById("anyotherdegree").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv11.innerHTML = ""; // Clear error message if valid
                                        }
                                        let equipmentname = document.getElementById("equipmentname").value;
                                        let errorDiv13 = document.getElementById("errorequipmentname");
                                        if (equipmentname === "") {
                                            errorDiv13.innerHTML = "Name of equipment cannot be blank";
                                            alert("Name of equipment cannot be blank");
                                            document.getElementById("equipmentname").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv13.innerHTML = ""; // Clear error message if valid
                                        }
                                        let iuih = document.getElementById("iuih").value;
                                        let errorDiv14 = document.getElementById("erroriuih");
                                        if (iuih === "") {
                                            errorDiv14.innerHTML = "Intra-uterine Insemination using Husband Semen (IUI-H) not be blank";
                                            alert("Intra-uterine Insemination using Husband Semen (IUI-H) not be blank");
                                            document.getElementById("iuih").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv14.innerHTML = ""; // Clear error message if valid
                                        }
                                        let iuid = document.getElementById("iuid").value;
                                        let errorDiv15 = document.getElementById("erroriuid");
                                        if (iuid === "") {
                                            errorDiv15.innerHTML = "Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank";
                                            alert("Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank");
                                            document.getElementById("iuid").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv15.innerHTML = ""; // Clear error message if valid
                                        }
                                        let ivfet = document.getElementById("ivfet").value;
                                        let errorDiv16 = document.getElementById("errorivfet");
                                        if (ivfet === "") {
                                            errorDiv16.innerHTML = "In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank";
                                            alert("In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank");
                                            document.getElementById("ivfet").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv16.innerHTML = ""; // Clear error message if valid
                                        }
                                        let icsi = document.getElementById("icsi").value;
                                        let errorDiv17 = document.getElementById("erroricsi");
                                        if (icsi === "") {
                                            errorDiv17.innerHTML = "Intra-cytoplasmic Sperm Injection (ICSI) not be blank";
                                            alert("Intra-cytoplasmic Sperm Injection (ICSI) not be blank");
                                            document.getElementById("icsi").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv17.innerHTML = ""; // Clear error message if valid
                                        }
                                        let pgt = document.getElementById("pgt").value;
                                        let errorDiv19 = document.getElementById("errorpgt");
                                        if (pgt === "") {
                                            errorDiv19.innerHTML = "Pre-implantation Genetic Testing (PGT) not be blank";
                                            alert("Pre-implantation Genetic Testing (PGT) not be blank");
                                            document.getElementById("pgt").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv19.innerHTML = ""; // Clear error message if valid
                                        }
                                        let spermandoocyte = document.getElementById("spermandoocyte").value;
                                        let errorDiv18 = document.getElementById("errorspermandoocyte");
                                        if (spermandoocyte === "") {
                                            errorDiv18.innerHTML = "Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient cannot be blank";
                                            alert("Processing or Storage of Gametes (sperm & oocyte)of the Patient and or embryos of patient cannot be blank");
                                            document.getElementById("spermandoocyte").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv18.innerHTML = ""; // Clear error message if valid
                                        }
                                        
                                        let anyotherprocedure = document.getElementById("anyotherprocedure").value;
                                        let errorDiv20 = document.getElementById("erroranyotherprocedure");
                                        if (anyotherprocedure === "") {
                                            errorDiv20.innerHTML = "Any Other Procedure cannot be blank";
                                            alert("Any Other Procedure cannot be blank");
                                            document.getElementById("otherprocedure").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv20.innerHTML = ""; // Clear error message if valid
                                        }
                                        let otherprocedure = document.getElementById("otherprocedure").value;
                                        let errorDiv21 = document.getElementById("errorotherprocedure");
                                        if ((anyotherprocedure === "Yes") && (otherprocedure ==="")) {
                                            errorDiv21.innerHTML = "Details of any other procedure cannot be blank";
                                            alert("Details of other procedure cannot be blank");
                                            document.getElementById("otherprocedure").focus();
                                            event.preventDefault(); // Prevent form submission
                                            return false;
                                        }else {
                                            errorDiv21.innerHTML = ""; // Clear error message if valid
                                        }
                                        if (!document.getElementById("declaration").checked) {
                                            alert("Declaration cannot be blank");
                                            document.getElementById("declaration").focus();
                                            return false;
                                        }
                                        var agree = confirm(
                                            "Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted."
                                        );
                                        if (agree) {
                                            //alert('test2');
                                            return true;
                                        } else {
                                            alert('test7');
                                            //return false;
                                        }
                                        return true;
                                    }
                                    </script>
@endsection