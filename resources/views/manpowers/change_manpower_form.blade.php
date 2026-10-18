@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .display-none-csp-clinic-one {
            display: none;
        }

        /*.color-csp-clinic-two {
                            color: red;
                        }

                          .bc-bc-color-csp-clinic-three {
                                                                                    background-color: #0b5ed7;
                                                                                    border-color: #0b5ed7;
                                                                                    color: white;
                                                                                }

                                                                                .bc-color-csp-clinic-four {
                                                                                    border-color: #0b5ed7;
                                                                                    color: #0b5ed7;
                                                                                }

                                                                                .height-csp-clinic-five {
                                                                                    height: 20px;
                                                                                }

                                                                                .width-csp-clinic-six {
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
                                                                                    background-color: #0d6efd;
                                                                                    ;
                                                                                }
                                                                                    */

        input.form-control[readonly],
        input.form-control:disabled {
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

                    {{-- <h3>Renewal Form for Surrogacy Clinic</h3> --}}
                    <!-- Progress Bar -->
                    {{-- <div class="progress mb-4 height-csp-clinic-five">
                        <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                            role="progressbar" class="width-csp-clinic-six" aria-valuenow="50" aria-valuemin="0"
                            aria-valuemax="100">
                            Step 1 of 2
                        </div>
                    </div> --}}
                    <!-- Form -->
                    <div class="bg-light">
                        <h2 class="text-center"><b>Change in Manpower Application Form</b></h2>
                    </div>
                    <form id="surrogacy_clinicform" method="POST"
                        action="{{ route('manpower.submit_change_manpower_application') }}" enctype="multipart/form-data">
                        @csrf
                        <div id="step-1" class="step">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class=" bc-color-csp-clinic-four">General Information and Staff Details</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="control-label" for="clinicname"><strong>Name of the
                                                Clinic</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input id="clinicname" name="clinicname" placeholder="Name of Clinic"
                                                class="form-control" value="{{ $clinic->name ?? '' }}" type="text"
                                                readonly>
                                        </div>
                                        @if ($errors->has('clinicname'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('clinicname') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="address"><strong>Address</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="address" id="address" placeholder="Address"
                                                value="{{ $clinic->address ?? '' }}" class="form-control border-left-end"
                                                readonly>
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
                                        <label class="text-label form-label" for="country"><strong>Registration
                                                Number</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="country" id="country"
                                                placeholder="Registration Number" class="form-control border-left-end"
                                                value="{{ $clinic->registration_no ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="pincode"><strong>Pincode</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="pincode" placeholder="pincode" id="pincode"
                                                pattern="^[0-9]{6}$" value="{{ $clinic->pincode ?? '' }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                        @if ($errors->has('pincode'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('pincode') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="state"><strong>State</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="state" placeholder="State" id="state"
                                                value="{{ $clinic->state ?? '' }}" class="form-control border-left-end"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="district"><strong>District</strong></label>
                                        <div class="input-group" id="district-container">
                                            <input type="text" name="district" placeholder="District" id="district"
                                                value="{{ $clinic->district ?? '' }}" class="form-control border-left-end"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="nature"><strong>Nature of the
                                                Organization</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="nature" id="nature"
                                                value="{{ $clinic->nature ?? '' }}" readonly>
                                        </div>
                                        @if ($errors->has('nature'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('nature') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="email_clinic"><strong>E-mail Address the
                                                clinic</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="email" name="email_clinic" placeholder="Email"
                                                id="email_clinic" value="{{ $clinic->email ?? '' }}"
                                                class="form-control" readonly>
                                        </div>
                                        @if ($errors->has('email_clinic'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('email_clinic') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="contactno"><strong>Contact
                                                Number</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="contactno"
                                                placeholder="Contact number of clinic (11 digit)" id="contactno"
                                                value="{{ $clinic->contact_number_clinic ?? '' }}" class="form-control"
                                                pattern="^ [0-9]{11}$" required>
                                        </div>
                                        @if ($errors->has('contactno'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('contactno') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="personname"><strong>Name of the Contact
                                                Person</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="personname" placeholder="Name of contact Person"
                                                id="personname" value="{{ $clinic->contact_person_name ?? '' }}"
                                                class="form-control" pattern="[A-Za-z0-9 ]+"
                                                title="Only alphabetic characters are allowed">
                                        </div>
                                        @if ($errors->has('personname'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('personname') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="mobilecontact"><strong>Mobile
                                                Number</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="mobilecontact"
                                                placeholder="Mobile number of contact person (10 digit)"
                                                id="mobilecontact" value="{{ $clinic->mobile ?? '' }}"
                                                class="form-control" pattern="^[0-9]{10}$">
                                        </div>
                                        @if ($errors->has('mobilecontact'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('mobilecontact') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="emailcontact"><strong>E-mail
                                                Address</strong><span class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="emailcontact"
                                                placeholder="Enter a email address.." id = "emailcontact"
                                                value="{{ old('email', $draft_data->contact_person_email ?? ($clinic_data->contact_person_email ?? '')) }}"
                                                class="form-control">
                                        </div>
                                        @if ($errors->has('emailcontact'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('emailcontact') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="fax"><strong>Fax
                                                Number</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="fax" placeholder="fax number (11 Digit)"
                                                id="fax" pattern="^[0-9]{11}$" class="form-control"
                                                value="{{ $clinic->fax_number ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="website"><strong>Website</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="website" placeholder="enter the website"
                                                id="website" class="form-control"
                                                value="{{ $clinic->website ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="datepicker"><strong>1. Date of
                                                establishment of your Surrogacy Clinic</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <input type="date" name="dateestab"
                                                class="datepicker-default form-control" id="datepicker"
                                                value="{{ $clinic->date_of_establishment ?? '' }}" readonly>
                                        </div>
                                        @if ($errors->has('dateestab'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('dateestab') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="datepicker"><strong>Date of
                                                Registration</strong><span class="color-red-fourtyseven"></span></label>
                                        <div class="input-group">
                                            <input type="text" class="datepicker-default form-control"
                                                value="{{ $clinic->rgistration_date ?? '' }}" disabled>
                                            <input type="hidden" name="current_registration_date"
                                                value="{{ $clinic->rgistration_date ?? '' }}">
                                            <input type="hidden" name="original_rgistration_date"
                                                value="{{ $clinic->rgistration_date ?? '' }}">
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
                                        <label class="text-label form-label" for="mtpact"><strong>2.
                                                Whether your Surrogacy Clinic is registered under MTP Act</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <select name="mtpact" id="mtpact"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"
                                                    {{ $clinic->clinic_reg_mpt === 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No"
                                                    {{ $clinic->clinic_reg_mpt === 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        @if ($errors->has('mtpact'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('mtpact') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="pcpndtact"><strong>3. Whether your
                                                Surrogacy Clinic is registered under PCPNDT Act</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <select name="pcpndtact" id="pcpndtact"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"
                                                    {{ $clinic->clinic_reg_pcpndt === 'Yes' ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="No"
                                                    {{ $clinic->clinic_reg_pcpndt === 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        @if ($errors->has('pcpndtact'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('pcpndtact') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="director"><strong>4.Whether your
                                                Surrogacy Clinic has Director</strong><span
                                                class="color-csp-clinic-two">*</span></label>
                                        <div class="input-group">
                                            <select id="director" name="director"
                                                class="nice-select default-select wide form-control solid">
                                                <option value="">Select</option>
                                                <option value="Yes"
                                                    {{ $clinic->clinic_director === 'Yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="No"
                                                    {{ $clinic->clinic_director === 'No' ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                        @if ($errors->has('director'))
                                            <div class="color-csp-clinic-two">
                                                <strong>{{ $errors->first('director') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div id="directory" data-section="directors"
                                    class="col-xs-12 form-group display-none-csp-clinic-one" id="directors-section">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="crud_table_director">
                                            <tr>
                                                <th>Name<span class="color-csp-clinic-two">*</span></th>
                                                <th>Qualification<span class="color-csp-clinic-two">*</span></th>
                                                <th>Registration No. (if applicable)</th>
                                                <th></th>
                                            </tr>
                                            @forelse($clinicDirector as $index => $director)
                                                <tr class="director-row" id="drow{{ $index + 1 }}">
                                                    <td>
                                                        <input type="text" name="name_director[]" class="form-control"
                                                            value="{{ $director->name_director ?? '' }}">
                                                        @error('name_director.' . $loop->index)
                                                            <strong><span
                                                                    class="text-danger">{{ $message }}</span></strong>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <select name="quali_director[]" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach (['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'] as $q)
                                                                <option value="{{ $q }}"
                                                                    {{ ($director->quali_director ?? '') == $q ? 'selected' : '' }}>
                                                                    {{ $q }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('quali_director.' . $index)
                                                            <strong><span
                                                                    class="text-danger">{{ $message }}</span></strong>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="text" name="reg_director[]" class="form-control"
                                                            value="{{ $director->reg_director ?? '' }}">
                                                        @error('reg_director.' . $index)
                                                            <strong><span
                                                                    class="text-danger">{{ $message }}</span></strong>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <button type="button" id="{{ $index + 1 }}"
                                                            class="btn btn-danger btn_remove1">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="director-row" id="drow1">
                                                    <td><input type="text" name="name_director[]"
                                                            class="form-control">

                                                    </td>
                                                    <td>
                                                        <select name="quali_director[]" class="form-control">
                                                            <option value="">Select</option>
                                                            @foreach (['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'] as $q)
                                                                <option value="{{ $q }}">{{ $q }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="reg_director[]" class="form-control">
                                                    </td>
                                                    <td>
                                                    </td>

                                                    </td>
                                                </tr>
                                            @endforelse
                                        </table>

                                        <div align="right">
                                            <button type="button" name="adddirector" id="adddirector"
                                                class="btn-xs bc-bc-color-csp-clinic-three"><i
                                                    class="fa fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                {{-- for staff  --}}
                                @php
                                    $staffData = old('post')
                                        ? collect(old('post'))->map(function ($post, $i) {
                                            return [
                                                'post' => $post,
                                                'anyotherpost' => old('anyotherpost.' . $i),
                                                'name' => old('name.' . $i),
                                                'quali_otherstaff' => old('quali_otherstaff.' . $i),
                                                'anyotherdegree' => old('anyotherdegree.' . $i),
                                                'regno' => old('regno.' . $i),
                                            ];
                                        })
                                        : $staff ?? collect([[]]); // ensures at least one row
                                @endphp
                                {{-- @php    dd($otherStaffData); @endphp --}}
                                <p><u>A. Existing Staff</u></p>
                                <div id="otherstaff" class="col-xs-12 form-group">
                                    <label class="control-label"><strong>5. Provide details of the staff.</strong></label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="crud_table_otherstaff1">
                                            <thead>
                                                <tr>
                                                    <th>Post<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Name<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Qualification<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Reg No</th>
                                                    <th>Expiry Date</th>
                                                    <th>Reason for Change</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staffData as $i => $row)
                                                    <tr class="staff-row">
                                                        <td>
                                                            <select name="post_existing[]" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Gynecologist"
                                                                    {{ ($row['post_existing'] ?? '') == 'Gynecologist' ? 'selected' : '' }}>
                                                                    Gynecologist</option>
                                                                <option value="Andrologist"
                                                                    {{ ($row['post_existing'] ?? '') == 'Andrologist' ? 'selected' : '' }}>
                                                                    Andrologist</option>
                                                                <option value="Clinical Embryologist"
                                                                    {{ ($row['post_existing'] ?? '') == 'Clinical Embryologist' ? 'selected' : '' }}>
                                                                    Clinical Embryologist</option>
                                                                <option value="Counselor"
                                                                    {{ ($row['post_existing'] ?? '') == 'Counselor' ? 'selected' : '' }}>
                                                                    Counselor</option>
                                                                <option value="Anesthetist"
                                                                    {{ ($row['post_existing'] ?? '') == 'Anesthetist' ? 'selected' : '' }}>
                                                                    Anesthetist</option>
                                                                <option value="Any Other"
                                                                    {{ ($row['post_existing'] ?? '') == 'Any Other' ? 'selected' : '' }}>
                                                                    Any Other</option>
                                                            </select>
                                                            <div id="errorpost_existing" class="color-csp-clinic-two">
                                                            </div>
                                                            <input type="text" name="anyotherpost_existing[]"
                                                                value="{{ $row['post_existing'] ?? '' }}"
                                                                placeholder="Specify other post_existing"
                                                                class="form-control {{ ($row['post_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            <div id="erroranyotherpost_existing"
                                                                class="color-csp-clinic-two">
                                                            </div>
                                                        </td>





                                                        {{--  --}}
                                                        <td><input type="text" name="name_otherstaff[]"
                                                                value="{{ $row['name'] ?? '' }}" class="form-control">
                                                            <div id="errorname_otherstaff" class="color-csp-clinic-two">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select name="quali_otherstaff_existing[]"
                                                                class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Doctorate"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Doctorate' ? 'selected' : '' }}>
                                                                    Doctorate</option>
                                                                <option value="Post Graduate"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>
                                                                    Post Graduate</option>
                                                                <option value="Graduate"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Graduate' ? 'selected' : '' }}>
                                                                    Graduate</option>
                                                                <option value="Diploma"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Diploma' ? 'selected' : '' }}>
                                                                    Diploma</option>
                                                                <option value="Under Graduate"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Under Graduate' ? 'selected' : '' }}>
                                                                    Under Graduate</option>
                                                                <option value="Any Other"
                                                                    {{ ($row['qualification_existing'] ?? '') == 'Any Other' ? 'selected' : '' }}>
                                                                    Any Other</option>
                                                            </select>
                                                            <div id="errorquali_otherstaff" class="color-csp-clinic-two">
                                                            </div>
                                                            <input type="text" name="anyotherdegree[]"
                                                                value="{{ $row['qualification_existing'] ?? '' }}"
                                                                placeholder="Specify degree"
                                                                class="form-control {{ ($row['quali_otherstaff_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            <div id="erroranyotherdegree" class="color-csp-clinic-two">
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="regno[]"
                                                                value="{{ $row['regno'] ?? '' }}" class="form-control">
                                                        </td>
                                                        <td><input type="date" name="expirydate[]"
                                                                value="{{ $row['expirydate'] ?? '' }}"
                                                                class="form-control">
                                                        </td>
                                                        <td><input type="text" name="reasonforchange[]"
                                                                value="{{ $row['reasonforchange'] ?? '' }}"
                                                                class="form-control">
                                                        </td>
                                                        {{-- <td><button type="button"
                                                                class="btn btn-danger btn-sm remove-row"> <i
                                                                    class="fa fa-trash"></i></button>
                                                                </td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <div align="right">
                                            <button type="button" name="addotherstaff" id="addotherstaff"
                                                class="btn-xs bc-bc-color-csp-clinic-three">+</button>
                                        </div> --}}
                                    </div>
                                </div>

                                <p><u>B. New Staff</u></p>
                                <div id="otherstaff" class="col-xs-12 form-group">
                                    <label class="control-label"><strong> Provide details of the staff.</strong></label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="crud_table_otherstaff">
                                            <thead>
                                                <tr>
                                                    <th>Post<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Name<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Qualification<span class="color-csp-clinic-two">*</span></th>
                                                    <th>Reg No</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($staffData as $i => $row)
                                                    <tr class="staff-row">
                                                        <td>
                                                            <select name="post[]" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Gynecologist"
                                                                    {{ ($row['post'] ?? '') == 'Gynecologist' ? 'selected' : '' }}>
                                                                    Gynecologist</option>
                                                                <option value="Andrologist"
                                                                    {{ ($row['post'] ?? '') == 'Andrologist' ? 'selected' : '' }}>
                                                                    Andrologist</option>
                                                                <option value="Clinical Embryologist"
                                                                    {{ ($row['post'] ?? '') == 'Clinical Embryologist' ? 'selected' : '' }}>
                                                                    Clinical Embryologist</option>
                                                                <option value="Counselor"
                                                                    {{ ($row['post'] ?? '') == 'Counselor' ? 'selected' : '' }}>
                                                                    Counselor</option>
                                                                <option value="Anesthetist"
                                                                    {{ ($row['post'] ?? '') == 'Anesthetist' ? 'selected' : '' }}>
                                                                    Anesthetist</option>
                                                                <option value="Any Other"
                                                                    {{ ($row['post'] ?? '') == 'Any Other' ? 'selected' : '' }}>
                                                                    Any Other</option>
                                                            </select>
                                                            <div id="errorpost" class="color-csp-clinic-two"></div>
                                                            <input type="text" name="anyotherpost[]"
                                                                value="{{ $row['post'] ?? '' }}"
                                                                placeholder="Specify other post"
                                                                class="form-control {{ ($row['post'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            <div id="erroranyotherpost" class="color-csp-clinic-two">
                                                            </div>
                                                        </td>





                                                        {{--  --}}
                                                        <td><input type="text" name="name_otherstaff[]"
                                                                value="{{ $row['name'] ?? '' }}" class="form-control">
                                                            <div id="errorname_otherstaff" class="color-csp-clinic-two">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select name="quali_otherstaff[]" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Doctorate"
                                                                    {{ ($row['qualification'] ?? '') == 'Doctorate' ? 'selected' : '' }}>
                                                                    Doctorate</option>
                                                                <option value="Post Graduate"
                                                                    {{ ($row['qualification'] ?? '') == 'Post Graduate' ? 'selected' : '' }}>
                                                                    Post Graduate</option>
                                                                <option value="Graduate"
                                                                    {{ ($row['qualification'] ?? '') == 'Graduate' ? 'selected' : '' }}>
                                                                    Graduate</option>
                                                                <option value="Diploma"
                                                                    {{ ($row['qualification'] ?? '') == 'Diploma' ? 'selected' : '' }}>
                                                                    Diploma</option>
                                                                <option value="Under Graduate"
                                                                    {{ ($row['qualification'] ?? '') == 'Under Graduate' ? 'selected' : '' }}>
                                                                    Under Graduate</option>
                                                                <option value="Any Other"
                                                                    {{ ($row['qualification'] ?? '') == 'Any Other' ? 'selected' : '' }}>
                                                                    Any Other</option>
                                                            </select>
                                                            <div id="errorquali_otherstaff" class="color-csp-clinic-two">
                                                            </div>
                                                            <input type="text" name="anyotherdegree[]"
                                                                value="{{ $row['qualification'] ?? '' }}"
                                                                placeholder="Specify degree"
                                                                class="form-control {{ ($row['quali_otherstaff'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            <div id="erroranyotherdegree" class="color-csp-clinic-two">
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="regno[]"
                                                                value="{{ $row['regno'] ?? '' }}" class="form-control">
                                                        </td>
                                                        <td><button type="button"
                                                                class="btn btn-danger btn-sm remove-row"> <i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div align="right">
                                            <button type="button" name="addotherstaff" id="addotherstaff"
                                                class="btn-xs bc-bc-color-csp-clinic-three btn btn-primary">+</button>
                                        </div>
                                    </div>
                                </div>


                                {{-- </div>
                            <button type="button" class="btn btn-primary bc-bc-color-csp-clinic-three" id="next-step">Next</button>
                        </div> --}}
                                <!-- Step 2 -->
                                {{-- <div id="step-2" class="step d-none"> --}}
                                <div class="row">
                                    @php
                                        $equipmentsData = old('equipmentname')
                                            ? collect(old('equipmentname'))->map(
                                                fn($eq) => (object) ['equipmentname' => $eq],
                                            )
                                            : $equipment ?? collect([(object) ['equipmentname' => '']]);
                                        // dd( $equipmentsData);
                                    @endphp
                                    <h3 class="bc-color-csp-clinic-four">Procedures</h3>
                                    <div id="equipment" class="col-xs-12 form-group">
                                        <label class="control-label">6. Provide list of Equipment's</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="crud_table_equipments">
                                                <tr>
                                                    <th>Name of Equipments<span class="color-csp-clinic-two">*</span></th>
                                                    <th></th>
                                                </tr>

                                                @forelse($equipmentsData as $i => $row)
                                                    <tr class="equipment-row" id="row1{{ $i + 1 }}">
                                                        <td>
                                                            <input type="text" id="equipmentname"
                                                                name="equipmentname[]"
                                                                value="{{ $row->equipmentname ?? '' }}" placeholder=""
                                                                class="form-control">
                                                            <div id="errorequipmentname" class="color-csp-clinic-two">
                                                            </div>
                                                            @error('equipmentname.' . $i)
                                                                <div class="color-csp-clinic-two">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <button type="button" id="{{ $i + 1 }}"
                                                                class="btn btn-danger btn_remove_addEQ">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- Show one empty row by default --}}
                                                    <tr id="row11" class="equipment-row">
                                                        <td>
                                                            <input type="text" id="equipmentname"
                                                                name="equipmentname[]" value="" placeholder=""
                                                                class="form-control">
                                                            <div id="errorequipmentname" class="color-csp-clinic-two">
                                                            </div>
                                                            @error('equipmentname.0')
                                                                <div class="color-csp-clinic-two">
                                                                    <strong>{{ $message }}</strong>
                                                                </div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            {{-- <button type="button" id="1" class="btn btn-danger btn_remove_addEQ">
                    <i class="fa fa-trash"></i>
                </button> --}}
                                                        </td>
                                                    </tr>
                                                @endforelse
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
                                                <label class="text-label form-label" for="iuih"><strong>i).
                                                        Intra-uterine Insemination using Husband Semen (IUI-H)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuih" id="iuih"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('iui_h_s', $draft_data->iuih ?? ($clinic_data->iui_h_s ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('iui_h_s', $draft_data->iuih ?? ($clinic_data->iui_h_s ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="iuid"><strong>ii).
                                                        Intra-uterine Insemination using
                                                        Donor Semen (IUI-D)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="iuid" id="iuid"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('iui_d_s', $draft_data->iuid ?? ($clinic_data->iui_d_s ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('iui_d_s', $draft_data->iuid ?? ($clinic_data->iui_d_s ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="ivfet"><strong>iii). In vitro
                                                        Fertilization-Embryo
                                                        Transfer (IVF-ET)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="ivfet" id="ivfet"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('ivf_et', $draft_data->ivfet ?? ($clinic_data->ivf_et ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('ivf_et', $draft_data->ivfet ?? ($clinic_data->ivf_et ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="icsi"><strong>iv).
                                                        Intra-cytoplasmic Sperm Injection (ICSI)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="icsi" id="icsi"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('icsi', $draft_data->icsi ?? ($clinic_data->icsi ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('icsi', $draft_data->icsi ?? ($clinic_data->icsi ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="pgt"><strong>v).
                                                        Pre-implantation Genetic Testing (PGT)<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="pgt" id="pgt"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('pgt', $draft_data->pgt ?? ($clinic_data->pgt ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('pgt', $draft_data->pgt ?? ($clinic_data->pgt ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="spermandoocyte"><strong>vi).
                                                        Processing or Storage of Gametes (sperm & oocyte)of the Patient
                                                        and
                                                        or embryos of patient<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="spermandoocyte" id="spermandoocyte"
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('spermandoocyte', $draft_data->spermandoocyte ?? ($clinic_data->sperm_oocyte ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('spermandoocyte', $draft_data->spermandoocyte ?? ($clinic_data->sperm_oocyte ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                                <label class="text-label form-label" for="anyotherprocedure"><strong>vii).
                                                        Any
                                                        Other Procedure<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <select name="anyotherprocedure" id='anyotherprocedure'
                                                        class="nice-select default-select wide form-control solid">
                                                        <option value="">Select</option>
                                                        <option value="Yes"
                                                            {{ old('anyotherprocedure', $draft_data->anyotherprocedure ?? ($clinic_data->any_other_procedure ?? '')) == 'Yes' ? 'selected' : '' }}>
                                                            Yes</option>
                                                        <option value="No"
                                                            {{ old('anyotherprocedure', $draft_data->anyotherprocedure ?? ($clinic_data->any_other_procedure ?? '')) == 'No' ? 'selected' : '' }}>
                                                            No</option>
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
                                            <div class="mb-3 display-none-csp-clinic-one" id='anyotherprocedurey'>
                                                <label class="text-label form-label" for="otherprocedure"><strong>If yes,
                                                        please specify<span
                                                            class="color-csp-clinic-two">*</span></strong></label>
                                                <div class="input-group">
                                                    <input type="text" id="otherprocedure" name="otherprocedure"
                                                        placeholder=""
                                                        value="{{ old('otherprocedure', $draft_data->otherprocedure ?? ($clinic_data->otherprocedure ?? '')) }}"
                                                        class="form-control">
                                                </div>
                                                <div id="errorotherprocedure" class="color-csp-clinic-two"></div>


                                                @if ($errors->has('otherprocedure'))
                                                    <div class="color-csp-clinic-two">
                                                        <strong>{{ $errors->first('otherprocedure') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="otherdetails" class="form-label"><strong>8. Any other
                                                        details</strong></label>
                                                <textarea class="form-control" id="otherdetails" name="otherdetails" rows="4" cols="163">{{ old('otherdetails', $draft_data->otherdetails ?? ($clinic_data->any_other_detail ?? '')) }}</textarea>
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
                                            <input type="checkbox" id="declaration" name="declaration"> <b> I hereby
                                                declare that the entries in this form and the additional particulars , if
                                                any,furnished herewith are true to the best of my knowledge and belief.<span
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
                                <div class="table-responsive">
                                    <button type="button" class="btn btn-secondary bc-bc-color-csp-clinic-three"
                                        id="prev-step">Back</button>
                                    <button type="submit" id="draftButton" name="submit_type" value="draft"
                                        class="btn btn-success bc-bc-color-csp-clinic-three">Save As draft</button>
                                    <button type="submit" id="submitButton" name="submit_type" value="final"
                                        class="btn btn-success bc-bc-color-csp-clinic-three">Submit</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            quali_otherpost = $("select[name='post[]']");
            quali_otherpost.change(function() {
                let input = this.closest('td').querySelector("input[name='anyotherpost[]']");
                if (this.value === 'Any Other') {
                    input.classList.remove('display-none-csp-clinic-one');
                } else {
                    input.classList.add('display-none-csp-clinic-one');
                }
            });

            $('#addotherstaff').click(function() {
                let newRow = $('#crud_table_otherstaff .staff-row:first').clone();
                newRow.find('input, select').val(''); // Clear input values
                $('#crud_table_otherstaff').append(newRow);
            });
            $(document).on('click', '.remove-row', function() {
                if ($('#crud_table_otherstaff .staff-row').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert("At least one row must be present.");
                }
            });
            
            quali_otherstaff = $("select[name='quali_otherstaff[]']");
            quali_otherstaff.change(function() {
                let input = this.closest('td').querySelector("input[name='anyotherdegree[]']");
                if (this.value === 'Any Other') {
                    alert('sdfdsf');
                    input.classList.remove('display-none-csp-clinic-one');
                } else {
                    alert('234');
                    input.classList.add('display-none-csp-clinic-one');
                }
            });
        });
    </script>
@endsection
