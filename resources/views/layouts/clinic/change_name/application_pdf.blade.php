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

        .csp-clinic-table-header {
            background-color: #d3d8fd;
            text-align: center;
        }

        .signature-right {
            text-align: right;
            margin-top: 80px;
            /* space for signature and stamp */
        }
    </style>




</head>

<body>
   
    @php
    if ($application->clinic_type == 'ARTCLINIC') {
        $clinicName = 'ART Clinic';
    } elseif ($application->clinic_type == 'ARTBANK') {
        $clinicName = 'ART Bank';
    } elseif ($application->clinic_type == 'ARTSURROGACY') {
        $clinicName = 'Surrogacy Clinic';
    } else {
        $clinicName = 'Clinic';
    }
@endphp

<div class="main-heading">
    Change Name Application Form for {{ $clinicName }}
</div>
    <div class="application-number">
        <h4 class="card-title csp-clinic-text-black"><strong>Application Number:</strong>
            {{ $application->application_no }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped verticle-middle table-responsive-sm">
                <tbody>
                    <!-- ART Clinic Details -->
                    <tr>

                        <th colspan="10" class="csp-clinic-table-header">{{ $clinicName }} Details</th>
                    </tr>

                    <!-- Application Details -->
                    <tr>
                        <th colspan="3">Name of the Clinic</th>
                        <td colspan="7">{{ $application->name }}</td>
                    </tr>
                    <tr>
                        <th colspan="3">Clinic Registration</th>
                        <td colspan="7">{{ $application->registration_no }}</td>
                    </tr>

                    <tr>
                        <th colspan="2">Clinic Type</th>
                                                                       <td colspan="8">
                                                @switch($application->clinic_type)
                                                @case('ARTCLINIC')
                                                ART Clinic
                                                @break

                                                @case('ARTBANK')
                                                ART Bank
                                                @break

                                                @case('ARTSURROGACY')
                                                Surrogacy Clinic
                                                @break

                                                @default
                                                {{ $application->clinic_type }}
                                                @endswitch
                                                </td>
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


                    <!-- Contact Person Details -->
                    <tr>

                        <th colspan="8" class="csp-clinic-table-header">Proposed New Name Details</th>
                    </tr>
                    <tr>
                        <th colspan="2">Proposed New Name Of the Clinic</th>
                        <td colspan="8">{{ $application->proposed_clinic_name }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Effective Date of Name change</th>
                        <td colspan="8">{{   $application->name_change_effective_date ? \Carbon\Carbon::parse($application->name_change_effective_date)->format('d-m-Y') : ''}}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Reason for Change of Name</th>
                        <td colspan="8">{{ $application->reason_for_name_change }}</td>

                    </tr>

                    <tr>
                        <th colspan="2">Name of Authorized Signatory</th>
                        <td colspan="8">{{ $application->authorized_signatory_name }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Designation</th>
                        <td colspan="8">{{ $application->designation }}</td>
                    </tr>
                    <tr>
                        <th colspan="2">Contact Number</th>
                        <td colspan="8">{{ $application->contact_number }}</td>

                    </tr>
                    <tr>
                        <th colspan="2">Declaration</th>
                        <td colspan="8">I/We hereby declare that the information provide above is true and correct to
                            the best of my/our
                            <br> knowledge and belief.I/We undertake that all the attached documents are genuine and
                            self attested.I/We also understand that if any information is found to be false,the
                            application may be rejected and action may be taken as per law.
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="signature-right">
                <b>Name &amp; Signature  of the {{ $clinicName }}  Authority</b>
            </div>
        </div>




</body>

</html>
