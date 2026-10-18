<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <style nonce="{{ $cspNonce }}">
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
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
       
    </style>


</head>

<body>
    <!-- Main Heading -->
    <div class="main-heading">Application form for ART Bank</div>
    <div class="application-number">
        <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong>
            {{ $application->applicationno }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- ART Clinic Details -->
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">ART Bank Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Bank</th>
                        <td colspan="7">{{ $application->clinicname }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Address</th>
                        <td colspan="7">{{ $application->address }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">State</th>
                        <td colspan="2">{{ $application->state }}</td>
                        <th colspan="2">District</th>
                        <td colspan="2">{{ $application->district }}</td>
                        <th>Pincode</th>
                        <td>{{ $application->pincode }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Nature</th>
                        <td colspan="2">{{ $application->nature }}</td>
                        <th colspan="2">Email ID</th>
                        <td colspan="2">{{ $application->email }}</td>
                        <th>Contact Number</th>
                        <td>{{ $application->contactno }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Fax</th>
                        <td colspan="3">{{ $application->fax ?? '-' }}</td>
                        <th colspan="2">Website</th>
                        <td colspan="2">{{ $application->website ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Date of establishment</th>
                        <td colspan="2">
                            {{ $application->dateestab ? date('d-m-Y', strtotime($application->dateestab)) : '' }}</td>
                        <th colspan="3">Current Registration Date</th>
                        <td colspan="2">
                            {{ $application->current_registration_date ? date('d-m-Y', strtotime($application->current_registration_date)) : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <!-- Contact Person Details -->
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Contact Person Details</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name of the Contact Person</th>
                        <td colspan="3">{{ $application->contact_person_name }}</td>
                        <th colspan="2">Mobile Number</th>
                        <td colspan="2">{{ $application->contact_person_mobile }}</td>
                    </tr>
                    <!-- Application Details -->
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Details of the Staff Available at your ART
                            Bank</th>
                    </tr>
                    <tr>
                        <th colspan="3">Name</th>
                        <th colspan="3">Designation</th>
                        <th colspan="4">Qualification</th>
                    </tr>
                    @foreach ($staff as $staffs)
                        <tr>
                            <td colspan="3">{{ $staffs->name }}</td>
                            <td colspan="3">{{ $staffs->post ?? '-' }}</td>
                            <td colspan="4">{{ $staffs->qualification }}</td>

                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="10">
                            <hr>
                        </td>
                    </tr>
                    <!-- Equipment -->
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Equipment Details</th>
                    </tr>
                    @foreach ($equipment as $equipments)
                        <tr>
                            <td colspan="10">{{ $equipments->equipmentname }}</td>
                        </tr>
                    @endforeach
                    <!-- Procedures -->
                    <tr><td colspan="10"><hr></td></tr>
                    <tr>
                        <th colspan="10" class="csp-clinic-table-header">Procedures Undertaken</th>
                    </tr>
                    <tr>
                        <th colspan="8">a). Ejaculation</th>
                        <td colspan="2">{{ $application->ejaculation }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">b). Electroejaculation (in
                            case of retrograde ejaculation)</th>
                        <td colspan="2">{{ $application->electrojaculation }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">ii). Processing of Sperm</th>
                        <td colspan="2">{{ $application->processing_sperm }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">iii). Storage of Sperm</th>
                        <td colspan="2">{{ $application->storage_sperm }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">iv). Provision/sourcing of
                            Oocyte Donor</th>
                        <td colspan="2">{{ $application->oocyte_doner }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">5. Cryopreservation of
                            Sperm</th>
                        <td colspan="2">{{ $application->cryopreservation_of_sperm }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">i). Sperm Slow Freezing</th>
                        <td colspan="2">{{ $application->methode_of_freezing_of_sperm }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">ii). Sperm Vitrification</th>
                        <td colspan="2">{{ $application->sperm_vitrification }}</td>
                    </tr>
                    <tr>
                        <th colspan="8">7. Whether Freezing of
                            Testicular Tissue</th>
                        <td colspan="2">{{ $application->freezing_of_testicular_tissue }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Other Details</th>
                        <td colspan="8">{{ $application->otherdetails }}</td>
                    </tr>
                </tbody>
            </table>
            <p>Submission Date:{{ date('d-m-Y',strtotime($application->application_datetime_submission)) }}</p>
            @if($application->is_resubmission == 1)
                <div class="border application-number1">
                    {{ $renewal_fee }}
                </div>
            @endif
            <h5 class="signature-right top-margin">
                <b>Name & Signature (with seal) of the ART Bank Authority</b>
            </h5>
            <br>
        </div>
        <div class="application-number1">
            <span><small>{!! $note !!}
                </small>
            </span>
        </div>
    </div>
</body>

</html>
