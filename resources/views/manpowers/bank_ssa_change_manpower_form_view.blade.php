@extends('layouts.admin.ssa_master')
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
                        <a href="{{ route('manpower.change_manpower_form.pdf', ['encryptedClinicId'=>Crypt::encryptString($existPendingApplicationCheck->id)]) }}"\ class="btn btn-primary" id="downloadpdfSurrogacy">Download</a>
                    </div>
                    <div class="bg-light">
                        <h3 class="m-3"><b>ART Bank Application for Change Manpower View</b></h3>
                    </div>
                    <div id="step-1" class="step">
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="bg-dark text-white p-2">1.Clinic Details (As per Registered)</h6>
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
                                    <td>{{ $existPendingApplicationCheck->clinic_type }}</td>
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
                                    @if (!empty($existPendingApplicationCheck->level) && $existPendingApplicationCheck->level)
                                        <th>Level</th>
                                        <td>{{ $existPendingApplicationCheck->state }}</td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                        
                        {{-- for staff  --}}
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <h6 class="bg-dark text-white p-2">2.Manpower Change Details</h6>
                            </div>
                            <div class="col-md-9">
                                <hr>
                            </div>
                        </div>
                        <div id="otherstaff" class="col-xs-12 form-group p-3 border m-2">
                            <p class="text-dark "><u class="bg-light p-2">A. Existing Staff</u></p>
                            <label class="control-label"><strong>5. Provide details of the staff.</strong></label>
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
                                                        {{-- <input type="text" name="anyotherpost_existing[]"
                                                            value="{{ $row['anyotherpost'] ?? '' }}"
                                                            placeholder="Specify other post"
                                                            class="form-control {{ ($row['post_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"
                                                            readonly> --}}
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['name'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['qualification'] ?? '' }}</label>
                                                        {{-- <input type="text" name="anyotherdegree_existing[]"
                                                            value="{{ $row['anyotherdegree'] ?? '' }}"
                                                            placeholder="Specify degree"
                                                            class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"> --}}
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
                                                        {{-- <input type="text" name="anyotherpost_existing[]"
                                                            value="{{ $row['anyotherpost'] ?? '' }}"
                                                            placeholder="Specify other post"
                                                            class="form-control {{ ($row['post_existing'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"
                                                            readonly> --}}
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['name'] ?? '' }}</label>
                                                    </td>
                                                    <td>
                                                        <label for="">{{ $row['qualification'] ?? '' }}</label>
                                                        {{-- <input type="text" name="anyotherdegree_existing[]"
                                                            value="{{ $row['anyotherdegree'] ?? '' }}"
                                                            placeholder="Specify degree"
                                                            class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"> --}}
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
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($staffData as $i => $row)
                                                @if ($row['type'] == 'new')
                                                    <tr class="staff-row-new">
                                                        <td>
                                                            <label for="">{{ $row['post'] }}</label>
                                                            {{-- <input type="text" name="anyotherpost[]"
                                                                value="{{ $row['post'] ?? '' }}"
                                                                placeholder="Specify other post"
                                                                class="form-control {{ ($row['post'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"> --}}
                                                        </td>

                                                        <td>
                                                            <label
                                                                for="">{{ $row['name_otherstaff'] ?? '' }}</label>
                                                        </td>
                                                        <td>
                                                            <label for="">{{ $row['qualification'] }}</label>
                                                            {{-- <input type="text" name="anyotherdegree[]"
                                                                value="{{ $row['anyotherdegree'] ?? '' }}"
                                                                placeholder="Specify degree"
                                                                class="form-control {{ ($row['qualification'] ?? '') == 'Any Other' ? '' : 'display-none-csp-clinic-one' }}"> --}}
                                                        </td>
                                                        <td>
                                                            <label for="">{{ $row['regno'] ?? '' }}</label>
                                                        </td>
                                                        {{-- <td><button type="button"
                                                                class="btn btn-danger btn-sm remove-row">
                                                                <i class="fa fa-trash"></i></button>
                                                        </td> --}}
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
                                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">
                                                            <i class="fa fa-trash"></i></button> </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{-- <div align="left">
                                        <button type="button" name="addotherstaff" id="addotherstaff"
                                            class="btn-xs bc-bc-color-csp-clinic-three btn btn-primary">+ Add More
                                            Staff</button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-3">
                            <div class="col-md-3">
                                <h6 class="bg-dark text-white p-2">4. Supporting Documents (Upload self-Altested
                                    Copies)</h6>
                            </div>
                            <div class="col-md-9">
                                <hr>
                            </div>
                        </div>
                        <div id="upload_supporting" class="col-xs-12 form-group p-3 border m-2">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Document Name</th>
                                            <th>Upload Document</th>
                                            <th>(PDF / JPG / PNG)</th>
                                            <th>File Size (MAX)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Copy of Registration Certificate of the Clinic</td>
                                            <td><input type="file" name="registration_certificate"
                                                    id="registration_certificate" class="form-control upload_file"></td>
                                            <td></td>
                                            <td>5 MB</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Copy of the Qualification and Registration of the existing staff whose
                                                change is being proposed</td>
                                            <td><input type="file" name="staff_qualification_registration"
                                                    id="staff_qualification_registration"
                                                    class="form-control upload_file"></td>
                                            <td></td>
                                            <td>5 MB</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Any other relevant document</td>
                                            <td><input type="file" name="other_relevant_document"
                                                    id="other_relevant_document" class="form-control upload_file"></td>
                                            <td></td>
                                            <td>5 MB</td>
                                    </tbody>
                                </table>
                            </div>
                        </div> --}}
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <h6 class="bg-dark text-white p-2">3. Declaration </h6>
                        </div>
                        <div class="col-md-9">
                            <hr>
                        </div>
                    </div>
                    <div id="upload_supporting" class="col-xs-12 form-group p-3 border m-2">
                        <p><input type="checkbox" id="declaration" name="declaration" class="form-check-input"
                                {{ $existPendingApplicationCheck ? 'checked' : '' }} disabled><strong> I/We hereby declare that the
                                information provided
                                above is true and correct to the best of my/our knowledge and belief. I/We undertake
                                that all the attached documents are genuine, and I/we also understand that if any
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
                                    <td>{{ $existPendingApplicationCheck->declaration_date }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
