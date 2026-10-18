@extends(session('user_type') === '5' ? 'layouts.admin.ssa_master' : 'layouts.clinic.clinic_master')
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
                    <div class="text-end">
                        <a href="{{ route('manpower.change_manpower_form.pdf', ['encryptedClinicId' => Crypt::encryptString($existPendingApplicationCheck->id)]) }}"\
                            class="btn btn-primary" id="downloadpdfSurrogacy">Download</a>
                    </div>
                    <div class="bg-light text-center">
                        <h3 class="m-3">
                            <b>{{ match ($existPendingApplicationCheck->clinic_type) {
                                'ARTCLINIC' => 'ART Clinic',
                                'ARTBANK' => 'ART Bank',
                                'ARTSURROGACY' => 'ART Surrogacy',
                                default => "Clinic",
                            } }}
                                Application for Change Manpower Details</b>
                        </h3>
                    </div>
                    <div id="step-1" class="step">
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="bg-dark text-white p-2">Clinic Details (As per Registered)</h6>
                            </div>
                            <div class="col-md-9">
                                <hr>
                            </div>
                        </div>
                        <div class="row border p-3 m-2">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Application No.</th>
                                    <td>{{ $existPendingApplicationCheck->application_no }}</td>
                                    <th>Registration Number</th>
                                    <td>{{ $existPendingApplicationCheck->registration_no }}</td>
                                    <th>Name of the Clinic</th>
                                    <td>{{ $existPendingApplicationCheck->clinicname }}</td>
                                </tr>
                                <tr>
                                    <th>Type of Clinic</th>
                                    <td>{{ match ($existPendingApplicationCheck->clinic_type) {
                                                'ARTCLINIC' => 'ART Clinic',
                                                'ARTBANK' => 'ART Bank',
                                                'ARTSURROGACY' => 'Surrogacy Clinic',
                                                default => 'Clinic',
                                            } }}</td>
                                    <th>Date of Registration</th>
                                    <td>{{ $existPendingApplicationCheck->current_registration_date ? date('d-m-Y', strtotime($existPendingApplicationCheck->current_registration_date)) : '' }}
                                    </td>
                                    <th>Pincode</th>
                                    <td>{{ $existPendingApplicationCheck->pincode }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $existPendingApplicationCheck->address }}</td>
                                    <th>State</th>
                                    <td>{{ $existPendingApplicationCheck->state }}</td>
                                    <th>District</th>
                                    <td>{{ $existPendingApplicationCheck->district }}</td>
                                </tr>
                                <tr>
                                    <th>Nature</th>
                                    <td>{{ $existPendingApplicationCheck->nature }}</td>
                                    @if (!empty($existPendingApplicationCheck) && $existPendingApplicationCheck->level)
                                        <th>Level</th>
                                        <td>{{ $existPendingApplicationCheck->level }}</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                        @if ($existPendingApplicationCheck->clinic_type != 'ARTBANK')
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <h6 class="bg-dark text-white p-2">Director Change Details</h6>
                                </div>
                                <div class="col-md-9">
                                    <hr>
                                </div>
                            </div>

                            <div class="row border p-3 m-2">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Whether your {{ match ($existPendingApplicationCheck->clinic_type) {
                                                    'ARTCLINIC' => 'ART Clinic',
                                                    'ARTSURROGACY' => 'Surrogacy Clinic',
                                                    default => "Clinic",
                                                } }} has Director</th>
                                            <td>{{ $existPendingApplicationCheck->clinic_director }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <p class="text-dark "><u class="bg-light p-2">A. Existing Director</u></p>
                                <div id="directory" data-section="directors"
                                    class="col-xs-12 form-group {{ ($clinic->clinic_director ?? $existPendingApplicationCheck->clinic_director) == 'Yes' ? '' : 'display-none-csp-clinic-one' }} "
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
                                                if (!empty($existPendingApplicationCheck)) {
                                                    $directorsData = $directors_cm;
                                                } else {
                                                    $directorsData = $clinicDirector;
                                                }
                                            @endphp
                                            @foreach ($directorsData as $index => $director)
                                                @if ($director->type == 'existing')
                                                    <tr class="director-row" id="drow{{ $index + 1 }}">
                                                        <td>
                                                            <label
                                                                for="">{{ $director->name_director ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ $director->quali_director ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ $director->reg_director ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ !empty($director->expiry_date) ? date('d-m-Y', strtotime($director->expiry_date)) : '' }}</label>
                                                        </td>
                                                    </tr>
                                                @elseif($director->type == '')
                                                    <tr class="director-row" id="drow{{ $index + 1 }}">
                                                        <td>
                                                            <label
                                                                for="">{{ $director->name_director ?? '' }}</label>

                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ $director->quali_director ?? '' }}</label>

                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ $director->reg_director ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ !empty($director->expiry_date) ? date('d-m-Y', strtotime($director->expiry_date)) : '' }}</label>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </div>


                                    <p class="text-dark "><u class="bg-light p-2">B. New Director</u></p>
                                    <div id="directory" data-section="directors"
                                        class="col-xs-12 form-group {{ ($clinic->clinic_director ?? $existPendingApplicationCheck->clinic_director) == 'Yes' ? '' : 'display-none-csp-clinic-one' }} "
                                        id="directors-section">
                                        <div class="table-responsive">
                                            @php
                                                $directorsDatanew = old('name_director')
                                                    ? collect(old('name_director'))
                                                        ->map(function ($name, $i) {
                                                            return [
                                                                'name_director' => $name,
                                                                'quali_director' => old('quali_director.' . $i),
                                                                'reg_director' => old('reg_director.' . $i),
                                                                'expiry_director' => old('expiry_director.' . $i),
                                                                'type' => '',
                                                            ];
                                                        })
                                                        ->toArray()
                                                    : collect($directors_cm ?? [])
                                                        ->map(function ($director_1) {
                                                            return [
                                                                'name_director' => $director_1->name_director ?? '',
                                                                'quali_director' => $director_1->quali_director ?? '',
                                                                'reg_director' => $director_1->reg_director ?? '',
                                                                'expiry_director' => $director_1->expiry_director ?? '',
                                                                'type' => $director_1->type ?? '',
                                                            ];
                                                        })
                                                        ->toArray();

                                            @endphp
                                            <table class="table table-bordered" id="crud_table_director">
                                                <tr>
                                                    <th>Name<span class="text-danger">*</span></th>
                                                    <th>Qualification<span class="text-danger">*</span></th>
                                                    <th>Registration No. (if applicable)</th>
                                                </tr>

                                                @forelse($directorsDatanew as $index => $director)
                                                    @if ($director['type'] == 'new')
                                                        <tr class="director-row" id="drow{{ $index + 1 }}">
                                                            <td>
                                                                <label
                                                                    for="">{{ $director['name_director'] ?? '' }}</label>
                                                            </td>
                                                            <td>
                                                                <label
                                                                    for="">{{ $director['quali_director'] }}</label>
                                                            </td>
                                                            <td>
                                                                <label
                                                                    for="">{{ $director['reg_director'] ?? '' }}</label>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr class="director-row" id="drow1">
                                                        <td>
                                                            <label
                                                                for="">{{ $director['name_director'] ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label for="">{{ $director['quali_director'] }}</label>
                                                        </td>
                                                        <td>
                                                            <label
                                                                for="">{{ $director['reg_director'] ?? '' }}</label>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </table>
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
                                            if (!empty($existPendingApplicationCheck)) {
                                                $clinicStaffData = $clinicStaff_cm;
                                            } else {
                                                $clinicStaffData = $clinicStaff;
                                            }

                                        @endphp
                                        @foreach ($clinicStaffData as $i => $row)
                                            @if ($row->type == 'existing')
                                                <tr class="staff-row">
                                                    <td>
                                                        <label for="">{{ $row['post'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['name'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['qualification'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['regno'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label
                                                            for="">{{ !empty($row['expiry_date']) ? date('d-m-Y', strtotime($row['expiry_date'])) : '' }}</label>
                                                    </td>
                                                </tr>
                                            @elseif($row->type == '')
                                                <tr class="staff-row">
                                                    <td>
                                                        <label for="">{{ $row['post'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['name'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['qualification'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['regno'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label
                                                            for="">{{ !empty($row['expiry_date']) ? date('d-m-Y', strtotime($row['expiry_date'])) : '' }}</label>
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

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($staffData as $i => $row)
                                                @if ($row['type'] == 'new')
                                                    <tr class="staff-row-new">
                                                        <td>
                                                            <label for="">{{ $row['post'] }}</label>
                                                        </td>

                                                        <td>
                                                            <label
                                                                for="">{{ $row['name_otherstaff'] ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label for="">{{ $row['qualification'] }}</label>
                                                        </td>
                                                        <td>
                                                            <label for="">{{ $row['regno'] ?? '' }}</label>
                                                        </td>

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
                                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fa fa-trash"></i></button> </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
                                {{ $existPendingApplicationCheck ? 'checked' : '' }} disabled><strong> I/We hereby declare
                                that the
                                information provided
                                above is true and correct to the best of my/our knowledge and belief. I/We undertake
                                that all the attached documents are genuine and I/we also understand that if any
                                information is found to be false, the application may be rejected and action may be
                                taken as per law.</strong>
                        </p>
                        <div class="row">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name of Authorized Signatory</th>
                                    <td>{{ $existPendingApplicationCheck->name_signatory }}</td>
                                    <th>Designation</th>
                                    <td>{{ $existPendingApplicationCheck->declaration_designation }}</td>
                                    <th>Contact Number</th>
                                    <td>{{ $existPendingApplicationCheck->declaration_contact }}</td>
                                    <th>Date</th>
                                    {{-- <td>{{ $existPendingApplicationCheck->declaration_date }}</td> --}}
                                    <td>{{ !empty($existPendingApplicationCheck->declaration_date)
                                            ? date('d-m-Y', strtotime($existPendingApplicationCheck->declaration_date))
                                            : '' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
