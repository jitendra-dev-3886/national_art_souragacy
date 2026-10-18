@extends('layouts.clinic.clinic_master')
@section('content')
    <style nonce="{{ $cspNonce }}">
        .display-none-csp-clinic-one {
            display: none;
        }

        input.form-control[readonly],
        input.form-control:disabled {
            background-color: #f8f8f8;
            border: 1px solid #f3f1f1;
            cursor: not-allowed;
        }

        .table thead tr th:last-child {
            text-align: start !important;
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
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    {{-- @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif --}}
                    <div class="border mb-2 text-center">
                        {{-- <h3 class="m-3"><b>ART Clinic Application form for Change Manpower</b></h3> --}}
                        <h3 class="m-3"><b>{{ $title ?? '' }}</b></h3>
                    </div>
                    <form id="surrogacy_clinicform" method="POST"
                        action="{{ route('manpower.submit_change_manpower_application') }}" enctype="multipart/form-data">
                        @csrf
                        @if (!empty($drftApplicationCheck))
                            <input type="hidden" id="id" name="id"
                                value="{{ $drftApplicationCheck->id ?? '' }}">
                        @endif
                        <input type="hidden" id="clinic_id" name="clinic_id"
                            value="{{ $clinic->clinic_id ?? $drftApplicationCheck->clinic_id }}">
                        <input type="hidden" id="application_no" name="application_no"
                            value="{{ $clinic->application_no ?? $drftApplicationCheck->application_no }}">
                        <input type="hidden" id="email" name="email"
                            value="{{ $clinic->email ?? $drftApplicationCheck->email }}">
                        <input type="hidden" id="mobile" name="mobile"
                            value="{{ $clinic->mobile ?? $drftApplicationCheck->mobile }}">
                        <input type="hidden" id="userid_applicant" name="userid_applicant"
                            value="{{ $clinic->userid_applicant ?? $drftApplicationCheck->userid_applicant }}">

                        <div id="step-1" class="step">
                            <p class="bg-light text-dark p-2">Note: Fields marked with * are Mandatory</p>
                            <div class="row">
                                <div class="col-md-3">
                                    <h6 class="bg-dark text-white p-2">Clinic Details (As per Registered)</h6>
                                </div>
                                <div class="col-md-9">
                                    <hr>
                                </div>
                            </div>
                            <div class="row border p-3 m-2">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="registration_no"><strong>Registration
                                                Number</strong><span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="registration_no" id="registration_no"
                                                placeholder="Registration Number" class="form-control border-left-end"
                                                value="{{ $clinic->registration_no ?? $drftApplicationCheck->registration_no }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="control-label" for="clinicname"><strong>Name of the
                                                Clinic</strong><span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="clinicname" name="clinicname" placeholder="Name of Clinic"
                                                class="form-control"
                                                value="{{ $clinic->name ?? $drftApplicationCheck->clinicname }}"
                                                type="text" readonly>
                                        </div>
                                        @if ($errors->has('clinicname'))
                                            <div class="text-danger">
                                                <strong>{{ $errors->first('clinicname') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @php
                                     $clinictype = $clinic->clinic_type ?? $drftApplicationCheck->clinic_type ;
                                    @endphp
                                    <div class="mb-3">
                                        <label class="control-label" for="clinictype"><strong>Type of Clinic</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input id="clinictype" placeholder="Type of Clinic"
                                                class="form-control"
                                                value="{{ match ($clinictype) {
                                                            'ARTCLINIC' => 'ART Clinic',
                                                            'ARTBANK' => 'ART Bank',
                                                            'ARTSURROGACY' => 'Surrogacy Clinic',
                                                            default => 'Clinic',
                                                        } }}"
                                                type="text" readonly>
                                                <input type="hidden" name="clinic_type"
                                                value="{{ $clinictype }}">
                                        </div>
                                        @if ($errors->has('clinic_type'))
                                            <div class="text-danger">
                                                <strong>{{ $errors->first('clinic_type') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="datepicker"><strong>Date of
                                                Registration</strong><span class="color-red-fourtyseven"></span></label>
                                        <div class="input-group">
                                            @php
                                                $registrationDate =
                                                    $clinic->rgistration_date ??
                                                    ($drftApplicationCheck->current_registration_date ?? null);
                                            @endphp
                                            <input type="text" class="datepicker-default form-control"
                                                value="{{ $registrationDate ? date('d-m-Y', strtotime($registrationDate)) : '' }}"
                                                disabled>
                                            <input type="hidden" name="current_registration_date"
                                                value="{{ $clinic->rgistration_date ?? $drftApplicationCheck->current_registration_date }}">
                                            <input type="hidden" name="original_rgistration_date"
                                                value="{{ $clinic->rgistration_date ?? $drftApplicationCheck->current_registration_date }}">
                                        </div>
                                        <div id="errordatepicker" class="color-red-fourtyseven"></div>
                                        @if ($errors->has('original_rgistration_date'))
                                            <div class="color-red-fourtyseven">
                                                <strong>{{ $errors->first('original_rgistration_date') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="address"><strong>Address</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="address" id="address" placeholder="Address"
                                                value="{{ $clinic->address ?? $drftApplicationCheck->address }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                        <div id="erroraddress" class="text-danger"></div>
                                        @if ($errors->has('address'))
                                            <div class="text-danger">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="pincode"><strong>Pincode</strong><span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="pincode" placeholder="pincode" id="pincode"
                                                pattern="^[0-9]{6}$"
                                                value="{{ $clinic->pincode ?? $drftApplicationCheck->pincode }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                        @if ($errors->has('pincode'))
                                            <div class="text-danger">
                                                <strong>{{ $errors->first('pincode') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label" for="state"><strong>State</strong></label>
                                        <div class="input-group">
                                            <input type="text" name="state" placeholder="State" id="state"
                                                value="{{ $clinic->state ?? $drftApplicationCheck->state }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="district"><strong>District</strong></label>
                                        <div class="input-group" id="district-container">
                                            <input type="text" name="district" placeholder="District" id="district"
                                                value="{{ $clinic->district ?? $drftApplicationCheck->district }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="text-label form-label"
                                            for="district"><strong>Nature</strong></label>
                                        <div class="input-group" id="district-container">
                                            <input type="text" name="nature" placeholder="nature" id="nature"
                                                value="{{ $clinic->nature ?? $drftApplicationCheck->nature }}"
                                                class="form-control border-left-end" readonly>
                                        </div>
                                    </div>
                                </div>
                                @if ($clinic->level ?? !empty($drftApplicationCheck->level))
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="text-label form-label"
                                                for="district"><strong>Level</strong></label>
                                            <div class="input-group" id="district-container">
                                                <input type="text" name="level" placeholder="level" id="level"
                                                    value="{{ $clinic->level ?? $drftApplicationCheck->level }}"
                                                    class="form-control border-left-end" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php $clinicType = $drftApplicationCheck?->clinic_type ?? $clinic->clinic_type; @endphp
                            @if (($clinic->clinic_type ?? ($drftApplicationCheck->clinic_type ?? '')) == 'ARTBANK')
                            @else
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <h6 class="bg-dark text-white p-2">Director Change Details </h6>
                                    </div>
                                    <div class="col-md-9">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row border p-3 m-2">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="text-label form-label" for="director"><strong>Whether your
                                                    {{ match ($clinicType) {
                                                        'ARTCLINIC' => 'ART Clinic',
                                                        'ARTSURROGACY' => 'Surrogacy Clinic',
                                                        default => 'Clinic',
                                                    } }}
                                                    has Director</strong><span class="text-danger">*</span></label>
                                            <div class="input-group">

                                                <input type="text" class="form-control" name="director"
                                                    value="{{ $clinic->clinic_director ?? ($drftApplicationCheck->clinic_director ?? '') }}"
                                                    readonly>

                                            </div>
                                            @if ($errors->has('director'))
                                                <div class="text-danger">
                                                    <strong>{{ $errors->first('director') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="text-label form-label" for="director"><strong>Is Director
                                                    Change ?</strong></label>
                                            <div class="input-group">
                                                {{-- <input type="checkbox" class="form-check-input directorcheckbutton"
                                                {{ !empty($drftApplicationCheck) && $drftApplicationCheck->director_checked ? 'checked' : '' }}
                                                value="1" name="director_checked"> --}}
                                                <select name="director_checked" id=""
                                                    class="form-control directorcheckbutton">
                                                    <option value="">Select</option>
                                                    <option value="yes"
                                                        {{ old('director_checked', $drftApplicationCheck->director_checked ?? '') == 'yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="no"
                                                        {{ old('director_checked', $drftApplicationCheck->director_checked ?? '') == 'no' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('director'))
                                                <div class="text-danger">
                                                    <strong>{{ $errors->first('director') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="directorShowAndhide">
                                        <p
                                            class="text-dark {{ ($clinic->clinic_director ?? !empty($drftApplicationCheck->clinic_director)) == 'Yes' ? '' : 'display-none-csp-clinic-one' }}">
                                            <u class="bg-light p-2">A. Existing Director</u></p>
                                        <div id="directory" data-section="directors"
                                            class="col-xs-12 form-group {{ ($clinic->clinic_director ?? !empty($drftApplicationCheck->clinic_director)) == 'Yes' ? '' : 'display-none-csp-clinic-one' }} "
                                            id="directors-section">
                                            <div class="table-responsive">

                                                <table class="table table-bordered" id="crud_table_director1">
                                                    <tr>
                                                        <th>Name<span class="text-danger">*</span></th>
                                                        <th>Qualification<span class="text-danger">*</span></th>
                                                        <th>Registration No. (if applicable)</th>
                                                        <th>Relieving Date</th>
                                                    </tr>
                                                    @php
                                                        if (!empty($drftApplicationCheck)) {
                                                            $directorsData = $directors_cm;
                                                        } else {
                                                            $directorsData = $clinicDirector;
                                                        }
                                                    @endphp

                                                    @foreach ($directorsData as $index => $director)
                                                        @if ($director->type == 'existing')
                                                            <tr class="director-row" id="drow{{ $index + 1 }}">
                                                                <td>
                                                                    <input type="text" name="name_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->name_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="quali_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->quali_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="reg_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->reg_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="expiry_director[]"
                                                                        class="form-control date-input"
                                                                        value="{{ old('expiry_director.' . $index, $director->expiry_date ?? '') }}"
                                                                        max="{{ date('Y-m-d') }}">
                                                                </td>
                                                            </tr>
                                                        @elseif($director->type == '')
                                                            <tr class="director-row" id="drow{{ $index + 1 }}">
                                                                <td>
                                                                    <input type="text" name="name_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->name_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="quali_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->quali_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="reg_director_existing[]"
                                                                        class="form-control"
                                                                        value="{{ $director->reg_director ?? '' }}"
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="expiry_director[]"
                                                                        class="form-control"
                                                                        value="{{ old('expiry_director.' . $index, $director->expiry_date ?? '') }}"
                                                                        max="{{ date('Y-m-d') }}">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </div>


                                            <p class="text-dark "><u class="bg-light p-2">B. New Director</u></p>
                                            <div id="directory" data-section="directors"
                                                class="col-xs-12 form-group {{ ($clinic->clinic_director ?? !empty($drftApplicationCheck->clinic_director)) == 'Yes' ? '' : 'display-none-csp-clinic-one' }} "
                                                id="directors-section">
                                                <div class="table-responsive">
                                                    @php
                                                        $directorsData = old('name_director')
                                                            ? collect(old('name_director'))
                                                                ->map(function ($name, $i) {
                                                                    return [
                                                                        'name_director' => $name,
                                                                        'quali_director' => old('quali_director.' . $i),
                                                                        'reg_director' => old('reg_director.' . $i),
                                                                        'expiry_director' => old(
                                                                            'expiry_director.' . $i,
                                                                        ),
                                                                        'type' => '',
                                                                    ];
                                                                })
                                                                ->toArray()
                                                            : collect($directors_cm ?? [])
                                                                ->map(function ($director) {
                                                                    return [
                                                                        'name_director' =>
                                                                            $director->name_director ?? '',
                                                                        'quali_director' =>
                                                                            $director->quali_director ?? '',
                                                                        'reg_director' => $director->reg_director ?? '',
                                                                        'expiry_director' =>
                                                                            $director->expiry_director ?? '',
                                                                        'type' => $director->type ?? '',
                                                                    ];
                                                                })
                                                                ->toArray();

                                                        // dd($directorsData);

                                                    @endphp
                                                    <table class="table table-bordered" id="crud_table_director">
                                                        <tr>
                                                            <th>Name<span class="text-danger">*</span></th>
                                                            <th>Qualification<span class="text-danger">*</span></th>
                                                            <th>Registration No. (if applicable)</th>
                                                            <th></th>
                                                        </tr>

                                                        @forelse($directorsData as $index => $director)
                                                            @if ($director['type'] == 'new')
                                                                <tr class="director-row" id="drow{{ $index + 1 }}">
                                                                    <td>
                                                                        <input type="text" name="name_director[]"
                                                                            class="form-control"
                                                                            value="{{ $director['name_director'] ?? '' }}">
                                                                        @error('name_director.' . $loop->index)
                                                                            <strong><span
                                                                                    class="text-danger">{{ $message }}</span></strong>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <select name="quali_director[]"
                                                                            class="form-control">
                                                                            <option value="">Select</option>
                                                                            @foreach (['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'] as $q)
                                                                                <option value="{{ $q }}"
                                                                                    {{ ($director['quali_director'] ?? '') == $q ? 'selected' : '' }}>
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
                                                                        <input type="text" name="reg_director[]"
                                                                            class="form-control"
                                                                            value="{{ $director['reg_director'] ?? '' }}">
                                                                        @error('reg_director.' . $index)
                                                                            <strong><span
                                                                                    class="text-danger">{{ $message }}</span></strong>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" id="{{ $index + 1 }}"
                                                                            class="btn btn-danger btn-sm btn_remove1">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @elseif($director['type'] == '')
                                                                <tr class="director-row" id="drow{{ $index + 1 }}">
                                                                    <td>
                                                                        <input type="text" name="name_director[]"
                                                                            class="form-control"
                                                                            value="{{ $director['name_director'] ?? '' }}">
                                                                        @error('name_director.' . $loop->index)
                                                                            <strong><span
                                                                                    class="text-danger">{{ $message }}</span></strong>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <select name="quali_director[]"
                                                                            class="form-control">
                                                                            <option value="">Select</option>
                                                                            @foreach (['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'] as $q)
                                                                                <option value="{{ $q }}"
                                                                                    {{ ($director['quali_director'] ?? '') == $q ? 'selected' : '' }}>
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
                                                                        <input type="text" name="reg_director[]"
                                                                            class="form-control"
                                                                            value="{{ $director['reg_director'] ?? '' }}">
                                                                        @error('reg_director.' . $index)
                                                                            <strong><span
                                                                                    class="text-danger">{{ $message }}</span></strong>
                                                                        @enderror
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" id="{{ $index + 1 }}"
                                                                            class="btn btn-danger btn-sm btn_remove1">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @empty
                                                            <tr class="director-row" id="drow1">
                                                                <td><input type="text" name="name_director[]"
                                                                        class="form-control">
                                                                </td>
                                                                <td>
                                                                    <select name="quali_director[]" class="form-control">
                                                                        <option value="">Select</option>
                                                                        @foreach (['PhD', 'DM', 'MCh', 'PG', 'MD', 'MS', 'DNB'] as $q)
                                                                            <option value="{{ $q }}">
                                                                                {{ $q }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="reg_director[]"
                                                                        class="form-control">
                                                                </td>
                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm btn_remove1">
                                                                        <i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </table>
                                                    <div align="left">
                                                        <button type="button" name="adddirector" id="adddirector"
                                                            class="btn-xs bc-bc-color-csp-clinic-three btn btn-primary"><i
                                                                class="fa fa fa-plus "></i> Add More Directors</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- for staff  --}}
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <h6 class="bg-dark text-white p-2">Manpower Change Details</h6>
                                </div>
                                <div class="col-md-9">
                                    <hr>
                                </div>
                            </div>
                            <div id="otherstaff" class="col-xs-12 form-group p-3 border m-2">
                                <p class="text-dark "><u class="bg-light p-2">A. Existing Staff</u></p>
                                <label class="control-label"><strong>Provide details of the staff.</strong></label>
                                <div class="table-responsive">

                                    <table class="table table-bordered" id="crud_table_otherstaff1">
                                        <thead>
                                            <tr>
                                                <th>Post<span class="text-danger">*</span></th>
                                                <th>Name<span class="text-danger">*</span></th>
                                                <th>Qualification<span class="text-danger">*</span></th>
                                                <th>Reg No</th>
                                                <th>Relieving Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // dd($drftApplicationCheck);
                                                if (!empty($drftApplicationCheck)) {
                                                    $clinicStaffData = $clinicStaff_cm;
                                                    // dd($clinicStaffData);
                                                } else {
                                                    $clinicStaffData = $clinicStaff;
                                                }

                                            @endphp
                                            @foreach ($clinicStaffData as $i => $row)
                                                @if ($row->type == 'existing')
                                                    <tr class="staff-row">
                                                        <td>
                                                            <input type="text" name="post_existing[]"
                                                                value="{{ $row['post'] ?? '' }} " class="form-control"
                                                                readonly>
                                                            <input type="text" name="anyotherpost_existing[]"
                                                                value="{{ $row['anyotherpost'] ?? '' }}"
                                                                placeholder="Specify other post"
                                                                class="form-control {{ ($row['post_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"
                                                                readonly>
                                                        </td>
                                                        <td><input type="text" name="name_otherstaff_existing[]"
                                                                value="{{ $row['name'] ?? '' }}" class="form-control"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="quali_otherstaff_existing[]"
                                                                value="{{ $row['qualification'] ?? '' }}"
                                                                class="form-control" readonly>

                                                            <input type="text" name="anyotherdegree_existing[]"
                                                                value="{{ $row['anyotherdegree'] ?? '' }}"
                                                                placeholder="Specify degree"
                                                                class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                        </td>
                                                        <td><input type="text" name="regno_staff_existing[]"
                                                                value="{{ $row['regno'] ?? '' }}" class="form-control"
                                                                readonly>
                                                        </td>
                                                        <td><input type="date" name="expirydate_staff_existing[]"
                                                                value="{{ $row['expiry_date'] ?? '' }}"
                                                                class="form-control date-input"
                                                                max="{{ date('Y-m-d') }}">
                                                        </td>
                                                    </tr>
                                                @elseif($row->type == '')
                                                    <tr class="staff-row">
                                                        <td>
                                                            <input type="text" name="post_existing[]"
                                                                value="{{ $row['post'] ?? '' }} " class="form-control"
                                                                readonly>
                                                            <input type="text" name="anyotherpost_existing[]"
                                                                value="{{ $row['anyotherpost'] ?? '' }}"
                                                                placeholder="Specify other post"
                                                                class="form-control {{ ($row['post_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"
                                                                readonly>
                                                        </td>
                                                        <td><input type="text" name="name_otherstaff_existing[]"
                                                                value="{{ $row['name'] ?? '' }}" class="form-control"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="quali_otherstaff_existing[]"
                                                                value="{{ $row['qualification'] ?? '' }}"
                                                                class="form-control" readonly>

                                                            <input type="text" name="anyotherdegree_existing[]"
                                                                value="{{ $row['anyotherdegree'] ?? '' }}"
                                                                placeholder="Specify degree"
                                                                class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                        </td>
                                                        <td><input type="text" name="regno_staff_existing[]"
                                                                value="{{ $row['regno'] ?? '' }}" class="form-control"
                                                                readonly>
                                                        </td>
                                                        <td><input type="date" name="expirydate_staff_existing[]"
                                                                value="{{ $row['expiry_date'] ?? '' }}"
                                                                class="form-control" max="{{ date('Y-m-d') }}">
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <p class="text-dark "><u class="bg-light p-2">B. New Staff</u></p>
                                <div id="otherstaff" class="col-xs-12 form-group">
                                    <label class="control-label"><strong> Provide details of the staff.</strong></label>
                                    <div class="table-responsive">
                                        @php

                                            $staffData = old('post')
                                                ? collect(old('post'))
                                                    ->map(function ($post, $i) {
                                                        return [
                                                            'post' => $post,
                                                            'anyotherpost' => old('anyotherpost.' . $i),
                                                            'name_otherstaff' => old('name_otherstaff.' . $i),
                                                            'qualification' => old('qualification.' . $i),
                                                            'anyotherdegree' => old('anyotherdegree.' . $i),
                                                            'regno' => old('regno.' . $i),
                                                            'type' => '',
                                                        ];
                                                    })
                                                    ->toArray()
                                                : collect($clinicStaff_cm ?? [])
                                                    ->map(function ($staff) {
                                                        return [
                                                            'post' => $staff->post ?? '',
                                                            'anyotherpost' => $staff->anyotherpost ?? '',
                                                            'name_otherstaff' => $staff->name ?? '',
                                                            'qualification' => $staff->qualification ?? '',
                                                            'anyotherdegree' => $staff->anyotherdegree ?? '',
                                                            'regno' => $staff->regno ?? '',
                                                            'type' => $staff->type ?? '',
                                                        ];
                                                    })
                                                    ->toArray();
                                        @endphp

                                        <table class="table table-bordered" id="crud_table_otherstaff">
                                            <thead>
                                                <tr>
                                                    <th>Post<span class="text-danger">*</span></th>
                                                    <th>Name<span class="text-danger">*</span></th>
                                                    <th>Qualification<span class="text-danger">*</span></th>
                                                    <th>Reg No</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($staffData as $i => $row)
                                                    @if ($row['type'] == 'new')
                                                        <tr class="staff-row-new">
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

                                                                @error('post.' . $i)
                                                                    <span
                                                                        class="text-danger"><b>{{ $message }}</b></span>
                                                                @enderror

                                                                <input type="text" name="anyotherpost[]"
                                                                    value="{{ $row['anyotherpost'] ?? '' }}"
                                                                    placeholder="Specify other post"
                                                                    class="form-control {{ ($row['post'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            </td>

                                                            <td><input type="text" name="name_otherstaff[]"
                                                                    value="{{ $row['name_otherstaff'] ?? '' }}"
                                                                    class="form-control">

                                                                @error('name_otherstaff.' . $i)
                                                                    <span
                                                                        class="text-danger"><b>{{ $message }}</b></span>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <select name="qualification[]" class="form-control">
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
                                                                @error('qualification.' . $i)
                                                                    <span
                                                                        class="text-danger"><b>{{ $message }}</b></span>
                                                                @enderror

                                                                <input type="text" name="anyotherdegree[]"
                                                                    value="{{ $row['anyotherdegree'] ?? '' }}"
                                                                    placeholder="Specify degree"
                                                                    class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}">
                                                            </td>
                                                            <td><input type="text" name="regno[]"
                                                                    value="{{ $row['regno'] ?? '' }}"
                                                                    class="form-control">
                                                                @error('regno.' . $i)
                                                                    <span
                                                                        class="text-danger"><b>{{ $message }}</b></span>
                                                                @enderror
                                                            </td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm remove-row">
                                                                    <i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @elseif($row['type'] == '')
                                                        <tr class="staff-row-new">
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
                                                                        Clinical
                                                                        Embryologist
                                                                    </option>
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
                                                                <div id="errorpost" class="text-danger"></div>
                                                                <input type="text"
                                                                    name="anyotherpost[]"value="{{ $row['anyotherpost'] ?? '' }}"
                                                                    placeholder="Specify other post"
                                                                    class="form-control display-none-csp-clinic-one">
                                                                <div id="erroranyotherpost" class="text-danger"> </div>
                                                            </td>
                                                            <td><input type="text" name="name_otherstaff[]"
                                                                    value="{{ $row['name_otherstaff'] ?? '' }}"
                                                                    class="form-control"> </td>
                                                            <td>
                                                                <select name="qualification[]" class="form-control">
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

                                                                <input type="text" name="anyotherdegree[]"
                                                                    value="{{ $row['anyotherdegree'] ?? '' }}"
                                                                    placeholder="Specify degree"
                                                                    class="form-control display-none-csp-clinic-one">
                                                            </td>
                                                            <td><input type="text" name="regno[]"
                                                                    value="{{ $row['regno'] ?? '' }}"
                                                                    class="form-control"> </td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm remove-row"> <i
                                                                        class="fa fa-trash"></i></button> </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr class="staff-row-new">
                                                        <td>
                                                            <select name="post[]" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Gynecologist">Gynecologist</option>
                                                                <option value="Andrologist">Andrologist</option>
                                                                <option value="Clinical Embryologist">Clinical Embryologist
                                                                </option>
                                                                <option value="Counselor">Counselor</option>
                                                                <option value="Anesthetist">Anesthetist</option>
                                                                <option value="Any Other">Any Other</option>
                                                            </select>
                                                            <div id="errorpost" class="text-danger"></div>
                                                            <input type="text" name="anyotherpost[]"value=""
                                                                placeholder="Specify other post"
                                                                class="form-control display-none-csp-clinic-one">
                                                            <div id="erroranyotherpost" class="text-danger"> </div>
                                                        </td>
                                                        {{--  --}}
                                                        <td><input type="text" name="name_otherstaff[]" value=""
                                                                class="form-control"> </td>
                                                        <td>
                                                            <select name="qualification[]" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Doctorate">Doctorate</option>
                                                                <option value="Post Graduate">Post Graduate</option>
                                                                <option value="Graduate">Graduate</option>
                                                                <option value="Diploma">Diploma</option>
                                                                <option value="Under Graduate">Under Graduate</option>
                                                                <option value="Any Other">Any Other</option>
                                                            </select>

                                                            <input type="text" name="anyotherdegree[]" value=""
                                                                placeholder="Specify degree"
                                                                class="form-control display-none-csp-clinic-one">
                                                        </td>
                                                        <td><input type="text" name="regno[]" value=""
                                                                class="form-control"> </td>
                                                        <td><button type="button"
                                                                class="btn btn-danger btn-sm remove-row"> <i
                                                                    class="fa fa-trash"></i></button> </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div align="left">
                                            <button type="button" name="addotherstaff" id="addotherstaff"
                                                class="btn-xs bc-bc-color-csp-clinic-three btn btn-primary">+ Add More
                                                Staff</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <h6 class="bg-dark text-white p-2">Declaration </h6>
                            </div>
                            <div class="col-md-9">
                                <hr>
                            </div>
                        </div>
                        <div id="upload_supporting" class="col-xs-12 form-group p-3 border m-2">
                            <p><input type="checkbox" id="declaration" name="declaration" class="form-check-input"
                                    {{ old('declaration') ? 'checked' : '' }}><strong> I/We hereby declare that the
                                    information provided
                                    above is true and correct to the best of my/our knowledge and belief. I/We undertake
                                    that all the attached documents are genuine and I/we also understand that if any
                                    information is found to be false, the application may be rejected and action may be
                                    taken as per law.</strong>
                            </p>
                            @error('declaration')
                                <span class="text-danger"><b>{{ $message }}</b></span>
                            @enderror
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name_signatory" class="form-label"><strong>Name of Authorized
                                            Signatory</strong><span class="text-danger">*</span></label>
                                    <input type="text" id="name_signatory" name="name_signatory" class="form-control name_signatory"
                                        value="{{ old('name_signatory') ?? ($drftApplicationCheck->name_signatory ?? '') }}">
                                    @error('name_signatory')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="declaration_designation"
                                        class="form-label"><strong>Designation</strong><span
                                            class="text-danger">*</span></label>

                                    <input type="text" id="declaration_designation" name="declaration_designation"
                                        class="form-control"
                                        value="{{ old('declaration_designation') ?? ($drftApplicationCheck->declaration_designation ?? '') }}">

                                    @error('declaration_designation')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="declaration_contact" class="form-label"><strong>Contact
                                            Number</strong><span class="text-danger">*</span></label>

                                    <input type="text" id="declaration_contact" name="declaration_contact"
                                        class="form-control"
                                        value="{{ old('declaration_contact') ?? ($drftApplicationCheck->declaration_contact ?? '') }}">
                                    @error('declaration_contact')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="declaration_date" class="form-label"><strong>Date</strong></label>
                                    <input type="text" id="declaration_date" name="declaration_date"
                                        class="form-control" max="{{ date('Y-m-d') }}" value="{{ date('d-m-Y') }}"
                                        readonly>
                                    @error('declaration_date')
                                        <span class="text-danger"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="table-responsive">
                            <button type="button" class="btn btn-secondary bc-bc-color-csp-clinic-three"
                                id="prev-step">Back</button>
                            <button type="submit" id="draftButton" name="submit_type" value="draft"
                                class="btn btn-primary bc-bc-color-csp-clinic-three">Save As draft</button>
                            <button type="submit" id="submitButton" name="submit_type" value="final"
                                class="btn btn-primary bc-bc-color-csp-clinic-three">Submit</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Directors 
            if ($('.directorcheckbutton').val() == 'yes') {
                $('.directorShowAndhide').show();
            } else {
                $('.directorShowAndhide').hide();
            }

            $('.directorcheckbutton').change(function() {
                if ($(this).val() == 'yes') {
                    $('.directorShowAndhide').show();
                } else {

                    const directorRows = document.querySelectorAll(".director-row");
                    for (const row of directorRows) {
                        const nameInput = row.querySelector('input[name="name_director[]"]');
                        const qualiSelect = row.querySelector('select[name="quali_director[]"]');
                        const reg_director = row.querySelector('input[name="reg_director[]"]');
                        const expiry_director = row.querySelector('input[name="expiry_director[]"]');


                        if (nameInput) {
                            nameInput.value = '';
                        }
                        if (qualiSelect) {
                            qualiSelect.selectedIndex = 0;
                        }
                        if (reg_director) {
                            reg_director.value = '';
                        }
                        if (expiry_director) {
                            expiry_director.value = '';
                        }
                    }

                    $('.directorShowAndhide').hide();
                }
            });

            var i = 1;
            $('#adddirector').click(function() {
                i++;
                $('#crud_table_director').append('<tr class="director-row" id="row1' + i +
                    '"><td><input type="text" id="namedirector" name="name_director[]"  placeholder="" class="form-control"><div class="error-namedirector" class="color-red-fourtyseven"></div></td><td><select id= "quali_director" name="quali_director[]" class="form-control" ><option value="">Select</option><option value="PhD">Ph.D</option><option value="DM">DM</option><option Value="MCh">M.Ch</option><option Value="PG">PG</option><option Value="MD">MD</option><option Value="MS">MS</option><option Value="DNB">DNB</option></select> <div class="error-quali_director" class="color-red-fourtyseven"></div></td><td><input type="text" id="regdirector" name="reg_director[]"  placeholder="" class="form-control" ></td><td><button type="button" name="remove1" id="' +
                    i +
                    '" class="btn btn-danger btn-sm btn_remove1"><i class="fa fa fa-trash"></i></button></td></tr>'
                );
            });
            $(document).on('click', '.btn_remove1', function() {
                if ($('#crud_table_director .director-row').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert("At least one row must be present.");
                }
            });

            $('#addotherstaff').click(function() {
                let newRow = $('#crud_table_otherstaff .staff-row-new:first').clone();
                newRow.find('input, select').val(''); // Clear input values
                $('#crud_table_otherstaff').append(newRow);
            });

            // Remove a row
            $(document).on('click', '.remove-row', function() {
                if ($('#crud_table_otherstaff .staff-row-new').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert("At least one row must be present.");
                }
            });
            // Show/hide "Any Other" input based on selection
            $(document).on('change', 'select[name="post[]"]', function() {
                let selectedValue = $(this).val();
                let anyOtherInput = $(this).closest('td').find('input[name="anyotherpost[]"]');
                console.log(anyOtherInput.attr('class'));
                if (selectedValue === 'Any Other') {
                    anyOtherInput.removeClass('display-none-csp-clinic-one');
                } else {
                    anyOtherInput.addClass('display-none-csp-clinic-one');
                    anyOtherInput.val('');
                }
            });
            $(document).on('change', 'select[name="qualification[]"]', function() {
                let selectedValue = $(this).val();
                let anyOtherInput = $(this).closest('td').find('input[name="anyotherdegree[]"]');
                console.log(anyOtherInput.attr('class'));
                if (selectedValue === 'Any Other') {
                    anyOtherInput.removeClass('display-none-csp-clinic-one');
                } else {
                    anyOtherInput.addClass('display-none-csp-clinic-one');
                    anyOtherInput.val('');
                }
            });
            $('#declaration_contact').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
            });

            // const setRowError = (row, fallbackId, inputEl, msg) => {
            //     let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;

            //     if (!holder) {
            //         holder = row.querySelector('.inline-error');
            //         if (!holder) {
            //             holder = document.createElement('div');
            //             holder.className = 'inline-error';
            //             holder.style.color = '#d33';
            //             holder.style.fontSize = '12px';
            //             holder.style.marginTop = '4px';
            //             (inputEl && inputEl.parentElement ? inputEl.parentElement : row).appendChild(holder);
            //         }
            //     }
            //     holder.textContent = msg;
            // };

            const setRowError = (row, fallbackId, inputEl, msg) => {
                let holder = fallbackId ? row.querySelector('#' + fallbackId) : null;

                if (!holder && inputEl) {
                    holder = inputEl.parentElement.querySelector('.inline-error');
                    if (!holder) {
                        holder = document.createElement('div');
                        holder.className = 'inline-error';
                        holder.style.color = '#d33';
                        holder.style.fontSize = '12px';
                        holder.style.marginTop = '4px';
                        inputEl.parentElement.appendChild(holder);
                    }
                }
                if (holder) {
                    holder.textContent = msg;
                }
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
                if (el && el.scrollIntoView) el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return false;
            };

            //file check only 5 KB
            $('.upload_file').on('change', function() {
                let file = this.files[0];
                if (file.type !== 'application/pdf') {
                    alert('Only PDF files are allowed.');
                    $(this).val('');
                    return false;
                }
                if (file && file.size > 5242880) {
                    alert('File size must not exceed 5 MB.');
                    $(this).val('');
                    return false;
                }
            });



            // form submit hone se pehle validation aur confirmation
            $('#submitButton').on('click', function(e) {

                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                if (!confirm('Are you sure you want to submit the form?')) {
                    e.preventDefault();
                    return false; // submit mat karo
                }
                return true;
            });

            function validateForm() {
                if ($('.directorcheckbutton').val() === 'yes') {
                    const directorRows = document.querySelectorAll(".director-row");
                    // console.log(directorRows);
                    for (const row of directorRows) {
                        const nameInput = row.querySelector('input[name="name_director[]"]');
                        const qualiSelect = row.querySelector('select[name="quali_director[]"]');
                        const reg_director = row.querySelector('input[name="reg_director[]"]');
                       
                        const hasData =
                            (nameInput && nameInput.value.trim() !== "") ||
                            (qualiSelect && qualiSelect.value.trim() !== "") ||
                            (reg_director && reg_director.value.trim() !== "");
                        
                        // Entire row blank -> skip validation
                        if (!hasData) {
                            continue;
                        }

                        clearRowError(row, "errornamedirector");
                        clearRowError(row, "errorquali_director");
                        // clearRowError(row, "errorreg_director");


                        if (nameInput && !nameInput.value.trim()) {
                            setRowError(row, "errornamedirector", nameInput, "Name of director cannot be blank");
                            alert("Name of director cannot be blank");
                            return focusAndStop(nameInput);
                        }
                        if (qualiSelect && !qualiSelect.value.trim()) {
                            setRowError(row, "errorquali_director", qualiSelect,
                                "Qualification of director cannot be blank");
                            alert("Qualification of director cannot be blank");
                            return focusAndStop(qualiSelect);
                        }
                        // if (reg_director && !reg_director.value.trim()) {
                        //     setRowError(row, "errorreg_director", reg_director,
                        //         "Registration of director cannot be blank");
                        //     alert("Registration of director cannot be blank");
                        //     return focusAndStop(reg_director);
                        // }
                    }
                }
                // Validate staff rows start
                const rows = document.querySelectorAll(".staff-row-new");
                for (const row of rows) {
                    const nameInput = row.querySelector('input[name="name_otherstaff[]"]');
                    const postSelect = row.querySelector('select[name="post[]"]');
                    const qualiSelect = row.querySelector('select[name="qualification[]"]');
                    const anyPost = row.querySelector('input[name="anyotherpost[]"]');
                    const anyDegree = row.querySelector('input[name="anyotherdegree[]"]');

                    const hasData =
                        (postSelect && postSelect.value.trim() !== "") ||
                        (nameInput && nameInput.value.trim() !== "") ||
                        (qualiSelect && qualiSelect.value.trim() !== "") ||
                        (anyPost && anyPost.value.trim() !== "") ||
                        (anyDegree && anyDegree.value.trim() !== "");

                    // Entire row blank -> skip validation
                    if (!hasData) {
                        continue;
                    }

                    clearRowError(row, "errorpostotherstaff");
                    clearRowError(row, "errornameotherstaff");
                    clearRowError(row, "errorqualiotherstaff");
                    clearRowError(row, "erroranyotherpost");
                    clearRowError(row, "erroranyotherdegree");

                    if (postSelect && !postSelect.value.trim()) {
                        setRowError(row, "errorpostotherstaff", postSelect, "Post of staff cannot be blank");
                        alert("Post of staff cannot be blank");
                        return focusAndStop(postSelect);
                    }

                    if (nameInput && !nameInput.value.trim()) {
                        setRowError(row, "errornameotherstaff", nameInput, "Name of staff cannot be blank ");
                        alert("Name of staff cannot be blank");
                        return focusAndStop(nameInput);
                    }

                    if (qualiSelect && !qualiSelect.value.trim()) {
                        setRowError(row, "errorqualiotherstaff", qualiSelect,
                            "Qualification of staff cannot be blank");
                        alert("Qualification of staff cannot be blank");
                        return focusAndStop(qualiSelect);
                    }

                    if (postSelect && postSelect.value === "Any Other") {
                        if (!anyPost || !anyPost.value.trim()) {
                            setRowError(row, "erroranyotherpost", anyPost || postSelect,
                                "Name of the other Post cannot be blank");
                            alert("Name of the other Post cannot be blank");
                            return focusAndStop(anyPost || postSelect);
                        }
                    }

                    if (qualiSelect && qualiSelect.value === "Any Other") {
                        if (!anyDegree || !anyDegree.value.trim()) {
                            setRowError(row, "erroranyotherdegree", anyDegree || qualiSelect,
                                "Other Qualification cannot be blank");
                            alert("Other Qualification cannot be blank");
                            return focusAndStop(anyDegree || qualiSelect);
                        }
                    }
                }
                // Validate staff rows End

                if ($('#declaration').prop('checked') == false) {
                    alert('Please accept the declaration.');
                    $('#declaration').focus();
                    return false;
                }
                if ($('#name_signatory').val().trim() === '') {
                    alert('Please fill the Name of Authorized Signatory.');
                    $('#name_signatory').focus();
                    return false;
                }
                if ($('#declaration_designation').val().trim() === '') {
                    alert('Please fill the Designation of Authorized Signatory.');
                    $('#declaration_designation').focus();
                    return false;
                }
                if ($('#declaration_contact').val().trim() === '') {
                    alert('Please fill the Contact Number of Authorized Signatory.');
                    $('#declaration_contact').focus();
                    return false;
                }

                if ($('#declaration_date').val().trim() === '') {
                    alert('Please fill the Date of Declaration.');
                    $('#declaration_date').focus();
                    return false;
                }

                return true;
            }

            $(document).on('keydown', '.date-input', function(e) {
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    e.preventDefault();
                    $(this).val('');
                }
            });
        });
        $(document).on('keyup', 'input[name="name_director[]"], .name_signatory, input[name="name_otherstaff[]"]', function() {
            let value = $(this).val();
            let nameRegex = /^[A-Za-z\s]*$/;
            if (!nameRegex.test(value)) {
                $(this).val(value.replace(/[^A-Za-z\s]/g, ''));
                $(this).next('.name-error').remove();
                $(this).after(
                    '<small class="text-danger name-error">' +
                    'Only letters and spaces are allowed.' +
                    '</small>'
                );
            } else {
                $(this).next('.name-error').remove();
            }
        });
    </script>
@endsection
