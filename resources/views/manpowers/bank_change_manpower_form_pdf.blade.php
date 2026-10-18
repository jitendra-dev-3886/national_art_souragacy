<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Change Manpower Application</title>
    <style nonce="{{ $cspNonce }}">
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            padding-top: 30px;
        }

        .main-heading {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #333;
            text-transform: uppercase;
        }

        .application-number {
            text-align: right;
            margin-right: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }

        .section-title {
            font-size: 18px;
            color: green;
            margin: 10px 0;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-bordered th {
            background-color: #f2f2f2;
        }

        .verticle-middle {
            vertical-align: middle;
        }

        .table-responsive-sm {
            overflow-x: auto;
        }

        th[colspan="4"] {
            font-weight: bold;
        }

        /* Add page-break for PDF */
        @page {
            margin: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        td {
            word-wrap: break-word;
            white-space: normal;
        }

        .csp-clinic-text-black {
            color: black;
        }

        th.csp-clinic-table-header {
            text-align: center;
        }

        .signature-right {
            text-align: right;
            margin-top: 80px;
            /* space for signature and stamp */
        }

        .top-margin {
            margin-top: 50px;
        }

        .center-text {
            text-align: center;
        }
        input.pading{
            padding-top :800px;
        }
    </style>

</head>

<body>
    <div class="bg-light center-text">
        <h3 class="m-3"><b>ART Bank Application for Change Manpower View</b></h3>
    </div>
    <div id="step-1" class="step">
        <div class="row">
            <div class="col-md-3">
                <h4 class="bg-dark text-white p-2">1.Clinic Details (As per Registered)</h4>
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

                </tr>
                <tr>
                    <th>Name of the Clinic</th>
                    <td>{{ $existPendingApplicationCheck->clinicname }}</td>
                    <th>Type of Clinic</th>
                    <td>{{ $existPendingApplicationCheck->clinic_type }}</td>
                </tr>
                <tr>

                    <th>Date of Registration</th>
                    <td>{{ $existPendingApplicationCheck->current_registration_date ? date('d-m-Y', strtotime($existPendingApplicationCheck->current_registration_date)) : '' }}
                    </td>
                    <th>Pincode</th>
                    <td>{{ $existPendingApplicationCheck->pincode }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $existPendingApplicationCheck->state }}</td>
                    <th>District</th>
                    <td>{{ $existPendingApplicationCheck->district }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $existPendingApplicationCheck->address }}</td>
                    <th>Nature</th>
                    <td>{{ $existPendingApplicationCheck->nature }}</td>
                    @if (!empty($existPendingApplicationCheck->level) && $existPendingApplicationCheck->level)
                        <th>Level</th>
                        <td>{{ $existPendingApplicationCheck->state }}</td>
                    @endif
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <h4 class="bg-dark text-white p-2">2.Manpower Change Details</h4>
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
                                            <label for="">{{ $row['name_otherstaff'] ?? '' }}</label>
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
                                    <td><input type="text" name="regno[]" value="" class="form-control">
                                    </td>
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
            <h4 class="bg-dark text-white p-2">3. Declaration </h4>
        </div>
        <div class="col-md-9">
            <hr>
        </div>
    </div>
    <div id="upload_supporting" class="pading">
        <p>&#9745;<input type="checkbox" {{ $existPendingApplicationCheck ? 'checked' : '' }}> <strong> I/We hereby declare that the information
                provided above is true and correct to the best of my/our knowledge and belief. I/We undertake that all
                the attached documents are genuine, and I/we also understand that if any information is found to be
                false, the application may be rejected and action may be taken as per law.</strong>
        </p>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th>Name of Authorized Signatory</th>
                <td>{{ $existPendingApplicationCheck->name_signatory }}</td>
                <th>Designation</th>
                <td>{{ $existPendingApplicationCheck->declaration_designation }}</td>
            </tr>
            <tr>
                <th>Contact Number</th>
                <td>{{ $existPendingApplicationCheck->declaration_contact }}</td>
                <th>Date</th>
                <td>{{ date('d-m-Y', strtotime($existPendingApplicationCheck->declaration_date)) }}</td>
            </tr>
        </table>
        <br><br>
        <div class="signature-right top-margin">
            <b>Name &amp; Signature (with seal) of the ART Surrogacy Authority</b>
        </div>
    </div>
    </div>
</body>

</html>
