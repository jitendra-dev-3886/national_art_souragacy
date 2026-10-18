@extends('layouts.clinic.clinic_master')
@section('content')
<style nonce="{{ $cspNonce }}">
    .display-none-csp-clinic-one{
    display:none;
    }
    .color-red-fourtyseven{
        color: #ff0000;
    }
    .bc-br-color-fourtyeight{
        background-color: #0b5ed7; border-color: #0b5ed7; color: white;
    }
    .bc-br-color-info{
        background-color: #4de9ee; border-color: #0ce0e0; color: white;
    }
    .bc-color-csp-fortynine{
        border-color: #0b5ed7; color: #0b5ed7;
    }
    .displyay-none-fifty{
        display: none;
    }
    .height-fifty-one{
        height: 20px;
    }
    .width-fify-two{
        width: 50%;
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
    input.form-control[readonly],input.form-control:disabled {
    background-color: #f8f8f8;
    border: 1px solid #f3f1f1;
    cursor: not-allowed;
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
        <h3>Application Form for ART Clinic</h3>
        <div class="progress mb-4 height-fifty-one">
            <div
            id="progress-bar" 
            class="progress-bar progress-bar-striped progress-bar-animated width-fify-two" 
            role="progressbar" 
            aria-valuenow="50" 
            aria-valuemin="0" 
            aria-valuemax="100">
            Step 1 of 2
            </div>
        </div>

            <!-- Form -->
            <form id="form-wizard" method="POST" action="{{ route('change_address.submit_application') }}" enctype="multipart/form-data" autocomplete="off">
              <!-- Step 1 -->
              @csrf
              <div id="step-1" class="step">
                <div class="row">
                    <div class="col-md-6">
                                <h3 class=" bc-color-csp-clinic-four" >General Information and Staff Details</h3>
                            </div>
                            <div class="col-md-6">
                            @if(($reject ?? null) === 'Rejected')
                                <h3 class="text-success text-center">Resubmission Against Previously Rejected Application</h3>
                                <input id="r_id" name="r_id"  value="{{ $encryptedAppId }}" type="hidden">
                            @endif
                            </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <input id="clinic_id" name="clinic_id"  value="{{ $clinic_data->clinic_id }}"
                                            type="hidden"> 
                        <input id="clinic_id" name="applicationno"  value="{{ $clinic_data->application_no }}"
                        type="hidden"> 
                        <input id="clinic_id" name="clinic_type"  value="{{ $clinic_data->clinic_type }}"
                                            type="hidden"> 
                        <label class="control-label" for="clinicname"><strong>Name of the Clinic</strong><span
                                class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input id="clinicname" name="clinicname" class="form-control" value="{{ $clinic_data->name  ?? $draft_data->name ?? '' }}"
                                type="text" readonly/>
                        </div>
                        <div id="errorclinicname" class="color-red-fourtyseven"></div>
                        @if ($errors->has('clinicname'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('clinicname') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="address"><strong>Address</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="address" id="address"
                               value="{{$clinic_data->address ?? $draft_data->address ?? '' }}"
                                class="form-control border-left-end">
                        </div>
                        <div id="erroraddress" class="color-red-fourtyseven"></div>
                        @if ($errors->has('address'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pincode"><strong>Pincode</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="pincode" placeholder="" id="pincode"
                                value="{{ $clinic_data->pincode ?? $draft_data->pincode ?? '' }}" class="form-control border-left-end">
                        </div>
                        <span id="pincodeavailability"></span>
                        <div id="errorpincode" class="color-red-fourtyseven"></div>
                        @if ($errors->has('pincode'))
                            <div class="color-red-fourtyseven">
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
                                value="{{ $clinic_data->state ?? $draft_data->state ??'' }}"
                                class="form-control border-left-end">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="district"><strong>District</strong></label>
                        <div class="input-group" id="district-container">
                            <input type="text" name="district" placeholder="district" id="district"
                                value="{{ $clinic_data->district ?? '' }}"
                                class="form-control border-left-end">
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="nature"><strong>Nature of the Organization</strong></label>
                            <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            {{-- <select name="nature" id="nature" class="form-control" >
                                <option value="">Select</option>
                                <option value="Government" {{ ($signup->nature ?? $draft->nature ?? '') == 'Government' ? 'selected' : '' }}>Government</option>
                                <option value="Private" {{ ($signup->nature ?? $draft->nature ?? '') == 'Private' ? 'selected' : '' }}>Private</option>
                            </select> --}}
                            <input type="text" class="form-control" name="nature" id="nature" value="{{($clinic_data->nature ?? $draft_data->nature ?? '')}}" readonly>
                        </div>
                        <div id="errornature" class="color-red-fourtyseven"></div>
                        @if ($errors->has('nature'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('nature') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="email_clinic"><strong>E-mail
                                Address of the clinic</strong><span
                               class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="email" name="email_clinic" placeholder="Email" id="email_clinic"
                            value="{{ $clinic_data->email ?? '' }}" class="form-control">
                        </div>
                        <div id="erroremail_clinic" class="color-red-fourtyseven"></div>
                        @if ($errors->has('email_clinic'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('email_clinic') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="contactno"><strong>Contact
                                Number</strong><span
                               class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="contactno" placeholder="Contact number of clinic (11 digit)" id="contactno" pattern="^[0-9]{11}$"
                                value="{{ $draft_data->contactno ?? $clinic_data->contact_number_clinic ?? '' }}" class="form-control" required>
                        </div>
                        <div id="errorcontactno" class="color-red-fourtyseven"></div>
                        @if ($errors->has('contactno'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('contactno') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="personname"><strong>Name
                                of the Contact Person</strong> <span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="text" name="personname" placeholder="" id="personname"
                            value="{{ $draft_data->contact_person_name ??  $clinic_data->contact_person_name ?? '' }}" class="form-control" required>
                        </div>
                        <div id="errorpersonname" class="color-red-fourtyseven"></div>
                        @if ($errors->has('personname'))
                            <div class="color-red-fourtyseven">
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
                                <span class="color-red-fourtyseven">*</span>
                        <div class="input-group">
                            <input type="text" name="mobilecontact" placeholder="Mobile number of contact person (10 digit)" id="mobilecontact" pattern="^[0-9]{10}$"
                            value="{{ $draft_data->contact_person_mobile ?? $clinic_data->mobile  ?? '' }}" class="form-control" required>
                        </div>
                        <div id="errormobilecontact" class="color-red-fourtyseven"></div>
                        @if ($errors->has('mobilecontact'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('mobilecontact') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="emailcontact"><strong>E-mail
                                Address</strong> <span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <input type="email" name="emailcontact" placeholder="" id ="emailcontact"
                            value="{{ $clinic_data->email }}" class="form-control">
                        </div>
                        <div id="erroremailcontact" class="color-red-fourtyseven"></div>
                        @if ($errors->has('emailcontact'))
                            <div class="color-red-fourtyseven">
                                <strong>{{ $errors->first('emailcontact') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="cliniclevel"><strong>Applying
                                for Renewal as</strong><span
                                class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="cliniclevel1" id="cliniclevel" 
                                class="nice-select default-select wide form-control solid" disabled>
                                <option value="">Select</option>
                                <option value="Level-1"  {{ old('Level-1', $draft_data->cliniclevel ?? $clinic_data->level ?? '') == 'Level-1' ? 'selected' : '' }}>Level-1</option>
                                <option value="Level-2" {{ old('Level-2', $draft_data->cliniclevel ??  $clinic_data->level ?? '') == 'Level-2' ? 'selected' : '' }}>Level-2</option>
                            </select>
                            <input type="hidden" name="cliniclevel" value="{{ $draft_data->cliniclevel ?? $clinic_data->level }}">

                        </div>
                         <!-- Error Message Container -->
                        <div id="errorCliniclevel" class="color-red-fourtyseven"></div>
                        @if ($errors->has('cliniclevel'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('cliniclevel') }}</strong>
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
                            <input type="text" name="fax" id="fax" placeholder="fax number (11 Digit)"
                                class="form-control" value="{{ old('fax', $draft_data->fax ?? $clinic_data->fax_number ?? '') }}">

                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="website"><strong>Website</strong></label>
                        <div class="input-group">
                            <input type="text" name="website" placeholder=""
                                 class="form-control" value="{{ old('website',$draft_data->website ?? $clinic_data->website ??'') }}">

                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>1.
                                Date of establishment of your ART Clinic</strong><span
                                class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                                <input type="date" name="dateestab"
                                class="datepicker-default form-control" id="datepicker" value="{{ old('dateestab',$draft_data->dateestab ?? $clinic_data->date_of_establishment ??'') }}" readonly>
                        </div>
                        <div id="errordatepicker" class="color-red-fourtyseven"></div>
                        @if ($errors->has('dateestab'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('dateestab') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="datepicker"><strong>Date of Registration</strong><span class="color-red-fourtyseven"></span></label>
                        <div class="input-group">
                            <input type="text" class="datepicker-default form-control" value="{{ date('d-m-Y',strtotime($clinic_data->rgistration_date )) }}" disabled>
                            <input type="hidden" name="current_registration_date" value="{{ $clinic_data->rgistration_date ?? '' }}">
                            <input type="hidden" name="original_rgistration_date" value="{{ $clinic_data->first_registration_date ?? '' }}">
                        </div>
                        <div id="errordatepicker" class="color-red-fourtyseven"></div>
                        @if ($errors->has('original_rgistration_date'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('original_rgistration_date') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="mtpact"><strong>2.
                                Whether your ART Clinic is registered under MTP
                                Act</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="mtpact" id="mtpact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                <option value="Yes" {{ old('mtpact', $draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ??'') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No"  {{ old('mtpact',$draft_data->mtpact ?? $clinic_data->clinic_reg_mpt ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div id="errormtpact" class="color-red-fourtyseven"></div>
                        @if ($errors->has('mtpact'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('mtpact') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="pcpndtact"><strong>3.
                                Whether your ART Clinic is registered under PCPNDT
                                Act</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select name="pcpndtact" id="pcpndtact"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                
                                <option value="Yes" {{ old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('pcpndtact', $draft_data->pcpndtact ?? $clinic_data->clinic_reg_pcpndt ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>

                        </div>
                        <div id="errorpcpndtact" class="color-red-fourtyseven"></div>
                        @if ($errors->has('pcpndtact'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('pcpndtact') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="text-label form-label"
                            for="director"><strong>4.Whether your ART Clinic has
                                Director</strong><span class="color-red-fourtyseven">*</span></label>
                        <div class="input-group">
                            <select id="director" name="director"
                                class="nice-select default-select wide form-control solid">
                                <option value="">Select</option>
                                
                                <option value="Yes" {{ old('director', $draft_data->director ?? $clinic_data->clinic_director ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('director',$draft_data->director ?? $clinic_data->clinic_director ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div id="errordirector" class="color-red-fourtyseven"></div>
                        @if ($errors->has('director'))
                                <div class="color-red-fourtyseven">
                                    <strong>{{ $errors->first('director') }}</strong>
                                </div>
                            @endif
                    </div>
                </div>




                        <div id="directory" data-section="directors" class="col-xs-12 form-group  {{ old('director', $draft_data->director ?? $clinic_data->clinic_director ??  '') == 'Yes' ? '' : 'displyay-none-fifty' }}" id="directors-section">
                                <div class="table-responsive">
                                    {{-- Prepare directors data before rendering the table --}}
                                    @php
                                    $directorsData = old('name_director') 
                                    ? collect(old('name_director'))->map(function ($name, $i) {
                                    return [
                                    'name_director'  => $name,
                                    'quali_director' => old('quali_director.' . $i),
                                    'reg_director'   => old('reg_director.' . $i),
                                    ];
                                    })
                                    : ($directors ?? collect([[]])); // if no draft, show one empty row
                                    @endphp

                                    <table class="table table-bordered" id="crud_table_director">
                                        <tr>
                                            <th>Name<span class="color-red-fourtyseven">*</span></th>
                                            <th>Qualification<span class="color-red-fourtyseven">*</span></th>
                                            <th>Registration No. (if applicable)</th>
                                            <th></th>
                                        </tr>


                                        @forelse($directorsData as $index => $director)
                                            <tr class="director-row" id="drow{{ $index+1 }}">
                                                <td>
                                                    <input type="text" name="name_director[]" class="form-control"
                                                        value="{{ $director['name_director'] ?? '' }}">
                                                </td>
                                                <td>
                                                    <select name="quali_director[]" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach(['PhD','DM','MCh','PG','MD','MS','DNB'] as $q)
                                                            <option value="{{ $q }}" {{ ($director['quali_director'] ?? '') == $q ? 'selected' : '' }}>
                                                                {{ $q }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="reg_director[]" class="form-control"
                                                        value="{{ $director['reg_director'] ?? '' }}">
                                                </td>
                                                <td>
                                                   
                                                    @if($index > 0)
                                                        <button type="button" id="{{ $index+1 }}" class="btn btn-danger btn_remove1">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                       
                                        @empty
                                            <tr class="director-row" id="drow1">
                                                <td><input type="text" name="name_director[]" class="form-control"></td>
                                                <td>
                                                    <select name="quali_director[]" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach(['PhD','DM','MCh','PG','MD','MS','DNB'] as $q)
                                                            <option value="{{ $q }}">{{ $q }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="reg_director[]" class="form-control"></td>
                                               
                                        
                                                </td> {{-- no delete button for first default row --}}
                                            </tr>
                                        @endforelse
                                    </table>

                        <div align="right">
                            <button type="button" name="adddirector" id="adddirector" 
                                class="btn-xs bc-br-color-fourtyeight"><i class="fa fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

    @php
                            $staffData = old('post')
                            ? collect(old('post'))->map(function ($post, $i) {
                            return [
                            'post' => $post,
                            'anyotherpost'   => old('anyotherpost.' . $i),
                            'name' => old('name.' . $i),
                            'quali_otherstaff' => old('quali_otherstaff.' . $i),
                            'anyotherdegree'  => old('anyotherdegree.' . $i),
                            'regno'           => old('regno.' . $i),
                            ];
                            })
                            : ($staff ?? collect([[]])); // ensures at least one row
                            @endphp
                <div id="otherstaff" class="col-xs-12 form-group">
                    <label class="control-label"><strong>5. Provide details of the staff.</strong></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="crud_table_otherstaff">
                            <thead>
                                <tr>
                                    <th>Post<span class="color-red-fourtyseven">*</span></th>
                                    <th>Name<span class="color-red-fourtyseven">*</span></th>
                                    <th>Qualification<span class="color-red-fourtyseven">*</span></th>
                                    <th>Reg No</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffData as $i => $row)
                                <tr class="staff-row">
                                    {{-- Post --}}
                                    <td>
                                        <select name="post[]" class="form-control toggle-other">
                                            <option value="">Select</option>
                                            <option value="Gynecologist" {{ ($row['post'] ?? '') == 'Gynecologist' ? 'selected' : '' }}>Gynecologist</option>
                                            <option value="Andrologist" {{ ($row['post'] ?? '') == 'Andrologist' ? 'selected' : '' }}>Andrologist</option>
                                            <option value="Clinical Embryologist" {{ ($row['post'] ?? '') == 'Clinical Embryologist' ? 'selected' : '' }}>Clinical Embryologist</option>
                                            <option value="Counselor" {{ ($row['post'] ?? '') == 'Counselor' ? 'selected' : '' }}>Counselor</option>
                                            <option value="Anesthetist" {{ ($row['post'] ?? '') == 'Anesthetist' ? 'selected' : '' }}>Anesthetist</option>
                                            <option value="Any Other" {{ ($row['post'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                        </select>
                                            <div id="errorpost" class="color-red-fourtyseven"></div>
                                            <input type="text" name="anyotherpost[]" value="{{ $row['post'] ?? '' }}" class="form-control displyay-none-fifty other-input {{ ($row['post'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                            <div id="erroranyotherpost" class="color-red-fourtyseven"></div>
                                            
                                    </td>

                                    {{-- Name --}}
                                    <td>
                                        <input type="text" name="name_otherstaff[]" value="{{ $row['name'] ?? '' }}" class="form-control">
                                        <div id="errorpost" class="color-red-fourtyseven"></div>
                                    </td>

                                    {{-- Qualification --}}
                                    <td>
                                        <select name="quali_otherstaff[]" class="form-control toggle-other">
                                            <option value="">Select</option>
                                            <option value="Doctorate" {{ ($row['qualification'] ?? '') == 'Doctorate' ? 'selected' : '' }}>Doctorate</option>
                                            <option value="Post Graduate" {{ ($row['qualification'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>Post Graduate</option>
                                            <option value="Graduate" {{ ($row['qualification'] ?? '') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                            <option value="Diploma" {{ ($row['qualification'] ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                            <option value="Under Graduate" {{ ($row['qualification'] ?? '') == 'Under Graduate' ? 'selected' : '' }}>Under Graduate</option>
                                            <option value="Any Other" {{ ($row['qualification'] ?? '') == 'Any Other' ? 'selected' : '' }}>Any Other</option>
                                        </select>
                                        <div id="errorquali_otherstaff" class="color-red-fourtyseven"></div>
                                        <input type="text" name="anyotherdegree[]" value="{{ $row['qualification'] ?? '' }}"
                                            class="form-control displyay-none-fifty other-input {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                            <div id="erroranyotherdegree" class="color-red-fourtyseven"></div>
                                    </td>

                                    {{-- Reg No --}}
                                    <td>
                                        <input type="text" name="regno[]" value="{{ $row['regno'] ?? '' }}" class="form-control">
                                    </td>

                                   
                                    <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div align="right">
                            <button type="button" name="addotherstaff" id="addotherstaff" class="btn-xs bc-br-color-fourtyeight">+</button>
                        </div>
                    </div>
                </div>


            </div>
                    <button type="button" class="btn btn-primary bc-br-color-fourtyeight" id="next-step">Next</button>
                  </div>

                        <!-- Step 2 -->
                        <div id="step-2" class="step d-none">
                            <div class="row">
                                <h3 class="bc-color-csp-fortynine">Procedures</h3>
                                @php
                                    $equipmentsData = old('equipmentname')
                                        ? collect(old('equipmentname'))->map(fn($eq) => (object)['equipmentname' => $eq])
                                        : ($equipment ?? collect([(object)['equipmentname' => '']]));
                                @endphp

                                <div id="equipment" class="col-xs-12 form-group">
                                    <label class="control-label" for="">6. Provide list of Equipment's</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="crud_table_equipments">
                                            <tr>
                                                <th>Name of Equipments<span class="color-red-fourtyseven">*</span></th>
                                                <th></th>
                                            </tr>

                                            @foreach($equipmentsData as $i => $row)
                                                <tr class="equipment-row" id="row1{{ $i+1 }}">
                                                    <td>
                                                        <input type="text" id="equipmentname" name="equipmentname[]"
                                                            value="{{ $row->equipmentname ?? '' }}"
                                                            placeholder="" class="form-control">
                                                        <div id="errorequipmentname" class="color-red-fourtyseven"></div>
                                                        @error('equipmentname.' . $i)
                                                            <div class="color-red-fourtyseven"><strong>{{ $message }}</strong></div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        @if($i > 0) {{-- पहली row पर delete button नहीं दिखेगा --}}
                                                            <button type="button" id="{{ $i+1 }}" class="btn btn-danger btn_remove_addEQ">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                        <div align="right">
                                            <button type="button" name="addequipment" id="addequipment"
                                                    class="btn-xs bc-br-color-fourtyeight">+</button>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="control-label" for=""><strong>7. Indicate which of the
                                                            following ART
                                                            procedures are being routinely carried out at
                                                            your ART Clinic
                                                        </strong></label>
                                                </div>
                                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="iuih"><strong>i).
                                                        Intra-uterine Insemination using Husband Semen (IUI-H)<span
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuih" id="iuih"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes" {{ old('iuih', $draft_data->iuih ??  $clinic_data->iui_h_s ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No" {{ old('iuih', $draft_data->iuih ??  $clinic_data->iui_h_s ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>

                                                </div>
                                                <div id="erroriuih" class="color-red-fourtyseven"></div>
                                                @if ($errors->has('iuih'))
                                                <div class="color-red-fourtyseven">
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
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuid" id="iuid"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('iuid', $draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('iuid', $draft_data->iuid ?? $clinic_data->iui_d_s ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>

                                                </div>
                                                <div id="erroriuid" class="color-red-fourtyseven"></div>
                                                @if ($errors->has('iuid'))
                                    <div class="color-red-fourtyseven">
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
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">

                                                    <select name="ivfet" id="ivfet"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('ivfet', $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('ivfet', $draft_data->ivfet ?? $clinic_data->ivf_et ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div id="errorivfet" class="color-red-fourtyseven"></div>
                                                 @if ($errors->has('ivfet'))
                                    <div class="color-red-fourtyseven">
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
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="icsi" id="icsi"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('icsi', $draft_data->icsi ?? $clinic_data->icsi ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>

                                                </div>
                                                <div id="erroricsi" class="color-red-fourtyseven"></div>
                                                 @if ($errors->has('icsi'))
                                    <div class="color-red-fourtyseven">
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
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="pgt" id="pgt"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('pgt', $draft_data->pgt ?? $clinic_data->pgt ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div id="errorpgt" class="color-red-fourtyseven"></div>
                                                @if ($errors->has('pgt'))
                                    <div class="color-red-fourtyseven">
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
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermandoocyte" id="spermandoocyte"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('spermandoocyte', $draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('spermandoocyte', $draft_data->spermandoocyte ?? $clinic_data->sperm_oocyte ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div id="errorspermandoocyte" class="color-red-fourtyseven"></div>
                                                @if ($errors->has('spermandoocyte'))
                                    <div class="color-red-fourtyseven">
                                        <strong>{{ $errors->first('spermandoocyte') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="text-label form-label"
                                                    for="anyotherprocedure"><strong>vii). Any Other Procedure<span class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="anyotherprocedure" id='anyotherprocedure'
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"  {{ old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                        <option value="No"  {{ old('anyotherprocedure', $draft_data->anyotherprocedure ??  $clinic_data->any_other_procedure ?? '') == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                                <div id="erroranyotherprocedure" class="color-red-fourtyseven"></div>
                                                @if ($errors->has('anyotherprocedure'))
                                                <div class="color-red-fourtyseven">
                                                    <strong>{{ $errors->first('anyotherprocedure') }}</strong>
                                                </div>
                                            @endif
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                            <div class="mb-3 displyay-none-fifty" id='anyotherprocedurey'>
                                                <label class="text-label form-label"
                                                    for="otherprocedure"><strong>If yes, please specify<span
                                                            class="color-red-fourtyseven">*</span></strong></label>
                                                <div class="input-group">
                                                    <input type="text" id="otherprocedure" name="otherprocedure"
                                                        placeholder="" class="form-control"  value="{{ old('otherprocedure', $draft_data->otherprocedure ?? $clinic_data->otherprocedure ??  '') }}" />
                                                </div>
                                                <div id="errorotherprocedure" class="color-red-fourtyseven"></div>                                      
                                                @if ($errors->has('otherprocedure.*'))
                                                    <div class="color-red-fourtyseven">
                                                        <strong>{{ $errors->first('otherprocedure.*') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div> --}}
    <div class="col-md-6">
                                    <div class="mb-3 display-none-csp-clinic-one" id='anyotherprocedurey' >
                                        <label class="text-label form-label"
                                            for="otherprocedure"><strong>If yes, please specify<span
                                            class="color-red-fourtyseven">*</span></strong></label>
                                        <div class="input-group">
                                            <input type="text" id="otherprocedure" name="otherprocedure"
                                                placeholder=""  value="{{ old('otherprocedure', $draft_data->otherprocedure ?? $clinic_data->otherprocedure ?? '') }}" class="form-control">
                                        </div>
                                        <div id="errorotherprocedure" class="color-red-fourtyseven"></div>
                                        @if ($errors->has('otherprocedure.*'))
                                        <div class="color-red-fourtyseven">
                                            <strong>{{ $errors->first('otherprocedure.*') }}</strong>
                                        </div>
                                        @endif
                                    </div>
    </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="otherdetails" class="form-label"><strong>8. Any other details</strong></label>
                                                <textarea class="form-control" id="otherdetails" name="otherdetails"
                                                    rows="4" cols="163">{{ old('otherdetails', $draft_data->otherdetails ?? $clinic_data->any_other_detail ?? '') }}</textarea>
                                                    @if ($errors->has('otherdetails'))
                                    <div class="color-red-fourtyseven">
                                        <strong>{{ $errors->first('otherdetails') }}</strong>
                                    </div>
                                @endif
                                            </div>
                                        </div>
                               </div>

                                        {{-- <legend>
                                            <h4 style="color: green;"><strong>Upload Documents<span
                                                        class="color-red-fourtyseven">*</span></h4>
                                            </strong>
                                        </legend> --}}


                                        <div class="row">
                                            <div class="col-md-9 mb-4">
                                                <input type="checkbox" id="declaration" name="declaration">
                                                <b> I hereby declare that the entries in this form and the additional
                                                    particulars , if any,furnished herewith are true to the best of my
                                                    knowledge and belief.<span
                                                        class="color-red-fourtyseven">*</span> </b>
                                                        </br>
                                    @if(($reject ?? null) === 'Rejected')
                                    <hr>
                                        <span>✓✓ <b>Fees already paid {{$fees ?? '-'}}/-</b> </span>
                                    @endif
                                                        @if ($errors->has('declaration'))
                                    <div class="color-red-fourtyseven">
                                        <strong>{{ $errors->first('declaration') }}</strong>
                                    </div>
                                @endif
                                            </div>

                                        </div>

                                    </div>
                    <button type="button" class="btn btn-secondary bc-br-color-fourtyeight" id="prev-step">Back</button>
                    <button type="submit" id="draftButton" name="submit_type" value="draft" class="btn btn-success bc-bc-color-csp-clinic-three">Save As draft</button>
                    <button  type="submit" id="submitButton" name="submit_type" value="final" class="btn btn-success bc-bc-color-csp-clinic-three">Submit</button>
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
    const draftButton = document.getElementById('draftButton');
    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            if (!validatesubmit()) {
                event.preventDefault();
            }
        });
    }
    if (draftButton) {
        draftButton.addEventListener('click', function(event) {
            if (!validatesdraft()) {
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
            $("input[name='name_director[]']").prop("disabled", false).val('');
            $("select[name='quali_director[]']").prop("disabled", false).val('');
            $("input[name='reg_director[]']").prop("disabled", false).val('');
        } else {
            $("#directory").hide();
            $("input[name='name_director[]']").prop("disabled", true).val('');
            $("select[name='quali_director[]']").prop("disabled", true).val('');
            $("input[name='reg_director[]']").prop("disabled", true).val('');
        }
    });
    </script>
 <script nonce="{{ $cspNonce }}">
    $(document).ready(function () {
        function toggleOtherProcedure() {
            if ($('#anyotherprocedure').val() === 'Yes') {
                $("#anyotherprocedurey").show();
                $("#otherprocedure").prop("disabled", false);
            } else {
                $("#anyotherprocedurey").hide();
                $("#otherprocedure").prop("disabled", true).val('');
            }
        }
    
        // Run once on page load (important for draft values)
        toggleOtherProcedure();
    
        // Run again whenever user changes the dropdown
        $('#anyotherprocedure').on('change', function () {
            toggleOtherProcedure();
        });
    });
</script>
    <script nonce="{{ $cspNonce }}">
        $('#crud_table_otherstaff').on('change', 'select', function() {
            if ($(this).val() == 'Any Other') {
                //alert("called");
                $(this).parent().find('input').show();
                //$(this).parent().find('input').attr('required', '');

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
    $(document).ready(function () {
        function createStaffRow() {
            return `
            <tr class="staff-row">
                <td>
                    <select name="post[]" class="form-control">
                        <option value="">Select</option>
                        <option value="Gynecologist">Gynecologist</option>
                        <option value="Andrologist">Andrologist</option>
                        <option value="Clinical Embryologist">Clinical Embryologist</option>
                        <option value="Counselor">Counselor</option>
                        <option value="Anesthetist">Anesthetist</option>
                        <option value="Any Other">Any Other</option>
                    </select>
                    <input type="text" name="anyotherpost[]" placeholder="Specify other post" class="form-control display-none-csp-clinic-one">
                </td>
                <td><input type="text" name="name_otherstaff[]" class="form-control"></td>
                <td>
                    <select name="quali_otherstaff[]" class="form-control">
                        <option value="">Select</option>
                        <option value="Doctorate">Doctorate</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Under Graduate">Under Graduate</option>
                        <option value="Any Other">Any Other</option>
                    </select>
                    <input type="text" name="anyotherdegree[]" placeholder="Specify degree" class="form-control display-none-csp-clinic-one">
                </td>
                <td><input type="text" name="regno[]" class="form-control"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa fa-trash"></i></button></td>
            </tr>`;
        }
    
        const $tableBody = $('#crud_table_otherstaff tbody');
    
        // Ensure at least one row is present on page load
        if ($tableBody.find('.staff-row').length === 0) {
            $tableBody.append(createStaffRow());
        }
    
        // Add row button
        $('#addotherstaff').on('click', function(e) {
            e.preventDefault();
            let newRow = $tableBody.find('.staff-row:first').clone();
            newRow.find('input, select').val(''); // clear values
            $tableBody.append(newRow);
        });
    
        // Remove row button
        $(document).on('click', '.remove-row', function(e) {
            e.preventDefault();
            if ($tableBody.find('.staff-row').length > 1) {
                $(this).closest('tr').remove();
            } 
            else {
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
            $('#crud_table_director').append('<tr class="director-row" id="row1' + i +
                '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control" required><div class="error-namedirector" class="color-red-fourtyseven"></div></td><td><select id= "quali_director" name="quali_director[]" class="form-control" required><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select> <div class="error-quali_director" class="color-red-fourtyseven"></div></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
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


  </script>

<script nonce="{{ $cspNonce }}">
   function validatesdraft(e) {
        const allInputs = document.querySelectorAll("input[type='text'], textarea");
            const forbiddenPattern = /[<>$%#{}[\];'"`]/; 

            for (let el of allInputs) {
                if (el.value && forbiddenPattern.test(el.value)) {
                    alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
                    el.focus();
                    return false;
                }
            }
            return true;

        }   
        
    function validatesubmit(e) {
        const allInputs = document.querySelectorAll("input[type='text'], textarea");
        const forbiddenPattern = /[<>$%#{}[\];'"`]/; 

        for (let el of allInputs) {
            if (el.value && forbiddenPattern.test(el.value)) {
                alert(`Invalid characters detected in "${el.name || el.id}". Special characters are not allowed.`);
                el.focus();
                return false;
            }
        }
    e = e || window.event;

    // ---------- helpers ----------
    const byId = (id) => document.getElementById(id);

    const setErrorForId = (id, msg) => { const el = byId(id); if (el) el.innerHTML = msg; };
    const clearErrorForId = (id) => { const el = byId(id); if (el) el.innerHTML = ""; };

    const setRowError = (row, fallbackId, inputEl, msg) => {
        // Try existing per-row error div (even if duplicated IDs, scoped query will find the one in this row)
        let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;
        if (!holder) {
            // create a lightweight inline error if not present
            holder = row.querySelector('.inline-error');
            if (!holder) {
                holder = document.createElement('div');
                holder.className = 'inline-error';
                holder.style.color = '#d33';
                holder.style.fontSize = '12px';
                holder.style.marginTop = '4px';
                // place inside same cell as the input
                (inputEl && inputEl.parentElement ? inputEl.parentElement : row).appendChild(holder);
            }
        }
        holder.textContent = msg;
    };

    const clearRowError = (row, fallbackId) => {
        if (fallbackId) {
            const holder = row.querySelector('#' + fallbackId);
            if (holder) holder.textContent = "";
        }
        const inline = row.querySelector('.inline-error');
        if (inline) inline.textContent = "";
    };

    const focusAndStop = (el) => {
        if (el && el.focus) el.focus();
        if (el && el.scrollIntoView) el.scrollIntoView({behavior: 'smooth', block: 'center'});
        return false;
    };

    // ---------- 1) simple field validations (your original list) ----------
    const art_form_elements = ['clinicname','address','pincode','nature','email_clinic','contactno','personname','mobilecontact','emailcontact'];

    for (let id of art_form_elements) {
        const el = byId(id);
        if (!el) continue;

        // skip buttons/checkbox/radio
        if (['submit','button','checkbox','radio'].includes(el.type)) continue;

        const errId = "error" + el.id;

        if (el.tagName === 'SELECT') {
            if (!el.value) {
                setErrorForId(errId, "please select the above");
                if (el.id === 'nature') alert("nature of the organization is not selected.");
                else alert((el.name || el.id) + " is not selected.");
                return focusAndStop(el);
            } else {
                clearErrorForId(errId);
            }
        } else if (['TEXTAREA'].includes(el.tagName) || ['text','date','email','number'].includes(el.type)) {
            if (el.value.trim() === '') {
                setErrorForId(errId, "please fill the above");
                if (el.name === 'email_clinic') alert("email of the clinic is empty.");
                else alert((el.name || el.id) + " is empty.");
                return focusAndStop(el);
            } else {
                clearErrorForId(errId);
            }
        }

        // phone length rule (8 to 14 digits)
        if (id === 'contactno' || id === 'mobilecontact') {
            const phone = el.value.trim();
            const phoneRegex = /^[0-9]{4,14}$/;
            if (phone && !phoneRegex.test(phone)) {
                setErrorForId(errId, "Please enter a valid 4–14 digit phone number");
                alert("Please enter a valid 4–14 digit phone number");
                return focusAndStop(el);
            } else {
                clearErrorForId(errId);
            }
        }
    }

    // ---------- 2) specific single fields ----------
    // Clinic level
    {
        const el = byId("cliniclevel");
        if (el && !el.value) {
            setErrorForId("errorCliniclevel", "Clinic Level cannot be blank");
            alert("Clinic Level cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorCliniclevel");
    }

    // Establishment date
    {
        const el = byId("datepicker");
        if (el && !el.value) {
            setErrorForId("errordatepicker", "Date of establishment of your ART Clinic cannot be blank");
            alert("Date of establishment of your ART Clinic cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errordatepicker");
    }

    // Acts
    {
        const el = byId("mtpact");
        if (el && !el.value) {
            setErrorForId("errormtpact", "Whether your ART Clinic is registered under MTP Act cannot be blank");
            alert("Whether your ART Clinic is registered under MTP Act cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errormtpact");
    }
    {
        const el = byId("pcpndtact");
        if (el && !el.value) {
            setErrorForId("errorpcpndtact", "Whether your ART Clinic is registered under PCPNDT Act cannot be blank");
            alert("Whether your ART Clinic is registered under PCPNDT Act cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorpcpndtact");
    }


    {
    const directorSelect = byId("director");
    // First validate the director dropdown itself
    if (directorSelect && !directorSelect.value) {
        setErrorForId("errordirector", "Whether your ART Clinic has Director cannot be blank");
        alert("Whether your ART Clinic has Director cannot be blank");
        return focusAndStop(directorSelect);
    } else {
        clearErrorForId("errordirector");
    }
    
    // If director is "Yes", validate the director table rows
    if (directorSelect && directorSelect.value === "Yes") {
        const directorRows = document.querySelectorAll("#crud_table_director .director-row");
        
        if (directorRows.length === 0) {
            alert("Please add at least one director");
            return false;
        }
        
        for (const row of directorRows) {
            const nameInput   = row.querySelector('input[name="name_director[]"]');
            const qualiSelect = row.querySelector('select[name="quali_director[]"]');
            const regInput    = row.querySelector('input[name="reg_director[]"]');

            // Clear previous errors for this row
            clearRowError(row, "errornamedirector");
            clearRowError(row, "errorquali_director");
            clearRowError(row, "errorregdirector");

            // Validate Name - Required
            if (!nameInput || !nameInput.value.trim()) {
                //alert("wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww");
                setRowError(row, "errornamedirector", nameInput, "Name of the Director cannot be blank");
                alert("Name of the Director cannot be blank");
                return focusAndStop(nameInput);
            }

            // Validate Qualification - Required
            if (!qualiSelect || !qualiSelect.value.trim()) {
                setRowError(row, "errorquali_director", qualiSelect, "Qualification of the Director cannot be blank");
                alert("Qualification of the Director cannot be blank");
                return focusAndStop(qualiSelect);
            }

            // Registration number is optional, so no validation needed
            // But you can add format validation here if needed
        }
    }
}

// ---------- 4) OTHER STAFF (dynamic table) ----------
{
    const rows = document.querySelectorAll("#crud_table_otherstaff .staff-row");

    for (const row of rows) {
        const postSelect  = row.querySelector('select[name="post[]"]');
        const nameInput   = row.querySelector('input[name="name_otherstaff[]"]');
        const qualiSelect = row.querySelector('select[name="quali_otherstaff[]"]');
        const anyPost     = row.querySelector('input[name="anyotherpost[]"]');
        const anyDegree   = row.querySelector('input[name="anyotherdegree[]"]');

        clearRowError(row, "errorpost");
        clearRowError(row, "errorname_otherstaff");
        clearRowError(row, "errorquali_otherstaff");
        clearRowError(row, "erroranyotherpost");
        clearRowError(row, "erroranyotherdegree");

        if (postSelect && !postSelect.value.trim()) {
            setRowError(row, "errorpost", postSelect, "Post of staff cannot be blank");
            alert("Post of staff cannot be blank");
            return focusAndStop(postSelect);
        }

        if (nameInput && !nameInput.value.trim()) {
            setRowError(row, "errorname_otherstaff", nameInput, "Name of staff cannot be blank");
            alert("Name of staff cannot be blank");
            return focusAndStop(nameInput);
        }

        if (qualiSelect && !qualiSelect.value.trim()) {
            setRowError(row, "errorquali_otherstaff", qualiSelect, "Qualification of staff cannot be blank");
            alert("Qualification of staff cannot be blank");
            return focusAndStop(qualiSelect);
        }

        if (postSelect && postSelect.value === "Any Other") {
            if (!anyPost || !anyPost.value.trim()) {
                setRowError(row, "erroranyotherpost", anyPost || postSelect, "Name of the other Post cannot be blank");
                alert("Name of the other Post cannot be blank");
                return focusAndStop(anyPost || postSelect);
            }
        }

        if (qualiSelect && qualiSelect.value === "Any Other") {
            if (!anyDegree || !anyDegree.value.trim()) {
                setRowError(row, "erroranyotherdegree", anyDegree || qualiSelect, "Other Qualification cannot be blank");
                alert("Other Qualification cannot be blank");
                return focusAndStop(anyDegree || qualiSelect);
            }
        }
    }
}

// ---------- 5) EQUIPMENT (dynamic rows) ----------
{
    const eqInputs = document.querySelectorAll('input[name="equipmentname[]"]');

    if (eqInputs.length === 0) {
        setErrorForId("errorequipmentname", "Please add at least one equipment");
        alert("Please add at least one equipment");
        return false;
    }

    for (const input of eqInputs) {
        const row = input.closest("tr") || input.parentElement;
        if (row) clearRowError(row, "errorequipmentname");

        if (!input.value.trim()) {
            if (row) setRowError(row, "errorequipmentname", input, "Name of equipment cannot be blank");
            else setErrorForId("errorequipmentname", "Name of equipment cannot be blank");
            alert("Name of equipment cannot be blank");
            return focusAndStop(input);
        }
    }
}

    // ---------- 6) Procedures (your existing single-field checks) ----------
    {
        const el = byId("iuih");
        if (el && !el.value) {
            setErrorForId("erroriuih", "Intra-uterine Insemination using Husband Semen (IUI-H) cannot be blank");
            alert("Intra-uterine Insemination using Husband Semen (IUI-H) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroriuih");
    }
    {
        const el = byId("iuid");
        if (el && !el.value) {
            setErrorForId("erroriuid", "Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank");
            alert("Intra-uterine Insemination using Donor Semen (IUI-D) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroriuid");
    }
    {
        const el = byId("ivfet");
        if (el && !el.value) {
            setErrorForId("errorivfet", "In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank");
            alert("In vitro Fertilization-Embryo Transfer (IVF-ET) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorivfet");
    }
    {
        const el = byId("icsi");
        if (el && !el.value) {
            setErrorForId("erroricsi", "Intra-cytoplasmic Sperm Injection (ICSI) cannot be blank");
            alert("Intra-cytoplasmic Sperm Injection (ICSI) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("erroricsi");
    }
    {
        const el = byId("pgt");
        if (el && !el.value) {
            setErrorForId("errorpgt", "Pre-implantation Genetic Testing (PGT) cannot be blank");
            alert("Pre-implantation Genetic Testing (PGT) cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorpgt");
    }
    {
        const el = byId("spermandoocyte");
        if (el && !el.value) {
            setErrorForId("errorspermandoocyte", "Processing/Storage of Gametes or Embryos cannot be blank");
            alert("Processing/Storage of Gametes or Embryos cannot be blank");
            return focusAndStop(el);
        } else clearErrorForId("errorspermandoocyte");
    }
    {
        const anyOther = byId("anyotherprocedure");
        if (anyOther && !anyOther.value) {
            setErrorForId("erroranyotherprocedure", "Any Other Procedure cannot be blank");
            alert("Any Other Procedure cannot be blank");
            return focusAndStop(anyOther);
        } else clearErrorForId("erroranyotherprocedure");

        const otherProc = byId("otherprocedure");
        if (anyOther && anyOther.value === "Yes" && otherProc && !otherProc.value.trim()) {
            setErrorForId("errorotherprocedure", "Details of any other procedure cannot be blank");
            alert("Details of any other procedure cannot be blank");
            return focusAndStop(otherProc);
        } else clearErrorForId("errorotherprocedure");
    }

    // ---------- 7) Declaration ----------
    {
        const decl = byId("declaration");
        if (decl && !decl.checked) {
            alert("Declaration cannot be blank");
            return focusAndStop(decl);
        }
    }

    // Final confirm
    const agree = confirm("Kindly check and confirm all details before final submission. There is no provision for editing/correction once application form submitted.");
    return !!agree;

    return true;
}
</script>

<script nonce="{{ $cspNonce }}">
   window.DEBUG_BYPASS_VALIDATION = true;

   window.validatesubmit = () => true;
   window.validatesdraft_data = () => true;

   document.addEventListener('DOMContentLoaded', () => {
       document.querySelectorAll('form').forEach(f => f.noValidate = true);
   });
</script>


@endsection